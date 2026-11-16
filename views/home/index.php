<!-- Hero Section with GSAP 3D Card & Parallax ScrollTrigger -->
<section id="hero" class="relative min-h-[92vh] flex items-center justify-center overflow-hidden pt-12 pb-20">
    <!-- Background Ambient Glow -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-gold/10 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-[350px] h-[350px] bg-blue-500/5 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Hero Left: Pitch & CTAs -->
            <div class="lg:col-span-7 space-y-8 text-center lg:text-right">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-surface border border-brand-gold/30 text-xs font-semibold text-brand-gold shadow-lg shadow-brand-gold/10">
                    <span class="w-2 h-2 rounded-full bg-brand-gold animate-ping"></span>
                    <span>نسل جدید ارتباطات تجاری لوکس با فناوری NFC</span>
                </div>

                <h1 id="hero-headline" class="text-4xl sm:text-6xl font-black text-white leading-tight tracking-tight">
                    کارت ویزیت هوشمند <br>
                    <span class="gold-gradient-text">CIPCard؛</span> لمس اعتبار شما
                </h1>

                <p id="hero-subtext" class="text-base sm:text-lg text-gray-400 max-w-2xl leading-relaxed">
                    تنها با یک لمس کارت روی گوشی مخاطبان خود، اطلاعات تماس، شبکه‌های اجتماعی، وب‌سایت و رزومه حرفه‌ای‌تان را با طراحی اختصاصی و بدون نیاز به نصب هیچ اپلیکیشنی انتقال دهید.
                </p>

                <!-- CTA & Fast Order Trigger -->
                <div id="hero-cta-box" class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <button onclick="openFastOrderModal('default_cip')" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-brand-goldDark via-brand-gold to-brand-goldLight text-black font-extrabold text-base shadow-xl shadow-brand-gold/25 hover:brightness-110 active:scale-95 transition-all flex items-center justify-center gap-3">
                        <i data-lucide="sparkles" class="w-5 h-5"></i>
                        <span>سفارش کارت هوشمند</span>
                    </button>
                    <a href="#templates" class="w-full sm:w-auto px-7 py-4 rounded-2xl bg-brand-surface border border-brand-border/80 text-white font-semibold text-base hover:border-brand-gold/50 transition-all flex items-center justify-center gap-2">
                        <i data-lucide="eye" class="w-5 h-5 text-gray-400"></i>
                        <span>مشاهده ۵ قالب اختصاصی</span>
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="pt-6 grid grid-cols-3 gap-6 border-t border-brand-border/40 text-center lg:text-right">
                    <div>
                        <span class="block text-2xl font-black text-white">۱۰۰٪</span>
                        <span class="text-xs text-gray-400">چیپ اصل NTAG216</span>
                    </div>
                    <div>
                        <span class="block text-2xl font-black text-white">۵ قالب</span>
                        <span class="text-xs text-gray-400">با پالت‌های رنگی لوکس</span>
                    </div>
                    <div>
                        <span class="block text-2xl font-black text-white">آنی</span>
                        <span class="text-xs text-gray-400">ذخیره یک‌کلیک مخاطب (.vcf)</span>
                    </div>
                </div>
            </div>

            <!-- Hero Right: 3D Card Mockup & Phone Interactive Target -->
            <div class="lg:col-span-5 relative flex items-center justify-center perspective-2000 py-10">
                
                <!-- Floating NFC & Social Icons for Parallax Depth -->
                <div id="floating-nfc-icon" class="absolute -top-6 right-8 w-14 h-14 rounded-2xl bg-brand-surface/90 border border-brand-gold/40 flex items-center justify-center shadow-lg shadow-brand-gold/20 z-30">
                    <i data-lucide="nfc" class="w-7 h-7 text-brand-gold"></i>
                </div>
                <div id="floating-social-1" class="absolute bottom-12 -right-4 w-12 h-12 rounded-xl bg-brand-surface/90 border border-brand-border flex items-center justify-center shadow-md z-30">
                    <i data-lucide="instagram" class="w-5 h-5 text-pink-500"></i>
                </div>
                <div id="floating-social-2" class="absolute top-20 -left-6 w-12 h-12 rounded-xl bg-brand-surface/90 border border-brand-border flex items-center justify-center shadow-md z-30">
                    <i data-lucide="send" class="w-5 h-5 text-sky-400"></i>
                </div>

                <!-- 3D Luxury NFC Card Mockup -->
                <div id="hero-3d-card" class="relative w-80 h-48 sm:w-96 sm:h-56 rounded-2xl p-6 bg-gradient-to-br from-[#1b1b22] via-[#0d0d12] to-[#050507] border border-brand-gold/40 shadow-2xl gold-glow transform-style-3d cursor-pointer transition-shadow duration-500 z-20">
                    
                    <!-- Inner Card Details -->
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-2">
                            <i data-lucide="nfc" class="w-7 h-7 text-brand-gold"></i>
                            <span class="text-xs font-mono tracking-widest text-brand-gold uppercase">CIP CONTACTLESS</span>
                        </div>
                        <span class="text-xl font-black font-mono tracking-widest text-white">CIP<span class="text-brand-gold">CARD</span></span>
                    </div>

                    <!-- Chip Visual Graphic -->
                    <div class="my-6 flex items-center gap-4">
                        <div class="w-12 h-9 rounded-md bg-gradient-to-tr from-amber-600 via-brand-gold to-yellow-200 p-0.5 shadow-inner">
                            <div class="w-full h-full bg-[#18181f] rounded-[4px] border border-brand-gold/50 grid grid-cols-2 gap-0.5 p-1">
                                <div class="border border-brand-gold/40 rounded-sm"></div>
                                <div class="border border-brand-gold/40 rounded-sm"></div>
                            </div>
                        </div>
                        <div class="relative w-12 h-12 flex items-center justify-center">
                            <div class="nfc-wave w-10 h-10"></div>
                            <div class="nfc-wave nfc-wave-delayed w-10 h-10"></div>
                            <i data-lucide="wifi" class="w-5 h-5 text-brand-gold rotate-90"></i>
                        </div>
                    </div>

                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase tracking-widest font-mono">CARDHOLDER</p>
                            <p class="text-sm font-bold text-white tracking-wide">MR. CIP EXECUTIVE</p>
                        </div>
                        <p class="text-xs font-mono text-brand-gold tracking-widest">VIP MEMBER</p>
                    </div>
                </div>

                <!-- Phone Target Mockup for Parallax Animation -->
                <div id="phone-mockup" class="absolute w-52 h-96 rounded-[36px] bg-[#0c0c10] border-4 border-gray-700/60 p-2 shadow-2xl -bottom-8 -left-6 opacity-30 scale-90 z-10 hidden sm:block">
                    <div class="w-full h-full rounded-[28px] bg-brand-darker border border-brand-border/40 overflow-hidden relative flex flex-col items-center justify-center p-3 text-center">
                        <div id="phone-screen" class="opacity-0 transition-opacity duration-700 space-y-2">
                            <div class="w-12 h-12 rounded-full bg-brand-gold/20 mx-auto flex items-center justify-center border border-brand-gold">
                                <i data-lucide="check" class="w-6 h-6 text-brand-gold"></i>
                            </div>
                            <p class="text-xs font-bold text-white">پروفایل باز شد!</p>
                            <span class="text-[9px] text-gray-400 font-mono">cipcard.ir/@0912...</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- 3 Simple Steps Section -->
