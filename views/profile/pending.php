<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \App\Core\Helper::e($title ?? 'پروفایل در انتظار فعال‌سازی') ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#070709] text-gray-200 font-sans min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-[#121217] rounded-3xl border border-amber-500/30 p-8 text-center space-y-6 shadow-2xl">
        <div class="w-20 h-20 rounded-2xl bg-amber-500/10 border border-amber-500/30 mx-auto flex items-center justify-center text-amber-400">
            <i data-lucide="clock" class="w-10 h-10"></i>
        </div>

        <div class="space-y-2">
            <h1 class="text-2xl font-black text-white">این پروفایل در انتظار فعال‌سازی است</h1>
            <p class="text-xs text-gray-400 leading-relaxed">
                کارت ویزیت هوشمند مربوط به این آدرس ثبت شده و پس از تکمیل فرآیند تایید سفارش و پرداخت فعال خواهد شد.
            </p>
        </div>

        <div class="p-4 rounded-2xl bg-[#09090d] border border-gray-800 text-xs text-gray-300 flex items-center justify-between font-mono">
            <span>آدرس صفحه:</span>
            <span class="text-amber-400 font-bold">cipcard.ir/@<?= \App\Core\Helper::e($profile['mobile'] ?? '') ?></span>
        </div>

        <div class="pt-4 space-y-3">
            <a href="<?= \App\Core\Helper::url('auth/login') ?>" class="block w-full py-3.5 rounded-xl bg-gradient-to-r from-amber-600 to-amber-400 text-black font-extrabold text-sm shadow-lg shadow-amber-500/20 hover:brightness-110 transition-all">
                ورود به پنل کاربری جهت فعال‌سازی
            </a>
            <a href="<?= \App\Core\Helper::url() ?>" class="block text-xs text-gray-400 hover:text-white transition-colors">
                بازگشت به صفحه اصلی CIPCard
            </a>
        </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>
