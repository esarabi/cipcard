<div class="space-y-8">

    <!-- Header & Action Buttons -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-brand-border/40">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-500 border border-amber-500/30 flex items-center justify-center">
                    <i data-lucide="qr-code" class="w-5 h-5"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-white">مدیریت کارت‌ها و QR Code</h1>
                    <p class="text-xs text-gray-400 mt-0.5">تولید انبوه، چاپ بر روی کارت فیزیکی، خروجی‌های صنعتی و اتصال به پروفایل مشتریان</p>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <!-- Bulk Generate Button -->
            <button type="button" onclick="openBulkModal()" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-300 text-slate-950 font-extrabold text-xs shadow-md shadow-amber-500/20 hover:brightness-105 active:scale-95 transition-all flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>تولید انبوه QR Code</span>
            </button>

            <!-- Export ZIP Button -->
            <a href="<?= \App\Core\Helper::url('admin/cards/export/zip?' . http_build_query($filters)) ?>" class="px-3.5 py-2.5 rounded-xl bg-brand-surfaceHover border border-brand-border text-gray-300 hover:text-white hover:border-amber-400/50 text-xs font-semibold transition-all flex items-center gap-1.5" title="دانلود کلیه تصاویر QR با کیفیت بالا در فایل زیپ">
                <i data-lucide="archive" class="w-4 h-4 text-amber-400"></i>
                <span>دانلود ZIP تصاویر</span>
            </a>

            <!-- Print Grid View -->
            <a href="<?= \App\Core\Helper::url('admin/cards/print?' . http_build_query($filters)) ?>" target="_blank" class="px-3.5 py-2.5 rounded-xl bg-brand-surfaceHover border border-brand-border text-gray-300 hover:text-white hover:border-amber-400/50 text-xs font-semibold transition-all flex items-center gap-1.5" title="صفحه استاندارد چاپ شیت کارت‌ها (A4)">
                <i data-lucide="printer" class="w-4 h-4 text-emerald-400"></i>
                <span>نسخه چاپی شیت</span>
            </a>

            <!-- Export CSV -->
            <a href="<?= \App\Core\Helper::url('admin/cards/export/csv?' . http_build_query($filters)) ?>" class="px-3.5 py-2.5 rounded-xl bg-brand-surfaceHover border border-brand-border text-gray-300 hover:text-white hover:border-amber-400/50 text-xs font-semibold transition-all flex items-center gap-1.5" title="خروجی فایل اکسل">
                <i data-lucide="file-spreadsheet" class="w-4 h-4 text-blue-400"></i>
                <span>خروجی اکسل</span>
            </a>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total -->
        <div class="p-5 rounded-2xl bg-brand-surface border border-brand-border/60 space-y-2">
            <div class="flex items-center justify-between text-xs text-gray-400">
                <span>کل کارت‌های سامانه</span>
                <i data-lucide="credit-card" class="w-4 h-4 text-amber-400"></i>
            </div>
            <div class="text-2xl font-black text-white font-mono"><?= number_format($stats['total']) ?></div>
            <div class="text-[11px] text-gray-500">تولید شده در کلیه دسته‌ها</div>
        </div>

        <!-- Unassigned (Ready for Print / Blank) -->
        <div class="p-5 rounded-2xl bg-brand-surface border border-amber-500/30 bg-amber-500/5 space-y-2">
            <div class="flex items-center justify-between text-xs text-amber-400">
                <span class="font-bold">کارت‌های خام (آماده چاپ / انتساب)</span>
                <i data-lucide="sparkles" class="w-4 h-4 text-amber-400"></i>
            </div>
            <div class="text-2xl font-black text-amber-400 font-mono"><?= number_format($stats['unassigned']) ?></div>
            <div class="text-[11px] text-amber-600 dark:text-amber-300">در انتظار اتصال به مشتری</div>
        </div>

        <!-- Assigned -->
        <div class="p-5 rounded-2xl bg-brand-surface border border-emerald-500/30 bg-emerald-500/5 space-y-2">
            <div class="flex items-center justify-between text-xs text-emerald-400">
                <span class="font-bold">کارت‌های متصل و فعال</span>
                <i data-lucide="user-check" class="w-4 h-4 text-emerald-400"></i>
            </div>
            <div class="text-2xl font-black text-emerald-400 font-mono"><?= number_format($stats['assigned']) ?></div>
            <div class="text-[11px] text-emerald-600 dark:text-emerald-300">متصل به پروفایل کاربران</div>
        </div>

        <!-- Total Scans -->
        <div class="p-5 rounded-2xl bg-brand-surface border border-brand-border/60 space-y-2">
            <div class="flex items-center justify-between text-xs text-gray-400">
                <span>مجموع دفعات اسکن QR</span>
                <i data-lucide="scan" class="w-4 h-4 text-blue-400"></i>
            </div>
            <div class="text-2xl font-black text-white font-mono"><?= number_format($stats['total_scans']) ?></div>
            <div class="text-[11px] text-gray-500">اسکن فیزیکی توسط مخاطبان</div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="p-5 rounded-2xl bg-brand-surface border border-brand-border/60">
        <form action="<?= \App\Core\Helper::url('admin/cards') ?>" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
            
            <!-- Search Text -->
            <div class="sm:col-span-4">
                <label class="block text-xs font-bold text-gray-400 mb-1.5">جستجو در کارت‌ها</label>
                <div class="relative">
                    <input type="text" name="q" value="<?= \App\Core\Helper::e($filters['search']) ?>" placeholder="کد کارت (مثلاً CIP-XXXX)، نام یا موبایل کاربر..." class="w-full pl-10 pr-3.5 py-2.5 rounded-xl bg-brand-darker border border-brand-border text-white text-xs placeholder:text-gray-500 focus:border-amber-400 focus:outline-none">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="sm:col-span-3">
                <label class="block text-xs font-bold text-gray-400 mb-1.5">وضعیت کارت</label>
                <select name="status" class="w-full px-3.5 py-2.5 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-amber-400 focus:outline-none">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="unassigned" <?= $filters['status'] === 'unassigned' ? 'selected' : '' ?>>کارت‌های خام (تخصیص‌نیافته)</option>
                    <option value="assigned" <?= $filters['status'] === 'assigned' ? 'selected' : '' ?>>متصل به پروفایل کاربر</option>
                    <option value="blocked" <?= $filters['status'] === 'blocked' ? 'selected' : '' ?>>مسدود شده</option>
                </select>
            </div>

            <!-- Batch Filter -->
            <div class="sm:col-span-3">
                <label class="block text-xs font-bold text-gray-400 mb-1.5">دسته چاپ (Batch)</label>
                <select name="batch_name" class="w-full px-3.5 py-2.5 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-amber-400 focus:outline-none">
                    <option value="">همه دسته‌ها</option>
                    <?php foreach ($batches as $b): ?>
                        <option value="<?= \App\Core\Helper::e($b['batch_name']) ?>" <?= $filters['batch_name'] === $b['batch_name'] ? 'selected' : '' ?>>
                            <?= \App\Core\Helper::e($b['batch_name']) ?> (<?= $b['total_count'] ?> کارت)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs transition-all flex items-center justify-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    <span>اعمال</span>
                </button>
                <?php if (!empty($filters['status']) || !empty($filters['batch_name']) || !empty($filters['search'])): ?>
                    <a href="<?= \App\Core\Helper::url('admin/cards') ?>" class="p-2.5 rounded-xl bg-brand-surfaceHover border border-brand-border text-gray-400 hover:text-white text-xs transition-all" title="حذف فیلترها">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    </a>
                <?php endif; ?>
            </div>

        </form>
    </div>

    <!-- Cards Data Table -->
    <div class="rounded-3xl bg-brand-surface border border-brand-border/60 overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead>
                    <tr class="border-b border-brand-border/40 text-gray-400 bg-brand-darker/60 font-bold">
                        <th class="p-4 w-16 text-center">بارکد</th>
                        <th class="p-4">کد کارت و آدرس اسکن</th>
                        <th class="p-4">دسته چاپ (Batch)</th>
                        <th class="p-4">وضعیت</th>
                        <th class="p-4">کاربر / پروفایل متصل</th>
                        <th class="p-4 text-center">دفعات اسکن</th>
                        <th class="p-4">تاریخ تولید</th>
                        <th class="p-4 text-center w-36">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-border/30">
                    <?php if (empty($cards)): ?>
                        <tr>
                            <td colspan="8" class="p-10 text-center text-gray-400">
                                <div class="max-w-xs mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-500 border border-amber-500/30 flex items-center justify-center mx-auto">
                                        <i data-lucide="inbox" class="w-6 h-6"></i>
                                    </div>
                                    <p class="font-bold text-white text-sm">هیچ کارت یا کدی یافت نشد</p>
                                    <p class="text-[11px] text-gray-500">جهت شروع می‌توانید با دکمه «تولید انبوه QR Code» کارت‌های جدید تولید کنید.</p>
                                    <button type="button" onclick="openBulkModal()" class="px-4 py-2 rounded-xl bg-amber-500 text-slate-950 font-bold text-xs">
                                        تولید اولین دسته کارت‌ها
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($cards as $c): ?>
                            <?php
                            $scanUrl = \App\Core\Helper::url('c/' . $c['card_code']);
                            $qrDataUri = \App\Services\QrCodeService::getDataUri($scanUrl, 160);
                            ?>
                            <tr class="hover:bg-brand-surfaceHover/50 transition-colors">
                                <!-- QR Thumbnail -->
                                <td class="p-4 text-center">
                                    <a href="<?= $scanUrl ?>" target="_blank" class="inline-block p-1 bg-white rounded-lg border border-slate-200 hover:scale-110 transition-transform shadow-sm" title="پیش‌نمایش اسکن">
                                        <img src="<?= $qrDataUri ?>" alt="QR" class="w-9 h-9 object-contain">
                                    </a>
                                </td>

                                <!-- Card Code & Scan URL -->
                                <td class="p-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-1.5">
                                            <span class="font-mono font-black text-amber-400 tracking-wider text-sm"><?= \App\Core\Helper::e($c['card_code']) ?></span>
                                            <button type="button" onclick="copyText('<?= $c['card_code'] ?>')" class="text-gray-400 hover:text-white p-1 rounded" title="کپی کد">
                                                <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </div>
                                        <a href="<?= $scanUrl ?>" target="_blank" class="font-mono text-[11px] text-gray-500 hover:text-amber-400 flex items-center gap-1 dir-ltr text-right">
                                            <i data-lucide="external-link" class="w-3 h-3 shrink-0"></i>
                                            <span class="truncate max-w-[200px]"><?= $scanUrl ?></span>
                                        </a>
                                    </div>
                                </td>

                                <!-- Batch Name -->
                                <td class="p-4 text-gray-300">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-brand-darker border border-brand-border/60 text-[11px]">
                                        <i data-lucide="layers" class="w-3 h-3 text-amber-500"></i>
                                        <span><?= \App\Core\Helper::e($c['batch_name'] ?: 'بدون دسته') ?></span>
                                    </span>
                                </td>

                                <!-- Status Badge -->
                                <td class="p-4">
                                    <?php if ($c['status'] === 'assigned'): ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                            <span>متصل به کاربر</span>
                                        </span>
                                    <?php elseif ($c['status'] === 'blocked'): ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-500/10 text-red-400 border border-red-500/30 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                            <span>مسدود شده</span>
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-500/15 text-amber-400 border border-amber-500/30 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                            <span>خام (آماده انتساب)</span>
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <!-- Assigned User -->
                                <td class="p-4">
                                    <?php if (!empty($c['user_id'])): ?>
                                        <div class="space-y-0.5">
                                            <div class="font-bold text-white flex items-center gap-1.5">
                                                <i data-lucide="user" class="w-3.5 h-3.5 text-amber-400"></i>
                                                <a href="<?= \App\Core\Helper::url('admin/users/edit/' . $c['user_id']) ?>" class="hover:underline">
                                                    <?= \App\Core\Helper::e($c['user_full_name'] ?: 'کاربر شماره ' . $c['user_id']) ?>
                                                </a>
                                            </div>
                                            <div class="text-[11px] font-mono text-gray-400 dir-ltr text-right">
                                                <?= \App\Core\Helper::e($c['user_mobile']) ?>
                                            </div>
                                            <?php if (!empty($c['profile_slug'])): ?>
                                                <a href="<?= \App\Core\Helper::url('@' . $c['profile_slug']) ?>" target="_blank" class="text-[10px] text-amber-500 hover:underline block font-mono">
                                                    @<?= \App\Core\Helper::e($c['profile_slug']) ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-gray-500 italic text-[11px]">— تخصیص داده نشده —</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Scan Count -->
                                <td class="p-4 text-center font-mono font-bold text-white">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-brand-darker border border-brand-border">
                                        <i data-lucide="eye" class="w-3 h-3 text-gray-400"></i>
                                        <span><?= number_format((int)$c['scan_count']) ?></span>
                                    </span>
                                </td>

                                <!-- Created At -->
                                <td class="p-4 text-gray-400 font-mono text-[11px]">
                                    <?= \App\Core\Helper::e($c['created_at']) ?>
                                </td>

                                <!-- Actions -->
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <?php if ($c['status'] === 'unassigned'): ?>
                                            <button type="button" onclick="openAssignModal(<?= (int)$c['id'] ?>, '<?= \App\Core\Helper::e($c['card_code']) ?>')" class="px-2.5 py-1.5 rounded-lg bg-emerald-500/15 text-emerald-400 hover:bg-emerald-500 hover:text-black border border-emerald-500/30 transition-all text-[11px] font-bold flex items-center gap-1" title="اتصال این کارت به کاربر">
                                                <i data-lucide="link" class="w-3.5 h-3.5"></i>
                                                <span>اتصال</span>
                                            </button>

                                            <!-- Delete Card -->
                                            <form action="<?= \App\Core\Helper::url('admin/cards/delete') ?>" method="POST" onsubmit="return confirm('آیا از حذف این کارت خام اطمینان دارید؟');" class="inline">
                                                <?= \App\Core\Csrf::field() ?>
                                                <input type="hidden" name="card_id" value="<?= $c['id'] ?>">
                                                <button type="submit" class="p-1.5 rounded-lg bg-brand-darker hover:bg-red-500/20 text-gray-400 hover:text-red-400 border border-brand-border transition-all" title="حذف کارت">
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <!-- Change User / Unbind -->
                                            <button type="button" onclick="openAssignModal(<?= (int)$c['id'] ?>, '<?= \App\Core\Helper::e($c['card_code']) ?>', <?= (int)$c['user_id'] ?>)" class="p-1.5 rounded-lg bg-brand-darker hover:bg-blue-500/20 text-gray-400 hover:text-blue-400 border border-brand-border transition-all" title="تغییر کاربر متصل">
                                                <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                                            </button>

                                            <form action="<?= \App\Core\Helper::url('admin/cards/unbind') ?>" method="POST" onsubmit="return confirm('آیا اتصال این کارت به کاربر برداشته شود؟');" class="inline">
                                                <?= \App\Core\Csrf::field() ?>
                                                <input type="hidden" name="card_id" value="<?= $c['id'] ?>">
                                                <button type="submit" class="p-1.5 rounded-lg bg-brand-darker hover:bg-amber-500/20 text-gray-400 hover:text-amber-400 border border-brand-border transition-all" title="قطع اتصال (تبدیل به خام)">
                                                    <i data-lucide="unlink" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="p-4 border-t border-brand-border/40 flex items-center justify-between text-xs text-gray-400">
                <div>
                    نمایش صفحه <span class="font-bold text-white"><?= $currentPage ?></span> از <span class="font-bold text-white"><?= $totalPages ?></span> (کل کارت‌ها: <?= number_format($totalCards) ?>)
                </div>
                <div class="flex items-center gap-1">
                    <?php if ($currentPage > 1): ?>
                        <a href="<?= \App\Core\Helper::url('admin/cards?' . http_build_query(array_merge($filters, ['page' => $currentPage - 1]))) ?>" class="px-3 py-1.5 rounded-lg bg-brand-darker border border-brand-border text-gray-300 hover:text-white">قبلی</a>
                    <?php endif; ?>
                    <?php if ($currentPage < $totalPages): ?>
                        <a href="<?= \App\Core\Helper::url('admin/cards?' . http_build_query(array_merge($filters, ['page' => $currentPage + 1]))) ?>" class="px-3 py-1.5 rounded-lg bg-brand-darker border border-brand-border text-gray-300 hover:text-white">بعدی</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- ==================== MODAL 1: BULK GENERATE ==================== -->
