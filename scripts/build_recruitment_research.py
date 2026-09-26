#!/usr/bin/env python3
"""Build the public HTML and PDF edition from one editorial source."""
import json, html
from pathlib import Path
from reportlab.platypus import SimpleDocTemplate, Paragraph, Spacer, Table, TableStyle, PageBreak, KeepTogether
from reportlab.lib.styles import ParagraphStyle
from reportlab.lib.colors import HexColor, white
from reportlab.lib.enums import TA_LEFT
from reportlab.lib.utils import ImageReader
from reportlab.pdfbase import pdfmetrics
from reportlab.pdfbase.ttfonts import TTFont

ROOT=Path(__file__).resolve().parents[1]
DATA=json.loads((ROOT/'docs/research/india-recruitment-sep2026.json').read_text())
OUT=ROOT/'public/reports'
OUT.mkdir(exist_ok=True)
NAVY='#0c3466'; ORANGE='#ff4e16'
LOGO=ROOT/'public/theme/assets/logo.jpeg'
FONT='/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
pdfmetrics.registerFont(TTFont('Research', FONT))
pdfmetrics.registerFont(TTFont('ResearchBold','/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'))
pdfmetrics.registerFontFamily('Research',normal='Research',bold='ResearchBold',italic='Research',boldItalic='ResearchBold')
styles={
 'title':ParagraphStyle('title',fontName='ResearchBold',fontSize=25,leading=29,textColor=HexColor(NAVY),spaceAfter=12),
 'subtitle':ParagraphStyle('subtitle',fontName='Research',fontSize=10,leading=14,textColor=HexColor('#526071'),spaceAfter=14),
 'page':ParagraphStyle('page',fontName='ResearchBold',fontSize=18,leading=23,textColor=HexColor(NAVY),spaceAfter=10),
 'h2':ParagraphStyle('h2',fontName='ResearchBold',fontSize=11,leading=15,textColor=HexColor(NAVY),spaceBefore=11,spaceAfter=5),
 'body':ParagraphStyle('body',fontName='Research',fontSize=9.2,leading=13,textColor=HexColor('#263447'),spaceAfter=7),
 'small':ParagraphStyle('small',fontName='Research',fontSize=7.3,leading=10,textColor=HexColor('#536071'),spaceAfter=4),
 'cell':ParagraphStyle('cell',fontName='Research',fontSize=8,leading=11,textColor=HexColor('#263447'),spaceAfter=0),
 'head':ParagraphStyle('head',fontName='ResearchBold',fontSize=8,leading=11,textColor=white)
}
def p(t,k='body'): return Paragraph(html.escape(t),styles[k])
def furniture(c,d):
 c.saveState(); w,h=d.pagesize
 c.setFillColor(HexColor(NAVY));c.rect(0,h-58,w,58,fill=1,stroke=0)
 c.drawImage(str(LOGO),36,h-44,width=142,height=29.4,preserveAspectRatio=True,mask='auto')
 c.setFillColor(white);c.setFont('Research',7.5);c.drawRightString(w-36,h-31,'RECRUITMENT INTELLIGENCE  |  26 SEP 2026')
 c.setStrokeColor(HexColor(ORANGE));c.setLineWidth(2);c.line(36,37,w-36,37)
 c.setFillColor(HexColor(NAVY));c.setFont('Research',7);c.drawString(36,23,'HiredNext Recruitment  |  India')
 c.drawRightString(w-36,23,str(d.page));c.restoreState()

