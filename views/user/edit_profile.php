<div class="max-w-4xl space-y-8">
    <div class="pb-6 border-b border-brand-border/40">
        <h1 class="text-2xl font-black text-white">ویرایش مشخصات پروفایل هوشمند</h1>
        <p class="text-xs text-gray-400 mt-1">اطلاعاتی که در این بخش وارد می‌کنید بلافاصله روی صفحه عمومی کارت شما نمایش داده خواهد شد.</p>
    </div>

    <form action="<?= \App\Core\Helper::url('dashboard/profile') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?= \App\Core\Csrf::field() ?>

        <!-- Avatar Upload Section -->
        <div class="p-6 rounded-3xl bg-brand-surface border border-brand-border/60 flex flex-col sm:flex-row items-center gap-6">
            <div class="w-24 h-24 rounded-full p-1 border-2 border-brand-gold overflow-hidden bg-black/40 flex-shrink-0">
                <?php if (!empty($profile['avatar_url'])): ?>
                    <img src="<?= \App\Core\Helper::url($profile['avatar_url']) ?>" alt="Avatar" class="w-full h-full object-cover rounded-full">
                <?php else: ?>
                    <div class="w-full h-full rounded-full flex items-center justify-center text-2xl font-bold text-brand-gold bg-brand-surface">
                        <?= mb_substr($user['full_name'], 0, 1) ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="space-y-2 text-center sm:text-right">
                <label class="block text-xs font-bold text-white">تصویر پروفایل یا لوگوی شرکت</label>
                <input type="file" name="avatar" accept="image/*" class="text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-surfaceHover file:text-brand-gold hover:file:bg-brand-gold hover:file:text-black cursor-pointer">
                <span class="block text-[11px] text-gray-500">حداکثر حجم فایل: ۱۵ مگابایت (فرمت‌های JPG, PNG, WEBP)</span>
            </div>
        </div>

        <!-- Personal & Corporate Info -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <h3 class="text-sm font-bold text-white mb-4 border-r-2 border-brand-gold pr-3">مشخصات هویتی و شغلی</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">نام و نام خانوادگی *</label>
                    <input type="text" name="display_name" required value="<?= \App\Core\Helper::e($profile['display_name'] ?? $user['full_name']) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">عنوان شغلی یا تخصص</label>
                    <input type="text" name="job_title" value="<?= \App\Core\Helper::e($profile['job_title'] ?? '') ?>" placeholder="مثال: مدیرعامل، وکیل پایه یک دادگستری" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">نام شرکت، سازمان یا برند</label>
                    <input type="text" name="company" value="<?= \App\Core\Helper::e($profile['company'] ?? '') ?>" placeholder="مثال: شرکت بین‌المللی ارس" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">آدرس وب‌سایت</label>
                    <input type="url" name="website" dir="ltr" value="<?= \App\Core\Helper::e($profile['website'] ?? '') ?>" placeholder="https://example.com" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>
            </div>

            <div class="pt-2">
                <label class="block text-xs font-bold text-gray-300 mb-1.5">بیوگرافی یا معرفی کوتاه خدمات</label>
                <textarea name="bio" rows="3" placeholder="توضیح مختصری درباره خدمات، فعالیت‌ها یا سوابق حرفه‌ای خود بنویسید..." class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none leading-relaxed"><?= \App\Core\Helper::e($profile['bio'] ?? '') ?></textarea>
            </div>
        </div>

        <!-- Contact Numbers & Location -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <h3 class="text-sm font-bold text-white mb-4 border-r-2 border-brand-gold pr-3">اطلاعات تماس و نشانی</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">شماره موبایل جهت تماس</label>
                    <input type="tel" name="phone_mobile" dir="ltr" value="<?= \App\Core\Helper::e($profile['phone_mobile'] ?? $user['mobile']) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">تلفن محل کار / دفتر</label>
                    <input type="tel" name="phone_work" dir="ltr" value="<?= \App\Core\Helper::e($profile['phone_work'] ?? '') ?>" placeholder="02188888888" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">آدرس ایمیل</label>
                    <input type="email" name="email" dir="ltr" value="<?= \App\Core\Helper::e($profile['email'] ?? '') ?>" placeholder="info@example.com" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>
            </div>

            <div class="pt-2">
                <label class="block text-xs font-bold text-gray-300 mb-1.5">آدرس دفتر / مطب / شرکت</label>
                <input type="text" name="address" value="<?= \App\Core\Helper::e($profile['address'] ?? '') ?>" placeholder="تهران، خیابان ولیعصر..." class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
            </div>
        </div>

        <!-- Social Networks -->
        <?php $social = $profile['social_links'] ?? []; ?>
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <h3 class="text-sm font-bold text-white mb-4 border-r-2 border-brand-gold pr-3">شبکه‌های اجتماعی</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">واتساپ (شماره با کد ۹۸)</label>
                    <input type="text" name="whatsapp" dir="ltr" value="<?= \App\Core\Helper::e($social['whatsapp'] ?? '') ?>" placeholder="989123456789" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">اینستاگرام (بدون @)</label>
                    <input type="text" name="instagram" dir="ltr" value="<?= \App\Core\Helper::e($social['instagram'] ?? '') ?>" placeholder="username" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">تلگرام (آیدی یا لینک کانال)</label>
                    <input type="text" name="telegram" dir="ltr" value="<?= \App\Core\Helper::e($social['telegram'] ?? '') ?>" placeholder="telegram_id" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">لینکدین (LinkedIn URL / ID)</label>
                    <input type="text" name="linkedin" dir="ltr" value="<?= \App\Core\Helper::e($social['linkedin'] ?? '') ?>" placeholder="linkedin_username" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>
            </div>
        </div>

        <button type="submit" class="px-8 py-4 rounded-xl bg-gradient-to-r from-brand-goldDark via-brand-gold to-brand-goldLight text-black font-extrabold text-sm shadow-xl shadow-brand-gold/20 hover:brightness-110 transition-all">
            ذخیره تمامی تغییرات
        </button>
    </form>
</div>
