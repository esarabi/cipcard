<div class="max-w-md mx-auto my-12 p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 shadow-2xl">
    
    <!-- STEP 1: Phone number -->
    <div id="login-step-phone" class="space-y-6">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-brand-gold/10 border border-brand-gold/30 text-brand-gold mx-auto flex items-center justify-center">
                <i data-lucide="key-round" class="w-6 h-6"></i>
            </div>
            <h1 class="text-2xl font-black text-white">ورود بدون رمز عبور</h1>
            <p class="text-xs text-gray-400">شماره موبایل خود را وارد کنید تا کد ورود یکبار مصرف برایتان پیامک شود.</p>
        </div>

        <form id="user-login-form" class="space-y-4">
            <?= \App\Core\Csrf::field() ?>
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1.5">شماره موبایل *</label>
                <input type="tel" id="login-mobile-input" name="mobile" required placeholder="09123456789" dir="ltr" class="w-full px-4 py-3.5 rounded-xl bg-brand-darker border border-brand-border text-white text-sm font-mono focus:border-brand-gold focus:outline-none text-left">
            </div>

            <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-brand-goldDark via-brand-gold to-brand-goldLight text-black font-extrabold text-sm shadow-xl shadow-brand-gold/20 hover:brightness-110 transition-all">
                دریافت کد تایید یکبار مصرف
            </button>
        </form>

        <div class="text-center pt-2">
            <a href="<?= \App\Core\Helper::url() ?>" class="text-xs text-gray-400 hover:text-white transition-colors">
                هنوز کارت نخریده‌اید؟ سفارش کارت هوشمند
            </a>
        </div>
    </div>

    <!-- STEP 2: Enter OTP Code -->
    <div id="login-step-code" class="hidden space-y-6">
        <div class="text-center space-y-2">
            <h2 class="text-2xl font-black text-white">کد تایید پیامکی</h2>
            <p class="text-xs text-gray-400">
                کد ۵ رقمی ارسالی به شماره <span id="login-mobile-text" class="font-mono text-brand-gold"></span> را وارد نمایید:
            </p>
        </div>

        <form id="user-verify-form" class="space-y-4">
            <div>
                <input type="text" id="login-code-input" maxlength="6" placeholder="• • • • •" dir="ltr" class="w-full text-center tracking-[1em] text-2xl font-mono px-4 py-3.5 rounded-xl bg-brand-darker border-2 border-brand-gold text-white focus:outline-none">
            </div>

            <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-brand-goldDark via-brand-gold to-brand-goldLight text-black font-extrabold text-sm shadow-xl shadow-brand-gold/20 hover:brightness-110 transition-all">
                تایید کد و ورود به پنل کاربری
            </button>
        </form>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('user-login-form');
    let targetMobile = '';

    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const mobileInput = document.getElementById('login-mobile-input');
            const submitBtn = loginForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            targetMobile = mobileInput.value.trim();
            if (!targetMobile) return;

            submitBtn.disabled = true;
            submitBtn.innerHTML = 'در حال ارسال کد...';

            const formData = new FormData(loginForm);

            try {
                const res = await fetch('/auth/otp/send', { method: 'POST', body: formData });
                const data = await res.json();
                if (data.success) {
                    document.getElementById('login-step-phone').classList.add('hidden');
                    document.getElementById('login-step-code').classList.remove('hidden');
                    document.getElementById('login-mobile-text').innerText = data.mobile;
                } else {
                    alert(data.message || 'خطا در ارسال کد.');
                }
            } catch (err) {
                alert('خطای اتصال.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }

    const verifyForm = document.getElementById('user-verify-form');
    if (verifyForm) {
        verifyForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const code = document.getElementById('login-code-input').value.trim();
            const submitBtn = verifyForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            if (!code) return;

            submitBtn.disabled = true;
            submitBtn.innerHTML = 'در حال بررسی...';

            const formData = new FormData();
            formData.append('mobile', targetMobile);
            formData.append('code', code);
            formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

            try {
                const res = await fetch('/auth/otp/verify', { method: 'POST', body: formData });
                const data = await res.json();
                if (data.success && data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message || 'کد تایید نامعتبر است.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            } catch (err) {
                alert('خطا در احراز هویت.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }
});
</script>
