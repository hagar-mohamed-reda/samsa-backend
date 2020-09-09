-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 08, 2020 at 12:47 PM
-- Server version: 5.7.30-0ubuntu0.16.04.1
-- PHP Version: 7.0.33-29+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MSA_student`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_years`
--

CREATE TABLE `academic_years` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_years`
--

INSERT INTO `academic_years` (`id`, `name`, `start_date`, `end_date`, `notes`, `created_at`, `updated_at`) VALUES
(1, '2019/2020', '2020-08-13', '2020-08-06', NULL, '2020-08-05 08:22:48', '2020-08-05 08:22:48');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationality_id` int(10) UNSIGNED DEFAULT NULL,
  `gender` enum('ذكر','انثى') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `academic_years_id` int(10) UNSIGNED DEFAULT NULL,
  `registeration_date` date DEFAULT NULL,
  `qualification_types_id` int(10) UNSIGNED DEFAULT NULL,
  `qualification_date` date DEFAULT NULL,
  `qualification_set_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language_1_id` int(10) UNSIGNED DEFAULT NULL,
  `language_2_id` int(10) UNSIGNED DEFAULT NULL,
  `city_id` int(10) UNSIGNED DEFAULT NULL,
  `government_id` int(10) UNSIGNED DEFAULT NULL,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `religion` enum('مسلم','مسيحى') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `military_status_id` int(10) UNSIGNED DEFAULT NULL,
  `military_area_id` int(10) UNSIGNED DEFAULT NULL,
  `national_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` double(8,2) DEFAULT NULL,
  `triple_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_status_id` int(10) UNSIGNED DEFAULT NULL,
  `registration_method_id` int(10) UNSIGNED DEFAULT NULL,
  `national_id_date` date DEFAULT NULL,
  `national_id_place` int(10) UNSIGNED DEFAULT NULL,
  `parent_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_national_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_job_id` int(10) UNSIGNED DEFAULT NULL,
  `parent_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `name`, `code`, `nationality_id`, `gender`, `academic_years_id`, `registeration_date`, `qualification_types_id`, `qualification_date`, `qualification_set_number`, `language_1_id`, `language_2_id`, `city_id`, `government_id`, `country_id`, `religion`, `military_status_id`, `military_area_id`, `national_id`, `password`, `grade`, `triple_number`, `address`, `birth_address`, `phone_1`, `registration_status_id`, `registration_method_id`, `national_id_date`, `national_id_place`, `parent_name`, `parent_national_id`, `parent_job_id`, `parent_address`, `parent_phone`, `created_at`, `updated_at`) VALUES
(1, 'مصطفى', '123123', 1, 'ذكر', 1, '2020-08-11', 1, '2020-08-20', '202012', 1, 2, 1, 1, 1, 'مسلم', 1, 1, '223323323', 'eeee', 2020.00, '23232323', 'قنا - قوص', 'قنا - قوص - مصنع السكر', '202020', 2, 2, '2020-08-29', 1, '232323', '232323', 1, 'قوص', '22222', '2020-08-05 08:41:53', '2020-08-05 08:41:53');

-- --------------------------------------------------------

--
-- Table structure for table `application_required`
--

CREATE TABLE `application_required` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_required`
--

