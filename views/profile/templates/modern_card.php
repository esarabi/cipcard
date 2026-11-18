<?php
// Template 5: Modern Card (3D Flip Physical Business Card Experience - Responsive Mobile + Full-Screen Desktop Layout)
$theme = $profile['theme_color'] ?? 'gold_black';
$themeMode = $profile['theme_mode'] ?? 'light';

$darkPalettes = [
    'gold_black'   => [
        'primary' => '#D4AF37',
        'pageBg' => '#09090b',
        'cardSurface' => '#121217',
        'cardBg' => 'linear-gradient(135deg, #1c1917 0%, #0c0a09 100%)',
        'border' => '#D4AF37',
        'cardText' => '#FFFFFF',
        'cardSub' => '#D1D5DB',
        'actionBg' => 'rgba(255,255,255,0.05)',
        'actionBorder' => 'rgba(255,255,255,0.12)',
        'actionText' => '#F3F4F6'
    ],
    'blue_white'   => [
        'primary' => '#38BDF8',
        'pageBg' => '#0B0F19',
        'cardSurface' => '#0F172A',
        'cardBg' => 'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)',
        'border' => '#38BDF8',
        'cardText' => '#FFFFFF',
        'cardSub' => '#94A3B8',
        'actionBg' => 'rgba(255,255,255,0.05)',
        'actionBorder' => 'rgba(255,255,255,0.12)',
        'actionText' => '#F3F4F6'
    ],
    'emerald_gray' => [
        'primary' => '#10B981',
        'pageBg' => '#06130E',
        'cardSurface' => '#0C1E16',
        'cardBg' => 'linear-gradient(135deg, #064e3b 0%, #061e16 100%)',
        'border' => '#10B981',
        'cardText' => '#FFFFFF',
        'cardSub' => '#A7F3D0',
        'actionBg' => 'rgba(255,255,255,0.05)',
        'actionBorder' => 'rgba(255,255,255,0.12)',
        'actionText' => '#F3F4F6'
    ]
];

$lightPalettes = [
    'gold_black'   => [
        'primary' => '#B8860B',
        'pageBg' => '#F8FAFC',
        'cardSurface' => '#FFFFFF',
        'cardBg' => 'linear-gradient(135deg, #FFFFFF 0%, #FFFBEB 100%)',
        'border' => '#D4AF37',
        'cardText' => '#1E293B',
        'cardSub' => '#64748B',
        'actionBg' => '#F8FAFC',
        'actionBorder' => '#E2E8F0',
        'actionText' => '#1E293B'
    ],
    'blue_white'   => [
        'primary' => '#0284C7',
        'pageBg' => '#F8FAFC',
        'cardSurface' => '#FFFFFF',
        'cardBg' => 'linear-gradient(135deg, #FFFFFF 0%, #F0F9FF 100%)',
        'border' => '#0284C7',
        'cardText' => '#0F172A',
        'cardSub' => '#64748B',
        'actionBg' => '#F8FAFC',
        'actionBorder' => '#E2E8F0',
        'actionText' => '#1E293B'
    ],
    'emerald_gray' => [
        'primary' => '#059669',
        'pageBg' => '#F8FAFC',
        'cardSurface' => '#FFFFFF',
        'cardBg' => 'linear-gradient(135deg, #FFFFFF 0%, #ECFDF5 100%)',
        'border' => '#059669',
        'cardText' => '#064E3B',
        'cardSub' => '#64748B',
        'actionBg' => '#F8FAFC',
        'actionBorder' => '#E2E8F0',
        'actionText' => '#1E293B'
    ]
];

