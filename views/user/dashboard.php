<div class="space-y-8">
    
    <!-- Header Welcome & Quick Stats -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-brand-border/40">
        <div>
            <h1 class="text-2xl font-black text-white">سلام، <?= \App\Core\Helper::e($user['full_name']) ?> 👋</h1>
            <p class="text-xs text-gray-400 mt-1">مدیریت کارت ویزیت هوشمند، آمار بازدید و پیگیری سفارشات شما</p>
        </div>
        <div class="flex items-center gap-3">
            <?php if ($profile && $profile['is_active']): ?>
                <a href="<?= \App\Core\Helper::e($profileUrl) ?>" target="_blank" class="px-4 py-2.5 rounded-xl bg-brand-surfaceHover border border-brand-gold/40 text-brand-gold hover:bg-brand-gold hover:text-black transition-all text-xs font-bold flex items-center gap-2">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    <span>مشاهده صفحه پروفایل</span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Active Profile Alert & URL Copy Box -->
    <?php if ($profile && $profile['is_active']): ?>
        <div class="p-6 rounded-3xl bg-gradient-to-r from-[#171720] via-brand-surface to-[#121217] border border-brand-gold/30 shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center md:text-right">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    کارت هوشمند و پروفایل فعال است
                </span>
                <h3 class="text-lg font-bold text-white">لینک عمومی کارت ویزیت شما:</h3>
                <p class="text-xs text-gray-400">با لمس کارت روی گوشی مخاطبان، این آدرس به صورت خودکار باز خواهد شد.</p>
                <div class="pt-2 flex items-center gap-2 font-mono text-sm text-brand-gold">
                    <input type="text" readonly value="<?= \App\Core\Helper::e($profileUrl) ?>" class="px-4 py-2 rounded-xl bg-black/40 border border-brand-border text-white text-xs w-64 md:w-80">
                    <button onclick="navigator.clipboard.writeText('<?= \App\Core\Helper::e($profileUrl) ?>'); alert('لینک در کلیپ‌بورد کپی شد!');" class="p-2.5 rounded-xl bg-brand-surface border border-brand-border text-gray-300 hover:text-brand-gold hover:border-brand-gold transition-all" title="کپی لینک">
                        <i data-lucide="copy" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="w-28 h-28 p-2 bg-white rounded-2xl shadow-lg flex items-center justify-center">
                    <img src="<?= $qrCodeDataUri ?>" alt="QR Code" class="w-full h-full object-contain">
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="p-6 rounded-3xl bg-amber-500/10 border border-amber-500/30 text-amber-300 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4 text-center sm:text-right">
                <i data-lucide="alert-triangle" class="w-10 h-10 flex-shrink-0 text-amber-400"></i>
                <div>
                    <h4 class="font-bold text-white text-sm">پروفایل در انتظار پرداخت و فعال‌سازی</h4>
                    <p class="text-xs text-amber-300/80 mt-1">سفارش شما ثبت شده است اما هنوز پرداخت نهایی صورت نگرفته است.</p>
                </div>
            </div>
            <?php if ($latestOrder && $latestOrder['status'] === 'unpaid'): ?>
                <a href="<?= \App\Core\Helper::url('order/retry/' . $latestOrder['order_number']) ?>" class="px-6 py-3 rounded-xl bg-gradient-to-r from-amber-600 to-amber-400 text-black font-extrabold text-xs shadow-lg shadow-amber-500/20 hover:brightness-110 transition-all flex items-center gap-2">
                    <i data-lucide="credit-card" class="w-4 h-4"></i>
                    <span>تلاش مجدد برای پرداخت سفارش</span>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Order Tracker Stepper (Order Progress) -->
    <?php if ($latestOrder): ?>
        <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-brand-border/40 pb-4">
                <div>
                    <h3 class="font-bold text-white text-base">پیگیری وضعیت سفارش (Order Stepper)</h3>
                    <p class="text-xs text-gray-400 font-mono mt-0.5">شماره سفارش: <?= \App\Core\Helper::e($latestOrder['order_number']) ?></p>
                </div>
                <div>
                    <span class="text-xs px-3 py-1.5 rounded-full bg-brand-darker border border-brand-border font-bold text-brand-gold">
                        <?= $latestOrder['card_type'] === 'custom_design' ? 'طرح اختصاصی' : 'طرح پیش‌فرض CIP' ?>
                    </span>
                </div>
            </div>

            <!-- Stepper Graphical UI -->
            <?php
            $statuses = ['unpaid' => 0, 'pending_design' => 1, 'printing' => 2, 'shipped' => 3, 'delivered' => 4];
            $currentStepIndex = $statuses[$latestOrder['status']] ?? 1;
            ?>
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 relative">
                
                <!-- Step 1 -->
                <div class="p-4 rounded-2xl border <?= $currentStepIndex >= 1 ? 'bg-brand-gold/10 border-brand-gold text-brand-gold' : 'bg-black/20 border-brand-border text-gray-500' ?> flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs <?= $currentStepIndex >= 1 ? 'bg-brand-gold text-black' : 'bg-gray-800 text-gray-400' ?>">1</div>
                    <div>
                        <p class="text-xs font-bold text-white">ثبت و پرداخت</p>
                        <span class="text-[10px]"><?= $currentStepIndex >= 1 ? 'انجام شد' : 'در انتظار پرداخت' ?></span>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="p-4 rounded-2xl border <?= $currentStepIndex >= 2 ? 'bg-brand-gold/10 border-brand-gold text-brand-gold' : ($currentStepIndex === 1 ? 'bg-amber-500/10 border-amber-500 text-amber-400' : 'bg-black/20 border-brand-border text-gray-500') ?> flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs <?= $currentStepIndex >= 2 ? 'bg-brand-gold text-black' : 'bg-gray-800 text-gray-400' ?>">2</div>
                    <div>
                        <p class="text-xs font-bold text-white">طراحی و تایید</p>
                        <span class="text-[10px]"><?= $currentStepIndex >= 2 ? 'تایید شد' : ($currentStepIndex === 1 ? 'در حال طراحی' : 'در نوبت') ?></span>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="p-4 rounded-2xl border <?= $currentStepIndex >= 3 ? 'bg-brand-gold/10 border-brand-gold text-brand-gold' : ($currentStepIndex === 2 ? 'bg-amber-500/10 border-amber-500 text-amber-400' : 'bg-black/20 border-brand-border text-gray-500') ?> flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs <?= $currentStepIndex >= 3 ? 'bg-brand-gold text-black' : 'bg-gray-800 text-gray-400' ?>">3</div>
                    <div>
                        <p class="text-xs font-bold text-white">چاپ و چیپ NFC</p>
                        <span class="text-[10px]"><?= $currentStepIndex >= 3 ? 'پایان چاپ' : ($currentStepIndex === 2 ? 'در حال چاپ' : 'در نوبت') ?></span>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="p-4 rounded-2xl border <?= $currentStepIndex >= 3 ? 'bg-emerald-500/10 border-emerald-500 text-emerald-400' : 'bg-black/20 border-brand-border text-gray-500' ?> flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs <?= $currentStepIndex >= 3 ? 'bg-emerald-400 text-black' : 'bg-gray-800 text-gray-400' ?>">4</div>
                    <div>
                        <p class="text-xs font-bold text-white">تحویل به پست</p>
                        <span class="text-[10px]"><?= !empty($latestOrder['tracking_code']) ? 'کد رهگیری صادر شد' : 'آماده‌سازی ارسال' ?></span>
                    </div>
                </div>

            </div>

            <!-- Postal Tracking Display -->
            <?php if (!empty($latestOrder['tracking_code'])): ?>
                <div class="p-4 rounded-2xl bg-black/40 border border-emerald-500/40 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-2 text-emerald-400 font-bold">
                        <i data-lucide="package-check" class="w-5 h-5"></i>
                        <span>مرسوله شما تحویل پست پیشتاز گردید:</span>
                    </div>
                    <div class="flex items-center gap-3 font-mono">
                        <span class="text-gray-300">کد رهگیری:</span>
                        <span class="px-3 py-1 rounded bg-emerald-500/20 text-emerald-300 font-bold tracking-widest"><?= \App\Core\Helper::e($latestOrder['tracking_code']) ?></span>
                        <a href="https://tracking.post.ir" target="_blank" class="text-brand-gold hover:underline">سامانه رهگیری پست</a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Custom Design Upload Form (If custom design selected and file not uploaded) -->
            <?php if ($latestOrder['card_type'] === 'custom_design' && empty($latestOrder['custom_design_file'])): ?>
                <div class="p-5 rounded-2xl bg-brand-surfaceHover border border-brand-gold/30 space-y-4">
                    <div class="space-y-1">
                        <h4 class="text-sm font-bold text-white">آپلود فایل لوگو یا طرح اختصاصی کارت</h4>
                        <p class="text-xs text-gray-400">فایل لوگو یا طراحی کارت خود را (فرمت‌های JPG, PNG, PDF, PSD, ZIP تا سقف ۱۵ مگابایت) ارسال کنید:</p>
                    </div>

                    <form action="<?= \App\Core\Helper::url('order/upload-design') ?>" method="POST" enctype="multipart/form-data" class="space-y-3">
                        <?= \App\Core\Csrf::field() ?>
                        <input type="hidden" name="order_id" value="<?= $latestOrder['id'] ?>">

                        <div class="flex flex-col sm:flex-row gap-3">
                            <input type="file" name="design_file" required class="flex-1 text-xs text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-gold file:text-black hover:file:brightness-110 cursor-pointer">
                            <input type="text" name="custom_design_notes" placeholder="توضیحات طراحی یا کد رنگ سازمانی (اختیاری)" class="flex-1 px-4 py-2.5 rounded-xl bg-brand-darker border border-brand-border text-xs text-white focus:outline-none">
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-gold text-black font-bold text-xs hover:brightness-110 transition-all flex items-center justify-center gap-1">
                                <i data-lucide="upload" class="w-4 h-4"></i>
                                <span>ارسال فایل طرح</span>
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>

    <!-- Template Switcher & Color Customizer -->
    <div class="p-6 sm:p-8 rounded-3xl bg-brand-surface border border-brand-border/60 space-y-6">
        <div>
            <h3 class="font-bold text-white text-base">تغییر قالب و پالت رنگی کارت ویزیت هوشمند</h3>
            <p class="text-xs text-gray-400 mt-1">با انتخاب هر قالب و تم، تغییرات بلافاصله روی لینک اختصاصی شما اعمال می‌شود.</p>
        </div>

        <form action="<?= \App\Core\Helper::url('dashboard/switch-template') ?>" method="POST" class="space-y-6">
            <?= \App\Core\Csrf::field() ?>
            
            <div class="grid grid-cols-1 sm:grid-cols-5 gap-4">
                <?php
                $currentTemplate = $profile['template_id'] ?? 'minimal';
                $tplOptions = [
                    'minimal'       => ['title' => 'مینیمال و لوکس', 'desc' => 'مشکی طلایی، مدرن'],
                    'glassmorphism' => ['title' => 'گلسمورفیسم', 'desc' => 'شیشه‌ای و بلور'],
                    'corporate'     => ['title' => 'شرکتی و رسمی', 'desc' => 'پزشکان و وکلا'],
                    'creative_dark' => ['title' => 'خلاقانه نئون', 'desc' => 'استارتاپی و دارک'],
                    'modern_card'   => ['title' => 'کارت ویزیت کلاسیک', 'desc' => 'چرخش سه‌بعدی']
                ];
                ?>
                <?php foreach ($tplOptions as $key => $opt): ?>
                    <label class="relative p-4 rounded-2xl border cursor-pointer transition-all <?= $currentTemplate === $key ? 'bg-brand-gold/10 border-brand-gold' : 'bg-brand-darker border-brand-border/60 hover:border-gray-500' ?>">
                        <input type="radio" name="template_id" value="<?= $key ?>" <?= $currentTemplate === $key ? 'checked' : '' ?> class="sr-only">
                        <div class="space-y-1">
                            <span class="block text-xs font-bold text-white"><?= $opt['title'] ?></span>
                            <span class="block text-[11px] text-gray-400"><?= $opt['desc'] ?></span>
                        </div>
                        <?php if ($currentTemplate === $key): ?>
                            <div class="absolute top-2 left-2 text-brand-gold"><i data-lucide="check-circle" class="w-4 h-4"></i></div>
                        <?php endif; ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <!-- Theme Mode Selector (Light vs Dark) -->
            <div class="pt-4 border-t border-brand-border/40 space-y-3">
                <label class="block text-xs font-bold text-gray-300">انتخاب حالت تم کارت ویزیت (روشن / تیره):</label>
                <?php $currentMode = $profile['theme_mode'] ?? 'light'; ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="p-4 rounded-2xl border cursor-pointer flex items-center justify-between transition-all <?= $currentMode === 'light' ? 'bg-amber-500/10 border-amber-400' : 'bg-brand-darker border-brand-border' ?>">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="theme_mode" value="light" <?= $currentMode === 'light' ? 'checked' : '' ?>>
                            <div>
                                <span class="block text-xs font-bold text-white flex items-center gap-1.5">
                                    <i data-lucide="sun" class="w-4 h-4 text-amber-500"></i>
                                    <span>تم روشن (Light Mode)</span>
                                </span>
                                <span class="text-[11px] text-gray-400">پس‌زمینه سفید، تمیز و فوق‌العاده خوانا</span>
                            </div>
                        </div>
                        <span class="text-[10px] px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-bold">پیشنهادی</span>
                    </label>

                    <label class="p-4 rounded-2xl border cursor-pointer flex items-center justify-between transition-all <?= $currentMode === 'dark' ? 'bg-amber-500/10 border-amber-400' : 'bg-brand-darker border-brand-border' ?>">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="theme_mode" value="dark" <?= $currentMode === 'dark' ? 'checked' : '' ?>>
                            <div>
                                <span class="block text-xs font-bold text-white flex items-center gap-1.5">
                                    <i data-lucide="moon" class="w-4 h-4 text-sky-400"></i>
                                    <span>تم تیره (Dark Mode)</span>
                                </span>
                                <span class="text-[11px] text-gray-400">مشکی متالیک لوکس و مدرن</span>
                            </div>
                        </div>
                        <span class="text-[10px] px-2.5 py-1 rounded-full bg-slate-800 text-gray-300 font-mono">VIP Dark</span>
                    </label>
                </div>
            </div>

            <!-- Color Palette Selector -->
            <div class="pt-2">
                <label class="block text-xs font-bold text-gray-300 mb-3">انتخاب پالت رنگی قالب:</label>
                <?php $currentTheme = $profile['theme_color'] ?? 'gold_black'; ?>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="theme_color" value="gold_black" <?= $currentTheme === 'gold_black' ? 'checked' : '' ?>>
                        <span class="w-4 h-4 rounded-full bg-[#D4AF37] border border-black inline-block"></span>
                        <span class="text-xs text-gray-300">طلایی - مشکی</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="theme_color" value="blue_white" <?= $currentTheme === 'blue_white' ? 'checked' : '' ?>>
                        <span class="w-4 h-4 rounded-full bg-[#38BDF8] border border-black inline-block"></span>
                        <span class="text-xs text-gray-300">آبی - سرمه‌ای</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="theme_color" value="emerald_gray" <?= $currentTheme === 'emerald_gray' ? 'checked' : '' ?>>
                        <span class="w-4 h-4 rounded-full bg-[#10B981] border border-black inline-block"></span>
                        <span class="text-xs text-gray-300">سبز زمردی - طوسی</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="px-6 py-3 rounded-xl bg-brand-gold text-black font-bold text-xs hover:brightness-110 shadow-lg shadow-brand-gold/10 transition-all">
                ذخیره و اعمال روی کارت
            </button>
        </form>
    </div>

</div>
