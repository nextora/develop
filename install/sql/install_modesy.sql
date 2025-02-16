-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 03, 2024 at 08:14 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `install_modesy`
--

-- --------------------------------------------------------

--
-- Table structure for table `abuse_reports`
--

CREATE TABLE `abuse_reports` (
  `id` int(11) NOT NULL,
  `item_type` varchar(30) DEFAULT 'product',
  `item_id` int(11) DEFAULT NULL,
  `report_user_id` int(11) DEFAULT NULL,
  `description` varchar(10000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ad_spaces`
--

CREATE TABLE `ad_spaces` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `ad_space` text DEFAULT NULL,
  `ad_code_desktop` text DEFAULT NULL,
  `desktop_width` int(11) DEFAULT NULL,
  `desktop_height` int(11) DEFAULT NULL,
  `ad_code_mobile` text DEFAULT NULL,
  `mobile_width` int(11) DEFAULT NULL,
  `mobile_height` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_earnings`
--

CREATE TABLE `affiliate_earnings` (
  `id` int(11) NOT NULL,
  `referrer_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `commission_rate` tinyint(4) DEFAULT NULL,
  `earned_amount` bigint(20) DEFAULT NULL,
  `currency` varchar(20) DEFAULT 'USD',
  `exchange_rate` double DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_links`
--

CREATE TABLE `affiliate_links` (
  `id` int(11) NOT NULL,
  `referrer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `link_short` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_transfers`
--

CREATE TABLE `bank_transfers` (
  `id` int(11) NOT NULL,
  `report_type` varchar(30) DEFAULT 'order',
  `report_item_id` int(11) DEFAULT NULL,
  `order_number` bigint(20) DEFAULT NULL,
  `payment_note` varchar(500) DEFAULT NULL,
  `receipt_path` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL,
  `lang_id` tinyint(4) DEFAULT 1,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `category_order` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `comment` varchar(5000) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_images`
--

CREATE TABLE `blog_images` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_path_thumb` varchar(255) DEFAULT NULL,
  `storage` varchar(20) DEFAULT 'local',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `lang_id` tinyint(4) DEFAULT 1,
  `title` varchar(500) DEFAULT NULL,
  `slug` varchar(500) DEFAULT NULL,
  `summary` varchar(1000) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `storage` varchar(20) DEFAULT 'local',
  `image_default` varchar(255) DEFAULT NULL,
  `image_small` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_tags`
--

CREATE TABLE `blog_tags` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `tag_slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `name_data` text DEFAULT NULL,
  `category_data` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `show_on_slider` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `tree_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `parent_tree` varchar(255) DEFAULT NULL,
  `title_meta_tag` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `category_order` mediumint(9) DEFAULT 0,
  `featured_order` mediumint(9) DEFAULT 1,
  `homepage_order` mediumint(9) DEFAULT 5,
  `visibility` tinyint(1) DEFAULT 1,
  `is_featured` tinyint(1) DEFAULT 0,
  `show_on_main_menu` tinyint(1) DEFAULT 1,
  `show_image_on_main_menu` tinyint(1) DEFAULT 0,
  `show_products_on_index` tinyint(1) DEFAULT 0,
  `show_subcategory_products` tinyint(1) DEFAULT 0,
  `storage` varchar(20) DEFAULT 'local',
  `image` varchar(255) DEFAULT NULL,
  `show_description` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories_lang`
--

CREATE TABLE `categories_lang` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `lang_id` tinyint(4) DEFAULT 1,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `subject` varchar(500) DEFAULT NULL,
  `product_id` int(11) DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` varchar(10000) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_user_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT 0,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `comment` varchar(5000) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` varchar(5000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `coupon_code` varchar(50) DEFAULT NULL,
  `discount_rate` smallint(6) DEFAULT NULL,
  `coupon_count` int(11) DEFAULT NULL,
  `minimum_order_amount` bigint(20) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `usage_type` varchar(20) DEFAULT 'single',
  `category_ids` text DEFAULT NULL,
  `expiry_date` timestamp NULL DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons_used`
--

CREATE TABLE `coupons_used` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_products`
--

CREATE TABLE `coupon_products` (
  `id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `symbol` varchar(10) DEFAULT NULL,
  `currency_format` varchar(30) DEFAULT 'us',
  `symbol_direction` varchar(30) DEFAULT 'left',
  `space_money_symbol` tinyint(1) DEFAULT 0,
  `exchange_rate` double DEFAULT 1,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `id` int(11) NOT NULL,
  `name_array` text DEFAULT NULL,
  `field_type` varchar(20) DEFAULT NULL,
  `row_width` varchar(20) DEFAULT 'half',
  `is_required` tinyint(1) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `field_order` int(11) DEFAULT 1,
  `is_product_filter` tinyint(1) DEFAULT 0,
  `product_filter_key` varchar(255) DEFAULT NULL,
  `sort_options` varchar(30) DEFAULT 'alphabetically',
  `where_to_display` tinyint(4) DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields_category`
--

CREATE TABLE `custom_fields_category` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `field_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields_options`
--

CREATE TABLE `custom_fields_options` (
  `id` int(11) NOT NULL,
  `field_id` int(11) DEFAULT NULL,
  `option_key` varchar(500) DEFAULT NULL,
  `name_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields_product`
--

CREATE TABLE `custom_fields_product` (
  `id` int(11) NOT NULL,
  `field_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_filter_key` varchar(255) DEFAULT NULL,
  `field_value` varchar(1000) DEFAULT NULL,
  `selected_option_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `digital_files`
--

CREATE TABLE `digital_files` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `storage` varchar(20) DEFAULT 'local',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `digital_sales`
--

CREATE TABLE `digital_sales` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_title` varchar(500) DEFAULT NULL,
  `seller_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `license_key` varchar(255) DEFAULT NULL,
  `purchase_code` varchar(100) NOT NULL,
  `currency` varchar(20) NOT NULL DEFAULT 'USD',
  `price` bigint(20) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE `earnings` (
  `id` int(11) NOT NULL,
  `order_number` bigint(20) DEFAULT NULL,
  `order_product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sale_amount` bigint(20) DEFAULT NULL,
  `vat_rate` double DEFAULT NULL,
  `vat_amount` bigint(20) DEFAULT NULL,
  `commission_rate` tinyint(4) DEFAULT NULL,
  `commission` bigint(20) DEFAULT NULL,
  `coupon_discount` bigint(20) DEFAULT NULL,
  `shipping_cost` bigint(20) DEFAULT NULL,
  `earned_amount` bigint(20) DEFAULT NULL,
  `affiliate_commission` bigint(20) DEFAULT 0,
  `affiliate_commission_rate` double DEFAULT 0,
  `affiliate_discount` bigint(20) DEFAULT 0,
  `affiliate_discount_rate` double DEFAULT 0,
  `currency` varchar(20) DEFAULT 'USD',
  `exchange_rate` double DEFAULT 1,
  `is_refunded` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_queue`
--

CREATE TABLE `email_queue` (
  `id` int(11) NOT NULL,
  `email_type` varchar(50) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `email_subject` varchar(255) DEFAULT NULL,
  `email_data` text DEFAULT NULL,
  `email_priority` smallint(6) DEFAULT 2,
  `template_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `following_id` int(11) DEFAULT NULL,
  `follower_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fonts`
--

CREATE TABLE `fonts` (
  `id` int(11) NOT NULL,
  `font_name` varchar(255) DEFAULT NULL,
  `font_key` varchar(255) DEFAULT NULL,
  `font_url` varchar(2000) DEFAULT NULL,
  `font_family` varchar(500) DEFAULT NULL,
  `font_source` varchar(50) DEFAULT 'google',
  `has_local_file` tinyint(1) DEFAULT 0,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fonts`
--

INSERT INTO `fonts` (`id`, `font_name`, `font_key`, `font_url`, `font_family`, `font_source`, `has_local_file`, `is_default`) VALUES
(1, 'Arial', 'arial', NULL, 'font-family: Arial, Helvetica, sans-serif', 'local', 0, 1),
(2, 'Arvo', 'arvo', '<link href=\"https://fonts.googleapis.com/css?family=Arvo:400,700&display=swap\" rel=\"stylesheet\">\r\n', 'font-family: \"Arvo\", Helvetica, sans-serif', 'google', 0, 0),
(3, 'Averia Libre', 'averia-libre', '<link href=\"https://fonts.googleapis.com/css?family=Averia+Libre:300,400,700&display=swap\" rel=\"stylesheet\">\r\n', 'font-family: \"Averia Libre\", Helvetica, sans-serif', 'google', 0, 0),
(4, 'Bitter', 'bitter', '<link href=\"https://fonts.googleapis.com/css?family=Bitter:400,400i,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Bitter\", Helvetica, sans-serif', 'google', 0, 0),
(5, 'Cabin', 'cabin', '<link href=\"https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Cabin\", Helvetica, sans-serif', 'google', 0, 0),
(6, 'Cherry Swash', 'cherry-swash', '<link href=\"https://fonts.googleapis.com/css?family=Cherry+Swash:400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Cherry Swash\", Helvetica, sans-serif', 'google', 0, 0),
(7, 'Encode Sans', 'encode-sans', '<link href=\"https://fonts.googleapis.com/css?family=Encode+Sans:300,400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Encode Sans\", Helvetica, sans-serif', 'google', 0, 0),
(8, 'Helvetica', 'helvetica', NULL, 'font-family: Helvetica, sans-serif', 'local', 0, 1),
(9, 'Hind', 'hind', '<link href=\"https://fonts.googleapis.com/css?family=Hind:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">', 'font-family: \"Hind\", Helvetica, sans-serif', 'google', 0, 0),
(10, 'Josefin Sans', 'josefin-sans', '<link href=\"https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Josefin Sans\", Helvetica, sans-serif', 'google', 0, 0),
(11, 'Kalam', 'kalam', '<link href=\"https://fonts.googleapis.com/css?family=Kalam:300,400,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Kalam\", Helvetica, sans-serif', 'google', 0, 0),
(12, 'Khula', 'khula', '<link href=\"https://fonts.googleapis.com/css?family=Khula:300,400,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Khula\", Helvetica, sans-serif', 'google', 0, 0),
(13, 'Lato', 'lato', '<link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">', 'font-family: \"Lato\", Helvetica, sans-serif', 'google', 0, 0),
(14, 'Lora', 'lora', '<link href=\"https://fonts.googleapis.com/css?family=Lora:400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Lora\", Helvetica, sans-serif', 'google', 0, 0),
(15, 'Merriweather', 'merriweather', '<link href=\"https://fonts.googleapis.com/css?family=Merriweather:300,400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Merriweather\", Helvetica, sans-serif', 'google', 0, 0),
(16, 'Montserrat', 'montserrat', '<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Montserrat\", Helvetica, sans-serif', 'google', 0, 0),
(17, 'Mukta', 'mukta', '<link href=\"https://fonts.googleapis.com/css?family=Mukta:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Mukta\", Helvetica, sans-serif', 'google', 0, 0),
(18, 'Nunito', 'nunito', '<link href=\"https://fonts.googleapis.com/css?family=Nunito:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Nunito\", Helvetica, sans-serif', 'google', 0, 0),
(19, 'Open Sans', 'open-sans', '<link href=\"https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap\" rel=\"stylesheet\">', 'font-family: \"Open Sans\", Helvetica, sans-serif', 'local', 1, 0),
(20, 'Oswald', 'oswald', '<link href=\"https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Oswald\", Helvetica, sans-serif', 'google', 0, 0),
(21, 'Oxygen', 'oxygen', '<link href=\"https://fonts.googleapis.com/css?family=Oxygen:300,400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Oxygen\", Helvetica, sans-serif', 'google', 0, 0),
(22, 'Poppins', 'poppins', '<link href=\"https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Poppins\", Helvetica, sans-serif', 'local', 1, 0),
(23, 'PT Sans', 'pt-sans', '<link href=\"https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"PT Sans\", Helvetica, sans-serif', 'google', 0, 0),
(24, 'Raleway', 'raleway', '<link href=\"https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Raleway\", Helvetica, sans-serif', 'google', 0, 0),
(25, 'Roboto', 'roboto', '<link href=\"https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Roboto\", Helvetica, sans-serif', 'google', 0, 0),
(26, 'Roboto Condensed', 'roboto-condensed', '<link href=\"https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Roboto Condensed\", Helvetica, sans-serif', 'google', 0, 0),
(27, 'Roboto Slab', 'roboto-slab', '<link href=\"https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Roboto Slab\", Helvetica, sans-serif', 'google', 0, 0),
(28, 'Rokkitt', 'rokkitt', '<link href=\"https://fonts.googleapis.com/css?family=Rokkitt:300,400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Rokkitt\", Helvetica, sans-serif', 'google', 0, 0),
(29, 'Source Sans Pro', 'source-sans-pro', '<link href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Source Sans Pro\", Helvetica, sans-serif', 'google', 0, 0),
(30, 'Titillium Web', 'titillium-web', '<link href=\"https://fonts.googleapis.com/css?family=Titillium+Web:300,400,600,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">', 'font-family: \"Titillium Web\", Helvetica, sans-serif', 'google', 0, 0),
(31, 'Ubuntu', 'ubuntu', '<link href=\"https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext\" rel=\"stylesheet\">', 'font-family: \"Ubuntu\", Helvetica, sans-serif', 'google', 0, 0),
(32, 'Verdana', 'verdana', NULL, 'font-family: Verdana, Helvetica, sans-serif', 'local', 0, 1),
(33, 'Work Sans', 'work-sans', '<link href=\"https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\"> ', 'font-family: \"Work Sans\", Helvetica, sans-serif', 'google', 0, 0),
(34, 'Libre Baskerville', 'libre-baskerville', '<link href=\"https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400i&display=swap&subset=latin-ext\" rel=\"stylesheet\"> ', 'font-family: \"Libre Baskerville\", Helvetica, sans-serif', 'google', 0, 0),
(35, 'Signika', 'signika', '<link href=\"https://fonts.googleapis.com/css2?family=Signika:wght@300;400;600;700&display=swap\" rel=\"stylesheet\">', 'font-family: \'Signika\', sans-serif;', 'google', 0, 0),
(36, 'Tajawal', 'tajawal', '<link href=\"https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap\" rel=\"stylesheet\">', 'font-family: \'Tajawal\', sans-serif;', 'google', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(11) NOT NULL,
  `physical_products_system` tinyint(1) DEFAULT 1,
  `digital_products_system` tinyint(1) DEFAULT 1,
  `marketplace_system` tinyint(1) DEFAULT 1,
  `classified_ads_system` tinyint(1) DEFAULT 1,
  `bidding_system` tinyint(1) DEFAULT 1,
  `selling_license_keys_system` tinyint(1) DEFAULT 1,
  `multi_vendor_system` tinyint(1) DEFAULT 1,
  `membership_plans_system` tinyint(1) DEFAULT 0,
  `site_lang` tinyint(4) DEFAULT 1,
  `timezone` varchar(100) DEFAULT 'America/New_York',
  `application_name` varchar(255) DEFAULT NULL,
  `selected_navigation` tinyint(4) DEFAULT 1,
  `fea_categories_design` varchar(30) DEFAULT 'round_boxes',
  `menu_limit` tinyint(4) DEFAULT 8,
  `recaptcha_site_key` varchar(500) DEFAULT NULL,
  `recaptcha_secret_key` varchar(500) DEFAULT NULL,
  `recaptcha_lang` varchar(30) DEFAULT NULL,
  `custom_header_codes` mediumtext DEFAULT NULL,
  `custom_footer_codes` mediumtext DEFAULT NULL,
  `mail_service` varchar(100) DEFAULT 'swift',
  `mail_protocol` varchar(20) DEFAULT 'smtp',
  `mail_encryption` varchar(100) DEFAULT 'tls',
  `mail_host` varchar(255) DEFAULT NULL,
  `mail_port` varchar(20) DEFAULT NULL,
  `mail_username` varchar(255) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL,
  `mail_title` varchar(255) DEFAULT NULL,
  `mail_reply_to` varchar(255) DEFAULT 'noreply@domain.com ',
  `mailjet_api_key` varchar(255) DEFAULT NULL,
  `mailjet_secret_key` varchar(255) DEFAULT NULL,
  `mailjet_email_address` varchar(255) DEFAULT NULL,
  `email_verification` tinyint(1) DEFAULT 0,
  `facebook_app_id` varchar(500) DEFAULT NULL,
  `facebook_app_secret` varchar(500) DEFAULT NULL,
  `google_client_id` varchar(500) DEFAULT NULL,
  `google_client_secret` varchar(500) DEFAULT NULL,
  `vk_app_id` varchar(500) DEFAULT NULL,
  `vk_secure_key` varchar(500) DEFAULT NULL,
  `google_analytics` text DEFAULT NULL,
  `promoted_products` tinyint(1) DEFAULT 1,
  `multilingual_system` tinyint(1) DEFAULT 1,
  `product_comments` tinyint(1) DEFAULT 1,
  `comment_approval_system` tinyint(1) DEFAULT 0,
  `reviews` tinyint(1) DEFAULT 1,
  `blog_comments` tinyint(1) DEFAULT 1,
  `slider_status` tinyint(4) DEFAULT 1,
  `slider_type` varchar(30) DEFAULT 'full_width',
  `slider_effect` varchar(30) DEFAULT 'fade',
  `featured_categories` tinyint(1) DEFAULT 1,
  `index_promoted_products` tinyint(1) DEFAULT 1,
  `index_promoted_products_count` tinyint(1) DEFAULT 8,
  `index_latest_products` tinyint(1) DEFAULT 1,
  `index_latest_products_count` tinyint(1) DEFAULT 4,
  `index_blog_slider` tinyint(1) DEFAULT 1,
  `product_link_structure` varchar(20) DEFAULT 'slug-id',
  `site_color` varchar(100) DEFAULT 'default',
  `logo` varchar(255) DEFAULT NULL,
  `logo_email` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `watermark_text` varchar(255) DEFAULT 'Modesy',
  `watermark_font_size` smallint(6) DEFAULT 42,
  `watermark_vrt_alignment` varchar(20) DEFAULT 'center',
  `watermark_hor_alignment` varchar(20) DEFAULT 'center',
  `watermark_product_images` tinyint(1) DEFAULT 0,
  `watermark_blog_images` tinyint(1) DEFAULT 0,
  `watermark_thumbnail_images` tinyint(1) DEFAULT 0,
  `facebook_comment` text DEFAULT NULL,
  `facebook_comment_status` tinyint(1) DEFAULT 0,
  `cache_system` tinyint(1) DEFAULT NULL,
  `cache_static_system` tinyint(1) DEFAULT 1,
  `refresh_cache_database_changes` tinyint(1) DEFAULT 0,
  `cache_refresh_time` int(11) DEFAULT 1800,
  `rss_system` tinyint(1) DEFAULT 1,
  `approve_before_publishing` tinyint(1) DEFAULT 1,
  `approve_after_editing` tinyint(1) DEFAULT 0,
  `vendor_verification_system` tinyint(1) DEFAULT 1,
  `email_options` text DEFAULT NULL,
  `mail_options_account` varchar(100) DEFAULT NULL,
  `show_vendor_contact_information` tinyint(1) DEFAULT 1,
  `guest_checkout` tinyint(1) DEFAULT 0,
  `maintenance_mode_title` varchar(500) DEFAULT NULL,
  `maintenance_mode_description` varchar(2000) DEFAULT NULL,
  `maintenance_mode_status` tinyint(1) DEFAULT 0,
  `google_adsense_code` varchar(2000) DEFAULT NULL,
  `sort_categories` varchar(30) DEFAULT 'category_order',
  `sort_parent_categories_by_order` tinyint(1) DEFAULT 1,
  `pwa_status` tinyint(1) DEFAULT 0,
  `pwa_logo` text DEFAULT NULL,
  `location_search_header` tinyint(1) DEFAULT 1,
  `vendor_bulk_product_upload` tinyint(1) DEFAULT 1,
  `vendors_change_shop_name` tinyint(1) DEFAULT 1,
  `show_sold_products` tinyint(1) DEFAULT 1,
  `newsletter_status` tinyint(1) DEFAULT 1,
  `newsletter_popup` tinyint(1) DEFAULT 1,
  `newsletter_image` varchar(255) DEFAULT NULL,
  `show_customer_email_seller` tinyint(1) DEFAULT 1,
  `show_customer_phone_seller` tinyint(1) DEFAULT 1,
  `request_documents_vendors` tinyint(1) DEFAULT 0,
  `explanation_documents_vendors` varchar(500) DEFAULT NULL,
  `allow_free_plan_multiple_times` tinyint(1) DEFAULT 0,
  `single_country_mode` tinyint(1) DEFAULT 0,
  `single_country_id` int(11) DEFAULT NULL,
  `refund_system` tinyint(1) DEFAULT 1,
  `affiliate_status` tinyint(1) DEFAULT 0,
  `affiliate_type` varchar(30) DEFAULT 'site_based',
  `affiliate_image` varchar(255) DEFAULT NULL,
  `affiliate_commission_rate` double DEFAULT 0,
  `affiliate_discount_rate` double DEFAULT 0,
  `auto_approve_orders` tinyint(1) DEFAULT 0,
  `auto_approve_orders_days` smallint(6) DEFAULT 10,
  `logo_size` varchar(30) DEFAULT '160x60',
  `profile_number_of_sales` tinyint(1) DEFAULT 1,
  `last_cron_update` timestamp NULL DEFAULT NULL,
  `version` varchar(30) DEFAULT '2.5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `physical_products_system`, `digital_products_system`, `marketplace_system`, `classified_ads_system`, `bidding_system`, `selling_license_keys_system`, `multi_vendor_system`, `membership_plans_system`, `site_lang`, `timezone`, `application_name`, `selected_navigation`, `fea_categories_design`, `menu_limit`, `recaptcha_site_key`, `recaptcha_secret_key`, `recaptcha_lang`, `custom_header_codes`, `custom_footer_codes`, `mail_service`, `mail_protocol`, `mail_encryption`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_title`, `mail_reply_to`, `mailjet_api_key`, `mailjet_secret_key`, `mailjet_email_address`, `email_verification`, `facebook_app_id`, `facebook_app_secret`, `google_client_id`, `google_client_secret`, `vk_app_id`, `vk_secure_key`, `google_analytics`, `promoted_products`, `multilingual_system`, `product_comments`, `comment_approval_system`, `reviews`, `blog_comments`, `slider_status`, `slider_type`, `slider_effect`, `featured_categories`, `index_promoted_products`, `index_promoted_products_count`, `index_latest_products`, `index_latest_products_count`, `index_blog_slider`, `product_link_structure`, `site_color`, `logo`, `logo_email`, `favicon`, `watermark_text`, `watermark_font_size`, `watermark_vrt_alignment`, `watermark_hor_alignment`, `watermark_product_images`, `watermark_blog_images`, `watermark_thumbnail_images`, `facebook_comment`, `facebook_comment_status`, `cache_system`, `cache_static_system`, `refresh_cache_database_changes`, `cache_refresh_time`, `rss_system`, `approve_before_publishing`, `approve_after_editing`, `vendor_verification_system`, `email_options`, `mail_options_account`, `show_vendor_contact_information`, `guest_checkout`, `maintenance_mode_title`, `maintenance_mode_description`, `maintenance_mode_status`, `google_adsense_code`, `sort_categories`, `sort_parent_categories_by_order`, `pwa_status`, `pwa_logo`, `location_search_header`, `vendor_bulk_product_upload`, `vendors_change_shop_name`, `show_sold_products`, `newsletter_status`, `newsletter_popup`, `newsletter_image`, `show_customer_email_seller`, `show_customer_phone_seller`, `request_documents_vendors`, `explanation_documents_vendors`, `allow_free_plan_multiple_times`, `single_country_mode`, `single_country_id`, `refund_system`, `affiliate_status`, `affiliate_type`, `affiliate_image`, `affiliate_commission_rate`, `affiliate_discount_rate`, `auto_approve_orders`, `auto_approve_orders_days`, `logo_size`, `profile_number_of_sales`, `last_cron_update`, `version`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 'America/New_York', 'Modesy', 1, 'round_boxes', 8, NULL, NULL, 'en', NULL, NULL, 'swift', 'smtp', 'tls', NULL, '587', NULL, NULL, 'Modesy', 'noreply@domain.com', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 'full_width', 'fade', 1, 1, 10, 1, 10, 1, 'slug-id', '#222222', NULL, NULL, NULL, 'Modesy', 42, 'center', 'center', 0, 0, 0, NULL, 0, 0, 1, 0, 1800, 1, 1, 0, 1, NULL, NULL, 1, 1, 'Coming Soon', 'Our website is under construction. We\'ll be here soon with our new awesome site.', 0, '', 'category_order', 1, 0, NULL, 1, 1, 1, 1, 1, 0, NULL, 1, 1, 0, NULL, 0, 0, NULL, 1, 0, 'site_based', NULL, 0, 0, 0, 10, '160x60', 1, NULL, '2.5');

-- --------------------------------------------------------

--
-- Table structure for table `homepage_banners`
--

CREATE TABLE `homepage_banners` (
  `id` int(11) NOT NULL,
  `banner_url` varchar(1000) DEFAULT NULL,
  `banner_image_path` varchar(255) DEFAULT NULL,
  `banner_order` int(11) NOT NULL DEFAULT 1,
  `banner_width` double DEFAULT NULL,
  `banner_location` varchar(100) DEFAULT 'featured_products',
  `lang_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_default` varchar(255) DEFAULT NULL,
  `image_big` varchar(255) DEFAULT NULL,
  `image_small` varchar(255) DEFAULT NULL,
  `is_main` tinyint(1) DEFAULT 0,
  `storage` varchar(20) DEFAULT 'local'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images_file_manager`
--

CREATE TABLE `images_file_manager` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `storage` varchar(20) DEFAULT 'local',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images_variation`
--

CREATE TABLE `images_variation` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `variation_option_id` int(11) DEFAULT 0,
  `image_default` varchar(255) DEFAULT NULL,
  `image_big` varchar(255) DEFAULT NULL,
  `image_small` varchar(255) DEFAULT NULL,
  `is_main` tinyint(1) DEFAULT 0,
  `storage` varchar(20) DEFAULT 'local'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `order_number` bigint(20) DEFAULT NULL,
  `client_username` varchar(255) DEFAULT NULL,
  `client_first_name` varchar(100) DEFAULT NULL,
  `client_last_name` varchar(100) DEFAULT NULL,
  `client_email` varchar(255) DEFAULT NULL,
  `client_phone_number` varchar(100) DEFAULT NULL,
  `client_tax_number` varchar(255) DEFAULT NULL,
  `client_address` varchar(500) DEFAULT NULL,
  `client_country` varchar(100) DEFAULT NULL,
  `client_state` varchar(100) DEFAULT NULL,
  `client_city` varchar(100) DEFAULT NULL,
  `invoice_items` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_base`
--

CREATE TABLE `knowledge_base` (
  `id` int(11) NOT NULL,
  `lang_id` tinyint(4) DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `slug` varchar(500) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `category_id` varchar(50) DEFAULT NULL,
  `content_order` smallint(6) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_base_categories`
--

CREATE TABLE `knowledge_base_categories` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `category_order` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_form` varchar(20) NOT NULL,
  `language_code` varchar(20) NOT NULL,
  `text_direction` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `language_order` tinyint(4) NOT NULL DEFAULT 1,
  `text_editor_lang` varchar(10) DEFAULT 'en',
  `flag_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `short_form`, `language_code`, `text_direction`, `status`, `language_order`, `text_editor_lang`, `flag_path`) VALUES
(1, 'English', 'en', 'en-US', 'ltr', 1, 1, 'en', 'uploads/blocks/flag_eng.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `language_translations`
--

CREATE TABLE `language_translations` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `translation` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `language_translations`
--

INSERT INTO `language_translations` (`id`, `lang_id`, `label`, `translation`) VALUES
(1, 1, 'abuse_reports', 'Abuse Reports'),
(2, 1, 'abuse_report_exp', 'Briefly describe the issue you\'re facing'),
(3, 1, 'abuse_report_msg', 'Your report has reached us. Thank you!'),
(4, 1, 'accept_cookies', 'Accept Cookies'),
(5, 1, 'accept_quote', 'Accept Quote'),
(6, 1, 'access_key', 'Access Key'),
(7, 1, 'account_deletion_requests', 'Account Deletion Requests'),
(8, 1, 'activate_all', 'Activate All'),
(9, 1, 'activation_email_sent', 'Activation email has been sent!'),
(10, 1, 'active', 'Active'),
(11, 1, 'active_orders', 'Active Orders'),
(12, 1, 'active_payment_request_error', 'You already have an active payment request! Once this is complete, you can make a new request.'),
(13, 1, 'active_sales', 'Active Sales'),
(14, 1, 'added_to_cart', 'Added to Cart'),
(15, 1, 'additional_information', 'Additional Information'),
(16, 1, 'additional_invoice_information', 'Additional Invoice Information'),
(17, 1, 'additional_invoice_information_exp', 'VAT Number, Company No etc.'),
(18, 1, 'address', 'Address'),
(19, 1, 'address_title', 'Address Title'),
(20, 1, 'address_type', 'Address Type'),
(21, 1, 'add_administrator', 'Add Administrator'),
(22, 1, 'add_banner', 'Add Banner'),
(23, 1, 'add_brand', 'Add Brand'),
(24, 1, 'add_category', 'Add Category'),
(25, 1, 'add_city', 'Add City'),
(26, 1, 'add_comment', 'Add Comment'),
(27, 1, 'add_content', 'Add Content'),
(28, 1, 'add_country', 'Add Country'),
(29, 1, 'add_coupon', 'Add Coupon'),
(30, 1, 'add_currency', 'Add Currency'),
(31, 1, 'add_custom_field', 'Add Custom Field'),
(32, 1, 'add_delivery_time', 'Add Delivery Time'),
(33, 1, 'add_external_download_link', 'Add External Download Link'),
(34, 1, 'add_feature', 'Add Feature'),
(35, 1, 'add_font', 'Add Font'),
(36, 1, 'add_funds', 'Add Funds'),
(37, 1, 'add_funds_pay_debt', 'Add funds to your wallet to pay your debt. The debt will be automatically deducted.'),
(38, 1, 'add_image', 'Add Image'),
(39, 1, 'add_language', 'Add Language'),
(40, 1, 'add_license_keys', 'Add License Keys'),
(41, 1, 'add_license_keys_exp', 'Add all license keys with comma(,) separator. (i.e. License Key, License Key...)'),
(42, 1, 'add_new_address', 'Add New Address'),
(43, 1, 'add_option', 'Add Option'),
(44, 1, 'add_page', 'Add Page'),
(45, 1, 'add_payout', 'Add Payout'),
(46, 1, 'add_post', 'Add Post'),
(47, 1, 'add_product', 'Add Product'),
(48, 1, 'add_products', 'Add Products'),
(49, 1, 'add_product_for_sale', 'Add a Product for Sale'),
(50, 1, 'add_product_for_sale_exp', 'Add a product to sell on the site'),
(51, 1, 'add_product_get_price_requests', 'Add a Product to Receive Quote (Price) Requests'),
(52, 1, 'add_product_get_price_requests_exp', 'Add a product without adding a price to get price requests from customers'),
(53, 1, 'add_product_sell_license_keys', 'Add a Product to Sell License Keys'),
(54, 1, 'add_product_sell_license_keys_exp', 'Add a product to sell only license keys'),
(55, 1, 'add_product_services_listing', 'Add a Product or Service as an Ordinary Listing'),
(56, 1, 'add_product_services_listing_exp', 'Add a product or service without buy option'),
(57, 1, 'add_question', 'Add Question'),
(58, 1, 'add_review', 'Add Review'),
(59, 1, 'add_role', 'Add Role'),
(60, 1, 'add_shipping_class', 'Add Shipping Class'),
(61, 1, 'add_shipping_method', 'Add Shipping Method'),
(62, 1, 'add_shipping_option', 'Add Shipping Option'),
(63, 1, 'add_shipping_zone', 'Add Shipping Zone'),
(64, 1, 'add_slider_item', 'Add Slider Item'),
(65, 1, 'add_space_between_money_currency', 'Add Space Between Money and Currency'),
(66, 1, 'add_state', 'Add State'),
(67, 1, 'add_tax', 'Add Tax'),
(68, 1, 'add_to_affiliate_program', 'Add to Affiliate Program'),
(69, 1, 'add_to_cart', 'Add to Cart'),
(70, 1, 'add_to_featured', 'Add to Featured'),
(71, 1, 'add_to_product_filters', 'Add to Product Filters'),
(72, 1, 'add_to_special_offers', 'Add to Special Offers'),
(73, 1, 'add_to_wishlist', 'Add to wishlist'),
(74, 1, 'add_user', 'Add User'),
(75, 1, 'add_variation', 'Add Variation'),
(76, 1, 'add_video', 'Add Video'),
(77, 1, 'add_watermark_blog_images', 'Add Watermark to Blog Images'),
(78, 1, 'add_watermark_product_images', 'Add Watermark to Product Images'),
(79, 1, 'add_watermark_thumbnail_images', 'Add Watermark to Thumbnail (Small) Images'),
(80, 1, 'administrators', 'Administrators'),
(81, 1, 'admin_emails_will_send', 'Admin emails will be sent to this address'),
(82, 1, 'admin_panel', 'Admin Panel'),
(83, 1, 'admin_panel_link', 'Admin Panel Link'),
(84, 1, 'adsense_head_exp', 'The codes you add here will be added in the <head></head> tags.'),
(85, 1, 'ad_size', 'Ad Size'),
(86, 1, 'ad_spaces', 'Ad Spaces'),
(87, 1, 'affiliate', 'Affiliate'),
(88, 1, 'affiliate_link', 'Affiliate Link'),
(89, 1, 'affiliate_links', 'Affiliate Links'),
(90, 1, 'affiliate_link_exp', 'To maximize your affiliate earnings, share this link in blog posts, on social media, and in email campaigns. Include it in YouTube video descriptions, on your website, and in online forums.'),
(91, 1, 'affiliate_program', 'Affiliate Program'),
(92, 1, 'affiliate_program_vendor_exp', 'The affiliate program allows you, as a seller, to pay external partners a commission for promoting your products and driving sales through their unique links, helping you reach a wider audience and increase revenue. When you activate this system, there will be an option to create an affiliate link on your product page. All users can participate in this program by creating their own links for your products.'),
(93, 1, 'affiliate_seller_based', 'Seller-based (for products selected by the seller, seller pays the commission)'),
(94, 1, 'affiliate_site_based', 'Site-based (for all products, site pays the commission)'),
(95, 1, 'all', 'All'),
(96, 1, 'allowed_file_extensions', 'Allowed File Extensions'),
(97, 1, 'allow_all_currencies_classified_ads', 'Allow All Currencies for Ordinary Listing'),
(98, 1, 'allow_duplicate_license_keys', 'Allow Duplicate License Keys'),
(99, 1, 'allow_free_plan_multiple_times', 'Allow Free Plan to be Used Multiple Times'),
(100, 1, 'allow_vendors_change_shop_name', 'Allow Vendors to Change Their Shop Name'),
(101, 1, 'all_active_currencies', 'All active currencies'),
(102, 1, 'all_categories', 'All Categories'),
(103, 1, 'all_countries', 'All Countries'),
(104, 1, 'all_help_topics', 'All Help Topics'),
(105, 1, 'all_locations', 'All Locations'),
(106, 1, 'all_permissions', 'All Permissions'),
(107, 1, 'all_states', 'All States'),
(108, 1, 'alphabetically', 'Alphabetically'),
(109, 1, 'already_have_active_request', 'You already have an active request for this product!'),
(110, 1, 'always', 'Always'),
(111, 1, 'animations', 'Animations'),
(112, 1, 'answer', 'Answer'),
(113, 1, 'api_key', 'Api Key'),
(114, 1, 'appear_on_homepage', 'Appear on the Homepage'),
(115, 1, 'apply', 'Apply'),
(116, 1, 'apply_for_product_sales', 'Apply for Product Sales'),
(117, 1, 'apply_for_service_payments', 'Apply for Service Payments'),
(118, 1, 'approve', 'Approve'),
(119, 1, 'approved', 'Approved'),
(120, 1, 'approved_comments', 'Approved Comments'),
(121, 1, 'approve_refund', 'Approve Refund'),
(122, 1, 'app_id', 'App ID'),
(123, 1, 'app_name', 'Application Name'),
(124, 1, 'app_secret', 'App Secret'),
(125, 1, 'april', 'April'),
(126, 1, 'ask_question', 'Ask Question'),
(127, 1, 'assign_membership_plan', 'Assign Membership Plan'),
(128, 1, 'attachments', 'Attachments'),
(129, 1, 'audio', 'Audio'),
(130, 1, 'audio_preview', 'Audio Preview'),
(131, 1, 'audio_preview_exp', 'MP3 or WAV preview audio'),
(132, 1, 'august', 'August'),
(133, 1, 'automatically_update_exchange_rates', 'Automatically Update Exchange Rates'),
(134, 1, 'auto_approve_orders', 'Auto-Approve Unapproved Orders (after x days)'),
(135, 1, 'awaiting_payment', 'Awaiting Payment'),
(136, 1, 'awaiting_sellers_bid', 'Awaiting Seller\'s Bid'),
(137, 1, 'aws_base_url', 'AWS Base URL'),
(138, 1, 'aws_key', 'AWS Access Key'),
(139, 1, 'aws_secret', 'AWS Secret Key'),
(140, 1, 'aws_storage', 'AWS S3 Storage'),
(141, 1, 'back', 'Back'),
(142, 1, 'backward', 'Backward'),
(143, 1, 'balance', 'Balance'),
(144, 1, 'balance_exp', 'Approved earnings'),
(145, 1, 'bank_accounts', 'Bank Accounts'),
(146, 1, 'bank_accounts_exp', 'You can make your payment to one of these bank accounts.'),
(147, 1, 'bank_account_holder_name', 'Bank Account Holder\'s Name'),
(148, 1, 'bank_branch_city', 'Bank Branch City'),
(149, 1, 'bank_branch_country', 'Bank Branch Country'),
(150, 1, 'bank_name', 'Bank Name'),
(151, 1, 'bank_transfer', 'Bank Transfer'),
(152, 1, 'bank_transfer_accepted', 'Bank transfer accepted'),
(153, 1, 'bank_transfer_declined', 'Bank transfer declined'),
(154, 1, 'bank_transfer_exp', 'Make your payment directly into our bank account.'),
(155, 1, 'bank_transfer_reports', 'Bank Transfer Reports'),
(156, 1, 'banned', 'Banned'),
(157, 1, 'banner', 'Banner'),
(158, 1, 'banner_desktop', 'Desktop Banner'),
(159, 1, 'banner_desktop_exp', 'This ad will be displayed on screens larger than 992px'),
(160, 1, 'banner_location_exp', 'The banner will be added under the selected section'),
(161, 1, 'banner_mobile', 'Mobile Banner'),
(162, 1, 'banner_mobile_exp', 'This ad will be displayed on screens smaller than 992px'),
(163, 1, 'banner_width', 'Banner Width'),
(164, 1, 'ban_user', 'Ban User'),
(165, 1, 'base_currency', 'Base Currency'),
(166, 1, 'bidding_system', 'Bidding System'),
(167, 1, 'bidding_system_emails', 'Bidding system emails'),
(168, 1, 'bidding_system_request_quote', 'Bidding System (Request Quote)'),
(169, 1, 'billing_address', 'Billing Address'),
(170, 1, 'bitcoin', 'Bitcoin (BTC)'),
(171, 1, 'blog', 'Blog'),
(172, 1, 'blog_ad_space_1', 'Blog Ad Space 1'),
(173, 1, 'blog_ad_space_2', 'Blog Ad Space 2'),
(174, 1, 'blog_comments', 'Blog Comments'),
(175, 1, 'blog_posts', 'Blog Posts'),
(176, 1, 'blog_slider', 'Blog Slider'),
(177, 1, 'bottom', 'Bottom'),
(178, 1, 'boxed', 'Boxed'),
(179, 1, 'brand', 'Brand'),
(180, 1, 'brands', 'Brands'),
(181, 1, 'browse_files', 'Browse Files'),
(182, 1, 'btc_address', 'BTC Address'),
(183, 1, 'bucket_name', 'Bucket Name'),
(184, 1, 'bulk_category_upload', 'Bulk Category Upload'),
(185, 1, 'bulk_custom_field_upload', 'Bulk Custom Field Upload'),
(186, 1, 'bulk_product_upload', 'Bulk Product Upload'),
(187, 1, 'bulk_product_upload_exp', 'You can add your products with a CSV file from this section'),
(188, 1, 'bulk_upload_documentation', 'Bulk Upload Documentation'),
(189, 1, 'button', 'Button'),
(190, 1, 'button_color', 'Button Color'),
(191, 1, 'button_text', 'Button Text'),
(192, 1, 'button_text_color', 'Button Text Color'),
(193, 1, 'buyer', 'Buyer'),
(194, 1, 'buyer_discount_rate', 'Buyer Discount Rate'),
(195, 1, 'buy_button_link', 'Buy button link'),
(196, 1, 'buy_now', 'Buy Now'),
(197, 1, 'by', 'By'),
(198, 1, 'by_category_order', 'by Category Order'),
(199, 1, 'by_date', 'by Date'),
(200, 1, 'cache_refresh_time', 'Cache Refresh Time (Minute)'),
(201, 1, 'cache_refresh_time_exp', 'After this time, your cache files will be refreshed.'),
(202, 1, 'cache_system', 'Cache System'),
(203, 1, 'cancel', 'Cancel'),
(204, 1, 'cancelled', 'Cancelled'),
(205, 1, 'cancelled_sales', 'Cancelled Sales'),
(206, 1, 'cancel_order', 'Cancel Order'),
(207, 1, 'card_number', 'Card Number'),
(208, 1, 'cart', 'Cart'),
(209, 1, 'cash_on_delivery', 'Cash on Delivery'),
(210, 1, 'cash_on_delivery_exp', 'Pay with cash upon delivery.'),
(211, 1, 'cash_on_delivery_vendor_exp', 'Sell your products with pay on delivery option'),
(212, 1, 'cash_on_delivery_warning', 'You have selected \'Cash on Delivery\' as your payment method. You must pay the total amount when you receive your package. If you accept this payment method, please click the button below to complete your order.'),
(213, 1, 'categories', 'Categories'),
(214, 1, 'categories_all', 'All Categories'),
(215, 1, 'category', 'Category'),
(216, 1, 'category_id_finder', 'Category Id Finder'),
(217, 1, 'category_id_finder_exp', 'You can use this section to find out the Id of a category'),
(218, 1, 'category_level', 'Category Level'),
(219, 1, 'category_name', 'Category Name'),
(220, 1, 'cell_phone', 'Cell Phone'),
(221, 1, 'center', 'Center'),
(222, 1, 'change_password', 'Change Password'),
(223, 1, 'change_user_role', 'Change User Role'),
(224, 1, 'charge_shipping_for_each_different_product', 'Charge shipping for each different product in the cart'),
(225, 1, 'charge_shipping_for_each_product', 'Charge shipping for each product in the cart'),
(226, 1, 'chat_messages', 'Chat Messages'),
(227, 1, 'checkbox', 'Checkbox (Multiple Selection)'),
(228, 1, 'checking_out_as_guest', 'You are checking out as a guest'),
(229, 1, 'checkout', 'Checkout'),
(230, 1, 'choose_plan', 'Choose Plan'),
(231, 1, 'cities', 'Cities'),
(232, 1, 'city', 'City'),
(233, 1, 'classified_ads', 'Classified Ads'),
(234, 1, 'classified_ads_adding_product_as_listing', 'Classified Ads (Adding a Product or Service as an Ordinary Listing)'),
(235, 1, 'clear', 'Clear'),
(236, 1, 'client_id', 'Client ID'),
(237, 1, 'client_information', 'Client Information'),
(238, 1, 'client_secret', 'Client Secret'),
(239, 1, 'close', 'Close'),
(240, 1, 'closed', 'Closed'),
(241, 1, 'close_seller_shop', 'Close Seller\'s Shop'),
(242, 1, 'close_ticket', 'Close Ticket'),
(243, 1, 'close_user_shop', 'Close User Shop'),
(244, 1, 'cod_cancel_exp', 'You can cancel your order within 24 hours after the order date.'),
(245, 1, 'cod_option_disabled', 'Cash on Delivery payment option has been disabled until your commission debt is paid.'),
(246, 1, 'color', 'Color'),
(247, 1, 'comment', 'Comment'),
(248, 1, 'comments', 'Comments'),
(249, 1, 'comment_approval_system', 'Comment Approval System'),
(250, 1, 'commission', 'Commission'),
(251, 1, 'commissions_discounts', 'Commissions & Discounts'),
(252, 1, 'commission_debt', 'Commission Debt'),
(253, 1, 'commission_debt_limit', 'Commission Debt Limit'),
(254, 1, 'commission_debt_limit_exp', 'Cash on Delivery commissions will be automatically deducted from your wallet balance. If your wallet has insufficient funds, the commission will be added as a debt. When these debts exceed the specified debt limit, this payment option will be automatically disabled for your store.'),
(255, 1, 'commission_rate', 'Commission Rate'),
(256, 1, 'completed', 'Completed'),
(257, 1, 'completed_orders', 'Completed Orders'),
(258, 1, 'completed_sales', 'Completed Sales'),
(259, 1, 'confirmed', 'Confirmed'),
(260, 1, 'confirm_action', 'Are you sure you want to perform this action?'),
(261, 1, 'confirm_approve_order', 'Are you sure you want to confirm this order?'),
(262, 1, 'confirm_close_user_shop', 'Are you sure you want to close this shop?'),
(263, 1, 'confirm_comment', 'Are you sure you want to delete this comment?'),
(264, 1, 'confirm_comments', 'Are you sure you want to delete selected comments?'),
(265, 1, 'confirm_delete', 'Are you sure you want to delete this item?'),
(266, 1, 'confirm_message', 'Are you sure you want to delete this conversation?'),
(267, 1, 'confirm_messages', 'Are you sure you want to delete selected conversations?'),
(268, 1, 'confirm_order_received', 'Confirm Order Received'),
(269, 1, 'confirm_order_received_exp', 'Confirm if you have received your order.'),
(270, 1, 'confirm_order_received_warning', 'When you receive your order, please check the products you have purchased. If there is not any problem, click \'Confirm Order Received\' button. After confirming your order, the money will be transferred to the seller.'),
(271, 1, 'confirm_payment', 'Confirm Payment'),
(272, 1, 'confirm_product', 'Are you sure you want to delete this product?'),
(273, 1, 'confirm_products', 'Are you sure you want to delete selected products?'),
(274, 1, 'confirm_product_audio', 'Are you sure you want to delete this audio?'),
(275, 1, 'confirm_product_permanent', 'Are you sure you want to permanently delete this product?'),
(276, 1, 'confirm_product_video', 'Are you sure you want to delete this video?'),
(277, 1, 'confirm_quote_request', 'Are you sure you want to delete this quote request?'),
(278, 1, 'confirm_review', 'Are you sure you want to delete this review?'),
(279, 1, 'confirm_reviews', 'Are you sure you want to delete selected reviews?'),
(280, 1, 'confirm_slider_item', 'Are you sure you want to delete this slider item?'),
(281, 1, 'confirm_user', 'Are you sure you want to delete this user?'),
(282, 1, 'confirm_user_email', 'Confirm Email'),
(283, 1, 'confirm_variation', 'Are you sure you want to delete this variation?'),
(284, 1, 'confirm_your_account', 'Confirm Your Account'),
(285, 1, 'connect_with_facebook', 'Connect with Facebook'),
(286, 1, 'connect_with_google', 'Connect with Google'),
(287, 1, 'connect_with_vk', 'Connect with VKontakte'),
(288, 1, 'contact', 'Contact'),
(289, 1, 'contact_message', 'Contact Message'),
(290, 1, 'contact_messages', 'Contact Messages'),
(291, 1, 'contact_seller', 'Contact Seller'),
(292, 1, 'contact_settings', 'Contact Settings'),
(293, 1, 'contact_support', 'Contact Support'),
(294, 1, 'contact_support_exp', 'If you didn\'t find what you were looking for, you can submit a support request here.'),
(295, 1, 'contact_text', 'Contact Text'),
(296, 1, 'content', 'Content'),
(297, 1, 'contents', 'Contents'),
(298, 1, 'content_type', 'Content Type'),
(299, 1, 'continent', 'Continent'),
(300, 1, 'continue_to_checkout', 'Continue to Checkout'),
(301, 1, 'continue_to_payment', 'Continue to Payment'),
(302, 1, 'continue_to_payment_method', 'Continue to Payment Method'),
(303, 1, 'cookies_warning', 'Cookies Warning'),
(304, 1, 'copied', 'Copied'),
(305, 1, 'copy', 'Copy'),
(306, 1, 'copyright', 'Copyright'),
(307, 1, 'copy_code', 'Copy Code'),
(308, 1, 'copy_link', 'Copy Link'),
(309, 1, 'cost', 'Cost'),
(310, 1, 'cost_calculation_type', 'Cost Calculation Type'),
(311, 1, 'countries', 'Countries'),
(312, 1, 'country', 'Country'),
(313, 1, 'coupon', 'Coupon'),
(314, 1, 'coupons', 'Coupons'),
(315, 1, 'coupon_code', 'Coupon Code'),
(316, 1, 'coupon_minimum_cart_total_exp', 'Minimum cart total needed to use the coupon'),
(317, 1, 'coupon_usage_type', 'Coupon Usage Type'),
(318, 1, 'coupon_usage_type_1', 'Each user can use it for only one order'),
(319, 1, 'coupon_usage_type_2', 'Each user can use it for multiple orders (Guests can use)'),
(320, 1, 'coupon_valid_till', 'Valid till: {field}'),
(321, 1, 'cover_image_type', 'Cover Image Type'),
(322, 1, 'cpf', 'CPF'),
(323, 1, 'created_variations', 'Created Variations'),
(324, 1, 'create_ad_exp', 'If you don\'t have an ad code, you can create an ad code by selecting an image and adding an URL'),
(325, 1, 'create_affiliate_link', 'Create affiliate link'),
(326, 1, 'create_new_plan', 'Create a New Plan'),
(327, 1, 'credit_card', 'Credit Card'),
(328, 1, 'csv_file', 'CSV File'),
(329, 1, 'currencies', 'Currencies'),
(330, 1, 'currency', 'Currency'),
(331, 1, 'currency_code', 'Currency Code'),
(332, 1, 'currency_converter', 'Currency Converter'),
(333, 1, 'currency_converter_api', 'Currency Converter API'),
(334, 1, 'currency_format', 'Currency Format'),
(335, 1, 'currency_name', 'Currency Name'),
(336, 1, 'currency_settings', 'Currency Settings'),
(337, 1, 'currency_symbol', 'Currency Symbol'),
(338, 1, 'currency_symbol_format', 'Currency Symbol Format'),
(339, 1, 'current_plan', 'Current Plan'),
(340, 1, 'custom', 'Custom'),
(341, 1, 'custom_field', 'Custom Field'),
(342, 1, 'custom_fields', 'Custom Fields'),
(343, 1, 'custom_field_options', 'Custom Field Options'),
(344, 1, 'custom_footer_codes', 'Custom Footer Codes'),
(345, 1, 'custom_footer_codes_exp', 'These codes will be added to the footer of the site'),
(346, 1, 'custom_header_codes', 'Custom Header Codes'),
(347, 1, 'custom_header_codes_exp', 'These codes will be added to the header of the site'),
(348, 1, 'cvv', 'CVV'),
(349, 1, 'cvv_exp', 'Three-digits code on the back of your card'),
(350, 1, 'daily', 'Daily'),
(351, 1, 'daily_plan', 'Daily Plan'),
(352, 1, 'dashboard', 'Dashboard'),
(353, 1, 'dashboard_font', 'Dashboard Font'),
(354, 1, 'data_type', 'Data Type'),
(355, 1, 'date', 'Date'),
(356, 1, 'date_of_birth', 'Date of Birth'),
(357, 1, 'day', 'Day'),
(358, 1, 'days', 'Days'),
(359, 1, 'days_ago', 'days ago'),
(360, 1, 'days_left', 'days left'),
(361, 1, 'day_ago', 'day ago'),
(362, 1, 'day_count', 'Number of Days'),
(363, 1, 'december', 'December'),
(364, 1, 'decline', 'Decline'),
(365, 1, 'declined', 'Declined'),
(366, 1, 'default', 'Default'),
(367, 1, 'default_currency', 'Default Currency'),
(368, 1, 'default_language', 'Default Language'),
(369, 1, 'default_option', 'Default Option'),
(370, 1, 'default_option_exp', 'This option will be selected by default. It will use the default images and price'),
(371, 1, 'delete', 'Delete'),
(372, 1, 'deleted', 'Deleted'),
(373, 1, 'deleted_products', 'Deleted Products'),
(374, 1, 'delete_account', 'Delete Account'),
(375, 1, 'delete_account_exp', 'Deleting your account is permanent and cannot be reversed. All data, including preferences and subscriptions, will be lost. The process requires admin approval, which may take some time. Please enter your password and confirm to proceed.'),
(376, 1, 'delete_account_submit_exp', 'Your account deletion request has been submitted and is awaiting admin approval. If you wish to cancel this request, please contact site administration through the Help Center.'),
(377, 1, 'delete_conversation', 'Delete Conversation'),
(378, 1, 'delete_from_affiliate_program', 'Delete from Affiliate Program'),
(379, 1, 'delete_permanently', 'Delete Permanently'),
(380, 1, 'delete_quote', 'Delete Quote'),
(381, 1, 'delivery_time', 'Delivery Time'),
(382, 1, 'demo_url', 'Demo URL'),
(383, 1, 'demo_url_exp', 'Add a preview URL (i.e. https://demo.com)'),
(384, 1, 'deposits', 'Deposits'),
(385, 1, 'deposit_amount', 'Deposit Amount'),
(386, 1, 'description', 'Description'),
(387, 1, 'details', 'Details'),
(388, 1, 'digital', 'Digital'),
(389, 1, 'digital_exp', 'A digital file that buyers will download'),
(390, 1, 'digital_file', 'Digital File'),
(391, 1, 'digital_files', 'Digital Files'),
(392, 1, 'digital_file_required', 'Digital file is required!'),
(393, 1, 'digital_products', 'Digital Products'),
(394, 1, 'digital_sales', 'Digital Sales'),
(395, 1, 'disable', 'Disable'),
(396, 1, 'discord_url', 'Discord Url'),
(397, 1, 'discount', 'Discount'),
(398, 1, 'discounted_price', 'Discounted Price'),
(399, 1, 'discount_coupon', 'Discount Coupon'),
(400, 1, 'discount_rate', 'Discount Rate'),
(401, 1, 'documentation', 'Documentation'),
(402, 1, 'dont_have_account', 'Don\'t have an account?'),
(403, 1, 'dont_want_receive_emails', 'Don\'t want receive these emails?'),
(404, 1, 'download', 'Download'),
(405, 1, 'downloads', 'Downloads'),
(406, 1, 'download_csv_example', 'Download CSV Example'),
(407, 1, 'download_csv_template', 'Download CSV Template'),
(408, 1, 'download_database_backup', 'Download Database Backup'),
(409, 1, 'do_not_have_membership_plan', 'You do not have a membership plan. Click the button below to buy a membership plan.'),
(410, 1, 'draft', 'Draft'),
(411, 1, 'drafts', 'Drafts'),
(412, 1, 'draft_added', 'Draft added successfully!'),
(413, 1, 'drag_drop_file_here', 'Drag and drop file here or'),
(414, 1, 'drag_drop_images_here', 'Drag and drop images here or'),
(415, 1, 'dropdown', 'Dropdown (Single Selection)'),
(416, 1, 'duration', 'Duration'),
(417, 1, 'earned_amount', 'Earned Amount'),
(418, 1, 'earnings', 'Earnings'),
(419, 1, 'edit', 'Edit'),
(420, 1, 'edited_products', 'Edited Products'),
(421, 1, 'edit_address', 'Edit Address'),
(422, 1, 'edit_banner', 'Edit Banner'),
(423, 1, 'edit_brand', 'Edit Brand'),
(424, 1, 'edit_content', 'Edit Content'),
(425, 1, 'edit_coupon', 'Edit Coupon'),
(426, 1, 'edit_delivery_time', 'Edit Delivery Time'),
(427, 1, 'edit_details', 'Edit Details'),
(428, 1, 'edit_option', 'Edit Option'),
(429, 1, 'edit_options', 'Edit Options'),
(430, 1, 'edit_order', 'Edit Order'),
(431, 1, 'edit_plan', 'Edit Plan'),
(432, 1, 'edit_product', 'Edit Product'),
(433, 1, 'edit_products', 'Edit Products'),
(434, 1, 'edit_role', 'Edit Role'),
(435, 1, 'edit_shipping_class', 'Edit Shipping Class'),
(436, 1, 'edit_shipping_zone', 'Edit Shipping Zone'),
(437, 1, 'edit_tax', 'Edit Tax'),
(438, 1, 'edit_translations', 'Edit Translations'),
(439, 1, 'edit_user', 'Edit User'),
(440, 1, 'edit_variation', 'Edit Variation'),
(441, 1, 'effect', 'Effect'),
(442, 1, 'email', 'Email'),
(443, 1, 'email_address', 'Email Address'),
(444, 1, 'email_options', 'Email Options'),
(445, 1, 'email_option_contact_messages', 'Send contact messages to email address'),
(446, 1, 'email_option_product_added', 'Send email when a new product is added'),
(447, 1, 'email_option_send_email_new_message', 'Send me an email when someone send me a message'),
(448, 1, 'email_option_send_email_order_shipped', 'Send email to buyer when order shipped'),
(449, 1, 'email_option_send_order_to_buyer', 'Send email to buyer after purchase (Send order summary)'),
(450, 1, 'email_reset_password', 'Please click on the button below to reset your password.'),
(451, 1, 'email_settings', 'Email Settings'),
(452, 1, 'email_status', 'Email Status'),
(453, 1, 'email_template', 'Email Template'),
(454, 1, 'email_text_new_order', 'Your order has been received and is now processed. Your order details are shown below.'),
(455, 1, 'email_text_new_product', 'A new product has been added'),
(456, 1, 'email_text_see_product', 'Click the button below to see the product.'),
(457, 1, 'email_text_thank_for_order', 'Thank you for your order!'),
(458, 1, 'email_verification', 'Email Verification'),
(459, 1, 'enable', 'Enable'),
(460, 1, 'enable_dont_hide_products', 'Enable, Do Not Hide Products'),
(461, 1, 'enable_for_all_products', 'Enable For All Products'),
(462, 1, 'enable_hide_products', 'Enable, Hide Products Until Approved'),
(463, 1, 'enable_only_for_selected_products', 'Enable Only for Selected Products (products can be selected from the products page)'),
(464, 1, 'encryption', 'Encryption'),
(465, 1, 'end', 'End'),
(466, 1, 'enter_amount', 'Enter Amount'),
(467, 1, 'enter_email', 'Enter your email'),
(468, 1, 'enter_your_password', 'Enter your password'),
(469, 1, 'error_image_limit', 'Image upload limit exceeded!'),
(470, 1, 'error_product_image_delete', 'Before deleting the product image, you need to upload another image for the product!'),
(471, 1, 'error_product_image_required', 'Product image is required! Please upload an image for your product.'),
(472, 1, 'estimated_delivery', 'Estimated Delivery'),
(473, 1, 'example', 'Example'),
(474, 1, 'excel', 'Excel'),
(475, 1, 'exchange_rate', 'Exchange Rate'),
(476, 1, 'expense', 'Expense'),
(477, 1, 'expenses', 'Expenses'),
(478, 1, 'expense_amount', 'Expense Amount'),
(479, 1, 'expiration_date', 'Expiration Date (MM / YY)'),
(480, 1, 'expired', 'Expired'),
(481, 1, 'expired_products', 'Expired Products'),
(482, 1, 'expiry_date', 'Expiry Date'),
(483, 1, 'explanation', 'Explanation'),
(484, 1, 'export', 'Export'),
(485, 1, 'exp_special_characters', 'Do not use special characters'),
(486, 1, 'external_download_link', 'External Download Link'),
(487, 1, 'external_link', 'External Link'),
(488, 1, 'external_link_exp', 'You can add an external product link. (i.e. https://domain.com/product)'),
(489, 1, 'facebook_comments', 'Facebook Comments'),
(490, 1, 'facebook_comments_code', 'Facebook Comments Plugin Code'),
(491, 1, 'facebook_login', 'Facebook Login'),
(492, 1, 'facebook_url', 'Facebook URL'),
(493, 1, 'fade', 'Fade'),
(494, 1, 'favicon', 'Favicon'),
(495, 1, 'feature', 'Feature'),
(496, 1, 'featured', 'Featured'),
(497, 1, 'featured_badge', 'Featured Badge'),
(498, 1, 'featured_categories', 'Featured Categories'),
(499, 1, 'featured_categories_exp', 'Select the categories you want to show under the slider'),
(500, 1, 'featured_products', 'Featured Products'),
(501, 1, 'featured_products_payment_currency', 'Featured Products Payment Currency'),
(502, 1, 'featured_products_system', 'Featured Products System'),
(503, 1, 'features', 'Features'),
(504, 1, 'february', 'February'),
(505, 1, 'field', 'Field'),
(506, 1, 'field_name', 'Field Name'),
(507, 1, 'files_included', 'Files Included'),
(508, 1, 'files_included_ext', 'Enter the extensions of the files that you are going to sell (i.e. JPG, MP4, MP3)'),
(509, 1, 'file_too_large', 'File is too large. Max file size:'),
(510, 1, 'file_upload', 'File Upload'),
(511, 1, 'filter', 'Filter'),
(512, 1, 'filter_by_keyword', 'Filter by keyword'),
(513, 1, 'filter_key', 'Filter Key'),
(514, 1, 'filter_key_exp', 'Don\'t add special characters'),
(515, 1, 'filter_products', 'Filter Products'),
(516, 1, 'filter_products_location', 'Filter products by location'),
(517, 1, 'first_name', 'First Name'),
(518, 1, 'fixed_shipping_cost_for_cart_total', 'Fixed Shipping Cost for Cart Total'),
(519, 1, 'flag', 'Flag'),
(520, 1, 'flat_rate', 'Flat Rate'),
(521, 1, 'folder_name', 'Folder Name'),
(522, 1, 'follow', 'Follow'),
(523, 1, 'followers', 'Followers'),
(524, 1, 'following', 'Following'),
(525, 1, 'follow_us', 'Follow Us'),
(526, 1, 'fonts', 'Fonts'),
(527, 1, 'font_family', 'Font Family'),
(528, 1, 'font_settings', 'Font Settings'),
(529, 1, 'font_size', 'Font Size'),
(530, 1, 'footer', 'Footer'),
(531, 1, 'footer_about_section', 'Footer About Section'),
(532, 1, 'footer_bottom', 'Footer Bottom'),
(533, 1, 'footer_information', 'Information'),
(534, 1, 'footer_quick_links', 'Quick Links'),
(535, 1, 'forgot_password', 'Forgot Password?'),
(536, 1, 'form_validation_is_unique', 'The {field} field must contain a unique value.'),
(537, 1, 'form_validation_matches', 'The {field} field does not match the {param} field.'),
(538, 1, 'form_validation_max_length', 'The {field} field cannot exceed {param} characters in length.'),
(539, 1, 'form_validation_min_length', 'The {field} field must be at least {param} characters in length.'),
(540, 1, 'form_validation_required', 'The {field} field is required.'),
(541, 1, 'forward', 'Forward'),
(542, 1, 'free', 'Free'),
(543, 1, 'free_product', 'Free Product'),
(544, 1, 'free_promotion', 'Free Promotion'),
(545, 1, 'free_shipping', 'Free Shipping'),
(546, 1, 'frequency', 'Frequency'),
(547, 1, 'frequency_exp', 'This value indicates how frequently the content at a particular URL is likely to change '),
(548, 1, 'frequently_asked_questions', 'Frequently Asked Questions'),
(549, 1, 'friday', 'Friday'),
(550, 1, 'from', 'From:'),
(551, 1, 'full_name', 'Full Name'),
(552, 1, 'full_width', 'Full Width'),
(553, 1, 'general', 'General'),
(554, 1, 'general_information', 'General Information'),
(555, 1, 'general_settings', 'General Settings'),
(556, 1, 'generate', 'Generate'),
(557, 1, 'generate_sitemap', 'Generate Sitemap'),
(558, 1, 'global', 'Global'),
(559, 1, 'global_taxes', 'Global Taxes'),
(560, 1, 'global_taxes_exp', 'Define new taxes by country for all sales on your site'),
(561, 1, 'google_adsense_code', 'Google Adsense Code'),
(562, 1, 'google_analytics', 'Google Analytics Code'),
(563, 1, 'google_login', 'Google Login'),
(564, 1, 'google_recaptcha', 'Google reCAPTCHA'),
(565, 1, 'google_url', 'Google+ URL'),
(566, 1, 'goto_home', 'Go to the Homepage'),
(567, 1, 'go_back_to_products', 'Go Back to the Products Page'),
(568, 1, 'go_back_to_shop_settings', 'Go Back to the Shop Settings'),
(569, 1, 'go_to_your_product', 'Go to Your Product'),
(570, 1, 'grid_layout', 'Grid Layout'),
(571, 1, 'guest', 'Guest'),
(572, 1, 'guest_checkout', 'Guest Checkout'),
(573, 1, 'half_width', 'Half Width'),
(574, 1, 'have_account', 'Have an account?'),
(575, 1, 'header', 'Header'),
(576, 1, 'height', 'Height'),
(577, 1, 'help_center', 'Help Center'),
(578, 1, 'help_documents', 'Help Documents'),
(579, 1, 'help_documents_exp', 'You can use these documents to generate your CSV file\r\n'),
(580, 1, 'hi', 'Hi'),
(581, 1, 'hidden', 'Hidden'),
(582, 1, 'hidden_products', 'Hidden Products'),
(583, 1, 'hide', 'Hide'),
(584, 1, 'highest_price', 'Highest Price'),
(585, 1, 'highest_rating', 'Highest Rating'),
(586, 1, 'home', 'Home'),
(587, 1, 'homepage', 'Homepage'),
(588, 1, 'homepage_banners', 'Homepage Banners'),
(589, 1, 'homepage_banners_exp', 'You can manage the product banners on the homepage from this section'),
(590, 1, 'homepage_manager', 'Homepage Manager'),
(591, 1, 'homepage_title', 'Homepage Title'),
(592, 1, 'horizontal_alignment', 'Horizontal Alignment'),
(593, 1, 'hourly', 'Hourly'),
(594, 1, 'hours_ago', 'hours ago'),
(595, 1, 'hour_ago', 'hour ago'),
(596, 1, 'how_can_we_help', 'How can we help?'),
(597, 1, 'how_it_works', 'How It Works'),
(598, 1, 'iban', 'IBAN'),
(599, 1, 'iban_long', 'International Bank Account Number'),
(600, 1, 'id', 'Id'),
(601, 1, 'identity_number', 'Identity Number'),
(602, 1, 'if_review_already_added', 'If you have already added a review, your review will be updated.'),
(603, 1, 'image', 'Image'),
(604, 1, 'images', 'Images'),
(605, 1, 'image_file_format', 'Image File Format'),
(606, 1, 'image_file_format_exp', 'Uploaded images will be converted to the selected format'),
(607, 1, 'import_language', 'Import Language'),
(608, 1, 'inactivate_all', 'Inactivate All'),
(609, 1, 'inactive', 'Inactive'),
(610, 1, 'index_ad_space_1', 'Index Ad Space 1'),
(611, 1, 'index_ad_space_2', 'Index Ad Space 2'),
(612, 1, 'index_slider', 'Index Slider'),
(613, 1, 'input_explanation', 'Input Explanation'),
(614, 1, 'instagram_url', 'Instagram URL'),
(615, 1, 'instant_download', 'Instant download'),
(616, 1, 'invalid_attempt', 'Invalid Attempt!'),
(617, 1, 'invalid_file_type', 'Invalid file type!'),
(618, 1, 'invalid_withdrawal_amount', 'Invalid withdrawal amount!'),
(619, 1, 'invoice', 'Invoice'),
(620, 1, 'invoices', 'Invoices'),
(621, 1, 'invoice_currency_warning', 'All amounts shown on this invoice are in'),
(622, 1, 'in_stock', 'In Stock'),
(623, 1, 'ip_address', 'Ip Address'),
(624, 1, 'item', 'Item'),
(625, 1, 'iyzico', 'Iyzico'),
(626, 1, 'iyzico_warning', 'This is the \"Checkout Form\" integration, not the \"Marketplace\" integration.'),
(627, 1, 'january', 'January'),
(628, 1, 'joined_affiliate_program', 'You joined the affiliate program'),
(629, 1, 'join_newsletter', 'Join Our Newsletter'),
(630, 1, 'join_program', 'Join Program'),
(631, 1, 'json_language_file', 'JSON Language File'),
(632, 1, 'july', 'July'),
(633, 1, 'june', 'June'),
(634, 1, 'just_now', 'Just Now'),
(635, 1, 'keep_original_file_format', 'Keep Original File Format'),
(636, 1, 'keep_shopping', 'Keep Shopping'),
(637, 1, 'keyword', 'Keyword'),
(638, 1, 'keywords', 'Keywords'),
(639, 1, 'knowledge_base', 'Knowledge Base'),
(640, 1, 'label', 'Label'),
(641, 1, 'language', 'Language'),
(642, 1, 'languages', 'Languages'),
(643, 1, 'language_code', 'Language Code'),
(644, 1, 'language_name', 'Language Name'),
(645, 1, 'language_settings', 'Language Settings'),
(646, 1, 'last_modification', 'Last Modification'),
(647, 1, 'last_modification_exp', 'The time the URL was last modified'),
(648, 1, 'last_name', 'Last Name'),
(649, 1, 'last_seen', 'Last seen: '),
(650, 1, 'last_update', 'Last Update'),
(651, 1, 'latest_blog_posts', 'Latest Blog Posts'),
(652, 1, 'latest_comments', 'Latest Comments'),
(653, 1, 'latest_members', 'Latest Members'),
(654, 1, 'latest_orders', 'Latest Orders'),
(655, 1, 'latest_pending_products', 'Latest Pending Products'),
(656, 1, 'latest_posts', 'Latest Posts'),
(657, 1, 'latest_products', 'Latest Products'),
(658, 1, 'latest_reviews', 'Latest Reviews'),
(659, 1, 'latest_sales', 'Latest Sales'),
(660, 1, 'latest_transactions', 'Latest Transactions'),
(661, 1, 'left', 'Left'),
(662, 1, 'left_to_right', 'Left to Right (LTR)'),
(663, 1, 'license_certificate', 'License Certificate'),
(664, 1, 'license_key', 'License Key'),
(665, 1, 'license_keys', 'License Keys'),
(666, 1, 'license_keys_system_exp', 'Add all your license keys from here. The system will automatically give a license key to each buyer.'),
(667, 1, 'link', 'Link'),
(668, 1, 'linkedin_url', 'Linkedin URL'),
(669, 1, 'listing_type', 'Listing Type'),
(670, 1, 'live_preview', 'Live Preview'),
(671, 1, 'load_more', 'Load More'),
(672, 1, 'load_more_comments', 'Load more comments'),
(673, 1, 'load_more_reviews', 'Load more reviews'),
(674, 1, 'local_pickup', 'Local Pickup'),
(675, 1, 'local_storage', 'Local Storage'),
(676, 1, 'location', 'Location'),
(677, 1, 'login', 'Login'),
(678, 1, 'login_error', 'Wrong email or password!'),
(679, 1, 'login_to_user_account_exp', 'Your current session will be terminated and a new session will be created for the account of the user you selected.'),
(680, 1, 'login_with_email', 'Or login with email'),
(681, 1, 'logo', 'Logo'),
(682, 1, 'logout', 'Logout'),
(683, 1, 'logo_email', 'Logo Email'),
(684, 1, 'logo_size', 'Logo Size'),
(685, 1, 'lowest_price', 'Lowest Price'),
(686, 1, 'mail', 'Mail'),
(687, 1, 'mailjet_email_address', 'Mailjet Email Address'),
(688, 1, 'mailjet_email_address_exp', 'The address you created your Mailjet account with'),
(689, 1, 'mail_host', 'Mail Host'),
(690, 1, 'mail_password', 'Mail Password'),
(691, 1, 'mail_port', 'Mail Port'),
(692, 1, 'mail_protocol', 'Mail Protocol'),
(693, 1, 'mail_service', 'Mail Service'),
(694, 1, 'mail_title', 'Mail Title'),
(695, 1, 'mail_username', 'Mail Username'),
(696, 1, 'main', 'main'),
(697, 1, 'maintenance_mode', 'Maintenance Mode'),
(698, 1, 'main_files', 'Main File(s)'),
(699, 1, 'main_menu', 'Main Menu'),
(700, 1, 'management_tools', 'Management Tools'),
(701, 1, 'march', 'March'),
(702, 1, 'marketplace', 'Marketplace'),
(703, 1, 'marketplace_selling_product_on_the_site', 'Marketplace (Selling Products on the Site)'),
(704, 1, 'max', 'Max'),
(705, 1, 'max_file_size', 'Max File Size'),
(706, 1, 'may', 'May'),
(707, 1, 'member', 'Member'),
(708, 1, 'members', 'Members'),
(709, 1, 'membership', 'Membership'),
(710, 1, 'membership_number_of_ads', 'Number of Active Ads'),
(711, 1, 'membership_payments', 'Membership Payments'),
(712, 1, 'membership_plan', 'Membership Plan'),
(713, 1, 'membership_plans', 'Membership Plans'),
(714, 1, 'membership_plan_payment', 'Membership Plan Payment'),
(715, 1, 'member_since', 'Member since'),
(716, 1, 'menu_limit', 'Menu Limit'),
(717, 1, 'message', 'Message'),
(718, 1, 'messages', 'Messages'),
(719, 1, 'meta_tag', 'Meta Tag'),
(720, 1, 'method_name', 'Method Name'),
(721, 1, 'mgs_reject_open_shop', 'Your request to open a store has been rejected!'),
(722, 1, 'mgs_reject_open_shop_permanently', 'Your request to open a store has been permanently rejected!'),
(723, 1, 'min', 'Min'),
(724, 1, 'minimum_order_amount', 'Minimum order amount'),
(725, 1, 'minutes_ago', 'minutes ago'),
(726, 1, 'minute_ago', 'minute ago'),
(727, 1, 'min_poyout_amount', 'Minimum payout amount'),
(728, 1, 'min_poyout_amounts', 'Minimum Payout Amounts'),
(729, 1, 'mode', 'Mode'),
(730, 1, 'monday', 'Monday'),
(731, 1, 'month', 'Month'),
(732, 1, 'monthly', 'Monthly'),
(733, 1, 'monthly_plan', 'Monthly Plan'),
(734, 1, 'monthly_sales', 'Monthly sales'),
(735, 1, 'months_ago', 'months ago'),
(736, 1, 'month_ago', 'month ago'),
(737, 1, 'month_count', 'Number of Months'),
(738, 1, 'more', 'More'),
(739, 1, 'more_from', 'More from'),
(740, 1, 'most_recent', 'Most Recent'),
(741, 1, 'most_viewed_products', 'Most Viewed Products'),
(742, 1, 'msg_accept_terms', 'You have to accept the terms!'),
(743, 1, 'msg_added', 'Item successfully added!'),
(744, 1, 'msg_add_license_keys', 'License keys successfully added!'),
(745, 1, 'msg_add_product_success', 'Your payment has been successfully completed! Once your product is approved, it will be published on our site!'),
(746, 1, 'msg_administrator_added', 'Administrator successfully added!'),
(747, 1, 'msg_bank_transfer_text', 'Once you have placed your order, you can make your payment to one of these bank accounts. Please add your order number to your payment description.'),
(748, 1, 'msg_bank_transfer_text_order_completed', 'You can make your payment to one of these bank accounts. Please add your order number to your payment description.'),
(749, 1, 'msg_bank_transfer_text_transaction_completed', 'You can make your payment to one of these bank accounts. Please add your transaction number to your payment description.'),
(750, 1, 'msg_ban_error', 'Your account has been suspended!'),
(751, 1, 'msg_cart_select_location', 'Please select your location to proceed with your purchase.'),
(752, 1, 'msg_cart_shipping', 'Please enter your shipping address and choose a shipping method!'),
(753, 1, 'msg_change_password_error', 'There was a problem changing your password!'),
(754, 1, 'msg_change_password_success', 'Your password has been successfully changed!'),
(755, 1, 'msg_comment_approved', 'Comment successfully approved!'),
(756, 1, 'msg_comment_deleted', 'Comment successfully deleted!'),
(757, 1, 'msg_comment_sent_successfully', 'Your comment has been sent. It will be published after being reviewed by the site management.'),
(758, 1, 'msg_complete_payment', 'Please click the button below to complete the payment.'),
(759, 1, 'msg_confirmation_email', 'Please click on the button below to confirm your account.'),
(760, 1, 'msg_confirmed', 'Your email address has been successfully confirmed!'),
(761, 1, 'msg_confirmed_required', 'In order to login to the site, you must confirm your email address.'),
(762, 1, 'msg_contact_error', 'There was a problem sending your message!'),
(763, 1, 'msg_contact_success', 'Your message has been successfully sent!'),
(764, 1, 'msg_coupon_auth', 'This coupon is for registered members only!'),
(765, 1, 'msg_coupon_cart_total', 'Your cart total is not enough to use this coupon. Minimum cart total:'),
(766, 1, 'msg_coupon_code_added_before', 'This coupon code has already been added before. Please add another coupon code.'),
(767, 1, 'msg_coupon_limit', 'Coupon usage limit has been reached!'),
(768, 1, 'msg_coupon_used', 'This coupon code has been used before!'),
(769, 1, 'msg_cron_sitemap', 'With this URL you can automatically update your sitemap.'),
(770, 1, 'msg_default_language_delete', 'Default language cannot be deleted!'),
(771, 1, 'msg_default_page_delete', 'Default pages cannot be deleted!'),
(772, 1, 'msg_deleted', 'Item successfully deleted!'),
(773, 1, 'msg_delete_posts', 'Please delete posts belonging to this category first!'),
(774, 1, 'msg_delete_subcategories', 'Please delete subcategories belonging to this category first!'),
(775, 1, 'msg_digital_product_register_error', 'You must create an account to purchase a digital product.'),
(776, 1, 'msg_dont_have_downloadable_files', 'You don\'t have any downloadable files.'),
(777, 1, 'msg_email_sent', 'Email successfully sent!'),
(778, 1, 'msg_email_unique_error', 'The email has already been taken.'),
(779, 1, 'msg_error', 'An error occurred please try again!'),
(780, 1, 'msg_error_product_type', 'You must enable at least one product type'),
(781, 1, 'msg_error_selected_system', 'You must enable at least one system'),
(782, 1, 'msg_error_sku', 'This SKU is used for your another product!'),
(783, 1, 'msg_expired_plan', 'When your plan expires, if you do not renew your plan within 3 days, your ads will be added to the \"Expired Products\" section and will not be displayed on the site.'),
(784, 1, 'msg_insufficient_balance', 'Insufficient balance!'),
(785, 1, 'msg_invalid_coupon', 'This coupon code is invalid or has expired!'),
(786, 1, 'msg_invalid_email', 'Invalid email address!'),
(787, 1, 'msg_membership_activated', 'Your membership plan has been successfully activated!'),
(788, 1, 'msg_membership_renewed', 'Your membership plan has been successfully renewed!'),
(789, 1, 'msg_message_deleted', 'Message successfully deleted!'),
(790, 1, 'msg_message_sent', 'Your message has been successfully sent!'),
(791, 1, 'msg_message_sent_error', 'You cannot send message to yourself!'),
(792, 1, 'msg_newsletter_error', 'Your email address is already registered!'),
(793, 1, 'msg_newsletter_success', 'Your email address has been successfully added!'),
(794, 1, 'msg_no_created_variations', 'You have no created variations.'),
(795, 1, 'msg_option_exists', 'This option already exists!'),
(796, 1, 'msg_order_completed', 'Your order has been successfully completed!'),
(797, 1, 'msg_payment_completed', 'Payment completed successfully!'),
(798, 1, 'msg_payment_database_error', 'Your payment has been successfully completed, but there was a problem with adding the order to the database! Please contact our site management for this order!'),
(799, 1, 'msg_payment_error', 'An error occurred during the payment!'),
(800, 1, 'msg_payment_success', 'Your payment has been successfully completed!'),
(801, 1, 'msg_payout_bitcoin_address_error', 'You must enter your BTC address to make this payment request'),
(802, 1, 'msg_payout_paypal_error', 'You must enter your PayPal email address to make this payment request'),
(803, 1, 'msg_plan_expired', 'Your membership plan has expired!'),
(804, 1, 'msg_product_already_purchased', 'You have already purchased this product before.'),
(805, 1, 'msg_product_approved', 'Product successfully approved!'),
(806, 1, 'msg_product_slug_used', 'This slug is used by another product!'),
(807, 1, 'msg_promote_bank_transfer_text', 'Once you have placed your order, you can make your payment to one of these bank accounts. Please add your transaction number to your payment description.'),
(808, 1, 'msg_quote_request_error', 'You cannot request a quote for your own item!'),
(809, 1, 'msg_quote_request_sent', 'Your request has been successfully submitted.'),
(810, 1, 'msg_reached_ads_limit', 'You have reached your ad adding limit! If you want to add more ads, you can upgrade your current plan by clicking the button below.'),
(811, 1, 'msg_recaptcha', 'Please confirm that you are not a robot!'),
(812, 1, 'msg_refund_request_email', 'You have received a refund request. Please click the button below to see the details.'),
(813, 1, 'msg_refund_request_update_email', 'There is an update for your refund request. Please click the button below to see the details.'),
(814, 1, 'msg_register_success', 'Your account has been created successfully!'),
(815, 1, 'msg_request_received', 'Your request has been received!'),
(816, 1, 'msg_request_sent', 'The request has been sent successfully!'),
(817, 1, 'msg_reset_cache', 'All cache files have been deleted!'),
(818, 1, 'msg_reset_password_error', 'We can\'t find a user with that e-mail address!'),
(819, 1, 'msg_reset_password_success', 'We\'ve sent an email for resetting your password to your email address. Please check your email for next steps.'),
(820, 1, 'msg_review_added', 'Your review has been successfully added!'),
(821, 1, 'msg_review_deleted', 'Review successfully deleted!'),
(822, 1, 'msg_send_confirmation_email', 'An activation email has been sent to your email address. Please confirm your account.'),
(823, 1, 'msg_shop_name_unique_error', 'The shop name has already been taken.'),
(824, 1, 'msg_shop_opening_requests', 'Your request to open a store is under evaluation!'),
(825, 1, 'msg_sitemap_updated', 'Sitemap successfully updated!'),
(826, 1, 'msg_slug_unique_error', 'The slug has already been taken.'),
(827, 1, 'msg_start_selling', 'We have received your request. Your store will be open when your request is approved.'),
(828, 1, 'msg_subscriber_deleted', 'Subscriber successfully deleted!'),
(829, 1, 'msg_support_message_received', 'Your Support Message has been Received'),
(830, 1, 'msg_support_message_received_exp', 'Thank you for reaching out to us. We have received your support message and will get back to you shortly.'),
(831, 1, 'msg_support_message_replied', 'Your Support Ticket Has Been Replied'),
(832, 1, 'msg_support_message_replied_exp', 'Please click the button below to view the ticket details.'),
(833, 1, 'msg_support_new_message', 'New Support Message'),
(834, 1, 'msg_unsubscribe', 'You will no longer receive emails from us!'),
(835, 1, 'msg_updated', 'Changes successfully saved!'),
(836, 1, 'msg_username_unique_error', 'The username has already been taken.'),
(837, 1, 'msg_vendor_membership_plan_expired', 'Your membership plan has expired, so your products will no longer be published on the site. If you would like your products to continue being published on the site, please renew your membership plan.'),
(838, 1, 'msg_wrong_old_password', 'Wrong old password!'),
(839, 1, 'multilingual_system', 'Multilingual System'),
(840, 1, 'multiple_sale', 'Multiple Sale'),
(841, 1, 'multiple_sale_option_1', 'Yes, I want to sell this product to more than one customer'),
(842, 1, 'multiple_sale_option_2', 'No, I want to sell this product to a single customer'),
(843, 1, 'multi_vendor_system', 'Multi-Vendor System'),
(844, 1, 'multi_vendor_system_exp', 'If you disable it, only Admin can add product.'),
(845, 1, 'my_account', 'My Account'),
(846, 1, 'my_cart', 'My Cart'),
(847, 1, 'my_coupons', 'My Coupons'),
(848, 1, 'my_reviews', 'My Reviews'),
(849, 1, 'name', 'Name'),
(850, 1, 'name_on_the_card', 'Name on the Card'),
(851, 1, 'navigation', 'Navigation'),
(852, 1, 'navigation_template', 'Navigation Template'),
(853, 1, 'need_more_help', 'Need more help?'),
(854, 1, 'never', 'Never'),
(855, 1, 'new', 'New'),
(856, 1, 'newsletter', 'Newsletter'),
(857, 1, 'newsletter_desc', 'Join our subscribers list to get the latest news, updates and special offers directly in your inbox'),
(858, 1, 'newsletter_popup', 'Newsletter Popup'),
(859, 1, 'newsletter_send_many_exp', 'Some servers do not allow mass mailing. Therefore, instead of sending your mails to all subscribers at once, you can send them part by part (Example: 50 subscribers at once). If your mail server stops sending mail, the sending process will also stop.'),
(860, 1, 'new_arrivals', 'New Arrivals'),
(861, 1, 'new_message', 'New'),
(862, 1, 'new_password', 'New Password'),
(863, 1, 'new_payout_request', 'New Payout Request'),
(864, 1, 'new_quote_request', 'New Quote Request'),
(865, 1, 'next', 'Next'),
(866, 1, 'no', 'No'),
(867, 1, 'none', 'None'),
(868, 1, 'not_added_shipping_address', 'You have not added a shipping address yet.'),
(869, 1, 'not_added_vendor_balance', 'Not Added to Vendor Balance'),
(870, 1, 'november', 'November'),
(871, 1, 'no_comments_found', 'No comments found for this product. Be the first to comment!'),
(872, 1, 'no_delivery_is_made_to_address', 'No delivery is made to the address you have chosen.'),
(873, 1, 'no_delivery_this_location', 'No delivery to this location'),
(874, 1, 'no_discount', 'No Discount'),
(875, 1, 'no_members_found', 'No members found!'),
(876, 1, 'no_messages_found', 'No messages found!'),
(877, 1, 'no_products_found', 'No products found!'),
(878, 1, 'no_records_found', 'No records found!'),
(879, 1, 'no_results_found', 'No Results Found!'),
(880, 1, 'no_reviews_found', 'No reviews found!'),
(881, 1, 'no_vat', 'No VAT'),
(882, 1, 'number', 'Number'),
(883, 1, 'number_featured_products', 'Number of Featured Products to Show'),
(884, 1, 'number_latest_products', 'Number of Latest Products to Show'),
(885, 1, 'number_of_ads', 'Number of Ads'),
(886, 1, 'number_of_coupons', 'Number of Coupons'),
(887, 1, 'number_of_coupons_exp', 'How many times a coupon can be used by all customers before being invalid'),
(888, 1, 'number_of_days', 'Number of Days'),
(889, 1, 'number_of_entries', 'Number of Entries'),
(890, 1, 'number_of_links_in_menu', 'The number of links that appear in the menu'),
(891, 1, 'number_of_results', 'Number of Results'),
(892, 1, 'number_of_total_sales', 'Number of total sales'),
(893, 1, 'number_remaining_ads', 'Number of Remaining Ads'),
(894, 1, 'number_short_billion', 'b'),
(895, 1, 'number_short_million', 'm');
INSERT INTO `language_translations` (`id`, `lang_id`, `label`, `translation`) VALUES
(896, 1, 'number_short_thousand', 'k'),
(897, 1, 'num_articles', '{field} Articles'),
(898, 1, 'october', 'October'),
(899, 1, 'offline', 'Offline'),
(900, 1, 'ok', 'OK'),
(901, 1, 'old_password', 'Old Password'),
(902, 1, 'online', 'Online'),
(903, 1, 'open', 'Open'),
(904, 1, 'open_user_shop', 'Open User Shop'),
(905, 1, 'option', 'Option'),
(906, 1, 'optional', 'Optional'),
(907, 1, 'options', 'Options'),
(908, 1, 'option_display_type', 'Option Display Type'),
(909, 1, 'option_name', 'Option Name'),
(910, 1, 'order', 'Order'),
(911, 1, 'orders', 'Orders'),
(912, 1, 'order_details', 'Order Details'),
(913, 1, 'order_has_been_shipped', 'The order has been shipped!'),
(914, 1, 'order_id', 'Order Id'),
(915, 1, 'order_information', 'Order Information'),
(916, 1, 'order_not_yet_shipped', 'The order has not yet been shipped.'),
(917, 1, 'order_number', 'Order Number'),
(918, 1, 'order_processing', 'Processing'),
(919, 1, 'order_summary', 'Order Summary'),
(920, 1, 'ordinary_listing', 'Ordinary Listing'),
(921, 1, 'out_of_stock', 'Out of Stock'),
(922, 1, 'pages', 'Pages'),
(923, 1, 'page_not_found', 'Page not found'),
(924, 1, 'page_not_found_sub', 'The page you are looking for doesn\'t exist.'),
(925, 1, 'page_type', 'Page Type'),
(926, 1, 'page_views', 'Page Views'),
(927, 1, 'pagination_product', 'Pagination (Number of products on each page)'),
(928, 1, 'pagseguro', 'PagSeguro'),
(929, 1, 'paid', 'Paid'),
(930, 1, 'panel', 'Panel'),
(931, 1, 'parent', 'Parent'),
(932, 1, 'parent_category', 'Parent Category'),
(933, 1, 'parent_option', 'Parent Option'),
(934, 1, 'parent_variation', 'Parent Variation'),
(935, 1, 'password', 'Password'),
(936, 1, 'password_confirm', 'Confirm Password'),
(937, 1, 'password_reset', 'Password Reset'),
(938, 1, 'paste_ad_code', 'Paste Ad Code'),
(939, 1, 'paste_ad_url', 'Paste Ad URL'),
(940, 1, 'pause', 'Pause'),
(941, 1, 'pay', 'Pay'),
(942, 1, 'payer_email', 'Payer Email'),
(943, 1, 'paying_wallet_balance', 'Paying with Wallet Balance'),
(944, 1, 'payment', 'Payment'),
(945, 1, 'payments', 'Payments'),
(946, 1, 'payment_amount', 'Payment Amount'),
(947, 1, 'payment_cancelled', 'Payment has been cancelled!'),
(948, 1, 'payment_details', 'Payment Details'),
(949, 1, 'payment_id', 'Payment Id'),
(950, 1, 'payment_method', 'Payment Method'),
(951, 1, 'payment_note', 'Payment Note'),
(952, 1, 'payment_received', 'Payment Received'),
(953, 1, 'payment_settings', 'Payment Settings'),
(954, 1, 'payment_status', 'Payment Status'),
(955, 1, 'payouts', 'Payouts'),
(956, 1, 'payout_requests', 'Payout Requests'),
(957, 1, 'payout_settings', 'Payout Settings'),
(958, 1, 'paypal', 'PayPal'),
(959, 1, 'paypal_email_address', 'PayPal Email Address'),
(960, 1, 'paystack', 'PayStack'),
(961, 1, 'pay_now', 'Pay Now'),
(962, 1, 'pay_wallet_balance_exp', 'Pay with your wallet balance'),
(963, 1, 'pay_wallet_balance_warning', 'The order amount will be deducted from your wallet balance. If you approve, please click the button below to complete the purchase.'),
(964, 1, 'pending', 'Pending'),
(965, 1, 'pending_comments', 'Pending Comments'),
(966, 1, 'pending_payment', 'Pending Payment'),
(967, 1, 'pending_products', 'Pending Products'),
(968, 1, 'pending_quote', 'Pending Quote'),
(969, 1, 'permanently_rejected', 'Permanently Rejected'),
(970, 1, 'permissions', 'Permissions'),
(971, 1, 'personal_website_url', 'Personal Website URL'),
(972, 1, 'phone', 'Phone'),
(973, 1, 'phone_number', 'Phone Number'),
(974, 1, 'physical', 'Physical'),
(975, 1, 'physical_exp', 'A tangible product that you will ship to buyers'),
(976, 1, 'physical_products', 'Physical Products'),
(977, 1, 'pinterest_url', 'Pinterest URL'),
(978, 1, 'place_order', 'Place Order'),
(979, 1, 'plan_expiration_date', 'Plan Expiration Date'),
(980, 1, 'play', 'Play'),
(981, 1, 'please_wait', 'Please wait...'),
(982, 1, 'popular', 'Popular'),
(983, 1, 'postal_code', 'Postal Code'),
(984, 1, 'postcode', 'Postcode'),
(985, 1, 'posts', 'Posts'),
(986, 1, 'post_comment', 'Post Comment'),
(987, 1, 'preferences', 'Preferences'),
(988, 1, 'preview', 'Preview'),
(989, 1, 'price', 'Price'),
(990, 1, 'price_per_day', 'Price Per Day'),
(991, 1, 'price_per_month', 'Price Per Month'),
(992, 1, 'pricing', 'Pricing'),
(993, 1, 'primary', 'Primary'),
(994, 1, 'print', 'Print'),
(995, 1, 'priority', 'Priority'),
(996, 1, 'priority_exp', 'The priority of a particular URL relative to other pages on the same site'),
(997, 1, 'priority_none', 'Automatically Calculated Priority'),
(998, 1, 'processing', 'Processing...'),
(999, 1, 'product', 'Product'),
(1000, 1, 'production', 'Production'),
(1001, 1, 'products', 'Products'),
(1002, 1, 'products_ad_space', 'Products Ad Space'),
(1003, 1, 'products_by_category', 'Products by Category'),
(1004, 1, 'products_by_category_exp', 'Show products by categories on the homepage'),
(1005, 1, 'products_sent_different_stores', 'Your products will be sent by different stores.'),
(1006, 1, 'product_added', 'Product added successfully!'),
(1007, 1, 'product_added_to_cart', 'Product successfully added to your cart!'),
(1008, 1, 'product_ad_space', 'Product Ad Space'),
(1009, 1, 'product_approval_edited_products', 'Product Approval for Edited Products'),
(1010, 1, 'product_approval_new_products', 'Product Approval for New Products'),
(1011, 1, 'product_approve_published', 'Once it is approved, it will be published on the site.'),
(1012, 1, 'product_based_vat', 'Product Based VAT'),
(1013, 1, 'product_cart_summary', 'Product cart summary'),
(1014, 1, 'product_code', 'Product Code'),
(1015, 1, 'product_comments', 'Product Comments'),
(1016, 1, 'product_details', 'Product Details'),
(1017, 1, 'product_does_not_ship_location', 'This product does not ship to this location.\r\n'),
(1018, 1, 'product_id', 'Product Id'),
(1019, 1, 'product_id_not_defined', 'Product ID is not defined.'),
(1020, 1, 'product_image_upload', 'Product Image Upload'),
(1021, 1, 'product_image_upload_limit', 'Product Image Upload Limit'),
(1022, 1, 'product_link_structure', 'Product Link Structure'),
(1023, 1, 'product_location', 'Product Location'),
(1024, 1, 'product_location_exp', 'Optional product location. Your shop location will be displayed if you do not add a location for your product'),
(1025, 1, 'product_location_system', 'Product Location System'),
(1026, 1, 'product_or_seller_profile_url', 'Product or seller profile URL'),
(1027, 1, 'product_price', 'Product Price'),
(1028, 1, 'product_promoting_payment', 'Product Promotion Payment'),
(1029, 1, 'product_promoting_payment_exp', 'Product Promotion Payment'),
(1030, 1, 'product_promotion', 'Product Promotion'),
(1031, 1, 'product_search_listing', 'Product Search & Listing'),
(1032, 1, 'product_settings', 'Product Settings'),
(1033, 1, 'product_type', 'Product Type'),
(1034, 1, 'product_url', 'Product URL'),
(1035, 1, 'profile', 'Profile'),
(1036, 1, 'profile_id', 'Profile Id'),
(1037, 1, 'profile_settings', 'Profile Settings'),
(1038, 1, 'program_type', 'Program Type'),
(1039, 1, 'promote', 'Promote'),
(1040, 1, 'promote_plan', 'Promote Plan'),
(1041, 1, 'promote_your_product', 'Promote Your Product'),
(1042, 1, 'promotion_payments', 'Promotion Payments'),
(1043, 1, 'public_coupon', 'Public Coupon'),
(1044, 1, 'public_coupon_exp', 'Public coupons are visible to all users'),
(1045, 1, 'public_key', 'Public Key'),
(1046, 1, 'publishable_key', 'Publishable Key'),
(1047, 1, 'purchase', 'Purchase'),
(1048, 1, 'purchased_plan', 'Purchased Plan'),
(1049, 1, 'purchase_code', 'Purchase Code'),
(1050, 1, 'pwa', 'Progressive Web App (PWA)'),
(1051, 1, 'pwa_logo', 'PWA Logo'),
(1052, 1, 'pwa_warning', 'If you enable PWA option, read \'Progressive Web App (PWA)\' section from the documentation to make the necessary settings.'),
(1053, 1, 'quantity', 'Quantity'),
(1054, 1, 'question', 'Question'),
(1055, 1, 'quote', 'Quote'),
(1056, 1, 'quote_request', 'Quote Request'),
(1057, 1, 'quote_requests', 'Quote Requests'),
(1058, 1, 'radio_button', 'Radio Button (Single Selection)'),
(1059, 1, 'rate_this_product', 'Rate this product'),
(1060, 1, 'reason', 'Reason'),
(1061, 1, 'receipt', 'Receipt'),
(1062, 1, 'received_quote_requests', 'Received Quote Requests'),
(1063, 1, 'receiver', 'Receiver'),
(1064, 1, 'recent_chats', 'Recent Chats'),
(1065, 1, 'reference_code', 'Reference Code'),
(1066, 1, 'referral_discount', 'Referral Discount'),
(1067, 1, 'referral_earnings', 'Referral Earnings'),
(1068, 1, 'referrer_commission', 'Referrer Commission'),
(1069, 1, 'referrer_commission_rate', 'Referrer Commission Rate'),
(1070, 1, 'refresh_cache_database_changes', 'Refresh Cache Files When Database Changes'),
(1071, 1, 'refund', 'Refund'),
(1072, 1, 'refund_admin_complete_exp', 'To complete a refund request, you must return the buyer\'s money. If you click the \"Approve Refund\" button, the system will change the order status to \"Refund Approved\" and deduct the order amount from the seller\'s balance.'),
(1073, 1, 'refund_approved', 'Refund Approved'),
(1074, 1, 'refund_approved_exp', 'Your refund request has been approved by the seller. The total amount for this product will be refunded to you.'),
(1075, 1, 'refund_declined_exp', 'Your refund request has been declined by the seller. If you want to raise a dispute, you can contact the site management.'),
(1076, 1, 'refund_reason_explain', 'Why do you want a refund? Explain in detail.'),
(1077, 1, 'refund_request', 'Refund Request'),
(1078, 1, 'refund_requests', 'Refund Requests'),
(1079, 1, 'refund_system', 'Refund System'),
(1080, 1, 'region', 'Region'),
(1081, 1, 'regions', 'Regions'),
(1082, 1, 'register', 'Register'),
(1083, 1, 'register_with_email', 'Or register with email'),
(1084, 1, 'regular', 'Regular'),
(1085, 1, 'regular_listing', 'Regular Listing'),
(1086, 1, 'reject', 'Reject'),
(1087, 1, 'rejected', 'Rejected'),
(1088, 1, 'rejected_quote', 'Rejected Quote'),
(1089, 1, 'reject_permanently', 'Reject Permanently'),
(1090, 1, 'reject_quote', 'Reject Quote'),
(1091, 1, 'related_help_topics', 'Related Help Topics'),
(1092, 1, 'related_posts', 'Related Posts'),
(1093, 1, 'remaining_days', 'Remaining Days'),
(1094, 1, 'remove', 'Remove'),
(1095, 1, 'removed_from_affiliate_program', 'You have been removed from the affiliate program.'),
(1096, 1, 'remove_from_featured', 'Remove from Featured'),
(1097, 1, 'remove_from_product_filters', 'Remove from Product Filters'),
(1098, 1, 'remove_from_special_offers', 'Remove from Special Offers'),
(1099, 1, 'remove_from_wishlist', 'Remove from wishlist'),
(1100, 1, 'remove_user_ban', 'Remove User Ban'),
(1101, 1, 'renew_your_plan', 'Renew Your Plan'),
(1102, 1, 'reply', 'Reply'),
(1103, 1, 'reply_to', 'Reply to'),
(1104, 1, 'report', 'Report'),
(1105, 1, 'reported_content', 'Reported Content'),
(1106, 1, 'report_bank_transfer', 'Report Bank Transfer'),
(1107, 1, 'report_comment', 'Report Comment'),
(1108, 1, 'report_review', 'Report Review'),
(1109, 1, 'report_this_product', 'Report this product'),
(1110, 1, 'report_this_seller', 'Report this seller'),
(1111, 1, 'report_type', 'Report Type'),
(1112, 1, 'request_a_quote', 'Request a Quote'),
(1113, 1, 'request_documents_vendors', 'Request Documents from Vendors to Open a Store'),
(1114, 1, 'required', 'Required'),
(1115, 1, 'required_files', 'Required Files'),
(1116, 1, 'resend_activation_email', 'Resend Activation Email'),
(1117, 1, 'reset', 'Reset'),
(1118, 1, 'reset_cache', 'Reset Cache'),
(1119, 1, 'reset_filters', 'Reset Filters'),
(1120, 1, 'reset_location', 'Reset Location'),
(1121, 1, 'reset_password', 'Reset Password'),
(1122, 1, 'reset_password_subtitle', 'Enter your email address'),
(1123, 1, 'responded', 'Responded'),
(1124, 1, 'restore', 'Restore'),
(1125, 1, 'return_to_cart', 'Return to cart'),
(1126, 1, 'review', 'Review'),
(1127, 1, 'reviews', 'Reviews'),
(1128, 1, 'right', 'Right'),
(1129, 1, 'right_to_left', 'Right to Left (RTL)'),
(1130, 1, 'role', 'Role'),
(1131, 1, 'roles', 'Roles'),
(1132, 1, 'roles_permissions', 'Roles & Permissions'),
(1133, 1, 'role_name', 'Role Name'),
(1134, 1, 'round_boxes', 'Round Boxes'),
(1135, 1, 'route_settings', 'Route Settings'),
(1136, 1, 'route_settings_warning', 'You cannot use special characters in routes. If your language contains special characters, please be careful when editing routes. If you enter an invalid route, you will not be able to access the related page.'),
(1137, 1, 'row_width', 'Row Width'),
(1138, 1, 'rss_feeds', 'RSS Feeds'),
(1139, 1, 'rss_system', 'RSS System'),
(1140, 1, 'sale', 'Sale'),
(1141, 1, 'sales', 'Sales'),
(1142, 1, 'sales_number', 'Sales'),
(1143, 1, 'sale_id', 'Sale Id'),
(1144, 1, 'sandbox', 'Sandbox'),
(1145, 1, 'saturday', 'Saturday'),
(1146, 1, 'save_and_continue', 'Save and Continue'),
(1147, 1, 'save_as_draft', 'Save as Draft'),
(1148, 1, 'save_changes', 'Save Changes'),
(1149, 1, 'search', 'Search'),
(1150, 1, 'search_by_location', 'Search by Location'),
(1151, 1, 'search_products_categories_brands', 'Search for products, categories or brands'),
(1152, 1, 'search_results', 'Search Results'),
(1153, 1, 'secret_key', 'Secret Key'),
(1154, 1, 'secure_key', 'Secure Key'),
(1155, 1, 'see_details', 'See Details'),
(1156, 1, 'see_more', 'See more'),
(1157, 1, 'see_order_details', 'See Order Details'),
(1158, 1, 'see_products', 'See Products'),
(1159, 1, 'select', 'Select'),
(1160, 1, 'select_ad_space', 'Select Ad Space'),
(1161, 1, 'select_all', 'Select All'),
(1162, 1, 'select_category', 'Select Category'),
(1163, 1, 'select_chat_start_messaging', 'Select a chat to start messaging'),
(1164, 1, 'select_country', 'Select Country'),
(1165, 1, 'select_existing_variation', 'Select an Existing Variation'),
(1166, 1, 'select_favicon', 'Select Favicon'),
(1167, 1, 'select_file', 'Select File'),
(1168, 1, 'select_for_coupon', 'Select for Coupon'),
(1169, 1, 'select_image', 'Select Image'),
(1170, 1, 'select_language', 'Select Language'),
(1171, 1, 'select_location', 'Select Location'),
(1172, 1, 'select_logo', 'Select Logo'),
(1173, 1, 'select_option', 'Select an option'),
(1174, 1, 'select_payment_option', 'Select Payment Option'),
(1175, 1, 'select_products', 'Select Products'),
(1176, 1, 'select_region', 'Select Region'),
(1177, 1, 'select_your_location', 'Select Your Location'),
(1178, 1, 'select_your_plan', 'Select Your Plan'),
(1179, 1, 'select_your_plan_exp', 'Select your membership plan to continue'),
(1180, 1, 'seller', 'Seller'),
(1181, 1, 'sellers_bid', 'Seller\'s Bid'),
(1182, 1, 'seller_balances', 'Seller Balances'),
(1183, 1, 'seller_does_not_ship_to_address', 'This seller does not ship to the address you have chosen. You can continue by removing the products of this seller from your cart.'),
(1184, 1, 'selling_license_keys', 'Selling License Keys'),
(1185, 1, 'selling_on_the_site', 'Selling on the Site'),
(1186, 1, 'sell_my_product_on_site', 'Sell product on the site'),
(1187, 1, 'sell_now', 'Sell Now'),
(1188, 1, 'send', 'Send'),
(1189, 1, 'sender', 'Sender'),
(1190, 1, 'send_email', 'Send Email'),
(1191, 1, 'send_email_subscribers', 'Send Email to Subscribers'),
(1192, 1, 'send_email_to_buyer', 'Send Email to Buyer'),
(1193, 1, 'send_message', 'Send Message'),
(1194, 1, 'send_test_email', 'Send Test Email'),
(1195, 1, 'send_test_email_exp', 'You can send a test mail to check if your mail server is working.'),
(1196, 1, 'sent_by', 'Sent By'),
(1197, 1, 'seo', 'SEO'),
(1198, 1, 'seo_tools', 'SEO Tools'),
(1199, 1, 'september', 'September'),
(1200, 1, 'server_key', 'Server Key'),
(1201, 1, 'server_response', 'Server\'s Response'),
(1202, 1, 'settings', 'Settings'),
(1203, 1, 'settings_language', 'Settings Language'),
(1204, 1, 'set_as_default', 'Set as Default'),
(1205, 1, 'set_fixed_vat_rate_all_countries', 'Set Fixed VAT Rate for All Countries'),
(1206, 1, 'set_payout_account', 'Set Payout Account'),
(1207, 1, 'share', 'Share'),
(1208, 1, 'shipped', 'Shipped'),
(1209, 1, 'shipped_product', 'Shipped Product'),
(1210, 1, 'shipping', 'Shipping'),
(1211, 1, 'shipping_address', 'Shipping Address'),
(1212, 1, 'shipping_class', 'Shipping Class'),
(1213, 1, 'shipping_classes', 'Shipping Classes'),
(1214, 1, 'shipping_classes_exp', 'Shipping classes allow you to define different shipping costs for your products. If you have products with high shipping costs (large in weight and size), you can add a class from here and set a different price for each shipping method for this class. You can choose shipping classes during adding your products.'),
(1215, 1, 'shipping_class_costs', 'Shipping Class Costs'),
(1216, 1, 'shipping_cost', 'Shipping Cost'),
(1217, 1, 'shipping_delivery_times', 'Shipping Delivery Times'),
(1218, 1, 'shipping_delivery_times_exp', 'You can add shipping delivery times from here (E.g: Ready to ship in 1 Business Day)'),
(1219, 1, 'shipping_information', 'Shipping Information'),
(1220, 1, 'shipping_location', 'Shipping & Location'),
(1221, 1, 'shipping_method', 'Shipping Method'),
(1222, 1, 'shipping_methods', 'Shipping Methods'),
(1223, 1, 'shipping_settings', 'Shipping Settings'),
(1224, 1, 'shipping_time', 'Shipping Time'),
(1225, 1, 'shipping_zones', 'Shipping Zones '),
(1226, 1, 'shop', 'Shop'),
(1227, 1, 'shopping_cart', 'Shopping Cart'),
(1228, 1, 'shop_by_brand', 'Shop By Brand'),
(1229, 1, 'shop_by_category', 'Shop By Category'),
(1230, 1, 'shop_description', 'Shop Description'),
(1231, 1, 'shop_location', 'Shop Location'),
(1232, 1, 'shop_name', 'Shop Name'),
(1233, 1, 'shop_now', 'Shop Now'),
(1234, 1, 'shop_opening_request', 'Shop Opening Request'),
(1235, 1, 'shop_opening_requests', 'Shop Opening Requests'),
(1236, 1, 'shop_opening_request_emails', 'Shop opening request emails'),
(1237, 1, 'shop_policies', 'Shop Policies'),
(1238, 1, 'shop_settings', 'Shop Settings'),
(1239, 1, 'short_description', 'Short Description'),
(1240, 1, 'short_form', 'Short Form'),
(1241, 1, 'show', 'Show'),
(1242, 1, 'show_all', 'Show All'),
(1243, 1, 'show_breadcrumb', 'Show Breadcrumb'),
(1244, 1, 'show_category_image_on_menu', 'Show Category Image on Menu'),
(1245, 1, 'show_cookies_warning', 'Show Cookies Warning'),
(1246, 1, 'show_customer_email_seller', 'Show Customer Email to Seller'),
(1247, 1, 'show_customer_phone_number_seller', 'Show Customer Phone Number to Seller'),
(1248, 1, 'show_description_category_page', 'Show Description on Category Page'),
(1249, 1, 'show_featured_products_first_search', 'Show Featured Products First in Search Results'),
(1250, 1, 'show_first_search_lists', 'Show first in search lists'),
(1251, 1, 'show_image_on_main_menu', 'Show Image on Main Menu'),
(1252, 1, 'show_image_on_navigation', 'Show Category Image on the Navigation'),
(1253, 1, 'show_my_email', 'Show my email address'),
(1254, 1, 'show_my_location', 'Show my location'),
(1255, 1, 'show_my_phone', 'Show my phone number'),
(1256, 1, 'show_number_sales_profile', 'Show Number of Sales on Profile'),
(1257, 1, 'show_on_main_menu', 'Show on Main Menu'),
(1258, 1, 'show_on_slider', 'Show on Slider'),
(1259, 1, 'show_option_images_on_slider', 'Show Option Images on Slider When an Option is Selected'),
(1260, 1, 'show_previous_products', 'Show Previous Products'),
(1261, 1, 'show_reason', 'Show Reason'),
(1262, 1, 'show_right_column', 'Show Right Column'),
(1263, 1, 'show_sold_products_on_site', 'Show Sold Products on the Site'),
(1264, 1, 'show_subcategory_products', 'Show subcategory products'),
(1265, 1, 'show_title', 'Show Title'),
(1266, 1, 'show_under_these_categories', 'Custom field will be displayed under these categories'),
(1267, 1, 'show_vendor_contact_information', 'Show Vendor Contact Information on the Site'),
(1268, 1, 'single_country_mode', 'Single Country Mode'),
(1269, 1, 'sitemap', 'Sitemap'),
(1270, 1, 'site_description', 'Site Description'),
(1271, 1, 'site_font', 'Site Font'),
(1272, 1, 'site_key', 'Site Key'),
(1273, 1, 'site_title', 'Site Title'),
(1274, 1, 'skip', 'Skip'),
(1275, 1, 'sku', 'SKU'),
(1276, 1, 'slide', 'Slide'),
(1277, 1, 'slider', 'Slider'),
(1278, 1, 'slider_items', 'Slider Items'),
(1279, 1, 'slider_settings', 'Slider Settings'),
(1280, 1, 'slug', 'Slug'),
(1281, 1, 'slug_exp', 'If you leave it empty, it will be generated automatically.'),
(1282, 1, 'smtp', 'SMTP'),
(1283, 1, 'social_login', 'Social Login'),
(1284, 1, 'social_media', 'Social Media'),
(1285, 1, 'social_media_settings', 'Social Media Settings'),
(1286, 1, 'sold', 'Sold'),
(1287, 1, 'sold_products', 'Sold Products'),
(1288, 1, 'sort_categories', 'Sort Categories'),
(1289, 1, 'sort_options', 'Sort Options'),
(1290, 1, 'sort_parent_categories_by_category_order', 'Sort Parent Categories by Category Order'),
(1291, 1, 'special_offers', 'Special Offers'),
(1292, 1, 'start', 'Start'),
(1293, 1, 'start_selling', 'Start Selling'),
(1294, 1, 'start_selling_exp', 'In order to sell your products, you must be a verified member. Verification is a one-time process. This verification process is necessary because of spammers and fraud.'),
(1295, 1, 'state', 'State'),
(1296, 1, 'states', 'States'),
(1297, 1, 'static_cache_system', 'Static Cache System'),
(1298, 1, 'static_cache_system_exp', 'While the cache system is used for products that are updated more frequently, static cache is applied to records that do not change often (such as categories, custom fields, settings, etc.). If any changes occur in these records, the cache files are automatically refreshed.'),
(1299, 1, 'status', 'Status'),
(1300, 1, 'still_have_questions', 'Still have questions?'),
(1301, 1, 'still_have_questions_exp', 'If you still have a question, you can submit a support request here.'),
(1302, 1, 'stock', 'Stock'),
(1303, 1, 'storage', 'Storage'),
(1304, 1, 'store_name', 'Store Name'),
(1305, 1, 'stripe', 'Stripe'),
(1306, 1, 'stripe_checkout', 'Stripe Checkout'),
(1307, 1, 'stripe_payment_for', 'Promote payment for'),
(1308, 1, 'subcategory', 'Subcategory'),
(1309, 1, 'subject', 'Subject'),
(1310, 1, 'submit', 'Submit'),
(1311, 1, 'submit_a_new_quote', 'Submit a New Quote'),
(1312, 1, 'submit_a_quote', 'Submit a Quote'),
(1313, 1, 'submit_a_request', 'Submit a Request'),
(1314, 1, 'submit_refund_request', 'Submit a Refund Request'),
(1315, 1, 'subscribe', 'Subscribe'),
(1316, 1, 'subscribers', 'Subscribers'),
(1317, 1, 'subtotal', 'Subtotal'),
(1318, 1, 'succeeded', 'Succeeded'),
(1319, 1, 'summary', 'Summary'),
(1320, 1, 'sunday', 'Sunday'),
(1321, 1, 'support_system_emails', 'Support system emails'),
(1322, 1, 'support_ticket', 'Ticket'),
(1323, 1, 'support_tickets', 'Support Tickets'),
(1324, 1, 'swift', 'SWIFT'),
(1325, 1, 'swift_code', 'SWIFT Code'),
(1326, 1, 'swift_iban', 'Bank Account Number/IBAN'),
(1327, 1, 'system', 'System'),
(1328, 1, 'tag', 'Tag'),
(1329, 1, 'tags', 'Tags'),
(1330, 1, 'tags_product_exp', 'Add relevant keywords for your product to increase visibility in search results'),
(1331, 1, 'tax_name', 'Tax Name'),
(1332, 1, 'tax_rate', 'Tax Rate'),
(1333, 1, 'tax_registration_number', 'Tax Registration Number'),
(1334, 1, 'tax_settings', 'Tax Settings'),
(1335, 1, 'telegram_url', 'Telegram URL'),
(1336, 1, 'tell_us_about_shop', 'Tell Us About Your Shop'),
(1337, 1, 'terms_conditions_exp', 'I have read and agree to the'),
(1338, 1, 'text', 'Text'),
(1339, 1, 'textarea', 'Textarea'),
(1340, 1, 'text_color', 'Text Color'),
(1341, 1, 'text_direction', 'Text Direction'),
(1342, 1, 'text_editor_language', 'Text Editor Language'),
(1343, 1, 'theme', 'Theme'),
(1344, 1, 'there_is_shop_opening_request', 'There is a new shop opening request.'),
(1345, 1, 'the_operation_completed', 'The operation completed successfully!'),
(1346, 1, 'thursday', 'Thursday'),
(1347, 1, 'ticket', 'Ticket'),
(1348, 1, 'tiktok_url', 'TikTok URL'),
(1349, 1, 'timezone', 'Timezone'),
(1350, 1, 'time_limit_for_plan', 'A time limit for the plan'),
(1351, 1, 'title', 'Title'),
(1352, 1, 'to', 'To:'),
(1353, 1, 'token', 'Token'),
(1354, 1, 'top', 'Top'),
(1355, 1, 'top_menu', 'Top Menu'),
(1356, 1, 'total', 'Total'),
(1357, 1, 'total_amount', 'Total Amount:'),
(1358, 1, 'tracking_code', 'Tracking Code'),
(1359, 1, 'tracking_url', 'Tracking URL'),
(1360, 1, 'transactions', 'Transactions'),
(1361, 1, 'transaction_fee', 'Transaction Fee'),
(1362, 1, 'transaction_fee_exp', 'If you don\'t want to charge a transaction fee, type 0'),
(1363, 1, 'transaction_number', 'Transaction Number'),
(1364, 1, 'translation', 'Translation'),
(1365, 1, 'tuesday', 'Tuesday'),
(1366, 1, 'twitch_url', 'Twitch Url'),
(1367, 1, 'twitter_url', 'X (Twitter) URL'),
(1368, 1, 'type', 'Type'),
(1369, 1, 'type_extension', 'Type an extension and hit enter '),
(1370, 1, 'type_tag', 'Type tag and hit enter'),
(1371, 1, 'unconfirmed', 'Unconfirmed'),
(1372, 1, 'unfollow', 'Unfollow'),
(1373, 1, 'unit_price', 'Unit Price'),
(1374, 1, 'unlimited', 'Unlimited'),
(1375, 1, 'unlimited_stock', 'Unlimited Stock'),
(1376, 1, 'unsubscribe', 'Unsubscribe'),
(1377, 1, 'unsubscribe_successful', 'Unsubscribe Successful!'),
(1378, 1, 'updated', 'Updated'),
(1379, 1, 'update_category', 'Update Category'),
(1380, 1, 'update_city', 'Update City'),
(1381, 1, 'update_country', 'Update Country'),
(1382, 1, 'update_currency', 'Update Currency'),
(1383, 1, 'update_custom_field', 'Update Custom Field'),
(1384, 1, 'update_exchange_rates', 'Update Exchange Rates'),
(1385, 1, 'update_font', 'Update Font'),
(1386, 1, 'update_language', 'Update Language'),
(1387, 1, 'update_order_status', 'Update Order Status'),
(1388, 1, 'update_page', 'Update Page'),
(1389, 1, 'update_post', 'Update Post'),
(1390, 1, 'update_product', 'Update Product'),
(1391, 1, 'update_profile', 'Update Profile'),
(1392, 1, 'update_quote', 'Update Quote'),
(1393, 1, 'update_seller_balance', 'Update Seller Balance'),
(1394, 1, 'update_slider_item', 'Update Slider Item'),
(1395, 1, 'update_state', 'Update State'),
(1396, 1, 'upload', 'Upload'),
(1397, 1, 'uploaded', 'Uploaded'),
(1398, 1, 'uploading', 'Uploading...'),
(1399, 1, 'upload_file', 'Upload File'),
(1400, 1, 'upload_your_banner', 'Upload Your Banner'),
(1401, 1, 'url', 'URL'),
(1402, 1, 'used', 'Used'),
(1403, 1, 'user', 'User'),
(1404, 1, 'username', 'Username'),
(1405, 1, 'users', 'Users'),
(1406, 1, 'user_agent', 'User Agent'),
(1407, 1, 'user_details', 'User Details'),
(1408, 1, 'user_id', 'User Id'),
(1409, 1, 'user_login_activities', 'User Login Activities'),
(1410, 1, 'user_reviews', 'User Reviews'),
(1411, 1, 'use_default_payment_account', 'Use as default payment account'),
(1412, 1, 'use_default_price', 'Use default price'),
(1413, 1, 'use_different_price_for_options', 'Use Different Price for Options'),
(1414, 1, 'use_same_address_for_billing', 'Use same address for billing address'),
(1415, 1, 'use_this_date', 'Use This Date'),
(1416, 1, 'vacation_message', 'Vacation Message'),
(1417, 1, 'vacation_mode', 'Vacation Mode'),
(1418, 1, 'variations', 'Variations'),
(1419, 1, 'variations_exp', 'Add available options, like color or size that buyers can choose during checkout'),
(1420, 1, 'variation_type', 'Variation Type'),
(1421, 1, 'vat', 'VAT'),
(1422, 1, 'vat_exp', 'Value-Added Tax'),
(1423, 1, 'vat_vendor_dashboard_exp', 'Define VAT values for your products based on countries'),
(1424, 1, 'vat_vendor_exp', 'Allow vendors to add VAT for their products'),
(1425, 1, 'vendor', 'Vendor'),
(1426, 1, 'vendors', 'Vendors'),
(1427, 1, 'vendor_bulk_product_upload', 'Vendor Bulk Product Upload'),
(1428, 1, 'vendor_no_shipping_option_warning', 'If you want to sell a physical product, you must add your shipping options before adding the product. Please go to this section and add your shipping options:'),
(1429, 1, 'vendor_on_vacation', 'Vendor on Vacation'),
(1430, 1, 'vendor_on_vacation_exp', 'This vendor is currently on vacation and is not available to process orders or respond to messages.'),
(1431, 1, 'vendor_on_vacation_vendor_exp', 'Vacation mode allows you to pause your store for a certain period of time'),
(1432, 1, 'vendor_vat_rates_exp', 'The VAT rate you set for a country will apply to all states within that country. However, if you want a state to have its own unique tax rate, you can specify a different VAT rate for that state.'),
(1433, 1, 'vendor_verification_system', 'Vendor Verification System'),
(1434, 1, 'vendor_verification_system_exp', 'Disable if you want to allow all users to add products.'),
(1435, 1, 'vertical_alignment', 'Vertical Alignment'),
(1436, 1, 'video', 'Video'),
(1437, 1, 'video_preview', 'Video Preview'),
(1438, 1, 'video_preview_exp', 'MP4 or WEBM preview video'),
(1439, 1, 'view_all', 'View All'),
(1440, 1, 'view_cart', 'View Cart'),
(1441, 1, 'view_content', 'View Content'),
(1442, 1, 'view_details', 'View Details'),
(1443, 1, 'view_invoice', 'View Invoice'),
(1444, 1, 'view_license_keys', 'View License Keys'),
(1445, 1, 'view_options', 'View Options'),
(1446, 1, 'view_pdf_file', 'View PDF File'),
(1447, 1, 'view_product', 'View Product'),
(1448, 1, 'view_site', 'View Site'),
(1449, 1, 'visibility', 'Visibility'),
(1450, 1, 'visible', 'Visible'),
(1451, 1, 'visual_settings', 'Visual Settings'),
(1452, 1, 'vk_login', 'VKontakte Login'),
(1453, 1, 'vk_url', 'VK URL'),
(1454, 1, 'waiting', 'Waiting...'),
(1455, 1, 'wallet', 'Wallet'),
(1456, 1, 'wallet_balance', 'Wallet Balance'),
(1457, 1, 'wallet_deposit', 'Wallet Deposit'),
(1458, 1, 'wallet_deposits', 'Wallet Deposits'),
(1459, 1, 'warning', 'Warning'),
(1460, 1, 'warning_add_order_tracking_code', 'You can add the order tracking code and link while changing the order status.'),
(1461, 1, 'warning_cannot_choose_plan', 'You cannot choose this plan due to the number of products you have added'),
(1462, 1, 'warning_category_sort', 'Sorting with drag and drop will be active only when the \"by Category Order\" option is selected.'),
(1463, 1, 'warning_edit_profile_image', 'Click on the save changes button after selecting your image'),
(1464, 1, 'warning_external_download_link', 'For security reasons, it is recommended to upload digital files instead of adding an external download link'),
(1465, 1, 'warning_membership_admin_role', 'Admin role does not require a membership plan.'),
(1466, 1, 'warning_plan_used', 'This plan has been used before'),
(1467, 1, 'warning_product_main_image', 'You can click on the \"Main\" button on the images to select the main image of your product'),
(1468, 1, 'watermark', 'Watermark'),
(1469, 1, 'watermark_image', 'Watermark Image'),
(1470, 1, 'wednesday', 'Wednesday'),
(1471, 1, 'weekly', 'Weekly'),
(1472, 1, 'whatsapp_url', 'WhatsApp URL'),
(1473, 1, 'where_to_display', 'Where to Display'),
(1474, 1, 'width', 'Width'),
(1475, 1, 'wishlist', 'Wishlist'),
(1476, 1, 'withdraw_amount', 'Withdrawal Amount'),
(1477, 1, 'withdraw_method', 'Withdrawal Method'),
(1478, 1, 'withdraw_money', 'Withdraw Money'),
(1479, 1, 'write_a_message', 'Write a message...'),
(1480, 1, 'write_review', 'Write a Review...'),
(1481, 1, 'wrong_password', 'Wrong password!'),
(1482, 1, 'yearly', 'Yearly'),
(1483, 1, 'years_ago', 'years ago'),
(1484, 1, 'year_ago', 'year ago'),
(1485, 1, 'yes', 'Yes'),
(1486, 1, 'your_balance', 'Your Balance'),
(1487, 1, 'your_cart_is_empty', 'Your cart is empty!'),
(1488, 1, 'your_order_shipped', 'Your order has been shipped'),
(1489, 1, 'your_quote_accepted', 'Your quote has been accepted.'),
(1490, 1, 'your_quote_rejected', 'Your quote has been rejected.'),
(1491, 1, 'your_quote_request_replied', 'Your quote request has been replied.'),
(1492, 1, 'your_rating', 'Your Rating:'),
(1493, 1, 'your_shop_opening_request_approved', 'Your shop opening request has been approved. You can go to our site and start to sell your items!'),
(1494, 1, 'youtube_url', 'Youtube URL'),
(1495, 1, 'you_have_new_message', 'You have a new message'),
(1496, 1, 'you_have_new_order', 'You have a new order'),
(1497, 1, 'you_have_new_quote_request', 'You have a new quote request.'),
(1498, 1, 'you_have_no_debt', 'You have no debt.'),
(1499, 1, 'you_may_also_like', 'You may also like'),
(1500, 1, 'you_will_earn', 'You Will Earn'),
(1501, 1, 'zip_code', 'Zip Code'),
(1502, 1, 'zone_name', 'Zone Name');

-- --------------------------------------------------------

--
-- Table structure for table `location_cities`
--

CREATE TABLE `location_cities` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `location_countries`
--

CREATE TABLE `location_countries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `continent_code` varchar(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `location_states`
--

CREATE TABLE `location_states` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `country_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `media_type` varchar(20) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `storage` varchar(20) DEFAULT 'local'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `membership_plans`
--

CREATE TABLE `membership_plans` (
  `id` int(11) NOT NULL,
  `title_array` text DEFAULT NULL,
  `number_of_ads` int(11) DEFAULT NULL,
  `number_of_days` int(11) DEFAULT NULL,
  `price` bigint(20) DEFAULT NULL,
  `is_free` tinyint(1) DEFAULT 0,
  `is_unlimited_number_of_ads` tinyint(1) DEFAULT 0,
  `is_unlimited_time` tinyint(1) DEFAULT 0,
  `features_array` text DEFAULT NULL,
  `plan_order` smallint(6) DEFAULT 1,
  `is_popular` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `membership_transactions`
--

CREATE TABLE `membership_transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `plan_title` varchar(500) DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `payment_amount` varchar(50) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `global_taxes_data` text DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_number` bigint(20) DEFAULT NULL,
  `buyer_id` int(11) NOT NULL,
  `buyer_type` varchar(20) DEFAULT NULL,
  `price_subtotal` varchar(50) DEFAULT NULL,
  `price_vat` bigint(20) DEFAULT 0,
  `price_shipping` varchar(50) DEFAULT NULL,
  `price_total` varchar(50) DEFAULT NULL,
  `price_currency` varchar(50) DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `coupon_products` text DEFAULT NULL,
  `coupon_discount` bigint(20) DEFAULT NULL,
  `coupon_discount_rate` smallint(6) DEFAULT 0,
  `coupon_seller_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `transaction_fee_rate` double DEFAULT NULL,
  `transaction_fee` bigint(20) DEFAULT NULL,
  `global_taxes_data` text DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `shipping` text DEFAULT NULL,
  `affiliate_data` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` int(11) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `buyer_type` varchar(20) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_type` varchar(20) DEFAULT 'physical',
  `listing_type` varchar(20) DEFAULT NULL,
  `product_title` varchar(500) DEFAULT NULL,
  `product_slug` varchar(500) DEFAULT NULL,
  `product_unit_price` bigint(20) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `product_currency` varchar(20) DEFAULT NULL,
  `product_vat_rate` double DEFAULT 0,
  `product_vat` bigint(20) DEFAULT 0,
  `product_total_price` bigint(20) DEFAULT NULL,
  `variation_option_ids` varchar(255) DEFAULT NULL,
  `commission_rate` tinyint(4) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `shipping_tracking_number` varchar(255) DEFAULT NULL,
  `shipping_tracking_url` varchar(500) DEFAULT NULL,
  `shipping_method` varchar(255) DEFAULT NULL,
  `seller_shipping_cost` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `title` varchar(500) DEFAULT NULL,
  `slug` varchar(500) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `page_content` longtext DEFAULT NULL,
  `page_order` int(11) DEFAULT 1,
  `visibility` tinyint(1) DEFAULT 1,
  `title_active` tinyint(1) DEFAULT 1,
  `location` varchar(50) DEFAULT 'information',
  `is_custom` tinyint(1) NOT NULL DEFAULT 1,
  `page_default_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `lang_id`, `title`, `slug`, `description`, `keywords`, `page_content`, `page_order`, `visibility`, `title_active`, `location`, `is_custom`, `page_default_name`, `created_at`) VALUES
(1, 1, 'Terms & Conditions', 'terms-conditions', 'Terms & Conditions Page', 'Terms, Conditions, Page', NULL, 1, 1, 1, 'information', 0, 'terms_conditions', '2020-11-21 07:40:30'),
(2, 1, 'Contact', 'contact', 'Contact Page', 'Contact, Page', NULL, 1, 1, 1, 'top_menu', 0, 'contact', '2020-11-21 07:40:30'),
(3, 1, 'Blog', 'blog', 'Blog Page', 'Blog, Page', NULL, 1, 1, 1, 'quick_links', 0, 'blog', '2020-11-21 07:40:30'),
(4, 1, 'Shops', 'shops', 'Shops Page', 'shops, page', NULL, 1, 1, 1, 'quick_links', 0, 'shops', '2021-11-02 20:58:03');

-- --------------------------------------------------------

--
-- Table structure for table `pages_vendor`
--

CREATE TABLE `pages_vendor` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content_shop_policies` text DEFAULT NULL,
  `status_shop_policies` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_id` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `payment_amount` varchar(50) DEFAULT NULL,
  `payer_email` varchar(100) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `purchased_plan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `name_key` varchar(255) DEFAULT NULL,
  `public_key` varchar(500) DEFAULT NULL,
  `secret_key` varchar(500) DEFAULT NULL,
  `environment` varchar(30) DEFAULT 'production',
  `base_currency` varchar(30) DEFAULT 'all',
  `transaction_fee` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `logos` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `name`, `name_key`, `public_key`, `secret_key`, `environment`, `base_currency`, `transaction_fee`, `status`, `logos`) VALUES
(1, 'PayPal', 'paypal', NULL, NULL, 'production', 'all', NULL, 0, 'visa,mastercard,amex,discover,paypal'),
(2, 'Stripe', 'stripe', NULL, NULL, 'production', 'all', NULL, 0, 'visa,mastercard,amex,stripe'),
(3, 'Paystack', 'paystack', NULL, NULL, 'production', 'all', NULL, 0, 'visa,mastercard,verve,paystack'),
(4, 'Razorpay', 'razorpay', NULL, NULL, 'production', 'INR', NULL, 0, 'visa,mastercard,amex,maestro,diners,rupay,razorpay'),
(5, 'Flutterwave', 'flutterwave', NULL, NULL, 'production', 'all', NULL, 0, 'visa,mastercard,amex,maestro,flutterwave'),
(6, 'Iyzico', 'iyzico', NULL, NULL, 'production', 'TRY', NULL, 0, 'visa,mastercard,amex,troy,iyzico'),
(7, 'Midtrans', 'midtrans', NULL, NULL, 'production', 'IDR', NULL, 0, 'visa,mastercard,amex,jcb,midtrans'),
(8, 'Mercado Pago', 'mercado_pago', NULL, NULL, 'production', 'BRL', NULL, 0, 'visa,mastercard,amex,discover,mercado_pago'),
(9, 'PayTabs', 'paytabs', NULL, NULL, 'production', 'all', NULL, 0, 'visa,mastercard,paytabs');

-- --------------------------------------------------------

--
-- Table structure for table `payment_settings`
--

CREATE TABLE `payment_settings` (
  `id` int(11) NOT NULL,
  `default_currency` varchar(30) DEFAULT 'USD',
  `allow_all_currencies_for_classied` tinyint(1) DEFAULT 1,
  `currency_converter` tinyint(1) DEFAULT 0,
  `auto_update_exchange_rates` tinyint(1) DEFAULT 1,
  `currency_converter_api` varchar(100) DEFAULT NULL,
  `currency_converter_api_key` varchar(255) DEFAULT NULL,
  `bank_transfer_enabled` tinyint(1) DEFAULT 0,
  `bank_transfer_accounts` text DEFAULT NULL,
  `cash_on_delivery_enabled` tinyint(1) DEFAULT 1,
  `cash_on_delivery_debt_limit` bigint(20) DEFAULT 1000,
  `price_per_day` bigint(20) DEFAULT 1,
  `price_per_month` bigint(20) DEFAULT 3,
  `free_product_promotion` tinyint(1) DEFAULT 0,
  `payout_paypal_enabled` tinyint(1) DEFAULT 1,
  `payout_bitcoin_enabled` tinyint(1) DEFAULT 0,
  `payout_iban_enabled` tinyint(1) DEFAULT 1,
  `payout_swift_enabled` tinyint(1) DEFAULT 1,
  `min_payout_paypal` bigint(20) DEFAULT 5000,
  `min_payout_bitcoin` bigint(20) DEFAULT 5000,
  `min_payout_iban` bigint(20) DEFAULT 5000,
  `min_payout_swift` bigint(20) DEFAULT 50000,
  `commission_rate` double DEFAULT 0,
  `vat_status` tinyint(1) DEFAULT 1,
  `wallet_deposit` tinyint(1) DEFAULT 1,
  `pay_with_wallet_balance` tinyint(1) DEFAULT 1,
  `additional_invoice_info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_settings`
--

INSERT INTO `payment_settings` (`id`, `default_currency`, `allow_all_currencies_for_classied`, `currency_converter`, `auto_update_exchange_rates`, `currency_converter_api`, `currency_converter_api_key`, `bank_transfer_enabled`, `bank_transfer_accounts`, `cash_on_delivery_enabled`, `cash_on_delivery_debt_limit`, `price_per_day`, `price_per_month`, `free_product_promotion`, `payout_paypal_enabled`, `payout_bitcoin_enabled`, `payout_iban_enabled`, `payout_swift_enabled`, `min_payout_paypal`, `min_payout_bitcoin`, `min_payout_iban`, `min_payout_swift`, `commission_rate`, `vat_status`, `wallet_deposit`, `pay_with_wallet_balance`, `additional_invoice_info`) VALUES
(1, 'USD', 1, 0, 0, NULL, NULL, 0, NULL, 0, 1000, 10, 100, 0, 1, 0, 1, 1, 5000, 5000, 5000, 5000, 0, 1, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payouts`
--

CREATE TABLE `payouts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payout_method` varchar(100) DEFAULT NULL,
  `amount` bigint(20) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `slug` varchar(500) DEFAULT NULL,
  `product_type` varchar(20) DEFAULT 'physical',
  `listing_type` varchar(20) DEFAULT 'sell_on_site',
  `sku` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `price` bigint(20) DEFAULT NULL,
  `price_discounted` bigint(20) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `discount_rate` smallint(3) DEFAULT 0,
  `vat_rate` double DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `is_promoted` tinyint(1) DEFAULT 0,
  `promote_start_date` timestamp NULL DEFAULT NULL,
  `promote_end_date` timestamp NULL DEFAULT NULL,
  `promote_plan` varchar(100) DEFAULT NULL,
  `promote_day` int(11) DEFAULT NULL,
  `is_special_offer` tinyint(1) DEFAULT 0,
  `special_offer_date` timestamp NULL DEFAULT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT 1,
  `rating` varchar(50) DEFAULT '0',
  `pageviews` int(11) DEFAULT 0,
  `demo_url` varchar(1000) DEFAULT NULL,
  `external_link` varchar(1000) DEFAULT NULL,
  `files_included` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 1,
  `shipping_class_id` int(11) DEFAULT NULL,
  `shipping_delivery_time_id` int(11) DEFAULT NULL,
  `multiple_sale` tinyint(1) DEFAULT 1,
  `digital_file_download_link` varchar(500) DEFAULT NULL,
  `country_id` int(11) DEFAULT 0,
  `state_id` int(11) DEFAULT 0,
  `city_id` int(11) DEFAULT 0,
  `address` varchar(500) DEFAULT NULL,
  `zip_code` varchar(50) DEFAULT NULL,
  `brand_id` int(11) DEFAULT 0,
  `is_sold` tinyint(1) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0,
  `is_draft` tinyint(1) DEFAULT 0,
  `is_edited` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `is_free_product` tinyint(1) DEFAULT 0,
  `is_rejected` tinyint(1) DEFAULT 0,
  `reject_reason` varchar(1000) DEFAULT NULL,
  `is_affiliate` tinyint(1) DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `lang_id` tinyint(4) DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `short_description` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_license_keys`
--

CREATE TABLE `product_license_keys` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `license_key` varchar(500) DEFAULT NULL,
  `is_used` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_search_indexes`
--

CREATE TABLE `product_search_indexes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `search_index` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_settings`
--

CREATE TABLE `product_settings` (
  `id` int(11) NOT NULL,
  `marketplace_sku` tinyint(1) DEFAULT 1,
  `marketplace_variations` tinyint(1) DEFAULT 1,
  `marketplace_shipping` tinyint(1) DEFAULT 1,
  `marketplace_product_location` tinyint(1) DEFAULT 1,
  `classified_price` tinyint(1) DEFAULT 1,
  `classified_price_required` tinyint(1) DEFAULT 1,
  `classified_product_location` tinyint(1) DEFAULT 1,
  `classified_external_link` tinyint(1) DEFAULT 1,
  `physical_demo_url` tinyint(1) DEFAULT 0,
  `physical_video_preview` tinyint(1) DEFAULT 1,
  `physical_audio_preview` tinyint(1) DEFAULT 1,
  `digital_demo_url` tinyint(1) DEFAULT 1,
  `digital_video_preview` tinyint(1) DEFAULT 1,
  `digital_audio_preview` tinyint(1) DEFAULT 1,
  `digital_external_link` tinyint(1) DEFAULT 1,
  `digital_allowed_file_extensions` varchar(500) DEFAULT 'zip',
  `is_product_image_required` tinyint(1) DEFAULT 1,
  `image_file_format` varchar(30) DEFAULT 'JPG',
  `product_image_limit` smallint(6) DEFAULT 20,
  `brand_status` tinyint(1) DEFAULT 0,
  `is_brand_optional` tinyint(1) DEFAULT 1,
  `brand_where_to_display` tinyint(4) DEFAULT 2,
  `max_file_size_image` bigint(20) DEFAULT 10485760,
  `max_file_size_video` bigint(20) DEFAULT 31457280,
  `max_file_size_audio` bigint(20) DEFAULT 10485760,
  `sitemap_frequency` varchar(30) DEFAULT 'monthly',
  `sitemap_last_modification` varchar(30) DEFAULT 'server_response',
  `sitemap_priority` varchar(30) DEFAULT 'automatically',
  `pagination_per_page` smallint(6) DEFAULT 60,
  `sort_by_featured_products` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_settings`
--

INSERT INTO `product_settings` (`id`, `marketplace_sku`, `marketplace_variations`, `marketplace_shipping`, `marketplace_product_location`, `classified_price`, `classified_price_required`, `classified_product_location`, `classified_external_link`, `physical_demo_url`, `physical_video_preview`, `physical_audio_preview`, `digital_demo_url`, `digital_video_preview`, `digital_audio_preview`, `digital_external_link`, `digital_allowed_file_extensions`, `is_product_image_required`, `image_file_format`, `product_image_limit`, `brand_status`, `is_brand_optional`, `brand_where_to_display`, `max_file_size_image`, `max_file_size_video`, `max_file_size_audio`, `sitemap_frequency`, `sitemap_last_modification`, `sitemap_priority`, `pagination_per_page`, `sort_by_featured_products`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '\"zip\"', 1, 'JPG', 20, 0, 1, 2, 10485760, 31457280, 10485760, 'daily', 'server_response', 'automatically', 60, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_tags`
--

CREATE TABLE `product_tags` (
  `id` int(11) NOT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promoted_transactions`
--

CREATE TABLE `promoted_transactions` (
  `id` int(11) NOT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `payment_amount` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `purchased_plan` varchar(255) DEFAULT NULL,
  `day_count` int(11) DEFAULT NULL,
  `global_taxes_data` text DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quote_requests`
--

CREATE TABLE `quote_requests` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_title` varchar(500) DEFAULT NULL,
  `product_quantity` mediumint(9) DEFAULT 1,
  `seller_id` int(11) DEFAULT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `price_offered` bigint(20) DEFAULT NULL,
  `price_currency` varchar(20) DEFAULT NULL,
  `is_buyer_deleted` tinyint(1) DEFAULT 0,
  `is_seller_deleted` tinyint(1) DEFAULT 0,
  `variation_option_ids` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refund_requests`
--

CREATE TABLE `refund_requests` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_number` bigint(20) DEFAULT NULL,
  `order_product_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `is_completed` tinyint(1) DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refund_requests_messages`
--

CREATE TABLE `refund_requests_messages` (
  `id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_buyer` tinyint(1) NOT NULL DEFAULT 1,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `review` varchar(10000) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `id` int(11) NOT NULL,
  `role_name` text DEFAULT NULL,
  `permissions` text DEFAULT NULL,
  `is_super_admin` tinyint(1) DEFAULT 0,
  `is_default` tinyint(1) DEFAULT 0,
  `is_admin` tinyint(1) DEFAULT 0,
  `is_vendor` tinyint(1) DEFAULT 0,
  `is_member` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`id`, `role_name`, `permissions`, `is_super_admin`, `is_default`, `is_admin`, `is_vendor`, `is_member`) VALUES
(1, 'a:1:{i:0;a:2:{s:7:\"lang_id\";s:1:\"1\";s:4:\"name\";s:11:\"Super Admin\";}}', 'all', 1, 1, 1, 0, 0),
(2, 'a:1:{i:0;a:2:{s:7:\"lang_id\";s:1:\"1\";s:4:\"name\";s:6:\"Vendor\";}}', '2', 0, 1, 0, 1, 0),
(3, 'a:1:{i:0;a:2:{s:7:\"lang_id\";s:1:\"1\";s:4:\"name\";s:6:\"Member\";}}', '', 0, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `route_key` varchar(100) DEFAULT NULL,
  `route` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `route_key`, `route`) VALUES
(1, 'add_coupon', 'add-coupon'),
(2, 'add_product', 'add-product'),
(3, 'add_shipping_zone', 'add-shipping-zone'),
(4, 'admin', 'admin'),
(5, 'affiliate', 'affiliate'),
(6, 'affiliate_links', 'affiliate-links'),
(7, 'affiliate_program', 'affiliate-program'),
(8, 'blog', 'blog'),
(9, 'bulk_product_upload', 'bulk-product-upload'),
(10, 'cart', 'cart'),
(11, 'cash_on_delivery', 'cash-on-delivery'),
(12, 'category', 'category'),
(13, 'change_password', 'change-password'),
(14, 'comments', 'comments'),
(15, 'contact', 'contact'),
(16, 'coupons', 'coupons'),
(17, 'coupon_products', 'coupon-products'),
(18, 'dashboard', 'dashboard'),
(19, 'delete_account', 'delete-account'),
(20, 'downloads', 'downloads'),
(21, 'earnings', 'earnings'),
(22, 'edit_coupon', 'edit-coupon'),
(23, 'edit_product', 'edit-product'),
(24, 'edit_profile', 'edit-profile'),
(25, 'edit_shipping_zone', 'edit-shipping-zone'),
(26, 'featured_products', 'featured-products'),
(27, 'followers', 'followers'),
(28, 'following', 'following'),
(29, 'forgot_password', 'forgot-password'),
(30, 'help_center', 'help-center'),
(31, 'latest_products', 'latest-products'),
(32, 'location', 'location'),
(33, 'members', 'members'),
(34, 'messages', 'messages'),
(35, 'my_coupons', 'my-coupons'),
(36, 'my_reviews', 'my-reviews'),
(37, 'orders', 'orders'),
(38, 'order_completed', 'order-completed'),
(39, 'order_details', 'order-details'),
(40, 'payment', 'payment'),
(41, 'payments', 'payments'),
(42, 'payment_method', 'payment-method'),
(43, 'product', 'product'),
(44, 'products', 'products'),
(45, 'product_details', 'product-details'),
(46, 'profile', 'profile'),
(47, 'quote_requests', 'quote-requests'),
(48, 'refund_requests', 'refund-requests'),
(49, 'register', 'register'),
(50, 'register_success', 'register-success'),
(51, 'reset_password', 'reset-password'),
(52, 'reviews', 'reviews'),
(53, 'rss_feeds', 'rss-feeds'),
(54, 'sale', 'sale'),
(55, 'sales', 'sales'),
(56, 'search', 'search'),
(57, 'select_membership_plan', 'select-membership-plan'),
(58, 'seller', 'seller'),
(59, 'service_payment_completed', 'service-payment-completed'),
(60, 'settings', 'settings'),
(61, 'shipping', 'shipping'),
(62, 'shipping_address', 'shipping-address'),
(63, 'shipping_settings', 'shipping-settings'),
(64, 'shops', 'shops'),
(65, 'shop_policies', 'shop-policies'),
(66, 'shop_settings', 'shop-settings'),
(67, 'social_media', 'social-media'),
(68, 'start_selling', 'start-selling'),
(69, 'submit_request', 'submit-request'),
(70, 'tag', 'tag'),
(71, 'terms_conditions', 'terms-conditions'),
(72, 'ticket', 'ticket'),
(73, 'tickets', 'tickets'),
(74, 'wallet', 'wallet'),
(75, 'wishlist', 'wishlist');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `site_font` smallint(6) DEFAULT 19,
  `dashboard_font` smallint(6) DEFAULT 22,
  `site_title` varchar(255) DEFAULT NULL,
  `homepage_title` varchar(255) DEFAULT 'Home',
  `site_description` varchar(500) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `social_media_data` text DEFAULT NULL,
  `about_footer` varchar(1000) DEFAULT NULL,
  `contact_text` text DEFAULT NULL,
  `contact_address` varchar(500) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `copyright` varchar(500) DEFAULT NULL,
  `cookies_warning` tinyint(1) DEFAULT 0,
  `cookies_warning_text` text DEFAULT NULL,
  `affiliate_description` text DEFAULT NULL,
  `affiliate_content` longtext DEFAULT NULL,
  `affiliate_faq` mediumtext DEFAULT NULL,
  `affiliate_works` mediumtext DEFAULT NULL,
  `bulk_upload_documentation` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `lang_id`, `site_font`, `dashboard_font`, `site_title`, `homepage_title`, `site_description`, `keywords`, `social_media_data`, `about_footer`, `contact_text`, `contact_address`, `contact_email`, `contact_phone`, `copyright`, `cookies_warning`, `cookies_warning_text`, `affiliate_description`, `affiliate_content`, `affiliate_faq`, `affiliate_works`, `bulk_upload_documentation`, `created_at`) VALUES
(1, 1, 19, 22, 'Modesy - Marketplace - Classified Ads Script', 'Home', 'Modesy Index Page', 'index, home, modesy', NULL, NULL, NULL, NULL, NULL, NULL, 'Copyright 2024 Modesy - All Rights Reserved.', 1, '<p>This site uses cookies. By continuing to browse the site, you are agreeing to our use of cookies.</p>', 'a:2:{s:5:\"title\";s:53:\"Boost Your Earnings with the Modesy Affiliate Program\";s:11:\"description\";s:196:\"Are you a content creator, blogger, influencer, or simply someone with a strong online presence? If so, Modesy has an exciting opportunity for you to turn your online influence into real earnings.\";}', 'a:2:{s:5:\"title\";s:38:\"Why Join the Modesy Affiliate Program?\";s:7:\"content\";s:1745:\"<p>Modesy, a leading e-commerce platform known for its diverse range of products and exceptional customer service, is thrilled to introduce its Affiliate Program. This program offers you a chance to earn lucrative commissions by promoting Modesy\'s products. Here’s everything you need to know about why the Modesy Affiliate Program is perfect for you.<br><br><strong>1. Attractive Commission Rates</strong><br>Modesy offers competitive commission rates that ensure you are rewarded generously for your efforts. Every time someone makes a purchase through your referral link, you earn a commission. The more you promote, the more you earn.</p>\r\n<p><strong>2. Wide Range of Products</strong><br>With Modesy’s extensive catalog, you have endless opportunities to promote products that resonate with your audience. Whether your niche is tech gadgets, fashion, beauty products, or home decor, Modesy has something for everyone.</p>\r\n<p><strong>3. Easy-to-Use Tools</strong><br>The Modesy Affiliate Program provides you with a suite of tools to make your promotional efforts seamless. From custom referral links to detailed performance reports, you’ll have everything you need to track your success and optimize your strategies.</p>\r\n<p><strong>4. Reliable Support</strong><br>Modesy values its affiliates and offers dedicated support to help you succeed. Whether you have questions about the program or need tips on how to maximize your earnings, the Modesy support team is always ready to assist you.</p>\r\n<p><strong>5. Timely Payments</strong><br>Modesy ensures that your hard-earned commissions are paid out on time. With a straightforward payout process, you can focus on what you do best – promoting great products and earning money.</p>\";}', 'a:8:{i:0;a:3:{s:1:\"o\";s:1:\"1\";s:1:\"q\";s:36:\"How do I join the Affiliate program?\";s:1:\"a\";s:110:\"Simply click the \"Join Now\" button and fill out the registration form. Once approved, you can start promoting!\";}i:1;a:3:{s:1:\"o\";s:1:\"2\";s:1:\"q\";s:45:\"Who can participate in the Affiliate Program?\";s:1:\"a\";s:215:\"Anyone with an online presence, including bloggers, social media influencers, website owners, and content creators, can join the affiliate program. As long as you can promote our products, you’re welcome to apply!\";}i:2;a:3:{s:1:\"o\";s:1:\"3\";s:1:\"q\";s:40:\"Where can I generate my Affiliate links?\";s:1:\"a\";s:222:\"You can generate your affiliate links directly from any product detail page on our website. Once logged in, visit the product page you want to promote, and you’ll find an option to create your affiliate link right there.\";}i:3;a:3:{s:1:\"o\";s:1:\"4\";s:1:\"q\";s:28:\"What products can I promote?\";s:1:\"a\";s:162:\"You can promote any product from our store that is included in the affiliate program and earn commission on any qualifying sales made through your affiliate link.\";}i:4;a:3:{s:1:\"o\";s:1:\"5\";s:1:\"q\";s:46:\"How long is the validity of an Affiliate link?\";s:1:\"a\";s:211:\"An affiliate link is valid for 30 days from the moment a person clicks on it and opens the product page. If the product is purchased during this period, the affiliate commission will be applied for that product.\";}i:5;a:3:{s:1:\"o\";s:1:\"6\";s:1:\"q\";s:20:\"How much can I earn?\";s:1:\"a\";s:120:\"There is no limit to how much you can earn. Your earnings depend on the sales you generate through your affiliate links.\";}i:6;a:3:{s:1:\"o\";s:1:\"7\";s:1:\"q\";s:37:\"How do I track my Affiliate earnings?\";s:1:\"a\";s:96:\"You can track your affiliate program earnings in the \"Referral Earnings\" section of your wallet.\";}i:7;a:3:{s:1:\"o\";s:1:\"8\";s:1:\"q\";s:35:\"How do I get my Affiliate earnings?\";s:1:\"a\";s:188:\"Once your earnings exceed the minimum payout limit, you can request a payment from the \"Payouts\" section of your wallet. Simply submit a payout request, and your payment will be processed.\";}}', 'a:3:{i:0;a:2:{s:5:\"title\";s:23:\"Sign up for the program\";s:11:\"description\";s:77:\"Join the Modesy affiliate program by completing a simple registration process\";}i:1;a:2:{s:5:\"title\";s:34:\"Create and share your referral URL\";s:11:\"description\";s:77:\"Generate a referral URL and share it on your website, email, or social media.\";}i:2;a:2:{s:5:\"title\";s:15:\"Earn commission\";s:11:\"description\";s:64:\"Earn commissions on every sale made through your affiliate links\";}}', '<p>With the bulk product upload feature, you can upload your products in bulk with the help of a CSV file.<br><br>Bulk upload has options to add new products and edit existing products:<br><br><strong>Add Products: </strong>To add new products, download the CSV template, add your products to this CSV file and upload it from this section. You can see detailed explanations of all required or optional columns in the table below. When adding your data, you need to pay attention to the data type of these columns.<br><br><strong>Edit Products: </strong> To edit products, you need to add an \"id\" column to the CSV template. You can see the ID numbers of your products on the \"products\" page. After adding the \"id\" column, you need to add the column names you want to edit. <br>For example, if you want to update the stock and prices of your products, your CSV template should be like this:<br><span style=\"color: rgb(35, 111, 161);\">\"id\",\"price\",\"price_discounted\",\"stock\"</span><br><br>Example:<br><span style=\"color: rgb(35, 111, 161);\">\"id\",\"price\",\"price_discounted\",\"stock\"</span><br><span style=\"color: rgb(132, 63, 161);\">\"1\",\"30\",\"20\",\"1000\"</span><br><span style=\"color: rgb(132, 63, 161);\">\"5\",\"40\",\"40\",\"500\"</span><br><br><span style=\"color: rgb(186, 55, 42);\">* To update the product price, you need to add both \"price\" and \"price_discounted\" columns to your CSV file.<br><br><br></span></p>\r\n<p><span style=\"font-size: 12pt;\"><strong>CSV Columns</strong></span></p>\r\n<table style=\"width: 100%;\" class=\"table table-bordered\">\r\n<tbody>\r\n<tr>\r\n<th>Column</th>\r\n<th>Description</th>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 180px;\">title</td>\r\n<td>Data Type: Text <br><strong>Required</strong><br>Example: Modern grey couch and pillows</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 180px;\">slug</td>\r\n<td>Data Type: Text <br><strong>Optional</strong> <small>(If you leave it empty, it will be generated automatically.)</small> <br>Example: modern-grey-couch-and-pillows</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 180px;\">sku</td>\r\n<td>Data Type: Text <br><strong>Optional</strong><br>Example: MD-GR-6898</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 180px;\">category_id</td>\r\n<td>Data Type: Number <br><strong>Required</strong><br>Example: 1</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 180px;\">price</td>\r\n<td>Data Type: Decimal/Number <br><strong>Required</strong><br>Example 1: 50<br>Example 2: 45.90<br>Example 3: 3456.25</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 180px;\">price_discounted</td>\r\n<td>Data Type: Decimal/Number <br><strong>Optional</strong><br>Example 1: 40<br>Example 2: 35.90<br>Example 3: 2456.25</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 180px;\">vat_rate</td>\r\n<td>Data Type: Number <br><strong>Optional</strong><br>Example: 8</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 180px;\">stock</td>\r\n<td>Data Type: Number <br><strong>Required</strong><br>Example: 100</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 180px;\">short_description</td>\r\n<td>Data Type: Text <br><strong>Optional</strong><br>Example: It is a nice and comfortable couch</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 180px;\">description</td>\r\n<td>Data Type: Text <br><strong>Optional</strong><br>Example: It is a nice and comfortable couch...</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 180px;\">tags</td>\r\n<td>Data Type: Text <br><strong>Optional</strong><br>Example: nice, comfortable, couch</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 180px;\">image_url</td>\r\n<td>Data Type: Text <br><strong>Optional</strong><br>Example 1:<br>https://upload.wikimedia.org/wikipedia/commons/7/70/Labrador-sea-paamiut.jpg<br><br>Example 2:<br>https://upload.wikimedia.org/wikipedia/commons/7/70/Labrador-sea-paamiut.jpg,<br>https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/Shaqi_jrvej.jpg/1600px-Shaqi_jrvej.jpg<br><br><span style=\"color: rgb(186, 55, 42);\">*You can add multiple image links by placing commas between them.</span></td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 180px;\">external_link</td>\r\n<td>Data Type: Text <br><strong>Optional</strong><br>Example: https://domain.com/product_url</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 180px;\">updated_at</td>\r\n<td>Data Type: Timestamp <br><strong>Optional</strong><br>Example: 2024-06-30 10:27:00 <br><br><span style=\"color: rgb(186, 55, 42);\">*If you leave it blank, the system will not assign an update date.</span></td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 180px;\">created_at</td>\r\n<td>Data Type: Timestamp <br><strong>Optional</strong><br>Example: 2024-06-30 10:27:00 <br><br><span style=\"color: rgb(186, 55, 42);\">*If you leave it blank, the system will automatically assign the current date.</span></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p><br><br><br><br><br></p>', '2021-02-20 19:51:50');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_addresses`
--

CREATE TABLE `shipping_addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `country_id` varchar(20) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zip_code` varchar(50) DEFAULT NULL,
  `address_type` varchar(30) DEFAULT 'shipping',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_classes`
--

CREATE TABLE `shipping_classes` (
  `id` int(11) NOT NULL,
  `name_array` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_delivery_times`
--

CREATE TABLE `shipping_delivery_times` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `option_array` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_zones`
--

CREATE TABLE `shipping_zones` (
  `id` int(11) NOT NULL,
  `name_array` text DEFAULT NULL,
  `estimated_delivery` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_zone_locations`
--

CREATE TABLE `shipping_zone_locations` (
  `id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `continent_code` varchar(10) DEFAULT NULL,
  `country_id` int(11) DEFAULT 0,
  `state_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_zone_methods`
--

CREATE TABLE `shipping_zone_methods` (
  `id` int(11) NOT NULL,
  `name_array` text DEFAULT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `method_type` varchar(100) DEFAULT NULL,
  `flat_rate_cost_calculation_type` varchar(100) DEFAULT NULL,
  `flat_rate_cost` bigint(20) DEFAULT NULL,
  `flat_rate_class_costs_array` text DEFAULT NULL,
  `local_pickup_cost` bigint(20) DEFAULT NULL,
  `free_shipping_min_amount` bigint(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `lang_id` tinyint(4) DEFAULT 1,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `link` text DEFAULT NULL,
  `item_order` smallint(6) DEFAULT 1,
  `button_text` varchar(255) DEFAULT NULL,
  `animation_title` varchar(50) DEFAULT 'none',
  `animation_description` varchar(50) DEFAULT 'none',
  `animation_button` varchar(50) DEFAULT 'none',
  `image` varchar(255) DEFAULT NULL,
  `image_mobile` varchar(255) DEFAULT NULL,
  `text_color` varchar(30) DEFAULT '#ffffff',
  `button_color` varchar(30) DEFAULT '#222222',
  `button_text_color` varchar(30) DEFAULT '#ffffff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `storage_settings`
--

CREATE TABLE `storage_settings` (
  `id` int(11) NOT NULL,
  `storage` varchar(255) DEFAULT 'local',
  `aws_key` varchar(255) DEFAULT NULL,
  `aws_secret` varchar(255) DEFAULT NULL,
  `aws_bucket` varchar(255) DEFAULT NULL,
  `aws_region` varchar(255) DEFAULT 'us-west-2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `storage_settings`
--

INSERT INTO `storage_settings` (`id`, `storage`, `aws_key`, `aws_secret`, `aws_bucket`, `aws_region`) VALUES
(1, 'local', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_subtickets`
--

CREATE TABLE `support_subtickets` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `attachments` text DEFAULT NULL,
  `is_support_reply` tinyint(1) DEFAULT 0,
  `storage` varchar(20) DEFAULT 'local',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `subject` varchar(500) DEFAULT NULL,
  `is_guest` tinyint(1) DEFAULT 0,
  `status` smallint(6) DEFAULT 1,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` int(11) NOT NULL,
  `name_data` text DEFAULT NULL,
  `tax_rate` double NOT NULL,
  `is_all_countries` tinyint(1) DEFAULT 0,
  `country_ids` text DEFAULT NULL,
  `state_ids` text DEFAULT NULL,
  `product_sales` tinyint(1) DEFAULT 1,
  `service_payments` tinyint(1) DEFAULT 1,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_id` varchar(100) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_type` varchar(30) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `payment_amount` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT 'name@domain.com',
  `email_status` tinyint(1) DEFAULT 0,
  `token` varchar(500) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` smallint(6) DEFAULT 3,
  `balance` bigint(20) DEFAULT 0,
  `number_of_sales` int(11) DEFAULT 0,
  `user_type` varchar(20) DEFAULT 'registered',
  `facebook_id` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `vkontakte_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `cover_image_type` varchar(30) DEFAULT 'full_width',
  `banned` tinyint(1) DEFAULT 0,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `about_me` varchar(5000) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `zip_code` varchar(50) DEFAULT NULL,
  `show_email` tinyint(1) DEFAULT 0,
  `show_phone` tinyint(1) DEFAULT 0,
  `show_location` tinyint(1) DEFAULT 0,
  `social_media_data` text DEFAULT NULL,
  `last_seen` timestamp NULL DEFAULT NULL,
  `show_rss_feeds` tinyint(1) DEFAULT 0,
  `send_email_new_message` tinyint(1) DEFAULT 0,
  `is_active_shop_request` tinyint(1) DEFAULT 0,
  `shop_request_reject_reason` text DEFAULT NULL,
  `shop_request_date` timestamp NULL DEFAULT NULL,
  `vendor_documents` varchar(1000) DEFAULT NULL,
  `is_membership_plan_expired` tinyint(1) DEFAULT 0,
  `is_used_free_plan` tinyint(1) DEFAULT 0,
  `cash_on_delivery` tinyint(1) DEFAULT 0,
  `is_fixed_vat` tinyint(1) DEFAULT 0,
  `fixed_vat_rate` double DEFAULT 0,
  `vat_rates_data` text DEFAULT NULL,
  `vat_rates_data_state` text DEFAULT NULL,
  `is_affiliate` tinyint(1) DEFAULT 0,
  `vendor_affiliate_status` tinyint(1) DEFAULT 0,
  `affiliate_commission_rate` double DEFAULT 0,
  `affiliate_discount_rate` double DEFAULT 0,
  `tax_registration_number` varchar(255) DEFAULT NULL,
  `vacation_mode` tinyint(1) DEFAULT 0,
  `vacation_message` text DEFAULT NULL,
  `commission_debt` bigint(20) DEFAULT NULL,
  `account_delete_req` tinyint(1) DEFAULT 0,
  `account_delete_req_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_membership_plans`
--

CREATE TABLE `users_membership_plans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `plan_title` varchar(500) DEFAULT NULL,
  `number_of_ads` int(11) DEFAULT NULL,
  `number_of_days` int(11) DEFAULT NULL,
  `price` bigint(20) DEFAULT NULL,
  `currency` varchar(20) DEFAULT 'USD',
  `is_free` tinyint(1) DEFAULT 0,
  `is_unlimited_number_of_ads` tinyint(1) DEFAULT 0,
  `is_unlimited_time` tinyint(1) DEFAULT 0,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `plan_status` tinyint(1) DEFAULT 0,
  `plan_start_date` timestamp NULL DEFAULT NULL,
  `plan_end_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_payout_accounts`
--

CREATE TABLE `users_payout_accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payout_paypal_email` varchar(255) DEFAULT NULL,
  `payout_bitcoin_address` varchar(500) DEFAULT NULL,
  `iban_full_name` varchar(255) DEFAULT NULL,
  `iban_country_id` varchar(20) DEFAULT NULL,
  `iban_bank_name` varchar(255) DEFAULT NULL,
  `iban_number` varchar(500) DEFAULT NULL,
  `swift_full_name` varchar(255) DEFAULT NULL,
  `swift_address` varchar(500) DEFAULT NULL,
  `swift_state` varchar(255) DEFAULT NULL,
  `swift_city` varchar(255) DEFAULT NULL,
  `swift_postcode` varchar(100) DEFAULT NULL,
  `swift_country_id` varchar(20) DEFAULT NULL,
  `swift_bank_account_holder_name` varchar(255) DEFAULT NULL,
  `swift_iban` varchar(255) DEFAULT NULL,
  `swift_code` varchar(255) DEFAULT NULL,
  `swift_bank_name` varchar(255) DEFAULT NULL,
  `swift_bank_branch_city` varchar(255) DEFAULT NULL,
  `swift_bank_branch_country_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_login_activities`
--

CREATE TABLE `user_login_activities` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `label_names` text DEFAULT NULL,
  `variation_type` varchar(50) DEFAULT NULL,
  `insert_type` varchar(10) DEFAULT 'new',
  `option_display_type` varchar(30) DEFAULT 'text',
  `show_images_on_slider` tinyint(1) DEFAULT 0,
  `use_different_price` tinyint(1) DEFAULT 0,
  `is_visible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `variation_options`
--

CREATE TABLE `variation_options` (
  `id` int(11) NOT NULL,
  `variation_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `option_names` text DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  `price` bigint(20) DEFAULT NULL,
  `price_discounted` bigint(20) DEFAULT NULL,
  `discount_rate` smallint(3) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `use_default_price` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_deposits`
--

CREATE TABLE `wallet_deposits` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_id` varchar(100) DEFAULT NULL,
  `deposit_amount` varchar(30) DEFAULT NULL,
  `currency` varchar(20) DEFAULT 'USD',
  `payment_status` tinyint(1) DEFAULT 0,
  `ip_address` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_expenses`
--

CREATE TABLE `wallet_expenses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_id` varchar(100) DEFAULT NULL,
  `expense_item_id` varchar(30) DEFAULT NULL,
  `expense_type` varchar(255) DEFAULT NULL,
  `expense_amount` bigint(20) DEFAULT NULL,
  `expense_detail` varchar(255) DEFAULT NULL,
  `currency` varchar(20) DEFAULT 'USD',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abuse_reports`
--
ALTER TABLE `abuse_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ad_spaces`
--
ALTER TABLE `ad_spaces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_earnings`
--
ALTER TABLE `affiliate_earnings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_links`
--
ALTER TABLE `affiliate_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_transfers`
--
ALTER TABLE `bank_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lang_id` (`lang_id`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_post_id` (`post_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `blog_images`
--
ALTER TABLE `blog_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lang_id` (`lang_id`),
  ADD KEY `idx_category_id` (`category_id`);

--
-- Indexes for table `blog_tags`
--
ALTER TABLE `blog_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_post_id` (`post_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_parent_id` (`parent_id`),
  ADD KEY `idx_visibility` (`visibility`),
  ADD KEY `idx_is_featured` (`is_featured`),
  ADD KEY `idx_show_products_on_index` (`show_products_on_index`),
  ADD KEY `idx_category_order` (`category_order`),
  ADD KEY `idx_featured_order` (`featured_order`),
  ADD KEY `idx_show_on_main_menu` (`show_on_main_menu`),
  ADD KEY `idx_tree_id` (`tree_id`),
  ADD KEY `idx_level` (`level`),
  ADD KEY `idx_parent_tree` (`parent_tree`),
  ADD KEY `idx_slug` (`slug`);

--
-- Indexes for table `categories_lang`
--
ALTER TABLE `categories_lang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_lang_id` (`lang_id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sender_id` (`sender_id`),
  ADD KEY `idx_receiver_id` (`receiver_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_conversation_id` (`chat_id`),
  ADD KEY `idx_sender_id` (`sender_id`),
  ADD KEY `idx_receiver_id` (`receiver_id`),
  ADD KEY `idx_is_read` (`is_read`),
  ADD KEY `idx_deleted_user_id` (`deleted_user_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_parent_id` (`parent_id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons_used`
--
ALTER TABLE `coupons_used`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_products`
--
ALTER TABLE `coupon_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_coupon_id` (`coupon_id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_where_to_display` (`where_to_display`),
  ADD KEY `idx_field_order` (`field_order`),
  ADD KEY `idx_is_product_filter` (`is_product_filter`);

--
-- Indexes for table `custom_fields_category`
--
ALTER TABLE `custom_fields_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_field_id` (`field_id`);

--
-- Indexes for table `custom_fields_options`
--
ALTER TABLE `custom_fields_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_field_id` (`field_id`),
  ADD KEY `idx_option_key` (`option_key`);

--
-- Indexes for table `custom_fields_product`
--
ALTER TABLE `custom_fields_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_field_id` (`field_id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_selected_option_id` (`selected_option_id`),
  ADD KEY `idx_product_filter_key` (`product_filter_key`);

--
-- Indexes for table `digital_files`
--
ALTER TABLE `digital_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `digital_sales`
--
ALTER TABLE `digital_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order_id` (`order_id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_seller_id` (`seller_id`),
  ADD KEY `idx_buyer_id` (`buyer_id`);

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `email_queue`
--
ALTER TABLE `email_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_following_id` (`following_id`),
  ADD KEY `idx_follower_id` (`follower_id`);

--
-- Indexes for table `fonts`
--
ALTER TABLE `fonts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homepage_banners`
--
ALTER TABLE `homepage_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_is_main` (`is_main`);

--
-- Indexes for table `images_file_manager`
--
ALTER TABLE `images_file_manager`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `images_variation`
--
ALTER TABLE `images_variation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_variation_option_id` (`variation_option_id`),
  ADD KEY `idx_is_main` (`is_main`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order_id` (`order_id`);

--
-- Indexes for table `knowledge_base`
--
ALTER TABLE `knowledge_base`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `knowledge_base_categories`
--
ALTER TABLE `knowledge_base_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_translations`
--
ALTER TABLE `language_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lang_id` (`lang_id`);

--
-- Indexes for table `location_cities`
--
ALTER TABLE `location_cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_country_id` (`country_id`),
  ADD KEY `idx_state_id` (`state_id`);

--
-- Indexes for table `location_countries`
--
ALTER TABLE `location_countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `location_states`
--
ALTER TABLE `location_states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_country_id` (`country_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- Indexes for table `membership_plans`
--
ALTER TABLE `membership_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership_transactions`
--
ALTER TABLE `membership_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order_number` (`order_number`),
  ADD KEY `idx_buyer_id` (`buyer_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order_id` (`order_id`),
  ADD KEY `idx_seller_id` (`seller_id`),
  ADD KEY `idx_buyer_id` (`buyer_id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages_vendor`
--
ALTER TABLE `pages_vendor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_payment_id` (`payment_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_settings`
--
ALTER TABLE `payment_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payouts`
--
ALTER TABLE `payouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_is_promoted` (`is_promoted`),
  ADD KEY `idx_visibility` (`visibility`),
  ADD KEY `idx_is_deleted` (`is_deleted`),
  ADD KEY `idx_is_draft` (`is_draft`),
  ADD KEY `idx_price` (`price`),
  ADD KEY `idx_discount_rate` (`discount_rate`),
  ADD KEY `idx_is_special_offer` (`is_special_offer`),
  ADD KEY `idx_is_sold` (`is_sold`),
  ADD KEY `idx_brand_id` (`brand_id`),
  ADD KEY `idx_price_discounted` (`price_discounted`),
  ADD KEY `idx_rating` (`rating`),
  ADD KEY `idx_country_id` (`country_id`),
  ADD KEY `idx_state_id` (`state_id`),
  ADD KEY `idx_city_id` (`city_id`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_sku` (`sku`),
  ADD KEY `idx_is_edited` (`is_edited`),
  ADD KEY `idx_is_active` (`is_active`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_lang_id` (`lang_id`);

--
-- Indexes for table `product_license_keys`
--
ALTER TABLE `product_license_keys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_is_used` (`is_used`);

--
-- Indexes for table `product_search_indexes`
--
ALTER TABLE `product_search_indexes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_lang_id` (`lang_id`);
ALTER TABLE `product_search_indexes` ADD FULLTEXT KEY `search_index` (`search_index`);

--
-- Indexes for table `product_settings`
--
ALTER TABLE `product_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tag` (`tag`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_lang_id` (`lang_id`);

--
-- Indexes for table `promoted_transactions`
--
ALTER TABLE `promoted_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quote_requests`
--
ALTER TABLE `quote_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_seller_id` (`seller_id`),
  ADD KEY `idx_buyer_id` (`buyer_id`),
  ADD KEY `idx_is_buyer_deleted` (`is_buyer_deleted`),
  ADD KEY `idx_is_seller_deleted` (`is_seller_deleted`);

--
-- Indexes for table `refund_requests`
--
ALTER TABLE `refund_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_buyer_id` (`buyer_id`),
  ADD KEY `idx_seller_id` (`seller_id`);

--
-- Indexes for table `refund_requests_messages`
--
ALTER TABLE `refund_requests_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `shipping_classes`
--
ALTER TABLE `shipping_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `shipping_delivery_times`
--
ALTER TABLE `shipping_delivery_times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `shipping_zone_locations`
--
ALTER TABLE `shipping_zone_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_zone_id` (`zone_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `shipping_zone_methods`
--
ALTER TABLE `shipping_zone_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_zone_id` (`zone_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storage_settings`
--
ALTER TABLE `storage_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_subtickets`
--
ALTER TABLE `support_subtickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ticket_id` (`ticket_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_is_support_reply` (`is_support_reply`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_payment_id` (`payment_id`),
  ADD KEY `idx_order_id` (`order_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_banned` (`banned`),
  ADD KEY `idx_country_id` (`country_id`),
  ADD KEY `idx_state_id` (`state_id`),
  ADD KEY `idx_city_id` (`city_id`),
  ADD KEY `idx_vacation_mode` (`vacation_mode`),
  ADD KEY `idx_is_membership_plan_expired` (`is_membership_plan_expired`);

--
-- Indexes for table `users_membership_plans`
--
ALTER TABLE `users_membership_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_payout_accounts`
--
ALTER TABLE `users_payout_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `user_login_activities`
--
ALTER TABLE `user_login_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_parent_id` (`parent_id`),
  ADD KEY `idx_is_visible` (`is_visible`);

--
-- Indexes for table `variation_options`
--
ALTER TABLE `variation_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_variation_id` (`variation_id`),
  ADD KEY `idx_parent_id` (`parent_id`);

--
-- Indexes for table `wallet_deposits`
--
ALTER TABLE `wallet_deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet_expenses`
--
ALTER TABLE `wallet_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abuse_reports`
--
ALTER TABLE `abuse_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ad_spaces`
--
ALTER TABLE `ad_spaces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_earnings`
--
ALTER TABLE `affiliate_earnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_links`
--
ALTER TABLE `affiliate_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_transfers`
--
ALTER TABLE `bank_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_images`
--
ALTER TABLE `blog_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_tags`
--
ALTER TABLE `blog_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories_lang`
--
ALTER TABLE `categories_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons_used`
--
ALTER TABLE `coupons_used`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon_products`
--
ALTER TABLE `coupon_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_fields_category`
--
ALTER TABLE `custom_fields_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_fields_options`
--
ALTER TABLE `custom_fields_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_fields_product`
--
ALTER TABLE `custom_fields_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `digital_files`
--
ALTER TABLE `digital_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `digital_sales`
--
ALTER TABLE `digital_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_queue`
--
ALTER TABLE `email_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fonts`
--
ALTER TABLE `fonts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `homepage_banners`
--
ALTER TABLE `homepage_banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images_file_manager`
--
ALTER TABLE `images_file_manager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images_variation`
--
ALTER TABLE `images_variation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `knowledge_base`
--
ALTER TABLE `knowledge_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `knowledge_base_categories`
--
ALTER TABLE `knowledge_base_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `language_translations`
--
ALTER TABLE `language_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1503;

--
-- AUTO_INCREMENT for table `location_cities`
--
ALTER TABLE `location_cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `location_countries`
--
ALTER TABLE `location_countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `location_states`
--
ALTER TABLE `location_states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `membership_plans`
--
ALTER TABLE `membership_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `membership_transactions`
--
ALTER TABLE `membership_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pages_vendor`
--
ALTER TABLE `pages_vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment_settings`
--
ALTER TABLE `payment_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payouts`
--
ALTER TABLE `payouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_license_keys`
--
ALTER TABLE `product_license_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_search_indexes`
--
ALTER TABLE `product_search_indexes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_settings`
--
ALTER TABLE `product_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_tags`
--
ALTER TABLE `product_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promoted_transactions`
--
ALTER TABLE `promoted_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quote_requests`
--
ALTER TABLE `quote_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refund_requests`
--
ALTER TABLE `refund_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refund_requests_messages`
--
ALTER TABLE `refund_requests_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_classes`
--
ALTER TABLE `shipping_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_delivery_times`
--
ALTER TABLE `shipping_delivery_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_zone_locations`
--
ALTER TABLE `shipping_zone_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_zone_methods`
--
ALTER TABLE `shipping_zone_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `storage_settings`
--
ALTER TABLE `storage_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_subtickets`
--
ALTER TABLE `support_subtickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_membership_plans`
--
ALTER TABLE `users_membership_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_payout_accounts`
--
ALTER TABLE `users_payout_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_login_activities`
--
ALTER TABLE `user_login_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `variations`
--
ALTER TABLE `variations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `variation_options`
--
ALTER TABLE `variation_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_deposits`
--
ALTER TABLE `wallet_deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_expenses`
--
ALTER TABLE `wallet_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
