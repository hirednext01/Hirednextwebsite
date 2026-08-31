<?php

namespace App\Services\Cv;

class CvDocxRenderer
{
    private const NAVY = '0C3466';
    private const ORANGE = 'C96B09';
    private const TEXT = '172033';
    private const MUTED = '556070';

    /**
     * Render a standards-based DOCX with no tables, text boxes, images, headers or
     * footers containing candidate data. Content follows one linear ATS-safe order.
     */
    public function render(array $lead, array $document, array $content, string $path): void
    {
        if (!class_exists(\ZipArchive::class)) {
            throw new \RuntimeException('PHP ZipArchive is required to create DOCX files.');
        }

        $dir = dirname($path);
        if (!is_dir($dir) && !mkdir($dir, 0750, true) && !is_dir($dir)) {
            throw new \RuntimeException('Could not create CV export directory.');
        }

        $zip = new \ZipArchive();
        $opened = $zip->open($path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        if ($opened !== true) {
            throw new \RuntimeException('Could not create DOCX package.');
        }

        $template = (string) ($document['template_key'] ?? 'ats_classic');
        $branding = ($document['branding_mode'] ?? 'remove') === 'keep';

        $zip->addFromString('[Content_Types].xml', $this->contentTypes());
        $zip->addEmptyDir('_rels');
        $zip->addFromString('_rels/.rels', $this->rootRels());
        $zip->addEmptyDir('docProps');
        $zip->addFromString('docProps/core.xml', $this->coreProperties((string) ($lead['name'] ?? 'Candidate')));
        $zip->addFromString('docProps/app.xml', $this->appProperties());
        $zip->addEmptyDir('word');
        $zip->addFromString('word/document.xml', $this->documentXml($lead, $document, $content, $branding));
        $zip->addFromString('word/styles.xml', $this->stylesXml($template));
        $zip->addEmptyDir('word/_rels');
        $zip->addFromString('word/_rels/document.xml.rels', $this->documentRels());

        if (!$zip->close()) {
            @unlink($path);
            throw new \RuntimeException('Could not finalize DOCX package.');
        }

        if (!is_file($path) || filesize($path) < 1500) {
            @unlink($path);
            throw new \RuntimeException('Generated DOCX is unexpectedly small or missing.');
        }
    }

    private function documentXml(array $lead, array $document, array $content, bool $branding): string
    {
        $template = (string) ($document['template_key'] ?? 'ats_classic');
        $name = trim((string) ($lead['name'] ?? 'Candidate'));
        $email = trim((string) ($lead['email'] ?? ''));
        $phone = trim((string) ($lead['phone'] ?? ''));
        $target = trim((string) ($content['target_title'] ?? $content['headline'] ?? ''));

        $body = [];
        $body[] = $this->paragraph($name, 'CandidateName');
        if ($target !== '') {
            $body[] = $this->paragraph(mb_strtoupper($target), 'TargetTitle');
        }
        $contact = implode(' | ', array_values(array_filter([$email, $phone], fn ($v) => $v !== '')));
        if ($contact !== '') {
            $body[] = $this->paragraph($contact, 'ContactLine');
        }

        $summary = trim((string) ($content['summary'] ?? ''));
        if ($summary !== '') {
            $body[] = $this->heading($template === 'executive_ats' ? 'EXECUTIVE PROFILE' : 'PROFESSIONAL SUMMARY');
            $body[] = $this->paragraph($summary, 'BodyText');
        }

        $achievements = $this->strings($content['selected_achievements'] ?? []);
        if ($template === 'executive_ats' && $achievements) {
            $body[] = $this->heading('LEADERSHIP IMPACT');
            foreach ($achievements as $item) {
                $body[] = $this->bullet($item);
            }
        }

        $skills = $this->strings($content['core_skills'] ?? []);
        if ($skills) {
            $body[] = $this->heading($template === 'executive_ats' ? 'FUNCTIONAL EXPERTISE' : 'CORE COMPETENCIES');
            $body[] = $this->paragraph(implode(' | ', $skills), 'SkillLine');
        }

        $experience = is_array($content['experience'] ?? null) ? $content['experience'] : [];
        if ($experience) {
            $body[] = $this->heading('PROFESSIONAL EXPERIENCE');
            foreach ($experience as $role) {
                if (!is_array($role)) {
                    continue;
                }
                $company = trim((string) ($role['company'] ?? ''));
                $title = trim((string) ($role['title'] ?? ''));
                $location = trim((string) ($role['location'] ?? ''));
                $dates = trim((string) ($role['dates'] ?? ''));
                if ($company !== '') {
                    $body[] = $this->paragraph($company, 'CompanyName');
                }
                $line = trim($title . ($location !== '' ? ' | ' . $location : '') . ($dates !== '' ? ' | ' . $dates : ''));
                if ($line !== '') {
                    $body[] = $this->paragraph($line, 'RoleLine');
                }
                foreach ($this->strings($role['bullets'] ?? []) as $bullet) {
                    $body[] = $this->bullet($bullet);
                }
            }
        }

        if ($template !== 'executive_ats' && $achievements) {
            $body[] = $this->heading('SELECTED ACHIEVEMENTS');
            foreach ($achievements as $item) {
                $body[] = $this->bullet($item);
            }
        }

        $this->appendListSection($body, 'BOARD / STRATEGIC HIGHLIGHTS', $content['board_highlights'] ?? []);
        $this->appendListSection($body, 'EDUCATION', $content['education'] ?? [], false);
        $this->appendListSection($body, 'CERTIFICATIONS', $content['certifications'] ?? [], false);

        $tools = $this->strings($content['tools'] ?? []);
        if ($tools) {
            $body[] = $this->heading('TOOLS / PLATFORMS');
            $body[] = $this->paragraph(implode(' | ', $tools), 'SkillLine');
        }

        if ($branding) {
            $body[] = $this->paragraph('Prepared with HiredNext Career Services · hirednext.net', 'BrandCredit');
        }

        $body[] = '<w:sectPr><w:pgSz w:w="11906" w:h="16838"/><w:pgMar w:top="850" w:right="900" w:bottom="850" w:left="900" w:header="0" w:footer="0" w:gutter="0"/></w:sectPr>';

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<w:body>' . implode('', $body) . '</w:body></w:document>';
    }

    private function appendListSection(array &$body, string $heading, $items, bool $bullets = true): void
    {
        $items = $this->strings($items);
        if (!$items) {
            return;
        }
        $body[] = $this->heading($heading);
        foreach ($items as $item) {
            $body[] = $bullets ? $this->bullet($item) : $this->paragraph($item, 'BodyText');
        }
    }

    private function heading(string $text): string
    {
        return $this->paragraph($text, 'SectionHeading');
    }

    private function bullet(string $text): string
    {
        // Unicode bullet in ordinary paragraph text avoids numbering-part complexity
        // and remains highly portable for ATS parsers.
        return $this->paragraph('• ' . $text, 'BulletText');
    }

    private function paragraph(string $text, string $style): string
    {
        $xmlText = $this->x($text);
        return '<w:p><w:pPr><w:pStyle w:val="' . $this->x($style) . '"/></w:pPr><w:r><w:t xml:space="preserve">' . $xmlText . '</w:t></w:r></w:p>';
    }

    private function stylesXml(string $template): string
    {
        $modern = $template === 'ats_modern';
        $executive = $template === 'executive_ats';
        $nameFont = $modern ? 'Arial' : 'Georgia';
        $nameSize = $executive ? 38 : ($modern ? 34 : 36); // half-points
        $headingColor = self::NAVY;
        $accent = $modern ? 'E87522' : self::ORANGE;

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<w:styles xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">'
            . '<w:docDefaults><w:rPrDefault><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial"/><w:sz w:val="20"/><w:szCs w:val="20"/><w:color w:val="' . self::TEXT . '"/></w:rPr></w:rPrDefault><w:pPrDefault><w:pPr><w:spacing w:after="80" w:line="260" w:lineRule="auto"/></w:pPr></w:pPrDefault></w:docDefaults>'
            . $this->style('Normal', 'Normal', 'Arial', 20, self::TEXT, false, 0, 80)
            . $this->style('CandidateName', 'Candidate Name', $nameFont, $nameSize, self::NAVY, true, 0, 60, $executive ? 'center' : 'left')
            . $this->style('TargetTitle', 'Target Title', 'Arial', 20, $accent, true, 0, 50, $executive ? 'center' : 'left')
            . $this->style('ContactLine', 'Contact Line', 'Arial', 16, self::MUTED, false, 0, 160, $executive ? 'center' : 'left')
            . $this->style('SectionHeading', 'Section Heading', 'Arial', 20, $headingColor, true, 170, 70)
            . $this->style('BodyText', 'Body Text', 'Arial', 19, self::TEXT, false, 0, 80)
            . $this->style('SkillLine', 'Skill Line', 'Arial', 18, '25364D', false, 0, 120)
            . $this->style('CompanyName', 'Company Name', 'Arial', 20, self::NAVY, true, 120, 0)
            . $this->style('RoleLine', 'Role Line', 'Arial', 18, self::MUTED, true, 0, 40)
            . $this->style('BulletText', 'Bullet Text', 'Arial', 18, self::TEXT, false, 0, 40, 'left', 300)
            . $this->style('BrandCredit', 'Brand Credit', 'Arial', 14, '7A8595', false, 220, 0, 'center')
            . '</w:styles>';
    }

    private function style(string $id, string $name, string $font, int $size, string $color, bool $bold, int $before, int $after, string $align = 'left', int $left = 0): string
    {
        return '<w:style w:type="paragraph" w:styleId="' . $this->x($id) . '">'
            . '<w:name w:val="' . $this->x($name) . '"/>'
            . '<w:pPr><w:spacing w:before="' . $before . '" w:after="' . $after . '"/>'
            . ($left > 0 ? '<w:ind w:left="' . $left . '" w:hanging="220"/>' : '')
            . '<w:jc w:val="' . $align . '"/></w:pPr>'
            . '<w:rPr><w:rFonts w:ascii="' . $this->x($font) . '" w:hAnsi="' . $this->x($font) . '"/>'
            . '<w:color w:val="' . $color . '"/><w:sz w:val="' . $size . '"/><w:szCs w:val="' . $size . '"/>'
            . ($bold ? '<w:b/><w:bCs/>' : '')
            . '</w:rPr></w:style>';
    }

    private function contentTypes(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>'
            . '<Override PartName="/word/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.styles+xml"/>'
            . '<Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/>'
            . '<Override PartName="/docProps/app.xml" ContentType="application/vnd.openxmlformats-officedocument.extended-properties+xml"/>'
            . '</Types>';
    }

    private function rootRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/>'
            . '<Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties" Target="docProps/app.xml"/>'
            . '</Relationships>';
    }

    private function documentRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>';
    }

    private function coreProperties(string $candidate): string
    {
        $now = gmdate('Y-m-d\TH:i:s\Z');
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:dcmitype="http://purl.org/dc/dcmitype/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">'
            . '<dc:title>' . $this->x($candidate . ' CV') . '</dc:title><dc:creator>HiredNext Career Services</dc:creator>'
            . '<dcterms:created xsi:type="dcterms:W3CDTF">' . $now . '</dcterms:created>'
            . '<dcterms:modified xsi:type="dcterms:W3CDTF">' . $now . '</dcterms:modified>'
            . '</cp:coreProperties>';
    }

    private function appProperties(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties" xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">'
            . '<Application>HiredNext CV Studio</Application><AppVersion>1.0</AppVersion>'
            . '</Properties>';
    }

    private function strings($value): array
    {
        if (!is_array($value)) {
            return [];
        }
        $out = [];
        foreach ($value as $item) {
            if (!is_scalar($item)) {
                continue;
            }
            $item = trim((string) $item);
            if ($item !== '') {
                $out[] = $item;
            }
        }
        return $out;
    }

    private function x(string $text): string
    {
        return htmlspecialchars($text, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}
