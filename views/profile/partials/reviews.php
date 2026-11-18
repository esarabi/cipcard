<?php
// Public NFC Profile Reviews & Star Ratings Partial
// Fully responsive, theme-variable aware, multi-language & AJAX enabled
if (!isset($enableReviews) || !$enableReviews) {
    return;
}

$revList = $reviews ?? [];
$statsData = $reviewStats ?? [
    'total_reviews'  => 0,
    'average_rating' => 5.0,
    'star_counts'    => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0]
];
$profileIdentifier = !empty($profile['slug']) ? $profile['slug'] : $profile['mobile'];
$actionUrl = \App\Core\Helper::url('@' . $profileIdentifier . '/review');
?>

<div id="reviews" class="rounded-3xl p-6 sm:p-7 border space-y-6 transition-all" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">

    <!-- Header & Overall Score Summary -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b pb-5" style="border-color: var(--border);">
        <div class="space-y-1">
            <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wider flex items-center gap-2.5" style="color: var(--text-main);">
                <span class="w-8 h-8 rounded-xl flex items-center justify-center border" style="background-color: var(--box-bg); border-color: var(--border); color: var(--primary);">
                    <i data-lucide="star" class="w-4 h-4 fill-amber-400 text-amber-400"></i>
                </span>
                <span><?= \App\Core\Helper::e($translations['reviews_title'] ?? 'نظرات و امتیازها') ?></span>
            </h3>
            <p class="text-[11px] sm:text-xs" style="color: var(--text-sub);">
                <?= \App\Core\Helper::e($translations['review_pending_note'] ?? 'نظرات پس از تایید توسط صاحب پروفایل نمایش داده می‌شوند.') ?>
            </p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap sm:flex-nowrap">
            <?php if ($statsData['total_reviews'] > 0): ?>
                <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-2xl border whitespace-nowrap flex-shrink-0" style="background-color: var(--box-bg); border-color: var(--border);">
                    <div class="flex items-center text-amber-400">
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400 text-amber-400"></i>
                    </div>
                    <span class="text-sm font-black font-mono" style="color: var(--text-main);"><?= number_format($statsData['average_rating'], 1) ?></span>
                    <span class="text-[11px]" style="color: var(--text-sub);">
                        (<?= $statsData['total_reviews'] ?>)
                    </span>
                </div>
            <?php endif; ?>

            <button type="button" 
                    onclick="toggleReviewForm()" 
                    id="open-review-form-btn"
                    class="px-4 py-2 rounded-2xl font-bold text-xs flex items-center justify-center gap-1.5 whitespace-nowrap flex-shrink-0 shadow-sm transition-all hover:brightness-105 active:scale-95"
                    style="background: linear-gradient(135deg, var(--primary), var(--text-accent, var(--primary))); color: #ffffff;">
                <i data-lucide="message-square-plus" class="w-4 h-4 flex-shrink-0"></i>
                <span class="whitespace-nowrap"><?= \App\Core\Helper::e($translations['submit_review'] ?? 'ثبت نظر و امتیاز') ?></span>
            </button>
        </div>
    </div>

    <!-- Collapsible Review Form -->
    <div id="review-form-container" class="hidden transition-all duration-300">
        <form id="public-review-form" 
              action="<?= $actionUrl ?>" 
              method="POST" 
              onsubmit="handleReviewSubmit(event)" 
              class="p-5 sm:p-6 rounded-2xl border space-y-4" 
              style="background-color: var(--box-bg); border-color: var(--border);">
            
            <input type="hidden" name="profile_identifier" value="<?= \App\Core\Helper::e($profileIdentifier) ?>">

            <!-- Form Title & Close -->
            <div class="flex items-center justify-between pb-3 border-b" style="border-color: var(--border);">
                <span class="text-xs font-bold" style="color: var(--text-main);">
                    <?= \App\Core\Helper::e($translations['submit_review'] ?? 'ثبت نظر و امتیاز شما') ?>
                </span>
                <button type="button" onclick="toggleReviewForm()" class="text-xs p-1 rounded-lg hover:opacity-75" style="color: var(--text-sub);">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Star Rating Input (1 to 5 Stars Interactive) -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold" style="color: var(--text-main);">
                    <?= \App\Core\Helper::e($translations['your_rating'] ?? 'امتیاز شما:') ?>
                </label>
                <div class="flex items-center gap-2">
                    <div id="star-picker" class="flex items-center gap-1 cursor-pointer dir-ltr" style="direction: ltr;">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <button type="button" 
                                    data-star="<?= $i ?>" 
                                    onclick="setRating(<?= $i ?>)" 
                                    onmouseenter="hoverRating(<?= $i ?>)" 
                                    onmouseleave="resetHoverRating()"
                                    class="star-btn p-1 transition-transform hover:scale-125 focus:outline-none">
                                <i data-lucide="star" class="w-6 h-6 star-icon fill-amber-400 text-amber-400"></i>
                            </button>
                        <?php endfor; ?>
                    </div>
                    <span id="rating-label" class="text-xs font-bold px-2 py-0.5 rounded-lg border whitespace-nowrap" style="background-color: var(--card); border-color: var(--border); color: var(--primary);">
                        ۵ از ۵ (عالی)
                    </span>
                    <input type="hidden" id="selected-rating" name="rating" value="5">
                </div>
            </div>

            <!-- Author Inputs Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                <div>
                    <label class="block text-xs font-bold mb-1.5 whitespace-nowrap" style="color: var(--text-main);">
                        <?= \App\Core\Helper::e($translations['your_name'] ?? 'نام و نام خانوادگی') ?> <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="author_name" 
                           required 
                           placeholder="مثال: رضا محمدی" 
                           class="w-full px-3.5 py-2.5 rounded-xl text-xs border focus:outline-none focus:ring-1" 
                           style="background-color: var(--card); border-color: var(--border); color: var(--text-main); --tw-ring-color: var(--primary);">
                </div>

                <div>
                    <label class="block text-xs font-bold mb-1.5 whitespace-nowrap" style="color: var(--text-main);">
                        شماره تماس یا ایمیل <span class="text-[10px] font-normal" style="color: var(--text-sub);">(اختیاری)</span>
                    </label>
                    <input type="text" 
                           name="author_mobile" 
                           placeholder="0912xxxxxxx یا info@email.com" 
                           class="w-full px-3.5 py-2.5 rounded-xl text-xs border focus:outline-none focus:ring-1 dir-ltr text-right" 
                           style="background-color: var(--card); border-color: var(--border); color: var(--text-main); --tw-ring-color: var(--primary);">
                </div>
            </div>

            <!-- Comment Body -->
            <div>
                <label class="block text-xs font-bold mb-1.5 whitespace-nowrap" style="color: var(--text-main);">
                    <?= \App\Core\Helper::e($translations['your_comment'] ?? 'متن نظر شما') ?> <span class="text-red-500">*</span>
                </label>
                <textarea name="comment" 
                          rows="3" 
                          required 
                          placeholder="تجربه همکاری، نظر درباره خدمات یا پیام خود را بنویسید..." 
                          class="w-full px-3.5 py-2.5 rounded-xl text-xs border focus:outline-none focus:ring-1 leading-relaxed" 
                          style="background-color: var(--card); border-color: var(--border); color: var(--text-main); --tw-ring-color: var(--primary);"></textarea>
            </div>

            <!-- Form Status / Response Message -->
            <div id="review-alert-box" class="hidden p-3 rounded-xl text-xs font-semibold"></div>

            <!-- Submit Button Area (Never wraps into multiple lines on mobile) -->
            <div class="flex flex-col-reverse sm:flex-row sm:items-center justify-between gap-3 pt-2">
                <span class="text-[11px] leading-relaxed" style="color: var(--text-sub);">
                    🔒 نظر شما پس از بررسی مدیر نمایش داده خواهد شد.
                </span>
                <button type="submit" 
                        id="review-submit-btn"
                        class="w-full sm:w-auto px-6 py-2.5 rounded-xl font-bold text-xs text-white flex items-center justify-center gap-2 whitespace-nowrap flex-shrink-0 shadow-md hover:brightness-110 active:scale-95 transition-all"
                        style="background: linear-gradient(135deg, var(--primary), var(--text-accent, var(--primary)));">
                    <i data-lucide="send" class="w-4 h-4 flex-shrink-0"></i>
                    <span id="review-submit-label" class="whitespace-nowrap">ارسال نظر</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Approved Reviews List -->
    <?php if (empty($revList)): ?>
        <div class="p-8 text-center rounded-2xl border space-y-2" style="background-color: var(--box-bg); border-color: var(--border);">
            <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto" style="background-color: var(--card); color: var(--primary);">
                <i data-lucide="message-square" class="w-6 h-6"></i>
            </div>
            <p class="text-xs font-medium" style="color: var(--text-sub);">
                <?= \App\Core\Helper::e($translations['no_reviews_yet'] ?? 'هنوز نظری ثبت نشده است. اولین نفری باشید که نظر خود را ثبت می‌کنید!') ?>
            </p>
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($revList as $r): ?>
                <?php $rRating = max(1, min(5, (int)$r['rating'])); ?>
                <div class="p-4 sm:p-5 rounded-2xl border space-y-3 transition-all" style="background-color: var(--box-bg); border-color: var(--border);">
                    
                    <!-- Review Author & Stars -->
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center font-black text-xs border" style="background-color: var(--card); border-color: var(--border); color: var(--primary);">
                                <?= mb_substr($r['author_name'], 0, 1) ?>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold" style="color: var(--text-main);"><?= \App\Core\Helper::e($r['author_name']) ?></h4>
                                <span class="text-[10px] font-mono" style="color: var(--text-sub);"><?= substr($r['created_at'], 0, 10) ?></span>
                            </div>
                        </div>

                        <!-- Filled Stars -->
                        <div class="flex items-center gap-0.5" style="direction: ltr;">
                            <?php for ($s = 1; $s <= 5; $s++): ?>
                                <i data-lucide="star" class="w-3.5 h-3.5 <?= $s <= $rRating ? 'fill-amber-400 text-amber-400' : 'text-gray-300 dark:text-gray-600' ?>"></i>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <!-- Comment Body -->
                    <p class="text-xs leading-relaxed whitespace-pre-line" style="color: var(--text-sub);">
                        <?= nl2br(\App\Core\Helper::e($r['comment'])) ?>
                    </p>

                    <!-- Owner Reply (If provided) -->
                    <?php if (!empty($r['owner_reply'])): ?>
                        <div class="mr-3 sm:mr-5 p-3.5 rounded-xl border space-y-1.5" style="background-color: var(--card); border-color: var(--border);">
                            <div class="flex items-center gap-1.5 text-[11px] font-bold" style="color: var(--primary);">
                                <i data-lucide="corner-down-left" class="w-3.5 h-3.5"></i>
                                <span><?= \App\Core\Helper::e($translations['owner_reply'] ?? 'پاسخ مدیریت') ?> (<?= \App\Core\Helper::e($profile['display_name']) ?>):</span>
                            </div>
                            <p class="text-xs leading-relaxed pr-2 border-r-2" style="color: var(--text-main); border-color: var(--primary);">
                                <?= nl2br(\App\Core\Helper::e($r['owner_reply'])) ?>
                            </p>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<script>
