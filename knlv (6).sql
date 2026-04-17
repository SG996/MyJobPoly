-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 12, 2026 at 06:53 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `knlv`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `job_id` bigint UNSIGNED NOT NULL,
  `cv_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_letter` text COLLATE utf8mb4_unicode_ci,
  `ai_summary` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `user_id`, `job_id`, `cv_path`, `cover_letter`, `ai_summary`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 32, 'cvs/R1h0yqsXfsaCtdixrmFCK1WzNVhdBiq401clEk9q.pdf', 'ewqewq', NULL, 'pending', '2026-04-03 00:09:10', '2026-04-03 00:09:10'),
(2, 4, 31, 'cvs/vwtZvAT9coXpqXXNDIe9IH5SMyhu3pQ8qeTqIF9S.pdf', 'jhgjgkjkgkjkgjh', NULL, 'rejected', '2026-04-03 00:27:44', '2026-04-09 11:45:27'),
(3, 4, 1, 'cvs/Ln0O3vIYYZVEO5jhQz4TcqzqX3lj78TtXfBXq8wc.pdf', NULL, NULL, 'rejected', '2026-04-03 00:40:33', '2026-04-09 11:45:25'),
(4, 4, 8, 'cvs/bDbDh9YzsTOyuAeZo6Pp4ulgNCaEhTPoYmwh9rbh.pdf', NULL, NULL, 'pending', '2026-04-03 00:45:57', '2026-04-09 11:45:22'),
(5, 7, 32, 'cvs/THFuyFLylBTelY5M5nePo79JdXhDTMoLF5fWDaWy.pdf', NULL, NULL, 'reviewed', '2026-04-09 10:49:33', '2026-04-09 11:45:13'),
(6, 1, 31, 'cvs/wTjostuj51xPG27c7EXl0lCaMZwDqNHMbRLwgCYX.pdf', 'ggez', NULL, 'accepted', '2026-04-09 11:35:35', '2026-04-09 11:45:17'),
(7, 4, 2, 'cvs/2CgI2MsFX1aZBCKu9YuvQ2pYa5v3LQbwfyAUFgtl.pdf', 'kkodwwda', NULL, 'reviewed', '2026-04-09 22:50:09', '2026-04-09 22:50:52'),
(8, 4, 33, 'cvs/TblPJysygoktfr02Vpow1eG3kugEulxcd6opSEcv.pdf', NULL, NULL, 'pending', '2026-04-11 12:19:49', '2026-04-11 12:19:49'),
(9, 29, 33, 'cvs/euqAyn2usXGYEXBdbszwJCsSFVSqRk2jFsg03mMM.pdf', NULL, NULL, 'pending', '2026-04-11 13:37:04', '2026-04-11 13:37:04'),
(10, 29, 34, 'cvs/C7iI16ZAia8UfhWZLmAdjS6XRQJy6ukOfbLi0vxE.pdf', 'ggez', NULL, 'pending', '2026-04-12 01:48:39', '2026-04-12 01:48:39'),
(11, 29, 32, 'cvs/IcknjfbxSSvWAvfNwRWMfLVXnrk1Ry4Yq7OvxHKT.pdf', NULL, NULL, 'pending', '2026-04-12 02:16:31', '2026-04-12 02:16:31'),
(12, 29, 6, 'cvs/6VTYKETcRnRLwOHWwxQqCXd25Q1xS9UWPLzIUylH.pdf', NULL, NULL, 'pending', '2026-04-12 02:35:41', '2026-04-12 02:35:41'),
(13, 35, 33, 'cvs/Zxp3EoRelJ4F1pAlUxAVKEh5Lgs1Cf1AhrP1ltIG.pdf', NULL, NULL, 'pending', '2026-04-12 02:36:55', '2026-04-12 02:37:50'),
(14, 29, 35, 'cvs/v9LNHklBaGqknO5O20Pqm9Ibds9cJ2K9RFRbDSIV.pdf', NULL, NULL, 'pending', '2026-04-12 02:46:06', '2026-04-12 02:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'IT Phần mềm', 'it-phan-mem', '2026-03-30 05:29:08', '2026-03-30 05:29:08'),
(2, 'Marketing', 'marketing', '2026-03-30 05:29:08', '2026-03-30 05:29:08'),
(3, 'Kinh doanh / Bán hàng', 'kinh-doanh-ban-hang', '2026-03-30 05:29:08', '2026-03-30 05:29:08'),
(4, 'Kế toán', 'ke-toan', '2026-03-30 05:29:08', '2026-03-30 05:29:08'),
(5, 'Thiết kế đồ họa', 'thiet-ke-do-hoa', '2026-03-30 05:29:08', '2026-03-30 05:29:08');

-- --------------------------------------------------------

--
-- Table structure for table `category_post`
--

CREATE TABLE `category_post` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hotline` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `address`, `tax_code`, `email`, `hotline`, `logo`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Công ty Pfannerstill-Von', '920 Trinity Place\nEast Loyal, AK 12176', '0393146488', 'langosh.alden@conn.com', '360-472-9042', 'https://via.placeholder.com/100', 'Praesentium illum quia sunt architecto eaque. Iusto ut qui non pariatur laborum est explicabo magnam. Illo suscipit neque reiciendis adipisci sequi veniam culpa.\n\nSit ut distinctio voluptatem. Consectetur maiores qui consectetur.', '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(2, 'Công ty Crooks and Sons', '153 Bartholome Expressway Apt. 021\nNorth Zeldaton, NE 71015', '8312060324', 'dortha83@hills.biz', '(480) 785-6959', 'https://via.placeholder.com/100', 'Ut voluptates atque nisi dicta est dolorem facilis. Voluptatibus eligendi nesciunt dolores voluptas quia nihil pariatur ad. Distinctio exercitationem quos vitae ea aut doloremque.\n\nEligendi et qui unde adipisci nemo quae. Est eum ad nulla iste ullam. Vel blanditiis expedita natus praesentium cumque debitis tenetur sit.', '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(3, 'Công ty Medhurst LLC', '2190 Mertz CoveWest Quinnbury, VT 64188-6639', '7520509310', 'lebsack.estevan@balistreri.com', '+1-919-875-6725', 'companies/UKlxQFFEiOzZX6uxXEDZT0czT23cHx6oJddR7mtX.jpg', 'Possimus atque eveniet eaque velit. Qui sunt inventore animi suscipit. Reprehenderit possimus quia magni et reiciendis iusto ad pariatur.\r\n\r\nDeserunt et rem harum molestias eaque. Id voluptatem omnis tempora qui dignissimos nobis inventore accusamus. A adipisci sunt officiis labore facere et facilis.', '2026-03-30 05:29:09', '2026-04-09 11:01:32'),
(4, 'Công ty Gutmann, Rutherford and Hansen', '8027 Borer Pines\nNew Garret, HI 44248-9040', '3556898959', 'yundt.nannie@pfannerstill.com', '364.917.0175', 'https://via.placeholder.com/100', 'Velit omnis temporibus nobis delectus. Distinctio amet fugiat blanditiis vel explicabo quia quasi. Vel aspernatur illum enim sit nihil minus. Ipsum et est ut.\n\nLabore eligendi asperiores doloribus id corrupti quod omnis. Et inventore sit earum porro quis omnis. Sint rerum impedit magni quas suscipit neque.', '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(5, 'Công ty Spencer PLC', '990 Langosh Brooks Apt. 369\nLarsonstad, NE 64146-8566', '5134298221', 'zbreitenberg@kuphal.com', '+13165837677', 'https://via.placeholder.com/100', 'Sint aut enim aut magnam. Illum alias cumque neque ducimus velit culpa porro. Reiciendis libero nobis ipsam dolorem et. Qui et voluptas sit ad sequi itaque ut voluptatum.\n\nReprehenderit eaque molestiae suscipit eos. Harum laborum dolores possimus provident molestiae est. Quas eum blanditiis quo quibusdam est delectus. Ut magni recusandae dignissimos quam.', '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(6, 'Công ty Reynolds-Murphy', '2841 Savannah Dam Suite 842Sigurdshire, IA 26124-2644', '0731483490', 'regan.friesen@dooley.com', '+1-959-939-4082', 'companies/14XmQCgjq5DuZcrQvEhzE9zGhLNIvqXbliIZw6OY.jpg', 'Nulla velit eos officiis amet soluta et enim. Quo placeat eum libero distinctio magnam voluptatem non. Id voluptatum sed sequi. Quam recusandae deleniti illum.\r\n\r\nAd nisi reprehenderit provident eveniet reiciendis non. Iusto voluptatem omnis eveniet in aliquam officia. Ea ea ullam corrupti qui mollitia exercitationem.', '2026-03-30 05:29:09', '2026-04-09 10:54:42'),
(7, 'Công ty Kling, Wolff and Welch', '221 Bailey Rue\nRomagueramouth, NC 68163', '8329203703', 'nicholas.hahn@kris.com', '225.629.6418', 'https://via.placeholder.com/100', 'Molestias cum possimus quisquam nemo id dicta nam. Optio sit in cum est ex facere. Fugiat laborum laboriosam in voluptatum sed autem facilis. Veniam neque aliquid qui ratione cumque est.\n\nAutem veniam dolorem optio cupiditate culpa. Repellendus et porro omnis earum magni ut.', '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(8, 'Công ty Jacobs-Rutherford', '4721 Wiegand Gardens Suite 799\nJenkinsmouth, WI 96694-8179', '4305499944', 'ucrooks@donnelly.com', '1-980-440-2305', 'https://via.placeholder.com/100', 'Quis ratione amet eveniet expedita. Eos natus voluptatibus repudiandae natus. Dolorem laborum ut sit tempora et sapiente. Soluta fugit expedita ut quis debitis expedita veritatis.\n\nExcepturi quibusdam unde saepe illum commodi. Vel nemo dolores accusamus cum sed rerum ratione. Labore dolores qui et in et. Numquam id animi ipsum sapiente dolorem.', '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(9, 'Công ty Konopelski PLC', '8480 Kaia Stream\nDemetriuschester, OK 97406-0214', '6578986868', 'lilian.wintheiser@murazik.com', '360.538.1330', 'https://via.placeholder.com/100', 'Eaque quia ex unde quo provident omnis et. Rerum eveniet facilis est corporis ullam. Quidem quasi possimus qui perspiciatis rerum sed numquam. Magni aut cupiditate nihil aliquid.\n\nReiciendis eaque sed distinctio aut et quae. Nostrum delectus cumque harum exercitationem maiores omnis.', '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(10, 'Công ty Dooley, Abernathy and Block', '488 Jennyfer Radial Apt. 686\nWest Gina, WV 71644', '7175356498', 'cordie81@gislason.net', '+16819006503', 'https://via.placeholder.com/100', 'Cumque officiis laudantium qui est quis voluptatum doloribus deserunt. Expedita aliquid alias qui dolores nulla occaecati. Inventore veniam asperiores eligendi. Et accusamus laborum inventore eos magnam quo et.\n\nEos ut suscipit vel inventore. Fugit illum ipsa perspiciatis. Quae at magnam officiis esse. Explicabo quia esse temporibus et ipsam voluptates et.', '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(11, 'TNHH MyJob', '212312312', '1010101010', 'huypros1@gmail.com', '10101010101', 'companies/5IHKFHnHBnJeHXvsd6ZhByCC3oel3AKorA9SDrYl.jpg', 'hh', '2026-03-30 06:57:54', '2026-04-09 10:53:33'),
(14, 'HuyPro', '123123', '1233332', 'hr@huypro.com', '123123', 'logos/UXhRUIju0CVXssHeHBrP73SvI6G1CEKHnp1gkMTR.jpg', '123', '2026-04-11 12:10:56', '2026-04-11 12:23:00'),
(15, 'Test Corp', '', '1234567890', 'testemployer555@gmail.com', '', NULL, NULL, '2026-04-11 13:46:56', '2026-04-11 13:46:56'),
(16, 'Test Company', '', '0123456789', 'employer_test@gmail.com', '', NULL, NULL, '2026-04-11 14:06:47', '2026-04-11 14:06:47'),
(17, 'sub', '', '123123', 'hr@sub.com', '', NULL, NULL, '2026-04-12 01:46:31', '2026-04-12 01:46:31'),
(18, 'sub', '', '12312333', 'hr@lol.com', '', NULL, NULL, '2026-04-12 02:44:50', '2026-04-12 02:44:50');

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
-- Table structure for table `job_postings`
--

CREATE TABLE `job_postings` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `salary` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `experience` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `degree` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `deadline` date NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirements` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `benefits` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `employer_id` bigint UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_postings`
--

INSERT INTO `job_postings` (`id`, `title`, `slug`, `company_id`, `salary`, `location`, `experience`, `degree`, `level`, `quantity`, `deadline`, `description`, `requirements`, `benefits`, `category_id`, `employer_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Order Clerk (Senior)', 'order-clerk-senior-8bUcb', 6, '15 - 25 Triệu', 'Đà Nẵng', '3 năm', NULL, NULL, 1, '2026-05-15', 'Qui ullam omnis amet veritatis amet vitae. Odit voluptas et eveniet necessitatibus. Rem officiis incidunt qui vero officia iure. Et eius et similique.\n\nOptio dignissimos consequuntur incidunt quo laborum. Odit ipsa debitis unde nihil facere laudantium reprehenderit. Aut minima porro veritatis in cumque tempora. Quo voluptatibus qui quas.\n\nDelectus quo quas voluptatem adipisci voluptatibus molestiae. Id repellendus possimus quia itaque.', 'Voluptatem placeat et qui voluptas explicabo eos. Voluptatibus illo eius consequatur quasi consequatur et expedita. Fugit commodi rerum natus. Totam incidunt autem quos eligendi sapiente. Aut et reprehenderit repudiandae rerum sed consectetur.\n\nCumque nisi officiis autem dolore magnam voluptatum. Veritatis dolor nobis corporis et saepe. Aut porro quo qui et est ut rerum. Veritatis consectetur dolorem quis minus et temporibus sit modi.', 'Officiis ut ipsa ad necessitatibus aperiam nisi. Enim quia possimus voluptates et doloremque. Aspernatur praesentium repellendus esse molestiae voluptates molestiae ipsa. Odit sequi est reiciendis voluptatem veritatis.\n\nMolestias aliquam suscipit hic non sit consequatur. Vitae deserunt et voluptas est quae blanditiis aut autem. Temporibus culpa vel sed doloremque qui asperiores rerum. Et pariatur expedita omnis.', 3, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(2, 'Telecommunications Equipment Installer (Remote)', 'telecommunications-equipment-installer-remote-TTkYK', 6, '15 - 25 Triệu', 'TP. Hồ Chí Minh', 'Không yêu cầu', NULL, NULL, 1, '2026-05-21', 'Est qui et iste dolores dolor minus quae ut. Delectus et aliquam excepturi quos qui nemo. Id et sapiente facilis voluptatem nihil beatae a.\n\nAccusamus dicta voluptatem est voluptatibus voluptate est. Enim harum rerum unde quia. Placeat voluptate sunt cumque adipisci perferendis quod. Consectetur ipsum tempore cupiditate sit.\n\nOccaecati eum amet qui temporibus corporis quod minima. Vel ut rerum vel officia quo earum modi similique. Consequuntur nisi unde et autem et delectus fuga mollitia.', 'Itaque deserunt eos sunt cupiditate quis iste eos. Accusantium cum et fugit veniam. Cum odit et ut aut molestiae rem quod. Magni laboriosam modi repellendus qui repellat quia. Nulla harum ut ut ut rerum sed.\n\nSint eum nihil nihil culpa. Praesentium perspiciatis enim reiciendis corporis sint mollitia modi. Beatae placeat nam animi impedit qui eveniet blanditiis esse. Quidem libero molestiae mollitia aliquam in eum recusandae. Magnam placeat voluptatum rerum quia et ducimus quae.', 'Quasi doloremque nostrum eum dignissimos provident dolorum quibusdam. Ut explicabo harum consequatur et. Eaque laudantium autem quas atque inventore. Ex est sit molestias cumque.\n\nCumque fugit nihil a. Et iste iste eius nemo. Quisquam reprehenderit aut aliquid perspiciatis. Et dicta enim laudantium ab aliquid est.', 3, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(3, 'Art Teacher (Junior)', 'art-teacher-junior-HGI4b', 2, '10 - 15 Triệu', 'Đà Nẵng', '1 năm', NULL, NULL, 1, '2026-05-28', 'Atque itaque nobis nostrum quos veritatis quod harum. Natus sit id numquam atque. Cum ipsum eos voluptatem aliquid non laudantium officia voluptas. Qui vero voluptatem deserunt quia sit qui.\n\nNesciunt et corporis dolores voluptatem. Veniam facilis est accusantium nihil. Ad praesentium dolores possimus dolorem explicabo deleniti et.\n\nNumquam pariatur beatae maiores tempore accusamus commodi eos. Molestias enim enim quisquam. Magni ut porro aliquam ipsum mollitia et dolores. Deleniti ducimus enim aut asperiores non vel est consequatur.', 'Maxime provident dolorum ducimus et reprehenderit et repudiandae. Et labore quisquam et quis dolor est exercitationem velit. Dolorem blanditiis nam animi sunt a voluptatem tenetur. Sit assumenda placeat eveniet amet. Architecto adipisci rerum non et.\n\nNihil repellat molestiae minus non facere quos. Nemo quibusdam possimus debitis minus occaecati accusantium. Vel perferendis minus temporibus expedita dolore unde voluptatem. Fugit odio sapiente nihil sit.', 'Deleniti ea sapiente itaque nam eveniet neque totam impedit. Fugiat impedit dolor perspiciatis quo. Nemo aut ullam veritatis.\n\nOmnis itaque sunt repudiandae adipisci explicabo non et vel. Impedit fugiat consequatur non libero. Et similique aperiam ullam rem repudiandae. Ut sint laudantium repellat saepe. Repellat culpa et harum quibusdam nesciunt.', 2, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(4, 'Stonemason (Remote)', 'stonemason-remote-nvu8Y', 1, 'Thỏa thuận', 'Hà Nội', '3 năm', NULL, NULL, 1, '2026-04-24', 'Molestiae suscipit tempora optio ea fugiat consequatur voluptas. Dolores excepturi aut delectus consequatur similique quibusdam perferendis.\n\nRem fugit recusandae alias in at. Incidunt odit enim illo maiores consequuntur sit. Facere illo dolores error harum.\n\nEum ullam ipsum quisquam quia ipsa aperiam. Et fugit iste repudiandae omnis officia quia. Sed qui deserunt dolores sequi.', 'Soluta quod omnis earum. Provident voluptatem cumque cum aut ut. Temporibus et non architecto. Quidem cumque pariatur cupiditate minus reprehenderit voluptas asperiores.\n\nEa veritatis omnis voluptatem maxime nobis aut. Officiis molestiae cum aliquid magni iure quis. Iure tenetur sunt voluptatem.', 'Nulla totam similique fugit. Non illo nam et rerum et et dolor exercitationem. Consequatur velit sunt aspernatur vero dolores quia.\n\nNihil doloribus nemo id fugit est voluptas iure. Voluptatem nihil quasi tempore ratione. Possimus debitis est expedita eos at blanditiis nam. Quia nam debitis soluta explicabo doloremque ut dicta.', 5, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(5, 'Landscape Artist (Remote)', 'landscape-artist-remote-3Rd1z', 4, '15 - 25 Triệu', 'TP. Hồ Chí Minh', 'Không yêu cầu', NULL, NULL, 1, '2026-05-16', 'In cum atque qui dolorum iste veniam atque. Voluptates corrupti repellat quod facilis dolore consequuntur. Amet sit ex facilis sed. Iure perspiciatis eum mollitia quis repellat.\n\nTempora sed ex amet consequuntur exercitationem. Autem inventore voluptas omnis voluptatem nemo sequi quam. Voluptatibus vel sapiente cum molestiae ut et. Ut omnis enim eos aut.\n\nDolorem alias quo magnam quam dolores. Eos sit quibusdam dolorem rerum. Dolorem fugit laborum ut ea et. Numquam blanditiis corporis autem ipsam.', 'Iure et sapiente fugiat ut. Reiciendis totam aspernatur dolor rerum eveniet reiciendis esse quod. Quasi qui corporis corporis adipisci quia incidunt voluptas.\n\nQuaerat quia officiis quis ab mollitia quia. Et aut maiores in facere est voluptatum aut. Veniam non et nisi et.', 'Doloribus voluptas ut est asperiores. Nihil ut sed id rerum non sit odio. Quis error rem porro doloremque dolorum suscipit earum dolor.\n\nMinus hic optio sed perferendis qui. Cupiditate temporibus sunt autem maiores. Commodi sit fugiat tenetur id sunt ex nostrum qui.', 2, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(6, 'Shear Machine Set-Up Operator (Remote)', 'shear-machine-set-up-operator-remote-DMKxk', 9, '10 - 15 Triệu', 'Đà Nẵng', '1 năm', NULL, NULL, 1, '2026-05-24', 'Et quia alias quisquam recusandae in. Quod modi et maiores neque aliquam ut nisi quod. Aut iste porro aut debitis ut.\n\nUt voluptatem quisquam ut sed molestiae labore. Ducimus occaecati consectetur doloribus beatae dolores soluta.\n\nVitae perferendis quia iusto eveniet molestiae cupiditate. Unde qui et praesentium est tenetur accusantium unde. Natus et qui odit. Possimus corporis quia sed harum iure atque reiciendis.', 'Sed delectus illo ut rerum debitis. Quia sit sint et esse veritatis magnam. Quis laborum quos consequatur. Itaque ea adipisci voluptatum facilis provident quia voluptatem.\n\nSunt rerum soluta fuga similique iure. Placeat aperiam vel earum ut quibusdam quia sequi. Ratione minus illo deserunt qui molestiae. Sit error quis et alias.', 'Fuga magnam illum minus expedita eius dolorem et. Vel deleniti voluptatem necessitatibus inventore. Officia quaerat magni illo sapiente molestiae dolorem. Officia consequuntur totam et aut sit.\n\nAd voluptates consequuntur perferendis eveniet enim ut. Quis sed aperiam deserunt iusto et numquam pariatur dolorem. Molestias ea similique ipsum ad nemo alias. Necessitatibus odit magnam laborum dolor vel ea id. Est architecto ea sapiente est dolores officia.', 5, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(7, 'Nonfarm Animal Caretaker (Senior)', 'nonfarm-animal-caretaker-senior-PzJUG', 6, '15 - 25 Triệu', 'Hà Nội', 'Không yêu cầu', NULL, NULL, 1, '2026-04-23', 'Deserunt in pariatur quaerat et sunt recusandae. Voluptatem eius sit officia rerum qui porro facere. Consectetur nesciunt similique eos maxime provident atque. Id nam iusto temporibus. Enim provident quia sed quidem sint doloribus distinctio nihil.\n\nOccaecati atque similique expedita dolorum. Qui qui accusamus sunt sed quae. Libero voluptas occaecati mollitia sequi nam reiciendis laborum.\n\nHic numquam sunt officia et iste et. Dolor distinctio repellendus et doloribus. Dolore id earum qui dignissimos voluptatem.', 'Reprehenderit exercitationem praesentium tempore explicabo eius. Alias quam odio est delectus beatae praesentium. Ea et pariatur optio ut quod animi similique. Itaque nostrum soluta quidem perferendis.\n\nQuos architecto accusamus nesciunt aut qui. Incidunt blanditiis ratione amet quos iusto aperiam. Enim cumque doloremque aut tenetur.', 'Doloribus aliquam fuga voluptas dolores autem minus nam aliquid. Aut qui rerum quae incidunt. Aliquid dolores aut veritatis ut. Natus non nemo aut nihil soluta ut cum.\n\nMolestias unde labore corrupti nobis omnis beatae. Ab mollitia et magni facere. Aut assumenda tenetur voluptatem et et ab. Itaque impedit delectus dignissimos architecto est blanditiis.', 4, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(8, 'Sailor (Remote)', 'sailor-remote-ht14h', 8, 'Thỏa thuận', 'Đà Nẵng', '3 năm', NULL, NULL, 1, '2026-05-14', 'Dicta rerum vel quo. In quo tenetur molestias quaerat a at ipsum alias. Est repellendus accusantium ducimus nulla illum labore voluptas. Sint et eius dolores ipsum.\n\nEt dicta nostrum est. Dolorem explicabo similique ea quo placeat eos modi.\n\nUt sapiente asperiores veniam velit. Mollitia excepturi et eos autem. Nam voluptates maxime iusto sint aut id rerum explicabo.', 'Aut molestiae est laborum omnis quas quo perspiciatis. Esse dicta omnis tempora quia. Voluptas quod repellat alias quaerat odit molestiae voluptas.\n\nIncidunt quaerat non voluptas. Suscipit iusto at et hic alias architecto earum. Voluptas dolorum occaecati molestias exercitationem earum totam ut. In corporis rerum omnis modi nam magni amet.', 'Corrupti quasi odit pariatur. Pariatur nesciunt aut et inventore doloribus. Et et et quas ea non ea pariatur. Ea et deserunt qui totam autem impedit quasi dolorem.\n\nEos totam dignissimos voluptatem recusandae animi nihil. Similique aut qui quidem reiciendis. Quod aspernatur laudantium consequatur non omnis totam ut. Sed omnis quos aliquid corrupti qui non nisi.', 4, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(9, 'Nuclear Monitoring Technician (Remote)', 'nuclear-monitoring-technician-remote-6llgI', 6, '10 - 15 Triệu', 'Hà Nội', '1 năm', NULL, NULL, 1, '2026-05-07', 'Illo error molestiae error velit. Tempora consectetur ipsum repellendus modi dignissimos nihil. Qui eligendi maiores enim fuga. Voluptas nemo illo animi est.\n\nDolorum et et quia eveniet nisi. Et aliquid similique nisi id. Et id eligendi ducimus consectetur occaecati. Ipsam eaque deleniti in ut ipsam sed.\n\nAccusantium et vel doloribus et vero inventore. Sequi id omnis deserunt dolores accusamus alias vitae. Eos rerum dolorum ratione tempora aliquam hic et voluptas. Nulla minus sit unde minus numquam tempore.', 'Aliquid ipsa pariatur vitae dolore omnis. Cupiditate sunt molestiae et sapiente. Et nisi reprehenderit qui eum quia minus dolor.\n\nNon praesentium cumque facere consequatur cum dolorem veniam. In eligendi fugiat velit assumenda tempora fugit illum. Qui explicabo est ut excepturi autem ab. Consequatur totam explicabo qui iusto sunt modi.', 'Voluptatem possimus vitae vero animi error. Sequi cupiditate labore aut consequatur cumque quia et. Soluta laudantium cum quis cum ab ratione in. Officiis et repudiandae delectus pariatur nobis.\n\nEaque maiores tempore dolore laudantium rem. Possimus odit quia repellat eveniet doloribus dicta. Distinctio et dolorum dignissimos rerum in quae nostrum. Ipsa dolorem eos est est consequuntur voluptas.', 3, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(10, 'Pantograph Engraver (Senior)', 'pantograph-engraver-senior-PCv4C', 5, '10 - 15 Triệu', 'TP. Hồ Chí Minh', '1 năm', NULL, NULL, 1, '2026-05-06', 'Doloremque tempore ratione non velit qui. A rem tempora quisquam molestias aut et eveniet. Cum voluptatem dolorem et dolorem. Cumque iste est sit eligendi.\n\nVeniam magnam aperiam sint nobis quia labore. Assumenda vel ut impedit aut alias ipsum laudantium. Necessitatibus praesentium explicabo ex enim laudantium eius illo. Ullam tempora iste impedit dicta quod pariatur laborum quas.\n\nIusto itaque ea voluptatem est dolor sed. Alias et ea harum eveniet. Libero laboriosam at voluptas commodi et. Et commodi odio minus quis sit.', 'Nam molestiae ut officia corrupti voluptatibus ipsum. Cupiditate dignissimos et ut velit nihil sint distinctio. Fugit dolorem nihil cumque. Aut voluptas reprehenderit esse qui aut id recusandae.\n\nIncidunt facilis quas dicta ullam commodi minima. Magni quaerat quaerat rerum aliquam. In deserunt nihil unde facere dolores. Ut voluptates in sunt sunt itaque dolorem consectetur.', 'Suscipit maxime quaerat hic eos porro. Enim eum rerum cumque dolore. Ullam est delectus voluptatem earum fuga quam odio.\n\nQuis reiciendis natus a ut exercitationem quo. Enim dolorem et cum ut. Omnis alias aspernatur voluptatum voluptatem dolorum temporibus. Vitae qui nobis vitae et.', 4, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(11, 'Restaurant Cook (Senior)', 'restaurant-cook-senior-BnjP7', 1, '10 - 15 Triệu', 'Đà Nẵng', 'Không yêu cầu', NULL, NULL, 1, '2026-05-13', 'Ipsam officia inventore quis eius ut aliquid nulla. Repellat et doloremque et et similique ducimus qui. Ut impedit hic quas maxime pariatur deserunt ea culpa.\n\nEx delectus et omnis. Temporibus totam ut fugiat nesciunt eum ut natus. Laborum omnis ut debitis vitae ipsa. Et voluptatem aut placeat atque. Impedit et aut corporis exercitationem.\n\nVoluptas provident deserunt asperiores exercitationem hic quam. Ea aut alias blanditiis aut porro vel. Mollitia adipisci rerum temporibus ea labore nihil omnis. Eligendi maxime tempore dolores in corrupti.', 'Qui rerum vero officia aliquid. Aut rem eum occaecati reprehenderit vero velit. Facere exercitationem tempore rem. Nulla aliquid est ullam sunt ab eum culpa aliquid.\n\nSaepe laudantium eum ipsum eos quae. Ut ut nesciunt quaerat doloribus voluptatem officiis. Sint vitae aliquid ullam veniam quis placeat quod eligendi.', 'Ipsa quod quia sed aut blanditiis qui. Nihil dolorem suscipit qui est. Molestiae nesciunt itaque nulla ut animi harum. Vel qui dolorum voluptatibus dicta itaque sapiente.\n\nEst impedit consectetur dolore illo cum. Aliquid ut minus voluptatibus.', 4, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(12, 'Materials Scientist (Remote)', 'materials-scientist-remote-7r1xq', 7, '10 - 15 Triệu', 'Đà Nẵng', '1 năm', NULL, NULL, 1, '2026-05-12', 'Eveniet harum ratione eaque. Omnis eaque incidunt quae rerum aperiam ipsa quo sunt.\n\nSed maiores officia autem non molestiae id sequi. Nulla amet assumenda facere. Quod qui dolor dolores quia ut.\n\nDolorem distinctio quia aperiam nihil sed. Sint dolores aut vitae exercitationem alias inventore. Numquam optio quasi voluptatem veritatis non aperiam occaecati. Aut odit aut molestias molestias in.', 'Omnis a est et ad aliquid. Praesentium iusto dolores aperiam qui saepe nihil. Nesciunt quaerat quo omnis veniam aut vel voluptatibus magni.\n\nEt ea temporibus qui nesciunt earum enim aut quia. Iusto ea sequi qui ex hic consequatur itaque. Voluptatem ab hic facilis quo quaerat.', 'Minus possimus facere reprehenderit tempora ipsa necessitatibus perferendis est. Molestiae eos aut omnis ipsam. A et quisquam rerum aut. Necessitatibus cum praesentium quis perspiciatis aut.\n\nDolor perspiciatis voluptatem deleniti asperiores cumque nihil. Nihil et ipsum ut aut commodi rerum. Nulla est et quas ipsam molestiae. Neque voluptas omnis id omnis id maiores.', 3, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(13, 'Manufactured Building Installer (Senior)', 'manufactured-building-installer-senior-wpgl3', 9, '15 - 25 Triệu', 'Đà Nẵng', '3 năm', NULL, NULL, 1, '2026-05-10', 'Eaque dolores eius eum nostrum. Voluptatem enim voluptas magni sed at blanditiis. Voluptas architecto quisquam quia et.\n\nDignissimos tenetur magni explicabo praesentium. Sapiente molestiae atque totam enim explicabo. Sunt eum sed esse pariatur nostrum. Voluptas perspiciatis et excepturi dolor asperiores neque perspiciatis quia.\n\nEt rem atque voluptatem magnam. Ut omnis eum qui mollitia. Vero fuga nobis consequatur dolor quia commodi quia voluptatem. Quos reprehenderit distinctio impedit.', 'Minus ea fuga maxime eum eligendi sint consequatur. Itaque aut alias sit sit qui dolores explicabo. Consequuntur ab repudiandae molestiae officia voluptas corporis tempore. Necessitatibus blanditiis aut fugiat officiis.\n\nUt pariatur id nisi eveniet. Non consequatur unde dignissimos mollitia officiis et aliquam. Eligendi mollitia harum dolorum qui qui quas voluptatem. Voluptatem autem aperiam est possimus. Quos et est doloremque iure in.', 'Exercitationem cum dolores nulla sed voluptatem id. Aspernatur in officiis blanditiis aut. Est itaque nesciunt qui rerum facere voluptate.\n\nEum qui voluptatibus nam temporibus. Est dolor reiciendis est qui at incidunt est sapiente. Temporibus consequatur fugit aut. Itaque velit at voluptatem corrupti dolores minima sint.', 2, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(14, 'Clerk (Remote)', 'clerk-remote-cq3GC', 2, 'Thỏa thuận', 'TP. Hồ Chí Minh', 'Không yêu cầu', NULL, NULL, 1, '2026-04-25', 'Vero aliquid laboriosam sit tenetur reprehenderit. Dolorem accusantium qui quae nihil expedita ut. Adipisci facere non quasi sed.\n\nSit repellendus dolores quibusdam perferendis doloribus ut fuga. Eos quasi eos commodi culpa quas. Nisi eligendi et reprehenderit sit velit et. Labore et cumque aliquid consequuntur fugit cumque. Voluptas ipsum minima rerum maxime tempora delectus.\n\nEt inventore perspiciatis ut et. Deserunt aut aut velit enim minima recusandae repellat saepe. Eos accusamus distinctio blanditiis debitis dolore.', 'Ut molestiae reiciendis error asperiores distinctio at. Et a consequatur et repudiandae cupiditate. Culpa laboriosam non aliquid et.\n\nTotam illo quia autem magni eveniet consectetur. Non debitis excepturi eius ducimus enim omnis qui. Aut est eius qui ea consequatur nulla.', 'Esse ut ullam veniam rerum eos repellendus excepturi. Aut ipsam qui sequi soluta id omnis. Quisquam enim provident aperiam error sapiente. Quaerat officia ut incidunt rerum eos.\n\nAspernatur et illum excepturi dolores. Ullam eius minima nihil ut est. Nihil sit nihil officia id praesentium libero qui.', 1, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(15, 'Commercial and Industrial Designer (Remote)', 'commercial-and-industrial-designer-remote-kzjXI', 10, '15 - 25 Triệu', 'TP. Hồ Chí Minh', 'Không yêu cầu', NULL, NULL, 1, '2026-05-03', 'Provident ipsa vel quia recusandae quo rerum assumenda. Rem minus iste quaerat. Et laudantium fugit blanditiis dicta sed facere.\n\nOptio aut sed sit voluptates aut ut. Minima praesentium voluptatem et inventore modi explicabo. Ut accusantium corporis quisquam at sunt voluptatibus consequuntur.\n\nReiciendis ut sequi repudiandae ipsa et atque. Qui est nostrum sint. Est voluptatum ea iure quia perspiciatis. Autem dolores ex quo eum quas quidem dolorum.', 'Quisquam eum ipsam voluptate ut rerum. Magni facere qui culpa qui. Dolores sunt fuga illo ut iste. Quidem est ad assumenda amet autem.\n\nUllam dicta omnis deserunt. Ea est perspiciatis aut odio cupiditate. Eveniet ut sint autem impedit sit. Libero aut nostrum magnam sunt et nihil.', 'Fugit numquam sequi doloribus sequi qui qui in consequatur. Eveniet ipsum accusamus at et. Natus cum optio ullam sunt consequuntur. Esse dolor occaecati rerum labore reprehenderit.\n\nEt ex sed aut porro quo eius. Dolor qui totam magni quis inventore ipsam.', 3, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(16, 'Locomotive Engineer (Remote)', 'locomotive-engineer-remote-DB20Z', 10, '15 - 25 Triệu', 'Đà Nẵng', '1 năm', NULL, NULL, 1, '2026-05-11', 'Quia ratione beatae earum facilis optio et. Maiores quasi voluptatem ullam. Harum id corrupti inventore laudantium.\n\nTenetur sint suscipit amet veniam. Id et consequatur sed deserunt.\n\nPerspiciatis quo omnis cum unde nobis tempora. Aliquam voluptatibus suscipit accusantium non id ut amet velit. Culpa aperiam sed est provident et voluptas in. Atque et qui fuga eum voluptas necessitatibus.', 'Quod quis fugiat natus expedita perferendis et a. Similique at nihil dolores pariatur iusto facere. Enim est quod quis ratione et temporibus.\n\nIllum quia provident maxime vitae. Hic quo quia facere distinctio. Enim sint et ad odio minima temporibus.', 'Tenetur illum sit et molestiae molestiae exercitationem. Dicta veritatis laborum cum adipisci voluptates saepe rerum consectetur. Eos corrupti voluptas est vero. Pariatur omnis consequatur nulla quisquam quo sit in et.\n\nRepellendus velit autem qui vel sit consequatur laudantium atque. Fuga earum soluta fugiat optio placeat dolore. Dignissimos nobis debitis nam dignissimos quasi molestiae qui.', 1, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(17, 'Occupational Therapist Assistant (Remote)', 'occupational-therapist-assistant-remote-H4Rpw', 2, '10 - 15 Triệu', 'Đà Nẵng', '3 năm', NULL, NULL, 1, '2026-04-11', 'Hic et nesciunt id occaecati numquam quam. Est natus illum in quis veritatis qui. Recusandae enim ipsa ullam voluptas ipsa reprehenderit voluptatibus. Veritatis a perferendis omnis atque repellendus.\n\nDignissimos dolores est blanditiis recusandae tempora ex voluptas. Sed aut facilis corporis aspernatur eum. Et exercitationem hic aliquam repellendus aut et. Velit ut id ut illum laborum.\n\nRerum omnis beatae consectetur sit consequatur numquam aut. Consequatur placeat dolorem provident repudiandae aut. Minima accusamus unde laborum ea.', 'Aliquid inventore consectetur mollitia qui. Et quas delectus beatae expedita qui asperiores voluptatem ea. Dolorum molestiae perferendis qui illum ex doloribus placeat. Non ut natus ex ut architecto dolore excepturi.\n\nLibero vel aut molestias earum dolorem. Velit ut velit sequi et neque ut. Cumque sapiente qui recusandae impedit. Et porro aut eos eaque eum.', 'Velit occaecati dolores debitis reprehenderit voluptate tenetur ipsum. Tempore illum saepe iste blanditiis a et esse culpa. Minima illo enim perferendis quibusdam totam ducimus ut. Aut veniam soluta rerum et animi ipsam soluta.\n\nAd eum omnis iure amet ut voluptas possimus. Aut aperiam rerum itaque et dolorem.', 3, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(18, 'Telecommunications Line Installer (Senior)', 'telecommunications-line-installer-senior-2v1cr', 5, '15 - 25 Triệu', 'Đà Nẵng', '1 năm', NULL, NULL, 1, '2026-05-23', 'Dolor et optio laudantium atque aut labore est. Et et accusantium qui quaerat in pariatur. Aut sed voluptas commodi exercitationem ducimus cupiditate sint. Odit doloremque vel sit quia ipsa facilis rerum.\n\nSed est exercitationem nostrum qui et ratione. Voluptatem architecto quo nisi placeat sunt voluptatem.\n\nVoluptas ipsam et quam sit quas voluptatibus pariatur. Et culpa necessitatibus et dolorum voluptas. Corporis eveniet molestias sapiente illo officia et consequatur. Ut doloribus beatae et dolores veritatis. Non distinctio sed natus commodi.', 'Consequatur officiis provident ea delectus. Corrupti labore sed nisi veritatis odit laudantium reprehenderit voluptatem. Nihil eos at hic. Sapiente ad nulla ut. Laboriosam inventore mollitia ullam soluta maiores quia.\n\nSoluta officiis in et qui magni nemo aliquid. Esse quam quam sint numquam in rerum. Maiores placeat culpa aut laudantium quo amet vel.', 'Eum qui et necessitatibus rem magni. Tempore dolorem minima nobis aut quos sit est. Sunt molestiae quia sed voluptas non.\n\nVoluptatem eius est eum ut est officiis voluptatem. Et qui placeat qui officia magni. Excepturi natus non qui cumque.', 1, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(19, 'Court Reporter (Senior)', 'court-reporter-senior-XN27J', 10, '10 - 15 Triệu', 'Hà Nội', 'Không yêu cầu', NULL, NULL, 1, '2026-05-20', 'Occaecati esse ad aliquam nostrum facilis. Officia pariatur est itaque a. Occaecati quae cumque sint fugiat sunt eum qui ut. Aut nobis dolorum quod veniam qui. Culpa mollitia architecto facere et.\n\nQuia nemo suscipit excepturi placeat similique. Nihil reiciendis accusamus fuga et qui. Aliquid aut ut labore voluptatem minus atque repudiandae.\n\nSint sed quaerat magni iste quo dolor sit. Recusandae voluptas corrupti id porro. Distinctio et molestiae minus qui odio.', 'Exercitationem qui soluta omnis tempora. Suscipit ipsa reprehenderit veritatis nam provident. Assumenda architecto quisquam quas ducimus animi nihil. Reprehenderit aut ducimus eum autem qui debitis.\n\nCorrupti quae enim aut deserunt. Aliquam omnis reiciendis et error quam ullam porro nesciunt. Eveniet consequuntur quia et numquam. Omnis vitae rerum quisquam maxime non neque.', 'Enim nihil cum consequatur cupiditate eos magnam. Veritatis iste provident ducimus excepturi in. Eius quidem ipsam veritatis aut expedita quod. Omnis dolorum est dignissimos suscipit ab neque dolorum sunt.\n\nPerspiciatis fuga optio ut quo. Pariatur adipisci ullam maiores autem ratione nam. Quidem doloribus et et voluptate dolores cumque necessitatibus.', 2, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(20, 'Glass Cutting Machine Operator (Senior)', 'glass-cutting-machine-operator-senior-Tfcif', 7, '15 - 25 Triệu', 'Hà Nội', '1 năm', NULL, NULL, 1, '2026-05-16', 'Praesentium non repellat omnis hic est in facilis. Eligendi quis quos itaque debitis assumenda. Odit eos nesciunt beatae vel qui. Libero autem dignissimos voluptas qui sunt nulla molestiae.\n\nEnim enim officiis necessitatibus aut corrupti voluptas autem. Non consequuntur fuga repellendus repellendus quod voluptas corrupti. Et ut eum architecto occaecati tempora in. Aperiam placeat eos est rerum officia est. Voluptatem sunt et porro dolore.\n\nQuisquam optio tempora odit occaecati id. At eum quidem odit quis. Nisi magnam distinctio ad unde et molestias nostrum. Veritatis harum ipsam dolore.', 'Eos eveniet est cum adipisci occaecati. Molestiae distinctio dolorem minima voluptatum dolorem unde aut. Aperiam temporibus dolore sint eligendi aut et et. Itaque optio qui laudantium ut ipsam.\n\nLaboriosam explicabo aut non sapiente molestiae doloremque. Fuga ut cumque tempore. Inventore est vitae fuga expedita ut nam magni vel. Ullam a iste consequatur impedit ut qui maiores.', 'Modi error et sit. Sit exercitationem quas neque modi alias reiciendis. Ut qui et eligendi autem. Nobis nobis unde quia repellendus quas et accusantium ut. Alias adipisci tempora impedit.\n\nNon placeat sed velit sit ducimus commodi. Unde eum aut maiores rem error perferendis. Eius veritatis explicabo ut harum et minus veritatis.', 2, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(21, 'Lifeguard (Junior)', 'lifeguard-junior-I9Ov9', 8, '15 - 25 Triệu', 'Hà Nội', '1 năm', NULL, NULL, 1, '2026-05-05', 'Inventore sapiente officia minima rerum. Sit et id beatae commodi rem magni adipisci. Iusto sed dolorum assumenda possimus. Libero voluptate quia a maxime laboriosam dolores fugit.\n\nEum velit ipsa accusamus consectetur eveniet. Esse consequuntur quia veniam quas quos ea.\n\nImpedit optio culpa pariatur deleniti. Molestiae nisi maxime quae qui tempora molestiae unde. Tenetur occaecati occaecati unde aut. Mollitia voluptatem voluptatem voluptas facilis maiores quae.', 'Optio nesciunt deleniti debitis dolorem unde at. Rerum facilis corporis voluptatem non perferendis quidem iste explicabo. Debitis unde voluptates nesciunt nulla accusamus.\n\nSequi ex impedit dicta quisquam reiciendis voluptatem natus quod. Iste voluptas deserunt repellat molestias et error sit. Saepe sequi laboriosam quis qui.', 'Qui iste quis eos dolore. Unde dolorem dolore perferendis voluptas. Sint officiis laboriosam qui. Placeat qui libero laborum sed id quasi quo.\n\nNihil iusto possimus iure commodi illo distinctio excepturi quibusdam. Dolore unde consequuntur maiores ex aspernatur impedit libero. Quis minus minima fuga cumque commodi. Corrupti ad est perferendis sit provident ipsum culpa.', 3, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(22, 'Tool Sharpener (Junior)', 'tool-sharpener-junior-BJEw6', 9, 'Thỏa thuận', 'Đà Nẵng', '3 năm', NULL, NULL, 1, '2026-04-06', 'Incidunt accusamus quis ut laborum. Occaecati laudantium qui quibusdam. Exercitationem id et aut odio voluptatem et.\n\nTempora sapiente aut et architecto. Molestias temporibus in et unde. Animi aliquam facilis temporibus eum ipsam est consectetur velit. Non facilis et rerum aut quidem natus.\n\nEnim optio quasi id a qui non aliquid. Dolor similique expedita sit commodi. Quidem quia magnam molestias enim exercitationem. Sed aliquam dolorum voluptatem.', 'Amet eum occaecati amet illo. Ut corrupti velit dignissimos ut omnis iste. Molestiae veniam eligendi consectetur accusamus fuga consequatur.\n\nEa est voluptatem eos quis voluptas ut consectetur. Repudiandae reiciendis praesentium deserunt vitae at quis ipsam sapiente. Iste doloribus corrupti sunt ipsam ut. Sit officia culpa sed earum dolores aliquid.', 'Suscipit amet dolorum eos ipsum nobis. Velit est vel vitae voluptatem. Magni unde quia cumque ad.\n\nAut placeat qui non sunt tempore ipsam. Sed rerum iure excepturi mollitia nesciunt tempore et quia. Id vel quia unde suscipit.', 3, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(23, 'Visual Designer (Senior)', 'visual-designer-senior-H9Iym', 8, '10 - 15 Triệu', 'Hà Nội', '1 năm', NULL, NULL, 1, '2026-04-26', 'Eveniet qui dolores nobis aut magnam ducimus. Voluptate omnis sint qui nisi quibusdam est. Dignissimos dolore velit sunt hic quia beatae optio. Nostrum voluptate porro ut facilis quia autem delectus.\n\nEa perspiciatis cum laboriosam voluptates eius. Est adipisci corporis molestias nesciunt rem est in. Sint et ducimus non necessitatibus blanditiis laudantium.\n\nAut totam autem eveniet et doloribus velit. Soluta veniam incidunt aut nulla rerum. Laborum sint velit rerum quod.', 'Omnis enim sed sed eum perspiciatis iusto enim. Eum cumque eum hic quam aut laboriosam. Qui vero ut ad iste dolor consequuntur. Quas earum consequatur corporis dolores impedit.\n\nSimilique non minus omnis deleniti at sed. Nostrum quos sed ut blanditiis provident sed. Quis fugit cupiditate sit maxime magni molestiae dicta.', 'Eos impedit ipsum velit. Ut sint voluptatem et ullam a sequi. Consequatur laborum harum quaerat eveniet repellat corporis pariatur.\n\nVoluptas velit optio blanditiis. Quis sunt animi qui nulla nisi quia. At est impedit enim voluptatem.', 3, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(24, 'Biological Science Teacher (Senior)', 'biological-science-teacher-senior-5S9g6', 4, 'Thỏa thuận', 'TP. Hồ Chí Minh', '3 năm', NULL, NULL, 1, '2026-05-27', 'Consequatur ut rerum eligendi consequatur id magnam nostrum. Culpa eveniet odit earum libero quia quia eius est. Rerum consequatur dolorem labore sit impedit rerum est ut. Consequatur porro atque voluptatibus consequuntur.\n\nQuam omnis ab deserunt minima asperiores unde enim. Repellendus quod sed dolore sunt recusandae similique. Fugiat amet iusto qui mollitia in nemo quas. Suscipit laudantium reiciendis distinctio cum incidunt eaque.\n\nAliquid non dicta minus tempora et ea qui velit. Expedita ut id est quis deserunt et provident. Consequatur excepturi beatae quam nam hic harum.', 'Culpa exercitationem aut vel non ducimus et. Quidem ea nihil voluptatibus eius beatae. Minima eos unde quia provident rem at. Fugiat id est numquam eaque ea nihil.\n\nLaborum et quam magni qui et ratione. Corporis odio tempore nobis eum. In nulla officiis alias sapiente fugit.', 'Quia dolores placeat praesentium asperiores illum dolorem. Rerum modi et distinctio id suscipit voluptatem. Quibusdam sed qui quasi qui sunt repellat.\n\nDucimus facere commodi reiciendis et id nemo. Suscipit placeat ea quam aliquam necessitatibus cumque explicabo. Sit quos deleniti maiores tempore molestiae nihil enim. Libero rem debitis sapiente ducimus.', 3, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(25, 'Astronomer (Senior)', 'astronomer-senior-iszHu', 3, 'Thỏa thuận', 'TP. Hồ Chí Minh', 'Không yêu cầu', NULL, NULL, 1, '2026-04-21', 'Voluptatem mollitia dolor qui. Sit neque ex et voluptatem pariatur non omnis. Deleniti sequi ut numquam ullam sint debitis aut.\n\nDolorem rem nulla commodi beatae. Exercitationem vel reiciendis beatae unde quam ut nihil. Quis similique ad consequatur dolores. Maxime eum laborum laborum placeat velit a iure.\n\nIncidunt dignissimos explicabo laboriosam deleniti voluptas culpa unde. Ipsa sit est incidunt neque sit nesciunt omnis. Enim quas error maxime.', 'Sed et ut sit autem laboriosam assumenda aliquam minima. Libero qui itaque repellat et doloribus voluptatum. Ut aut quo qui possimus.\n\nMagnam et voluptas non reiciendis iusto rerum omnis. Et ipsa aliquid sunt fugiat totam placeat non. Consequuntur praesentium quam voluptas. Quis dignissimos facere est aut iste consequatur commodi ut.', 'Quasi tenetur mollitia est voluptatem. Eum occaecati dolorum magni quibusdam dicta nostrum qui. Asperiores et culpa voluptas debitis tempora ut sint. Aut quis soluta fugiat non quasi illo.\n\nNihil odio in voluptas omnis id labore. Est quisquam velit qui qui inventore. Est eos eum odit quia doloremque. Temporibus corrupti id possimus ut ad hic fugit.', 1, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(26, 'Forging Machine Setter (Senior)', 'forging-machine-setter-senior-bBCFi', 5, '15 - 25 Triệu', 'Đà Nẵng', '1 năm', NULL, NULL, 1, '2026-04-16', 'Officiis est soluta et impedit quidem. Voluptas aliquam dolorem eos distinctio. Alias blanditiis aut explicabo assumenda tempore tempore ut. Asperiores eaque expedita magni ut omnis.\n\nSed inventore porro saepe saepe vel. Id deserunt deleniti aut autem. Accusantium occaecati eveniet enim ea.\n\nSint omnis quis et est et mollitia dolorem provident. Est blanditiis unde tempore tenetur. Non commodi molestiae ab ab.', 'Dolores laudantium enim non non. Et provident explicabo nemo illo.\n\nSaepe aperiam in temporibus blanditiis esse ut. Voluptates pariatur et molestiae et animi. Illum temporibus dolorem eum. Cupiditate quis illo sed omnis voluptatem dolores error.', 'Quia sed sint aut. Enim et blanditiis officia rem veritatis est rerum quia.\n\nEt dolores ipsam voluptas occaecati rerum. Autem quibusdam fuga et sit fugiat numquam impedit. Qui reprehenderit quo nemo a repellat illum. Aut reprehenderit itaque et rerum sapiente rem. Enim sapiente explicabo libero et maxime quis.', 3, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(27, 'Aircraft Launch Specialist (Remote)', 'aircraft-launch-specialist-remote-rRo4a', 2, 'Thỏa thuận', 'Đà Nẵng', '3 năm', NULL, NULL, 1, '2026-04-01', 'Fugit voluptatem vel fuga et natus voluptatibus. Et iusto in aut iste et quam. Corporis similique omnis voluptatem nostrum.\n\nOdio quia alias sed repellendus ea voluptatem. Totam est doloribus eaque facere autem repellendus. Odit fugit aut sed et molestias.\n\nIn mollitia molestias minus quis quia ea et. Ullam qui quia non ut aut animi vitae. Minus a aut aut facilis doloribus ut. Sint ab animi officia a quam perspiciatis numquam necessitatibus.', 'Recusandae magnam odit ullam eos totam dolores officiis. Vel iure cumque quasi officiis. Ad magni sed rerum nemo similique sed pariatur.\n\nVoluptatem qui reprehenderit enim sit aut vel voluptatem. Commodi esse corporis nisi odit perferendis eius eligendi. Quod earum ex aut quia molestiae et natus.', 'Non velit non asperiores ut tempora. Eos consequatur ducimus est officia numquam facere a. Incidunt omnis pariatur dolore soluta maiores et aut. Nihil non beatae consequatur reprehenderit enim est.\n\nNon est in numquam rerum hic voluptate vitae. Tempore enim eos recusandae sed maiores cum. Non autem et reiciendis enim inventore.', 5, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(28, 'MARCOM Director (Senior)', 'marcom-director-senior-sDOol', 5, 'Thỏa thuận', 'Hà Nội', 'Không yêu cầu', NULL, NULL, 1, '2026-05-14', 'In non sit nihil voluptas. Repellat nulla sed unde tempore error dicta officiis. Beatae officiis optio incidunt quia. Et laboriosam aut cupiditate consequatur quam fugit.\n\nQuo molestiae asperiores necessitatibus. Nihil quis id vitae ipsam inventore rem.\n\nSint non nobis ex reiciendis modi ad. Fuga consequatur ex deleniti tenetur. Voluptatem accusamus placeat aut et reiciendis nam sunt. Est eligendi sed quidem non adipisci.', 'Dolorem labore non saepe velit magnam veniam. Aspernatur voluptatem et assumenda totam eius veritatis. Voluptatem sint ab eum minus magni voluptates hic.\n\nItaque earum omnis id illo pariatur rerum et. Voluptas dicta iusto rerum doloremque. Quis quia dicta provident explicabo soluta. Quo harum expedita minima voluptatem odio velit beatae. Velit reprehenderit et ad blanditiis et dolor.', 'Autem dolor ullam velit odit aut quis aliquam. Odit doloribus ut ut optio culpa iusto autem. Nihil illum voluptatem commodi autem. Id magnam aut eos possimus asperiores quam voluptatem.\n\nVoluptas consequatur et animi vitae. Sit sunt repellendus voluptatem repellat ut.', 3, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(29, 'Coaches and Scout (Remote)', 'coaches-and-scout-remote-fFq6A', 8, 'Thỏa thuận', 'Đà Nẵng', '1 năm', NULL, NULL, 1, '2026-04-08', 'Totam aut enim minus. Nostrum sunt et eum sequi. Dolor ut perspiciatis et non beatae non. Beatae doloribus explicabo sed aperiam consectetur quia sit.\n\nPariatur qui impedit soluta. Enim optio qui quo nam. Et nihil aperiam rerum. Dolorem enim beatae non aspernatur.\n\nPossimus vero in ipsum qui similique perferendis cum. Id et hic dolor voluptatum in accusamus. Pariatur culpa enim saepe unde cupiditate nesciunt.', 'Ex est maxime ut dicta et aut et. Blanditiis quaerat eum necessitatibus qui dolorem cumque. Nulla rem asperiores ut saepe similique hic quaerat. Quae quis deleniti expedita dolores ex neque sed. Voluptatem repellendus architecto recusandae ut voluptas iste.\n\nPerspiciatis assumenda aliquid et omnis velit. Veritatis ipsum ut quia vel. Commodi dolorum et aperiam dolorem soluta rerum similique voluptate.', 'Est eos necessitatibus delectus non aperiam deleniti deleniti. Repudiandae eum suscipit corrupti. Assumenda quia qui ex qui atque voluptatem. Tempore voluptas excepturi ea sunt.\n\nOmnis officia delectus illum soluta minima. Fugit non iusto quos explicabo molestiae numquam dicta quia. Et est ut velit libero.', 4, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(30, 'Textile Worker (Senior)', 'textile-worker-senior-wMc9D', 1, '15 - 25 Triệu', 'Đà Nẵng', 'Không yêu cầu', NULL, NULL, 1, '2026-05-09', 'Blanditiis in non accusamus natus consequatur explicabo beatae nobis. Consequatur error adipisci neque dolorem eos quam ipsum. Et dolorem quae mollitia.\n\nVeritatis consequatur et illo veniam vel. Sint vitae et accusantium porro neque omnis. Quo sed ea iusto repudiandae deserunt nam. Quasi sit in quia.\n\nIllo dolor quis consequatur nihil. Eos molestias quo dolores exercitationem.', 'Dolores nesciunt est ipsa sunt ratione dicta. Qui deserunt suscipit sit. Enim provident odit corporis id. Necessitatibus quis suscipit ut qui veniam.\n\nIpsa optio sapiente non. Similique maiores unde adipisci consequatur reiciendis. Qui quia qui sequi voluptatem occaecati ut suscipit. Possimus eligendi tempora velit maxime sequi.', 'Explicabo in porro asperiores ipsam quae facere. Sint qui ullam cupiditate ad quia. Et provident enim repellat earum.\n\nConsequatur est facere officiis dolore. Consectetur nulla sed molestiae est occaecati dolorem quisquam. Id facilis magnam ad non laborum qui occaecati ut.', 4, 1, 1, '2026-03-30 05:29:09', '2026-03-30 05:29:09'),
(31, 'Intern Backend Developer', '123123', 11, '2.000.000 - 5.000.000/Tháng', 'TP. Hồ Chí Minh', '5', NULL, NULL, 1, '2004-05-02', '🚀 Mô tả công việc\r\nTham gia phát triển và bảo trì hệ thống backend cho các sản phẩm web (E-commerce, CMS, API service).\r\nXây dựng RESTful API phục vụ frontend (Web / Mobile).\r\nLàm việc với database (MySQL / PostgreSQL / MongoDB).\r\nTối ưu hiệu năng, xử lý lỗi và đảm bảo bảo mật cho hệ thống.\r\nPhối hợp với team Frontend, UI/UX để phát triển tính năng.\r\nViết tài liệu API (Swagger / Postman).', 'Sinh viên năm 3/4 ngành CNTT hoặc liên quan.\r\nCó kiến thức cơ bản về:\r\nBackend: PHP (Laravel) / Node.js (Express) / Java (Spring Boot)\r\nDatabase: MySQL hoặc PostgreSQL\r\nRESTful API\r\nHiểu cơ bản về:\r\nHTTP, JSON, MVC\r\nAuthentication (JWT, Session)\r\nBiết Git là một lợi thế.\r\nCó project cá nhân (E-commerce, CRUD app, API...) là điểm cộng lớn.\r\n⭐ Ưu tiên (Nice to have)\r\nCó kinh nghiệm làm việc với:\r\nDocker\r\nRedis / Caching\r\nCI/CD (GitHub Actions, GitLab CI)\r\nHiểu về:\r\nMicroservices\r\nClean Architecture', '🎁 Quyền lợi\r\nHỗ trợ thực tập: 2 – 5 triệu/tháng (tuỳ năng lực)\r\nĐược mentor 1-1 bởi Senior Developer\r\nCơ hội trở thành nhân viên chính thức\r\nMôi trường trẻ, năng động, được tham gia các dự án thực tế\r\nFlexible working time\r\n📩 Cách ứng tuyển\r\nGửi CV + Portfolio (GitHub, project) về email:\r\nhr@myjob.vn', 1, 1, 1, '2026-03-30 06:50:43', '2026-04-09 11:30:38'),
(32, 'Intern Frontend Developer', '213213', 11, '22222222', 'TPHCM', '5 nawm', NULL, NULL, 1, '2030-05-05', 'gg', '123123', '123213', 2, 1, 1, '2026-03-30 06:52:04', '2026-04-09 11:23:48'),
(33, 'Intern Backend Developer', 'intern-backend-developer-1775934791', 14, '2-5 triệu', 'TPHCM', 'Không yêu cầu', NULL, NULL, 1, '2026-05-30', 'huy', 'huy', 'huy', 1, 28, 1, '2026-04-11 12:13:11', '2026-04-11 12:13:11'),
(34, 'Backend ez', 'backend-ez-1775983654', 17, '20-30 triệu', 'TP.HCM', 'Dưới 1 năm', NULL, NULL, 1, '2026-05-05', 'ưeqweqw', '123123', '321312', 1, 34, 1, '2026-04-12 01:47:34', '2026-04-12 01:47:34'),
(35, 'ngụ đat', 'ngu-dat-1775987125', 18, '123123', '123123', 'Không yêu cầu', NULL, NULL, 1, '2026-05-05', '123', '123', '123', 1, 36, 1, '2026-04-12 02:45:25', '2026-04-12 02:45:25');

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
(4, '2026_02_30_121627_create_companies_table', 1),
(5, '2026_03_30_121347_create_categories_table', 1),
(6, '2026_03_30_121353_create_jobs_table', 1),
(7, '2026_03_30_121403_create_posts_table', 1),
(8, '2026_03_30_121418_create_category_post_table', 1),
(10, '2026_04_03_061443_create_applications_table', 2),
(11, '2026_04_11_182745_add_company_id_to_users_table', 3),
(12, '2026_04_11_193235_add_is_published_to_posts_table', 4),
(13, '2026_04_11_202204_create_mini_tasks_table', 5),
(14, '2026_04_11_202205_add_student_and_bank_to_users_table', 5),
(15, '2026_04_11_202205_create_user_verifications_table', 5),
(16, '2026_04_11_202206_create_mini_task_applications_table', 6),
(17, '2026_04_11_212626_change_requirements_to_text_in_mini_tasks', 7),
(18, '2026_04_11_213354_add_cv_file_to_mini_task_applications', 8),
(19, '2026_04_11_215223_add_bank_account_name_to_users', 9),
(20, '2026_04_11_220105_add_avatar_to_users', 10),
(21, '2026_04_11_222814_add_profile_fields_to_users_table', 11),
(22, '2026_04_12_090652_add_ai_summary_to_applications_table', 12),
(23, '2026_04_12_090810_add_ai_summary_to_mini_task_applications_table', 12),
(24, '2026_04_12_100304_add_is_approved_to_users_table', 13),
(25, '2026_04_12_183823_add_details_to_job_postings_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `mini_tasks`
--

CREATE TABLE `mini_tasks` (
  `id` bigint UNSIGNED NOT NULL,
  `employer_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirements` text COLLATE utf8mb4_unicode_ci,
  `type` enum('freelance','internship') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'freelance',
  `budget_min` bigint UNSIGNED NOT NULL DEFAULT '0',
  `budget_max` bigint UNSIGNED NOT NULL DEFAULT '0',
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Toàn quốc',
  `work_type` enum('online','offline','hybrid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'online',
  `payment_type` enum('per_project','per_hour','per_month') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'per_project',
  `max_workers` int UNSIGNED NOT NULL DEFAULT '1',
  `deadline` datetime NOT NULL,
  `status` enum('open','in_progress','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mini_tasks`
--

INSERT INTO `mini_tasks` (`id`, `employer_id`, `title`, `slug`, `description`, `requirements`, `type`, `budget_min`, `budget_max`, `location`, `work_type`, `payment_type`, `max_workers`, `deadline`, `status`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 32, 'Xay dung Landing Page WordPress', 'xay-dung-landing-page-wordpress', 'Can freelancer WordPress co kinh nghiem Elementor de xay dung landing page toi uu chuyen doi.', NULL, 'freelance', 5000000, 15000000, 'Toàn quốc', 'online', 'per_project', 2, '2026-05-30 00:00:00', 'open', 1, '2026-04-11 14:18:04', '2026-04-11 14:18:04'),
(5, 32, 'XXay dung Landing Page WordPress toi uu chuyen doi', 'xxay-dung-landing-page-wordpress-toi-uu-chuyen-doi', 'ChWe are looking for WordPress freelancers to support building and optimizing landing pages for digital marketing in the US/EU market. The work focuses on fast execution, conversion optimization, and working with AI tools (no complex coding required). You will work directly with the founder and marketing team to quickly deploy new landing pages according to existing briefs.', 'Experience with WordPress (Elementor preferred). Basic understanding of landing pages and conversion (CTA, layout, UX). Able to work according to clear briefs, no need for creativity from scratch. No advanced coding required. Preferred candidates with a portfolio of landing pages previously done.', 'freelance', 12000000, 15000000, 'Toàn quốcTP. Ho Chi Minh', 'online', 'per_project', 12, '2026-05-06 12:00:00', 'open', 1, '2026-04-11 14:29:54', '2026-04-11 14:29:54'),
(6, 28, 'Xây dựng Landing Page WordPress tối ưu chuyển đổi (Elementor + AI tools)', 'xay-dung-landing-page-wordpress-toi-uu-chuyen-doi-elementor-ai-tools', 'Bạn có thể cung cấp dịch vụ này? Thêm vào hồ sơ làm việc.\r\nChúng tôi đang tìm freelancer WordPress để hỗ trợ xây dựng và tối ưu các landing page phục vụ digital marketing cho thị trường US/EU.\r\n\r\nCông việc tập trung vào execution nhanh, tối ưu chuyển đổi và làm việc với các công cụ AI (không yêu cầu code phức tạp).\r\n\r\nCông việc cụ thể:\r\n\r\n- Build và customize landing page trên WordPress (Elementor)\r\n\r\n- Sử dụng AI tools (10Web AI Builder) để tăng tốc sản xuất\r\n\r\n- Chỉnh sửa layout theo brand guideline (font, spacing, UI consistency)\r\n\r\n- Setup form đăng ký (lead form) + email notification\r\n\r\nTối ưu tốc độ website (Core Web Vitals cơ bản)\r\n\r\nHỗ trợ A/B testing (duplicate & chỉnh sửa version landing page)\r\n\r\nFix các issue nhỏ liên quan đến UI/UX và responsive\r\n\r\nYêu cầu:\r\n\r\n- Có kinh nghiệm WordPress (ưu tiên Elementor)\r\n\r\n- Hiểu cơ bản về landing page và conversion (CTA, bố cục, UX)\r\n\r\n- Cẩn thận, attention to detail tốt\r\n\r\n- Có thể làm việc nhanh, phản hồi nhanh theo feedback\r\n\r\n- Có thể đọc hiểu và trao đổi tiếng Anh cơ bản\r\n\r\n- Ưu tiên có kinh nghiệm làm với AI tools (hoặc sẵn sàng học)\r\n\r\nLưu ý:\r\n\r\n- Đây không phải role dev code nặng, mà thiên về build landing page nhanh + tối ưu hiệu quả marketing.', '- Có kinh nghiệm WordPress (ưu tiên Elementor)\r\n\r\n- Hiểu cơ bản về landing page và conversion (CTA, bố cục, UX)\r\n\r\n- Cẩn thận, attention to detail tốt\r\n\r\n- Có thể làm việc nhanh, phản hồi nhanh theo feedback\r\n\r\n- Có thể đọc hiểu và trao đổi tiếng Anh cơ bản\r\n\r\n- Ưu tiên có kinh nghiệm làm với AI tools (hoặc sẵn sàng học)', 'freelance', 12000000, 15000000, 'Toàn quốc', 'online', 'per_project', 1, '2026-06-05 00:00:00', 'completed', 1, '2026-04-11 14:32:09', '2026-04-11 14:55:13');

-- --------------------------------------------------------

--
-- Table structure for table `mini_task_applications`
--

CREATE TABLE `mini_task_applications` (
  `id` bigint UNSIGNED NOT NULL,
  `mini_task_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `cover_letter` text COLLATE utf8mb4_unicode_ci,
  `ai_summary` text COLLATE utf8mb4_unicode_ci,
  `proposed_budget` bigint UNSIGNED DEFAULT NULL,
  `cv_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Path to uploaded CV/portfolio file',
  `status` enum('pending','accepted','rejected','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `progress_percentage` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `progress_notes` text COLLATE utf8mb4_unicode_ci,
  `completed_at` timestamp NULL DEFAULT NULL,
  `payment_amount` bigint UNSIGNED DEFAULT NULL,
  `payment_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_note` text COLLATE utf8mb4_unicode_ci,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mini_task_applications`
--

INSERT INTO `mini_task_applications` (`id`, `mini_task_id`, `user_id`, `cover_letter`, `ai_summary`, `proposed_budget`, `cv_file`, `status`, `progress_percentage`, `progress_notes`, `completed_at`, `payment_amount`, `payment_proof`, `payment_note`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 6, 29, 'ggez', NULL, 5000000, 'mini-task-cvs/v5Z31CtRuhuWwosF1EOAnkMpJYsdBTAzAcNWpC4i.pdf', 'completed', 100, NULL, '2026-04-11 14:55:13', 5000000, 'payment-proofs/xAoCP4vB7yihzykGVzX8zhfYN0p3lIa8LvxH7CyO.jpg', 'ggez', '2026-04-11 14:55:13', '2026-04-11 14:38:49', '2026-04-11 14:55:13'),
(2, 5, 29, 'Tôi là huydep trai nhat the gioi nay va de thuong', NULL, 123123, 'mini-task-cvs/JEN0lKqvtzjQcwEobQ1g4CVax3lkeuLHvNCwLhu2.pdf', 'pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-12 02:47:39', '2026-04-12 02:47:39');

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
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `author_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `excerpt`, `content`, `thumbnail`, `is_published`, `author_id`, `created_at`, `updated_at`) VALUES
(1, '5 Bí quyết viết CV ấn tượng để chinh phục nhà tuyển dụng', '5-bi-quyet-viet-cv-an-tuong-chieu-phuc-nha-tuyen-dung', 'Một CV ấn tượng là chìa khóa mở ra cánh cửa sự nghiệp. Hãy cùng khám phá 5 bí quyết giúp CV của bạn nổi bật trong hàng trăm hồ sơ ứng tuyển.', '<h2>1. Tùy chỉnh CV theo từng vị trí</h2><p>Đừng gửi cùng một mẫu CV cho tất cả các công ty. Hãy đọc kỹ mô tả công việc và điều chỉnh CV để làm nổi bật những kỹ năng phù hợp nhất.</p><h2>2. Sử dụng số liệu cụ thể</h2><p>Thay vì viết \"Tăng doanh thu\", hãy viết \"Tăng doanh thu 35% trong quý 3/2024\". Số liệu cụ thể tạo độ tin cậy và ấn tượng mạnh.</p><h2>3. Thiết kế rõ ràng, chuyên nghiệp</h2><p>Sử dụng font chữ dễ đọc, bố cục gọn gàng. Tránh màu sắc quá nổi bật hoặc hình ảnh quá nhiều.</p><h2>4. Tối ưu từ khóa ATS</h2><p>Nhiều công ty sử dụng phần mềm lọc hồ sơ. Hãy chèn các từ khóa từ JD vào CV để vượt qua vòng lọc tự động.</p><h2>5. Kiểm tra kỹ lỗi chính tả</h2><p>Một lỗi chính tả nhỏ có thể khiến bạn bị loại ngay từ vòng đầu. Hãy nhờ người khác đọc lại CV của bạn ít nhất một lần.</p>', NULL, 1, 1, '2026-04-11 12:38:19', '2026-04-11 12:38:19'),
(2, 'Cách trả lời câu hỏi phỏng vấn \"Điểm yếu của bạn là gì?\"', 'cach-tra-loi-cau-hoi-phong-van-diem-yeu-ban-la-gi', 'Đây là câu hỏi tưởng dễ nhưng lại rất dễ mắc bẫy. Học cách trả lời thông minh để biến điểm yếu thành điểm mạnh trong mắt nhà tuyển dụng.', '<h2>Tại sao nhà tuyển dụng hỏi câu này?</h2><p>Câu hỏi này không phải để làm khó bạn, mà để đánh giá sự tự nhận thức và khả năng cải thiện bản thân của ứng viên.</p><h2>Công thức trả lời hiệu quả</h2><p>Hãy chia sẻ một điểm yếu thật, nhưng đồng thời cho thấy bạn đang nỗ lực khắc phục nó.</p><p><strong>Ví dụ:</strong> \"Tôi từng gặp khó khăn trong việc ủy thác công việc. Nhưng sau khi tham gia khóa học quản lý nhóm, tôi đã học được cách tin tưởng và phân công hiệu quả hơn.\"</p><h2>Những điều cần tránh</h2><ul><li>Giả vờ không có điểm yếu nào</li><li>Nêu điểm yếu quá nghiêm trọng liên quan trực tiếp đến công việc</li><li>Trả lời quá dài dòng hoặc quá ngắn</li></ul>', NULL, 1, 1, '2026-04-11 12:38:19', '2026-04-11 12:38:19'),
(3, 'Xu hướng tuyển dụng hot nhất năm 2026 bạn cần biết', 'xu-huong-tuyen-dung-hot-nhat-nam-2026', 'Thị trường lao động đang thay đổi nhanh chóng. Cùng điểm qua những xu hướng tuyển dụng nổi bật nhất trong năm 2026 để chuẩn bị tốt nhất cho sự nghiệp.', '<h2>1. Tuyển dụng từ xa (Remote Hiring) tiếp tục bùng nổ</h2><p>Các doanh nghiệp ngày càng mở rộng tìm kiếm nhân tài toàn cầu, không giới hạn địa lý. Đây là cơ hội lớn cho nhân lực Việt Nam tiếp cận các vị trí quốc tế.</p><h2>2. Kỹ năng AI trở thành bắt buộc</h2><p>Không chỉ dân tech, ngay cả nhân viên marketing, kế toán cũng cần biết sử dụng các công cụ AI như ChatGPT, Copilot để tăng năng suất.</p><h2>3. Soft skills được đánh giá cao hơn bao giờ hết</h2><p>Tư duy phản biện, giao tiếp hiệu quả và khả năng thích nghi đang được các nhà tuyển dụng xếp hàng đầu.</p><h2>4. Tuyển dụng qua video interview</h2><p>Video phỏng vấn một chiều đang được áp dụng rộng rãi, giúp tiết kiệm thời gian cho cả hai bên.</p>', NULL, 1, 1, '2026-04-11 12:38:19', '2026-04-11 12:38:19'),
(4, 'Làm thế nào để đàm phán mức lương khi nhận offer?', 'lam-the-nao-dam-phan-muc-luong-khi-nhan-offer', 'Đã nhận được offer việc làm nhưng mức lương chưa như mong đợi? Đừng vội từ chối hay chấp nhận ngay — hãy học cách đàm phán để có được mức lương xứng đáng.', '<h2>Khi nào nên đàm phán lương?</h2><p>Thời điểm tốt nhất là sau khi nhận offer chính thức, không phải trong buổi phỏng vấn đầu tiên.</p><h2>Nghiên cứu mức lương thị trường</h2><p>Trước khi đàm phán, hãy tìm hiểu mức lương trung bình của vị trí tương đương tại các trang như LinkedIn Salary, Glassdoor.</p><h2>Cách trình bày yêu cầu lương</h2><p>Thay vì nói \"Tôi muốn lương cao hơn\", hãy nói: \"Dựa trên kinh nghiệm và kỹ năng của tôi, tôi kỳ vọng mức lương từ A đến B triệu.\"</p><h2>Không chỉ đàm phán lương cơ bản</h2><p>Hãy cân nhắc đàm phán thêm các quyền lợi: ngày phép, thưởng, cổ phần, hoặc lộ trình thăng tiến.</p>', NULL, 1, 1, '2026-04-11 12:38:19', '2026-04-11 12:38:19'),
(5, 'Top 10 ngành nghề có nhu cầu tuyển dụng cao nhất tại Việt Nam 2026', 'top-10-nganh-nghe-nhu-cau-tuyen-dung-cao-nhat-viet-nam-2026', 'Bạn đang cân nhắc định hướng nghề nghiệp? Khám phá top 10 ngành nghề đang được săn đón nhiều nhất tại thị trường lao động Việt Nam năm 2026.', '<h2>Danh sách 10 ngành hot nhất 2026</h2><ul><li><strong>Công nghệ thông tin (IT)</strong> — Lập trình viên, DevOps, Data Engineer với mức lương 20-80 triệu.</li><li><strong>Digital Marketing</strong> — SEO, Performance Marketing, Content Creator đang cực kỳ được săn đón.</li><li><strong>Tài chính - Ngân hàng</strong> — Phân tích tài chính, FinTech đang bùng nổ.</li><li><strong>Y tế và Dược phẩm</strong> — Nhu cầu nhân lực y tế ngày càng tăng.</li><li><strong>Logistics và Chuỗi cung ứng</strong> — Thương mại điện tử thúc đẩy nhu cầu lớn.</li><li><strong>Giáo dục và Đào tạo</strong> — Đặc biệt là EdTech và giáo dục trực tuyến.</li><li><strong>Kỹ thuật và Sản xuất</strong> — Các khu công nghiệp tiếp tục mở rộng.</li><li><strong>Thiết kế UI/UX</strong> — Mọi công ty đều cần người giỏi thiết kế trải nghiệm.</li><li><strong>Thương mại điện tử</strong> — Marketplace Manager, vận hành sàn TMĐT.</li><li><strong>Nhân sự (HR)</strong> — Đặc biệt HR Tech và tuyển dụng trực tuyến.</li></ul>', NULL, 1, 1, '2026-04-11 12:38:19', '2026-04-11 12:38:19'),
(6, 'Cẩm nang cho người đi làm lần đầu: Những điều bạn không học ở trường', 'cam-nang-nguoi-di-lam-lan-dau-nhung-dieu-ban-khong-hoc-o-truong', 'Bước chân vào thị trường lao động lần đầu tiên có thể rất choáng ngợp. Đây là những bài học thực tế quý giá mà không trường nào dạy bạn.', '<h2>1. Networking quan trọng hơn bằng cấp</h2><p>80% cơ hội việc làm đến từ mối quan hệ. Hãy bắt đầu xây dựng mạng lưới chuyên nghiệp ngay từ khi còn là sinh viên.</p><h2>2. Đừng ngại hỏi</h2><p>Người mới không cần phải biết tất cả. Hỏi đúng lúc, đúng người sẽ giúp bạn học nhanh hơn rất nhiều.</p><h2>3. Quản lý thời gian là kỹ năng sống còn</h2><p>Deadline thật, áp lực thật. Hãy học cách ưu tiên công việc và tránh để mọi thứ dồn vào phút cuối.</p><h2>4. Chủ động hơn là ngồi chờ</h2><p>Đừng chờ sếp giao việc. Hãy chủ động đề xuất ý tưởng và tìm cách đóng góp nhiều hơn.</p><h2>5. Xây dựng thương hiệu cá nhân</h2><p>LinkedIn không chỉ để tìm việc. Hãy chia sẻ kiến thức, cập nhật thành tích và kết nối với những người trong ngành.</p>', NULL, 1, 1, '2026-04-11 12:38:19', '2026-04-11 12:38:19');

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
('4BewVMZShaDPHAnB1CdLPakuPI43CGLFWVIsnom4', 29, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'eyJfdG9rZW4iOiIwQm96V2YxcDYwV001VktQeGw5WWNEZk5vNU0yaUpFYkI1OFluRVBiIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2tubHYudGVzdFwvZnJlZWxhbmNlIiwicm91dGUiOiJmcmVlbGFuY2UuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6Mjl9', 1775987823),
('m13uDb3wJf5PUaciwQqhVBeU3Qg0RADW6yYPstSt', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJJcXJkNXhnWU5VRThIejdBbmt4UG1VUW4zcU9tT1hiaGl5ODdsTkFiIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2tubHYudGVzdCIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1776015304),
('MipQl1drkgEWf4AL4EtkMy5wWX0z80e3wu52txBW', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'eyJfdG9rZW4iOiJQTDhzc244dUlESlRRSnF4TnpwUktTUWM2YlpuWmpoZmlnZ2xkemlwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2tubHYudGVzdFwvYWRtaW5cL2pvYnMiLCJyb3V0ZSI6ImFkbWluLmpvYnMuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6NH0=', 1775997325),
('o3QazYbKGC0WS9f2YH9wVFIalNf6LUgW0SEbl9zK', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJQOFQxTVNiYlRxWU9PbzFObUNWYTZDMlVEZHlJUlIwMjluWXFkQmtMIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2tubHYudGVzdFwvYWRtaW5cL3VzZXJzP2ZpbHRlcj1wZW5kaW5nIiwicm91dGUiOiJhZG1pbi51c2Vycy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjo0fQ==', 1775996645),
('xjTObG9psyaeSiNeg4JenTJkztz2evGTXg5U4bmE', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiIxaVFpNjhjTldjaHhyS291N1VDNEdmd1AyNGhjT3N0eUNoZ2VNSmtjIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2tubHYudGVzdCIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1775989387),
('xPL2XPmj2y7y6qrq1yelcyMtx7chK4iFrLC2JSXY', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJZTXNiUkRtMVY4U2d5V0w0QUFVQldxdVEwZEJaQ25FbDhCaVpGancwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvS05MVlwvcHVibGljXC9pbmRleC5waHAiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1776019876);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role` tinyint NOT NULL DEFAULT '0' COMMENT '0: user, 1: admin',
  `is_approved` tinyint(1) NOT NULL DEFAULT '1',
  `is_student_verified` tinyint(1) NOT NULL DEFAULT '0',
  `bank_account` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_qr_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` bigint UNSIGNED DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `avatar`, `email`, `title`, `phone`, `gender`, `dob`, `address`, `bio`, `email_verified_at`, `role`, `is_approved`, `is_student_verified`, `bank_account`, `bank_account_name`, `bank_name`, `bank_qr_image`, `company_id`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin MyJobCV', NULL, 'admin@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$W0TVU/1xZYKLIrMujJLg3eLNEv7NQcIBwmQnUUPVrEbLC.GO212ju', NULL, '2026-03-30 05:29:08', '2026-04-12 04:16:25'),
(2, 'Nguyễn Ứng Viên', NULL, 'user@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$Vsa1RqFkxHSUeC9skK4scu5Elaon6rRSM.92tjSt1xVSWNI6pgcJy', NULL, '2026-03-30 05:29:08', '2026-04-12 04:16:25'),
(3, 'Nguyễn Quang Huy', NULL, 'huynguyenvnn2006@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$3hS0rfEiFFsNAo4OOAmed.6jZx1Rmlv5hqkxIViq8Py2BuKlHEMLS', NULL, '2026-03-30 06:10:37', '2026-04-12 04:16:25'),
(4, 'Áo thun basic trắng', NULL, 'huybanthu2025@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$yUlD509vXvGpnBODTVGWw.JrOJmiFfMxlvJOuDcqfBnJbd93ZN.6a', '0REGy5hsKBq3kBpMPluZZwzxWg801cs5fC4k2lJ45JhoEGVC0IujaMF5LNw8', '2026-04-02 22:16:06', '2026-04-12 04:16:25'),
(5, 'Test User', NULL, 'test@example.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$KjYn0ChIypUUdOzbSJyNo.C8Pve.CTaFCXBSJReUuOyjURtH4cwKu', NULL, '2026-04-02 23:05:45', '2026-04-12 04:16:25'),
(6, 'Sub Agent', NULL, 'testsub@example.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$xhcYoEAFEI7EwW6FYg0ldO084s0GjaKE/tA9NbXPpF1Z5B71mgRfC', NULL, '2026-04-02 23:32:09', '2026-04-12 04:16:25'),
(7, 'gay', NULL, 'huybanthu2021@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$jJNB4sUas26hKqUd6bfMYeK1L5PAZm9N7MX4ebQlk7ztHWk/V0gPy', NULL, '2026-04-09 10:49:04', '2026-04-12 04:16:25'),
(8, 'Trần Văn Phúc', NULL, 'tranvanphuc98@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000001', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(9, 'Lê Minh Tuấn', NULL, 'leminhtuan.dev@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000002', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(10, 'Phạm Gia Huy', NULL, 'phamgiahuy2002@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000003', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(11, 'Nguyễn Quốc Bảo', NULL, 'nguyenquocbao.vn@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000004', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(12, 'Đặng Thanh Tùng', NULL, 'dangthanhtung.it@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000005', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(13, 'Hoàng Minh Đức', NULL, 'hoangminhduc.dev@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000006', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(14, 'Bùi Quốc Anh', NULL, 'buiquocanh99@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000007', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(15, 'Võ Thành Nam', NULL, 'vothanhnam.vn@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000008', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(16, 'Trương Hải Đăng', NULL, 'truonghaidang.dev@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000009', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(17, 'Ngô Quang Vinh', NULL, 'ngoquangvinh@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000010', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(18, 'Phan Thành Công', NULL, 'phanthanhcong@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000011', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(19, 'Đỗ Minh Hoàng', NULL, 'dominhanh.dev@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000012', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(20, 'Lý Thanh Bình', NULL, 'lythanhbinh@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000013', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(21, 'Dương Quốc Hưng', NULL, 'duongquochung@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000014', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(22, 'Huỳnh Gia Bảo', NULL, 'huynhgiabao@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000015', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(23, 'Cao Minh Khoa', NULL, 'caominhkhoa@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000016', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(24, 'Tạ Quốc Duy', NULL, 'taquocduy@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000017', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(25, 'Mai Thanh Sơn', NULL, 'maithanhson@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000018', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(26, 'Trịnh Minh Tâm', NULL, 'trinhminhtam@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000019', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(27, 'Nguyễn Thành Đạt', NULL, 'nguyenthanhdat@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$hashsample00000000000000000000000000000000000020', NULL, '2026-04-10 05:00:00', '2026-04-12 04:16:25'),
(28, 'HuyPro', NULL, 'hr@huypro.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 0, NULL, NULL, NULL, NULL, 14, '$2y$12$J6vD0/JoAolf88cAXYNN5.sCJ6jIYUl.p6wTF/aHJ4Auc5vl3wLiS', 'yYLgsFOEiRVtNCA18If8QnkAbhK9RViPJcpUWRKVIDvhu8DcEK8bx9Grafij', '2026-04-11 12:10:56', '2026-04-12 04:16:25'),
(29, 'huydeptrai1', 'avatars/74vw7f6CPBYhNWXNY6deNZFdNPGRub0ToJF8MPI8.png', 'huybanthu2020@gmail.com', 'GG', '0947541167', 'nam', NULL, '123123', 'GG', NULL, 0, 1, 1, '0359286509', 'NGUYỄN ĐÌNH DU HUY', 'MB Bank', 'bank-qr/nwlLXCBnDzTp2R4gq086DFdJa1EvgFvPfqzzE4R9.png', NULL, '$2y$12$QhiB1i4n/YvSqoLZKJV2.OVMvJLJwHleeIqzvu7xHJoulGWxikIty', NULL, '2026-04-11 13:36:24', '2026-04-12 04:16:25'),
(30, 'Test Student', NULL, 'teststudent123@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '0359286509', NULL, 'MB Bank', 'bank-qr/lphJQrWYhOajM2vBsdlcww4zhqKG5jtuLFx9yJOO.png', NULL, '$2y$12$3cxSTuEvZulLRWZLSk5g2ONzK7VGj8slJaj46.ujlnaCeuLhOeZOa', NULL, '2026-04-11 13:45:03', '2026-04-12 04:16:25'),
(31, 'Test Corp', NULL, 'testemployer555@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 0, NULL, NULL, NULL, NULL, 15, '$2y$12$pYxcTQjXVb.9Q4IAkz5b6.j0F3soxJWP7NZD7twudMp7UdsSgRP0S', NULL, '2026-04-11 13:46:57', '2026-04-12 04:16:25'),
(32, 'Test Company', NULL, 'employer_test@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 0, NULL, NULL, NULL, NULL, 16, '$2y$12$YlHwkmJRXeQO4FMY1mBV1e3yG0XLa848nVXEZXblLY8AF4FZg.Dcm', NULL, '2026-04-11 14:06:47', '2026-04-12 04:16:25'),
(33, 'Sub Agent', NULL, 'huybanthu2022@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$iI.j69/4UMejb/D4wOOpzu5dEcSWyvNHDSmp3hlqEwmyswJUWX.ra', NULL, '2026-04-11 14:53:57', '2026-04-12 04:16:25'),
(34, 'sub', NULL, 'hr@sub.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 0, NULL, NULL, NULL, NULL, 17, '$2y$12$nclXAOmrsE/Sadf5dG5grOq8eio.xyKX3gIfPeGogh7GFPdX2JtQC', NULL, '2026-04-12 01:46:31', '2026-04-12 04:16:25'),
(35, 'Gaming', NULL, 'huy@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$7DF77ZDmwe.SQbP5pvidN.4dFEX4l0a2VqugFXu9gv9yEi40ndFnK', NULL, '2026-04-12 02:36:21', '2026-04-12 04:16:25'),
(36, 'sub', NULL, 'hr@lol.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 0, NULL, NULL, NULL, NULL, 18, '$2y$12$aqKqyo.PZHgUuLEzyfgRiepGN.yxH2u7lvCqLc2T55SQir539Lx7.', NULL, '2026-04-12 02:44:50', '2026-04-12 04:16:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_verifications`
--

CREATE TABLE `user_verifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `student_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_note` text COLLATE utf8mb4_unicode_ci,
  `reviewed_by` bigint UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_verifications`
--

INSERT INTO `user_verifications` (`id`, `user_id`, `student_id`, `school_name`, `card_image`, `status`, `admin_note`, `reviewed_by`, `reviewed_at`, `created_at`, `updated_at`) VALUES
(1, 30, 'PS45273', 'FPT Polytechnic', 'verifications/1Wx5nvUUZcMbiU9WBupYOmIsCYaSXC3HzRPmeQb1.png', 'approved', NULL, 4, '2026-04-11 13:51:45', '2026-04-11 13:50:55', '2026-04-11 13:51:45'),
(2, 29, 'PS45273', 'FPT Polytechnic', 'verifications/sUjcGGx1v0oI9GuIMIPmenius06zF4hztO7MQvSA.jpg', 'approved', NULL, 4, '2026-04-11 14:42:35', '2026-04-11 14:41:16', '2026-04-11 14:42:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applications_user_id_foreign` (`user_id`),
  ADD KEY `applications_job_id_foreign` (`job_id`);

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `category_post`
--
ALTER TABLE `category_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_post_category_id_foreign` (`category_id`),
  ADD KEY `category_post_post_id_foreign` (`post_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_tax_code_unique` (`tax_code`),
  ADD UNIQUE KEY `companies_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `job_postings_slug_unique` (`slug`),
  ADD KEY `job_postings_company_id_foreign` (`company_id`),
  ADD KEY `job_postings_category_id_foreign` (`category_id`),
  ADD KEY `job_postings_employer_id_foreign` (`employer_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mini_tasks`
--
ALTER TABLE `mini_tasks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mini_tasks_slug_unique` (`slug`),
  ADD KEY `mini_tasks_employer_id_foreign` (`employer_id`);

--
-- Indexes for table `mini_task_applications`
--
ALTER TABLE `mini_task_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mini_task_applications_mini_task_id_user_id_unique` (`mini_task_id`,`user_id`),
  ADD KEY `mini_task_applications_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_author_id_foreign` (`author_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_company_id_foreign` (`company_id`);

--
-- Indexes for table `user_verifications`
--
ALTER TABLE `user_verifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_verifications_user_id_unique` (`user_id`),
  ADD KEY `user_verifications_reviewed_by_foreign` (`reviewed_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category_post`
--
ALTER TABLE `category_post`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `mini_tasks`
--
ALTER TABLE `mini_tasks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mini_task_applications`
--
ALTER TABLE `mini_task_applications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user_verifications`
--
ALTER TABLE `user_verifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `job_postings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_post`
--
ALTER TABLE `category_post`
  ADD CONSTRAINT `category_post_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_post_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD CONSTRAINT `job_postings_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_postings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_postings_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mini_tasks`
--
ALTER TABLE `mini_tasks`
  ADD CONSTRAINT `mini_tasks_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mini_task_applications`
--
ALTER TABLE `mini_task_applications`
  ADD CONSTRAINT `mini_task_applications_mini_task_id_foreign` FOREIGN KEY (`mini_task_id`) REFERENCES `mini_tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mini_task_applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_verifications`
--
ALTER TABLE `user_verifications`
  ADD CONSTRAINT `user_verifications_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `user_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
