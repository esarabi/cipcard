<?php
// Template 4: Creative Dark & Neon
$theme = $profile['theme_color'] ?? 'gold_black';
$palettes = [
    'gold_black'   => ['neon' => '#FACC15', 'shadow' => 'rgba(250, 204, 21, 0.4)', 'accent' => '#FEF08A'],
    'blue_white'   => ['neon' => '#38BDF8', 'shadow' => 'rgba(56, 189, 248, 0.4)', 'accent' => '#BAE6FD'],
    'emerald_gray' => ['neon' => '#34D399', 'shadow' => 'rgba(52, 211, 153, 0.4)', 'accent' => '#A7F3D0']
];
$colors = $palettes[$theme] ?? $palettes['gold_black'];
$social = $profile['social_links'] ?? [];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \App\Core\Helper::e($profile['display_name']) ?> - Creative Profile</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { background-color: #030305; font-family: 'Vazirmatn', sans-serif; }
        .neon-border {
            border: 1px solid <?= $colors['neon'] ?>;
            box-shadow: 0 0 15px <?= $colors['shadow'] ?>;
        }
        .neon-text {
            color: <?= $colors['neon'] ?>;
            text-shadow: 0 0 10px <?= $colors['shadow'] ?>;
        }
    </style>
</head>
<body class="text-gray-100 min-h-screen flex flex-col justify-between p-4 sm:p-6">
    <div class="max-w-md w-full mx-auto space-y-6 pt-6">
        
        <!-- Neon Card -->
        <div class="bg-[#0B0B10] rounded-[32px] p-6 sm:p-8 neon-border relative overflow-hidden space-y-5">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 rounded-2xl overflow-hidden border-2" style="border-color: <?= $colors['neon'] ?>;">
                    <?php if (!empty($profile['avatar_url'])): ?>
                        <img src="<?= \App\Core\Helper::url($profile['avatar_url']) ?>" alt="Avatar" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-2xl font-bold bg-black neon-text">
                            <?= mb_substr($profile['display_name'], 0, 1) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="space-y-1">
                    <h1 class="text-xl font-black text-white"><?= \App\Core\Helper::e($profile['display_name']) ?></h1>
                    <p class="text-xs font-mono neon-text">&lt;<?= \App\Core\Helper::e($profile['job_title'] ?: 'Creative Technologist') ?> /&gt;</p>
                    <?php if (!empty($profile['company'])): ?>
                        <p class="text-[11px] text-gray-400 font-mono">@<?= \App\Core\Helper::e($profile['company']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($profile['bio'])): ?>
                <p class="text-xs text-gray-300 leading-relaxed font-mono bg-black/40 p-3 rounded-xl border border-gray-800">
                    <?= nl2br(\App\Core\Helper::e($profile['bio'])) ?>
                </p>
            <?php endif; ?>

            <a href="<?= \App\Core\Helper::url('vcard/@' . $profile['mobile']) ?>" class="w-full py-3.5 rounded-xl font-black text-xs text-black flex items-center justify-center gap-2 shadow-xl hover:brightness-125 transition-all" style="background-color: <?= $colors['neon'] ?>;">
                <i data-lucide="terminal" class="w-4 h-4"></i>
                <span>SAVE_CONTACT.VCF</span>
            </a>

            <!-- Social and Creative Links Grid -->
            <div class="grid grid-cols-2 gap-3 pt-2">
                <?php if (!empty($social['github'])): ?>
                    <a href="https://github.com/<?= ltrim(\App\Core\Helper::e($social['github']), '@') ?>" target="_blank" class="p-3 rounded-xl bg-black/60 border border-gray-800 hover:border-gray-600 transition-all flex items-center gap-2 text-xs">
                        <i data-lucide="github" class="w-4 h-4 text-white"></i>
                        <span class="font-mono text-gray-300">GitHub</span>
                    </a>
                <?php endif; ?>

                <?php if (!empty($social['instagram'])): ?>
                    <a href="https://instagram.com/<?= ltrim(\App\Core\Helper::e($social['instagram']), '@') ?>" target="_blank" class="p-3 rounded-xl bg-black/60 border border-gray-800 hover:border-pink-500/50 transition-all flex items-center gap-2 text-xs">
                        <i data-lucide="instagram" class="w-4 h-4 text-pink-400"></i>
                        <span class="text-gray-300">Instagram</span>
                    </a>
                <?php endif; ?>

                <?php if (!empty($social['telegram'])): ?>
                    <a href="https://t.me/<?= ltrim(\App\Core\Helper::e($social['telegram']), '@') ?>" target="_blank" class="p-3 rounded-xl bg-black/60 border border-gray-800 hover:border-sky-500/50 transition-all flex items-center gap-2 text-xs">
                        <i data-lucide="send" class="w-4 h-4 text-sky-400"></i>
                        <span class="text-gray-300">Telegram</span>
                    </a>
                <?php endif; ?>

                <?php if (!empty($profile['website'])): ?>
                    <a href="<?= \App\Core\Helper::e($profile['website']) ?>" target="_blank" class="p-3 rounded-xl bg-black/60 border border-gray-800 hover:border-amber-400/50 transition-all flex items-center gap-2 text-xs">
                        <i data-lucide="globe" class="w-4 h-4 text-amber-400"></i>
                        <span class="text-gray-300">Website</span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- QR Module -->
            <div class="pt-4 border-t border-gray-800 text-center space-y-2">
                <div class="w-36 h-36 mx-auto p-2 bg-white rounded-xl shadow-lg">
                    <img src="<?= $qrCodeDataUri ?>" alt="QR" class="w-full h-full object-contain">
                </div>
                <span class="text-[10px] font-mono text-gray-500">CIPCard v2.0 // NFC_TOKEN</span>
            </div>
        </div>

    </div>

    <footer class="text-center py-6 text-[11px] font-mono text-gray-600">
        POWERED BY CIPCARD.IR
    </footer>
    <script>lucide.createIcons();</script>
</body>
</html>
