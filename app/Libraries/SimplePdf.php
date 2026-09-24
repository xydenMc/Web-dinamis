<?php

namespace App\Libraries;

/** Small dependency-free PDF writer for plain text receipts and reports. */
class SimplePdf
{
    public static function render(array $lines): string
    {
        $wrapped = [];
        foreach ($lines as $line) {
            $line = trim((string) $line);
            if ($line === '') {
                $wrapped[] = '';
                continue;
            }
            foreach (explode("\n", wordwrap($line, 92, "\n", true)) as $part) {
                $wrapped[] = $part;
            }
        }

        $pages = array_chunk($wrapped ?: [''], 48);
        $objects = [
            1 => '<< /Type /Catalog /Pages 2 0 R >>',
            3 => '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
        ];
        $pageRefs = [];

        foreach ($pages as $index => $pageLines) {
            $pageId = 4 + ($index * 2);
            $contentId = $pageId + 1;
            $pageRefs[] = $pageId . ' 0 R';
            $commands = ["BT", "/F1 10 Tf", "45 795 Td", "15 TL"];
            foreach ($pageLines as $line) {
                $line = iconv('UTF-8', 'Windows-1252//TRANSLIT//IGNORE', $line) ?: '';
                $line = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $line);
                $commands[] = '(' . $line . ') Tj';
                $commands[] = 'T*';
            }
            $commands[] = 'ET';
            $stream = implode("\n", $commands);
            $objects[$pageId] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 3 0 R >> >> /Contents ' . $contentId . ' 0 R >>';
            $objects[$contentId] = '<< /Length ' . strlen($stream) . ">>\nstream\n" . $stream . "\nendstream";
        }

        $objects[2] = '<< /Type /Pages /Kids [' . implode(' ', $pageRefs) . '] /Count ' . count($pageRefs) . ' >>';
        ksort($objects);
        $pdf = "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n";
        $offsets = [0];
        $maxId = max(array_keys($objects));
        for ($id = 1; $id <= $maxId; $id++) {
            $offsets[$id] = strlen($pdf);
            $pdf .= $id . " 0 obj\n" . ($objects[$id] ?? '<<>>') . "\nendobj\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 " . ($maxId + 1) . "\n0000000000 65535 f \n";
        for ($id = 1; $id <= $maxId; $id++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$id]);
        }
        $pdf .= "trailer\n<< /Size " . ($maxId + 1) . " /Root 1 0 R >>\nstartxref\n" . $xrefOffset . "\n%%EOF";
        return $pdf;
    }
}
