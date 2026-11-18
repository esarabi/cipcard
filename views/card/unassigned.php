<div class="max-w-lg mx-auto my-14 p-6 sm:p-10 rounded-3xl bg-white border border-slate-200 shadow-2xl shadow-slate-200/50 text-center space-y-6">

    <!-- Card Brand & Badge -->
    <div class="space-y-3">
        <div class="w-16 h-16 rounded-3xl bg-gradient-to-tr from-amber-600 via-amber-500 to-amber-400 p-0.5 mx-auto shadow-lg shadow-amber-500/20 flex items-center justify-center">
            <div class="w-full h-full bg-slate-900 rounded-[22px] flex items-center justify-center text-amber-400">
                <i data-lucide="nfc" class="w-8 h-8"></i>
            </div>
        </div>

        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/15 text-amber-700 border border-amber-500/30 text-xs font-bold font-mono">
            <span>کد کارت:</span>
            <span dir="ltr"><?= \App\Core\Helper::e($card['card_code']) ?></span>
        </span>

        <h1 class="text-2xl font-black text-slate-900">کارت هوشمند CIPCard</h1>
        <p class="text-xs text-slate-500 leading-relaxed max-w-sm mx-auto">
            این کارت هوشمند با موفقیت تولید و چاپ گردیده است و در حال حاضر در انتظار اتصال به پروفایل کاربر می‌باشد.
        </p>
    </div>

    <!-- QR Code Visual -->
    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 inline-block shadow-inner">
        <img src="<?= $qrCodeDataUri ?>" alt="QR Code" class="w-48 h-48 mx-auto object-contain">
        <div class="text-[11px] text-slate-400 font-mono mt-3">
            <?= \App\Core\Helper::url('c/' . $card['card_code']) ?>
        </div>
    </div>

    <!-- Batch details if present -->
    <?php if (!empty($card['batch_name'])): ?>
        <div class="text-[11px] text-slate-400">
            <span>دسته چاپ:</span>
            <span class="font-bold text-slate-600"><?= \App\Core\Helper::e($card['batch_name']) ?></span>
        </div>
    <?php endif; ?>

    <!-- Action Buttons -->
    <div class="space-y-3 pt-2">
        <?php if ($isAdmin): ?>
            <a href="<?= \App\Core\Helper::url('admin/cards?q=' . urlencode($card['card_code'])) ?>" class="w-full py-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs shadow-md transition-all flex items-center justify-center gap-2">
                <i data-lucide="shield-check" class="w-4 h-4 text-amber-400"></i>
                <span>اتصال این کارت در پنل ادمین</span>
            </a>
        <?php elseif ($isLoggedIn): ?>
            <form action="<?= \App\Core\Helper::url('c/' . $card['card_code'] . '/claim') ?>" method="POST">
                <?= \App\Core\Csrf::field() ?>
                <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-amber-600 via-amber-500 to-amber-400 text-slate-950 font-extrabold text-sm shadow-lg shadow-amber-500/25 hover:brightness-105 active:scale-95 transition-all flex items-center justify-center gap-2">
                    <i data-lucide="link-2" class="w-4 h-4"></i>
                    <span>اتصال این کارت به پروفایل من</span>
                </button>
            </form>
        <?php else: ?>
            <a href="<?= \App\Core\Helper::url('auth/login') ?>" class="w-full py-4 rounded-xl bg-gradient-to-r from-amber-600 via-amber-500 to-amber-400 text-slate-950 font-extrabold text-sm shadow-lg shadow-amber-500/25 hover:brightness-105 active:scale-95 transition-all flex items-center justify-center gap-2">
                <i data-lucide="log-in" class="w-4 h-4"></i>
                <span>ورود به حساب کاربری جهت فعال‌سازی</span>
            </a>
            <div class="pt-2">
                <a href="<?= \App\Core\Helper::url() ?>#pricing" class="text-xs text-slate-500 hover:text-amber-600 font-medium transition-colors">
                    سفارش کارت ویزیت هوشمند اختصاصی
                </a>
            </div>
        <?php endif; ?>
    </div>

</div>
