<?php
// Featured In-Page Showcase Image Partial
$featuredImageUrl = trim((string)($profile['featured_image_url'] ?? ''));
$featuredTitle = trim((string)($profile['featured_image_title'] ?? ''));
if ($featuredTitle === '') {
    $featuredTitle = $translations['featured_image'] ?? ($currentLang === 'fa' ? 'تصویر معرفی و نمونه‌کار' : 'Featured Showcase');
}
?>
<?php if ($featuredImageUrl !== ''): ?>
    <div class="rounded-3xl p-5 sm:p-7 border space-y-4 transition-all overflow-hidden" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">
        <div class="flex items-center justify-between">
            <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wider flex items-center gap-2.5" style="color: var(--text-main);">
                <span class="w-8 h-8 rounded-xl flex items-center justify-center border" style="background-color: var(--box-bg); border-color: var(--border); color: var(--primary);">
                    <i data-lucide="image" class="w-4 h-4"></i>
                </span>
                <span><?= \App\Core\Helper::e($featuredTitle) ?></span>
            </h3>

            <a href="<?= \App\Core\Helper::url($featuredImageUrl) ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border text-[11px] font-bold transition-all hover:brightness-110" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-sub);">
                <i data-lucide="maximize-2" class="w-3.5 h-3.5"></i>
                <span><?= $currentLang === 'fa' ? 'اندازه کامل' : 'Full Size' ?></span>
            </a>
        </div>

        <div class="relative w-full rounded-2xl overflow-hidden border group bg-black/5" style="border-color: var(--border);">
            <a href="<?= \App\Core\Helper::url($featuredImageUrl) ?>" target="_blank" rel="noopener" class="block w-full cursor-zoom-in">
                <img src="<?= \App\Core\Helper::url($featuredImageUrl) ?>" 
                     alt="<?= \App\Core\Helper::e($featuredTitle) ?>" 
                     loading="lazy"
                     class="w-full h-auto max-h-[500px] object-cover sm:object-contain rounded-2xl group-hover:scale-[1.01] transition-transform duration-300 mx-auto">
            </a>
        </div>
    </div>
<?php endif; ?>