<section class="py-20 bg-brand-surface/40 border-y border-brand-border/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
            <span class="text-xs font-bold text-brand-gold uppercase tracking-widest">سریع، مدرن و کارآمد</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white">فقط ۳ مرحله تا داشتن کارت ویزیت هوشمند</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="feature-card bg-brand-surface p-8 rounded-3xl border border-brand-border/60 hover:border-brand-gold/40 transition-all space-y-4 relative">
                <span class="text-4xl font-black font-mono text-brand-gold/20">01</span>
                <h3 class="text-xl font-bold text-white">ثبت سفارش و انتخاب قالب</h3>
                <p class="text-sm text-gray-400 leading-relaxed">
                    اطلاعات شغلی خود را وارد کنید، نوع کارت (طرح پیش‌فرض یا اختصاصی) را انتخاب کرده و قالب مورد نظر خود را برگزینید.
                </p>
            </div>

            <div class="feature-card bg-brand-surface p-8 rounded-3xl border border-brand-border/60 hover:border-brand-gold/40 transition-all space-y-4 relative">
                <span class="text-4xl font-black font-mono text-brand-gold/20">02</span>
                <h3 class="text-xl font-bold text-white">تایید پیامکی و پرداخت امن</h3>
                <p class="text-sm text-gray-400 leading-relaxed">
                    کد یکبار مصرف ارسالی به موبایل خود را تایید کرده و هزینه را از طریق درگاه امن شاپرکی زرین‌پال پرداخت نمایید.
                </p>
            </div>

            <div class="feature-card bg-brand-surface p-8 rounded-3xl border border-brand-border/60 hover:border-brand-gold/40 transition-all space-y-4 relative">
                <span class="text-4xl font-black font-mono text-brand-gold/20">03</span>
                <h3 class="text-xl font-bold text-white">چاپ، کدگذاری و تحویل درب محل</h3>
                <p class="text-sm text-gray-400 leading-relaxed">
                    کارت شما با بالاترین کیفیت چاپ و چیپ NFC آن با لینک اختصاصی شما برنامه‌ریزی شده و با پست پیشتاز ارسال می‌گردد.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Live Templates Showcase (5 Unique Templates) -->