CSS="""*{box-sizing:border-box}body{margin:0;background:#f8f7f4;color:#233244;font:17px/1.65 Arial,sans-serif}a{color:#0c3466;text-underline-offset:3px}a:hover{color:#d13b0b}a:focus-visible{outline:3px solid #ff4e16;outline-offset:5px}header{background:#0c3466;padding:18px max(5vw,20px);display:flex;align-items:center;justify-content:space-between;gap:24px}header img{display:block;width:190px;max-width:40vw;height:auto}nav{display:flex;gap:20px;flex-wrap:wrap}nav a{font-size:14px;color:#fff;text-decoration:none}.skip{position:absolute;left:8px;top:-80px;background:white;padding:8px;z-index:10}.skip:focus{top:8px}.hero{background:#0c3466;color:white;padding:48px max(5vw,20px);background-image:radial-gradient(ellipse at 100% 0,rgba(255,78,22,.15),transparent 65%)}.wrap{max-width:1030px;margin:auto}.eyebrow{font-size:12px;text-transform:uppercase;letter-spacing:.14em;color:#ff4e16;font-weight:bold}h1{font:700 clamp(30px,4vw,49px)/1.14 Georgia,serif;max-width:890px;margin:14px 0 20px}h2{font:700 28px/1.2 Georgia,serif;color:#0c3466;margin:26px 0 12px}h3{font-size:19px;color:#0c3466;margin:24px 0 8px}p{margin:0 0 15px}.hero p{max-width:810px;color:#dce7f4}.date{font-size:13px;margin:20px 0}.button{display:inline-block;background:#ff4e16;color:white;font-weight:bold;font-size:15px;padding:12px 20px;border-radius:7px;text-decoration:none}.button:hover{color:white;background:#d83c0b}.main{padding:30px max(5vw,20px) 48px}.thesis{border-left:4px solid #ff4e16;background:white;padding:20px 24px;font-size:20px;font-weight:bold;color:#0c3466}.block{margin:28px 0}.card{background:white;border:1px solid #dce0e5;border-radius:10px;padding:24px;margin:18px 0}.grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}.grid .card{margin:0}.small{font-size:13px;color:#596576}.table-wrap{overflow-x:auto}table{border-collapse:collapse;width:100%;font-size:15px}th,td{text-align:left;vertical-align:top;padding:13px;border:1px solid #d9e0e8}th{background:#0c3466;color:white}tr:nth-child(even){background:#eef2f7}li{margin:8px 0}.sources a{overflow-wrap:anywhere}.cta{background:#edf2f8;border-radius:10px;padding:24px;margin-top:30px}footer{background:#0c3466;color:white;padding:20px max(5vw,20px);font-size:13px}footer a{color:white}@media(max-width:650px){header{align-items:flex-start;gap:15px}nav{gap:8px 14px}nav a{font-size:12px}.hero{padding-top:32px;padding-bottom:30px}.grid{grid-template-columns:1fr}body{font-size:16px}.thesis{font-size:18px}.card{padding:20px}th,td{padding:10px;min-width:110px}}"""
def head(title,desc,url,schema):
 return '<!doctype html><html lang="en-IN"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>'+html.escape(title)+' | HiredNext</title><meta name="description" content="'+html.escape(desc,quote=True)+'"><meta name="robots" content="index,follow,max-image-preview:large"><link rel="canonical" href="'+url+'"><meta property="og:title" content="'+html.escape(title,quote=True)+'"><meta property="og:description" content="'+html.escape(desc,quote=True)+'"><meta property="og:url" content="'+url+'"><meta property="og:type" content="article"><meta property="og:image" content="https://hirednext.net/theme/assets/logo.jpeg"><meta name="twitter:card" content="summary"><style>'+CSS+'</style><script type="application/ld+json">'+json.dumps(schema,ensure_ascii=False).replace('<','\\u003c')+'</script></head><body><a class="skip" href="#content">Skip to content</a><header><a href="/"><img src="/theme/assets/logo.jpeg" alt="HiredNext Recruitment home" width="2048" height="424"></a><nav aria-label="Primary"><a href="/services/clients">For Employers</a><a href="/reports/">Research</a><a href="/blog">Insights</a><a href="/hiring-discussion">Discuss a mandate</a></nav></header>'
