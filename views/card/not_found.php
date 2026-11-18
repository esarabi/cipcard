<div class="max-w-md mx-auto my-14 p-6 sm:p-10 rounded-3xl bg-white border border-slate-200 shadow-xl text-center space-y-6">
    <div class="w-14 h-14 rounded-2xl bg-red-500/10 text-red-600 border border-red-500/30 flex items-center justify-center mx-auto">
        <i data-lucide="help-circle" class="w-7 h-7"></i>
    </div>
    <div class="space-y-2">
        <h1 class="text-xl font-black text-slate-900">کارت هوشمند یافت نشد</h1>
        <p class="text-xs text-slate-500 leading-relaxed">
            کارت با شناسه <span class="font-mono text-red-600 font-bold"><?= \App\Core\Helper::e($code) ?></span> در سامانه CIPCard ثبت نشده است.
        </p>
    </div>
    <div>
        <a href="<?= \App\Core\Helper::url() ?>" class="inline-flex items-center gap-1.5 px-6 py-3 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800 transition-all">
            <i data-lucide="home" class="w-4 h-4"></i>
            <span>صفحه اصلی وب‌سایت</span>
        </a>
    </div>
</div>