INSERT INTO `application_required` (`id`, `name`, `display_name`, `required`, `created_at`, `updated_at`) VALUES
(1, 'name', 'اسم الطالب', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(2, 'address', 'عنوان الطالب', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(3, 'birth_address', 'محل الولادة', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(4, 'national_id', ' رقم البطاقة الشخصية ', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(5, 'national_id_date', ' تاريخ اصدار البطاقة الشخصية  ', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(6, 'national_id_place', ' مكان اصدار البطاقة الشخصية', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(7, 'triple_number', ' الرقم الثلاثى ', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(8, 'registeration_date', ' تاريخ تقديم طلب الالتحاق ', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(9, 'military_area_id', 'جهة التجنيد', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(10, 'military_status_id', 'حالة التجنيد ', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(11, 'academic_years_id', ' السنة الدراسية ', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(12, 'password', ' كلمة سر التنسيق ', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(13, 'qualification_types_id', ' نوع المؤهل الدراسى الحاصل عليه ', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(14, 'qualification_date', ' تاريخ الحصول على شهادة المؤهل ', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(15, 'qualification_set_number', '  رقم الجلوس  ', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(16, 'nationality_id', 'الجنسية', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(17, 'religion', 'الديانة', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(18, 'gender', 'الجنس', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(19, 'country_id', 'الدولة', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(20, 'government_id', 'المحافظة', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(21, 'city_id', 'المدينة', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(22, 'language_1_id', ' لغة اجنبية اولى ', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(23, 'language_2_id', ' لغة اجنبية ثانية ', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(24, 'grade', ' درجة الحصول على الشهادة ', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(25, 'phone_1', ' تليفون الطالب المتقدم ', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(26, 'parent_name', 'اسم ولى الامر ', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(27, 'parent_national_id', 'رقم البطاقة الشخصية لولى الامر', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(28, 'parent_job_id', 'وظيفة ولى الامر', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(29, 'parent_address', 'عنوان ولى الامر', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19'),
(30, 'parent_phone', ' تليفون ولى الامر ', '1', '2020-08-05 06:53:19', '2020-08-05 06:53:19');

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `government_id` int(10) UNSIGNED NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `government_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'شبرا', 1, NULL, '2020-08-05 08:16:58', '2020-08-05 08:16:58'),
(2, 'الخرطوم', 2, NULL, '2020-08-05 08:17:08', '2020-08-05 08:17:08');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'جمهورية مصر العربية', NULL, '2020-08-05 08:16:16', '2020-08-05 08:16:16'),
(2, 'جمهورية السودان', NULL, '2020-08-05 08:16:24', '2020-08-05 08:16:24');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_id` int(10) UNSIGNED NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `level_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'عام', 1, NULL, '2020-08-05 08:24:21', '2020-08-05 08:24:21'),
(2, 'تمويل', 2, NULL, '2020-08-05 08:24:35', '2020-08-05 08:24:35');

-- --------------------------------------------------------

--
-- Table structure for table `departments_levels`
--

CREATE TABLE `departments_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(11) NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `department_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'تجارة', 2, NULL, '2020-08-05 08:24:51', '2020-08-05 08:24:51');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `globale_settings`
--

CREATE TABLE `globale_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `governments`
--

CREATE TABLE `governments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `governments`
--

INSERT INTO `governments` (`id`, `name`, `country_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'القاهرة', 1, NULL, '2020-08-05 08:16:36', '2020-08-05 08:16:36'),
(2, 'الخرطوم', 2, NULL, '2020-08-05 08:16:44', '2020-08-05 08:16:44');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'اللغة الانجليزية', NULL, '2020-08-05 08:26:16', '2020-08-05 08:26:16'),
(2, 'اللغة الفرنسية', NULL, '2020-08-05 08:26:26', '2020-08-05 08:26:26');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `name`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'الاول', NULL, '2020-08-05 08:23:54', '2020-08-05 08:23:54'),
(2, 'الثانى', NULL, '2020-08-05 08:24:02', '2020-08-05 08:24:02');

-- --------------------------------------------------------

--
-- Table structure for table `login_histories`
--

CREATE TABLE `login_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_07_17_173338_create_academic_years_table', 1),
(5, '2020_07_18_201114_create_applications_table', 1),
(6, '2020_07_18_205107_create_team_work_control_tabl', 1),
(7, '2020_07_18_205312_create_parent_relation_type_tabl', 1),
(8, '2020_07_18_205445_create_globale_settings_table', 1),
(9, '2020_07_18_205734_create_military_areas_table', 1),
(10, '2020_07_18_205935_create_military_status_table', 1),
(11, '2020_07_18_210053_create_military_settings_table', 1),
(12, '2020_07_18_210320_create_nationalities_table', 1),
(13, '2020_07_18_210403_create_parent_jobs_table', 1),
(14, '2020_07_18_210440_create_countries_table', 1),
(15, '2020_07_18_210504_create_governments_table', 1),
(16, '2020_07_18_210655_create_cities_table', 1),
(17, '2020_07_18_210851_create_registeration_status_table', 1),
(18, '2020_07_18_211348_create_qualifications_table', 1),
(19, '2020_07_18_211440_create_qualification_years_table', 1),
(20, '2020_07_18_211859_create_departments_table', 1),
(21, '2020_07_18_212029_create_levels_table', 1),
(22, '2020_07_18_212229_create_languages_table', 1),
(23, '2020_07_18_212330_create_specializations_table', 1),
(24, '2020_07_19_063008_create_students_table', 1),
(25, '2020_07_19_063315_create_parents_table', 1),
(26, '2020_07_19_065711_create_attributes_table', 1),
(27, '2020_07_19_065835_create_student_attributes_table', 1),
(28, '2020_07_19_070059_create_student_military_history_table', 1),
(29, '2020_07_19_075825_create_qualification_types_table', 1),
(30, '2020_07_19_083616_create_required_documents_table', 1),
(31, '2020_07_19_105519_create_registration_methods_table', 1),
(32, '2020_07_19_111658_create_student_required_documents_table', 1),
(33, '2020_07_19_112201_create_terms_table', 1),
(34, '2020_07_19_112243_create_schools_table', 1),
(35, '2020_07_19_112703_create_student_logs_table', 1),
(36, '2020_07_19_113313_create_student_status_table', 1),
(37, '2020_07_25_072834_laratrust_setup_tables', 1),
(38, '2020_07_27_111504_create_table_departments_levels', 1),
(39, '2020_07_27_114107_create_divisions_table', 1),
(40, '2020_07_29_110101_add_column_phone_to_users', 1),
(41, '2020_07_29_125315_create_login_histories_table', 1),
(42, '2020_08_04_080915_add_coloumn_level_id_to_qualification_types', 1),
(43, '2020_08_04_103631_create_application_required_table', 1),
(44, '2020_08_08_072657_create_relative_relation_table', 2),
(45, '2020_08_08_081617_create_translations_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `military_areas`
--

CREATE TABLE `military_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `government_id` int(10) UNSIGNED NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `military_areas`
--

INSERT INTO `military_areas` (`id`, `name`, `government_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'الهايكستب', 1, NULL, '2020-08-05 08:21:57', '2020-08-05 08:21:57');

-- --------------------------------------------------------

--
-- Table structure for table `military_settings`
--

CREATE TABLE `military_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `condition_age` int(11) NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `military_status_id` int(11) NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `military_status`
--

CREATE TABLE `military_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `military_status`
--

INSERT INTO `military_status` (`id`, `name`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'اعفاء نهائى من اداء الخدمة العسكرية', NULL, '2020-08-05 08:22:21', '2020-08-05 08:22:21'),
(2, 'اعفاء مؤقت', NULL, '2020-08-05 08:22:28', '2020-08-05 08:22:28');

-- --------------------------------------------------------

--
-- Table structure for table `nationalities`
--

CREATE TABLE `nationalities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nationalities`
--

INSERT INTO `nationalities` (`id`, `name`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'مصرى', NULL, '2020-08-05 08:25:24', '2020-08-05 08:25:24'),
(2, 'سودانى', NULL, '2020-08-05 08:25:32', '2020-08-05 08:25:32');

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_job_id` int(11) NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `national_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count_students` int(11) NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parent_jobs`
--

CREATE TABLE `parent_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parent_jobs`
--

INSERT INTO `parent_jobs` (`id`, `name`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'طبيب بشرى', NULL, '2020-08-05 08:26:56', '2020-08-05 08:26:56'),
(2, 'مهندس مدنى', NULL, '2020-08-05 08:27:04', '2020-08-05 08:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `parent_relation_type`
--

CREATE TABLE `parent_relation_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'users_create', 'Create Users', 'Create Users', NULL, NULL),
(2, 'users_read', 'Read Users', 'Read Users', NULL, NULL),
(3, 'users_update', 'Update Users', 'Update Users', NULL, NULL),
(4, 'users_delete', 'Delete Users', 'Delete Users', NULL, NULL),
(5, 'roles_create', 'Create Roles', 'Create Roles', NULL, NULL),
(6, 'roles_read', 'Read Roles', 'Read Roles', NULL, NULL),
(7, 'roles_update', 'Update Roles', 'Update Roles', NULL, NULL),
(8, 'roles_delete', 'Delete Roles', 'Delete Roles', NULL, NULL),
(9, 'cities_read', NULL, NULL, NULL, NULL),
(10, 'cities_create', NULL, NULL, NULL, NULL),
(11, 'cities_update', NULL, NULL, NULL, NULL),
(12, 'cities_delete', NULL, NULL, NULL, NULL),
(13, 'countries_read', NULL, NULL, NULL, NULL),
(14, 'countries_create', NULL, NULL, NULL, NULL),
(15, 'countries_update', NULL, NULL, NULL, NULL),
(16, 'countries_delete', NULL, NULL, NULL, NULL),
(17, 'settings_read', NULL, NULL, NULL, NULL),
(18, 'settings_create', NULL, NULL, NULL, NULL),
(19, 'settings_update', NULL, NULL, NULL, NULL),
(20, 'settings_delete', NULL, NULL, NULL, NULL),
(21, 'academic-years_read', NULL, NULL, NULL, NULL),
(22, 'academic-years_create', NULL, NULL, NULL, NULL),
(23, 'academic-years_update', NULL, NULL, NULL, NULL),
(24, 'academic-years_delete', NULL, NULL, NULL, NULL),
(25, 'levels_read', NULL, NULL, NULL, NULL),
(26, 'levels_create', NULL, NULL, NULL, NULL),
(27, 'levels_update', NULL, NULL, NULL, NULL),
(28, 'levels_delete', NULL, NULL, NULL, NULL),
(29, 'governments_create', NULL, NULL, NULL, NULL),
(30, 'governments_update', NULL, NULL, NULL, NULL),
(31, 'governments_read', NULL, NULL, NULL, NULL),
(32, 'governments_delete', NULL, NULL, NULL, NULL),
(33, 'languages_read', NULL, NULL, NULL, NULL),
(34, 'languages_create', NULL, NULL, NULL, NULL),
(35, 'languages_update', NULL, NULL, NULL, NULL),
(36, 'languages_delete', NULL, NULL, NULL, NULL),
(37, 'nationalities_read', NULL, NULL, NULL, NULL),
(38, 'nationalities_create', NULL, NULL, NULL, NULL),
(39, 'nationalities_update', NULL, NULL, NULL, NULL),
(40, 'nationalities_delete', NULL, NULL, NULL, NULL),
(41, 'registeration-status_read', NULL, NULL, NULL, NULL),
(42, 'registeration-status_create', NULL, NULL, NULL, NULL),
(43, 'registeration-status_update', NULL, NULL, NULL, NULL),
(44, 'registeration-status_delete', NULL, NULL, NULL, NULL),
(45, 'registeration-methods_read', NULL, NULL, NULL, NULL),
(46, 'registeration-methods_create', NULL, NULL, NULL, NULL),
(47, 'registeration-methods_update', NULL, NULL, NULL, NULL),
(48, 'registeration-methods_delete', NULL, NULL, NULL, NULL),
(49, 'departments_read', NULL, NULL, NULL, NULL),
(50, 'departments_create', NULL, NULL, NULL, NULL),
(51, 'departments_update', NULL, NULL, NULL, NULL),
(52, 'departments_delete', NULL, NULL, NULL, NULL),
(53, 'divisions_read', NULL, NULL, NULL, NULL),
(54, 'divisions_create', NULL, NULL, NULL, NULL),
(55, 'divisions_update', NULL, NULL, NULL, NULL),
(56, 'divisions_delete', NULL, NULL, NULL, NULL),
(57, 'qualifications_read', NULL, NULL, NULL, NULL),
(58, 'qualifications_create', NULL, NULL, NULL, NULL),
(59, 'qualifications_update', NULL, NULL, NULL, NULL),
(60, 'qualifications_delete', NULL, NULL, NULL, NULL),
(61, 'qualification-types_read', NULL, NULL, NULL, NULL),
(62, 'qualification-types_create', NULL, NULL, NULL, NULL),
(63, 'qualification-types_update', NULL, NULL, NULL, NULL),
(64, 'qualification-types_delete', NULL, NULL, NULL, NULL),
(65, 'parent-jobs_read', NULL, NULL, NULL, NULL),
(66, 'parent-jobs_create', NULL, NULL, NULL, NULL),
(67, 'parent-jobs_update', NULL, NULL, NULL, NULL),
(68, 'parent-jobs_delete', NULL, NULL, NULL, NULL),
(69, 'relations_read', NULL, NULL, NULL, NULL),
(70, 'relations_create', NULL, NULL, NULL, NULL),
(71, 'relations_update', NULL, NULL, NULL, NULL),
(72, 'relations_delete', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1);

-- --------------------------------------------------------

--
-- Table structure for table `permission_user`
--

CREATE TABLE `permission_user` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualifications`
--

CREATE TABLE `qualifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` double(8,2) NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qualifications`
--

INSERT INTO `qualifications` (`id`, `name`, `grade`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'ثانوية عامة وما يعادلها', 660.00, NULL, '2020-08-05 08:23:06', '2020-08-05 08:23:06');

-- --------------------------------------------------------

--
-- Table structure for table `qualification_types`
--

CREATE TABLE `qualification_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `qualification_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` double(8,2) NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `level_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qualification_types`
--

INSERT INTO `qualification_types` (`id`, `qualification_id`, `name`, `grade`, `notes`, `created_at`, `updated_at`, `level_id`) VALUES
(1, 1, 'ادبى', 220.00, NULL, '2020-08-05 08:31:04', '2020-08-05 08:31:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `qualification_years`
--

CREATE TABLE `qualification_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `qualification_id` int(10) UNSIGNED NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `acceptance_grade` double(8,2) NOT NULL,
  `level_id` int(10) UNSIGNED NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registeration_status`
--

CREATE TABLE `registeration_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registeration_status`
--

INSERT INTO `registeration_status` (`id`, `name`, `notes`, `created_at`, `updated_at`) VALUES
(2, 'حالة 2', NULL, '2020-08-05 07:26:40', '2020-08-05 07:27:59');

-- --------------------------------------------------------

--
-- Table structure for table `registration_methods`
--

CREATE TABLE `registration_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registration_methods`
--

INSERT INTO `registration_methods` (`id`, `name`, `notes`, `created_at`, `updated_at`) VALUES
(2, 'الفيسبوك', NULL, '2020-08-05 07:51:45', '2020-08-05 07:51:45');

-- --------------------------------------------------------

--
-- Table structure for table `relative_relation`
--

CREATE TABLE `relative_relation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `relative_relation`
--

INSERT INTO `relative_relation` (`id`, `name`, `notes`, `created_at`, `updated_at`) VALUES
(2, 'م', NULL, '2020-08-08 05:54:41', '2020-08-08 05:54:41');

-- --------------------------------------------------------

--
-- Table structure for table `required_documents`
--

CREATE TABLE `required_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('original','copy','both') COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'Super Admin', 'Super Admin', '2020-08-05 06:53:17', '2020-08-05 06:53:17'),
(2, 'hr', NULL, NULL, '2020-08-07 07:30:16', '2020-08-07 07:30:16');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`, `user_type`) VALUES
(1, 1, 'App\\User'),
(1, 2, 'App\\User');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acceptance_grade` double(8,2) NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specializations`
--

CREATE TABLE `specializations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationality_id` int(10) UNSIGNED NOT NULL,
  `gender` enum('ذكر','انثى') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `academic_years_id` int(10) UNSIGNED NOT NULL,
  `registeration_date` date NOT NULL,
  `qualification_types_id` int(10) UNSIGNED NOT NULL,
  `qualification_date` date NOT NULL,
  `qualification_set_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_1_id` int(10) UNSIGNED NOT NULL,
  `language_2_id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `government_id` int(10) UNSIGNED NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `religion` enum('مسلم','مسيحى') COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL,
  `military_status_id` int(10) UNSIGNED NOT NULL,
  `military_area_id` int(10) UNSIGNED NOT NULL,
  `national_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` double(8,2) NOT NULL,
  `level_id` int(10) UNSIGNED NOT NULL,
  `triple_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_place_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_attributes`
--

CREATE TABLE `student_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `attributes_id` int(10) UNSIGNED NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_logs`
--

CREATE TABLE `student_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `student_status_id` int(10) UNSIGNED NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_military_history`
--

CREATE TABLE `student_military_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `military_status_id` int(11) NOT NULL,
  `military_settings_id` int(11) NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_required_documents`
--

CREATE TABLE `student_required_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `required_document_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validation` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_status`
--

CREATE TABLE `student_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_work`
--

CREATE TABLE `team_work` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sign_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `key`, `name_ar`, `name_en`, `created_at`, `updated_at`) VALUES
(3, 'main_settings', NULL, 'main settings', '2020-08-08 07:36:07', '2020-08-08 07:36:07'),
(4, 'not_found', 'الاعوام الدراسية', 'Not Found', '2020-08-08 07:36:07', '2020-08-08 07:36:07'),
(5, 'academic_year', NULL, 'Academic year', '2020-08-08 07:36:50', '2020-08-08 07:36:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `image`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `phone`) VALUES
(1, 'admin', 'admin', 'uploads/User_icon_2.svg.png', 'admin@admin.com', '2020-08-05 06:53:18', '$2y$10$I3R3JZ47Gn94qQ7Fz6Y0ueKwjZAChb6sYzDww31e3b0zm4yB7T2qK', NULL, '2020-08-05 06:53:18', '2020-08-05 06:53:18', '01100968183'),
(2, 'مصطفىى', 'مصطفىى', 'uploads/User_icon_2.svg.png', 'admin@admin.comm', NULL, '$2y$10$hD5nzYdZiKbIQspwKoLhRuDi0D8lU.wC45CO9E.U8VnYZPTCTd17q', NULL, '2020-08-05 09:27:47', '2020-08-05 09:27:47', '0110096812');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `applications_code_unique` (`code`);

--
-- Indexes for table `application_required`
--
ALTER TABLE `application_required`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments_levels`
--
ALTER TABLE `departments_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `globale_settings`
--
ALTER TABLE `globale_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `governments`
--
ALTER TABLE `governments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_histories`
--
ALTER TABLE `login_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `military_areas`
--
ALTER TABLE `military_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `military_settings`
--
ALTER TABLE `military_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `military_status`
--
ALTER TABLE `military_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nationalities`
--
ALTER TABLE `nationalities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent_jobs`
--
ALTER TABLE `parent_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent_relation_type`
--
ALTER TABLE `parent_relation_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
  ADD KEY `permission_user_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qualification_types`
--
ALTER TABLE `qualification_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qualification_years`
--
ALTER TABLE `qualification_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registeration_status`
--
ALTER TABLE `registeration_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration_methods`
--
ALTER TABLE `registration_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `relative_relation`
--
ALTER TABLE `relative_relation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `required_documents`
--
ALTER TABLE `required_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`,`user_type`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_attributes`
--
ALTER TABLE `student_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_logs`
--
ALTER TABLE `student_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_military_history`
--
ALTER TABLE `student_military_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_required_documents`
--
ALTER TABLE `student_required_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_status`
--
ALTER TABLE `student_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_work`
--
ALTER TABLE `team_work`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `translations_key_unique` (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `application_required`
--
ALTER TABLE `application_required`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `departments_levels`
--
ALTER TABLE `departments_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `globale_settings`
--
ALTER TABLE `globale_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `governments`
--
ALTER TABLE `governments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `login_histories`
--
ALTER TABLE `login_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `military_areas`
--
ALTER TABLE `military_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `military_settings`
--
ALTER TABLE `military_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `military_status`
--
ALTER TABLE `military_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `nationalities`
--
ALTER TABLE `nationalities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `parent_jobs`
--
ALTER TABLE `parent_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `parent_relation_type`
--
ALTER TABLE `parent_relation_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `qualifications`
--
ALTER TABLE `qualifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `qualification_types`
--
ALTER TABLE `qualification_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `qualification_years`
--
ALTER TABLE `qualification_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `registeration_status`
--
ALTER TABLE `registeration_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `registration_methods`
--
ALTER TABLE `registration_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `relative_relation`
--
ALTER TABLE `relative_relation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `required_documents`
--
ALTER TABLE `required_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `specializations`
--
ALTER TABLE `specializations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_attributes`
--
ALTER TABLE `student_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_logs`
--
ALTER TABLE `student_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_military_history`
--
ALTER TABLE `student_military_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_required_documents`
--
ALTER TABLE `student_required_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_status`
--
ALTER TABLE `student_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `team_work`
--
ALTER TABLE `team_work`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
