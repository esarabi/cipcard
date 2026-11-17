<?php
// Template 4: Creative & Neon
$theme = $profile['theme_color'] ?? 'gold_black';
$themeMode = $profile['theme_mode'] ?? 'light';

$darkPalettes = [
    'gold_black'   => ['neon' => '#D97706', 'shadow' => 'rgba(217, 119, 6, 0.4)', 'bg' => '#030305', 'card' => '#0B0B10', 'text' => '#FFFFFF', 'sub' => '#9CA3AF', 'itemBg' => 'rgba(0,0,0,0.6)', 'border' => '#27272a'],
    'blue_white'   => ['neon' => '#0284C7', 'shadow' => 'rgba(2, 132, 199, 0.4)', 'bg' => '#030712', 'card' => '#0B1120', 'text' => '#FFFFFF', 'sub' => '#9CA3AF', 'itemBg' => 'rgba(0,0,0,0.6)', 'border' => '#1e293b'],
    'emerald_gray' => ['neon' => '#059669', 'shadow' => 'rgba(5, 150, 105, 0.4)', 'bg' => '#02120B', 'card' => '#071F14', 'text' => '#FFFFFF', 'sub' => '#9CA3AF', 'itemBg' => 'rgba(0,0,0,0.6)', 'border' => '#064e3b']
];

$lightPalettes = [
    'gold_black'   => ['neon' => '#D97706', 'shadow' => 'rgba(217, 119, 6, 0.25)', 'bg' => '#FFFBEB', 'card' => '#FFFFFF', 'text' => '#0F172A', 'sub' => '#64748B', 'itemBg' => '#FEF3C7', 'border' => '#FDE68A'],
    'blue_white'   => ['neon' => '#0284C7', 'shadow' => 'rgba(2, 132, 199, 0.25)', 'bg' => '#F0F9FF', 'card' => '#FFFFFF', 'text' => '#0F172A', 'sub' => '#64748B', 'itemBg' => '#E0F2FE', 'border' => '#BAE6FD'],
    'emerald_gray' => ['neon' => '#059669', 'shadow' => 'rgba(5, 150, 105, 0.25)', 'bg' => '#F0FDF4', 'card' => '#FFFFFF', 'text' => '#0F172A', 'sub' => '#64748B', 'itemBg' => '#D1FAE5', 'border' => '#A7F3D0']
];

