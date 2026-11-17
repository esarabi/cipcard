<!-- ==============================================================================
     HERO SECTION (Light Luxury Theme with 3D Parallax NFC Card)
     ============================================================================== -->
<section id="hero" class="relative min-h-[92vh] flex items-center justify-center overflow-hidden pt-10 pb-20 bg-gradient-to-b from-white via-slate-50/60 to-white">
    <!-- Ambient Light Glows -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-amber-400/10 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-[450px] h-[450px] bg-blue-500/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Hero Left: Pitch & Action CTAs -->
            <div class="lg:col-span-7 space-y-8 text-center lg:text-right">
                
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-50 border border-amber-200 text-xs font-bold text-amber-800 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                    <span>نسل جدید ارتباطات تجاری لوکس با فناوری NFC</span>
                </div>

                <!-- Main Heading -->
                <h1 id="hero-headline" class="text-4xl sm:text-6xl font-black text-slate-900 leading-[1.4] sm:leading-[1.45] tracking-normal">
                    کارت ویزیت هوشمند <br>
                    <span class="bg-gradient-to-r from-amber-600 via-amber-500 to-yellow-600 bg-clip-text text-transparent">CIPCard؛</span> لمس اعتبار شما
                </h1>

                <!-- Subtext -->
                <p id="hero-subtext" class="text-base sm:text-lg text-slate-600 max-w-2xl leading-relaxed">
                    تنها با یک لمس کارت روی گوشی مخاطب، تمام اطلاعات شغلی، شبکه‌های اجتماعی، وب‌سایت و رزومه اختصاصی شما بدون نیاز به نصب هیچ‌گونه اپلیکیشن منتقل و ذخیره می‌شود.
                </p>

                <!-- CTA Action Buttons -->
                <div id="hero-cta-box" class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <button onclick="openFastOrderModal('default_cip')" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 text-slate-950 font-extrabold text-base shadow-xl shadow-amber-500/25 hover:brightness-105 active:scale-95 transition-all flex items-center justify-center gap-3">
                        <i data-lucide="sparkles" class="w-5 h-5"></i>
                        <span>سفارش کارت هوشمند</span>
                    </button>
                    
                    <a href="#templates" class="w-full sm:w-auto px-7 py-4 rounded-2xl bg-white border border-slate-300 text-slate-800 font-bold text-base hover:border-amber-500 hover:text-amber-700 shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2">
                        <i data-lucide="eye" class="w-5 h-5 text-amber-600"></i>
                        <span>مشاهده ۵ نمونه زنده</span>
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="pt-6 grid grid-cols-3 gap-6 border-t border-slate-200 text-center lg:text-right">
                    <div>
                        <span class="block text-2xl font-black text-slate-900">۱۰۰٪</span>
                        <span class="text-xs text-slate-500 font-medium">چیپ اورجینال NTAG216</span>
                    </div>
                    <div>
                        <span class="block text-2xl font-black text-slate-900">۵ قالب</span>
                        <span class="text-xs text-slate-500 font-medium">پالت‌های رنگی اختصاصی</span>
                    </div>
                    <div>
                        <span class="block text-2xl font-black text-slate-900">آنی</span>
                        <span class="text-xs text-slate-500 font-medium">ذخیره مخاطب با ۱ کلیک (.vcf)</span>
                    </div>
                </div>
            </div>

            <!-- Hero Right: 3D Luxury NFC Card Mockup & Visual Experience -->
            <div class="lg:col-span-5 relative flex items-center justify-center perspective-2000 py-10">
                
                <!-- Floating Badges for Parallax Depth -->
                <div id="floating-nfc-icon" class="absolute -top-4 right-8 w-14 h-14 rounded-2xl bg-white/95 border border-amber-300 flex items-center justify-center shadow-lg shadow-amber-500/10 z-30">
                    <i data-lucide="nfc" class="w-7 h-7 text-amber-600"></i>
                </div>
                <div id="floating-social-1" class="absolute bottom-10 -right-4 w-12 h-12 rounded-xl bg-white/95 border border-slate-200 flex items-center justify-center shadow-md z-30">
                    <i data-lucide="instagram" class="w-5 h-5 text-pink-500"></i>
                </div>
                <div id="floating-social-2" class="absolute top-16 -left-6 w-12 h-12 rounded-xl bg-white/95 border border-slate-200 flex items-center justify-center shadow-md z-30">
                    <i data-lucide="send" class="w-5 h-5 text-sky-500"></i>
                </div>

                <!-- 3D Luxury Physical NFC Card Mockup -->
                <div id="hero-3d-card" class="relative w-80 h-48 sm:w-96 sm:h-56 rounded-2xl p-6 bg-gradient-to-br from-[#1c1c24] via-[#0f0f15] to-[#050508] border border-amber-400/60 shadow-[0_20px_50px_rgba(0,0,0,0.25)] gold-glow transform-style-3d cursor-pointer transition-shadow duration-500 z-20">
                    
                    <!-- Inner Card Header -->
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-2">
                            <i data-lucide="nfc" class="w-7 h-7 text-amber-400"></i>
                            <span class="text-xs font-mono tracking-widest text-amber-400 uppercase font-semibold">CIP CONTACTLESS</span>
                        </div>
                        <span class="text-xl font-black font-mono tracking-widest text-white">CIP<span class="text-amber-400">CARD</span></span>
                    </div>

                    <!-- Chip Visual Graphic & Waves -->
                    <div class="my-6 flex items-center gap-4">
                        <div class="w-12 h-9 rounded-md bg-gradient-to-tr from-amber-600 via-yellow-400 to-amber-200 p-0.5 shadow-md">
                            <div class="w-full h-full bg-[#181820] rounded-[4px] border border-amber-400/60 grid grid-cols-2 gap-0.5 p-1">
                                <div class="border border-amber-400/40 rounded-sm"></div>
                                <div class="border border-amber-400/40 rounded-sm"></div>
                            </div>
                        </div>
                        <div class="relative w-12 h-12 flex items-center justify-center">
                            <div class="nfc-wave w-10 h-10 border-amber-400/50"></div>
                            <div class="nfc-wave nfc-wave-delayed w-10 h-10 border-amber-400/30"></div>
                            <i data-lucide="wifi" class="w-5 h-5 text-amber-400 rotate-90"></i>
                        </div>
                    </div>

                    <!-- Card Footer Details -->
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-[9px] text-gray-400 uppercase tracking-widest font-mono">CARDHOLDER</p>
                            <p class="text-sm font-bold text-white tracking-wide">MR. CIP EXECUTIVE</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-md bg-amber-500/20 border border-amber-400/40 text-[10px] font-mono text-amber-300 font-bold tracking-wider">VIP MEMBER</span>
                    </div>
                </div>

                <!-- Phone Target Mockup for Parallax Animation -->
                <div id="phone-mockup" class="absolute w-52 h-96 rounded-[36px] bg-slate-900 border-4 border-slate-700/60 p-2 shadow-2xl -bottom-8 -left-6 opacity-40 scale-90 z-10 hidden sm:block">
                    <div class="w-full h-full rounded-[28px] bg-slate-950 border border-slate-800 overflow-hidden relative flex flex-col items-center justify-center p-3 text-center">
                        <div id="phone-screen" class="opacity-0 transition-opacity duration-700 space-y-2">
                            <div class="w-12 h-12 rounded-full bg-amber-400/20 mx-auto flex items-center justify-center border border-amber-400">
                                <i data-lucide="check" class="w-6 h-6 text-amber-400"></i>
                            </div>
                            <p class="text-xs font-bold text-white">پروفایل باز شد!</p>
                            <span class="text-[9px] text-slate-400 font-mono">cipcard.ir/@0912...</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- ==============================================================================
     3 SIMPLE STEPS SECTION (Light Theme)
     ============================================================================== -->