(function() {
    var currentRating = 5;
    var ratingLabels = {
        1: '۱ از ۵ (ضعیف)',
        2: '۲ از ۵ (متوسط)',
        3: '۳ از ۵ (خوب)',
        4: '۴ از ۵ (خیلی خوب)',
        5: '۵ از ۵ (عالی)'
    };

    window.toggleReviewForm = function() {
        var container = document.getElementById('review-form-container');
        if (container) {
            container.classList.toggle('hidden');
            if (!container.classList.contains('hidden')) {
                container.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }
    };

    window.setRating = function(rating) {
        currentRating = rating;
        document.getElementById('selected-rating').value = rating;
        updateStarVisuals(rating);
        var lbl = document.getElementById('rating-label');
        if (lbl && ratingLabels[rating]) {
            lbl.textContent = ratingLabels[rating];
        }
    };

    window.hoverRating = function(rating) {
        updateStarVisuals(rating);
        var lbl = document.getElementById('rating-label');
        if (lbl && ratingLabels[rating]) {
            lbl.textContent = ratingLabels[rating];
        }
    };

    window.resetHoverRating = function() {
        updateStarVisuals(currentRating);
        var lbl = document.getElementById('rating-label');
        if (lbl && ratingLabels[currentRating]) {
            lbl.textContent = ratingLabels[currentRating];
        }
    };

    function updateStarVisuals(rating) {
        var starButtons = document.querySelectorAll('#star-picker .star-btn');
        starButtons.forEach(function(btn, idx) {
            var icon = btn.querySelector('svg') || btn.querySelector('i');
            if (icon) {
                if (idx < rating) {
                    icon.classList.add('fill-amber-400', 'text-amber-400');
                    icon.classList.remove('text-gray-300', 'dark:text-gray-600');
                } else {
                    icon.classList.remove('fill-amber-400', 'text-amber-400');
                    icon.classList.add('text-gray-300');
                }
            }
        });
    }

    window.handleReviewSubmit = function(e) {
        e.preventDefault();
        var form = e.target;
        var btn = document.getElementById('review-submit-btn');
        var label = document.getElementById('review-submit-label');
        var alertBox = document.getElementById('review-alert-box');

        if (btn) btn.disabled = true;
        if (label) label.textContent = 'در حال ارسال...';
        if (alertBox) alertBox.classList.add('hidden');

        var formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(function(res) {
            return res.json().catch(function() {
                return { success: res.ok, message: 'عملیات با موفقیت انجام شد.' };
            });
        })
        .then(function(data) {
            if (alertBox) {
                alertBox.classList.remove('hidden', 'bg-red-500/10', 'text-red-500', 'border-red-500/30', 'bg-emerald-500/10', 'text-emerald-500', 'border-emerald-500/30');
                if (data.success) {
                    alertBox.className = 'p-3.5 rounded-xl text-xs font-semibold bg-emerald-500/10 text-emerald-500 border border-emerald-500/30';
                    alertBox.innerHTML = '✓ ' + (data.message || 'نظر و امتیاز شما با موفقیت ثبت شد و پس از بررسی و تایید مدیر نمایش داده خواهد شد.');
                    form.reset();
                    setRating(5);
                    setTimeout(function() {
                        toggleReviewForm();
                    }, 4000);
                } else {
                    alertBox.className = 'p-3.5 rounded-xl text-xs font-semibold bg-red-500/10 text-red-500 border border-red-500/30';
                    alertBox.innerHTML = '⚠ ' + (data.message || 'خطا در ثبت نظر. لطفاً مجدداً تلاش فرمایید.');
                }
            }
        })
        .catch(function(err) {
            if (alertBox) {
                alertBox.classList.remove('hidden');
                alertBox.className = 'p-3.5 rounded-xl text-xs font-semibold bg-red-500/10 text-red-500 border border-red-500/30';
                alertBox.innerHTML = '⚠ خطا در برقراری ارتباط با سرور. لطفاً مجدداً تلاش کنید.';
            }
        })
        .finally(function() {
            if (btn) btn.disabled = false;
            if (label) label.textContent = 'ارسال نظر';
            if (window.lucide) lucide.createIcons();
        });
    };
})();
</script>
