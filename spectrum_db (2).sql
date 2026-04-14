-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2026 at 04:48 AM
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
-- Database: `spectrum_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_spectrum_attachment`
--

CREATE TABLE `wp_spectrum_attachment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `evidence_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_type` varchar(100) DEFAULT NULL,
  `file_size` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_spectrum_evidence`
--

CREATE TABLE `wp_spectrum_evidence` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submitter_id` bigint(20) UNSIGNED NOT NULL,
  `year` int(11) NOT NULL,
  `unit_code` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `summary` text DEFAULT NULL,
  `justification` text DEFAULT NULL,
  `link_url` text DEFAULT NULL,
  `attachment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `metric_category` enum('MANDATORY','RECOMMENDED','GENERAL') DEFAULT NULL,
  `status` enum('DRAFT','SUBMITTED','APPROVED','REJECTED') NOT NULL DEFAULT 'DRAFT',
  `submitted_at` datetime DEFAULT NULL,
  `last_reviewed_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_spectrum_evidence`
--

INSERT INTO `wp_spectrum_evidence` (`id`, `submitter_id`, `year`, `unit_code`, `title`, `summary`, `justification`, `link_url`, `attachment_id`, `metric_category`, `status`, `submitted_at`, `last_reviewed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2024, 'UNKNOWN', 'tes1 edit', 'edit 2– twr', NULL, '', NULL, NULL, 'REJECTED', '2026-02-26 06:35:09', '2026-02-26 06:47:40', '2026-02-25 08:13:30', '2026-02-26 06:47:40'),
(2, 1, 2024, 'UNKNOWN', 'tes draft 1', 'tes draft file', NULL, '', 92, NULL, 'APPROVED', '2026-02-26 06:48:21', '2026-02-26 06:48:36', '2026-02-26 06:39:16', '2026-02-26 06:48:36'),
(3, 1, 2024, 'UNKNOWN', 'tes redirect', 'redirect to evidence saya', NULL, '', NULL, NULL, 'SUBMITTED', '2026-02-27 06:53:04', NULL, '2026-02-27 06:52:52', '2026-02-27 06:53:04'),
(4, 1, 2024, 'UNKNOWN', 'tes', 'tes', NULL, '', NULL, NULL, 'SUBMITTED', '2026-02-27 06:53:18', NULL, '2026-02-27 06:53:18', '2026-02-27 06:53:18'),
(5, 1, 2024, 'UNKNOWN', 'redirect tes2', 'rejected tes edit', NULL, 'http://localhost/spectrum/detail-evidence/?evidence_id=5&mode=edit', NULL, NULL, 'DRAFT', NULL, '2026-03-02 07:38:33', '2026-02-27 06:57:24', '2026-03-02 07:44:00'),
(6, 1, 2024, 'UNKNOWN', 'tes link', 'tr', NULL, '', NULL, NULL, 'APPROVED', '2026-02-27 06:58:56', '2026-03-02 07:38:28', '2026-02-27 06:58:56', '2026-03-02 07:38:28'),
(7, 1, 2024, 'UNKNOWN', 'tes link 2', 'tes', NULL, 'http://localhost/spectrum/buat-evidence-baru/', NULL, NULL, 'REJECTED', '2026-02-27 07:00:01', '2026-03-02 03:41:50', '2026-02-27 07:00:01', '2026-03-02 03:41:50'),
(8, 1, 2024, 'UNKNOWN', 'tes redirect', 'tes kosong liink and file', NULL, '', NULL, NULL, 'APPROVED', '2026-03-02 02:13:42', '2026-03-02 03:34:04', '2026-03-02 02:13:09', '2026-03-02 03:34:04'),
(9, 1, 2024, 'UNKNOWN', 'tes required - edited', 'tes', NULL, 'http://localhost/spectrum/test-jam2update-nih/', NULL, NULL, 'DRAFT', NULL, NULL, '2026-03-02 03:39:00', '2026-03-02 07:53:21'),
(10, 1, 2024, 'UNKNOWN', 'tes created_at', 'tes-edit', NULL, 'http://localhost/spectrum/buat-evidence-baru/', NULL, NULL, 'DRAFT', NULL, NULL, '2026-03-02 07:55:54', '2026-03-02 14:57:45'),
(11, 1, 2024, 'UNKNOWN', 'created-at 2', '2', NULL, '', NULL, NULL, 'DRAFT', NULL, NULL, '2026-03-02 14:58:05', '2026-03-02 14:58:05'),
(12, 2, 2024, 'dirdik', 'tes dirdik', 'tes', NULL, 'http://localhost/spectrum/buat-evidence-baru/', NULL, 'GENERAL', 'SUBMITTED', '2026-03-10 14:51:55', NULL, '2026-03-10 14:51:55', '2026-03-10 14:51:55'),
(13, 2, 2024, 'dirdik', 'tes dirdik', 'tes', NULL, 'http://localhost/spectrum/buat-evidence-baru/', NULL, 'MANDATORY', 'APPROVED', '2026-03-10 14:52:48', '2026-03-10 14:53:33', '2026-03-10 14:52:00', '2026-03-10 14:53:33');

-- --------------------------------------------------------

--
-- Table structure for table `wp_spectrum_evidence_log`
--

CREATE TABLE `wp_spectrum_evidence_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `evidence_id` bigint(20) UNSIGNED NOT NULL,
  `actor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `from_status` varchar(32) DEFAULT NULL,
  `to_status` varchar(32) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_spectrum_evidence_log`
--

INSERT INTO `wp_spectrum_evidence_log` (`id`, `evidence_id`, `actor_id`, `from_status`, `to_status`, `notes`, `created_at`) VALUES
(1, 1, 1, NULL, 'DRAFT', 'Create evidence', '2026-02-25 08:13:30'),
(2, 1, 1, 'DRAFT', 'SUBMITTED', 'Update evidence', '2026-02-26 06:35:09'),
(3, 2, 1, NULL, 'DRAFT', 'Create evidence', '2026-02-26 06:39:16'),
(4, 1, 1, 'SUBMITTED', 'REJECTED', 'Review decision', '2026-02-26 06:47:40'),
(5, 2, 1, 'DRAFT', 'SUBMITTED', 'Update evidence', '2026-02-26 06:48:21'),
(6, 2, 1, 'SUBMITTED', 'APPROVED', 'Review decision', '2026-02-26 06:48:36'),
(7, 3, 1, NULL, 'DRAFT', 'Create evidence', '2026-02-27 06:52:52'),
(8, 3, 1, 'DRAFT', 'SUBMITTED', 'Update evidence', '2026-02-27 06:53:04'),
(9, 4, 1, NULL, 'SUBMITTED', 'Create evidence', '2026-02-27 06:53:18'),
(10, 5, 1, NULL, 'SUBMITTED', 'Create evidence', '2026-02-27 06:57:24'),
(11, 6, 1, NULL, 'SUBMITTED', 'Create evidence', '2026-02-27 06:58:57'),
(12, 7, 1, NULL, 'SUBMITTED', 'Create evidence', '2026-02-27 07:00:02'),
(13, 8, 1, NULL, 'DRAFT', 'Create evidence', '2026-03-02 02:13:09'),
(14, 8, 1, 'DRAFT', 'SUBMITTED', 'Update evidence', '2026-03-02 02:13:42'),
(15, 8, 1, 'SUBMITTED', 'APPROVED', 'Review decision', '2026-03-02 03:34:04'),
(16, 9, 1, NULL, 'DRAFT', 'Create evidence', '2026-03-02 03:39:00'),
(17, 7, 1, 'SUBMITTED', 'REJECTED', 'Review decision', '2026-03-02 03:41:50'),
(18, 6, 1, 'SUBMITTED', 'APPROVED', 'Review decision', '2026-03-02 07:38:28'),
(19, 5, 1, 'SUBMITTED', 'REJECTED', 'Review decision', '2026-03-02 07:38:33'),
(20, 5, 1, 'REJECTED', 'DRAFT', 'Update evidence', '2026-03-02 07:44:00'),
(21, 10, 1, NULL, 'DRAFT', 'Create evidence', '2026-03-02 07:55:54'),
(22, 11, 1, NULL, 'DRAFT', 'Create evidence', '2026-03-02 14:58:05'),
(23, 12, 2, NULL, 'SUBMITTED', 'Create evidence', '2026-03-10 14:51:55'),
(24, 13, 2, NULL, 'DRAFT', 'Create evidence', '2026-03-10 14:52:00'),
(25, 13, 2, 'DRAFT', 'SUBMITTED', 'Update evidence', '2026-03-10 14:52:48'),
(26, 13, 1, 'SUBMITTED', 'APPROVED', 'Review decision', '2026-03-10 14:53:33');

-- --------------------------------------------------------

--
-- Table structure for table `wp_spectrum_evidence_metric`
--

CREATE TABLE `wp_spectrum_evidence_metric` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `evidence_id` bigint(20) UNSIGNED NOT NULL,
  `metric_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_spectrum_evidence_metric`
--

INSERT INTO `wp_spectrum_evidence_metric` (`id`, `evidence_id`, `metric_id`, `created_at`) VALUES
(3, 1, 9, '2026-02-26 06:35:09'),
(5, 2, 14, '2026-02-26 06:48:21'),
(7, 3, 12, '2026-02-27 06:53:04'),
(8, 4, 13, '2026-02-27 06:53:18'),
(10, 6, 12, '2026-02-27 06:58:56'),
(11, 7, 12, '2026-02-27 07:00:02'),
(13, 8, 8, '2026-03-02 02:13:42'),
(19, 5, 15, '2026-03-02 07:44:00'),
(21, 9, 12, '2026-03-02 07:53:21'),
(23, 10, 14, '2026-03-02 14:57:45'),
(24, 11, 15, '2026-03-02 14:58:05'),
(25, 12, 3, '2026-03-10 14:51:55'),
(27, 13, 1, '2026-03-10 14:52:48');

-- --------------------------------------------------------

--
-- Table structure for table `wp_spectrum_function_metric_assignment`
--

CREATE TABLE `wp_spectrum_function_metric_assignment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metric_id` bigint(20) UNSIGNED NOT NULL,
  `year` int(11) NOT NULL,
  `category` enum('MANDATORY','RECOMMENDED') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wp_spectrum_function_metric_assignment`
--

INSERT INTO `wp_spectrum_function_metric_assignment` (`id`, `unit_code`, `metric_id`, `year`, `category`, `created_at`, `updated_at`) VALUES
(1, 'dirdik', 1, 2024, 'MANDATORY', '2026-03-10 14:46:05', NULL),
(2, 'dirdik', 2, 2024, 'MANDATORY', '2026-03-10 14:46:05', NULL),
(3, 'dirdik', 5, 2024, 'RECOMMENDED', '2026-03-10 14:46:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wp_spectrum_metric`
--

CREATE TABLE `wp_spectrum_metric` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sdg_number` tinyint(3) UNSIGNED NOT NULL,
  `metric_code` varchar(10) NOT NULL,
  `metric_type` enum('numeric','initiatives','policy') NOT NULL,
  `metric_title` varchar(255) NOT NULL,
  `metric_question` text DEFAULT NULL,
  `metric_note` longtext DEFAULT NULL,
  `is_active_default` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_spectrum_metric`
--

INSERT INTO `wp_spectrum_metric` (`id`, `sdg_number`, `metric_code`, `metric_type`, `metric_title`, `metric_question`, `metric_note`, `is_active_default`, `created_at`, `updated_at`) VALUES
(1, 1, '1.2.1', 'numeric', 'Number of students', NULL, 'Year: 2024\r\nDefinitions: Students\r\nThis is the FTE (full-time equivalent) number of students in all years and of all programmes that lead to a degree or certificate equivalent to an ISCED level 6, 7 or 8 qualification.', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(2, 1, '1.2.1', 'numeric', 'Number of low income students receiving financial aid', NULL, 'Year: 2024\r\nThis is the FTE (Full Time Equivalent) number of students receiving financial aid.', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(3, 1, '1.3.1', 'initiatives', 'Bottom financial quintile admission target', 'Does your university as a body have targets to admit students who fall into the bottom 20% of household income group (or a more tightly defined target) in the country?', 'Year: 2024\r\nPlease provide one piece of evidence to show targets. Evidence can include policy documents, reports, publicity materials, guides, timetable of services or similar. (You can only upload a maximum of one evidence item  in total per question.)\r\n\r\nData submission guidance \r\n\r\nDefinitions of income: When we refer to countries that are ‘Low or lower-middle income’ this relates to the definition of the country used by the World Bank. We also refer to the income of individuals or households in the country, for example ‘household income’ refers to the income of people in the country. All countries will have people with low relative incomes despite the country’s status, or lower-middle income’ refer to countries and ‘household income’ refers to the people in the\r\ncountry.\r\n\r\nGuidance: Target to admit students: \r\nWe are looking for examples of focusing activities at people who may not be able to attend university because of serious financial disadvantages. This can include long term objectives and measurements that support them where discrimination at the point of admission is not permissible. For example pipeline programs would fit under this definition.\r\n\r\nGuidance: Bottom financial quintile:\r\nHere we are exploring specific targeting of individuals because of poverty. The bottom financial quintile refers to people in the lowest 20% by income. However the actual target group could be tighter (for example the lowest 10%) – the important thing is that there is a target associated with poverty. In some situations this could be based on geographic based measurements – for example targeting people from the poorest neighborhoods. This could also include targets that include refugee students or displaced students who also experience poverty.', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(4, 1, '1.3.2', 'initiatives', 'Bottom financial quintile student success', 'Does your university as a body have graduation/completion targets for students who fall into the bottom 20% of household income group?', 'Year: 2024', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(5, 1, '1.3.3', 'initiatives', 'Low-income student support', 'Does your university as a body provide support (e.g. food, housing, transportation, legal services) for students from low income families?', 'Year: 2024', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(6, 1, '1.3.4', 'initiatives', 'Bottom financial quintile student support', 'Does your university as a body have programmes or initiatives to assist students who fall into the bottom 20% of household income group?', 'Year: 2024', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(7, 1, '1.3.5', 'initiatives', 'Low or lower-middle income countries student support', 'Does your university as a body have schemes to support poor students from low or lower-middle income countries?', 'Year: 2024', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(8, 1, '1.4.1', 'initiatives', 'Local start-up assistance', 'Does your university as a body provide assistance supporting the start-up of sustainable businesses?', 'Year: 2024', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(9, 1, '1.4.2', 'initiatives', 'Local start-up financial assistance', 'Does your university as a body provide financial assistance for sustainable local start-ups?', 'Year: 2024', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(10, 1, '1.4.3', 'initiatives', 'Programmes for services access', 'Does your university as a body organise programmes to improve access to basic services?', 'Year: 2024', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(11, 1, '1.4.4', 'initiatives', 'Policy addressing poverty', 'Does your university as a body participate in policy making to end poverty?', 'Year: 2024', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(12, 2, '2.2.1', 'initiatives', 'Campus food waste tracking', 'Does your university measure food waste generated on campus?', 'Year: 2024', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(13, 2, '2.2.2', 'numeric', 'Total food waste', NULL, 'Year: 2024\r\nUnit: metric tons (mt).', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(14, 2, '2.2.2', 'numeric', 'Campus population', NULL, 'Year: 2024\r\nFTE students + FTE employees.', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(15, 2, '2.3.1', 'initiatives', 'Student food insecurity and hunger', 'Does your university have a programme addressing student hunger?', 'Year: 2024', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(16, 2, '2.3.2', 'initiatives', 'Students hunger interventions', 'Does your university provide interventions to alleviate student hunger?', 'Year: 2024', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(17, 2, '2.3.3', 'initiatives', 'Sustainable food choices on campus', 'Does your university provide sustainable food choices on campus?', 'Year: 2024', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(18, 2, '2.3.4', 'initiatives', 'Healthy and affordable food choices', 'Does your university provide healthy and affordable food choices?', 'Year: 2024', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16'),
(19, 2, '2.3.5', 'initiatives', 'Staff hunger interventions', 'Does your university provide hunger interventions for staff?', 'Year: 2024', 1, '2026-01-19 04:59:16', '2026-01-19 04:59:16');

-- --------------------------------------------------------

--
-- Table structure for table `wp_spectrum_review`
--

CREATE TABLE `wp_spectrum_review` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `evidence_id` bigint(20) UNSIGNED NOT NULL,
  `reviewer_id` bigint(20) UNSIGNED NOT NULL,
  `decision` enum('APPROVED','NEED_REVISION','REJECTED') NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_spectrum_reviewer_scope`
--

CREATE TABLE `wp_spectrum_reviewer_scope` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reviewer_id` bigint(20) UNSIGNED NOT NULL,
  `sdg_number` tinyint(3) UNSIGNED DEFAULT NULL,
  `metric_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit_code` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_spectrum_sdg`
--

CREATE TABLE `wp_spectrum_sdg` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `sdg_number` tinyint(3) UNSIGNED NOT NULL,
  `sdg_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_spectrum_sdg`
--

INSERT INTO `wp_spectrum_sdg` (`id`, `sdg_number`, `sdg_title`) VALUES
(1, 1, 'No Poverty'),
(2, 2, 'Zero Hunger'),
(3, 3, 'Good Health and Well-being'),
(4, 4, 'Quality Education'),
(5, 5, 'Gender Equality'),
(6, 6, 'Clean Water and Sanitation'),
(7, 7, 'Affordable and Clean Energy'),
(8, 8, 'Decent Work and Economic Growth'),
(9, 9, 'Industry, Innovation and Infrastructure'),
(10, 10, 'Reduced Inequalities'),
(11, 11, 'Sustainable Cities and Communities'),
(12, 12, 'Responsible Consumption and Production'),
(13, 13, 'Climate Action'),
(14, 14, 'Life Below Water'),
(15, 15, 'Life on Land'),
(16, 16, 'Peace, Justice and Strong Institutions'),
(17, 17, 'Partnerships for the Goals');

-- --------------------------------------------------------

--
-- Table structure for table `wp_spectrum_year_metric`
--

CREATE TABLE `wp_spectrum_year_metric` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `year` int(11) NOT NULL,
  `metric_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `weight` decimal(5,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_spectrum_year_metric`
--

INSERT INTO `wp_spectrum_year_metric` (`id`, `year`, `metric_id`, `is_active`, `weight`, `created_at`, `updated_at`) VALUES
(1, 2024, 1, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(2, 2024, 2, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(3, 2024, 3, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(4, 2024, 4, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(5, 2024, 5, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(6, 2024, 6, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(7, 2024, 7, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(8, 2024, 8, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(9, 2024, 9, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(10, 2024, 10, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(11, 2024, 11, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(12, 2024, 12, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(13, 2024, 13, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(14, 2024, 14, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(15, 2024, 15, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(16, 2024, 16, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(17, 2024, 17, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(18, 2024, 18, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04'),
(19, 2024, 19, 1, NULL, '2026-01-19 05:00:04', '2026-01-19 05:00:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_spectrum_attachment`
--
ALTER TABLE `wp_spectrum_attachment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_att_evidence` (`evidence_id`);

--
-- Indexes for table `wp_spectrum_evidence`
--
ALTER TABLE `wp_spectrum_evidence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_evidence_submitter` (`submitter_id`),
  ADD KEY `idx_evidence_year_status` (`year`,`status`),
  ADD KEY `idx_evidence_unit` (`unit_code`),
  ADD KEY `idx_evidence_status` (`status`),
  ADD KEY `idx_evidence_metric_category` (`metric_category`);

--
-- Indexes for table `wp_spectrum_evidence_log`
--
ALTER TABLE `wp_spectrum_evidence_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_log_evidence` (`evidence_id`),
  ADD KEY `idx_log_actor` (`actor_id`),
  ADD KEY `evidence_id` (`evidence_id`),
  ADD KEY `actor_id` (`actor_id`);

--
-- Indexes for table `wp_spectrum_evidence_metric`
--
ALTER TABLE `wp_spectrum_evidence_metric`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_evidence_metric` (`evidence_id`,`metric_id`),
  ADD KEY `idx_evmetric_evidence` (`evidence_id`),
  ADD KEY `idx_evmetric_metric` (`metric_id`);

--
-- Indexes for table `wp_spectrum_function_metric_assignment`
--
ALTER TABLE `wp_spectrum_function_metric_assignment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_unit_metric_year` (`unit_code`,`metric_id`,`year`),
  ADD KEY `idx_fma_unit_year` (`unit_code`,`year`),
  ADD KEY `idx_fma_category` (`category`),
  ADD KEY `idx_fma_metric` (`metric_id`);

--
-- Indexes for table `wp_spectrum_metric`
--
ALTER TABLE `wp_spectrum_metric`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_metric_sdg` (`sdg_number`),
  ADD KEY `idx_metric_code` (`metric_code`),
  ADD KEY `idx_metric_type` (`metric_type`);

--
-- Indexes for table `wp_spectrum_review`
--
ALTER TABLE `wp_spectrum_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_review_evidence` (`evidence_id`),
  ADD KEY `idx_review_reviewer` (`reviewer_id`);

--
-- Indexes for table `wp_spectrum_reviewer_scope`
--
ALTER TABLE `wp_spectrum_reviewer_scope`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_scope_reviewer` (`reviewer_id`),
  ADD KEY `idx_scope_sdg` (`sdg_number`),
  ADD KEY `idx_scope_metric` (`metric_id`),
  ADD KEY `idx_scope_unit` (`unit_code`);

--
-- Indexes for table `wp_spectrum_sdg`
--
ALTER TABLE `wp_spectrum_sdg`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sdg_number` (`sdg_number`);

--
-- Indexes for table `wp_spectrum_year_metric`
--
ALTER TABLE `wp_spectrum_year_metric`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_year_metric` (`year`,`metric_id`),
  ADD KEY `idx_year_active` (`year`,`is_active`),
  ADD KEY `fk_year_metric_metric` (`metric_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_spectrum_attachment`
--
ALTER TABLE `wp_spectrum_attachment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_spectrum_evidence`
--
ALTER TABLE `wp_spectrum_evidence`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `wp_spectrum_evidence_log`
--
ALTER TABLE `wp_spectrum_evidence_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `wp_spectrum_evidence_metric`
--
ALTER TABLE `wp_spectrum_evidence_metric`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `wp_spectrum_function_metric_assignment`
--
ALTER TABLE `wp_spectrum_function_metric_assignment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wp_spectrum_metric`
--
ALTER TABLE `wp_spectrum_metric`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `wp_spectrum_review`
--
ALTER TABLE `wp_spectrum_review`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_spectrum_reviewer_scope`
--
ALTER TABLE `wp_spectrum_reviewer_scope`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_spectrum_year_metric`
--
ALTER TABLE `wp_spectrum_year_metric`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wp_spectrum_attachment`
--
ALTER TABLE `wp_spectrum_attachment`
  ADD CONSTRAINT `fk_att_evidence` FOREIGN KEY (`evidence_id`) REFERENCES `wp_spectrum_evidence` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wp_spectrum_evidence_metric`
--
ALTER TABLE `wp_spectrum_evidence_metric`
  ADD CONSTRAINT `fk_evmetric_evidence` FOREIGN KEY (`evidence_id`) REFERENCES `wp_spectrum_evidence` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_evmetric_metric` FOREIGN KEY (`metric_id`) REFERENCES `wp_spectrum_metric` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wp_spectrum_review`
--
ALTER TABLE `wp_spectrum_review`
  ADD CONSTRAINT `fk_review_evidence` FOREIGN KEY (`evidence_id`) REFERENCES `wp_spectrum_evidence` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wp_spectrum_year_metric`
--
ALTER TABLE `wp_spectrum_year_metric`
  ADD CONSTRAINT `fk_year_metric_metric` FOREIGN KEY (`metric_id`) REFERENCES `wp_spectrum_metric` (`id`) ON DELETE CASCADE;

-- --------------------------------------------------------
-- Add-on schema updates (Form Evidence V2)
-- --------------------------------------------------------
ALTER TABLE `wp_spectrum_metric`
  ADD COLUMN `metric_desc` TEXT NULL AFTER `metric_question`;

ALTER TABLE `wp_spectrum_evidence`
  ADD COLUMN `numeric_value` DECIMAL(20,4) NULL AFTER `summary`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