$dColors = $darkPalettes[$theme] ?? $darkPalettes['gold_black'];
$lColors = $lightPalettes[$theme] ?? $lightPalettes['gold_black'];
$social = $profile['social_links'] ?? [];
?>
<!DOCTYPE html>
<html lang="<?= $currentLang ?? 'fa' ?>" dir="<?= $langDir ?? 'rtl' ?>" data-theme="<?= \App\Core\Helper::e($themeMode) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \App\Core\Helper::e($profile['display_name']) ?> - <?= \App\Core\Helper::e($translations['card_title'] ?? 'کارت ویزیت هوشمند') ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        html[data-theme="dark"] {
            --bg: <?= $dColors['bg'] ?>;
            --card-bg: <?= $dColors['card'] ?>;
            --card: <?= $dColors['card'] ?>;
            --primary: <?= $dColors['neon'] ?>;
            --neon: <?= $dColors['neon'] ?>;
            --shadow: <?= $dColors['shadow'] ?>;
            --text-main: <?= $dColors['text'] ?>;
            --text-sub: <?= $dColors['sub'] ?>;
            --item-bg: <?= $dColors['itemBg'] ?>;
            --box-bg: <?= $dColors['itemBg'] ?>;
            --border: <?= $dColors['border'] ?>;
            --btn-text: #FFFFFF;
            --card-shadow: 0 0 20px var(--shadow);
        }

        html[data-theme="light"] {
            --bg: <?= $lColors['bg'] ?>;
            --card-bg: <?= $lColors['card'] ?>;
            --card: <?= $lColors['card'] ?>;
            --primary: <?= $lColors['neon'] ?>;
            --neon: <?= $lColors['neon'] ?>;
            --shadow: <?= $lColors['shadow'] ?>;
            --text-main: <?= $lColors['text'] ?>;
            --text-sub: <?= $lColors['sub'] ?>;
            --item-bg: <?= $lColors['itemBg'] ?>;
            --box-bg: <?= $lColors['itemBg'] ?>;
            --border: <?= $lColors['border'] ?>;
            --btn-text: #FFFFFF;
            --card-shadow: 0 10px 30px -5px rgba(0,0,0,0.06);
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            font-family: 'Vazirmatn', sans-serif;
            transition: background-color 0.25s;
        }

        .neon-border {
            border: 2px solid var(--neon);
            box-shadow: 0 0 20px var(--shadow);
        }

        .neon-text {
            color: var(--neon);
            text-shadow: 0 0 10px var(--shadow);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between p-4 sm:p-6">

    <!-- Floating Top Nav: Theme Toggle & 6-Language Selector -->
    <?php require __DIR__ . '/../partials/header_nav.php'; ?>

    <div class="max-w-md w-full mx-auto space-y-6 pt-12">
        
        <!-- Neon Identity Card -->
        <div class="rounded-[32px] p-6 sm:p-8 neon-border relative overflow-hidden space-y-5" style="background-color: var(--card-bg);">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 rounded-2xl overflow-hidden border-2 flex-shrink-0" style="border-color: var(--neon);">
                    <?php if (!empty($profile['avatar_url'])): ?>
                        <img src="<?= \App\Core\Helper::url($profile['avatar_url']) ?>" alt="Avatar" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-2xl font-black neon-text" style="background-color: var(--item-bg);">
                            <?= mb_substr($profile['display_name'], 0, 1) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="space-y-1 overflow-hidden">
                    <h1 class="text-xl font-black truncate" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['display_name']) ?></h1>
                    <p class="text-xs font-mono font-bold uppercase tracking-wider neon-text"><?= \App\Core\Helper::e($profile['job_title'] ?: 'VIP MEMBER') ?></p>
                    <?php if (!empty($profile['company'])): ?>
                        <p class="text-[11px]" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profile['company']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($profile['bio'])): ?>
                <p class="text-xs leading-relaxed pt-2 border-t" style="color: var(--text-sub); border-color: var(--border);">
                    <?= nl2br(\App\Core\Helper::e($profile['bio'])) ?>
                </p>
            <?php endif; ?>

            <a href="<?= \App\Core\Helper::url('vcard/@' . (!empty($profile['slug']) ? $profile['slug'] : $profile['mobile'])) ?>" class="w-full py-4 rounded-2xl font-black text-sm flex items-center justify-center gap-2 shadow-lg hover:brightness-105 active:scale-95 transition-all" style="background-color: var(--neon); color: var(--btn-text);">
                <i data-lucide="download" class="w-5 h-5"></i>
                <span><?= \App\Core\Helper::e($translations['save_contact'] ?? 'ذخیره در مخاطبین') ?></span>
            </a>

            <!-- Quick Communication Grid -->
            <div class="grid grid-cols-2 gap-2 pt-2">
                <?php if (!empty($profile['phone_mobile'])): ?>
                    <a href="tel:<?= \App\Core\Helper::e($profile['phone_mobile']) ?>" class="p-3 rounded-xl border transition-all flex items-center gap-2 text-xs font-bold" style="background-color: var(--item-bg); border-color: var(--border); color: var(--text-main);">
                        <i data-lucide="phone" class="w-4 h-4" style="color: var(--neon);"></i>
                        <span class="font-mono truncate"><?= \App\Core\Helper::e($profile['phone_mobile']) ?></span>
                    </a>
                <?php endif; ?>

                <?php if (!empty($profile['phone_work'])): ?>
                    <a href="tel:<?= \App\Core\Helper::e($profile['phone_work']) ?>" class="p-3 rounded-xl border transition-all flex items-center gap-2 text-xs font-bold" style="background-color: var(--item-bg); border-color: var(--border); color: var(--text-main);">
                        <i data-lucide="phone-call" class="w-4 h-4" style="color: var(--neon);"></i>
                        <span class="font-mono truncate"><?= \App\Core\Helper::e($profile['phone_work']) ?></span>
                    </a>
                <?php elseif (!empty($profile['email'])): ?>
                    <a href="mailto:<?= \App\Core\Helper::e($profile['email']) ?>" class="p-3 rounded-xl border transition-all flex items-center gap-2 text-xs font-bold" style="background-color: var(--item-bg); border-color: var(--border); color: var(--text-main);">
                        <i data-lucide="mail" class="w-4 h-4" style="color: var(--neon);"></i>
                        <span class="truncate">Email</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Working Hours Partial -->
        <?php require __DIR__ . '/../partials/working_hours.php'; ?>

        <!-- Location & Navigation Partial -->
        <?php require __DIR__ . '/../partials/location_map.php'; ?>

        <!-- Iranian & International Socials Partial -->
        <?php require __DIR__ . '/../partials/social_links.php'; ?>

        <!-- QR Module -->
        <div class="rounded-3xl p-6 text-center space-y-3 border" style="background-color: var(--card-bg); border-color: var(--border);">
            <h3 class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-main);"><?= \App\Core\Helper::e($translations['scan_qr'] ?? 'اسکن بارکد QR') ?></h3>
            <div class="w-36 h-36 mx-auto p-2.5 bg-white rounded-2xl shadow-lg border border-slate-200">
                <img src="<?= $qrCodeDataUri ?>" alt="QR" class="w-full h-full object-contain">
            </div>
            <span class="text-[10px] font-mono block" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profileUrl) ?></span>
        </div>

    </div>

    <!-- CIPCard Brand Footer -->
    <?php require __DIR__ . '/../partials/footer.php'; ?>

    <script>
        function toggleCreativeTheme() {
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
