<!-- Floating Top Nav: Theme Toggle & 6-Language Selector -->
<div class="fixed top-4 inset-x-4 max-w-md mx-auto z-50 flex items-center justify-between pointer-events-none">
    <!-- Theme Toggle -->
    <div class="pointer-events-auto">
        <button type="button" onclick="toggleCardTheme()" class="px-3.5 py-1.5 rounded-full border shadow-md text-xs font-bold flex items-center gap-1.5 transition-all backdrop-blur-md" style="background-color: var(--card, #121217); color: var(--text-main, #fff); border-color: var(--border, rgba(255,255,255,0.15));">
            <i id="theme-btn-icon" data-lucide="<?= ($themeMode ?? 'light') === 'light' ? 'sun' : 'moon' ?>" class="w-3.5 h-3.5" style="color: var(--primary, #D4AF37);"></i>
            <span id="theme-btn-text"><?= ($themeMode ?? 'light') === 'light' ? ($currentLang === 'fa' ? 'تم روشن' : 'Light') : ($currentLang === 'fa' ? 'تم تیره' : 'Dark') ?></span>
        </button>
    </div>

    <!-- 6-Language Selector Dropdown Pill -->
    <div class="relative pointer-events-auto">
        <button type="button" onclick="toggleLangMenu()" class="px-3.5 py-1.5 rounded-full border shadow-md text-xs font-bold flex items-center gap-1.5 transition-all backdrop-blur-md" style="background-color: var(--card, #121217); color: var(--text-main, #fff); border-color: var(--border, rgba(255,255,255,0.15));">
            <span class="text-sm"><?= $supportedLangs[$currentLang]['flag'] ?? '🌐' ?></span>
            <span class="uppercase font-mono text-[11px]"><?= $currentLang ?></span>
            <i data-lucide="chevron-down" class="w-3 h-3 opacity-60"></i>
        </button>

        <div id="langDropdown" class="hidden absolute left-0 mt-2 w-44 rounded-2xl border shadow-2xl p-1.5 space-y-1 backdrop-blur-xl z-50" style="background-color: var(--card, #121217); border-color: var(--border, rgba(255,255,255,0.2));">
            <?php foreach ($supportedLangs as $code => $info): ?>
                <?php
                $active = ($code === $currentLang);
                $url = '?lang=' . $code;
                ?>
                <a href="<?= $url ?>" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium transition-all <?= $active ? 'font-bold' : 'hover:opacity-80' ?>" style="<?= $active ? 'background: var(--box-bg, rgba(255,255,255,0.1)); color: var(--primary, #D4AF37);' : 'color: var(--text-main, #fff);' ?>">
                    <span class="flex items-center gap-2">
                        <span class="text-base"><?= $info['flag'] ?></span>
                        <span><?= $info['name'] ?></span>
                    </span>
                    <span class="text-[10px] uppercase font-mono text-gray-400"><?= $code ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
function toggleLangMenu() {
    var dd = document.getElementById('langDropdown');
    if (dd) dd.classList.toggle('hidden');
}
document.addEventListener('click', function(e) {
    var dd = document.getElementById('langDropdown');
    if (dd && !e.target.closest('.relative.pointer-events-auto')) {
        dd.classList.add('hidden');
    }
});
</script>
