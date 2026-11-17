<?php
// Template 2: Glassmorphism
$theme = $profile['theme_color'] ?? 'blue_white';
$themeMode = $profile['theme_mode'] ?? 'light';

$darkPalettes = [
    'gold_black'   => ['primary' => '#D97706', 'gradient' => 'linear-gradient(135deg, #18181b 0%, #09090b 100%)', 'glass' => 'rgba(24, 24, 27, 0.7)', 'accent' => '#B45309', 'border' => 'rgba(255, 255, 255, 0.12)', 'text' => '#FFFFFF', 'sub' => '#9CA3AF', 'itemBg' => 'rgba(255, 255, 255, 0.05)'],
    'blue_white'   => ['primary' => '#0284C7', 'gradient' => 'linear-gradient(135deg, #0f172a 0%, #020617 100%)', 'glass' => 'rgba(15, 23, 42, 0.7)', 'accent' => '#2563EB', 'border' => 'rgba(255, 255, 255, 0.12)', 'text' => '#FFFFFF', 'sub' => '#9CA3AF', 'itemBg' => 'rgba(255, 255, 255, 0.05)'],
    'emerald_gray' => ['primary' => '#059669', 'gradient' => 'linear-gradient(135deg, #064e3b 0%, #022c22 100%)', 'glass' => 'rgba(6, 78, 59, 0.7)', 'accent' => '#047857', 'border' => 'rgba(255, 255, 255, 0.12)', 'text' => '#FFFFFF', 'sub' => '#9CA3AF', 'itemBg' => 'rgba(255, 255, 255, 0.05)']
];

$lightPalettes = [
    'gold_black'   => ['primary' => '#B8860B', 'gradient' => 'linear-gradient(135deg, #FEF9C3 0%, #F8FAFC 100%)', 'glass' => 'rgba(255, 255, 255, 0.85)', 'accent' => '#D4AF37', 'border' => 'rgba(255, 255, 255, 0.9)', 'text' => '#0F172A', 'sub' => '#64748B', 'itemBg' => 'rgba(255, 255, 255, 0.7)'],
    'blue_white'   => ['primary' => '#0284C7', 'gradient' => 'linear-gradient(135deg, #E0F2FE 0%, #F8FAFC 100%)', 'glass' => 'rgba(255, 255, 255, 0.85)', 'accent' => '#38BDF8', 'border' => 'rgba(255, 255, 255, 0.9)', 'text' => '#0F172A', 'sub' => '#64748B', 'itemBg' => 'rgba(255, 255, 255, 0.7)'],
    'emerald_gray' => ['primary' => '#059669', 'gradient' => 'linear-gradient(135deg, #D1FAE5 0%, #F8FAFC 100%)', 'glass' => 'rgba(255, 255, 255, 0.85)', 'accent' => '#34D399', 'border' => 'rgba(255, 255, 255, 0.9)', 'text' => '#0F172A', 'sub' => '#64748B', 'itemBg' => 'rgba(255, 255, 255, 0.7)']
];