def section_html(s):
 out='<section><h3>'+html.escape(s['title'])+'</h3>'
 for v in s.get('paragraphs',[]): out+='<p>'+html.escape(v)+'</p>'
 if s.get('bullets'): out+='<ul>'+''.join('<li>'+html.escape(b)+'</li>' for b in s['bullets'])+'</ul>'
 if s.get('table'):
  t=s['table'];out+='<div class="table-wrap"><table><thead><tr>'+''.join('<th scope="col">'+html.escape(h)+'</th>' for h in t['headers'])+'</tr></thead><tbody>'+''.join('<tr>'+''.join('<td>'+html.escape(c)+'</td>' for c in row)+'</tr>' for row in t['rows'])+'</tbody></table></div>'
 return out+'</section>'
footer='<footer><div class="wrap">HiredNext Recruitment · Founded 2016 · Executive recruitment and talent advisory<br><a href="/press-media">Press &amp; Media</a> · <a href="/testimonials">Testimonials</a> · <a href="/hiring-intelligence">Hiring Intelligence</a></div></footer></body></html>'
for report in DATA['reports']:
 slug=report['slug'];url='https://hirednext.net/reports/'+slug+'.html'
 story=[]
 for index,page in enumerate(report['pages']):
  if index: story.append(PageBreak())
  if index==0:
   story.extend([p(report['short_title'],'title'),p(report['subtitle'],'subtitle'),p(report['thesis'],'body'),Spacer(1,6)])
  story.extend([p(page['title'],'page'),p(page['intro'])])
  for s in page['sections']:
   chunk=[p(s['title'],'h2')]
   chunk.extend(p(t) for t in s.get('paragraphs',[]))
   chunk.extend(p('• '+t) for t in s.get('bullets',[]))
   if s.get('table'):
    t=s['table']; rows=[[p(x,'head') for x in t['headers']]]+[[p(x,'cell') for x in row] for row in t['rows']]
    table=Table(rows,colWidths=[112,399],hAlign='LEFT')
    table.setStyle(TableStyle([('BACKGROUND',(0,0),(-1,0),HexColor(NAVY)),('ROWBACKGROUNDS',(0,1),(-1,-1),[white,HexColor('#eef2f7')]),('VALIGN',(0,0),(-1,-1),'TOP'),('LEFTPADDING',(0,0),(-1,-1),8),('RIGHTPADDING',(0,0),(-1,-1),8),('TOPPADDING',(0,0),(-1,-1),7),('BOTTOMPADDING',(0,0),(-1,-1),7)]))
    chunk.append(table)
   story.append(KeepTogether(chunk))
 story.extend([Spacer(1,8),p('Sources and scope','h2')])
 for s in report['sources']:
  story.append(Paragraph('['+str(s['id'])+'] <link href="'+html.escape(s['url'],quote=True)+'" color="'+NAVY+'">'+html.escape(s['title'])+'</link>',styles['small']))
 story.append(p('Sources checked 26 September 2026. '+DATA['methodology'],'small'))
 story.append(Paragraph('<link href="https://hirednext.net/hiring-discussion" color="'+ORANGE+'"><b>Discuss a confidential hiring mandate with HiredNext →</b></link>',styles['body']))
 doc=SimpleDocTemplate(str(OUT/(slug+'.pdf')),pagesize=(595.28,841.89),rightMargin=42,leftMargin=42,topMargin=76,bottomMargin=48,title=report['title'],author='HiredNext Recruitment',subject=report['description'])
 doc.build(story,onFirstPage=furniture,onLaterPages=furniture)
 schema={'@context':'https://schema.org','@type':'Report','@id':url+'#report','name':report['title'],'headline':report['title'],'description':report['description'],'datePublished':DATA['date'],'dateModified':DATA['date'],'inLanguage':'en-IN','url':url,'author':{'@type':'Organization','name':'HiredNext Recruitment','@id':'https://hirednext.net/#organization'},'publisher':{'@type':'Organization','name':'HiredNext Recruitment','@id':'https://hirednext.net/#organization'},'citation':[s['url'] for s in report['sources']],'encoding':{'@type':'MediaObject','contentUrl':url.replace('.html','.pdf'),'encodingFormat':'application/pdf'},'isPartOf':{'@type':'CollectionPage','url':'https://hirednext.net/reports/'}}
 body=head(report['title'],report['description'],url,schema)
 body+='<div class="hero"><div class="wrap"><div class="eyebrow">HiredNext Recruitment Intelligence</div><h1>'+html.escape(report['title'])+'</h1><p>'+html.escape(report['subtitle'])+'</p><div class="date">HiredNext Editorial · <time datetime="2026-09-26">26 September 2026</time></div><a class="button" href="'+slug+'.pdf">Download the PDF</a></div></div><main id="content" class="main"><div class="wrap"><p class="thesis">'+html.escape(report['thesis'])+'</p>'
 for page in report['pages']: body+='<section class="block"><h2>'+html.escape(page['title'])+'</h2><p>'+html.escape(page['intro'])+'</p>'+''.join(section_html(s) for s in page['sections'])+'</section>'
 body+='<section class="sources card"><h2>Sources and methodology</h2><ol>'+''.join('<li id="source-'+str(s['id'])+'"><a href="'+s['url']+'" target="_blank" rel="noopener noreferrer">'+html.escape(s['title'])+'</a></li>' for s in report['sources'])+'</ol><p class="small">Sources checked 26 September 2026. '+html.escape(DATA['methodology'])+'</p></section><p>Read the companion paper: <a href="'+report['related']+'.html">'+html.escape(next(r['title'] for r in DATA['reports'] if r['slug']==report['related']))+'</a>.</p><div class="cta"><h2>Discuss the hiring behind your growth plan</h2><p>For employers, GCC leaders and portfolio teams considering a recruitment mandate in India.</p><a class="button" href="/hiring-discussion">Discuss a confidential mandate</a></div></div></main>'+footer
 (OUT/(slug+'.html')).write_text(body)
