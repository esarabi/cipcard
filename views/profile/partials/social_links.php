<?php
use App\Services\SocialService;

$social = $profile['social_links'] ?? [];
$activeSocials = [];
foreach (SocialService::PLATFORMS as $key => $meta) {
    if (!empty($social[$key])) {
        $activeSocials[$key] = [
            'meta' => $meta,
            'url'  => SocialService::formatUrl($key, (string)$social[$key]),
            'val'  => (string)$social[$key]
        ];
    }
}
?>
<?php if (!empty($activeSocials)): ?>
    <div class="rounded-3xl p-6 sm:p-7 border space-y-4 transition-all h-full" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">
        <div class="flex items-center justify-between">
            <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wider flex items-center gap-2" style="color: var(--text-main);">
                <span class="w-8 h-8 rounded-xl flex items-center justify-center border" style="background-color: var(--box-bg); border-color: var(--border); color: var(--primary);">
                    <i data-lucide="share-2" class="w-4 h-4"></i>
                </span>
                <span><?= \App\Core\Helper::e($translations['social_networks'] ?? 'شبکه‌های اجتماعی و پیام‌رسان‌ها') ?></span>
            </h3>
            <span class="text-[11px] font-mono px-2.5 py-0.5 rounded-full border" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-sub);">
                <?= count($activeSocials) ?>
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <?php foreach ($activeSocials as $key => $item): ?>
                <?php
                $name = ($currentLang === 'fa') ? $item['meta']['name_fa'] : $item['meta']['name_en'];
                $cleanHandle = ltrim($item['val'], '@');
                ?>
                <a href="<?= \App\Core\Helper::e($item['url']) ?>" target="_blank" rel="noopener" class="group flex items-center justify-between p-3.5 sm:p-4 rounded-2xl border hover:brightness-105 hover:-translate-y-0.5 active:scale-[0.99] transition-all text-xs font-medium" style="background-color: var(--box-bg); border-color: var(--border);">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm transition-transform group-hover:scale-110" style="background-color: <?= $item['meta']['color'] ?>15; color: <?= $item['meta']['color'] ?>; border: 1px solid <?= $item['meta']['color'] ?>30;">
                            <?= SocialService::getIconSvg($key, 'w-5 h-5') ?>
                        </span>
                        <div class="min-w-0">
                            <span class="font-bold block truncate text-xs sm:text-sm" style="color: var(--text-main);"><?= $name ?></span>
                            <span class="font-mono text-[11px] block truncate opacity-75 dir-ltr text-left" style="color: var(--text-sub);">@<?= \App\Core\Helper::e($cleanHandle) ?></span>
                        </div>
                    </div>

                    <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 opacity-60 group-hover:opacity-100 transition-all" style="color: var(--primary);">
                        <i data-lucide="<?= ($langDir ?? 'rtl') === 'rtl' ? 'arrow-up-left' : 'arrow-up-right' ?>" class="w-4 h-4"></i>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
