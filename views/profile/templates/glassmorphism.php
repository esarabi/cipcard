<?php
// Template 2: Glassmorphism (Responsive Mobile + Full-Screen Desktop Layout)
$theme = $profile['theme_color'] ?? 'blue_white';
$themeMode = $profile['theme_mode'] ?? 'light';

$darkPalettes = [
    'gold_black'   => ['primary' => '#D97706', 'gradient' => 'linear-gradient(135deg, #18181b 0%, #09090b 100%)', 'glass' => 'rgba(24, 24, 27, 0.72)', 'accent' => '#B45309', 'border' => 'rgba(255, 255, 255, 0.12)', 'text' => '#FFFFFF', 'sub' => '#9CA3AF', 'itemBg' => 'rgba(255, 255, 255, 0.05)'],
    'blue_white'   => ['primary' => '#0284C7', 'gradient' => 'linear-gradient(135deg, #0f172a 0%, #020617 100%)', 'glass' => 'rgba(15, 23, 42, 0.72)', 'accent' => '#2563EB', 'border' => 'rgba(255, 255, 255, 0.12)', 'text' => '#FFFFFF', 'sub' => '#9CA3AF', 'itemBg' => 'rgba(255, 255, 255, 0.05)'],
    'emerald_gray' => ['primary' => '#059669', 'gradient' => 'linear-gradient(135deg, #064e3b 0%, #022c22 100%)', 'glass' => 'rgba(6, 78, 59, 0.72)', 'accent' => '#047857', 'border' => 'rgba(255, 255, 255, 0.12)', 'text' => '#FFFFFF', 'sub' => '#9CA3AF', 'itemBg' => 'rgba(255, 255, 255, 0.05)']
];

$lightPalettes = [
    'gold_black'   => ['primary' => '#B8860B', 'gradient' => 'linear-gradient(135deg, #FEF9C3 0%, #F8FAFC 100%)', 'glass' => 'rgba(255, 255, 255, 0.85)', 'accent' => '#D4AF37', 'border' => 'rgba(255, 255, 255, 0.9)', 'text' => '#0F172A', 'sub' => '#64748B', 'itemBg' => 'rgba(255, 255, 255, 0.7)'],
    'blue_white'   => ['primary' => '#0284C7', 'gradient' => 'linear-gradient(135deg, #E0F2FE 0%, #F8FAFC 100%)', 'glass' => 'rgba(255, 255, 255, 0.85)', 'accent' => '#38BDF8', 'border' => 'rgba(255, 255, 255, 0.9)', 'text' => '#0F172A', 'sub' => '#64748B', 'itemBg' => 'rgba(255, 255, 255, 0.7)'],
    'emerald_gray' => ['primary' => '#059669', 'gradient' => 'linear-gradient(135deg, #D1FAE5 0%, #F8FAFC 100%)', 'glass' => 'rgba(255, 255, 255, 0.85)', 'accent' => '#34D399', 'border' => 'rgba(255, 255, 255, 0.9)', 'text' => '#0F172A', 'sub' => '#64748B', 'itemBg' => 'rgba(255, 255, 255, 0.7)']
];

