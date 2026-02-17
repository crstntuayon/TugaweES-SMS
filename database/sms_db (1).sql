-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 17, 2026 at 03:04 PM
-- Server version: 8.0.45
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('admin','teacher') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `user_id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED DEFAULT NULL,
  `is_pinned` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `type`, `user_id`, `section_id`, `is_pinned`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'Meeting', 'Grade 2 Parents. February 23, 2026 @3:00 PM.', 'teacher', 42, NULL, 0, '2026-02-16 05:47:09', '2026-02-16 05:56:03', NULL),
(5, 'PTA Meeting', 'All parents. @2:00 PM.', 'admin', 1, NULL, 0, '2026-02-16 05:59:16', '2026-02-16 08:02:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` enum('none','present','late','absent') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `student_id`, `section_id`, `date`, `status`, `created_at`, `updated_at`) VALUES
(119, 61, 40, '2026-02-02', 'present', '2026-02-10 04:36:45', '2026-02-10 04:36:45'),
(120, 61, 40, '2026-02-03', 'present', '2026-02-10 04:36:46', '2026-02-10 04:36:46'),
(121, 61, 40, '2026-02-04', 'present', '2026-02-10 04:36:46', '2026-02-10 04:36:46'),
(122, 61, 40, '2026-02-05', 'present', '2026-02-10 04:36:46', '2026-02-10 04:36:46'),
(123, 61, 40, '2026-02-06', 'present', '2026-02-10 04:36:46', '2026-02-10 04:36:46'),
(124, 61, 40, '2026-02-09', 'present', '2026-02-10 04:36:46', '2026-02-10 04:36:46'),
(125, 61, 40, '2026-02-10', 'present', '2026-02-10 04:36:46', '2026-02-10 04:36:46'),
(126, 61, 40, '2026-02-11', 'late', '2026-02-10 04:36:46', '2026-02-10 05:57:02'),
(127, 61, 40, '2026-02-12', 'absent', '2026-02-10 04:36:46', '2026-02-10 05:57:02'),
(128, 61, 40, '2026-02-13', 'present', '2026-02-10 04:36:46', '2026-02-10 16:08:47'),
(129, 61, 40, '2026-02-16', 'late', '2026-02-10 04:36:46', '2026-02-10 16:08:47'),
(130, 61, 40, '2026-02-17', 'present', '2026-02-10 04:36:46', '2026-02-10 16:09:38'),
(131, 61, 40, '2026-02-18', 'present', '2026-02-10 04:36:46', '2026-02-10 16:09:38'),
(132, 61, 40, '2026-02-19', 'present', '2026-02-10 04:36:46', '2026-02-10 16:09:38'),
(133, 61, 40, '2026-02-20', 'late', '2026-02-10 04:36:46', '2026-02-10 16:09:38'),
(134, 61, 40, '2026-02-23', 'present', '2026-02-10 04:36:46', '2026-02-10 16:09:38'),
(135, 61, 40, '2026-02-24', 'present', '2026-02-10 04:36:46', '2026-02-10 16:09:38'),
(136, 61, 40, '2026-02-25', 'present', '2026-02-10 04:36:46', '2026-02-10 16:09:38'),
(137, 61, 40, '2026-02-26', 'present', '2026-02-10 04:36:46', '2026-02-10 16:09:38'),
(138, 61, 40, '2026-02-27', 'present', '2026-02-10 04:36:46', '2026-02-10 16:09:38'),
(139, 61, 40, '2026-01-01', 'present', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(140, 61, 40, '2026-01-02', 'present', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(141, 61, 40, '2026-01-05', 'present', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(142, 61, 40, '2026-01-06', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(143, 61, 40, '2026-01-07', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(144, 61, 40, '2026-01-08', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(145, 61, 40, '2026-01-09', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(146, 61, 40, '2026-01-12', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(147, 61, 40, '2026-01-13', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(148, 61, 40, '2026-01-14', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(149, 61, 40, '2026-01-15', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(150, 61, 40, '2026-01-16', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(151, 61, 40, '2026-01-19', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(152, 61, 40, '2026-01-20', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(153, 61, 40, '2026-01-21', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(154, 61, 40, '2026-01-22', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(155, 61, 40, '2026-01-23', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(156, 61, 40, '2026-01-26', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(157, 61, 40, '2026-01-27', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(158, 61, 40, '2026-01-28', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(159, 61, 40, '2026-01-29', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51'),
(160, 61, 40, '2026-01-30', 'none', '2026-02-10 06:21:51', '2026-02-10 06:21:51');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_records`
--

CREATE TABLE `attendance_records` (
  `id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `quarter` tinyint NOT NULL,
  `grade` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `quarter`, `grade`, `created_at`, `updated_at`) VALUES
(1, 156, 93, 1, 88.00, '2026-02-17 04:02:48', '2026-02-17 04:02:48'),
(2, 156, 94, 1, 83.00, '2026-02-17 04:23:37', '2026-02-17 05:12:40'),
(3, 156, 95, 1, 87.00, '2026-02-17 05:13:18', '2026-02-17 05:13:18'),
(4, 156, 96, 1, 86.00, '2026-02-17 05:16:30', '2026-02-17 05:16:30');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_27_123811_create_roles_table', 2),
(5, '2026_01_27_123927_add_role_id_to_users_table', 3),
(6, '2026_01_27_125206_create_students_table', 4),
(7, '2026_01_27_131235_create_attendance_records_table', 5),
(8, '2026_01_27_131235_create_attendances_table', 5),
(9, '2026_01_27_132003_create_subjects_table', 6),
(10, '2026_01_27_132004_create_grades_table', 6),
(11, '2026_01_28_012026_add_student_fields_to_users_table', 7),
(12, '2026_01_29_022208_make_user_id_nullable_in_students_table', 8),
(13, '2026_01_29_045644_add_capacity_to_sections_table', 9),
(14, '2026_01_29_052644_make_teacher_id_nullable_in_sections_table', 10),
(15, '2026_01_29_061618_create_year_levels_table', 11),
(16, '2026_01_29_123052_add_year_level_to_sections_table', 12),
(17, '2026_01_29_123245_add_school_year_to_sections_table', 13),
(18, '2026_01_29_125456_fill_null_year_level_and_school_year_in_sections_table', 14),
(19, '2026_01_29_130139_make_year_level_and_school_year_not_nullable_in_sections_table', 15),
(20, '2026_01_29_131043_change_year_level_to_string_in_sections_table', 16),
(21, '2026_01_29_131952_make_year_level_and_school_year_not_nullable_in_sections_table', 17),
(22, '2026_01_29_132656_set_default_yearlevel_and_schoolyear_in_sections_table', 18),
(23, '2026_01_29_133750_make_year_and_school_year_not_nullable_in_sections_table', 19),
(24, '2026_01_29_135434_add_default_to_year_level_in_sections_table', 20),
(25, '2026_01_29_135828_set_default_school_year_on_sections_table', 21),
(26, '2026_01_29_135829_set_default_school_year_on_sections_table', 21),
(27, '2026_01_29_150228_add_details_to_students_table', 22),
(28, '2026_01_29_152808_add_address_to_students_table', 23),
(29, '2026_01_29_170522_add_sex_to_students_table', 24),
(30, '2026_01_30_004924_add_sex_to_students_table', 25),
(31, '2026_01_31_050020_create_enrollments_table', 26),
(32, '2026_01_31_054802_create_teachers_table', 27),
(33, '2026_01_31_100826_add_teacher_id_to_students_table', 28),
(34, '2026_01_31_232621_add_school_id_to_students_table', 29),
(35, '2026_01_31_235758_add_photo_to_students_table', 30),
(36, '2026_01_31_235858_add_photo_to_teachers_table', 31),
(37, '2026_02_01_000010_add_school_id_to_teachers_table', 32),
(38, '2026_02_08_013953_create_section_student_table', 33),
(39, '2026_02_08_133247_create_grades_table', 34),
(40, '2026_02_08_133622_create_attendances_table', 35),
(41, '2026_02_09_130105_add_day_to_attendances_table', 36),
(42, '2026_02_09_131519_create_attendances_table', 37),
(43, '2026_02_09_132455_create_attendances_table', 38),
(44, '2026_02_09_132535_create_grades_table', 38),
(45, '2026_02_09_132852_remove_day_from_attendances_table', 39),
(46, '2026_02_09_140854_create_grades_table', 40),
(47, '2026_02_09_142014_add_average_grade_to_students_table', 41),
(48, '2026_02_09_153539_create_grades_table', 42),
(49, '2026_02_09_160343_create_attendances_table', 43),
(50, '2026_02_11_004251_create_school_years_table', 44),
(51, '2026_02_11_073152_create_teachers_table', 45),
(52, '2026_02_11_073500_create_section_teacher_table', 46),
(53, '2026_02_11_083812_add_program_fields_to_teachers_table', 47),
(54, '2026_02_11_092612_create_teaching_loads_table', 48),
(55, '2026_02_14_102340_create_student_subjects_table', 49),
(58, '2026_02_14_103839_create_section_subject_table', 50),
(59, '2026_02_15_011708_add_school_year_id_column_to_students_table', 51),
(60, '2026_02_15_065652_add_grade_level_to_students_table', 52),
(61, '2026_02_15_070411_add_grade_level_to_sections_table', 53),
(62, '2026_02_15_110502_make_birthday_nullable_in_teachers_table', 54),
(63, '2026_02_16_052424_create_announcements_table', 55),
(64, '2026_02_16_114809_add_login_attempts_to_users_table', 56),
(65, '2026_02_16_121943_create_announcements_table', 57),
(66, '2026_02_16_155026_add_soft_deletes_to_announcements_table', 58),
(67, '2026_02_16_164310_add_birthday_to_users_table', 59),
(68, '2026_02_17_092505_add_components_to_subjects_table', 60);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'System Admin', '2026-01-27 04:41:10', '2026-01-27 04:41:10'),
(2, 'Teacher', '2026-01-27 04:41:10', '2026-01-27 04:41:10'),
(3, 'Registrar', '2026-01-27 04:41:10', '2026-01-27 04:41:10'),
(4, 'Student', '2026-01-27 04:41:10', '2026-01-27 04:41:10');

-- --------------------------------------------------------

--
-- Table structure for table `school_years`
--

CREATE TABLE `school_years` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_years`
--

INSERT INTO `school_years` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '2025-2026', 1, '2026-02-10 17:00:16', '2026-02-15 01:02:15'),
(2, '2026-2027', 0, '2026-02-10 17:00:16', '2026-02-15 01:02:15'),
(3, '2027-2028', 0, '2026-02-10 17:00:16', '2026-02-15 01:02:15'),
(4, '2028-2029', 0, '2026-02-10 17:00:16', '2026-02-15 01:02:15'),
(5, '2029-2030', 0, '2026-02-10 17:00:16', '2026-02-15 01:02:15'),
(6, '2030-2031', 0, '2026-02-10 17:00:16', '2026-02-15 01:02:15'),
(7, '2031-2032', 0, '2026-02-10 17:00:16', '2026-02-15 01:02:15'),
(8, '2032-2033', 0, '2026-02-10 17:00:16', '2026-02-15 01:02:15'),
(9, '2033-2034', 0, '2026-02-10 17:00:16', '2026-02-15 01:02:15');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `teacher_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `capacity` int NOT NULL DEFAULT '40',
  `school_year_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `year_level`, `teacher_id`, `created_at`, `updated_at`, `capacity`, `school_year_id`) VALUES
(40, 'ASDILLO - AM', 'Kindergarten', 43, '2026-02-10 04:28:24', '2026-02-17 06:59:21', 40, 2),
(41, 'MANGINSAY', 'Grade 1', 44, '2026-02-11 22:47:19', '2026-02-16 17:38:14', 40, 1),
(42, 'NOCETE', 'Grade 2', 45, '2026-02-11 22:47:33', '2026-02-17 05:25:31', 40, 1),
(43, 'ASDILLO - PM', 'Kindergarten', 43, '2026-02-11 22:48:20', '2026-02-11 22:53:24', 40, 0),
(44, 'RUBIA', 'Grade 3', 47, '2026-02-11 22:49:05', '2026-02-11 22:53:39', 40, 0),
(45, 'SOJOR', 'Grade 3', 46, '2026-02-11 22:49:24', '2026-02-11 22:53:49', 40, 0),
(46, 'ALAMA', 'Grade 4', 48, '2026-02-11 22:51:06', '2026-02-11 22:54:01', 40, 0),
(47, 'RIO', 'Grade 5', 49, '2026-02-11 22:51:27', '2026-02-11 22:54:10', 40, 0),
(48, 'MONOPOLLO', 'Grade 6', 50, '2026-02-11 22:51:44', '2026-02-11 22:54:19', 40, 0),
(49, 'ALCORIZA', 'Grade 6', 51, '2026-02-11 22:52:19', '2026-02-11 22:54:27', 40, 0),
(50, 'SAMPAGUITA', 'Grade 6', 42, '2026-02-14 01:35:15', '2026-02-17 05:24:41', 40, 1),
(51, 'Gulamela', 'Grade 2', NULL, '2026-02-16 17:09:40', '2026-02-17 05:24:57', 40, 1),
(52, 'Santan', 'Grade 4', NULL, '2026-02-16 17:16:09', '2026-02-17 05:25:09', 40, 1),
(53, 'Daisy', 'Grade 1', NULL, '2026-02-16 17:38:53', '2026-02-17 05:25:20', 40, 1),
(54, 'Lily', 'Grade 2', NULL, '2026-02-16 17:42:51', '2026-02-16 17:43:02', 40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `section_student`
--

CREATE TABLE `section_student` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section_subject`
--

CREATE TABLE `section_subject` (
  `id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section_teacher`
--

CREATE TABLE `section_teacher` (
  `id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('6fJFN0LGUDUGwezg4zGJBcZ1CqOFFGI2Wx4fKHSm', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ3VQOEptbFB1UUxIMnhYelFKUThFVUk4ZFpqbUlSMWhsTDBPSXp0cCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQvc3RhdHMiO3M6NToicm91dGUiO3M6MjE6ImFkbWluLmRhc2hib2FyZC5zdGF0cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1771340637);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint UNSIGNED NOT NULL,
  `lrn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `average_grade` decimal(5,2) DEFAULT NULL,
  `sex` enum('Male','Female') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suffix` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `section_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `teacher_id` bigint UNSIGNED DEFAULT NULL,
  `school_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_year_id` bigint UNSIGNED DEFAULT NULL,
  `grade_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `lrn`, `first_name`, `middle_name`, `last_name`, `average_grade`, `sex`, `suffix`, `birthday`, `email`, `contact_number`, `address`, `user_id`, `section_id`, `created_at`, `updated_at`, `teacher_id`, `school_id`, `photo`, `school_year_id`, `grade_level`) VALUES
(61, '120231090040', 'Crestian', 'Bajado', 'Tuayon', NULL, 'Male', 'Jr.', '2004-01-07', 'cresttuayon@gmail.com', '09368726547', 'Tugawe, Dauin, Negros Oriental', 39, 50, '2026-02-10 03:52:06', '2026-02-16 04:06:31', NULL, 'S-120231260001', 'students/IayQOCgaPC5eY4dIUelsyHpAv6WItUkR9t2EuCU9.jpg', 1, NULL),
(62, '120231260002', 'Kristian', 'Amparado', 'Alsola', NULL, 'Male', NULL, '2026-02-12', 'kristianalsola@gmail.com', NULL, NULL, 52, 40, '2026-02-11 23:00:56', '2026-02-12 20:35:54', NULL, 'S-120231260002', NULL, NULL, NULL),
(63, '120231260003', 'Rofer John', 'Decon', 'Araneta', NULL, 'Male', NULL, '2026-02-12', 'aranetareferjohn@gmail.com', NULL, NULL, 53, 40, '2026-02-11 23:02:34', '2026-02-12 20:35:54', NULL, 'S-120231260003', NULL, NULL, NULL),
(64, '120231260004', 'MERALD JAY', 'FLORES', 'DELES', NULL, 'Male', NULL, '2026-02-12', 'delesmeraldjay@gmail.com', NULL, NULL, 54, 40, '2026-02-11 23:06:52', '2026-02-12 20:35:54', NULL, 'S-120231260004', NULL, NULL, NULL),
(66, '120231260006', 'Geo', 'Rematcho', 'Mondido', NULL, 'Male', NULL, '2026-02-12', 'mondidogeo@gmail.com', NULL, NULL, 56, 40, '2026-02-11 23:12:38', '2026-02-12 20:35:54', NULL, 'S-120231260005', NULL, 1, NULL),
(67, '120231260005', 'Emman', 'Rematcho', 'Mondido', NULL, 'Male', NULL, '2026-02-12', 'emmanmondido@gmail.com', NULL, NULL, 57, 40, '2026-02-11 23:23:56', '2026-02-12 20:35:54', NULL, 'S-120231260006', NULL, NULL, NULL),
(68, '120231260007', 'Ivan', 'Rematcho', 'Mondido', NULL, 'Male', NULL, '2026-02-12', 'ivanmondido@gmail.com', NULL, NULL, 58, 40, '2026-02-11 23:25:04', '2026-02-12 20:35:54', NULL, 'S-120231260007', NULL, NULL, NULL),
(69, '120231260008', 'Christ Angelo', 'Bacud', 'Pelayo', NULL, 'Male', NULL, '2026-02-12', 'christangelopelayo@gmail.com', NULL, NULL, 59, 40, '2026-02-11 23:26:42', '2026-02-12 20:35:54', NULL, 'S-120231260008', NULL, NULL, NULL),
(70, '120231260009', 'Daryl', 'Solis', 'Sison', NULL, 'Male', NULL, '2026-02-12', 'sisondaryl@gmail.com', NULL, NULL, 60, 40, '2026-02-11 23:28:14', '2026-02-12 20:35:54', NULL, 'S-120231260009', NULL, NULL, NULL),
(71, '120231260010', 'John Marco', 'Bandian', 'Tinambacan', NULL, 'Male', NULL, '2026-02-12', 'johnmarcotinambacan@gmail.com', NULL, NULL, 61, 40, '2026-02-11 23:29:52', '2026-02-12 20:35:54', NULL, 'S-120231260010', NULL, NULL, NULL),
(72, '120231260011', 'Shawn Edrian', 'Trumata', 'Tubog', NULL, 'Male', NULL, '2026-02-12', 'shawnedriantubog@gmail.com', NULL, NULL, 62, 40, '2026-02-11 23:31:26', '2026-02-12 20:35:54', NULL, 'S-120231260011', NULL, NULL, NULL),
(73, '120231260012', 'Jeron', 'Ybañez', 'Viola', NULL, 'Male', NULL, '2026-02-12', 'violajeron@gmail.com', NULL, NULL, 63, 40, '2026-02-11 23:40:57', '2026-02-12 20:35:54', NULL, 'S-120231260012', NULL, NULL, NULL),
(74, '120231260013', 'Nathalia Zymth', 'Padaong', 'Alama', NULL, 'Female', NULL, '2026-02-12', 'alamanathaliazymth@gmail.com', NULL, NULL, 64, 40, '2026-02-11 23:46:47', '2026-02-12 20:35:54', NULL, 'S-120231260013', NULL, NULL, NULL),
(75, '120231260014', 'Sofia Nicole', 'Tuble', 'Callora', NULL, 'Female', NULL, '2026-02-12', 'callorasofianicole@gmail.com', NULL, NULL, 65, 40, '2026-02-11 23:48:08', '2026-02-12 20:35:54', NULL, 'S-120231260014', NULL, NULL, NULL),
(76, '120231260015', 'Miah Ele', 'Perater', 'Cofino', NULL, 'Female', NULL, '2026-02-12', 'cofinomiahele@gmail.com', NULL, NULL, 66, 40, '2026-02-11 23:49:28', '2026-02-12 20:35:54', NULL, 'S-120231260015', NULL, NULL, NULL),
(77, '120231260016', 'Aaliyah Gabrielle', 'Bantoto', 'Morato', NULL, 'Female', NULL, '2026-02-12', 'moratoaaliyahgabrielle@gmail.com', NULL, NULL, 67, 40, '2026-02-11 23:51:32', '2026-02-12 20:35:54', NULL, 'S-120231260016', NULL, NULL, NULL),
(78, '120231260017', 'Zoe', 'Tubog', 'Tabangan', NULL, 'Female', NULL, '2026-02-12', 'tabanganzoe@gmail.com', NULL, NULL, 68, 40, '2026-02-11 23:52:52', '2026-02-12 20:35:54', NULL, 'S-120231260017', NULL, NULL, NULL),
(79, '120231260018', 'Princess Coleen', 'Pontenilla', 'Toro', NULL, 'Female', NULL, '2026-02-12', 'toroprincesscoleen@gmail.com', NULL, NULL, 69, 40, '2026-02-11 23:54:32', '2026-02-12 20:35:54', NULL, 'S-120231260018', NULL, NULL, NULL),
(80, '120231260019', 'Jane Shannel', 'Bax', 'Tuban', NULL, 'Female', NULL, '2026-02-12', 'tubanjaneshannel@gmail.com', NULL, NULL, 70, 40, '2026-02-11 23:56:30', '2026-02-12 20:35:54', NULL, 'S-120231260019', NULL, NULL, NULL),
(81, '120231260020', 'Niana Marithe', 'Tubat', 'Tuban', NULL, 'Female', NULL, '2026-02-12', 'tubannianamarithe@gmail.com', NULL, NULL, 71, 40, '2026-02-11 23:58:12', '2026-02-12 20:35:54', NULL, 'S-120231260020', NULL, NULL, NULL),
(82, '120231260021', 'Jian', 'Requilme', 'Tuble', NULL, 'Female', NULL, '2026-02-12', 'tublejian@gmail.com', NULL, NULL, 72, 40, '2026-02-11 23:59:43', '2026-02-12 20:35:54', NULL, 'S-120231260021', NULL, NULL, NULL),
(83, '120231260022', 'Alexander', 'Magalso', 'Alas-as', NULL, 'Male', NULL, '2026-02-12', 'alasasalexander@gmail.com', NULL, NULL, 73, 43, '2026-02-12 00:15:01', '2026-02-12 20:38:13', NULL, 'S-120231260022', NULL, NULL, NULL),
(84, '120231260023', 'Donn Kieffer', 'Gerasol', 'Bantoto', NULL, 'Male', NULL, '2026-02-12', 'bantotodonnkieffer@gmail.com', NULL, NULL, 74, 43, '2026-02-12 00:18:20', '2026-02-12 20:38:13', NULL, 'S-120231260023', NULL, NULL, NULL),
(85, '120231260024', 'Maxwell Laurent', 'Torres', 'Bantoto', NULL, 'Male', NULL, '2026-02-12', 'bantotomaxwelllaurent@gmail.com', NULL, NULL, 75, 43, '2026-02-12 00:20:22', '2026-02-12 20:38:13', NULL, 'S-120231260024', NULL, NULL, NULL),
(86, '120231260025', 'Mark Christian', NULL, 'Pajente', NULL, 'Male', NULL, '2026-02-12', 'pajentemarkchristian@gmail.com', NULL, NULL, 76, 43, '2026-02-12 00:22:12', '2026-02-12 20:38:13', NULL, 'S-120231260025', NULL, NULL, NULL),
(87, '120231260026', 'Noel', NULL, 'Sardan', NULL, 'Male', NULL, '2026-02-12', 'sardannoel@gmail.com', NULL, NULL, 77, 43, '2026-02-12 00:23:22', '2026-02-12 20:38:13', NULL, 'S-120231260026', NULL, NULL, NULL),
(88, '120231260027', 'Christian', 'Mentawan', 'Veloz', NULL, 'Male', NULL, '2026-02-12', 'velozchristian@gmail.com', NULL, NULL, 78, 43, '2026-02-12 00:26:34', '2026-02-12 20:38:13', NULL, 'S-120231260027', NULL, NULL, NULL),
(89, '120231260028', 'Dhaine Gerhaine', 'Tubio', 'Aga', NULL, 'Female', NULL, '2026-02-12', 'agadhainegerhaine@gmail.com', NULL, NULL, 79, 43, '2026-02-12 00:28:17', '2026-02-12 20:38:13', NULL, 'S-120231260028', NULL, NULL, NULL),
(90, '120231260029', 'Carren', 'Barrios', 'Alcoriza', NULL, 'Female', NULL, '2026-02-12', 'alcorizacarren@gmail.com', NULL, NULL, 80, 43, '2026-02-12 00:30:04', '2026-02-12 20:38:13', NULL, 'S-120231260029', NULL, NULL, NULL),
(91, '120231260030', 'Marchell', 'Carreon', 'Bantoto', NULL, 'Female', NULL, '2026-02-12', 'bantotomarchell@gmail.com', NULL, NULL, 81, 43, '2026-02-12 00:31:50', '2026-02-12 20:38:13', NULL, 'S-120231260030', NULL, NULL, NULL),
(92, '120231260031', 'Merriam', 'De Jesus', 'Bantoto', NULL, 'Female', NULL, '2026-02-12', 'bantotomerriam@gmail.com', NULL, NULL, 82, 43, '2026-02-12 00:35:00', '2026-02-12 20:38:13', NULL, 'S-120231260031', NULL, NULL, NULL),
(93, '120231260032', 'Elizabelle Celyn', 'Alagadmo', 'Martinez', NULL, 'Female', NULL, '2026-02-12', 'martinezelizabellecelyn@gmail.com', NULL, NULL, 83, 43, '2026-02-12 00:38:53', '2026-02-12 20:38:13', NULL, 'S-120231260032', NULL, NULL, NULL),
(94, '120231260033', 'Jaira Jane', 'Cadayona', 'Orellana', NULL, 'Female', NULL, '2026-02-12', 'orellanajairajane@gmail.com', NULL, NULL, 84, 43, '2026-02-12 00:42:07', '2026-02-12 20:38:13', NULL, 'S-120231260033', NULL, NULL, NULL),
(95, '120231260034', 'Jelliana Gennely', NULL, 'Patilano', NULL, 'Female', NULL, '2026-02-12', 'patilanojellianagennely@gmail.com', NULL, NULL, 85, 43, '2026-02-12 00:43:35', '2026-02-12 20:38:13', NULL, 'S-120231260034', NULL, NULL, NULL),
(96, '120231260035', 'Mishca', 'Tilos', 'Quitoy', NULL, 'Female', NULL, '2026-02-12', 'quitoymishca@gmail.com', NULL, NULL, 86, 43, '2026-02-12 00:45:22', '2026-02-12 20:38:13', NULL, 'S-120231260035', NULL, NULL, NULL),
(97, '120231260036', 'Amber Mcquenzie', 'Alar', 'Salatan', NULL, 'Female', NULL, '2026-02-12', 'salatanambermcquenzie@gmail.com', NULL, NULL, 87, 43, '2026-02-12 00:47:08', '2026-02-12 20:38:13', NULL, 'S-120231260036', NULL, NULL, NULL),
(98, '120231260037', 'Jelah', 'Alama', 'Tose', NULL, 'Female', NULL, '2026-02-12', 'tosejelah@gmail.com', NULL, NULL, 88, 43, '2026-02-12 00:48:13', '2026-02-12 20:38:13', NULL, 'S-120231260037', NULL, NULL, NULL),
(99, '120231260038', 'Calista Dior', 'Bendijo', 'Trumata', NULL, 'Female', NULL, '2026-02-12', 'trumatacalistadior@gmail.com', NULL, NULL, 89, 43, '2026-02-12 00:49:26', '2026-02-12 20:38:13', NULL, 'S-120231260038', NULL, NULL, NULL),
(100, '120231260039', 'Zhia Mae', 'Monopollo', 'Tuble', NULL, 'Female', NULL, '2026-02-12', 'tublezhiamae@gmail.com', NULL, NULL, 90, 43, '2026-02-12 00:50:31', '2026-02-12 20:38:13', NULL, 'S-120231260039', NULL, NULL, NULL),
(101, '120231260040', 'Christine', 'Insid', 'Tubog', NULL, 'Female', NULL, '2026-02-12', 'tubogchristine@gmail.com', NULL, NULL, 91, 43, '2026-02-12 00:51:38', '2026-02-12 20:38:13', NULL, 'S-120231260040', NULL, NULL, NULL),
(102, '120231260041', 'Draven Ryle', 'Trumata', 'Alegre', NULL, 'Male', NULL, '2026-02-12', 'alegredravenryle@gmail.com', NULL, NULL, 92, 41, '2026-02-12 01:05:28', '2026-02-12 20:38:39', NULL, 'S-120231260041', NULL, NULL, NULL),
(103, '120231260042', 'Hanz Elbin', 'Redoble', 'Bajado', NULL, 'Male', NULL, '2026-02-12', 'bajadohanzelbin@gmail.com', NULL, NULL, 93, 41, '2026-02-12 01:06:47', '2026-02-12 20:38:39', NULL, 'S-120231260042', NULL, NULL, NULL),
(104, '120231260043', 'Pablito, Jr', 'Amot', 'Bantilan', NULL, 'Male', NULL, '2026-02-12', 'bantilanpablitojr@gmail.com', NULL, NULL, 94, 41, '2026-02-12 01:09:16', '2026-02-12 20:38:39', NULL, 'S-120231260043', NULL, NULL, NULL),
(105, '120231260044', 'Dominique Shaun Vincent', 'Ybañez', 'Biyo', NULL, 'Male', NULL, '2026-02-12', 'biyodominique@gmail.com', NULL, NULL, 95, 41, '2026-02-12 01:11:02', '2026-02-12 20:38:39', NULL, 'S-120231260044', NULL, NULL, NULL),
(106, '120231260045', 'Kurt Reign', 'Callao', 'Carba', NULL, 'Male', NULL, '2026-02-12', 'carbakurtreign@gmail.com', NULL, NULL, 96, 41, '2026-02-12 01:13:00', '2026-02-12 20:38:39', NULL, 'S-120231260045', NULL, NULL, NULL),
(107, '120231260046', 'Stethan', 'Bolo', 'Dacotdacot', NULL, 'Male', NULL, '2026-02-12', 'dacotdacotstethan@gmail.com', NULL, NULL, 97, 41, '2026-02-12 01:14:38', '2026-02-12 20:38:39', NULL, 'S-120231260046', NULL, NULL, NULL),
(108, '120231260047', 'Zayn', 'Tinambacan', 'Daymil', NULL, 'Male', NULL, '2026-02-12', 'daymilzayn@gmail.com', NULL, NULL, 98, 41, '2026-02-12 01:18:57', '2026-02-12 20:38:39', NULL, 'S-120231260047', NULL, NULL, NULL),
(109, '120231260048', 'Uzumaki', 'Ramirez', 'Fernando', NULL, 'Male', NULL, '2026-02-12', 'fernandouzumaki@gmail.com', NULL, NULL, 99, 41, '2026-02-12 01:20:34', '2026-02-12 20:38:39', NULL, 'S-120231260048', NULL, NULL, NULL),
(110, '120231260049', 'Noah Matteo', 'Tubog', 'Gestupa', NULL, 'Male', NULL, '2026-02-12', 'gestupanoahmatteo@gmail.com', NULL, NULL, 100, 41, '2026-02-12 01:22:57', '2026-02-12 20:38:39', NULL, 'S-120231260049', NULL, NULL, NULL),
(111, '120231260050', 'Giean', 'Patrocinio', 'Oteda', NULL, 'Male', NULL, '2026-02-12', 'otedagiean@gmail.com', NULL, NULL, 101, 41, '2026-02-12 01:24:39', '2026-02-12 20:38:39', NULL, 'S-120231260050', NULL, NULL, NULL),
(112, '120231260051', 'Jonas', 'Bariga', 'Partosa', NULL, 'Male', NULL, '2026-02-12', 'partosajonas@gmail.com', NULL, NULL, 102, 41, '2026-02-12 01:29:19', '2026-02-12 20:38:39', NULL, 'S-120231260051', NULL, NULL, NULL),
(113, '120231260052', 'Prince Andy', 'Balansag', 'Sarao', NULL, 'Male', NULL, '2026-02-12', 'saraoprinceandy@gmail.com', NULL, NULL, 103, 41, '2026-02-12 01:30:49', '2026-02-12 20:38:39', NULL, 'S-120231260052', NULL, NULL, NULL),
(114, '120231260053', 'Charlie, Jr', 'Gabuya', 'Serojano', NULL, 'Male', NULL, '2026-02-12', 'serojanocharliejr@gmail.com', NULL, NULL, 104, 41, '2026-02-12 01:33:19', '2026-02-12 20:38:39', NULL, 'S-120231260053', NULL, NULL, NULL),
(115, '120231260054', 'Prince John', 'Cabando', 'Sonlit', NULL, 'Male', NULL, '2026-02-12', 'sonlitprincejohn@gmail.com', NULL, NULL, 105, 41, '2026-02-12 01:40:07', '2026-02-12 20:38:39', NULL, 'S-120231260054', NULL, NULL, NULL),
(116, '120231260055', 'Christoff', 'Alar', 'Tolomia', NULL, 'Male', NULL, '2026-02-12', 'tolomiachristoff@gmail.com', NULL, NULL, 106, 41, '2026-02-12 01:41:47', '2026-02-12 20:38:39', NULL, 'S-120231260055', NULL, NULL, NULL),
(117, '120231260056', 'Rejay', 'Cual', 'Toro', NULL, 'Male', NULL, '2026-02-12', 'totorejay@gmail.com', NULL, NULL, 107, 41, '2026-02-12 01:44:32', '2026-02-12 20:38:39', NULL, 'S-120231260056', NULL, NULL, NULL),
(118, '120231260057', 'Prince Jullian', 'Palalon', 'Ubay', NULL, 'Male', NULL, '2026-02-12', 'ubayprincejullian@gmail.com', NULL, NULL, 108, 41, '2026-02-12 01:45:56', '2026-02-12 20:38:39', NULL, 'S-120231260057', NULL, NULL, NULL),
(119, '120231260058', 'France Aethan', 'Alas-as', 'Usman', NULL, 'Male', NULL, '2026-02-12', 'usmanfranceaethan@gmail.com', NULL, NULL, 109, 41, '2026-02-12 01:47:09', '2026-02-12 20:38:39', NULL, 'S-120231260058', NULL, NULL, NULL),
(120, '120231260059', 'John Martin', 'Ventolero', 'Verzano', NULL, 'Male', NULL, '2026-02-12', 'verzanohohnmartin@gmail.com', NULL, NULL, 110, 41, '2026-02-12 01:48:44', '2026-02-12 20:38:39', NULL, 'S-120231260059', NULL, NULL, NULL),
(121, '120231260060', 'Kurt Ernest', 'Quiamson', 'Villarosa', NULL, 'Male', NULL, '2026-02-12', 'villarosakurternest@gmail.com', NULL, NULL, 111, 41, '2026-02-12 01:50:13', '2026-02-12 20:38:39', NULL, 'S-120231260060', NULL, NULL, NULL),
(122, '120231260061', 'Chike', 'Nama', 'Badrina', NULL, 'Female', NULL, '2026-02-12', 'badrinachike@gmail.com', NULL, NULL, 112, 41, '2026-02-12 03:02:10', '2026-02-12 20:38:40', NULL, 'S-120231260061', NULL, NULL, NULL),
(123, '120231260062', 'Clarissa Niña', 'Palo-Palo', 'Bantoto', NULL, 'Female', NULL, '2026-02-12', 'bantotoclarissa@gmail.com', NULL, NULL, 113, 41, '2026-02-12 03:04:21', '2026-02-12 20:38:40', NULL, 'S-120231260062', NULL, NULL, NULL),
(124, '120231260063', 'Cris Keira', 'Briones', 'Cabanilla', NULL, 'Female', NULL, '2026-02-12', 'cabanillacriskeira@gmail.com', NULL, NULL, 114, 41, '2026-02-12 03:05:44', '2026-02-12 20:38:40', NULL, 'S-120231260063', NULL, NULL, NULL),
(125, '120231260064', 'Brianna Zia', 'Buñi', 'Camacho', NULL, 'Female', NULL, '2026-02-12', 'camachobriannazia@gmail.com', NULL, NULL, 115, 41, '2026-02-12 03:08:18', '2026-02-12 20:38:40', NULL, 'S-120231260064', NULL, NULL, NULL),
(126, '120231260065', 'Prim Rose', 'Calimba', 'Carvellida', NULL, 'Female', NULL, '2026-02-12', 'carvellidaprimrose@gmail.com', NULL, NULL, 116, 41, '2026-02-12 03:09:40', '2026-02-12 20:38:40', NULL, 'S-120231260065', NULL, NULL, NULL),
(127, '120231260066', 'Kynleigh', 'Pilongo', 'Chu', NULL, 'Female', NULL, '2026-02-12', 'chukynleigh@gmail.com', NULL, NULL, 117, 41, '2026-02-12 03:11:08', '2026-02-12 20:38:40', NULL, 'S-120231260066', NULL, NULL, NULL),
(128, '120231260067', 'Jhella Mae', 'Cadimas', 'Divina', NULL, 'Female', NULL, '2026-02-12', 'divinajhellamae@gmail.com', NULL, NULL, 118, 41, '2026-02-12 03:12:34', '2026-02-12 20:38:40', NULL, 'S-120231260067', NULL, NULL, NULL),
(129, '120231260068', 'Jewel Scarlet', 'Bayer', 'Gargar', NULL, 'Female', NULL, '2026-02-12', 'gargarjewelscarlet@gmail.com', NULL, NULL, 119, 41, '2026-02-12 03:14:00', '2026-02-12 20:38:40', NULL, 'S-120231260068', NULL, NULL, NULL),
(130, '120231260069', 'Asherah Elsie', 'Montemayor', 'Icaonapo', NULL, 'Female', NULL, '2026-02-12', 'icaonapoasherahelsie@gmail.com', NULL, NULL, 120, 41, '2026-02-12 03:15:32', '2026-02-12 20:38:40', NULL, 'S-120231260069', NULL, NULL, NULL),
(131, '120231260070', 'Jairil Monette', 'Abequibel', 'Lampaso', NULL, 'Female', NULL, '2026-02-12', 'lampasojairilmonette@gmail.com', NULL, NULL, 121, 41, '2026-02-12 03:17:06', '2026-02-12 20:38:40', NULL, 'S-120231260070', NULL, NULL, NULL),
(132, '120231260071', 'Francine', NULL, 'Lozada', NULL, 'Female', NULL, '2026-02-12', 'lozadafrancine@gmail.com', NULL, NULL, 122, 41, '2026-02-12 03:18:14', '2026-02-12 20:38:40', NULL, 'S-120231260071', NULL, 1, NULL),
(133, '120231260072', 'Crissmalyn Faye', NULL, 'Mohammad', NULL, 'Female', NULL, '2026-02-12', 'mohammadcrissmalyn@gmail.com', NULL, NULL, 123, 41, '2026-02-12 03:19:50', '2026-02-12 20:38:40', NULL, 'S-120231260072', NULL, NULL, NULL),
(134, '120231260073', 'Lianah', NULL, 'Mohello', NULL, 'Female', NULL, '2026-02-12', 'mohellolianah@gmail.com', NULL, NULL, 124, 41, '2026-02-12 03:21:28', '2026-02-12 20:38:40', NULL, 'S-120231260073', NULL, NULL, NULL),
(135, '120231260074', 'Arianne', 'Serrano', 'Pao', NULL, 'Female', NULL, '2026-02-12', 'paoarianne@gmail.com', NULL, NULL, 125, 41, '2026-02-12 03:22:40', '2026-02-12 20:38:40', NULL, 'S-120231260074', NULL, NULL, NULL),
(136, '120231260075', 'Avril Kate', NULL, 'Paquinol', NULL, 'Female', NULL, '2026-02-12', 'paquinolavrilkate@gmail.com', NULL, NULL, 126, 41, '2026-02-12 03:24:11', '2026-02-12 20:38:40', NULL, 'S-120231260075', NULL, NULL, NULL),
(137, '120231260076', 'Maria Celestine', 'Anza', 'Salatan', NULL, 'Female', NULL, '2026-02-12', 'salatanmariacelestine@gmail.com', NULL, NULL, 127, 41, '2026-02-12 03:47:51', '2026-02-12 20:38:40', NULL, 'S-120231260076', NULL, NULL, NULL),
(138, '120231260077', 'DJ Anne', 'Tubog', 'Senahon', NULL, 'Female', NULL, '2026-02-12', 'senahondjanne@gmail.com', NULL, NULL, 128, 41, '2026-02-12 03:49:36', '2026-02-12 20:38:40', NULL, 'S-120231260077', NULL, NULL, NULL),
(139, '120231260078', 'Elaine Joy', 'Sastrillo', 'Tenedo', NULL, 'Female', NULL, '2026-02-12', 'tenedoelainejoy@gmail.com', NULL, NULL, 129, 41, '2026-02-12 03:51:07', '2026-02-12 20:38:40', NULL, 'S-120231260078', NULL, NULL, NULL),
(140, '120231260079', 'Ellyza Mae', 'Ballovar', 'Tuble', NULL, 'Female', NULL, '2026-02-12', 'tubleellyzamae@gmail.com', NULL, NULL, 130, 41, '2026-02-12 03:52:46', '2026-02-12 20:38:40', NULL, 'S-120231260079', NULL, NULL, NULL),
(142, '120231260080', 'Jillianne Shane', 'Tubio', 'Villamil', NULL, 'Female', NULL, '2026-02-13', 'villamiljillianneshan@gmail.com', NULL, NULL, 132, 41, '2026-02-12 18:02:40', '2026-02-12 20:38:40', NULL, 'S-120231260080', NULL, NULL, NULL),
(155, '120231090041', 'Crestian', 'Bajado', 'Tuayon', NULL, 'Male', NULL, '2026-02-15', 'cresttuayon7@gmail.com', NULL, 'Tugawe, Dauin, Negros Oriental', 153, 45, '2026-02-15 00:12:46', '2026-02-15 00:16:46', NULL, NULL, NULL, 3, NULL),
(156, '120231260082', 'Troilan', 'Bajado', 'Tuayon', NULL, 'Male', NULL, '2026-02-15', 'troituayon@gmail.com', NULL, 'Tugawe, Dauin, Negros Oriental', 154, 40, '2026-02-15 01:11:47', '2026-02-17 05:26:32', NULL, NULL, 'photos/0WRKM7POVwIgw18nQCFFP8hP62eCTT8tdfsT2Aa1.jpg', 1, NULL),
(157, '120231260085', 'Ejie Mae', 'Santos', 'Tradio', NULL, 'Female', NULL, '2003-10-31', 'ezimeitradio@gmail.com', NULL, NULL, 157, NULL, '2026-02-16 08:34:24', '2026-02-16 08:34:24', NULL, NULL, NULL, 1, NULL),
(162, '120231260087', 'Noime', 'T.', 'Baldomar', NULL, 'Female', NULL, '2026-02-17', 'baldomarnoime@gmail.com', '09759264665', 'Bayawan City, Negros Oriental', 162, NULL, '2026-02-16 15:07:01', '2026-02-16 15:07:01', NULL, NULL, 'students/dYDpWT4X2IOjP5PafYzb3rXOw5cLUVA3AjK8L8nB.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_subjects`
--

CREATE TABLE `student_subjects` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED DEFAULT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `school_year_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `grade_level` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `components` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `code`, `name`, `grade_level`, `components`, `created_at`, `updated_at`) VALUES
(93, 'K_LIT', 'Language Literacy', 'Kindergarten', NULL, NULL, NULL),
(94, 'K_NUM', 'Number Readiness', 'Kindergarten', NULL, NULL, NULL),
(95, 'K_HEALTH', 'Health & Safety', 'Kindergarten', NULL, NULL, NULL),
(96, 'K_PE', 'Physical Education', 'Kindergarten', NULL, NULL, NULL),
(97, 'FIL1', 'Filipino', 'Grade 1', NULL, NULL, NULL),
(98, 'ENG1', 'English', 'Grade 1', NULL, NULL, NULL),
(99, 'MATH1', 'Mathematics', 'Grade 1', NULL, NULL, NULL),
(100, 'ESP1', 'Edukasyon sa Pagpapakatao', 'Grade 1', NULL, NULL, NULL),
(101, 'MAPEH1', 'MAPEH', 'Grade 1', '[\"Music\", \"Arts\", \"Physical Education\", \"Health\"]', NULL, NULL),
(102, 'FIL2', 'Filipino', 'Grade 2', NULL, NULL, NULL),
(103, 'ENG2', 'English', 'Grade 2', NULL, NULL, NULL),
(104, 'MATH2', 'Mathematics', 'Grade 2', NULL, NULL, NULL),
(105, 'ESP2', 'Edukasyon sa Pagpapakatao', 'Grade 2', NULL, NULL, NULL),
(106, 'MAPEH2', 'MAPEH', 'Grade 2', '[\"Music\", \"Arts\", \"Physical Education\", \"Health\"]', NULL, NULL),
(107, 'AP2', 'Araling Panlipunan', 'Grade 2', NULL, NULL, NULL),
(108, 'FIL3', 'Filipino', 'Grade 3', NULL, NULL, NULL),
(109, 'ENG3', 'English', 'Grade 3', NULL, NULL, NULL),
(110, 'MATH3', 'Mathematics', 'Grade 3', NULL, NULL, NULL),
(111, 'SCI3', 'Science', 'Grade 3', NULL, NULL, NULL),
(112, 'ESP3', 'Edukasyon sa Pagpapakatao', 'Grade 3', NULL, NULL, NULL),
(113, 'MAPEH3', 'MAPEH', 'Grade 3', '[\"Music\", \"Arts\", \"Physical Education\", \"Health\"]', NULL, NULL),
(114, 'AP3', 'Araling Panlipunan', 'Grade 3', NULL, NULL, NULL),
(115, 'FIL4', 'Filipino', 'Grade 4', NULL, NULL, NULL),
(116, 'ENG4', 'English', 'Grade 4', NULL, NULL, NULL),
(117, 'MATH4', 'Mathematics', 'Grade 4', NULL, NULL, NULL),
(118, 'SCI4', 'Science', 'Grade 4', NULL, NULL, NULL),
(119, 'ESP4', 'Edukasyon sa Pagpapakatao', 'Grade 4', NULL, NULL, NULL),
(120, 'MAPEH4', 'MAPEH', 'Grade 4', '[\"Music\", \"Arts\", \"Physical Education\", \"Health\"]', NULL, NULL),
(121, 'AP4', 'Araling Panlipunan', 'Grade 4', NULL, NULL, NULL),
(122, 'EPP4', 'Edukasyong Pantahanan at Pangkabuhayan', 'Grade 4', NULL, NULL, NULL),
(123, 'FIL5', 'Filipino', 'Grade 5', NULL, NULL, NULL),
(124, 'ENG5', 'English', 'Grade 5', NULL, NULL, NULL),
(125, 'MATH5', 'Mathematics', 'Grade 5', NULL, NULL, NULL),
(126, 'SCI5', 'Science', 'Grade 5', NULL, NULL, NULL),
(127, 'ESP5', 'Edukasyon sa Pagpapakatao', 'Grade 5', NULL, NULL, NULL),
(128, 'MAPEH5', 'MAPEH', 'Grade 5', '[\"Music\", \"Arts\", \"Physical Education\", \"Health\"]', NULL, NULL),
(129, 'AP5', 'Araling Panlipunan', 'Grade 5', NULL, NULL, NULL),
(130, 'EPP5', 'Edukasyong Pantahanan at Pangkabuhayan', 'Grade 5', NULL, NULL, NULL),
(131, 'FIL6', 'Filipino', 'Grade 6', NULL, NULL, NULL),
(132, 'ENG6', 'English', 'Grade 6', NULL, NULL, NULL),
(133, 'MATH6', 'Mathematics', 'Grade 6', NULL, NULL, NULL),
(134, 'SCI6', 'Science', 'Grade 6', NULL, NULL, NULL),
(135, 'ESP6', 'Edukasyon sa Pagpapakatao', 'Grade 6', NULL, NULL, NULL),
(136, 'MAPEH6', 'MAPEH', 'Grade 6', '[\"Music\", \"Arts\", \"Physical Education\", \"Health\"]', NULL, NULL),
(137, 'AP6', 'Araling Panlipunan', 'Grade 6', NULL, NULL, NULL),
(138, 'EPP6', 'Edukasyong Pantahanan at Pangkabuhayan', 'Grade 6', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suffix` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_hired` date DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `advisory_section_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `years_experience` int NOT NULL DEFAULT '0',
  `grade_experience` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `male_enrollment` int NOT NULL DEFAULT '0',
  `female_enrollment` int NOT NULL DEFAULT '0',
  `prepared_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conforme` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `birthday`, `email`, `contact_number`, `employee_id`, `date_hired`, `photo`, `advisory_section_id`, `created_at`, `updated_at`, `position`, `years_experience`, `grade_experience`, `male_enrollment`, `female_enrollment`, `prepared_by`, `conforme`, `approved_by`) VALUES
(3, 42, 'Juan', 'De La', 'Cruz', 'Jr.', '1995-01-02', 'juandelacruz@gmail.com', '09759264665', NULL, NULL, 'teachers/AA9eOlMh5rsiZ6u1VXW65kIoRnb22v6Np4HqZjPC.jpg', NULL, '2026-02-10 23:50:01', '2026-02-15 21:00:20', 'Principal I', 4, '1', 14, 13, 'Mae Harriet M. De la Pena, EdD', 'Alelyn D. Nocete', 'Beda Jovenciana D. Agor, EdD'),
(4, 43, 'Leeneth', NULL, 'Asdillo', NULL, '2026-02-12', 'asdilloleeneth@gmail.com', NULL, NULL, NULL, NULL, NULL, '2026-02-11 22:28:20', '2026-02-11 22:28:20', NULL, 0, NULL, 0, 0, NULL, NULL, NULL),
(5, 44, 'Antonieta', NULL, 'Manginsay', NULL, '2026-02-12', 'manginsayantonieta@gmail.com', NULL, NULL, NULL, NULL, NULL, '2026-02-11 22:30:44', '2026-02-11 22:30:44', NULL, 0, NULL, 0, 0, NULL, NULL, NULL),
(6, 45, 'Alelyn', 'D.', 'Nocete', NULL, '2026-02-12', 'nocetealelyn@gmail.com', NULL, NULL, NULL, NULL, NULL, '2026-02-11 22:32:28', '2026-02-11 22:32:28', NULL, 0, NULL, 0, 0, NULL, NULL, NULL),
(7, 46, 'Victoria', 'A.', 'Sojor', NULL, '2026-02-12', 'sojorvictoria@gmail.com', NULL, NULL, NULL, NULL, NULL, '2026-02-11 22:33:47', '2026-02-11 22:33:47', NULL, 0, NULL, 0, 0, NULL, NULL, NULL),
(8, 47, 'Reneegen', NULL, 'Rubia', NULL, '2026-02-12', 'rubiareneegen@gmail.com', NULL, NULL, NULL, NULL, NULL, '2026-02-11 22:35:27', '2026-02-11 22:35:27', NULL, 0, NULL, 0, 0, NULL, NULL, NULL),
(9, 48, 'Eva', 'A.', 'Alama', NULL, '2026-02-12', 'alamaeva@gmail.com', NULL, NULL, NULL, NULL, NULL, '2026-02-11 22:36:30', '2026-02-11 22:36:30', NULL, 0, NULL, 0, 0, NULL, NULL, NULL),
(10, 49, 'Wilz', NULL, 'Rio', NULL, '2026-02-12', 'riowilz@gmail.com', NULL, NULL, NULL, NULL, NULL, '2026-02-11 22:37:48', '2026-02-11 22:37:48', NULL, 0, NULL, 0, 0, NULL, NULL, NULL),
(11, 50, 'Carmel', NULL, 'Monopollo', NULL, '2026-02-12', 'monopollocarmel@gmail.com', NULL, NULL, NULL, NULL, NULL, '2026-02-11 22:44:47', '2026-02-11 22:44:47', NULL, 0, NULL, 0, 0, NULL, NULL, NULL),
(12, 51, 'Victor', NULL, 'Alcoriza', NULL, '2026-02-12', 'alcorizavictor@gmail.com', NULL, NULL, NULL, NULL, NULL, '2026-02-11 22:45:28', '2026-02-11 22:45:28', NULL, 0, NULL, 0, 0, NULL, NULL, NULL),
(13, 150, 'System', NULL, 'Administrator', NULL, '2026-02-14', 'tugaweESadmin@gmail.com', NULL, NULL, NULL, 'teachers/dYFj9QimrODFzX6D4n9cVQaKHG8o18T5OJbse1U7.jpg', NULL, '2026-02-13 18:04:41', '2026-02-13 18:05:37', 'System Admin', 0, NULL, 0, 0, 'System Administrator', 'Adviser', 'Public School District Supervisor');

-- --------------------------------------------------------

--
-- Table structure for table `teaching_loads`
--

CREATE TABLE `teaching_loads` (
  `id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `session` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Morning',
  `time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `minutes` int DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teaching_loads`
--

INSERT INTO `teaching_loads` (`id`, `teacher_id`, `session`, `time`, `minutes`, `subject`, `created_at`, `updated_at`) VALUES
(1, 3, 'Morning', '8:00-9:00 AM', 60, 'ENGLISH 2', '2026-02-11 02:44:10', '2026-02-15 21:00:20'),
(2, 3, 'Morning', '10:00-11:00 AM', 60, 'FILIPINO 2', '2026-02-11 02:56:25', '2026-02-15 21:00:20'),
(3, 3, 'Morning', '11:00-12:00 PM', 60, 'MATHEMATICS 2', '2026-02-11 03:18:22', '2026-02-15 21:00:20'),
(4, 3, 'Morning', '1:00-2:00 PM', 60, 'SCIENCE 2', '2026-02-11 15:41:33', '2026-02-15 21:00:20'),
(5, 3, 'Morning', '2:00-3:00 PM', 60, 'MAPEH 2', '2026-02-11 15:41:33', '2026-02-15 21:00:20'),
(6, 3, 'Morning', '3:00-4:00 pm', 60, 'ESP 2', '2026-02-11 17:46:41', '2026-02-15 21:00:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `lrn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suffix` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_attempts` int NOT NULL DEFAULT '0',
  `lock_until` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `lrn`, `role_id`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `first_name`, `middle_name`, `last_name`, `suffix`, `birthday`, `username`, `login_attempts`, `lock_until`) VALUES
(1, '', 1, 'admin@tugaweES.edu.ph', NULL, '$2y$12$zXtYoxdECMpT8DvDKSKFee0E.B7PXe4yQgoRJim6sPz/1zutl3Gsu', 'LMK47MP2m8G919utIQvQf5ensTanF52WIwVrjjCKEYWazrHR3H8sg1gOGKE5', '2026-01-27 05:37:20', '2026-02-16 04:35:23', '', NULL, '', NULL, NULL, '', 1, NULL),
(2, '', 3, 'registrar@tugaweES.edu.ph', NULL, '$2y$12$U.1P6YsXem2b3PGR94gFeO14UKaqX8ohqvff/ouYL7FnqE9LDE.oi', 'nccbD0wj3C8DCCA5bmj539qorahXQTTW7a2N4I9oydPbwKJlK9BuJAP5QvYK', '2026-01-27 05:37:21', '2026-01-27 05:37:21', '', NULL, '', NULL, NULL, '', 0, NULL),
(39, '', 4, 'cresttuayon@gmail.com', NULL, '$2y$12$6hxW91UwOUdbxrUxrP7QxucAWPs5ylptuX30Dk0qCQcZpIb7HGt7u', NULL, '2026-02-10 03:52:06', '2026-02-17 05:19:02', 'Crestian', NULL, 'Tuayon', NULL, NULL, 'ctuayon620', 4, NULL),
(42, '', 2, 'juandelacruz@gmail.com', NULL, '$2y$12$W7asov1IAI8NcPPXLa1Ln.NEW2oYwK.6eyUPvVGr6HyG8PM3U8NeO', NULL, '2026-02-10 23:50:01', '2026-02-16 06:11:16', 'Juan', NULL, 'Cruz', NULL, NULL, 'juandelacruz', 1, NULL),
(43, '', 2, 'asdilloleeneth@gmail.com', NULL, '$2y$12$msUYN.TKY3W85BIabLfFIuCydYrZblJYSksVDaeCl7.f7KE9ue.Gu', NULL, '2026-02-11 22:28:20', '2026-02-11 22:28:20', 'Leeneth', NULL, 'Asdillo', NULL, NULL, 'leenethasdillo', 0, NULL),
(44, '', 2, 'manginsayantonieta@gmail.com', NULL, '$2y$12$p8q2BH/cn9Q8jh4F4pB6DOeNaZnuLl8pq/BpBJhv4fy2Rhe0iBU1y', NULL, '2026-02-11 22:30:44', '2026-02-11 22:30:44', 'Antonieta', NULL, 'Manginsay', NULL, NULL, 'antonietamanginsay', 0, NULL),
(45, '', 2, 'nocetealelyn@gmail.com', NULL, '$2y$12$QTg/Cq5XqxnbdNedFLgaUub10LFBrlFNnidbQqOAxC6HIofJjIKpu', NULL, '2026-02-11 22:32:28', '2026-02-11 22:32:28', 'Alelyn', 'D.', 'Nocete', NULL, NULL, 'alelynnocete@gmail.com', 0, NULL),
(46, '', 2, 'sojorvictoria@gmail.com', NULL, '$2y$12$DNufZwV0xkGSkKKD/myAOOfokXT27UtrfjAWGhSAr52aiS2wx51lq', NULL, '2026-02-11 22:33:47', '2026-02-11 22:33:47', 'Victoria', 'A.', 'Sojor', NULL, NULL, 'victoriasojor', 0, NULL),
(47, '', 2, 'rubiareneegen@gmail.com', NULL, '$2y$12$TCMiMoDlqWoNnSlm13Zl6empLYX4HIXHGurmzQQ/P/jKlX6JKA5Cu', NULL, '2026-02-11 22:35:27', '2026-02-11 22:35:27', 'Reneegen', NULL, 'Rubia', NULL, NULL, 'reneegenrubia', 0, NULL),
(48, '', 2, 'alamaeva@gmail.com', NULL, '$2y$12$IKVdqoJQ25uWdgZHvDqX/ehu2EEemzMDLMZ.bSrPXoPDuFVT2v4wO', NULL, '2026-02-11 22:36:30', '2026-02-11 22:36:30', 'Eva', 'A.', 'Alama', NULL, NULL, 'evaalama', 0, NULL),
(49, '', 2, 'riowilz@gmail.com', NULL, '$2y$12$dywGTgY0H48pirQ2ZbRPK./7CMcKtHPJZ/ZcrtiosC9NTxLdagKlq', NULL, '2026-02-11 22:37:48', '2026-02-11 22:37:48', 'Wilz', NULL, 'Rio', NULL, NULL, 'wilzrio', 0, NULL),
(50, '', 2, 'monopollocarmel@gmail.com', NULL, '$2y$12$D6J3kp69GRItD2v8vIAuyuh/0buQx5KjCFK6Nqc/9QD1H115hT/Iu', NULL, '2026-02-11 22:44:47', '2026-02-11 22:44:47', 'Carmel', NULL, 'Monopollo', NULL, NULL, 'carmelmonopollo', 0, NULL),
(51, '', 2, 'alcorizavictor@gmail.com', NULL, '$2y$12$Ot2hzYu5hc4X0oVOvmcW3es0m9mptBCXCUbSM0PILaV7p42mlLDym', NULL, '2026-02-11 22:45:28', '2026-02-11 22:45:28', 'Victor', NULL, 'Alcoriza', NULL, NULL, 'victoralcoriza', 0, NULL),
(52, '', 4, 'kristianalsola@gmail.com', NULL, '$2y$12$E9Z4IF9EZ1N68i2zTnY2P.MU58iEODEpN2LofGf3yBODOOOXFSiZC', NULL, '2026-02-11 23:00:56', '2026-02-11 23:00:56', 'Kristian', NULL, 'Alsola', NULL, NULL, 'kalsola703', 0, NULL),
(53, '', 4, 'aranetareferjohn@gmail.com', NULL, '$2y$12$ruVIhy6LiCij4XMDkMMaLeC2LTwEt/wDPM9Z0NdNwzVDThZX6N606', NULL, '2026-02-11 23:02:34', '2026-02-11 23:02:34', 'Rofer John', NULL, 'Araneta', NULL, NULL, 'raraneta101', 0, NULL),
(54, '', 4, 'delesmeraldjay@gmail.com', NULL, '$2y$12$WfPu0EeMmo92fLICmLvImuA4vTBOODSSbujFs8.M603TA.1aLtV2C', NULL, '2026-02-11 23:06:52', '2026-02-11 23:06:52', 'MERALD JAY', NULL, 'DELES', NULL, NULL, 'mdeles911', 0, NULL),
(56, '', 4, 'mondidogeo@gmail.com', NULL, '$2y$12$8cgI03dTLcihpLMb23Gw8OpashieJ9drHm0G3MzMMEIfClpRaoH02', NULL, '2026-02-11 23:12:38', '2026-02-11 23:12:38', 'Geo', NULL, 'Mondido', NULL, NULL, 'gmondido308', 0, NULL),
(57, '', 4, 'emmanmondido@gmail.com', NULL, '$2y$12$9nBOPT8pdjDZT2RzclRqHebg.QH0U77kegBfDgqhWf6u6kxfuFEeO', NULL, '2026-02-11 23:23:56', '2026-02-11 23:23:56', 'Emman', NULL, 'Mondido', NULL, NULL, 'emondido203', 0, NULL),
(58, '', 4, 'ivanmondido@gmail.com', NULL, '$2y$12$kDos1ve615xmPlYCjlxjaelP0/..0UZ/vNwbfEuEvSTLUs6veqDIa', NULL, '2026-02-11 23:25:04', '2026-02-11 23:25:04', 'Ivan', NULL, 'Mondido', NULL, NULL, 'imondido318', 0, NULL),
(59, '', 4, 'christangelopelayo@gmail.com', NULL, '$2y$12$/Fqok1ZTYRzhSxQDNsvDPOM17tm8tMYk3SmDeWLMLYTZbxdLo8YHC', NULL, '2026-02-11 23:26:42', '2026-02-11 23:26:42', 'Christ Angelo', NULL, 'Pelayo', NULL, NULL, 'cpelayo388', 0, NULL),
(60, '', 4, 'sisondaryl@gmail.com', NULL, '$2y$12$oc2i6DLflznzv4Quwoj5Vec1GX0w4WKpLaVg12lzC0L8WQb6KnKOu', NULL, '2026-02-11 23:28:14', '2026-02-11 23:28:14', 'Daryl', NULL, 'Sison', NULL, NULL, 'dsison531', 0, NULL),
(61, '', 4, 'johnmarcotinambacan@gmail.com', NULL, '$2y$12$RGpMfxDyTFKXab8EbKfjtuNWFliFbgRgHQOkk26A/5ksSZVb6Fqpm', NULL, '2026-02-11 23:29:52', '2026-02-11 23:29:52', 'John Marco', NULL, 'Tinambacan', NULL, NULL, 'jtinambacan917', 0, NULL),
(62, '', 4, 'shawnedriantubog@gmail.com', NULL, '$2y$12$l1F0IBX7g.TSgn6A1M6VHO5UoRQYlMf1G839flF3lP8CfFq5ouSVu', NULL, '2026-02-11 23:31:26', '2026-02-11 23:31:26', 'Shawn Edrian', NULL, 'Tubog', NULL, NULL, 'stubog314', 0, NULL),
(63, '', 4, 'violajeron@gmail.com', NULL, '$2y$12$pHUe2CndPMpewDh56YXCr.lYhpcy7Ljvk4o7GtgUotOgcYawFQLoO', NULL, '2026-02-11 23:40:57', '2026-02-11 23:40:57', 'Jeron', NULL, 'Viola', NULL, NULL, 'jviola986', 0, NULL),
(64, '', 4, 'alamanathaliazymth@gmail.com', NULL, '$2y$12$0lBQZFiMh8YG8HJ2FGlGney42s9u3TshTkHBnrharYWsixqk6zF.G', NULL, '2026-02-11 23:46:47', '2026-02-11 23:46:47', 'Nathalia Zymth', NULL, 'Alama', NULL, NULL, 'nalama814', 0, NULL),
(65, '', 4, 'callorasofianicole@gmail.com', NULL, '$2y$12$NXeIJaTs/95hppdV./LDsucYpJdt7sq.KeOLOjVg4UP45btxFVe3K', NULL, '2026-02-11 23:48:08', '2026-02-11 23:48:08', 'Sofia Nicole', NULL, 'Callora', NULL, NULL, 'scallora807', 0, NULL),
(66, '', 4, 'cofinomiahele@gmail.com', NULL, '$2y$12$r1GOG2WoAAKHc5MZRRR44.EQOn1j84Bf1CQlwh3/WBcHLk0abKtNK', NULL, '2026-02-11 23:49:28', '2026-02-11 23:49:28', 'Miah Ele', NULL, 'Cofino', NULL, NULL, 'mcofino400', 0, NULL),
(67, '', 4, 'moratoaaliyahgabrielle@gmail.com', NULL, '$2y$12$XqkZwCYiijZmDYiwoDDdWuunaBk1V/CnMrg4RgWe7Y53Gk6rm3gLW', NULL, '2026-02-11 23:51:32', '2026-02-11 23:51:32', 'Aaliyah Gabrielle', NULL, 'Morato', NULL, NULL, 'amorato474', 0, NULL),
(68, '', 4, 'tabanganzoe@gmail.com', NULL, '$2y$12$PgvkzjBFh56Q.anAWQ2o5OBi2WkpMt7nCSlws03rcibpVDoGkhl9q', NULL, '2026-02-11 23:52:52', '2026-02-11 23:52:52', 'Zoe', NULL, 'Tabangan', NULL, NULL, 'ztabangan729', 0, NULL),
(69, '', 4, 'toroprincesscoleen@gmail.com', NULL, '$2y$12$2EAyzKUuxDB2mDIvbjBmEecZSS7fJDxLNFVRpp7BaP/GcwTbSQgxe', NULL, '2026-02-11 23:54:32', '2026-02-11 23:54:32', 'Princess Coleen', NULL, 'Toro', NULL, NULL, 'ptoro381', 0, NULL),
(70, '', 4, 'tubanjaneshannel@gmail.com', NULL, '$2y$12$LtFchyoFGPNGjVRosGrB8uM3mGCEDrbvUmQDPbM8cpEQZIehxYe6G', NULL, '2026-02-11 23:56:30', '2026-02-11 23:56:30', 'Jane Shannel', NULL, 'Tuban', NULL, NULL, 'jtuban320', 0, NULL),
(71, '', 4, 'tubannianamarithe@gmail.com', NULL, '$2y$12$Q74/.NDPhP9UmUwUNITqx.glE0zhMAAJjnnAg.tFwUsjwoyauRqGm', NULL, '2026-02-11 23:58:12', '2026-02-11 23:58:12', 'Niana Marithe', NULL, 'Tuban', NULL, NULL, 'ntuban551', 0, NULL),
(72, '', 4, 'tublejian@gmail.com', NULL, '$2y$12$Wfsu13M9yJQAMLFQGYNLMe2seCsGZ9ctFk.a4Tm3K.c6b8ah1pP5C', NULL, '2026-02-11 23:59:43', '2026-02-11 23:59:43', 'Jian', NULL, 'Tuble', NULL, NULL, 'jtuble103', 0, NULL),
(73, '', 4, 'alasasalexander@gmail.com', NULL, '$2y$12$nDfucyFGU2qfttoldtLgXOJ8Kz1YuFu2KFg5QTVhYqKLuK77czAn2', NULL, '2026-02-12 00:15:01', '2026-02-12 00:15:01', 'Alexander', NULL, 'Alas-as', NULL, NULL, 'aalas-as346', 0, NULL),
(74, '', 4, 'bantotodonnkieffer@gmail.com', NULL, '$2y$12$tmBNPiBIqh1ppdSORWaCmOgnDBYL7jy.Ja6UJv.ptPiPKJhBvbOVe', NULL, '2026-02-12 00:18:20', '2026-02-12 00:18:20', 'Donn Kieffer', NULL, 'Bantoto', NULL, NULL, 'dbantoto563', 0, NULL),
(75, '', 4, 'bantotomaxwelllaurent@gmail.com', NULL, '$2y$12$cRjt21RiUFxp9KVyKpMKru/7kB4N9y5fAjWCA9YzpKA6Zb2vBM7aW', NULL, '2026-02-12 00:20:22', '2026-02-12 00:20:22', 'Maxwell Laurent', NULL, 'Bantoto', NULL, NULL, 'mbantoto819', 0, NULL),
(76, '', 4, 'pajentemarkchristian@gmail.com', NULL, '$2y$12$m6/zyuDblNsB3pXL.jzHbOLy1FgXQn9nIfvnfFbi1yPF02JCztDM6', NULL, '2026-02-12 00:22:12', '2026-02-12 00:22:12', 'Mark Christian', NULL, 'Pajente', NULL, NULL, 'mpajente534', 0, NULL),
(77, '', 4, 'sardannoel@gmail.com', NULL, '$2y$12$G/zjE8.aqzZjptnotthi3uIpHQLkdps38RjXs1rePNyLkG51u8N8C', NULL, '2026-02-12 00:23:22', '2026-02-12 00:23:22', 'Noel', NULL, 'Sardan', NULL, NULL, 'nsardan951', 0, NULL),
(78, '', 4, 'velozchristian@gmail.com', NULL, '$2y$12$HoHngjOXYumt6S.qL4D2Lei2sKGGnF/JenaBQefcaEhfCSPEQJ4GO', NULL, '2026-02-12 00:26:34', '2026-02-12 00:26:34', 'Christian', NULL, 'Veloz', NULL, NULL, 'cveloz905', 0, NULL),
(79, '', 4, 'agadhainegerhaine@gmail.com', NULL, '$2y$12$F8K6S1naqfdrxBHBIY3A3.K4CTxyenk1bPoRxxyYucOZU4n2t/CTm', NULL, '2026-02-12 00:28:17', '2026-02-12 00:28:17', 'Dhaine Gerhaine', NULL, 'Aga', NULL, NULL, 'daga722', 0, NULL),
(80, '', 4, 'alcorizacarren@gmail.com', NULL, '$2y$12$VjfwhT7OxeMv2aDmMGc/qe8DLoQBqxssd3S/B6WzQnu.THTZ5S5yS', NULL, '2026-02-12 00:30:04', '2026-02-12 00:30:04', 'Carren', NULL, 'Alcoriza', NULL, NULL, 'calcoriza759', 0, NULL),
(81, '', 4, 'bantotomarchell@gmail.com', NULL, '$2y$12$0NJcJMohtkB1c7szLs0FHuYmFfZHjzhlh4/8064y3NyrLJ4w9RTom', NULL, '2026-02-12 00:31:50', '2026-02-12 00:31:50', 'Marchell', NULL, 'Bantoto', NULL, NULL, 'mbantoto332', 0, NULL),
(82, '', 4, 'bantotomerriam@gmail.com', NULL, '$2y$12$pptFjizLd0LwtktyUWBnguTJKceVTPiwIUcHjQI6S4Ol.K93xl57G', NULL, '2026-02-12 00:35:00', '2026-02-12 00:35:00', 'Merriam', NULL, 'Bantoto', NULL, NULL, 'mbantoto588', 0, NULL),
(83, '', 4, 'martinezelizabellecelyn@gmail.com', NULL, '$2y$12$anhcHq.OJKbfkPkkOufVluKO13lGafapEso7EW63yorJSikP3/soq', NULL, '2026-02-12 00:38:53', '2026-02-12 00:38:53', 'Elizabelle Celyn', NULL, 'Martinez', NULL, NULL, 'emartinez933', 0, NULL),
(84, '', 4, 'orellanajairajane@gmail.com', NULL, '$2y$12$KgILoWaJYbLwhbc4M2MO6u7OOZb7CRPrS9myGcQ3dDPabwYGlgcXG', NULL, '2026-02-12 00:42:07', '2026-02-12 00:42:07', 'Jaira Jane', NULL, 'Orellana', NULL, NULL, 'jorellana753', 0, NULL),
(85, '', 4, 'patilanojellianagennely@gmail.com', NULL, '$2y$12$esv3fodGdbhR1FAMJFqmiO4hya3oTVNubmUqHDybkzPOR11LgWDPG', NULL, '2026-02-12 00:43:35', '2026-02-12 00:43:35', 'Jelliana Gennely', NULL, 'Patilano', NULL, NULL, 'jpatilano613', 0, NULL),
(86, '', 4, 'quitoymishca@gmail.com', NULL, '$2y$12$Ct7I.VkJEhvCmrRioVuL7..dvHPYeiPFc1r6mH4x919674z1tjr82', NULL, '2026-02-12 00:45:22', '2026-02-12 00:45:22', 'Mishca', NULL, 'Quitoy', NULL, NULL, 'mquitoy729', 0, NULL),
(87, '', 4, 'salatanambermcquenzie@gmail.com', NULL, '$2y$12$1JDVJbIIkWEQ6Be0Zme9vuRHw4bPgmtKJFV13WwLQEW8aGTlo/d92', NULL, '2026-02-12 00:47:08', '2026-02-12 00:47:08', 'Amber Mcquenzie', NULL, 'Salatan', NULL, NULL, 'asalatan786', 0, NULL),
(88, '', 4, 'tosejelah@gmail.com', NULL, '$2y$12$TEPYh.R95jOTrkzSz0EY3.O1cqLWQI5wNIltTgnSB9xTKSeJQyEoi', NULL, '2026-02-12 00:48:13', '2026-02-12 00:48:13', 'Jelah', NULL, 'Tose', NULL, NULL, 'jtose441', 0, NULL),
(89, '', 4, 'trumatacalistadior@gmail.com', NULL, '$2y$12$rY56KPSTSHzAKLdGlOYOU.Nl8LhrNWmkyDXzEjv8QOlDayW4Ega86', NULL, '2026-02-12 00:49:26', '2026-02-12 00:49:26', 'Calista Dior', NULL, 'Trumata', NULL, NULL, 'ctrumata444', 0, NULL),
(90, '', 4, 'tublezhiamae@gmail.com', NULL, '$2y$12$8OdU96T8HKyJbDo9YveJd.T4ANk6YxlAgQd1xMu.A7U55uNkW7vVq', NULL, '2026-02-12 00:50:31', '2026-02-12 00:50:31', 'Zhia Mae', NULL, 'Tuble', NULL, NULL, 'ztuble413', 0, NULL),
(91, '', 4, 'tubogchristine@gmail.com', NULL, '$2y$12$s/dLSLwQkQ2zsnqIf8tx8Ou2D6cg41xei/nAP/KgIkixN28OGppF2', NULL, '2026-02-12 00:51:38', '2026-02-12 00:51:38', 'Christine', NULL, 'Tubog', NULL, NULL, 'ctubog123', 0, NULL),
(92, '', 4, 'alegredravenryle@gmail.com', NULL, '$2y$12$ajZZMqHQhsk5zoa21pJ8eOnk1o1aOu03SxFrFz4y9oBxTvMs/VLOO', NULL, '2026-02-12 01:05:28', '2026-02-12 01:05:28', 'Draven Ryle', NULL, 'Alegre', NULL, NULL, 'dalegre534', 0, NULL),
(93, '', 4, 'bajadohanzelbin@gmail.com', NULL, '$2y$12$qvOzusX9QqH4uodjzCJDMOw.f1nzaQzyEewN3C2ABi5TvG4hvLL5W', NULL, '2026-02-12 01:06:47', '2026-02-12 01:06:47', 'Hanz Elbin', NULL, 'Bajado', NULL, NULL, 'hbajado429', 0, NULL),
(94, '', 4, 'bantilanpablitojr@gmail.com', NULL, '$2y$12$dBPFY8uR/x.8OiSpdhlxnOsWK66aLVpcYzoLaMkFmGVW3l9P.MUm.', NULL, '2026-02-12 01:09:16', '2026-02-12 01:09:16', 'Pablito, Jr', NULL, 'Bantilan', NULL, NULL, 'pbantilan719', 0, NULL),
(95, '', 4, 'biyodominique@gmail.com', NULL, '$2y$12$Cmu3u0dsiRSda203xWUI8ONWSR6j.WMzo7EaJ5VKj6IwtEGZryT2O', NULL, '2026-02-12 01:11:02', '2026-02-12 01:11:02', 'Dominique Shaun Vincent', NULL, 'Biyo', NULL, NULL, 'dbiyo803', 0, NULL),
(96, '', 4, 'carbakurtreign@gmail.com', NULL, '$2y$12$pTIphsY/zxt8jtq5XKthS.UqVMfsbkVLGSdGQpBKx9ulGCYLCiTyO', NULL, '2026-02-12 01:13:00', '2026-02-12 01:13:00', 'Kurt Reign', NULL, 'Carba', NULL, NULL, 'kcarba932', 0, NULL),
(97, '', 4, 'dacotdacotstethan@gmail.com', NULL, '$2y$12$D.EoAt7lpVoPe37ohY64hOaGIVB1PZgXW9ehoRgJIoOzq5vZxboOW', NULL, '2026-02-12 01:14:38', '2026-02-12 01:14:38', 'Stethan', NULL, 'Dacotdacot', NULL, NULL, 'sdacotdacot810', 0, NULL),
(98, '', 4, 'daymilzayn@gmail.com', NULL, '$2y$12$2wONubMrE8hitdgkWfsqd.XNCbnzMuVfCK.PpkPmh1arTNq648Lx.', NULL, '2026-02-12 01:18:57', '2026-02-12 01:18:57', 'Zayn', NULL, 'Daymil', NULL, NULL, 'zdaymil265', 0, NULL),
(99, '', 4, 'fernandouzumaki@gmail.com', NULL, '$2y$12$6LHhvD4iYMUarkZfXcTTuuGkHdjTNvArXiMS5REyPsDk0v058mRFe', NULL, '2026-02-12 01:20:34', '2026-02-12 01:20:34', 'Uzumaki', NULL, 'Fernando', NULL, NULL, 'ufernando842', 0, NULL),
(100, '', 4, 'gestupanoahmatteo@gmail.com', NULL, '$2y$12$9nrfLD0aV31hWFOlzBOhBOfrUTtGVUKYz2rOjbq9QNoRto93ZS1E6', NULL, '2026-02-12 01:22:57', '2026-02-12 01:22:57', 'Noah Matteo', NULL, 'Gestupa', NULL, NULL, 'ngestupa817', 0, NULL),
(101, '', 4, 'otedagiean@gmail.com', NULL, '$2y$12$EiCLWwdDAJxwNVXzulMtMOIbkzPtC6afXE2x84v5M3QIURe7Giixe', NULL, '2026-02-12 01:24:39', '2026-02-12 01:24:39', 'Giean', NULL, 'Oteda', NULL, NULL, 'goteda238', 0, NULL),
(102, '', 4, 'partosajonas@gmail.com', NULL, '$2y$12$3kSoB.XMCSxUhrDT18mgkeFK.c00EU2hxqvKQjmjL5Esqat2rdRjO', NULL, '2026-02-12 01:29:19', '2026-02-12 01:29:19', 'Jonas', NULL, 'Partosa', NULL, NULL, 'jpartosa727', 0, NULL),
(103, '', 4, 'saraoprinceandy@gmail.com', NULL, '$2y$12$3A5APAXhrC4.3i68DT0BpO9HO1q717ylux8O27pqqYyjZTUZyyv22', NULL, '2026-02-12 01:30:49', '2026-02-12 01:30:49', 'Prince Andy', NULL, 'Sarao', NULL, NULL, 'psarao773', 0, NULL),
(104, '', 4, 'serojanocharliejr@gmail.com', NULL, '$2y$12$RQokFsPmi9kOK2SVNMPfG.Np5CDxTfMLoDsM0gmWBAqipIED9.DRG', NULL, '2026-02-12 01:33:19', '2026-02-12 01:33:19', 'Charlie, Jr', NULL, 'Serojano', NULL, NULL, 'cserojano554', 0, NULL),
(105, '', 4, 'sonlitprincejohn@gmail.com', NULL, '$2y$12$A70OWh0S3d4MBthC4zwRIusSQFP1FTZAJ71xYGFDCySIAMAx3OGAm', NULL, '2026-02-12 01:40:07', '2026-02-12 01:40:07', 'Prince John', NULL, 'Sonlit', NULL, NULL, 'psonlit443', 0, NULL),
(106, '', 4, 'tolomiachristoff@gmail.com', NULL, '$2y$12$oYmeD6qUiytCLk7q1x.FtOL56kbCHVeeb70yUKuesRriASwYCokkG', NULL, '2026-02-12 01:41:47', '2026-02-12 01:41:47', 'Christoff', NULL, 'Tolomia', NULL, NULL, 'ctolomia904', 0, NULL),
(107, '', 4, 'totorejay@gmail.com', NULL, '$2y$12$wJFo9zpauQmxUQ7MgtNIb.j8pjimLWoPtK9e22DU5pnJD.DjyPJw6', NULL, '2026-02-12 01:44:32', '2026-02-12 01:44:32', 'Rejay', NULL, 'Toro', NULL, NULL, 'rtoro755', 0, NULL),
(108, '', 4, 'ubayprincejullian@gmail.com', NULL, '$2y$12$XqT42jc7luEXThY1XSwTjOlEHMTAmRllekDgmJlkvSu8y9xHlrlM6', NULL, '2026-02-12 01:45:56', '2026-02-12 01:45:56', 'Prince Jullian', NULL, 'Ubay', NULL, NULL, 'pubay454', 0, NULL),
(109, '', 4, 'usmanfranceaethan@gmail.com', NULL, '$2y$12$32rRs2wcBf..i4DnN1CCleq1AzXRc0FGddxsWmDXDpDFvIUyPUjLu', NULL, '2026-02-12 01:47:09', '2026-02-12 01:47:09', 'France Aethan', NULL, 'Usman', NULL, NULL, 'fusman372', 0, NULL),
(110, '', 4, 'verzanohohnmartin@gmail.com', NULL, '$2y$12$KIIBtBSTjzdLA5FrYKunLexT6KowB9A6pX6T71hA15kgCyl.ccwnq', NULL, '2026-02-12 01:48:44', '2026-02-12 01:48:44', 'John Martin', NULL, 'Verzano', NULL, NULL, 'jverzano239', 0, NULL),
(111, '', 4, 'villarosakurternest@gmail.com', NULL, '$2y$12$iZLw2xrZTFgTnt95QCLjBOy11xRRRxbPiAhUFbNn1jbUIYAdlIkf6', NULL, '2026-02-12 01:50:13', '2026-02-12 01:50:13', 'Kurt Ernest', NULL, 'Villarosa', NULL, NULL, 'kvillarosa277', 0, NULL),
(112, '', 4, 'badrinachike@gmail.com', NULL, '$2y$12$Dmb4l8Y7qMCf5T2qCe6ICupPe.zAnB9M6zXI8YGgOF8AOmvt9e9Ey', NULL, '2026-02-12 03:02:10', '2026-02-12 03:02:10', 'Chike', NULL, 'Badrina', NULL, NULL, 'cbadrina944', 0, NULL),
(113, '', 4, 'bantotoclarissa@gmail.com', NULL, '$2y$12$16GYTqOB.va0a.RouGDlRuF9.3t.StXmf3becXWJzrRnI1/URb832', NULL, '2026-02-12 03:04:21', '2026-02-12 03:04:21', 'Clarissa Niña', NULL, 'Bantoto', NULL, NULL, 'cbantoto845', 0, NULL),
(114, '', 4, 'cabanillacriskeira@gmail.com', NULL, '$2y$12$hF4pNHk355KxgjtDG3GP9e6wx96smgU9BcHK/TgcBzY34lQIPFDBK', NULL, '2026-02-12 03:05:44', '2026-02-12 03:05:44', 'Cris Keira', NULL, 'Cabanilla', NULL, NULL, 'ccabanilla400', 0, NULL),
(115, '', 4, 'camachobriannazia@gmail.com', NULL, '$2y$12$KK7AyzqNTfF4dvNJ443BTuf4ndFmi24eiglx0SxIOPaV2XpesIPYu', NULL, '2026-02-12 03:08:18', '2026-02-12 03:08:18', 'Brianna Zia', NULL, 'Camacho', NULL, NULL, 'bcamacho756', 0, NULL),
(116, '', 4, 'carvellidaprimrose@gmail.com', NULL, '$2y$12$Mfwq/zMaSb42.8XDfpVoA..jMwFvVoN8JY4.2ywnC9IpYKUIbbHzG', NULL, '2026-02-12 03:09:40', '2026-02-12 03:09:40', 'Prim Rose', NULL, 'Carvellida', NULL, NULL, 'pcarvellida701', 0, NULL),
(117, '', 4, 'chukynleigh@gmail.com', NULL, '$2y$12$PW1cnAS4gHkj05We03VewO65sOoB0Yb3ljl2ZiLn75CiWPYR6gU1.', NULL, '2026-02-12 03:11:08', '2026-02-12 03:11:08', 'Kynleigh', NULL, 'Chu', NULL, NULL, 'kchu755', 0, NULL),
(118, '', 4, 'divinajhellamae@gmail.com', NULL, '$2y$12$CFKr29Iq3A312uHwt6sCOu5Xe09E/fezPG0TVD2lNwy2zBrkiStp6', NULL, '2026-02-12 03:12:34', '2026-02-12 03:12:34', 'Jhella Mae', NULL, 'Divina', NULL, NULL, 'jdivina246', 0, NULL),
(119, '', 4, 'gargarjewelscarlet@gmail.com', NULL, '$2y$12$kWCeBSuzkljX5JxnEL3WiOsjqpiNErtSI1MMc8PvSGeSs2h2YB3F.', NULL, '2026-02-12 03:14:00', '2026-02-12 03:14:00', 'Jewel Scarlet', NULL, 'Gargar', NULL, NULL, 'jgargar863', 0, NULL),
(120, '', 4, 'icaonapoasherahelsie@gmail.com', NULL, '$2y$12$ABEdoyuBrvC1mdui.Cb8sO3M1L2zbeY31gBqvAlkEsyvM5SJMxbge', NULL, '2026-02-12 03:15:32', '2026-02-12 03:15:32', 'Asherah Elsie', NULL, 'Icaonapo', NULL, NULL, 'aicaonapo374', 0, NULL),
(121, '', 4, 'lampasojairilmonette@gmail.com', NULL, '$2y$12$uTcTGB8klfSit3qKMrGYPuvKEpEDMB/VVgFWG5Y4tT.Cqu2fOnJkK', NULL, '2026-02-12 03:17:06', '2026-02-12 03:17:06', 'Jairil Monette', NULL, 'Lampaso', NULL, NULL, 'jlampaso786', 0, NULL),
(122, '', 4, 'lozadafrancine@gmail.com', NULL, '$2y$12$qXHsdBxt/A2TVjwOBwy3L.jrUKNWgx3J6d3LCtpDJMM0r5nlfiiFy', NULL, '2026-02-12 03:18:14', '2026-02-12 03:18:14', 'Francine', NULL, 'Lozada', NULL, NULL, 'flozada386', 0, NULL),
(123, '', 4, 'mohammadcrissmalyn@gmail.com', NULL, '$2y$12$qUHgAbys1/KCP4suaJbEN.Ym4DRDQ0fg1OLSZX6lmy8Ykxc.UUESS', NULL, '2026-02-12 03:19:50', '2026-02-12 03:19:50', 'Crissmalyn Faye', NULL, 'Mohammad', NULL, NULL, 'cmohammad253', 0, NULL),
(124, '', 4, 'mohellolianah@gmail.com', NULL, '$2y$12$O9s9MfGcF67c6SlWFfCJHOgq7jEbd3ZvZfAM80.jIMiGJy0CVvqLq', NULL, '2026-02-12 03:21:28', '2026-02-12 03:21:28', 'Lianah', NULL, 'Mohello', NULL, NULL, 'lmohello339', 0, NULL),
(125, '', 4, 'paoarianne@gmail.com', NULL, '$2y$12$aCjxozpilp29mmbe18QqROIUkyYboO.EYgZYWT4eQ4b20/EbNeX0e', NULL, '2026-02-12 03:22:40', '2026-02-12 03:22:40', 'Arianne', NULL, 'Pao', NULL, NULL, 'apao617', 0, NULL),
(126, '', 4, 'paquinolavrilkate@gmail.com', NULL, '$2y$12$KNJlt2OtaTp4mRzuecgFoONC18nPdvZJfTs0VdvWbWzZgyoocPDYC', NULL, '2026-02-12 03:24:11', '2026-02-12 03:24:11', 'Avril Kate', NULL, 'Paquinol', NULL, NULL, 'apaquinol664', 0, NULL),
(127, '', 4, 'salatanmariacelestine@gmail.com', NULL, '$2y$12$MKgZdSdtAe7qsuOELF8oXO4FSVWrgAwGGVMbffRQrSQRyHjZNCyY2', NULL, '2026-02-12 03:47:51', '2026-02-12 18:53:01', 'Maria Celestine', NULL, 'Salatan', NULL, NULL, 'mssalatan111', 0, NULL),
(128, '', 4, 'senahondjanne@gmail.com', NULL, '$2y$12$1j9wT96qPtyJ3Swzf7/v0OB1JUt.OZEnHtq/D0whXhqkWr6sATEcm', NULL, '2026-02-12 03:49:36', '2026-02-16 14:46:55', 'DJ Anne', NULL, 'Senahon', NULL, NULL, 'dsenahon72', 1, NULL),
(129, '', 4, 'tenedoelainejoy@gmail.com', NULL, '$2y$12$fsbO4rOx1NHH1/AHczKWdOlpz7okmydKxhKIiFrFHO31aoVcweczW', NULL, '2026-02-12 03:51:07', '2026-02-12 03:51:07', 'Elaine Joy', NULL, 'Tenedo', NULL, NULL, 'etenedo678', 0, NULL),
(130, '', 4, 'tubleellyzamae@gmail.com', NULL, '$2y$12$XVHDIfwgZXr9eOcBHnnUzO.SxMAXYiqvYT2n0yM2ujkwErnv59joa', NULL, '2026-02-12 03:52:46', '2026-02-12 18:44:31', 'Ellyza Mae', NULL, 'Tuble', NULL, NULL, 'etuble321', 0, NULL),
(132, '', 4, 'villamiljillianneshan@gmail.com', NULL, '$2y$12$VvPgmBYL02dhct8T07TXd.AvreRHTae3OD7TvYo36MBHxO39sFgvG', NULL, '2026-02-12 18:02:40', '2026-02-12 18:02:40', 'Jillianne Shane', NULL, 'Villamil', NULL, NULL, 'jvillamil438', 0, NULL),
(150, '', 2, 'tugaweESadmin@gmail.com', NULL, '$2y$12$XJxk7PBRdGhBSAeb/kfQ4.oe.QiGClDMC9/F2MBr99..DxBFDWv92', NULL, '2026-02-13 18:04:40', '2026-02-13 18:04:40', 'System', NULL, 'Administrator', NULL, NULL, 'admin123', 0, NULL),
(153, '', 4, 'cresttuayon7@gmail.com', NULL, '$2y$12$BvuxxgYVKMCbiksYw4fCpOKyEgxrPiFWgfyj1plZfqzIpOHP7BOa6', NULL, '2026-02-15 00:12:46', '2026-02-15 00:12:46', 'Crestian', NULL, 'Tuayon', NULL, NULL, 'ctuayon282', 0, NULL),
(154, '', 4, 'troituayon@gmail.com', NULL, '$2y$12$VIz.r7oGtGx106kigWzdFug7dISIT6rP5slDfFZVzbBXgWPRc5Omy', NULL, '2026-02-15 01:11:47', '2026-02-15 01:11:47', 'Troilan', NULL, 'Tuayon', NULL, NULL, 'ttuayon698', 0, NULL),
(157, '', 4, 'ezimeitradio@gmail.com', NULL, '$2y$12$gmLyg8u6kF4S81B/gALKMemehDWRKESxE/FVhimibLKduFYCqA8s2', NULL, '2026-02-16 08:34:24', '2026-02-16 08:34:24', 'Ejie Mae', NULL, 'Tradio', NULL, NULL, 'etradio758', 0, NULL),
(162, '120231260087', 4, 'baldomarnoime@gmail.com', NULL, '$2y$12$gvviHzsTBwHM0goohaeaYOryjcBU2xr4VEEeey8L389A6S5qPn7py', NULL, '2026-02-16 15:07:01', '2026-02-16 15:07:01', 'Noime', 'T.', 'Baldomar', NULL, '2026-02-17', 'evarocksredhell', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `year_levels`
--

CREATE TABLE `year_levels` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `year_levels`
--

INSERT INTO `year_levels` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Kindergarten', '2026-01-28 22:21:48', '2026-01-28 22:21:48'),
(2, 'Grade 1', '2026-01-28 22:21:48', '2026-01-28 22:21:48'),
(3, 'Grade 2', '2026-01-28 22:21:48', '2026-01-28 22:21:48'),
(4, 'Grade 3', '2026-01-28 22:21:48', '2026-01-28 22:21:48'),
(5, 'Grade 4', '2026-01-28 22:21:48', '2026-01-28 22:21:48'),
(6, 'Grade 5', '2026-01-28 22:21:48', '2026-01-28 22:21:48'),
(7, 'Grade 6', '2026-01-28 22:21:48', '2026-01-28 22:21:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_user_id_foreign` (`user_id`),
  ADD KEY `announcements_section_id_foreign` (`section_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendances_student_id_date_unique` (`student_id`,`date`),
  ADD KEY `attendances_section_id_foreign` (`section_id`);

--
-- Indexes for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendance_records_section_id_date_unique` (`section_id`,`date`),
  ADD KEY `attendance_records_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollments_student_id_foreign` (`student_id`),
  ADD KEY `enrollments_section_id_foreign` (`section_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `school_years`
--
ALTER TABLE `school_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_student`
--
ALTER TABLE `section_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_student_student_id_foreign` (`student_id`),
  ADD KEY `section_student_section_id_foreign` (`section_id`);

--
-- Indexes for table `section_subject`
--
ALTER TABLE `section_subject`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_subject_section_id_subject_id_unique` (`section_id`,`subject_id`),
  ADD KEY `section_subject_subject_id_foreign` (`subject_id`),
  ADD KEY `section_subject_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `section_teacher`
--
ALTER TABLE `section_teacher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_teacher_teacher_id_foreign` (`teacher_id`),
  ADD KEY `section_teacher_section_id_foreign` (`section_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_email_unique` (`email`),
  ADD UNIQUE KEY `students_school_id_unique` (`school_id`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_section_id_foreign` (`section_id`),
  ADD KEY `students_teacher_id_foreign` (`teacher_id`),
  ADD KEY `students_school_year_id_foreign` (`school_year_id`);

--
-- Indexes for table `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_subjects_student_id_subject_id_school_year_id_unique` (`student_id`,`subject_id`,`school_year_id`),
  ADD KEY `student_subjects_subject_id_foreign` (`subject_id`),
  ADD KEY `student_subjects_teacher_id_foreign` (`teacher_id`),
  ADD KEY `student_subjects_section_id_foreign` (`section_id`),
  ADD KEY `student_subjects_school_year_id_foreign` (`school_year_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `teachers_employee_id_unique` (`employee_id`),
  ADD KEY `teachers_advisory_section_id_foreign` (`advisory_section_id`);

--
-- Indexes for table `teaching_loads`
--
ALTER TABLE `teaching_loads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teaching_loads_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `year_levels`
--
ALTER TABLE `year_levels`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `attendance_records`
--
ALTER TABLE `attendance_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `section_student`
--
ALTER TABLE `section_student`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `section_subject`
--
ALTER TABLE `section_subject`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section_teacher`
--
ALTER TABLE `section_teacher`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `student_subjects`
--
ALTER TABLE `student_subjects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `teaching_loads`
--
ALTER TABLE `teaching_loads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `year_levels`
--
ALTER TABLE `year_levels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `announcements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD CONSTRAINT `attendance_records_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_records_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `section_student`
--
ALTER TABLE `section_student`
  ADD CONSTRAINT `section_student_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `section_student_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `section_subject`
--
ALTER TABLE `section_subject`
  ADD CONSTRAINT `section_subject_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `section_subject_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `section_subject_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `section_teacher`
--
ALTER TABLE `section_teacher`
  ADD CONSTRAINT `section_teacher_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `section_teacher_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD CONSTRAINT `student_subjects_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_subjects_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_subjects_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_subjects_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_subjects_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_advisory_section_id_foreign` FOREIGN KEY (`advisory_section_id`) REFERENCES `sections` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `teachers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teaching_loads`
--
ALTER TABLE `teaching_loads`
  ADD CONSTRAINT `teaching_loads_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