<section id="templates" class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
            <span class="text-xs font-bold text-brand-gold uppercase tracking-widest">تنوع طراحی و هویت بصری</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white">۵ قالب اختصاصی با پالت‌های رنگی جذاب</h2>
            <p class="text-sm text-gray-400">هر کاربر می‌تواند در هر لحظه قالب و پالت رنگی کارت خود را تغییر دهد.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            
            <!-- 1. Minimal Luxury -->
            <div class="bg-brand-surface p-5 rounded-2xl border border-brand-border/60 flex flex-col justify-between space-y-4 hover:border-brand-gold/50 transition-all">
                <div class="space-y-2">
                    <span class="px-2.5 py-1 rounded-md bg-amber-500/10 text-brand-gold text-[11px] font-bold">قالب ۱</span>
                    <h4 class="font-bold text-white text-base">مینیمال و لوکس</h4>
                    <p class="text-xs text-gray-400 leading-relaxed">ترکیب مشکی مات و طلایی ویژه مدیران ارشد و برندهای لاکچری.</p>
                </div>
                <button onclick="openFastOrderModal('default_cip')" class="w-full py-2.5 rounded-xl bg-brand-surfaceHover text-xs font-semibold text-brand-gold hover:bg-brand-gold hover:text-black transition-all">
                    انتخاب این قالب
                </button>
            </div>

            <!-- 2. Glassmorphism -->
            <div class="bg-brand-surface p-5 rounded-2xl border border-brand-border/60 flex flex-col justify-between space-y-4 hover:border-brand-gold/50 transition-all">
                <div class="space-y-2">
                    <span class="px-2.5 py-1 rounded-md bg-cyan-500/10 text-cyan-400 text-[11px] font-bold">قالب ۲</span>
                    <h4 class="font-bold text-white text-base">گلسمورفیسم شیشه‌ای</h4>
                    <p class="text-xs text-gray-400 leading-relaxed">افکت بلور و کارت‌های شیشه‌ای مدرن و ترند روز وب.</p>
                </div>
                <button onclick="openFastOrderModal('default_cip')" class="w-full py-2.5 rounded-xl bg-brand-surfaceHover text-xs font-semibold text-cyan-400 hover:bg-cyan-400 hover:text-black transition-all">
                    انتخاب این قالب
                </button>
            </div>

            <!-- 3. Corporate Pro -->
            <div class="bg-brand-surface p-5 rounded-2xl border border-brand-border/60 flex flex-col justify-between space-y-4 hover:border-brand-gold/50 transition-all">
                <div class="space-y-2">
                    <span class="px-2.5 py-1 rounded-md bg-blue-500/10 text-blue-400 text-[11px] font-bold">قالب ۳</span>
                    <h4 class="font-bold text-white text-base">شرکتی و رسمی</h4>
                    <p class="text-xs text-gray-400 leading-relaxed">ساختارمند و منظم، ایده‌آل برای وکلا، پزشکان و مهندسین مشاور.</p>
                </div>
                <button onclick="openFastOrderModal('default_cip')" class="w-full py-2.5 rounded-xl bg-brand-surfaceHover text-xs font-semibold text-blue-400 hover:bg-blue-400 hover:text-black transition-all">
                    انتخاب این قالب
                </button>
            </div>

            <!-- 4. Creative Dark -->
            <div class="bg-brand-surface p-5 rounded-2xl border border-brand-border/60 flex flex-col justify-between space-y-4 hover:border-brand-gold/50 transition-all">
                <div class="space-y-2">
                    <span class="px-2.5 py-1 rounded-md bg-purple-500/10 text-purple-400 text-[11px] font-bold">قالب ۴</span>
                    <h4 class="font-bold text-white text-base">خلاقانه نئون/تیره</h4>
                    <p class="text-xs text-gray-400 leading-relaxed">طراحی تاریک با هایلایت‌های نئونی، مناسب طراحان و استارتاپ‌ها.</p>
                </div>
                <button onclick="openFastOrderModal('default_cip')" class="w-full py-2.5 rounded-xl bg-brand-surfaceHover text-xs font-semibold text-purple-400 hover:bg-purple-400 hover:text-black transition-all">
                    انتخاب این قالب
                </button>
            </div>

            <!-- 5. Modern Card -->
            <div class="bg-brand-surface p-5 rounded-2xl border border-brand-border/60 flex flex-col justify-between space-y-4 hover:border-brand-gold/50 transition-all">
                <div class="space-y-2">
                    <span class="px-2.5 py-1 rounded-md bg-emerald-500/10 text-emerald-400 text-[11px] font-bold">قالب ۵</span>
                    <h4 class="font-bold text-white text-base">کارت ویزیت کلاسیک</h4>
                    <p class="text-xs text-gray-400 leading-relaxed">انیمیشن چرخش سه‌بعدی کارت درست شبیه کارت فیزیکی در دست مخاطب.</p>
                </div>
                <button onclick="openFastOrderModal('default_cip')" class="w-full py-2.5 rounded-xl bg-brand-surfaceHover text-xs font-semibold text-emerald-400 hover:bg-emerald-400 hover:text-black transition-all">
                    انتخاب این قالب
                </button>
            </div>

        </div>
    </div>
