<?php
// Working Days & Hours Partial
$hasHours = !empty($profile['working_days']) || !empty($profile['working_hours']) || !empty($profile['working_note']);
?>
<?php if ($hasHours): ?>
    <div class="rounded-3xl p-6 border space-y-4 transition-all" style="background-color: var(--card); border-color: var(--border); box-shadow: var(--card-shadow);">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5 font-bold text-xs" style="color: var(--primary);">
                <i data-lucide="clock" class="w-4 h-4"></i>
                <span><?= \App\Core\Helper::e($translations['working_hours'] ?? 'روزها و ساعات پاسخگویی') ?></span>
            </div>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <span><?= \App\Core\Helper::e($translations['open_badge'] ?? 'پاسخگوی شما هستیم') ?></span>
            </span>
        </div>

        <div class="space-y-2.5 text-xs">
            <?php if (!empty($profile['working_days'])): ?>
                <div class="flex items-center justify-between p-3 rounded-xl border" style="background-color: var(--box-bg); border-color: var(--border);">
                    <span class="font-medium" style="color: var(--text-sub);"><?= \App\Core\Helper::e($translations['working_days_label'] ?? 'روزهای کاری') ?>:</span>
                    <span class="font-bold" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['working_days']) ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($profile['working_hours'])): ?>
                <div class="flex items-center justify-between p-3 rounded-xl border" style="background-color: var(--box-bg); border-color: var(--border);">
                    <span class="font-medium" style="color: var(--text-sub);"><?= \App\Core\Helper::e($translations['working_hours_label'] ?? 'ساعات کاری') ?>:</span>
                    <span class="font-bold font-mono" style="color: var(--text-main);"><?= \App\Core\Helper::e($profile['working_hours']) ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($profile['working_note'])): ?>
                <div class="p-3 rounded-xl border text-[11px] leading-relaxed flex items-start gap-2" style="background-color: var(--box-bg); border-color: var(--border); color: var(--text-sub);">
                    <i data-lucide="info" class="w-3.5 h-3.5 flex-shrink-0 mt-0.5 text-amber-500"></i>
                    <span><?= \App\Core\Helper::e($profile['working_note']) ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