<section id="steps" class="py-20 bg-white border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
            <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">سریع، مدرن و استاندارد</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-[1.5] sm:leading-[1.55]">فقط ۳ مرحله تا دریافت کارت ویزیت هوشمند</h2>
            <p class="text-sm text-slate-500">بدون معطلی اطلاعات خود را ثبت کنید و کارت هوشمند اختصاصی خود را تحویل بگیرید.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-200 hover:border-amber-400 hover:bg-white hover:shadow-xl transition-all space-y-4 relative group">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 border border-amber-300 flex items-center justify-center font-black font-mono text-xl text-amber-700">
                    01
                </div>
                <h3 class="text-xl font-bold text-slate-900 group-hover:text-amber-700 transition-colors leading-[1.5]">۱. ثبت اطلاعات و انتخاب قالب</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    نام، تخصص و شماره موبایل خود را وارد کرده، بین ۵ قالب اختصاصی و پالت‌های رنگی جذاب انتخاب کنید و نوع کارت (پیش‌فرض یا طرح اختصاصی) را تعیین نمایید.
                </p>
            </div>

            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-200 hover:border-amber-400 hover:bg-white hover:shadow-xl transition-all space-y-4 relative group">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 border border-amber-300 flex items-center justify-center font-black font-mono text-xl text-amber-700">
                    02
                </div>
                <h3 class="text-xl font-bold text-slate-900 group-hover:text-amber-700 transition-colors leading-[1.5]">۲. تایید پیامکی (OTP) و پرداخت امن</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    کد یکبار مصرف ارسالی به شماره موبایل خود را تایید کنید؛ سپس حساب کاربری‌تان ایجاد شده و برای پرداخت به درگاه امن شاپرکی زرین‌پال متصل می‌شوید.
                </p>
            </div>

            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-200 hover:border-amber-400 hover:bg-white hover:shadow-xl transition-all space-y-4 relative group">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 border border-amber-300 flex items-center justify-center font-black font-mono text-xl text-amber-700">
                    03
                </div>
                <h3 class="text-xl font-bold text-slate-900 group-hover:text-amber-700 transition-colors leading-[1.5]">۳. چاپ اختصاصی و ارسال به سراسر کشور</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    کارت ویزیت شما با کیفیت چاپ مات/UV تولید شده، چیپ NFC آن با آدرس یکتای <code class="text-amber-700 font-mono">cipcard.ir/@موبایل</code> برنامه‌ریزی و با پست پیشتاز ارسال می‌شود.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- ==============================================================================
     LIVE TEMPLATES SHOWCASE (5 Unique Interactive Templates with Live Demos)
     ============================================================================== -->