<div id="modal-bulk" class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-brand-surface border border-brand-border rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-2xl relative animate-in fade-in zoom-in-95 duration-150">
        <div class="flex items-center justify-between border-b border-brand-border/40 pb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-500 border border-amber-500/30 flex items-center justify-center">
                    <i data-lucide="layers" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white">تولید انبوه کارت و QR Code</h3>
                    <p class="text-xs text-gray-400">ایجاد کدهای یکتا جهت چاپ انبوه روی کارت‌های فیزیکی NFC</p>
                </div>
            </div>
            <button type="button" onclick="closeBulkModal()" class="text-gray-400 hover:text-white p-1 rounded-lg">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="<?= \App\Core\Helper::url('admin/cards/bulk-generate') ?>" method="POST" class="space-y-4">
            <?= \App\Core\Csrf::field() ?>

            <!-- Quantity -->
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1.5">تعداد کارت جهت تولید *</label>
                <div class="grid grid-cols-5 gap-2 mb-2">
                    <button type="button" onclick="setCount(10)" class="py-1.5 rounded-lg bg-brand-darker border border-brand-border hover:border-amber-400 text-xs font-mono font-bold text-gray-300 hover:text-amber-400">10</button>
                    <button type="button" onclick="setCount(50)" class="py-1.5 rounded-lg bg-brand-darker border border-brand-border hover:border-amber-400 text-xs font-mono font-bold text-gray-300 hover:text-amber-400">50</button>
                    <button type="button" onclick="setCount(100)" class="py-1.5 rounded-lg bg-brand-darker border border-brand-border hover:border-amber-400 text-xs font-mono font-bold text-gray-300 hover:text-amber-400">100</button>
                    <button type="button" onclick="setCount(250)" class="py-1.5 rounded-lg bg-brand-darker border border-brand-border hover:border-amber-400 text-xs font-mono font-bold text-gray-300 hover:text-amber-400">250</button>
                    <button type="button" onclick="setCount(500)" class="py-1.5 rounded-lg bg-brand-darker border border-brand-border hover:border-amber-400 text-xs font-mono font-bold text-gray-300 hover:text-amber-400">500</button>
                </div>
                <input type="number" name="count" id="bulk-count-input" required min="1" max="1000" value="50" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-sm font-mono focus:border-amber-400 focus:outline-none">
                <span class="text-[11px] text-gray-400 mt-1 block">حداقل ۱ و حداکثر ۱۰۰۰ کارت در هر بار تولید.</span>
            </div>

            <!-- Batch Name -->
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1.5">نام دسته چاپ (Batch Name) *</label>
                <input type="text" name="batch_name" required value="چاپ سری <?= date('Y-m-d') ?>" placeholder="مثلاً: سری ۱ متالیک مشکی مات" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-amber-400 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <!-- Prefix -->
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">پیش‌وند کد</label>
                    <input type="text" name="prefix" value="CIP-" placeholder="CIP-" dir="ltr" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs font-mono text-left focus:border-amber-400 focus:outline-none">
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">یادداشت چاپخانه / متریال</label>
                    <input type="text" name="notes" placeholder="مثلاً استیل طلایی، مشکی مات" class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-amber-400 focus:outline-none">
                </div>
            </div>

            <div class="p-3.5 rounded-2xl bg-black/40 border border-brand-border/60 text-[11px] text-gray-400 leading-relaxed space-y-1">
                <div class="flex items-center gap-1.5 font-bold text-amber-400">
                    <i data-lucide="info" class="w-3.5 h-3.5"></i>
                    <span>نحوه عملکرد پس از تولید:</span>
                </div>
                <p>کارت‌های تولید شده در وضعیت «خام» ذخیره می‌شوند و بارکدهای QR آن‌ها بلافاصله آماده چاپ روی متریال کارت‌های فیزیکی هستند. سپس می‌توانید در هر زمان هر کارت را به کاربر یا پروفایل مشخص متصل نمایید.</p>
            </div>

            <div class="pt-2 flex items-center justify-end gap-2">
                <button type="button" onclick="closeBulkModal()" class="px-5 py-3 rounded-xl bg-brand-surfaceHover border border-brand-border text-gray-400 hover:text-white text-xs font-bold">
                    انصراف
                </button>
                <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-amber-500 to-amber-400 text-slate-950 font-extrabold text-xs shadow-lg shadow-amber-500/25 hover:brightness-105 active:scale-95 transition-all flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>شروع تولید کارت‌ها</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==================== MODAL 2: ASSIGN CARD TO USER ==================== -->
