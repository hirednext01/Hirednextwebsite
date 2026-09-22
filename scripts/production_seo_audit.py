#!/usr/bin/env python3
import argparse
import concurrent.futures
import html
import json
import os
import re
import sys
import time
import urllib.error
import urllib.parse
import urllib.request
import xml.etree.ElementTree as ET
from collections import Counter
from dataclasses import dataclass, asdict
from html.parser import HTMLParser
from pathlib import Path

BASE = "https://hirednext.net"
UA = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0 Safari/537.36 HiredNext-SearchAuthorityAudit/1.0"
PRIVATE_PREFIXES = (
    "/api/", "/admin/", "/candidate-resume", "/uploads/resumes/",
    "/cv-upgrade/", "/cv-payment/", "/advisory/payment/", "/career-services/start/"
)

@dataclass
class FetchResult:
    requested_url: str
    final_url: str
    status: int
    content_type: str
    body: str
    error: str = ""

class PageParser(HTMLParser):
    def __init__(self):
        super().__init__(convert_charrefs=True)
        self.titles = []
        self.descriptions = []
        self.canonicals = []
        self.robots = []
        self.h1 = []
        self.links = []
        self.jsonld = []
        self._capture = None
        self._buf = []
        self._script_type = ""

    def handle_starttag(self, tag, attrs):
        attrs = {k.lower(): (v or "") for k, v in attrs}
        tag = tag.lower()
        if tag == "title":
            self._capture = "title"; self._buf = []
        elif tag == "h1":
            self._capture = "h1"; self._buf = []
        elif tag == "meta":
            name = attrs.get("name", "").lower()
            if name == "description":
                self.descriptions.append(attrs.get("content", "").strip())
            if name == "robots":
                self.robots.append(attrs.get("content", "").lower())
        elif tag == "link":
            rel = attrs.get("rel", "").lower().split()
            if "canonical" in rel:
                self.canonicals.append(attrs.get("href", "").strip())
        elif tag == "a":
            href = attrs.get("href", "").strip()
            if href:
                self.links.append(href)
        elif tag == "script":
            self._script_type = attrs.get("type", "").lower()
            if self._script_type == "application/ld+json":
                self._capture = "jsonld"; self._buf = []

    def handle_endtag(self, tag):
        tag = tag.lower()
        if self._capture == "title" and tag == "title":
            self.titles.append(" ".join("".join(self._buf).split()))
            self._capture = None
        elif self._capture == "h1" and tag == "h1":
            self.h1.append(" ".join("".join(self._buf).split()))
            self._capture = None
        elif self._capture == "jsonld" and tag == "script":
            raw = "".join(self._buf).strip()
            if raw:
                self.jsonld.append(raw)
            self._capture = None
            self._script_type = ""

    def handle_data(self, data):
        if self._capture:
            self._buf.append(data)

def fetch(url, retries=3, timeout=25):
    last = ""
    for attempt in range(retries):
        req = urllib.request.Request(url, headers={
            "User-Agent": UA,
            "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
            "Accept-Language": "en-IN,en;q=0.9",
            "Cache-Control": "no-cache",
        })
        try:
            with urllib.request.urlopen(req, timeout=timeout) as r:
                body = r.read(3_000_000).decode("utf-8", errors="replace")
                return FetchResult(url, r.geturl(), r.status, r.headers.get("Content-Type", ""), body)
        except urllib.error.HTTPError as e:
            last = f"HTTP {e.code}"
            if e.code < 500 and e.code != 429:
                return FetchResult(url, getattr(e, "url", url), e.code, e.headers.get("Content-Type", "") if e.headers else "", "", last)
        except Exception as e:
            last = str(e)
        time.sleep(2 * (attempt + 1))
    return FetchResult(url, url, 0, "", "", last)

def normalise_url(url, base=BASE):
    absolute = urllib.parse.urljoin(base, html.unescape(url))
    p = urllib.parse.urlsplit(absolute)
    if p.scheme not in ("http", "https"):
        return ""
    clean = p._replace(fragment="").geturl()
    return clean

def is_public_internal(url):
    p = urllib.parse.urlsplit(url)
    if p.hostname not in ("hirednext.net", "www.hirednext.net"):
        return False
    return not any(p.path.startswith(x) for x in PRIVATE_PREFIXES)

def parse_sitemap_xml(xml_text):
    root = ET.fromstring(xml_text)
    ns = {"sm": "http://www.sitemaps.org/schemas/sitemap/0.9"}
    tag = root.tag.rsplit("}", 1)[-1]
    locs = [el.text.strip() for el in root.findall(".//sm:loc", ns) if el.text and el.text.strip()]
    return tag, locs

