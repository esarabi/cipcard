<div class="max-w-4xl space-y-8">
    <div class="flex items-center justify-between pb-6 border-b border-brand-border/40">
        <div>
            <h1 class="text-2xl font-black text-white">ویرایش کاربر: <?= \App\Core\Helper::e($user['full_name']) ?></h1>
            <p class="text-xs text-gray-400 mt-1">تغییر شماره موبایل، وضعیت دسترسی و اطلاعات پروفایل کارت هوشمند</p>
        </div>
        <a href="<?= \App\Core\Helper::url('admin/users') ?>" class="text-xs text-gray-400 hover:text-white flex items-center gap-1">
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
            <span>بازگشت به لیست</span>
        </a>
    </div>

    <form action="<?= \App\Core\Helper::url('admin/users/edit/' . $user['id']) ?>" method="POST" class="space-y-6">
        <?= \App\Core\Csrf::field() ?>

        <!-- Account Core Settings -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <h3 class="text-sm font-bold text-white mb-4 border-r-2 border-brand-gold pr-3">حساب کاربری و دسترسی</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">نام و نام خانوادگی *</label>
                    <input type="text" name="full_name" required value="<?= \App\Core\Helper::e($user['full_name']) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">شماره موبایل (شناسه یکتا) *</label>
                    <input type="tel" name="mobile" required dir="ltr" value="<?= \App\Core\Helper::e($user['mobile']) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                    <span class="text-[10px] text-amber-400 mt-1 block">تغییر موبایل، آدرس پروفایل @موبایل را به‌روز می‌کند.</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">وضعیت حساب کاربری</label>
                    <select name="status" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                        <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>فعال (Active)</option>
                        <option value="pending_verification" <?= $user['status'] === 'pending_verification' ? 'selected' : '' ?>>در انتظار تایید (Pending)</option>
                        <option value="suspended" <?= $user['status'] === 'suspended' ? 'selected' : '' ?>>مسدود (Suspended)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Smart Card Profile Details -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <div class="flex items-center justify-between mb-4 border-r-2 border-brand-gold pr-3">
                <h3 class="text-sm font-bold text-white">اطلاعات نمایش داده‌شده در کارت و پروفایل</h3>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" <?= (!empty($profile['is_active'])) ? 'checked' : '' ?> class="w-4 h-4 rounded text-brand-gold focus:ring-0">
                    <span class="text-xs font-bold text-emerald-400">پروفایل فعال و عمومی باشد</span>
                </label>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">نام روی کارت (Display Name)</label>
                    <input type="text" name="display_name" value="<?= \App\Core\Helper::e($profile['display_name'] ?? $user['full_name']) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">عنوان شغلی / تخصص</label>
                    <input type="text" name="job_title" value="<?= \App\Core\Helper::e($profile['job_title'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">شرکت / سازمان</label>
                    <input type="text" name="company" value="<?= \App\Core\Helper::e($profile['company'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">ایمیل عمومی</label>
                    <input type="email" name="email" dir="ltr" value="<?= \App\Core\Helper::e($profile['email'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">تلفن محل کار</label>
                    <input type="tel" name="phone_work" dir="ltr" value="<?= \App\Core\Helper::e($profile['phone_work'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">آدرس وب‌سایت</label>
                    <input type="url" name="website" dir="ltr" value="<?= \App\Core\Helper::e($profile['website'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1.5">بیوگرافی یا توضیحات</label>
                <textarea name="bio" rows="2" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none"><?= \App\Core\Helper::e($profile['bio'] ?? '') ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1.5">نشانی فیزیکی</label>
                <input type="text" name="address" value="<?= \App\Core\Helper::e($profile['address'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
            </div>
        </div>

        <button type="submit" class="px-8 py-4 rounded-xl bg-brand-gold text-black font-extrabold text-sm hover:brightness-110 shadow-xl shadow-brand-gold/20 transition-all">
            ذخیره تغییرات کاربر
        </button>
    </form>
</div>
