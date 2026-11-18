<?php
// Working Days & Hours Partial
$hasHours = !empty($profile['working_days']) || !empty($profile['working_hours']) || !empty($profile['working_note']);
?>
<?php if ($hasHours): ?>
    <div class="rounded-3xl p-6 sm:p-7 border space-y-4 transition-all h-full flex flex-col justify-between" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">
        <div class="space-y-4">
            <div class="flex items-center justify-between gap-2 flex-wrap">
                <div class="flex items-center gap-2.5 font-bold text-xs sm:text-sm" style="color: var(--text-main);">
                    <span class="w-8 h-8 rounded-xl flex items-center justify-center border" style="background-color: var(--box-bg); border-color: var(--border); color: var(--primary);">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                    </span>
                    <span><?= \App\Core\Helper::e($translations['working_hours'] ?? 'روزها و ساعات پاسخگویی') ?></span>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] sm:text-[11px] font-bold bg-emerald-500/10 text-emerald-500 border border-emerald-500/25">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span><?= \App\Core\Helper::e($translations['open_badge'] ?? 'پاسخگوی شما هستیم') ?></span>
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                <?php if (!empty($profile['working_days'])): ?>
                    <div class="flex flex-col justify-between p-3.5 rounded-2xl border gap-1.5" style="background-color: var(--box-bg); border-color: var(--border);">
                        <span class="text-[11px] font-medium flex items-center gap-1.5" style="color: var(--text-sub);">
                            <i data-lucide="calendar" class="w-3.5 h-3.5" style="color: var(--primary);"></i>
                            <span><?= \App\Core\Helper::e($translations['working_days_label'] ?? 'روزهای کاری') ?></span>
                        </span>
                        <span class="font-bold text-xs sm:text-sm" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['working_days']) ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($profile['working_hours'])): ?>
                    <div class="flex flex-col justify-between p-3.5 rounded-2xl border gap-1.5" style="background-color: var(--box-bg); border-color: var(--border);">
                        <span class="text-[11px] font-medium flex items-center gap-1.5" style="color: var(--text-sub);">
                            <i data-lucide="watch" class="w-3.5 h-3.5" style="color: var(--primary);"></i>
                            <span><?= \App\Core\Helper::e($translations['working_hours_label'] ?? 'ساعات کاری') ?></span>
                        </span>
                        <span class="font-bold font-mono text-xs sm:text-sm" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['working_hours']) ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($profile['working_note'])): ?>
            <div class="p-3.5 rounded-2xl border text-[11px] sm:text-xs leading-relaxed flex items-start gap-2.5 mt-3" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-sub);">
                <i data-lucide="info" class="w-4 h-4 flex-shrink-0 mt-0.5 text-amber-500"></i>
                <span><?= \App\Core\Helper::e($profile['working_note']) ?></span>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
