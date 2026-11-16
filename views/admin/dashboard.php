<div class="space-y-8">
    <div class="pb-6 border-b border-brand-border/40">
        <h1 class="text-2xl font-black text-white">داشبورد آمار و گزارشات جامع</h1>
        <p class="text-xs text-gray-400 mt-1">نمای کلی عملکرد مالی، میزان فروش، سفارشات در انتظار و کاربران فعال</p>
    </div>

    <!-- 4 Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Revenue -->
        <div class="p-6 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-2">
            <div class="flex justify-between items-center text-xs text-gray-400">
                <span>کل درآمد پلتفرم</span>
                <i data-lucide="wallet" class="w-4 h-4 text-brand-gold"></i>
            </div>
            <p class="text-2xl font-black text-brand-gold font-mono"><?= \App\Core\Helper::formatPrice($totalRevenue) ?></p>
            <span class="text-[10px] text-gray-500">تراکنش‌های موفق زرین‌پال</span>
        </div>

        <!-- Monthly Revenue -->
        <div class="p-6 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-2">
            <div class="flex justify-between items-center text-xs text-gray-400">
                <span>درآمد ۳۰ روز اخیر</span>
                <i data-lucide="trending-up" class="w-4 h-4 text-emerald-400"></i>
            </div>
            <p class="text-2xl font-black text-emerald-400 font-mono"><?= \App\Core\Helper::formatPrice($monthlyRevenue) ?></p>
            <span class="text-[10px] text-gray-500">فروش ماه جاری</span>
        </div>

        <!-- Total Orders -->
        <div class="p-6 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-2">
            <div class="flex justify-between items-center text-xs text-gray-400">
                <span>کل سفارشات ثبت‌شده</span>
                <i data-lucide="shopping-cart" class="w-4 h-4 text-sky-400"></i>
            </div>
            <p class="text-2xl font-black text-white font-mono"><?= number_format($totalOrders) ?></p>
            <span class="text-[10px] text-gray-500">طرح‌های پیش‌فرض و اختصاصی</span>
        </div>

        <!-- Pending Orders -->
        <div class="p-6 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-2">
            <div class="flex justify-between items-center text-xs text-gray-400">
                <span>سفارشات در انتظار چاپ/ارسال</span>
                <i data-lucide="clock" class="w-4 h-4 text-amber-400"></i>
            </div>
            <p class="text-2xl font-black text-amber-400 font-mono"><?= number_format($pendingOrders) ?></p>
            <span class="text-[10px] text-gray-500">نیازمند اقدام در کارگاه</span>
        </div>

    </div>

    <!-- Chart.js Graph Section -->
    <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="font-bold text-white text-base">نمودار فروش و تراکنش‌های ۳۰ روز اخیر</h3>
                <p class="text-xs text-gray-400 mt-0.5">روند نوسان درآمد روزانه از درگاه بانکی زرین‌پال</p>
            </div>
            <span class="text-xs px-3 py-1 rounded-full bg-brand-gold/10 text-brand-gold font-mono border border-brand-gold/30">Chart.js Engine</span>
        </div>

        <div class="w-full h-72 sm:h-80">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-6">
        <div class="flex justify-between items-center">
            <h3 class="font-bold text-white text-base">آخرین سفارشات ثبت‌شده</h3>
            <a href="<?= \App\Core\Helper::url('admin/orders') ?>" class="text-xs text-brand-gold hover:underline">مشاهده همه سفارشات</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead>
                    <tr class="border-b border-brand-border text-gray-400 font-bold">
                        <th class="py-3 px-3">شماره سفارش</th>
                        <th class="py-3 px-3">مشتری</th>
                        <th class="py-3 px-3">شماره تماس</th>
                        <th class="py-3 px-3">نوع کارت</th>
                        <th class="py-3 px-3">مبلغ (تومان)</th>
                        <th class="py-3 px-3">وضعیت</th>
                        <th class="py-3 px-3">تاریخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-border/40 text-gray-300">
                    <?php foreach ($recentOrders as $ro): ?>
                        <tr class="hover:bg-brand-surfaceHover/50 transition-colors">
                            <td class="py-3.5 px-3 font-mono font-bold text-white"><?= \App\Core\Helper::e($ro['order_number']) ?></td>
                            <td class="py-3.5 px-3"><?= \App\Core\Helper::e($ro['full_name']) ?></td>
                            <td class="py-3.5 px-3 font-mono"><?= \App\Core\Helper::e($ro['mobile']) ?></td>
                            <td class="py-3.5 px-3"><?= $ro['card_type'] === 'custom_design' ? 'طرح اختصاصی' : 'طرح پیش‌فرض' ?></td>
                            <td class="py-3.5 px-3 font-mono text-brand-gold font-bold"><?= \App\Core\Helper::formatPrice($ro['amount']) ?></td>
                            <td class="py-3.5 px-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold <?= $ro['status'] === 'unpaid' ? 'bg-red-500/10 text-red-400' : 'bg-emerald-500/10 text-emerald-400' ?>">
                                    <?= $ro['status'] ?>
                                </span>
                            </td>
                            <td class="py-3.5 px-3 text-gray-500"><?= substr($ro['created_at'], 0, 10) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('salesChart');
    if (!ctx) return;

    const chartRaw = <?= json_encode($chartData) ?>;
    const labels = chartRaw.map(item => item.date_day);
    const revenues = chartRaw.map(item => item.total_revenue);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels.length ? labels : ['امروز'],
            datasets: [{
                label: 'درآمد روزانه (تومان)',
                data: revenues.length ? revenues : [0],
                borderColor: '#D4AF37',
                backgroundColor: 'rgba(212, 175, 55, 0.1)',
                fill: true,
                tension: 0.35,
                borderWidth: 2,
                pointBackgroundColor: '#D4AF37',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: { color: '#9CA3AF', font: { family: 'Vazirmatn' } }
                }
            },
            scales: {
                x: {
                    ticks: { color: '#6B7280', font: { family: 'Vazirmatn', size: 10 } },
                    grid: { color: 'rgba(255, 255, 255, 0.04)' }
                },
                y: {
                    ticks: { color: '#6B7280', font: { family: 'Vazirmatn', size: 10 } },
                    grid: { color: 'rgba(255, 255, 255, 0.04)' }
                }
            }
        }
    });
});
</script>
