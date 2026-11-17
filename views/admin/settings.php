<div class="max-w-4xl space-y-8">
    <div class="pb-6 border-b border-brand-border/40">
        <h1 class="text-2xl font-black text-white">تنظیمات اصلی و اطلاعات سیستم CIPCard</h1>
        <p class="text-xs text-gray-400 mt-1">مدیریت شماره‌های تماس، ایمیل، اطلاعات شرکت، قیمت کارت‌ها و درگاه‌های بانکی و پیامک</p>
    </div>

    <form action="<?= \App\Core\Helper::url('admin/settings') ?>" method="POST" class="space-y-6">
        <?= \App\Core\Csrf::field() ?>

        <!-- General Info & Contact Configuration -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-6">
            <h3 class="text-sm font-bold text-white mb-2 border-r-2 border-brand-gold pr-3">اطلاعات کلی، تماس و برندینگ</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">عنوان وب‌سایت (Site Title)</label>
                    <input type="text" name="site_title" required value="<?= \App\Core\Helper::e(\App\Models\Setting::get('site_title', 'CIPCard | کارت ویزیت هوشمند NFC لوکس')) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">نام تجاری / شرکت</label>
                    <input type="text" name="company_name" value="<?= \App\Core\Helper::e(\App\Models\Setting::get('company_name', 'مجموعه هوشمند CIPCard')) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">شماره تلفن پشتیبانی و تماس</label>
                    <input type="text" name="support_phone" required value="<?= \App\Core\Helper::e(\App\Models\Setting::get('support_phone', '021-91000000')) ?>" dir="ltr" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none font-mono text-left">
                    <span class="text-[11px] text-gray-500 mt-1 block">در فوتر و بخش‌های تماس سایت نمایش داده می‌شود.</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">ایمیل پشتیبانی رسمی</label>
                    <input type="email" name="support_email" required value="<?= \App\Core\Helper::e(\App\Models\Setting::get('support_email', 'info@cipcard.ir')) ?>" dir="ltr" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none font-mono text-left">
                    <span class="text-[11px] text-gray-500 mt-1 block">جهت مکاتبات و نمایش در فوتر.</span>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">آدرس دفتر مرکزی / موقعیت</label>
                    <input type="text" name="support_address" value="<?= \App\Core\Helper::e(\App\Models\Setting::get('support_address', 'تهران، زعفرانیه، مرکز تجاری پالادیوم، طبقه ۹')) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">توضیحات کلی و سئو سایت (Meta Description)</label>
                    <textarea name="site_description" rows="2" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none"><?= \App\Core\Helper::e(\App\Models\Setting::get('site_description', 'پلتفرم پیشرفته خرید و مدیریت کارت ویزیت هوشمند NFC با قابلیت اتصال مستقیم به گوشی و شبکه‌های اجتماعی بدون نیاز به برنامه')) ?></textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">متن امضا و طراح در فوتر (Branding & Credit)</label>
                    <input type="text" name="branding_note" value="<?= \App\Core\Helper::e(\App\Models\Setting::get('branding_note', 'Designed for VIP & Business Leaders by rastin.ir')) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-brand-gold text-xs font-mono focus:border-brand-gold focus:outline-none" dir="ltr">
                    <span class="text-[11px] text-gray-500 mt-1 block">پیش‌فرض: Designed for VIP & Business Leaders by rastin.ir</span>
                </div>
            </div>

            <!-- Social Links in Settings -->
            <div class="pt-4 border-t border-brand-border/40 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">آیدی اینستاگرام</label>
                    <div class="relative">
                        <span class="absolute right-3 top-3 text-gray-500 text-xs">@</span>
                        <input type="text" name="social_instagram" value="<?= \App\Core\Helper::e(\App\Models\Setting::get('social_instagram', 'cipcard_ir')) ?>" dir="ltr" class="w-full pr-8 pl-4 py-2.5 rounded-xl bg-brand-darker border border-brand-border text-white text-xs font-mono text-left focus:border-brand-gold focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">آیدی کانال / پشتیبانی تلگرام</label>
                    <div class="relative">
                        <span class="absolute right-3 top-3 text-gray-500 text-xs">@</span>
                        <input type="text" name="social_telegram" value="<?= \App\Core\Helper::e(\App\Models\Setting::get('social_telegram', 'cipcard_support')) ?>" dir="ltr" class="w-full pr-8 pl-4 py-2.5 rounded-xl bg-brand-darker border border-brand-border text-white text-xs font-mono text-left focus:border-brand-gold focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">شماره واتساپ پشتیبانی</label>
                    <input type="text" name="social_whatsapp" value="<?= \App\Core\Helper::e(\App\Models\Setting::get('social_whatsapp', '989120000000')) ?>" dir="ltr" class="w-full px-4 py-2.5 rounded-xl bg-brand-darker border border-brand-border text-white text-xs font-mono text-left focus:border-brand-gold focus:outline-none">
                </div>
            </div>
        </div>

        <!-- Pricing Configuration -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <h3 class="text-sm font-bold text-white mb-4 border-r-2 border-brand-gold pr-3">تعرفه‌ها و قیمت فروش کارت‌ها</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">قیمت طرح پیش‌فرض CIP (تومان)</label>
                    <input type="number" name="price_default_cip" required value="<?= \App\Core\Helper::e(\App\Models\Setting::get('price_default_cip', '2500000')) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-brand-gold font-mono font-bold text-sm focus:border-brand-gold focus:outline-none">
                    <span class="text-[11px] text-gray-500 mt-1 block">پیش‌فرض: ۲,۵۰۰,۰۰۰ تومان</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">قیمت طرح اختصاصی با لوگو (تومان)</label>
                    <input type="number" name="price_custom_design" required value="<?= \App\Core\Helper::e(\App\Models\Setting::get('price_custom_design', '5000000')) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-brand-gold font-mono font-bold text-sm focus:border-brand-gold focus:outline-none">
                    <span class="text-[11px] text-gray-500 mt-1 block">پیش‌فرض: ۵,۰۰۰,۰۰۰ تومان</span>
                </div>
            </div>
        </div>

        <!-- Zarinpal Gateway Configuration -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <h3 class="text-sm font-bold text-white mb-4 border-r-2 border-brand-gold pr-3">تنظیمات درگاه پرداخت زرین‌پال (API v4)</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">مرچنت کد زرین‌پال (Merchant ID)</label>
                    <input type="text" name="zarinpal_merchant_id" dir="ltr" value="<?= \App\Core\Helper::e(\App\Models\Setting::get('zarinpal_merchant_id', '00000000-0000-0000-0000-000000000000')) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs font-mono focus:border-brand-gold focus:outline-none text-left">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">حالت محیط درگاه</label>
                    <select name="zarinpal_sandbox" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                        <option value="1" <?= \App\Models\Setting::get('zarinpal_sandbox', '1') == '1' ? 'selected' : '' ?>>آزمایشی (Sandbox)</option>
                        <option value="0" <?= \App\Models\Setting::get('zarinpal_sandbox', '1') == '0' ? 'selected' : '' ?>>واقعی و زنده (Live Production)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- SMS Gateway Configuration -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <h3 class="text-sm font-bold text-white mb-4 border-r-2 border-brand-gold pr-3">تنظیمات وب‌سرویس پیامک (URL-Based Pattern)</h3>

            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1.5">الگوی URL سرویس پیامک (HTTP GET/POST)</label>
                <input type="text" name="sms_url_pattern" dir="ltr" value="<?= \App\Core\Helper::e(\App\Models\Setting::get('sms_url_pattern', 'https://api.sms-provider.ir/send?apikey=YOUR_KEY&to={mobile}&text={text}')) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs font-mono focus:border-brand-gold focus:outline-none text-left">
                <span class="text-[11px] text-gray-400 mt-1 block">متغیرهای مجاز: <code class="text-brand-gold">{mobile}</code>، <code class="text-brand-gold">{text}</code>، <code class="text-brand-gold">{code}</code></span>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1.5">متن پیامک کد تایید ورود OTP</label>
                <textarea name="sms_otp_template" rows="2" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none"><?= \App\Core\Helper::e(\App\Models\Setting::get('sms_otp_template', "کد تایید ورود به CIPCard:\n{code}\nاعتبار: ۲ دقیقه")) ?></textarea>
            </div>
        </div>

        <button type="submit" class="px-8 py-4 rounded-xl bg-brand-gold text-black font-extrabold text-sm hover:brightness-110 shadow-xl shadow-brand-gold/20 transition-all flex items-center gap-2">
            <i data-lucide="check" class="w-4 h-4"></i>
            <span>ذخیره کلیه تنظیمات سیستم</span>
        </button>
    </form>
</div>
