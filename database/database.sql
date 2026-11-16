-- =======================================================
-- CIPCard Platform Database Schema
-- Brand: CIPCard (cipcard.ir)
-- PHP 8.2+ Clean MVC & PDO Architecture
-- Character Set: utf8mb4 | Collation: utf8mb4_unicode_ci
-- =======================================================

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `transactions`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `profiles`;
DROP TABLE IF EXISTS `otp_codes`;
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `users`;
SET FOREIGN_KEY_CHECKS = 1;

-- -------------------------------------------------------
-- 1. USERS TABLE
-- -------------------------------------------------------
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `mobile` VARCHAR(15) NOT NULL UNIQUE COMMENT 'Unique identifier and login username (e.g. 09123456789)',
  `full_name` VARCHAR(150) NOT NULL COMMENT 'Full name of user/customer',
  `role` ENUM('user', 'admin') NOT NULL DEFAULT 'user' COMMENT 'System access role',
  `password` VARCHAR(255) NULL COMMENT 'Bcrypt hashed password (mainly for admin, null for OTP users)',
  `status` ENUM('pending_verification', 'active', 'suspended') NOT NULL DEFAULT 'pending_verification' COMMENT 'Account status',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_users_mobile` (`mobile`),
  INDEX `idx_users_role` (`role`),
  INDEX `idx_users_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------
