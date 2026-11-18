<div class="max-w-md mx-auto my-14 p-6 sm:p-10 rounded-3xl bg-white border border-slate-200 shadow-xl text-center space-y-6">
    <div class="w-14 h-14 rounded-2xl bg-amber-500/10 text-amber-600 border border-amber-500/30 flex items-center justify-center mx-auto">
        <i data-lucide="shield-alert" class="w-7 h-7"></i>
    </div>
    <div class="space-y-2">
        <h1 class="text-xl font-black text-slate-900">این کارت غیرفعال است</h1>
        <p class="text-xs text-slate-500 leading-relaxed">
            کارت با شناسه <span class="font-mono text-amber-600 font-bold"><?= \App\Core\Helper::e($card['card_code']) ?></span> مسدود یا غیرفعال شده است. در صورت نیاز به راهنمایی با پشتیبانی تماس حاصل فرمایید.
        </p>
    </div>
    <div>
        <a href="<?= \App\Core\Helper::url() ?>" class="inline-flex items-center gap-1.5 px-6 py-3 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800 transition-all">
            <i data-lucide="home" class="w-4 h-4"></i>
            <span>صفحه اصلی وب‌سایت</span>
        </a>
    </div>
</div>
