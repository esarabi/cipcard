<?php
// Template 5: Modern Card (3D Flip Physical Business Card Experience)
$theme = $profile['theme_color'] ?? 'gold_black';
$palettes = [
    'gold_black'   => ['primary' => '#D4AF37', 'cardBg' => 'linear-gradient(135deg, #1f1f28 0%, #0d0d12 100%)', 'border' => '#D4AF37'],
    'blue_white'   => ['primary' => '#38BDF8', 'cardBg' => 'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)', 'border' => '#38BDF8'],
    'emerald_gray' => ['primary' => '#10B981', 'cardBg' => 'linear-gradient(135deg, #064e3b 0%, #061e16 100%)', 'border' => '#10B981']
];
$colors = $palettes[$theme] ?? $palettes['gold_black'];
$social = $profile['social_links'] ?? [];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \App\Core\Helper::e($profile['display_name']) ?> - کارت ویزیت فیزیکی هوشمند</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { background-color: #060608; font-family: 'Vazirmatn', sans-serif; }
        .perspective-card { perspective: 1200px; }
        .card-inner {
            transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transform-style: preserve-3d;
        }
        .card-inner.flipped { transform: rotateY(180deg); }
        .card-front, .card-back {
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }
        .card-back { transform: rotateY(180deg); }
    </style>
</head>
<body class="text-gray-100 min-h-screen flex flex-col justify-between p-4 sm:p-6">
    <div class="max-w-md w-full mx-auto space-y-6 pt-4">
        
        <div class="text-center space-y-1">
            <span class="text-xs font-mono tracking-widest text-gray-400 uppercase">DIGITAL TWIN OF PHYSICAL CARD</span>
            <p class="text-xs text-gray-500">برای چرخش کارت روی دکمه چرخش یا خود کارت کلیک کنید.</p>
        </div>

        <!-- 3D Interactive Physical Card -->
        <div class="perspective-card w-full h-[250px] sm:h-[270px] cursor-pointer" onclick="toggleCardFlip()">
            <div id="physical-card" class="card-inner relative w-full h-full">
                
                <!-- FRONT OF CARD -->
                <div class="card-front absolute inset-0 rounded-3xl p-6 sm:p-7 border-2 shadow-2xl flex flex-col justify-between" style="background: <?= $colors['cardBg'] ?>; border-color: <?= $colors['border'] ?>;">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-2">
                            <i data-lucide="nfc" class="w-6 h-6" style="color: <?= $colors['primary'] ?>;"></i>
                            <span class="text-[10px] font-mono tracking-widest text-gray-300 uppercase">CIP NFC CONTACTLESS</span>
                        </div>
                        <span class="text-lg font-black font-mono tracking-wider text-white">CIP<span style="color: <?= $colors['primary'] ?>;">CARD</span></span>
                    </div>

                    <!-- Chip & User Identity -->
                    <div class="flex items-center gap-4">
                        <div class="w-11 h-8 rounded-md bg-gradient-to-tr from-amber-600 to-amber-300 p-0.5 shadow-inner">
                            <div class="w-full h-full bg-[#15151c] rounded-[3px] border border-amber-400/40 grid grid-cols-2 gap-0.5 p-1"></div>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-white"><?= \App\Core\Helper::e($profile['display_name']) ?></h2>
                            <p class="text-xs font-semibold" style="color: <?= $colors['primary'] ?>;"><?= \App\Core\Helper::e($profile['job_title'] ?: 'مدیر ارشد') ?></p>
                        </div>
                    </div>

                    <div class="flex justify-between items-end border-t border-white/10 pt-3">
                        <span class="text-[11px] text-gray-400"><?= \App\Core\Helper::e($profile['company'] ?: 'CIPCard Member') ?></span>
                        <div class="flex items-center gap-1 text-[11px] font-bold text-gray-300">
                            <i data-lucide="rotate-cw" class="w-3.5 h-3.5 text-gray-400"></i>
                            <span>مشاهده پشت کارت</span>
                        </div>
                    </div>
                </div>

                <!-- BACK OF CARD -->
                <div class="card-back absolute inset-0 rounded-3xl p-6 sm:p-7 border-2 shadow-2xl flex items-center justify-between" style="background: <?= $colors['cardBg'] ?>; border-color: <?= $colors['border'] ?>;">
                    <div class="w-32 h-32 p-2 bg-white rounded-2xl flex items-center justify-center shadow-lg">
                        <img src="<?= $qrCodeDataUri ?>" alt="QR" class="w-full h-full object-contain">
                    </div>

                    <div class="flex-1 pr-6 space-y-2 text-right">
                        <span class="text-[10px] font-mono text-gray-400 block">SCAN TO CONNECT</span>
                        <p class="text-xs text-white font-mono"><?= \App\Core\Helper::e($profile['phone_mobile'] ?: $profile['mobile']) ?></p>
                        <?php if (!empty($profile['email'])): ?>
                            <p class="text-[11px] text-gray-300 truncate font-mono"><?= \App\Core\Helper::e($profile['email']) ?></p>
                        <?php endif; ?>
                        <div class="pt-2">
                            <span class="text-[9px] px-2 py-1 rounded bg-white/10 text-gray-300 font-mono">cipcard.ir/@<?= $profile['mobile'] ?></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3 pt-2">
            <a href="<?= \App\Core\Helper::url('vcard/@' . $profile['mobile']) ?>" class="w-full py-4 rounded-2xl font-black text-sm text-black flex items-center justify-center gap-2 shadow-xl hover:brightness-110 active:scale-95 transition-all" style="background-color: <?= $colors['primary'] ?>;">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
                <span>ذخیره مستقیم در گوشی (Save Contact)</span>
            </a>

            <?php if (!empty($profile['phone_mobile'])): ?>
                <a href="tel:<?= \App\Core\Helper::e($profile['phone_mobile']) ?>" class="w-full py-3 rounded-xl bg-white/5 border border-white/10 hover:border-white/30 text-xs font-semibold flex items-center justify-center gap-2 transition-all">
                    <i data-lucide="phone" class="w-4 h-4" style="color: <?= $colors['primary'] ?>;"></i>
                    <span>تماس سریع تلفنی</span>
                </a>
            <?php endif; ?>

            <?php if (!empty($social['whatsapp'])): ?>
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $social['whatsapp']) ?>" target="_blank" class="w-full py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-semibold flex items-center justify-center gap-2 transition-all">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>ارسال پیام در واتساپ</span>
                </a>
            <?php endif; ?>
        </div>

    </div>

    <footer class="text-center py-6 text-xs text-gray-500">
        CIPCard 3D Interactive Card
    </footer>

    <script>
        lucide.createIcons();
        function toggleCardFlip() {
            document.getElementById('physical-card').classList.toggle('flipped');
        }
    </script>
</body>
</html>
