"""Render exactly three assessment pages. No network calls or paid dependencies.

Usage: python render_cv_assessment.py assessment.json assessment.pdf
The caller must check the rendered pages before setting quality.layout_checked.
"""
from __future__ import annotations
import json
import hashlib
import sys
from pathlib import Path
from xml.sax.saxutils import escape

from reportlab.lib import colors
from reportlab.lib.enums import TA_LEFT
from reportlab.lib.pagesizes import A4
from reportlab.lib.styles import ParagraphStyle
from reportlab.pdfbase import pdfmetrics
from reportlab.pdfbase.ttfonts import TTFont
from reportlab.pdfgen import canvas
from reportlab.platypus import Paragraph


def render(report: dict, output: Path) -> None:
    if len(report.get('pages', [])) != 3:
        raise ValueError('Exactly three report pages are required')
    fonts = Path('/usr/share/fonts/truetype/dejavu')
    regular = fonts / 'DejaVuSans.ttf'
    bold = fonts / 'DejaVuSans-Bold.ttf'
    if not regular.exists() or not bold.exists():
        raise RuntimeError('DejaVu Sans fonts must be available before rendering')
    pdfmetrics.registerFont(TTFont('HNBody', str(regular)))
    pdfmetrics.registerFont(TTFont('HNStrong', str(bold)))
    width, height = A4
    margin = 45
    inner = width - 2 * margin
    navy = colors.HexColor('#123453')
    grey = colors.HexColor('#566473')
    body = ParagraphStyle('body', fontName='HNBody', fontSize=9.6, leading=14.3, textColor=colors.HexColor('#25303b'), alignment=TA_LEFT)
    heading = ParagraphStyle('heading', fontName='HNStrong', fontSize=11.2, leading=15, textColor=navy)
    title = ParagraphStyle('title', fontName='HNStrong', fontSize=20, leading=26, textColor=navy)
    meta = ParagraphStyle('meta', fontName='HNBody', fontSize=9.2, leading=13.5, textColor=grey)
    output.parent.mkdir(parents=True, exist_ok=True)
    document = canvas.Canvas(str(output), pagesize=A4, pageCompression=1)
    document.setTitle('HiredNext CV Assessment - ' + report['candidate_name'])
    document.setAuthor('HiredNext Recruitment')
    document.setSubject('Confidential CV assessment')
    manifest = [report['candidate_name'], report.get('target_role', ''), report.get('delivery_id', ''), report['source_sha256'], [[p['title'], [[s['heading'], s['text']] for s in p['sections']]] for p in report['pages']]]
    digest = hashlib.sha256(json.dumps(manifest, ensure_ascii=False, separators=(',', ':')).encode()).hexdigest()
    document.setKeywords('HN_REPORT_SHA256:' + digest)

    def paragraph(text: str, style: ParagraphStyle, y: float, gap: float = 9) -> float:
        item = Paragraph(escape(str(text)).replace('\n', '<br/>'), style)
        _, used = item.wrap(inner, height)
        if y - used < 65:
            raise ValueError('Assessment content exceeds the page; edit the text rather than clipping or shrinking it')
        item.drawOn(document, margin, y - used)
        return y - used - gap

    for number, page in enumerate(report['pages'], 1):
        document.setFillColor(navy)
        document.setFont('HNStrong', 16)
        document.drawString(margin, height - 43, 'HIREDNEXT')
        document.setFont('HNBody', 7.4)
        document.drawString(margin, height - 56, 'R E C R U I T M E N T')
        document.setFillColor(grey)
        document.setFont('HNBody', 7.7)
        document.drawRightString(width - margin, height - 44, 'CONFIDENTIAL CV ASSESSMENT')
        document.drawRightString(width - margin, height - 57, str(report.get('delivery_id', 'Assessment preview')))
        document.setStrokeColor(colors.HexColor('#d5dde4'))
        document.line(margin, height - 70, width - margin, height - 70)
        y = height - 91
        y = paragraph(page['title'], title, y, 11)
        y = paragraph(report['candidate_name'] + '  |  Target: ' + report.get('target_role', 'Not specified'), meta, y, 16)
        for section in page['sections']:
            y = paragraph(section['heading'], heading, y, 5)
            y = paragraph(section['text'], body, y, 14)
        document.setStrokeColor(colors.HexColor('#d5dde4'))
        document.line(margin, 49, width - margin, 49)
        document.setFillColor(grey)
        document.setFont('HNBody', 7)
        footer = 'INTERNAL TEST - FICTIONAL CV - NO SALE' if report.get('is_test') else 'Based on the submitted CV. No job, interview or shortlist guarantee.'
        document.drawString(margin, 35, footer)
        document.drawRightString(width - margin, 35, f'{number} / 3')
        document.showPage()
    document.save()


if __name__ == '__main__':
    render(json.loads(Path(sys.argv[1]).read_text()), Path(sys.argv[2]))
    print('Rendered three-page assessment:', sys.argv[2])
