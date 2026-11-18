<!-- CIPCard Brand Footer -->
<footer class="w-full max-w-md lg:max-w-7xl mx-auto px-4 pt-8 pb-6 text-xs transition-all" style="color: var(--text-sub);">
    <div class="pt-6 border-t flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-start" style="border-color: var(--border, rgba(148,163,184,0.2));">
        <a href="<?= \App\Core\Helper::url() ?>" target="_blank" class="font-bold hover:underline transition-colors inline-flex items-center justify-center gap-2" style="color: var(--text-main);">
            <span class="w-6 h-6 rounded-lg flex items-center justify-center border" style="background-color: var(--box-bg); border-color: var(--border); color: var(--primary);">
                <i data-lucide="nfc" class="w-3.5 h-3.5"></i>
            </span>
            <span><?= \App\Core\Helper::e($translations['order_your_card'] ?? 'کارت هوشمند لوکس CIPCard') ?></span>
        </a>
        <p class="text-[11px]">
            <?= $currentLang === 'fa' ? 'طراحی و توسعه توسط' : 'Designed & Developed by' ?>
            <a href="https://rastingroup.ir" target="_blank" rel="noopener" class="font-bold hover:underline" style="color: var(--primary);">
                <?= $currentLang === 'fa' ? 'تیم توسعه هوشمند راستین' : 'Rastin Smart Development Team' ?>
            </a>
        </p>
    </div>
</footer>
