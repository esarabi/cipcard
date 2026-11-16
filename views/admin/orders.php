<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-brand-border/40">
        <div>
            <h1 class="text-2xl font-black text-white">مدیریت سفارشات کارت هوشمند</h1>
            <p class="text-xs text-gray-400 mt-1">تغییر وضعیت سفارشات و ثبت کد رهگیری پستی مرسولات</p>
        </div>

        <!-- Filter Status Tabs -->
        <div class="flex flex-wrap gap-2 text-xs">
            <a href="<?= \App\Core\Helper::url('admin/orders') ?>" class="px-3 py-1.5 rounded-xl border <?= empty($statusFilter) ? 'bg-brand-gold text-black font-bold border-brand-gold' : 'bg-brand-surface text-gray-400 border-brand-border hover:text-white' ?>">همه</a>
            <a href="<?= \App\Core\Helper::url('admin/orders?status=pending_design') ?>" class="px-3 py-1.5 rounded-xl border <?= $statusFilter === 'pending_design' ? 'bg-brand-gold text-black font-bold border-brand-gold' : 'bg-brand-surface text-gray-400 border-brand-border hover:text-white' ?>">در انتظار طرح</a>
            <a href="<?= \App\Core\Helper::url('admin/orders?status=printing') ?>" class="px-3 py-1.5 rounded-xl border <?= $statusFilter === 'printing' ? 'bg-brand-gold text-black font-bold border-brand-gold' : 'bg-brand-surface text-gray-400 border-brand-border hover:text-white' ?>">در حال چاپ</a>
            <a href="<?= \App\Core\Helper::url('admin/orders?status=shipped') ?>" class="px-3 py-1.5 rounded-xl border <?= $statusFilter === 'shipped' ? 'bg-brand-gold text-black font-bold border-brand-gold' : 'bg-brand-surface text-gray-400 border-brand-border hover:text-white' ?>">ارسال شده</a>
            <a href="<?= \App\Core\Helper::url('admin/orders?status=unpaid') ?>" class="px-3 py-1.5 rounded-xl border <?= $statusFilter === 'unpaid' ? 'bg-brand-gold text-black font-bold border-brand-gold' : 'bg-brand-surface text-gray-400 border-brand-border hover:text-white' ?>">پرداخت نشده</a>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead>
                    <tr class="border-b border-brand-border text-gray-400 font-bold">
                        <th class="py-3 px-3">شماره سفارش</th>
                        <th class="py-3 px-3">مشتری و موبایل</th>
                        <th class="py-3 px-3">نوع کارت</th>
                        <th class="py-3 px-3">فایل طرح اختصاصی</th>
                        <th class="py-3 px-3">مبلغ</th>
                        <th class="py-3 px-3">وضعیت و تغییر</th>
                        <th class="py-3 px-3">کد رهگیری پستی</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-border/40 text-gray-300">
                    <?php if (empty($orders)): ?>
                        <tr><td colspan="7" class="py-8 text-center text-gray-500">سفارشی در این وضعیت یافت نشد.</td></tr>
                    <?php else: ?>
                        <?php foreach ($orders as $o): ?>
                            <tr class="hover:bg-brand-surfaceHover/50 transition-colors">
                                <td class="py-4 px-3 font-mono font-bold text-white"><?= \App\Core\Helper::e($o['order_number']) ?></td>
                                <td class="py-4 px-3">
                                    <span class="block font-semibold text-white"><?= \App\Core\Helper::e($o['full_name']) ?></span>
                                    <span class="block text-[11px] text-gray-400 font-mono"><?= \App\Core\Helper::e($o['mobile']) ?></span>
                                </td>
                                <td class="py-4 px-3">
                                    <span class="px-2 py-0.5 rounded bg-brand-darker border border-brand-border text-[10px]">
                                        <?= $o['card_type'] === 'custom_design' ? 'طرح اختصاصی' : 'طرح پیش‌فرض' ?>
                                    </span>
                                </td>
                                <td class="py-4 px-3">
                                    <?php if (!empty($o['custom_design_file'])): ?>
                                        <a href="<?= \App\Core\Helper::url($o['custom_design_file']) ?>" target="_blank" class="text-brand-gold hover:underline flex items-center gap-1">
                                            <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                            <span>دانلود فایل</span>
                                        </a>
                                        <?php if (!empty($o['custom_design_notes'])): ?>
                                            <span class="block text-[10px] text-gray-400 truncate max-w-[150px]"><?= \App\Core\Helper::e($o['custom_design_notes']) ?></span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-gray-500">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-3 font-mono text-brand-gold font-bold"><?= \App\Core\Helper::formatPrice($o['amount']) ?></td>
                                <td class="py-4 px-3">
                                    <form action="<?= \App\Core\Helper::url('admin/orders/status') ?>" method="POST" class="flex items-center gap-2">
                                        <?= \App\Core\Csrf::field() ?>
                                        <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                                        <select name="status" class="px-2 py-1 rounded-lg bg-brand-darker border border-brand-border text-white text-[11px] focus:outline-none">
                                            <option value="unpaid" <?= $o['status'] === 'unpaid' ? 'selected' : '' ?>>پرداخت نشده</option>
                                            <option value="pending_design" <?= $o['status'] === 'pending_design' ? 'selected' : '' ?>>در انتظار طرح</option>
                                            <option value="printing" <?= $o['status'] === 'printing' ? 'selected' : '' ?>>در حال چاپ</option>
                                            <option value="shipped" <?= $o['status'] === 'shipped' ? 'selected' : '' ?>>ارسال به پست</option>
                                            <option value="delivered" <?= $o['status'] === 'delivered' ? 'selected' : '' ?>>تحویل داده شده</option>
                                            <option value="cancelled" <?= $o['status'] === 'cancelled' ? 'selected' : '' ?>>لغو شده</option>
                                        </select>
                                        <input type="text" name="tracking_code" value="<?= \App\Core\Helper::e($o['tracking_code'] ?? '') ?>" placeholder="کد رهگیری پستی" class="w-28 px-2 py-1 rounded-lg bg-brand-darker border border-brand-border text-white text-[11px] font-mono focus:outline-none">
                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-brand-gold text-black font-bold text-[10px] hover:brightness-110">
                                            ثبت
                                        </button>
                                    </form>
                                </td>
                                <td class="py-4 px-3 font-mono text-[11px] text-gray-400">
                                    <?= !empty($o['tracking_code']) ? \App\Core\Helper::e($o['tracking_code']) : '-' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