$dColors = $darkPalettes[$theme] ?? $darkPalettes['gold_black'];
$lColors = $lightPalettes[$theme] ?? $lightPalettes['gold_black'];
$social = $profile['social_links'] ?? [];
$hasHours = !empty($profile['working_days']) || !empty($profile['working_hours']) || !empty($profile['working_note']);
$hasLocation = !empty($profile['address']) || !empty($profile['map_link']) || (!empty($profile['map_latitude']) && !empty($profile['map_longitude']));
$canSaveContact = $showSaveContact ?? (empty($profile['slug']) || \App\Core\Helper::normalizeMobile((string)$profile['slug']) !== null);
$vcardUrl = \App\Core\Helper::url('vcard/@' . (!empty($profile['slug']) ? $profile['slug'] : $profile['mobile']));
?>
<!DOCTYPE html>
<html lang="<?= $currentLang ?? 'fa' ?>" dir="<?= $langDir ?? 'rtl' ?>" data-theme="<?= \App\Core\Helper::e($themeMode) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \App\Core\Helper::e($profile['display_name']) ?> - <?= \App\Core\Helper::e($translations['card_title'] ?? 'کارت ویزیت هوشمند سه‌بعدی') ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        html[data-theme="dark"] {
            --page-bg: <?= $dColors['pageBg'] ?>;
            --card-bg: <?= $dColors['cardBg'] ?>;
            --card: <?= $dColors['cardSurface'] ?>;
            --primary: <?= $dColors['primary'] ?>;
            --border: <?= $dColors['actionBorder'] ?>;
            --card-border: <?= $dColors['border'] ?>;
            --card-text: <?= $dColors['cardText'] ?>;
            --card-sub: <?= $dColors['cardSub'] ?>;
            --action-bg: <?= $dColors['actionBg'] ?>;
            --box-bg: <?= $dColors['actionBg'] ?>;
            --action-border: <?= $dColors['actionBorder'] ?>;
            --action-text: <?= $dColors['actionText'] ?>;
            --text-main: <?= $dColors['actionText'] ?>;
            --text-sub: <?= $dColors['cardSub'] ?>;
            --chip-bg: #1c1917;
            --shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            --card-shadow: 0 20px 40px -15px rgba(0,0,0,0.7);
        }

        html[data-theme="light"] {
            --page-bg: <?= $lColors['pageBg'] ?>;
            --card-bg: <?= $lColors['cardBg'] ?>;
            --card: <?= $lColors['cardSurface'] ?>;
            --primary: <?= $lColors['primary'] ?>;
            --border: <?= $lColors['actionBorder'] ?>;
            --card-border: <?= $lColors['border'] ?>;
            --card-text: <?= $lColors['cardText'] ?>;
            --card-sub: <?= $lColors['cardSub'] ?>;
            --action-bg: <?= $lColors['actionBg'] ?>;
            --box-bg: <?= $lColors['actionBg'] ?>;
            --action-border: <?= $lColors['actionBorder'] ?>;
            --action-text: <?= $lColors['actionText'] ?>;
            --text-main: <?= $lColors['actionText'] ?>;
            --text-sub: <?= $lColors['cardSub'] ?>;
            --chip-bg: #fef3c7;
            --shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.12);
            --card-shadow: 0 10px 30px -5px rgba(0,0,0,0.06);
        }

        body { 
            background-color: var(--page-bg); 
            color: var(--action-text);
            font-family: 'Vazirmatn', sans-serif;
            transition: background-color 0.25s;
        }

        .perspective-card { perspective: 1200px; }
        .card-inner {
            transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transform-style: preserve-3d;
        }
        .card-inner.flipped { transform: rotateY(180deg); }
        .card-front, .card-back {
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            box-shadow: var(--shadow);
        }
        .card-back { transform: rotateY(180deg); }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between p-4 sm:p-6 lg:p-10 xl:px-14">

    <!-- Floating Top Nav: Theme Toggle & 6-Language Selector -->
    <?php require __DIR__ . '/../partials/header_nav.php'; ?>

    <main class="w-full max-w-md lg:max-w-7xl mx-auto pt-14 lg:pt-16 flex-1 flex flex-col justify-center">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

            <!-- Left / Right Sidebar Column (3D Interactive Card + Bio + Primary Actions) -->
            <div class="lg:col-span-5 xl:col-span-5 lg:sticky lg:top-24 space-y-5">
                
                <div class="text-center lg:text-start flex flex-col lg:flex-row lg:items-center justify-between gap-1 px-1">
                    <span class="text-xs font-mono tracking-widest uppercase font-bold" style="color: var(--primary);">CIP NFC 3D SMART CARD</span>
                    <span class="text-xs flex items-center justify-center lg:justify-end gap-1" style="color: var(--card-sub);">
                        <i data-lucide="rotate-cw" class="w-3.5 h-3.5" style="color: var(--primary);"></i>
                        <span><?= \App\Core\Helper::e($translations['flip_card'] ?? 'لمس کارت جهت چرخش سه‌بعدی') ?></span>
                    </span>
                </div>

                <!-- 3D Interactive Physical Card -->
                <div class="perspective-card w-full h-[255px] sm:h-[275px] cursor-pointer" onclick="toggleCardFlip()">
                    <div id="physical-card" class="card-inner relative w-full h-full">
                        
                        <!-- FRONT OF CARD -->
                        <div class="card-front absolute inset-0 rounded-3xl p-6 sm:p-7 border-2 flex flex-col justify-between transition-all" style="background: var(--card-bg); border-color: var(--card-border);">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="nfc" class="w-6 h-6" style="color: var(--primary);"></i>
                                    <span class="text-[10px] font-mono tracking-widest uppercase font-bold" style="color: var(--card-sub);">CIP NFC CONTACTLESS</span>
                                </div>
                                <span class="text-lg font-black font-mono tracking-wider" style="color: var(--card-text);">CIP<span style="color: var(--primary);">CARD</span></span>
                            </div>

                            <!-- Chip & User Identity -->
                            <div class="flex items-center gap-4">
                                <?php if (!empty($profile['avatar_url'])): ?>
                                    <div class="w-14 h-14 rounded-2xl overflow-hidden border-2 flex-shrink-0 shadow-md" style="border-color: var(--primary);">
                                        <img src="<?= \App\Core\Helper::url($profile['avatar_url']) ?>" alt="Avatar" class="w-full h-full object-cover">
                                    </div>
                                <?php else: ?>
                                    <div class="w-12 h-9 rounded-md bg-gradient-to-tr from-amber-600 via-amber-400 to-amber-200 p-0.5 shadow-inner flex-shrink-0">
                                        <div class="w-full h-full rounded-[3px] border border-amber-400/50 grid grid-cols-2 gap-0.5 p-1" style="background-color: var(--chip-bg);">
                                            <div class="border-b border-r border-amber-500/40"></div>
                                            <div class="border-b border-amber-500/40"></div>
                                            <div class="border-r border-amber-500/40"></div>
                                            <div></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="truncate">
                                    <h1 class="text-xl sm:text-2xl font-black truncate" style="color: var(--card-text);"><?= \App\Core\Helper::e($profile['display_name']) ?></h1>
                                    <p class="text-xs sm:text-sm font-bold truncate mt-0.5" style="color: var(--primary);"><?= \App\Core\Helper::e($profile['job_title'] ?: 'VIP Member') ?></p>
                                </div>
                            </div>

                            <div class="flex justify-between items-end border-t pt-3" style="border-color: var(--action-border);">
                                <span class="text-[11px] font-medium truncate max-w-[65%]" style="color: var(--card-sub);"><?= \App\Core\Helper::e($profile['company'] ?: 'CIPCard Smart Member') ?></span>
                                <div class="flex items-center gap-1.5 text-[11px] font-bold" style="color: var(--card-text);">
                                    <i data-lucide="rotate-cw" class="w-3.5 h-3.5" style="color: var(--primary);"></i>
                                    <span><?= \App\Core\Helper::e($translations['flip_card'] ?? 'چرخش کارت') ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- BACK OF CARD -->
                        <div class="card-back absolute inset-0 rounded-3xl p-6 sm:p-7 border-2 flex items-center justify-between transition-all" style="background: var(--card-bg); border-color: var(--card-border);">
                            <div class="w-32 h-32 p-2 bg-white rounded-2xl flex items-center justify-center shadow-lg border border-gray-100 flex-shrink-0">
                                <img src="<?= $qrCodeDataUri ?>" alt="QR" class="w-full h-full object-contain">
                            </div>

                            <div class="flex-1 px-4 space-y-2 text-right min-w-0">
                                <span class="text-[10px] font-mono block font-bold" style="color: var(--primary);">SCAN TO CONNECT</span>
                                <p class="text-xs font-mono font-bold dir-ltr" style="color: var(--card-text);"><?= \App\Core\Helper::e($profile['phone_mobile'] ?: $profile['mobile']) ?></p>
                                <?php if (!empty($profile['email'])): ?>
                                    <p class="text-[11px] truncate font-mono dir-ltr" style="color: var(--card-sub);"><?= \App\Core\Helper::e($profile['email']) ?></p>
                                <?php endif; ?>
                                <div class="pt-2">
                                    <span class="text-[9px] px-2.5 py-1 rounded-md font-mono border inline-block truncate max-w-full dir-ltr" style="background-color: var(--action-bg); border-color: var(--action-border); color: var(--card-text);">cipcard.ir/@<?= !empty($profile['slug']) ? $profile['slug'] : $profile['mobile'] ?></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Biography & Action Buttons Card -->
                <div class="rounded-3xl p-6 border space-y-4" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">
                    <?php if (!empty($profile['bio'])): ?>
                        <div class="space-y-1.5 pb-3 border-b" style="border-color: var(--border);">
                            <span class="text-[11px] font-bold uppercase" style="color: var(--primary);"><?= \App\Core\Helper::e($translations['about'] ?? 'درباره ما / بیوگرافی') ?></span>
                            <p class="text-xs sm:text-sm leading-relaxed" style="color: var(--text-sub);">
                                <?= nl2br(\App\Core\Helper::e($profile['bio'])) ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <?php if ($canSaveContact): ?>
                        <a href="<?= $vcardUrl ?>" class="w-full py-4 rounded-2xl font-black text-sm text-white flex items-center justify-center gap-2 shadow-xl hover:brightness-105 active:scale-95 transition-all" style="background-color: var(--primary);">
                            <i data-lucide="user-plus" class="w-5 h-5"></i>
                            <span><?= \App\Core\Helper::e($translations['save_contact'] ?? 'ذخیره در مخاطبین') ?></span>
                        </a>
                    <?php endif; ?>

                    <div class="grid grid-cols-2 gap-3">
                        <?php if (!empty($profile['phone_mobile'])): ?>
                            <a href="tel:<?= \App\Core\Helper::e($profile['phone_mobile']) ?>" class="py-3.5 px-4 rounded-xl border text-xs font-bold flex items-center justify-center gap-2 shadow-sm hover:scale-[1.01] transition-all" style="background-color: var(--action-bg); border-color: var(--action-border); color: var(--action-text);">
                                <i data-lucide="phone-call" class="w-4 h-4" style="color: var(--primary);"></i>
                                <span><?= \App\Core\Helper::e($translations['call_mobile'] ?? 'تماس همراه') ?></span>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($profile['phone_work'])): ?>
                            <a href="tel:<?= \App\Core\Helper::e($profile['phone_work']) ?>" class="py-3.5 px-4 rounded-xl border text-xs font-bold flex items-center justify-center gap-2 shadow-sm hover:scale-[1.01] transition-all" style="background-color: var(--action-bg); border-color: var(--action-border); color: var(--action-text);">
                                <i data-lucide="phone" class="w-4 h-4" style="color: var(--primary);"></i>
                                <span><?= \App\Core\Helper::e($translations['call_work'] ?? 'تلفن کار') ?></span>
                            </a>
                        <?php elseif (!empty($profile['email'])): ?>
                            <a href="mailto:<?= \App\Core\Helper::e($profile['email']) ?>" class="py-3.5 px-4 rounded-xl border text-xs font-bold flex items-center justify-center gap-2 shadow-sm hover:scale-[1.01] transition-all" style="background-color: var(--action-bg); border-color: var(--action-border); color: var(--action-text);">
                                <i data-lucide="mail" class="w-4 h-4" style="color: var(--primary);"></i>
                                <span><?= \App\Core\Helper::e($translations['email'] ?? 'ایمیل') ?></span>
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($profile['email']) || !empty($profile['website'])): ?>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1">
                            <?php if (!empty($profile['email'])): ?>
                                <a href="mailto:<?= \App\Core\Helper::e($profile['email']) ?>" class="p-3 rounded-xl border text-xs flex items-center justify-between hover:brightness-105 transition-all" style="background-color: var(--action-bg); border-color: var(--action-border); color: var(--action-text);">
                                    <span class="flex items-center gap-2 truncate">
                                        <i data-lucide="mail" class="w-3.5 h-3.5 flex-shrink-0" style="color: var(--primary);"></i>
                                        <span class="font-mono truncate dir-ltr"><?= \App\Core\Helper::e($profile['email']) ?></span>
                                    </span>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($profile['website'])): ?>
                                <a href="<?= \App\Core\Helper::e($profile['website']) ?>" target="_blank" rel="noopener" class="p-3 rounded-xl border text-xs flex items-center justify-between hover:brightness-105 transition-all" style="background-color: var(--action-bg); border-color: var(--action-border); color: var(--action-text);">
                                    <span class="flex items-center gap-2 truncate">
                                        <i data-lucide="globe" class="w-3.5 h-3.5 flex-shrink-0" style="color: var(--primary);"></i>
                                        <span class="font-mono truncate dir-ltr"><?= \App\Core\Helper::e(preg_replace('#^https?://#', '', $profile['website'])) ?></span>
                                    </span>
                                    <i data-lucide="external-link" class="w-3.5 h-3.5 flex-shrink-0 opacity-60"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <!-- Main Content Column (Right / Left 7 Columns on Desktop) -->
            <div class="lg:col-span-7 xl:col-span-7 space-y-6">

                <!-- Collapsible Extended Description ("توضیحات بیشتر") -->
                <?php require __DIR__ . '/../partials/more_info.php'; ?>

                <!-- Iranian & International Socials Partial -->
                <?php require __DIR__ . '/../partials/social_links.php'; ?>

                <!-- Working Hours & Location Side-by-Side on Desktop -->
                <?php if ($hasHours || $hasLocation): ?>
                    <div class="grid grid-cols-1 <?= ($hasHours && $hasLocation) ? 'xl:grid-cols-2' : '' ?> gap-6 items-stretch">
                        <?php if ($hasHours): ?>
                            <div><?php require __DIR__ . '/../partials/working_hours.php'; ?></div>
                        <?php endif; ?>
                        <?php if ($hasLocation): ?>
                            <div><?php require __DIR__ . '/../partials/location_map.php'; ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Customer Reviews & Star Ratings Partial -->
                <?php require __DIR__ . '/../partials/reviews.php'; ?>

            </div>

        </div>
    </main>

    <!-- CIPCard Brand Footer -->
    <?php require __DIR__ . '/../partials/footer.php'; ?>

    <script>
        lucide.createIcons();
        function toggleCardFlip() {
            document.getElementById('physical-card').classList.toggle('flipped');
        }

        function toggleCardTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme') || 'light';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', newTheme);
            
            const btnText = document.getElementById('theme-btn-text');
            const btnIcon = document.getElementById('theme-btn-icon');
            const isFa = '<?= $currentLang ?>' === 'fa';
            if (btnText && btnIcon) {
                btnText.textContent = newTheme === 'light' ? (isFa ? 'تم روشن' : 'Light') : (isFa ? 'تم تیره' : 'Dark');
                btnIcon.setAttribute('data-lucide', newTheme === 'light' ? 'sun' : 'moon');
                lucide.createIcons();
            }
        }
    </script>
</body>
</html>