</section>

<!-- Pricing & Plan Comparison Section -->
<section id="pricing" class="py-20 bg-brand-surface/30 border-t border-brand-border/40">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto space-y-4 mb-16">
            <span class="text-xs font-bold text-brand-gold uppercase tracking-widest">تعرفه‌ها و پلن‌های سفارش</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white">انتخاب پلن مناسب کسب‌وکار شما</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
            
            <!-- Plan 1: Default CIP -->
            <div class="bg-brand-surface p-8 sm:p-10 rounded-3xl border border-brand-border/80 flex flex-col justify-between space-y-8 relative">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">پلن استاندارد VIP</span>
                        <span class="px-3 py-1 rounded-full bg-brand-darker border border-brand-border text-xs text-gray-300">تحویل سریع</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white">طرح پیش‌فرض CIP</h3>
                    <p class="text-xs text-gray-400">کارت متالیک مات با لوگوی اختصاصی و طلایی CIPCard، فوق‌العاده شیک و آماده استفاده.</p>
                    
                    <div class="pt-4 border-t border-brand-border/40">
                        <span class="text-3xl font-black text-white"><?= \App\Core\Helper::formatPrice($priceDefault) ?></span>
                        <span class="text-xs text-gray-500 mr-2">هزینه یک‌باره بدون اشتراک ماهانه</span>
                    </div>

                    <ul class="space-y-3 pt-4 text-sm text-gray-300">
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-gold"></i><span>کارت فیزیکی هوشمند با روکش مات لوکس</span></li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-gold"></i><span>پروفایل اختصاصی بر روی <span class="font-mono text-brand-gold">cipcard.ir/@موبایل</span></span></li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-gold"></i><span>دسترسی به تمام ۵ قالب و پالت‌های رنگی</span></li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-gold"></i><span>تولید QR Code و فایل اختصاصی vCard</span></li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-gold"></i><span>پنل مدیریت با امکان ویرایش نامحدود اطلاعات</span></li>
                    </ul>
                </div>

                <button onclick="openFastOrderModal('default_cip')" class="w-full py-4 rounded-xl bg-brand-surfaceHover border border-brand-border text-white font-bold text-sm hover:border-brand-gold hover:text-brand-gold transition-all">
                    سفارش طرح پیش‌فرض
                </button>
            </div>

            <!-- Plan 2: Custom Design -->
            <div class="bg-gradient-to-b from-brand-surface to-[#16161f] p-8 sm:p-10 rounded-3xl border-2 border-brand-gold flex flex-col justify-between space-y-8 relative shadow-2xl gold-glow">
                <div class="absolute -top-3.5 right-8 px-4 py-1 rounded-full bg-gradient-to-r from-brand-gold to-brand-goldLight text-black text-xs font-extrabold uppercase tracking-wider">
                    پیشنهاد ویژه برندها
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-brand-gold uppercase tracking-wider">پلن اختصاصی و سازمانی</span>
                        <span class="px-3 py-1 rounded-full bg-brand-gold/10 border border-brand-gold/30 text-xs text-brand-gold">شخصی‌سازی کامل</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white">طرح اختصاصی (Custom Design)</h3>
                    <p class="text-xs text-gray-400">چاپ دو رو با طرح گرافیکی، رنگ سازمانی و لوگوی اختصاصی شرکت یا برند شخصی شما.</p>
                    
                    <div class="pt-4 border-t border-brand-border/40">
                        <span class="text-3xl font-black text-brand-gold"><?= \App\Core\Helper::formatPrice($priceCustom) ?></span>
                        <span class="text-xs text-gray-500 mr-2">هزینه کامل طراحی، چاپ و چیپ</span>
                    </div>

                    <ul class="space-y-3 pt-4 text-sm text-gray-300">
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-gold"></i><span>چاپ اختصاصی با لوگو و طرح دلخواه شما</span></li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-gold"></i><span>آپلود فایل طرح یا درخواست بررسی تیم طراحی</span></li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-gold"></i><span>پروفایل هوشمند با آدرس یکتا <span class="font-mono text-brand-gold">/@موبایل</span></span></li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-gold"></i><span>کارت فیزیکی ضدآب با بالاترین کیفیت چاپ UV</span></li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-gold"></i><span>گارانتی مادام‌العمر کارکرد چیپست NFC</span></li>
                    </ul>
                </div>

                <button onclick="openFastOrderModal('custom_design')" class="w-full py-4 rounded-xl bg-gradient-to-r from-brand-goldDark via-brand-gold to-brand-goldLight text-black font-extrabold text-sm hover:brightness-110 shadow-lg shadow-brand-gold/25 transition-all">
                    سفارش با طرح اختصاصی
                </button>
            </div>

        </div>
    </div>
