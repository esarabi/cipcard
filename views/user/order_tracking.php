<div class="max-w-4xl space-y-8">
    <div class="pb-6 border-b border-brand-border/40">
        <h1 class="text-2xl font-black text-white">پیگیری سفارشات و بسته‌های پستی</h1>
        <p class="text-xs text-gray-400 mt-1">مشاهده تاریخچه سفارش‌ها، وضعیت تولید کارت فیزیکی و کدهای رهگیری پست پیشتاز</p>
    </div>

    <?php if (empty($orders)): ?>
        <div class="p-12 text-center rounded-3xl bg-brand-surface border border-brand-border/60 space-y-3">
            <i data-lucide="package-x" class="w-12 h-12 text-gray-500 mx-auto"></i>
            <p class="text-sm text-gray-400">شما هنوز سفارشی ثبت نکرده‌اید.</p>
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
                                <span class="block text-[11px] text-gray-400"><?= $order['card_type'] === 'custom_design' ? 'طرح اختصاصی' : 'طرح پیش‌فرض CIP' ?></span>
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
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($order['status'] === 'unpaid'): ?>
                        <div class="pt-2">
                            <a href="<?= \App\Core\Helper::url('order/retry/' . $order['order_number']) ?>" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-amber-500 text-black font-bold text-xs hover:brightness-110">
                                <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                                <span>پرداخت مجدد این سفارش</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
