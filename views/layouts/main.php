<!DOCTYPE html>
<html lang="fa" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \App\Core\Helper::e($title ?? \App\Models\Setting::get('site_title', 'CIPCard | کارت ویزیت هوشمند NFC لوکس')) ?></title>
    <meta name="description" content="<?= \App\Core\Helper::e(\App\Models\Setting::get('site_description', 'کارت ویزیت هوشمند NFC با فناوری روز، اشتراک‌گذاری سریع اطلاعات با یک لمس، ۵ قالب اختصاصی و طراحی لوکس و VIP')) ?>">
    
    <!-- Google / CDN Fonts: Vazirmatn -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN with RTL Support & Light Theme -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            gold: '#D4AF37',
                            goldLight: '#F3E5AB',
                            goldDark: '#B8860B',
                            primary: '#0F172A',
                            secondary: '#334155',
                            muted: '#64748B',
                            surface: '#FFFFFF',
                            surfaceAlt: '#F8FAFC',
                            border: '#E2E8F0',
                            borderDark: '#CBD5E1'
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
    <style>
        /* Persian Typography Standards: Generous Line Spacing for Headings */
        h1, h2, h3, h4, h5, h6 {
            line-height: 1.55 !important;
            letter-spacing: normal !important;
        }
        #hero-headline {
            line-height: 1.45 !important;
        }
    </style>