def discover_urls():
    critical = []
    robots_url = BASE + "/robots.txt"
    robots = fetch(robots_url, retries=5)
    if robots.status != 200:
        critical.append(f"robots.txt inaccessible: {robots.status or robots.error}")
        robot_sitemaps = []
    else:
        robot_sitemaps = re.findall(r"(?im)^\s*Sitemap:\s*(\S+)\s*$", robots.body)
    sitemap_urls = []
    for u in robot_sitemaps + [BASE + "/sitemap.xml", BASE + "/sitemap-search.xml"]:
        u = normalise_url(u)
        if u and u not in sitemap_urls:
            sitemap_urls.append(u)

    pages = []
    sitemap_results = []
    queue = list(sitemap_urls)
    seen_maps = set()
    while queue and len(seen_maps) < 20:
        sm = queue.pop(0)
        if sm in seen_maps:
            continue
        seen_maps.add(sm)
        fr = fetch(sm, retries=4)
        item = {"url": sm, "status": fr.status, "error": fr.error, "count": 0}
        if fr.status != 200:
            critical.append(f"sitemap inaccessible: {sm} -> {fr.status or fr.error}")
            sitemap_results.append(item)
            continue
        try:
            kind, locs = parse_sitemap_xml(fr.body)
            item["count"] = len(locs)
            if kind == "sitemapindex":
                queue.extend([normalise_url(x) for x in locs if normalise_url(x)])
            else:
                for x in locs:
                    x = normalise_url(x)
                    if x and is_public_internal(x) and x not in pages:
                        pages.append(x)
        except Exception as e:
            item["error"] = f"XML parse error: {e}"
            critical.append(f"invalid sitemap XML: {sm}: {e}")
        sitemap_results.append(item)

    priority = [
        BASE + "/",
        BASE + "/recruitment-agency-india/",
        BASE + "/services/executive-search",
        BASE + "/industry/global-capability-centres-hiring-india",
        BASE + "/jobs",
        BASE + "/services/cv-assessment",
        BASE + "/services/professional-cv-rebuild",
        BASE + "/services/executive-cv",
        BASE + "/services/interview-coaching",
        BASE + "/guides/best-cv-writing-service-india",
        BASE + "/about/taru-shikha",
        BASE + "/regions/executive-search-gurgaon",
        BASE + "/regions/executive-search-mumbai",
        BASE + "/regions/executive-search-bangalore",
        BASE + "/regions/executive-search-chennai",
        BASE + "/regions/recruitment-agency-hyderabad",
        BASE + "/regions/recruitment-agency-pune",
        BASE + "/regions/recruitment-agency-delhi",
    ]
    ordered = []
    for u in priority + pages:
        if u not in ordered:
            ordered.append(u)
    return robots, sitemap_results, ordered, critical

def inspect_page(fr):
    result = {
        "url": fr.requested_url,
        "final_url": fr.final_url,
        "status": fr.status,
        "content_type": fr.content_type,
        "title": [],
        "description": [],
        "canonical": [],
        "h1": [],
        "robots": [],
        "schema_types": [],
        "invalid_jsonld": 0,
        "internal_links": [],
        "critical": [],
        "warnings": [],
    }
    if fr.status != 200:
        result["critical"].append(f"HTTP status {fr.status or fr.error}")
        return result
    if "text/html" not in fr.content_type.lower() and "<html" not in fr.body[:1000].lower():
        result["warnings"].append("non-HTML response")
        return result
    p = PageParser()
    try:
        p.feed(fr.body)
    except Exception as e:
        result["warnings"].append(f"HTML parser warning: {e}")
    result["title"] = p.titles
    result["description"] = p.descriptions
    result["canonical"] = p.canonicals
    result["h1"] = p.h1
    result["robots"] = p.robots
    if len(p.titles) != 1 or not p.titles[0].strip():
        result["critical"].append(f"title count={len(p.titles)}")
    if len(p.canonicals) != 1:
        result["critical"].append(f"canonical count={len(p.canonicals)}")
    else:
        canon = normalise_url(p.canonicals[0], fr.final_url)
        cp = urllib.parse.urlsplit(canon)
        if cp.scheme != "https" or cp.hostname not in ("hirednext.net", "www.hirednext.net"):
            result["critical"].append(f"invalid canonical={canon}")
    if any("noindex" in x for x in p.robots):
        result["critical"].append("noindex present on public audited page")
    if not p.descriptions or not any(x.strip() for x in p.descriptions):
        result["warnings"].append("meta description missing")
    if not p.h1 or not any(x.strip() for x in p.h1):
        result["warnings"].append("H1 missing")
    elif len(p.h1) > 1:
        result["warnings"].append(f"multiple H1 tags={len(p.h1)}")
    schema_types = []
    for raw in p.jsonld:
        try:
            obj = json.loads(raw)
            stack = [obj]
            while stack:
                item = stack.pop()
                if isinstance(item, dict):
                    t = item.get("@type")
                    if isinstance(t, str): schema_types.append(t)
                    elif isinstance(t, list): schema_types.extend([str(x) for x in t])
                    stack.extend(item.values())
                elif isinstance(item, list):
                    stack.extend(item)
        except Exception:
            result["invalid_jsonld"] += 1
    result["schema_types"] = sorted(set(schema_types))
    if result["invalid_jsonld"]:
        result["warnings"].append(f"invalid JSON-LD blocks={result['invalid_jsonld']}")
    for href in p.links:
        u = normalise_url(href, fr.final_url)
        if u and is_public_internal(u) and u not in result["internal_links"]:
            result["internal_links"].append(u)
    return result

