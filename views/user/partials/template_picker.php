<?php
/**
 * Reusable Template, Theme Mode & Color Palette Selector Component
 * Used in edit_profile.php and dashboard.php
 */
$currentTemplate = $profile['template_id'] ?? 'minimal';
$currentMode     = $profile['theme_mode'] ?? 'light';
$currentTheme    = $profile['theme_color'] ?? 'gold_black';

$tplOptions = [
    'minimal' => [
        'id'    => 'minimal',
        'title' => 'مینیمال و لوکس',
        'sub'   => 'Minimal & Luxury',
        'desc'  => 'مشکی و طلایی لوکس VIP، مینیمال، فوق‌العاده شیک و مدرن',
        'badge' => 'پیش‌فرض VIP',
        'icon'  => 'sparkles'
    ],
    'glassmorphism' => [
        'id'    => 'glassmorphism',
        'title' => 'شیشه‌ای و بلور',
        'sub'   => 'Glassmorphism',
        'desc'  => 'افکت مات شیشه‌ای و مدرن با عمق سه‌بعدی و جلوه‌های شفاف',
        'badge' => 'مدرن',
        'icon'  => 'layers'
    ],
    'corporate' => [
        'id'    => 'corporate',
        'title' => 'شرکتی و رسمی',
        'sub'   => 'Corporate Pro',
        'desc'  => 'طراحی ساختاریافته ویژه هلدینگ‌ها، مدیران، پزشکان و وکلا',
        'badge' => 'رسمی و اداری',
        'icon'  => 'building-2'
    ],
    'creative_dark' => [
        'id'    => 'creative_dark',
        'title' => 'خلاقانه نئون',
        'sub'   => 'Creative Neon',
        'desc'  => 'استارتاپی، دارک و های‌تک با نوارهای نورانی و جلوه‌های نئونی',
        'badge' => 'استارتاپی',
        'icon'  => 'zap'
    ],
    'modern_card' => [
        'id'    => 'modern_card',
        'title' => 'کارت ویزیت ۳بعدی',
        'sub'   => '3D Card Flip',
        'desc'  => 'شبیه‌ساز سه‌بعدی کارت فیزیکی با قابلیت لمس و چرخش ۱۸۰ درجه',
        'badge' => 'چرخش ۳بعدی',
        'icon'  => 'credit-card'
    ]
];
?>

