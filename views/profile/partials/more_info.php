<?php
// Collapsible Extended Description ("توضیحات بیشتر") with Smooth Fade & Down Arrow Toggle
$moreInfoText = trim((string)($profile['more_info'] ?? ''));
$moreInfoTitle = trim((string)($profile['more_info_title'] ?? ''));
if ($moreInfoTitle === '') {
    $moreInfoTitle = $translations['more_info'] ?? 'توضیحات بیشتر';
}
?>
<?php if ($moreInfoText !== ''): ?>
    <div class="rounded-3xl p-6 sm:p-7 border space-y-4 transition-all" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">
        <div class="flex items-center justify-between">
            <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wider flex items-center gap-2.5" style="color: var(--text-main);">
                <span class="w-8 h-8 rounded-xl flex items-center justify-center border" style="background-color: var(--box-bg); border-color: var(--border); color: var(--primary);">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                </span>
                <span><?= \App\Core\Helper::e($moreInfoTitle) ?></span>
            </h3>
        </div>

        <div class="relative">
            <!-- Collapsible Text Container -->
            <div id="more-info-body"
                 data-expanded="false"
                 class="text-xs sm:text-sm leading-7 overflow-hidden transition-[max-height,mask-image,-webkit-mask-image] duration-500 ease-in-out"
                 style="color: var(--text-sub); max-height: 5.5rem; -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 45%, rgba(0,0,0,0) 100%); mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 45%, rgba(0,0,0,0) 100%);">
                <div id="more-info-inner" class="whitespace-pre-line break-words">
                    <?= nl2br(\App\Core\Helper::e($moreInfoText)) ?>
                </div>
            </div>

            <!-- Toggle Button with Down/Up Arrow -->
            <div id="more-info-toggle-wrap" class="pt-3 flex justify-center">
                <button type="button"
                        id="more-info-toggle-btn"
                        onclick="toggleMoreInfoBox()"
                        class="group inline-flex items-center gap-2 px-5 py-2.5 rounded-full border text-xs font-bold transition-all hover:brightness-110 active:scale-95 shadow-sm"
                        style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-main);">
                    <span id="more-info-toggle-label"><?= \App\Core\Helper::e($translations['read_more'] ?? 'مشاهده کامل توضیحات') ?></span>
                    <span id="more-info-arrow-wrap" class="w-5 h-5 rounded-full flex items-center justify-center transition-transform duration-300" style="background-color: var(--card); color: var(--primary);">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <script>
    (function() {
        function initMoreInfoBox() {
            var body = document.getElementById('more-info-body');
            var inner = document.getElementById('more-info-inner');
            var wrap = document.getElementById('more-info-toggle-wrap');
            if (!body || !inner || !wrap) return;

            // If text is short (fits within ~88px), remove fade mask and hide expand button
            if (inner.scrollHeight <= 96) {
                body.style.maxHeight = 'none';
                body.style.webkitMaskImage = 'none';
                body.style.maskImage = 'none';
                wrap.style.display = 'none';
            }
        }

        window.toggleMoreInfoBox = function() {
            var body = document.getElementById('more-info-body');
            var inner = document.getElementById('more-info-inner');
            var label = document.getElementById('more-info-toggle-label');
            var arrow = document.getElementById('more-info-arrow-wrap');
            if (!body || !inner) return;

            var isExpanded = body.getAttribute('data-expanded') === 'true';
            var readMoreText = <?= json_encode($translations['read_more'] ?? 'مشاهده کامل توضیحات', JSON_UNESCAPED_UNICODE) ?>;
            var readLessText = <?= json_encode($translations['read_less'] ?? 'بستن توضیحات', JSON_UNESCAPED_UNICODE) ?>;

            if (!isExpanded) {
                body.style.maxHeight = (inner.scrollHeight + 32) + 'px';
                body.style.webkitMaskImage = 'none';
                body.style.maskImage = 'none';
                body.setAttribute('data-expanded', 'true');
                if (label) label.textContent = readLessText;
                if (arrow) arrow.style.transform = 'rotate(180deg)';
            } else {
                body.style.maxHeight = '5.5rem';
                body.style.webkitMaskImage = 'linear-gradient(to bottom, rgba(0,0,0,1) 45%, rgba(0,0,0,0) 100%)';
                body.style.maskImage = 'linear-gradient(to bottom, rgba(0,0,0,1) 45%, rgba(0,0,0,0) 100%)';
                body.setAttribute('data-expanded', 'false');
                if (label) label.textContent = readMoreText;
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initMoreInfoBox);
        } else {
            initMoreInfoBox();
        }
    })();
    </script>
<?php endif; ?>