<div id="modal-assign" class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-brand-surface border border-brand-border rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-5 shadow-2xl relative animate-in fade-in zoom-in-95 duration-150">
        <div class="flex items-center justify-between border-b border-brand-border/40 pb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 flex items-center justify-center">
                    <i data-lucide="link" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white">اتصال کارت به کاربر</h3>
                    <p class="text-xs text-gray-400">انتساب کد QR فیزیکی به پروفایل هوشمند</p>
                </div>
            </div>
            <button type="button" onclick="closeAssignModal()" class="text-gray-400 hover:text-white p-1 rounded-lg">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="<?= \App\Core\Helper::url('admin/cards/assign') ?>" method="POST" class="space-y-4">
            <?= \App\Core\Csrf::field() ?>
            <input type="hidden" name="card_id" id="assign-card-id" value="">

            <div class="p-3 rounded-xl bg-brand-darker border border-brand-border text-xs flex items-center justify-between">
                <span class="text-gray-400">کارت انتخاب شده:</span>
                <span id="assign-card-code-text" class="font-mono font-black text-amber-400 text-sm"></span>
            </div>

            <div>
                <label for="assign-user-select" class="block text-xs font-bold text-gray-300 mb-1.5">انتخاب کاربر مقصد *</label>
                <select name="user_id" id="assign-user-select" required class="w-full px-4 py-3 rounded-xl bg-brand-darker border border-brand-border text-white text-xs focus:border-amber-400 focus:outline-none">
                    <option value="">-- لطفاً کاربر را انتخاب کنید --</option>
                    <?php foreach ($users as $u): ?>
                        <option value="<?= $u['id'] ?>">
                            <?= \App\Core\Helper::e($u['full_name']) ?> (<?= \App\Core\Helper::e($u['mobile']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="text-[11px] text-gray-500 mt-1 block">پس از اتصال، با اسکن این کارت مستقیماً پروفایل شخص باز می‌شود.</span>
            </div>

            <div class="pt-2 flex items-center justify-end gap-2">
                <button type="button" onclick="closeAssignModal()" class="px-5 py-3 rounded-xl bg-brand-surfaceHover border border-brand-border text-gray-400 hover:text-white text-xs font-bold">
                    انصراف
                </button>
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-500 text-slate-950 font-extrabold text-xs shadow-lg shadow-emerald-500/25 hover:brightness-105 active:scale-95 transition-all flex items-center gap-1.5">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>تایید و اتصال کارت</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openBulkModal() {
    document.getElementById('modal-bulk').classList.remove('hidden');
    if (window.lucide) lucide.createIcons();
}
function closeBulkModal() {
    document.getElementById('modal-bulk').classList.add('hidden');
}
function setCount(val) {
    document.getElementById('bulk-count-input').value = val;
}

function openAssignModal(cardId, cardCode, currentUserId) {
    document.getElementById('assign-card-id').value = cardId;
    document.getElementById('assign-card-code-text').innerText = cardCode;
    var userSelect = document.getElementById('assign-user-select');
    if (currentUserId && userSelect) {
        userSelect.value = currentUserId;
    }
    document.getElementById('modal-assign').classList.remove('hidden');
    if (window.lucide) lucide.createIcons();
}
function closeAssignModal() {
    document.getElementById('modal-assign').classList.add('hidden');
}

function copyText(str) {
    navigator.clipboard.writeText(str).then(function() {
        alert('کد کارت ' + str + ' در کلیپ‌بورد کپی شد.');
    });
}
</script>