schema={'@context':'https://schema.org','@type':'CollectionPage','name':'India Recruitment Research | HiredNext','url':'https://hirednext.net/reports/','mainEntity':{'@type':'ItemList','itemListElement':[{'@type':'ListItem','position':i+1,'name':r['title'],'url':'https://hirednext.net/reports/'+r['slug']+'.html'} for i,r in enumerate(DATA['reports'])]}}
index=head('India Recruitment Research','Source-linked recruitment research for employers, GCC leaders, PE operating partners and HR-tech investors.','https://hirednext.net/reports/',schema)
index+='<div class="hero"><div class="wrap"><div class="eyebrow">HiredNext Recruitment Intelligence</div><h1>The hiring behind the investment.</h1><p>India recruitment research and practical decision frameworks for employers, GCC leaders and investors.</p></div></div><main id="content" class="main"><div class="wrap"><div class="grid">'
for r in DATA['reports']:
 index+='<article class="card"><div class="eyebrow">26 September 2026</div><h2>'+html.escape(r['title'])+'</h2><p>'+html.escape(r['description'])+'</p><a href="'+r['slug']+'.html">Read the paper →</a> · <a href="'+r['slug']+'.pdf">Download PDF</a></article>'
index+='</div><p class="small" style="margin-top:24px">'+html.escape(DATA['methodology'])+'</p><p>Earlier edition: <a href="hirednext-leadership-hiring-pulse-2026-08-24.html">Leadership Hiring Pulse, 24 August 2026</a></p><div class="cta"><h2>Planning a critical hire in India?</h2><p>Bring the business problem and the capability you need. We begin with a confidential mandate discussion.</p><a class="button" href="/hiring-discussion">Discuss a hiring mandate</a></div></div></main>'+footer
(OUT/'index.html').write_text(index)
print('Built two HTML papers, two PDFs and the research index.')

