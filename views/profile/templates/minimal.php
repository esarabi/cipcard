<?php
// Template 1: Minimal Luxury
$theme = $profile['theme_color'] ?? 'gold_black';
$palettes = [
    'gold_black'   => ['primary' => '#D4AF37', 'bg' => '#0A0A0C', 'card' => '#121217', 'text' => '#F3E5AB', 'border' => 'rgba(212, 175, 55, 0.3)'],
    'blue_white'   => ['primary' => '#38BDF8', 'bg' => '#080E1A', 'card' => '#0F172A', 'text' => '#E0F2FE', 'border' => 'rgba(56, 189, 248, 0.3)'],
    'emerald_gray' => ['primary' => '#10B981', 'bg' => '#06130D', 'card' => '#0C1E16', 'text' => '#D1FAE5', 'border' => 'rgba(16, 185, 129, 0.3)']
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
        :root {
            --primary: <?= $colors['primary'] ?>;
            --bg: <?= $colors['bg'] ?>;
            --card: <?= $colors['card'] ?>;
            --text-accent: <?= $colors['text'] ?>;
            --border: <?= $colors['border'] ?>;
        }
        body { background-color: var(--bg); font-family: 'Vazirmatn', sans-serif; }
    </style>
</head>
<body class="text-gray-100 min-h-screen flex flex-col justify-between p-4 sm:p-6 selection:bg-[var(--primary)] selection:text-black">

    <div class="max-w-md w-full mx-auto space-y-6 pt-6">
        
        <!-- Header Card -->
        <div class="relative rounded-3xl p-6 sm:p-8 text-center space-y-5 border shadow-2xl transition-all" style="background-color: var(--card); border-color: var(--border);">
            
            <!-- Avatar -->
            <div class="relative w-28 h-28 mx-auto">
                <div class="w-full h-full rounded-full p-1 border-2" style="border-color: var(--primary);">
                    <?php if (!empty($profile['avatar_url'])): ?>
                        <img src="<?= \App\Core\Helper::url($profile['avatar_url']) ?>" alt="<?= \App\Core\Helper::e($profile['display_name']) ?>" class="w-full h-full object-cover rounded-full">
                    <?php else: ?>
                        <div class="w-full h-full rounded-full flex items-center justify-center text-3xl font-bold uppercase" style="background-color: var(--bg); color: var(--primary);">
                            <?= mb_substr($profile['display_name'], 0, 1) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="absolute bottom-1 right-1 w-6 h-6 rounded-full bg-emerald-500 border-2 border-[var(--card)] flex items-center justify-center text-black" title="تایید شده">
                    <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3]"></i>
                </div>
            </div>

            <!-- Identity -->
            <div class="space-y-1">
                <h1 class="text-2xl font-black text-white"><?= \App\Core\Helper::e($profile['display_name']) ?></h1>
                <?php if (!empty($profile['job_title'])): ?>
                    <p class="text-sm font-semibold" style="color: var(--primary);"><?= \App\Core\Helper::e($profile['job_title']) ?></p>
                <?php endif; ?>
                <?php if (!empty($profile['company'])): ?>
                    <p class="text-xs text-gray-400"><?= \App\Core\Helper::e($profile['company']) ?></p>
                <?php endif; ?>
            </div>

            <?php if (!empty($profile['bio'])): ?>
                <p class="text-xs text-gray-300 leading-relaxed pt-2 border-t border-gray-800">
                    <?= nl2br(\App\Core\Helper::e($profile['bio'])) ?>
                </p>
            <?php endif; ?>

            <!-- Direct Actions: vCard & Call -->
            <div class="pt-4 flex flex-col gap-3">
                <a href="<?= \App\Core\Helper::url('vcard/@' . $profile['mobile']) ?>" class="w-full py-4 rounded-2xl font-black text-sm text-black flex items-center justify-center gap-2 shadow-xl hover:brightness-110 active:scale-95 transition-all" style="background: linear-gradient(135deg, var(--text-accent), var(--primary));">
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                    <span>ذخیره در مخاطبین (Save Contact)</span>
                </a>

                <div class="grid grid-cols-2 gap-3">
                    <?php if (!empty($profile['phone_mobile'])): ?>
                        <a href="tel:<?= \App\Core\Helper::e($profile['phone_mobile']) ?>" class="py-3 px-4 rounded-xl text-xs font-semibold flex items-center justify-center gap-2 border hover:brightness-125 transition-all text-white" style="background-color: rgba(255,255,255,0.04); border-color: var(--border);">
                            <i data-lucide="phone-call" class="w-4 h-4" style="color: var(--primary);"></i>
                            <span>تماس مستقیم</span>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($social['whatsapp'])): ?>
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $social['whatsapp']) ?>" target="_blank" class="py-3 px-4 rounded-xl text-xs font-semibold flex items-center justify-center gap-2 border hover:brightness-125 transition-all text-white" style="background-color: rgba(255,255,255,0.04); border-color: var(--border);">
                            <i data-lucide="message-circle" class="w-4 h-4 text-emerald-400"></i>
                            <span>واتساپ</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <!-- Social & Contact Links Card -->
        <div class="rounded-3xl p-6 border space-y-4 shadow-xl" style="background-color: var(--card); border-color: var(--border);">
            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400">راه‌های ارتباطی</h3>
            
            <div class="space-y-2.5">
                <?php if (!empty($profile['email'])): ?>
                    <a href="mailto:<?= \App\Core\Helper::e($profile['email']) ?>" class="flex items-center justify-between p-3.5 rounded-xl border bg-black/20 hover:border-[var(--primary)] transition-all text-sm">
                        <div class="flex items-center gap-3">
                            <i data-lucide="mail" class="w-4 h-4" style="color: var(--primary);"></i>
                            <span class="text-xs text-gray-200"><?= \App\Core\Helper::e($profile['email']) ?></span>
                        </div>
                        <i data-lucide="chevron-left" class="w-4 h-4 text-gray-500"></i>
                    </a>
                <?php endif; ?>

                <?php if (!empty($social['instagram'])): ?>
                    <a href="https://instagram.com/<?= ltrim(\App\Core\Helper::e($social['instagram']), '@') ?>" target="_blank" class="flex items-center justify-between p-3.5 rounded-xl border bg-black/20 hover:border-pink-500/50 transition-all text-sm">
                        <div class="flex items-center gap-3">
                            <i data-lucide="instagram" class="w-4 h-4 text-pink-400"></i>
                            <span class="text-xs text-gray-200">اینستاگرام</span>
                        </div>
                        <span class="text-xs font-mono text-gray-400">@<?= ltrim(\App\Core\Helper::e($social['instagram']), '@') ?></span>
                    </a>
                <?php endif; ?>

                <?php if (!empty($social['telegram'])): ?>
                    <a href="https://t.me/<?= ltrim(\App\Core\Helper::e($social['telegram']), '@') ?>" target="_blank" class="flex items-center justify-between p-3.5 rounded-xl border bg-black/20 hover:border-sky-500/50 transition-all text-sm">
                        <div class="flex items-center gap-3">
                            <i data-lucide="send" class="w-4 h-4 text-sky-400"></i>
                            <span class="text-xs text-gray-200">کانال یا آیدی تلگرام</span>
                        </div>
                        <i data-lucide="external-link" class="w-4 h-4 text-gray-500"></i>
                    </a>
                <?php endif; ?>

                <?php if (!empty($profile['website'])): ?>
                    <a href="<?= \App\Core\Helper::e($profile['website']) ?>" target="_blank" class="flex items-center justify-between p-3.5 rounded-xl border bg-black/20 hover:border-[var(--primary)] transition-all text-sm">
                        <div class="flex items-center gap-3">
                            <i data-lucide="globe" class="w-4 h-4" style="color: var(--primary);"></i>
                            <span class="text-xs text-gray-200">وب‌سایت رسمی</span>
                        </div>
                        <i data-lucide="external-link" class="w-4 h-4 text-gray-500"></i>
                    </a>
                <?php endif; ?>

                <?php if (!empty($profile['address'])): ?>
                    <div class="p-3.5 rounded-xl border bg-black/20 text-xs text-gray-300 space-y-2">
                        <div class="flex items-center gap-2 font-bold" style="color: var(--primary);">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            <span>نشانی دفتر یا محل کار:</span>
                        </div>
                        <p class="leading-relaxed text-gray-300"><?= \App\Core\Helper::e($profile['address']) ?></p>
                        <a href="https://maps.google.com/?q=<?= urlencode($profile['address']) ?>" target="_blank" class="inline-flex items-center gap-1 text-[11px] hover:underline" style="color: var(--primary);">
                            <span>مسیریابی روی نقشه</span>
                            <i data-lucide="arrow-left" class="w-3 h-3"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="rounded-3xl p-6 border text-center space-y-4 shadow-xl" style="background-color: var(--card); border-color: var(--border);">
            <div class="space-y-1">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-300">اسکن مستقیم بارکد QR</h3>
                <p class="text-[11px] text-gray-400">اسکن با دوربین گوشی جهت مشاهده یا اشتراک‌گذاری سریع</p>
            </div>
            
            <div class="w-44 h-44 mx-auto p-3 bg-white rounded-2xl shadow-inner flex items-center justify-center">
                <img src="<?= $qrCodeDataUri ?>" alt="QR Code" class="w-full h-full object-contain">
            </div>

            <span class="block text-[11px] font-mono text-gray-400"><?= \App\Core\Helper::e($profileUrl) ?></span>
        </div>

    </div>

    <!-- CIPCard Brand Footer -->
    <footer class="text-center py-6 text-xs text-gray-500 space-y-1">
        <a href="<?= \App\Core\Helper::url() ?>" target="_blank" class="font-bold hover:text-gray-300 transition-colors flex items-center justify-center gap-1.5">
            <i data-lucide="nfc" class="w-4 h-4" style="color: var(--primary);"></i>
            <span>قدرت گرفته از کارت ویزیت هوشمند <strong class="text-white">CIPCard</strong></span>
        </a>
        <p class="text-[11px] text-gray-400">Designed for VIP & Business Leaders by <a href="https://rastin.ir" target="_blank" rel="noopener" class="text-amber-400 hover:underline font-bold">rastin.ir</a></p>
    </footer>

    <script>lucide.createIcons();</script>
</body>
</html>
