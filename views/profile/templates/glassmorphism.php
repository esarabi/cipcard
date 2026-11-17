<?php
// Template 2: Glassmorphism
$theme = $profile['theme_color'] ?? 'gold_black';
$palettes = [
    'gold_black'   => ['primary' => '#EAB308', 'gradient' => 'linear-gradient(135deg, #18181b 0%, #09090b 100%)', 'glass' => 'rgba(24, 24, 27, 0.65)', 'accent' => '#FEF08A'],
    'blue_white'   => ['primary' => '#38BDF8', 'gradient' => 'linear-gradient(135deg, #0f172a 0%, #020617 100%)', 'glass' => 'rgba(15, 23, 42, 0.65)', 'accent' => '#BAE6FD'],
    'emerald_gray' => ['primary' => '#34D399', 'gradient' => 'linear-gradient(135deg, #064e3b 0%, #022c22 100%)', 'glass' => 'rgba(6, 78, 59, 0.65)', 'accent' => '#A7F3D0']
];
$colors = $palettes[$theme] ?? $palettes['gold_black'];
$social = $profile['social_links'] ?? [];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \App\Core\Helper::e($profile['display_name']) ?> - کارت ویزیت هوشمند</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            background: <?= $colors['gradient'] ?>;
            font-family: 'Vazirmatn', sans-serif;
        }
        .glass-card {
            background: <?= $colors['glass'] ?>;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }
    </style>
