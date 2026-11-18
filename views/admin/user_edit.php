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

    <!-- Physical Smart Cards & QR Codes Linked to this User -->
    <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-6 shadow-xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-brand-border/40 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-500 border border-amber-500/30 flex items-center justify-center">
                    <i data-lucide="qr-code" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white">کارت‌های هوشمند فیزیکی و بارکدهای QR متصل</h3>
                    <p class="text-xs text-gray-400">کارت‌های چاپی و چیپ‌های NFC متصل شده به پروفایل این کاربر</p>
                </div>
            </div>
            <a href="<?= \App\Core\Helper::url('admin/cards') ?>" class="text-xs text-amber-500 hover:underline flex items-center gap-1 font-bold">
                <span>مدیریت کل کارت‌ها</span>
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <!-- Currently Linked Cards -->
        <?php if (!empty($userCards)): ?>
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-gray-300">کارت‌های متصل فعلی (<?= count($userCards) ?> عدد):</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <?php foreach ($userCards as $uc): ?>
                        <?php
                        $scanUrl = \App\Core\Helper::url('c/' . $uc['card_code']);
                        $qrDataUri = \App\Services\QrCodeService::getDataUri($scanUrl, 160);
                        ?>
                        <div class="p-4 rounded-2xl bg-brand-darker border border-brand-border/80 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <a href="<?= $scanUrl ?>" target="_blank" class="p-1 bg-white rounded-lg border border-slate-200 shrink-0">
                                    <img src="<?= $qrDataUri ?>" alt="QR" class="w-10 h-10 object-contain">
                                </a>
                                <div>
                                    <span class="font-mono font-black text-amber-400 text-xs block"><?= \App\Core\Helper::e($uc['card_code']) ?></span>
                                    <span class="text-[10px] text-gray-400"><?= \App\Core\Helper::e($uc['batch_name'] ?: 'بدون دسته') ?></span>
                                    <span class="text-[10px] text-gray-500 block">اسکن: <?= number_format((int)$uc['scan_count']) ?> بار</span>
                                </div>
                            </div>
                            <form action="<?= \App\Core\Helper::url('admin/cards/unbind') ?>" method="POST" onsubmit="return confirm('آیا از قطع اتصال این کارت از کاربر اطمینان دارید؟');">
                                <?= \App\Core\Csrf::field() ?>
                                <input type="hidden" name="card_id" value="<?= $uc['id'] ?>">
                                <input type="hidden" name="redirect_back" value="admin/users/edit/<?= $user['id'] ?>">
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-brand-surfaceHover hover:bg-amber-500/20 text-gray-400 hover:text-amber-400 border border-brand-border text-xs font-semibold transition-all flex items-center gap-1" title="قطع اتصال کارت">
                                    <i data-lucide="unlink" class="w-3.5 h-3.5"></i>
                                    <span>قطع اتصال</span>
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="p-4 rounded-2xl bg-black/20 border border-brand-border/40 text-xs text-gray-400 flex items-center gap-2">
                <i data-lucide="info" class="w-4 h-4 text-amber-500 shrink-0"></i>
                <span>هنوز هیچ کارت فیزیکی یا بارکد QR به این کاربر متصل نشده است. می‌توانید با فرم زیر یک کارت خام را به او تخصیص دهید.</span>
            </div>
        <?php endif; ?>

        <!-- Form to Connect an Unassigned Card -->
        <div class="pt-4 border-t border-brand-border/40">
            <h4 class="text-xs font-bold text-white mb-3 flex items-center gap-1.5">
                <i data-lucide="plus" class="w-4 h-4 text-amber-500"></i>
                <span>تخصیص و اتصال کارت جدید به این کاربر:</span>
            </h4>

            <form action="<?= \App\Core\Helper::url('admin/cards/assign') ?>" method="POST" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                <?= \App\Core\Csrf::field() ?>
                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                <input type="hidden" name="redirect_back" value="admin/users/edit/<?= $user['id'] ?>">

                <!-- Select unassigned card from list -->
                <div class="sm:col-span-6">
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">انتخاب از کارت‌های خام موجود</label>
                    <select name="card_id" class="w-full px-4 py-2.5 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-amber-400 focus:outline-none">
                        <option value="">-- انتخاب از کارت‌های خام --</option>
                        <?php foreach ($unassignedCards as $unc): ?>
                            <option value="<?= $unc['id'] ?>">
                                <?= \App\Core\Helper::e($unc['card_code']) ?> (دسته: <?= \App\Core\Helper::e($unc['batch_name'] ?: 'بدون دسته') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Or manual card code input -->
                <div class="sm:col-span-3">
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">یا تایپ / اسکن کد کارت</label>
                    <input type="text" name="card_code" placeholder="CIP-XXXXXX" dir="ltr" class="w-full px-4 py-2.5 rounded-xl bg-brand-darker border border-brand-border text-white text-xs font-mono text-left focus:border-amber-400 focus:outline-none">
                </div>

                <!-- Submit Button -->
                <div class="sm:col-span-3">
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-md shadow-emerald-500/20 transition-all flex items-center justify-center gap-1.5">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>اتصال کارت به کاربر</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
