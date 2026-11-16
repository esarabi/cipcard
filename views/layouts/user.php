<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \App\Core\Helper::e($title ?? 'داشبورد کاربری - CIPCard') ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            gold: '#D4AF37',
                            goldLight: '#F3E5AB',
                            goldDark: '#AA820A',
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
</head>
<body class="bg-brand-darker text-gray-200 font-sans antialiased min-h-screen flex flex-col md:flex-row">

    <!-- Mobile Top Header -->
    <div class="md:hidden bg-brand-surface border-b border-brand-border/60 p-4 flex items-center justify-between">
        <a href="<?= \App\Core\Helper::url() ?>" class="flex items-center gap-2">
            <i data-lucide="nfc" class="w-6 h-6 text-brand-gold"></i>
            <span class="font-bold text-white tracking-wider">CIP<span class="text-brand-gold">CARD</span></span>
        </a>
        <a href="<?= \App\Core\Helper::url('auth/logout') ?>" class="text-xs text-red-400 flex items-center gap-1">
            <i data-lucide="log-out" class="w-4 h-4"></i>
            <span>خروج</span>
        </a>
    </div>

    <!-- Sidebar Navigation -->
    <aside class="w-full md:w-64 bg-brand-surface border-l border-brand-border/60 flex-shrink-0 flex flex-col justify-between p-6">
        <div class="space-y-8">
            <div class="hidden md:flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-brand-goldDark to-brand-gold p-0.5 flex items-center justify-center">
                    <div class="w-full h-full bg-brand-darker rounded-[10px] flex items-center justify-center">
                        <i data-lucide="nfc" class="w-5 h-5 text-brand-gold"></i>
                    </div>
                </div>
                <span class="text-xl font-bold tracking-wider text-white">CIP<span class="text-brand-gold">CARD</span></span>
            </div>

            <!-- User Info Badge -->
            <div class="bg-brand-darker p-3.5 rounded-xl border border-brand-border/40 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-brand-gold/10 text-brand-gold border border-brand-gold/30 flex items-center justify-center font-bold">
                    <?= mb_substr(\App\Core\Session::get('user_name', 'مشتری'), 0, 1) ?>
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-semibold text-white truncate"><?= \App\Core\Helper::e(\App\Core\Session::get('user_name')) ?></p>
                    <p class="text-[11px] text-gray-400 font-mono"><?= \App\Core\Helper::e(\App\Core\Session::get('user_mobile')) ?></p>
                </div>
            </div>

            <!-- Menu Links -->
            <nav class="space-y-1.5">
                <a href="<?= \App\Core\Helper::url('dashboard') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all <?= (!str_contains($_SERVER['REQUEST_URI'], 'profile') && !str_contains($_SERVER['REQUEST_URI'], 'tracking')) ? 'bg-brand-gold/10 text-brand-gold border border-brand-gold/20' : 'text-gray-300 hover:bg-brand-surfaceHover hover:text-white' ?>">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>میز کار (داشبورد)</span>
                </a>
                <a href="<?= \App\Core\Helper::url('dashboard/profile') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all <?= str_contains($_SERVER['REQUEST_URI'], 'profile') ? 'bg-brand-gold/10 text-brand-gold border border-brand-gold/20' : 'text-gray-300 hover:bg-brand-surfaceHover hover:text-white' ?>">
                    <i data-lucide="user-cog" class="w-4 h-4"></i>
                    <span>ویرایش پروفایل هوشمند</span>
                </a>
                <a href="<?= \App\Core\Helper::url('dashboard/tracking') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all <?= str_contains($_SERVER['REQUEST_URI'], 'tracking') ? 'bg-brand-gold/10 text-brand-gold border border-brand-gold/20' : 'text-gray-300 hover:bg-brand-surfaceHover hover:text-white' ?>">
                    <i data-lucide="truck" class="w-4 h-4"></i>
                    <span>پیگیری وضعیت سفارش</span>
                </a>
                <a href="<?= \App\Core\Helper::url() ?>" target="_blank" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:bg-brand-surfaceHover hover:text-white transition-all">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    <span>مشاهده سایت اصلی</span>
                </a>
            </nav>
        </div>

        <div class="pt-6 border-t border-brand-border/40">
            <a href="<?= \App\Core\Helper::url('auth/logout') ?>" class="flex items-center gap-2 text-sm text-red-400/80 hover:text-red-300 transition-colors">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                <span>خروج از حساب</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-grow p-4 md:p-8 max-w-6xl overflow-y-auto">
        <!-- Flash Alert Messages -->
        <?php if ($successMsg = \App\Core\Session::getFlash('success')): ?>
            <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center gap-3 text-sm">
                <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
                <span><?= \App\Core\Helper::e($successMsg) ?></span>
            </div>
        <?php endif; ?>

        <?php if ($errorMsg = \App\Core\Session::getFlash('error')): ?>
            <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 flex items-center gap-3 text-sm">
                <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                <span><?= \App\Core\Helper::e($errorMsg) ?></span>
            </div>
        <?php endif; ?>

        <?php if ($warningMsg = \App\Core\Session::getFlash('warning')): ?>
            <div class="mb-6 p-4 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center gap-3 text-sm">
                <i data-lucide="alert-triangle" class="w-5 h-5 flex-shrink-0"></i>
                <span><?= \App\Core\Helper::e($warningMsg) ?></span>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
