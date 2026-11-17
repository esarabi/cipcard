<div class="max-w-md mx-auto my-14 p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xl shadow-slate-200/50">
    
    <!-- STEP 1: Phone number -->
    <div id="login-step-phone" class="space-y-6">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-600 mx-auto flex items-center justify-center">
                <i data-lucide="key-round" class="w-6 h-6"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-900">ورود به حساب کاربری</h1>
            <p class="text-xs text-slate-500">شماره موبایل خود را وارد کنید تا کد ورود یکبار مصرف برایتان پیامک شود.</p>
        </div>

        <form id="user-login-form" class="space-y-4">
            <?= \App\Core\Csrf::field() ?>
            <div>
                <label for="login-mobile-input" class="block text-xs font-bold text-slate-700 mb-1.5">شماره موبایل *</label>
                <div class="relative">
                    <input type="tel" id="login-mobile-input" name="mobile" required placeholder="09123456789" dir="ltr" class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-base font-mono placeholder:text-slate-400 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none text-left transition-all">
                </div>
            </div>

            <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-amber-600 via-amber-500 to-amber-400 text-slate-950 font-extrabold text-sm shadow-lg shadow-amber-500/25 hover:brightness-105 active:scale-95 transition-all flex items-center justify-center gap-2">
                <span>دریافت کد تایید یکبار مصرف</span>
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </button>
        </form>

        <div class="text-center pt-2">
            <a href="<?= \App\Core\Helper::url() ?>#pricing" class="text-xs text-slate-500 hover:text-amber-600 font-medium transition-colors">
                هنوز کارت نخریده‌اید؟ سفارش کارت هوشمند CIPCard
            </a>
        </div>
    </div>

    <!-- STEP 2: Enter OTP Code -->
    <div id="login-step-code" class="hidden space-y-6">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-600 mx-auto flex items-center justify-center">
                <i data-lucide="shield-check" class="w-6 h-6"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-900">کد تایید پیامکی</h2>
            <p class="text-xs text-slate-500">
                کد ۵ رقمی ارسالی به شماره <span id="login-mobile-text" class="font-mono text-amber-600 font-bold"></span> را وارد نمایید:
            </p>
        </div>

        <form id="user-verify-form" class="space-y-4">
            <div>
                <input type="text" id="login-code-input" maxlength="6" placeholder="• • • • •" dir="ltr" class="w-full text-center tracking-[0.5em] text-3xl font-mono font-bold px-4 py-3.5 rounded-xl bg-slate-50 border-2 border-amber-500 text-slate-900 placeholder:text-slate-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/20 transition-all">
            </div>

            <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-amber-600 via-amber-500 to-amber-400 text-slate-950 font-extrabold text-sm shadow-lg shadow-amber-500/25 hover:brightness-105 active:scale-95 transition-all flex items-center justify-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                <span>تایید کد و ورود به پنل کاربری</span>
            </button>

            <div class="text-center pt-1">
                <button type="button" id="back-to-phone-btn" class="text-xs text-slate-500 hover:text-amber-600 font-medium transition-colors flex items-center justify-center gap-1 mx-auto">
                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                    <span>ویرایش شماره موبایل</span>
                </button>
            </div>
        </form>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('user-login-form');
    const backBtn = document.getElementById('back-to-phone-btn');
    let targetMobile = '';

    if (backBtn) {
        backBtn.addEventListener('click', () => {
            document.getElementById('login-step-code').classList.add('hidden');
            document.getElementById('login-step-phone').classList.remove('hidden');
            document.getElementById('login-mobile-input').focus();
        });
    }

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
                const res = await fetch('<?= \App\Core\Helper::url("auth/otp/send") ?>', { method: 'POST', body: formData });
                const data = await res.json();
                if (data.success) {
                    document.getElementById('login-step-phone').classList.add('hidden');
                    document.getElementById('login-step-code').classList.remove('hidden');
                    document.getElementById('login-mobile-text').innerText = data.mobile;
                    document.getElementById('login-code-input').focus();
                    if (window.lucide) lucide.createIcons();
                } else {
                    alert(data.message || 'خطا در ارسال کد.');
                }
            } catch (err) {
                alert('خطای اتصال به سرور.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                if (window.lucide) lucide.createIcons();
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
            submitBtn.innerHTML = 'در حال بررسی کد...';

            const formData = new FormData();
            formData.append('mobile', targetMobile);
            formData.append('code', code);
            formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

            try {
                const res = await fetch('<?= \App\Core\Helper::url("auth/otp/verify") ?>', { method: 'POST', body: formData });
                const data = await res.json();
                if (data.success && data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message || 'کد تایید وارد شده نامعتبر یا منقضی شده است.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                    if (window.lucide) lucide.createIcons();
                }
            } catch (err) {
                alert('خطا در احراز هویت.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                if (window.lucide) lucide.createIcons();
            }
        });
    }
});
</script>
