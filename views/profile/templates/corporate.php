<?php
// Template 3: Corporate Pro
$theme = $profile['theme_color'] ?? 'gold_black';
$palettes = [
    'gold_black'   => ['primary' => '#B45309', 'headerBg' => '#1C1917', 'bg' => '#0C0A09', 'badge' => '#D97706'],
    'blue_white'   => ['primary' => '#1D4ED8', 'headerBg' => '#1E293B', 'bg' => '#0F172A', 'badge' => '#3B82F6'],
    'emerald_gray' => ['primary' => '#047857', 'headerBg' => '#064E3B', 'bg' => '#022C22', 'badge' => '#10B981']
];
$colors = $palettes[$theme] ?? $palettes['gold_black'];
$social = $profile['social_links'] ?? [];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \App\Core\Helper::e($profile['display_name']) ?> - پروفایل رسمی</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { background-color: <?= $colors['bg'] ?>; font-family: 'Vazirmatn', sans-serif; }
    </style>
</head>
<body class="text-gray-100 min-h-screen flex flex-col justify-between p-4 sm:p-6">
    <div class="max-w-md w-full mx-auto bg-[#18181b] rounded-3xl overflow-hidden border border-gray-800 shadow-2xl">
        
        <!-- Corporate Header Banner -->
        <div class="p-8 text-center relative border-b border-gray-800" style="background-color: <?= $colors['headerBg'] ?>;">
            <div class="w-24 h-24 mx-auto rounded-2xl p-1 bg-black/40 border-2 shadow-lg mb-4" style="border-color: <?= $colors['badge'] ?>;">
                <?php if (!empty($profile['avatar_url'])): ?>
                    <img src="<?= \App\Core\Helper::url($profile['avatar_url']) ?>" alt="Avatar" class="w-full h-full object-cover rounded-xl">
                <?php else: ?>
                    <div class="w-full h-full rounded-xl flex items-center justify-center text-2xl font-bold text-white bg-black/30">
                        <?= mb_substr($profile['display_name'], 0, 1) ?>
                    </div>
                <?php endif; ?>
            </div>

            <h1 class="text-2xl font-black text-white"><?= \App\Core\Helper::e($profile['display_name']) ?></h1>
            <span class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-bold text-white tracking-wide" style="background-color: <?= $colors['primary'] ?>;">
                <?= \App\Core\Helper::e($profile['job_title'] ?: 'مدیر ارشد') ?>
            </span>
            <?php if (!empty($profile['company'])): ?>
                <p class="text-xs text-gray-300 mt-2"><?= \App\Core\Helper::e($profile['company']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Body Section -->
        <div class="p-6 space-y-6">
            <?php if (!empty($profile['bio'])): ?>
                <div class="p-4 rounded-xl bg-black/30 border border-gray-800 text-xs text-gray-300 leading-relaxed">
                    <?= nl2br(\App\Core\Helper::e($profile['bio'])) ?>
                </div>
            <?php endif; ?>

            <a href="<?= \App\Core\Helper::url('vcard/@' . $profile['mobile']) ?>" class="w-full py-3.5 rounded-xl font-bold text-sm text-white flex items-center justify-center gap-2 shadow-lg hover:brightness-110 active:scale-95 transition-all" style="background-color: <?= $colors['badge'] ?>;">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>افزودن به دفترچه تلفن مخاطبان</span>
            </a>

            <!-- Corporate Structured Info -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold uppercase text-gray-400 border-r-2 pr-2" style="border-color: <?= $colors['badge'] ?>;">مشخصات ارتباطی</h4>
                
                <?php if (!empty($profile['phone_mobile'])): ?>
                    <a href="tel:<?= \App\Core\Helper::e($profile['phone_mobile']) ?>" class="flex items-center justify-between p-3 rounded-xl bg-black/20 hover:bg-black/40 transition-all text-xs border border-gray-800">
                        <span class="text-gray-400">تلفن همراه:</span>
                        <span class="font-mono text-white"><?= \App\Core\Helper::e($profile['phone_mobile']) ?></span>
                    </a>
                <?php endif; ?>

                <?php if (!empty($profile['phone_work'])): ?>
                    <a href="tel:<?= \App\Core\Helper::e($profile['phone_work']) ?>" class="flex items-center justify-between p-3 rounded-xl bg-black/20 hover:bg-black/40 transition-all text-xs border border-gray-800">
                        <span class="text-gray-400">تلفن محل کار:</span>
                        <span class="font-mono text-white"><?= \App\Core\Helper::e($profile['phone_work']) ?></span>
                    </a>
                <?php endif; ?>

                <?php if (!empty($profile['email'])): ?>
                    <a href="mailto:<?= \App\Core\Helper::e($profile['email']) ?>" class="flex items-center justify-between p-3 rounded-xl bg-black/20 hover:bg-black/40 transition-all text-xs border border-gray-800">
                        <span class="text-gray-400">ایمیل سازمانی:</span>
                        <span class="text-white"><?= \App\Core\Helper::e($profile['email']) ?></span>
                    </a>
                <?php endif; ?>

                <?php if (!empty($profile['address'])): ?>
                    <div class="p-3 rounded-xl bg-black/20 text-xs border border-gray-800 space-y-1">
                        <span class="text-gray-400">آدرس:</span>
                        <p class="text-gray-200"><?= \App\Core\Helper::e($profile['address']) ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- QR Code -->
            <div class="pt-2 text-center space-y-3">
                <div class="w-36 h-36 mx-auto p-2.5 bg-white rounded-xl shadow-md">
                    <img src="<?= $qrCodeDataUri ?>" alt="QR" class="w-full h-full object-contain">
                </div>
                <span class="text-[10px] text-gray-500 font-mono">شناسه دیجیتال رسمی CIPCard</span>
            </div>
        </div>

    </div>

    <footer class="text-center py-6 text-xs text-gray-500">
        CIPCard Corporate NFC Systems
    </footer>
    <script>lucide.createIcons();</script>
</body>
</html>
