-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 24, 2024 at 03:57 AM
-- Server version: 8.3.0
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skool`
--

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

DROP TABLE IF EXISTS `batches`;
CREATE TABLE IF NOT EXISTS `batches` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merit_seat` int NOT NULL,
  `payment_seat` int NOT NULL,
  `tution_fee` decimal(8,2) NOT NULL,
  `start_date` date NOT NULL,
  `course_tenure` tinyint UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `batches_code_unique` (`code`),
  KEY `batches_course_id_foreign` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `code`, `course_id`, `name`, `merit_seat`, `payment_seat`, `tution_fee`, `start_date`, `course_tenure`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'T.T.C-2024-2025', 3, 'T.T.C-2024', 0, 50, 60000.00, '2024-05-29', 12, NULL, '2024-05-28 04:23:57', '2024-05-28 04:23:57'),
(2, 'B.Ed-2024-2026', 2, 'B.Ed 2024-2026', 70, 30, 240000.00, '2024-05-30', 24, NULL, '2024-05-28 04:30:14', '2024-05-28 04:30:14');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `school_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `courses_code_unique` (`code`),
  KEY `courses_school_id_foreign` (`school_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `school_id`, `name`, `code`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Management', 'management', NULL, '2024-05-28 04:22:21', '2024-05-28 04:22:21'),
(2, 1, 'Bachelor Of Education', 'B.Ed', NULL, '2024-05-28 04:22:22', '2024-05-28 04:22:22'),
(3, 1, 'Teacher Training Course', 'T.T.C', NULL, '2024-05-28 04:22:22', '2024-05-28 04:22:22');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_code_unique` (`code`),
  KEY `departments_course_id_foreign` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `course_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'English', 'B.Ed-Eng', 2, NULL, '2024-05-28 04:31:03', '2024-05-28 04:31:03'),
(2, 'Maths', 'B.Ed-Mat', 2, NULL, '2024-05-28 04:31:20', '2024-05-28 04:31:20'),
(3, 'Physics', 'B.Ed-Phy', 2, NULL, '2024-05-28 04:31:34', '2024-05-28 04:31:34'),
(4, 'Dummy', 'B.Ed-Dum', 2, NULL, '2024-06-30 15:45:52', '2024-06-30 15:45:52');

-- --------------------------------------------------------

--
-- Table structure for table `employee_expenses`
--

