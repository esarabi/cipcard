<div class="space-y-8">
    <div class="pb-6 border-b border-brand-border/40">
        <h1 class="text-2xl font-black text-white">مدیریت مالی و تراکنش‌های بانکی</h1>
        <p class="text-xs text-gray-400 mt-1">لاگ تمامی پرداخت‌های درگاه زرین‌پال به همراه کد پیگیری (RefID) و شماره کارت پرداخت‌کننده</p>
    </div>

    <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead>
                    <tr class="border-b border-brand-border text-gray-400 font-bold">
                        <th class="py-3 px-3">شماره پیگیری (RefID)</th>
                        <th class="py-3 px-3">شماره سفارش</th>
                        <th class="py-3 px-3">مشتری</th>
                        <th class="py-3 px-3">مبلغ (تومان)</th>
                        <th class="py-3 px-3">شماره کارت ماسک‌شده</th>
                        <th class="py-3 px-3">وضعیت پرداخت</th>
                        <th class="py-3 px-3">تاریخ و ساعت</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-border/40 text-gray-300">
                    <?php if (empty($transactions)): ?>
                        <tr><td colspan="7" class="py-8 text-center text-gray-500">هیچ تراکنشی ثبت نشده است.</td></tr>
                    <?php else: ?>
                        <?php foreach ($transactions as $t): ?>
                            <tr class="hover:bg-brand-surfaceHover/50 transition-colors">
                                <td class="py-4 px-3 font-mono font-bold <?= $t['status'] === 'success' ? 'text-emerald-400' : 'text-gray-400' ?>">
                                    <?= !empty($t['ref_id']) ? \App\Core\Helper::e($t['ref_id']) : '-' ?>
                                </td>
                                <td class="py-4 px-3 font-mono text-white"><?= \App\Core\Helper::e($t['order_number']) ?></td>
                                <td class="py-4 px-3">
                                    <span class="block text-white font-medium"><?= \App\Core\Helper::e($t['full_name']) ?></span>
                                    <span class="block text-[11px] text-gray-500 font-mono"><?= \App\Core\Helper::e($t['mobile']) ?></span>
                                </td>
                                <td class="py-4 px-3 font-mono font-bold text-brand-gold"><?= \App\Core\Helper::formatPrice($t['amount']) ?></td>
                                <td class="py-4 px-3 font-mono text-[11px] text-gray-400"><?= !empty($t['card_pan']) ? \App\Core\Helper::e($t['card_pan']) : '-' ?></td>
                                <td class="py-4 px-3">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold <?= $t['status'] === 'success' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' ?>">
                                        <?= $t['status'] === 'success' ? 'پرداخت موفق' : ($t['status'] === 'pending' ? 'در انتظار' : 'ناموفق') ?>
                                    </span>
                                </td>
                                <td class="py-4 px-3 text-gray-400 text-[11px] font-mono"><?= \App\Core\Helper::e($t['payment_date'] ?: $t['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
