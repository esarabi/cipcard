<div class="max-w-4xl space-y-8">
    <div class="pb-6 border-b border-brand-border/40 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">پیگیری و مدیریت سفارشات</h1>
            <p class="text-xs text-gray-400 mt-1">مشاهده تاریخچه سفارش‌ها، وضعیت تولید کارت فیزیکی و کدهای رهگیری پست پیشتاز</p>
        </div>
        <button type="button" onclick="openNewOrderModal()" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-brand-goldDark via-brand-gold to-brand-goldLight text-black font-extrabold text-xs shadow-lg shadow-brand-gold/20 hover:brightness-110 transition-all flex items-center gap-2 self-start sm:self-auto">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>+ ثبت سفارش کارت جدید</span>
        </button>
    </div>

    <?php if (empty($orders)): ?>
        <div class="p-12 text-center rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <i data-lucide="package-x" class="w-12 h-12 text-gray-500 mx-auto"></i>
            <p class="text-sm text-gray-400">شما هنوز سفارشی ثبت نکرده‌اید.</p>
            <button type="button" onclick="openNewOrderModal()" class="px-6 py-2.5 rounded-xl bg-brand-gold text-black font-bold text-xs hover:brightness-110">
                ثبت اولین سفارش کارت هوشمند
            </button>
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($orders as $order): ?>
                <div class="p-6 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-brand-border/40 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-brand-gold/10 border border-brand-gold/30 text-brand-gold flex items-center justify-center">
                                <i data-lucide="credit-card" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <span class="font-mono font-bold text-white text-sm"><?= \App\Core\Helper::e($order['order_number']) ?></span>
                                <span class="block text-[11px] text-gray-400"><?= $order['card_type'] === 'custom_design' ? 'طرح اختصاصی با لوگوی سازمانی' : 'طرح پیش‌فرض CIP' ?></span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <span class="text-sm font-bold text-brand-gold font-mono"><?= \App\Core\Helper::formatPrice($order['amount']) ?></span>
                            <?php
                            $statusLabels = [
                                'unpaid'         => ['title' => 'پرداخت نشده', 'class' => 'bg-red-500/10 text-red-400 border-red-500/30'],
                                'pending_design' => ['title' => 'در انتظار ارسال طرح', 'class' => 'bg-amber-500/10 text-amber-400 border-amber-500/30'],
                                'printing'       => ['title' => 'در حال چاپ و برنامه‌ریزی', 'class' => 'bg-blue-500/10 text-blue-400 border-blue-500/30'],
                                'shipped'        => ['title' => 'ارسال شده با پست', 'class' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30'],
                                'delivered'      => ['title' => 'تحویل داده شده', 'class' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/50'],
                                'cancelled'      => ['title' => 'لغو شده', 'class' => 'bg-gray-800 text-gray-500 border-gray-700']
                            ];
                            $st = $statusLabels[$order['status']] ?? ['title' => $order['status'], 'class' => 'bg-gray-800 text-gray-300 border-gray-700'];
                            ?>
                            <span class="text-xs px-3 py-1 rounded-full border <?= $st['class'] ?> font-semibold"><?= $st['title'] ?></span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-between text-xs text-gray-400 gap-2">
                        <span>تاریخ ثبت: <?= \App\Core\Helper::e($order['created_at']) ?></span>
                        <?php if (!empty($order['tracking_code'])): ?>
                            <div class="flex items-center gap-2">
                                <span>کد رهگیری پستی:</span>
                                <span class="font-mono text-emerald-400 font-bold px-2 py-0.5 rounded bg-black border border-emerald-500/30"><?= \App\Core\Helper::e($order['tracking_code']) ?></span>
                                <a href="https://tracking.post.ir" target="_blank" class="text-brand-gold hover:underline">رهگیری مرسوله</a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($order['shipping_address'])): ?>
                        <div class="text-xs text-gray-400 border-t border-brand-border/30 pt-2 flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-brand-gold"></i>
                            <span>نشانی ارسال: <?= \App\Core\Helper::e($order['shipping_address']) ?> <?= !empty($order['postal_code']) ? '(کد پستی: ' . \App\Core\Helper::e($order['postal_code']) . ')' : '' ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($order['status'] === 'unpaid'): ?>
                        <div class="pt-2 flex items-center gap-3">
                            <a href="<?= \App\Core\Helper::url('order/retry/' . $order['order_number']) ?>" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-600 to-amber-400 text-black font-extrabold text-xs hover:brightness-110 shadow-lg shadow-amber-500/20">
                                <i data-lucide="credit-card" class="w-3.5 h-3.5"></i>
                                <span>پرداخت آنلاین سفارش</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/partials/new_order_modal.php'; ?>
