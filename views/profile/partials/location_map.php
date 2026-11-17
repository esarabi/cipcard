<?php
// Interactive Map & Smart Navigation Partial
$hasLocation = !empty($profile['address']) || !empty($profile['map_link']) || (!empty($profile['map_latitude']) && !empty($profile['map_longitude']));
$lat = !empty($profile['map_latitude']) ? (float)$profile['map_latitude'] : null;
$lng = !empty($profile['map_longitude']) ? (float)$profile['map_longitude'] : null;
?>
<?php if ($hasLocation): ?>
    <div class="rounded-3xl p-6 border space-y-4 transition-all" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">
        <div class="flex items-center gap-2.5 font-bold text-xs" style="color: var(--primary);">
            <i data-lucide="map-pin" class="w-4 h-4"></i>
            <span><?= \App\Core\Helper::e($translations['location_navigation'] ?? 'موقعیت روی نقشه و مسیریابی') ?></span>
        </div>

        <?php if (!empty($profile['address'])): ?>
            <p class="text-xs leading-relaxed" style="color: var(--text-main);">
                <?= \App\Core\Helper::e($profile['address']) ?>
            </p>
        <?php endif; ?>

        <!-- Smart Navigation Buttons (Neshan, Balad, Google Maps) -->
        <div class="pt-1">
            <span class="block text-[11px] font-medium mb-2.5" style="color: var(--text-sub);">
                <?= $currentLang === 'fa' ? 'مسیریابی سریع با یک کلیک:' : ($translations['location_navigation'] ?? 'Navigate with:') ?>
            </span>

            <div class="grid grid-cols-3 gap-2">
                <?php if ($lat && $lng): ?>
                    <!-- Neshan -->
                    <a href="https://neshan.org/maps/@<?= $lat ?>,<?= $lng ?>,16z" target="_blank" rel="noopener" class="py-2.5 px-2 rounded-xl text-xs font-bold flex flex-col items-center justify-center gap-1.5 border hover:brightness-105 active:scale-95 transition-all text-center" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                        <svg class="w-4 h-4 text-sky-400" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        <span class="text-[11px]"><?= \App\Core\Helper::e($translations['nav_neshan'] ?? 'نشان') ?></span>
                    </a>

                    <!-- Balad -->
                    <a href="https://balad.ir/location?latitude=<?= $lat ?>&longitude=<?= $lng ?>" target="_blank" rel="noopener" class="py-2.5 px-2 rounded-xl text-xs font-bold flex flex-col items-center justify-center gap-1.5 border hover:brightness-105 active:scale-95 transition-all text-center" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                        <svg class="w-4 h-4 text-emerald-400" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="10"/>
                            <path fill="#fff" d="M12 7l4 8H8z"/>
                        </svg>
                        <span class="text-[11px]"><?= \App\Core\Helper::e($translations['nav_balad'] ?? 'بلد') ?></span>
                    </a>

                    <!-- Google Maps -->
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?= $lat ?>,<?= $lng ?>" target="_blank" rel="noopener" class="py-2.5 px-2 rounded-xl text-xs font-bold flex flex-col items-center justify-center gap-1.5 border hover:brightness-105 active:scale-95 transition-all text-center" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                        <svg class="w-4 h-4 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C7.589 2 4 5.589 4 9.995 4 15.672 11.233 21.57 11.541 21.82a.75.75 0 0 0 .918 0c.308-.25 7.541-6.148 7.541-11.825C20 5.589 16.411 2 12 2zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                        </svg>
                        <span class="text-[11px]"><?= \App\Core\Helper::e($translations['nav_google'] ?? 'گوگل مپس') ?></span>
                    </a>
                <?php elseif (!empty($profile['map_link'])): ?>
                    <a href="<?= \App\Core\Helper::e($profile['map_link']) ?>" target="_blank" rel="noopener" class="col-span-3 py-3 px-4 rounded-xl text-xs font-bold flex items-center justify-center gap-2 border hover:brightness-105 transition-all" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                        <i data-lucide="navigation" class="w-4 h-4" style="color: var(--primary);"></i>
                        <span><?= \App\Core\Helper::e($translations['location_navigation'] ?? 'مشاهده روی نقشه') ?></span>
                    </a>
                <?php else: ?>
                    <a href="https://maps.google.com/?q=<?= urlencode($profile['address']) ?>" target="_blank" rel="noopener" class="col-span-3 py-3 px-4 rounded-xl text-xs font-bold flex items-center justify-center gap-2 border hover:brightness-105 transition-all" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                        <i data-lucide="map" class="w-4 h-4" style="color: var(--primary);"></i>
                        <span><?= \App\Core\Helper::e($translations['nav_google'] ?? 'مسیریابی با گوگل مپ') ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
