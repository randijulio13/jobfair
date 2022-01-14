-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 14, 2022 at 10:21 AM
-- Server version: 10.3.32-MariaDB-cll-lve
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u1687779_jobfair`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicant_datas`
--

CREATE TABLE `applicant_datas` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `gender` enum('L','P') DEFAULT NULL,
  `pob` varchar(64) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `last_edu` enum('SD','SMP','SMA','DIII','DIV','S1','S2','') DEFAULT NULL,
  `major` varchar(64) DEFAULT NULL,
  `grad_year` varchar(4) DEFAULT NULL,
  `file` varchar(256) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applicant_datas`
--

INSERT INTO `applicant_datas` (`id`, `user_id`, `name`, `gender`, `pob`, `dob`, `last_edu`, `major`, `grad_year`, `file`, `created_at`, `updated_at`) VALUES
(2, 2, 'Rico Ardi Saputra', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-01-13 14:45:48', '2022-01-13 14:45:48'),
(3, 3, 'Randi Yulio Fajri', 'L', 'Palembang', '1998-07-13', 'DIII', 'Manajemen Informatika', '2020', '202201137843randi-yulio-fajri.pdf', '2022-01-13 14:52:46', '2022-01-13 14:52:46');

-- --------------------------------------------------------

--
-- Table structure for table `applicant_fields`
--

CREATE TABLE `applicant_fields` (
  `applicant_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applicant_fields`
--

INSERT INTO `applicant_fields` (`applicant_id`, `field_id`) VALUES
(3, 6),
(3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `applicant_tokens`
--

CREATE TABLE `applicant_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(256) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `career_fields`
--

CREATE TABLE `career_fields` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `career_fields`
--

INSERT INTO `career_fields` (`id`, `name`, `created_at`, `updated_at`) VALUES
(6, 'Teknologi', '2022-01-13 13:23:44', '2022-01-13 13:23:44'),
(7, 'Akuntansi', '2022-01-13 13:23:51', '2022-01-13 13:23:51');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `sender_name` varchar(64) NOT NULL,
  `sender_email` varchar(64) DEFAULT NULL,
  `sender_phone` varchar(32) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `new_messages`
--

CREATE TABLE `new_messages` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `logo` varchar(256) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE `sponsors` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `type` int(11) NOT NULL,
  `logo` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`id`, `name`, `type`, `logo`, `description`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'GK Invest', 3, '202201135690gk-invest.jpg', 'Global Kapital Investama Berjangka dengan merk dagang \"GKInvest\" adalah perusahaan pialang berjangka resmi, berkantor pusat di Jakarta dan teregulasi BAPEBBTI serta merupakan anggota resmi JFX dan ICDX.', 4, 1, '2022-01-13 17:10:03', '2022-01-13 17:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `sponsor_fields`
--