$dColors = $darkPalettes[$theme] ?? $darkPalettes['blue_white'];
$lColors = $lightPalettes[$theme] ?? $lightPalettes['blue_white'];
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
            box-shadow: 0 15px 35px -5px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between p-4 sm:p-6 relative overflow-x-hidden">
    <!-- Ambient blur spheres -->
    <div class="fixed top-10 -right-20 w-72 h-72 rounded-full blur-[100px] pointer-events-none opacity-20" style="background-color: var(--primary);"></div>
    <div class="fixed bottom-10 -left-20 w-80 h-80 rounded-full blur-[120px] pointer-events-none opacity-15" style="background-color: var(--accent);"></div>

    <!-- Floating Theme Toggle -->
    <div class="fixed top-4 left-4 z-50">
        <button type="button" onclick="toggleGlassTheme()" class="px-3.5 py-1.5 rounded-full shadow-md text-xs font-bold flex items-center gap-1.5 transition-all glass-card">
            <i id="theme-icon" data-lucide="<?= $themeMode === 'light' ? 'sun' : 'moon' ?>" class="w-3.5 h-3.5" style="color: var(--primary);"></i>
            <span id="theme-text"><?= $themeMode === 'light' ? 'تم روشن' : 'تم تیره' ?></span>
        </button>
    </div>

    <div class="max-w-md w-full mx-auto space-y-6 pt-10 relative z-10">
        
        <!-- Glass Profile Card -->
        <div class="glass-card rounded-[32px] p-6 sm:p-8 text-center space-y-5 shadow-2xl">
            <div class="w-28 h-28 mx-auto rounded-full p-1 border-2 shadow-xl" style="border-color: var(--primary);">
                <?php if (!empty($profile['avatar_url'])): ?>
                    <img src="<?= \App\Core\Helper::url($profile['avatar_url']) ?>" alt="Avatar" class="w-full h-full object-cover rounded-full">
                <?php else: ?>
                    <div class="w-full h-full rounded-full flex items-center justify-center text-3xl font-black" style="background-color: var(--item-bg); color: var(--primary);">
                        <?= mb_substr($profile['display_name'], 0, 1) ?>
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <h1 class="text-2xl font-black" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['display_name']) ?></h1>
                <?php if (!empty($profile['job_title'])): ?>
                    <p class="text-sm font-bold mt-1" style="color: var(--primary);"><?= \App\Core\Helper::e($profile['job_title']) ?></p>
                <?php endif; ?>
                <?php if (!empty($profile['company'])): ?>
                    <p class="text-xs font-medium mt-0.5" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profile['company']) ?></p>
                <?php endif; ?>
            </div>

            <?php if (!empty($profile['bio'])): ?>
                <p class="text-xs leading-relaxed pt-2 border-t border-white/10" style="color: var(--text-sub);">
                    <?= nl2br(\App\Core\Helper::e($profile['bio'])) ?>
                </p>
            <?php endif; ?>

            <a href="<?= \App\Core\Helper::url('vcard/@' . (!empty($profile['slug']) ? $profile['slug'] : $profile['mobile'])) ?>" class="w-full py-4 rounded-2xl font-black text-sm flex items-center justify-center gap-2 shadow-xl hover:brightness-105 active:scale-95 transition-all" style="background: linear-gradient(135deg, var(--accent), var(--primary)); color: var(--btn-text);">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
                <span>ذخیره مستقیم در گوشی (Save Contact)</span>
            </a>
        </div>

        <!-- Glass Actions Card -->
        <div class="glass-card rounded-[32px] p-6 space-y-3 shadow-xl">
            <?php if (!empty($profile['phone_mobile'])): ?>
                <a href="tel:<?= \App\Core\Helper::e($profile['phone_mobile']) ?>" class="flex items-center justify-between p-3.5 rounded-2xl transition-all border border-white/10 text-sm" style="background-color: var(--item-bg); color: var(--text-main);">
                    <div class="flex items-center gap-3">
                        <i data-lucide="phone" class="w-4 h-4" style="color: var(--primary);"></i>
                        <span class="font-bold">تماس تلفنی</span>
                    </div>
                    <span class="text-xs font-mono" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profile['phone_mobile']) ?></span>
                </a>
            <?php endif; ?>

            <?php if (!empty($social['whatsapp'])): ?>
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $social['whatsapp']) ?>" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl transition-all border border-white/10 text-sm" style="background-color: var(--item-bg); color: var(--text-main);">
                    <div class="flex items-center gap-3">
                        <i data-lucide="message-circle" class="w-4 h-4 text-emerald-500"></i>
                        <span class="font-bold">واتساپ</span>
                    </div>
                    <i data-lucide="external-link" class="w-4 h-4" style="color: var(--text-sub);"></i>
                </a>
            <?php endif; ?>

            <?php if (!empty($social['instagram'])): ?>
                <a href="https://instagram.com/<?= ltrim(\App\Core\Helper::e($social['instagram']), '@') ?>" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl transition-all border border-white/10 text-sm" style="background-color: var(--item-bg); color: var(--text-main);">
                    <div class="flex items-center gap-3">
                        <i data-lucide="instagram" class="w-4 h-4 text-pink-500"></i>
                        <span class="font-bold">اینستاگرام</span>
                    </div>
                    <span class="text-xs font-mono" style="color: var(--text-sub);">@<?= ltrim(\App\Core\Helper::e($social['instagram']), '@') ?></span>
                </a>
            <?php endif; ?>

            <?php if (!empty($profile['email'])): ?>
                <a href="mailto:<?= \App\Core\Helper::e($profile['email']) ?>" class="flex items-center justify-between p-3.5 rounded-2xl transition-all border border-white/10 text-sm" style="background-color: var(--item-bg); color: var(--text-main);">
                    <div class="flex items-center gap-3">
                        <i data-lucide="mail" class="w-4 h-4" style="color: var(--primary);"></i>
                        <span class="font-bold">ایمیل</span>
                    </div>
                    <span class="text-xs font-mono" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profile['email']) ?></span>
                </a>
            <?php endif; ?>
        </div>

        <!-- Glass QR Code -->
        <div class="glass-card rounded-[32px] p-6 text-center space-y-3 shadow-xl">
            <h3 class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-main);">اسکن کیوآرکد اختصاصی</h3>
            <div class="w-40 h-40 mx-auto p-3 bg-white/95 rounded-2xl shadow-md flex items-center justify-center">
                <img src="<?= $qrCodeDataUri ?>" alt="QR" class="w-full h-full object-contain">
            </div>
            <p class="text-[10px] font-mono" style="color: var(--text-sub);"><?= \App\Core\Helper::e($profileUrl) ?></p>
        </div>

    </div>

    <footer class="text-center py-6 text-xs relative z-10 space-y-1" style="color: var(--text-sub);">
        <a href="<?= \App\Core\Helper::url() ?>" target="_blank" class="hover:underline transition-colors font-bold" style="color: var(--text-main);">
            CIPCard Smart NFC Experience
        </a>
        <p class="text-[11px]">Designed for VIP & Business Leaders by <a href="https://rastin.ir" target="_blank" rel="noopener" class="font-bold hover:underline" style="color: var(--primary);">rastin.ir</a></p>
    </footer>

    <script>
        function toggleGlassTheme() {
            var curr = document.documentElement.getAttribute('data-theme') || '<?= $themeMode ?>';
            var next = curr === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', next);
            var txt = document.getElementById('theme-text');
            var icon = document.getElementById('theme-icon');
            if (txt) txt.innerText = next === 'light' ? 'تم روشن' : 'تم تیره';
            if (icon) icon.setAttribute('data-lucide', next === 'light' ? 'sun' : 'moon');
            if (window.lucide) lucide.createIcons();
        }
        lucide.createIcons();
    </script>
</body>
</html>
