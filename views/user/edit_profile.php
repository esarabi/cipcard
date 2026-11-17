<div class="max-w-4xl space-y-8">
    <div class="pb-6 border-b border-brand-border/40 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">ویرایش مشخصات کارت ویزیت هوشمند</h1>
            <p class="text-xs text-gray-400 mt-1">تغییر آدرس اختصاصی، شبکه‌های اجتماعی ایرانی و بین‌المللی، نقشه و ساعات پاسخگویی</p>
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

        <!-- 3. Avatar Upload Section -->
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
                <label class="block text-xs font-bold text-white">تصویر پروفایل شخصی یا لوگوی سازمان</label>
                <input type="file" name="avatar" accept="image/*" class="text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-surfaceHover file:text-brand-gold hover:file:bg-brand-gold hover:file:text-black cursor-pointer">
                <span class="block text-[11px] text-gray-500">حداکثر حجم فایل: ۱۵ مگابایت (فرمت‌های JPG, PNG, WEBP)</span>
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
                <label class="block text-xs font-bold text-gray-300 mb-1.5">بیوگرافی یا معرفی کوتاه خدمات و فعالیت‌ها</label>
                <textarea name="bio" rows="3" placeholder="توضیح مختصری درباره خدمات، فعالیت‌ها، سوابق حرفه‌ای یا ماموریت سازمان خود بنویسید..." class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none leading-relaxed"><?= \App\Core\Helper::e($profile['bio'] ?? '') ?></textarea>
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

        <!-- 7. Map & Smart GPS Navigation (نمایش روی نقشه و مسیریابی) -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 flex items-center justify-center">
                        <i data-lucide="map-pin" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white">موقعیت مکانی و مسیریابی هوشمند (نشان، بلد و گوگل‌مپ)</h3>
                        <p class="text-xs text-gray-400">مشتریان با لمس کارت می‌توانند با یک کلیک آدرس شما را در نشان، بلد یا گوگل مپ مسیریابی کنند.</p>
                    </div>
                </div>
                <button type="button" onclick="detectGpsLocation()" class="px-3.5 py-2 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 hover:bg-emerald-500 hover:text-black transition-all text-xs font-bold flex items-center gap-1.5">
                    <i data-lucide="crosshair" class="w-4 h-4"></i>
                    <span>دریافت موقعیت GPS من</span>
                </button>
            </div>

            <div class="space-y-4 pt-2">
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">نشانی دقیق متنی (خیابان، پلاک، طبقه و واحد)</label>
                    <input type="text" name="address" value="<?= \App\Core\Helper::e($profile['address'] ?? '') ?>" placeholder="مثال: تهران، میدان ونک، خیابان ولیعصر، برج سپهر، طبقه ۵، واحد ۱۰" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
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

        <div class="pt-4 flex items-center justify-between">
            <button type="submit" class="px-10 py-4 rounded-2xl bg-gradient-to-r from-brand-goldDark via-brand-gold to-brand-goldLight text-black font-extrabold text-sm shadow-xl shadow-brand-gold/20 hover:brightness-110 active:scale-95 transition-all flex items-center gap-2">
                <i data-lucide="check" class="w-5 h-5"></i>
                <span>ذخیره تمامی تغییرات پروفایل</span>
            </button>
        </div>
    </form>
</div>

<script>
function detectGpsLocation() {
    if (!navigator.geolocation) {
        alert('مرورگر شما از قابلیت دریافت موقعیت جغرافیایی پشتیبانی نمی‌کند.');
        return;
    }
    navigator.geolocation.getCurrentPosition(
        function(position) {
            document.getElementById('geo-lat').value = position.coords.latitude.toFixed(6);
            document.getElementById('geo-lng').value = position.coords.longitude.toFixed(6);
            alert('موقعیت مکانی شما با موفقیت از GPS دریافت و ثبت شد!');
        },
        function(error) {
            alert('خطا در دریافت موقعیت مکانی. لطفاً دسترسی لوکیشن را در مرورگر خود تایید فرمایید.');
        },
        { enableHighAccuracy: true, timeout: 10000 }
    );
}
</script>
