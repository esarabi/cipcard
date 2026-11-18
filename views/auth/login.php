<div class="max-w-md mx-auto my-14 p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xl shadow-slate-200/50">
    
    <!-- Top Brand / Icon Header -->
    <div class="text-center space-y-2 mb-6">
        <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-600 mx-auto flex items-center justify-center shadow-sm">
            <i data-lucide="shield-check" class="w-6 h-6"></i>
        </div>
        <h1 class="text-2xl font-black text-slate-900">ورود به حساب کاربری</h1>
        <p class="text-xs text-slate-500">جهت دسترسی به پنل مدیریت کارت هوشمند خود وارد شوید</p>
    </div>

    <!-- Login Mode Tabs (OTP vs Password) -->
    <div class="grid grid-cols-2 p-1.5 bg-slate-100 rounded-2xl mb-6 text-xs font-bold border border-slate-200/80">
        <button type="button" id="tab-btn-otp" onclick="switchLoginTab('otp')" class="py-2.5 px-3 rounded-xl transition-all flex items-center justify-center gap-1.5 bg-white text-slate-900 shadow-sm border border-slate-200">
            <i data-lucide="smartphone" class="w-4 h-4 text-amber-600"></i>
            <span>پیامک یکبار مصرف (OTP)</span>
        </button>
        <button type="button" id="tab-btn-password" onclick="switchLoginTab('password')" class="py-2.5 px-3 rounded-xl transition-all flex items-center justify-center gap-1.5 text-slate-500 hover:text-slate-800">
            <i data-lucide="lock" class="w-4 h-4 text-slate-400"></i>
            <span>ورود با رمز عبور</span>
        </button>
    </div>

    <!-- ==================== MODE 1: OTP LOGIN ==================== -->
    <div id="login-mode-otp">
        <!-- STEP 1: Phone number -->
        <div id="login-step-phone" class="space-y-4">
            <form id="user-login-form" class="space-y-4">
                <?= \App\Core\Csrf::field() ?>
                <div>
                    <label for="login-mobile-input" class="block text-xs font-bold text-slate-700 mb-1.5">شماره موبایل *</label>
                    <div class="relative">
                        <input type="tel" id="login-mobile-input" name="mobile" required placeholder="09123456789" dir="ltr" class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-base font-mono placeholder:text-slate-400 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none text-left transition-all">
                    </div>
                </div>

                <button type="submit" id="btn-send-otp" class="w-full py-4 rounded-xl bg-gradient-to-r from-amber-600 via-amber-500 to-amber-400 text-slate-950 font-extrabold text-sm shadow-lg shadow-amber-500/25 hover:brightness-105 active:scale-95 transition-all flex items-center justify-center gap-2">
                    <span>دریافت کد تایید یکبار مصرف</span>
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                </button>
            </form>

            <div class="pt-2 text-center">
                <button type="button" onclick="switchLoginTab('password')" class="text-xs text-amber-600 hover:text-amber-700 font-bold transition-colors inline-flex items-center gap-1">
                    <i data-lucide="key" class="w-3.5 h-3.5"></i>
                    <span>قبلاً رمز عبور تعیین کرده‌اید؟ ورود با رمز عبور</span>
                </button>
            </div>
        </div>

        <!-- STEP 2: Enter OTP Code -->
        <div id="login-step-code" class="hidden space-y-5">
            <div class="text-center space-y-1.5">
                <p class="text-xs text-slate-500">
                    کد ۵ رقمی ارسالی به شماره <span id="login-mobile-text" class="font-mono text-amber-600 font-bold"></span> را وارد کنید:
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

    <!-- ==================== MODE 2: PASSWORD LOGIN ==================== -->
    <div id="login-mode-password" class="hidden space-y-4">
        <form id="user-password-form" class="space-y-4">
            <?= \App\Core\Csrf::field() ?>
            <div>
                <label for="login-pwd-mobile-input" class="block text-xs font-bold text-slate-700 mb-1.5">شماره موبایل *</label>
                <input type="tel" id="login-pwd-mobile-input" name="mobile" required placeholder="09123456789" dir="ltr" class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-base font-mono placeholder:text-slate-400 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none text-left transition-all">
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="login-password-input" class="block text-xs font-bold text-slate-700">رمز عبور *</label>
                </div>
                <div class="relative">
                    <input type="password" id="login-password-input" name="password" required placeholder="••••••••" dir="ltr" class="w-full pl-12 pr-4 py-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-base placeholder:text-slate-400 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none text-left transition-all">
                    <button type="button" onclick="togglePasswordVisibility('login-password-input', this)" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 p-1 rounded-lg focus:outline-none" title="نمایش / مخفی‌سازی رمز">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- Login Error Box -->
            <div id="login-pwd-error" class="hidden p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs flex items-start gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5 text-red-500"></i>
                <span id="login-pwd-error-msg"></span>
            </div>

            <button type="submit" id="btn-login-pwd" class="w-full py-4 rounded-xl bg-gradient-to-r from-amber-600 via-amber-500 to-amber-400 text-slate-950 font-extrabold text-sm shadow-lg shadow-amber-500/25 hover:brightness-105 active:scale-95 transition-all flex items-center justify-center gap-2">
                <i data-lucide="log-in" class="w-4 h-4"></i>
                <span>ورود با رمز عبور</span>
            </button>
        </form>

        <div class="p-3.5 rounded-xl bg-amber-50/70 border border-amber-200/80 text-[11px] text-amber-800 space-y-1">
            <div class="flex items-center gap-1.5 font-bold">
                <i data-lucide="help-circle" class="w-3.5 h-3.5 text-amber-600"></i>
                <span>رمز عبور را فراموش کرده‌اید یا هنوز تعیین نکرده‌اید؟</span>
            </div>
            <p class="leading-relaxed">
                می‌توانید به سادگی از طریق تب <button type="button" onclick="switchLoginTab('otp')" class="text-amber-700 underline font-extrabold hover:text-amber-900">پیامک یکبار مصرف (OTP)</button> وارد پنل شده و در بخش «امنیت و رمز عبور»، رمز عبور خود را تعیین یا تغییر دهید.
            </p>
        </div>
    </div>

    <!-- Purchase link footer -->
    <div class="text-center pt-4 border-t border-slate-100 mt-6">
        <a href="<?= \App\Core\Helper::url() ?>#pricing" class="text-xs text-slate-500 hover:text-amber-600 font-medium transition-colors">
            هنوز کارت نخریده‌اید؟ سفارش کارت هوشمند CIPCard
        </a>
    </div>