-- 2. PROFILES TABLE (NFC Smart Card Public & Private Data)
-- -------------------------------------------------------
CREATE TABLE `profiles` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL UNIQUE COMMENT 'Foreign key to users table',
  `slug` VARCHAR(50) NULL UNIQUE COMMENT 'Custom profile slug (e.g. username or mobile number)',
  `display_name` VARCHAR(150) NOT NULL COMMENT 'Name displayed on card/profile',
  `job_title` VARCHAR(150) NULL COMMENT 'Job title / specialty',
  `company` VARCHAR(150) NULL COMMENT 'Company or organization name',
  `bio` TEXT NULL COMMENT 'Short biography or company introduction',
  `avatar_url` VARCHAR(255) NULL COMMENT 'Path to uploaded avatar/logo image',
  `cover_url` VARCHAR(255) NULL COMMENT 'Path to profile cover image',
  `email` VARCHAR(150) NULL COMMENT 'Work or personal email address',
  `phone_work` VARCHAR(25) NULL COMMENT 'Work phone number',
  `phone_mobile` VARCHAR(25) NULL COMMENT 'Mobile number displayed on profile',
  `website` VARCHAR(255) NULL COMMENT 'Personal/Company website URL',
  `address` TEXT NULL COMMENT 'Physical address or office location',
  `social_links` JSON NULL COMMENT 'JSON storage for Instagram, WhatsApp, Telegram, LinkedIn, etc.',
  `template_id` ENUM('minimal', 'glassmorphism', 'corporate', 'creative_dark', 'modern_card') NOT NULL DEFAULT 'minimal' COMMENT '1 of 5 selected templates',
  `theme_color` VARCHAR(50) NOT NULL DEFAULT 'gold_black' COMMENT 'Palette: gold_black, blue_white, emerald_gray',
  `is_active` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0: Pending activation (unpaid), 1: Active profile',
  `view_count` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Total profile visit count',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_profiles_user_id` (`user_id`),
  INDEX `idx_profiles_slug` (`slug`),
  INDEX `idx_profiles_template` (`template_id`),
  INDEX `idx_profiles_active` (`is_active`),
  CONSTRAINT `fk_profiles_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------
-- 3. ORDERS TABLE
-- -------------------------------------------------------
CREATE TABLE `orders` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_number` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Unique order code (e.g. CIP-202611-1001)',
  `user_id` BIGINT UNSIGNED NOT NULL COMMENT 'Foreign key to users table',
  `card_type` ENUM('default_cip', 'custom_design') NOT NULL COMMENT 'Default CIP design vs Custom design',
  `amount` BIGINT UNSIGNED NOT NULL COMMENT 'Payable amount in Toman',
  `status` ENUM('unpaid', 'pending_design', 'printing', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'unpaid' COMMENT 'Order workflow stepper status',
  `custom_design_file` VARCHAR(255) NULL COMMENT 'Path to uploaded customer logo/design file',
  `custom_design_notes` TEXT NULL COMMENT 'Customer notes for custom design',
  `shipping_address` TEXT NULL COMMENT 'Customer postal shipping address',
  `postal_code` VARCHAR(20) NULL COMMENT '10-digit postal code',
  `tracking_code` VARCHAR(100) NULL COMMENT 'Postal tracking code for customer panel tracking',
  `shipped_at` DATETIME NULL COMMENT 'Date when order was handed to postal service',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_orders_order_number` (`order_number`),
  INDEX `idx_orders_user_id` (`user_id`),
  INDEX `idx_orders_status` (`status`),
  CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------
-- 4. TRANSACTIONS TABLE (Zarinpal API v4)
-- -------------------------------------------------------
CREATE TABLE `transactions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` BIGINT UNSIGNED NOT NULL COMMENT 'Foreign key to orders table',
  `user_id` BIGINT UNSIGNED NOT NULL COMMENT 'Foreign key to users table',
  `authority` VARCHAR(100) NOT NULL UNIQUE COMMENT 'Zarinpal authority code',
  `ref_id` VARCHAR(100) NULL COMMENT 'Zarinpal transaction reference ID upon successful verification',
  `amount` BIGINT UNSIGNED NOT NULL COMMENT 'Transaction amount in Toman',
  `gateway` VARCHAR(50) NOT NULL DEFAULT 'zarinpal' COMMENT 'Payment gateway identifier',
  `status` ENUM('pending', 'success', 'failed') NOT NULL DEFAULT 'pending' COMMENT 'Payment status',
  `card_pan` VARCHAR(50) NULL COMMENT 'Masked card number returned by gateway',
  `fee` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Gateway transaction fee in Toman',
  `payment_date` DATETIME NULL COMMENT 'Timestamp of successful payment verification',
  `error_message` TEXT NULL COMMENT 'Gateway error message if failed',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_trans_order_id` (`order_id`),
  INDEX `idx_trans_user_id` (`user_id`),
  INDEX `idx_trans_authority` (`authority`),
  INDEX `idx_trans_ref_id` (`ref_id`),
  INDEX `idx_trans_status` (`status`),
  CONSTRAINT `fk_trans_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_trans_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------
-- 5. OTP_CODES TABLE (Passwordless Authentication)
-- -------------------------------------------------------
CREATE TABLE `otp_codes` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `mobile` VARCHAR(15) NOT NULL COMMENT 'Mobile number code was dispatched to',
  `code` VARCHAR(6) NOT NULL COMMENT '4 to 6-digit one time password',
  `expires_at` DATETIME NOT NULL COMMENT 'Expiration datetime (typically 2-3 minutes)',
  `is_used` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0: Unused, 1: Used/Invalidated',
  `ip_address` VARCHAR(45) NULL COMMENT 'Client IP address requesting code',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_otp_lookup` (`mobile`, `is_used`, `expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------
-- 6. SETTINGS TABLE (Dynamic System Configuration)
-- -------------------------------------------------------
CREATE TABLE `settings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `key_name` VARCHAR(100) NOT NULL UNIQUE COMMENT 'Unique config key name',
  `value` LONGTEXT NULL COMMENT 'Configuration value',
  `title` VARCHAR(255) NOT NULL COMMENT 'Human readable label for admin panel',
  `group_name` VARCHAR(50) NOT NULL DEFAULT 'general' COMMENT 'Grouping: pricing, zarinpal, sms, general',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_settings_key` (`key_name`),
  INDEX `idx_settings_group` (`group_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------
-- DEFAULT SEED DATA
-- -------------------------------------------------------

-- Default System Settings
INSERT INTO `settings` (`key_name`, `value`, `title`, `group_name`) VALUES
('price_default_cip', '2500000', 'قیمت طرح پیش‌فرض CIP (تومان)', 'pricing'),
('price_custom_design', '5000000', 'قیمت طرح اختصاصی با لوگو و طراحی اختصاصی (تومان)', 'pricing'),
('zarinpal_merchant_id', '00000000-0000-0000-0000-000000000000', 'مرچنت کد زرین‌پال (Merchant ID)', 'zarinpal'),
('zarinpal_sandbox', '1', 'حالت آزمایشی زرین‌پال (Sandbox 1=فعال, 0=غیرفعال)', 'zarinpal'),
('sms_url_pattern', 'https://api.sms-provider.ir/send?apikey=YOUR_API_KEY&to={mobile}&text={text}', 'الگوی آدرس وب‌سرویس پیامک (URL Pattern)', 'sms'),
('sms_otp_template', 'کد تایید ورود به CIPCard:\n{code}\nاعتبار: ۲ دقیقه', 'متن پیامک کد تایید OTP', 'sms'),
('site_title', 'CIPCard | کارت ویزیت هوشمند NFC لوکس', 'عنوان وب‌سایت', 'general'),
('site_description', 'پلتفرم پیشرفته خرید و مدیریت کارت ویزیت هوشمند NFC با قابلیت اتصال مستقیم به گوشی و شبکه‌های اجتماعی', 'توضیحات وب‌سایت', 'general'),
('support_phone', '021-91000000', 'شماره تلفن پشتیبانی', 'general'),
('support_email', 'info@cipcard.ir', 'ایمیل پشتیبانی', 'general');

-- Default Administrator Account
-- Username / Mobile: 09120000000
-- Password: Admin@CIPCard2026 (hashed via standard BCRYPT)
INSERT INTO `users` (`id`, `mobile`, `full_name`, `role`, `password`, `status`) VALUES
(1, '09120000000', 'مدیر ارشد سی‌آی‌پی کارت', 'admin', '$2y$12$R9WpGqB6G75N3w880Qe23OXwzH48x2v2tKzG3R1c0P2eQxWqZq2kG', 'active');
