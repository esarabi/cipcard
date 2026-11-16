<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \App\Core\Helper::e($title ?? 'CIPCard | کارت ویزیت هوشمند NFC') ?></title>
    <meta name="description" content="کارت ویزیت هوشمند NFC با فناوری روز، اشتراک‌گذاری سریع اطلاعات با یک لمس، ۵ قالب اختصاصی و طراحی لوکس و VIP">
    
    <!-- Google / CDN Fonts: Vazirmatn -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN with RTL Support -->
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
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- GSAP & ScrollTrigger CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    
    <link rel="stylesheet" href="<?= \App\Core\Helper::asset('css/style.css') ?>">
    <meta name="csrf-token" content="<?= \App\Core\Csrf::getToken() ?>">
</head>
<body class="bg-brand-darker text-gray-200 font-sans antialiased selection:bg-brand-gold selection:text-black min-h-screen flex flex-col justify-between overflow-x-hidden">

    <!-- Top Navigation Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-brand-darker/80 backdrop-blur-md border-b border-brand-border/40 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="<?= \App\Core\Helper::url() ?>" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-goldDark via-brand-gold to-brand-goldLight p-0.5 shadow-lg shadow-brand-gold/20 flex items-center justify-center">
                    <div class="w-full h-full bg-brand-darker rounded-[10px] flex items-center justify-center">
                        <i data-lucide="nfc" class="w-5 h-5 text-brand-gold group-hover:scale-110 transition-transform"></i>
                    </div>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-black tracking-wider text-white font-mono flex items-center gap-1">
                        CIP<span class="text-brand-gold">CARD</span>
                    </span>
                    <span class="text-[10px] text-gray-400 -mt-1 tracking-widest uppercase">Smart VIP NFC</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-300">
                <a href="<?= \App\Core\Helper::url() ?>#hero" class="hover:text-brand-gold transition-colors">معرفی کارت</a>
                <a href="<?= \App\Core\Helper::url() ?>#features" class="hover:text-brand-gold transition-colors">مزایا و قابلیت‌ها</a>
                <a href="<?= \App\Core\Helper::url() ?>#templates" class="hover:text-brand-gold transition-colors">پیش‌نمایش قالب‌ها</a>
                <a href="<?= \App\Core\Helper::url() ?>#pricing" class="hover:text-brand-gold transition-colors">قیمت‌ها</a>
                <a href="<?= \App\Core\Helper::url() ?>#faq" class="hover:text-brand-gold transition-colors">سوالات متداول</a>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                <?php if (\App\Core\Session::has('user_id')): ?>
                    <a href="<?= \App\Core\Helper::url('dashboard') ?>" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-surface border border-brand-border text-sm font-medium hover:border-brand-gold/60 transition-all text-white">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 text-brand-gold"></i>
                        <span>داشبورد کاربری</span>
                    </a>
                <?php else: ?>
                    <a href="<?= \App\Core\Helper::url('auth/login') ?>" class="text-sm font-medium text-gray-300 hover:text-white transition-colors hidden sm:block">
                        ورود به پنل
                    </a>
                    <button onclick="openFastOrderModal()" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-brand-goldDark via-brand-gold to-brand-goldLight text-black font-semibold text-sm hover:brightness-110 shadow-lg shadow-brand-gold/20 transition-all active:scale-95 flex items-center gap-2">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                        <span>سفارش فوری</span>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content Injection -->
    <main class="flex-grow pt-20">
        <?= $content ?>
    </main>

    <!-- Global Footer -->
    <footer class="bg-brand-surface border-t border-brand-border/60 mt-20 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-brand-border/40">
                <div class="space-y-4 md:col-span-1">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-brand-gold to-brand-goldLight p-0.5 flex items-center justify-center">
                            <div class="w-full h-full bg-brand-darker rounded-[10px] flex items-center justify-center">
                                <i data-lucide="nfc" class="w-5 h-5 text-brand-gold"></i>
                            </div>
                        </div>
                        <span class="text-xl font-bold tracking-wider text-white">CIP<span class="text-brand-gold">CARD</span></span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        پلتفرم هوشمند فروش و مدیریت کارت ویزیت NFC برای مدیران، پزشکان، وکلا و کسب‌وکارهای سطح VIP. اتصال آنی با یک لمس.
                    </p>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-r-2 border-brand-gold pr-3">بخش‌های وب‌سایت</h4>
                    <ul class="space-y-2.5 text-sm text-gray-400">
                        <li><a href="#hero" class="hover:text-brand-gold transition-colors">کارت ویزیت هوشمند چیست؟</a></li>
                        <li><a href="#templates" class="hover:text-brand-gold transition-colors">۵ قالب اختصاصی پروفایل</a></li>
                        <li><a href="#pricing" class="hover:text-brand-gold transition-colors">مقایسه پلن‌ها و سفارش</a></li>
                        <li><a href="#faq" class="hover:text-brand-gold transition-colors">سوالات متداول مشتریان</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-r-2 border-brand-gold pr-3">قوانین و پشتیبانی</h4>
                    <ul class="space-y-2.5 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-brand-gold transition-colors">حریم خصوصی مشتریان</a></li>
                        <li><a href="#" class="hover:text-brand-gold transition-colors">شرایط چاپ و گارانتی چیپ NFC</a></li>
                        <li><a href="#" class="hover:text-brand-gold transition-colors">راهنمای استفاده از کارت هوشمند</a></li>
                        <li><a href="<?= \App\Core\Helper::url('auth/login') ?>" class="hover:text-brand-gold transition-colors">ورود به حساب کاربری</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-r-2 border-brand-gold pr-3">تماس و سفارشات</h4>
                    <div class="space-y-3 text-sm text-gray-400">
                        <div class="flex items-center gap-3">
                            <i data-lucide="phone" class="w-4 h-4 text-brand-gold"></i>
                            <span>تلفن تماس: <?= \App\Core\Helper::e(\App\Models\Setting::get('support_phone', '021-91000000')) ?></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i data-lucide="mail" class="w-4 h-4 text-brand-gold"></i>
                            <span>ایمیل: <?= \App\Core\Helper::e(\App\Models\Setting::get('support_email', 'info@cipcard.ir')) ?></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i data-lucide="shield-check" class="w-4 h-4 text-brand-gold"></i>
                            <span>پرداخت امن از طریق درگاه زرین‌پال</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 gap-4">
                <p>© <?= date('Y') ?> تمامی حقوق مادی و معنوی متعلق به پلتفرم CIPCard (cipcard.ir) می‌باشد.</p>
                <div class="flex items-center gap-4">
                    <span>Designed for VIP & Business Leaders</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
    <script src="<?= \App\Core\Helper::asset('js/app.js') ?>"></script>
    <script src="<?= \App\Core\Helper::asset('js/gsap-hero.js') ?>"></script>
</body>
</html>
