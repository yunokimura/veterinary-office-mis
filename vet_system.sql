-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2026 at 10:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vet_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `addressable_type` enum('pet_owner','admin') NOT NULL,
  `addressable_id` bigint(20) UNSIGNED NOT NULL,
  `block_lot_phase` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `subdivision` varchar(255) DEFAULT NULL,
  `barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `addressable_type`, `addressable_id`, `block_lot_phase`, `street`, `subdivision`, `barangay_id`, `city`, `province`, `postal_code`, `is_primary`, `created_at`, `updated_at`) VALUES
(1, 'pet_owner', 2, 'Blk 21 Lot 48 Ph 1', 'Tel Aviv', 'England', 1, NULL, NULL, NULL, 0, '2026-04-28 19:36:28', '2026-04-28 19:36:28'),
(2, 'pet_owner', 3, 'Blk 21 Lot 5 Ph 4', 'Worchesstor', 'Woodestte', 6, NULL, NULL, NULL, 0, '2026-04-28 20:41:48', '2026-04-28 21:32:10'),
(4, 'pet_owner', 4, 'Blk 21 Lot 21 Ph 1', 'London', 'Avida', 41, 'Dasmariñas City', 'Cavite', NULL, 0, '2026-04-29 03:13:06', '2026-04-29 03:13:06'),
(5, 'pet_owner', 5, 'Blk 21 Lot 48 Ph 1 # 2', 'London', 'Avida', 27, 'Dasmariñas City', 'Cavite', NULL, 0, '2026-06-04 03:16:52', '2026-06-04 03:16:52'),
(6, 'pet_owner', 6, 'Blk 21 Lot 48 Ph 1 # 2', 'London', 'Avida', 27, 'Dasmariñas City', 'Cavite', NULL, 0, '2026-06-04 03:23:07', '2026-06-04 03:23:07'),
(7, 'pet_owner', 7, 'Blk 31 Lot 21 Ph 2 # 5', 'Shibuya', 'Japan', 42, 'Dasmariñas City', 'Cavite', NULL, 0, '2026-06-14 11:09:10', '2026-06-14 11:09:10'),
(8, 'pet_owner', 8, 'Blk 21 Lot 52 Ph 1 # 41', 'Shibuya', 'Japan', 43, 'Dasmariñas City', 'Cavite', NULL, 0, '2026-06-14 11:59:37', '2026-06-14 11:59:37'),
(9, 'admin', 1, 'Blk 12 Lot 05 Ph 1', 'Mabini St.', 'Greenwoods Subdivision', 12, 'Dasmariñas', 'Cavite', '4114', 1, '2026-08-25 18:30:05', '2026-08-25 18:30:05'),
(10, 'admin', 2, 'Blk 08 Lot 19 Ph 2', 'Rizal Ave.', 'Golden City', 25, 'Dasmariñas', 'Cavite', '4114', 1, '2026-08-25 18:30:05', '2026-08-25 18:30:05'),
(11, 'admin', 4, 'Blk 21 Lot 48 Ph 1', 'Luna St.', 'Palapala Homes', 41, 'Dasmariñas', 'Cavite', '4114', 1, '2026-08-25 18:30:05', '2026-08-25 18:30:05'),
(12, 'admin', 6, 'Blk 03 Lot 33 Ph 3', 'Bonifacio St.', 'Salawag Village', 58, 'Dasmariñas', 'Cavite', '4114', 1, '2026-08-25 18:30:05', '2026-08-25 18:30:05'),
(13, 'admin', 8, 'Blk 15 Lot 12 Ph 2', 'Del Pilar St.', 'Orchard Estate', 67, 'Dasmariñas', 'Cavite', '4114', 1, '2026-08-25 18:30:05', '2026-08-25 18:30:05'),
(14, 'pet_owner', 8, 'Blk 21 Lot 52 Ph 1 # 41', 'Shibuya', 'Japan', 43, 'Dasmariñas City', 'Cavite', NULL, 0, '2026-08-26 06:00:58', '2026-08-26 06:00:58'),
(15, 'pet_owner', 9, 'Blk 11 Lot 1 Ph 1 # 12', 'Shibuya', 'Japan', 13, 'Dasmariñas City', 'Cavite', NULL, 0, '2026-09-02 01:27:40', '2026-09-02 01:27:40'),
(16, 'pet_owner', 10, 'Blk 6 Lot 22 Ph 1', 'Fir', 'Woodestate', NULL, NULL, NULL, NULL, 0, '2026-10-14 02:19:49', '2026-10-14 02:19:49'),
(18, 'pet_owner', 12, 'Blk 2 Lot 22 Ph 2', 'Shibuya', 'Mabuhay Homes 2000', 22, 'Dasmariñas City', 'Cavite', NULL, 0, '2026-10-14 04:41:24', '2026-10-14 04:41:24'),
(19, 'pet_owner', 13, 'Blk 48 Lot 21 Ph 4 # 2', 'Shibuya', 'Woodestate', 32, 'Dasmariñas City', 'Cavite', NULL, 0, '2026-10-20 05:52:36', '2026-10-20 05:52:36'),
(20, 'pet_owner', 14, 'Blk 21 Lot 99 Ph 9', 'Diliw', 'Pula', 14, 'Dasmariñas City', 'Cavite', NULL, 0, '2026-10-27 04:45:01', '2026-10-27 04:45:01'),
(21, 'pet_owner', 15, 'Blk 21 Lot 99 Ph 9', 'Diliw', 'Pula', 9, 'Dasmariñas City', 'Cavite', NULL, 0, '2026-10-27 04:52:23', '2026-10-27 04:52:23'),
(22, 'pet_owner', 16, 'Blk 31 Lot 21 Ph 23 # 22', 'Gedli', 'Doon', 8, 'Dasmariñas City', 'Cavite', NULL, 0, '2026-11-01 14:48:58', '2026-11-01 14:48:58'),
(23, 'pet_owner', 17, 'Blk 31 Lot 28 Ph 12 # 2', 'Sunflower', 'Woodestate', 27, 'Dasmariñas City', 'Cavite', NULL, 0, '2026-11-03 04:06:50', '2026-11-03 04:06:50');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `suffix` varchar(20) DEFAULT NULL,
  `role_type` enum('super_admin','city_vet','admin_staff','admin_asst','assistant_vet','livestock_inspector','meat_inspector') NOT NULL,
  `facility_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `role_type`, `facility_id`, `contact_number`, `date_of_birth`, `created_at`, `updated_at`) VALUES
(1, 1, 'Super', NULL, 'Administrator', NULL, 'super_admin', NULL, '09198887701', NULL, '2026-04-28 19:15:30', '2026-04-28 19:15:30'),
(2, 2, 'Andrew Rovie', 'Mangubat', 'Buencamino', NULL, 'city_vet', NULL, '091988877702', NULL, '2026-04-28 19:15:31', '2026-04-28 19:15:31'),
(4, 4, 'Camilo', NULL, 'Polinga', 'Jr.', 'assistant_vet', NULL, '091988877704', NULL, '2026-04-28 19:15:32', '2026-04-28 19:15:32'),
(6, 6, 'Pedro', NULL, 'Martinez', NULL, 'meat_inspector', NULL, '091988877706', NULL, '2026-04-28 19:15:33', '2026-04-28 19:15:33'),
(8, 9, 'Ana Marie', NULL, 'Bugal', NULL, 'admin_asst', NULL, '091988877709', NULL, '2026-04-28 19:15:35', '2026-04-28 19:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `adoption_applications`
--

CREATE TABLE `adoption_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `selected_pet_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `social_media` varchar(255) DEFAULT NULL,
  `marital_status` enum('Single','Married','Others') DEFAULT NULL,
  `adopted_before` enum('yes','no') NOT NULL DEFAULT 'no',
  `status` enum('pending_review','approved','rejected','adopted') NOT NULL DEFAULT 'pending_review',
  `rejection_reason` varchar(1000) DEFAULT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `alternate_contact` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`alternate_contact`)),
  `questionnaire` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`questionnaire`)),
  `valid_id_path` varchar(255) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `adoption_applications`
--

INSERT INTO `adoption_applications` (`id`, `selected_pet_id`, `user_id`, `owner_id`, `address_id`, `occupation`, `company`, `social_media`, `marital_status`, `adopted_before`, `status`, `rejection_reason`, `reviewed_by`, `reviewed_at`, `alternate_contact`, `questionnaire`, `valid_id_path`, `appointment_date`, `appointment_time`, `notes`, `created_at`, `updated_at`) VALUES
(6, 1, 30, 16, 22, NULL, NULL, NULL, NULL, 'no', 'pending_review', NULL, NULL, NULL, '{\"first_name\":null,\"last_name\":null,\"relationship\":null,\"phone\":null,\"email\":null}', '{\"housing_type\":\"Condo\",\"housing_ownership\":\"Rent (Landlord allows pets)\",\"household_members\":[\"Living alone\"],\"household_agreement\":\"Yes\",\"pet_allergies\":\"Yes\",\"primary_caregiver\":\"Myself\",\"time_alone\":\"4 \\u2013 8 hours\",\"relocation_plan\":\"Rehome responsibly\",\"current_pets\":\"No\",\"past_pet_experience\":\"Yes\",\"vaccination_stance\":\"Yes\",\"home_photos\":{\"primary_living_area\":[\"adoption\\/home-photos\\/JmBeWhAmCtBqCQhVNXDgUnFiPyJ8Z2h7uDaDBy9A.jpg\"],\"outdoor_yard_gate\":[\"adoption\\/home-photos\\/5N09Ryklb40AWJ6wmtEoyilMS6jrgr4jiUlRKj1f.jpg\"]}}', 'adoption/valid-ids/SNNtSTASgtbmvZH7FJ21oHNBSA3ifjOOdUU1gXJ4.jpg', '2026-11-16', '16:00:00', 'need to go to the dentist', '2026-11-01 16:05:09', '2026-11-03 15:59:20'),
(7, 1, 30, 16, 22, NULL, NULL, NULL, NULL, 'no', 'pending_review', NULL, NULL, NULL, '{\"first_name\":null,\"last_name\":null,\"relationship\":null,\"phone\":null,\"email\":null}', '{\"housing_type\":\"Condo\",\"housing_ownership\":\"Own\",\"household_members\":[\"Spouse or Partner\"],\"household_agreement\":\"No\",\"pet_allergies\":\"No\",\"primary_caregiver\":\"Myself & Spouse\\/Partner\",\"time_alone\":\"Less than 4 hours\",\"relocation_plan\":\"Bring the pet with me\",\"current_pets\":\"No\",\"past_pet_experience\":\"Yes\",\"vaccination_stance\":\"No\",\"home_photos\":{\"primary_living_area\":[\"adoption\\/home-photos\\/GAFdruLBOFNUVmXVQQM615gMI8vYnxtCuxU6GPgh.jpg\"],\"outdoor_yard_gate\":[]}}', 'adoption/valid-ids/j58aCRcGIlOpyxLYOA3gaIYIDuCzQCYXDLlupoP8.jpg', '2026-11-13', '09:00:00', NULL, '2026-11-04 06:26:03', '2026-11-04 06:26:03');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `organized_by` varchar(255) DEFAULT NULL,
  `attachment_path` varchar(255) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `category` enum('campaign','event','announcement') NOT NULL DEFAULT 'event',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `status` enum('Draft','Published','Archived','Scheduled') DEFAULT 'Draft',
  `event_date` date DEFAULT NULL,
  `event_time` time DEFAULT NULL,
  `max_pets` int(11) DEFAULT NULL,
  `event_type` enum('vaccination','spay_neuter','both') DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_number` varchar(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `organized_by`, `attachment_path`, `photo_path`, `category`, `is_active`, `status`, `event_date`, `event_time`, `max_pets`, `event_type`, `location`, `barangay_id`, `contact_number`, `created_by`, `created_at`, `updated_at`) VALUES
(2, 'Rabies Alert: Increased Cases in Area', 'We have observed an increase in rabies cases in nearby areas. Please ensure your pets are vaccinated and avoid contact with stray animals. Report any suspected rabies cases immediately to the veterinary office.', NULL, NULL, NULL, 'campaign', 1, 'Scheduled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(3, 'Pet Registration Reminder', 'Pet owners are reminded to register their pets at the City Veterinary Office. Registered pets will receive identification tags and are eligible for free vaccinations. Please bring your pet and valid ID to register.', NULL, NULL, NULL, 'campaign', 1, 'Draft', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(10, 'Anti-Rabies Vaccination and Spay/Neuter Data for Dogs and Cats', 'Operation PusaDog — Thank you, Ex-Congressman Kiko Barzaga, for helping make these achievements in anti-rabies vaccination and spay/neuter services possible—for a safer, healthier Dasmariñas.\r\nThank you also to our kapon partners Biyaya Animal Care, Philippine Animal Welfare Society (PAWS) and the Dasmariñas City Animal Welfare Advocates Club mass kapon organizers and volunteers', NULL, NULL, 'announcements/dp7PT2u3G4Kk3171hGsgLWd63ObKUNnQYSuOM4uz.jpg', 'announcement', 1, 'Published', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-11-02 11:48:13', '2026-11-02 11:48:13'),
(11, 'Low-Cost Kapon Dasmarinas Cavite', 'Low-Cost Kapon (Spay & Neuter) Event in Dasmaville!\n\nKeep your pets healthy and help control the stray population! Join our upcoming low-cost Kapon event led by Doc Gab Veterinarian.\n📞 For inquiries, bookings, or PMs: 0998-366-3403\n\nSlots are limited! Send us a message or call today to reserve a slot for your fur-babies. 🐶🐱', NULL, NULL, 'announcements/tRavudnJwiVOky2Ps9zAbOmMF3xN45lLh0btXwcV.jpg', 'event', 1, 'Published', '2026-11-06', '09:20:00', NULL, NULL, 'Covered Court, Dasmaville', 1, NULL, 1, '2026-11-02 12:20:54', '2026-11-02 12:20:54'),
(12, 'Animal Welfare Week 2026', 'Ang kapakanan ng hayop at kapakanan ng tao ay magkaugnay. Sa bawat alagang nababakunahan, pamilyang natutulungang maging responsableng pet owner, at hayop na nabibigyan ng tamang pangangalaga, mas ligtas at mas maayos ang ating komunidad.\r\n\r\nIto ang papel ng Dasmariñas City Veterinary Office—maging tulay upang mas maunawaan na ang animal welfare ay bahagi rin ng paglilingkod sa tao. Ang libreng kapon, anti-rabies vaccination, at pet food giveaway ay mga konkretong paraan upang alagaan ang mga hayop habang tinutulungan ang mga pamilyang nagmamahal at umaako ng responsibilidad para sa kanila.\r\n\r\nNgayong Animal Welfare Week, salamat kina Cong Jenny Austria-Barzaga, Mayor Third Barzaga, Ex-Congressman Kiko Barzaga at sa Zootari, Knights of Columbus, at Bank of Commerce sa pakikiisa sa ating dalawang araw na serbisyo. Sa pagtutulungan, naipapakita natin na ang malasakit sa hayop at malasakit sa tao ay may iisang layunin: isang mas ligtas, malusog, at mapagkalingang Dasmariñas.', NULL, NULL, 'announcements/tjp69BkoGcqtNFXOVFatnhlMa17IYPYm6GppydWE.jpg', 'campaign', 1, 'Published', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-11-02 12:22:59', '2026-11-02 12:22:59');

-- --------------------------------------------------------

--
-- Table structure for table `announcement_reads`
--

CREATE TABLE `announcement_reads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `announcement_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `read_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `service_type` enum('vaccination','kapon','adoption_interview') NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','scheduled','completed','cancelled','no_show') NOT NULL DEFAULT 'pending',
  `total_weight` int(11) NOT NULL DEFAULT 1,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barangays`
--

CREATE TABLE `barangays` (
  `barangay_id` bigint(20) UNSIGNED NOT NULL,
  `barangay_name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL DEFAULT 'City',
  `province` varchar(255) NOT NULL DEFAULT 'Province',
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `office_email` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barangays`
--

INSERT INTO `barangays` (`barangay_id`, `barangay_name`, `city`, `province`, `latitude`, `longitude`, `contact_number`, `office_email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Zone I', 'Dasmariñas', 'Cavite', 14.32940000, 120.93580000, NULL, NULL, 'active', NULL, NULL),
(2, 'Zone I-B', 'Dasmariñas', 'Cavite', 14.33030000, 120.93670000, NULL, NULL, 'active', NULL, NULL),
(3, 'Zone II', 'Dasmariñas', 'Cavite', 14.33120000, 120.93750000, NULL, NULL, 'active', NULL, NULL),
(4, 'Zone III', 'Dasmariñas', 'Cavite', 14.33300000, 120.93920000, NULL, NULL, 'active', NULL, NULL),
(5, 'Zone IV', 'Dasmariñas', 'Cavite', 14.33480000, 120.94100000, NULL, NULL, 'active', NULL, NULL),
(6, 'Burol Main', 'Dasmariñas', 'Cavite', 14.34230000, 120.93010000, NULL, NULL, 'active', NULL, NULL),
(7, 'Burol I', 'Dasmariñas', 'Cavite', 14.34120000, 120.92870000, NULL, NULL, 'active', NULL, NULL),
(8, 'Burol II', 'Dasmariñas', 'Cavite', 14.33900000, 120.92650000, NULL, NULL, 'active', NULL, NULL),
(9, 'Burol III', 'Dasmariñas', 'Cavite', 14.33680000, 120.92430000, NULL, NULL, 'active', NULL, NULL),
(10, 'Datu Esmael (Bago-a-Ingud)', 'Dasmariñas', 'Cavite', 14.35670000, 120.94890000, NULL, NULL, 'active', NULL, NULL),
(11, 'Emmanuel Bergado I', 'Dasmariñas', 'Cavite', 14.34560000, 120.94320000, NULL, NULL, 'active', NULL, NULL),
(12, 'Emmanuel Bergado II', 'Dasmariñas', 'Cavite', 14.34340000, 120.94100000, NULL, NULL, 'active', NULL, NULL),
(13, 'Fatima I', 'Dasmariñas', 'Cavite', 14.34890000, 120.94230000, NULL, NULL, 'active', NULL, NULL),
(14, 'Fatima II', 'Dasmariñas', 'Cavite', 14.34670000, 120.94010000, NULL, NULL, 'active', NULL, NULL),
(15, 'Fatima III', 'Dasmariñas', 'Cavite', 14.34450000, 120.93790000, NULL, NULL, 'active', NULL, NULL),
(16, 'H-2', 'Dasmariñas', 'Cavite', 14.32780000, 120.91450000, NULL, NULL, 'active', NULL, NULL),
(17, 'Langkaan I', 'Dasmariñas', 'Cavite', 14.31560000, 120.94250000, NULL, NULL, 'active', NULL, NULL),
(18, 'Langkaan II', 'Dasmariñas', 'Cavite', 14.31340000, 120.94030000, NULL, NULL, 'active', NULL, NULL),
(19, 'Luzviminda I', 'Dasmariñas', 'Cavite', 14.32340000, 120.90890000, NULL, NULL, 'active', NULL, NULL),
(20, 'Luzviminda II', 'Dasmariñas', 'Cavite', 14.32120000, 120.90670000, NULL, NULL, 'active', NULL, NULL),
(21, 'Paliparan I', 'Dasmariñas', 'Cavite', 14.32120000, 120.91780000, NULL, NULL, 'active', NULL, NULL),
(22, 'Paliparan II', 'Dasmariñas', 'Cavite', 14.31900000, 120.91560000, NULL, NULL, 'active', NULL, NULL),
(23, 'Paliparan III', 'Dasmariñas', 'Cavite', 14.31680000, 120.91340000, NULL, NULL, 'active', NULL, NULL),
(24, 'Sabang', 'Dasmariñas', 'Cavite', 14.34780000, 120.95670000, NULL, NULL, 'active', NULL, NULL),
(25, 'Saint Peter I', 'Dasmariñas', 'Cavite', 14.33890000, 120.93670000, NULL, NULL, 'active', NULL, NULL),
(26, 'Saint Peter II', 'Dasmariñas', 'Cavite', 14.33670000, 120.93450000, NULL, NULL, 'active', NULL, NULL),
(27, 'Salawag', 'Dasmariñas', 'Cavite', 14.32560000, 120.92340000, NULL, NULL, 'active', NULL, NULL),
(28, 'Salitran I', 'Dasmariñas', 'Cavite', 14.32670000, 120.95120000, NULL, NULL, 'active', NULL, NULL),
(29, 'Salitran II', 'Dasmariñas', 'Cavite', 14.32450000, 120.95350000, NULL, NULL, 'active', NULL, NULL),
(30, 'Salitran III', 'Dasmariñas', 'Cavite', 14.32230000, 120.95580000, NULL, NULL, 'active', NULL, NULL),
(31, 'Salitran IV', 'Dasmariñas', 'Cavite', 14.32010000, 120.95810000, NULL, NULL, 'active', NULL, NULL),
(32, 'Sampaloc I (Pala-Pala)', 'Dasmariñas', 'Cavite', 14.30980000, 120.93450000, NULL, NULL, 'active', NULL, NULL),
(33, 'Sampaloc II (Bucal/Malinta)', 'Dasmariñas', 'Cavite', 14.30760000, 120.93230000, NULL, NULL, 'active', NULL, NULL),
(34, 'Sampaloc III (Piela)', 'Dasmariñas', 'Cavite', 14.30540000, 120.93010000, NULL, NULL, 'active', NULL, NULL),
(35, 'Sampaloc IV (Talisayan/Bautista)', 'Dasmariñas', 'Cavite', 14.30320000, 120.92790000, NULL, NULL, 'active', NULL, NULL),
(36, 'Sampaloc V (New Era)', 'Dasmariñas', 'Cavite', 14.30100000, 120.92570000, NULL, NULL, 'active', NULL, NULL),
(37, 'San Agustin I', 'Dasmariñas', 'Cavite', 14.34010000, 120.94890000, NULL, NULL, 'active', NULL, NULL),
(38, 'San Agustin II (R. Tirona)', 'Dasmariñas', 'Cavite', 14.33790000, 120.94670000, NULL, NULL, 'active', NULL, NULL),
(39, 'San Agustin III', 'Dasmariñas', 'Cavite', 14.33570000, 120.94450000, NULL, NULL, 'active', NULL, NULL),
(40, 'San Andres I', 'Dasmariñas', 'Cavite', 14.32890000, 120.95010000, NULL, NULL, 'active', NULL, NULL),
(41, 'San Andres II', 'Dasmariñas', 'Cavite', 14.32670000, 120.94790000, NULL, NULL, 'active', NULL, NULL),
(42, 'San Antonio De Padua I', 'Dasmariñas', 'Cavite', 14.35230000, 120.93560000, NULL, NULL, 'active', NULL, NULL),
(43, 'San Antonio De Padua II', 'Dasmariñas', 'Cavite', 14.35010000, 120.93340000, NULL, NULL, 'active', NULL, NULL),
(44, 'San Dionisio (Barangay 1)', 'Dasmariñas', 'Cavite', 14.32560000, 120.92340000, NULL, NULL, 'active', NULL, NULL),
(45, 'San Esteban (Barangay 4)', 'Dasmariñas', 'Cavite', 14.33450000, 120.93120000, NULL, NULL, 'active', NULL, NULL),
(46, 'San Francisco I', 'Dasmariñas', 'Cavite', 14.35670000, 120.92340000, NULL, NULL, 'active', NULL, NULL),
(47, 'San Francisco II', 'Dasmariñas', 'Cavite', 14.35450000, 120.92120000, NULL, NULL, 'active', NULL, NULL),
(48, 'San Isidro Labrador I', 'Dasmariñas', 'Cavite', 14.31780000, 120.92560000, NULL, NULL, 'active', NULL, NULL),
(49, 'San Isidro Labrador II', 'Dasmariñas', 'Cavite', 14.31560000, 120.92340000, NULL, NULL, 'active', NULL, NULL),
(50, 'San Jose', 'Dasmariñas', 'Cavite', 14.33140000, 120.94020000, NULL, NULL, 'active', NULL, NULL),
(51, 'San Juan (San Juan I)', 'Dasmariñas', 'Cavite', 14.32980000, 120.93890000, NULL, NULL, 'active', NULL, NULL),
(52, 'San Lorenzo Ruiz I', 'Dasmariñas', 'Cavite', 14.32340000, 120.91670000, NULL, NULL, 'active', NULL, NULL),
(53, 'San Lorenzo Ruiz II', 'Dasmariñas', 'Cavite', 14.32120000, 120.91450000, NULL, NULL, 'active', NULL, NULL),
(54, 'San Luis I', 'Dasmariñas', 'Cavite', 14.34890000, 120.92980000, NULL, NULL, 'active', NULL, NULL),
(55, 'San Luis II', 'Dasmariñas', 'Cavite', 14.34670000, 120.92760000, NULL, NULL, 'active', NULL, NULL),
(56, 'San Manuel I', 'Dasmariñas', 'Cavite', 14.35780000, 120.91670000, NULL, NULL, 'active', NULL, NULL),
(57, 'San Manuel II', 'Dasmariñas', 'Cavite', 14.35560000, 120.91450000, NULL, NULL, 'active', NULL, NULL),
(58, 'San Mateo', 'Dasmariñas', 'Cavite', 14.35450000, 120.92340000, NULL, NULL, 'active', NULL, NULL),
(59, 'San Miguel', 'Dasmariñas', 'Cavite', 14.35230000, 120.93120000, NULL, NULL, 'active', NULL, NULL),
(60, 'San Miguel II', 'Dasmariñas', 'Cavite', 14.35010000, 120.92900000, NULL, NULL, 'active', NULL, NULL),
(61, 'San Nicolas I', 'Dasmariñas', 'Cavite', 14.33980000, 120.91980000, NULL, NULL, 'active', NULL, NULL),
(62, 'San Nicolas II', 'Dasmariñas', 'Cavite', 14.33760000, 120.91760000, NULL, NULL, 'active', NULL, NULL),
(63, 'San Roque (Sta. Cristina II)', 'Dasmariñas', 'Cavite', 14.34010000, 120.94900000, NULL, NULL, 'active', NULL, NULL),
(64, 'San Simon (Barangay 7)', 'Dasmariñas', 'Cavite', 14.32780000, 120.92670000, NULL, NULL, 'active', NULL, NULL),
(65, 'Santa Cristina I', 'Dasmariñas', 'Cavite', 14.34230000, 120.95120000, NULL, NULL, 'active', NULL, NULL),
(66, 'Santa Cristina II', 'Dasmariñas', 'Cavite', 14.34010000, 120.94900000, NULL, NULL, 'active', NULL, NULL),
(67, 'Santa Cruz I', 'Dasmariñas', 'Cavite', 14.32450000, 120.91010000, NULL, NULL, 'active', NULL, NULL),
(68, 'Santa Cruz II', 'Dasmariñas', 'Cavite', 14.32230000, 120.90790000, NULL, NULL, 'active', NULL, NULL),
(69, 'Santa Fe', 'Dasmariñas', 'Cavite', 14.31890000, 120.92010000, NULL, NULL, 'active', NULL, NULL),
(70, 'Santa Lucia (San Juan II)', 'Dasmariñas', 'Cavite', 14.33120000, 120.93670000, NULL, NULL, 'active', NULL, NULL),
(71, 'Santa Maria (Barangay 20)', 'Dasmariñas', 'Cavite', 14.32670000, 120.91890000, NULL, NULL, 'active', NULL, NULL),
(72, 'Santo Cristo (Barangay 3)', 'Dasmariñas', 'Cavite', 14.33340000, 120.92890000, NULL, NULL, 'active', NULL, NULL),
(73, 'Santo Niño I', 'Dasmariñas', 'Cavite', 14.34560000, 120.92670000, NULL, NULL, 'active', NULL, NULL),
(74, 'Santo Niño II', 'Dasmariñas', 'Cavite', 14.34340000, 120.92450000, NULL, NULL, 'active', NULL, NULL),
(75, 'Victoria Reyes', 'Dasmariñas', 'Cavite', 14.31890000, 120.93780000, NULL, NULL, 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificate_series`
--

CREATE TABLE `certificate_series` (
  `series_id` bigint(20) UNSIGNED NOT NULL,
  `series_name` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `last_number` int(11) NOT NULL DEFAULT 0,
  `prefix` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clinical_actions`
--

CREATE TABLE `clinical_actions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `case_title` varchar(255) NOT NULL,
  `action_type` varchar(255) DEFAULT NULL,
  `pet_id` bigint(20) UNSIGNED DEFAULT NULL,
  `animal_name` varchar(255) DEFAULT NULL,
  `species` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `owner_contact` varchar(255) DEFAULT NULL,
  `action_date` date DEFAULT NULL,
  `description` text NOT NULL,
  `diagnosis` text DEFAULT NULL,
  `treatment_given` text DEFAULT NULL,
  `medication` varchar(255) DEFAULT NULL,
  `follow_up_date` date DEFAULT NULL,
  `outcome` varchar(255) DEFAULT NULL,
  `veterinarian_id` bigint(20) UNSIGNED DEFAULT NULL,
  `barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('Pending','In Review','Completed') NOT NULL DEFAULT 'Pending',
  `remarks` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_tokens`
--

CREATE TABLE `device_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(500) NOT NULL,
  `device_type` varchar(255) DEFAULT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `establishments`
--

CREATE TABLE `establishments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('meat_shop','poultry','pet_shop','vet_clinic','livestock_facility','other') NOT NULL,
  `permit_no` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','suspended','pending') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('abc','clinic','hospital') NOT NULL,
  `barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `type`, `barangay_id`, `created_at`, `updated_at`) VALUES