</head>
<body class="text-gray-100 min-h-screen flex flex-col justify-between p-4 sm:p-6 relative overflow-x-hidden">
    <!-- Ambient blur spheres -->
    <div class="fixed top-10 -right-20 w-72 h-72 rounded-full blur-[100px] pointer-events-none" style="background-color: <?= $colors['primary'] ?>; opacity: 0.15;"></div>
    <div class="fixed bottom-10 -left-20 w-80 h-80 rounded-full blur-[120px] pointer-events-none" style="background-color: <?= $colors['accent'] ?>; opacity: 0.1;"></div>

    <div class="max-w-md w-full mx-auto space-y-6 pt-6 relative z-10">
        
        <!-- Glass Profile Card -->
        <div class="glass-card rounded-[32px] p-6 sm:p-8 text-center space-y-5 shadow-2xl">
            <div class="w-28 h-28 mx-auto rounded-full p-1 border-2 shadow-xl" style="border-color: <?= $colors['primary'] ?>;">
                <?php if (!empty($profile['avatar_url'])): ?>
                    <img src="<?= \App\Core\Helper::url($profile['avatar_url']) ?>" alt="Avatar" class="w-full h-full object-cover rounded-full">
                <?php else: ?>
                    <div class="w-full h-full rounded-full flex items-center justify-center text-3xl font-bold bg-white/5" style="color: <?= $colors['primary'] ?>;">
                        <?= mb_substr($profile['display_name'], 0, 1) ?>
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <h1 class="text-2xl font-black text-white"><?= \App\Core\Helper::e($profile['display_name']) ?></h1>
                <?php if (!empty($profile['job_title'])): ?>
                    <p class="text-sm font-semibold mt-1" style="color: <?= $colors['primary'] ?>;"><?= \App\Core\Helper::e($profile['job_title']) ?></p>
                <?php endif; ?>
                <?php if (!empty($profile['company'])): ?>
                    <p class="text-xs text-gray-300 mt-0.5"><?= \App\Core\Helper::e($profile['company']) ?></p>
                <?php endif; ?>
            </div>

            <?php if (!empty($profile['bio'])): ?>
                <p class="text-xs text-gray-300 leading-relaxed pt-2 border-t border-white/10">
                    <?= nl2br(\App\Core\Helper::e($profile['bio'])) ?>
                </p>
            <?php endif; ?>

            <a href="<?= \App\Core\Helper::url('vcard/@' . $profile['mobile']) ?>" class="w-full py-4 rounded-2xl font-black text-sm text-black flex items-center justify-center gap-2 shadow-2xl hover:brightness-110 active:scale-95 transition-all" style="background: linear-gradient(135deg, <?= $colors['accent'] ?>, <?= $colors['primary'] ?>);">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
                <span>ذخیره مستقیم در گوشی (Save)</span>
            </a>
        </div>

        <!-- Glass Actions Card -->
        <div class="glass-card rounded-[32px] p-6 space-y-3 shadow-xl">
            <?php if (!empty($profile['phone_mobile'])): ?>
                <a href="tel:<?= \App\Core\Helper::e($profile['phone_mobile']) ?>" class="flex items-center justify-between p-3.5 rounded-2xl bg-white/5 hover:bg-white/10 transition-all border border-white/5 text-sm">
                    <div class="flex items-center gap-3">
                        <i data-lucide="phone" class="w-4 h-4" style="color: <?= $colors['primary'] ?>;"></i>
                        <span>تماس تلفنی</span>
                    </div>
                    <span class="text-xs font-mono text-gray-400"><?= \App\Core\Helper::e($profile['phone_mobile']) ?></span>
                </a>
            <?php endif; ?>

            <?php if (!empty($social['whatsapp'])): ?>
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $social['whatsapp']) ?>" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl bg-white/5 hover:bg-white/10 transition-all border border-white/5 text-sm">
                    <div class="flex items-center gap-3">
                        <i data-lucide="message-circle" class="w-4 h-4 text-emerald-400"></i>
                        <span>واتساپ</span>
                    </div>
                    <i data-lucide="external-link" class="w-4 h-4 text-gray-500"></i>
                </a>
            <?php endif; ?>

            <?php if (!empty($social['instagram'])): ?>
                <a href="https://instagram.com/<?= ltrim(\App\Core\Helper::e($social['instagram']), '@') ?>" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl bg-white/5 hover:bg-white/10 transition-all border border-white/5 text-sm">
                    <div class="flex items-center gap-3">
                        <i data-lucide="instagram" class="w-4 h-4 text-pink-400"></i>
                        <span>اینستاگرام</span>
                    </div>
                    <span class="text-xs font-mono text-gray-400">@<?= ltrim(\App\Core\Helper::e($social['instagram']), '@') ?></span>
                </a>
            <?php endif; ?>

            <?php if (!empty($profile['email'])): ?>
                <a href="mailto:<?= \App\Core\Helper::e($profile['email']) ?>" class="flex items-center justify-between p-3.5 rounded-2xl bg-white/5 hover:bg-white/10 transition-all border border-white/5 text-sm">
                    <div class="flex items-center gap-3">
                        <i data-lucide="mail" class="w-4 h-4" style="color: <?= $colors['primary'] ?>;"></i>
                        <span>ایمیل</span>
                    </div>
                    <span class="text-xs text-gray-400"><?= \App\Core\Helper::e($profile['email']) ?></span>
                </a>
            <?php endif; ?>
        </div>

        <!-- Glass QR Code -->
        <div class="glass-card rounded-[32px] p-6 text-center space-y-3 shadow-xl">
            <h3 class="text-xs font-bold text-gray-300">اسکن کیوآرکد اختصاصی</h3>
            <div class="w-40 h-40 mx-auto p-3 bg-white/90 backdrop-blur rounded-2xl flex items-center justify-center">
                <img src="<?= $qrCodeDataUri ?>" alt="QR" class="w-full h-full object-contain">
            </div>
            <p class="text-[10px] text-gray-400 font-mono"><?= \App\Core\Helper::e($profileUrl) ?></p>
        </div>

    </div>

    <footer class="text-center py-6 text-xs text-gray-400 relative z-10 space-y-1">
        <a href="<?= \App\Core\Helper::url() ?>" target="_blank" class="hover:text-white transition-colors">
            CIPCard Smart NFC Experience
        </a>
        <p class="text-[11px] text-gray-400">Designed for VIP & Business Leaders by <a href="https://rastin.ir" target="_blank" rel="noopener" class="text-cyan-400 hover:underline font-bold">rastin.ir</a></p>
    </footer>
    <script>lucide.createIcons();</script>
</body>
</html>