<div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-gold/40 space-y-6 shadow-xl">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-400 border border-amber-500/30 flex items-center justify-center">
            <i data-lucide="palette" class="w-5 h-5"></i>
        </div>
        <div>
            <h3 class="text-sm font-bold text-white">انتخاب قالب و پالت رنگی کارت ویزیت هوشمند</h3>
            <p class="text-xs text-gray-400">قالب ظاهری، حالت تم روشن یا تیره و پالت رنگی کارت ویزیت خود را به دلخواه انتخاب کنید.</p>
        </div>
    </div>

    <!-- 1. Template Cards (5 Distinct Templates) -->
    <div class="space-y-2">
        <label class="block text-xs font-bold text-gray-300">
            ۱. انتخاب یکی از ۵ قالب اختصاصی و واکنش‌گرا:
        </label>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5 pt-1">
            <?php foreach ($tplOptions as $key => $opt): ?>
                <?php $isSelected = ($currentTemplate === $key); ?>
                <label id="tpl-card-<?= $key ?>" 
                       onclick="selectTemplateOption('<?= $key ?>')" 
                       class="template-card relative p-4 rounded-2xl border cursor-pointer transition-all flex flex-col justify-between gap-3 <?= $isSelected ? 'bg-amber-500/10 border-amber-400 shadow-md shadow-amber-500/10' : 'bg-brand-darker border-brand-border/60 hover:border-gray-500' ?>">
                    <input type="radio" name="template_id" value="<?= $key ?>" <?= $isSelected ? 'checked' : '' ?> class="sr-only">
                    
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-white flex items-center gap-1.5">
                                <i data-lucide="<?= $opt['icon'] ?>" class="w-4 h-4 text-amber-500"></i>
                                <span><?= $opt['title'] ?></span>
                            </span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full font-mono font-bold bg-brand-surface border border-brand-border/60 text-amber-400">
                                <?= $opt['badge'] ?>
                            </span>
                        </div>
                        <p class="text-[11px] text-gray-400 leading-relaxed"><?= $opt['desc'] ?></p>
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-brand-border/30 text-[10px]">
                        <span class="font-mono text-gray-500"><?= $opt['sub'] ?></span>
                        <div id="tpl-check-<?= $key ?>" class="tpl-check flex items-center gap-1 font-bold text-amber-400 <?= $isSelected ? '' : 'hidden' ?>">
                            <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                            <span>فعال</span>
                        </div>
                    </div>
                </label>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- 2. Theme Mode Selector (Light vs Dark) -->
    <div class="pt-4 border-t border-brand-border/40 space-y-3">
        <label class="block text-xs font-bold text-gray-300">
            ۲. حالت پیش‌فرض نمایش (تم روشن / تم تیره):
        </label>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <label id="mode-card-light" 
                   onclick="selectThemeMode('light')" 
                   class="theme-mode-card p-4 rounded-2xl border cursor-pointer flex items-center justify-between transition-all <?= $currentMode === 'light' ? 'bg-amber-500/10 border-amber-400 shadow-md' : 'bg-brand-darker border-brand-border' ?>">
                <div class="flex items-center gap-3">
                    <input type="radio" name="theme_mode" value="light" <?= $currentMode === 'light' ? 'checked' : '' ?> class="sr-only">
                    <div class="w-9 h-9 rounded-xl bg-amber-500/20 text-amber-500 flex items-center justify-center">
                        <i data-lucide="sun" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-white">تم روشن (Light Mode)</span>
                        <span class="text-[11px] text-gray-400">پس‌زمینه سفید، تمیز و خوانایی بالا در محیط‌های پرنور</span>
                    </div>
                </div>
                <div id="mode-check-light" class="mode-check text-amber-400 <?= $currentMode === 'light' ? '' : 'hidden' ?>">
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                </div>
            </label>

            <label id="mode-card-dark" 
                   onclick="selectThemeMode('dark')" 
                   class="theme-mode-card p-4 rounded-2xl border cursor-pointer flex items-center justify-between transition-all <?= $currentMode === 'dark' ? 'bg-amber-500/10 border-amber-400 shadow-md' : 'bg-brand-darker border-brand-border' ?>">
                <div class="flex items-center gap-3">
                    <input type="radio" name="theme_mode" value="dark" <?= $currentMode === 'dark' ? 'checked' : '' ?> class="sr-only">
                    <div class="w-9 h-9 rounded-xl bg-sky-500/20 text-sky-400 flex items-center justify-center">
                        <i data-lucide="moon" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-white">تم تیره (Dark Mode)</span>
                        <span class="text-[11px] text-gray-400">مشکی متالیک لوکس و مدرن برای محیط‌های کم‌نور</span>
                    </div>
                </div>
                <div id="mode-check-dark" class="mode-check text-amber-400 <?= $currentMode === 'dark' ? '' : 'hidden' ?>">
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                </div>
            </label>
        </div>
    </div>

    <!-- 3. Color Palette Selector -->
    <div class="pt-4 border-t border-brand-border/40 space-y-3">
        <label class="block text-xs font-bold text-gray-300">
            ۳. پالت رنگی سازمانی و تزئینی کارت:
        </label>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <!-- Gold - Black -->
            <label id="palette-card-gold_black" 
                   onclick="selectPaletteColor('gold_black')" 
                   class="palette-card p-3.5 rounded-2xl border cursor-pointer flex items-center justify-between transition-all <?= $currentTheme === 'gold_black' ? 'bg-amber-500/10 border-amber-400 shadow-md' : 'bg-brand-darker border-brand-border' ?>">
                <div class="flex items-center gap-3">
                    <input type="radio" name="theme_color" value="gold_black" <?= $currentTheme === 'gold_black' ? 'checked' : '' ?> class="sr-only">
                    <div class="flex items-center -space-x-1">
                        <span class="w-5 h-5 rounded-full bg-[#D4AF37] border-2 border-black inline-block z-10"></span>
                        <span class="w-5 h-5 rounded-full bg-[#1c1917] border-2 border-black inline-block"></span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-white">طلایی - مشکی VIP</span>
                        <span class="text-[10px] text-gray-400 font-mono">Gold & Black</span>
                    </div>
                </div>
                <div id="palette-check-gold_black" class="palette-check text-amber-400 <?= $currentTheme === 'gold_black' ? '' : 'hidden' ?>">
                    <i data-lucide="check" class="w-4 h-4"></i>
                </div>
            </label>

            <!-- Blue - Navy -->
            <label id="palette-card-blue_white" 
                   onclick="selectPaletteColor('blue_white')" 
                   class="palette-card p-3.5 rounded-2xl border cursor-pointer flex items-center justify-between transition-all <?= $currentTheme === 'blue_white' ? 'bg-amber-500/10 border-amber-400 shadow-md' : 'bg-brand-darker border-brand-border' ?>">
                <div class="flex items-center gap-3">
                    <input type="radio" name="theme_color" value="blue_white" <?= $currentTheme === 'blue_white' ? 'checked' : '' ?> class="sr-only">
                    <div class="flex items-center -space-x-1">
                        <span class="w-5 h-5 rounded-full bg-[#0284C7] border-2 border-black inline-block z-10"></span>
                        <span class="w-5 h-5 rounded-full bg-[#0F172A] border-2 border-black inline-block"></span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-white">آبی - سرمه‌ای</span>
                        <span class="text-[10px] text-gray-400 font-mono">Blue & Navy</span>
                    </div>
                </div>
                <div id="palette-check-blue_white" class="palette-check text-amber-400 <?= $currentTheme === 'blue_white' ? '' : 'hidden' ?>">
                    <i data-lucide="check" class="w-4 h-4"></i>
                </div>
            </label>

            <!-- Emerald - Gray -->
            <label id="palette-card-emerald_gray" 
                   onclick="selectPaletteColor('emerald_gray')" 
                   class="palette-card p-3.5 rounded-2xl border cursor-pointer flex items-center justify-between transition-all <?= $currentTheme === 'emerald_gray' ? 'bg-amber-500/10 border-amber-400 shadow-md' : 'bg-brand-darker border-brand-border' ?>">
                <div class="flex items-center gap-3">
                    <input type="radio" name="theme_color" value="emerald_gray" <?= $currentTheme === 'emerald_gray' ? 'checked' : '' ?> class="sr-only">
                    <div class="flex items-center -space-x-1">
                        <span class="w-5 h-5 rounded-full bg-[#059669] border-2 border-black inline-block z-10"></span>
                        <span class="w-5 h-5 rounded-full bg-[#1F2937] border-2 border-black inline-block"></span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-white">سبز زمردی - طوسی</span>
                        <span class="text-[10px] text-gray-400 font-mono">Emerald Green</span>
                    </div>
                </div>
                <div id="palette-check-emerald_gray" class="palette-check text-amber-400 <?= $currentTheme === 'emerald_gray' ? '' : 'hidden' ?>">
                    <i data-lucide="check" class="w-4 h-4"></i>
                </div>
            </label>
        </div>
    </div>
