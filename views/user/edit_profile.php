<div class="max-w-4xl space-y-8">
    <div class="pb-6 border-b border-brand-border/40 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">ویرایش مشخصات کارت ویزیت هوشمند</h1>
            <p class="text-xs text-gray-400 mt-1">تغییر آدرس اختصاصی، توضیحات بیشتر، شبکه‌های اجتماعی ایرانی و بین‌المللی، نقشه و ساعات پاسخگویی</p>
        </div>
        <?php if (!empty($profile['slug']) || !empty($user['mobile'])): ?>
            <a href="<?= \App\Core\Helper::url('@' . (!empty($profile['slug']) ? $profile['slug'] : $user['mobile'])) ?>" target="_blank" class="px-4 py-2 rounded-xl bg-brand-surfaceHover border border-brand-gold/40 text-brand-gold hover:bg-brand-gold hover:text-black transition-all text-xs font-bold flex items-center gap-2 self-start sm:self-auto">
                <i data-lucide="eye" class="w-4 h-4"></i>
                <span>پیش‌نمایش زنده کارت</span>
            </a>
        <?php endif; ?>
    </div>

    <form action="<?= \App\Core\Helper::url('dashboard/profile') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?= \App\Core\Csrf::field() ?>

        <!-- 1. Custom Non-Mobile Profile Slug (آدرس و شناسه اختصاصی کارت) -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-gold/40 space-y-4 shadow-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-brand-gold/10 text-brand-gold border border-brand-gold/30 flex items-center justify-center">
                    <i data-lucide="at-sign" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white">آدرس و شناسه اختصاصی کارت هوشمند (Custom Slug)</h3>
                    <p class="text-xs text-gray-400">مناسب برای اشخاص، پزشکان، وکلا، شرکت‌ها، برندها و هلدینگ‌های تجاری بدون نمایش شماره موبایل در آدرس</p>
                </div>
            </div>

            <div class="space-y-2 pt-2">
                <label class="block text-xs font-bold text-gray-300">آدرس عمومی کارت شما:</label>
                <div class="flex items-center gap-2 max-w-lg">
                    <span class="px-4 py-3 rounded-xl bg-black/40 border border-brand-border text-gray-400 font-mono text-xs select-none dir-ltr text-left">
                        cipcard.ir/@
                    </span>
                    <input type="text" name="slug" id="slug-input" value="<?= \App\Core\Helper::e($profile['slug'] ?? '') ?>" placeholder="مثلاً: holding یا dr_alavi یا rastingroup" dir="ltr" class="flex-1 px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-brand-gold font-mono text-xs focus:border-brand-gold focus:outline-none text-left">
                </div>
                <p class="text-[11px] text-gray-400">
                    * حداقل ۳ و حداکثر ۴۰ حرف انگلیسی، اعداد، خط فاصله (-) یا آندرلاین (_). در صورت خالی بودن، شماره موبایل شما به عنوان شناسه پیش‌فرض استفاده می‌شود.
                </p>
            </div>
        </div>

        <!-- 2. Multi-Language Support (زبان پیش‌فرض کارت) -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-blue-500/10 text-blue-400 border border-blue-500/30 flex items-center justify-center">
                    <i data-lucide="languages" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white">زبان پیش‌فرض کارت ویزیت (پشتیبانی از ۶ زبان زنده)</h3>
                    <p class="text-xs text-gray-400">بازدیدکننده هنگام باز کردن کارت یا اسکن با این زبان روبرو می‌شود و می‌تواند در بالای کارت زبان را تغییر دهد.</p>
                </div>
            </div>

            <?php
            $currentLang = $profile['default_lang'] ?? 'fa';
            $langs = \App\Services\TranslationService::SUPPORTED_LANGUAGES;
            ?>
            <div class="grid grid-cols-2 sm:grid-cols-6 gap-3 pt-2">
                <?php foreach ($langs as $code => $info): ?>
                    <label class="p-3.5 rounded-2xl border cursor-pointer text-center transition-all <?= $currentLang === $code ? 'bg-brand-gold/10 border-brand-gold text-brand-gold font-bold shadow-md' : 'bg-brand-darker border-brand-border/60 text-gray-300 hover:border-gray-500' ?>">
                        <input type="radio" name="default_lang" value="<?= $code ?>" <?= $currentLang === $code ? 'checked' : '' ?> class="sr-only">
                        <span class="text-xl block mb-1"><?= $info['flag'] ?></span>
                        <span class="block text-xs"><?= $info['name'] ?></span>
                        <span class="block text-[10px] text-gray-400 uppercase font-mono mt-0.5"><?= $code ?> (<?= $info['dir'] ?>)</span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 3. Template, Theme Mode & Color Palette Customizer -->
        <?php require __DIR__ . '/partials/template_picker.php'; ?>

        <!-- 4. Avatar & Banner Upload Section -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            <!-- Avatar Upload (5 cols) -->
            <div class="md:col-span-5 p-6 rounded-3xl bg-brand-surface border border-brand-border/60 flex flex-col items-center text-center justify-between gap-4">
                <div class="space-y-1">
                    <span class="block text-xs font-bold text-white">تصویر پروفایل / لوگو</span>
                    <span class="block text-[11px] text-gray-400">نمایش در دایره هویت کارت ویزیت</span>
                </div>
                <div class="w-24 h-24 rounded-full p-1 border-2 border-brand-gold overflow-hidden bg-black/40 flex-shrink-0 shadow-lg">
                    <?php if (!empty($profile['avatar_url'])): ?>
                        <img src="<?= \App\Core\Helper::url($profile['avatar_url']) ?>" alt="Avatar" class="w-full h-full object-cover rounded-full">
                    <?php else: ?>
                        <div class="w-full h-full rounded-full flex items-center justify-center text-2xl font-bold text-brand-gold bg-brand-surface">
                            <?= mb_substr($user['full_name'], 0, 1) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="w-full space-y-1.5">
                    <input type="file" name="avatar" accept="image/*" class="w-full text-xs text-gray-400 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-surfaceHover file:text-brand-gold hover:file:bg-brand-gold hover:file:text-black cursor-pointer">
                    <span class="block text-[10px] text-gray-500">حداکثر ۱۵ مگابایت (JPG, PNG, WEBP)</span>
                </div>
            </div>

            <!-- Banner / Cover Upload (7 cols) -->
            <div class="md:col-span-7 p-6 rounded-3xl bg-brand-surface border border-brand-border/60 flex flex-col justify-between gap-4">
                <div class="flex items-center justify-between">
                    <div class="space-y-0.5">
                        <span class="block text-xs font-bold text-white flex items-center gap-1.5">
                            <i data-lucide="image" class="w-4 h-4 text-amber-500"></i>
                            <span>تصویر بنر / کاور هدر پروفایل</span>
                        </span>
                        <span class="block text-[11px] text-gray-400">تصویر پس‌زمینه افقی در بالای کارت ویزیت</span>
                    </div>
                    <?php if (!empty($profile['cover_url'])): ?>
                        <label class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-[11px] font-bold cursor-pointer hover:bg-red-500/20 transition-all">
                            <input type="checkbox" name="remove_cover" value="1" class="rounded accent-red-500">
                            <span>حذف بنر</span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Banner Preview -->
                <div class="w-full h-28 sm:h-32 rounded-2xl overflow-hidden border border-brand-border/60 relative bg-brand-darker flex items-center justify-center">
                    <?php if (!empty($profile['cover_url'])): ?>
                        <img src="<?= \App\Core\Helper::url($profile['cover_url']) ?>" alt="Banner Cover" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="text-center p-3 text-gray-500 space-y-1">
                            <i data-lucide="image-plus" class="w-7 h-7 mx-auto text-gray-600"></i>
                            <span class="block text-[11px] text-gray-400">بنری آپلود نشده است</span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="w-full space-y-1.5">
                    <input type="file" name="cover" accept="image/*" class="w-full text-xs text-gray-400 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-surfaceHover file:text-brand-gold hover:file:bg-brand-gold hover:file:text-black cursor-pointer">
                    <span class="block text-[10px] text-gray-500">سایز پیشنهادی: ۱۲۰۰ در ۴۰۰ پیکسل (افقی) تا سقف ۱۵ مگابایت</span>
                </div>
            </div>
        </div>

        <!-- 5. Featured In-Page Showcase Photo Upload (عکس معرفی / نمونه کار در صفحه) -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="space-y-1">
                    <h3 class="text-xs sm:text-sm font-bold text-white flex items-center gap-2">
                        <i data-lucide="image" class="w-4 h-4 text-brand-gold"></i>
                        <span>تصویر شاخص و معرفی در صفحه پروفایل (نمایش تصویر نمونه کار، محصول، فروشگاه، کلینیک یا گواهینامه)</span>
                    </h3>
                    <p class="text-[11px] text-gray-400 leading-relaxed">
                        علاوه بر بنر بالای کارت، می‌توانید ۱ تصویر دلخواه (مانند نمای محیط کار، معرفی محصول، گواهینامه یا نمونه‌کار شاخص) را برای نمایش مستقیم در ستون اصلی صفحه کارت ویزیت هوشمند خود آپلود کنید.
                    </p>
                </div>
                <?php if (!empty($profile['featured_image_url'])): ?>
                    <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold cursor-pointer hover:bg-red-500/20 transition-all flex-shrink-0 self-start sm:self-auto">
                        <input type="checkbox" name="remove_featured_image" value="1" class="rounded accent-red-500">
                        <span>حذف تصویر شاخص</span>
                    </label>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                <!-- Image Preview (5 cols) -->
                <div class="md:col-span-5">
                    <div class="w-full h-44 rounded-2xl overflow-hidden border border-brand-border/60 relative bg-brand-darker flex items-center justify-center p-2">
                        <?php if (!empty($profile['featured_image_url'])): ?>
                            <img src="<?= \App\Core\Helper::url($profile['featured_image_url']) ?>" alt="Featured Photo" class="w-full h-full object-cover sm:object-contain rounded-xl">
                        <?php else: ?>
                            <div class="text-center p-4 text-gray-500 space-y-1.5">
                                <i data-lucide="image-plus" class="w-8 h-8 mx-auto text-gray-600"></i>
                                <span class="block text-xs text-gray-400">تصویری آپلود نشده است</span>
                                <span class="block text-[10px] text-gray-500">پس از آپلود در این قسمت و در صفحه پروفایل نمایش داده می‌شود</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Input Controls & Title (7 cols) -->
                <div class="md:col-span-7 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-300 mb-1.5">تیتر یا عنوان بالای تصویر در صفحه <span class="text-gray-500">(اختیاری)</span></label>
                        <input type="text" name="featured_image_title" value="<?= \App\Core\Helper::e($profile['featured_image_title'] ?? '') ?>" placeholder="مثال: نمای کلینیک، نمونه کار شاخص، گواهینامه بین‌المللی، کاتالوگ محصولات..." class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-300">انتخاب فایل تصویر جهت بارگذاری</label>
                        <input type="file" name="featured_image" accept="image/*" class="w-full text-xs text-gray-400 file:mr-2 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-surfaceHover file:text-brand-gold hover:file:bg-brand-gold hover:file:text-black cursor-pointer">
                        <span class="block text-[10px] text-gray-500">فرمت‌های مجاز: JPG, PNG, WEBP تا حداکثر ۱۵ مگابایت</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Personal & Corporate Info -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <h3 class="text-sm font-bold text-white mb-4 border-r-2 border-brand-gold pr-3">مشخصات هویتی و شغلی</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">نام و نام خانوادگی / نام مجموعه *</label>
                    <input type="text" name="display_name" required value="<?= \App\Core\Helper::e($profile['display_name'] ?? $user['full_name']) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">عنوان شغلی، حوزه فعالیت یا تخصص</label>
                    <input type="text" name="job_title" value="<?= \App\Core\Helper::e($profile['job_title'] ?? '') ?>" placeholder="مثال: مدیرعامل، وکیل دادگستری، کلینیک تخصصی" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">نام شرکت، برند یا مجموعه</label>
                    <input type="text" name="company" value="<?= \App\Core\Helper::e($profile['company'] ?? '') ?>" placeholder="مثال: هلدینگ توسعه راستین" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">آدرس وب‌سایت رسمی</label>
                    <input type="url" name="website" dir="ltr" value="<?= \App\Core\Helper::e($profile['website'] ?? '') ?>" placeholder="https://rastingroup.ir" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>
            </div>

            <div class="pt-2">
                <label class="block text-xs font-bold text-gray-300 mb-1.5">بیوگرافی یا معرفی کوتاه (نمایش در کارت هویت بالا)</label>
                <textarea name="bio" rows="3" placeholder="توضیح مختصری درباره خدمات، فعالیت‌ها، سوابق حرفه‌ای یا ماموریت سازمان خود بنویسید..." class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none leading-relaxed"><?= \App\Core\Helper::e($profile['bio'] ?? '') ?></textarea>
            </div>

            <div class="pt-2">
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-bold text-brand-gold flex items-center gap-1.5">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                        <span>توضیحات بیشتر و معرفی تفصیلی (با قابلیت باز و بسته شدن در صفحه پروفایل)</span>
                    </label>
                    <span class="text-[11px] text-gray-400">نمایش خلاصه با افکت محو شونده (Fade) و دکمه باز کردن کل متن</span>
                </div>

                <div class="mb-3">
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">تیتر بخش توضیحات بیشتر <span class="text-gray-500">(پیش‌فرض: توضیحات بیشتر)</span></label>
                    <input type="text" name="more_info_title" value="<?= \App\Core\Helper::e($profile['more_info_title'] ?? '') ?>" placeholder="مثال: درباره ما، معرفی خدمات، تاریخچه، رزومه کاری..." class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <textarea name="more_info" rows="6" placeholder="توضیحات کامل درباره خدمات، رزومه، لیست محصولات، افتخارات، شعب یا شرایط همکاری را اینجا وارد کنید. در صفحه پروفایل چند خط اول نمایش داده شده و بازدیدکننده با زدن دکمه فلش رو به پایین می‌تواند کل متن را باز کند..." class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none leading-relaxed"><?= \App\Core\Helper::e($profile['more_info'] ?? '') ?></textarea>
            </div>
        </div>

        <!-- 5. Contact Numbers & Direct Communications -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <h3 class="text-sm font-bold text-white mb-4 border-r-2 border-brand-gold pr-3">شماره‌های تماس مستقیم</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">شماره موبایل جهت تماس مستقیم</label>
                    <input type="tel" name="phone_mobile" dir="ltr" value="<?= \App\Core\Helper::e($profile['phone_mobile'] ?? $user['mobile']) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">تلفن ثابت دفتر / مطب / شرکت</label>
                    <input type="tel" name="phone_work" dir="ltr" value="<?= \App\Core\Helper::e($profile['phone_work'] ?? '') ?>" placeholder="02188888888" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">آدرس ایمیل سازمانی یا شخصی</label>
                    <input type="email" name="email" dir="ltr" value="<?= \App\Core\Helper::e($profile['email'] ?? '') ?>" placeholder="info@company.com" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>
            </div>
        </div>

        <!-- 6. Working Days & Business Hours (روزها و ساعات پاسخگویی) -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-400 border border-amber-500/30 flex items-center justify-center">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white">روزها و ساعات کاری و پاسخگویی</h3>
                    <p class="text-xs text-gray-400">نمایش روزهای حضور، ساعت‌های تماس، و توضیحات ویژه ایام تعطیل روی کارت هوشمند</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">روزهای کاری و پاسخگویی</label>
                    <input type="text" name="working_days" value="<?= \App\Core\Helper::e($profile['working_days'] ?? '') ?>" placeholder="مثال: شنبه تا چهارشنبه (یا همه‌روزه)" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">ساعات کاری و پاسخگویی</label>
                    <input type="text" name="working_hours" value="<?= \App\Core\Helper::e($profile['working_hours'] ?? '') ?>" placeholder="مثال: ۰۹:۰۰ الی ۱۸:۰۰ (یا ۲۴ ساعته)" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>
            </div>

            <div class="pt-2">
                <label class="block text-xs font-bold text-gray-300 mb-1.5">توضیحات تکمیلی یا تعطیلات</label>
                <input type="text" name="working_note" value="<?= \App\Core\Helper::e($profile['working_note'] ?? '') ?>" placeholder="مثال: پنج‌شنبه‌ها تا ساعت ۱۳:۰۰ - ایام تعطیلات رسمی پاسخگویی فقط از طریق واتساپ و ایتا" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
            </div>
        </div>

        <!-- 7. Map & Smart GPS Navigation (انتخاب موقعیت از روی نقشه، GPS و مسیریابی) -->
        <!-- Leaflet Map CSS & JS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
        <style>
            #location-picker-map {
                z-index: 5;
                background-color: #121217;
            }
            .leaflet-pane {
                z-index: 10 !important;
            }
            .leaflet-top, .leaflet-bottom {
                z-index: 20 !important;
            }
            .leaflet-container {
                font-family: 'Vazirmatn', sans-serif !important;
            }
            html[data-theme="dark"] .leaflet-layer,
            html[data-theme="dark"] .leaflet-control-zoom-in,
            html[data-theme="dark"] .leaflet-control-zoom-out,
            html[data-theme="dark"] .leaflet-control-attribution {
                filter: brightness(0.88) contrast(1.08);
            }
        </style>

        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-5">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 flex items-center justify-center">
                        <i data-lucide="map-pin" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white">موقعیت مکانی، انتخاب از روی نقشه و مسیریابی هوشمند (نشان، بلد و گوگل‌مپ)</h3>
                        <p class="text-xs text-gray-400">موقعیت دقیق خود را با کلیک روی نقشه مشخص کنید، یا با دکمه GPS موقعیت جاری خود را ثبت فرمایید.</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                    <button type="button" onclick="detectGpsLocation()" class="px-3.5 py-2 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 hover:bg-emerald-500 hover:text-black transition-all text-xs font-bold flex items-center gap-1.5 shadow-sm">
                        <i data-lucide="crosshair" class="w-4 h-4"></i>
                        <span>دریافت موقعیت GPS من</span>
                    </button>
                    <button type="button" onclick="clearMapLocation()" class="px-3 py-2 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 hover:bg-red-500/20 transition-all text-xs font-bold flex items-center gap-1">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        <span>پاک کردن نقشه</span>
                    </button>
                </div>
            </div>

            <div class="space-y-4 pt-1">
                <!-- Address Input -->
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">نشانی دقیق متنی (خیابان، پلاک، طبقه و واحد)</label>
                    <input type="text" name="address" value="<?= \App\Core\Helper::e($profile['address'] ?? '') ?>" placeholder="مثال: تهران، میدان ونک، خیابان ولیعصر، برج سپهر، طبقه ۵، واحد ۱۰" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <!-- Interactive Map Picker -->
                <div class="space-y-3 pt-1">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-gray-200 flex items-center gap-1.5">
                                <i data-lucide="map" class="w-4 h-4 text-emerald-400"></i>
                                <span>انتخاب نقطه روی نقشه:</span>
                            </span>
                            <span class="text-[11px] text-gray-400">(روی هر نقطه کلیک کنید یا نشانگر قرمز را جابجا نمایید)</span>
                        </div>

                        <!-- Quick Search in Iran -->
                        <div class="flex items-center gap-1.5 w-full sm:w-auto">
                            <div class="relative flex-1 sm:w-64">
                                <input type="text" id="map-search-query" placeholder="جستجوی شهر، خیابان یا میدان..." onkeydown="if(event.key==='Enter'){event.preventDefault();searchMapLocation();}" class="w-full pl-8 pr-3 py-2 rounded-xl bg-brand-darker border border-brand-border text-xs text-white placeholder-gray-500 focus:border-emerald-500 focus:outline-none">
                                <i data-lucide="search" class="w-3.5 h-3.5 text-gray-500 absolute left-2.5 top-2.5"></i>
                            </div>
                            <button type="button" id="map-search-btn" onclick="searchMapLocation()" class="px-3.5 py-2 rounded-xl bg-brand-surfaceHover border border-brand-border text-gray-200 hover:text-white hover:border-emerald-500 transition-all text-xs font-bold whitespace-nowrap">
                                جستجو
                            </button>
                        </div>
                    </div>

                    <!-- Map Container -->
                    <div class="relative w-full h-72 sm:h-80 rounded-2xl overflow-hidden border border-brand-border/60 bg-brand-darker shadow-inner">
                        <div id="location-picker-map" class="w-full h-full"></div>
                    </div>

                    <!-- Status / Coords Badge -->
                    <div class="flex items-center justify-between flex-wrap gap-2 pt-1 text-xs">
                        <div id="map-coords-badge">
                            <!-- Filled dynamically by JavaScript -->
                        </div>
                        <span class="text-[11px] text-gray-400">
                            مختصات به صورت زنده در فیلدهای طول و عرض جغرافیایی زیر ذخیره می‌شوند
                        </span>
                    </div>
                </div>

                <!-- Latitude / Longitude & Map Link Inputs -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-1">
                    <div>
                        <label class="block text-xs font-bold text-gray-300 mb-1.5">عرض جغرافیایی (Latitude)</label>
                        <input type="text" name="map_latitude" id="geo-lat" dir="ltr" value="<?= \App\Core\Helper::e($profile['map_latitude'] ?? '') ?>" placeholder="مثلاً: 35.7219" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none font-mono text-left">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-300 mb-1.5">طول جغرافیایی (Longitude)</label>
                        <input type="text" name="map_longitude" id="geo-lng" dir="ltr" value="<?= \App\Core\Helper::e($profile['map_longitude'] ?? '') ?>" placeholder="مثلاً: 51.3347" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none font-mono text-left">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-300 mb-1.5">لینک اشتراک‌گذاری نقشه (اختیاری)</label>
                        <input type="url" name="map_link" dir="ltr" value="<?= \App\Core\Helper::e($profile['map_link'] ?? '') ?>" placeholder="لینک نشان، بلد یا Google Map" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none font-mono text-left">
                    </div>
                </div>
            </div>
        </div>

        <!-- 8. Iranian Messengers & Socials (پیام‌رسان‌ها و شبکه‌های اجتماعی ایرانی) -->
        <?php $social = $profile['social_links'] ?? []; ?>
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-orange-500/10 text-orange-400 border border-orange-500/30 flex items-center justify-center">
                    <i data-lucide="share-2" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white">پیام‌رسان‌ها و شبکه‌های اجتماعی بومی ایران</h3>
                    <p class="text-xs text-gray-400">شناسه یا لینک کانال‌های خود را در ایتا، بله، روبیکا، سروش پلاس و آپارات ثبت کنید.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5 flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span>
                        <span>ایتا (Eitaa)</span>
                    </label>
                    <input type="text" name="eitaa" dir="ltr" value="<?= \App\Core\Helper::e($social['eitaa'] ?? '') ?>" placeholder="cipcard_ir یا eitaa.com/channel" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5 flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-teal-500"></span>
                        <span>بله (Bale)</span>
                    </label>
                    <input type="text" name="bale" dir="ltr" value="<?= \App\Core\Helper::e($social['bale'] ?? '') ?>" placeholder="channel_id یا ble.ir/id" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5 flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                        <span>روبیکا (Rubika)</span>
                    </label>
                    <input type="text" name="rubika" dir="ltr" value="<?= \App\Core\Helper::e($social['rubika'] ?? '') ?>" placeholder="rubika_page یا rubika.ir/page" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5 flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                        <span>سروش پلاس (Soroush+)</span>
                    </label>
                    <input type="text" name="soroush" dir="ltr" value="<?= \App\Core\Helper::e($social['soroush'] ?? '') ?>" placeholder="splus.ir/channel" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-300 mb-1.5 flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-pink-600"></span>
                        <span>آپارات (Aparat)</span>
                    </label>
                    <input type="text" name="aparat" dir="ltr" value="<?= \App\Core\Helper::e($social['aparat'] ?? '') ?>" placeholder="aparat_username یا aparat.com/username" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>
            </div>
        </div>

        <!-- 9. International Social Networks (شبکه‌های اجتماعی بین‌المللی) -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <h3 class="text-sm font-bold text-white mb-4 border-r-2 border-brand-gold pr-3">شبکه‌های اجتماعی و پیام‌رسان‌های بین‌المللی</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">واتساپ (WhatsApp)</label>
                    <input type="text" name="whatsapp" dir="ltr" value="<?= \App\Core\Helper::e($social['whatsapp'] ?? '') ?>" placeholder="989123456789 یا 09123456789" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">اینستاگرام (Instagram)</label>
                    <input type="text" name="instagram" dir="ltr" value="<?= \App\Core\Helper::e($social['instagram'] ?? '') ?>" placeholder="username (بدون @)" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">تلگرام (Telegram)</label>
                    <input type="text" name="telegram" dir="ltr" value="<?= \App\Core\Helper::e($social['telegram'] ?? '') ?>" placeholder="username یا t.me/channel" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">لینکدین (LinkedIn)</label>
                    <input type="text" name="linkedin" dir="ltr" value="<?= \App\Core\Helper::e($social['linkedin'] ?? '') ?>" placeholder="linkedin.com/in/username" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">گیت‌هاب (GitHub)</label>
                    <input type="text" name="github" dir="ltr" value="<?= \App\Core\Helper::e($social['github'] ?? '') ?>" placeholder="github_username" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">توییتر / X</label>
                    <input type="text" name="twitter" dir="ltr" value="<?= \App\Core\Helper::e($social['twitter'] ?? '') ?>" placeholder="twitter_username" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                </div>
            </div>
        </div>

        <!-- 8. Reviews & Star Ratings Setting -->
        <div id="reviews-setting" class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center">
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400 text-amber-400"></i>
                    </span>
                    <h3 class="text-sm font-bold text-white">بخش نظرات و امتیازدهی کارت ویزیت (Star Reviews)</h3>
                </div>
                <a href="<?= \App\Core\Helper::url('dashboard/reviews') ?>" class="px-3.5 py-1.5 rounded-xl bg-brand-darker border border-brand-gold/40 text-brand-gold hover:bg-brand-gold hover:text-black transition-all text-xs font-bold flex items-center gap-1.5">
                    <i data-lucide="messages-square" class="w-3.5 h-3.5"></i>
                    <span>مدیریت و تایید نظرات</span>
                </a>
            </div>

            <div class="p-4 rounded-2xl bg-brand-darker border border-brand-border/60">
                <label class="flex items-start sm:items-center justify-between gap-4 cursor-pointer">
                    <div class="space-y-1">
                        <span class="block text-xs font-bold text-white">فعال‌سازی امکان ثبت نظر و امتیازدهی ستاره‌ای توسط مخاطبان</span>
                        <p class="text-[11px] text-gray-400 leading-relaxed">
                            با فعال بودن این گزینه، فرم ثبت نظر و امتیاز (۱ تا ۵ ستاره) در کارت شما نمایش داده می‌شود. به درخواست شما، تمام نظرات ابتدا در حالت «در انتظار بررسی» قرار می‌گیرند و تنها پس از تایید توسط شما در پروفایل منتشر خواهند شد. همچنین می‌توانید به هر نظر پاسخ دهید.
                        </p>
                    </div>
                    <div class="pt-1 sm:pt-0">
                        <input type="checkbox" name="enable_reviews" value="1" <?= (!isset($profile['enable_reviews']) || (int)$profile['enable_reviews'] === 1) ? 'checked' : '' ?> class="w-5 h-5 rounded accent-amber-500 cursor-pointer">
                    </div>
                </label>
            </div>
        </div>

        <div class="pt-4 flex items-center justify-between">
            <button type="submit" class="px-10 py-4 rounded-2xl bg-gradient-to-r from-brand-goldDark via-brand-gold to-brand-goldLight text-black font-extrabold text-sm shadow-xl shadow-brand-gold/20 hover:brightness-110 active:scale-95 transition-all flex items-center gap-2">
                <i data-lucide="check" class="w-5 h-5"></i>
                <span>ذخیره تمامی تغییرات پروفایل</span>
            </button>
        </div>
    </form>

    <!-- ==================== ACCOUNT SECURITY & PASSWORD ==================== -->
    <div id="security" class="mt-10 p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 shadow-xl space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-brand-border/40 pb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-500 border border-amber-500/30 flex items-center justify-center">
                    <i data-lucide="shield-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white">امنیت و رمز عبور حساب کاربری</h3>
                    <p class="text-xs text-gray-400">امکان ورود به پنل کاربری با رمز عبور پایدار علاوه بر پیامک یکبار مصرف (OTP)</p>
                </div>
            </div>
            <div>
                <?php if (!empty($user['password'])): ?>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span>رمز عبور فعال است</span>
                    </span>
                <?php else: ?>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/30 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        <span>هنوز رمزی تعیین نشده است</span>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <?php if (empty($user['password'])): ?>
            <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-xs text-amber-200/90 leading-relaxed space-y-1">
                <p class="font-bold flex items-center gap-1.5 text-amber-300">
                    <i data-lucide="info" class="w-4 h-4"></i>
                    <span>تعیین رمز عبور برای ورود سریع‌تر به پنل</span>
                </p>
                <p>
                    حساب شما با تایید شماره موبایل و پیامک فعال است. با تعیین رمز عبور، در شرایطی که پیامک با تاخیر ارسال می‌شود یا به خط همراه دسترسی ندارید، می‌توانید مستقیماً با رمز عبور وارد پنل شوید.
                </p>
            </div>
        <?php endif; ?>

        <form action="<?= \App\Core\Helper::url('dashboard/password/change') ?>" method="POST" id="change-password-form" class="space-y-5">
            <?= \App\Core\Csrf::field() ?>

            <?php if (!empty($user['password'])): ?>
                <div class="space-y-1.5">
                    <label for="current-password-input" class="block text-xs font-bold text-gray-300">رمز عبور فعلی *</label>
                    <div class="relative max-w-md">
                        <input type="password" id="current-password-input" name="current_password" required placeholder="رمز عبور فعلی خود را وارد کنید" dir="ltr" class="w-full pl-12 pr-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-sm placeholder:text-gray-500 focus:border-brand-gold focus:outline-none transition-all">
                        <button type="button" onclick="togglePasswordVisibility('current-password-input', this)" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white p-1 rounded-lg focus:outline-none" title="نمایش / مخفی‌سازی رمز">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="new-password-input" class="block text-xs font-bold text-gray-300">
                        <?= !empty($user['password']) ? 'رمز عبور جدید *' : 'تعیین رمز عبور جدید *' ?>
                    </label>
                    <div class="relative">
                        <input type="password" id="new-password-input" name="new_password" required minlength="8" maxlength="72" placeholder="حداقل ۸ کاراکتر (حروف انگلیسی و عدد)" dir="ltr" oninput="checkPasswordStrengthLive()" class="w-full pl-12 pr-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-sm placeholder:text-gray-500 focus:border-brand-gold focus:outline-none transition-all">
                        <button type="button" onclick="togglePasswordVisibility('new-password-input', this)" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white p-1 rounded-lg focus:outline-none" title="نمایش / مخفی‌سازی رمز">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="confirm-password-input" class="block text-xs font-bold text-gray-300">تکرار رمز عبور جدید *</label>
                    <div class="relative">
                        <input type="password" id="confirm-password-input" name="confirm_password" required minlength="8" maxlength="72" placeholder="تکرار دقیق رمز عبور جدید" dir="ltr" oninput="checkPasswordStrengthLive()" class="w-full pl-12 pr-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-sm placeholder:text-gray-500 focus:border-brand-gold focus:outline-none transition-all">
                        <button type="button" onclick="togglePasswordVisibility('confirm-password-input', this)" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white p-1 rounded-lg focus:outline-none" title="نمایش / مخفی‌سازی رمز">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Password Standards Checklist -->
            <div class="p-4 rounded-2xl bg-black/30 border border-brand-border/40 space-y-2.5">
                <div class="text-xs font-bold text-gray-300 flex items-center gap-1.5">
                    <i data-lucide="check-shield" class="w-4 h-4 text-brand-gold"></i>
                    <span>استانداردهای امنیتی رمز عبور:</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-[11px]">
                    <div id="rule-length" class="flex items-center gap-1.5 text-gray-400">
                        <span class="w-2 h-2 rounded-full bg-gray-600 inline-block transition-colors rule-dot"></span>
                        <span>حداقل ۸ کاراکتر</span>
                    </div>
                    <div id="rule-combo" class="flex items-center gap-1.5 text-gray-400">
                        <span class="w-2 h-2 rounded-full bg-gray-600 inline-block transition-colors rule-dot"></span>
                        <span>شامل حروف انگلیسی و اعداد</span>
                    </div>
                    <div id="rule-match" class="flex items-center gap-1.5 text-gray-400">
                        <span class="w-2 h-2 rounded-full bg-gray-600 inline-block transition-colors rule-dot"></span>
                        <span>تطابق با تکرار رمز</span>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" id="btn-submit-password" class="px-8 py-3.5 rounded-xl bg-gradient-to-r from-brand-goldDark via-brand-gold to-brand-goldLight text-black font-extrabold text-xs shadow-lg shadow-brand-gold/15 hover:brightness-110 active:scale-95 transition-all flex items-center gap-2">
                    <i data-lucide="lock" class="w-4 h-4"></i>
                    <span><?= !empty($user['password']) ? 'به‌روزرسانی رمز عبور' : 'ذخیره و فعال‌سازی رمز عبور' ?></span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
