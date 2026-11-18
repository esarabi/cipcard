<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Helper;
use App\Models\Profile;

class SitemapController
{
    /**
     * Generate dynamic XML Sitemap compliant with Google Search Console & Schema
     */
    public function sitemap(): void
    {
        // 1. Fetch all active public profiles
        $profiles = Profile::getAllPublicForSitemap();

        // 2. Set headers
        header('Content-Type: application/xml; charset=utf-8');
        header('X-Robots-Tag: noindex, follow');

        // 3. Build XML
        $xml = [];
        $xml[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Homepage
        $xml[] = '  <url>';
        $xml[] = '    <loc>' . htmlspecialchars(Helper::url(), ENT_XML1) . '</loc>';
        $xml[] = '    <lastmod>' . date('Y-m-d') . '</lastmod>';
        $xml[] = '    <changefreq>daily</changefreq>';
        $xml[] = '    <priority>1.0</priority>';
        $xml[] = '  </url>';

        // Public Profiles
        foreach ($profiles as $p) {
            $identifier = !empty($p['slug']) ? $p['slug'] : $p['mobile'];
            $profileUrl = Helper::url('@' . $identifier);
            $lastmod = !empty($p['updated_at']) ? date('Y-m-d', strtotime($p['updated_at'])) : date('Y-m-d');

            $xml[] = '  <url>';
            $xml[] = '    <loc>' . htmlspecialchars($profileUrl, ENT_XML1) . '</loc>';
            $xml[] = '    <lastmod>' . $lastmod . '</lastmod>';
            $xml[] = '    <changefreq>weekly</changefreq>';
            $xml[] = '    <priority>0.8</priority>';
            $xml[] = '  </url>';
        }

        $xml[] = '</urlset>';

        echo implode("\n", $xml);
        exit;
    }

    /**
     * Serve dynamic robots.txt
     */
    public function robots(): void
    {
        header('Content-Type: text/plain; charset=utf-8');

        $sitemapUrl = Helper::url('sitemap.xml');

        echo "User-agent: *\n";
        echo "Allow: /\n";
        echo "Disallow: /admin\n";
        echo "Disallow: /admin/\n";
        echo "Disallow: /dashboard\n";
        echo "Disallow: /dashboard/\n";
        echo "Disallow: /auth/\n";
        echo "Disallow: /api/\n\n";
        echo "Sitemap: {$sitemapUrl}\n";
        exit;
    }
}