$dColors = $darkPalettes[$theme] ?? $darkPalettes['blue_white'];
$lColors = $lightPalettes[$theme] ?? $lightPalettes['blue_white'];
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
    <title><?= \App\Core\Helper::e($profile['display_name']) ?> - <?= \App\Core\Helper::e($translations['card_title'] ?? 'کارت ویزیت هوشمند') ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        html[data-theme="dark"] {
            --bg-grad: <?= $dColors['gradient'] ?>;
            --glass-bg: <?= $dColors['glass'] ?>;
            --glass-border: <?= $dColors['border'] ?>;
            --primary: <?= $dColors['primary'] ?>;
            --accent: <?= $dColors['accent'] ?>;
            --text-main: <?= $dColors['text'] ?>;
            --text-sub: <?= $dColors['sub'] ?>;
            --item-bg: <?= $dColors['itemBg'] ?>;
            --btn-text: #FFFFFF;
            --card: <?= $dColors['glass'] ?>;
            --border: <?= $dColors['border'] ?>;
            --box-bg: <?= $dColors['itemBg'] ?>;
            --card-shadow: 0 15px 35px -5px rgba(0,0,0,0.5);
        }

        html[data-theme="light"] {
            --bg-grad: <?= $lColors['gradient'] ?>;
            --glass-bg: <?= $lColors['glass'] ?>;
            --glass-border: <?= $lColors['border'] ?>;
            --primary: <?= $lColors['primary'] ?>;
            --accent: <?= $lColors['accent'] ?>;
            --text-main: <?= $lColors['text'] ?>;
            --text-sub: <?= $lColors['sub'] ?>;
            --item-bg: <?= $lColors['itemBg'] ?>;
            --btn-text: #FFFFFF;
            --card: <?= $lColors['glass'] ?>;
            --border: <?= $lColors['border'] ?>;
            --box-bg: <?= $lColors['itemBg'] ?>;
            --card-shadow: 0 15px 35px -5px rgba(0,0,0,0.08);
        }

        body {
            background: var(--bg-grad);
            color: var(--text-main);
            font-family: 'Vazirmatn', sans-serif;
            transition: background 0.3s ease;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            box-shadow: var(--card-shadow);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between p-4 sm:p-6 lg:p-10 xl:px-14 relative overflow-x-hidden">
    <!-- Ambient blur spheres -->
    <div class="fixed top-10 -right-20 w-72 lg:w-96 h-72 lg:h-96 rounded-full blur-[110px] pointer-events-none opacity-25" style="background-color: var(--primary);"></div>
    <div class="fixed bottom-10 -left-20 w-80 lg:w-[28rem] h-80 lg:h-[28rem] rounded-full blur-[130px] pointer-events-none opacity-20" style="background-color: var(--accent);"></div>

    <!-- Floating Top Nav: Theme Toggle & 6-Language Selector -->
    <?php require __DIR__ . '/../partials/header_nav.php'; ?>

    <main class="w-full max-w-md lg:max-w-7xl mx-auto pt-14 lg:pt-16 relative z-10 flex-1 flex flex-col justify-center">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

            <!-- Left / Right Sidebar Column (Identity + Desktop QR) -->
            <div class="lg:col-span-4 xl:col-span-4 lg:sticky lg:top-24 space-y-6">
                
                <!-- Glass Profile Card -->
                <div class="glass-card rounded-[32px] p-6 sm:p-8 text-center space-y-5 shadow-2xl overflow-hidden">
                    <?php if (!empty($profile['cover_url'])): ?>
                        <div class="-mx-6 -mt-6 sm:-mx-8 sm:-mt-8 h-36 sm:h-44 lg:h-48 overflow-hidden relative border-b border-white/10">
                            <img src="<?= \App\Core\Helper::url($profile['cover_url']) ?>" alt="Cover Banner" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                        </div>
                    <?php endif; ?>

                    <div class="relative w-28 h-28 lg:w-32 lg:h-32 mx-auto <?= !empty($profile['cover_url']) ? '-mt-20 sm:-mt-24 relative z-20' : '' ?>">
                        <div class="w-full h-full rounded-full p-1 border-4 shadow-2xl" style="border-color: var(--card); background-color: var(--card);">
                            <div class="w-full h-full rounded-full overflow-hidden border-2" style="border-color: var(--primary);">
                                <?php if (!empty($profile['avatar_url'])): ?>
                                    <img src="<?= \App\Core\Helper::url($profile['avatar_url']) ?>" alt="Avatar" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-3xl lg:text-4xl font-black" style="background-color: var(--item-bg); color: var(--primary);">
                                        <?= mb_substr($profile['display_name'], 0, 1) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <h1 class="text-2xl lg:text-3xl font-black" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['display_name']) ?></h1>
                        <?php if (!empty($profile['job_title'])): ?>
                            <p class="text-sm lg:text-base font-bold" style="color: var(--primary);"><?= \App\Core\Helper::e($profile['job_title']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($profile['company'])): ?>
                            <p class="text-xs lg:text-sm font-medium" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profile['company']) ?></p>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($profile['bio'])): ?>
                        <p class="text-xs sm:text-sm leading-relaxed pt-3 border-t border-white/10" style="color: var(--text-sub);">
                            <?= nl2br(\App\Core\Helper::e($profile['bio'])) ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($canSaveContact): ?>
                        <a href="<?= $vcardUrl ?>" class="w-full py-4 rounded-2xl font-black text-sm flex items-center justify-center gap-2 shadow-xl hover:brightness-105 active:scale-95 transition-all" style="background: linear-gradient(135deg, var(--accent), var(--primary)); color: var(--btn-text);">
                            <i data-lucide="user-plus" class="w-5 h-5"></i>
                            <span><?= \App\Core\Helper::e($translations['save_contact'] ?? 'ذخیره مستقیم در گوشی') ?></span>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Desktop Glass QR Code -->
                <div class="hidden lg:block glass-card rounded-[32px] p-6 text-center space-y-3 shadow-xl">
                    <h3 class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-main);"><?= \App\Core\Helper::e($translations['scan_qr'] ?? 'اسکن کیوآرکد اختصاصی') ?></h3>
                    <div class="w-40 h-40 mx-auto p-3 bg-white/95 rounded-2xl shadow-md flex items-center justify-center">
                        <img src="<?= $qrCodeDataUri ?>" alt="QR" class="w-full h-full object-contain">
                    </div>
                    <p class="text-[11px] font-mono dir-ltr" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profileUrl) ?></p>
                </div>

            </div>

            <!-- Main Content Column (Right / Left 8 Columns on Desktop) -->
            <div class="lg:col-span-8 xl:col-span-8 space-y-6">

                <!-- Collapsible Extended Description ("توضیحات بیشتر") -->
                <?php require __DIR__ . '/../partials/more_info.php'; ?>

                <!-- Glass Actions Card -->
                <?php if (!empty($profile['phone_mobile']) || !empty($profile['phone_work']) || !empty($profile['email']) || !empty($profile['website'])): ?>
                    <div class="glass-card rounded-[32px] p-6 sm:p-7 space-y-4 shadow-xl">
                        <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wider flex items-center gap-2" style="color: var(--text-main);">
                            <span class="w-8 h-8 rounded-xl flex items-center justify-center border border-white/10" style="background-color: var(--item-bg); color: var(--primary);">
                                <i data-lucide="phone-call" class="w-4 h-4"></i>
                            </span>
                            <span><?= \App\Core\Helper::e($translations['contact_info'] ?? ($currentLang === 'fa' ? 'راه‌های ارتباطی و تماس' : 'Direct Contact')) ?></span>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <?php if (!empty($profile['phone_mobile'])): ?>
                                <a href="tel:<?= \App\Core\Helper::e($profile['phone_mobile']) ?>" class="flex items-center justify-between p-4 rounded-2xl transition-all border border-white/10 hover:brightness-105 hover:-translate-y-0.5 text-sm" style="background-color: var(--item-bg); color: var(--text-main);">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <i data-lucide="phone-call" class="w-4 h-4 flex-shrink-0" style="color: var(--primary);"></i>
                                        <span class="font-bold text-xs"><?= \App\Core\Helper::e($translations['call_mobile'] ?? 'تماس همراه') ?></span>
                                    </div>
                                    <span class="text-xs sm:text-sm font-mono font-bold dir-ltr" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profile['phone_mobile']) ?></span>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($profile['phone_work'])): ?>
                                <a href="tel:<?= \App\Core\Helper::e($profile['phone_work']) ?>" class="flex items-center justify-between p-4 rounded-2xl transition-all border border-white/10 hover:brightness-105 hover:-translate-y-0.5 text-sm" style="background-color: var(--item-bg); color: var(--text-main);">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <i data-lucide="phone" class="w-4 h-4 flex-shrink-0" style="color: var(--primary);"></i>
                                        <span class="font-bold text-xs"><?= \App\Core\Helper::e($translations['call_work'] ?? 'تلفن کار') ?></span>
                                    </div>
                                    <span class="text-xs sm:text-sm font-mono font-bold dir-ltr" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profile['phone_work']) ?></span>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($profile['email'])): ?>
                                <a href="mailto:<?= \App\Core\Helper::e($profile['email']) ?>" class="flex items-center justify-between p-4 rounded-2xl transition-all border border-white/10 hover:brightness-105 hover:-translate-y-0.5 text-sm" style="background-color: var(--item-bg); color: var(--text-main);">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <i data-lucide="mail" class="w-4 h-4 flex-shrink-0" style="color: var(--primary);"></i>
                                        <span class="font-bold text-xs"><?= \App\Core\Helper::e($translations['email'] ?? 'ارسال ایمیل') ?></span>
                                    </div>
                                    <span class="text-xs font-mono truncate max-w-[180px] dir-ltr" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profile['email']) ?></span>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($profile['website'])): ?>
                                <a href="<?= \App\Core\Helper::e($profile['website']) ?>" target="_blank" rel="noopener" class="flex items-center justify-between p-4 rounded-2xl transition-all border border-white/10 hover:brightness-105 hover:-translate-y-0.5 text-sm" style="background-color: var(--item-bg); color: var(--text-main);">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <i data-lucide="globe" class="w-4 h-4 flex-shrink-0" style="color: var(--primary);"></i>
                                        <span class="font-bold text-xs"><?= \App\Core\Helper::e($translations['website'] ?? 'وب‌سایت رسمی') ?></span>
                                    </div>
                                    <div class="flex items-center gap-1.5 min-w-0">
                                        <span class="text-xs font-mono truncate max-w-[140px] dir-ltr" style="color: var(--text-sub);"><?= \App\Core\Helper::e(preg_replace('#^https?://#', '', $profile['website'])) ?></span>
                                        <i data-lucide="external-link" class="w-4 h-4 flex-shrink-0" style="color: var(--text-sub);"></i>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Iranian & International Social Networks -->
                <?php require __DIR__ . '/../partials/social_links.php'; ?>

                <!-- Working Hours & Location Map Side-by-Side on Desktop -->
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

                <!-- Mobile Glass QR Code -->
                <div class="lg:hidden glass-card rounded-[32px] p-6 text-center space-y-3 shadow-xl">
                    <h3 class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-main);"><?= \App\Core\Helper::e($translations['scan_qr'] ?? 'اسکن کیوآرکد اختصاصی') ?></h3>
                    <div class="w-40 h-40 mx-auto p-3 bg-white/95 rounded-2xl shadow-md flex items-center justify-center">
                        <img src="<?= $qrCodeDataUri ?>" alt="QR" class="w-full h-full object-contain">
                    </div>
                    <p class="text-[10px] font-mono dir-ltr" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profileUrl) ?></p>
                </div>

            </div>

        </div>
    </main>

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