<section id="templates" class="py-24 bg-slate-50/70">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
            <span class="px-3.5 py-1.5 rounded-full bg-amber-100 text-amber-800 text-xs font-bold border border-amber-300 inline-block">
                تنوع طراحی و هویت بصری
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-[1.5] sm:leading-[1.55]">۵ قالب کاملاً اختصاصی با نمونه‌های زنده</h2>
            <p class="text-sm text-slate-600">
                می‌توانید پیش‌نمایش واقعی هر ۵ قالب را آنلاین مشاهده کرده یا قالب دلخواه خود را برای سفارش انتخاب فرمایید:
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            
            <!-- 1. Minimal Luxury -->
            <div class="bg-white p-6 rounded-3xl border-2 border-slate-200 hover:border-amber-500 hover:shadow-xl transition-all flex flex-col justify-between space-y-6 group">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="px-2.5 py-1 rounded-md bg-amber-100 text-amber-800 text-[11px] font-bold">قالب ۱</span>
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                    </div>
                    <div class="w-full h-32 rounded-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-black p-3 flex flex-col justify-between text-white border border-amber-400/30">
                        <div class="flex justify-between items-center text-[10px] text-amber-300 font-mono">
                            <span>MINIMAL LUXURY</span>
                            <i data-lucide="nfc" class="w-4 h-4"></i>
                        </div>
                        <div class="space-y-1 text-center">
                            <div class="w-9 h-9 rounded-full bg-amber-400/20 border border-amber-400 mx-auto flex items-center justify-center text-xs font-bold text-amber-300">CIP</div>
                            <p class="text-xs font-bold">مدیر ارشد اجرایی</p>
                        </div>
                        <div class="text-[9px] text-gray-400 text-center font-mono">gold_black palette</div>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-lg">مینیمال و لوکس</h4>
                        <p class="text-xs text-slate-500 leading-relaxed mt-1">ترکیب مشکی مات، خاکستری نفیس و طلایی، انتخابی بی‌نظیر برای مدیران عامل، هلدینگ‌ها و برندهای لاکچری.</p>
                    </div>
                </div>

                <div class="space-y-2 pt-2 border-t border-slate-100">
                    <a href="<?= \App\Core\Helper::url('@demo-minimal') ?>" target="_blank" class="w-full py-2.5 rounded-xl bg-slate-100 text-slate-800 text-xs font-bold hover:bg-slate-200 transition-all flex items-center justify-center gap-1.5">
                        <i data-lucide="external-link" class="w-4 h-4 text-amber-600"></i>
                        <span>مشاهده نمونه زنده</span>
                    </a>
                    <button onclick="openFastOrderModal('default_cip', 'minimal')" class="w-full py-2.5 rounded-xl bg-amber-500 text-slate-950 text-xs font-extrabold hover:bg-amber-400 transition-all flex items-center justify-center gap-1.5 shadow-sm">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>سفارش با این قالب</span>
                    </button>
                </div>
            </div>

            <!-- 2. Glassmorphism -->
            <div class="bg-white p-6 rounded-3xl border-2 border-slate-200 hover:border-cyan-500 hover:shadow-xl transition-all flex flex-col justify-between space-y-6 group">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="px-2.5 py-1 rounded-md bg-cyan-100 text-cyan-800 text-[11px] font-bold">قالب ۲</span>
                        <span class="w-3 h-3 rounded-full bg-cyan-500"></span>
                    </div>
                    <div class="w-full h-32 rounded-2xl bg-gradient-to-tr from-cyan-900 via-slate-900 to-blue-950 p-3 flex flex-col justify-between text-white border border-cyan-400/30">
                        <div class="flex justify-between items-center text-[10px] text-cyan-300 font-mono">
                            <span>GLASSMORPHISM</span>
                            <i data-lucide="sparkles" class="w-4 h-4 text-cyan-400"></i>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-2 text-center border border-white/20">
                            <p class="text-xs font-bold text-white">طراح ارشد محصول</p>
                            <span class="text-[9px] text-cyan-200">افکت شیشه‌ای بلور</span>
                        </div>
                        <div class="text-[9px] text-gray-400 text-center font-mono">blue_white palette</div>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-lg">گلسمورفیسم مدرن</h4>
                        <p class="text-xs text-slate-500 leading-relaxed mt-1">طراحی شفاف شیشه‌ای با افکت بلور (Backdrop Blur)، مناسب طراحان محصول، معماران نرم‌افزار و استارتاپ‌ها.</p>
                    </div>
                </div>

                <div class="space-y-2 pt-2 border-t border-slate-100">
                    <a href="<?= \App\Core\Helper::url('@demo-glassmorphism') ?>" target="_blank" class="w-full py-2.5 rounded-xl bg-slate-100 text-slate-800 text-xs font-bold hover:bg-slate-200 transition-all flex items-center justify-center gap-1.5">
                        <i data-lucide="external-link" class="w-4 h-4 text-cyan-600"></i>
                        <span>مشاهده نمونه زنده</span>
                    </a>
                    <button onclick="openFastOrderModal('default_cip', 'glassmorphism')" class="w-full py-2.5 rounded-xl bg-cyan-500 text-slate-950 text-xs font-extrabold hover:bg-cyan-400 transition-all flex items-center justify-center gap-1.5 shadow-sm">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>سفارش با این قالب</span>
                    </button>
                </div>
            </div>

            <!-- 3. Corporate Pro -->
            <div class="bg-white p-6 rounded-3xl border-2 border-slate-200 hover:border-blue-600 hover:shadow-xl transition-all flex flex-col justify-between space-y-6 group">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="px-2.5 py-1 rounded-md bg-blue-100 text-blue-800 text-[11px] font-bold">قالب ۳</span>
                        <span class="w-3 h-3 rounded-full bg-blue-600"></span>
                    </div>
                    <div class="w-full h-32 rounded-2xl bg-gradient-to-br from-blue-900 via-slate-800 to-slate-900 p-3 flex flex-col justify-between text-white border border-blue-400/30">
                        <div class="flex justify-between items-center text-[10px] text-blue-300 font-mono">
                            <span>CORPORATE PRO</span>
                            <i data-lucide="shield" class="w-4 h-4 text-blue-400"></i>
                        </div>
                        <div class="space-y-1 text-center">
                            <p class="text-xs font-bold">وکیل پایه یک / پزشک</p>
                            <span class="text-[9px] text-blue-200">ساختار رسمی و آکادمیک</span>
                        </div>
                        <div class="text-[9px] text-gray-400 text-center font-mono">emerald_gray palette</div>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-lg">شرکتی و رسمی</h4>
                        <p class="text-xs text-slate-500 leading-relaxed mt-1">ساختار منظم، دکمه‌های تماس برجسته، مناسب وکلا، پزشکان، دفاتر اسناد، مهندسان مشاور و شرکت‌ها.</p>
                    </div>
                </div>

                <div class="space-y-2 pt-2 border-t border-slate-100">
                    <a href="<?= \App\Core\Helper::url('@demo-corporate') ?>" target="_blank" class="w-full py-2.5 rounded-xl bg-slate-100 text-slate-800 text-xs font-bold hover:bg-slate-200 transition-all flex items-center justify-center gap-1.5">
                        <i data-lucide="external-link" class="w-4 h-4 text-blue-600"></i>
                        <span>مشاهده نمونه زنده</span>
                    </a>
                    <button onclick="openFastOrderModal('default_cip', 'corporate')" class="w-full py-2.5 rounded-xl bg-blue-600 text-white text-xs font-extrabold hover:bg-blue-500 transition-all flex items-center justify-center gap-1.5 shadow-sm">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>سفارش با این قالب</span>
                    </button>
                </div>
            </div>

            <!-- 4. Creative Dark -->
            <div class="bg-white p-6 rounded-3xl border-2 border-slate-200 hover:border-purple-500 hover:shadow-xl transition-all flex flex-col justify-between space-y-6 group">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="px-2.5 py-1 rounded-md bg-purple-100 text-purple-800 text-[11px] font-bold">قالب ۴</span>
                        <span class="w-3 h-3 rounded-full bg-purple-500"></span>
                    </div>
                    <div class="w-full h-32 rounded-2xl bg-gradient-to-tr from-purple-950 via-slate-950 to-black p-3 flex flex-col justify-between text-white border border-purple-500/40">
                        <div class="flex justify-between items-center text-[10px] text-purple-300 font-mono">
                            <span>CREATIVE NEON</span>
                            <i data-lucide="palette" class="w-4 h-4 text-purple-400"></i>
                        </div>
                        <div class="space-y-1 text-center">
                            <p class="text-xs font-bold text-purple-300">مدیر هنری و خلاقیت</p>
                            <span class="text-[9px] text-gray-400">هایلایت‌های نئونی تیره</span>
                        </div>
                        <div class="text-[9px] text-gray-400 text-center font-mono">gold_black palette</div>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-lg">خلاقانه نئون/تیره</h4>
                        <p class="text-xs text-slate-500 leading-relaxed mt-1">جلوه‌های بصری جسورانه و تیره، ایده‌آل برای برنامه‌نویسان، هنرمندان، طراحان گرافیک و دیجیتال مارکترها.</p>
                    </div>
                </div>

                <div class="space-y-2 pt-2 border-t border-slate-100">
                    <a href="<?= \App\Core\Helper::url('@demo-creative') ?>" target="_blank" class="w-full py-2.5 rounded-xl bg-slate-100 text-slate-800 text-xs font-bold hover:bg-slate-200 transition-all flex items-center justify-center gap-1.5">
                        <i data-lucide="external-link" class="w-4 h-4 text-purple-600"></i>
                        <span>مشاهده نمونه زنده</span>
                    </a>
                    <button onclick="openFastOrderModal('default_cip', 'creative_dark')" class="w-full py-2.5 rounded-xl bg-purple-600 text-white text-xs font-extrabold hover:bg-purple-500 transition-all flex items-center justify-center gap-1.5 shadow-sm">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>سفارش با این قالب</span>
                    </button>
                </div>
            </div>

            <!-- 5. Modern Card (3D Flip) -->
            <div class="bg-white p-6 rounded-3xl border-2 border-slate-200 hover:border-emerald-500 hover:shadow-xl transition-all flex flex-col justify-between space-y-6 group">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-800 text-[11px] font-bold">قالب ۵</span>
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                    </div>
                    <div class="w-full h-32 rounded-2xl bg-gradient-to-tr from-emerald-950 via-slate-900 to-slate-950 p-3 flex flex-col justify-between text-white border border-emerald-400/30">
                        <div class="flex justify-between items-center text-[10px] text-emerald-300 font-mono">
                            <span>3D CARD FLIP</span>
                            <i data-lucide="rotate-cw" class="w-4 h-4 text-emerald-400"></i>
                        </div>
                        <div class="space-y-1 text-center">
                            <p class="text-xs font-bold text-white">مشاور بین‌الملل</p>
                            <span class="text-[9px] text-emerald-200">چرخش سه‌بعدی کارت فیزیکی</span>
                        </div>
                        <div class="text-[9px] text-gray-400 text-center font-mono">blue_white palette</div>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-lg">کارت ویزیت سه‌بعدی</h4>
                        <p class="text-xs text-slate-500 leading-relaxed mt-1">شبیه‌ساز لمسی کارت فیزیکی با قابلیت چرخش سه‌بعدی (Flip) و نمایش رو و پشت کارت، فوق‌العاده شیک و جذاب.</p>
                    </div>
                </div>

                <div class="space-y-2 pt-2 border-t border-slate-100">
                    <a href="<?= \App\Core\Helper::url('@demo-modern') ?>" target="_blank" class="w-full py-2.5 rounded-xl bg-slate-100 text-slate-800 text-xs font-bold hover:bg-slate-200 transition-all flex items-center justify-center gap-1.5">
                        <i data-lucide="external-link" class="w-4 h-4 text-emerald-600"></i>
                        <span>مشاهده نمونه زنده</span>
                    </a>
                    <button onclick="openFastOrderModal('default_cip', 'modern_card')" class="w-full py-2.5 rounded-xl bg-emerald-600 text-white text-xs font-extrabold hover:bg-emerald-500 transition-all flex items-center justify-center gap-1.5 shadow-sm">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>سفارش با این قالب</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ==============================================================================
     PRICING & PLANS SECTION (Light Luxury Theme)
     ============================================================================== -->
