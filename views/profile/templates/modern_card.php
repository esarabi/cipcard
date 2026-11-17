<?php
// Template 5: Modern Card (3D Flip Physical Business Card Experience)
$theme = $profile['theme_color'] ?? 'gold_black';
$themeMode = $profile['theme_mode'] ?? 'light';

$darkPalettes = [
    'gold_black'   => [
        'primary' => '#D4AF37',
        'pageBg' => '#09090b',
        'cardBg' => 'linear-gradient(135deg, #1c1917 0%, #0c0a09 100%)',
        'border' => '#D4AF37',
        'cardText' => '#FFFFFF',
        'cardSub' => '#D1D5DB',
        'actionBg' => 'rgba(255,255,255,0.05)',
        'actionBorder' => 'rgba(255,255,255,0.12)',
        'actionText' => '#F3F4F6'
    ],
    'blue_white'   => [
        'primary' => '#38BDF8',
        'pageBg' => '#0B0F19',
        'cardBg' => 'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)',
        'border' => '#38BDF8',
        'cardText' => '#FFFFFF',
        'cardSub' => '#94A3B8',
        'actionBg' => 'rgba(255,255,255,0.05)',
        'actionBorder' => 'rgba(255,255,255,0.12)',
        'actionText' => '#F3F4F6'
    ],
    'emerald_gray' => [
        'primary' => '#10B981',
        'pageBg' => '#06130E',
        'cardBg' => 'linear-gradient(135deg, #064e3b 0%, #061e16 100%)',
        'border' => '#10B981',
        'cardText' => '#FFFFFF',
        'cardSub' => '#A7F3D0',
        'actionBg' => 'rgba(255,255,255,0.05)',
        'actionBorder' => 'rgba(255,255,255,0.12)',
        'actionText' => '#F3F4F6'
    ]
];

