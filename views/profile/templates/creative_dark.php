<?php
// Template 4: Creative & Neon (Responsive Mobile + Full-Screen Desktop Layout)
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
            --card-shadow: 0 0 25px var(--shadow);
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
<body class="min-h-screen flex flex-col justify-between p-4 sm:p-6 lg:p-10 xl:px-14">

    <!-- Floating Top Nav: Theme Toggle & 6-Language Selector -->
    <?php require __DIR__ . '/../partials/header_nav.php'; ?>

    <main class="w-full max-w-md lg:max-w-7xl mx-auto pt-14 lg:pt-16 flex-1 flex flex-col justify-center">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

            <!-- Left / Right Sidebar Column (Neon Identity + Desktop QR) -->
            <div class="lg:col-span-4 xl:col-span-4 lg:sticky lg:top-24 space-y-6">
                
                <!-- Neon Identity Card -->
                <div class="rounded-[32px] p-6 sm:p-8 neon-border relative overflow-hidden space-y-5" style="background-color: var(--card-bg);">
                    <?php if (!empty($profile['cover_url'])): ?>
                        <div class="-mx-6 -mt-6 sm:-mx-8 sm:-mt-8 h-28 sm:h-36 overflow-hidden relative border-b border-white/10 mb-4">
                            <img src="<?= \App\Core\Helper::url($profile['cover_url']) ?>" alt="Cover Banner" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        </div>
                    <?php endif; ?>

                    <div class="flex items-center lg:flex-col lg:text-center gap-4 <?= !empty($profile['cover_url']) ? '-mt-12 relative z-10' : '' ?>">
                        <div class="w-20 h-20 lg:w-28 lg:h-28 rounded-2xl overflow-hidden border-2 flex-shrink-0 shadow-lg" style="border-color: var(--neon); background-color: var(--card-bg);">
                            <?php if (!empty($profile['avatar_url'])): ?>
                                <img src="<?= \App\Core\Helper::url($profile['avatar_url']) ?>" alt="Avatar" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-2xl lg:text-3xl font-black neon-text" style="background-color: var(--item-bg);">
                                    <?= mb_substr($profile['display_name'], 0, 1) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="space-y-1 overflow-hidden">
                            <h1 class="text-xl lg:text-2xl font-black truncate" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['display_name']) ?></h1>
                            <p class="text-xs lg:text-sm font-mono font-bold uppercase tracking-wider neon-text"><?= \App\Core\Helper::e($profile['job_title'] ?: 'VIP MEMBER') ?></p>
                            <?php if (!empty($profile['company'])): ?>
                                <p class="text-xs" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profile['company']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($profile['bio'])): ?>
                        <p class="text-xs sm:text-sm leading-relaxed pt-3 border-t" style="color: var(--text-sub); border-color: var(--border);">
                            <?= nl2br(\App\Core\Helper::e($profile['bio'])) ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($canSaveContact): ?>
                        <a href="<?= $vcardUrl ?>" class="w-full py-4 rounded-2xl font-black text-sm flex items-center justify-center gap-2 shadow-lg hover:brightness-105 active:scale-95 transition-all" style="background-color: var(--neon); color: var(--btn-text);">
                            <i data-lucide="download" class="w-5 h-5"></i>
                            <span><?= \App\Core\Helper::e($translations['save_contact'] ?? 'ذخیره در مخاطبین') ?></span>
                        </a>
                    <?php endif; ?>

                    <!-- Quick Communication Grid (Mobile view inside card) -->
                    <div class="grid grid-cols-2 gap-2 pt-2 lg:hidden">
                        <?php if (!empty($profile['phone_mobile'])): ?>
                            <a href="tel:<?= \App\Core\Helper::e($profile['phone_mobile']) ?>" class="p-3 rounded-xl border transition-all flex items-center gap-2 text-xs font-bold" style="background-color: var(--item-bg); border-color: var(--border); color: var(--text-main);">
                                <i data-lucide="phone" class="w-4 h-4" style="color: var(--neon);"></i>
                                <span class="font-mono truncate dir-ltr"><?= \App\Core\Helper::e($profile['phone_mobile']) ?></span>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($profile['phone_work'])): ?>
                            <a href="tel:<?= \App\Core\Helper::e($profile['phone_work']) ?>" class="p-3 rounded-xl border transition-all flex items-center gap-2 text-xs font-bold" style="background-color: var(--item-bg); border-color: var(--border); color: var(--text-main);">
                                <i data-lucide="phone-call" class="w-4 h-4" style="color: var(--neon);"></i>
                                <span class="font-mono truncate dir-ltr"><?= \App\Core\Helper::e($profile['phone_work']) ?></span>
                            </a>
                        <?php elseif (!empty($profile['email'])): ?>
                            <a href="mailto:<?= \App\Core\Helper::e($profile['email']) ?>" class="p-3 rounded-xl border transition-all flex items-center gap-2 text-xs font-bold" style="background-color: var(--item-bg); border-color: var(--border); color: var(--text-main);">
                                <i data-lucide="mail" class="w-4 h-4" style="color: var(--neon);"></i>
                                <span class="truncate">Email</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Desktop QR Module -->
                <div class="hidden lg:block rounded-3xl p-6 text-center space-y-3 border" style="background-color: var(--card-bg); border-color: var(--border); box-shadow: var(--card-shadow);">
                    <h3 class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-main);"><?= \App\Core\Helper::e($translations['scan_qr'] ?? 'اسکن بارکد QR') ?></h3>
                    <div class="w-40 h-40 mx-auto p-2.5 bg-white rounded-2xl shadow-lg border border-slate-200">
                        <img src="<?= $qrCodeDataUri ?>" alt="QR" class="w-full h-full object-contain">
                    </div>
                    <span class="text-[11px] font-mono block dir-ltr" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profileUrl) ?></span>
                </div>

            </div>

            <!-- Main Content Column (Right / Left 8 Columns on Desktop) -->
            <div class="lg:col-span-8 xl:col-span-8 space-y-6">

                <!-- Collapsible Extended Description ("توضیحات بیشتر") -->
                <?php require __DIR__ . '/../partials/more_info.php'; ?>

                <!-- Direct Contact Channels Card -->
                <?php if (!empty($profile['phone_mobile']) || !empty($profile['phone_work']) || !empty($profile['email']) || !empty($profile['website'])): ?>
                    <div class="rounded-3xl p-6 sm:p-7 border space-y-4" style="background-color: var(--card-bg); border-color: var(--border); box-shadow: var(--card-shadow);">
                        <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wider flex items-center gap-2" style="color: var(--text-main);">
                            <span class="w-8 h-8 rounded-xl flex items-center justify-center border" style="background-color: var(--item-bg); border-color: var(--border); color: var(--neon);">
                                <i data-lucide="zap" class="w-4 h-4"></i>
                            </span>
                            <span><?= \App\Core\Helper::e($translations['contact_info'] ?? ($currentLang === 'fa' ? 'ارتباط سریع و مستقیم' : 'Quick Connect')) ?></span>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <?php if (!empty($profile['phone_mobile'])): ?>
                                <a href="tel:<?= \App\Core\Helper::e($profile['phone_mobile']) ?>" class="p-4 rounded-2xl border transition-all hover:brightness-110 hover:-translate-y-0.5 flex items-center justify-between text-xs font-bold" style="background-color: var(--item-bg); border-color: var(--border); color: var(--text-main);">
                                    <span class="flex items-center gap-2.5">
                                        <i data-lucide="smartphone" class="w-4 h-4" style="color: var(--neon);"></i>
                                        <span><?= \App\Core\Helper::e($translations['call_mobile'] ?? 'تلفن همراه') ?></span>
                                    </span>
                                    <span class="font-mono text-xs sm:text-sm dir-ltr"><?= \App\Core\Helper::e($profile['phone_mobile']) ?></span>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($profile['phone_work'])): ?>
                                <a href="tel:<?= \App\Core\Helper::e($profile['phone_work']) ?>" class="p-4 rounded-2xl border transition-all hover:brightness-110 hover:-translate-y-0.5 flex items-center justify-between text-xs font-bold" style="background-color: var(--item-bg); border-color: var(--border); color: var(--text-main);">
                                    <span class="flex items-center gap-2.5">
                                        <i data-lucide="phone-call" class="w-4 h-4" style="color: var(--neon);"></i>
                                        <span><?= \App\Core\Helper::e($translations['call_work'] ?? 'تلفن کار') ?></span>
                                    </span>
                                    <span class="font-mono text-xs sm:text-sm dir-ltr"><?= \App\Core\Helper::e($profile['phone_work']) ?></span>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($profile['email'])): ?>
                                <a href="mailto:<?= \App\Core\Helper::e($profile['email']) ?>" class="p-4 rounded-2xl border transition-all hover:brightness-110 hover:-translate-y-0.5 flex items-center justify-between text-xs font-bold" style="background-color: var(--item-bg); border-color: var(--border); color: var(--text-main);">
                                    <span class="flex items-center gap-2.5">
                                        <i data-lucide="mail" class="w-4 h-4" style="color: var(--neon);"></i>
                                        <span><?= \App\Core\Helper::e($translations['email'] ?? 'ایمیل') ?></span>
                                    </span>
                                    <span class="font-mono truncate max-w-[180px] dir-ltr"><?= \App\Core\Helper::e($profile['email']) ?></span>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($profile['website'])): ?>
                                <a href="<?= \App\Core\Helper::e($profile['website']) ?>" target="_blank" rel="noopener" class="p-4 rounded-2xl border transition-all hover:brightness-110 hover:-translate-y-0.5 flex items-center justify-between text-xs font-bold" style="background-color: var(--item-bg); border-color: var(--border); color: var(--text-main);">
                                    <span class="flex items-center gap-2.5">
                                        <i data-lucide="globe" class="w-4 h-4" style="color: var(--neon);"></i>
                                        <span><?= \App\Core\Helper::e($translations['website'] ?? 'وب‌سایت') ?></span>
                                    </span>
                                    <span class="font-mono truncate max-w-[180px] dir-ltr"><?= \App\Core\Helper::e(preg_replace('#^https?://#', '', $profile['website'])) ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

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

                <!-- Mobile QR Module -->
                <div class="lg:hidden rounded-3xl p-6 text-center space-y-3 border" style="background-color: var(--card-bg); border-color: var(--border);">
                    <h3 class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-main);"><?= \App\Core\Helper::e($translations['scan_qr'] ?? 'اسکن بارکد QR') ?></h3>
                    <div class="w-36 h-36 mx-auto p-2.5 bg-white rounded-2xl shadow-lg border border-slate-200">
                        <img src="<?= $qrCodeDataUri ?>" alt="QR" class="w-full h-full object-contain">
                    </div>
                    <span class="text-[10px] font-mono block dir-ltr" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profileUrl) ?></span>
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
        function toggleCreativeTheme() {
            toggleCardTheme();
        }
        lucide.createIcons();
    </script>
</body>
</html>
