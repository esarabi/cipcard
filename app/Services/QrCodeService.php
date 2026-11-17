<?php
declare(strict_types=1);

namespace App\Services;

/**
 * Standard-Compliant QR Code Service for CIPCard Profiles
 * Encodes URLs and text into scannable QR Code PNG Data URIs and direct image responses.
 */
class QrCodeService
{
    /**
     * Get Base64 PNG Data URI of QR code for direct <img> tag embedding
     *
     * @param string $content The URL or text to encode
     * @param int $size Approximate display size in pixels (e.g. 260, 280)
     * @param string $foregroundColor Hex color (e.g. '#000000' or '000000')
     * @param string $backgroundColor Hex color (e.g. '#ffffff' or 'ffffff')
     * @return string Data URI (data:image/png;base64,...)
     */
    public static function getDataUri(
        string $content,
        int $size = 280,
        string $foregroundColor = '#000000',
        string $backgroundColor = '#ffffff'
    ): string {
        $fg = ltrim($foregroundColor, '#');
        $bg = ltrim($backgroundColor, '#');

        // Scale factor: 8 gives a crisp ~264px to ~320px QR code for standard URLs
        $scale = max(4, min(12, (int)round($size / 33)));

        $encoder = new QrCodeEncoder($content, [
            's'  => 'qrm', // Medium error correction (15% redundancy)
            'sf' => $scale,
            'fc' => $fg,
            'bc' => $bg
        ]);

        $image = $encoder->render_image();
        if (!$image) {
            return '';
        }

        ob_start();
        imagepng($image);
        $pngData = ob_get_clean();
        imagedestroy($image);

        return 'data:image/png;base64,' . base64_encode($pngData);
    }

    /**
     * Render direct PNG response with proper HTTP headers (for /qr/@mobile route)
     */
    public static function renderPngResponse(string $content, int $size = 360): void
    {
        $scale = max(6, min(14, (int)round($size / 33)));

        $encoder = new QrCodeEncoder($content, [
            's'  => 'qrm',
            'sf' => $scale,
            'fc' => '000000',
            'bc' => 'FFFFFF'
        ]);

        $image = $encoder->render_image();
        if ($image) {
            header('Content-Type: image/png');
            header('Cache-Control: public, max-age=86400');
            imagepng($image);
            imagedestroy($image);
            exit;
        }

        http_response_code(500);
        echo 'Error generating QR Code';
        exit;
    }

    /**
     * Alias for backward compatibility
     */
    public static function renderSvgResponse(string $content, int $size = 360): void
    {
        self::renderPngResponse($content, $size);
    }
}