$lightPalettes = [
    'gold_black'   => [
        'primary' => '#B8860B',
        'pageBg' => '#F8FAFC',
        'cardBg' => 'linear-gradient(135deg, #FFFFFF 0%, #FFFBEB 100%)',
        'border' => '#D4AF37',
        'cardText' => '#1E293B',
        'cardSub' => '#64748B',
        'actionBg' => '#FFFFFF',
        'actionBorder' => '#E2E8F0',
        'actionText' => '#1E293B'
    ],
    'blue_white'   => [
        'primary' => '#0284C7',
        'pageBg' => '#F8FAFC',
        'cardBg' => 'linear-gradient(135deg, #FFFFFF 0%, #F0F9FF 100%)',
        'border' => '#0284C7',
        'cardText' => '#0F172A',
        'cardSub' => '#64748B',
        'actionBg' => '#FFFFFF',
        'actionBorder' => '#E2E8F0',
        'actionText' => '#1E293B'
    ],
    'emerald_gray' => [
        'primary' => '#059669',
        'pageBg' => '#F8FAFC',
        'cardBg' => 'linear-gradient(135deg, #FFFFFF 0%, #ECFDF5 100%)',
        'border' => '#059669',
        'cardText' => '#064E3B',
        'cardSub' => '#64748B',
        'actionBg' => '#FFFFFF',
        'actionBorder' => '#E2E8F0',
        'actionText' => '#1E293B'
    ]
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
    <title><?= \App\Core\Helper::e($profile['display_name']) ?> - کارت ویزیت هوشمند CIP</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        html[data-theme="dark"] {
            --page-bg: <?= $dColors['pageBg'] ?>;
            --card-bg: <?= $dColors['cardBg'] ?>;
            --primary: <?= $dColors['primary'] ?>;
            --border: <?= $dColors['border'] ?>;
            --card-text: <?= $dColors['cardText'] ?>;
            --card-sub: <?= $dColors['cardSub'] ?>;
            --action-bg: <?= $dColors['actionBg'] ?>;
            --action-border: <?= $dColors['actionBorder'] ?>;
            --action-text: <?= $dColors['actionText'] ?>;
            --chip-bg: #1c1917;
            --shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
        }

        html[data-theme="light"] {
            --page-bg: <?= $lColors['pageBg'] ?>;
            --card-bg: <?= $lColors['cardBg'] ?>;
            --primary: <?= $lColors['primary'] ?>;
            --border: <?= $lColors['border'] ?>;
            --card-text: <?= $lColors['cardText'] ?>;
            --card-sub: <?= $lColors['cardSub'] ?>;
            --action-bg: <?= $lColors['actionBg'] ?>;
            --action-border: <?= $lColors['actionBorder'] ?>;
            --action-text: <?= $lColors['actionText'] ?>;
            --chip-bg: #fef3c7;
            --shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.12);
        }

        body { 
            background-color: var(--page-bg); 
            color: var(--action-text);
            font-family: 'Vazirmatn', sans-serif;
            transition: background-color 0.25s;
        }

        .perspective-card { perspective: 1200px; }
        .card-inner {
            transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transform-style: preserve-3d;
        }
        .card-inner.flipped { transform: rotateY(180deg); }
        .card-front, .card-back {
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            box-shadow: var(--shadow);
        }
        .card-back { transform: rotateY(180deg); }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between p-4 sm:p-6">

    <!-- Floating Theme Switcher -->
    <div class="fixed top-4 left-4 z-50">
        <button type="button" onclick="toggleModernCardTheme()" class="px-3.5 py-1.5 rounded-full border shadow-md text-xs font-bold flex items-center gap-1.5 transition-all" style="background-color: var(--action-bg); color: var(--action-text); border-color: var(--action-border);">
            <i id="theme-btn-icon" data-lucide="<?= $themeMode === 'light' ? 'sun' : 'moon' ?>" class="w-3.5 h-3.5" style="color: var(--primary);"></i>
            <span id="theme-btn-text"><?= $themeMode === 'light' ? 'تم روشن' : 'تم تیره' ?></span>
        </button>
    </div>

    <div class="max-w-md w-full mx-auto space-y-6 pt-4">
        
        <div class="text-center space-y-1">
            <span class="text-xs font-mono tracking-widest uppercase font-bold" style="color: var(--primary);">DIGITAL TWIN OF PHYSICAL CARD</span>
            <p class="text-xs" style="color: var(--card-sub);">برای چرخش کارت روی دکمه چرخش یا خود کارت کلیک کنید.</p>
        </div>

        <!-- 3D Interactive Physical Card -->
        <div class="perspective-card w-full h-[255px] sm:h-[275px] cursor-pointer" onclick="toggleCardFlip()">
            <div id="physical-card" class="card-inner relative w-full h-full">
                
                <!-- FRONT OF CARD -->
                <div class="card-front absolute inset-0 rounded-3xl p-6 sm:p-7 border-2 flex flex-col justify-between transition-all" style="background: var(--card-bg); border-color: var(--border);">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-2">
                            <i data-lucide="nfc" class="w-6 h-6" style="color: var(--primary);"></i>
                            <span class="text-[10px] font-mono tracking-widest uppercase font-bold" style="color: var(--card-sub);">CIP NFC CONTACTLESS</span>
                        </div>
                        <span class="text-lg font-black font-mono tracking-wider" style="color: var(--card-text);">CIP<span style="color: var(--primary);">CARD</span></span>
                    </div>

                    <!-- Chip & User Identity -->
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-9 rounded-md bg-gradient-to-tr from-amber-600 via-amber-400 to-amber-200 p-0.5 shadow-inner flex-shrink-0">
                            <div class="w-full h-full rounded-[3px] border border-amber-400/50 grid grid-cols-2 gap-0.5 p-1" style="background-color: var(--chip-bg);">
                                <div class="border-b border-r border-amber-500/40"></div>
                                <div class="border-b border-amber-500/40"></div>
                                <div class="border-r border-amber-500/40"></div>
                                <div></div>
                            </div>
                        </div>
                        <div class="truncate">
                            <h2 class="text-xl font-black truncate" style="color: var(--card-text);"><?= \App\Core\Helper::e($profile['display_name']) ?></h2>
                            <p class="text-xs font-bold truncate mt-0.5" style="color: var(--primary);"><?= \App\Core\Helper::e($profile['job_title'] ?: 'مدیر ارشد') ?></p>
                        </div>
                    </div>

                    <div class="flex justify-between items-end border-t pt-3" style="border-color: var(--action-border);">
                        <span class="text-[11px] font-medium" style="color: var(--card-sub);"><?= \App\Core\Helper::e($profile['company'] ?: 'CIPCard Member') ?></span>
                        <div class="flex items-center gap-1.5 text-[11px] font-bold" style="color: var(--card-text);">
                            <i data-lucide="rotate-cw" class="w-3.5 h-3.5" style="color: var(--primary);"></i>
                            <span>مشاهده پشت کارت</span>
                        </div>
                    </div>
                </div>

                <!-- BACK OF CARD -->
                <div class="card-back absolute inset-0 rounded-3xl p-6 sm:p-7 border-2 flex items-center justify-between transition-all" style="background: var(--card-bg); border-color: var(--border);">
                    <div class="w-32 h-32 p-2 bg-white rounded-2xl flex items-center justify-center shadow-lg border border-gray-100 flex-shrink-0">
                        <img src="<?= $qrCodeDataUri ?>" alt="QR" class="w-full h-full object-contain">
                    </div>

                    <div class="flex-1 pr-6 space-y-2 text-right">
                        <span class="text-[10px] font-mono block font-bold" style="color: var(--primary);">SCAN TO CONNECT</span>
                        <p class="text-xs font-mono font-bold" style="color: var(--card-text);"><?= \App\Core\Helper::e($profile['phone_mobile'] ?: $profile['mobile']) ?></p>
                        <?php if (!empty($profile['email'])): ?>
                            <p class="text-[11px] truncate font-mono" style="color: var(--card-sub);"><?= \App\Core\Helper::e($profile['email']) ?></p>
                        <?php endif; ?>
                        <div class="pt-2">
                            <span class="text-[9px] px-2.5 py-1 rounded-md font-mono border" style="background-color: var(--action-bg); border-color: var(--action-border); color: var(--card-text);">cipcard.ir/@<?= !empty($profile['slug']) ? $profile['slug'] : $profile['mobile'] ?></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3 pt-2">
            <a href="<?= \App\Core\Helper::url('vcard/@' . (!empty($profile['slug']) ? $profile['slug'] : $profile['mobile'])) ?>" class="w-full py-4 rounded-2xl font-black text-sm text-white flex items-center justify-center gap-2 shadow-xl hover:brightness-105 active:scale-95 transition-all" style="background-color: var(--primary);">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
                <span>ذخیره مستقیم مخاطب (Save Contact)</span>
            </a>

            <?php if (!empty($profile['phone_mobile'])): ?>
                <a href="tel:<?= \App\Core\Helper::e($profile['phone_mobile']) ?>" class="w-full py-3.5 rounded-xl border text-xs font-bold flex items-center justify-center gap-2 shadow-sm hover:scale-[1.01] transition-all" style="background-color: var(--action-bg); border-color: var(--action-border); color: var(--action-text);">
                    <i data-lucide="phone" class="w-4 h-4" style="color: var(--primary);"></i>
                    <span>تماس سریع تلفنی</span>
                </a>
            <?php endif; ?>

            <?php if (!empty($social['whatsapp'])): ?>
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $social['whatsapp']) ?>" target="_blank" class="w-full py-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-xs font-bold flex items-center justify-center gap-2 transition-all">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>ارسال پیام در واتساپ</span>
                </a>
            <?php endif; ?>

            <?php if (!empty($social['telegram'])): ?>
                <a href="https://t.me/<?= ltrim($social['telegram'], '@') ?>" target="_blank" class="w-full py-3.5 rounded-xl bg-sky-500/10 border border-sky-500/30 text-sky-600 dark:text-sky-400 text-xs font-bold flex items-center justify-center gap-2 transition-all">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    <span>ارتباط در تلگرام</span>
                </a>
            <?php endif; ?>

            <?php if (!empty($social['instagram'])): ?>
                <a href="https://instagram.com/<?= ltrim($social['instagram'], '@') ?>" target="_blank" class="w-full py-3.5 rounded-xl bg-pink-500/10 border border-pink-500/30 text-pink-600 dark:text-pink-400 text-xs font-bold flex items-center justify-center gap-2 transition-all">
                    <i data-lucide="instagram" class="w-4 h-4"></i>
                    <span>صفحه اینستاگرام</span>
                </a>
            <?php endif; ?>

            <?php if (!empty($social['website'])): ?>
                <a href="<?= \App\Core\Helper::e($social['website']) ?>" target="_blank" class="w-full py-3.5 rounded-xl border text-xs font-bold flex items-center justify-center gap-2 transition-all" style="background-color: var(--action-bg); border-color: var(--action-border); color: var(--action-text);">
                    <i data-lucide="globe" class="w-4 h-4" style="color: var(--primary);"></i>
                    <span>مشاهده وب‌سایت</span>
                </a>
            <?php endif; ?>
        </div>

    </div>

    <footer class="text-center py-6 text-xs space-y-1" style="color: var(--card-sub);">
        <p class="font-medium">CIPCard 3D Interactive Card</p>
        <p class="text-[11px]">Designed for VIP & Business Leaders by <a href="https://rastingroup.ir" target="_blank" rel="noopener" class="text-emerald-500 hover:underline font-bold">rastingroup.ir</a></p>
    </footer>

    <script>
        lucide.createIcons();
        function toggleCardFlip() {
            document.getElementById('physical-card').classList.toggle('flipped');
        }

        function toggleModernCardTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme') || 'light';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', newTheme);
            
            const btnText = document.getElementById('theme-btn-text');
            const btnIcon = document.getElementById('theme-btn-icon');
            if (btnText && btnIcon) {
                btnText.textContent = newTheme === 'light' ? 'تم روشن' : 'تم تیره';
                btnIcon.setAttribute('data-lucide', newTheme === 'light' ? 'sun' : 'moon');
                lucide.createIcons();
            }
        }
    </script>
</body>
</html>
