<!-- CIPCard Brand Footer -->
<footer class="text-center py-8 text-xs space-y-1.5 transition-all" style="color: var(--text-sub);">
    <a href="<?= \App\Core\Helper::url() ?>" target="_blank" class="font-bold hover:underline transition-colors inline-flex items-center justify-center gap-1.5" style="color: var(--text-main);">
        <i data-lucide="nfc" class="w-4 h-4" style="color: var(--primary);"></i>
        <span><?= \App\Core\Helper::e($translations['order_your_card'] ?? 'کارت هوشمند لوکس CIPCard') ?></span>
    </a>
    <p class="text-[11px]">
        <?= $currentLang === 'fa' ? 'طراحی و توسعه توسط' : 'Designed & Developed by' ?>
        <a href="https://rastingroup.ir" target="_blank" rel="noopener" class="font-bold hover:underline" style="color: var(--primary);">
            <?= $currentLang === 'fa' ? 'تیم توسعه هوشمند راستین' : 'Rastin Smart Development Team' ?>
        </a>
    </p>
</footer>
