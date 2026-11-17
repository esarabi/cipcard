<?php
// Template 3: Corporate Pro
$theme = $profile['theme_color'] ?? 'blue_white';
$themeMode = $profile['theme_mode'] ?? 'light';

$darkPalettes = [
    'gold_black'   => ['primary' => '#B45309', 'headerBg' => '#1C1917', 'bg' => '#0C0A09', 'badge' => '#D97706', 'text' => '#FFFFFF', 'sub' => '#9CA3AF', 'card' => '#18181b', 'itemBg' => 'rgba(0,0,0,0.3)', 'border' => '#27272a'],
    'blue_white'   => ['primary' => '#1D4ED8', 'headerBg' => '#1E293B', 'bg' => '#0F172A', 'badge' => '#3B82F6', 'text' => '#FFFFFF', 'sub' => '#9CA3AF', 'card' => '#18181b', 'itemBg' => 'rgba(0,0,0,0.3)', 'border' => '#27272a'],
    'emerald_gray' => ['primary' => '#047857', 'headerBg' => '#064E3B', 'bg' => '#022C22', 'badge' => '#10B981', 'text' => '#FFFFFF', 'sub' => '#9CA3AF', 'card' => '#18181b', 'itemBg' => 'rgba(0,0,0,0.3)', 'border' => '#27272a']
];

$lightPalettes = [
    'gold_black'   => ['primary' => '#B8860B', 'headerBg' => '#FEF3C7', 'bg' => '#F8FAFC', 'badge' => '#D97706', 'text' => '#0F172A', 'sub' => '#64748B', 'card' => '#FFFFFF', 'itemBg' => '#F8FAFC', 'border' => '#E2E8F0'],
    'blue_white'   => ['primary' => '#1D4ED8', 'headerBg' => '#DBEAFE', 'bg' => '#F8FAFC', 'badge' => '#2563EB', 'text' => '#0F172A', 'sub' => '#64748B', 'card' => '#FFFFFF', 'itemBg' => '#F8FAFC', 'border' => '#E2E8F0'],
    'emerald_gray' => ['primary' => '#047857', 'headerBg' => '#D1FAE5', 'bg' => '#F8FAFC', 'badge' => '#059669', 'text' => '#0F172A', 'sub' => '#64748B', 'card' => '#FFFFFF', 'itemBg' => '#F8FAFC', 'border' => '#E2E8F0']
];

