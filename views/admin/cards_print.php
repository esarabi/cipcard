<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \App\Core\Helper::e($title) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background-color: #f1f5f9;
            color: #0f172a;
        }
        @media print {
            body {
                background-color: #ffffff !important;
                color: #000000 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-page {
                page-break-after: always;
                margin: 0 !important;
                padding: 10mm !important;
                box-shadow: none !important;
                border: none !important;
            }
            .card-grid-item {
                break-inside: avoid;
            }
        }
        .cut-guide {
            border: 1px dashed #94a3b8;
        }
    </style>
</head>
<body class="p-4 sm:p-8">

    <!-- Top Toolbar (Hidden on Print) -->
    <div class="no-print max-w-5xl mx-auto mb-6 p-4 rounded-2xl bg-white border border-slate-200 shadow-md flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-base font-black text-slate-900">شیت آماده چاپ بارکدهای QR</h1>
            <p class="text-xs text-slate-500">
                <?= !empty($batchName) ? 'دسته: ' . \App\Core\Helper::e($batchName) : 'تمام کارت‌های فیلتر شده' ?>
                (مجموع: <?= count($cards) ?> کارت)
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold text-xs shadow-md transition-all flex items-center gap-2">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>پرینت یا ذخیره PDF (Ctrl + P)</span>
            </button>
            <a href="<?= \App\Core\Helper::url('admin/cards') ?>" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all">
                بازگشت به پنل
            </a>
        </div>
    </div>

    <!-- Printable Sheet (A4 Dimensions / Clean Grid) -->
    <div class="max-w-5xl mx-auto bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xl print-page">
        
        <!-- Sheet Header -->
        <div class="flex items-center justify-between border-b border-slate-200 pb-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-amber-500 text-slate-950 font-black flex items-center justify-center text-xs">
                    CIP
                </div>
                <div>
                    <span class="text-sm font-black text-slate-900">CIPCard.ir - برگه بارکدهای QR اختصاصی کارت هوشمند</span>
                    <span class="block text-[10px] text-slate-400 font-mono">Industrial NFC Smart Card Production Sheet</span>
                </div>
            </div>
            <div class="text-left font-mono text-xs text-slate-500">
                <span>تعداد: <?= count($cards) ?></span> | 
                <span><?= date('Y-m-d H:i') ?></span>
            </div>
        </div>

        <!-- Grid of QR Codes -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            <?php foreach ($cards as $c): ?>
                <?php
                $scanUrl = \App\Core\Helper::url('c/' . $c['card_code']);
                $qrDataUri = \App\Services\QrCodeService::getDataUri($scanUrl, 260);
                ?>
                <div class="card-grid-item cut-guide p-3.5 rounded-xl text-center space-y-2 bg-white flex flex-col items-center justify-between relative">
                    <!-- Brand Micro Badge -->
                    <div class="flex items-center justify-between w-full text-[9px] text-slate-400 font-bold px-1">
                        <span class="font-mono text-amber-600 font-black">CIPCard</span>
                        <span class="font-mono"><?= $c['id'] ?></span>
                    </div>

                    <!-- QR Image -->
                    <div class="w-32 h-32 p-1 bg-white flex items-center justify-center">
                        <img src="<?= $qrDataUri ?>" alt="QR" class="w-full h-full object-contain">
                    </div>

                    <!-- Code & URL -->
                    <div class="space-y-0.5 w-full">
                        <div class="font-mono font-black text-slate-900 text-xs tracking-wider border-t border-slate-100 pt-1">
                            <?= \App\Core\Helper::e($c['card_code']) ?>
                        </div>
                        <div class="text-[9px] text-slate-400 font-mono truncate dir-ltr">
                            cipcard.ir/c/<?= \App\Core\Helper::e($c['card_code']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <script>
        if (window.lucide) lucide.createIcons();
    </script>
</body>
</html>
