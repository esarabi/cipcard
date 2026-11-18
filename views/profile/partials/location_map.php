<?php
// Interactive Embedded Map & Smart Navigation Partial
$hasLocation = !empty($profile['address']) || !empty($profile['map_link']) || (!empty($profile['map_latitude']) && !empty($profile['map_longitude']));
$lat = !empty($profile['map_latitude']) ? (float)$profile['map_latitude'] : null;
$lng = !empty($profile['map_longitude']) ? (float)$profile['map_longitude'] : null;

// Try extracting coordinates from map_link if lat/lng fields weren't explicitly filled
if ((!$lat || !$lng) && !empty($profile['map_link'])) {
    if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', (string)$profile['map_link'], $m)) {
        $lat = (float)$m[1];
        $lng = (float)$m[2];
    } elseif (preg_match('/[?&](?:q|ll|query|latitude)=(-?\d+\.\d+)(?:,|%2C|&longitude=)(-?\d+\.\d+)/i', (string)$profile['map_link'], $m)) {
        $lat = (float)$m[1];
        $lng = (float)$m[2];
    }
}

$mapEmbedUrl = null;
if ($lat && $lng) {
    $mapEmbedUrl = 'https://maps.google.com/maps?q=' . rawurlencode($lat . ',' . $lng) . '&hl=' . rawurlencode($currentLang ?? 'fa') . '&z=16&output=embed';
} elseif (!empty($profile['address'])) {
    $mapEmbedUrl = 'https://maps.google.com/maps?q=' . rawurlencode((string)$profile['address']) . '&hl=' . rawurlencode($currentLang ?? 'fa') . '&z=15&output=embed';
}
?>
<?php if ($hasLocation): ?>
    <div class="rounded-3xl p-6 sm:p-7 border space-y-4 transition-all h-full flex flex-col justify-between" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">
        <div class="space-y-4">
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-2.5 font-bold text-xs sm:text-sm" style="color: var(--text-main);">
                    <span class="w-8 h-8 rounded-xl flex items-center justify-center border" style="background-color: var(--box-bg); border-color: var(--border); color: var(--primary);">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                    </span>
                    <span><?= \App\Core\Helper::e($translations['location_navigation'] ?? 'موقعیت روی نقشه و مسیریابی') ?></span>
                </div>

                <?php if ($lat && $lng): ?>
                    <span class="text-[10px] font-mono px-2.5 py-1 rounded-full border dir-ltr" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-sub);">
                        <?= number_format($lat, 4) ?>, <?= number_format($lng, 4) ?>
                    </span>
                <?php endif; ?>
            </div>

            <?php if (!empty($profile['address'])): ?>
                <div class="p-3.5 rounded-2xl border text-xs sm:text-sm leading-relaxed flex items-start gap-2.5" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                    <i data-lucide="building-2" class="w-4 h-4 flex-shrink-0 mt-1 opacity-70" style="color: var(--primary);"></i>
                    <span><?= \App\Core\Helper::e($profile['address']) ?></span>
                </div>
            <?php endif; ?>

            <!-- Live Interactive Map Preview (Embedded Map) -->
            <?php if ($mapEmbedUrl): ?>
                <div class="relative w-full h-52 sm:h-60 rounded-2xl overflow-hidden border shadow-inner" style="border-color: var(--border); background-color: var(--box-bg);">
                    <iframe
                        src="<?= \App\Core\Helper::e($mapEmbedUrl) ?>"
                        class="w-full h-full border-0"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        title="<?= \App\Core\Helper::e($profile['display_name'] ?? 'Map Location') ?>">
                    </iframe>
                </div>
            <?php endif; ?>
        </div>

        <!-- Smart Navigation Buttons (Neshan, Balad, Google Maps) -->
        <div class="pt-2">
            <span class="block text-[11px] font-medium mb-2.5" style="color: var(--text-sub);">
                <?= $currentLang === 'fa' ? 'مسیریابی سریع با یک کلیک:' : ($translations['location_navigation'] ?? 'Navigate with:') ?>
            </span>

            <div class="grid grid-cols-3 gap-2.5">
                <?php if ($lat && $lng): ?>
                    <!-- Neshan -->
                    <a href="https://neshan.org/maps/@<?= $lat ?>,<?= $lng ?>,16z" target="_blank" rel="noopener" class="py-3 px-2.5 rounded-2xl text-xs font-bold flex flex-col sm:flex-row items-center justify-center gap-1.5 sm:gap-2 border hover:brightness-105 hover:-translate-y-0.5 active:scale-95 transition-all text-center" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                        <svg class="w-4 h-4 text-sky-400 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        <span class="text-[11px] sm:text-xs"><?= \App\Core\Helper::e($translations['nav_neshan'] ?? 'نشان') ?></span>
                    </a>

                    <!-- Balad -->
                    <a href="https://balad.ir/location?latitude=<?= $lat ?>&longitude=<?= $lng ?>" target="_blank" rel="noopener" class="py-3 px-2.5 rounded-2xl text-xs font-bold flex flex-col sm:flex-row items-center justify-center gap-1.5 sm:gap-2 border hover:brightness-105 hover:-translate-y-0.5 active:scale-95 transition-all text-center" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                        <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="10"/>
                            <path fill="#fff" d="M12 7l4 8H8z"/>
                        </svg>
                        <span class="text-[11px] sm:text-xs"><?= \App\Core\Helper::e($translations['nav_balad'] ?? 'بلد') ?></span>
                    </a>

                    <!-- Google Maps -->
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?= $lat ?>,<?= $lng ?>" target="_blank" rel="noopener" class="py-3 px-2.5 rounded-2xl text-xs font-bold flex flex-col sm:flex-row items-center justify-center gap-1.5 sm:gap-2 border hover:brightness-105 hover:-translate-y-0.5 active:scale-95 transition-all text-center" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C7.589 2 4 5.589 4 9.995 4 15.672 11.233 21.57 11.541 21.82a.75.75 0 0 0 .918 0c.308-.25 7.541-6.148 7.541-11.825C20 5.589 16.411 2 12 2zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                        </svg>
                        <span class="text-[11px] sm:text-xs"><?= \App\Core\Helper::e($translations['nav_google'] ?? 'گوگل مپس') ?></span>
                    </a>
                <?php elseif (!empty($profile['map_link'])): ?>
                    <a href="<?= \App\Core\Helper::e($profile['map_link']) ?>" target="_blank" rel="noopener" class="col-span-3 py-3.5 px-4 rounded-2xl text-xs font-bold flex items-center justify-center gap-2 border hover:brightness-105 transition-all" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                        <i data-lucide="navigation" class="w-4 h-4" style="color: var(--primary);"></i>
                        <span><?= \App\Core\Helper::e($translations['location_navigation'] ?? 'مشاهده روی نقشه') ?></span>
                    </a>
                <?php else: ?>
                    <a href="https://maps.google.com/?q=<?= urlencode((string)$profile['address']) ?>" target="_blank" rel="noopener" class="col-span-3 py-3.5 px-4 rounded-2xl text-xs font-bold flex items-center justify-center gap-2 border hover:brightness-105 transition-all" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                        <i data-lucide="map" class="w-4 h-4" style="color: var(--primary);"></i>
                        <span><?= \App\Core\Helper::e($translations['nav_google'] ?? 'مسیریابی با گوگل مپ') ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