def check_link(url):
    fr = fetch(url, retries=2, timeout=18)
    return {"url": url, "status": fr.status, "final_url": fr.final_url, "error": fr.error}

def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--output-dir", default="artifacts/production-seo-audit")
    ap.add_argument("--max-pages", type=int, default=180)
    ap.add_argument("--max-link-checks", type=int, default=220)
    args = ap.parse_args()
    outdir = Path(args.output_dir)
    outdir.mkdir(parents=True, exist_ok=True)

    robots, sitemaps, urls, critical = discover_urls()
    urls = urls[:args.max_pages]
    page_results = []
    for i, url in enumerate(urls, 1):
        print(f"[{i}/{len(urls)}] {url}", flush=True)
        page_results.append(inspect_page(fetch(url, retries=3)))

    internal = []
    for p in page_results:
        for u in p["internal_links"]:
            if u not in internal:
                internal.append(u)
    internal = internal[:args.max_link_checks]

    link_results = []
    with concurrent.futures.ThreadPoolExecutor(max_workers=8) as ex:
        for res in ex.map(check_link, internal):
            link_results.append(res)

    broken_links = [x for x in link_results if x["status"] == 0 or x["status"] >= 400]
    page_critical = [{"url": p["url"], "issues": p["critical"]} for p in page_results if p["critical"]]
    warnings = [{"url": p["url"], "issues": p["warnings"]} for p in page_results if p["warnings"]]
    critical.extend([f"{x['url']}: {', '.join(x['issues'])}" for x in page_critical])
    critical.extend([f"broken internal link {x['url']} -> {x['status'] or x['error']}" for x in broken_links])

    report = {
        "generated_at_utc": time.strftime("%Y-%m-%dT%H:%M:%SZ", time.gmtime()),
        "base": BASE,
        "robots": {"status": robots.status, "error": robots.error},
        "sitemaps": sitemaps,
        "pages_audited": len(page_results),
        "links_checked": len(link_results),
        "critical_count": len(critical),
        "warning_count": sum(len(x["issues"]) for x in warnings),
        "critical": critical,
        "warnings": warnings,
        "broken_internal_links": broken_links,
        "pages": page_results,
    }
    (outdir / "report.json").write_text(json.dumps(report, indent=2, ensure_ascii=False))

    lines = [
        "# HiredNext Production Search Authority Audit",
        "",
        f"- Generated: {report['generated_at_utc']}",
        f"- Pages audited: **{report['pages_audited']}**",
        f"- Internal links checked: **{report['links_checked']}**",
        f"- Critical issues: **{report['critical_count']}**",
        f"- Warnings: **{report['warning_count']}**",
        "",
    ]
    if critical:
        lines += ["## Critical issues"] + [f"- {x}" for x in critical[:100]] + [""]
    if warnings:
        lines += ["## Warnings"] + [f"- {x['url']}: {', '.join(x['issues'])}" for x in warnings[:100]] + [""]
    lines += ["## Sitemap sources"] + [
        f"- {x['url']}: status {x['status']}, URLs {x['count']}" + (f", {x['error']}" if x["error"] else "")
        for x in sitemaps
    ]
    (outdir / "summary.md").write_text("\n".join(lines) + "\n")

    print("\n".join(lines), flush=True)
    if critical:
        return 1
    return 0

if __name__ == "__main__":
    sys.exit(main())