CREATE TABLE `sponsor_fields` (
  `sponsor_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sponsor_types`
--

CREATE TABLE `sponsor_types` (
  `id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `field_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sponsor_types`
--

INSERT INTO `sponsor_types` (`id`, `type`, `field_total`) VALUES
(1, 'Silver', 0),
(2, 'Gold', 2),
(3, 'Platinum', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `email` varchar(64) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `type` int(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `status`, `email`, `phone`, `type`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', '$2y$10$EedBae4yTQaGcIPe38bl7.cKDd21Q5gmucwIEIb.puETAHeChyNeq', 1, 'admin@gmail.com', '1234', 1, '2022-01-13 14:41:46', '2022-01-13 14:41:46'),
(2, 'Rico Ardi Saputra', 'tebak', '$2y$10$uCYEAsBtf0iaCUuirU6iEe87y/0ujS/oJCscgKvLKu13RrFtKCRcC', 1, 'co30091998@gmail.com', '085783495674', 3, '2022-01-13 14:45:48', '2022-01-13 14:45:48'),
(3, 'Randi Yulio Fajri', 'randijuliofajri', '$2y$10$YZqpenotZwyVukKdxEcuBu8IHPo7nz9Yc/oJC4NIxtUnan/JxIHaa', 1, 'randijulio13@gmail.com', '081373020035', 3, '2022-01-13 14:52:46', '2022-01-13 14:52:46'),
(4, 'GK Invest', 'gkinvest', '$2y$10$ODR97tcQ5ETWl6AfB.MbmeW7ktPXj3.u9O/EfMVscszlS6HLkm4t2', 0, NULL, NULL, 2, '2022-01-13 17:10:03', '2022-01-13 17:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `type`) VALUES
(1, 'Admin'),
(2, 'Sponsor'),
(3, 'Pelamar');

-- --------------------------------------------------------

--
-- Table structure for table `vacancies`
--

CREATE TABLE `vacancies` (
  `id` int(11) NOT NULL,
  `sponsor_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `career_field` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vacancy_applicants`
--

CREATE TABLE `vacancy_applicants` (
  `vacancy_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `seen` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_config`
--

CREATE TABLE `web_config` (
  `id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `icon` varchar(256) NOT NULL,
  `logo` varchar(256) NOT NULL,
  `about_us` text NOT NULL,
  `email` varchar(64) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `address` text NOT NULL,
  `title_description` text NOT NULL,
  `hero_image` varchar(64) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `web_config`
--

INSERT INTO `web_config` (`id`, `title`, `icon`, `logo`, `about_us`, `email`, `phone`, `address`, `title_description`, `hero_image`, `created_at`, `updated_at`) VALUES
(1, 'Tribun Jobfair', 'default.jpg', 'default.jpg', 'Tribun Sumsel adalah sebuah surat kabar harian yang terbit di Sumatra Selatan, Indonesia. Surat kabar ini termasuk dalam grup Tribun Network. Kantor pusatnya terletak di kota Palembang. Koran ini pertama kali terbit tahun 2012. Koran ini umumnya memberitakan tentang musik, nasional, olahraga dan masih banyak lagi.', 'jobhunter.tribunsripo@gmail.com', '+6281958777762', 'Jalan Alamsyah Ratu Prawira Negara No. 123 Kelurahan Bukit Lama, Kecamatan Ilir Barat I Kota Palembang, Sumatera Selatan 30139', 'Tribun Sumsel adalah sebuah surat kabar harian yang terbit di Sumatra Selatan, Indonesia. Surat kabar ini termasuk dalam grup Tribun Network. Kantor pusatnya terletak di kota Palembang. Koran ini pertama kali terbit tahun 2012. Koran ini umumnya memberitakan tentang musik, nasional, olahraga dan masih banyak lagi.', 'default.jpg', '2021-12-29 15:13:54', '2021-12-29 15:13:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicant_datas`
--
ALTER TABLE `applicant_datas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `applicant_fields`
--
ALTER TABLE `applicant_fields`
  ADD KEY `field_id` (`field_id`),
  ADD KEY `applicant` (`applicant_id`);

--
-- Indexes for table `applicant_tokens`
--
ALTER TABLE `applicant_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `career_fields`
--
ALTER TABLE `career_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_messages`
--
ALTER TABLE `new_messages`
  ADD KEY `message` (`message_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sponsor_fields`
--
ALTER TABLE `sponsor_fields`
  ADD KEY `field_id` (`field_id`),
  ADD KEY `sponsor` (`sponsor_id`);

--
-- Indexes for table `sponsor_types`
--
ALTER TABLE `sponsor_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vacancies`
--
ALTER TABLE `vacancies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vacancy_applicants`
--
ALTER TABLE `vacancy_applicants`
  ADD KEY `vacancy` (`vacancy_id`);

--
-- Indexes for table `web_config`
--
ALTER TABLE `web_config`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicant_datas`
--
ALTER TABLE `applicant_datas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `applicant_tokens`
--
ALTER TABLE `applicant_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `career_fields`
--
ALTER TABLE `career_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sponsor_types`
--
ALTER TABLE `sponsor_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vacancies`
--
ALTER TABLE `vacancies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `web_config`
--
ALTER TABLE `web_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicant_fields`
--
ALTER TABLE `applicant_fields`
  ADD CONSTRAINT `applicant` FOREIGN KEY (`applicant_id`) REFERENCES `applicant_datas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `career_field` FOREIGN KEY (`field_id`) REFERENCES `career_fields` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `new_messages`
--
ALTER TABLE `new_messages`
  ADD CONSTRAINT `message` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sponsor_fields`
--
ALTER TABLE `sponsor_fields`
  ADD CONSTRAINT `field` FOREIGN KEY (`field_id`) REFERENCES `career_fields` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sponsor` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vacancy_applicants`
--
ALTER TABLE `vacancy_applicants`
  ADD CONSTRAINT `vacancy` FOREIGN KEY (`vacancy_id`) REFERENCES `vacancies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