<section id="pricing" class="py-24 bg-white border-t border-slate-200">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto space-y-3 mb-16">
            <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">تعرفه‌ها و پلن‌های سفارش</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-[1.5] sm:leading-[1.55]">پلن متناسب با سطح پرستیژ خود را انتخاب کنید</h2>
            <p class="text-sm text-slate-500">تمامی پلن‌ها شامل دسترسی مادام‌العمر به پنل کاربری بدون هرگونه اشتراک ماهانه است.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
            
            <!-- Plan 1: Default CIP -->
            <div class="bg-slate-50 p-8 sm:p-10 rounded-3xl border-2 border-slate-200 flex flex-col justify-between space-y-8 hover:border-slate-400 hover:shadow-xl transition-all">
                <div class="space-y-5">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">پلن استاندارد VIP</span>
                        <span class="px-3 py-1 rounded-full bg-white border border-slate-200 text-xs text-slate-700 font-semibold">تحویل سریع ۲ روزه</span>
                    </div>
                    
                    <div>
                        <h3 class="text-2xl font-black text-slate-900 leading-[1.5]">طرح پیش‌فرض CIP</h3>
                        <p class="text-xs text-slate-500 mt-1">کارت مشکی متالیک مات با حک طلایی لوگوی رسمی CIPCard؛ آماده استفاده فوری.</p>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-200">
                        <span class="text-3xl font-black text-slate-900"><?= \App\Core\Helper::formatPrice($priceDefault) ?></span>
                        <span class="text-xs text-slate-500 mr-2">هزینه یک‌باره (مادام‌العمر)</span>
                    </div>

                    <ul class="space-y-3 pt-2 text-sm text-slate-700">
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i><span>کارت فیزیکی هوشمند با روکش مات و ضدآب</span></li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i><span>پروفایل اختصاصی بر روی <span class="font-mono text-amber-700">cipcard.ir/@موبایل</span></span></li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i><span>دسترسی کامل به تمام ۵ قالب و پالت‌های رنگی</span></li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i><span>تولید QR Code وکتور و فایل اختصاصی vCard</span></li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i><span>پنل مدیریت با امکان ویرایش نامحدود اطلاعات</span></li>
                    </ul>
                </div>

                <button onclick="openFastOrderModal('default_cip')" class="w-full py-4 rounded-2xl bg-white border-2 border-slate-300 text-slate-900 font-bold text-sm hover:border-amber-500 hover:text-amber-700 hover:shadow-md transition-all flex items-center justify-center gap-2">
                    <i data-lucide="credit-card" class="w-4 h-4 text-amber-600"></i>
                    <span>سفارش با طرح پیش‌فرض</span>
                </button>
            </div>

            <!-- Plan 2: Custom Corporate Design -->
            <div class="bg-gradient-to-b from-amber-50/70 via-white to-amber-50/40 p-8 sm:p-10 rounded-3xl border-2 border-amber-400 flex flex-col justify-between space-y-8 relative shadow-xl shadow-amber-500/10">
                <div class="absolute -top-3.5 right-8 px-4 py-1 rounded-full bg-gradient-to-r from-amber-500 to-yellow-500 text-slate-950 text-xs font-extrabold uppercase tracking-wider shadow-sm">
                    پیشنهاد ویژه برندها و سازمان‌ها
                </div>

                <div class="space-y-5">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-amber-800 uppercase tracking-wider">پلن اختصاصی و سازمانی</span>
                        <span class="px-3 py-1 rounded-full bg-amber-100 border border-amber-300 text-xs text-amber-900 font-semibold">شخصی‌سازی ۱۰۰٪</span>
                    </div>
                    
                    <div>
                        <h3 class="text-2xl font-black text-slate-900 leading-[1.5]">طرح اختصاصی (Custom Design)</h3>
                        <p class="text-xs text-slate-500 mt-1">چاپ دو رو با رنگ سازمانی، هویت بصری و لوگوی شرکت شما روی متریال لوکس.</p>
                    </div>
                    
                    <div class="pt-4 border-t border-amber-200">
                        <span class="text-3xl font-black text-amber-700"><?= \App\Core\Helper::formatPrice($priceCustom) ?></span>
                        <span class="text-xs text-slate-500 mr-2">هزینه طراحی، چاپ دورو و چیپ NFC</span>
                    </div>

                    <ul class="space-y-3 pt-2 text-sm text-slate-700">
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-amber-600"></i><span>چاپ اختصاصی با رنگ سازمانی و لوگوی شما</span></li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-amber-600"></i><span>امکان آپلود مستقیم فایل طراحی در پنل کاربری</span></li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-amber-600"></i><span>پروفایل هوشمند با آدرس یکتای <span class="font-mono text-amber-700">/@موبایل</span></span></li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-amber-600"></i><span>چاپ با بالاترین کیفیت UV ضد خش و ضد آب</span></li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-amber-600"></i><span>گارانتی تعویض و کارکرد مادام‌العمر چیپست NFC</span></li>
                    </ul>
                </div>

                <button onclick="openFastOrderModal('custom_design')" class="w-full py-4 rounded-2xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 text-slate-950 font-extrabold text-sm hover:brightness-105 shadow-lg shadow-amber-500/20 active:scale-95 transition-all flex items-center justify-center gap-2">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                    <span>سفارش با طرح اختصاصی سازمانی</span>
                </button>
            </div>

        </div>
    </div>
