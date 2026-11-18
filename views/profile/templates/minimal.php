<?php
// Template 1: Minimal Luxury (Responsive Mobile + Full-Screen Desktop Layout)
$theme = $profile['theme_color'] ?? 'gold_black';
$themeMode = $profile['theme_mode'] ?? 'light';

$darkPalettes = [
    'gold_black'   => ['primary' => '#D4AF37', 'bg' => '#0A0A0C', 'card' => '#121217', 'textAccent' => '#92400E', 'border' => 'rgba(212, 175, 55, 0.3)'],
    'blue_white'   => ['primary' => '#0284C7', 'bg' => '#080E1A', 'card' => '#0F172A', 'textAccent' => '#1D4ED8', 'border' => 'rgba(56, 189, 248, 0.3)'],
    'emerald_gray' => ['primary' => '#059669', 'bg' => '#06130D', 'card' => '#0C1E16', 'textAccent' => '#047857', 'border' => 'rgba(16, 185, 129, 0.3)']
];

$lightPalettes = [
    'gold_black'   => ['primary' => '#B8860B', 'bg' => '#F8FAFC', 'card' => '#FFFFFF', 'textAccent' => '#92400E', 'border' => '#E2E8F0'],
    'blue_white'   => ['primary' => '#0284C7', 'bg' => '#F0F9FF', 'card' => '#FFFFFF', 'textAccent' => '#1D4ED8', 'border' => '#BAE6FD'],
    'emerald_gray' => ['primary' => '#059669', 'bg' => '#F0FDF4', 'card' => '#FFFFFF', 'textAccent' => '#047857', 'border' => '#A7F3D0']
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
        /* Dark Theme Variables */
        html[data-theme="dark"] {
            --primary: <?= $dColors['primary'] ?>;
            --bg: <?= $dColors['bg'] ?>;
            --card: <?= $dColors['card'] ?>;
            --text-main: #FFFFFF;
            --text-sub: #9CA3AF;
            --text-accent: <?= $dColors['textAccent'] ?>;
            --border: <?= $dColors['border'] ?>;
            --box-bg: rgba(255, 255, 255, 0.04);
            --card-shadow: 0 20px 40px -15px rgba(0,0,0,0.7);
        }

        /* Light Theme Variables */
        html[data-theme="light"] {
            --primary: <?= $lColors['primary'] ?>;
            --bg: <?= $lColors['bg'] ?>;
            --card: <?= $lColors['card'] ?>;
            --text-main: #0F172A;
            --text-sub: #64748B;
            --text-accent: <?= $lColors['textAccent'] ?>;
            --border: <?= $lColors['border'] ?>;
            --box-bg: #F1F5F9;
            --card-shadow: 0 10px 30px -5px rgba(0,0,0,0.06);
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            font-family: 'Vazirmatn', sans-serif;
            transition: background-color 0.25s, color 0.25s;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between p-4 sm:p-6 lg:p-10 xl:px-14 selection:bg-[var(--primary)] selection:text-black">

    <!-- Floating Top Nav: Theme Toggle & 6-Language Selector -->
    <?php require __DIR__ . '/../partials/header_nav.php'; ?>

    <main class="w-full max-w-md lg:max-w-7xl mx-auto pt-14 lg:pt-16 flex-1 flex flex-col justify-center">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
            
            <!-- Left / Right Sidebar (Identity + QR on Desktop) -->
            <div class="lg:col-span-4 xl:col-span-4 lg:sticky lg:top-24 space-y-6">
                
                <!-- Header Identity Card -->
                <div class="relative rounded-3xl p-6 sm:p-8 text-center space-y-5 border transition-all overflow-hidden" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">
                    
                    <?php if (!empty($profile['cover_url'])): ?>
                        <div class="-mx-6 -mt-6 sm:-mx-8 sm:-mt-8 h-28 sm:h-32 overflow-hidden relative border-b" style="border-color: var(--border);">
                            <img src="<?= \App\Core\Helper::url($profile['cover_url']) ?>" alt="Cover" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        </div>
                    <?php endif; ?>

                    <!-- Avatar -->
                    <div class="relative w-28 h-28 lg:w-32 lg:h-32 mx-auto <?= !empty($profile['cover_url']) ? '-mt-14 relative z-10' : '' ?>">
                        <div class="w-full h-full rounded-full p-1 border-2 shadow-lg" style="border-color: var(--primary); background-color: var(--card);">
                            <?php if (!empty($profile['avatar_url'])): ?>
                                <img src="<?= \App\Core\Helper::url($profile['avatar_url']) ?>" alt="<?= \App\Core\Helper::e($profile['display_name']) ?>" class="w-full h-full object-cover rounded-full">
                            <?php else: ?>
                                <div class="w-full h-full rounded-full flex items-center justify-center text-3xl lg:text-4xl font-black uppercase" style="background-color: var(--box-bg); color: var(--primary);">
                                    <?= mb_substr($profile['display_name'], 0, 1) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="absolute bottom-1 right-1 w-6 h-6 lg:w-7 lg:h-7 rounded-full bg-emerald-500 border-2 border-[var(--card)] flex items-center justify-center text-white" title="تایید شده">
                            <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3]"></i>
                        </div>
                    </div>

                    <!-- Identity -->
                    <div class="space-y-1.5">
                        <h1 class="text-2xl lg:text-3xl font-black tracking-tight" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['display_name']) ?></h1>
                        <?php if (!empty($profile['job_title'])): ?>
                            <p class="text-sm lg:text-base font-bold" style="color: var(--primary);"><?= \App\Core\Helper::e($profile['job_title']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($profile['company'])): ?>
                            <p class="text-xs lg:text-sm font-medium" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profile['company']) ?></p>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($profile['bio'])): ?>
                        <p class="text-xs sm:text-sm leading-relaxed pt-3 border-t" style="color: var(--text-sub); border-color: var(--border);">
                            <?= nl2br(\App\Core\Helper::e($profile['bio'])) ?>
                        </p>
                    <?php endif; ?>

                    <!-- Direct Actions: vCard (only when identifier is mobile) & Call -->
                    <?php if ($canSaveContact || !empty($profile['phone_mobile']) || !empty($profile['phone_work']) || !empty($social['whatsapp'])): ?>
                        <div class="pt-3 flex flex-col gap-3">
                            <?php if ($canSaveContact): ?>
                                <a href="<?= $vcardUrl ?>" class="w-full py-4 rounded-2xl font-black text-sm text-white flex items-center justify-center gap-2 shadow-xl hover:brightness-105 active:scale-95 transition-all" style="background: linear-gradient(135deg, var(--primary), var(--text-accent));">
                                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                                    <span><?= \App\Core\Helper::e($translations['save_contact'] ?? 'ذخیره در مخاطبین') ?></span>
                                </a>
                            <?php endif; ?>

                            <div class="grid grid-cols-2 gap-3">
                                <?php if (!empty($profile['phone_mobile'])): ?>
                                    <a href="tel:<?= \App\Core\Helper::e($profile['phone_mobile']) ?>" class="py-3 px-4 rounded-xl text-xs font-bold flex items-center justify-center gap-2 border hover:brightness-105 transition-all" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                                        <i data-lucide="phone-call" class="w-4 h-4" style="color: var(--primary);"></i>
                                        <span><?= \App\Core\Helper::e($translations['call_mobile'] ?? 'تماس همراه') ?></span>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($profile['phone_work'])): ?>
                                    <a href="tel:<?= \App\Core\Helper::e($profile['phone_work']) ?>" class="py-3 px-4 rounded-xl text-xs font-bold flex items-center justify-center gap-2 border hover:brightness-105 transition-all" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                                        <i data-lucide="phone" class="w-4 h-4" style="color: var(--primary);"></i>
                                        <span><?= \App\Core\Helper::e($translations['call_work'] ?? 'تلفن کار') ?></span>
                                    </a>
                                <?php elseif (!empty($social['whatsapp'])): ?>
                                    <a href="<?= \App\Services\SocialService::formatUrl('whatsapp', (string)$social['whatsapp']) ?>" target="_blank" class="py-3 px-4 rounded-xl text-xs font-bold flex items-center justify-center gap-2 border hover:brightness-105 transition-all" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                                        <i data-lucide="message-circle" class="w-4 h-4 text-emerald-500"></i>
                                        <span>واتساپ</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Desktop Sticky QR Code Module (Visible on lg+) -->
                <div class="hidden lg:block rounded-3xl p-6 border text-center space-y-4 transition-all" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">
                    <div class="space-y-1">
                        <h3 class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-main);"><?= \App\Core\Helper::e($translations['scan_qr'] ?? 'اسکن بارکد QR') ?></h3>
                        <p class="text-[11px]" style="color: var(--text-sub);"><?= $currentLang === 'fa' ? 'اسکن با دوربین گوشی جهت ذخیره یا اشتراک‌گذاری' : 'Scan with camera to open or share card' ?></p>
                    </div>
                    
                    <div class="w-40 h-40 mx-auto p-3 bg-white rounded-2xl shadow-md border border-slate-200 flex items-center justify-center">
                        <img src="<?= $qrCodeDataUri ?>" alt="QR Code" class="w-full h-full object-contain">
                    </div>

                    <div class="pt-1 flex items-center justify-center gap-2">
                        <span class="text-[11px] font-mono dir-ltr px-3 py-1 rounded-lg border" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-sub);">
                            <?= \App\Core\Helper::e($profileUrl) ?>
                        </span>
                    </div>
                </div>

            </div>

            <!-- Main Content Column (Right / Left 8 Columns on Desktop) -->
            <div class="lg:col-span-8 xl:col-span-8 space-y-6">

                <!-- Collapsible Extended Description ("توضیحات بیشتر") -->
                <?php require __DIR__ . '/../partials/more_info.php'; ?>

                <!-- Direct Contact Details Card (Phone, Work Phone, Email, Website) -->
                <?php if (!empty($profile['phone_mobile']) || !empty($profile['phone_work']) || !empty($profile['email']) || !empty($profile['website'])): ?>
                    <div class="rounded-3xl p-6 sm:p-7 border space-y-4 transition-all" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">
                        <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wider flex items-center gap-2" style="color: var(--text-main);">
                            <span class="w-8 h-8 rounded-xl flex items-center justify-center border" style="background-color: var(--box-bg); border-color: var(--border); color: var(--primary);">
                                <i data-lucide="contact" class="w-4 h-4"></i>
                            </span>
                            <span><?= \App\Core\Helper::e($translations['contact_info'] ?? ($currentLang === 'fa' ? 'راه‌های ارتباط مستقیم' : 'Direct Contact Channels')) ?></span>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <?php if (!empty($profile['phone_mobile'])): ?>
                                <a href="tel:<?= \App\Core\Helper::e($profile['phone_mobile']) ?>" class="flex items-center justify-between p-4 rounded-2xl border hover:brightness-105 hover:-translate-y-0.5 transition-all text-xs" style="background-color: var(--box-bg); border-color: var(--border);">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 border" style="background-color: var(--card); border-color: var(--border); color: var(--primary);">
                                            <i data-lucide="smartphone" class="w-4 h-4"></i>
                                        </span>
                                        <div class="min-w-0">
                                            <span class="block text-[11px]" style="color: var(--text-sub);"><?= \App\Core\Helper::e($translations['call_mobile'] ?? 'تلفن همراه') ?></span>
                                            <span class="font-bold font-mono text-xs sm:text-sm block truncate dir-ltr text-left" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['phone_mobile']) ?></span>
                                        </div>
                                    </div>
                                    <i data-lucide="phone-outgoing" class="w-4 h-4 opacity-60 flex-shrink-0" style="color: var(--primary);"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($profile['phone_work'])): ?>
                                <a href="tel:<?= \App\Core\Helper::e($profile['phone_work']) ?>" class="flex items-center justify-between p-4 rounded-2xl border hover:brightness-105 hover:-translate-y-0.5 transition-all text-xs" style="background-color: var(--box-bg); border-color: var(--border);">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 border" style="background-color: var(--card); border-color: var(--border); color: var(--primary);">
                                            <i data-lucide="phone" class="w-4 h-4"></i>
                                        </span>
                                        <div class="min-w-0">
                                            <span class="block text-[11px]" style="color: var(--text-sub);"><?= \App\Core\Helper::e($translations['call_work'] ?? 'تلفن محل کار') ?></span>
                                            <span class="font-bold font-mono text-xs sm:text-sm block truncate dir-ltr text-left" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['phone_work']) ?></span>
                                        </div>
                                    </div>
                                    <i data-lucide="phone-forwarded" class="w-4 h-4 opacity-60 flex-shrink-0" style="color: var(--primary);"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($profile['email'])): ?>
                                <a href="mailto:<?= \App\Core\Helper::e($profile['email']) ?>" class="flex items-center justify-between p-4 rounded-2xl border hover:brightness-105 hover:-translate-y-0.5 transition-all text-xs" style="background-color: var(--box-bg); border-color: var(--border);">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 border" style="background-color: var(--card); border-color: var(--border); color: var(--primary);">
                                            <i data-lucide="mail" class="w-4 h-4"></i>
                                        </span>
                                        <div class="min-w-0">
                                            <span class="block text-[11px]" style="color: var(--text-sub);"><?= \App\Core\Helper::e($translations['email'] ?? 'ارسال ایمیل') ?></span>
                                            <span class="font-bold font-mono text-xs sm:text-sm block truncate dir-ltr text-left" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['email']) ?></span>
                                        </div>
                                    </div>
                                    <i data-lucide="send" class="w-4 h-4 opacity-60 flex-shrink-0" style="color: var(--primary);"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($profile['website'])): ?>
                                <a href="<?= \App\Core\Helper::e($profile['website']) ?>" target="_blank" rel="noopener" class="flex items-center justify-between p-4 rounded-2xl border hover:brightness-105 hover:-translate-y-0.5 transition-all text-xs" style="background-color: var(--box-bg); border-color: var(--border);">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 border" style="background-color: var(--card); border-color: var(--border); color: var(--primary);">
                                            <i data-lucide="globe" class="w-4 h-4"></i>
                                        </span>
                                        <div class="min-w-0">
                                            <span class="block text-[11px]" style="color: var(--text-sub);"><?= \App\Core\Helper::e($translations['website'] ?? 'وب‌سایت رسمی') ?></span>
                                            <span class="font-bold font-mono text-xs sm:text-sm block truncate dir-ltr text-left" style="color: var(--text-main);"><?= \App\Core\Helper::e(preg_replace('#^https?://#', '', $profile['website'])) ?></span>
                                        </div>
                                    </div>
                                    <i data-lucide="external-link" class="w-4 h-4 opacity-60 flex-shrink-0" style="color: var(--primary);"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Iranian & International Social Networks -->
                <?php require __DIR__ . '/../partials/social_links.php'; ?>

                <!-- Working Hours & Location Map Side-by-Side on Desktop when both exist -->
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

                <!-- Mobile QR Code Section (Hidden on lg+ since it's in the sticky left column) -->
                <div class="lg:hidden rounded-3xl p-6 border text-center space-y-4" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">
                    <div class="space-y-1">
                        <h3 class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-main);"><?= \App\Core\Helper::e($translations['scan_qr'] ?? 'اسکن بارکد QR') ?></h3>
                        <p class="text-[11px]" style="color: var(--text-sub);"><?= $currentLang === 'fa' ? 'اسکن با دوربین گوشی جهت ذخیره یا اشتراک‌گذاری' : 'Scan with camera to open or share card' ?></p>
                    </div>
                    
                    <div class="w-44 h-44 mx-auto p-3 bg-white rounded-2xl shadow-md border border-slate-200 flex items-center justify-center">
                        <img src="<?= $qrCodeDataUri ?>" alt="QR Code" class="w-full h-full object-contain">
                    </div>

                    <div class="pt-1 flex items-center justify-center gap-2">
                        <button type="button" onclick="navigator.clipboard.writeText('<?= \App\Core\Helper::e($profileUrl) ?>'); alert('<?= \App\Core\Helper::e($translations['link_copied'] ?? 'لینک کپی شد!') ?>');" class="px-3.5 py-1.5 rounded-full border text-[11px] font-bold flex items-center gap-1.5 hover:brightness-105" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                            <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                            <span><?= \App\Core\Helper::e($translations['share_card'] ?? 'اشتراک‌گذاری') ?></span>
                        </button>
                    </div>
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
