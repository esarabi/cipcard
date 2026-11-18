<?php
// CIPCard Profile Master SEO & Social Meta Partial

$metaTitle = !empty($profile['seo_title'])
    ? $profile['seo_title']
    : ($profile['display_name'] . (!empty($profile['job_title']) ? ' - ' . $profile['job_title'] : '') . (!empty($profile['company']) ? ' | ' . $profile['company'] : '') . ' - ' . ($translations['card_title'] ?? 'کارت ویزیت هوشمند CIPCard'));

$cleanBio = !empty($profile['bio']) ? preg_replace('/\s+/', ' ', trim(strip_tags((string)$profile['bio']))) : '';
$defaultDesc = "کارت ویزیت هوشمند، اطلاعات تماس، آدرس و شبکه‌های اجتماعی {$profile['display_name']}" . (!empty($profile['job_title']) ? " ({$profile['job_title']})" : '') . " در پلتفرم CIPCard.";

$metaDesc = !empty($profile['seo_description'])
    ? $profile['seo_description']
    : (!empty($cleanBio) ? mb_substr($cleanBio, 0, 160) : $defaultDesc);

$metaKeywords = !empty($profile['seo_keywords'])
    ? $profile['seo_keywords']
    : ($profile['display_name'] . ', ' . ($profile['job_title'] ?? '') . ', ' . ($profile['company'] ?? '') . ', کارت ویزیت هوشمند, CIPCard, کارت دیجیتال');

// Resolve Best Image for Social Media Sharing (Avatar > Cover > Featured > Default)
$shareImage = null;
if (!empty($profile['avatar_url'])) {
    $shareImage = \App\Core\Helper::url($profile['avatar_url']);
} elseif (!empty($profile['cover_url'])) {
    $shareImage = \App\Core\Helper::url($profile['cover_url']);
} elseif (!empty($profile['featured_image_url'])) {
    $shareImage = \App\Core\Helper::url($profile['featured_image_url']);
}

// Canonical URL
$canonicalUrl = $profileUrl ?? \App\Core\Helper::url('@' . (!empty($profile['slug']) ? $profile['slug'] : $profile['mobile']));

// Build Schema.org JSON-LD Structured Data
$schema = [
    '@context'    => 'https://schema.org',
    '@type'       => !empty($profile['company']) ? ['Person', 'LocalBusiness'] : 'Person',
    'name'        => $profile['display_name'],
    'url'         => $canonicalUrl,
    'description' => $metaDesc
];

if (!empty($profile['job_title'])) {
    $schema['jobTitle'] = $profile['job_title'];
}

if (!empty($profile['company'])) {
    $schema['worksFor'] = [
        '@type' => 'Organization',
        'name'  => $profile['company']
    ];
}

if ($shareImage) {
    $schema['image'] = $shareImage;
}

if (!empty($profile['email'])) {
    $schema['email'] = $profile['email'];
}

$tel = !empty($profile['phone_mobile']) ? $profile['phone_mobile'] : (!empty($profile['phone_work']) ? $profile['phone_work'] : null);
if ($tel) {
    $schema['telephone'] = $tel;
}

if (!empty($profile['address'])) {
    $schema['address'] = [
        '@type'         => 'PostalAddress',
        'streetAddress' => $profile['address'],
        'addressCountry'=> 'IR'
    ];
}

if (!empty($profile['map_latitude']) && !empty($profile['map_longitude'])) {
    $schema['geo'] = [
        '@type'     => 'GeoCoordinates',
        'latitude'  => (float)$profile['map_latitude'],
        'longitude' => (float)$profile['map_longitude']
    ];
}

// Social links for sameAs
if (!empty($profile['social_links']) && is_array($profile['social_links'])) {
    $sameAs = [];
    $socialUrls = [
        'instagram' => 'https://instagram.com/',
        'telegram'  => 'https://t.me/',
        'linkedin'  => 'https://linkedin.com/in/',
        'github'    => 'https://github.com/',
        'twitter'   => 'https://twitter.com/',
        'aparat'    => 'https://www.aparat.com/'
    ];
    foreach ($profile['social_links'] as $net => $handle) {
        if (!empty($handle)) {
            if (str_starts_with($handle, 'http://') || str_starts_with($handle, 'https://')) {
                $sameAs[] = $handle;
            } elseif (isset($socialUrls[$net])) {
                $sameAs[] = $socialUrls[$net] . ltrim($handle, '@');
            }
        }
    }
    if (!empty($sameAs)) {
        $schema['sameAs'] = $sameAs;
    }
}

// Aggregate Rating (Google Rich Stars)
if (!empty($enableReviews) && !empty($reviewStats['total_reviews']) && $reviewStats['total_reviews'] > 0) {
    $schema['aggregateRating'] = [
        '@type'       => 'AggregateRating',
        'ratingValue' => number_format((float)$reviewStats['average_rating'], 1),
        'bestRating'  => '5',
        'worstRating' => '1',
        'ratingCount' => (int)$reviewStats['total_reviews'],
        'reviewCount' => (int)$reviewStats['total_reviews']
    ];
}
?>

<title><?= \App\Core\Helper::e($metaTitle) ?></title>
<meta name="description" content="<?= \App\Core\Helper::e($metaDesc) ?>">
<meta name="keywords" content="<?= \App\Core\Helper::e($metaKeywords) ?>">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<link rel="canonical" href="<?= $canonicalUrl ?>">

<!-- Open Graph / Facebook / WhatsApp / Telegram / LinkedIn -->
<meta property="og:type" content="profile">
<meta property="og:locale" content="<?= ($currentLang ?? 'fa') === 'fa' ? 'fa_IR' : 'en_US' ?>">
<meta property="og:site_name" content="CIPCard | کارت ویزیت هوشمند">
<meta property="og:title" content="<?= \App\Core\Helper::e($metaTitle) ?>">
<meta property="og:description" content="<?= \App\Core\Helper::e($metaDesc) ?>">
<meta property="og:url" content="<?= $canonicalUrl ?>">
<?php if ($shareImage): ?>
<meta property="og:image" content="<?= $shareImage ?>">
<meta property="og:image:secure_url" content="<?= $shareImage ?>">
<meta property="og:image:alt" content="<?= \App\Core\Helper::e($profile['display_name']) ?>">
<?php endif; ?>

<!-- Twitter Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= \App\Core\Helper::e($metaTitle) ?>">
<meta name="twitter:description" content="<?= \App\Core\Helper::e($metaDesc) ?>">
<?php if ($shareImage): ?>
<meta name="twitter:image" content="<?= $shareImage ?>">
<?php endif; ?>

<!-- Schema.org JSON-LD Structured Data for Google Rich Snippets -->
<script type="application/ld+json">
<?= json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
</script>
