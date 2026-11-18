<style>
    /* Reviews Management Comment Box Styles */
    .review-comment-box {
        background-color: #F8FAFC !important;
        border-color: #E2E8F0 !important;
        color: #1E293B !important;
    }
    html[data-theme="dark"] .review-comment-box {
        background-color: rgba(5, 5, 7, 0.75) !important;
        border-color: rgba(42, 42, 54, 0.6) !important;
        color: #E2E8F0 !important;
    }
    html[data-theme="light"] .review-reply-btn {
        background-color: #FEF3C7 !important;
        border-color: #FCD34D !important;
        color: #92400E !important;
    }
    html[data-theme="light"] .review-reply-btn:hover {
        background-color: #FDE68A !important;
        color: #78350F !important;
    }
    html[data-theme="light"] .owner-reply-card {
        background-color: #FFFBEB !important;
        border-color: #FDE68A !important;
    }
    html[data-theme="light"] .owner-reply-card p {
        color: #334155 !important;
    }
</style>

<div class="space-y-8">

    <!-- Header & Review Status Badge -->
    <div class="pb-6 border-b border-brand-border/40 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <h1 class="text-2xl font-black text-white">نظرات و امتیازهای کارت هوشمند</h1>
                <?php if (!empty($profile['enable_reviews'])): ?>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 text-[11px] font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span>بخش نظرات فعال است</span>
                    </span>
                <?php else: ?>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-500/10 text-red-400 border border-red-500/30 text-[11px] font-bold">
                        <span class="w-2 h-2 rounded-full bg-red-400"></span>
                        <span>بخش نظرات غیرفعال است</span>
                    </span>
                <?php endif; ?>
            </div>
            <p class="text-xs text-gray-400 mt-1">بررسی، تایید، انتشار، رد و پاسخ‌گویی به نظرات و امتیازهای مخاطبان کارت ویزیت شما</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="<?= \App\Core\Helper::url('dashboard/profile#reviews-setting') ?>" class="px-4 py-2.5 rounded-xl bg-brand-surfaceHover border border-brand-border text-gray-300 hover:text-white transition-all text-xs font-bold flex items-center gap-2">
                <i data-lucide="settings" class="w-4 h-4 text-amber-500"></i>
                <span>تنظیمات نظرات</span>
            </a>
            <a href="<?= \App\Core\Helper::url('@' . (!empty($profile['slug']) ? $profile['slug'] : $profile['mobile'])) ?>#reviews" target="_blank" class="px-4 py-2.5 rounded-xl bg-brand-gold/10 border border-brand-gold/40 text-brand-gold hover:bg-brand-gold hover:text-black transition-all text-xs font-bold flex items-center gap-2">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                <span>مشاهده در پروفایل</span>
            </a>
        </div>
    </div>

    <!-- Stats Overview Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <!-- Average Rating -->
        <div class="p-5 rounded-3xl bg-brand-surface border border-brand-border/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center font-black">
                <i data-lucide="star" class="w-6 h-6 fill-amber-400 text-amber-400"></i>
            </div>
            <div>
                <span class="block text-xl font-black text-white font-mono"><?= $stats['average_rating'] ?> <span class="text-xs text-gray-400 font-normal">از ۵</span></span>
                <span class="block text-[11px] text-gray-400 font-medium">میانگین امتیازها</span>
            </div>
        </div>

        <!-- Total Reviews -->
        <div class="p-5 rounded-3xl bg-brand-surface border border-brand-border/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-blue-500/30 text-blue-400 flex items-center justify-center font-black">
                <i data-lucide="messages-square" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="block text-xl font-black text-white font-mono"><?= $counts['all'] ?></span>
                <span class="block text-[11px] text-gray-400 font-medium">کل نظرات دریافتی</span>
            </div>
        </div>

        <!-- Pending Approval -->
        <div class="p-5 rounded-3xl bg-brand-surface border border-brand-border/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/20 border border-amber-500/40 text-amber-300 flex items-center justify-center font-black">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="block text-xl font-black text-amber-400 font-mono"><?= $counts['pending'] ?></span>
                <span class="block text-[11px] text-amber-300/80 font-medium">در انتظار تایید شما</span>
            </div>
        </div>

        <!-- Approved / Published -->
        <div class="p-5 rounded-3xl bg-brand-surface border border-brand-border/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center font-black">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="block text-xl font-black text-emerald-400 font-mono"><?= $counts['approved'] ?></span>
                <span class="block text-[11px] text-gray-400 font-medium">تایید و منتشر شده</span>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-2 border-b border-brand-border/40 pb-2 overflow-x-auto">
        <?php
        $tabDefs = [
            'all'      => ['label' => 'همه نظرات', 'count' => $counts['all'], 'icon' => 'list'],
            'pending'  => ['label' => 'در انتظار تایید', 'count' => $counts['pending'], 'icon' => 'clock', 'badge_class' => 'bg-amber-500 text-black'],
            'approved' => ['label' => 'تایید و منتشر شده', 'count' => $counts['approved'], 'icon' => 'check-circle-2', 'badge_class' => 'bg-emerald-500 text-black'],
            'rejected' => ['label' => 'رد شده', 'count' => $counts['rejected'], 'icon' => 'x-circle', 'badge_class' => 'bg-red-500/15 text-red-600 dark:bg-gray-700 dark:text-gray-300'],
        ];
        ?>
        <?php foreach ($tabDefs as $key => $tab): ?>
            <?php $isActive = $currentStatus === $key; ?>
            <a href="<?= \App\Core\Helper::url('dashboard/reviews?status=' . $key) ?>" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap <?= $isActive ? 'bg-brand-gold text-black shadow-md shadow-brand-gold/20' : 'bg-brand-surface border border-brand-border/60 text-gray-300 hover:text-white hover:bg-brand-surfaceHover' ?>">
                <i data-lucide="<?= $tab['icon'] ?>" class="w-4 h-4"></i>
                <span><?= $tab['label'] ?></span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-black <?= $isActive ? 'bg-black text-white' : ($tab['badge_class'] ?? 'bg-brand-darker text-gray-300') ?>">
                    <?= $tab['count'] ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Reviews List -->
    <?php if (empty($reviews)): ?>
        <div class="p-16 text-center rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <div class="w-16 h-16 rounded-full bg-brand-darker border border-brand-border flex items-center justify-center mx-auto text-gray-500">
                <i data-lucide="message-square" class="w-8 h-8"></i>
            </div>
            <div class="space-y-1">
                <h3 class="text-base font-bold text-white">نظری در این بخش یافت نشد</h3>
                <p class="text-xs text-gray-400">
                    <?php if ($currentStatus === 'pending'): ?>
                        هیچ نظری در انتظار تایید وجود ندارد. همه نظرات بررسی شده‌اند.
                    <?php else: ?>
                        هنوز نظری در این وضعیت ثبت نگردیده است.
                    <?php endif; ?>
                </p>
            </div>
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($reviews as $rev): ?>
                <?php
                $statusBadges = [
                    'pending'  => ['label' => 'در انتظار تایید شما', 'class' => 'bg-amber-500/15 text-amber-700 dark:text-amber-400 border-amber-500/30', 'icon' => 'clock'],
                    'approved' => ['label' => 'تایید و منتشر شده', 'class' => 'bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 border-emerald-500/30', 'icon' => 'check-circle'],
                    'rejected' => ['label' => 'رد شده (عدم نمایش)', 'class' => 'bg-red-500/15 text-red-700 dark:text-red-400 border-red-500/30', 'icon' => 'x-circle'],
                ];
                $sb = $statusBadges[$rev['status']] ?? ['label' => $rev['status'], 'class' => 'bg-gray-800 text-gray-300 border-gray-700', 'icon' => 'info'];
                $rating = max(1, min(5, (int)$rev['rating']));
                ?>

                <div class="p-6 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4 transition-all">
                    
                    <!-- Review Top Row -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-brand-border/40 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-brand-gold/10 border border-brand-gold/30 text-brand-gold flex items-center justify-center font-black text-sm">
                                <?= mb_substr($rev['author_name'], 0, 1) ?>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-white text-sm"><?= \App\Core\Helper::e($rev['author_name']) ?></h4>
                                    <?php if (!empty($rev['author_mobile'])): ?>
                                        <span class="inline-flex items-center gap-1 text-[11px] font-mono text-gray-400 bg-brand-darker px-2 py-0.5 rounded-lg border border-brand-border">
                                            <i data-lucide="phone" class="w-3 h-3 text-amber-500"></i>
                                            <span dir="ltr"><?= \App\Core\Helper::e($rev['author_mobile']) ?></span>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <span class="text-[11px] text-gray-400 font-mono"><?= \App\Core\Helper::e($rev['created_at']) ?></span>
                            </div>
                        </div>

                        <!-- Stars & Status Badge -->
                        <div class="flex items-center gap-3 self-start sm:self-auto">
                            <!-- Star Rating Visual -->
                            <div class="flex items-center gap-1 text-amber-400 bg-brand-darker px-3 py-1.5 rounded-xl border border-brand-border/60">
                                <?php for ($s = 1; $s <= 5; $s++): ?>
                                    <i data-lucide="star" class="w-4 h-4 <?= $s <= $rating ? 'fill-amber-400 text-amber-400' : 'text-gray-600' ?>"></i>
                                <?php endfor; ?>
                                <span class="text-xs font-mono font-bold mr-1 text-white"><?= $rating ?>/5</span>
                            </div>

                            <!-- Status Badge -->
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border <?= $sb['class'] ?> text-xs font-bold">
                                <i data-lucide="<?= $sb['icon'] ?>" class="w-3.5 h-3.5"></i>
                                <span><?= $sb['label'] ?></span>
                            </span>
                        </div>
                    </div>

                    <!-- Comment Content Body -->
                    <div class="review-comment-box p-4 rounded-2xl bg-slate-50 dark:bg-brand-darker border border-slate-200 dark:border-brand-border/60 text-xs sm:text-sm text-slate-800 dark:text-gray-200 leading-relaxed whitespace-pre-line shadow-sm" style="background-color: #F8FAFC; color: #1E293B; border-color: #E2E8F0;">
                        <?= nl2br(\App\Core\Helper::e($rev['comment'])) ?>
                    </div>

                    <!-- Owner Reply Display (If already replied) -->
                    <?php if (!empty($rev['owner_reply'])): ?>
                        <div class="owner-reply-card mr-4 p-4 rounded-2xl bg-amber-50/90 dark:bg-amber-500/5 border border-amber-200 dark:border-amber-500/20 space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-amber-700 dark:text-amber-400 flex items-center gap-1.5">
                                    <i data-lucide="corner-down-left" class="w-4 h-4"></i>
                                    <span>پاسخ شما (مدیریت):</span>
                                </span>
                                <?php if (!empty($rev['replied_at'])): ?>
                                    <span class="text-[10px] text-gray-500 dark:text-gray-400 font-mono"><?= \App\Core\Helper::e($rev['replied_at']) ?></span>
                                <?php endif; ?>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-800 dark:text-gray-300 leading-relaxed whitespace-pre-line pr-2 border-r-2 border-amber-500">
                                <?= nl2br(\App\Core\Helper::e($rev['owner_reply'])) ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <!-- Action Controls Bar -->
                    <div class="pt-2 flex flex-wrap items-center justify-between gap-3 border-t border-brand-border/30">
                        <!-- Status Changing Forms -->
                        <div class="flex items-center gap-2">
                            <?php if ($rev['status'] !== 'approved'): ?>
                                <form action="<?= \App\Core\Helper::url('dashboard/reviews/status') ?>" method="POST" class="inline">
                                    <?= \App\Core\Csrf::field() ?>
                                    <input type="hidden" name="review_id" value="<?= $rev['id'] ?>">
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="px-3.5 py-2 rounded-xl bg-emerald-500 text-black font-bold text-xs hover:brightness-110 active:scale-95 transition-all flex items-center gap-1.5 shadow-sm">
                                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                        <span>تایید و انتشار نظر</span>
                                    </button>
                                </form>
                            <?php endif; ?>

                            <?php if ($rev['status'] !== 'rejected'): ?>
                                <form action="<?= \App\Core\Helper::url('dashboard/reviews/status') ?>" method="POST" class="inline">
                                    <?= \App\Core\Csrf::field() ?>
                                    <input type="hidden" name="review_id" value="<?= $rev['id'] ?>">
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="px-3.5 py-2 rounded-xl bg-brand-surfaceHover border border-brand-border text-gray-300 hover:text-red-400 hover:border-red-500/40 text-xs font-semibold transition-all flex items-center gap-1.5">
                                        <i data-lucide="ban" class="w-3.5 h-3.5"></i>
                                        <span>رد نظر (عدم نمایش)</span>
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Reply Toggle Button -->
                            <button type="button" onclick="toggleReplyBox(<?= $rev['id'] ?>)" class="review-reply-btn px-3.5 py-2 rounded-xl bg-amber-500/15 border border-amber-500/30 text-amber-700 dark:text-amber-400 hover:bg-amber-500 hover:text-black text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm">
                                <i data-lucide="reply" class="w-3.5 h-3.5"></i>
                                <span><?= !empty($rev['owner_reply']) ? 'ویرایش پاسخ' : 'پاسخ به این نظر' ?></span>
                            </button>
                        </div>

                        <!-- Delete Review Form -->
                        <form action="<?= \App\Core\Helper::url('dashboard/reviews/delete') ?>" method="POST" onsubmit="return confirm('آیا از حذف کامل این نظر اطمینان دارید؟ این عملیات قابل بازگشت نیست.')" class="inline">
                            <?= \App\Core\Csrf::field() ?>
                            <input type="hidden" name="review_id" value="<?= $rev['id'] ?>">
                            <button type="submit" class="p-2 rounded-xl text-gray-500 hover:text-red-500 hover:bg-red-500/10 transition-all text-xs flex items-center gap-1" title="حذف کامل نظر">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Collapsible Inline Reply Box -->
                    <div id="reply-box-<?= $rev['id'] ?>" class="hidden pt-3 border-t border-brand-border/30">
                        <form action="<?= \App\Core\Helper::url('dashboard/reviews/reply') ?>" method="POST" class="space-y-3">
                            <?= \App\Core\Csrf::field() ?>
                            <input type="hidden" name="review_id" value="<?= $rev['id'] ?>">
                            <label class="block text-xs font-bold text-amber-700 dark:text-amber-400">متن پاسخ شما به عنوان صاحب کارت:</label>
                            <textarea name="reply" rows="3" placeholder="پاسخ، تشکر یا توضیحات خود را اینجا وارد کنید..." class="w-full px-4 py-3 rounded-2xl bg-white dark:bg-brand-darker border border-slate-300 dark:border-brand-border text-slate-800 dark:text-white text-xs focus:border-brand-gold focus:outline-none leading-relaxed"><?= \App\Core\Helper::e($rev['owner_reply'] ?? '') ?></textarea>
                            <div class="flex items-center gap-2">
                                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-brand-goldDark via-brand-gold to-brand-goldLight text-black font-extrabold text-xs shadow-md shadow-brand-gold/20 hover:brightness-110 transition-all flex items-center gap-1.5">
                                    <i data-lucide="send" class="w-3.5 h-3.5"></i>
                                    <span>ثبت و ذخیره پاسخ</span>
                                </button>
                                <button type="button" onclick="toggleReplyBox(<?= $rev['id'] ?>)" class="px-4 py-2.5 rounded-xl border border-brand-border text-gray-400 hover:text-white text-xs">
                                    انصراف
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<script>
function toggleReplyBox(id) {
    var box = document.getElementById('reply-box-' + id);
    if (box) {
        box.classList.toggle('hidden');
    }
}
</script>
