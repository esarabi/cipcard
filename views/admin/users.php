<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-brand-border/40">
        <div>
            <h1 class="text-2xl font-black text-white">مدیریت کاربران و پروفایل‌های مشتریان</h1>
            <p class="text-xs text-gray-400 mt-1">مشاهده، جستجو و ویرایش دسترسی یا اطلاعات هویتی و پروفایل هوشمند کاربران</p>
        </div>

        <!-- Search Input -->
        <form action="<?= \App\Core\Helper::url('admin/users') ?>" method="GET" class="flex items-center gap-2">
            <input type="text" name="q" value="<?= \App\Core\Helper::e($search ?? '') ?>" placeholder="جستجو با نام یا موبایل..." class="px-4 py-2.5 rounded-xl bg-brand-surface border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none w-64">
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-brand-gold text-black font-bold text-xs hover:brightness-110">
                جستجو
            </button>
        </form>
    </div>

    <!-- Users Table -->
    <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead>
                    <tr class="border-b border-brand-border text-gray-400 font-bold">
                        <th class="py-3 px-3">شناسه</th>
                        <th class="py-3 px-3">نام و نام خانوادگی</th>
                        <th class="py-3 px-3">شماره موبایل</th>
                        <th class="py-3 px-3">نقش</th>
                        <th class="py-3 px-3">وضعیت حساب</th>
                        <th class="py-3 px-3">وضعیت کارت/پروفایل</th>
                        <th class="py-3 px-3">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-border/40 text-gray-300">
                    <?php foreach ($users as $u): ?>
                        <tr class="hover:bg-brand-surfaceHover/50 transition-colors">
                            <td class="py-4 px-3 font-mono"><?= $u['id'] ?></td>
                            <td class="py-4 px-3 font-bold text-white"><?= \App\Core\Helper::e($u['full_name']) ?></td>
                            <td class="py-4 px-3 font-mono"><?= \App\Core\Helper::e($u['mobile']) ?></td>
                            <td class="py-4 px-3">
                                <span class="px-2 py-0.5 rounded text-[10px] <?= $u['role'] === 'admin' ? 'bg-amber-500/20 text-amber-400 font-bold' : 'bg-gray-800 text-gray-400' ?>">
                                    <?= $u['role'] === 'admin' ? 'مدیر ارشد' : 'کاربر' ?>
                                </span>
                            </td>
                            <td class="py-4 px-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold <?= $u['status'] === 'active' ? 'text-emerald-400' : 'text-amber-400' ?>">
                                    <?= $u['status'] === 'active' ? 'فعال' : 'در انتظار تایید' ?>
                                </span>
                            </td>
                            <td class="py-4 px-3">
                                <?php if (!empty($u['profile_active'])): ?>
                                    <span class="text-emerald-400 font-bold">فعال (پرداخت شده)</span>
                                <?php else: ?>
                                    <span class="text-gray-500">غیرفعال</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-3">
                                <div class="flex items-center gap-2">
                                    <a href="<?= \App\Core\Helper::url('admin/users/edit/' . $u['id']) ?>" class="px-3 py-1.5 rounded-lg bg-brand-surfaceHover border border-brand-border text-brand-gold hover:bg-brand-gold hover:text-black transition-all font-semibold text-[11px] flex items-center gap-1">
                                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                        <span>ویرایش کامل</span>
                                    </a>
                                    <a href="<?= \App\Core\Helper::url('@' . $u['mobile']) ?>" target="_blank" class="p-1.5 rounded-lg bg-brand-surfaceHover text-gray-400 hover:text-white" title="مشاهده پروفایل">
                                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
