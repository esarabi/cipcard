<!DOCTYPE html>
<html lang="fa" dir="rtl" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \App\Core\Helper::e($title ?? 'داشبورد کاربری - CIPCard') ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script>
        (function() {
            var savedTheme = localStorage.getItem('cipcard_user_theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: ['class', '[data-theme="dark"]'],
            theme: {
                extend: {
                    colors: {
                        brand: {
                            gold: '#D4AF37',
                            goldLight: '#F3E5AB',
                            goldDark: '#B8860B',
                            dark: '#0A0A0C',
                            darker: '#050507',
                            surface: '#121217',
                            surfaceHover: '#1A1A22',
                            border: '#2A2A36'
                        }
                    },
                    fontFamily: {
                        sans: ['Vazirmatn', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="<?= \App\Core\Helper::asset('css/style.css') ?>">

    <style>
        /* Light Theme for Customer Panel */
        html[data-theme="light"] body {
            background-color: #F8FAFC !important;
            color: #1E293B !important;
        }

        html[data-theme="light"] .bg-brand-surface {
            background-color: #FFFFFF !important;
            border-color: #E2E8F0 !important;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04) !important;
        }

        html[data-theme="light"] .bg-brand-darker {
            background-color: #F1F5F9 !important;
            border-color: #E2E8F0 !important;
        }

        html[data-theme="light"] .bg-brand-surfaceHover {
            background-color: #F8FAFC !important;
        }

        html[data-theme="light"] aside {
            background-color: #FFFFFF !important;
            border-left-color: #E2E8F0 !important;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.03) !important;
        }

        html[data-theme="light"] .text-white {
            color: #0F172A !important;
        }

        html[data-theme="light"] .text-gray-200 {
            color: #1E293B !important;
        }

        html[data-theme="light"] .text-gray-300 {
            color: #334155 !important;
        }

        html[data-theme="light"] .text-gray-400 {
            color: #64748B !important;
        }

        html[data-theme="light"] .text-gray-500 {
            color: #94A3B8 !important;
        }

        html[data-theme="light"] .border-brand-border,
        html[data-theme="light"] .border-brand-border\/60,
        html[data-theme="light"] .border-brand-border\/40 {
            border-color: #E2E8F0 !important;
        }

        html[data-theme="light"] input:not([type="checkbox"]):not([type="radio"]),
        html[data-theme="light"] select,
        html[data-theme="light"] textarea {
            background-color: #FFFFFF !important;
            border-color: #CBD5E1 !important;
            color: #0F172A !important;
        }

        html[data-theme="light"] input:focus,
        html[data-theme="light"] select:focus,
        html[data-theme="light"] textarea:focus {
            border-color: #D4AF37 !important;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15) !important;
        }

        html[data-theme="light"] .bg-black\/40,
        html[data-theme="light"] .bg-black\/30,
        html[data-theme="light"] .bg-black\/20 {
            background-color: #F1F5F9 !important;
            border-color: #E2E8F0 !important;
        }

        /* Active Nav Link */
        html[data-theme="light"] .user-nav-active {
            background-color: #FEF3C7 !important;
            color: #92400E !important;
            border-color: #FCD34D !important;
        }

        html[data-theme="dark"] .user-nav-active {
            background-color: rgba(212, 175, 55, 0.1) !important;
            color: #D4AF37 !important;
            border-color: rgba(212, 175, 55, 0.2) !important;
        }
    </style>
</head>
<body class="bg-brand-darker text-gray-200 font-sans antialiased min-h-screen flex flex-col md:flex-row transition-colors duration-200">

    <!-- Mobile Top Header -->
    <div class="md:hidden bg-brand-surface border-b border-brand-border/60 p-4 flex items-center justify-between">
        <a href="<?= \App\Core\Helper::url() ?>" class="flex items-center gap-2">
            <i data-lucide="nfc" class="w-6 h-6 text-amber-500"></i>
            <span class="font-black text-white tracking-wider">CIP<span class="text-amber-500">CARD</span></span>
        </a>
        <div class="flex items-center gap-2">
            <button type="button" onclick="toggleUserTheme()" class="p-2 rounded-xl border border-brand-border text-xs flex items-center gap-1">
                <i data-lucide="sun-moon" class="w-4 h-4 text-amber-500"></i>
            </button>
            <a href="<?= \App\Core\Helper::url('auth/logout') ?>" class="text-xs text-red-500 font-bold flex items-center gap-1 p-2">
                <i data-lucide="log-out" class="w-4 h-4"></i>
            </a>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <aside class="w-full md:w-64 bg-brand-surface border-l border-brand-border/60 flex-shrink-0 flex flex-col justify-between p-6">
        <div class="space-y-6">
            <div class="hidden md:flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-brand-goldDark to-brand-gold p-0.5 flex items-center justify-center shadow-md shadow-brand-gold/20">
                    <div class="w-full h-full bg-slate-900 rounded-[14px] flex items-center justify-center">
                        <i data-lucide="nfc" class="w-5 h-5 text-amber-400"></i>
                    </div>
                </div>
                <div>
                    <span class="text-xl font-black tracking-wider text-white">CIP<span class="text-amber-500">CARD</span></span>
                    <span class="block text-[10px] text-amber-600 font-mono tracking-widest uppercase font-bold">Customer Portal</span>
                </div>
            </div>

            <!-- Theme Switcher Button for Customer Dashboard -->
            <div class="pt-1">
                <button type="button" onclick="toggleUserTheme()" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border border-brand-border bg-brand-darker hover:border-amber-400 transition-all text-xs font-semibold group">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-amber-400/20 text-amber-600 flex items-center justify-center">
                            <i id="user-theme-icon" data-lucide="sun" class="w-3.5 h-3.5"></i>
                        </span>
                        <span id="user-theme-label" class="text-xs font-bold text-gray-300">تم روشن</span>
                    </div>
                    <span id="user-theme-badge" class="text-[10px] px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-700 font-bold border border-amber-500/30">
                        سوییچ
                    </span>
                </button>
            </div>

            <!-- User Info Badge -->
            <div class="bg-brand-darker p-3.5 rounded-2xl border border-brand-border/40 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-amber-500/20 text-amber-600 border border-amber-400/40 flex items-center justify-center font-black text-sm">
                    <?= mb_substr(\App\Core\Session::get('user_name', 'مشتری'), 0, 1) ?>
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-bold text-white truncate"><?= \App\Core\Helper::e(\App\Core\Session::get('user_name')) ?></p>
                    <p class="text-[11px] text-gray-400 font-mono dir-ltr text-right"><?= \App\Core\Helper::e(\App\Core\Session::get('user_mobile')) ?></p>
                </div>
            </div>

            <!-- Menu Navigation Links -->
            <nav class="space-y-1.5 pt-2">
                <?php
                $uri = $_SERVER['REQUEST_URI'] ?? '';
                $isRev = str_contains($uri, 'reviews');
                $isDash = (!str_contains($uri, 'profile') && !str_contains($uri, 'tracking') && !str_contains($uri, 'reviews'));
                $isProf = str_contains($uri, 'profile');
                $isTrack = str_contains($uri, 'tracking');

                $pendingCount = 0;
                try {
                    $navUserId = (int)\App\Core\Session::get('user_id');
                    if ($navUserId > 0) {
                        $navProf = \App\Models\Profile::findByUserId($navUserId);
                        if ($navProf) {
                            $pendingCount = \App\Models\Review::countPendingByProfileId((int)$navProf['id']);
                        }
                    }
                } catch (\Throwable $e) {}
                ?>

                <a href="<?= \App\Core\Helper::url('dashboard') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all <?= $isDash ? 'user-nav-active' : 'text-gray-300 hover:bg-brand-surfaceHover hover:text-white' ?>">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-amber-500"></i>
                    <span>میز کار (داشبورد)</span>
                </a>

                <a href="<?= \App\Core\Helper::url('dashboard/profile') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all <?= $isProf ? 'user-nav-active' : 'text-gray-300 hover:bg-brand-surfaceHover hover:text-white' ?>">
                    <i data-lucide="user-cog" class="w-4 h-4 text-amber-500"></i>
                    <span>ویرایش پروفایل هوشمند</span>
                </a>

                <a href="<?= \App\Core\Helper::url('dashboard/reviews') ?>" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all <?= $isRev ? 'user-nav-active' : 'text-gray-300 hover:bg-brand-surfaceHover hover:text-white' ?>">
                    <div class="flex items-center gap-3">
                        <i data-lucide="star" class="w-4 h-4 text-amber-500"></i>
                        <span>نظرات و امتیازها</span>
                    </div>
                    <?php if ($pendingCount > 0): ?>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-amber-500 text-black shadow-sm animate-pulse">
                            <?= $pendingCount ?>
                        </span>
                    <?php endif; ?>
                </a>

                <a href="<?= \App\Core\Helper::url('dashboard/tracking') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all <?= $isTrack ? 'user-nav-active' : 'text-gray-300 hover:bg-brand-surfaceHover hover:text-white' ?>">
                    <i data-lucide="truck" class="w-4 h-4 text-amber-500"></i>
                    <span>پیگیری وضعیت سفارش</span>
                </a>

                <a href="<?= \App\Core\Helper::url() ?>" target="_blank" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-gray-400 hover:bg-brand-surfaceHover hover:text-white transition-all">
                    <i data-lucide="external-link" class="w-4 h-4 text-amber-500"></i>
                    <span>مشاهده سایت اصلی</span>
                </a>
            </nav>
        </div>

        <div class="pt-6 border-t border-brand-border/40">
            <a href="<?= \App\Core\Helper::url('auth/logout') ?>" class="flex items-center gap-2 p-2.5 rounded-xl text-xs text-red-500 font-semibold hover:bg-red-500/10 transition-colors">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                <span>خروج از حساب</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-grow p-4 md:p-8 max-w-6xl overflow-y-auto">
        <!-- Flash Alert Messages -->
        <?php if ($successMsg = \App\Core\Session::getFlash('success')): ?>
            <div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-500 flex items-center gap-3 text-sm font-semibold">
                <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0 text-emerald-500"></i>
                <span><?= \App\Core\Helper::e($successMsg) ?></span>
            </div>
        <?php endif; ?>

        <?php if ($errorMsg = \App\Core\Session::getFlash('error')): ?>
            <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-500 flex items-center gap-3 text-sm font-semibold">
                <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 text-red-500"></i>
                <span><?= \App\Core\Helper::e($errorMsg) ?></span>
            </div>
        <?php endif; ?>

        <?php if ($warningMsg = \App\Core\Session::getFlash('warning')): ?>
            <div class="mb-6 p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-500 flex items-center gap-3 text-sm font-semibold">
                <i data-lucide="alert-triangle" class="w-5 h-5 flex-shrink-0 text-amber-500"></i>
                <span><?= \App\Core\Helper::e($warningMsg) ?></span>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </main>

    <!-- Theme Toggle Scripts -->
    <script>
        function updateUserThemeVisuals(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('cipcard_user_theme', theme);

            var label = document.getElementById('user-theme-label');
            var icon = document.getElementById('user-theme-icon');

            if (theme === 'light') {
                if (label) label.innerText = 'تم روشن (فعال)';
                if (icon) icon.setAttribute('data-lucide', 'sun');
            } else {
                if (label) label.innerText = 'تم تیره (فعال)';
                if (icon) icon.setAttribute('data-lucide', 'moon');
            }

            if (window.lucide) {
                lucide.createIcons();
            }
        }

        function toggleUserTheme() {
            var current = document.documentElement.getAttribute('data-theme') || 'light';
            var next = current === 'light' ? 'dark' : 'light';
            updateUserThemeVisuals(next);
        }

        document.addEventListener('DOMContentLoaded', function() {
            var saved = localStorage.getItem('cipcard_user_theme') || 'light';
            updateUserThemeVisuals(saved);
            lucide.createIcons();
        });
    </script>
</body>
</html>
