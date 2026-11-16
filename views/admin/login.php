<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود مدیریت - CIPCard</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#070709] text-gray-200 font-sans min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-[#121217] rounded-3xl border border-gray-800 p-8 space-y-6 shadow-2xl">
        <div class="text-center space-y-2">
            <div class="w-14 h-14 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-400 mx-auto flex items-center justify-center">
                <i data-lucide="shield" class="w-7 h-7"></i>
            </div>
            <h1 class="text-xl font-black text-white">ورود به پنل مدیریت CIPCard</h1>
            <p class="text-xs text-gray-400">فقط مدیران مجاز سیستم</p>
        </div>

        <?php if ($error = \App\Core\Session::getFlash('error')): ?>
            <div class="p-3.5 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs">
                <?= \App\Core\Helper::e($error) ?>
            </div>
        <?php endif; ?>

        <form action="<?= \App\Core\Helper::url('admin/login') ?>" method="POST" class="space-y-4">
            <?= \App\Core\Csrf::field() ?>

            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1.5">شماره موبایل یا نام کاربری</label>
                <input type="text" name="username" required placeholder="09120000000" dir="ltr" class="w-full px-4 py-3 rounded-xl bg-black/40 border border-gray-800 text-white text-xs focus:border-amber-400 focus:outline-none font-mono">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1.5">رمز عبور امنیتی</label>
                <input type="password" name="password" required placeholder="••••••••" dir="ltr" class="w-full px-4 py-3 rounded-xl bg-black/40 border border-gray-800 text-white text-xs focus:border-amber-400 focus:outline-none">
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-amber-600 to-amber-400 text-black font-extrabold text-xs shadow-lg shadow-amber-500/20 hover:brightness-110 transition-all">
                ورود به مدیریت
            </button>
        </form>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>
