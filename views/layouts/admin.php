<!DOCTYPE html>
<html lang="fa" dir="rtl" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \App\Core\Helper::e($title ?? 'پنل مدیریت - CIPCard') ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Early theme init script to prevent flash -->
    <script>
        (function() {
            var savedTheme = localStorage.getItem('cipcard_admin_theme') || 'light';
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
    <!-- Chart.js for Business Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="<?= \App\Core\Helper::asset('css/style.css') ?>">

    <style>
        /* =========================================================
           Admin Light Theme Variables & Core Overrides
           ========================================================= */
        html[data-theme="light"] body {
            background-color: #F8FAFC !important;
            color: #1E293B !important;
        }

        /* Light Cards & Surfaces */
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

        /* Light Typography */
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

        /* Light Borders */
        html[data-theme="light"] .border-brand-border,
        html[data-theme="light"] .border-brand-border\/60,
        html[data-theme="light"] .border-brand-border\/40 {
            border-color: #E2E8F0 !important;
        }

        html[data-theme="light"] .divide-brand-border\/40 > :not([hidden]) ~ :not([hidden]) {
            border-color: #E2E8F0 !important;
        }

        /* Light Form Inputs */
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

        /* Light Tables */
        html[data-theme="light"] table thead tr {
            background-color: #F8FAFC !important;
            border-color: #E2E8F0 !important;
            color: #475569 !important;
        }

        html[data-theme="light"] table tbody tr:hover {
            background-color: #F8FAFC !important;
        }

        html[data-theme="light"] .bg-black\/40,
        html[data-theme="light"] .bg-black\/30,
        html[data-theme="light"] .bg-black\/20 {
            background-color: #F1F5F9 !important;
            border-color: #E2E8F0 !important;
        }

        /* Navigation Active Link in Light Mode */
        html[data-theme="light"] .nav-link-active {
            background-color: #FEF3C7 !important;
            color: #92400E !important;
            border-color: #FCD34D !important;
        }

        html[data-theme="dark"] .nav-link-active {
            background-color: rgba(212, 175, 55, 0.1) !important;
            color: #D4AF37 !important;
            border-color: rgba(212, 175, 55, 0.2) !important;
        }
    </style>
</head>
<body class="bg-brand-darker text-gray-200 font-sans antialiased min-h-screen flex flex-col md:flex-row transition-colors duration-200">

    <!-- Sidebar Navigation -->
    <aside class="w-full md:w-64 bg-brand-surface border-l border-brand-border/60 flex-shrink-0 flex flex-col justify-between p-6">
        <div class="space-y-6">
            <!-- Brand & Master Control Title -->
            <div class="flex items-center justify-between">
                <a href="<?= \App\Core\Helper::url('admin') ?>" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-goldDark to-brand-gold p-0.5 flex items-center justify-center shadow-md shadow-brand-gold/20">
                        <div class="w-full h-full bg-slate-900 rounded-[10px] flex items-center justify-center">
                            <i data-lucide="shield" class="w-5 h-5 text-brand-gold"></i>
                        </div>
                    </div>
                    <div>
                        <span class="text-xl font-black tracking-wider text-white">CIP<span class="text-amber-500">ADMIN</span></span>
                        <span class="block text-[10px] text-amber-600 font-mono tracking-widest uppercase font-bold">Master Control</span>
                    </div>
                </a>
            </div>

            <!-- Theme Switcher Button (Light / Dark Toggle) -->
            <div class="pt-2">
                <button type="button" onclick="toggleAdminTheme()" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border border-brand-border bg-brand-darker hover:border-amber-400 transition-all text-xs font-semibold group">
                    <div class="flex items-center gap-2">
                        <span id="theme-icon-container" class="w-6 h-6 rounded-lg bg-amber-400/20 text-amber-600 flex items-center justify-center">
                            <i id="theme-icon" data-lucide="sun" class="w-3.5 h-3.5"></i>
                        </span>
                        <span id="theme-label" class="text-xs font-bold text-gray-300">تم روشن</span>
                    </div>
                    <span id="theme-sub-badge" class="text-[10px] px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-700 font-bold border border-amber-500/30">
                        سوییچ
                    </span>
                </button>
            </div>

            <!-- Admin Profile Info -->
            <div class="bg-brand-darker p-3.5 rounded-2xl border border-brand-border/40 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-amber-500/20 text-amber-600 border border-amber-400/40 flex items-center justify-center font-black text-sm">
                    CIP
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-bold text-white truncate"><?= \App\Core\Helper::e(\App\Core\Session::get('user_name', 'مدیر ارشد')) ?></p>
                    <p class="text-[11px] text-gray-400 font-mono dir-ltr text-right"><?= \App\Core\Helper::e(\App\Core\Session::get('user_mobile')) ?></p>
                </div>
            </div>

            <!-- Menu Navigation Links -->
            <nav class="space-y-1.5 pt-2">
                <?php
                $currentUri = $_SERVER['REQUEST_URI'] ?? '';
                $isDashboard = ($currentUri === '/admin' || $currentUri === '/admin/' || str_ends_with($currentUri, 'admin'));
                $isOrders = str_contains($currentUri, 'admin/orders');
                $isUsers = str_contains($currentUri, 'admin/users');
                $isTransactions = str_contains($currentUri, 'admin/transactions');
                $isSettings = str_contains($currentUri, 'admin/settings');
                ?>

                <a href="<?= \App\Core\Helper::url('admin') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all <?= $isDashboard && !$isOrders && !$isUsers && !$isTransactions && !$isSettings ? 'nav-link-active' : 'text-gray-300 hover:bg-brand-surfaceHover hover:text-white' ?>">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-amber-500"></i>
                    <span>داشبورد و آمار</span>
                </a>

                <a href="<?= \App\Core\Helper::url('admin/orders') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all <?= $isOrders ? 'nav-link-active' : 'text-gray-300 hover:bg-brand-surfaceHover hover:text-white' ?>">
                    <i data-lucide="shopping-bag" class="w-4 h-4 text-amber-500"></i>
                    <span>مدیریت سفارشات</span>
                </a>

                <a href="<?= \App\Core\Helper::url('admin/users') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all <?= $isUsers ? 'nav-link-active' : 'text-gray-300 hover:bg-brand-surfaceHover hover:text-white' ?>">
                    <i data-lucide="users" class="w-4 h-4 text-amber-500"></i>
                    <span>کاربران و پروفایل‌ها</span>
                </a>

                <a href="<?= \App\Core\Helper::url('admin/transactions') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all <?= $isTransactions ? 'nav-link-active' : 'text-gray-300 hover:bg-brand-surfaceHover hover:text-white' ?>">
                    <i data-lucide="receipt" class="w-4 h-4 text-amber-500"></i>
                    <span>تراکنش‌های مالی</span>
                </a>

                <a href="<?= \App\Core\Helper::url('admin/settings') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all <?= $isSettings ? 'nav-link-active' : 'text-gray-300 hover:bg-brand-surfaceHover hover:text-white' ?>">
                    <i data-lucide="sliders" class="w-4 h-4 text-amber-500"></i>
                    <span>تنظیمات سیستم</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Bottom Footer -->
        <div class="pt-6 border-t border-brand-border/40 space-y-2.5">
            <a href="<?= \App\Core\Helper::url() ?>" target="_blank" class="flex items-center justify-between p-2.5 rounded-xl border border-brand-border/50 text-xs text-gray-400 hover:text-white hover:bg-brand-surfaceHover transition-all">
                <span class="flex items-center gap-2">
                    <i data-lucide="external-link" class="w-3.5 h-3.5 text-amber-500"></i>
                    <span>مشاهده سایت اصلی</span>
                </span>
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 text-gray-500"></i>
            </a>

            <a href="<?= \App\Core\Helper::url('auth/logout') ?>" class="flex items-center gap-2 p-2.5 rounded-xl text-xs text-red-500 font-semibold hover:bg-red-500/10 transition-colors">
                <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                <span>خروج از پنل مدیریت</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-grow p-4 md:p-8 max-w-7xl overflow-y-auto">
        
        <!-- Top Utility Bar for Mobile & Desktop -->
        <div class="flex items-center justify-between pb-6 mb-6 border-b border-brand-border/40">
            <div class="flex items-center gap-3">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                <span class="text-xs font-bold text-gray-400">سیستم مدیریت متمرکز کارت هوشمند CIPCard</span>
            </div>

            <!-- Quick Actions Top Bar -->
            <div class="flex items-center gap-3">
                <!-- Theme toggle pill button -->
                <button type="button" onclick="toggleAdminTheme()" class="px-3 py-1.5 rounded-xl border border-brand-border bg-brand-surface hover:border-amber-400 text-xs font-semibold flex items-center gap-1.5 transition-all text-gray-300">
                    <i data-lucide="sun-moon" class="w-3.5 h-3.5 text-amber-500"></i>
                    <span class="hidden sm:inline">حالت تم:</span>
                    <strong id="top-theme-badge" class="font-bold text-amber-600">روشن</strong>
                </button>

                <a href="<?= \App\Core\Helper::url() ?>" target="_blank" class="px-3 py-1.5 rounded-xl bg-brand-surface border border-brand-border text-xs text-gray-300 hover:text-white transition-all hidden sm:flex items-center gap-1.5">
                    <i data-lucide="globe" class="w-3.5 h-3.5 text-amber-500"></i>
                    <span>cipcard.ir</span>
                </a>
            </div>
        </div>

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

        <?= $content ?>
    </main>

    <!-- Theme Toggle & Lucide Scripts -->
    <script>
        function updateThemeVisuals(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('cipcard_admin_theme', theme);

            var label = document.getElementById('theme-label');
            var icon = document.getElementById('theme-icon');
            var topBadge = document.getElementById('top-theme-badge');

            if (theme === 'light') {
                if (label) label.innerText = 'تم روشن (فعال)';
                if (topBadge) topBadge.innerText = 'روشن';
                if (icon) {
                    icon.setAttribute('data-lucide', 'sun');
                }
            } else {
                if (label) label.innerText = 'تم تیره (فعال)';
                if (topBadge) topBadge.innerText = 'تیره';
                if (icon) {
                    icon.setAttribute('data-lucide', 'moon');
                }
            }

            if (window.lucide) {
                lucide.createIcons();
            }

            // If salesChart exists on page, re-adjust colors
            if (window.salesChartInstance) {
                var isLight = theme === 'light';
                window.salesChartInstance.options.scales.x.ticks.color = isLight ? '#475569' : '#6B7280';
                window.salesChartInstance.options.scales.y.ticks.color = isLight ? '#475569' : '#6B7280';
                window.salesChartInstance.options.scales.x.grid.color = isLight ? 'rgba(0, 0, 0, 0.05)' : 'rgba(255, 255, 255, 0.04)';
                window.salesChartInstance.options.scales.y.grid.color = isLight ? 'rgba(0, 0, 0, 0.05)' : 'rgba(255, 255, 255, 0.04)';
                window.salesChartInstance.update();
            }
        }

        function toggleAdminTheme() {
            var current = document.documentElement.getAttribute('data-theme') || 'light';
            var next = current === 'light' ? 'dark' : 'light';
            updateThemeVisuals(next);
        }

        document.addEventListener('DOMContentLoaded', function() {
            var saved = localStorage.getItem('cipcard_admin_theme') || 'light';
            updateThemeVisuals(saved);
            lucide.createIcons();
        });
    </script>
</body>
</html>