</section>

<!-- FAQs Section -->
<section id="faq" class="py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <div class="text-center space-y-3">
            <span class="text-xs font-bold text-brand-gold uppercase tracking-widest">پاسخ به ابهامات متداول</span>
            <h2 class="text-3xl font-bold text-white">سوالات متداول مشتریان CIPCard</h2>
        </div>

        <div class="space-y-4">
            <details class="group bg-brand-surface p-6 rounded-2xl border border-brand-border/60 [&_svg]:open:-rotate-180">
                <summary class="flex justify-between items-center font-bold text-white cursor-pointer list-none">
                    <span>آیا مخاطب برای دریافت اطلاعات نیاز به نصب اپلیکیشن دارد؟</span>
                    <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform"></i>
                </summary>
                <p class="text-sm text-gray-400 leading-relaxed mt-4 pt-4 border-t border-brand-border/40">
                    خیر، به هیچ عنوان! مخاطب فقط کافیست گوشی خود (آیفون یا اندروید) را نزدیک کارت نگه دارد تا بدون نیاز به برنامه، صفحه پروفایل شما باز شده و دکمه ذخیره در مخاطبین نمایش یابد.
                </p>
            </details>

            <details class="group bg-brand-surface p-6 rounded-2xl border border-brand-border/60 [&_svg]:open:-rotate-180">
                <summary class="flex justify-between items-center font-bold text-white cursor-pointer list-none">
                    <span>اگر گوشی مخاطب قدیمی بود و NFC نداشت چطور؟</span>
                    <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform"></i>
                </summary>
                <p class="text-sm text-gray-400 leading-relaxed mt-4 pt-4 border-t border-brand-border/40">
                    پشت هر کارت یک بارکد QR اختصاصی چاپ می‌شود و همچنین روی صفحه پروفایل نیز قرار دارد تا هر گوشی مجهز به دوربین بتواند به آسانی اطلاعات شما را اسکن کند.
                </p>
            </details>

            <details class="group bg-brand-surface p-6 rounded-2xl border border-brand-border/60 [&_svg]:open:-rotate-180">
                <summary class="flex justify-between items-center font-bold text-white cursor-pointer list-none">
                    <span>آیا بعد از دریافت کارت می‌توانم اطلاعات یا شماره‌هایم را عوض کنم؟</span>
                    <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform"></i>
                </summary>
                <p class="text-sm text-gray-400 leading-relaxed mt-4 pt-4 border-t border-brand-border/40">
                    بله! شما دسترسی مادام‌العمر به پنل کاربری خود دارید و هر زمان که شماره، آدرس یا شبکه‌های اجتماعی‌تان تغییر کرد، در لحظه در پنل ویرایش می‌کنید و کارت فیزیکی بدون نیاز به تعویض به‌روز می‌شود.
                </p>
            </details>
        </div>
    </div>
