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
    <div class="rounded-3xl p-6 border space-y-4 transition-all" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">
        <h3 class="text-xs font-bold uppercase tracking-wider flex items-center gap-2" style="color: var(--text-sub);">
            <i data-lucide="share-2" class="w-4 h-4" style="color: var(--primary);"></i>
            <span><?= \App\Core\Helper::e($translations['social_networks'] ?? 'شبکه‌های اجتماعی و پیام‌رسان‌ها') ?></span>
        </h3>

        <div class="space-y-2.5">
            <?php foreach ($activeSocials as $key => $item): ?>
                <?php
                $name = ($currentLang === 'fa') ? $item['meta']['name_fa'] : $item['meta']['name_en'];
                $cleanHandle = ltrim($item['val'], '@');
                ?>
                <a href="<?= \App\Core\Helper::e($item['url']) ?>" target="_blank" rel="noopener" class="flex items-center justify-between p-3.5 rounded-xl border hover:brightness-105 active:scale-[0.99] transition-all text-xs font-medium" style="background-color: var(--box-bg); border-color: var(--border);">
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-lg flex items-center justify-center flex-shrink-0" style="color: <?= $item['meta']['color'] ?>;">
                            <?= SocialService::getIconSvg($key, 'w-5 h-5') ?>
                        </span>
                        <span class="font-bold" style="color: var(--text-main);"><?= $name ?></span>
                    </div>

                    <div class="flex items-center gap-1.5 font-mono text-[11px] opacity-70" style="color: var(--text-sub);">
                        <span class="truncate max-w-[140px]"><?= \App\Core\Helper::e($cleanHandle) ?></span>
                        <i data-lucide="<?= $langDir === 'rtl' ? 'arrow-left' : 'arrow-right' ?>" class="w-3.5 h-3.5"></i>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