</section>

<!-- ==============================================================================
     FAQ SECTION (Light Theme Accordion)
     ============================================================================== -->
<section id="faq" class="py-20 bg-slate-50 border-t border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="text-center space-y-3">
            <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">پاسخ به سوالات پرتکرار</span>
            <h2 class="text-3xl font-extrabold text-slate-900 leading-[1.5]">سوالات متداول مشتریان CIPCard</h2>
        </div>

        <div class="space-y-4">
            <details class="group bg-white p-6 rounded-2xl border border-slate-200 shadow-sm [&_svg]:open:-rotate-180 transition-all">
                <summary class="flex justify-between items-center font-bold text-slate-900 cursor-pointer list-none">
                    <span>آیا مخاطب برای دریافت اطلاعات من نیاز به نصب اپلیکیشن دارد؟</span>
                    <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 group-hover:text-amber-600 transition-transform"></i>
                </summary>
                <p class="text-sm text-slate-600 leading-relaxed mt-4 pt-4 border-t border-slate-100">
                    خیر، به هیچ وجه! مخاطب تنها با نزدیک کردن گوشی خود (آیفون یا اندروید) به کارت شما، صفحه اختصاصی پروفایل را مشاهده کرده و می‌تواند با ۱ کلیک دکمه «ذخیره در مخاطبین»، تمامی شماره‌ها، شبکه‌های اجتماعی و آدرس شما را در گوشی خود ذخیره کند.
                </p>
            </details>

            <details class="group bg-white p-6 rounded-2xl border border-slate-200 shadow-sm [&_svg]:open:-rotate-180 transition-all">
                <summary class="flex justify-between items-center font-bold text-slate-900 cursor-pointer list-none">
                    <span>اگر گوشی مخاطب قدیمی بود یا قابلیت NFC نداشت چگونه عمل می‌کند؟</span>
                    <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 group-hover:text-amber-600 transition-transform"></i>
                </summary>
                <p class="text-sm text-slate-600 leading-relaxed mt-4 pt-4 border-t border-slate-100">
                    پشت هر کارت یک QR Code وکتور با کیفیت بالا چاپ می‌شود. بنابراین هر فردی با دوربین ساده موبایل می‌تواند بارکد را اسکن کرده و بلافاصله به پروفایل آنلاین شما متصل شود.
                </p>
            </details>

            <details class="group bg-white p-6 rounded-2xl border border-slate-200 shadow-sm [&_svg]:open:-rotate-180 transition-all">
                <summary class="flex justify-between items-center font-bold text-slate-900 cursor-pointer list-none">
                    <span>آیا پس از چاپ کارت، امکان تغییر اطلاعات، عکس و شماره‌ها وجود دارد؟</span>
                    <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 group-hover:text-amber-600 transition-transform"></i>
                </summary>
                <p class="text-sm text-slate-600 leading-relaxed mt-4 pt-4 border-t border-slate-100">
                    بله! شما دسترسی دائمی به داشبورد کاربری خود در <code class="font-mono text-amber-700">cipcard.ir/dashboard</code> دارید. هر زمان که شماره تماس، سمت شغلی، شبکه‌های اجتماعی یا قالب خود را تغییر دهید، تغییرات در کسری از ثانیه روی کارت فیزیکی شما اعمال می‌شود.
                </p>
            </details>

            <details class="group bg-white p-6 rounded-2xl border border-slate-200 shadow-sm [&_svg]:open:-rotate-180 transition-all">
                <summary class="flex justify-between items-center font-bold text-slate-900 cursor-pointer list-none">
                    <span>آیا سفارش برای شرکت‌ها و با تعداد بالا شامل تخفیف سازمانی می‌شود؟</span>
                    <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 group-hover:text-amber-600 transition-transform"></i>
                </summary>
                <p class="text-sm text-slate-600 leading-relaxed mt-4 pt-4 border-t border-slate-100">
                    بله؛ سازمان‌ها و مجموعه‌هایی که برای مدیران یا پرسنل خود سفارش بیش از ۵ عدد کارت اختصاصی دارند، می‌توانند با شماره پشتیبانی <?= \App\Core\Helper::e(\App\Models\Setting::get('support_phone', '021-91000000')) ?> تماس بگیرند تا از تخفیف‌های ویژه سازمانی بهره‌مند شوند.
                </p>
            </details>
        </div>
    </div>
