-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 22, 2026 at 04:54 AM
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
  `school_year_id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `status` enum('enrolled','promoted','retained','transferred','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'enrolled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `school_year_id`, `section_id`, `status`, `created_at`, `updated_at`) VALUES
(34, 163, 1, 50, 'enrolled', '2026-02-21 20:41:19', '2026-02-21 20:41:19');

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
  `component` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quarter` tinyint NOT NULL,
  `grade` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `component`, `quarter`, `grade`, `created_at`, `updated_at`) VALUES
(78, 163, 93, NULL, 1, 83, '2026-02-21 20:46:40', '2026-02-21 20:46:40'),
(79, 163, 93, NULL, 2, 86, '2026-02-21 20:46:40', '2026-02-21 20:46:40'),
(80, 163, 93, NULL, 3, 88, '2026-02-21 20:46:40', '2026-02-21 20:46:40'),
(81, 163, 93, NULL, 4, 90, '2026-02-21 20:46:40', '2026-02-21 20:46:40'),
(82, 163, 94, NULL, 1, 85, '2026-02-21 20:46:40', '2026-02-21 20:46:40'),
(83, 163, 94, NULL, 2, 87, '2026-02-21 20:46:40', '2026-02-21 20:46:40'),
(84, 163, 94, NULL, 3, 88, '2026-02-21 20:46:40', '2026-02-21 20:46:40'),
(85, 163, 94, NULL, 4, 89, '2026-02-21 20:46:40', '2026-02-21 20:46:40'),
(86, 163, 95, NULL, 1, 88, '2026-02-21 20:46:40', '2026-02-21 20:46:40'),
(87, 163, 95, NULL, 2, 87, '2026-02-21 20:46:40', '2026-02-21 20:46:40'),
(88, 163, 95, NULL, 3, 88, '2026-02-21 20:46:40', '2026-02-21 20:46:40'),
(89, 163, 95, NULL, 4, 88, '2026-02-21 20:46:40', '2026-02-21 20:46:40'),
(90, 163, 96, NULL, 1, 87, '2026-02-21 20:46:40', '2026-02-21 20:46:40'),
(91, 163, 96, NULL, 2, 88, '2026-02-21 20:46:40', '2026-02-21 20:46:40'),
(92, 163, 96, NULL, 3, 89, '2026-02-21 20:46:40', '2026-02-21 20:46:40'),
(93, 163, 96, NULL, 4, 88, '2026-02-21 20:46:40', '2026-02-21 20:46:40');

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
(68, '2026_02_17_092505_add_components_to_subjects_table', 60),
(70, '2026_02_18_080052_add_component_to_grades_table', 61),
(71, '2026_02_18_082828_create_grades_table', 62),
(72, '2026_02_18_084853_create_grades_table', 63),
(74, '2026_02_19_053101_add_teacher_id_to_subjects_table', 64),
(75, '2026_02_21_125747_create_enrollments_table', 64);

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
(1, '2025-2026', 1, '2026-02-10 17:00:16', '2026-02-21 06:02:31'),
(2, '2026-2027', 0, '2026-02-10 17:00:16', '2026-02-21 06:02:31'),
(3, '2027-2028', 0, '2026-02-10 17:00:16', '2026-02-21 06:02:31'),
(4, '2028-2029', 0, '2026-02-10 17:00:16', '2026-02-21 06:02:31'),
(5, '2029-2030', 0, '2026-02-10 17:00:16', '2026-02-21 06:02:31'),
(6, '2030-2031', 0, '2026-02-10 17:00:16', '2026-02-21 06:02:31'),
(7, '2031-2032', 0, '2026-02-10 17:00:16', '2026-02-21 06:02:31'),
(8, '2032-2033', 0, '2026-02-10 17:00:16', '2026-02-21 06:02:31'),
(9, '2033-2034', 0, '2026-02-10 17:00:16', '2026-02-21 06:02:31');

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
(50, 'SAMPAGUITA', 'Grade 6', 42, '2026-02-14 01:35:15', '2026-02-17 05:24:41', 40, 1),
(54, 'Lily', 'Grade 2', 42, '2026-02-16 17:42:51', '2026-02-18 15:59:09', 40, 1);

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
('VUss0XkI0JFMlcgGYESbKtOTEVkgElvABsy34H9G', 42, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSnhISWQ2MGV4MDNFN0dlY3VTN3JZbzVTNlBQSkRpSjJYOHhWUjY3MCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90ZWFjaGVyL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoxNzoidGVhY2hlci5kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0Mjt9', 1771735993);

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
(163, '120231090040', 'Crestian', 'Bajado', 'Tuayon', NULL, 'Male', 'III', '2004-01-07', 'cresttuayon@gmail.com', '09368726547', 'Tugawe, Dauin, Negros Oriental', 163, NULL, '2026-02-21 17:36:01', '2026-02-21 17:36:01', NULL, NULL, 'students/0tGMCaY8Z5vFTJGDTreJgGwbzaK0uTv8XVn7NHod.jpg', NULL, NULL);

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `teacher_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `code`, `name`, `grade_level`, `components`, `created_at`, `updated_at`, `teacher_id`) VALUES
(93, 'K_LIT', 'Language Literacy', 'Kindergarten', NULL, NULL, NULL, NULL),
(94, 'K_NUM', 'Number Readiness', 'Kindergarten', NULL, NULL, NULL, NULL),
(95, 'K_HEALTH', 'Health & Safety', 'Kindergarten', NULL, NULL, NULL, NULL),
(96, 'K_PE', 'Physical Education', 'Kindergarten', NULL, NULL, NULL, NULL),
(97, 'FIL1', 'Filipino', 'Grade 1', NULL, NULL, NULL, NULL),
(98, 'ENG1', 'English', 'Grade 1', NULL, NULL, NULL, NULL),
(99, 'MATH1', 'Mathematics', 'Grade 1', NULL, NULL, NULL, NULL),
(100, 'ESP1', 'Edukasyon sa Pagpapakatao', 'Grade 1', NULL, NULL, NULL, NULL),
(101, 'MAPEH1', 'MAPEH', 'Grade 1', '[\"Music\", \"Arts\", \"Physical Education\", \"Health\"]', NULL, NULL, NULL),
(102, 'FIL2', 'Filipino', 'Grade 2', NULL, NULL, NULL, NULL),
(103, 'ENG2', 'English', 'Grade 2', NULL, NULL, NULL, NULL),
(104, 'MATH2', 'Mathematics', 'Grade 2', NULL, NULL, NULL, NULL),
(105, 'ESP2', 'Edukasyon sa Pagpapakatao', 'Grade 2', NULL, NULL, NULL, NULL),
(106, 'MAPEH2', 'MAPEH', 'Grade 2', '[\"Music\", \"Arts\", \"Physical Education\", \"Health\"]', NULL, NULL, NULL),
(107, 'AP2', 'Araling Panlipunan', 'Grade 2', NULL, NULL, NULL, NULL),
(108, 'FIL3', 'Filipino', 'Grade 3', NULL, NULL, NULL, NULL),
(109, 'ENG3', 'English', 'Grade 3', NULL, NULL, NULL, NULL),
(110, 'MATH3', 'Mathematics', 'Grade 3', NULL, NULL, NULL, NULL),
(111, 'SCI3', 'Science', 'Grade 3', NULL, NULL, NULL, NULL),
(112, 'ESP3', 'Edukasyon sa Pagpapakatao', 'Grade 3', NULL, NULL, NULL, NULL),
(113, 'MAPEH3', 'MAPEH', 'Grade 3', '[\"Music\", \"Arts\", \"Physical Education\", \"Health\"]', NULL, NULL, NULL),
(114, 'AP3', 'Araling Panlipunan', 'Grade 3', NULL, NULL, NULL, NULL),
(115, 'FIL4', 'Filipino', 'Grade 4', NULL, NULL, NULL, NULL),
(116, 'ENG4', 'English', 'Grade 4', NULL, NULL, NULL, NULL),
(117, 'MATH4', 'Mathematics', 'Grade 4', NULL, NULL, NULL, NULL),
(118, 'SCI4', 'Science', 'Grade 4', NULL, NULL, NULL, NULL),
(119, 'ESP4', 'Edukasyon sa Pagpapakatao', 'Grade 4', NULL, NULL, NULL, NULL),
(120, 'MAPEH4', 'MAPEH', 'Grade 4', '[\"Music\", \"Arts\", \"Physical Education\", \"Health\"]', NULL, NULL, NULL),
(121, 'AP4', 'Araling Panlipunan', 'Grade 4', NULL, NULL, NULL, NULL),
(122, 'EPP4', 'Edukasyong Pantahanan at Pangkabuhayan', 'Grade 4', NULL, NULL, NULL, NULL),
(123, 'FIL5', 'Filipino', 'Grade 5', NULL, NULL, NULL, NULL),
(124, 'ENG5', 'English', 'Grade 5', NULL, NULL, NULL, NULL),
(125, 'MATH5', 'Mathematics', 'Grade 5', NULL, NULL, NULL, NULL),
(126, 'SCI5', 'Science', 'Grade 5', NULL, NULL, NULL, NULL),
(127, 'ESP5', 'Edukasyon sa Pagpapakatao', 'Grade 5', NULL, NULL, NULL, NULL),
(128, 'MAPEH5', 'MAPEH', 'Grade 5', '[\"Music\", \"Arts\", \"Physical Education\", \"Health\"]', NULL, NULL, NULL),
(129, 'AP5', 'Araling Panlipunan', 'Grade 5', NULL, NULL, NULL, NULL),
(130, 'EPP5', 'Edukasyong Pantahanan at Pangkabuhayan', 'Grade 5', NULL, NULL, NULL, NULL),
(131, 'FIL6', 'Filipino', 'Grade 6', NULL, NULL, NULL, NULL),
(132, 'ENG6', 'English', 'Grade 6', NULL, NULL, NULL, NULL),
(133, 'MATH6', 'Mathematics', 'Grade 6', NULL, NULL, NULL, NULL),
(134, 'SCI6', 'Science', 'Grade 6', NULL, NULL, NULL, NULL),
(135, 'ESP6', 'Edukasyon sa Pagpapakatao', 'Grade 6', NULL, NULL, NULL, NULL),
(136, 'MAPEH6', 'MAPEH', 'Grade 6', '[\"Music\", \"Arts\", \"Physical Education\", \"Health\"]', NULL, NULL, NULL),
(137, 'AP6', 'Araling Panlipunan', 'Grade 6', NULL, NULL, NULL, NULL),
(138, 'EPP6', 'Edukasyong Pantahanan at Pangkabuhayan', 'Grade 6', NULL, NULL, NULL, NULL);

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
(3, 42, 'Juan', 'De La', 'Cruz', 'Jr.', '1995-01-02', 'juandelacruz@gmail.com', '09759264665', NULL, NULL, 'teachers/AA9eOlMh5rsiZ6u1VXW65kIoRnb22v6Np4HqZjPC.jpg', NULL, '2026-02-10 23:50:01', '2026-02-15 21:00:20', 'Principal I', 4, '1', 14, 13, 'Mae Harriet M. De la Pena, EdD', 'Alelyn D. Nocete', 'Beda Jovenciana D. Agor, EdD');

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
(1, '', 1, 'admin@tugaweES.edu.ph', NULL, '$2y$12$zXtYoxdECMpT8DvDKSKFee0E.B7PXe4yQgoRJim6sPz/1zutl3Gsu', 'c516hpdcfxHddMUP7DvV7RlFgzLroIxCv4k2GBvxNIsdRevKLJe2GAhYO2Om', '2026-01-27 05:37:20', '2026-02-18 16:57:29', '', NULL, '', NULL, NULL, '', 2, NULL),
(2, '', 3, 'registrar@tugaweES.edu.ph', NULL, '$2y$12$U.1P6YsXem2b3PGR94gFeO14UKaqX8ohqvff/ouYL7FnqE9LDE.oi', 'nccbD0wj3C8DCCA5bmj539qorahXQTTW7a2N4I9oydPbwKJlK9BuJAP5QvYK', '2026-01-27 05:37:21', '2026-01-27 05:37:21', '', NULL, '', NULL, NULL, '', 0, NULL),
(42, '', 2, 'juandelacruz@gmail.com', NULL, '$2y$12$W7asov1IAI8NcPPXLa1Ln.NEW2oYwK.6eyUPvVGr6HyG8PM3U8NeO', NULL, '2026-02-10 23:50:01', '2026-02-16 06:11:16', 'Juan', NULL, 'Cruz', NULL, NULL, 'juandelacruz', 1, NULL),
(163, '120231090040', 4, 'cresttuayon@gmail.com', NULL, '$2y$12$qYxrwngqjSJTO7M8s0JqdeETmL9W42Fmn/PGnLCTGUTqqJ1/DpekO', NULL, '2026-02-21 17:36:01', '2026-02-21 17:36:01', 'Crestian', 'Bajado', 'Tuayon', 'III', '2004-01-07', 'crstn', 0, NULL);

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
  ADD UNIQUE KEY `enrollments_student_id_school_year_id_unique` (`student_id`,`school_year_id`),
  ADD KEY `enrollments_school_year_id_foreign` (`school_year_id`),
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
  ADD UNIQUE KEY `grades_student_id_subject_id_component_quarter_unique` (`student_id`,`subject_id`,`component`,`quarter`),
  ADD KEY `grades_subject_id_foreign` (`subject_id`);

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
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `subjects_teacher_id_foreign` (`teacher_id`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

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
  ADD CONSTRAINT `enrollments_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
