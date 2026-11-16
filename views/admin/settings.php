<div class="max-w-4xl space-y-8">
    <div class="pb-6 border-b border-brand-border/40">
        <h1 class="text-2xl font-black text-white">تنظیمات اصلی سیستم CIPCard</h1>
        <p class="text-xs text-gray-400 mt-1">ویرایش قیمت کارت‌ها، درگاه بانکی زرین‌پال و وب‌سرویس پیامک</p>
    </div>

    <form action="<?= \App\Core\Helper::url('admin/settings') ?>" method="POST" class="space-y-6">
        <?= \App\Core\Csrf::field() ?>

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

        <!-- General Info -->
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-4">
            <h3 class="text-sm font-bold text-white mb-4 border-r-2 border-brand-gold pr-3">اطلاعات عمومی وب‌سایت</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">عنوان وب‌سایت</label>
                    <input type="text" name="site_title" value="<?= \App\Core\Helper::e(\App\Models\Setting::get('site_title', 'CIPCard | کارت ویزیت هوشمند NFC لوکس')) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">شماره تلفن پشتیبانی</label>
                    <input type="text" name="support_phone" value="<?= \App\Core\Helper::e(\App\Models\Setting::get('support_phone', '021-91000000')) ?>" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none font-mono">
                </div>
            </div>
        </div>

        <button type="submit" class="px-8 py-4 rounded-xl bg-brand-gold text-black font-extrabold text-sm hover:brightness-110 shadow-xl shadow-brand-gold/20 transition-all">
            ذخیره تنظیمات سیستم
        </button>
    </form>
</div>
