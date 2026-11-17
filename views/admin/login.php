<!DOCTYPE html>
<html lang="fa" dir="rtl" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود مدیریت - CIPCard</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        (function() {
            var saved = localStorage.getItem('cipcard_admin_theme') || 'light';
            document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>

    <style>
        html[data-theme="light"] body {
            background-color: #F8FAFC !important;
            color: #1E293B !important;
        }
        html[data-theme="light"] .login-card {
            background-color: #FFFFFF !important;
            border-color: #E2E8F0 !important;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.08) !important;
        }
        html[data-theme="light"] .text-white {
            color: #0F172A !important;
        }
        html[data-theme="light"] .text-gray-300 {
            color: #334155 !important;
        }
        html[data-theme="light"] .text-gray-400 {
            color: #64748B !important;
        }
        html[data-theme="light"] input {
            background-color: #F8FAFC !important;
            border-color: #CBD5E1 !important;
            color: #0F172A !important;
        }
        html[data-theme="light"] input:focus {
            background-color: #FFFFFF !important;
            border-color: #D4AF37 !important;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15) !important;
        }
    </style>
</head>
<body class="bg-[#070709] text-gray-200 font-sans min-h-screen flex flex-col items-center justify-center p-4 transition-colors duration-200">
    
    <!-- Top Theme Toggle -->
    <div class="max-w-md w-full flex justify-between items-center mb-4 px-2">
        <a href="<?= \App\Core\Helper::url() ?>" class="text-xs text-gray-400 hover:text-amber-500 transition-colors flex items-center gap-1.5 font-bold">
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
            <span>بازگشت به سایت اصلی</span>
        </a>

        <button type="button" onclick="toggleLoginTheme()" class="px-3 py-1.5 rounded-xl border border-gray-700/60 text-xs font-semibold flex items-center gap-1.5 transition-all hover:border-amber-400">
            <i id="theme-icon" data-lucide="sun" class="w-3.5 h-3.5 text-amber-500"></i>
            <span id="theme-text">تم روشن</span>
        </button>
    </div>

    <div class="login-card max-w-md w-full bg-[#121217] rounded-3xl border border-gray-800 p-8 space-y-6 shadow-2xl transition-all">
        <div class="text-center space-y-2">
            <div class="w-14 h-14 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-500 mx-auto flex items-center justify-center shadow-md">
                <i data-lucide="shield" class="w-7 h-7"></i>
            </div>
            <h1 class="text-xl font-black text-white">ورود به پنل مدیریت CIPCard</h1>
            <p class="text-xs text-gray-400">احراز هویت مدیران ارشد سیستم</p>
        </div>

        <?php if ($error = \App\Core\Session::getFlash('error')): ?>
            <div class="p-3.5 rounded-xl bg-red-500/10 border border-red-500/30 text-red-500 text-xs font-semibold">
                <?= \App\Core\Helper::e($error) ?>
            </div>
        <?php endif; ?>

        <form action="<?= \App\Core\Helper::url('admin/login') ?>" method="POST" class="space-y-4">
            <?= \App\Core\Csrf::field() ?>

            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1.5">شماره موبایل یا نام کاربری</label>
                <input type="text" name="username" required placeholder="09120000000 یا admin" dir="ltr" class="w-full px-4 py-3 rounded-xl bg-black/40 border border-gray-800 text-white text-xs focus:border-amber-400 focus:outline-none font-mono">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1.5">رمز عبور امنیتی</label>
                <input type="password" name="password" required placeholder="••••••••" dir="ltr" class="w-full px-4 py-3 rounded-xl bg-black/40 border border-gray-800 text-white text-xs focus:border-amber-400 focus:outline-none">
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 text-slate-950 font-black text-xs shadow-lg shadow-amber-500/20 hover:brightness-105 active:scale-95 transition-all">
                ورود به مدیریت
            </button>
        </form>
    </div>

    <script>
        function updateVisuals(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('cipcard_admin_theme', theme);
            var txt = document.getElementById('theme-text');
            var icon = document.getElementById('theme-icon');
            if (theme === 'light') {
                if (txt) txt.innerText = 'تم روشن';
                if (icon) icon.setAttribute('data-lucide', 'sun');
            } else {
                if (txt) txt.innerText = 'تم تیره';
                if (icon) icon.setAttribute('data-lucide', 'moon');
            }
            if (window.lucide) lucide.createIcons();
        }

        function toggleLoginTheme() {
            var curr = document.documentElement.getAttribute('data-theme') || 'light';
            var next = curr === 'light' ? 'dark' : 'light';
            updateVisuals(next);
        }

        document.addEventListener('DOMContentLoaded', function() {
            var saved = localStorage.getItem('cipcard_admin_theme') || 'light';
            updateVisuals(saved);
        });
    </script>
</body>
</html>