var pickerMap = null;
var pickerMarker = null;

function initLocationPicker() {
    var mapContainer = document.getElementById('location-picker-map');
    var latInput = document.getElementById('geo-lat');
    var lngInput = document.getElementById('geo-lng');
    if (!mapContainer || !latInput || !lngInput) return;
    if (typeof L === 'undefined') {
        setTimeout(initLocationPicker, 150);
        return;
    }

    var initialLat = parseFloat(latInput.value);
    var initialLng = parseFloat(lngInput.value);
    var hasInitial = !isNaN(initialLat) && !isNaN(initialLng) && initialLat !== 0 && initialLng !== 0;

    // Default to Tehran coordinates if user hasn't set location yet
    var defaultCenter = [35.6892, 51.3890];
    var center = hasInitial ? [initialLat, initialLng] : defaultCenter;
    var zoom = hasInitial ? 15 : 12;

    pickerMap = L.map('location-picker-map', {
        center: center,
        zoom: zoom,
        zoomControl: true,
        scrollWheelZoom: true
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(pickerMap);

    // Custom Luxury Pin DivIcon
    var pinIcon = L.divIcon({
        className: 'custom-map-pin',
        html: '<div style="transform: translate(-50%, -100%); display: flex; flex-direction: column; align-items: center; cursor: pointer;">' +
              '<div style="background: #E11D48; color: #fff; width: 34px; height: 34px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.45); border: 2.5px solid #ffffff;">' +
              '<div style="transform: rotate(45deg); width: 10px; height: 10px; background: white; border-radius: 50%;"></div>' +
              '</div>' +
              '<div style="width: 12px; height: 5px; background: rgba(0,0,0,0.35); border-radius: 50%; filter: blur(1px); margin-top: -2px;"></div>' +
              '</div>',
        iconSize: [34, 42],
        iconAnchor: [17, 42]
    });

    function setPickerCoords(lat, lng, pan, zoomLevel) {
        lat = parseFloat(lat.toFixed(6));
        lng = parseFloat(lng.toFixed(6));
        latInput.value = lat;
        lngInput.value = lng;

        if (pickerMarker) {
            pickerMarker.setLatLng([lat, lng]);
        } else {
            pickerMarker = L.marker([lat, lng], { icon: pinIcon, draggable: true }).addTo(pickerMap);
            pickerMarker.on('dragend', function(e) {
                var pos = e.target.getLatLng();
                setPickerCoords(pos.lat, pos.lng, false);
            });
        }

        updateCoordsBadge(lat, lng);

        if (pan) {
            if (zoomLevel) {
                pickerMap.flyTo([lat, lng], zoomLevel, { duration: 1.2 });
            } else {
                pickerMap.panTo([lat, lng]);
            }
        }
    }

    window.setPickerLocation = setPickerCoords;

    if (hasInitial) {
        setPickerCoords(initialLat, initialLng, false);
    } else {
        updateCoordsBadge(null, null);
    }

    // Click anywhere on map to position the pin
    pickerMap.on('click', function(e) {
        setPickerCoords(e.latlng.lat, e.latlng.lng, false);
    });

    // Listen to manual input adjustments
    latInput.addEventListener('input', function() {
        var lat = parseFloat(latInput.value);
        var lng = parseFloat(lngInput.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            setPickerCoords(lat, lng, true);
        }
    });

    lngInput.addEventListener('input', function() {
        var lat = parseFloat(latInput.value);
        var lng = parseFloat(lngInput.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            setPickerCoords(lat, lng, true);
        }
    });

    // Invalidate size after layout rendering
    setTimeout(function() {
        if (pickerMap) pickerMap.invalidateSize();
    }, 400);
}

function updateCoordsBadge(lat, lng) {
    var el = document.getElementById('map-coords-badge');
    if (!el) return;
    if (lat !== null && lng !== null) {
        el.innerHTML = '<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 font-mono text-xs font-bold">' +
                       '<i data-lucide="check-circle" class="w-3.5 h-3.5"></i>' +
                       '<span>موقعیت انتخابی: ' + lat.toFixed(5) + ' , ' + lng.toFixed(5) + '</span>' +
                       '</span>';
    } else {
        el.innerHTML = '<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-500/15 border border-amber-500/30 text-amber-400 text-xs font-bold">' +
                       '<i data-lucide="info" class="w-3.5 h-3.5"></i>' +
                       '<span>روی نقشه کلیک کنید تا نشانگر در محل دلخواه قرار گیرد</span>' +
                       '</span>';
    }
    if (window.lucide) lucide.createIcons();
}

function clearMapLocation() {
    document.getElementById('geo-lat').value = '';
    document.getElementById('geo-lng').value = '';
    if (pickerMarker && pickerMap) {
        pickerMap.removeLayer(pickerMarker);
        pickerMarker = null;
    }
    updateCoordsBadge(null, null);
}

async function searchMapLocation() {
    var queryInput = document.getElementById('map-search-query');
    if (!queryInput) return;
    var query = queryInput.value.trim();
    if (!query) {
        alert('لطفاً نام شهر، خیابان یا میدان مورد نظر را وارد نمایید.');
        return;
    }

    var btn = document.getElementById('map-search-btn');
    if (btn) {
        btn.disabled = true;
        btn.innerText = 'در حال جستجو...';
    }

    try {
        var url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query) + '&countrycodes=ir&limit=1';
        var res = await fetch(url, { headers: { 'Accept-Language': 'fa' } });
        var data = await res.json();
        if (data && data.length > 0) {
            var lat = parseFloat(data[0].lat);
            var lon = parseFloat(data[0].lon);
            if (window.setPickerLocation) {
                window.setPickerLocation(lat, lon, true, 16);
            }
        } else {
            alert('موقعیت مورد نظر در جستجو یافت نشد. می‌توانید با زوم و کلیک روی نقشه، نقطه دقیق را انتخاب نمایید.');
        }
    } catch (e) {
        alert('خطا در برقراری ارتباط با سرویس جستجو. لطفاً مستقیماً از روی نقشه نقطه را انتخاب فرمایید.');
    } finally {
        if (btn) {
            btn.disabled = false;
            btn.innerText = 'جستجو';
        }
    }
}

function detectGpsLocation() {
    if (!navigator.geolocation) {
        alert('مرورگر شما از قابلیت دریافت موقعیت جغرافیایی پشتیبانی نمی‌کند.');
        return;
    }

    var badge = document.getElementById('map-coords-badge');
    if (badge) {
        badge.innerHTML = '<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sky-500/15 border border-sky-500/30 text-sky-400 text-xs font-bold animate-pulse">' +
                          '<i data-lucide="loader" class="w-3.5 h-3.5 animate-spin"></i>' +
                          '<span>در حال دریافت موقعیت مکانی از GPS دستگاه شما...</span>' +
                          '</span>';
        if (window.lucide) lucide.createIcons();
    }

    navigator.geolocation.getCurrentPosition(
        function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            if (window.setPickerLocation) {
                window.setPickerLocation(lat, lng, true, 16);
            } else {
                document.getElementById('geo-lat').value = lat.toFixed(6);
                document.getElementById('geo-lng').value = lng.toFixed(6);
            }
            alert('موقعیت مکانی شما با موفقیت از GPS دریافت و روی نقشه پین شد!');
        },
        function(error) {
            var msg = 'خطا در دریافت موقعیت مکانی. لطفاً دسترسی لوکیشن (GPS) را در مرورگر یا دستگاه خود تایید فرمایید.';
            if (error.code === 1) {
                msg = 'دسترسی به موقعیت مکانی رد شد. لطفاً در تنظیمات مرورگر اجازه دسترسی به لوکیشن را تایید کنید، یا موقعیت را مستقیماً با کلیک روی نقشه انتخاب نمایید.';
            }
            alert(msg);
            var curLat = parseFloat(document.getElementById('geo-lat').value);
            var curLng = parseFloat(document.getElementById('geo-lng').value);
            updateCoordsBadge(isNaN(curLat) ? null : curLat, isNaN(curLng) ? null : curLng);
        },
        { enableHighAccuracy: true, timeout: 12000, maximumAge: 0 }
    );
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLocationPicker);
} else {
    initLocationPicker();
}