</div>

<script>
function selectTemplateOption(key) {
    document.querySelectorAll('.template-card').forEach(function(card) {
        card.classList.remove('bg-amber-500/10', 'border-amber-400', 'shadow-md', 'shadow-amber-500/10');
        card.classList.add('bg-brand-darker', 'border-brand-border/60');
    });
    document.querySelectorAll('.tpl-check').forEach(function(ch) {
        ch.classList.add('hidden');
    });

    var card = document.getElementById('tpl-card-' + key);
    var check = document.getElementById('tpl-check-' + key);
    if (card) {
        card.classList.remove('bg-brand-darker', 'border-brand-border/60');
        card.classList.add('bg-amber-500/10', 'border-amber-400', 'shadow-md', 'shadow-amber-500/10');
        var radio = card.querySelector('input[type="radio"]');
        if (radio) radio.checked = true;
    }
    if (check) check.classList.remove('hidden');
    if (window.lucide) lucide.createIcons();
}

function selectThemeMode(mode) {
    document.querySelectorAll('.theme-mode-card').forEach(function(card) {
        card.classList.remove('bg-amber-500/10', 'border-amber-400', 'shadow-md');
        card.classList.add('bg-brand-darker', 'border-brand-border');
    });
    document.querySelectorAll('.mode-check').forEach(function(ch) {
        ch.classList.add('hidden');
    });

    var card = document.getElementById('mode-card-' + mode);
    var check = document.getElementById('mode-check-' + mode);
    if (card) {
        card.classList.remove('bg-brand-darker', 'border-brand-border');
        card.classList.add('bg-amber-500/10', 'border-amber-400', 'shadow-md');
        var radio = card.querySelector('input[type="radio"]');
        if (radio) radio.checked = true;
    }
    if (check) check.classList.remove('hidden');
    if (window.lucide) lucide.createIcons();
}

function selectPaletteColor(color) {
    document.querySelectorAll('.palette-card').forEach(function(card) {
        card.classList.remove('bg-amber-500/10', 'border-amber-400', 'shadow-md');
        card.classList.add('bg-brand-darker', 'border-brand-border');
    });
    document.querySelectorAll('.palette-check').forEach(function(ch) {
        ch.classList.add('hidden');
    });

    var card = document.getElementById('palette-card-' + color);
    var check = document.getElementById('palette-check-' + color);
    if (card) {
        card.classList.remove('bg-brand-darker', 'border-brand-border');
        card.classList.add('bg-amber-500/10', 'border-amber-400', 'shadow-md');
        var radio = card.querySelector('input[type="radio"]');
        if (radio) radio.checked = true;
    }
    if (check) check.classList.remove('hidden');
    if (window.lucide) lucide.createIcons();
}
</script>
