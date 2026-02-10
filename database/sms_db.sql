-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 09, 2026 at 05:00 PM
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
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` enum('none','present','late','absent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `student_id`, `section_id`, `date`, `status`, `created_at`, `updated_at`) VALUES
(1, 58, 38, '2026-02-09', 'none', '2026-02-09 08:07:49', '2026-02-09 08:36:08'),
(2, 59, 38, '2026-02-09', 'none', '2026-02-09 08:07:49', '2026-02-09 08:36:08'),
(3, 58, 38, '2026-02-10', 'none', '2026-02-09 08:08:33', '2026-02-09 08:36:08'),
(4, 59, 38, '2026-02-10', 'none', '2026-02-09 08:08:33', '2026-02-09 08:36:08'),
(5, 58, 38, '2026-02-01', 'present', '2026-02-09 08:36:08', '2026-02-09 08:36:20'),
(6, 58, 38, '2026-02-02', 'late', '2026-02-09 08:36:08', '2026-02-09 08:45:21'),
(7, 58, 38, '2026-02-03', 'absent', '2026-02-09 08:36:08', '2026-02-09 08:47:01'),
(8, 58, 38, '2026-02-04', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(9, 58, 38, '2026-02-05', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(10, 58, 38, '2026-02-06', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(11, 58, 38, '2026-02-07', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(12, 58, 38, '2026-02-08', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(13, 58, 38, '2026-02-11', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(14, 58, 38, '2026-02-12', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(15, 58, 38, '2026-02-13', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(16, 58, 38, '2026-02-14', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(17, 58, 38, '2026-02-15', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(18, 58, 38, '2026-02-16', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(19, 58, 38, '2026-02-17', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(20, 58, 38, '2026-02-18', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(21, 58, 38, '2026-02-19', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(22, 58, 38, '2026-02-20', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(23, 58, 38, '2026-02-21', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(24, 58, 38, '2026-02-22', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(25, 58, 38, '2026-02-23', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(26, 58, 38, '2026-02-24', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(27, 58, 38, '2026-02-25', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(28, 58, 38, '2026-02-26', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(29, 58, 38, '2026-02-27', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(30, 58, 38, '2026-02-28', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(31, 59, 38, '2026-02-01', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(32, 59, 38, '2026-02-02', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(33, 59, 38, '2026-02-03', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(34, 59, 38, '2026-02-04', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(35, 59, 38, '2026-02-05', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(36, 59, 38, '2026-02-06', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(37, 59, 38, '2026-02-07', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(38, 59, 38, '2026-02-08', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(39, 59, 38, '2026-02-11', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(40, 59, 38, '2026-02-12', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(41, 59, 38, '2026-02-13', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(42, 59, 38, '2026-02-14', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(43, 59, 38, '2026-02-15', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(44, 59, 38, '2026-02-16', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(45, 59, 38, '2026-02-17', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(46, 59, 38, '2026-02-18', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(47, 59, 38, '2026-02-19', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(48, 59, 38, '2026-02-20', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(49, 59, 38, '2026-02-21', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(50, 59, 38, '2026-02-22', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(51, 59, 38, '2026-02-23', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(52, 59, 38, '2026-02-24', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(53, 59, 38, '2026-02-25', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(54, 59, 38, '2026-02-26', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(55, 59, 38, '2026-02-27', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08'),
(56, 59, 38, '2026-02-28', 'none', '2026-02-09 08:36:08', '2026-02-09 08:36:08');

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
  `quarter` tinyint UNSIGNED NOT NULL,
  `grade` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `quarter`, `grade`, `created_at`, `updated_at`) VALUES
(1, 58, 1, 1, 90.00, '2026-02-09 07:41:40', '2026-02-09 07:42:16'),
(2, 58, 2, 1, 88.00, '2026-02-09 07:41:40', '2026-02-09 07:42:16'),
(3, 58, 3, 1, 87.00, '2026-02-09 07:41:40', '2026-02-09 07:42:16'),
(4, 58, 4, 1, 90.00, '2026-02-09 07:41:40', '2026-02-09 07:42:16'),
(5, 58, 5, 1, 92.00, '2026-02-09 07:41:40', '2026-02-09 07:42:16'),
(6, 58, 6, 1, 94.00, '2026-02-09 07:41:40', '2026-02-09 07:42:16'),
(7, 58, 7, 1, 85.00, '2026-02-09 07:41:40', '2026-02-09 07:42:16'),
(8, 58, 8, 1, 97.00, '2026-02-09 07:41:40', '2026-02-09 07:42:16'),
(9, 58, 1, 2, 90.00, '2026-02-09 07:46:22', '2026-02-09 07:46:22'),
(10, 58, 1, 3, 88.00, '2026-02-09 07:46:22', '2026-02-09 07:46:22'),
(11, 58, 1, 4, 87.00, '2026-02-09 07:46:22', '2026-02-09 07:46:22');

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
(49, '2026_02_09_160343_create_attendances_table', 43);

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
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `school_year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2026-2027',
  `teacher_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `capacity` int NOT NULL DEFAULT '40'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `year_level`, `school_year`, `teacher_id`, `created_at`, `updated_at`, `capacity`) VALUES
(38, 'Mercury', 'Kindergarten', '2025-2026', 13, '2026-02-07 14:41:36', '2026-02-07 22:39:50', 40),
(39, 'Venus', 'Grade 1', '2025-2026', NULL, '2026-02-07 22:42:11', '2026-02-07 22:48:53', 40);

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
('o8YF7s7tRGFx4cZybhZuL9GWM0J0WZdAmSFkSLjS', 13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ3F5MHZqYWttOEFmbVV2Z002cTNvNlkxTE1UR0lPWVM5R25yY2x0OCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQvc3RhdHMiO3M6NToicm91dGUiO3M6MjE6ImFkbWluLmRhc2hib2FyZC5zdGF0cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEzO30=', 1770656127);

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
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `lrn`, `first_name`, `middle_name`, `last_name`, `average_grade`, `sex`, `suffix`, `birthday`, `email`, `contact_number`, `address`, `user_id`, `section_id`, `created_at`, `updated_at`, `teacher_id`, `school_id`, `photo`) VALUES
(58, '120231090040', 'Crestian', 'Bajado', 'Tuayon', 90.50, 'Male', NULL, '2004-01-07', 'cresttuayon@gmail.com', '09368726547', 'Tugawe, Dauin, Negros Oriental', 36, 38, '2026-02-07 23:15:00', '2026-02-09 06:31:59', NULL, 'S-120231260001', 'photos/7T6haQwMkIrlv3coGpqKKYTxffe99IG68S83yg0q.jpg'),
(59, '120231000036', 'Caterine', 'Abad', 'Alagadmo', 89.50, 'Female', NULL, '2003-10-03', 'alagadmocatherine@gmail.com', '09759264665', 'Tugawe, Dauin, Negros Oriental', 37, 38, '2026-02-07 23:28:13', '2026-02-09 06:32:00', NULL, 'S-120231260002', 'photos/aZtzcluAtlVoj8fFHCyy0QxqixkUe8FOvU4U0iu4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'English', '2026-02-09 05:46:38', '2026-02-09 05:46:38'),
(2, 'Filipino', '2026-02-09 05:46:38', '2026-02-09 05:46:38'),
(3, 'Mathematics', '2026-02-09 05:46:38', '2026-02-09 05:46:38'),
(4, 'Science', '2026-02-09 05:46:38', '2026-02-09 05:46:38'),
(5, 'Araling Panlipunan', '2026-02-09 05:46:38', '2026-02-09 05:46:38'),
(6, 'Edukasyong Pantahanan at Pangkabuhayan (EPP)', '2026-02-09 05:46:38', '2026-02-09 05:46:38'),
(7, 'Music, Arts, PE, and Health (MAPEH)', '2026-02-09 05:46:38', '2026-02-09 05:46:38'),
(8, 'Values Education', '2026-02-09 05:46:38', '2026-02-09 05:46:38');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `lrn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suffix` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `lrn`, `first_name`, `middle_name`, `last_name`, `suffix`, `birthday`, `username`) VALUES
(1, 1, 'admin@tugaweES.edu.ph', NULL, '$2y$12$zXtYoxdECMpT8DvDKSKFee0E.B7PXe4yQgoRJim6sPz/1zutl3Gsu', 'IA08b1g3ImVZZaH61Zf36V92HGc3grdYOFZUlAcYxPaxzGbvTJgDl6mBFl3E', '2026-01-27 05:37:20', '2026-01-27 05:37:20', NULL, '', NULL, '', NULL, NULL, ''),
(2, 3, 'registrar@tugaweES.edu.ph', NULL, '$2y$12$U.1P6YsXem2b3PGR94gFeO14UKaqX8ohqvff/ouYL7FnqE9LDE.oi', 'nccbD0wj3C8DCCA5bmj539qorahXQTTW7a2N4I9oydPbwKJlK9BuJAP5QvYK', '2026-01-27 05:37:21', '2026-01-27 05:37:21', NULL, '', NULL, '', NULL, NULL, ''),
(13, 2, 'teacher@tugaweES.edu.ph', NULL, '$2y$12$I703bY65xDMTGUJ/NA1hYuoccRQRYjy7INoW2feSbrdmlKoqmEbTO', NULL, '2026-01-28 21:57:58', '2026-01-28 21:57:58', NULL, 'Teacher', NULL, 'User', NULL, NULL, 'teacheruser1'),
(36, 4, 'cresttuayon@gmail.com', NULL, '$2y$12$cVf4Ip8ZPAM.ATsqpUGD8uCSp3KoexnV2L.PU/cGTkQKt4Sk0LfEK', NULL, '2026-02-07 23:15:00', '2026-02-07 23:15:00', NULL, 'Crestian', NULL, 'Tuayon', NULL, NULL, 'ctuayon985'),
(37, 4, 'alagadmocatherine@gmail.com', NULL, '$2y$12$zd48NCck5rZWDRjLUWwT8uGT8KRTWVYb/0nv0aef83v4.48x3nY7a', NULL, '2026-02-07 23:28:13', '2026-02-07 23:28:13', NULL, 'Caterine', NULL, 'Alagadmo', NULL, NULL, 'calagadmo245');

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
  ADD UNIQUE KEY `grades_student_id_subject_id_quarter_unique` (`student_id`,`subject_id`,`quarter`),
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
  ADD KEY `students_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_email_unique` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_lrn_unique` (`lrn`),
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
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `section_student`
--
ALTER TABLE `section_student`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `year_levels`
--
ALTER TABLE `year_levels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

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
  ADD CONSTRAINT `grades_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `section_student`
--
ALTER TABLE `section_student`
  ADD CONSTRAINT `section_student_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `section_student_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
