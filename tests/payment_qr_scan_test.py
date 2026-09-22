#!/usr/bin/env python3
import base64
import pathlib
import re
import subprocess
import sys
import tempfile
import urllib.parse

root = pathlib.Path(__file__).resolve().parents[1]
gate = (root / "app/Views/components/business-payment-gate.php").read_text(encoding="utf-8")

matches = re.findall(r'data:image/png;base64,([A-Za-z0-9+/=]+)', gate)
if len(matches) != 1:
    raise SystemExit(f"FAIL: expected exactly one embedded business QR, found {len(matches)}")

png = base64.b64decode(matches[0], validate=True)
if not png.startswith(b"\x89PNG\r\n\x1a\n"):
    raise SystemExit("FAIL: embedded business QR is not a valid PNG payload")

with tempfile.NamedTemporaryFile(suffix=".png") as fh:
    fh.write(png)
    fh.flush()
    proc = subprocess.run(
        ["zbarimg", "--quiet", "--raw", fh.name],
        capture_output=True,
        text=True,
        timeout=20,
    )

payload = proc.stdout.strip()
if proc.returncode != 0 or not payload:
    raise SystemExit("FAIL: embedded business QR could not be decoded by zbarimg")

parsed = urllib.parse.urlparse(payload)
scheme = parsed.scheme.lower()
if scheme not in {"upi", "https", "http"}:
    raise SystemExit(f"FAIL: decoded QR uses unexpected scheme: {scheme or 'none'}")

query = urllib.parse.parse_qs(parsed.query)
if "am" in query and any(v.strip() for v in query["am"]):
    raise SystemExit("FAIL: central reusable business QR hard-codes an amount")

print(f"PASS: business QR decodes successfully; scheme={scheme}; reusable_amount=true")
