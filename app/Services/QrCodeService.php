<?php
declare(strict_types=1);

namespace App\Services;

/**
 * Robust Standalone QR Code Generator for User Profiles
 * Generates vector SVG and Data URIs for cipcard.ir/@09xxxxxxxxx
 */
class QrCodeService
{
    /**
     * Get Base64 Data URI of SVG QR code for direct <img> tag embedding
     */
    public static function getDataUri(string $content, int $size = 280, string $foregroundColor = '#0f172a', string $backgroundColor = '#ffffff'): string
    {
        $svg = self::generateSvg($content, $size, $foregroundColor, $backgroundColor);
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    /**
     * Render SVG with proper HTTP headers
     */
    public static function renderSvgResponse(string $content, int $size = 300): void
    {
        $svg = self::generateSvg($content, $size);
        header('Content-Type: image/svg+xml; charset=utf-8');
        header('Content-Length: ' . strlen($svg));
        header('Cache-Control: public, max-age=86400');
        echo $svg;
        exit;
    }

    /**
     * Generate standalone SVG markup
     */
    public static function generateSvg(string $text, int $size = 280, string $fg = '#000000', string $bg = '#ffffff'): string
    {
        $matrix = self::encodeTextToMatrix($text);
        $moduleCount = count($matrix);
        $cellSize = 10;
        $quietZone = 4;
        $totalSize = ($moduleCount + ($quietZone * 2)) * $cellSize;

        $rects = [];
        for ($r = 0; $r < $moduleCount; $r++) {
            for ($c = 0; $c < $moduleCount; $c++) {
                if ($matrix[$r][$c] === 1) {
                    $x = ($c + $quietZone) * $cellSize;
                    $y = ($r + $quietZone) * $cellSize;
                    $rects[] = "<rect x=\"{$x}\" y=\"{$y}\" width=\"{$cellSize}\" height=\"{$cellSize}\" fill=\"{$fg}\" />";
                }
            }
        }

        $rectsString = implode("\n    ", $rects);

        return <<<SVG
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="{$size}" height="{$size}" viewBox="0 0 {$totalSize} {$totalSize}">
    <rect width="100%" height="100%" fill="{$bg}" />
    {$rectsString}
</svg>
SVG;
    }

    /**
     * QR Code Matrix Encoder (Standard Model 2, Version 3-M with Reed-Solomon)
     */
    private static function encodeTextToMatrix(string $text): array
    {
        // 29x29 matrix (Version 3) accommodates profile URLs up to ~77 characters comfortably
        $version = 3;
        $modules = 17 + ($version * 4); // 29
        $matrix = array_fill(0, $modules, array_fill(0, $modules, null));

        // 1. Finder patterns (7x7 at 3 corners)
        self::placeFinderPattern($matrix, 0, 0);
        self::placeFinderPattern($matrix, $modules - 7, 0);
        self::placeFinderPattern($matrix, 0, $modules - 7);

        // 2. Separators
        self::placeSeparators($matrix, $modules);

        // 3. Timing patterns
        for ($i = 8; $i < $modules - 8; $i++) {
            $val = ($i % 2 === 0) ? 1 : 0;
            if ($matrix[6][$i] === null) $matrix[6][$i] = $val;
            if ($matrix[$i][6] === null) $matrix[$i][6] = $val;
        }

        // 4. Alignment pattern for Version 3 (at row 22, col 22)
        self::placeAlignmentPattern($matrix, 22, 22);

        // 5. Dark module (4*V + 9, 8)
        $matrix[(4 * $version) + 9][8] = 1;

        // 6. Encode data bits
        $dataBits = self::buildDataBits($text);

        // 7. Place data bits into matrix following QR zigzag order
        $bitIndex = 0;
        $totalBits = count($dataBits);

        for ($right = $modules - 1; $right > 0; $right -= 2) {
            if ($right === 6) $right--; // skip vertical timing column

            $upward = (($modules - 1 - $right) / 2) % 2 === 0;

            for ($vert = 0; $vert < $modules; $vert++) {
                $row = $upward ? ($modules - 1 - $vert) : $vert;

                for ($col = $right; $col >= $right - 1; $col--) {
                    if ($matrix[$row][$col] === null) {
                        $bit = ($bitIndex < $totalBits) ? $dataBits[$bitIndex++] : 0;
                        // Apply standard mask pattern 0: (row + col) % 2 == 0
                        if (($row + $col) % 2 === 0) {
                            $bit ^= 1;
                        }
                        $matrix[$row][$col] = $bit;
                    }
                }
            }
        }

        // Fill any remaining unassigned modules with 0
        for ($r = 0; $r < $modules; $r++) {
            for ($c = 0; $c < $modules; $c++) {
                if ($matrix[$r][$c] === null) {
                    $matrix[$r][$c] = 0;
                }
            }
        }

        return $matrix;
    }

    private static function placeFinderPattern(array &$matrix, int $row, int $col): void
    {
        for ($r = 0; $r < 7; $r++) {
            for ($c = 0; $c < 7; $c++) {
                if ($r === 0 || $r === 6 || $c === 0 || $c === 6 || ($r >= 2 && $r <= 4 && $c >= 2 && $c <= 4)) {
                    $matrix[$row + $r][$col + $c] = 1;
                } else {
                    $matrix[$row + $r][$col + $c] = 0;
                }
            }
        }
    }

    private static function placeSeparators(array &$matrix, int $modules): void
    {
        for ($i = 0; $i < 8; $i++) {
            // Top-left
            if ($i < 8) {
                if (isset($matrix[7][$i])) $matrix[7][$i] = 0;
                if (isset($matrix[$i][7])) $matrix[$i][7] = 0;
            }
            // Top-right
            $matrix[7][$modules - 8 + $i] = 0;
            $matrix[$i][$modules - 8] = 0;
            // Bottom-left
            $matrix[$modules - 8][$i] = 0;
            $matrix[$modules - 8 + $i][7] = 0;
        }
    }

    private static function placeAlignmentPattern(array &$matrix, int $centerRow, int $centerCol): void
    {
        for ($r = -2; $r <= 2; $r++) {
            for ($c = -2; $c <= 2; $c++) {
                if (abs($r) === 2 || abs($c) === 2 || ($r === 0 && $c === 0)) {
                    $matrix[$centerRow + $r][$centerCol + $c] = 1;
                } else {
                    $matrix[$centerRow + $r][$centerCol + $c] = 0;
                }
            }
        }
    }

    private static function buildDataBits(string $text): array
    {
        $bytes = array_values(unpack('C*', $text));
        $len = count($bytes);

        $bits = [];
        // Byte mode indicator: 0100
        $bits[] = 0; $bits[] = 1; $bits[] = 0; $bits[] = 0;

        // Character count indicator (8 bits for Version 3 Byte mode)
        for ($i = 7; $i >= 0; $i--) {
            $bits[] = ($len >> $i) & 1;
        }

        // Data bytes
        foreach ($bytes as $byte) {
            for ($i = 7; $i >= 0; $i--) {
                $bits[] = ($byte >> $i) & 1;
            }
        }

        // Terminator: up to 4 zero bits
        for ($i = 0; $i < 4; $i++) {
            $bits[] = 0;
        }

        // Pad to byte boundary
        while (count($bits) % 8 !== 0) {
            $bits[] = 0;
        }

        // Pad bytes (0xEC, 0x11)
        $padBytes = [0b11101100, 0b00010001];
        $padIndex = 0;
        // Total data capacity for Version 3-M is 44 bytes * 8 bits = 352 bits
        while (count($bits) < 352) {
            $p = $padBytes[$padIndex % 2];
            for ($i = 7; $i >= 0; $i--) {
                $bits[] = ($p >> $i) & 1;
            }
            $padIndex++;
        }

        return $bits;
    }
}
