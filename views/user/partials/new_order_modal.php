<!-- New Smart Card Order Modal -->
<div id="newOrderModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/80 backdrop-blur-sm p-4 flex items-center justify-center">
    <div class="relative w-full max-w-xl rounded-3xl bg-brand-surface border border-brand-gold/40 shadow-2xl p-6 sm:p-8 space-y-6 my-8">
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-brand-border/60 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-brand-gold/10 text-brand-gold border border-brand-gold/30 flex items-center justify-center">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white">ثبت سفارش کارت هوشمند جدید</h3>
                    <p class="text-xs text-gray-400">سفارش برای خودتان، همکاران، پرسنل شرکت یا شعب جدید</p>
                </div>
            </div>
            <button type="button" onclick="closeNewOrderModal()" class="text-gray-400 hover:text-white p-2 rounded-xl bg-brand-darker border border-brand-border">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="<?= \App\Core\Helper::url('dashboard/order/new') ?>" method="POST" enctype="multipart/form-data" class="space-y-5">
            <?= \App\Core\Csrf::field() ?>

            <!-- Card Type Selection -->
            <div class="space-y-3">
                <label class="block text-xs font-bold text-gray-300">انتخاب نوع کارت هوشمند NFC:</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="p-4 rounded-2xl border cursor-pointer transition-all bg-brand-darker border-brand-border hover:border-brand-gold" id="label-default">
                        <input type="radio" name="card_type" value="default_cip" checked onchange="toggleOrderCardType(this.value)" class="sr-only">
                        <div class="space-y-1.5">
                            <span class="block text-xs font-bold text-white">طرح پیش‌فرض CIPCard</span>
                            <span class="block text-[11px] text-gray-400">کارت متالیک لوکس با چیپ NFC و QR اختصاصی</span>
                            <span class="inline-block text-xs font-extrabold text-brand-gold font-mono pt-1"><?= \App\Core\Helper::formatPrice($priceDefault ?? 2500000) ?></span>
                        </div>
                    </label>

                    <label class="p-4 rounded-2xl border cursor-pointer transition-all bg-brand-darker border-brand-border hover:border-brand-gold" id="label-custom">
                        <input type="radio" name="card_type" value="custom_design" onchange="toggleOrderCardType(this.value)" class="sr-only">
                        <div class="space-y-1.5">
                            <span class="block text-xs font-bold text-white">طرح اختصاصی سازمانی</span>
                            <span class="block text-[11px] text-gray-400">چاپ دو رو با لوگو، رنگ و هویت بصری سازمان شما</span>
                            <span class="inline-block text-xs font-extrabold text-brand-gold font-mono pt-1"><?= \App\Core\Helper::formatPrice($priceCustom ?? 5000000) ?></span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Custom Design Upload (Shown if custom_design selected) -->
            <div id="custom-design-box" class="hidden p-4 rounded-2xl bg-brand-darker border border-brand-gold/30 space-y-2">
                <label class="block text-xs font-bold text-brand-gold">فایل لوگو یا طراحی اختصاصی کارت (اختیاری):</label>
                <input type="file" name="design_file" accept=".jpg,.jpeg,.png,.webp,.pdf,.zip,.rar,.psd,.ai" class="text-xs text-gray-400 file:mr-4 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-gold file:text-black hover:file:brightness-110 cursor-pointer w-full">
                <p class="text-[10px] text-gray-400">می‌توانید فایل را اکنون آپلود کنید یا پس از پرداخت در پنل ارسال فرمایید.</p>
            </div>

            <!-- Shipping Information -->
            <div class="space-y-3">
                <label class="block text-xs font-bold text-gray-300">اطلاعات ارسال پستی (پست پیشتاز رایگان):</label>
                
                <div>
                    <input type="text" name="shipping_address" placeholder="نشانی دقیق پستی (استان، شهر، خیابان، پلاک، واحد)" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <input type="text" name="postal_code" dir="ltr" maxlength="10" placeholder="کد پستی ۱۰ رقمی" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none text-left font-mono">
                    <input type="text" name="custom_design_notes" placeholder="نام فرد یا پرسنل روی کارت (اختیاری)" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-brand-gold focus:outline-none">
                </div>
            </div>

            <!-- Price Summary & Submit -->
            <div class="pt-4 border-t border-brand-border/60 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <span class="text-xs text-gray-400 block">مبلغ نهایی قابل پرداخت:</span>
                    <span id="order-price-display" class="text-base font-extrabold text-brand-gold font-mono"><?= \App\Core\Helper::formatPrice($priceDefault ?? 2500000) ?></span>
                </div>
                <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-gradient-to-r from-brand-goldDark via-brand-gold to-brand-goldLight text-black font-extrabold text-xs shadow-xl shadow-brand-gold/20 hover:brightness-110 transition-all flex items-center justify-center gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    <span>تایید و پرداخت آنلاین</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openNewOrderModal() {
    var m = document.getElementById('newOrderModal');
    if (m) m.classList.remove('hidden');
    if (window.lucide) lucide.createIcons();
}
function closeNewOrderModal() {
    var m = document.getElementById('newOrderModal');
    if (m) m.classList.add('hidden');
}
function toggleOrderCardType(type) {
    var box = document.getElementById('custom-design-box');
    var priceDisp = document.getElementById('order-price-display');
    var lDef = document.getElementById('label-default');
    var lCust = document.getElementById('label-custom');

    var pDef = '<?= \App\Core\Helper::formatPrice($priceDefault ?? 2500000) ?>';
    var pCust = '<?= \App\Core\Helper::formatPrice($priceCustom ?? 5000000) ?>';

    if (type === 'custom_design') {
        if (box) box.classList.remove('hidden');
        if (priceDisp) priceDisp.innerText = pCust;
        if (lCust) { lCust.classList.add('border-brand-gold', 'bg-brand-gold/10'); }
        if (lDef) { lDef.classList.remove('border-brand-gold', 'bg-brand-gold/10'); }
    } else {
        if (box) box.classList.add('hidden');
        if (priceDisp) priceDisp.innerText = pDef;
        if (lDef) { lDef.classList.add('border-brand-gold', 'bg-brand-gold/10'); }
        if (lCust) { lCust.classList.remove('border-brand-gold', 'bg-brand-gold/10'); }
    }
}
</script>
