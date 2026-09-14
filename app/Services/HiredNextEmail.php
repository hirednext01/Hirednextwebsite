<?php
declare(strict_types=1);
namespace App\Services;

/** Shared, inline-styled candidate correspondence; no remote fonts or tracking. */
final class HiredNextEmail
{
    public const FONT = "Aptos, 'Segoe UI', 'Helvetica Neue', Arial, sans-serif";
    public const NAVY = '#0c3466';
    public const ORANGE = '#ff4e16';

    public static function render(string $title, string $bodyHtml): string
    {
        $font=self::FONT;
        $title=htmlspecialchars($title,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');
        $heading=$title===''?'':'<h1 style="margin:0 0 22px;font-family:'.$font.';font-size:25px;line-height:1.3;font-weight:600;color:#0c3466">'.$title.'</h1>';
        return '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>HiredNext Recruitment</title></head>'.
            '<body style="margin:0;padding:0;background:#f4f6f9;font-family:'.$font.';color:#172033">'.
            '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f4f6f9"><tr><td align="center" style="padding:24px 12px;font-family:'.$font.'">'.
            '<table role="presentation" width="640" cellspacing="0" cellpadding="0" border="0" style="width:100%;max-width:640px;background:#ffffff;border:1px solid #e0e6ee">'.
            '<tr><td style="padding:27px 28px 23px;border-top:4px solid #ff4e16;border-bottom:1px solid #e0e6ee;font-family:'.$font.'">'.
            '<div style="font-size:27px;line-height:32px;font-weight:700;letter-spacing:-0.5px;color:#0c3466">HIRED<span style="color:#ff4e16">NEXT</span></div>'.
            '<div style="margin-top:3px;font-size:10px;line-height:15px;letter-spacing:2.5px;font-weight:600;color:#0c3466">RECRUITMENT</div></td></tr>'.
            '<tr><td style="padding:28px;font-family:'.$font.';font-size:16px;line-height:1.7;color:#172033;overflow-wrap:anywhere">'.$heading.$bodyHtml.'</td></tr>'.
            '<tr><td style="padding:19px 28px;border-top:1px solid #e0e6ee;font-family:'.$font.';font-size:12px;line-height:1.65;color:#556070">'.
            '<strong style="color:#0c3466;font-size:13px">HiredNext Recruitment</strong><br>'.
            '<a href="https://hirednext.net" style="color:#0c3466;text-decoration:underline">hirednext.net</a> &nbsp;·&nbsp; '.
            '<a href="mailto:jobs@hirednext.info" style="color:#0c3466;text-decoration:underline">jobs@hirednext.info</a></td></tr></table></td></tr></table></body></html>';
    }

    public static function fromText(string $title, string $text): string
    {
        $paragraphs=preg_split('/\n\s*\n/',str_replace("\r",'',trim($text))) ?: [];
        $html='';
        foreach ($paragraphs as $paragraph) {
            $escaped=htmlspecialchars($paragraph,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');
            $escaped=preg_replace_callback('~https?://[^\s<>]+~u',static fn($m)=>'<a href="'.$m[0].'" style="color:#0c3466;text-decoration:underline">'.$m[0].'</a>',$escaped) ?? $escaped;
            $html.='<p style="margin:0 0 18px;font-family:'.self::FONT.';font-size:16px;line-height:1.7;color:#172033">'.nl2br($escaped,false).'</p>';
        }
        return self::render($title,$html);
    }

    public static function applyText($email, string $title, string $text): void
    {
        $email->setMailType('html');
        $email->setMessage(self::fromText($title,$text));
        $email->setAltMessage($text);
    }
}