function togglePasswordVisibility(inputId, btn) {
    var input = document.getElementById(inputId);
    if (!input) return;
    var isPass = input.type === 'password';
    input.type = isPass ? 'text' : 'password';
    btn.innerHTML = isPass ? '<i data-lucide="eye-off" class="w-4 h-4 text-amber-500"></i>' : '<i data-lucide="eye" class="w-4 h-4"></i>';
    if (window.lucide) lucide.createIcons();
}

function checkPasswordStrengthLive() {
    var newPwd = (document.getElementById('new-password-input') || {}).value || '';
    var confirmPwd = (document.getElementById('confirm-password-input') || {}).value || '';

    var ruleLen = document.getElementById('rule-length');
    var ruleCombo = document.getElementById('rule-combo');
    var ruleMatch = document.getElementById('rule-match');

    // Rule 1: Length >= 8
    var hasLen = newPwd.length >= 8 && newPwd.length <= 72;
    updateRuleVisual(ruleLen, hasLen);

    // Rule 2: Combo letters + digits
    var hasLetters = /[a-zA-Z]/.test(newPwd);
    var hasDigits = /\d/.test(newPwd);
    var hasCombo = hasLetters && hasDigits;
    updateRuleVisual(ruleCombo, hasCombo);

    // Rule 3: Match
    var hasMatch = newPwd.length > 0 && newPwd === confirmPwd;
    updateRuleVisual(ruleMatch, hasMatch);
}

function updateRuleVisual(el, isValid) {
    if (!el) return;
    var dot = el.querySelector('.rule-dot');
    if (isValid) {
        el.classList.remove('text-gray-400');
        el.classList.add('text-emerald-400', 'font-bold');
        if (dot) {
            dot.classList.remove('bg-gray-600');
            dot.classList.add('bg-emerald-400');
        }
    } else {
        el.classList.remove('text-emerald-400', 'font-bold');
        el.classList.add('text-gray-400');
        if (dot) {
            dot.classList.remove('bg-emerald-400');
            dot.classList.add('bg-gray-600');
        }
    }
}
</script>
