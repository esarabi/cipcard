/**
 * CIPCard Platform - Client-side Flow & Interactive Controls
 */

let otpTimerInterval = null;
let currentMobileNumber = '';

function openFastOrderModal(cardType = 'default_cip', templateId = null) {
    const modal = document.getElementById('fast-order-modal');
    if (!modal) return;

    const cardTypeInput = document.getElementById('modal-card-type');
    if (cardTypeInput) {
        cardTypeInput.value = cardType;
    }

    if (templateId) {
        const templateSelect = document.getElementById('modal-template-select');
        if (templateSelect) {
            templateSelect.value = templateId;
        }
    }

    // Update active tab visual
    selectCardType(cardType);

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeFastOrderModal() {
    const modal = document.getElementById('fast-order-modal');
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

function selectCardType(type) {
    const defaultBtn = document.getElementById('btn-type-default');
    const customBtn = document.getElementById('btn-type-custom');
    const cardTypeInput = document.getElementById('modal-card-type');

    if (cardTypeInput) cardTypeInput.value = type;

    if (type === 'default_cip') {
        if (defaultBtn) defaultBtn.className = "flex-1 py-3 px-4 rounded-xl text-center text-sm font-bold border-2 border-amber-500 bg-amber-50 text-amber-800 transition-all";
        if (customBtn) customBtn.className = "flex-1 py-3 px-4 rounded-xl text-center text-sm font-semibold border border-slate-300 bg-slate-50 text-slate-600 hover:text-slate-900 transition-all";
    } else {
        if (customBtn) customBtn.className = "flex-1 py-3 px-4 rounded-xl text-center text-sm font-bold border-2 border-amber-500 bg-amber-50 text-amber-800 transition-all";
        if (defaultBtn) defaultBtn.className = "flex-1 py-3 px-4 rounded-xl text-center text-sm font-semibold border border-slate-300 bg-slate-50 text-slate-600 hover:text-slate-900 transition-all";
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Fast Order Form Handler
    const fastOrderForm = document.getElementById('fast-order-form');
    if (fastOrderForm) {
        fastOrderForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = fastOrderForm.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="animate-spin inline-block mr-2">⏳</span> در حال ثبت و ارسال پیامک...';

            const formData = new FormData(fastOrderForm);

            try {
                const response = await fetch('/api/order/fast', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });

                const data = await response.json();

                if (data.success) {
                    currentMobileNumber = data.mobile;
                    // Transition to OTP Step
                    document.getElementById('step-order-form').classList.add('hidden');
                    document.getElementById('step-otp-form').classList.remove('hidden');
                    document.getElementById('otp-mobile-display').innerText = data.mobile;
                    startOtpTimer();
                } else {
                    alert(data.message || 'خطا در ثبت اطلاعات.');
                }
            } catch (err) {
                alert('خطای اتصال به سرور. لطفاً مجدداً تلاش کنید.');
                console.error(err);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    }

    // OTP Verification Handler
    const otpVerifyForm = document.getElementById('otp-verify-form');
    if (otpVerifyForm) {
        otpVerifyForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = otpVerifyForm.querySelector('button[type="submit"]');
            const codeInput = document.getElementById('otp-code-input');
            const originalBtnText = submitBtn.innerHTML;

            const code = codeInput.value.trim();
            if (!code || code.length < 4) {
                alert('لطفاً کد تایید ۴ تا ۵ رقمی را وارد کنید.');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="animate-spin inline-block mr-2">⏳</span> در حال بررسی و انتقال به درگاه...';

            const formData = new FormData();
            formData.append('mobile', currentMobileNumber);
            formData.append('code', code);
            formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

            try {
                const response = await fetch('/auth/otp/verify', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success && data.redirect) {
                    // Step 3: Direct redirect to Zarinpal or Dashboard
                    window.location.href = data.redirect;
                } else {
                    alert(data.message || 'کد تایید اشتباه است.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            } catch (err) {
                alert('خطا در برقراری ارتباط.');
                console.error(err);
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    }
});

function startOtpTimer() {
    let timeLeft = 120; // 2 minutes
    const timerDisplay = document.getElementById('otp-timer');
    const resendBtn = document.getElementById('btn-resend-otp');

    if (resendBtn) resendBtn.classList.add('hidden');
    if (timerDisplay) timerDisplay.classList.remove('hidden');

    if (otpTimerInterval) clearInterval(otpTimerInterval);

    otpTimerInterval = setInterval(() => {
        timeLeft--;
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        if (timerDisplay) {
            timerDisplay.innerText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds} تا ارسال مجدد`;
        }

        if (timeLeft <= 0) {
            clearInterval(otpTimerInterval);
            if (timerDisplay) timerDisplay.classList.add('hidden');
            if (resendBtn) resendBtn.classList.remove('hidden');
        }
    }, 1000);
}

async function resendOtp() {
    if (!currentMobileNumber) return;
    const resendBtn = document.getElementById('btn-resend-otp');
    resendBtn.innerText = 'در حال ارسال مجدد...';

    const formData = new FormData();
    formData.append('mobile', currentMobileNumber);
    formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

    try {
        const response = await fetch('/auth/otp/send', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        if (data.success) {
            alert('کد تایید مجدداً پیامک شد.');
            startOtpTimer();
        } else {
            alert(data.message || 'خطا در ارسال مجدد.');
        }
    } catch (e) {
        alert('خطای اتصال.');
    } finally {
        resendBtn.innerText = 'ارسال مجدد کد تایید';
    }
}