</section>

<!-- ==============================================================================
     FAST ORDER MODAL (Step 1 Info & Step 2 OTP Engine)
     ============================================================================== -->
<div id="fast-order-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="relative w-full max-w-lg bg-white rounded-3xl border border-slate-200 shadow-2xl p-6 sm:p-8 my-8 text-right">
        
        <!-- Close Button -->
        <button onclick="closeFastOrderModal()" class="absolute top-6 left-6 text-slate-400 hover:text-slate-800 transition-colors">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>

        <!-- STEP 1: Fast Order Info Form -->
        <div id="step-order-form" class="space-y-6">
            <div>
                <span class="text-xs font-bold text-amber-600">مرحله ۱ از ۳</span>
                <h3 class="text-2xl font-black text-slate-900 mt-1 leading-[1.5]">ثبت سفارش سریع کارت هوشمند</h3>
                <p class="text-xs text-slate-500 mt-1">مشخصات اولیه خود را وارد فرمایید تا پروفایل هوشمند شما ساخته شود.</p>
            </div>

            <!-- Card Type Toggle -->
            <div class="flex gap-3">
                <button type="button" id="btn-type-default" onclick="selectCardType('default_cip')" class="flex-1 py-3 px-4 rounded-xl text-center text-sm font-bold border-2 border-amber-500 bg-amber-50 text-amber-800 transition-all">
                    طرح پیش‌فرض CIP
                </button>
                <button type="button" id="btn-type-custom" onclick="selectCardType('custom_design')" class="flex-1 py-3 px-4 rounded-xl text-center text-sm font-semibold border border-slate-300 bg-slate-50 text-slate-600 hover:text-slate-900 transition-all">
                    طرح اختصاصی لوگودار
                </button>
            </div>

            <form id="fast-order-form" class="space-y-4">
                <input type="hidden" name="card_type" id="modal-card-type" value="default_cip">
                <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::getToken() ?>">

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">نام و نام خانوادگی *</label>
                    <input type="text" name="full_name" required placeholder="مثال: دکتر علیرضا سهرابی" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:border-amber-500 focus:outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">عنوان شغلی یا تخصص</label>
                    <input type="text" name="job_title" placeholder="مثال: مدیرعامل هلدینگ / وکیل پایه یک" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:border-amber-500 focus:outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">شماره موبایل (شناسه یکتا و نام کاربری) *</label>
                    <input type="tel" name="mobile" required placeholder="09123456789" dir="ltr" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm text-left focus:bg-white focus:border-amber-500 focus:outline-none transition-all font-mono">
                    <span class="text-[11px] text-slate-500 mt-1 block">کد تایید پیامکی و آدرس پروفایل شما با این شماره تنظیم خواهد شد.</span>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">انتخاب قالب اولیه</label>
                        <select name="template_id" id="modal-template-select" class="w-full px-3 py-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs focus:bg-white focus:border-amber-500 focus:outline-none">
                            <option value="minimal">۱. مینیمال و لوکس</option>
                            <option value="glassmorphism">۲. گلسمورفیسم مدرن</option>
                            <option value="corporate">۳. شرکتی و رسمی</option>
                            <option value="creative_dark">۴. خلاقانه نئون/تیره</option>
                            <option value="modern_card">۵. کارت ویزیت سه‌بعدی</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">پالت رنگی</label>
                        <select name="theme_color" class="w-full px-3 py-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs focus:bg-white focus:border-amber-500 focus:outline-none">
                            <option value="gold_black">طلایی - مشکی</option>
                            <option value="blue_white">آبی - سرمه‌ای</option>
                            <option value="emerald_gray">سبز زمردی - طوسی</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full mt-4 py-4 rounded-xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 text-slate-950 font-extrabold text-sm shadow-xl shadow-amber-500/20 hover:brightness-105 active:scale-95 transition-all">
                    ادامه و دریافت کد تایید پیامکی
                </button>
            </form>
        </div>

        <!-- STEP 2: OTP Verification Form -->
        <div id="step-otp-form" class="hidden space-y-6">
            <div>
                <span class="text-xs font-bold text-amber-600">مرحله ۲ از ۳</span>
                <h3 class="text-2xl font-black text-slate-900 mt-1 leading-[1.5]">تایید شماره موبایل</h3>
                <p class="text-xs text-slate-500 mt-1">
                    کد تایید ارسال‌شده به شماره <span id="otp-mobile-display" class="font-mono font-bold text-amber-700"></span> را وارد کنید:
                </p>
            </div>

            <form id="otp-verify-form" class="space-y-4">
                <div>
                    <input type="text" id="otp-code-input" maxlength="6" placeholder="• • • • •" dir="ltr" class="w-full text-center tracking-[1em] text-2xl font-mono px-4 py-3.5 rounded-xl bg-slate-50 border-2 border-amber-500 text-slate-900 focus:bg-white focus:outline-none">
                </div>

                <div class="flex items-center justify-between text-xs text-slate-500">
                    <span id="otp-timer">02:00 تا ارسال مجدد</span>
                    <button type="button" id="btn-resend-otp" onclick="resendOtp()" class="text-amber-700 font-bold hover:underline hidden">
                        ارسال مجدد کد تایید
                    </button>
                </div>

                <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 text-slate-950 font-extrabold text-sm shadow-xl shadow-amber-500/20 hover:brightness-105 active:scale-95 transition-all">
                    تایید کد و انتقال به درگاه پرداخت
                </button>
            </form>
        </div>

    </div>
</div>
