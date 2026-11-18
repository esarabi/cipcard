<?php
declare(strict_types=1);

namespace App\Services;

class TranslationService
{
    public const SUPPORTED_LANGUAGES = [
        'fa' => ['name' => 'فارسی',   'dir' => 'rtl', 'flag' => '🇮🇷'],
        'en' => ['name' => 'English', 'dir' => 'ltr', 'flag' => '🇬🇧'],
        'ar' => ['name' => 'العربية', 'dir' => 'rtl', 'flag' => '🇦🇪'],
        'tr' => ['name' => 'Türkçe',  'dir' => 'ltr', 'flag' => '🇹🇷'],
        'ru' => ['name' => 'Русский', 'dir' => 'ltr', 'flag' => '🇷🇺'],
        'zh' => ['name' => '中文',    'dir' => 'ltr', 'flag' => '🇨🇳'],
    ];

    public const TRANSLATIONS = [
        'save_contact' => [
            'fa' => 'ذخیره در مخاطبین',
            'en' => 'Save Contact',
            'ar' => 'حفظ في جهات الاتصال',
            'tr' => 'Rehbere Kaydet',
            'ru' => 'Сохранить контакт',
            'zh' => '保存联系人'
        ],
        'call_mobile' => [
            'fa' => 'تماس همراه',
            'en' => 'Call Mobile',
            'ar' => 'اتصال بالجوال',
            'tr' => 'Mobil Ara',
            'ru' => 'Позвонить',
            'zh' => '拨打手机'
        ],
        'call_work' => [
            'fa' => 'تلفن محل کار',
            'en' => 'Work Phone',
            'ar' => 'هاتف العمل',
            'tr' => 'İş Telefonu',
            'ru' => 'Рабочий телефон',
            'zh' => '办公电话'
        ],
        'send_sms' => [
            'fa' => 'ارسال پیامک',
            'en' => 'Send SMS',
            'ar' => 'إرسال رسالة',
            'tr' => 'SMS Gönder',
            'ru' => 'Отправить SMS',
            'zh' => '发送短信'
        ],
        'email' => [
            'fa' => 'ارسال ایمیل',
            'en' => 'Send Email',
            'ar' => 'إرسال بريد إلكتروني',
            'tr' => 'E-posta Gönder',
            'ru' => 'Эл. почта',
            'zh' => '发送邮件'
        ],
        'website' => [
            'fa' => 'وب‌سایت رسمی',
            'en' => 'Official Website',
            'ar' => 'الموقع الرسمي',
            'tr' => 'Resmî Web Sitesi',
            'ru' => 'Официальный сайт',
            'zh' => '官方网站'
        ],
        'address' => [
            'fa' => 'نشانی و آدرس',
            'en' => 'Address & Office',
            'ar' => 'العنوان والمقر',
            'tr' => 'Adres ve Ofis',
            'ru' => 'Адрес офиса',
            'zh' => '办公地址'
        ],
        'about' => [
            'fa' => 'درباره ما / بیوگرافی',
            'en' => 'About / Biography',
            'ar' => 'نبذة تعريفية',
            'tr' => 'Hakkında / Biyografi',
            'ru' => 'О компании / Биография',
            'zh' => '关于我们 / 个人简介'
        ],
        'social_networks' => [
            'fa' => 'شبکه‌های اجتماعی و پیام‌رسان‌ها',
            'en' => 'Social Networks & Messengers',
            'ar' => 'شبكات التواصل والمراسلة',
            'tr' => 'Sosyal Medya ve Mesajlaşma',
            'ru' => 'Социальные сети и мессенджеры',
            'zh' => '社交平台与即时通讯'
        ],
        'working_hours' => [
            'fa' => 'روزها و ساعات پاسخگویی',
            'en' => 'Working Days & Hours',
            'ar' => 'ساعات العمل والتواصل',
            'tr' => 'Çalışma Günleri ve Saatleri',
            'ru' => 'Дни и часы работы',
            'zh' => '工作日与服务时间'
        ],
        'working_days_label' => [
            'fa' => 'روزهای کاری',
            'en' => 'Working Days',
            'ar' => 'أيام العمل',
            'tr' => 'Çalışma Günleri',
            'ru' => 'Рабочие дни',
            'zh' => '工作日'
        ],
        'working_hours_label' => [
            'fa' => 'ساعات کاری',
            'en' => 'Hours',
            'ar' => 'ساعات العمل',
            'tr' => 'Saatler',
            'ru' => 'Время',
            'zh' => '工作时间'
        ],
        'open_badge' => [
            'fa' => 'پاسخگوی شما هستیم',
            'en' => 'Open for Inquiries',
            'ar' => 'متاحون للتواصل',
            'tr' => 'Şu An Açık',
            'ru' => 'Открыто для обращений',
            'zh' => '在线营业中'
        ],
        'location_navigation' => [
            'fa' => 'موقعیت روی نقشه و مسیریابی',
            'en' => 'Location & Navigation',
            'ar' => 'الموقع والملاحة الذكية',
            'tr' => 'Konum ve Akıllı Yol Tarifi',
            'ru' => 'Локация и навигация',
            'zh' => '地理位置与路线导航'
        ],
        'nav_neshan' => [
            'fa' => 'نشان',
            'en' => 'Neshan Map',
            'ar' => 'نشان',
            'tr' => 'Neshan',
            'ru' => 'Нешан',
            'zh' => 'Neshan 导航'
        ],
        'nav_balad' => [
            'fa' => 'بلد',
            'en' => 'Balad Map',
            'ar' => 'بلد',
            'tr' => 'Balad',
            'ru' => 'Балад',
            'zh' => 'Balad 导航'
        ],
        'nav_google' => [
            'fa' => 'گوگل مپس',
            'en' => 'Google Maps',
            'ar' => 'خرائط جوجل',
            'tr' => 'Google Haritalar',
            'ru' => 'Google Карты',
            'zh' => '谷歌地图'
        ],
        'share_card' => [
            'fa' => 'اشتراک‌گذاری کارت',
            'en' => 'Share Card',
            'ar' => 'مشاركة البطاقة',
            'tr' => 'Kartı Paylaş',
            'ru' => 'Поделиться визиткой',
            'zh' => '分享名片'
        ],
        'scan_qr' => [
            'fa' => 'اسکن کد QR',
            'en' => 'Scan QR Code',
            'ar' => 'رمز QR',
            'tr' => 'QR Kodu Tara',
            'ru' => 'QR-код',
            'zh' => '扫描二维码'
        ],
        'flip_card' => [
            'fa' => 'لمس کارت جهت چرخش سه‌بعدی',
            'en' => 'Tap card for 3D flip',
            'ar' => 'انقر لقلب البطاقة ثلاثية الأبعاد',
            'tr' => '3D döndürmek için dokunun',
            'ru' => 'Нажмите для 3D вращения',
            'zh' => '点击卡片3D翻转'
        ],
        'card_title' => [
            'fa' => 'کارت ویزیت هوشمند لوکس',
            'en' => 'Luxury Smart Business Card',
            'ar' => 'بطاقة أعمال ذكية فاخرة',
            'tr' => 'Lüks Akıllı Kartvizit',
            'ru' => 'Премиальная смарт-визитка',
            'zh' => '尊贵智能商务名片'
        ],
        'featured_image' => [
            'fa' => 'تصویر معرفی و نمونه‌کار',
            'en' => 'Featured Showcase',
            'ar' => 'صورة العرض والتعريف',
            'tr' => 'Öne Çıkan Görsel',
            'ru' => 'Избранное фото / Презентация',
            'zh' => '精选展示图片'
        ],
        'order_your_card' => [
            'fa' => 'سفارش کارت هوشمند CIPCard',
            'en' => 'Order Your CIPCard',
            'ar' => 'طلب بطاقتك الذكية CIPCard',
            'tr' => 'CIPCard Sipariş Edin',
            'ru' => 'Заказать карту CIPCard',
            'zh' => '订购 CIPCard 专属智能卡'
        ],
        'rights_reserved' => [
            'fa' => 'طراحی و توسعه توسط تیم توسعه هوشمند راستین',
            'en' => 'Designed & Developed by Rastin Smart Development Team',
            'ar' => 'تصميم وتطوير بواسطة فريق راستين للتطوير الذكي',
            'tr' => 'Rastin Akıllı Geliştirme Ekibi tarafından tasarlandı ve geliştirildi',
            'ru' => 'Разработано командой умной разработки Rastin',
            'zh' => '由 Rastin 智能研发团队设计与开发'
        ],
        'link_copied' => [
            'fa' => 'لینک پروفایل در کلیپ‌بورد کپی شد!',
            'en' => 'Profile link copied to clipboard!',
            'ar' => 'تم نسخ رابط الملف الشخصي!',
            'tr' => 'Profil bağlantısı panoya kopyalandı!',
            'ru' => 'Ссылка скопирована в буфер обмена!',
            'zh' => '名片链接已复制到剪贴板！'
        ],
        'reviews_title' => [
            'fa' => 'نظرات و امتیازها',
            'en' => 'Reviews & Ratings',
            'ar' => 'التقييمات والآراء',
            'tr' => 'Yorumlar ve Puanlar',
            'ru' => 'Отзывы и оценки',
            'zh' => '用户评价与评分'
        ],
        'submit_review' => [
            'fa' => 'ثبت نظر و امتیاز',
            'en' => 'Submit Review',
            'ar' => 'أضف تقييمك',
            'tr' => 'Değerlendirme Yap',
            'ru' => 'Оставить отзыв',
            'zh' => '提交评价'
        ],
        'your_rating' => [
            'fa' => 'امتیاز شما به این کارت',
            'en' => 'Your Rating',
            'ar' => 'تقييمك',
            'tr' => 'Puanınız',
            'ru' => 'Ваша оценка',
            'zh' => '您的评分'
        ],
        'your_name' => [
            'fa' => 'نام و نام خانوادگی شما',
            'en' => 'Your Name',
            'ar' => 'الاسم الكامل',
            'tr' => 'Adınız Soyadınız',
            'ru' => 'Ваше имя',
            'zh' => '您的姓名'
        ],
        'your_comment' => [
            'fa' => 'متن نظر یا تجربه شما',
            'en' => 'Your Review or Feedback',
            'ar' => 'تعليقك أو تجربتك',
            'tr' => 'Yorumunuz veya deneyiminiz',
            'ru' => 'Текст отзыва',
            'zh' => '您的评价或反馈'
        ],
        'review_pending_note' => [
            'fa' => 'نظرات پس از تایید توسط صاحب پروفایل نمایش داده می‌شوند.',
            'en' => 'Reviews are published after owner approval.',
            'ar' => 'يتم نشر التعليقات بعد موافقة صاحب الحساب.',
            'tr' => 'Yorumlar profil sahibinin onayından sonra yayınlanır.',
            'ru' => 'Отзывы публикуются после подтверждения владельцем.',
            'zh' => '评价需经名片所有者审核后发布。'
        ],
        'owner_reply' => [
            'fa' => 'پاسخ مدیریت',
            'en' => 'Owner Reply',
            'ar' => 'رد صاحب الملف',
            'tr' => 'Kart Sahibinin Cevabı',
            'ru' => 'Ответ владельца',
            'zh' => '名片主人回复'
        ],
        'no_reviews_yet' => [
            'fa' => 'هنوز نظری ثبت نشده است. اولین نفری باشید که نظر خود را ثبت می‌کنید!',
            'en' => 'No reviews yet. Be the first to share your experience!',
            'ar' => 'لا توجد تقييمات بعد. كن أول من يشارك تجربته!',
            'tr' => 'Henüz yorum yok. İlk yorum yapan siz olun!',
            'ru' => 'Пока нет отзывов. Будьте первым!',
            'zh' => '暂无评价，快来抢先留下第一条评价吧！'
        ]
    ];

    public static function sanitizeLang(?string $lang): string
    {
        if ($lang && array_key_exists($lang, self::SUPPORTED_LANGUAGES)) {
            return $lang;
        }
        return 'fa';
    }

    public static function getDirection(string $lang): string
    {
        $clean = self::sanitizeLang($lang);
        return self::SUPPORTED_LANGUAGES[$clean]['dir'] ?? 'rtl';
    }

    public static function get(string $key, string $lang = 'fa'): string
    {
        $cleanLang = self::sanitizeLang($lang);
        if (isset(self::TRANSLATIONS[$key][$cleanLang])) {
            return self::TRANSLATIONS[$key][$cleanLang];
        }
        return self::TRANSLATIONS[$key]['fa'] ?? $key;
    }

    public static function getAll(string $lang = 'fa'): array
    {
        $cleanLang = self::sanitizeLang($lang);
        $res = [];
        foreach (self::TRANSLATIONS as $key => $values) {
            $res[$key] = $values[$cleanLang] ?? $values['fa'] ?? $key;
        }
        return $res;
    }

    public static function getSupportedLanguages(): array
    {
        return self::SUPPORTED_LANGUAGES;
    }
}