</div>

<script>
function switchLoginTab(mode) {
    const tabOtp = document.getElementById('tab-btn-otp');
    const tabPwd = document.getElementById('tab-btn-password');
    const modeOtp = document.getElementById('login-mode-otp');
    const modePwd = document.getElementById('login-mode-password');
    const mobileOtp = document.getElementById('login-mobile-input');
    const mobilePwd = document.getElementById('login-pwd-mobile-input');

    if (mode === 'password') {
        // Switch styling
        tabOtp.className = 'py-2.5 px-3 rounded-xl transition-all flex items-center justify-center gap-1.5 text-slate-500 hover:text-slate-800';
        tabOtp.querySelector('i')?.classList.replace('text-amber-600', 'text-slate-400');
        tabPwd.className = 'py-2.5 px-3 rounded-xl transition-all flex items-center justify-center gap-1.5 bg-white text-slate-900 shadow-sm border border-slate-200';
        tabPwd.querySelector('i')?.classList.replace('text-slate-400', 'text-amber-600');

        modeOtp.classList.add('hidden');
        modePwd.classList.remove('hidden');

        // Sync mobile if entered
        if (mobileOtp && mobileOtp.value.trim() && !mobilePwd.value.trim()) {
            mobilePwd.value = mobileOtp.value.trim();
        }
        mobilePwd.focus();
    } else {
        // OTP Mode
        tabPwd.className = 'py-2.5 px-3 rounded-xl transition-all flex items-center justify-center gap-1.5 text-slate-500 hover:text-slate-800';
        tabPwd.querySelector('i')?.classList.replace('text-amber-600', 'text-slate-400');
        tabOtp.className = 'py-2.5 px-3 rounded-xl transition-all flex items-center justify-center gap-1.5 bg-white text-slate-900 shadow-sm border border-slate-200';
        tabOtp.querySelector('i')?.classList.replace('text-slate-400', 'text-amber-600');

        modePwd.classList.add('hidden');
        modeOtp.classList.remove('hidden');

        if (mobilePwd && mobilePwd.value.trim() && !mobileOtp.value.trim()) {
            mobileOtp.value = mobilePwd.value.trim();
        }
        mobileOtp.focus();
    }
    if (window.lucide) lucide.createIcons();
}

function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    if (!input) return;
    const isPass = input.type === 'password';
    input.type = isPass ? 'text' : 'password';
    btn.innerHTML = isPass ? '<i data-lucide="eye-off" class="w-4 h-4 text-amber-600"></i>' : '<i data-lucide="eye" class="w-4 h-4"></i>';
    if (window.lucide) lucide.createIcons();
}

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

    // OTP Send Form Handler
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const mobileInput = document.getElementById('login-mobile-input');
            const submitBtn = document.getElementById('btn-send-otp');
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

    // OTP Verify Form Handler
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

    // Password Login Form Handler
    const pwdForm = document.getElementById('user-password-form');
    const pwdErrBox = document.getElementById('login-pwd-error');
    const pwdErrMsg = document.getElementById('login-pwd-error-msg');

    if (pwdForm) {
        pwdForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = document.getElementById('btn-login-pwd');
            const originalText = submitBtn.innerHTML;

            pwdErrBox.classList.add('hidden');

            const mobile = document.getElementById('login-pwd-mobile-input').value.trim();
            const password = document.getElementById('login-password-input').value;

            if (!mobile || !password) {
                pwdErrMsg.innerText = 'لطفاً شماره موبایل و رمز عبور را وارد کنید.';
                pwdErrBox.classList.remove('hidden');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = 'در حال بررسی اطلاعات...';

            const formData = new FormData(pwdForm);

            try {
                const res = await fetch('<?= \App\Core\Helper::url("auth/password/login") ?>', { method: 'POST', body: formData });
                const data = await res.json();

                if (data.success && data.redirect) {
                    submitBtn.innerHTML = 'ورود موفق! در حال انتقال...';
                    window.location.href = data.redirect;
                } else {
                    pwdErrMsg.innerText = data.message || 'اطلاعات ورود نادرست است.';
                    pwdErrBox.classList.remove('hidden');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                    if (window.lucide) lucide.createIcons();
                }
            } catch (err) {
                pwdErrMsg.innerText = 'خطای اتصال به سرور. لطفاً مجدداً تلاش نمایید.';
                pwdErrBox.classList.remove('hidden');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                if (window.lucide) lucide.createIcons();
            }
        });
    }
});
</script>
