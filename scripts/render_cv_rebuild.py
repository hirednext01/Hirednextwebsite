"""Render two truthful CV variants as PDFs; the website creates their DOCX partners.

Usage: python scripts/render_cv_rebuild.py bundle.json output_directory
The input has order contact details plus the structured bundle contract. Output
PDFs are inserted into bundle-ready.json; no network or model API is called.
"""
from __future__ import annotations
import base64
import hashlib
import json
import sys
from pathlib import Path
from xml.sax.saxutils import escape
from reportlab.lib import colors
from reportlab.lib.enums import TA_CENTER, TA_LEFT
from reportlab.lib.pagesizes import A4
from reportlab.lib.styles import ParagraphStyle
from reportlab.pdfbase import pdfmetrics
from reportlab.pdfbase.ttfonts import TTFont
from reportlab.platypus import SimpleDocTemplate, Paragraph, Spacer, KeepTogether
from render_cv_assessment import render as render_assessment


def canonical(value):
    if isinstance(value, dict):
        return {key: canonical(value[key]) for key in sorted(value)} if value else []
    if isinstance(value, list):
        return [canonical(item) for item in value]
    return value


def render_cv(bundle: dict, variant: dict, output: Path) -> None:
    fonts = Path('/usr/share/fonts/truetype/dejavu')
    for name, filename in [('CVBody', 'DejaVuSans.ttf'), ('CVBold', 'DejaVuSans-Bold.ttf'), ('CVTitle', 'DejaVuSerif.ttf')]:
        pdfmetrics.registerFont(TTFont(name, str(fonts / filename)))
    template = variant['template_key']
    content = variant['content']
    executive = template == 'executive_ats'
    modern = template == 'ats_modern'
    navy, orange = colors.HexColor('#0c3466'), colors.HexColor('#ff4e16')
    body = ParagraphStyle('body', fontName='CVBody', fontSize=10.3, leading=15.3, textColor=colors.HexColor('#172033'), spaceAfter=6)
    bullet = ParagraphStyle('bullet', parent=body, leftIndent=10, firstLineIndent=-10, spaceAfter=5)
    heading = ParagraphStyle('heading', parent=body, fontName='CVBold', fontSize=10.5, leading=15, textColor=navy, spaceBefore=15, spaceAfter=7, keepWithNext=True)
    company = ParagraphStyle('company', parent=body, fontName='CVBold', fontSize=11.2, textColor=navy, spaceBefore=12, spaceAfter=3, keepWithNext=True)
    role = ParagraphStyle('role', parent=body, fontSize=9.5, leading=14, textColor=colors.HexColor('#556070'), spaceAfter=7, keepWithNext=True)
    align = TA_CENTER if executive else TA_LEFT
    name = ParagraphStyle('name', parent=body, fontName='CVTitle' if executive else 'CVBold', fontSize=23 if executive else 21, leading=29, textColor=navy, alignment=align, spaceAfter=8)
    target = ParagraphStyle('target', parent=body, fontName='CVBold', fontSize=11, leading=16, textColor=navy, alignment=align, spaceAfter=7)
    contact = ParagraphStyle('contact', parent=body, fontSize=9, leading=13, textColor=colors.HexColor('#556070'), alignment=align, spaceAfter=16)
    paragraphs = []

    def p(text: str, style=body):
        return Paragraph(escape(str(text)), style)

    paragraphs.extend([p(bundle['candidate_name'], name), p(content.get('target_title') or content.get('headline', ''), target)])
    contact_text = ' | '.join(str(bundle.get(k, '')).strip() for k in ('candidate_email', 'candidate_phone') if str(bundle.get(k, '')).strip())
    if contact_text:
        paragraphs.append(p(contact_text, contact))

    def section(title: str, values: list, as_bullets: bool = True):
        if not values:
            return
        paragraphs.append(p(title, heading))
        paragraphs.extend(p(('• ' if as_bullets else '') + str(value), bullet if as_bullets else body) for value in values)

    paragraphs.extend([p('EXECUTIVE PROFILE' if executive else 'PROFESSIONAL SUMMARY', heading), p(content['summary'])])
    if executive:
        section('SELECTED IMPACT', content.get('selected_achievements', []))
    section('CORE COMPETENCIES', [' | '.join(content.get('core_skills', []))] if content.get('core_skills') else [], False)
    paragraphs.append(p('PROFESSIONAL EXPERIENCE', heading))
    for position in content['experience']:
        items = [p(position['company'], company), p(' | '.join(str(position.get(k, '')).strip() for k in ('title', 'location', 'dates') if str(position.get(k, '')).strip()), role)]
        bullets = position['bullets']
        if bullets:
            items.append(p('• ' + str(bullets[0]), bullet))
        paragraphs.append(KeepTogether(items))
        paragraphs.extend(p('• ' + str(text), bullet) for text in bullets[1:])
        paragraphs.append(Spacer(1, 5))
    if not executive:
        section('SELECTED ACHIEVEMENTS', content.get('selected_achievements', []))
    section('BOARD / STRATEGIC HIGHLIGHTS', content.get('board_highlights', []))
    section('EDUCATION', content.get('education', []), False)
    section('CERTIFICATIONS', content.get('certifications', []), False)
    section('TOOLS / PLATFORMS', [' | '.join(content.get('tools', []))] if content.get('tools') else [], False)
    manifest = [bundle['candidate_name'], bundle['candidate_email'], bundle.get('candidate_phone', ''), template, bundle['delivery_id'], bundle['source_sha256'], bundle['answers_sha256'], canonical(content)]
    digest = hashlib.sha256(json.dumps(manifest, ensure_ascii=False, separators=(',', ':')).encode()).hexdigest()
    pages = []

    def decorate(canvas, document):
        pages.append(document.page)
        canvas.setTitle(bundle['candidate_name'] + ' - CV')
        canvas.setAuthor(bundle['candidate_name'])
        canvas.setKeywords('HN_CV_SHA256:' + digest)
        canvas.setStrokeColor(navy)
        canvas.setLineWidth(0.55)
        if executive:
            canvas.line(42, A4[1] - 31, A4[0] - 42, A4[1] - 31)
            canvas.line(42, 35, A4[0] - 42, 35)
        elif modern:
            canvas.setStrokeColor(orange)
            canvas.setLineWidth(2)
            canvas.line(31, 44, 31, A4[1] - 44)
        else:
            canvas.line(46, A4[1] - 32, A4[0] - 46, A4[1] - 32)
        canvas.setFillColor(colors.HexColor('#556070'))
        canvas.setFont('CVBody', 7)
        canvas.drawRightString(A4[0] - 46, 23, str(document.page))
        if document.page > 1:
            canvas.drawString(46, A4[1] - 25, bundle['candidate_name'] + ' | continued')

    document = SimpleDocTemplate(str(output), pagesize=A4, leftMargin=47, rightMargin=47, topMargin=45, bottomMargin=47)
    document.build(paragraphs, onFirstPage=decorate, onLaterPages=decorate)
    if not 1 <= len(pages) <= 4:
        output.unlink(missing_ok=True)
        raise ValueError('CV must fit within four readable pages; revise content rather than reducing the type size')


def render_bundle(data: dict, directory: Path) -> dict:
    directory.mkdir(parents=True, exist_ok=True)
    for index, variant in enumerate(data['variants'], 1):
        output = directory / f"{data['delivery_id']}-{index}.pdf"
        render_cv(data, variant, output)
        variant['pdf_base64'] = base64.b64encode(output.read_bytes()).decode()
    if data.get('assessment'):
        report = data['assessment']['report']
        output = directory / f"{report['delivery_id']}.pdf"
        render_assessment(report, output)
        data['assessment']['pdf_base64'] = base64.b64encode(output.read_bytes()).decode()
    (directory / 'bundle-ready.json').write_text(json.dumps(data, ensure_ascii=False, separators=(',', ':')))
    return data


if __name__ == '__main__':
    render_bundle(json.loads(Path(sys.argv[1]).read_text()), Path(sys.argv[2]))
    print('Rendered CV variants and prepared the private delivery bundle.')