$dColors = $darkPalettes[$theme] ?? $darkPalettes['blue_white'];
$lColors = $lightPalettes[$theme] ?? $lightPalettes['blue_white'];
$social = $profile['social_links'] ?? [];
?>
<!DOCTYPE html>
<html lang="<?= $currentLang ?? 'fa' ?>" dir="<?= $langDir ?? 'rtl' ?>" data-theme="<?= \App\Core\Helper::e($themeMode) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \App\Core\Helper::e($profile['display_name']) ?> - <?= \App\Core\Helper::e($translations['card_title'] ?? 'پروفایل سازمانی رسمی') ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        html[data-theme="dark"] {
            --bg: <?= $dColors['bg'] ?>;
            --header-bg: <?= $dColors['headerBg'] ?>;
            --card-bg: <?= $dColors['card'] ?>;
            --card: <?= $dColors['card'] ?>;
            --primary: <?= $dColors['badge'] ?>;
            --badge: <?= $dColors['badge'] ?>;
            --text-main: <?= $dColors['text'] ?>;
            --text-sub: <?= $dColors['sub'] ?>;
            --item-bg: <?= $dColors['itemBg'] ?>;
            --box-bg: <?= $dColors['itemBg'] ?>;
            --border: <?= $dColors['border'] ?>;
            --card-shadow: 0 20px 40px -15px rgba(0,0,0,0.8);
        }

        html[data-theme="light"] {
            --bg: <?= $lColors['bg'] ?>;
            --header-bg: <?= $lColors['headerBg'] ?>;
            --card-bg: <?= $lColors['card'] ?>;
            --card: <?= $lColors['card'] ?>;
            --primary: <?= $lColors['primary'] ?>;
            --badge: <?= $lColors['badge'] ?>;
            --text-main: <?= $lColors['text'] ?>;
            --text-sub: <?= $lColors['sub'] ?>;
            --item-bg: <?= $lColors['itemBg'] ?>;
            --box-bg: <?= $lColors['itemBg'] ?>;
            --border: <?= $lColors['border'] ?>;
            --card-shadow: 0 10px 30px -5px rgba(0,0,0,0.06);
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            font-family: 'Vazirmatn', sans-serif;
            transition: background-color 0.25s;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between p-4 sm:p-6">

    <!-- Floating Top Nav: Theme Toggle & 6-Language Selector -->
    <?php require __DIR__ . '/../partials/header_nav.php'; ?>

    <div class="max-w-md w-full mx-auto rounded-3xl overflow-hidden border shadow-2xl pt-2 mt-12 space-y-4" style="background-color: var(--card-bg); border-color: var(--border); box-shadow: var(--card-shadow);">
        
        <!-- Corporate Header Banner -->
        <div class="p-8 text-center relative border-b" style="background-color: var(--header-bg); border-color: var(--border);">
            <div class="w-24 h-24 mx-auto rounded-2xl p-1 shadow-lg mb-4 border-2" style="border-color: var(--badge); background-color: var(--card-bg);">
                <?php if (!empty($profile['avatar_url'])): ?>
                    <img src="<?= \App\Core\Helper::url($profile['avatar_url']) ?>" alt="Avatar" class="w-full h-full object-cover rounded-xl">
                <?php else: ?>
                    <div class="w-full h-full rounded-xl flex items-center justify-center text-2xl font-black text-white" style="background-color: var(--badge);">
                        <?= mb_substr($profile['display_name'], 0, 1) ?>
                    </div>
                <?php endif; ?>
            </div>

            <h1 class="text-2xl font-black" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['display_name']) ?></h1>
            <span class="inline-block mt-2 px-3.5 py-1 rounded-full text-xs font-bold text-white tracking-wide shadow-sm" style="background-color: var(--badge);">
                <?= \App\Core\Helper::e($profile['job_title'] ?: 'مدیر ارشد') ?>
            </span>
            <?php if (!empty($profile['company'])): ?>
                <p class="text-xs font-medium mt-2" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profile['company']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Body Section -->
        <div class="p-6 space-y-5">
            <?php if (!empty($profile['bio'])): ?>
                <div class="p-4 rounded-xl border text-xs leading-relaxed" style="background-color: var(--item-bg); border-color: var(--border); color: var(--text-sub);">
                    <?= nl2br(\App\Core\Helper::e($profile['bio'])) ?>
                </div>
            <?php endif; ?>

            <a href="<?= \App\Core\Helper::url('vcard/@' . (!empty($profile['slug']) ? $profile['slug'] : $profile['mobile'])) ?>" class="w-full py-4 rounded-xl font-bold text-sm text-white flex items-center justify-center gap-2 shadow-lg hover:brightness-105 active:scale-95 transition-all" style="background-color: var(--badge);">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span><?= \App\Core\Helper::e($translations['save_contact'] ?? 'افزودن به دفترچه تلفن مخاطبان') ?></span>
            </a>

            <!-- Corporate Structured Info -->
            <div class="space-y-2.5">
                <h4 class="text-xs font-bold uppercase border-r-2 pr-2" style="border-color: var(--badge); color: var(--text-sub);"><?= \App\Core\Helper::e($translations['contact_info'] ?? 'مشخصات ارتباطی') ?></h4>
                
                <?php if (!empty($profile['phone_mobile'])): ?>
                    <a href="tel:<?= \App\Core\Helper::e($profile['phone_mobile']) ?>" class="flex items-center justify-between p-3.5 rounded-xl transition-all text-xs border" style="background-color: var(--item-bg); border-color: var(--border);">
                        <span style="color: var(--text-sub);"><?= \App\Core\Helper::e($translations['call_mobile'] ?? 'تلفن همراه') ?>:</span>
                        <span class="font-mono font-bold" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['phone_mobile']) ?></span>
                    </a>
                <?php endif; ?>

                <?php if (!empty($profile['phone_work'])): ?>
                    <a href="tel:<?= \App\Core\Helper::e($profile['phone_work']) ?>" class="flex items-center justify-between p-3.5 rounded-xl transition-all text-xs border" style="background-color: var(--item-bg); border-color: var(--border);">
                        <span style="color: var(--text-sub);"><?= \App\Core\Helper::e($translations['call_work'] ?? 'تلفن محل کار') ?>:</span>
                        <span class="font-mono font-bold" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['phone_work']) ?></span>
                    </a>
                <?php endif; ?>

                <?php if (!empty($profile['email'])): ?>
                    <a href="mailto:<?= \App\Core\Helper::e($profile['email']) ?>" class="flex items-center justify-between p-3.5 rounded-xl transition-all text-xs border" style="background-color: var(--item-bg); border-color: var(--border);">
                        <span style="color: var(--text-sub);"><?= \App\Core\Helper::e($translations['email'] ?? 'ایمیل سازمانی') ?>:</span>
                        <span class="font-mono font-bold truncate max-w-[170px]" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['email']) ?></span>
                    </a>
                <?php endif; ?>

                <?php if (!empty($profile['website'])): ?>
                    <a href="<?= \App\Core\Helper::e($profile['website']) ?>" target="_blank" rel="noopener" class="flex items-center justify-between p-3.5 rounded-xl transition-all text-xs border" style="background-color: var(--item-bg); border-color: var(--border);">
                        <span style="color: var(--text-sub);"><?= \App\Core\Helper::e($translations['website'] ?? 'وب‌سایت رسمی') ?>:</span>
                        <span class="font-mono font-bold truncate max-w-[170px]" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['website']) ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Working Hours Partial -->
            <?php require __DIR__ . '/../partials/working_hours.php'; ?>

            <!-- Location & Navigation Partial -->
            <?php require __DIR__ . '/../partials/location_map.php'; ?>

            <!-- Iranian & International Socials Partial -->
            <?php require __DIR__ . '/../partials/social_links.php'; ?>

            <!-- QR Code Section -->
            <div class="pt-2 text-center space-y-3">
                <div class="w-36 h-36 mx-auto p-2.5 bg-white rounded-xl shadow-md border border-slate-200">
                    <img src="<?= $qrCodeDataUri ?>" alt="QR" class="w-full h-full object-contain">
                </div>
                <span class="text-[10px] font-mono" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profileUrl) ?></span>
            </div>
        </div>

    </div>

    <!-- CIPCard Brand Footer -->
    <?php require __DIR__ . '/../partials/footer.php'; ?>

    <script>
        function toggleCardTheme() {
            var curr = document.documentElement.getAttribute('data-theme') || '<?= $themeMode ?>';
            var next = curr === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', next);
            var txt = document.getElementById('theme-btn-text');
            var icon = document.getElementById('theme-btn-icon');
            var isFa = '<?= $currentLang ?>' === 'fa';
            if (txt) txt.innerText = next === 'light' ? (isFa ? 'تم روشن' : 'Light') : (isFa ? 'تم تیره' : 'Dark');
            if (icon) icon.setAttribute('data-lucide', next === 'light' ? 'sun' : 'moon');
            if (window.lucide) lucide.createIcons();
        }
        lucide.createIcons();
    </script>
</body>
</html>