</head>
<body class="bg-[#FAFAFA] text-slate-800 font-sans antialiased selection:bg-amber-100 selection:text-amber-900 min-h-screen flex flex-col justify-between overflow-x-hidden">

    <!-- Top Navigation Header (Light Luxury) -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200/80 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.04)] transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="<?= \App\Core\Helper::url() ?>" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-amber-600 via-amber-400 to-amber-200 p-0.5 shadow-md shadow-amber-500/20 flex items-center justify-center">
                    <div class="w-full h-full bg-slate-900 rounded-[14px] flex items-center justify-center">
                        <i data-lucide="nfc" class="w-5 h-5 text-amber-400 group-hover:scale-110 transition-transform"></i>
                    </div>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-black tracking-wider text-slate-900 font-mono flex items-center gap-1">
                        CIP<span class="text-amber-600">CARD</span>
                    </span>
                    <span class="text-[10px] text-slate-500 -mt-1 tracking-widest uppercase font-semibold">Smart VIP NFC</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden lg:flex items-center gap-7 text-sm font-semibold text-slate-600">
                <a href="<?= \App\Core\Helper::url() ?>#hero" class="hover:text-amber-600 transition-colors">معرفی کارت</a>
                <a href="<?= \App\Core\Helper::url() ?>#steps" class="hover:text-amber-600 transition-colors">نحوه کارکرد</a>
                <a href="<?= \App\Core\Helper::url() ?>#templates" class="hover:text-amber-600 transition-colors flex items-center gap-1.5">
                    <span>۵ نمونه زنده قالب‌ها</span>
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-300">زنده</span>
                </a>
                <a href="<?= \App\Core\Helper::url() ?>#pricing" class="hover:text-amber-600 transition-colors">قیمت‌ها</a>
                <a href="<?= \App\Core\Helper::url() ?>#faq" class="hover:text-amber-600 transition-colors">سوالات متداول</a>
                <a href="<?= \App\Core\Helper::url() ?>#contact" class="hover:text-amber-600 transition-colors">تماس</a>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <?php if (\App\Core\Session::has('user_id')): ?>
                    <a href="<?= \App\Core\Helper::url('dashboard') ?>" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 shadow-md transition-all">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 text-amber-400"></i>
                        <span>داشبورد کاربری</span>
                    </a>
                <?php else: ?>
                    <a href="<?= \App\Core\Helper::url('auth/login') ?>" class="text-sm font-semibold text-slate-700 hover:text-amber-600 px-3 py-2 transition-colors hidden sm:inline-flex items-center gap-1.5">
                        <i data-lucide="log-in" class="w-4 h-4 text-slate-500"></i>
                        <span>ورود به پنل</span>
                    </a>
                    <button onclick="openFastOrderModal('default_cip')" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 text-slate-950 font-extrabold text-sm hover:brightness-105 shadow-md shadow-amber-500/20 active:scale-95 transition-all flex items-center gap-2">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                        <span>سفارش فوری</span>
                    </button>
                <?php endif; ?>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" onclick="toggleMobileMenu()" class="p-2.5 rounded-xl border border-slate-200 text-slate-700 lg:hidden hover:bg-slate-100 transition-colors" aria-label="Menu">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white border-b border-slate-200 px-6 py-5 space-y-4 shadow-xl">
            <nav class="flex flex-col space-y-3 text-sm font-semibold text-slate-700">
                <a href="<?= \App\Core\Helper::url() ?>#hero" onclick="toggleMobileMenu()" class="py-2 hover:text-amber-600">معرفی کارت هوشمند</a>
                <a href="<?= \App\Core\Helper::url() ?>#steps" onclick="toggleMobileMenu()" class="py-2 hover:text-amber-600">مراحل سفارش و نحوه کارکرد</a>
                <a href="<?= \App\Core\Helper::url() ?>#templates" onclick="toggleMobileMenu()" class="py-2 hover:text-amber-600 flex items-center justify-between">
                    <span>۵ نمونه زنده قالب‌ها</span>
                    <span class="px-2 py-0.5 text-[10px] rounded-full bg-amber-100 text-amber-800">پیش‌نمایش آنلاین</span>
                </a>
                <a href="<?= \App\Core\Helper::url() ?>#pricing" onclick="toggleMobileMenu()" class="py-2 hover:text-amber-600">تعرفه‌ها و پلن‌ها</a>
                <a href="<?= \App\Core\Helper::url() ?>#faq" onclick="toggleMobileMenu()" class="py-2 hover:text-amber-600">سوالات متداول</a>
                <a href="<?= \App\Core\Helper::url() ?>#contact" onclick="toggleMobileMenu()" class="py-2 hover:text-amber-600">تماس و پشتیبانی</a>
                <a href="<?= \App\Core\Helper::url('auth/login') ?>" class="py-2 text-amber-700 flex items-center gap-2 border-t border-slate-100 pt-3">
                    <i data-lucide="user" class="w-4 h-4"></i>
                    <span>ورود به حساب کاربری</span>
                </a>
                <a href="<?= \App\Core\Helper::url('admin/login') ?>" class="py-2 text-slate-500 text-xs flex items-center gap-2">
                    <i data-lucide="shield" class="w-3.5 h-3.5"></i>
                    <span>ورود مدیران سیستم</span>
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
        <?= $content ?>
    </main>

    <!-- Global Footer (Light Luxury Aesthetic) -->
    <footer id="contact" class="bg-slate-100 border-t border-slate-200 mt-20 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-300/70">
                
                <!-- Col 1: About & Identity -->
                <div class="space-y-4 md:col-span-1">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-amber-600 via-amber-400 to-amber-200 p-0.5 shadow-md flex items-center justify-center">
                            <div class="w-full h-full bg-slate-900 rounded-[14px] flex items-center justify-center">
                                <i data-lucide="nfc" class="w-5 h-5 text-amber-400"></i>
                            </div>
                        </div>
                        <span class="text-xl font-black tracking-wider text-slate-900 font-mono">CIP<span class="text-amber-600">CARD</span></span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        <?= \App\Core\Helper::e(\App\Models\Setting::get('site_description', 'پلتفرم پیشرفته خرید و مدیریت کارت ویزیت هوشمند NFC با قابلیت اتصال مستقیم به گوشی و شبکه‌های اجتماعی برای مدیران و شرکت‌های معتبر ایران.')) ?>
                    </p>
                    <div class="pt-2 flex items-center gap-3">
                        <?php if ($ig = \App\Models\Setting::get('social_instagram', 'cipcard_ir')): ?>
                            <a href="https://instagram.com/<?= urlencode($ig) ?>" target="_blank" rel="noopener" class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:text-pink-600 hover:border-pink-300 transition-all shadow-sm">
                                <i data-lucide="instagram" class="w-4 h-4"></i>
                            </a>
                        <?php endif; ?>
                        <?php if ($tg = \App\Models\Setting::get('social_telegram', 'cipcard_support')): ?>
                            <a href="https://t.me/<?= urlencode($tg) ?>" target="_blank" rel="noopener" class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:text-sky-600 hover:border-sky-300 transition-all shadow-sm">
                                <i data-lucide="send" class="w-4 h-4"></i>
                            </a>
                        <?php endif; ?>
                        <?php if ($wa = \App\Models\Setting::get('social_whatsapp', '989120000000')): ?>
                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $wa) ?>" target="_blank" rel="noopener" class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:text-emerald-600 hover:border-emerald-300 transition-all shadow-sm">
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Col 2: Navigation -->
                <div>
                    <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 border-r-2 border-amber-500 pr-3">دسترسی سریع</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-slate-600">
                        <li><a href="<?= \App\Core\Helper::url() ?>#hero" class="hover:text-amber-600 transition-colors">کارت ویزیت هوشمند چیست؟</a></li>
                        <li><a href="<?= \App\Core\Helper::url() ?>#steps" class="hover:text-amber-600 transition-colors">مراحل سه‌گانه سفارش</a></li>
                        <li><a href="<?= \App\Core\Helper::url() ?>#templates" class="hover:text-amber-600 transition-colors">مشاهده ۵ قالب اختصاصی</a></li>
                        <li><a href="<?= \App\Core\Helper::url() ?>#pricing" class="hover:text-amber-600 transition-colors">تعرفه‌ها و سفارش کارت</a></li>
                        <li><a href="<?= \App\Core\Helper::url() ?>#faq" class="hover:text-amber-600 transition-colors">سوالات متداول مشتریان</a></li>
                    </ul>
                </div>

                <!-- Col 3: Live Demos of 5 Templates -->
                <div>
                    <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 border-r-2 border-amber-500 pr-3">نمونه‌های زنده ۵ قالب</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-slate-600">
                        <li><a href="<?= \App\Core\Helper::url('@demo-minimal') ?>" target="_blank" class="hover:text-amber-600 transition-colors flex items-center gap-1.5"><i data-lucide="external-link" class="w-3.5 h-3.5 text-amber-500"></i><span>۱. قالب مینیمال و لوکس</span></a></li>
                        <li><a href="<?= \App\Core\Helper::url('@demo-glassmorphism') ?>" target="_blank" class="hover:text-amber-600 transition-colors flex items-center gap-1.5"><i data-lucide="external-link" class="w-3.5 h-3.5 text-cyan-500"></i><span>۲. قالب گلسمورفیسم شیشه‌ای</span></a></li>
                        <li><a href="<?= \App\Core\Helper::url('@demo-corporate') ?>" target="_blank" class="hover:text-amber-600 transition-colors flex items-center gap-1.5"><i data-lucide="external-link" class="w-3.5 h-3.5 text-blue-500"></i><span>۳. قالب شرکتی و رسمی</span></a></li>
                        <li><a href="<?= \App\Core\Helper::url('@demo-creative') ?>" target="_blank" class="hover:text-amber-600 transition-colors flex items-center gap-1.5"><i data-lucide="external-link" class="w-3.5 h-3.5 text-purple-500"></i><span>۴. قالب خلاقانه و نئون</span></a></li>
                        <li><a href="<?= \App\Core\Helper::url('@demo-modern') ?>" target="_blank" class="hover:text-amber-600 transition-colors flex items-center gap-1.5"><i data-lucide="external-link" class="w-3.5 h-3.5 text-emerald-500"></i><span>۵. قالب کارت ویزیت سه‌بعدی</span></a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact & Phone & Email (Configurable from Admin) -->
                <div>
                    <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 border-r-2 border-amber-500 pr-3">اطلاعات تماس و پشتیبانی</h4>
                    <div class="space-y-3.5 text-xs sm:text-sm text-slate-600">
                        <div class="flex items-start gap-3">
                            <i data-lucide="phone-call" class="w-4 h-4 text-amber-600 mt-0.5 shrink-0"></i>
                            <div>
                                <span class="block text-slate-400 text-[11px]">شماره تماس مستقیم:</span>
                                <a href="tel:<?= \App\Core\Helper::e(\App\Models\Setting::get('support_phone', '021-91000000')) ?>" class="font-bold text-slate-900 hover:text-amber-600 transition-colors font-mono dir-ltr inline-block">
                                    <?= \App\Core\Helper::e(\App\Models\Setting::get('support_phone', '021-91000000')) ?>
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <i data-lucide="mail" class="w-4 h-4 text-amber-600 mt-0.5 shrink-0"></i>
                            <div>
                                <span class="block text-slate-400 text-[11px]">ایمیل پشتیبانی:</span>
                                <a href="mailto:<?= \App\Core\Helper::e(\App\Models\Setting::get('support_email', 'info@cipcard.ir')) ?>" class="font-semibold text-slate-800 hover:text-amber-600 transition-colors font-mono">
                                    <?= \App\Core\Helper::e(\App\Models\Setting::get('support_email', 'info@cipcard.ir')) ?>
                                </a>
                            </div>
                        </div>

                        <?php if ($addr = \App\Models\Setting::get('support_address')): ?>
                        <div class="flex items-start gap-3">
                            <i data-lucide="map-pin" class="w-4 h-4 text-amber-600 mt-0.5 shrink-0"></i>
                            <span class="text-slate-600 text-xs leading-relaxed"><?= \App\Core\Helper::e($addr) ?></span>
                        </div>
                        <?php endif; ?>

                        <div class="pt-2 flex items-center gap-2 text-xs text-emerald-700 font-semibold">
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                            <span>پرداخت امن متصل به شبکه شاپرک (زرین‌پال)</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer Bottom Bar with Explicit Requested Branding -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>© <?= date('Y') ?> تمامی حقوق برای پلتفرم هوشمند CIPCard (cipcard.ir) محفوظ است.</p>
                <div class="flex items-center gap-1.5 font-medium">
                    <span class="text-slate-600">طراحی و توسعه توسط</span>
                    <a href="https://rastingroup.ir" target="_blank" rel="noopener" class="text-amber-600 hover:text-amber-700 font-extrabold underline decoration-amber-400 decoration-2 underline-offset-4 transition-colors">
                        تیم توسعه هوشمند راستین
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Initialize Lucide Icons & Mobile Menu Helper -->
    <script>
        lucide.createIcons();
        function toggleMobileMenu() {
            var menu = document.getElementById('mobile-menu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }
    </script>
    <script src="<?= \App\Core\Helper::asset('js/app.js') ?>"></script>
    <script src="<?= \App\Core\Helper::asset('js/gsap-hero.js') ?>"></script>
</body>
</html>