(1, 'ABC Animal Bite Center - Salawag', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(2, 'ABC Animal Bite Center - San Agustin', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(3, 'ABC Animal Bite Center - San Jose', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(4, 'ABC Happy Life Animal Bite Clinic - Kadiwa, Burol 2', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(5, 'ABC Happy Life Animal Bite Clinic - Pala-Pala', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(6, 'Animal Bite Center - Dasmariñas, Cavite', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(7, 'Armielou ABC Animal Bite Center', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(8, 'Bytz Aide Animal Bite Center', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(9, 'Damarinas City Health Office (CHO) 4', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(10, 'Dasmarinas City Health Office (CHO) 1', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(11, 'Dasmarinas City Health Office (CHO) 3', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(12, 'Firstline Medical Clinic and Animal Bite Center', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(13, 'JGMD Animal Bite Center', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(14, 'Pagamutan ng Dasmariñas (Animal Bite Treatment Center)', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(15, 'St. Mary\'s Animal Bite Clinic - Dasmarinas Cavite', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(16, 'Vaccicare Animal Bite Center', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(17, 'Vaxilife Animal Bite Center', 'abc', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(18, 'Amigos Pet Grooming', 'clinic', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(19, 'Crupet Grooming Center', 'clinic', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(20, 'Dasma Animal Clinic', 'clinic', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(21, 'IOLAC Vet Clinic', 'clinic', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(22, 'Ivan Animal Clinic', 'clinic', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(23, 'Kanjis Pet Grooming', 'clinic', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(24, 'Lil Pet Grooming Center', 'clinic', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(25, 'Pet Express', 'clinic', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(26, 'Petology Emergency Animal Hospital', 'clinic', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(27, 'Salitran Animal Clinic & Grooming Station', 'clinic', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(28, 'Tucay Vet Clinic and Pet Grooming', 'clinic', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(29, 'Vetterhealth Animal Clinic', 'clinic', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(30, 'Vetways Animal Clinic', 'clinic', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(31, 'Agraan Hospital', 'hospital', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(32, 'Asia Medic Family Hospital & Medical Center', 'hospital', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(33, 'Dasmarinas City (DBB) Municipal Hospital', 'hospital', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(34, 'Dasmarinas City Medical Center', 'hospital', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(35, 'De La Salle University Medical Center', 'hospital', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(36, 'EAC Medical Center - Cavite', 'hospital', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(37, 'GMF Hospital', 'hospital', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(38, 'Medcor Dasmarinas Hospital and Medical Center', 'hospital', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(39, 'Pagamutan ng Dasmarinas', 'hospital', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(40, 'St. Paul Hospital Cavite', 'hospital', NULL, '2026-04-28 19:15:39', '2026-04-28 19:15:39');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_submissions`
--

CREATE TABLE `form_submissions` (
  `submission_id` bigint(20) UNSIGNED NOT NULL,
  `form_id` bigint(20) UNSIGNED NOT NULL,
  `submitted_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `citizen_name` varchar(255) DEFAULT NULL,
  `citizen_contact` varchar(255) DEFAULT NULL,
  `citizen_address` text DEFAULT NULL,
  `payload_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload_json`)),
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `review_notes` text DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guest_report_tokens`
--

CREATE TABLE `guest_report_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(255) NOT NULL,
  `pet_name` varchar(255) DEFAULT NULL,
  `species` varchar(255) DEFAULT NULL,
  `is_crossbreed` tinyint(1) NOT NULL DEFAULT 0,
  `reporter_contact` varchar(255) DEFAULT NULL,
  `reporter_email` varchar(255) DEFAULT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_controls`
--

CREATE TABLE `inventory_controls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `minimum_stock` int(11) NOT NULL DEFAULT 0,
  `unit_cost` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `batch_number` varchar(255) DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `storage_location` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','out_of_stock') NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_controls`
--

INSERT INTO `inventory_controls` (`id`, `item_name`, `item_code`, `category`, `unit`, `quantity`, `minimum_stock`, `unit_cost`, `description`, `expiry_date`, `batch_number`, `supplier`, `storage_location`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Rabisin', 'ARV-001', 'Vaccines', 'vial', 120, 30, 185.00, 'For animal anti-rabies vaccination', '2027-06-30', 'ARV-2026-01', 'Department of Health', 'Main Veterinary Storage', 'active', 1, '2026-09-22 13:57:35', '2026-09-22 13:57:35'),
(2, 'Rabisin', 'ARV-002', 'Vaccines', 'vial', 95, 25, 185.00, 'For animal anti-rabies vaccination', '2027-07-31', 'ARV-2026-02', 'Department of Health', 'Main Veterinary Storage', 'active', 1, '2026-09-22 13:57:35', '2026-09-22 13:57:35'),
(3, 'Disposable Syringe 1mL', 'SYR-001', 'Vaccination Supplies', 'piece', 500, 100, 8.50, '1mL sterile disposable syringe', '2029-12-31', 'SYR-2026-01', 'Department of Health', 'Medical Supplies Cabinet', 'active', 1, '2026-09-22 13:57:35', '2026-09-22 13:57:35'),
(4, 'Disposable Syringe 3mL', 'SYR-003', 'Vaccination Supplies', 'piece', 350, 75, 10.50, '3mL sterile disposable syringe', '2029-12-31', 'SYR-2026-02', 'Department of Health', 'Medical Supplies Cabinet', 'active', 1, '2026-09-22 13:57:35', '2026-09-22 13:57:35'),
(5, 'Disposable Gloves', 'GLV-001', 'Personal Protective Equipment', 'box', 80, 20, 165.00, 'Disposable examination gloves', '2029-08-31', 'GLV-2026-01', 'Department of Health', 'PPE Storage', 'active', 1, '2026-09-22 13:57:35', '2026-09-22 13:57:35'),
(6, 'Alcohol 70% Solution', 'ALC-070', 'Disinfectants', 'bottle', 60, 15, 95.00, '70% ethyl alcohol for disinfection', '2028-05-31', 'ALC-2026-01', 'Department of Health', 'Medical Supplies Cabinet', 'active', 1, '2026-09-22 13:57:35', '2026-09-22 13:57:35'),
(7, 'Cotton Balls', 'CTN-001', 'Medical Supplies', 'pack', 100, 25, 45.00, 'Sterile cotton balls for vaccination procedures', '2028-11-30', 'CTN-2026-01', 'Department of Health', 'Medical Supplies Cabinet', 'active', 1, '2026-09-22 13:57:35', '2026-09-22 13:57:35'),
(8, 'Gauze Pads', 'GAZ-001', 'Medical Supplies', 'pack', 75, 20, 55.00, 'Sterile gauze pads', '2028-10-31', 'GAZ-2026-01', 'Department of Health', 'Medical Supplies Cabinet', 'active', 1, '2026-09-22 13:57:35', '2026-09-22 13:57:35'),
(9, 'Surgical Masks', 'MSK-001', 'Personal Protective Equipment', 'box', 120, 30, 125.00, 'Disposable surgical masks', '2029-03-31', 'MSK-2026-01', 'Department of Health', 'PPE Storage', 'active', 1, '2026-09-22 13:57:35', '2026-09-22 13:57:35'),
(10, 'Sharps Container', 'SCP-001', 'Medical Waste Supplies', 'piece', 30, 10, 220.00, 'Container for used needles and sharps', '2029-06-30', 'SCP-2026-01', 'Department of Health', 'Medical Waste Area', 'active', 1, '2026-09-22 13:57:35', '2026-09-22 13:57:35'),
(11, 'Vaccine Carrier', 'VCR-001', 'Cold Chain Equipment', 'piece', 12, 3, 1450.00, 'Insulated carrier for vaccine transport', NULL, 'VCR-2026-01', 'Department of Health', 'Cold Chain Storage', 'active', 1, '2026-09-22 13:57:35', '2026-09-22 13:57:35'),
(12, 'Ice Pack', 'ICP-001', 'Cold Chain Supplies', 'piece', 40, 10, 120.00, 'Reusable ice pack for vaccine carrier', NULL, 'ICP-2026-01', 'Department of Health', 'Cold Chain Storage', 'active', 1, '2026-09-22 13:57:35', '2026-09-22 13:57:35'),
(13, 'Digital Thermometer', 'THM-001', 'Monitoring Equipment', 'piece', 8, 2, 350.00, 'Digital thermometer for vaccine storage monitoring', NULL, 'THM-2026-01', 'Department of Health', 'Cold Chain Storage', 'active', 1, '2026-09-22 13:57:35', '2026-09-22 13:57:35'),
(14, 'Vitamin Supplement', 'VIT-001', 'Animal Supplements', 'bottle', 25, 5, 280.00, 'Veterinary vitamin supplement', '2027-12-31', 'VIT-2026-01', 'Department of Health', 'Veterinary Supplies Shelf', 'active', 1, '2026-09-22 13:57:35', '2026-09-22 13:57:35'),
(15, 'Antiseptic Solution', 'ANT-001', 'Disinfectants', 'bottle', 35, 10, 135.00, 'Antiseptic solution for wound cleaning', '2028-04-30', 'ANT-2026-01', 'Department of Health', 'Medical Supplies Cabinet', 'active', 1, '2026-09-22 13:57:35', '2026-09-22 13:57:35');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_items`
--

CREATE TABLE `inventory_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `unit` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `min_stock_level` int(11) NOT NULL DEFAULT 10,
  `expiry_date` date DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `cost_per_unit` decimal(10,2) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','discontinued') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_items`
--

INSERT INTO `inventory_items` (`id`, `user_id`, `item_name`, `item_code`, `category`, `description`, `unit`, `quantity`, `min_stock_level`, `expiry_date`, `supplier`, `cost_per_unit`, `location`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Rabies Vaccine (Inactivated)', 'RAB-001', 'vaccine', 'Inactivated rabies vaccine for dogs and cats', 'vials', 150, 50, '2026-10-29', 'Veterinary Pharma Inc.', 150.00, 'Cold Storage A', 'active', '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(2, 1, 'Deworming Tablet (Broad Spectrum)', 'DEW-001', 'medication', 'Broad spectrum deworming medication', 'tablets', 500, 100, '2027-04-29', 'Animal Health Co.', 25.00, 'Storage B', 'active', '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(3, 1, '5-in-1 Vaccine (DHPPiL)', 'VAC-005', 'vaccine', 'Combination vaccine for dogs', 'vials', 80, 30, '2026-08-29', 'Veterinary Pharma Inc.', 200.00, 'Cold Storage A', 'active', '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(4, 1, 'Antibiotic (Amoxicillin)', 'ANT-001', 'medication', 'Broad spectrum antibiotic', 'capsules', 200, 50, '2026-12-29', 'Pharma Vet Corp.', 15.00, 'Storage B', 'active', '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(5, 1, 'Syringe (3ml)', 'SUP-001', 'supplies', '3ml disposable syringe with needle', 'pieces', 20, 100, NULL, 'Medical Supplies Inc.', 5.00, 'Supplies Cabinet', 'active', '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(6, 1, 'Rabies Vaccine (Expired)', 'RAB-002', 'vaccine', 'Expired rabies vaccine - for disposal', 'vials', 30, 50, '2026-03-01', 'Veterinary Pharma Inc.', 150.00, 'Quarantine Area', 'inactive', '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(7, 1, 'FVRCP Vaccine (Cats)', 'VAC-FVR', 'vaccine', 'Feline viral rhinotracheitis, calicivirus, panleukopenia', 'vials', 10, 20, '2026-09-29', 'Cat Health Ltd.', 180.00, 'Cold Storage B', 'active', '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(8, 1, 'Surgical Gloves (Medium)', 'SUP-GL', 'supplies', 'Disposable surgical gloves - medium size', 'pairs', 45, 50, '2027-10-29', 'Safety First Inc.', 20.00, 'Surgery Room', 'active', '2026-04-28 19:15:39', '2026-04-28 19:15:39');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_movements`
--

CREATE TABLE `inventory_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inventory_control_id` bigint(20) UNSIGNED NOT NULL,
  `movement_type` enum('In','Out','Adjustment','Transfer') NOT NULL,
  `movement_reason` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `reason` text DEFAULT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `performed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `target_barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vaccination_report_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `livestock`
--

CREATE TABLE `livestock` (
  `livestock_id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `farm_name` varchar(255) DEFAULT NULL,
  `animal_type` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `species` varchar(255) NOT NULL,
  `breed` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `gender` enum('male','female','unknown') NOT NULL DEFAULT 'unknown',
  `age` int(11) DEFAULT NULL,
  `age_unit` enum('years','months','weeks') NOT NULL DEFAULT 'years',
  `tag_number` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `owner_contact` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('active','sold','deceased','slaughtered') NOT NULL DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `recorded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `livestock_censuses`
--

CREATE TABLE `livestock_censuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `encoded_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `species` enum('cattle','carabao','swine','horse','goat','dog','pigeon') NOT NULL,
  `no_of_heads` int(11) NOT NULL DEFAULT 0,
  `no_of_farmers` int(11) NOT NULL DEFAULT 0,
  `report_year` year(4) NOT NULL,
  `report_month` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meat_establishments`
--

CREATE TABLE `meat_establishments` (
  `establishment_id` bigint(20) UNSIGNED NOT NULL,
  `establishment_name` varchar(255) NOT NULL,
  `establishment_type` enum('meat_shop','slaughterhouse','livestock_farm','poultry_farm','meat_processing_plant') DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address_text` text NOT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `permit_no` varchar(255) DEFAULT NULL,
  `inspection_date` date DEFAULT NULL,
  `barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `registered_by_user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('Active','Expired','Pending Inspection') NOT NULL DEFAULT 'Active',
  `permit_expiry_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meat_establishments`
--

INSERT INTO `meat_establishments` (`establishment_id`, `establishment_name`, `establishment_type`, `owner_name`, `contact_person`, `contact_number`, `email`, `address_text`, `landmark`, `permit_no`, `inspection_date`, `barangay_id`, `registered_by_user_id`, `status`, `permit_expiry_date`, `created_at`, `updated_at`) VALUES
(1, 'Dasmariñas Meat Market', 'meat_shop', 'Juan Dela Cruz', 'Pedro Santos', '09123456789', 'meat@email.com', '5449 Zemlak Rue, Dasmariñas City', NULL, NULL, '2024-01-15', 56, 1, 'Pending Inspection', '2025-01-15', '2026-06-26 12:26:58', '2026-06-26 12:26:58'),
(2, 'Paliparan Meat Shop', 'meat_shop', 'Maria Garcia', 'Ana Reyes', '09234567890', 'paliparan@email.com', '567 Marcelo Throughway, Dasmariñas City', NULL, NULL, '2024-02-20', 61, 1, 'Pending Inspection', '2025-02-20', '2026-06-26 12:26:58', '2026-06-26 12:26:58'),
(3, 'Zone 3 Poultry Dealer', 'poultry_farm', 'Jose Ramos', 'Carlos Mendez', '09345678901', 'poultry@email.com', '5904 Blick Prairie Apt. 632, Dasmariñas City', NULL, NULL, '2024-03-10', 62, 1, 'Pending Inspection', '2025-03-10', '2026-06-26 12:26:58', '2026-06-26 12:26:58'),
(4, 'Salitran Pork Center', 'meat_processing_plant', 'Elena Cruz', 'Miguel Torres', '09456789012', 'salitran@email.com', '656 Hammes Extensions Apt. 335, Dasmariñas City', NULL, NULL, '2023-06-01', 6, 1, 'Expired', '2024-06-01', '2026-06-26 12:26:58', '2026-06-26 12:26:58'),
(5, 'Burol Meat Stall', 'meat_shop', 'Rosa Villanueva', 'Luis Fernandez', '09567890123', 'burol@email.com', '717 Lora Springs Apt. 661, Dasmariñas City', NULL, NULL, '2024-05-01', 9, 1, 'Active', '2025-05-01', '2026-06-26 12:26:58', '2026-06-26 12:26:58'),
(6, 'Langkaan II Meat Shop', 'meat_shop', 'Antonio Lim', 'Sofia Reyes', '09678901234', 'langkaan@email.com', '7080 Considine Shore, Dasmariñas City', NULL, NULL, '2024-04-12', 39, 1, 'Active', '2025-04-12', '2026-06-26 12:26:58', '2026-06-26 12:26:58'),
(7, 'Sampalukan Meat Market', 'meat_shop', 'Carmen Diaz', 'Diego Villar', '09789012345', 'sampalukan@email.com', '23912 Florida Branch, Dasmariñas City', NULL, NULL, '2024-01-20', 52, 1, 'Active', '2025-01-20', '2026-06-26 12:26:58', '2026-06-26 12:26:58'),
(8, 'San Agustin Poultry', 'poultry_farm', 'Francisco Santos', 'Isabella Cruz', '09890123456', 'sanagustin@email.com', '398 Mann Creek, Dasmariñas City', NULL, NULL, '2024-03-05', 63, 1, 'Active', '2025-03-05', '2026-06-26 12:26:58', '2026-06-26 12:26:58');

-- --------------------------------------------------------

--
-- Table structure for table `meat_inspections`
--

CREATE TABLE `meat_inspections` (
  `inspection_id` bigint(20) UNSIGNED NOT NULL,
  `establishment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `inspector_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `inspector_name` varchar(255) DEFAULT NULL,
  `inspection_type` varchar(255) DEFAULT NULL,
  `inspection_date` date NOT NULL,
  `status` enum('passed','failed','conditional') NOT NULL DEFAULT 'passed',
  `compliance_status` enum('compliant','non_compliant','conditional') DEFAULT NULL,
  `findings` text DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `recommendations` text DEFAULT NULL,
  `overall_rating` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meat_shop_inspections`
--

CREATE TABLE `meat_shop_inspections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `meat_shop_id` bigint(20) UNSIGNED DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `inspection_date` date NOT NULL DEFAULT '2026-04-29',
  `ticket_number` varchar(255) DEFAULT NULL,
  `licensing` enum('compliant','non_compliant') DEFAULT NULL,
  `storage` enum('compliant','non_compliant') DEFAULT NULL,
  `meat_quality` enum('compliant','non_compliant') DEFAULT NULL,
  `sanitation` enum('compliant','non_compliant') DEFAULT NULL,
  `lighting` enum('compliant','non_compliant') DEFAULT NULL,
  `personal_hygiene` enum('compliant','non_compliant') DEFAULT NULL,
  `equipment` enum('compliant','non_compliant') DEFAULT NULL,
  `apprehension_status` enum('none','1st_warning','2nd_warning','3rd_warning') NOT NULL DEFAULT 'none',
  `apprehended_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('vaccination','kapon') NOT NULL,
  `appointment_date` date DEFAULT NULL,
  `status` enum('pending','approved','completed','rejected') NOT NULL DEFAULT 'pending',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_record_agreements`
--

CREATE TABLE `medical_record_agreements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `medical_record_id` bigint(20) UNSIGNED NOT NULL,
  `pet_id` bigint(20) UNSIGNED NOT NULL,
  `agreement_signed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_record_pets`
--

CREATE TABLE `medical_record_pets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `medical_record_id` bigint(20) UNSIGNED NOT NULL,
  `pet_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merge_audit`
--

CREATE TABLE `merge_audit` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pet_id_kept` bigint(20) UNSIGNED NOT NULL,
  `pet_id_merged` bigint(20) UNSIGNED NOT NULL,
  `confidence` varchar(50) NOT NULL,
  `reason` text NOT NULL,
  `merged_by` bigint(20) UNSIGNED DEFAULT NULL,
  `merged_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2014_10_12_000000_create_admin_users_table', 1),
(4, '2014_10_12_000000_create_users_table', 1),
(5, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2024_01_01_000001_add_role_to_users_table', 1),
(8, '2024_01_01_000002_create_pet_owners_table', 1),
(9, '2024_01_01_000003_create_pets_table', 1),
(10, '2026_02_12_125122_add_status_to_users_table', 1),
(11, '2026_02_12_130054_create_rabies_vaccination_reports_table', 1),
(12, '2026_02_12_230001_create_barangays_table', 1),
(13, '2026_02_12_230001_create_utility_tables_batch1', 1),
(14, '2026_02_12_230003_create_stray_reports_table', 1),
(15, '2026_02_13_000014_create_meat_establishments_table', 1),
(16, '2026_02_13_000016_create_report_exports_table', 1),
(17, '2026_02_13_023801_create_all_tables', 1),
(18, '2026_02_14_000001_create_device_tokens_table', 1),
(19, '2026_02_21_000001_update_users_table_for_erd', 1),
(20, '2026_02_21_000006_create_impounds_table', 1),
(21, '2026_02_21_000008_create_meat_inspections_table', 1),
(22, '2026_02_21_032747_add_otp_fields_to_users', 1),
(23, '2026_02_21_052727_add_fields_to_pets_table', 1),
(24, '2026_02_21_055934_make_birthdate_nullable_in_pets_table', 1),
(25, '2026_02_22_000001_drop_unused_tables', 1),
(26, '2026_02_27_000001_add_otp_fields_to_users_table', 1),
(27, '2026_03_05_124349_add_date_of_birth_to_users_and_pet_owners_tables', 1),
(28, '2026_03_11_000001_add_coordinates_to_barangays_table', 1),
(29, '2026_03_11_000002_update_users_table_role_column', 1),
(30, '2026_03_20_000001_fix_pets_and_add_vaccinations', 1),
(31, '2026_03_20_000006_create_livestock_table', 1),
(32, '2026_03_24_000002_recreate_establishments_table', 1),
(33, '2026_03_25_000001_create_clinical_actions_table', 1),
(34, '2026_03_25_000004_create_inventory_controls_table', 1),
(35, '2026_03_30_110258_add_alternate_phone_to_pet_owners_table', 1),
(36, '2026_03_31_150200_create_adoption_pets_table', 1),
(37, '2026_03_31_152000_add_weight_to_adoption_pets_table', 1),
(38, '2026_04_01_033500_add_estimated_age_to_adoption_pets_table', 1),
(39, '2026_04_01_035000_refactor_adoption_pets_age_columns', 1),
(40, '2026_04_01_060000_add_trait_columns_to_adoption_pets_table', 1),
(41, '2026_04_01_061000_create_pet_traits_table', 1),
(42, '2026_04_01_070000_create_traits_and_pet_traits_tables', 1),
(43, '2026_04_01_071000_modify_adoption_pets_table', 1),
(44, '2026_04_02_000003_add_bite_rabies_report_to_notifications_module_enum', 1),
(45, '2026_04_03_075605_create_meat_shop_inspections_table', 1),
(46, '2026_04_08_180000_rename_users_to_admin_users', 1),
(47, '2026_04_08_180001_fix_fk_references_to_admin_users', 1),
(48, '2026_04_08_180002_drop_unused_tables', 1),
(49, '2026_04_10_000001_create_bite_rabies_reports_table', 1),
(50, '2026_04_10_000002_drop_old_rabies_tables', 1),
(51, '2026_04_10_000011_create_announcements_table', 1),
(52, '2026_04_10_000012_consolidated_fixes', 1),
(53, '2026_04_10_000017_fix_all_user_fk_to_admin_users', 1),
(54, '2026_04_10_000018_add_user_id_to_bite_rabies_reports', 1),
(55, '2026_04_12_000000_create_missing_pets_table', 1),
(56, '2026_04_12_000001_add_bite_rabies_report_fields', 1),
(57, '2026_04_12_000001_add_columns_to_system_logs_table', 1),
(58, '2026_04_12_000001_create_medical_records_table', 1),
(59, '2026_04_12_000002_add_patient_name_fields', 1),
(60, '2026_04_12_000002_add_priority_to_notifications_table', 1),
(61, '2026_04_12_000002_create_medical_record_pets_table', 1),
(62, '2026_04_12_000003_create_medical_record_agreements_table', 1),
(63, '2026_04_12_000004_create_adoption_applications_table', 1),
(64, '2026_04_12_000005_create_adoption_selected_pets_table', 1),
(65, '2026_04_12_000006_create_media_table', 1),
(66, '2026_04_12_000007_create_appointments_table', 1),
(67, '2026_04_13_000000_create_missing_pets_reports_table', 1),
(68, '2026_04_13_000001_create_missing_pets_photos_table', 1),
(69, '2026_04_13_000002_add_indexes_to_missing_pets_reports_table', 1),
(70, '2026_04_13_063741_drop_tables_clients_animals', 1),
(71, '2026_04_13_064014_fix_fk_references_animals_to_pets', 1),
(72, '2026_04_13_064143_fix_clinical_actions_animal_id_to_pet_id', 1),
(73, '2026_04_13_100000_refactor_admin_users_normalize', 1),
(74, '2026_04_13_100001_add_source_tracking_to_pets_table', 1),
(75, '2026_04_13_100100_create_missing_reports_table', 1),
(76, '2026_04_13_100200_migrate_adoption_pets_to_pets', 1),
(77, '2026_04_13_100400_migrate_pet_traits_to_pet_id', 1),
(78, '2026_04_13_100600_create_merge_audit_table', 1),
(79, '2026_04_13_120000_create_facilities_table', 1),
(80, '2026_04_13_130000_add_facility_id_to_admin_users', 1),
(81, '2026_04_13_170000_create_spatie_permission_tables', 1),
(82, '2026_04_13_170001_make_system_logs_event_nullable', 1),
(83, '2026_04_13_180000_add_role_column_back_to_admin_users', 1),
(84, '2026_04_13_180500_add_name_column_back_to_admin_users', 1),
(85, '2026_04_13_181000_add_status_column_to_announcements', 1),
(86, '2026_04_13_181500_expand_notifications_related_module', 1),
(87, '2026_04_13_200000_add_missing_columns_to_pets_table', 1),
(88, '2026_04_13_200001_add_missing_columns_to_adoption_pets_table', 1),
(89, '2026_04_14_000000_add_email_to_pet_owners_table', 1),
(90, '2026_04_14_000000_fix_user_fk_references_to_admin_users', 1),
(91, '2026_04_14_000001_fix_otp_code_column_size', 1),
(92, '2026_04_14_000002_rename_pets_sex_to_gender', 1),
(93, '2026_04_14_000003_add_vaccination_columns_to_pets_table', 1),
(94, '2026_04_15_000001_rename_admin_users_to_users', 1),
(95, '2026_04_15_015418_drop_missing_reports_table', 1),
(96, '2026_04_16_000001_update_spay_neuter_reports_pet_age_to_string', 1),
(97, '2026_04_16_000002_rename_spay_neuter_columns', 1),
(98, '2026_04_16_000003_remove_color_markings_column', 1),
(99, '2026_04_16_035108_create_sessions_table', 1),
(100, '2026_04_16_090000_create_vaccination_reports_table', 1),
(101, '2026_04_18_122150_add_adoption_id_to_pet_traits_table', 1),
(102, '2026_04_18_124000_add_trait_id_to_pet_traits_table', 1),
(103, '2026_04_19_220335_fix_appointments_unique_constraint_to_include_service_type', 1),
(104, '2026_04_21_000000_change_user_status_values', 1),
(105, '2026_04_22_234422_create_admins_table', 1),
(106, '2026_04_22_234430_create_addresses_table', 1),
(107, '2026_04_22_234430_create_organizations_table', 1),
(108, '2026_04_22_234431_add_organization_id_to_users_table', 1),
(109, '2026_04_22_234432_add_address_id_to_pet_owners_table', 1),
(110, '2026_04_24_160109_add_city_and_province_to_addresses_table', 1),
(111, '2026_04_24_170000_drop_deprecated_columns_from_pet_owners', 1),
(112, '2026_04_24_180000_update_addresses_with_city_province', 1),
(113, '2026_04_24_190000_add_pet_owners_user_id_foreign_key', 1),
(114, '2026_04_24_200000_add_facility_id_to_admins_table', 1),
(115, '2026_04_25_091553_modify_pet_status_enum_and_drop_adoption_pets', 1),
(116, '2026_04_25_093717_create_pet_traits_table', 1),
(117, '2026_04_25_135546_drop_adoption_selected_pets_table', 1),
(118, '2026_04_25_191123_add_selected_pet_id_to_adoption_applications_table', 1),
(119, '2026_04_26_012800_update_pet_status_to_owned_for_user_registered_pets', 1),
(120, '2026_04_26_020000_add_adoption_availability_index_to_pets_table', 1),
(121, '2026_04_26_025200_make_pets_owner_id_nullable', 1),
(122, '2026_04_26_225442_backfill_city_province_for_pet_owner_addresses', 1),
(123, '2026_04_26_230044_backfill_address_id_for_existing_pet_owners', 1),
(124, '2026_04_27_221327_add_barangay_id_to_announcements_table', 1),
(125, '2026_04_27_225840_add_organized_by_to_announcements_table', 1),
(126, '2026_04_28_125615_add_pet_owner_id_to_vaccination_reports_table', 1),
(127, '2026_04_28_125624_add_pet_owner_id_to_spay_neuter_reports_table', 1),
(128, '2026_04_28_125631_add_pet_owner_id_to_adoption_applications_table', 1),
(129, '2026_04_28_125700_update_adoption_applications_add_pet_owner_id', 1),
(130, '2026_04_28_140000_rename_pet_owner_id_to_owner_id_in_vaccination_reports_table', 1),
(131, '2026_04_28_140010_add_address_id_to_vaccination_reports_table', 1),
(132, '2026_04_28_140020_backfill_vaccination_reports_relationships', 1),
(133, '2026_04_28_140030_remove_redundant_columns_from_vaccination_reports_table', 1),
(134, '2026_04_28_140040_add_vaccination_report_id_to_rabies_vaccination_reports_table', 1),
(135, '2026_04_28_150000_add_pet_id_to_spay_neuter_reports_table', 1),
(136, '2026_04_28_150010_rename_pet_owner_id_to_owner_id_in_spay_neuter_reports_table', 1),
(137, '2026_04_28_150020_add_barangay_id_to_spay_neuter_reports_table', 1),
(138, '2026_04_28_150030_modify_veterinarian_column_to_enum_in_spay_neuter_reports_table', 1),
(139, '2026_04_28_150040_remove_redundant_columns_from_spay_neuter_reports_table', 1),
(140, '2026_04_28_150100_add_address_id_to_adoption_applications_table', 1),
(141, '2026_04_28_150110_rename_pet_owner_id_to_owner_id_in_adoption_applications_table', 1),
(142, '2026_04_28_150120_backfill_address_id_in_adoption_applications', 1),
(143, '2026_04_28_150130_remove_redundant_columns_from_adoption_applications_table', 1),
(144, '2026_04_28_212418_remove_name_columns_from_users_table', 1),
(145, '2026_04_28_213106_remove_additional_legacy_columns_from_users_table', 1),
(146, '2026_05_24_000000_drop_scheduled_deprecated_tables', 1),
(147, '2026_04_29_045851_backfill_addresses_from_pet_owners_table', 2),
(148, '2026_04_29_050503_fix_addressable_type_for_pet_owners', 3),
(149, '2026_04_29_051031_populate_address_fields_from_pet_owners', 4),
(150, '2026_06_14_000001_add_additional_photos_to_pets_table', 5),
(151, '2026_06_26_172245_add_barangay_id_to_rabies_vaccination_reports_table', 6),
(152, '2026_06_26_180000_add_status_to_meat_establishments_table', 7),
(153, '2026_06_27_120000_add_barangay_id_to_rabies_vaccination_reports_table', 8),
(154, '2026_06_27_120001_add_rabies_confirmed_column_to_bite_rabies_reports_table', 9),
(155, '2026_06_27_120002_clean_up_bite_rabies_reports_columns', 10),
(156, '2026_06_27_120003_add_patient_last_name_to_bite_rabies_reports_table', 11),
(157, '2026_04_24_234500_drop_barangay_id_from_admins_table', 12),
(158, '2026_09_04_000001_change_users_role_to_string', 13),
(160, '2026_09_13_000001_update_adoption_applications_status_enum', 14),
(161, '2026_09_15_000001_update_pet_status_enum', 15),
(162, '2026_09_15_000002_update_missing_pets_reports_status_enum', 16),
(163, '2026_09_15_000003_drop_missing_pets_table', 17),
(164, '2026_09_15_000004_add_pet_id_index_to_missing_pets_reports_table', 18),
(165, '2026_09_15_000005_drop_is_missing_and_missing_since_from_pets_table', 19),
(166, '2026_09_06_142617_add_display_name_and_hierarchy_to_roles_table', 20),
(168, '2026_09_15_000001_create_pet_info_table_and_move_columns', 21),
(169, '2026_09_19_000001_refactor_bite_rabies_reports_and_create_patients', 22),
(170, '2026_09_19_000002_drop_user_id_from_rabies_reports', 23),
(171, '2026_09_19_000003_add_age_column_to_patients_table', 24),
(172, '2026_09_22_000001_refactor_inventory_tables', 25),
(173, '2026_09_22_000002_rename_vaccinations_to_vaccination_appointments', 26),
(174, '2026_09_22_000003_restructure_vaccination_reports_table', 26),
(175, '2026_09_22_000004_add_vaccination_report_id_to_inventory_movements', 27),
(176, '2026_09_22_000005_add_soft_deletes_to_pets_table', 27),
(177, '2026_09_22_000006_finish_vaccination_reports_restructure', 27),
(178, '2026_09_23_000001_drop_pet_color_from_vaccination_reports_table', 28),
(179, '2026_09_23_000002_refactor_rabies_reports_for_confirmed_dog_cat_cases', 29),
(180, '2026_09_23_000003_drop_exposure_type_and_category_from_rabies_reports', 30),
(181, '2026_09_23_000004_add_animal_name_to_rabies_reports_table', 31),
(182, '2026_09_23_000005_remove_wild_from_animal_status_enum', 32),
(183, '2026_09_25_000001_add_animal_gender_to_rabies_reports_table', 33),
(184, '2026_09_25_000002_backfill_animal_gender_in_rabies_reports', 34),
(185, '2026_04_28_130000_add_reporter_fields_to_missing_pets_reports', 35),
(186, '2026_04_28_130001_backfill_missing_pets_reporter_fields', 36),
(187, '2026_04_28_140000_add_photo_path_to_missing_pets_reports', 37),
(188, '2026_04_28_150000_change_location_barangay_to_barangay_id', 38),
(189, '2026_09_26_000001_add_rejection_reason_to_adoption_applications_table', 39),
(190, '2026_09_26_000001_add_adopted_to_adoption_applications_status', 40),
(191, '2026_09_27_000001_make_company_nullable_in_adoption_applications_table', 41),
(192, '2026_09_27_000002_add_marital_status_to_adoption_applications_table', 42),
(193, '2026_09_27_000003_rename_zoom_to_appointment_and_drop_obsolete_columns_in_adoption_applications_table', 43),
(194, '2026_09_29_000001_add_assigned_vet_to_vaccination_appointments_table', 44),
(195, '2026_09_29_000001_rename_estimated_age_to_pet_age_in_pet_info_table', 45),
(196, '2026_09_29_000002_add_cascade_delete_to_vaccination_reports', 46),
(197, '2026_09_29_000003_add_medical_history_fields_to_vaccination_appointments_table', 47),
(198, '2026_09_30_214045_add_vaccination_certificate_path_to_vaccination_appointments_table', 48),
(199, '2026_10_01_102508_add_pet_id_and_drop_metadata_from_vaccination_appointments_table', 49),
(200, '2026_10_05_190000_fix_invalid_pet_birthdates', 50),
(201, '2026_10_06_200000_change_vaccination_reports_pet_age_to_string', 51),
(202, '2026_10_06_200001_change_rabies_vaccination_reports_pet_age_to_string', 51),
(203, '2026_10_10_211655_add_vaccination_fields_to_vaccination_reports_table', 52),
(204, '2026_10_10_211752_drop_legacy_vaccination_columns_from_pets_table', 52),
(205, '2026_10_14_000001_create_spay_neuter_appointments_table', 53),
(206, '2026_10_14_000002_add_spay_neuter_appointment_id_to_spay_neuter_reports_table', 53),
(207, '2026_10_17_000001_add_eye_color_to_pet_info_table', 54),
(208, '2026_10_18_000001_add_found_pet_fields_to_missing_pets_reports_table', 55),
(209, '2026_10_18_140000_add_eye_color_to_missing_pets_reports_table', 56),
(210, '2026_10_23_221632_create_guest_report_tokens_table', 57),
(211, '2026_10_27_110000_add_mass_event_columns_to_appointment_tables', 58),
(212, '2026_10_27_110001_add_mass_event_columns_to_announcements_table', 58),
(213, '2026_10_28_115223_set_default_assigned_vet_to_maria_santos_on_vaccination_appointments', 59),
(214, '2026_10_28_000001_set_default_assigned_vet_spay_neuter_appointments', 60),
(215, '2026_10_29_000001_standardize_inventory_status_enum', 61),
(216, '2026_10_29_000002_add_quantity_deducted_to_vaccination_reports', 62),
(217, '2026_11_01_000001_add_reviewed_fields_to_adoption_applications_table', 63),
(218, '2026_11_02_000001_add_pet_name_to_missing_pets_reports_table', 63),
(219, '2026_11_02_000000_add_pet_photo_to_missing_pets_reports', 64),
(220, '2026_11_02_000001_add_species_to_missing_pets_reports_table', 65),
(221, '2026_11_02_000001_add_color_to_missing_pets_reports_table', 66),
(222, '2026_11_03_000001_add_notes_to_spay_neuter_appointments', 67),
(223, '2026_11_03_000002_add_notes_to_adoption_applications', 67),
(224, '2026_11_03_000003_add_notes_to_vaccination_appointments', 68),
(225, '2026_11_04_000001_add_previous_surgery_to_spay_neuter_appointments', 69);

-- --------------------------------------------------------

--
-- Table structure for table `missing_pets_photos`
--

CREATE TABLE `missing_pets_photos` (
  `photo_id` bigint(20) UNSIGNED NOT NULL,
  `report_id` bigint(20) UNSIGNED NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `photo_type` enum('main','body_marks','eye_color','collar_harness','other') NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `missing_pets_reports`
--

CREATE TABLE `missing_pets_reports` (
  `report_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pet_id` bigint(20) UNSIGNED DEFAULT NULL,
  `body_marks` text DEFAULT NULL,
  `collar_harness` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `last_seen_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location_description` text DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `status` enum('pending review','approved','rejected','resolved - reunited','resolved - shelter intake','closed - expired','closed - cancelled','closed - duplicate') NOT NULL DEFAULT 'pending review',
  `report_type` varchar(20) NOT NULL DEFAULT 'missing',
  `pet_name` varchar(255) DEFAULT NULL,
  `reported_by_name` varchar(255) DEFAULT NULL,
  `reporter_contact` varchar(255) DEFAULT NULL,
  `reporter_email` varchar(255) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `pet_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `estimated_age` varchar(255) DEFAULT NULL,
  `breed` varchar(255) DEFAULT NULL,
  `species` varchar(255) DEFAULT NULL,
  `fur_colors` varchar(255) DEFAULT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `eye_color_left` varchar(255) DEFAULT NULL,
  `eye_color_right` varchar(255) DEFAULT NULL,
  `eye_color_other` varchar(255) DEFAULT NULL,
  `eye_color` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `missing_pets_reports`
--

INSERT INTO `missing_pets_reports` (`report_id`, `user_id`, `pet_id`, `body_marks`, `collar_harness`, `gender`, `last_seen_at`, `barangay_id`, `location_description`, `emergency_contact`, `status`, `report_type`, `pet_name`, `reported_by_name`, `reporter_contact`, `reporter_email`, `photo_path`, `pet_photo`, `created_at`, `updated_at`, `estimated_age`, `breed`, `species`, `fur_colors`, `condition`, `eye_color_left`, `eye_color_right`, `eye_color_other`, `eye_color`, `color`) VALUES
(13, 101, 25, 'White patch on chest', 'Red collar with tag', NULL, '2026-09-26 04:52:30', 2, 'Near the local convenience store', '09171234567', 'approved', 'missing', NULL, NULL, '09174829103', NULL, NULL, NULL, '2026-06-01 00:10:00', '2026-09-25 16:19:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 102, 26, 'None', 'Pink rhinestone collar', NULL, '2026-09-26 04:52:41', 3, 'Near the subdivision gate', '09182345678', 'approved', 'missing', NULL, NULL, '09183057741', NULL, NULL, NULL, '2026-06-02 01:45:00', '2026-09-25 16:19:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 103, 27, 'Black spot on left ear', 'Blue nylon harness', NULL, '2026-10-07 07:03:11', 21, 'Near the public school', '09193456789', 'approved', 'missing', NULL, NULL, '09206194382', NULL, NULL, NULL, '2026-06-03 06:15:00', '2026-09-25 16:19:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 104, 28, 'None', 'No collar', NULL, '2026-09-26 04:52:55', 22, 'Inside residential compound', '09204567890', 'approved', 'missing', NULL, NULL, '09981248590', NULL, NULL, NULL, '2026-06-04 09:00:00', '2026-09-25 16:19:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 105, 29, 'Scar on right hind leg', 'Black tactical collar', NULL, '2026-09-26 04:53:05', 2, 'Near the barangay hall', '09215678901', 'approved', 'missing', NULL, NULL, '09087321049', NULL, NULL, NULL, '2026-06-04 23:30:00', '2026-09-25 16:19:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 106, 30, 'None', 'Yellow bell collar', NULL, '2026-10-07 07:03:15', 25, 'Near the basketball court', '09226789012', 'approved', 'missing', NULL, NULL, '09195512836', NULL, NULL, NULL, '2026-06-06 03:40:00', '2026-09-25 16:19:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 107, 31, 'None', 'Green collar', NULL, '2026-09-26 04:53:27', 31, 'Along the main road', '09237890123', 'approved', 'missing', NULL, NULL, '09278403165', NULL, NULL, NULL, '2026-06-07 05:15:00', '2026-09-25 16:19:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 108, 32, 'Brown paw pads', 'Purple harness', NULL, '2026-09-26 04:53:35', 71, 'Near the wet market', '09248901234', 'approved', 'missing', NULL, NULL, '09392086417', NULL, NULL, NULL, '2026-06-08 07:30:00', '2026-09-25 16:19:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 109, 33, 'None', 'Red collar', NULL, '2026-09-26 04:53:45', 15, 'Near the chapel', '09259012345', 'approved', 'missing', NULL, NULL, '09569137204', NULL, NULL, NULL, '2026-06-09 09:45:00', '2026-09-25 16:19:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 110, 34, 'None', 'No collar', NULL, '2026-10-03 04:12:28', 21, 'Near the open field', '09260123456', 'approved', 'missing', NULL, NULL, '09774628951', NULL, NULL, NULL, '2026-06-10 10:15:00', '2026-09-25 16:19:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, NULL, NULL, 'blue black', 'Red Collar with bells', NULL, '2026-11-02 06:13:10', 9, 'over ther ther', '09238121379', 'pending review', 'missing', NULL, 'Spooderman', '09238121379', 'keryuxo@gmail.com', 'missing-pets/zPMe2fsSNFdnKnQoudIAHQy6lyhDE99mgGUmdHcs.jpg', 'missing-pets/bRarjjEmE6v3dRSszLskOMGCP25leZMu2vNMTOrK.jpg', '2026-11-02 03:47:01', '2026-11-02 03:47:01', 'Adult', 'British Shorthair', 'Cat', NULL, NULL, NULL, NULL, NULL, 'Green', NULL),
(38, NULL, NULL, 'None', 'None', NULL, '2026-11-02 06:13:14', 7, 'Alert test location', '09994445555', 'pending review', 'missing', NULL, 'Alert Test', '09994445555', 'alert@example.com', NULL, NULL, '2026-11-02 03:49:08', '2026-11-02 03:49:08', 'Senior', 'Siamese', 'Cat', NULL, NULL, NULL, NULL, NULL, 'Green', NULL),
(39, NULL, NULL, 'red', 'Red Collar with bells', NULL, '2026-11-02 06:13:16', 9, 'der', '09238121379', 'pending review', 'missing', NULL, 'Spooderman', '09238121379', 'keryuxo@gmail.com', 'missing-pets/fiqgTILRt16sEpYT8TDuosFNCV9l9HTAnlbeYQ5B.jpg', 'missing-pets/DfmRaEGblxjdXaWHfUOIg9hAHKqPQaJYNRBfNG2x.jpg', '2026-11-02 03:50:05', '2026-11-02 03:50:05', 'Adult', 'British Shorthair', 'Cat', NULL, NULL, NULL, NULL, NULL, 'Green', NULL),
(47, NULL, NULL, 'She is red and white', 'White collar with yellow hearts', NULL, '2026-11-02 06:13:19', 9, 'over der', '09371273124', 'pending review', 'found', 'Silvia', 'Spooderman', '09371273124', 'keryuxo@gmail.com', NULL, 'missing-pets/HW9b7zqpPclas7IKqyeMusiIqwVgaRb0kOr4QDgP.jpg', '2026-11-02 05:45:04', '2026-11-02 05:45:04', 'Adult', 'Abyssinian', 'Cat', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `related_module` enum('announcement','stray_report','impound','adoption','bite_rabies_report','vaccination','clinical_action','meat_inspection','missing_pet','system_log') NOT NULL,
  `related_record_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `priority` varchar(255) DEFAULT 'normal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `title`, `message`, `related_module`, `related_record_id`, `is_read`, `priority`, `created_at`, `updated_at`) VALUES
(1, 2, 'New Adoption Application', 'A new adoption application was submitted by Keryu Amayushi Xo.', 'adoption', 6, 0, 'normal', '2026-11-01 16:05:09', '2026-11-01 16:05:09'),
(2, 9, 'New Adoption Application', 'A new adoption application was submitted by Keryu Amayushi Xo.', 'adoption', 6, 0, 'normal', '2026-11-01 16:05:09', '2026-11-01 16:05:09'),
(3, 2, 'New Missing Pet Report', 'A new missing pet report was submitted by Keryu Amayushi Xo.', 'stray_report', NULL, 0, 'normal', '2026-11-01 18:21:35', '2026-11-01 18:21:35'),
(4, 9, 'New Missing Pet Report', 'A new missing pet report was submitted by Keryu Amayushi Xo.', 'stray_report', NULL, 0, 'normal', '2026-11-01 18:21:35', '2026-11-01 18:21:35'),
(5, 2, 'New Missing Pet Report', 'A new missing pet report was submitted by Keryu Amayushi Xo.', 'stray_report', NULL, 0, 'normal', '2026-11-01 18:23:17', '2026-11-01 18:23:17'),
(6, 9, 'New Missing Pet Report', 'A new missing pet report was submitted by Keryu Amayushi Xo.', 'stray_report', NULL, 0, 'normal', '2026-11-01 18:23:17', '2026-11-01 18:23:17'),
(7, 2, 'New Missing Pet Report', 'A new missing pet report was submitted by Keryu Amayushi Xo.', 'stray_report', NULL, 0, 'normal', '2026-11-01 19:03:33', '2026-11-01 19:03:33'),
(8, 9, 'New Missing Pet Report', 'A new missing pet report was submitted by Keryu Amayushi Xo.', 'stray_report', NULL, 0, 'normal', '2026-11-01 19:03:33', '2026-11-01 19:03:33'),
(9, 1, 'New Announcement', 'A new announcement has been published.', 'announcement', 9, 0, 'normal', '2026-11-02 11:42:45', '2026-11-02 11:42:45'),
(10, 2, 'New Announcement', 'A new announcement has been published.', 'announcement', 9, 0, 'normal', '2026-11-02 11:42:45', '2026-11-02 11:42:45'),
(11, 9, 'New Announcement', 'A new announcement has been published.', 'announcement', 9, 0, 'normal', '2026-11-02 11:42:45', '2026-11-02 11:42:45'),
(12, 1, 'New Announcement', 'A new announcement has been published.', 'announcement', 10, 0, 'normal', '2026-11-02 11:48:13', '2026-11-02 11:48:13'),
(13, 2, 'New Announcement', 'A new announcement has been published.', 'announcement', 10, 0, 'normal', '2026-11-02 11:48:13', '2026-11-02 11:48:13'),
(14, 9, 'New Announcement', 'A new announcement has been published.', 'announcement', 10, 0, 'normal', '2026-11-02 11:48:13', '2026-11-02 11:48:13'),
(15, 1, 'New Announcement', 'A new announcement has been published.', 'announcement', 11, 0, 'normal', '2026-11-02 12:20:54', '2026-11-02 12:20:54'),
(16, 2, 'New Announcement', 'A new announcement has been published.', 'announcement', 11, 0, 'normal', '2026-11-02 12:20:54', '2026-11-02 12:20:54'),
(17, 9, 'New Announcement', 'A new announcement has been published.', 'announcement', 11, 0, 'normal', '2026-11-02 12:20:54', '2026-11-02 12:20:54'),
(18, 1, 'New Announcement', 'A new announcement has been published.', 'announcement', 12, 0, 'normal', '2026-11-02 12:22:59', '2026-11-02 12:22:59'),
(19, 2, 'New Announcement', 'A new announcement has been published.', 'announcement', 12, 0, 'normal', '2026-11-02 12:22:59', '2026-11-02 12:22:59'),
(20, 9, 'New Announcement', 'A new announcement has been published.', 'announcement', 12, 0, 'normal', '2026-11-02 12:22:59', '2026-11-02 12:22:59'),
(21, 2, 'New Missing Pet Report', 'A new missing pet report was submitted by Keryu Amayushi Xo.', 'stray_report', NULL, 0, 'normal', '2026-11-04 06:11:25', '2026-11-04 06:11:25'),
(22, 9, 'New Missing Pet Report', 'A new missing pet report was submitted by Keryu Amayushi Xo.', 'stray_report', NULL, 0, 'normal', '2026-11-04 06:11:25', '2026-11-04 06:11:25'),
(23, 2, 'New Adoption Application', 'A new adoption application was submitted by Keryu Amayushi Xo.', 'adoption', 7, 0, 'normal', '2026-11-04 06:26:04', '2026-11-04 06:26:04'),
(24, 9, 'New Adoption Application', 'A new adoption application was submitted by Keryu Amayushi Xo.', 'adoption', 7, 0, 'normal', '2026-11-04 06:26:04', '2026-11-04 06:26:04');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('clinic','hospital','bite_center') NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `official_email` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `type`, `name`, `contact_user_id`, `contact_number`, `official_email`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'clinic', 'Happy Paws Veterinary Clinic', NULL, '091988877710', 'clinic@vetmis.gov', 1, '2026-04-28 19:15:35', '2026-04-28 19:15:35'),
(2, 'hospital', 'City Pet Hospital', NULL, '091988877711', 'hospital@vetmis.gov', 1, '2026-04-28 19:15:35', '2026-04-28 19:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `pet_id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pet_name` varchar(255) NOT NULL,
  `species` varchar(255) NOT NULL,
  `breed` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `pet_image` varchar(255) DEFAULT NULL,
  `body_mark_image` varchar(255) DEFAULT NULL,
  `additional_photos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`additional_photos`)),
  `body_mark_details` text DEFAULT NULL,
  `source_module` varchar(50) DEFAULT NULL,
  `source_module_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `consolidated_at` timestamp NULL DEFAULT NULL,
  `pet_status` enum('owned','missing','for adoption','in shelter/intake','adopted','deceased') NOT NULL DEFAULT 'owned',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`pet_id`, `owner_id`, `pet_name`, `species`, `breed`, `gender`, `birthdate`, `pet_image`, `body_mark_image`, `additional_photos`, `body_mark_details`, `source_module`, `source_module_id`, `is_approved`, `consolidated_at`, `pet_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Acacia', 'Dog', 'Labrador Retriever', 'male', '2025-11-27', 'images/adoption pets/acacia.jpg', NULL, NULL, NULL, 'adoption_pets', NULL, 1, NULL, 'for adoption', '2026-04-28 19:15:38', '2026-04-28 19:15:38', NULL),
(2, NULL, 'Carla', 'Dog', 'German Shepherd', 'female', '2022-06-11', 'images/adoption pets/carla.jpg', NULL, NULL, NULL, 'adoption_pets', NULL, 1, NULL, 'for adoption', '2026-04-28 19:15:38', '2026-04-28 19:15:38', NULL),
(3, NULL, 'Chance', 'Dog', 'Corgi', 'male', '2024-05-15', 'images/adoption pets/chance.jpg', NULL, NULL, NULL, 'adoption_pets', NULL, 1, NULL, 'for adoption', '2026-04-28 19:15:38', '2026-04-28 19:15:38', NULL),
(4, NULL, 'Fajita', 'Dog', 'Pomeranian', 'female', '2021-03-14', 'images/adoption pets/fajita.jpg', NULL, NULL, NULL, 'adoption_pets', NULL, 1, NULL, 'for adoption', '2026-04-28 19:15:38', '2026-04-28 19:15:38', NULL),
(5, NULL, 'Gabriela', 'Dog', 'Siberian Husky', 'female', '2023-12-01', 'images/adoption pets/gabriela.jpg', NULL, NULL, NULL, 'adoption_pets', NULL, 1, NULL, 'for adoption', '2026-04-28 19:15:38', '2026-04-28 19:15:38', NULL),
(6, NULL, 'Gilly', 'Dog', 'Beagle', 'female', '2026-03-23', 'images/adoption pets/gilly.jpg', NULL, NULL, NULL, 'adoption_pets', NULL, 1, NULL, 'for adoption', '2026-04-28 19:15:38', '2026-04-28 19:15:38', NULL),
(7, NULL, 'Jas', 'Dog', 'Aspin', 'female', '2022-01-15', 'images/adoption pets/jas.jpg', NULL, NULL, NULL, 'adoption_pets', NULL, 1, NULL, 'for adoption', '2026-04-28 19:15:38', '2026-04-28 19:15:38', NULL),
(8, NULL, 'Josiah', 'Dog', 'Golden Retriever', 'male', '2025-04-21', 'images/adoption pets/josiah.jpg', NULL, NULL, NULL, 'adoption_pets', NULL, 1, NULL, 'for adoption', '2026-04-28 19:15:38', '2026-04-28 19:15:38', NULL),
(9, NULL, 'Julia', 'Cat', 'Puspin', 'female', '2024-01-22', 'images/adoption pets/julia.jpg', NULL, NULL, NULL, 'adoption_pets', NULL, 1, NULL, 'for adoption', '2026-04-28 19:15:38', '2026-04-28 19:15:38', NULL),
(10, NULL, 'Lexus', 'Cat', 'Puspin', 'male', '2021-11-03', 'images/adoption pets/lexus.jpeg', NULL, NULL, NULL, 'adoption_pets', NULL, 1, NULL, 'for adoption', '2026-04-28 19:15:38', '2026-04-28 19:15:38', NULL),
(11, NULL, 'Raylie', 'Cat', 'Persian', 'male', '2023-06-05', 'images/adoption pets/rayllie.jpg', NULL, NULL, NULL, 'adoption_pets', NULL, 1, NULL, 'for adoption', '2026-04-28 19:15:38', '2026-04-28 19:15:38', NULL),
(12, NULL, 'Sky', 'Cat', 'Siamese', 'male', '2026-05-19', 'images/adoption pets/sky.jpg', NULL, NULL, NULL, 'adoption_pets', NULL, 1, NULL, 'for adoption', '2026-04-28 19:15:38', '2026-04-28 19:15:38', NULL),
(13, NULL, 'Snow White', 'Cat', 'Scottish Fold', 'female', '2022-10-10', 'images/adoption pets/snow white.jpg', NULL, NULL, NULL, 'adoption_pets', NULL, 1, NULL, 'for adoption', '2026-04-28 19:15:38', '2026-04-28 19:15:38', NULL),
(14, NULL, 'Tiki', 'Cat', 'Ragdoll', 'female', '2024-10-31', 'images/adoption pets/tiki.jpg', NULL, NULL, NULL, 'adoption_pets', NULL, 1, NULL, 'for adoption', '2026-04-28 19:15:38', '2026-04-28 19:15:38', NULL),
(15, NULL, 'Tiktok', 'Cat', 'Russian Blue', 'male', '2025-08-12', 'images/adoption pets/tiktok.jpg', NULL, NULL, NULL, 'adoption_pets', NULL, 1, NULL, 'for adoption', '2026-04-28 19:15:38', '2026-04-28 19:15:38', NULL),
(19, 6, 'Oreo', 'cat', 'Puspin', 'male', '2024-03-30', 'images/pets/1780543506_448172743_760830396122615_3111118159836858503_n.jpg', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'owned', NULL, NULL, NULL),
(20, 8, 'Apol De App', 'cat', 'Puspin', 'female', '2022-08-25', 'images/pets/1781438471_photo_6239983699336741701_y.jpg', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'owned', NULL, NULL, NULL),
(21, 8, 'Whitey', 'cat', 'Puspin', 'female', '2025-02-09', 'images/pets/1781438554_450642545_1597525477475073_3687967288804725992_n.jpg', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'owned', NULL, NULL, NULL),
(22, 8, 'Cream', 'cat', 'Puspin', 'male', '2021-05-22', 'images/pets/1781494349_448172743_760830396122615_3111118159836858503_n.jpg', 'images/pets/1781494349_body_462568017_1976595086178161_1277323562437109126_n.jpg', '\"{\\\"front\\\":\\\"images\\\\\\/pets\\\\\\/22\\\\\\/front_1781494349_6a2f724d28684.jpg\\\",\\\"side\\\":\\\"images\\\\\\/pets\\\\\\/22\\\\\\/side_1781494349_6a2f724d28f9c.jpg\\\",\\\"top\\\":\\\"images\\\\\\/pets\\\\\\/22\\\\\\/top_1781494349_6a2f724d298d7.jpg\\\"}\"', 'Oroeo', NULL, NULL, 0, NULL, 'owned', NULL, NULL, NULL),
(23, 6, 'Brownie', 'dog', 'Bulldog', 'male', '2023-09-12', NULL, 'images/pets/1788312881_body_448172743_760830396122615_3111118159836858503_n.jpg', '\"[]\"', 'bigotilyo', NULL, NULL, 0, NULL, 'owned', NULL, NULL, NULL),
(24, 6, 'Swoosh', 'cat', 'Puspin', 'female', '2024-12-14', 'images/pets/1788531521_photo_6239983699336741701_y.jpg', 'images/pets/1788531521_body_448172743_760830396122615_3111118159836858503_n.jpg', '\"[]\"', 'awawa', NULL, NULL, 0, NULL, 'owned', NULL, NULL, NULL),
(25, NULL, 'Max', 'Dog', 'Golden Retriever', 'Male', '2022-04-02', 'max.jpg', 'mark1.jpg', '[\"add1.jpg\"]', 'White patch on chest', 'web_portal', 1, 1, '0000-00-00 00:00:00', 'owned', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(26, NULL, 'Adam', 'Dog', 'Aspin', 'Male', '2025-10-05', 'adam.jpg', NULL, '[\"add2.jpg\"]', NULL, 'web_portal', 2, 1, '0000-00-00 00:00:00', 'missing', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(27, NULL, 'Andie', 'Dog', 'Aspin', 'Male', '2021-09-19', 'andie.jpg', 'mark3.jpg', NULL, 'Black spot on left ear', 'mobile_app', 3, 1, '0000-00-00 00:00:00', 'missing', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(28, NULL, 'Gali', 'Cat', 'Puspin', 'Female', '2023-07-29', 'gali.jpg', NULL, NULL, NULL, 'web_portal', 4, 1, '0000-00-00 00:00:00', 'missing', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(29, 0, 'Ashton', 'Dog', 'German Shepherd', 'Male', '2024-07-04', 'ashton.jpg', 'mark5.jpg', '[\"add5.jpg\"]', 'Scar on right hind leg', 'mobile_app', 5, 1, '0000-00-00 00:00:00', 'missing', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(30, 106, 'Indigo', 'Cat', 'Persian', 'Male', '2022-11-30', 'indigo.jpg', NULL, NULL, NULL, 'web_portal', 6, 1, '0000-00-00 00:00:00', 'missing', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(31, 107, 'Cookie', 'Dog', 'Labrador', 'Female', '2025-06-18', 'cookie.jpg', NULL, NULL, NULL, 'mobile_app', 7, 1, '0000-00-00 00:00:00', 'missing', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(32, 108, 'Fe', 'Cat', 'Poodle', 'Female', '2021-12-28', 'fe.jpg', 'mark8.jpg', NULL, 'Brown paw pads', 'web_portal', 8, 1, '0000-00-00 00:00:00', 'missing', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(33, 109, 'Lottie', 'Cat', 'Siamese', 'Female', '2023-04-17', 'lottie.jpg', NULL, '[\"add9.jpg\"]', NULL, 'mobile_app', 9, 1, '0000-00-00 00:00:00', 'missing', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(34, 110, 'Walter', 'Dog', 'Aspin', 'Male', '2024-09-08', 'walter.jpg', NULL, NULL, NULL, 'web_portal', 10, 1, '0000-00-00 00:00:00', 'missing', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(35, 6, 'Lemon', 'cat', 'Puspin', 'male', '2023-06-11', 'images/pets/1791696575_photo_6239983699336741732_y.jpg', NULL, '\"{\\\"front\\\":\\\"images\\\\\\/pets\\\\\\/35\\\\\\/front_1791696576_6acb1ec00f0c0.jpg\\\",\\\"side\\\":\\\"images\\\\\\/pets\\\\\\/35\\\\\\/side_1791696576_6acb1ec00f3bb.jpg\\\",\\\"top\\\":\\\"images\\\\\\/pets\\\\\\/35\\\\\\/top_1791696576_6acb1ec00f5c0.jpg\\\"}\"', NULL, NULL, NULL, 0, NULL, 'owned', NULL, NULL, NULL),
(69, 13, 'Oreo', 'cat', 'Balinese', 'male', '2023-06-20', 'images/pets/1792476017_448172743_760830396122615_3111118159836858503_n.jpg', NULL, '{\"front\":\"images\\/pets\\/69\\/front_1792476017_6ad70371768e8.jpg\",\"side\":\"images\\/pets\\/69\\/side_1792476017_6ad7037176b6a.jpg\",\"top\":\"images\\/pets\\/69\\/top_1792476017_6ad7037176d56.jpg\"}', NULL, NULL, NULL, 0, NULL, 'owned', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pet_info`
--

CREATE TABLE `pet_info` (
  `pet_id` bigint(20) UNSIGNED NOT NULL,
  `is_neutered` varchar(255) DEFAULT NULL,
  `is_crossbreed` varchar(255) DEFAULT NULL,
  `eye_color` varchar(255) DEFAULT NULL,
  `pet_age` varchar(255) DEFAULT NULL,
  `pet_weight` varchar(255) DEFAULT NULL,
  `training` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`training`)),
  `insurance` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`insurance`)),
  `behavior` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`behavior`)),
  `likes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`likes`)),
  `dislikes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`dislikes`)),
  `diet` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`diet`)),
  `allergy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`allergy`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pet_info`
--

INSERT INTO `pet_info` (`pet_id`, `is_neutered`, `is_crossbreed`, `eye_color`, `pet_age`, `pet_weight`, `training`, `insurance`, `behavior`, `likes`, `dislikes`, `diet`, `allergy`, `created_at`, `updated_at`) VALUES
(1, 'Yes', 'Yes', 'Amber/Yellow', '10 months', '10 kg', '[\"Obedience trained\"]', '[\"Insured\"]', '[\"Protective\",\"Playful\",\"Energetic\"]', '[\"Playing fetch\",\"Sunbathing\"]', '[\"Vacuum cleaners\"]', '[\"Carrots\",\"Kibble\",\"Chicken\"]', '[\"Tailored treats preferred\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(2, 'No', 'Yes', 'Amber/Yellow', '4 years 3 months', '21 kg', '[\"Obedience trained\",\"Potty trained\"]', '[\"Uninsured\"]', '[\"Social\",\"Shy\"]', '[\"Cuddle\",\"Playing fetch\"]', '[\"Car rides\"]', '[\"Beef\"]', '[\"Beef\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(3, 'No', 'Yes', 'Brown', '2 years 4 months', '20 kg', '[\"Potty trained\"]', '[\"Insured\"]', '[\"Social\",\"Reactive\",\"Affectionate\"]', '[\"Chew toys\",\"Playing fetch\",\"Cuddle\",\"Sunbathing\"]', '[\"Baths\",\"Vacuum cleaners\"]', '[\"Turkey\"]', '[\"Beef\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(4, 'No', 'No', 'Green', '5 years 6 months', '14 kg', '[\"Obedience trained\",\"Potty trained\"]', '[\"Insured\"]', '[\"Shy\",\"Protective\",\"Affectionate\"]', '[\"Sunbathing\",\"Long walks\"]', '[\"Vet visits\",\"Loud noises\\/Fireworks\"]', '[\"Eggs\"]', '[\"Beef\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(5, 'Yes', 'Yes', 'Brown', '2 years 10 months', '13 kg', '[\"Potty trained\",\"Obedience trained\"]', '[\"Insured\"]', '[\"Reactive\",\"Affectionate\",\"Gentle\"]', '[\"Sunbathing\",\"Chew toys\",\"Gentle patting\"]', '[\"Vacuum cleaners\"]', '[\"Carrots\",\"Eggs\",\"Beef\"]', '[\"Tailored treats preferred\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(6, 'No', 'No', 'Amber/Yelloww', '6 months', '10 kg', '[\"Potty trained\"]', '[\"Insured\"]', '[\"Playful\"]', '[\"Gentle patting\",\"Belly rubs\"]', '[\"Car rides\",\"Loud noises\\/Fireworks\",\"Baths\"]', '[\"Turkey\",\"Carrots\"]', '[\"Grain\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(7, 'No', 'Yes', 'Amber/Yellow', '4 years 8 months', '24 kg', '[\"Potty trained\",\"Obedience trained\"]', '[\"Uninsured\"]', '[\"Shy\",\"Gentle\"]', '[\"Treats\",\"Sunbathing\"]', '[\"Loud noises\\/Fireworks\"]', '[\"Eggs\"]', '[\"Beef\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(8, 'Yes', 'Yes', 'Brown', '1 year 5 months', '8 kg', '[\"Potty trained\"]', '[\"Uninsured\"]', '[\"Playful\"]', '[\"Treats\",\"Chew toys\",\"Playing fetch\"]', '[\"Loud noises\\/Fireworks\"]', '[\"Kibble\"]', '[\"Tailored treats preferred\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(9, 'No', 'Yes', 'Green', '2 years 8 months', '7 kg', '[\"Potty trained\"]', '[\"Insured\"]', '[\"Protective\",\"Energetic\"]', '[\"Long walks\",\"Cuddle\"]', '[\"Car rides\",\"Thunderstorms\"]', '[\"Carrots\",\"Turkey\"]', '[\"None\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(10, 'Yes', 'Yes', 'Green', '4 years 11 months', '13 kg', '[\"Obedience trained\"]', '[\"Insured\"]', '[\"Playful\"]', '[\"Playing fetch\",\"Chew toys\",\"Sunbathing\",\"Cuddle\"]', '[\"Baths\",\"Loud noises\\/Fireworks\"]', '[\"Beef\"]', '[\"Tailored treats preferred\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(11, 'No', 'Yes', 'Brown', '3 years 4 months', '7 kg', '[\"Obedience trained\",\"Potty trained\"]', '[\"Uninsured\"]', '[\"Playful\"]', '[\"Belly rubs\",\"Gentle patting\"]', '[\"Car rides\",\"Vet visits\"]', '[\"Kibble\",\"Eggs\",\"Carrots\"]', '[\"Grain\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(12, 'No', 'Yes', 'Brown', '4 months', '9 kg', '[\"Potty trained\"]', '[\"Insured\"]', '[\"Shy\",\"Social\"]', '[\"Long walks\",\"Belly rubs\",\"Playing fetch\"]', '[\"Loud noises\\/Fireworks\",\"Baths\"]', '[\"Eggs\"]', '[\"Dairy\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(13, 'Yes', 'Yes', 'Amber/Yellow', '3 years 11 months', '8 kg', '[\"Potty trained\",\"Obedience trained\"]', '[\"Insured\"]', '[\"Friendly\",\"Shy\"]', '[\"Playing fetch\",\"Long walks\",\"Gentle patting\"]', '[\"Thunderstorms\",\"Car rides\"]', '[\"Eggs\",\"Carrots\",\"Turkey\"]', '[\"Chicken\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(14, 'Yes', 'No', 'Amber/Yellow', '1 year 11 months', '4 kg', '[\"Potty trained\"]', '[\"Insured\"]', '[\"Anxious\"]', '[\"Gentle patting\",\"Playing fetch\",\"Treats\"]', '[\"Vacuum cleaners\"]', '[\"Carrots\"]', '[\"None\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(15, 'Yes', 'No', 'Green', '1 year 1 month', '21 kg', '[\"Obedience trained\"]', '[\"Insured\"]', '[\"Anxious\",\"Protective\"]', '[\"Treats\",\"Chew toys\",\"Cuddle\"]', '[\"Thunderstorms\",\"Vacuum cleaners\",\"Vet visits\"]', '[\"Chicken\",\"Beef\"]', '[\"Grain\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(19, 'No', 'Yes', 'Green', '2 years 6 months', '17 kg', '[\"Obedience trained\"]', '[\"Insured\"]', '[\"Social\",\"Shy\",\"Reactive\"]', '[\"Long walks\",\"Gentle patting\"]', '[\"Vacuum cleaners\",\"Car rides\"]', '[\"Eggs\",\"Beef\",\"Kibble\"]', '[\"Tailored treats preferred\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(20, 'No', 'Yes', 'Amber/Yellow', '4 years 1 month', '11 kg', '[\"Obedience trained\"]', '[\"Insured\"]', '[\"Social\",\"Affectionate\"]', '[\"Cuddle\",\"Chew toys\",\"Sunbathing\",\"Gentle patting\"]', '[\"Car rides\",\"Thunderstorms\",\"Baths\"]', '[\"Eggs\"]', '[\"Grain\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(21, 'No', 'Yes', 'Brown', '1 year 7 months', '13 kg', '[\"Potty trained\"]', '[\"Insured\"]', '[\"Gentle\",\"Protective\",\"Energetic\"]', '[\"Playing fetch\",\"Sunbathing\",\"Belly rubs\",\"Chew toys\"]', '[\"Baths\",\"Thunderstorms\",\"Vacuum cleaners\"]', '[\"Chicken\",\"Kibble\"]', '[\"Beef\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(22, 'No', 'Yes', 'Blue', '5 years 4 months', '9 kg', '[\"Obedience trained\"]', '[\"Uninsured\"]', '[\"Energetic\",\"Shy\",\"Affectionate\"]', '[\"Gentle patting\",\"Long walks\"]', '[\"Vacuum cleaners\"]', '[\"Beef\",\"Turkey\",\"Chicken\"]', '[\"Beef\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(23, 'Yes', 'Yes', 'Brown', '3 years', '4 kg', '[\"Obedience trained\",\"Potty trained\"]', '[\"Uninsured\"]', '[\"Social\",\"Affectionate\"]', '[\"Playing fetch\",\"Cuddle\"]', '[\"Car rides\"]', '[\"Beef\",\"Kibble\"]', '[\"Beef\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(24, 'No', 'No', 'Blue', '1 year 9 months', '13 kg', '[\"Obedience trained\"]', '[\"Uninsured\"]', '[\"Anxious\"]', '[\"Playing fetch\",\"Sunbathing\",\"Treats\"]', '[\"Thunderstorms\",\"Vet visits\"]', '[\"Carrots\",\"Eggs\"]', '[\"None\"]', '2026-09-15 14:34:54', '2026-10-05 20:07:09'),
(25, 'Yes', 'Yes', 'Brown', '4 years 6 months', '12 kg', '[\"Obedience trained\",\"Potty trained\"]', '[\"Insured\"]', '[\"Playful\",\"Social\",\"Energetic\"]', '[\"Playing fetch\",\"Sunbathing\",\"Cuddle\"]', '[\"Baths\",\"Loud noises\\/Fireworks\"]', '[\"Kibble\",\"Chicken\",\"Carrots\"]', '[\"Grain\"]', '2026-10-03 03:53:07', '2026-10-05 20:07:09'),
(26, 'No', 'No', 'Dark Brown', '1 year', '9 kg', '[\"Potty trained\"]', '[\"Uninsured\"]', '[\"Shy\",\"Gentle\",\"Affectionate\"]', '[\"Belly rubs\",\"Gentle patting\",\"Treats\"]', '[\"Car rides\",\"Vet visits\"]', '[\"Beef\",\"Eggs\"]', '[\"Chicken\"]', '2026-10-03 03:53:07', '2026-10-05 20:07:09'),
(27, 'Yes', 'Yes', 'Brown', '5 years', '22 kg', '[\"Obedience trained\",\"Potty trained\"]', '[\"Insured\"]', '[\"Social\",\"Protective\",\"Playful\"]', '[\"Long walks\",\"Chew toys\",\"Playing fetch\"]', '[\"Thunderstorms\",\"Vacuum cleaners\"]', '[\"Beef\",\"Turkey\",\"Kibble\"]', '[\"None\"]', '2026-10-03 03:53:07', '2026-10-05 20:07:09'),
(28, 'Yes', 'No', 'Green', '3 years 2 months', '5 kg', '[\"Obedience trained\"]', '[\"Insured\"]', '[\"Curious\",\"Active\",\"Vocal\"]', '[\"Window perches\",\"Interactive toys\",\"Cuddle\"]', '[\"Baths\",\"Loud noises\\/Fireworks\"]', '[\"Fish\",\"Kibble\"]', '[\"Dairy\"]', '2026-10-03 03:53:07', '2026-10-05 20:07:09'),
(29, 'No', 'Yes', 'Amber', '2 years 3 months', '18 kg', '[\"Potty trained\",\"Obedience trained\"]', '[\"Uninsured\"]', '[\"Energetic\",\"Protective\",\"Loyal\"]', '[\"Running\",\"Playing fetch\",\"Chew toys\"]', '[\"Car rides\",\"Thunderstorms\"]', '[\"Chicken\",\"Beef\",\"Carrots\"]', '[\"Grain\"]', '2026-10-03 03:53:07', '2026-10-05 20:07:09'),
(30, 'Yes', 'Yes', 'Blue', '3 years 10 months', '4 kg', '[\"Potty trained\"]', '[\"Insured\"]', '[\"Playful\",\"Social\",\"Affectionate\"]', '[\"Feather toys\",\"Treats\",\"Sunbathing\"]', '[\"Vacuum cleaners\",\"Being alone\"]', '[\"Kibble\",\"Eggs\"]', '[\"Beef\"]', '2026-10-03 03:53:07', '2026-10-05 20:07:09'),
(31, 'No', 'No', 'Brown', '1 year 3 months', '26 kg', '[\"Obedience trained\",\"Potty trained\"]', '[\"Insured\"]', '[\"Gentle\",\"Calm\",\"Protective\"]', '[\"Cuddle\",\"Long walks\",\"Playing fetch\"]', '[\"Vet visits\",\"Loud noises\\/Fireworks\"]', '[\"Beef\",\"Kibble\",\"Turkey\"]', '[\"Chicken\"]', '2026-10-03 03:53:07', '2026-10-05 20:07:09'),
(32, 'Yes', 'Yes', 'Hazel', '4 years 9 months', '11 kg', '[\"Potty trained\",\"Obedience trained\"]', '[\"Uninsured\"]', '[\"Energetic\",\"Playful\",\"Friendly\"]', '[\"Running\",\"Chew toys\",\"Playing fetch\"]', '[\"Baths\",\"Thunderstorms\"]', '[\"Chicken\",\"Kibble\",\"Carrots\"]', '[\"None\"]', '2026-10-03 03:53:07', '2026-10-05 20:07:09'),
(33, 'Yes', 'No', 'Blue', '3 years 5 months', '6 kg', '[\"Obedience trained\"]', '[\"Insured\"]', '[\"Independent\",\"Curious\",\"Vocal\"]', '[\"Window perches\",\"Treats\",\"Gentle patting\"]', '[\"Car rides\",\"Baths\"]', '[\"Fish\",\"Kibble\",\"Eggs\"]', '[\"Grain\"]', '2026-10-03 03:53:07', '2026-10-05 20:07:09'),
(34, 'No', 'Yes', 'Green', '2 years', '8 kg', '[\"Potty trained\"]', '[\"Uninsured\"]', '[\"Playful\",\"Social\",\"Shy\"]', '[\"Interactive toys\",\"Cuddle\",\"Playing fetch\"]', '[\"Loud noises\\/Fireworks\",\"Vet visits\"]', '[\"Kibble\",\"Chicken\",\"Turkey\"]', '[\"Tailored treats preferred\"]', '2026-10-03 03:53:07', '2026-10-05 20:07:09'),
(35, 'yes', 'no', 'Amber', '3 years 4 months', '12 kg', '\"[\\\"Potty-trained\\\"]\"', '\"[\\\"Insured\\\"]\"', '\"[\\\"Curious\\\",\\\"Play-biter\\\",\\\"Affectionate\\\",\\\"Gentle\\\"]\"', '\"[\\\"Playing with yarn\\\",\\\"Sunbathing by the window\\\",\\\"Chasing mice toys\\\",\\\"Feather wands\\\"]\"', '\"[\\\"Vacuum cleaners\\\",\\\"Wearing clothes\\\",\\\"Being ignored\\\"]\"', '\"[\\\"Turkey\\\",\\\"Pork\\\",\\\"Venison\\\",\\\"Apple\\\",\\\"Blueberry\\\"]\"', '\"[\\\"Tailored treats preferred\\\"]\"', '2026-10-11 05:29:36', '2026-10-11 05:29:36'),
(69, 'no', 'no', NULL, '3 years 4 months', '25 kg', '\"[\\\"Obedience-trained\\\",\\\"Potty-trained\\\"]\"', '\"[\\\"Insured\\\"]\"', '\"[\\\"Curious\\\",\\\"Social\\\",\\\"Shy\\\"]\"', '\"[\\\"Sunbathing by the window\\\",\\\"Feather wands\\\"]\"', '\"[\\\"Vacuum cleaners\\\",\\\"Wearing clothes\\\"]\"', '\"[\\\"Carrots\\\"]\"', '\"[\\\"Lamb\\\"]\"', '2026-10-20 06:00:17', '2026-10-20 06:00:17');

-- --------------------------------------------------------

--
-- Table structure for table `pet_owners`
--

CREATE TABLE `pet_owners` (
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) NOT NULL,
  `alternate_phone_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pet_owners`
--

INSERT INTO `pet_owners` (`owner_id`, `address_id`, `user_id`, `first_name`, `last_name`, `middle_name`, `suffix`, `phone_number`, `alternate_phone_number`, `created_at`, `updated_at`, `date_of_birth`) VALUES
(6, 6, 20, 'Kevin', 'Saw', NULL, NULL, '946 159 8684', '124 124 1245', '2026-06-04 03:23:07', '2026-06-04 03:23:07', '2004-01-03'),
(13, 19, 27, 'Chelsy', 'Alba', NULL, NULL, '946 158 2783', NULL, '2026-10-20 05:52:36', '2026-10-20 05:52:36', '2002-02-06'),
(16, 22, 30, 'Keryu', 'Xo', 'Amayushi', NULL, '092 313 1231', '312 312 3214', '2026-11-01 14:48:58', '2026-11-01 14:48:58', '2004-03-04'),
(17, 23, 31, 'Aries', 'Llesis', 'Bawar', NULL, '898 139 8131', NULL, '2026-11-03 04:06:50', '2026-11-03 04:06:50', '2007-02-10');

-- --------------------------------------------------------

--
-- Table structure for table `pet_traits`
--

CREATE TABLE `pet_traits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pet_id` bigint(20) UNSIGNED NOT NULL,
  `trait_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pet_traits`
--

INSERT INTO `pet_traits` (`id`, `pet_id`, `trait_id`, `created_at`, `updated_at`) VALUES
(1, 1, 6, '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(2, 1, 11, '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(3, 1, 15, '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(4, 2, 5, '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(5, 2, 8, '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(6, 2, 14, '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(7, 3, 3, '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(8, 3, 7, '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(9, 4, 3, '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(10, 4, 12, '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(11, 5, 1, '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(12, 5, 13, '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(13, 6, 7, '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(14, 6, 11, '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(15, 7, 3, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(16, 7, 9, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(17, 8, 1, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(18, 8, 3, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(19, 9, 5, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(20, 9, 14, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(21, 10, 6, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(22, 10, 7, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(23, 10, 12, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(24, 11, 1, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(25, 11, 10, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(26, 12, 5, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(27, 12, 11, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(28, 13, 8, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(29, 13, 11, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(30, 14, 5, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(31, 14, 12, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(32, 14, 15, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(33, 15, 4, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(34, 15, 7, '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(35, 15, 11, '2026-04-28 19:15:39', '2026-04-28 19:15:39');

-- --------------------------------------------------------

--
-- Table structure for table `rabies_reports`
--

CREATE TABLE `rabies_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_number` varchar(50) NOT NULL,
  `barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `exact_location` varchar(255) DEFAULT NULL,
  `incident_date` date NOT NULL,
  `animal_name` varchar(255) DEFAULT NULL,
  `animal_type` enum('dog','cat') NOT NULL,
  `animal_gender` enum('male','female') DEFAULT NULL,
  `animal_status` enum('stray','owned') NOT NULL DEFAULT 'stray',
  `vaccination_status` enum('vaccinated','unvaccinated') NOT NULL,
  `animal_owner_name` varchar(255) DEFAULT NULL,
  `animal_owner_contact` varchar(11) DEFAULT NULL,
  `date_reported` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `action_taken` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rabies_reports`
--

INSERT INTO `rabies_reports` (`id`, `report_number`, `barangay_id`, `exact_location`, `incident_date`, `animal_name`, `animal_type`, `animal_gender`, `animal_status`, `vaccination_status`, `animal_owner_name`, `animal_owner_contact`, `date_reported`, `notes`, `action_taken`, `created_at`, `updated_at`) VALUES
(1, 'RAB-2026-0001', 5, 'residential street, Barangay 5', '2026-06-28', NULL, 'dog', NULL, 'stray', 'unvaccinated', NULL, NULL, '2026-06-28', 'Case documented for surveillance and follow-up.', 'Incident recorded for monitoring and barangay follow-up.', '2026-06-28 02:36:00', '2026-09-19 13:30:34'),
(2, 'RAB-2026-0002', 10, 'residential subdivision, Barangay 10', '2026-01-11', 'Bella', 'dog', 'female', 'owned', 'unvaccinated', 'Teresa Mendoza', '09443670896', '2026-01-11', 'Rabies exposure confirmed and case placed under monitoring.', 'Patient referred for rabies post-exposure management and case monitoring.', '2026-01-11 02:40:00', '2026-09-19 13:30:34'),
(3, 'RAB-2026-0003', 7, 'public market area, Barangay 7', '2026-03-02', 'Milo', 'cat', 'male', 'owned', 'unvaccinated', 'Teresa Mendoza', '09616507321', '2026-03-02', 'Animal observation and patient follow-up advised.', 'Animal observation initiated and patient advised to return for follow-up.', '2026-03-02 02:51:00', '2026-09-19 13:30:34'),
(4, 'RAB-2026-0004', 1, 'near barangay hall, Barangay 1', '2026-05-15', NULL, 'cat', NULL, 'stray', 'unvaccinated', NULL, NULL, '2026-05-16', 'Rabies exposure confirmed and case placed under monitoring.', 'Patient referred for rabies post-exposure management and case monitoring.', '2026-05-16 02:12:00', '2026-09-19 13:30:34'),
(5, 'RAB-2026-0005', 4, 'public market area, Barangay 4', '2026-02-01', 'Charlie', 'cat', 'male', 'owned', 'unvaccinated', 'Elena Reyes', '09594188992', '2026-02-03', 'Exposure assessed; animal monitoring recommended.', 'Incident recorded for monitoring and barangay follow-up.', '2026-02-03 02:43:00', '2026-09-19 13:30:34'),
(6, 'RAB-2026-0006', 5, 'near elementary school, Barangay 5', '2026-08-29', 'Coco', 'dog', 'male', 'owned', 'unvaccinated', 'Elena Reyes', '09956539837', '2026-08-31', 'Rabies exposure confirmed and case placed under monitoring.', 'Patient referred for rabies post-exposure management and case monitoring.', '2026-08-31 02:42:00', '2026-09-19 13:30:34'),
(7, 'RAB-2026-0007', 6, 'roadside near tricycle terminal, Barangay 6', '2026-03-25', 'Rocky', 'cat', 'male', 'owned', 'unvaccinated', 'Mario Garcia', '09348053918', '2026-03-27', 'Exposure assessed; animal monitoring recommended.', 'Incident recorded for monitoring and barangay follow-up.', '2026-03-27 02:35:00', '2026-09-19 13:30:34'),
(8, 'RAB-2026-0008', 8, 'community basketball court, Barangay 8', '2026-05-25', 'Lucy', 'dog', 'female', 'owned', 'unvaccinated', 'Grace Flores', '09698411939', '2026-05-25', 'Case documented for surveillance and follow-up.', 'Incident recorded for monitoring and barangay follow-up.', '2026-05-25 02:52:00', '2026-09-19 13:30:34'),
(9, 'RAB-2026-0009', 7, 'near elementary school, Barangay 7', '2026-01-26', NULL, 'cat', NULL, 'stray', 'unvaccinated', NULL, NULL, '2026-01-27', 'Rabies exposure confirmed and case placed under monitoring.', 'Patient referred for rabies post-exposure management and case monitoring.', '2026-01-27 02:53:00', '2026-09-19 13:30:34'),
(10, 'RAB-2026-0010', 7, 'roadside near tricycle terminal, Barangay 7', '2026-03-25', 'Daisy', 'dog', 'female', 'owned', 'vaccinated', 'Elena Reyes', '09687953166', '2026-03-25', 'Animal observation and patient follow-up advised.', 'Case referred to health personnel for further assessment.', '2026-03-25 02:35:00', '2026-09-19 13:30:34'),
(11, 'RAB-2026-0011', 9, 'residential street, Barangay 9', '2026-03-08', NULL, 'dog', NULL, 'stray', 'unvaccinated', NULL, NULL, '2026-03-08', 'Rabies exposure confirmed and case placed under monitoring.', 'Patient referred for rabies post-exposure management and case monitoring.', '2026-03-08 02:45:00', '2026-09-19 13:30:34'),
(12, 'RAB-2026-0012', 3, 'community basketball court, Barangay 3', '2026-03-09', 'Molly', 'cat', 'female', 'owned', 'unvaccinated', 'Grace Flores', '09669468772', '2026-03-09', 'Case documented for surveillance and follow-up.', 'Incident recorded for monitoring and barangay follow-up.', '2026-03-09 02:38:00', '2026-09-19 13:30:34'),
(13, 'RAB-2026-0013', 1, 'residential street, Barangay 1', '2026-03-12', 'Bruno', 'dog', 'male', 'owned', 'unvaccinated', 'Cynthia Navarro', '09195793722', '2026-03-12', 'Animal observation and patient follow-up advised.', 'Case referred to health personnel for further assessment.', '2026-03-12 02:44:00', '2026-09-19 13:30:34'),
(14, 'RAB-2026-0014', 8, 'community basketball court, Barangay 8', '2026-01-25', 'Lola', 'dog', 'female', 'owned', 'unvaccinated', 'Mario Garcia', '09372077581', '2026-01-25', 'Rabies exposure confirmed and case placed under monitoring.', 'Patient referred for rabies post-exposure management and case monitoring.', '2026-01-25 02:36:00', '2026-09-19 13:30:34'),
(15, 'RAB-2026-0015', 4, 'public market area, Barangay 4', '2026-01-20', 'Jack', 'cat', 'male', 'owned', 'unvaccinated', 'Antonio Torres', '09711098919', '2026-01-20', 'Animal observation and patient follow-up advised.', 'Incident recorded for monitoring and barangay follow-up.', '2026-01-20 02:44:00', '2026-09-19 13:30:34'),
(16, 'RAB-2026-0016', 9, 'community basketball court, Barangay 9', '2026-07-15', NULL, 'cat', NULL, 'stray', 'unvaccinated', NULL, NULL, '2026-07-17', 'Animal observation and patient follow-up advised.', 'Case referred to health personnel for further assessment.', '2026-07-17 02:31:00', '2026-09-19 13:30:34'),
(17, 'RAB-2026-0017', 5, 'near barangay hall, Barangay 5', '2026-06-25', 'Ollie', 'cat', 'male', 'owned', 'unvaccinated', 'Cynthia Navarro', '09269961107', '2026-06-27', 'Rabies exposure confirmed and case placed under monitoring.', 'Patient referred for rabies post-exposure management and case monitoring.', '2026-06-27 02:51:00', '2026-09-19 13:30:34'),
(18, 'RAB-2026-0018', 7, 'public market area, Barangay 7', '2026-04-24', 'Sophie', 'cat', 'female', 'owned', 'unvaccinated', 'Teresa Mendoza', '09686483562', '2026-04-24', 'Exposure assessed; animal monitoring recommended.', 'Case referred to health personnel for further assessment.', '2026-04-24 02:26:00', '2026-09-19 13:30:34'),
(19, 'RAB-2026-0019', 4, 'roadside near tricycle terminal, Barangay 4', '2026-08-06', 'Toby', 'cat', 'male', 'owned', 'unvaccinated', 'Roberto Santos', '09544761823', '2026-08-06', 'Rabies exposure confirmed and case placed under monitoring.', 'Patient referred for rabies post-exposure management and case monitoring.', '2026-08-06 02:25:00', '2026-09-19 13:30:34'),
(20, 'RAB-2026-0020', 9, 'near barangay hall, Barangay 9', '2026-02-25', NULL, 'cat', NULL, 'stray', 'unvaccinated', NULL, NULL, '2026-02-25', 'Exposure assessed; animal monitoring recommended.', 'Incident recorded for monitoring and barangay follow-up.', '2026-02-25 02:59:00', '2026-09-19 13:30:34'),
(21, 'RAB-2026-0021', 7, 'public market area, Barangay 7', '2026-04-09', NULL, 'cat', NULL, 'stray', 'unvaccinated', NULL, NULL, '2026-04-09', 'Animal observation and patient follow-up advised.', 'Animal observation initiated and patient advised to return for follow-up.', '2026-04-09 02:46:00', '2026-09-19 13:30:34'),
(22, 'RAB-2026-0022', 9, 'near barangay hall, Barangay 9', '2026-06-27', 'Rosie', 'cat', 'female', 'owned', 'unvaccinated', 'Elena Reyes', '09855074336', '2026-06-28', 'Rabies exposure confirmed and case placed under monitoring.', 'Patient referred for rabies post-exposure management and case monitoring.', '2026-06-28 02:32:00', '2026-09-19 13:30:34'),
(23, 'RAB-2026-0023', 2, 'community basketball court, Barangay 2', '2026-05-21', 'Duke', 'dog', 'male', 'owned', 'unvaccinated', 'Antonio Torres', '09722770648', '2026-05-22', 'Exposure assessed; animal monitoring recommended.', 'Animal observation initiated and patient advised to return for follow-up.', '2026-05-22 02:37:00', '2026-09-19 13:30:34'),
(24, 'RAB-2026-0024', 5, 'near elementary school, Barangay 5', '2026-02-19', NULL, 'cat', NULL, 'stray', 'unvaccinated', NULL, NULL, '2026-02-21', 'Rabies exposure confirmed and case placed under monitoring.', 'Patient referred for rabies post-exposure management and case monitoring.', '2026-02-21 02:56:00', '2026-09-19 13:30:34'),
(25, 'RAB-2026-0025', 1, 'public market area, Barangay 1', '2026-06-05', 'Cooper', 'dog', 'male', 'owned', 'unvaccinated', 'Cynthia Navarro', '09827358385', '2026-06-06', 'Exposure assessed; animal monitoring recommended.', 'Animal observation initiated and patient advised to return for follow-up.', '2026-06-06 02:21:00', '2026-09-19 13:30:34'),
(26, 'RAB-2026-0026', 3, 'near elementary school, Barangay 3', '2026-05-09', 'Penny', 'dog', 'female', 'owned', 'unvaccinated', 'Ramon Ramos', '09811170307', '2026-05-09', 'Case documented for surveillance and follow-up.', 'Incident recorded for monitoring and barangay follow-up.', '2026-05-09 02:56:00', '2026-09-19 13:30:34'),
(27, 'RAB-2026-0027', 5, 'community basketball court, Barangay 5', '2026-04-19', NULL, 'cat', NULL, 'stray', 'unvaccinated', NULL, NULL, '2026-04-20', 'Rabies exposure confirmed and case placed under monitoring.', 'Patient referred for rabies post-exposure management and case monitoring.', '2026-04-20 02:15:00', '2026-09-19 13:30:34'),
(28, 'RAB-2026-0028', 9, 'public market area, Barangay 9', '2026-03-21', 'Lilly', 'cat', 'female', 'owned', 'unvaccinated', 'Grace Flores', '09709907391', '2026-03-21', 'Case documented for surveillance and follow-up.', 'Incident recorded for monitoring and barangay follow-up.', '2026-03-21 02:54:00', '2026-09-19 13:30:34'),
(29, 'RAB-2026-0029', 3, 'near barangay hall, Barangay 3', '2026-05-01', 'Bear', 'dog', 'male', 'owned', 'unvaccinated', 'Elena Reyes', '09346294016', '2026-05-02', 'Rabies exposure confirmed and case placed under monitoring.', 'Patient referred for rabies post-exposure management and case monitoring.', '2026-05-02 02:57:00', '2026-09-19 13:30:34'),
(30, 'RAB-2026-0030', 10, 'public market area, Barangay 10', '2026-05-08', NULL, 'cat', NULL, 'stray', 'unvaccinated', NULL, NULL, '2026-05-09', 'Animal observation and patient follow-up advised.', 'Animal observation initiated and patient advised to return for follow-up.', '2026-05-09 02:29:00', '2026-09-19 13:30:34');

-- --------------------------------------------------------

--
-- Table structure for table `rabies_vaccination_reports`
--

CREATE TABLE `rabies_vaccination_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vaccination_report_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `clinic_name` varchar(255) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `patient_contact` varchar(255) NOT NULL,
  `patient_address` varchar(255) NOT NULL,
  `barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pet_name` varchar(255) DEFAULT NULL,
  `pet_species` enum('Cat','Dog','Other') NOT NULL,
  `pet_breed` varchar(255) DEFAULT NULL,
  `pet_age` varchar(50) DEFAULT NULL,
  `pet_gender` varchar(255) DEFAULT NULL,
  `pet_color` varchar(255) DEFAULT NULL,
  `vaccine_brand` varchar(255) NOT NULL,
  `vaccine_batch_number` varchar(255) DEFAULT NULL,
  `vaccination_date` date NOT NULL,
  `vaccination_time` time NOT NULL,
  `next_vaccination_date` date DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `vaccination_type` enum('primary','booster') NOT NULL,
  `observations` text DEFAULT NULL,
  `status` enum('completed','pending','adverse_reaction') NOT NULL DEFAULT 'completed',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rabies_vaccination_reports`
--

INSERT INTO `rabies_vaccination_reports` (`id`, `vaccination_report_id`, `user_id`, `clinic_name`, `patient_name`, `patient_contact`, `patient_address`, `barangay_id`, `pet_name`, `pet_species`, `pet_breed`, `pet_age`, `pet_gender`, `pet_color`, `vaccine_brand`, `vaccine_batch_number`, `vaccination_date`, `vaccination_time`, `next_vaccination_date`, `weight`, `vaccination_type`, `observations`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, NULL, 11, 'Bogisich, Maggio and Zboncak Veterinary Clinic', 'Alessandro Boyle', '09817621887', '31465 O\'Conner Station Suite 263\nImeldaton, HI 59269', 21, 'Wilhelmine', 'Cat', 'Labrador', '6', 'female', 'White', 'Rabivac', 'BATCH-WV544', '2025-12-20', '16:53:00', NULL, 54.27, 'booster', 'Modi reprehenderit omnis velit nihil.', 'adverse_reaction', NULL, '2025-12-20 12:26:58', '2025-12-20 12:26:58'),
(2, NULL, 11, 'Grady PLC Veterinary Clinic', 'Russell Gulgowski', '09917800025', '47818 Rosalinda Ford\nEast Eldaville, VA 44742-7179', 11, 'Jada', 'Dog', 'Puspin', '2', 'male', 'Black', 'Imrab', 'BATCH-KJ420', '2026-05-02', '08:37:00', '2027-05-02', 191.79, 'booster', 'Rem nam blanditiis consectetur error.', 'completed', NULL, '2026-05-02 12:26:58', '2026-05-02 12:26:58'),
(3, NULL, 11, 'Oberbrunner Group Veterinary Clinic', 'Kaylah Koepp', '09137787507', '888 Schmidt Springs\nKohlerview, IA 21218-4081', 13, 'Nelle', 'Cat', 'Puspin', '14', 'female', 'Golden', 'Rabisin', 'BATCH-OB776', '2026-03-13', '15:07:00', NULL, 308.47, 'booster', 'Et asperiores expedita sint dolor sit quasi.', 'adverse_reaction', NULL, '2026-03-13 12:26:58', '2026-03-13 12:26:58'),
(4, NULL, 10, 'O\'Hara LLC Veterinary Clinic', 'Linda Keebler', '09914314521', '8042 Wunsch Track\nNew Hoseatown, MD 83401', 5, 'Tyson', 'Cat', 'Mongrel', '9', 'male', 'Brown', 'Rabisin', 'BATCH-EK364', '2025-09-03', '13:20:00', NULL, 72.82, 'booster', 'Quis aperiam molestiae aspernatur.', 'pending', NULL, '2025-09-03 12:26:58', '2025-09-03 12:26:58'),
(5, NULL, 10, 'Runte Group Veterinary Clinic', 'Ms. Leila Abernathy', '09545492524', '249 Jenkins Radial Apt. 836\nErnserborough, WV 06072', 7, 'Jakayla', 'Cat', 'Puspin', '5', 'male', 'Orange', 'RabAvert', 'BATCH-ZA206', '2026-02-27', '10:15:00', '2027-02-27', 37.27, 'booster', 'Illo in esse qui et odio.', 'completed', 'Dicta a ea perferendis asperiores voluptas.', '2026-02-27 12:26:58', '2026-02-27 12:26:58'),
(6, NULL, 11, 'Gaylord-O\'Reilly Veterinary Clinic', 'Sandy McDermott', '09954667002', '5828 Taya Courts\nNorth Bruce, KY 39004-9057', 31, 'Eveline', 'Cat', 'Aspin', '8', 'female', 'Brown', 'Nobivac', 'BATCH-UU465', '2025-11-23', '11:40:00', NULL, 215.01, 'primary', 'Qui quas omnis quas ipsa harum et iure.', 'adverse_reaction', 'Adipisci adipisci earum aut occaecati fuga non.', '2025-11-23 12:26:58', '2025-11-23 12:26:58'),
(7, NULL, 10, 'Weimann, Beahan and Schmidt Veterinary Clinic', 'Prof. Carter Corwin Jr.', '09286775025', '69176 Jaden Knoll Suite 104\nKerlukeland, VA 47822', 32, 'Helene', 'Dog', 'Poodle', '4', 'female', 'White', 'Rabivac', 'BATCH-PE755', '2026-02-03', '12:55:00', NULL, 340.09, 'booster', 'Magni possimus quod et accusamus.', 'adverse_reaction', NULL, '2026-02-03 12:26:58', '2026-02-03 12:26:58'),
(8, NULL, 11, 'Kunze Group Veterinary Clinic', 'Kristin Schowalter', '09317685285', '54875 Deshaun Island\nKimtown, NV 76994', 31, 'Minnie', 'Dog', 'Aspin', '7', 'female', 'Golden', 'Nobivac', 'BATCH-AF013', '2025-08-22', '08:25:00', NULL, 143.82, 'booster', 'Sed nihil consequatur sapiente nostrum inventore quo.', 'pending', NULL, '2025-08-22 12:26:58', '2025-08-22 12:26:58'),
(9, NULL, 10, 'Steuber-McCullough Veterinary Clinic', 'Ms. Kendra Wyman', '09979219438', '561 Albin Radial Apt. 125\nPort Deangelo, OK 24315-7917', 7, 'Immanuel', 'Cat', 'Labrador', '12', 'male', 'Orange', 'RabAvert', 'BATCH-QR677', '2025-07-03', '12:02:00', NULL, 51.10, 'primary', 'Quo dolor placeat ad voluptas voluptatum debitis.', 'pending', NULL, '2025-07-03 12:26:58', '2025-07-03 12:26:58'),
(10, NULL, 11, 'Torp Group Veterinary Clinic', 'Patsy Sauer', '09701758724', '8809 Austin Land\nHudsontown, UT 30674-7503', 8, 'Demetris', 'Cat', 'Mongrel', '2', 'male', 'Brown', 'RabAvert', 'BATCH-WV789', '2025-07-05', '14:23:00', '2026-07-05', 216.08, 'booster', 'Quia debitis minus occaecati perferendis doloribus occaecati.', 'completed', NULL, '2025-07-05 12:26:58', '2025-07-05 12:26:58'),
(11, NULL, 11, 'Jenkins, O\'Conner and Nader Veterinary Clinic', 'Mr. Trace Balistreri MD', '09661866834', '8786 Doyle Locks Apt. 788\nNew Annie, NC 26244', 21, 'Scot', 'Dog', 'Puspin', '13', 'female', 'Gray', 'Rabivac', 'BATCH-DB958', '2025-11-15', '12:59:00', NULL, 200.90, 'primary', 'Et sit autem voluptas laboriosam.', 'adverse_reaction', NULL, '2025-11-15 12:26:58', '2025-11-15 12:26:58'),
(12, NULL, 10, 'Veum Group Veterinary Clinic', 'Rusty Zemlak', '09181589173', '478 Sawayn Plain\nLuciennehaven, FL 70855', 18, 'Tristian', 'Cat', 'Labrador', '13', 'female', 'Gray', 'Rabivac', 'BATCH-TE250', '2026-04-30', '13:57:00', '2027-04-30', 46.46, 'primary', 'Illo aliquid autem delectus aut dolorem illo exercitationem.', 'completed', NULL, '2026-04-30 12:26:58', '2026-04-30 12:26:58'),
(13, NULL, 10, 'Heaney LLC Veterinary Clinic', 'Miss Lenora Hahn', '09800306854', '324 Judge Greens\nHarrisberg, IN 23381-1682', 19, 'Godfrey', 'Dog', 'Mongrel', '5', 'female', 'Brown', 'Imrab', 'BATCH-GF610', '2025-09-09', '10:49:00', NULL, 9.29, 'primary', 'Quaerat veniam voluptatum quaerat omnis.', 'adverse_reaction', NULL, '2025-09-09 12:26:58', '2025-09-09 12:26:58'),
(14, NULL, 11, 'Corkery, Reinger and Bechtelar Veterinary Clinic', 'Prof. Westley Howe', '09491916472', '24929 Kunze Unions\nGoldnerburgh, MI 04873', 11, 'Josiah', 'Dog', 'Labrador', '4', 'female', 'White', 'Rabisin', 'BATCH-DP446', '2025-08-13', '09:59:00', NULL, 47.81, 'booster', 'Est numquam dolores tenetur.', 'pending', 'Adipisci aut nesciunt ut ut suscipit.', '2025-08-13 12:26:58', '2025-08-13 12:26:58'),
(15, NULL, 11, 'Pollich-Stroman Veterinary Clinic', 'Jabari Kohler', '09541466387', '8023 Thiel Green Suite 173\nLangburgh, CT 93466', 6, 'Werner', 'Cat', 'Shih Tzu', '11', 'male', 'Golden', 'RabAvert', 'BATCH-OL572', '2025-11-17', '17:01:00', '2026-11-17', 230.99, 'primary', 'Autem nesciunt in aut maiores blanditiis voluptatem.', 'completed', NULL, '2025-11-17 12:26:58', '2025-11-17 12:26:58'),
(16, NULL, 10, 'Reichert-Senger Veterinary Clinic', 'Norene O\'Kon', '09419531201', '2004 Konopelski Parkway Apt. 790\nEast Victoriastad, KS 43925-5714', 9, 'Jammie', 'Cat', 'Poodle', '8', 'female', 'Golden', 'RabAvert', 'BATCH-YO954', '2026-03-09', '14:17:00', '2027-03-09', 252.91, 'primary', 'Nostrum asperiores id iure repellat facilis aut.', 'completed', NULL, '2026-03-09 12:26:58', '2026-03-09 12:26:58'),
(17, NULL, 11, 'Mayer-Sporer Veterinary Clinic', 'Mrs. Velva Macejkovic IV', '09381603341', '14240 Walter Drive\nNorth Milfordbury, HI 19598', 41, 'Wilhelm', 'Dog', 'Labrador', '13', 'male', 'Orange', 'RabAvert', 'BATCH-KN003', '2026-04-03', '16:50:00', NULL, 242.73, 'booster', 'Et alias laboriosam cum.', 'pending', NULL, '2026-04-03 12:26:58', '2026-04-03 12:26:58'),
(18, NULL, 11, 'Johnston, Mayert and Leuschke Veterinary Clinic', 'Myles Schimmel', '09737172973', '66621 Adaline Forks Suite 831\nLaurelland, AZ 00822-1285', 32, 'Fiona', 'Dog', 'Puspin', '3', 'female', 'Golden', 'Imrab', 'BATCH-YS689', '2026-05-11', '16:45:00', '2027-05-11', 285.50, 'primary', 'Numquam et vel ratione natus porro quas.', 'completed', NULL, '2026-05-11 12:26:58', '2026-05-11 12:26:58'),
(19, NULL, 11, 'Stokes, Buckridge and Turner Veterinary Clinic', 'Ollie Zboncak', '09351038693', '2363 Frami Crest Apt. 027\nBrooksville, CT 63638-2167', 21, 'Lulu', 'Dog', 'Shih Tzu', '11', 'female', 'Golden', 'Rabisin', 'BATCH-PM446', '2025-09-28', '08:23:00', '2026-09-28', 155.61, 'primary', 'Nam animi non nihil in possimus non impedit.', 'completed', NULL, '2025-09-28 12:26:58', '2025-09-28 12:26:58'),
(20, NULL, 10, 'Thompson PLC Veterinary Clinic', 'Miss Teresa Hamill Sr.', '09972774233', '329 Estefania Ferry Apt. 804\nPort Cordie, NM 32834', 54, 'Stacey', 'Dog', 'Poodle', '5', 'male', 'White', 'Imrab', 'BATCH-LN960', '2026-05-19', '14:58:00', NULL, 243.49, 'booster', 'Saepe et enim voluptas odio.', 'adverse_reaction', NULL, '2026-05-19 12:26:58', '2026-05-19 12:26:58'),
(21, NULL, 11, 'Bradtke, Bailey and Stoltenberg Veterinary Clinic', 'Alexzander Murphy', '09404823358', '3813 Vicenta Crossing\nMorarfurt, KS 76175', 34, 'Kali', 'Cat', 'Shih Tzu', '12', 'female', 'Gray', 'Imrab', 'BATCH-UM815', '2025-09-16', '09:56:00', NULL, 65.13, 'booster', 'Fugiat accusamus est occaecati non nam est iusto id.', 'adverse_reaction', NULL, '2025-09-16 12:26:58', '2025-09-16 12:26:58'),
(22, NULL, 10, 'Rosenbaum-Harber Veterinary Clinic', 'Mae Renner IV', '09684026995', '557 Paucek Square\nBrakusmouth, AK 91937-5896', 20, 'Deontae', 'Cat', 'Poodle', '3', 'male', 'Black', 'Rabisin', 'BATCH-ZT992', '2025-07-16', '09:42:00', NULL, 298.65, 'primary', 'Eveniet ad est amet iusto harum.', 'adverse_reaction', 'Ut nihil id id eius illum.', '2025-07-16 12:26:58', '2025-07-16 12:26:58'),
(23, NULL, 10, 'Rutherford-Denesik Veterinary Clinic', 'Prof. Trevor Wunsch Sr.', '09475277820', '96397 Medhurst Knoll Suite 463\nHartmannborough, PA 57949-7473', 40, 'Milo', 'Dog', 'Mongrel', '7', 'female', 'Golden', 'Imrab', 'BATCH-MV703', '2026-01-19', '16:38:00', NULL, 28.53, 'booster', 'Et ad et minus autem quis.', 'pending', 'Laudantium saepe consequatur sunt maiores quas fugiat repellat.', '2026-01-19 12:26:58', '2026-01-19 12:26:58'),
(24, NULL, 10, 'Rice and Sons Veterinary Clinic', 'Cheyanne Hane', '09289544053', '2706 Yundt Spur Suite 943\nHillport, MS 21054', 35, 'Willy', 'Cat', 'Shih Tzu', '4', 'male', 'Black', 'Rabivac', 'BATCH-ZD236', '2025-09-22', '13:42:00', NULL, 146.63, 'primary', 'Placeat expedita ab excepturi ipsum.', 'pending', 'Iusto dicta non dolorum qui ut soluta voluptates.', '2025-09-22 12:26:58', '2025-09-22 12:26:58'),
(25, NULL, 11, 'Green Inc Veterinary Clinic', 'Alfonzo Rath', '09671290416', '78136 Korey Ridges\nSouth Ashleigh, LA 25235', 27, 'Aurore', 'Dog', 'Mongrel', '12', 'female', 'Golden', 'Nobivac', 'BATCH-HV213', '2025-07-04', '14:29:00', NULL, 124.45, 'primary', 'Dolor impedit rerum molestiae et et nihil.', 'adverse_reaction', 'Esse dicta officiis aliquid eaque quia consequatur aut.', '2025-07-04 12:26:58', '2025-07-04 12:26:58'),
(26, NULL, 11, 'Schmitt Ltd Veterinary Clinic', 'Murray Hill', '09202328298', '5337 Jerde Terrace\nPowlowskiville, MS 92173', NULL, 'Talia', 'Cat', 'Aspin', '5', 'male', 'Golden', 'Rabisin', 'BATCH-RW452', '2025-12-29', '08:39:00', '2026-12-29', 292.32, 'booster', 'Suscipit veritatis quis ut sint.', 'completed', 'Eaque ut ipsa voluptatem voluptatem qui delectus architecto.', '2025-12-29 12:26:58', '2025-12-29 12:26:58'),
(27, NULL, 10, 'Nitzsche-Gulgowski Veterinary Clinic', 'Gaston Reynolds', '09463415567', '2061 Halvorson Street\nWest Malinda, CA 99587', NULL, 'Alvera', 'Dog', 'Mongrel', '3', 'male', 'Orange', 'Nobivac', 'BATCH-HN354', '2025-12-14', '13:00:00', NULL, 31.27, 'primary', 'Ratione dolores officia ipsum nihil consequatur.', 'adverse_reaction', NULL, '2025-12-14 12:26:58', '2025-12-14 12:26:58'),
(28, NULL, 11, 'Bergstrom-Nienow Veterinary Clinic', 'Kylie Pagac', '09684451845', '557 Feeney Coves Apt. 445\nEast Jewel, MI 53666', NULL, 'Carissa', 'Cat', 'Puspin', '11', 'male', 'Brown', 'Nobivac', 'BATCH-DU265', '2026-06-16', '11:15:00', NULL, 68.07, 'booster', 'Eius sed rerum consequatur repudiandae.', 'pending', 'Molestias quis soluta sed quia facilis similique sunt.', '2026-06-16 12:26:58', '2026-06-16 12:26:58'),
(29, NULL, 11, 'Bernier-Boyer Veterinary Clinic', 'Felipa Dach', '09599027132', '47726 Angel Inlet Apt. 917\nArloview, MT 92409', NULL, 'Haylee', 'Dog', 'Mongrel', '13', 'female', 'Brown', 'Imrab', 'BATCH-HY340', '2025-11-05', '16:38:00', NULL, 97.63, 'primary', 'Voluptatem et sint quia.', 'pending', 'Et veniam quas sapiente minima sint.', '2025-11-05 12:26:58', '2025-11-05 12:26:58'),
(30, NULL, 11, 'Howell, Glover and Cole Veterinary Clinic', 'Odessa Skiles Sr.', '09388657470', '93472 Pacocha Throughway Apt. 568\nPort Rosalindatown, NH 50548-8090', NULL, 'Eladio', 'Dog', 'Labrador', '6', 'male', 'Black', 'Nobivac', 'BATCH-DM966', '2025-12-12', '13:39:00', NULL, 235.25, 'primary', 'Enim inventore a eos rerum aut.', 'adverse_reaction', NULL, '2025-12-12 12:26:58', '2025-12-12 12:26:58');

-- --------------------------------------------------------

--
-- Table structure for table `report_exports`
--

CREATE TABLE `report_exports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_type` varchar(255) NOT NULL,
  `parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`parameters`)),
  `file_path` varchar(255) DEFAULT NULL,
  `exported_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `exported_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_forms`
--

CREATE TABLE `service_forms` (
  `form_id` bigint(20) UNSIGNED NOT NULL,
  `form_type` enum('kapon','vaccination','pet_registration','adoption','bite_report','stray_report','other') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spatie_model_has_permissions`
--

CREATE TABLE `spatie_model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spatie_model_has_roles`
--

CREATE TABLE `spatie_model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spatie_model_has_roles`
--

INSERT INTO `spatie_model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 4),
(5, 'App\\Models\\User', 9),
(8, 'App\\Models\\User', 6),
(12, 'App\\Models\\User', 20),
(12, 'App\\Models\\User', 22),
(12, 'App\\Models\\User', 24),
(12, 'App\\Models\\User', 26),
(12, 'App\\Models\\User', 27),
(12, 'App\\Models\\User', 28),
(12, 'App\\Models\\User', 29),
(12, 'App\\Models\\User', 30),
(12, 'App\\Models\\User', 31);

-- --------------------------------------------------------

--
-- Table structure for table `spatie_permissions`
--

CREATE TABLE `spatie_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spatie_permissions`
--

INSERT INTO `spatie_permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard.access', 'web', '2026-09-07 15:10:08', '2026-09-07 15:10:08'),
(2, 'users.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(3, 'users.create', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(4, 'users.edit', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(5, 'users.delete', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(6, 'users.toggle-status', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(7, 'users.change-role', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(8, 'announcements.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(9, 'announcements.create', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(10, 'announcements.edit', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(11, 'announcements.delete', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(12, 'system-logs.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(13, 'system-logs.export', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(14, 'settings.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(15, 'settings.edit', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(16, 'rabies-cases.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(17, 'rabies-cases.create', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(18, 'rabies-cases.edit', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(19, 'rabies-cases.delete', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(20, 'spay-neuter.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(21, 'spay-neuter.create', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(22, 'spay-neuter.edit', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(23, 'spay-neuter.delete', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(24, 'inventory.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(25, 'inventory.create', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(26, 'inventory.edit', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(27, 'inventory.delete', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(28, 'livestock-census.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(29, 'livestock-census.create', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(30, 'livestock-census.edit', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(31, 'livestock-census.delete', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(32, 'reports.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(33, 'reports.export', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(34, 'vaccination-reports.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(35, 'vaccination-reports.create', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(36, 'bite-reports.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(37, 'bite-reports.create', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(38, 'vaccination-records.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(39, 'vaccination-records.create', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(40, 'missing-pet-reports.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(41, 'adoption-reports.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(42, 'meat-inspection-reports.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(43, 'meat-inspection-reports.create', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(44, 'meat-inspection-reports.edit', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(45, 'meat-shop-inspections.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(46, 'meat-shop-inspections.create', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(47, 'meat-shop-inspections.edit', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(48, 'establishments.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(49, 'establishments.create', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(50, 'establishments.edit', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(51, 'pet-registrations.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(52, 'pet-registrations.create', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(53, 'pet-registrations.edit', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(54, 'pet-registrations.delete', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(55, 'missing-pets.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(56, 'missing-pets.create', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(57, 'missing-pets.edit', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(58, 'appointments.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(59, 'appointments.approve', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(60, 'appointments.reject', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(61, 'appointments.complete', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(62, 'appointments.reset', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(63, 'owner-reports.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(64, 'medical-records.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(65, 'medical-records.create', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(66, 'medical-records.edit', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(67, 'medical-records.delete', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(68, 'pets.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(69, 'pets.edit', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(70, 'pets.delete', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(71, 'profile.view', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(72, 'profile.edit', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09'),
(73, 'profile.delete', 'web', '2026-09-07 15:10:09', '2026-09-07 15:10:09');

-- --------------------------------------------------------

--
-- Table structure for table `spatie_roles`
--

CREATE TABLE `spatie_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `hierarchy_level` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spatie_roles`
--

INSERT INTO `spatie_roles` (`id`, `name`, `display_name`, `description`, `hierarchy_level`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'Super Administrator', 'Full system access', 10, 'web', '2026-04-28 19:15:29', '2026-09-15 14:23:03'),
(2, 'city_vet', 'City Veterinarian', 'Admin/office head access', 8, 'web', '2026-04-28 19:15:29', '2026-09-15 14:23:03'),
(4, 'assistant_vet', 'Assistant Veterinarian', 'Assistant vet access', 5, 'web', '2026-04-28 19:15:29', '2026-09-15 14:23:03'),
(5, 'admin_asst', 'Administrative Assistant', 'Admin assistant access', 5, 'web', '2026-04-28 19:15:29', '2026-09-15 14:23:03'),
(8, 'meat_inspector', 'Meat Inspector', 'Meat inspection access', 4, 'web', '2026-04-28 19:15:29', '2026-09-15 14:23:03'),
(12, 'pet_owner', 'Pet Owner', 'Pet owner / citizen portal', 1, 'web', '2026-04-28 19:15:30', '2026-09-15 14:23:03');

-- --------------------------------------------------------

--
-- Table structure for table `spatie_role_has_permissions`
--

CREATE TABLE `spatie_role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spatie_role_has_permissions`
--

INSERT INTO `spatie_role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 4),
(1, 5),
(1, 8),
(1, 12),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(6, 1),
(6, 2),
(7, 1),
(8, 1),
(8, 2),
(9, 1),
(9, 2),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(12, 1),
(12, 2),
(13, 1),
(13, 2),
(14, 1),
(14, 2),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(16, 4),
(17, 1),
(17, 2),
(17, 4),
(18, 1),
(18, 2),
(18, 4),
(19, 1),
(19, 2),
(19, 4),
(20, 1),
(20, 2),
(20, 4),
(21, 1),
(21, 2),
(21, 4),
(22, 1),
(22, 2),
(22, 4),
(23, 1),
(23, 2),
(23, 4),
(24, 1),
(24, 2),
(24, 4),
(25, 1),
(25, 2),
(25, 4),
(26, 1),
(26, 2),
(26, 4),
(27, 1),
(27, 2),
(27, 4),
(28, 1),
(28, 2),
(28, 4),
(29, 1),
(29, 2),
(29, 4),
(30, 1),
(30, 2),
(30, 4),
(31, 1),
(31, 2),
(31, 4),
(32, 1),
(32, 2),
(33, 1),
(33, 2),
(34, 1),
(34, 2),
(34, 4),
(35, 1),
(35, 2),
(35, 4),
(36, 1),
(36, 2),
(36, 4),
(37, 1),
(37, 2),
(37, 4),
(37, 12),
(38, 1),
(38, 4),
(39, 1),
(39, 4),
(40, 1),
(40, 2),
(41, 1),
(41, 2),
(41, 5),
(42, 1),
(42, 2),
(42, 8),
(43, 1),
(43, 8),
(44, 1),
(44, 8),
(45, 1),
(45, 8),
(46, 1),
(46, 8),
(47, 1),
(47, 8),
(48, 1),
(48, 8),
(49, 1),
(49, 8),
(50, 1),
(50, 8),
(51, 1),
(51, 5),
(52, 1),
(52, 5),
(53, 1),
(53, 5),
(54, 1),
(54, 5),
(55, 1),
(55, 5),
(56, 1),
(56, 5),
(57, 1),
(57, 5),
(58, 1),
(58, 5),
(59, 1),
(59, 5),
(60, 1),
(60, 5),
(61, 1),
(61, 5),
(62, 1),
(62, 5),
(63, 1),
(63, 5),
(64, 1),
(64, 4),
(65, 1),
(65, 4),
(66, 1),
(66, 4),
(67, 1),
(67, 4),
(68, 1),
(68, 12),
(69, 1),
(69, 12),
(70, 1),
(70, 12),
(71, 1),
(71, 12),
(72, 1),
(72, 12),
(73, 1),
(73, 12);

-- --------------------------------------------------------

--
-- Table structure for table `spay_neuter_appointments`
--

CREATE TABLE `spay_neuter_appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pet_id` bigint(20) UNSIGNED DEFAULT NULL,
  `scheduled_at` datetime DEFAULT NULL,
  `event_id` bigint(20) UNSIGNED DEFAULT NULL,
  `appointment_mode` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `procedure_type` varchar(255) DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `general_agreement` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`general_agreement`)),
  `veterinarian` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `previous_surgery_date` date DEFAULT NULL,
  `surgery_type` varchar(255) DEFAULT NULL,
  `is_ineligible_until` date DEFAULT NULL,
  `assigned_vet` bigint(20) UNSIGNED DEFAULT 4,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spay_neuter_appointments`
--

INSERT INTO `spay_neuter_appointments` (`id`, `user_id`, `owner_id`, `address_id`, `barangay_id`, `pet_id`, `scheduled_at`, `event_id`, `appointment_mode`, `status`, `procedure_type`, `weight`, `general_agreement`, `veterinarian`, `notes`, `previous_surgery_date`, `surgery_type`, `is_ineligible_until`, `assigned_vet`, `created_at`, `updated_at`) VALUES
(12, 20, 6, 6, 27, 19, '2026-10-15 09:00:00', NULL, NULL, 'pending', 'neuter', 17.00, '{\"combined\":\"yes\"}', 'Assistant Veterinarian', NULL, NULL, NULL, NULL, 4, '2026-10-14 00:54:39', '2026-10-14 00:54:39'),
(13, 30, 16, 22, 8, 70, '2026-11-13 00:00:00', NULL, NULL, 'pending', 'spay', 10.00, '{\"combined\":\"yes\"}', 'City Veterinarian', 'need to help at the hospital', NULL, NULL, NULL, 4, '2026-11-01 15:39:44', '2026-11-03 16:08:24'),
(14, 20, 6, NULL, NULL, 24, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'Assistant Veterinarian', NULL, '2026-10-21', 'fractured', '2026-11-04', 4, '2026-11-04 15:11:28', '2026-11-04 15:11:33'),
(15, 20, 6, 6, 27, 24, '2026-11-13 09:00:00', NULL, NULL, 'pending', 'spay', 13.00, '{\"combined\":\"yes\"}', 'Assistant Veterinarian', NULL, '2026-10-21', 'fractured', '2026-11-04', NULL, '2026-11-04 15:17:37', '2026-11-04 15:17:37');

-- --------------------------------------------------------

--
-- Table structure for table `spay_neuter_reports`
--

CREATE TABLE `spay_neuter_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pet_id` bigint(20) UNSIGNED DEFAULT NULL,
  `spay_neuter_appointment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `procedure_type` enum('spay','neuter','both') NOT NULL,
  `veterinarian` enum('City Veterinarian','Assistant Veterinarian') DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `status` enum('scheduled','completed','cancelled','pending') NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `report_date` date NOT NULL DEFAULT '2026-04-29',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `scheduled_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inventory_item_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `movement_type` enum('stock_in','stock_out','adjustment','return') NOT NULL,
  `quantity` int(11) NOT NULL,
  `previous_quantity` int(11) NOT NULL,
  `new_quantity` int(11) NOT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `movement_date` date NOT NULL DEFAULT '2026-04-29',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_movements`
--

INSERT INTO `stock_movements` (`id`, `inventory_item_id`, `user_id`, `movement_type`, `quantity`, `previous_quantity`, `new_quantity`, `reference_number`, `remarks`, `movement_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'stock_in', 150, 0, 150, 'INITIAL-RAB-001', 'Initial stock entry', '2026-03-30', '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(2, 2, 1, 'stock_in', 500, 0, 500, 'INITIAL-DEW-001', 'Initial stock entry', '2026-03-30', '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(3, 3, 1, 'stock_in', 80, 0, 80, 'INITIAL-VAC-005', 'Initial stock entry', '2026-03-30', '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(4, 4, 1, 'stock_in', 200, 0, 200, 'INITIAL-ANT-001', 'Initial stock entry', '2026-03-30', '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(5, 7, 1, 'stock_in', 10, 0, 10, 'INITIAL-VAC-FVR', 'Initial stock entry', '2026-03-30', '2026-04-28 19:15:39', '2026-04-28 19:15:39'),
(6, 8, 1, 'stock_in', 45, 0, 45, 'INITIAL-SUP-GL', 'Initial stock entry', '2026-03-30', '2026-04-28 19:15:39', '2026-04-28 19:15:39');

-- --------------------------------------------------------

--
-- Table structure for table `stray_reports`
--

CREATE TABLE `stray_reports` (
  `stray_report_id` bigint(20) UNSIGNED NOT NULL,
  `barangay_id` bigint(20) UNSIGNED NOT NULL,
  `reported_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `report_type` enum('stray','nuisance','injured') NOT NULL,
  `species` enum('dog','cat','other') NOT NULL,
  `description` text DEFAULT NULL,
  `location_text` varchar(255) DEFAULT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `urgency_level` enum('low','medium','high') NOT NULL DEFAULT 'medium',
  `report_status` enum('new','validated','responding','closed') NOT NULL DEFAULT 'new',
  `reported_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `record_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_logs`
--

INSERT INTO `system_logs` (`id`, `log_name`, `description`, `subject_type`, `subject_id`, `event`, `properties`, `causer_id`, `causer_type`, `user_agent`, `created_at`, `updated_at`, `module`, `action`, `status`, `record_id`, `ip_address`, `user_id`, `role`) VALUES
(1, NULL, 'User logged in via OTP verification', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-28 19:37:36', '2026-04-28 19:37:36', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 16, NULL),
(2, NULL, 'create request to otp/verify', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-28 19:37:41', '2026-04-28 19:37:41', 'otp', 'create', 'success', NULL, '127.0.0.1', 16, NULL),
(3, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-28 19:38:24', '2026-04-28 19:38:24', 'pet', 'create', 'success', NULL, '127.0.0.1', 16, NULL),
(4, NULL, 'User logged in via OTP verification', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-28 20:42:18', '2026-04-28 20:42:18', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 17, NULL),
(5, NULL, 'create request to otp/verify', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-28 20:42:23', '2026-04-28 20:42:23', 'otp', 'create', 'success', NULL, '127.0.0.1', 17, NULL),
(6, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-28 20:43:06', '2026-04-28 20:43:06', 'pet', 'create', 'success', NULL, '127.0.0.1', 17, NULL),
(7, NULL, 'update request to profile', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-28 20:56:02', '2026-04-28 20:56:02', 'profile', 'update', 'success', NULL, '127.0.0.1', 17, NULL),
(8, NULL, 'update request to profile', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-28 21:32:10', '2026-04-28 21:32:10', 'profile', 'update', 'success', NULL, '127.0.0.1', 17, NULL),
(9, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-28 22:43:45', '2026-04-28 22:43:45', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 17, NULL),
(10, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-28 23:21:20', '2026-04-28 23:21:20', 'pet', 'create', 'success', NULL, '127.0.0.1', 17, NULL),
(11, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-29 03:15:44', '2026-04-29 03:15:44', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 17, NULL),
(12, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-29 03:22:21', '2026-04-29 03:22:21', 'pet', 'create', 'success', NULL, '127.0.0.1', 17, NULL),
(13, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-29 03:31:24', '2026-04-29 03:31:24', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(14, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-29 03:35:09', '2026-04-29 03:35:09', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(15, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-04 12:54:17', '2026-05-04 12:54:17', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(16, NULL, 'User logged in via OTP verification', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-04 03:23:38', '2026-06-04 03:23:38', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(17, NULL, 'create request to otp/verify', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-04 03:23:43', '2026-06-04 03:23:43', 'otp', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(18, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-04 03:25:06', '2026-06-04 03:25:06', 'pet', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(19, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-07 14:32:15', '2026-06-07 14:32:15', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(20, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-07 14:32:37', '2026-06-07 14:32:37', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(21, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-07 14:37:44', '2026-06-07 14:37:44', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(22, NULL, 'update request to city-vet/bite-rabies-reports/1/check', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-07 14:40:31', '2026-06-07 14:40:31', 'city-vet', 'update', 'failed', NULL, '127.0.0.1', 2, NULL),
(23, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-07 14:43:04', '2026-06-07 14:43:04', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 9, NULL),
(24, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-07 14:43:13', '2026-06-07 14:43:13', 'Unknown', 'create', 'failed', NULL, '127.0.0.1', 9, NULL),
(25, NULL, 'create request to logout', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-07 14:43:19', '2026-06-07 14:43:19', 'logout', 'create', 'failed', NULL, '127.0.0.1', 9, NULL),
(26, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-07 15:46:38', '2026-06-07 15:46:38', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(27, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-07 15:46:54', '2026-06-07 15:46:54', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(28, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-07 15:47:04', '2026-06-07 15:47:04', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(29, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-07 15:47:37', '2026-06-07 15:47:37', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(30, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-07 15:48:53', '2026-06-07 15:48:53', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(31, NULL, 'User logged in via OTP verification', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-14 11:09:43', '2026-06-14 11:09:43', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 21, NULL),
(32, NULL, 'create request to otp/verify', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-14 11:09:50', '2026-06-14 11:09:50', 'otp', 'create', 'success', NULL, '127.0.0.1', 21, NULL),
(33, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-14 11:13:00', '2026-06-14 11:13:00', 'pet', 'create', 'success', NULL, '127.0.0.1', 21, NULL),
(34, NULL, 'User logged in via OTP verification', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-14 12:00:00', '2026-06-14 12:00:00', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 22, NULL),
(35, NULL, 'create request to otp/verify', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-14 12:00:07', '2026-06-14 12:00:07', 'otp', 'create', 'success', NULL, '127.0.0.1', 22, NULL),
(36, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-14 12:01:11', '2026-06-14 12:01:11', 'pet', 'create', 'success', NULL, '127.0.0.1', 22, NULL),
(37, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-14 12:02:34', '2026-06-14 12:02:34', 'pet', 'create', 'success', NULL, '127.0.0.1', 22, NULL),
(38, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-15 03:24:43', '2026-06-15 03:24:43', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 22, NULL),
(39, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-15 03:32:29', '2026-06-15 03:32:29', 'pet', 'create', 'success', NULL, '127.0.0.1', 22, NULL),
(40, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-15 03:45:10', '2026-06-15 03:45:10', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(41, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-15 03:48:43', '2026-06-15 03:48:43', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(42, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-15 03:53:50', '2026-06-15 03:53:50', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(43, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-15 03:56:41', '2026-06-15 03:56:41', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 9, NULL),
(44, NULL, 'create request to logout', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-15 03:56:55', '2026-06-15 03:56:55', 'logout', 'create', 'failed', NULL, '127.0.0.1', 9, NULL),
(45, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-15 03:57:51', '2026-06-15 03:57:51', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(46, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-23 05:58:30', '2026-06-23 05:58:30', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(47, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 14:19:20', '2026-06-25 14:19:20', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(48, NULL, 'update request to super-admin/announcements/1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 14:20:50', '2026-06-25 14:20:50', 'super-admin', 'update', 'success', NULL, '127.0.0.1', 1, NULL),
(49, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 14:21:22', '2026-06-25 14:21:22', 'super-admin', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(50, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 14:22:08', '2026-06-25 14:22:08', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(51, NULL, 'update request to super-admin/announcements/1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 14:22:19', '2026-06-25 14:22:19', 'super-admin', 'update', 'success', NULL, '127.0.0.1', 1, NULL),
(52, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 00:51:48', '2026-06-26 00:51:48', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(53, NULL, 'delete request to super-admin/announcements/1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 00:52:14', '2026-06-26 00:52:14', 'super-admin', 'delete', 'success', NULL, '127.0.0.1', 1, NULL),
(54, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 01:05:35', '2026-06-26 01:05:35', 'super-admin', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(55, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 01:19:03', '2026-06-26 01:19:03', 'super-admin', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(56, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 01:20:02', '2026-06-26 01:20:02', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(57, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 01:25:15', '2026-06-26 01:25:15', 'super-admin', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(58, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 01:41:49', '2026-06-26 01:41:49', 'super-admin', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(59, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 01:51:45', '2026-06-26 01:51:45', 'super-admin', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(60, NULL, 'delete request to super-admin/announcements/7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 02:00:13', '2026-06-26 02:00:13', 'super-admin', 'delete', 'success', NULL, '127.0.0.1', 1, NULL),
(61, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 02:00:59', '2026-06-26 02:00:59', 'super-admin', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(62, NULL, 'delete request to super-admin/announcements/4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 02:11:43', '2026-06-26 02:11:43', 'super-admin', 'delete', 'success', NULL, '127.0.0.1', 1, NULL),
(63, NULL, 'update request to super-admin/announcements/8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 02:12:20', '2026-06-26 02:12:20', 'super-admin', 'update', 'success', NULL, '127.0.0.1', 1, NULL),
(64, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 03:48:43', '2026-06-26 03:48:43', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(65, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 07:02:26', '2026-06-26 07:02:26', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(66, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 07:02:50', '2026-06-26 07:02:50', 'Unknown', 'create', 'failed', NULL, '127.0.0.1', 2, NULL),
(67, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 07:03:23', '2026-06-26 07:03:23', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(68, NULL, 'update request to city-vet/bite-rabies-reports/1/check', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 07:16:14', '2026-06-26 07:16:14', 'city-vet', 'update', 'failed', NULL, '127.0.0.1', 2, NULL),
(69, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 12:22:54', '2026-06-26 12:22:54', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(70, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-27 05:58:53', '2026-06-27 05:58:53', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(71, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-27 12:04:42', '2026-06-27 12:04:42', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(72, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-28 06:06:49', '2026-06-28 06:06:49', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(73, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-29 04:59:12', '2026-06-29 04:59:12', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(74, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-29 08:58:27', '2026-06-29 08:58:27', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(75, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-29 08:58:34', '2026-06-29 08:58:34', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(76, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-29 10:06:36', '2026-06-29 10:06:36', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(77, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-30 02:45:55', '2026-06-30 02:45:55', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(78, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-30 03:45:30', '2026-06-30 03:45:30', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(79, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 05:47:01', '2026-07-01 05:47:01', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(80, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 05:47:12', '2026-07-01 05:47:12', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(81, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 11:21:26', '2026-07-01 11:21:26', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(82, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 11:22:09', '2026-07-01 11:22:09', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(83, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-02 05:55:34', '2026-07-02 05:55:34', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(84, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-03 05:44:55', '2026-07-03 05:44:55', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(85, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-06 05:14:07', '2026-07-06 05:14:07', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(86, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-06 14:18:33', '2026-07-06 14:18:33', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(87, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-07 05:07:10', '2026-07-07 05:07:10', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(88, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-07 07:34:14', '2026-07-07 07:34:14', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(89, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-07 08:25:41', '2026-07-07 08:25:41', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(90, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-07 08:26:27', '2026-07-07 08:26:27', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(91, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-07 08:26:38', '2026-07-07 08:26:38', 'Unknown', 'create', 'failed', NULL, '127.0.0.1', 4, NULL),
(92, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-07 08:29:36', '2026-07-07 08:29:36', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(93, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-07 08:30:00', '2026-07-07 08:30:00', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(94, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-07 08:54:59', '2026-07-07 08:54:59', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(95, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-07 08:57:13', '2026-07-07 08:57:13', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(96, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-08 03:23:18', '2026-07-08 03:23:18', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(97, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-08 03:33:45', '2026-07-08 03:33:45', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(98, NULL, 'update request to admin/vaccination-appointments/19/status', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-08 05:23:11', '2026-07-08 05:23:11', 'admin', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(99, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-08 06:04:53', '2026-07-08 06:04:53', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(100, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-09 05:58:04', '2026-07-09 05:58:04', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(101, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-09 06:34:09', '2026-07-09 06:34:09', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(102, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-09 06:44:30', '2026-07-09 06:44:30', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(103, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-09 08:15:29', '2026-07-09 08:15:29', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(104, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-09 09:03:01', '2026-07-09 09:03:01', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(105, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 05:59:25', '2026-07-17 05:59:25', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(106, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 06:21:45', '2026-07-17 06:21:45', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 9, NULL),
(107, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 12:49:54', '2026-07-17 12:49:54', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(108, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 12:50:11', '2026-07-17 12:50:11', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 9, NULL),
(109, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-18 05:33:12', '2026-07-18 05:33:12', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 9, NULL),
(110, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-18 06:07:08', '2026-07-18 06:07:08', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(111, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-18 06:08:59', '2026-07-18 06:08:59', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(112, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-18 06:09:53', '2026-07-18 06:09:53', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 9, NULL),
(113, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-19 04:15:07', '2026-07-19 04:15:07', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 9, NULL),
(114, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-20 05:22:46', '2026-07-20 05:22:46', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 9, NULL),
(115, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-20 06:50:44', '2026-07-20 06:50:44', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 6, NULL),
(116, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-25 06:59:06', '2026-07-25 06:59:06', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(117, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-25 06:59:24', '2026-07-25 06:59:24', 'Unknown', 'create', 'failed', NULL, '127.0.0.1', 2, NULL),
(118, NULL, 'create request to logout', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-25 06:59:29', '2026-07-25 06:59:29', 'logout', 'create', 'failed', NULL, '127.0.0.1', 2, NULL),
(119, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-25 07:00:06', '2026-07-25 07:00:06', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(120, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-25 07:19:38', '2026-07-25 07:19:38', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(121, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-25 07:19:56', '2026-07-25 07:19:56', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(122, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-25 07:20:19', '2026-07-25 07:20:19', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(123, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-25 07:20:29', '2026-07-25 07:20:29', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 9, NULL),
(124, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-14 03:42:28', '2026-08-14 03:42:28', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(125, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-14 06:35:54', '2026-08-14 06:35:54', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(126, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-25 14:26:20', '2026-08-25 14:26:20', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(127, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-25 16:12:52', '2026-08-25 16:12:52', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(128, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-26 05:59:31', '2026-08-26 05:59:31', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(129, NULL, 'Updated user: Chelsy Alba (ID: 22)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-26 06:00:58', '2026-08-26 06:00:58', 'User Management', 'update_user', 'success', NULL, '127.0.0.1', 1, NULL),
(130, NULL, 'update request to admin/users/22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-26 06:00:58', '2026-08-26 06:00:58', 'admin', 'update', 'success', NULL, '127.0.0.1', 1, NULL),
(131, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-27 02:31:52', '2026-08-27 02:31:52', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(132, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-27 05:56:42', '2026-08-27 05:56:42', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(133, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-28 01:28:57', '2026-08-28 01:28:57', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(134, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-29 12:40:01', '2026-08-29 12:40:01', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(135, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-29 13:13:58', '2026-08-29 13:13:58', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(136, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-29 18:51:55', '2026-08-29 18:51:55', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(137, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-30 15:30:38', '2026-08-30 15:30:38', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(138, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-01 06:16:48', '2026-09-01 06:16:48', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(139, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-01 07:03:58', '2026-09-01 07:03:58', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(140, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-01 07:05:26', '2026-09-01 07:05:26', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(141, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 00:37:35', '2026-09-02 00:37:35', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(142, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 00:46:00', '2026-09-02 00:46:00', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(143, NULL, 'User logged in via OTP verification', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 01:28:21', '2026-09-02 01:28:21', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 23, NULL),
(144, NULL, 'create request to otp/verify', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 01:28:27', '2026-09-02 01:28:27', 'otp', 'create', 'success', NULL, '127.0.0.1', 23, NULL),
(145, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 01:34:41', '2026-09-02 01:34:41', 'pet', 'create', 'success', NULL, '127.0.0.1', 23, NULL),
(146, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 01:49:10', '2026-09-02 01:49:10', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(147, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 02:02:57', '2026-09-02 02:02:57', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 9, NULL),
(148, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 02:10:47', '2026-09-02 02:10:47', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 23, NULL),
(149, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 05:39:59', '2026-09-02 05:39:59', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(150, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 06:16:32', '2026-09-02 06:16:32', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(151, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 07:05:08', '2026-09-02 07:05:08', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 23, NULL),
(152, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 07:07:31', '2026-09-02 07:07:31', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(153, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 07:12:25', '2026-09-02 07:12:25', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(154, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 07:13:28', '2026-09-02 07:13:28', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(155, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 07:18:31', '2026-09-02 07:18:31', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(156, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 08:07:24', '2026-09-02 08:07:24', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(157, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 08:09:24', '2026-09-02 08:09:24', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 9, NULL),
(158, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 08:10:01', '2026-09-02 08:10:01', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 4, NULL),
(159, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 08:10:26', '2026-09-02 08:10:26', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(160, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 08:40:52', '2026-09-02 08:40:52', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 23, NULL),
(161, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 08:50:13', '2026-09-02 08:50:13', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 23, NULL),
(162, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 08:50:21', '2026-09-02 08:50:21', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(163, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 11:08:12', '2026-09-02 11:08:12', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(164, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-02 18:23:45', '2026-09-02 18:23:45', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(165, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-03 00:30:26', '2026-09-03 00:30:26', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(166, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-03 02:17:08', '2026-09-03 02:17:08', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(167, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-03 02:31:27', '2026-09-03 02:31:27', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 2, NULL),
(168, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-03 03:09:46', '2026-09-03 03:09:46', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 9, NULL),
(169, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-03 05:47:21', '2026-09-03 05:47:21', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(170, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-04 01:21:33', '2026-09-04 01:21:33', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(171, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-04 05:08:14', '2026-09-04 05:08:14', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 9, NULL),
(172, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-04 07:32:50', '2026-09-04 07:32:50', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 9, NULL),
(173, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-04 10:47:24', '2026-09-04 10:47:24', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 9, NULL),
(174, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-04 13:39:30', '2026-09-04 13:39:30', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(175, NULL, 'create request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-04 14:02:13', '2026-09-04 14:02:13', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(176, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-04 14:06:14', '2026-09-04 14:06:14', 'auth', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(177, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-04 14:09:51', '2026-09-04 14:09:51', 'auth', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(178, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-04 14:16:28', '2026-09-04 14:16:28', 'auth', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(179, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-04 14:18:41', '2026-09-04 14:18:41', 'pet', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(180, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-04 14:18:49', '2026-09-04 14:18:49', 'auth', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(181, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-05 06:04:15', '2026-09-05 06:04:15', 'auth', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(182, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-06 05:24:48', '2026-09-06 05:24:48', 'auth', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(183, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-06 07:48:03', '2026-09-06 07:48:03', 'auth', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(184, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-06 09:43:57', '2026-09-06 09:43:57', 'auth', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(185, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-06 09:44:15', '2026-09-06 09:44:15', 'auth', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(186, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-06 09:44:57', '2026-09-06 09:44:57', 'auth', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(187, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-07 15:13:50', '2026-09-07 15:13:50', 'auth', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(188, NULL, 'logout request to logout', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-07 16:29:39', '2026-09-07 16:29:39', 'auth', 'logout', 'failed', NULL, '127.0.0.1', 2, NULL),
(189, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-07 16:30:08', '2026-09-07 16:30:08', 'auth', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(190, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 01:01:02', '2026-09-08 01:01:02', 'auth', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(191, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 08:09:33', '2026-09-08 08:09:33', 'auth', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(192, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 08:10:38', '2026-09-08 08:10:38', 'auth', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(193, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 09:45:38', '2026-09-08 09:45:38', 'auth', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(194, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 09:45:45', '2026-09-08 09:45:45', 'auth', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(195, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 13:48:25', '2026-09-08 13:48:25', 'auth', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(196, NULL, 'Changed user Chelsy Alba status to deactivated', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 13:48:45', '2026-09-08 13:48:45', NULL, 'toggle_user_status', NULL, NULL, '127.0.0.1', 1, NULL),
(197, NULL, 'create request to super-admin/users/22/toggle-status', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 13:48:45', '2026-09-08 13:48:45', 'super-admin', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(198, NULL, 'Changed user Chelsy Alba status to active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 13:48:51', '2026-09-08 13:48:51', NULL, 'toggle_user_status', NULL, NULL, '127.0.0.1', 1, NULL),
(199, NULL, 'create request to super-admin/users/22/toggle-status', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 13:48:51', '2026-09-08 13:48:51', 'super-admin', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(200, NULL, 'Changed user Chelsy Alba status to deactivated', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 14:23:58', '2026-09-08 14:23:58', 'User Management', 'toggle_user_status', NULL, NULL, '127.0.0.1', 1, NULL),
(201, NULL, 'create request to super-admin/users/22/toggle-status', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 14:23:58', '2026-09-08 14:23:58', 'super-admin', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(202, NULL, 'Changed user Chelsy Alba status to active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 14:24:02', '2026-09-08 14:24:02', 'User Management', 'toggle_user_status', NULL, NULL, '127.0.0.1', 1, NULL),
(203, NULL, 'create request to super-admin/users/22/toggle-status', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 14:24:02', '2026-09-08 14:24:02', 'super-admin', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(204, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 16:41:22', '2026-09-08 16:41:22', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(205, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 21:46:30', '2026-09-08 21:46:30', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(206, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-08 22:22:44', '2026-09-08 22:22:44', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(207, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-10 14:30:46', '2026-09-10 14:30:46', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(208, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-10 17:17:20', '2026-09-10 17:17:20', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(209, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-10 20:54:44', '2026-09-10 20:54:44', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(210, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-11 03:38:27', '2026-09-11 03:38:27', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(211, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-11 03:38:51', '2026-09-11 03:38:51', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(212, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-11 03:39:01', '2026-09-11 03:39:01', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(213, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-11 03:45:34', '2026-09-11 03:45:34', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(214, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-13 07:19:47', '2026-09-13 07:19:47', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(215, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-13 13:00:37', '2026-09-13 13:00:37', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(216, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-13 15:14:40', '2026-09-13 15:14:40', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(217, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-13 15:41:31', '2026-09-13 15:41:31', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(218, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-13 15:41:38', '2026-09-13 15:41:38', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(219, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-14 14:40:34', '2026-09-14 14:40:34', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(220, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-15 04:14:01', '2026-09-15 04:14:01', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(221, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-15 14:54:31', '2026-09-15 14:54:31', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(222, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-15 18:53:14', '2026-09-15 18:53:14', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(223, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-15 19:01:34', '2026-09-15 19:01:34', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(224, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-17 02:34:26', '2026-09-17 02:34:26', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(225, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-17 02:46:40', '2026-09-17 02:46:40', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(226, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-17 02:55:04', '2026-09-17 02:55:04', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(227, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-19 06:43:17', '2026-09-19 06:43:17', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(228, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-19 12:56:46', '2026-09-19 12:56:46', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(229, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-19 13:37:46', '2026-09-19 13:37:46', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(230, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-19 13:45:46', '2026-09-19 13:45:46', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(231, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-22 01:45:02', '2026-09-22 01:45:02', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(232, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-22 03:00:28', '2026-09-22 03:00:28', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(233, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-22 12:34:05', '2026-09-22 12:34:05', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(234, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-23 01:58:28', '2026-09-23 01:58:28', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(235, NULL, 'update request to admin/vaccination-appointments/2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-23 01:58:43', '2026-09-23 01:58:43', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(236, NULL, 'update request to admin/vaccination-appointments/2/status', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-23 01:58:48', '2026-09-23 01:58:48', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(237, NULL, 'update request to admin/vaccination-appointments/2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-23 01:59:37', '2026-09-23 01:59:37', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(238, NULL, 'update request to admin/vaccination-appointments/6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-23 02:05:12', '2026-09-23 02:05:12', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(239, NULL, 'update request to admin/vaccination-appointments/6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-23 02:05:19', '2026-09-23 02:05:19', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(240, NULL, 'update request to admin/vaccination-appointments/6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-23 02:16:59', '2026-09-23 02:16:59', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(241, NULL, 'update request to admin/vaccination-appointments/6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-23 02:17:04', '2026-09-23 02:17:04', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(242, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-24 03:20:07', '2026-09-24 03:20:07', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(243, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-24 08:44:37', '2026-09-24 08:44:37', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(244, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-25 00:32:54', '2026-09-25 00:32:54', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(245, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-25 13:11:39', '2026-09-25 13:11:39', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(246, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-25 22:36:56', '2026-09-25 22:36:56', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(247, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-26 02:22:13', '2026-09-26 02:22:13', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(248, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-26 15:50:17', '2026-09-26 15:50:17', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(249, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-27 02:42:55', '2026-09-27 02:42:55', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(250, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-27 05:04:49', '2026-09-27 05:04:49', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(251, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-27 11:27:26', '2026-09-27 11:27:26', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(252, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-27 13:28:51', '2026-09-27 13:28:51', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(253, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-27 14:02:24', '2026-09-27 14:02:24', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(254, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-27 14:12:25', '2026-09-27 14:12:25', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(255, NULL, 'create request to adoption/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-27 18:10:46', '2026-09-27 18:10:46', 'adoption', 'create', 'failed', NULL, '127.0.0.1', 20, NULL),
(256, NULL, 'create request to adoption/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-27 18:23:03', '2026-09-27 18:23:03', 'adoption', 'create', 'failed', NULL, '127.0.0.1', 20, NULL),
(257, NULL, 'create request to adoption/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-27 18:37:30', '2026-09-27 18:37:30', 'adoption', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(258, NULL, 'create request to adoption/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-27 18:44:02', '2026-09-27 18:44:02', 'adoption', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(259, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-27 18:44:18', '2026-09-27 18:44:18', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(260, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-28 05:40:28', '2026-09-28 05:40:28', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL);
INSERT INTO `system_logs` (`id`, `log_name`, `description`, `subject_type`, `subject_id`, `event`, `properties`, `causer_id`, `causer_type`, `user_agent`, `created_at`, `updated_at`, `module`, `action`, `status`, `record_id`, `ip_address`, `user_id`, `role`) VALUES
(261, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-29 05:17:19', '2026-09-29 05:17:19', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(262, NULL, 'update request to admin/vaccination-appointments/6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-29 06:08:00', '2026-09-29 06:08:00', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(263, NULL, 'update request to admin/vaccination-appointments/2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-29 06:08:07', '2026-09-29 06:08:07', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(264, NULL, 'update request to admin/vaccination-appointments/4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-29 06:08:13', '2026-09-29 06:08:13', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(265, NULL, 'update request to admin/vaccination-appointments/3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-29 06:08:23', '2026-09-29 06:08:23', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(266, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-29 06:43:18', '2026-09-29 06:43:18', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(267, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-29 07:17:29', '2026-09-29 07:17:29', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(268, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-29 13:22:12', '2026-09-29 13:22:12', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(269, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-29 13:22:38', '2026-09-29 13:22:38', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(270, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-29 16:13:57', '2026-09-29 16:13:57', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(271, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-29 16:15:49', '2026-09-29 16:15:49', 'vaccination', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(272, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-30 03:24:42', '2026-09-30 03:24:42', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(273, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-30 13:03:42', '2026-09-30 13:03:42', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(274, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-30 20:22:23', '2026-09-30 20:22:23', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(275, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-30 20:25:48', '2026-09-30 20:25:48', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(276, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 00:08:51', '2026-10-01 00:08:51', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 4, NULL),
(277, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 00:09:50', '2026-10-01 00:09:50', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(278, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 00:12:11', '2026-10-01 00:12:11', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 9, NULL),
(279, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 00:16:52', '2026-10-01 00:16:52', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 6, NULL),
(280, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 00:17:20', '2026-10-01 00:17:20', 'Authentication', 'login', 'failed', NULL, '127.0.0.1', 6, NULL),
(281, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 00:17:23', '2026-10-01 00:17:23', 'Authentication', 'login', 'failed', NULL, '127.0.0.1', 6, NULL),
(282, NULL, 'logout request to logout', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 00:17:27', '2026-10-01 00:17:27', 'Authentication', 'logout', 'failed', NULL, '127.0.0.1', 6, NULL),
(283, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 00:45:11', '2026-10-01 00:45:11', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(284, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 00:54:03', '2026-10-01 00:54:03', 'vaccination', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(285, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 01:21:46', '2026-10-01 01:21:46', 'vaccination', 'create', 'failed', NULL, '127.0.0.1', 20, NULL),
(286, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 01:23:45', '2026-10-01 01:23:45', 'vaccination', 'create', 'failed', NULL, '127.0.0.1', 20, NULL),
(287, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 01:36:18', '2026-10-01 01:36:18', 'vaccination', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(288, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 01:52:51', '2026-10-01 01:52:51', 'vaccination', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(289, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 02:13:05', '2026-10-01 02:13:05', 'vaccination', 'create', 'failed', NULL, '127.0.0.1', 20, NULL),
(290, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 02:17:11', '2026-10-01 02:17:11', 'vaccination', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(291, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 02:17:54', '2026-10-01 02:17:54', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(292, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 02:30:27', '2026-10-01 02:30:27', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(293, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 06:28:45', '2026-10-01 06:28:45', 'vaccination', 'create', 'failed', NULL, '127.0.0.1', 20, NULL),
(294, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 07:20:31', '2026-10-01 07:20:31', 'vaccination', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(295, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 07:22:21', '2026-10-01 07:22:21', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(296, NULL, 'update request to admin/vaccination-appointments/5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 07:47:11', '2026-10-01 07:47:11', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(297, NULL, 'update request to admin/vaccination-appointments/5/status', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 07:47:18', '2026-10-01 07:47:18', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(298, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 09:30:52', '2026-10-01 09:30:52', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(299, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 09:34:06', '2026-10-01 09:34:06', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(300, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 09:36:25', '2026-10-01 09:36:25', 'vaccination', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(301, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 09:36:47', '2026-10-01 09:36:47', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(302, NULL, 'update request to admin/vaccination-appointments/5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-01 09:38:56', '2026-10-01 09:38:56', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(303, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 00:47:46', '2026-10-02 00:47:46', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(304, NULL, 'update request to admin/vaccination-appointments/6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 00:48:09', '2026-10-02 00:48:09', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(305, NULL, 'update request to admin/vaccination-appointments/5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 01:20:33', '2026-10-02 01:20:33', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(306, NULL, 'update request to admin/vaccination-appointments/5/status', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 01:20:41', '2026-10-02 01:20:41', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(307, NULL, 'update request to admin/vaccination-appointments/5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 01:20:46', '2026-10-02 01:20:46', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(308, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 04:52:53', '2026-10-02 04:52:53', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(309, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 05:03:55', '2026-10-02 05:03:55', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(310, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 05:05:06', '2026-10-02 05:05:06', 'Authentication', 'login', 'failed', NULL, '127.0.0.1', 20, NULL),
(311, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 05:05:10', '2026-10-02 05:05:10', 'Authentication', 'login', 'failed', NULL, '127.0.0.1', 20, NULL),
(312, NULL, 'logout request to logout', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 05:05:15', '2026-10-02 05:05:15', 'Authentication', 'logout', 'failed', NULL, '127.0.0.1', 20, NULL),
(313, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 07:17:15', '2026-10-02 07:17:15', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(314, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 07:26:00', '2026-10-02 07:26:00', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(315, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 07:27:02', '2026-10-02 07:27:02', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(316, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 13:20:11', '2026-10-02 13:20:11', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(317, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 18:39:28', '2026-10-02 18:39:28', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(318, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-03 03:15:00', '2026-10-03 03:15:00', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(319, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-03 17:33:35', '2026-10-03 17:33:35', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(320, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-03 23:51:32', '2026-10-03 23:51:32', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(321, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-05 05:24:36', '2026-10-05 05:24:36', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(322, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-05 17:45:49', '2026-10-05 17:45:49', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(323, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 06:01:40', '2026-10-07 06:01:40', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(324, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 08:27:44', '2026-10-07 08:27:44', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(325, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-08 00:14:04', '2026-10-08 00:14:04', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(326, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-09 04:06:48', '2026-10-09 04:06:48', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(327, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-09 04:31:48', '2026-10-09 04:31:48', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(328, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-09 17:37:40', '2026-10-09 17:37:40', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(329, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-09 23:09:24', '2026-10-09 23:09:24', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(330, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:37:48', '2026-10-10 10:37:48', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(331, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-10 18:35:40', '2026-10-10 18:35:40', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(332, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-11 00:16:46', '2026-10-11 00:16:46', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(333, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-11 05:29:36', '2026-10-11 05:29:36', 'pet', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(334, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-11 11:27:19', '2026-10-11 11:27:19', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(335, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-12 07:23:37', '2026-10-12 07:23:37', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(336, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-12 07:56:33', '2026-10-12 07:56:33', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(337, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-12 07:58:13', '2026-10-12 07:58:13', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(338, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-12 11:27:49', '2026-10-12 11:27:49', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(339, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-13 02:34:26', '2026-10-13 02:34:26', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(340, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-13 07:38:51', '2026-10-13 07:38:51', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(341, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-13 11:25:19', '2026-10-13 11:25:19', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(342, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-13 18:19:24', '2026-10-13 18:19:24', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(343, NULL, 'create request to kapon/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-13 22:25:35', '2026-10-13 22:25:35', 'Unknown', 'create', 'failed', NULL, '127.0.0.1', 20, NULL),
(344, NULL, 'create request to kapon/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-13 22:25:37', '2026-10-13 22:25:37', 'Unknown', 'create', 'failed', NULL, '127.0.0.1', 20, NULL),
(345, NULL, 'create request to kapon/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-13 22:28:40', '2026-10-13 22:28:40', 'Unknown', 'create', 'failed', NULL, '127.0.0.1', 20, NULL),
(346, NULL, 'create request to kapon/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-13 22:28:41', '2026-10-13 22:28:41', 'Unknown', 'create', 'failed', NULL, '127.0.0.1', 20, NULL),
(347, NULL, 'create request to kapon/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-13 22:29:45', '2026-10-13 22:29:45', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(348, NULL, 'create request to kapon/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-13 22:29:45', '2026-10-13 22:29:45', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(349, NULL, 'create request to kapon/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-13 22:29:45', '2026-10-13 22:29:45', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(350, NULL, 'create request to kapon/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-13 22:33:48', '2026-10-13 22:33:48', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(351, NULL, 'create request to kapon/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-13 22:33:49', '2026-10-13 22:33:49', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(352, NULL, 'create request to kapon/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-13 22:33:49', '2026-10-13 22:33:49', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(353, NULL, 'create request to kapon/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-13 22:33:49', '2026-10-13 22:33:49', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(354, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-13 22:44:24', '2026-10-13 22:44:24', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(355, NULL, 'create request to kapon/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 00:50:03', '2026-10-14 00:50:03', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(356, NULL, 'create request to kapon/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 00:54:39', '2026-10-14 00:54:39', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(357, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 00:56:41', '2026-10-14 00:56:41', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(358, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 00:56:55', '2026-10-14 00:56:55', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 4, NULL),
(359, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 00:57:30', '2026-10-14 00:57:30', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 9, NULL),
(360, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 00:59:11', '2026-10-14 00:59:11', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(361, NULL, 'User logged in via OTP verification', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 02:20:09', '2026-10-14 02:20:09', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 24, NULL),
(362, NULL, 'create request to otp/verify', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 02:20:13', '2026-10-14 02:20:13', 'otp', 'create', 'success', NULL, '127.0.0.1', 24, NULL),
(363, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 02:22:39', '2026-10-14 02:22:39', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 24, NULL),
(364, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 02:29:03', '2026-10-14 02:29:03', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(365, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 02:29:24', '2026-10-14 02:29:24', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 24, NULL),
(366, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 02:44:27', '2026-10-14 02:44:27', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(367, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 04:18:15', '2026-10-14 04:18:15', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(368, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 04:22:48', '2026-10-14 04:22:48', 'pet', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(369, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 04:43:30', '2026-10-14 04:43:30', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(370, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 04:43:59', '2026-10-14 04:43:59', 'Authentication', 'login', 'failed', NULL, '127.0.0.1', 20, NULL),
(371, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 04:44:03', '2026-10-14 04:44:03', 'Authentication', 'login', 'failed', NULL, '127.0.0.1', 20, NULL),
(372, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 04:51:25', '2026-10-14 04:51:25', 'pet', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(373, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 04:53:38', '2026-10-14 04:53:38', 'vaccination', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(374, NULL, 'create request to adoption/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 04:57:18', '2026-10-14 04:57:18', 'adoption', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(375, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 04:57:36', '2026-10-14 04:57:36', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(376, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-15 01:14:45', '2026-10-15 01:14:45', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(377, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-15 01:21:36', '2026-10-15 01:21:36', 'pet', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(378, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-15 03:50:15', '2026-10-15 03:50:15', 'pet', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(379, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-15 05:34:49', '2026-10-15 05:34:49', 'pet', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(380, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-15 06:04:03', '2026-10-15 06:04:03', 'pet', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(381, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-15 06:15:07', '2026-10-15 06:15:07', 'pet', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(382, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-15 06:15:53', '2026-10-15 06:15:53', 'vaccination', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(383, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-15 12:23:35', '2026-10-15 12:23:35', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(384, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-15 16:59:00', '2026-10-15 16:59:00', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(385, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-15 19:14:13', '2026-10-15 19:14:13', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(386, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-16 00:36:29', '2026-10-16 00:36:29', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(387, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-16 06:10:49', '2026-10-16 06:10:49', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(388, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-16 13:13:39', '2026-10-16 13:13:39', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(389, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-16 20:07:18', '2026-10-16 20:07:18', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(390, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-17 03:36:14', '2026-10-17 03:36:14', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(391, NULL, 'create request to adoption/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-17 04:02:10', '2026-10-17 04:02:10', 'adoption', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(392, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-17 22:41:49', '2026-10-17 22:41:49', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(393, NULL, 'create request to missing-pets/report', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-18 00:11:59', '2026-10-18 00:11:59', 'missing-pets', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(394, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-18 01:34:55', '2026-10-18 01:34:55', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(395, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-18 05:41:30', '2026-10-18 05:41:30', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(396, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-18 10:24:17', '2026-10-18 10:24:17', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(397, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-18 19:36:45', '2026-10-18 19:36:45', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(398, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-19 05:59:43', '2026-10-19 05:59:43', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(399, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-19 06:13:32', '2026-10-19 06:13:32', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(400, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-19 06:15:57', '2026-10-19 06:15:57', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(401, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-19 11:13:59', '2026-10-19 11:13:59', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(402, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-19 21:42:11', '2026-10-19 21:42:11', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(403, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-20 04:31:54', '2026-10-20 04:31:54', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(404, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-20 04:34:36', '2026-10-20 04:34:36', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(405, NULL, 'User logged in via OTP verification', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-20 05:53:25', '2026-10-20 05:53:25', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 27, NULL),
(406, NULL, 'create request to otp/verify', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-20 05:53:33', '2026-10-20 05:53:33', 'otp', 'create', 'success', NULL, '127.0.0.1', 27, NULL),
(407, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-20 06:00:17', '2026-10-20 06:00:17', 'pet', 'create', 'success', NULL, '127.0.0.1', 27, NULL),
(408, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-20 06:02:46', '2026-10-20 06:02:46', 'vaccination', 'create', 'success', NULL, '127.0.0.1', 27, NULL),
(409, NULL, 'create request to missing-pets/report', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-20 06:05:02', '2026-10-20 06:05:02', 'missing-pets', 'create', 'success', NULL, '127.0.0.1', 27, NULL),
(410, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-20 06:05:53', '2026-10-20 06:05:53', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(411, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-20 06:07:37', '2026-10-20 06:07:37', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(412, NULL, 'update request to admin/vaccination-appointments/11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-20 06:09:34', '2026-10-20 06:09:34', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(413, NULL, 'update request to admin/vaccination-appointments/10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-20 06:09:53', '2026-10-20 06:09:53', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(414, NULL, 'update request to admin/vaccination-appointments/10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-20 06:10:07', '2026-10-20 06:10:07', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(415, NULL, 'update request to admin/vaccination-appointments/7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-20 06:10:25', '2026-10-20 06:10:25', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(416, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-20 06:15:17', '2026-10-20 06:15:17', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(417, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-21 00:11:56', '2026-10-21 00:11:56', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(418, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-21 00:12:30', '2026-10-21 00:12:30', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(419, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-21 00:21:59', '2026-10-21 00:21:59', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(420, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-21 00:22:12', '2026-10-21 00:22:12', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(421, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-21 04:58:35', '2026-10-21 04:58:35', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(422, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-21 11:36:55', '2026-10-21 11:36:55', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(423, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-21 17:32:13', '2026-10-21 17:32:13', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(424, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-21 21:43:08', '2026-10-21 21:43:08', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(425, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-22 07:20:28', '2026-10-22 07:20:28', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(426, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-23 06:38:43', '2026-10-23 06:38:43', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(427, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-23 15:12:11', '2026-10-23 15:12:11', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(428, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-25 13:17:35', '2026-10-25 13:17:35', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(429, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-25 13:18:36', '2026-10-25 13:18:36', 'Authentication', 'login', 'failed', NULL, '127.0.0.1', 20, NULL),
(430, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-25 21:28:21', '2026-10-25 21:28:21', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(431, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-26 03:50:00', '2026-10-26 03:50:00', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(432, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-26 20:35:31', '2026-10-26 20:35:31', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(433, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-27 01:38:50', '2026-10-27 01:38:50', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(434, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-27 04:50:48', '2026-10-27 04:50:48', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(435, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-27 04:58:47', '2026-10-27 04:58:47', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(436, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-27 11:26:14', '2026-10-27 11:26:14', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(437, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-27 13:53:54', '2026-10-27 13:53:54', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(438, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-27 16:57:49', '2026-10-27 16:57:49', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(439, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-27 22:11:28', '2026-10-27 22:11:28', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(440, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-27 22:23:05', '2026-10-27 22:23:05', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(441, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-27 22:41:27', '2026-10-27 22:41:27', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(442, NULL, 'update request to admin/vaccination-appointments/10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-27 22:42:01', '2026-10-27 22:42:01', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(443, NULL, 'update request to admin/vaccination-appointments/7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-27 22:42:07', '2026-10-27 22:42:07', 'vaccination-appointments', 'update', 'success', NULL, '127.0.0.1', 2, NULL),
(444, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-27 22:48:51', '2026-10-27 22:48:51', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(445, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-28 02:25:44', '2026-10-28 02:25:44', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(446, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-28 10:46:26', '2026-10-28 10:46:26', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(447, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-28 19:30:56', '2026-10-28 19:30:56', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(448, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-28 22:44:46', '2026-10-28 22:44:46', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(449, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-28 23:36:45', '2026-10-28 23:36:45', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(450, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-29 01:12:48', '2026-10-29 01:12:48', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 4, NULL),
(451, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-29 01:26:14', '2026-10-29 01:26:14', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(452, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-29 01:27:45', '2026-10-29 01:27:45', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 4, NULL),
(453, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-29 03:20:53', '2026-10-29 03:20:53', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 9, NULL),
(454, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-29 03:38:15', '2026-10-29 03:38:15', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(455, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-29 04:55:31', '2026-10-29 04:55:31', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 9, NULL),
(456, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-30 00:12:23', '2026-10-30 00:12:23', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(457, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-30 00:12:40', '2026-10-30 00:12:40', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(458, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-30 00:28:12', '2026-10-30 00:28:12', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(459, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-30 00:28:20', '2026-10-30 00:28:20', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(460, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-30 00:38:15', '2026-10-30 00:38:15', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(461, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-30 12:06:09', '2026-10-30 12:06:09', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(462, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-30 12:10:55', '2026-10-30 12:10:55', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(463, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-30 12:29:36', '2026-10-30 12:29:36', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(464, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-30 12:34:17', '2026-10-30 12:34:17', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(465, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-30 12:36:33', '2026-10-30 12:36:33', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(466, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-30 22:12:27', '2026-10-30 22:12:27', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(467, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-30 22:25:05', '2026-10-30 22:25:05', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(468, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-30 23:21:12', '2026-10-30 23:21:12', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(469, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-30 23:40:14', '2026-10-30 23:40:14', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(470, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-30 23:40:21', '2026-10-30 23:40:21', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(471, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-30 23:43:06', '2026-10-30 23:43:06', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(472, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-31 05:40:07', '2026-10-31 05:40:07', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(473, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-31 14:56:56', '2026-10-31 14:56:56', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(474, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-31 16:44:23', '2026-10-31 16:44:23', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(475, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-31 16:51:35', '2026-10-31 16:51:35', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 9, NULL),
(476, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 01:15:25', '2026-11-01 01:15:25', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 9, NULL),
(477, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 01:15:45', '2026-11-01 01:15:45', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(478, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 01:30:11', '2026-11-01 01:30:11', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(479, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 11:08:10', '2026-11-01 11:08:10', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(480, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 13:47:35', '2026-11-01 13:47:35', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(481, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 14:08:35', '2026-11-01 14:08:35', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(482, NULL, 'User logged in via OTP verification', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 14:49:19', '2026-11-01 14:49:19', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 30, NULL),
(483, NULL, 'create request to otp/verify', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 14:49:23', '2026-11-01 14:49:23', 'otp', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(484, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 14:53:40', '2026-11-01 14:53:40', 'pet', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(485, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 15:03:06', '2026-11-01 15:03:06', 'vaccination', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(486, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 15:09:57', '2026-11-01 15:09:57', 'vaccination', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(487, NULL, 'create request to kapon/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 15:39:44', '2026-11-01 15:39:44', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(488, NULL, 'create request to adoption/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 16:05:09', '2026-11-01 16:05:09', 'adoption', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(489, NULL, 'create request to missing-pets/report', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 18:03:59', '2026-11-01 18:03:59', 'missing-pets', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(490, NULL, 'create request to missing-pets/report', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 18:21:35', '2026-11-01 18:21:35', 'missing-pets', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(491, NULL, 'create request to missing-pets/report', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 18:23:17', '2026-11-01 18:23:17', 'missing-pets', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(492, NULL, 'create request to missing-pets/report', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 19:03:33', '2026-11-01 19:03:33', 'missing-pets', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(493, NULL, 'create request to found-pets/report', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 19:04:36', '2026-11-01 19:04:36', 'found-pets', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(494, NULL, 'create request to found-pets/report', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-01 20:01:33', '2026-11-01 20:01:33', 'found-pets', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(495, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 07:09:15', '2026-11-02 07:09:15', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(496, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 07:09:27', '2026-11-02 07:09:27', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(497, NULL, 'delete request to super-admin/announcements/8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 07:21:56', '2026-11-02 07:21:56', 'announcements', 'delete', 'success', NULL, '127.0.0.1', 1, NULL),
(498, NULL, 'delete request to super-admin/announcements/6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 07:22:00', '2026-11-02 07:22:00', 'announcements', 'delete', 'success', NULL, '127.0.0.1', 1, NULL),
(499, NULL, 'delete request to super-admin/announcements/5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 07:22:04', '2026-11-02 07:22:04', 'announcements', 'delete', 'success', NULL, '127.0.0.1', 1, NULL),
(500, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 09:34:15', '2026-11-02 09:34:15', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(501, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 11:29:59', '2026-11-02 11:29:59', 'announcements', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(502, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 11:32:24', '2026-11-02 11:32:24', 'announcements', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(503, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 11:32:43', '2026-11-02 11:32:43', 'announcements', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(504, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 11:39:49', '2026-11-02 11:39:49', 'announcements', 'create', 'failed', NULL, '127.0.0.1', 1, NULL),
(505, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 11:42:45', '2026-11-02 11:42:45', 'announcements', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(506, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 11:48:13', '2026-11-02 11:48:13', 'announcements', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(507, NULL, 'delete request to super-admin/announcements/9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 11:48:19', '2026-11-02 11:48:19', 'announcements', 'delete', 'success', NULL, '127.0.0.1', 1, NULL),
(508, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 11:53:20', '2026-11-02 11:53:20', 'announcements', 'create', 'failed', NULL, '127.0.0.1', 1, NULL),
(509, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 12:14:04', '2026-11-02 12:14:04', 'announcements', 'create', 'failed', NULL, '127.0.0.1', 1, NULL),
(510, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 12:20:54', '2026-11-02 12:20:54', 'announcements', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(511, NULL, 'create request to super-admin/announcements', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 12:22:59', '2026-11-02 12:22:59', 'announcements', 'create', 'success', NULL, '127.0.0.1', 1, NULL),
(512, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 13:15:08', '2026-11-02 13:15:08', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL);
INSERT INTO `system_logs` (`id`, `log_name`, `description`, `subject_type`, `subject_id`, `event`, `properties`, `causer_id`, `causer_type`, `user_agent`, `created_at`, `updated_at`, `module`, `action`, `status`, `record_id`, `ip_address`, `user_id`, `role`) VALUES
(513, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 13:15:21', '2026-11-02 13:15:21', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 30, NULL),
(514, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 16:31:31', '2026-11-02 16:31:31', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(515, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 16:32:18', '2026-11-02 16:32:18', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(516, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 16:48:59', '2026-11-02 16:48:59', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(517, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-02 16:49:16', '2026-11-02 16:49:16', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(518, NULL, 'User logged in via OTP verification', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 04:07:32', '2026-11-03 04:07:32', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 31, NULL),
(519, NULL, 'create request to otp/verify', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 04:07:40', '2026-11-03 04:07:40', 'otp', 'create', 'success', NULL, '127.0.0.1', 31, NULL),
(520, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 04:13:42', '2026-11-03 04:13:42', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 30, NULL),
(521, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 04:21:37', '2026-11-03 04:21:37', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(522, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 04:33:09', '2026-11-03 04:33:09', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(523, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 04:37:35', '2026-11-03 04:37:35', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 4, NULL),
(524, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 04:38:49', '2026-11-03 04:38:49', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 9, NULL),
(525, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 04:49:52', '2026-11-03 04:49:52', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 30, NULL),
(526, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 04:53:06', '2026-11-03 04:53:06', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(527, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 04:57:54', '2026-11-03 04:57:54', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 1, NULL),
(528, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 07:50:28', '2026-11-03 07:50:28', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 30, NULL),
(529, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 07:56:58', '2026-11-03 07:56:58', 'pet', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(530, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 08:00:08', '2026-11-03 08:00:08', 'vaccination', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(531, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 08:02:47', '2026-11-03 08:02:47', 'pet', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(532, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 08:12:01', '2026-11-03 08:12:01', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 2, NULL),
(533, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 12:50:33', '2026-11-03 12:50:33', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 30, NULL),
(534, NULL, 'update request to owner/adoption-applications/6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 15:40:34', '2026-11-03 15:40:34', 'owner', 'update', 'failed', NULL, '127.0.0.1', 30, NULL),
(535, NULL, 'update request to owner/adoption-applications/6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 15:40:41', '2026-11-03 15:40:41', 'owner', 'update', 'failed', NULL, '127.0.0.1', 30, NULL),
(536, NULL, 'update request to owner/adoption-applications/6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 15:42:12', '2026-11-03 15:42:12', 'owner', 'update', 'success', NULL, '127.0.0.1', 30, NULL),
(537, NULL, 'update request to owner/adoption-applications/6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 15:53:24', '2026-11-03 15:53:24', 'owner', 'update', 'success', NULL, '127.0.0.1', 30, NULL),
(538, NULL, 'update request to owner/adoption-applications/6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 15:59:20', '2026-11-03 15:59:20', 'owner', 'update', 'success', NULL, '127.0.0.1', 30, NULL),
(539, NULL, 'update request to owner/appointments/14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 16:01:50', '2026-11-03 16:01:50', 'owner', 'update', 'failed', NULL, '127.0.0.1', 30, NULL),
(540, NULL, 'update request to owner/appointments/14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 16:01:56', '2026-11-03 16:01:56', 'owner', 'update', 'failed', NULL, '127.0.0.1', 30, NULL),
(541, NULL, 'update request to owner/appointments/14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 16:02:01', '2026-11-03 16:02:01', 'owner', 'update', 'failed', NULL, '127.0.0.1', 30, NULL),
(542, NULL, 'update request to owner/appointments/14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 16:05:21', '2026-11-03 16:05:21', 'owner', 'update', 'success', NULL, '127.0.0.1', 30, NULL),
(543, NULL, 'update request to owner/appointments/14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 16:05:47', '2026-11-03 16:05:47', 'owner', 'update', 'success', NULL, '127.0.0.1', 30, NULL),
(544, NULL, 'update request to owner/appointments/13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 16:08:24', '2026-11-03 16:08:24', 'owner', 'update', 'success', NULL, '127.0.0.1', 30, NULL),
(545, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 20:04:52', '2026-11-03 20:04:52', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 30, NULL),
(546, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 20:53:23', '2026-11-03 20:53:23', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(547, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 20:54:52', '2026-11-03 20:54:52', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 30, NULL),
(548, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-03 20:58:59', '2026-11-03 20:58:59', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 30, NULL),
(549, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 05:56:49', '2026-11-04 05:56:49', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 30, NULL),
(550, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 06:04:10', '2026-11-04 06:04:10', 'pet', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(551, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 06:05:48', '2026-11-04 06:05:48', 'vaccination', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(552, NULL, 'create request to missing-pets/report', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 06:11:25', '2026-11-04 06:11:25', 'missing-pets', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(553, NULL, 'create request to adoption/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 06:26:04', '2026-11-04 06:26:04', 'adoption', 'create', 'success', NULL, '127.0.0.1', 30, NULL),
(554, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 13:31:45', '2026-11-04 13:31:45', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 30, NULL),
(555, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 13:36:18', '2026-11-04 13:36:18', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 30, NULL),
(556, NULL, 'login request to login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 13:40:54', '2026-11-04 13:40:54', 'Authentication', 'login', 'success', NULL, '127.0.0.1', 20, NULL),
(557, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 14:01:53', '2026-11-04 14:01:53', 'pet', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(558, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 14:05:11', '2026-11-04 14:05:11', 'pet', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(559, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 14:17:26', '2026-11-04 14:17:26', 'pet', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(560, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 14:22:14', '2026-11-04 14:22:14', 'pet', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(561, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 14:23:53', '2026-11-04 14:23:53', 'pet', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(562, NULL, 'create request to pet-registration/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 14:28:43', '2026-11-04 14:28:43', 'pet', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(563, NULL, 'create request to api/kapon/previous-surgery/24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 15:11:28', '2026-11-04 15:11:28', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(564, NULL, 'create request to api/kapon/previous-surgery/24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 15:11:33', '2026-11-04 15:11:33', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(565, NULL, 'create request to kapon/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 15:17:37', '2026-11-04 15:17:37', 'Unknown', 'create', 'success', NULL, '127.0.0.1', 20, NULL),
(566, NULL, 'create request to vaccination/form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-04 15:20:45', '2026-11-04 15:20:45', 'vaccination', 'create', 'success', NULL, '127.0.0.1', 20, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `traits`
--

CREATE TABLE `traits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `traits`
--

INSERT INTO `traits` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Friendly', '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(2, 'Playful', '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(3, 'Calm', '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(4, 'Energetic', '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(5, 'Loyal', '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(6, 'Gentle', '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(7, 'Intelligent', '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(8, 'Protective', '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(9, 'Affectionate', '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(10, 'Good with kids', '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(11, 'Good with other pets', '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(12, 'House trained', '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(13, 'Leash trained', '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(14, 'Quiet', '2026-04-28 19:15:38', '2026-04-28 19:15:38'),
(15, 'Curious', '2026-04-28 19:15:38', '2026-04-28 19:15:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'pet_owner',
  `email` varchar(255) NOT NULL,
  `otp_code` varchar(255) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','deactivated') DEFAULT 'active',
  `organization_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `facility_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `email`, `otp_code`, `otp_expires_at`, `is_verified`, `email_verified_at`, `password`, `status`, `organization_id`, `remember_token`, `created_at`, `updated_at`, `barangay_id`, `facility_id`) VALUES
(1, 'super_admin', 'superadmin@vetmis.gov', NULL, NULL, 0, NULL, '$2y$12$VnnvAjGIN3Q198GNqUSE6eNlthAWwAW65eppNMlCIea3KKrI2vwza', 'active', NULL, NULL, '2026-04-28 19:15:30', '2026-04-28 19:15:30', NULL, NULL),
(2, 'city_vet', 'cityvet@vetmis.gov', NULL, NULL, 0, NULL, '$2y$12$CzrY5cjTim/mUDDlVThjk.ZTJpGVqYgAukCo1w1W68.jXYllBEQZ2', 'active', NULL, NULL, '2026-04-28 19:15:31', '2026-04-28 19:15:31', NULL, NULL),
(4, 'assistant_vet', 'assistantvet@vetmis.gov', NULL, NULL, 0, NULL, '$2y$12$OAprRpKuMfEF.CFvxzAjROg/3cUp7UvH86SZ6agqCdH6JpBRpGuSS', 'active', NULL, NULL, '2026-04-28 19:15:32', '2026-04-28 19:15:32', NULL, NULL),
(6, 'meat_inspector', 'meatinspector@vetmis.gov', NULL, NULL, 0, NULL, '$2y$12$VbZ8QcO72kSHafnz8nySG.8PG5lb1jxLWxFEM6mQWyUox5UUHlAl.', 'active', NULL, NULL, '2026-04-28 19:15:33', '2026-04-28 19:15:33', NULL, NULL),
(9, 'admin_asst', 'adminasst@vetmis.gov', NULL, NULL, 0, NULL, '$2y$12$XvDNzsDOHBda65vhzUPc9OUiGBoOGzap83z1kRaQ3ph82IMKbvlcC', 'active', NULL, NULL, '2026-04-28 19:15:35', '2026-04-28 19:15:35', NULL, NULL),
(20, 'pet_owner', 'sawkevin581@gmail.com', NULL, NULL, 1, NULL, '$2y$12$bjeBuBY/quFFO9lpS88zAevgYhASAttk6yyyuAlRCOy4i4ZTT75ju', 'active', NULL, 'Vm9EvfwB6mooQp6SK2PRSD5hsB5PeJoPayp8gAbjQPTAwRjqXfwJ5r9epm3t', '2026-06-04 03:23:07', '2026-10-31 14:56:42', NULL, NULL),
(27, 'pet_owner', 'albajoychelsy2@gmail.com', NULL, NULL, 1, NULL, '$2y$12$U5CB44ZL8wkEoaYiNEtjGOb83VFVcKCWuk.KIo1vOGQi77lEHHJL2', 'active', NULL, NULL, '2026-10-20 05:52:35', '2026-10-20 05:53:25', NULL, NULL),
(30, 'pet_owner', 'keryuxo@gmail.com', NULL, NULL, 1, NULL, '$2y$12$GW98P0Zr1tCuzWjbwIbDH.blTqDhVNulVZJrUzjzFtvkqOhXlx6HS', 'active', NULL, NULL, '2026-11-01 14:48:58', '2026-11-01 14:49:19', NULL, NULL),
(31, 'pet_owner', 'cjdlalba@kld.edu.ph', NULL, NULL, 1, NULL, '$2y$12$xqRljCNRWwZRb9AYGeTVAertxyMkwbFbjPpxiX9YSwhuUKPrSy..W', 'active', NULL, NULL, '2026-11-03 04:06:50', '2026-11-03 04:07:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vaccination_appointments`
--

CREATE TABLE `vaccination_appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pet_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `scheduled_at` datetime DEFAULT NULL,
  `event_id` bigint(20) UNSIGNED DEFAULT NULL,
  `appointment_mode` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `last_anti_rabies_date` date DEFAULT NULL,
  `recent_surgery` tinyint(1) NOT NULL DEFAULT 0,
  `clinic_name` varchar(255) DEFAULT NULL,
  `vaccination_certificate` varchar(255) DEFAULT NULL,
  `vaccine_lot_number` varchar(255) DEFAULT NULL,
  `vaccination_certificate_path` varchar(255) DEFAULT NULL,
  `assigned_vet` bigint(20) UNSIGNED DEFAULT 2,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vaccination_appointments`
--

INSERT INTO `vaccination_appointments` (`id`, `pet_id`, `user_id`, `owner_id`, `address_id`, `scheduled_at`, `event_id`, `appointment_mode`, `status`, `last_anti_rabies_date`, `recent_surgery`, `clinic_name`, `vaccination_certificate`, `vaccine_lot_number`, `vaccination_certificate_path`, `assigned_vet`, `created_at`, `updated_at`, `notes`) VALUES
(5, 24, 20, 6, 6, '2026-10-03 09:00:00', NULL, NULL, 'completed', NULL, 0, NULL, NULL, NULL, NULL, 2, '2026-10-01 07:20:31', '2026-10-02 01:20:46', NULL),
(7, 35, 20, 6, 6, '2026-10-15 09:00:00', NULL, NULL, 'completed', NULL, 0, NULL, NULL, NULL, NULL, 4, '2026-10-14 04:53:38', '2026-10-27 22:42:07', NULL),
(8, 24, 20, 6, 6, '2026-10-15 09:00:00', NULL, NULL, 'pending', NULL, 0, NULL, NULL, NULL, NULL, 2, '2026-10-14 04:53:38', '2026-10-14 04:53:38', NULL),
(9, 19, 20, 6, 6, '2026-10-15 09:00:00', NULL, NULL, 'pending', NULL, 0, NULL, NULL, NULL, NULL, 2, '2026-10-14 04:53:38', '2026-10-14 04:53:38', NULL),
(13, NULL, 30, 16, 22, '2026-11-06 08:00:00', NULL, NULL, 'pending', NULL, 0, NULL, NULL, NULL, NULL, 2, '2026-11-01 15:09:57', '2026-11-01 15:09:57', NULL),
(14, NULL, 30, 16, 22, '2026-11-13 00:00:00', NULL, NULL, 'pending', NULL, 0, NULL, NULL, NULL, NULL, 2, '2026-11-03 08:00:08', '2026-11-03 16:05:47', 'needs to go to school'),
(15, NULL, 30, 16, 22, '2026-11-13 09:00:00', NULL, NULL, 'pending', NULL, 0, NULL, NULL, NULL, NULL, 2, '2026-11-04 06:05:48', '2026-11-04 06:05:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vaccination_reports`
--

CREATE TABLE `vaccination_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vaccination_appointment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pet_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pet_name` varchar(255) DEFAULT NULL,
  `pet_species` varchar(255) DEFAULT NULL,
  `pet_breed` varchar(255) DEFAULT NULL,
  `pet_gender` varchar(255) DEFAULT NULL,
  `pet_age` varchar(50) DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `barangay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vaccine_brand` varchar(255) DEFAULT NULL,
  `vaccine_batch_number` varchar(255) DEFAULT NULL,
  `vaccination_type` varchar(255) DEFAULT NULL,
  `vaccination_date` date DEFAULT NULL,
  `vaccination_time` time DEFAULT NULL,
  `next_vaccination_date` date DEFAULT NULL,
  `inventory_control_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity_deducted` int(11) DEFAULT 1,
  `administered_by` bigint(20) UNSIGNED DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `not_vaccinated` tinyint(1) NOT NULL DEFAULT 0,
  `vaccination_records` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`vaccination_records`)),
  `anti_rabies_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`anti_rabies_details`)),
  `vaccination_card_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vaccination_reports`
--

INSERT INTO `vaccination_reports` (`id`, `vaccination_appointment_id`, `pet_id`, `pet_name`, `pet_species`, `pet_breed`, `pet_gender`, `pet_age`, `weight`, `barangay_id`, `vaccine_brand`, `vaccine_batch_number`, `vaccination_type`, `vaccination_date`, `vaccination_time`, `next_vaccination_date`, `inventory_control_id`, `quantity_deducted`, `administered_by`, `observations`, `notes`, `status`, `created_at`, `updated_at`, `not_vaccinated`, `vaccination_records`, `anti_rabies_details`, `vaccination_card_path`) VALUES
(1, 5, 24, 'Swoosh', 'cat', 'Mixed Breed (Puspin)', 'female', '3', NULL, 27, NULL, 'G64884', NULL, '2026-10-03', '09:00:00', NULL, NULL, 1, 2, NULL, NULL, 'completed', '2026-10-02 01:20:46', '2026-10-02 01:20:46', 0, NULL, NULL, NULL),
(30, 7, 35, 'Lemon', 'cat', 'Puspin', 'male', '3 years 4 months', NULL, 27, NULL, 'G64884', NULL, '2026-10-15', '09:00:00', NULL, NULL, 1, 2, NULL, NULL, 'completed', '2026-10-20 06:10:25', '2026-10-20 06:10:25', 0, NULL, NULL, NULL),
(31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'completed', '2026-11-01 14:53:40', '2026-11-01 14:53:40', 0, '[{\"name\":\"Anti-Rabies\",\"type\":\"core\",\"date_administered\":\"2025-02-27\",\"lot_no\":null,\"tag_no\":null},{\"name\":\"4-in-1 \\/ 3-in-1 (FVRCP - Rhinotracheitis, Calicivirus, Panleukopenia)\",\"type\":\"core\"},{\"name\":\"Feline Leukemia (FeLV)\",\"type\":\"optional\"}]', '{\"date_administered\":\"2025-02-27\",\"lot_no\":null,\"tag_no\":null}', 'images/vaccination_cards/vaccination_card_70_1793544820_6ae752746b440.jpg'),
(32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'completed', '2026-11-03 07:56:58', '2026-11-03 07:56:58', 0, '[{\"name\":\"Anti-Rabies\",\"type\":\"core\",\"date_administered\":\"2025-07-03\",\"lot_no\":null,\"tag_no\":null},{\"name\":\"4-in-1 \\/ 3-in-1 (FVRCP - Rhinotracheitis, Calicivirus, Panleukopenia)\",\"type\":\"core\"}]', '{\"date_administered\":\"2025-07-03\",\"lot_no\":null,\"tag_no\":null}', NULL),
(33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'completed', '2026-11-03 08:02:47', '2026-11-03 08:02:47', 1, '[]', NULL, NULL),
(34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'completed', '2026-11-04 06:04:09', '2026-11-04 06:04:09', 0, '[{\"name\":\"Anti-Rabies\",\"type\":\"core\",\"date_administered\":\"2025-02-05\",\"lot_no\":null,\"tag_no\":null,\"vaccine_brand\":\"Rabisin\"},{\"name\":\"4-in-1 \\/ 3-in-1 (FVRCP - Rhinotracheitis, Calicivirus, Panleukopenia)\",\"type\":\"core\"}]', '{\"date_administered\":\"2025-02-05\",\"lot_no\":null,\"tag_no\":null,\"vaccine_brand\":\"Rabisin\",\"vaccine_brand_other\":null}', NULL),
(35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'completed', '2026-11-04 14:01:53', '2026-11-04 14:01:53', 0, '[{\"name\":\"Anti-Rabies\",\"type\":\"core\",\"date_administered\":\"2025-03-06\",\"lot_no\":\"G18231\",\"tag_no\":\"DAS-2026-002\",\"vaccine_brand\":\"Rabisin\"},{\"name\":\"4-in-1 \\/ 3-in-1 (FVRCP - Rhinotracheitis, Calicivirus, Panleukopenia)\",\"type\":\"core\"},{\"name\":\"Feline Leukemia (FeLV)\",\"type\":\"optional\"}]', '{\"date_administered\":\"2025-03-06\",\"lot_no\":\"G18231\",\"tag_no\":\"DAS-2026-002\",\"vaccine_brand\":\"Rabisin\",\"vaccine_brand_other\":null}', 'images/vaccination_cards/vaccination_card_74_1793800913_6aeb3ad115332.jpg'),
(36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'completed', '2026-11-04 14:05:11', '2026-11-04 14:05:11', 0, '[{\"name\":\"Anti-Rabies\",\"type\":\"core\",\"date_administered\":\"2026-07-02\",\"lot_no\":null,\"tag_no\":null,\"vaccine_brand\":\"Rabisin\"},{\"name\":\"4-in-1 \\/ 3-in-1 (FVRCP - Rhinotracheitis, Calicivirus, Panleukopenia)\",\"type\":\"core\"},{\"name\":\"Feline Leukemia (FeLV)\",\"type\":\"optional\"}]', '{\"date_administered\":\"2026-07-02\",\"lot_no\":null,\"tag_no\":null,\"vaccine_brand\":\"Rabisin\",\"vaccine_brand_other\":null}', NULL),
(37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'completed', '2026-11-04 14:17:26', '2026-11-04 14:17:26', 1, '[]', NULL, NULL),
(38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'completed', '2026-11-04 14:22:14', '2026-11-04 14:22:14', 1, '[]', NULL, NULL),
(39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'completed', '2026-11-04 14:23:53', '2026-11-04 14:23:53', 0, '[{\"name\":\"Anti-Rabies\",\"type\":\"core\",\"date_administered\":\"2026-11-04\",\"lot_no\":null,\"tag_no\":null,\"vaccine_brand\":\"Rabisin\"}]', '{\"date_administered\":\"2026-11-04\",\"lot_no\":null,\"tag_no\":null,\"vaccine_brand\":\"Rabisin\",\"vaccine_brand_other\":null}', NULL),
(40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'completed', '2026-11-04 14:28:43', '2026-11-04 14:28:43', 0, '[{\"name\":\"Anti-Rabies\",\"type\":\"core\",\"date_administered\":\"2026-11-04\",\"lot_no\":null,\"tag_no\":null,\"vaccine_brand\":\"Rabisin\"}]', '{\"date_administered\":\"2026-11-04\",\"lot_no\":null,\"tag_no\":null,\"vaccine_brand\":\"Rabisin\",\"vaccine_brand_other\":null}', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_polymorphic_index` (`addressable_type`,`addressable_id`),
  ADD KEY `addresses_barangay_id_index` (`barangay_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admins_user_id_foreign` (`user_id`),
  ADD KEY `admins_facility_id_index` (`facility_id`);

--
-- Indexes for table `adoption_applications`
--
ALTER TABLE `adoption_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adoption_applications_user_id_index` (`user_id`),
  ADD KEY `adoption_applications_adopted_before_index` (`adopted_before`),
  ADD KEY `adoption_applications_status_index` (`status`),
  ADD KEY `adoption_applications_zoom_date_index` (`appointment_date`),
  ADD KEY `adoption_applications_selected_pet_id_index` (`selected_pet_id`),
  ADD KEY `adoption_applications_address_id_index` (`address_id`),
  ADD KEY `adoption_applications_owner_id_foreign` (`owner_id`),
  ADD KEY `adoption_applications_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_category_index` (`category`),
  ADD KEY `announcements_created_by_index` (`created_by`),
  ADD KEY `announcements_barangay_id_foreign` (`barangay_id`),
  ADD KEY `announcements_event_type_index` (`event_type`);

--
-- Indexes for table `announcement_reads`
--
ALTER TABLE `announcement_reads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `announcement_reads_announcement_id_user_id_unique` (`announcement_id`,`user_id`),
  ADD KEY `announcement_reads_user_id_foreign` (`user_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_date_time_service_slot` (`appointment_date`,`appointment_time`,`service_type`),
  ADD KEY `appointments_appointment_date_index` (`appointment_date`),
  ADD KEY `appointments_appointment_time_index` (`appointment_time`),
  ADD KEY `appointments_service_type_index` (`service_type`),
  ADD KEY `appointments_service_type_service_id_index` (`service_type`,`service_id`),
  ADD KEY `appointments_status_index` (`status`);

--
-- Indexes for table `barangays`
--
ALTER TABLE `barangays`
  ADD PRIMARY KEY (`barangay_id`);

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
-- Indexes for table `certificate_series`
--
ALTER TABLE `certificate_series`
  ADD PRIMARY KEY (`series_id`),
  ADD UNIQUE KEY `certificate_series_series_name_year_unique` (`series_name`,`year`);

--
-- Indexes for table `clinical_actions`
--
ALTER TABLE `clinical_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clinical_actions_status_index` (`status`),
  ADD KEY `clinical_actions_barangay_id_index` (`barangay_id`),
  ADD KEY `clinical_actions_barangay_index` (`barangay_id`),
  ADD KEY `clinical_actions_created_index` (`created_at`),
  ADD KEY `clinical_actions_created_by_foreign` (`created_by`),
  ADD KEY `clinical_actions_assigned_to_foreign` (`assigned_to`);

--
-- Indexes for table `device_tokens`
--
ALTER TABLE `device_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_tokens_user_id_is_active_index` (`user_id`,`is_active`),
  ADD KEY `device_tokens_token_index` (`token`);

--
-- Indexes for table `establishments`
--
ALTER TABLE `establishments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `establishments_barangay_id_index` (`barangay_id`),
  ADD KEY `establishments_user_id_index` (`user_id`),
  ADD KEY `establishments_type_index` (`type`),
  ADD KEY `establishments_status_index` (`status`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facilities_barangay_id_index` (`barangay_id`),
  ADD KEY `facilities_type_index` (`type`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `form_submissions`
--
ALTER TABLE `form_submissions`
  ADD PRIMARY KEY (`submission_id`),
  ADD KEY `form_submissions_form_id_foreign` (`form_id`),
  ADD KEY `form_submissions_submitted_by_user_id_foreign` (`submitted_by_user_id`),
  ADD KEY `form_submissions_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `guest_report_tokens`
--
ALTER TABLE `guest_report_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guest_report_tokens_token_unique` (`token`);

--
-- Indexes for table `inventory_controls`
--
ALTER TABLE `inventory_controls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventory_controls_item_code_unique` (`item_code`),
  ADD KEY `inventory_controls_created_by_foreign` (`created_by`),
  ADD KEY `inventory_controls_category_index` (`category`),
  ADD KEY `inventory_controls_status_index` (`status`),
  ADD KEY `inventory_controls_expiry_date_index` (`expiry_date`);

--
-- Indexes for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventory_items_item_code_unique` (`item_code`),
  ADD KEY `inventory_items_user_id_foreign` (`user_id`);

--
-- Indexes for table `inventory_movements`
--
ALTER TABLE `inventory_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_movements_performed_by_foreign` (`performed_by`),
  ADD KEY `inventory_movements_movement_type_index` (`movement_type`),
  ADD KEY `inventory_movements_inventory_control_id_index` (`inventory_control_id`),
  ADD KEY `inventory_movements_target_barangay_id_index` (`target_barangay_id`),
  ADD KEY `inventory_movements_vaccination_report_id_index` (`vaccination_report_id`);

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
-- Indexes for table `livestock`
--
ALTER TABLE `livestock`
  ADD PRIMARY KEY (`livestock_id`),
  ADD KEY `livestock_species_index` (`species`),
  ADD KEY `livestock_barangay_id_index` (`barangay_id`),
  ADD KEY `livestock_status_index` (`status`),
  ADD KEY `livestock_recorded_by_index` (`recorded_by`),
  ADD KEY `livestock_owner_id_index` (`owner_id`);

--
-- Indexes for table `livestock_censuses`
--
ALTER TABLE `livestock_censuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `livestock_censuses_barangay_id_foreign` (`barangay_id`),
  ADD KEY `livestock_censuses_encoded_by_user_id_foreign` (`encoded_by_user_id`);

--
-- Indexes for table `meat_establishments`
--
ALTER TABLE `meat_establishments`
  ADD PRIMARY KEY (`establishment_id`),
  ADD UNIQUE KEY `meat_establishments_establishment_name_unique` (`establishment_name`),
  ADD KEY `meat_establishments_barangay_id_index` (`barangay_id`),
  ADD KEY `meat_establishments_registered_by_user_id_index` (`registered_by_user_id`);

--
-- Indexes for table `meat_inspections`
--
ALTER TABLE `meat_inspections`
  ADD PRIMARY KEY (`inspection_id`),
  ADD KEY `meat_inspections_establishment_id_index` (`establishment_id`),
  ADD KEY `meat_inspections_inspector_user_id_index` (`inspector_user_id`),
  ADD KEY `meat_inspections_inspection_date_index` (`inspection_date`),
  ADD KEY `meat_inspections_status_index` (`status`);

--
-- Indexes for table `meat_shop_inspections`
--
ALTER TABLE `meat_shop_inspections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meat_shop_inspections_meat_shop_id_index` (`meat_shop_id`),
  ADD KEY `meat_shop_inspections_inspection_date_index` (`inspection_date`),
  ADD KEY `meat_shop_inspections_apprehended_by_user_id_index` (`apprehended_by_user_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_records_type_index` (`type`),
  ADD KEY `medical_records_appointment_date_index` (`appointment_date`),
  ADD KEY `medical_records_status_index` (`status`),
  ADD KEY `medical_records_user_id_index` (`user_id`),
  ADD KEY `medical_records_owner_id_index` (`owner_id`);

--
-- Indexes for table `medical_record_agreements`
--
ALTER TABLE `medical_record_agreements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_record_agreements_medical_record_id_index` (`medical_record_id`),
  ADD KEY `medical_record_agreements_pet_id_index` (`pet_id`),
  ADD KEY `medical_record_agreements_agreement_signed_index` (`agreement_signed`);

--
-- Indexes for table `medical_record_pets`
--
ALTER TABLE `medical_record_pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_record_pets_medical_record_id_index` (`medical_record_id`),
  ADD KEY `medical_record_pets_pet_id_index` (`pet_id`);

--
-- Indexes for table `merge_audit`
--
ALTER TABLE `merge_audit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merge_audit_pet_id_kept_index` (`pet_id_kept`),
  ADD KEY `merge_audit_pet_id_merged_index` (`pet_id_merged`),
  ADD KEY `merge_audit_merged_by_index` (`merged_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `missing_pets_photos`
--
ALTER TABLE `missing_pets_photos`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `missing_pets_photos_report_id_foreign` (`report_id`);

--
-- Indexes for table `missing_pets_reports`
--
ALTER TABLE `missing_pets_reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_last_seen_at` (`last_seen_at`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status_barangay` (`status`),
  ADD KEY `idx_missing_pets_reports_pet_id` (`pet_id`),
  ADD KEY `missing_pets_reports_report_type_index` (`report_type`),
  ADD KEY `missing_pets_reports_barangay_id_foreign` (`barangay_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `notifications_user_id_index` (`user_id`),
  ADD KEY `notifications_is_read_index` (`is_read`),
  ADD KEY `notifications_related_module_index` (`related_module`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organizations_contact_user_id_foreign` (`contact_user_id`),
  ADD KEY `organizations_type_is_active_index` (`type`,`is_active`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patients_barangay_id_foreign` (`barangay_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`pet_id`),
  ADD KEY `pets_owner_id_foreign` (`owner_id`),
  ADD KEY `pets_source_module_index` (`source_module`),
  ADD KEY `pets_source_module_source_module_id_index` (`source_module`,`source_module_id`),
  ADD KEY `idx_pets_adoption_availability` (`source_module`,`pet_status`,`is_approved`);

--
-- Indexes for table `pet_info`
--
ALTER TABLE `pet_info`
  ADD PRIMARY KEY (`pet_id`);

--
-- Indexes for table `pet_owners`
--
ALTER TABLE `pet_owners`
  ADD PRIMARY KEY (`owner_id`),
  ADD KEY `pet_owners_address_id_foreign` (`address_id`),
  ADD KEY `pet_owners_user_id_foreign` (`user_id`);

--
-- Indexes for table `pet_traits`
--
ALTER TABLE `pet_traits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pet_traits_pet_id_trait_id_unique` (`pet_id`,`trait_id`),
  ADD KEY `pet_traits_trait_id_foreign` (`trait_id`);

--
-- Indexes for table `rabies_reports`
--
ALTER TABLE `rabies_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bite_rabies_reports_report_number_unique` (`report_number`),
  ADD KEY `bite_rabies_reports_report_number_index` (`report_number`),
  ADD KEY `bite_rabies_reports_barangay_id_index` (`barangay_id`),
  ADD KEY `bite_rabies_reports_incident_date_index` (`incident_date`),
  ADD KEY `bite_rabies_reports_animal_type_index` (`animal_type`);

--
-- Indexes for table `rabies_vaccination_reports`
--
ALTER TABLE `rabies_vaccination_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rabies_vaccination_reports_user_id_foreign` (`user_id`),
  ADD KEY `rabies_vaccination_reports_vaccination_report_id_index` (`vaccination_report_id`),
  ADD KEY `rabies_vaccination_reports_barangay_id_index` (`barangay_id`);

--
-- Indexes for table `report_exports`
--
ALTER TABLE `report_exports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_exports_exported_by_user_id_foreign` (`exported_by_user_id`);

--
-- Indexes for table `service_forms`
--
ALTER TABLE `service_forms`
  ADD PRIMARY KEY (`form_id`),
  ADD KEY `service_forms_created_by_foreign` (`created_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `spatie_model_has_permissions`
--
ALTER TABLE `spatie_model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `spatie_model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `spatie_model_has_roles`
--
ALTER TABLE `spatie_model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `spatie_model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `spatie_permissions`
--
ALTER TABLE `spatie_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `spatie_permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `spatie_roles`
--
ALTER TABLE `spatie_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `spatie_roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `spatie_role_has_permissions`
--
ALTER TABLE `spatie_role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `spatie_role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `spay_neuter_appointments`
--
ALTER TABLE `spay_neuter_appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spay_neuter_appointments_user_id_index` (`user_id`),
  ADD KEY `spay_neuter_appointments_owner_id_index` (`owner_id`),
  ADD KEY `spay_neuter_appointments_address_id_index` (`address_id`),
  ADD KEY `spay_neuter_appointments_barangay_id_index` (`barangay_id`),
  ADD KEY `spay_neuter_appointments_assigned_vet_index` (`assigned_vet`),
  ADD KEY `sn_appt_pet_status_sched_idx` (`pet_id`,`status`,`scheduled_at`),
  ADD KEY `spay_neuter_appointments_event_id_index` (`event_id`),
  ADD KEY `spay_neuter_appointments_appointment_mode_index` (`appointment_mode`),
  ADD KEY `spay_neuter_appointments_is_ineligible_until_index` (`is_ineligible_until`);

--
-- Indexes for table `spay_neuter_reports`
--
ALTER TABLE `spay_neuter_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spay_neuter_reports_user_id_foreign` (`user_id`),
  ADD KEY `spay_neuter_reports_created_index` (`created_at`),
  ADD KEY `spay_neuter_reports_pet_id_index` (`pet_id`),
  ADD KEY `spay_neuter_reports_owner_id_foreign` (`owner_id`),
  ADD KEY `spay_neuter_reports_barangay_id_index` (`barangay_id`),
  ADD KEY `spay_neuter_reports_spay_neuter_appointment_id_index` (`spay_neuter_appointment_id`);

--
-- Indexes for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_movements_inventory_item_id_foreign` (`inventory_item_id`),
  ADD KEY `stock_movements_user_id_foreign` (`user_id`);

--
-- Indexes for table `stray_reports`
--
ALTER TABLE `stray_reports`
  ADD PRIMARY KEY (`stray_report_id`),
  ADD KEY `stray_reports_barangay_id_foreign` (`barangay_id`),
  ADD KEY `stray_reports_reported_by_user_id_foreign` (`reported_by_user_id`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_logs_subject_type_index` (`subject_type`),
  ADD KEY `system_logs_subject_id_index` (`subject_id`),
  ADD KEY `system_logs_event_index` (`event`),
  ADD KEY `system_logs_causer_id_index` (`causer_id`),
  ADD KEY `system_logs_module_index` (`module`),
  ADD KEY `system_logs_action_index` (`action`),
  ADD KEY `system_logs_causer_index` (`causer_id`),
  ADD KEY `system_logs_created_index` (`created_at`);

--
-- Indexes for table `traits`
--
ALTER TABLE `traits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `traits_name_unique` (`name`),
  ADD KEY `traits_name_index` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_users_email_unique` (`email`),
  ADD KEY `admin_users_status_index` (`status`),
  ADD KEY `admin_users_email_index` (`email`),
  ADD KEY `admin_users_barangay_id_index` (`barangay_id`),
  ADD KEY `admin_users_clinic_id_index` (`facility_id`),
  ADD KEY `admin_users_facility_id_index` (`facility_id`),
  ADD KEY `users_organization_id_foreign` (`organization_id`);

--
-- Indexes for table `vaccination_appointments`
--
ALTER TABLE `vaccination_appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vaccination_appointments_user_id_index` (`user_id`),
  ADD KEY `vaccination_appointments_owner_id_index` (`owner_id`),
  ADD KEY `vaccination_appointments_address_id_index` (`address_id`),
  ADD KEY `vaccination_appointments_scheduled_at_index` (`scheduled_at`),
  ADD KEY `vaccination_appointments_status_index` (`status`),
  ADD KEY `vaccination_appointments_assigned_vet_index` (`assigned_vet`),
  ADD KEY `vaccination_appointments_pet_id_index` (`pet_id`),
  ADD KEY `vaccination_appointments_event_id_index` (`event_id`),
  ADD KEY `vaccination_appointments_appointment_mode_index` (`appointment_mode`);

--
-- Indexes for table `vaccination_reports`
--
ALTER TABLE `vaccination_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vaccination_reports_vaccination_appointment_id_index` (`vaccination_appointment_id`),
  ADD KEY `vaccination_reports_pet_id_index` (`pet_id`),
  ADD KEY `vaccination_reports_barangay_id_index` (`barangay_id`),
  ADD KEY `vaccination_reports_vaccination_date_index` (`vaccination_date`),
  ADD KEY `vaccination_reports_status_index` (`status`),
  ADD KEY `vaccination_reports_inventory_control_id_index` (`inventory_control_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `adoption_applications`
--
ALTER TABLE `adoption_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `announcement_reads`
--
ALTER TABLE `announcement_reads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barangays`
--
ALTER TABLE `barangays`
  MODIFY `barangay_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `certificate_series`
--
ALTER TABLE `certificate_series`
  MODIFY `series_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinical_actions`
--
ALTER TABLE `clinical_actions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `device_tokens`
--
ALTER TABLE `device_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `establishments`
--
ALTER TABLE `establishments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_submissions`
--
ALTER TABLE `form_submissions`
  MODIFY `submission_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guest_report_tokens`
--
ALTER TABLE `guest_report_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_controls`
--
ALTER TABLE `inventory_controls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `inventory_items`
--
ALTER TABLE `inventory_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `inventory_movements`
--
ALTER TABLE `inventory_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `livestock`
--
ALTER TABLE `livestock`
  MODIFY `livestock_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `livestock_censuses`
--
ALTER TABLE `livestock_censuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meat_establishments`
--
ALTER TABLE `meat_establishments`
  MODIFY `establishment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `meat_inspections`
--
ALTER TABLE `meat_inspections`
  MODIFY `inspection_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meat_shop_inspections`
--
ALTER TABLE `meat_shop_inspections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_record_agreements`
--
ALTER TABLE `medical_record_agreements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_record_pets`
--
ALTER TABLE `medical_record_pets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merge_audit`
--
ALTER TABLE `merge_audit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT for table `missing_pets_photos`
--
ALTER TABLE `missing_pets_photos`
  MODIFY `photo_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `missing_pets_reports`
--
ALTER TABLE `missing_pets_reports`
  MODIFY `report_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `pet_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `pet_owners`
--
ALTER TABLE `pet_owners`
  MODIFY `owner_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pet_traits`
--
ALTER TABLE `pet_traits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `rabies_reports`
--
ALTER TABLE `rabies_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `rabies_vaccination_reports`
--
ALTER TABLE `rabies_vaccination_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `report_exports`
--
ALTER TABLE `report_exports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_forms`
--
ALTER TABLE `service_forms`
  MODIFY `form_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spatie_permissions`
--
ALTER TABLE `spatie_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `spatie_roles`
--
ALTER TABLE `spatie_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `spay_neuter_appointments`
--
ALTER TABLE `spay_neuter_appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `spay_neuter_reports`
--
ALTER TABLE `spay_neuter_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stray_reports`
--
ALTER TABLE `stray_reports`
  MODIFY `stray_report_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=567;

--
-- AUTO_INCREMENT for table `traits`
--
ALTER TABLE `traits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `vaccination_appointments`
--
ALTER TABLE `vaccination_appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `vaccination_reports`
--
ALTER TABLE `vaccination_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_barangay_id_foreign` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`barangay_id`) ON DELETE SET NULL;

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `admins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `adoption_applications`
--
ALTER TABLE `adoption_applications`
  ADD CONSTRAINT `adoption_applications_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `adoption_applications_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `pet_owners` (`owner_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `adoption_applications_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `adoption_applications_selected_pet_id_foreign` FOREIGN KEY (`selected_pet_id`) REFERENCES `pets` (`pet_id`) ON DELETE SET NULL;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_barangay_id_foreign` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`barangay_id`),
  ADD CONSTRAINT `announcements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `announcement_reads`
--
ALTER TABLE `announcement_reads`
  ADD CONSTRAINT `announcement_reads_announcement_id_foreign` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `announcement_reads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `clinical_actions`
--
ALTER TABLE `clinical_actions`
  ADD CONSTRAINT `clinical_actions_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `clinical_actions_barangay_id_foreign` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`barangay_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `clinical_actions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `establishments`
--
ALTER TABLE `establishments`
  ADD CONSTRAINT `establishments_barangay_id_foreign` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`barangay_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `establishments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `facilities`
--
ALTER TABLE `facilities`
  ADD CONSTRAINT `facilities_barangay_id_foreign` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`barangay_id`) ON DELETE SET NULL;

--
-- Constraints for table `form_submissions`
--
ALTER TABLE `form_submissions`
  ADD CONSTRAINT `form_submissions_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `service_forms` (`form_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `form_submissions_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `form_submissions_submitted_by_user_id_foreign` FOREIGN KEY (`submitted_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_controls`
--
ALTER TABLE `inventory_controls`
  ADD CONSTRAINT `inventory_controls_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD CONSTRAINT `inventory_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_movements`
--
ALTER TABLE `inventory_movements`
  ADD CONSTRAINT `inventory_movements_barangay_id_foreign` FOREIGN KEY (`target_barangay_id`) REFERENCES `barangays` (`barangay_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_movements_inventory_control_id_foreign` FOREIGN KEY (`inventory_control_id`) REFERENCES `inventory_controls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_movements_performed_by_foreign` FOREIGN KEY (`performed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_movements_vaccination_report_id_foreign` FOREIGN KEY (`vaccination_report_id`) REFERENCES `vaccination_reports` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `livestock`
--
ALTER TABLE `livestock`
  ADD CONSTRAINT `livestock_barangay_id_foreign` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`barangay_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `livestock_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `pet_owners` (`owner_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `livestock_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `livestock_censuses`
--
ALTER TABLE `livestock_censuses`
  ADD CONSTRAINT `livestock_censuses_barangay_id_foreign` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`barangay_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `livestock_censuses_encoded_by_user_id_foreign` FOREIGN KEY (`encoded_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `pet_owners` (`owner_id`) ON DELETE CASCADE;

--
-- Constraints for table `medical_record_agreements`
--
ALTER TABLE `medical_record_agreements`
  ADD CONSTRAINT `medical_record_agreements_medical_record_id_foreign` FOREIGN KEY (`medical_record_id`) REFERENCES `medical_records` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medical_record_agreements_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`pet_id`) ON DELETE CASCADE;

--
-- Constraints for table `medical_record_pets`
--
ALTER TABLE `medical_record_pets`
  ADD CONSTRAINT `medical_record_pets_medical_record_id_foreign` FOREIGN KEY (`medical_record_id`) REFERENCES `medical_records` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medical_record_pets_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`pet_id`) ON DELETE CASCADE;

--
-- Constraints for table `missing_pets_photos`
--
ALTER TABLE `missing_pets_photos`
  ADD CONSTRAINT `missing_pets_photos_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `missing_pets_reports` (`report_id`) ON DELETE CASCADE;

--
-- Constraints for table `missing_pets_reports`
--
ALTER TABLE `missing_pets_reports`
  ADD CONSTRAINT `missing_pets_reports_barangay_id_foreign` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`barangay_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `missing_pets_reports_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`pet_id`) ON DELETE CASCADE;

--
-- Constraints for table `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `organizations_contact_user_id_foreign` FOREIGN KEY (`contact_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_barangay_id_foreign` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`barangay_id`) ON DELETE SET NULL;

--
-- Constraints for table `pet_info`
--
ALTER TABLE `pet_info`
  ADD CONSTRAINT `pet_info_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`pet_id`) ON DELETE CASCADE;

--
-- Constraints for table `pet_owners`
--
ALTER TABLE `pet_owners`
  ADD CONSTRAINT `pet_owners_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pet_owners_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pet_traits`
--
ALTER TABLE `pet_traits`
  ADD CONSTRAINT `pet_traits_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`pet_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pet_traits_trait_id_foreign` FOREIGN KEY (`trait_id`) REFERENCES `traits` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rabies_reports`
--
ALTER TABLE `rabies_reports`
  ADD CONSTRAINT `bite_rabies_reports_barangay_id_foreign` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`barangay_id`) ON DELETE SET NULL;

--
-- Constraints for table `rabies_vaccination_reports`
--
ALTER TABLE `rabies_vaccination_reports`
  ADD CONSTRAINT `rabies_vaccination_reports_barangay_id_foreign` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`barangay_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `rabies_vaccination_reports_vaccination_report_id_foreign` FOREIGN KEY (`vaccination_report_id`) REFERENCES `vaccination_reports` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `report_exports`
--
ALTER TABLE `report_exports`
  ADD CONSTRAINT `report_exports_exported_by_user_id_foreign` FOREIGN KEY (`exported_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `service_forms`
--
ALTER TABLE `service_forms`
  ADD CONSTRAINT `service_forms_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `spatie_model_has_permissions`
--
ALTER TABLE `spatie_model_has_permissions`
  ADD CONSTRAINT `spatie_model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `spatie_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `spatie_model_has_roles`
--
ALTER TABLE `spatie_model_has_roles`
  ADD CONSTRAINT `spatie_model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `spatie_roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `spatie_role_has_permissions`
--
ALTER TABLE `spatie_role_has_permissions`
  ADD CONSTRAINT `spatie_role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `spatie_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `spatie_role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `spatie_roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `spay_neuter_appointments`
--
ALTER TABLE `spay_neuter_appointments`
  ADD CONSTRAINT `spay_neuter_appointments_assigned_vet_foreign` FOREIGN KEY (`assigned_vet`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `spay_neuter_appointments_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `announcements` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `spay_neuter_reports`
--
ALTER TABLE `spay_neuter_reports`
  ADD CONSTRAINT `spay_neuter_reports_barangay_id_foreign` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`barangay_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `spay_neuter_reports_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `pet_owners` (`owner_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `spay_neuter_reports_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`pet_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `spay_neuter_reports_spay_neuter_appointment_id_foreign` FOREIGN KEY (`spay_neuter_appointment_id`) REFERENCES `spay_neuter_appointments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `spay_neuter_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD CONSTRAINT `stock_movements_inventory_item_id_foreign` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_movements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stray_reports`
--
ALTER TABLE `stray_reports`
  ADD CONSTRAINT `stray_reports_barangay_id_foreign` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`barangay_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stray_reports_reported_by_user_id_foreign` FOREIGN KEY (`reported_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `admin_users_barangay_id_foreign` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`barangay_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `vaccination_appointments`
--
ALTER TABLE `vaccination_appointments`
  ADD CONSTRAINT `vaccination_appointments_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vaccination_appointments_assigned_vet_foreign` FOREIGN KEY (`assigned_vet`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vaccination_appointments_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `announcements` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vaccination_appointments_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`pet_id`) ON DELETE SET NULL;

--
-- Constraints for table `vaccination_reports`
--
ALTER TABLE `vaccination_reports`
  ADD CONSTRAINT `vaccination_reports_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`pet_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vaccination_reports_vaccination_appointment_id_foreign` FOREIGN KEY (`vaccination_appointment_id`) REFERENCES `vaccination_appointments` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