DROP TABLE IF EXISTS `employee_expenses`;
CREATE TABLE IF NOT EXISTS `employee_expenses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `voucher_no` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `expense_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `description` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settled` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_expenses_voucher_no_unique` (`voucher_no`),
  KEY `employee_expenses_employee_id_index` (`employee_id`),
  KEY `employee_expenses_expense_id_index` (`expense_id`),
  KEY `employee_expenses_created_by_index` (`created_by`),
  KEY `employee_expenses_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `employee_expense_masters`
--

DROP TABLE IF EXISTS `employee_expense_masters`;
CREATE TABLE IF NOT EXISTS `employee_expense_masters` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_expense_masters_status_index` (`status`),
  KEY `employee_expense_masters_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_05_23_135606_create_schools', 1),
(2, '2014_09_11_123556_create_courses_table', 1),
(3, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2024_05_23_090531_create_permission_tables', 1),
(8, '2024_05_24_140148_create_batches_table', 1),
(9, '2024_05_27_042454_create_departments_table', 1),
(10, '2024_10_12_000000_create_users_table', 1),
(11, '2024_05_31_062131_create_students_table', 2),
(12, '2024_06_23_083616_create_student_seat_type', 3),
(13, '2024_06_24_145351_create_vehicles_table', 4),
(14, '2024_06_26_155159_create_vehicle_expenses', 4),
(15, '2024_06_26_170948_vehicle_expense_master', 4),
(16, '2024_07_12_171526_create_students_expense_masters_table', 5),
(18, '2024_07_16_134026_create_students_expenses_table', 6),
(19, '2024_07_12_154301_create_employee_expense_masters_table', 7),
(20, '2024_07_12_154302_create_employee_expenses_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 3),
(1, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(4, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 10);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'school_add', 'web', '2024-05-28 04:22:22', '2024-05-28 04:22:22'),
(2, 'school_delete', 'web', '2024-05-28 04:22:23', '2024-05-28 04:22:23'),
(3, 'school_edit', 'web', '2024-05-28 04:22:23', '2024-05-28 04:22:23'),
(4, 'school_view', 'web', '2024-05-28 04:22:23', '2024-05-28 04:22:23'),
(5, 'course_add', 'web', '2024-05-28 04:22:23', '2024-05-28 04:22:23'),
(6, 'course_delete', 'web', '2024-05-28 04:22:24', '2024-05-28 04:22:24'),
(7, 'course_edit', 'web', '2024-05-28 04:22:24', '2024-05-28 04:22:24'),
(8, 'course_view', 'web', '2024-05-28 04:22:24', '2024-05-28 04:22:24'),
(9, 'batch_add', 'web', '2024-05-28 04:22:24', '2024-05-28 04:22:24'),
(10, 'batch_delete', 'web', '2024-05-28 04:22:24', '2024-05-28 04:22:24'),
(11, 'batch_edit', 'web', '2024-05-28 04:22:24', '2024-05-28 04:22:24'),
(12, 'batch_view', 'web', '2024-05-28 04:22:24', '2024-05-28 04:22:24'),
(13, 'department_add', 'web', '2024-05-28 04:22:24', '2024-05-28 04:22:24'),
(14, 'department_delete', 'web', '2024-05-28 04:22:25', '2024-05-28 04:22:25'),
(15, 'department_edit', 'web', '2024-05-28 04:22:25', '2024-05-28 04:22:25'),
(16, 'department_view', 'web', '2024-05-28 04:22:25', '2024-05-28 04:22:25'),
(17, 'employee_add', 'web', '2024-05-28 04:22:25', '2024-05-28 04:22:25'),
(18, 'employee_delete', 'web', '2024-05-28 04:22:25', '2024-05-28 04:22:25'),
(19, 'employee_edit', 'web', '2024-05-28 04:22:25', '2024-05-28 04:22:25'),
(20, 'employee_view', 'web', '2024-05-28 04:22:25', '2024-05-28 04:22:25'),
(21, 'student_add', 'web', '2024-05-28 04:22:25', '2024-05-28 04:22:25'),
(22, 'student_delete', 'web', '2024-05-28 04:22:26', '2024-05-28 04:22:26'),
(23, 'student_edit', 'web', '2024-05-28 04:22:26', '2024-05-28 04:22:26'),
(24, 'student_view', 'web', '2024-05-28 04:22:26', '2024-05-28 04:22:26'),
(25, 'permissions_add', 'web', NULL, NULL),
(26, 'permissions_delete', 'web', NULL, NULL),
(27, 'permissions_edit', 'web', NULL, NULL),
(28, 'permissions_view', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Management', 'web', '2024-05-28 04:22:22', '2024-05-28 04:22:22'),
(2, 'Organizer', 'web', '2024-05-28 04:22:22', '2024-05-28 04:22:22'),
(3, 'Accountant', 'web', '2024-05-28 04:22:22', '2024-05-28 04:22:22'),
(4, 'Teacher', 'web', '2024-05-28 04:22:22', '2024-05-28 04:22:22'),
(5, 'Staff', 'web', '2024-05-28 04:22:22', '2024-05-28 04:22:22');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
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
(27, 1),
(28, 1),
(1, 2),
(3, 2),
(4, 2),
(5, 2),
(7, 2),
(8, 2),
(9, 2),
(11, 2),
(12, 2),
(13, 2),
(15, 2),
(16, 2),
(17, 2),
(19, 2),
(20, 2),
(21, 2),
(23, 2),
(24, 2),
(4, 3),
(8, 3),
(12, 3),
(16, 3),
(20, 3),
(24, 3);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

DROP TABLE IF EXISTS `schools`;
CREATE TABLE IF NOT EXISTS `schools` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `affiliation_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `schools_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `code`, `affiliation_no`, `phone`, `email`, `address`, `logo`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'St Johns Residential School', 'STJRS', NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-28 04:22:21', '2024-05-28 04:22:21');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `contact_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_relation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seat_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `donation` double DEFAULT NULL,
  `referred_by` bigint DEFAULT NULL,
  `address` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admission_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` bigint NOT NULL,
  `batch_id` bigint NOT NULL,
  `department_id` bigint NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_admission_no_unique` (`admission_no`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `dob`, `contact_number`, `contact_person`, `student_relation`, `seat_type`, `donation`, `referred_by`, `address`, `gender`, `admission_no`, `course_id`, `batch_id`, `department_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'hemanth', '2024-07-18', '21321233', '2525252', 'werewrewr', '1', 4432324324, 1, NULL, 'male', '3213', 1, 1, 1, NULL, '2024-07-14 12:15:53', '2024-07-16 07:29:26'),
(2, 'etettt', '2024-07-17', '4664365654', 'tteetrt', 'dhjdgjgdjg', '1', 234352535, 1, NULL, 'male', '321355', 2, 2, 2, '2024-07-14 13:52:12', '2024-07-14 13:51:58', '2024-07-14 13:52:12'),
(3, 'ghfhh', '2024-07-25', '645654564', 'sgjhjjgf', 'hhgffhhg', '2', 45654556, 7, NULL, 'male', '2423324342', 2, 1, 2, NULL, '2024-07-14 13:55:50', '2024-07-14 13:55:50'),
(4, 'sdffdssfdsdfd', '2024-07-19', '24343432342', '23324342342', 'sdfdfsfds', '1', 324432342, 7, NULL, 'male', '332432342', 2, 1, 1, NULL, '2024-07-14 14:09:57', '2024-07-14 14:09:57');

-- --------------------------------------------------------

--
-- Table structure for table `students_expenses`
--

DROP TABLE IF EXISTS `students_expenses`;
CREATE TABLE IF NOT EXISTS `students_expenses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` bigint UNSIGNED NOT NULL,
  `reciept_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expense_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `students_expenses`
--

INSERT INTO `students_expenses` (`id`, `student_id`, `reciept_no`, `expense_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 'REC-000001', 1, 5300.00, '2024-07-16 17:19:29', '2024-07-19 15:49:21'),
(2, 1, 'REC-000002', 2, 5000.00, '2024-07-16 17:20:46', '2024-07-16 17:20:46'),
(3, 1, 'REC-000003', 1, 5000.00, '2024-07-16 17:21:32', '2024-07-16 17:21:32'),
(4, 1, 'REC-000004', 1, 9000.00, '2024-07-19 15:56:16', '2024-07-19 15:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `students_expense_masters`
--

DROP TABLE IF EXISTS `students_expense_masters`;
CREATE TABLE IF NOT EXISTS `students_expense_masters` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `expense_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `students_expense_masters`
--

INSERT INTO `students_expense_masters` (`id`, `expense_name`, `created_at`, `deleted_at`, `updated_at`, `status`) VALUES
(1, 'Fees', '2024-07-14 09:27:32', NULL, '2024-07-14 09:30:55', 1),
(2, 'Donation', '2024-07-14 09:31:09', NULL, '2024-07-14 09:31:20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_seat_type`
--

DROP TABLE IF EXISTS `student_seat_type`;
CREATE TABLE IF NOT EXISTS `student_seat_type` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `student_seat_type`
--

INSERT INTO `student_seat_type` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Merit Seat', 1, '2024-06-23 03:38:12', '2024-06-23 03:38:12'),
(2, 'Management Seat', 1, '2024-06-23 03:38:12', '2024-06-23 03:38:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_course_id_foreign` (`course_id`),
  KEY `users_role_id_foreign` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `designation`, `course_id`, `role_id`, `address`, `phone`, `dob`, `deleted_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Administrator', 'management@skool.com', NULL, '$2y$12$/kQ192IBfPa6gGhEZZGzVuD1RVuOTJ4dedqfVRIiU5kSmS4nyqiRK', 'Manager', 1, 1, 'MRA-24, Muthoor, Thiruvalla, Pathanamthitta', '952601254', '1999-05-30', NULL, NULL, '2024-05-28 04:22:26', '2024-06-28 12:50:27'),
(2, 'Accountant User', 'accounts@skool.com', NULL, '$2y$12$rpaKtfFNlt1PZDsp.wvvreBUiaIuI03tMzBqnYTAfxN102FsPwE.C', 'Accountant', 2, 3, 'Address of the employee', '9524510224', '2024-05-27', NULL, NULL, '2024-05-28 05:21:33', '2024-05-28 05:21:33'),
(3, 'B.Ed Clerk', 'clerk@skool.com', NULL, '$2y$12$knmRmuLVfWXgvTMIcY6DkOEU.udDEwpHAlvT0hrD6a7ySdy0jbHxa', 'Staff', 2, 2, 'House Number, Street, Place , District', '9526015009', '1985-05-01', NULL, NULL, '2024-05-28 06:21:15', '2024-06-23 03:02:22'),
(4, 'TTC Clerk', 'ttcclerk@skool.com', NULL, '$2y$12$NKfFWXUFlwyqAH/yBStdeOgt3L6HwgQVQ5TlQO6jYDG/E8KaXuy0a', 'Staff', 3, 5, 'House Number, Street, Place , District, State, Country', '9895232564', '1998-05-14', NULL, NULL, '2024-05-28 06:23:20', '2024-05-28 06:23:20'),
(5, 'Admission Cordinator', 'ac@skool.com', NULL, '$2y$12$oFiwDjQVF.VYExIzLq0er.JbcvTuKK8RD8wxGebVIzV1gd0fw8ydC', 'Other', 3, 5, 'Address', '9526015009', '1990-05-29', NULL, NULL, '2024-05-28 06:57:36', '2024-05-29 08:57:16'),
(6, 'Principal', 'principal@skool.com', NULL, '$2y$12$8D3k4DxgUM5wx2QG4qhaL.doEp2Pht0786Te8INU9BxjchAcMR4iW', 'Teacher', 3, 2, 'Address', '9524510224', '1994-05-26', NULL, NULL, '2024-05-28 07:04:07', '2024-05-28 07:04:07'),
(7, 'Arun Raj G.S', 'arun@skool.com', NULL, '$2y$12$d6GYdMi5vqjSAqz218ERLuWGibIDAr7VoZyf/2mP2OzKMpatAYIry', 'Manager', 1, 1, 'MRA-24, Kottoorathil House, Muthoor, Thiruvalla, Kerala', '9526015009', '1986-05-29', NULL, NULL, '2024-05-29 01:08:57', '2024-05-29 08:54:38'),
(8, 'Hemanth U K', 'hemanth2uk@gmail.com', NULL, '$2y$12$JO3kIbJ.fcDSVTACMv/N1eGXE8hpyhKTxkMry10BbxJeRmaUQdCU.', 'Accountant', 2, 3, 'Hemanth Address', '9526015009', '1986-05-29', NULL, NULL, '2024-06-09 05:04:22', '2024-06-09 05:04:22'),
(9, 'Dummy User', 'dummy1@gmail.com', NULL, '$2y$12$aD3xDRdhuK3aca8NjbL4vuf66V1YPykc.chZiPqU/EureS7f/Ld5O', 'Teacher', 2, 4, 'Dummy Address', '9526015009', '1990-07-30', NULL, NULL, '2024-06-09 05:09:12', '2024-06-09 05:09:12'),
(10, 'Naveen D A', 'naveen@skool.com', NULL, '$2y$12$tYuZjh3BAs2U0p7qx3ypQ.hnEG918mdTACigyOL8uEV9NCDdL6Gcy', 'Manager', 3, 2, 'Naveen, Kurichi, Kottayam', '95263012554', '1986-05-29', NULL, NULL, '2024-06-30 05:46:43', '2024-06-30 05:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `plate_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fuel` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vehicles_plate_number_unique` (`plate_number`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `plate_number`, `fuel`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'KL-27-D-7852', 'diesel', 'Toyota Innova 8 Seater Mica Grey', NULL, '2024-06-27 11:25:56', '2024-06-27 11:25:56'),
(2, 'KL-27-3770', 'diesel', 'Innova 8 Seater Silky Silver', NULL, '2024-06-27 11:26:29', '2024-06-27 11:26:29'),
(3, 'KL-24-946', 'petrol', 'Maruthi Suzuki Alto K-10', NULL, '2024-06-27 11:27:19', '2024-06-27 11:27:19'),
(4, 'KL-02-3009', 'petrol', 'Maruthi Alto 800', NULL, '2024-07-11 18:25:09', '2024-07-11 18:25:09');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_expenses`
--

DROP TABLE IF EXISTS `vehicle_expenses`;
CREATE TABLE IF NOT EXISTS `vehicle_expenses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `vehicle_id` int NOT NULL,
  `expense_id` int NOT NULL,
  `amount` double(8,2) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `vehicle_expenses`
--

INSERT INTO `vehicle_expenses` (`id`, `vehicle_id`, `expense_id`, `amount`, `description`, `created_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 10000.00, 'July fuel', 7, NULL, '2024-07-11 17:23:37', '2024-07-11 17:23:37'),
(2, 3, 3, 10000.00, 'Service and re-balancing', 7, NULL, '2024-07-11 17:46:36', '2024-07-11 17:46:36'),
(3, 2, 3, 15000.00, '2024 Vehicle test', 7, NULL, '2024-07-11 17:59:33', '2024-07-11 17:59:33'),
(4, 2, 3, 15000.00, '2024 Vehicle test', 7, NULL, '2024-07-11 18:23:49', '2024-07-11 18:23:49'),
(5, 4, 2, 15000.00, 'Insurance for 2024', 7, NULL, '2024-07-11 18:25:58', '2024-07-11 18:25:58');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_expense_master`
--

DROP TABLE IF EXISTS `vehicle_expense_master`;
CREATE TABLE IF NOT EXISTS `vehicle_expense_master` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `vehicle_expense_master`
--

INSERT INTO `vehicle_expense_master` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Fuel', NULL, '2024-06-27 11:31:49', '2024-06-27 11:31:49'),
(2, 'Insurance', NULL, '2024-06-27 11:31:50', '2024-06-27 11:31:50'),
(3, 'Maintenance', NULL, '2024-06-27 11:31:50', '2024-06-27 11:31:50'),
(4, 'Painting', NULL, '2024-06-27 11:31:50', '2024-06-27 11:31:50'),
(5, 'Penalty', NULL, '2024-06-27 11:31:50', '2024-06-27 11:31:50');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `batches`
--
ALTER TABLE `batches`
  ADD CONSTRAINT `batches_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_expenses`
--
ALTER TABLE `employee_expenses`
  ADD CONSTRAINT `employee_expenses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_expenses_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_expenses_expense_id_foreign` FOREIGN KEY (`expense_id`) REFERENCES `employee_expense_masters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