</section>

<!-- ==============================================================================
     FAST ORDER MODAL (Step 1 & Step 2 OTP Engine)
     ============================================================================== -->
<div id="fast-order-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-md p-4 overflow-y-auto">
    <div class="relative w-full max-w-lg bg-brand-surface rounded-3xl border border-brand-gold/30 shadow-2xl p-6 sm:p-8 my-8 text-right">
        
        <!-- Close Button -->
        <button onclick="closeFastOrderModal()" class="absolute top-6 left-6 text-gray-400 hover:text-white">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>

        <!-- STEP 1: Fast Order Info Form -->
        <div id="step-order-form" class="space-y-6">
            <div>
                <span class="text-xs font-bold text-brand-gold">مرحله ۱ از ۳</span>
                <h3 class="text-2xl font-black text-white mt-1">ثبت سفارش سریع کارت هوشمند</h3>
                <p class="text-xs text-gray-400 mt-1">اطلاعات اولیه پروفایل خود را وارد نمایید.</p>
            </div>

            <!-- Card Type Toggle -->
            <div class="flex gap-3">
                <button type="button" id="btn-type-default" onclick="selectCardType('default_cip')" class="flex-1 py-3 px-4 rounded-xl text-center text-sm font-semibold border-2 border-brand-gold bg-brand-gold/10 text-brand-gold transition-all">
                    طرح پیش‌فرض CIP
                </button>
                <button type="button" id="btn-type-custom" onclick="selectCardType('custom_design')" class="flex-1 py-3 px-4 rounded-xl text-center text-sm font-medium border border-brand-border bg-brand-surface text-gray-400 hover:text-white transition-all">
                    طرح اختصاصی
                </button>
            </div>

            <form id="fast-order-form" class="space-y-4">
                <input type="hidden" name="card_type" id="modal-card-type" value="default_cip">
                <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::getToken() ?>">

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">نام و نام خانوادگی *</label>
                    <input type="text" name="full_name" required placeholder="مثال: دکتر علیرضا سهرابی" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-sm focus:border-brand-gold focus:outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">عنوان شغلی یا تخصص</label>
                    <input type="text" name="job_title" placeholder="مثال: مدیرعامل هلدینگ / وکیل پایه یک" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-sm focus:border-brand-gold focus:outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">شماره موبایل (نام کاربری و شناسه یکتا) *</label>
                    <input type="tel" name="mobile" required placeholder="09123456789" dir="ltr" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-sm text-left focus:border-brand-gold focus:outline-none transition-all font-mono">
                    <span class="text-[11px] text-gray-500 mt-1 block">کد تایید پیامکی و آدرس پروفایل شما با این شماره تنظیم خواهد شد.</span>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-300 mb-1.5">انتخاب قالب اولیه</label>
                        <select name="template_id" class="w-full px-3 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                            <option value="minimal">مینیمال و لوکس</option>
                            <option value="glassmorphism">گلسمورفیسم شیشه‌ای</option>
                            <option value="corporate">شرکتی و رسمی</option>
                            <option value="creative_dark">خلاقانه نئون/تیره</option>
                            <option value="modern_card">کارت ویزیت کلاسیک</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-300 mb-1.5">پالت رنگی</label>
                        <select name="theme_color" class="w-full px-3 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                            <option value="gold_black">طلایی - مشکی</option>
                            <option value="blue_white">آبی - سرمه‌ای</option>
                            <option value="emerald_gray">سبز زمردی - طوسی</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full mt-4 py-4 rounded-xl bg-gradient-to-r from-brand-goldDark via-brand-gold to-brand-goldLight text-black font-extrabold text-sm shadow-xl shadow-brand-gold/20 hover:brightness-110 transition-all">
                    ادامه و دریافت کد تایید پیامکی
                </button>
            </form>
        </div>

        <!-- STEP 2: OTP Verification Form -->
        <div id="step-otp-form" class="hidden space-y-6">
            <div>
                <span class="text-xs font-bold text-brand-gold">مرحله ۲ از ۳</span>
                <h3 class="text-2xl font-black text-white mt-1">تایید شماره موبایل</h3>
                <p class="text-xs text-gray-400 mt-1">
                    کد تایید پیامک‌شده به شماره <span id="otp-mobile-display" class="font-mono text-brand-gold"></span> را وارد کنید:
                </p>
            </div>

            <form id="otp-verify-form" class="space-y-4">
                <div>
                    <input type="text" id="otp-code-input" maxlength="6" placeholder="• • • • •" dir="ltr" class="w-full text-center tracking-[1em] text-2xl font-mono px-4 py-3.5 rounded-xl bg-brand-darker border-2 border-brand-gold/60 text-white focus:outline-none">
                </div>

                <div class="flex items-center justify-between text-xs text-gray-400">
                    <span id="otp-timer">02:00 تا ارسال مجدد</span>
                    <button type="button" id="btn-resend-otp" onclick="resendOtp()" class="text-brand-gold hover:underline hidden">
                        ارسال مجدد کد تایید
                    </button>
                </div>

                <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-brand-goldDark via-brand-gold to-brand-goldLight text-black font-extrabold text-sm shadow-xl shadow-brand-gold/20 hover:brightness-110 transition-all">
                    تایید کد و انتقال به درگاه پرداخت
                </button>
            </form>
        </div>

    </div>
</div>
