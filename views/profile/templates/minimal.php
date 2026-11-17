<?php
// Template 1: Minimal Luxury
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
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl" data-theme="<?= \App\Core\Helper::e($themeMode) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \App\Core\Helper::e($profile['display_name']) ?> - کارت ویزیت هوشمند</title>
    
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
<body class="min-h-screen flex flex-col justify-between p-4 sm:p-6 selection:bg-[var(--primary)] selection:text-black">

    <!-- Floating Theme Switcher for Visitor -->
    <div class="fixed top-4 left-4 z-50">
        <button type="button" onclick="toggleCardTheme()" class="px-3.5 py-1.5 rounded-full border shadow-md text-xs font-bold flex items-center gap-1.5 transition-all backdrop-blur-md" style="background-color: var(--card); color: var(--text-main); border-color: var(--border);">
            <i id="theme-btn-icon" data-lucide="<?= $themeMode === 'light' ? 'sun' : 'moon' ?>" class="w-3.5 h-3.5" style="color: var(--primary);"></i>
            <span id="theme-btn-text"><?= $themeMode === 'light' ? 'تم روشن' : 'تم تیره' ?></span>
        </button>
    </div>

    <div class="max-w-md w-full mx-auto space-y-6 pt-10">
        
        <!-- Header Card -->
        <div class="relative rounded-3xl p-6 sm:p-8 text-center space-y-5 border transition-all" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">
            
            <!-- Avatar -->
            <div class="relative w-28 h-28 mx-auto">
                <div class="w-full h-full rounded-full p-1 border-2" style="border-color: var(--primary);">
                    <?php if (!empty($profile['avatar_url'])): ?>
                        <img src="<?= \App\Core\Helper::url($profile['avatar_url']) ?>" alt="<?= \App\Core\Helper::e($profile['display_name']) ?>" class="w-full h-full object-cover rounded-full">
                    <?php else: ?>
                        <div class="w-full h-full rounded-full flex items-center justify-center text-3xl font-black uppercase" style="background-color: var(--box-bg); color: var(--primary);">
                            <?= mb_substr($profile['display_name'], 0, 1) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="absolute bottom-1 right-1 w-6 h-6 rounded-full bg-emerald-500 border-2 border-[var(--card)] flex items-center justify-center text-white" title="تایید شده">
                    <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3]"></i>
                </div>
            </div>

            <!-- Identity -->
            <div class="space-y-1">
                <h1 class="text-2xl font-black" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['display_name']) ?></h1>
                <?php if (!empty($profile['job_title'])): ?>
                    <p class="text-sm font-bold" style="color: var(--primary);"><?= \App\Core\Helper::e($profile['job_title']) ?></p>
                <?php endif; ?>
                <?php if (!empty($profile['company'])): ?>
                    <p class="text-xs font-medium" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profile['company']) ?></p>
                <?php endif; ?>
            </div>

            <?php if (!empty($profile['bio'])): ?>
                <p class="text-xs leading-relaxed pt-2 border-t" style="color: var(--text-sub); border-color: var(--border);">
                    <?= nl2br(\App\Core\Helper::e($profile['bio'])) ?>
                </p>
            <?php endif; ?>

            <!-- Direct Actions: vCard & Call -->
            <div class="pt-4 flex flex-col gap-3">
                <a href="<?= \App\Core\Helper::url('vcard/@' . (!empty($profile['slug']) ? $profile['slug'] : $profile['mobile'])) ?>" class="w-full py-4 rounded-2xl font-black text-sm text-white flex items-center justify-center gap-2 shadow-xl hover:brightness-105 active:scale-95 transition-all" style="background: linear-gradient(135deg, var(--primary), var(--text-accent));">
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                    <span>ذخیره در مخاطبین (Save Contact)</span>
                </a>

                <div class="grid grid-cols-2 gap-3">
                    <?php if (!empty($profile['phone_mobile'])): ?>
                        <a href="tel:<?= \App\Core\Helper::e($profile['phone_mobile']) ?>" class="py-3 px-4 rounded-xl text-xs font-bold flex items-center justify-center gap-2 border hover:brightness-105 transition-all" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                            <i data-lucide="phone-call" class="w-4 h-4" style="color: var(--primary);"></i>
                            <span>تماس مستقیم</span>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($social['whatsapp'])): ?>
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $social['whatsapp']) ?>" target="_blank" class="py-3 px-4 rounded-xl text-xs font-bold flex items-center justify-center gap-2 border hover:brightness-105 transition-all" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                            <i data-lucide="message-circle" class="w-4 h-4 text-emerald-500"></i>
                            <span>واتساپ</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <!-- Social & Contact Links Card -->
        <div class="rounded-3xl p-6 border space-y-4" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">
            <h3 class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-sub);">راه‌های ارتباطی</h3>
            
            <div class="space-y-2.5">
                <?php if (!empty($profile['email'])): ?>
                    <a href="mailto:<?= \App\Core\Helper::e($profile['email']) ?>" class="flex items-center justify-between p-3.5 rounded-xl border transition-all text-sm" style="background-color: var(--box-bg); border-color: var(--border);">
                        <div class="flex items-center gap-3">
                            <i data-lucide="mail" class="w-4 h-4" style="color: var(--primary);"></i>
                            <span class="text-xs font-medium" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['email']) ?></span>
                        </div>
                        <i data-lucide="chevron-left" class="w-4 h-4" style="color: var(--text-sub);"></i>
                    </a>
                <?php endif; ?>

                <?php if (!empty($social['instagram'])): ?>
                    <a href="https://instagram.com/<?= ltrim(\App\Core\Helper::e($social['instagram']), '@') ?>" target="_blank" class="flex items-center justify-between p-3.5 rounded-xl border hover:border-pink-500/50 transition-all text-sm" style="background-color: var(--box-bg); border-color: var(--border);">
                        <div class="flex items-center gap-3">
                            <i data-lucide="instagram" class="w-4 h-4 text-pink-500"></i>
                            <span class="text-xs font-medium" style="color: var(--text-main);">اینستاگرام</span>
                        </div>
                        <span class="text-xs font-mono" style="color: var(--text-sub);">@<?= ltrim(\App\Core\Helper::e($social['instagram']), '@') ?></span>
                    </a>
                <?php endif; ?>

                <?php if (!empty($social['telegram'])): ?>
                    <a href="https://t.me/<?= ltrim(\App\Core\Helper::e($social['telegram']), '@') ?>" target="_blank" class="flex items-center justify-between p-3.5 rounded-xl border hover:border-sky-500/50 transition-all text-sm" style="background-color: var(--box-bg); border-color: var(--border);">
                        <div class="flex items-center gap-3">
                            <i data-lucide="send" class="w-4 h-4 text-sky-500"></i>
                            <span class="text-xs font-medium" style="color: var(--text-main);">کانال یا آیدی تلگرام</span>
                        </div>
                        <i data-lucide="external-link" class="w-4 h-4" style="color: var(--text-sub);"></i>
                    </a>
                <?php endif; ?>

                <?php if (!empty($social['linkedin'])): ?>
                    <a href="https://linkedin.com/in/<?= ltrim(\App\Core\Helper::e($social['linkedin']), '@') ?>" target="_blank" class="flex items-center justify-between p-3.5 rounded-xl border hover:border-blue-500/50 transition-all text-sm" style="background-color: var(--box-bg); border-color: var(--border);">
                        <div class="flex items-center gap-3">
                            <i data-lucide="linkedin" class="w-4 h-4 text-blue-600"></i>
                            <span class="text-xs font-medium" style="color: var(--text-main);">لینکدین</span>
                        </div>
                        <i data-lucide="external-link" class="w-4 h-4" style="color: var(--text-sub);"></i>
                    </a>
                <?php endif; ?>

                <?php if (!empty($profile['website'])): ?>
                    <a href="<?= \App\Core\Helper::e($profile['website']) ?>" target="_blank" class="flex items-center justify-between p-3.5 rounded-xl border transition-all text-sm" style="background-color: var(--box-bg); border-color: var(--border);">
                        <div class="flex items-center gap-3">
                            <i data-lucide="globe" class="w-4 h-4" style="color: var(--primary);"></i>
                            <span class="text-xs font-medium" style="color: var(--text-main);">وب‌سایت رسمی</span>
                        </div>
                        <i data-lucide="external-link" class="w-4 h-4" style="color: var(--text-sub);"></i>
                    </a>
                <?php endif; ?>

                <?php if (!empty($profile['address'])): ?>
                    <div class="p-3.5 rounded-xl border text-xs space-y-2" style="background-color: var(--box-bg); border-color: var(--border);">
                        <div class="flex items-center gap-2 font-bold" style="color: var(--primary);">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            <span>نشانی دفتر یا محل کار:</span>
                        </div>
                        <p class="leading-relaxed" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profile['address']) ?></p>
                        <a href="https://maps.google.com/?q=<?= urlencode($profile['address']) ?>" target="_blank" class="inline-flex items-center gap-1 text-[11px] hover:underline" style="color: var(--primary);">
                            <span>مسیریابی روی نقشه</span>
                            <i data-lucide="arrow-left" class="w-3 h-3"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="rounded-3xl p-6 border text-center space-y-4" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">
            <div class="space-y-1">
                <h3 class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-main);">اسکن مستقیم بارکد QR</h3>
                <p class="text-[11px]" style="color: var(--text-sub);">اسکن با دوربین گوشی جهت مشاهده یا اشتراک‌گذاری سریع</p>
            </div>
            
            <div class="w-44 h-44 mx-auto p-3 bg-white rounded-2xl shadow-md border border-slate-200 flex items-center justify-center">
                <img src="<?= $qrCodeDataUri ?>" alt="QR Code" class="w-full h-full object-contain">
            </div>

            <span class="block text-[11px] font-mono" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profileUrl) ?></span>
        </div>

    </div>

    <!-- CIPCard Brand Footer -->
    <footer class="text-center py-6 text-xs space-y-1" style="color: var(--text-sub);">
        <a href="<?= \App\Core\Helper::url() ?>" target="_blank" class="font-bold hover:underline transition-colors flex items-center justify-center gap-1.5" style="color: var(--text-main);">
            <i data-lucide="nfc" class="w-4 h-4" style="color: var(--primary);"></i>
            <span>قدرت گرفته از کارت ویزیت هوشمند <strong>CIPCard</strong></span>
        </a>
        <p class="text-[11px]">طراحی و توسعه توسط <a href="https://rastingroup.ir" target="_blank" rel="noopener" class="font-bold hover:underline" style="color: var(--primary);">تیم توسعه هوشمند راستین</a></p>
    </footer>

    <script>
        function toggleCardTheme() {
            var curr = document.documentElement.getAttribute('data-theme') || '<?= $themeMode ?>';
            var next = curr === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', next);
            var txt = document.getElementById('theme-btn-text');
            var icon = document.getElementById('theme-btn-icon');
            if (txt) txt.innerText = next === 'light' ? 'تم روشن' : 'تم تیره';
            if (icon) icon.setAttribute('data-lucide', next === 'light' ? 'sun' : 'moon');
            if (window.lucide) lucide.createIcons();
        }
        lucide.createIcons();
    </script>
</body>
</html>
