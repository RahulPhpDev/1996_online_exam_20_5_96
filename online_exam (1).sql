-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2018 at 03:10 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `course_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `add_by` int(11) NOT NULL,
  `add_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` mediumtext,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `add_date` date NOT NULL,
  `edit_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `status`, `add_date`, `edit_date`) VALUES
(1, 'Btech', '<p><strong>Btech Course is amaxing course</strong></p>', 1, '2018-10-27', '2018-10-27');

-- --------------------------------------------------------

--
-- Table structure for table `course_exam`
--

CREATE TABLE `course_exam` (
  `id` int(11) UNSIGNED NOT NULL,
  `exam_type_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `exam_name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `total_marks` double NOT NULL DEFAULT '0',
  `total_question` int(11) NOT NULL DEFAULT '0',
  `required_question` int(11) NOT NULL DEFAULT '0',
  `negative_question` int(11) NOT NULL DEFAULT '0',
  `negative_marks` double NOT NULL DEFAULT '0',
  `minimum_passing_marks` double NOT NULL DEFAULT '0',
  `passing_marks_type` tinyint(4) NOT NULL DEFAULT '0',
  `exam_visible_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1->all,2->register,3->package',
  `is_payable` tinyint(4) DEFAULT '0',
  `payable_amount` double DEFAULT '0',
  `status` tinyint(2) NOT NULL,
  `description` mediumtext NOT NULL,
  `notes` mediumtext,
  `add_date` date NOT NULL,
  `edit_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `exam_name`, `category_id`, `total_marks`, `total_question`, `required_question`, `negative_question`, `negative_marks`, `minimum_passing_marks`, `passing_marks_type`, `exam_visible_status`, `is_payable`, `payable_amount`, `status`, `description`, `notes`, `add_date`, `edit_date`) VALUES
(1, 'Gate', NULL, 20, 4, 2, 1, 4, 0, 0, 3, 0, 0, 1, '<p>This is description</p>', '<p>This is details</p>', '2018-10-27', '2018-10-27 12:31:24'),
(2, 'Btech', NULL, 11, 3, 3, 1, 4, 12, 1, 3, 0, 0, 1, '<p>bdfghf fdgsd</p>', '<p>dsfgsd sfdghsd</p>', '2018-10-28', '2018-10-28 15:47:06'),
(3, 'Quiz', NULL, 8, 1, 1, 0, 0, 2, 1, 3, 0, 0, 1, '<p>dfgsdf</p>', '<p>fdgsd</p>', '2018-10-28', '2018-10-28 21:02:22');

-- --------------------------------------------------------

--
-- Table structure for table `exam_question`
--

CREATE TABLE `exam_question` (
  `id` int(11) UNSIGNED NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam_question`
--

INSERT INTO `exam_question` (`id`, `exam_id`, `question_id`, `status`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 1),
(5, 2, 5, 1),
(6, 2, 6, 1),
(7, 2, 7, 1),
(8, 3, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `exam_subscription`
--

CREATE TABLE `exam_subscription` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `subscription_id` tinyint(1) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam_subscription`
--

INSERT INTO `exam_subscription` (`id`, `exam_id`, `subscription_id`, `status`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1),
(5, 4, 1, 1),
(6, 3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `exam_type`
--

CREATE TABLE `exam_type` (
  `id` int(11) UNSIGNED NOT NULL,
  `exam_id` int(11) NOT NULL,
  `exam_type` tinyint(2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `institutions`
--

CREATE TABLE `institutions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` mediumtext NOT NULL,
  `type` tinyint(2) NOT NULL,
  `marks` double NOT NULL DEFAULT '0',
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `is_negative_marking` tinyint(1) NOT NULL DEFAULT '0',
  `negative_marks` tinyint(4) NOT NULL DEFAULT '0',
  `hint` mediumtext,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `add_date` date NOT NULL,
  `edit_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `add_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `type`, `marks`, `is_required`, `is_negative_marking`, `negative_marks`, `hint`, `status`, `add_date`, `edit_date`, `add_by`) VALUES
(1, '2 + 2 = ?', 1, 0, 1, 0, 0, NULL, 1, '2018-10-27', '2018-10-27 12:57:00', 1),
(2, '&lt;p&gt;6 + 67 = ?&lt;/p&gt;', 1, 0, 0, 0, 0, NULL, 1, '2018-10-27', '2018-10-27 14:16:22', 1),
(3, '&lt;p&gt;&lt;strong&gt;22 + 2 = ?&lt;/strong&gt;&lt;/p&gt;', 1, 0, 0, 0, 0, NULL, 1, '2018-10-27', '2018-10-27 14:16:22', 1),
(4, 'India Capital ?', 1, 0, 1, 1, 4, NULL, 1, '2018-10-27', '2018-10-27 14:38:25', 1),
(5, '&lt;p&gt;&lt;math xmlns=&quot;http://www.w3.org/1998/Math/MathML&quot;&gt;&lt;msubsup&gt;&lt;mo&gt;&amp;#8747;&lt;/mo&gt;&lt;mrow&gt;&lt;mi&gt;d&lt;/mi&gt;&lt;mi&gt;x&lt;/mi&gt;&lt;/mrow&gt;&lt;mi&gt;d&lt;/mi&gt;&lt;/msubsup&gt;&lt;mi&gt;sin&lt;/mi&gt;&lt;mo&gt;&amp;#160;&lt;/mo&gt;&lt;mo&gt;@&lt;/mo&gt;&lt;mo&gt;=&lt;/mo&gt;&lt;mo&gt;&amp;#160;&lt;/mo&gt;&lt;mo&gt;?&lt;/mo&gt;&lt;/math&gt;&lt;/p&gt;', 1, 0, 1, 1, 4, NULL, 1, '2018-10-28', '2018-10-28 15:50:11', 1),
(6, '&lt;p&gt;2 + 2&lt;/p&gt;', 1, 0, 1, 0, 0, NULL, 1, '2018-10-28', '2018-10-28 15:50:11', 1),
(7, '1 + 1 =', 1, 0, 1, 0, 0, NULL, 1, '2018-10-28', '2018-10-28 15:50:39', 1),
(8, '8 + 8', 1, 0, 1, 0, 0, NULL, 1, '2018-10-28', '2018-10-28 21:02:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `question_options`
--

CREATE TABLE `question_options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `question_option` varchar(255) NOT NULL,
  `option_type` tinyint(2) DEFAULT NULL,
  `add_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_options`
--

INSERT INTO `question_options` (`id`, `question_id`, `question_option`, `option_type`, `add_date`) VALUES
(1, 1, '2', 1, '2018-10-27'),
(2, 1, '4', 1, '2018-10-27'),
(3, 1, '9', 1, '2018-10-27'),
(4, 1, '6', 1, '2018-10-27'),
(5, 2, '95', 1, '2018-10-27'),
(6, 2, '73', 1, '2018-10-27'),
(7, 2, '74', 1, '2018-10-27'),
(8, 2, '26', 1, '2018-10-27'),
(9, 3, '48', 1, '2018-10-27'),
(10, 3, '47', 1, '2018-10-27'),
(11, 3, '11', 1, '2018-10-27'),
(12, 3, '24', 1, '2018-10-27'),
(13, 4, 'Delhi', 1, '2018-10-27'),
(14, 4, 'Mumbai', 1, '2018-10-27'),
(15, 4, 'Ayodhuya', 1, '2018-10-27'),
(16, 4, 'aaa', 1, '2018-10-27'),
(17, 5, 'cos a', 1, '2018-10-28'),
(18, 5, 'sin a', 1, '2018-10-28'),
(19, 5, 'dfas', 1, '2018-10-28'),
(20, 5, 'fsdf', 1, '2018-10-28'),
(21, 6, '1', 1, '2018-10-28'),
(22, 6, '5', 1, '2018-10-28'),
(23, 6, '4', 1, '2018-10-28'),
(24, 6, 'df', 1, '2018-10-28'),
(25, 7, '1', 1, '2018-10-28'),
(26, 7, '3', 1, '2018-10-28'),
(27, 7, '5', 1, '2018-10-28'),
(28, 7, '2', 1, '2018-10-28'),
(29, 8, '3', 1, '2018-10-28'),
(30, 8, '16', 1, '2018-10-28'),
(31, 8, '5', 1, '2018-10-28'),
(32, 8, '8', 1, '2018-10-28');

-- --------------------------------------------------------

--
-- Table structure for table `question_right_answer`
--

CREATE TABLE `question_right_answer` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_right_answer`
--

INSERT INTO `question_right_answer` (`id`, `question_id`, `option_id`, `status`) VALUES
(1, 1, 2, 1),
(2, 2, 6, 1),
(3, 3, 12, 1),
(4, 4, 13, 1),
(5, 5, 18, 1),
(6, 6, 23, 1),
(7, 7, 28, 1),
(8, 8, 30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `id` int(11) NOT NULL,
  `exam` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `obtain_mark` double NOT NULL,
  `result_status` tinyint(1) NOT NULL,
  `right_answer` int(11) NOT NULL,
  `negative_marks` double NOT NULL,
  `correct_answer` int(11) NOT NULL,
  `wrong_answer` int(11) NOT NULL,
  `not_attempt` int(11) NOT NULL,
  `feedback` mediumtext NOT NULL,
  `add_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'LEM', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 5, 1, NULL, NULL),
(2, 6, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `enroll_number` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `join_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `course_id`, `address`, `enroll_number`, `status`, `join_date`, `end_date`, `description`) VALUES
(1, 9, NULL, 'India', '123456', 1, NULL, NULL, NULL),
(2, 10, NULL, 'dfsda', '12345678yyww', 1, NULL, NULL, NULL),
(3, 11, NULL, 'dfsda', '12345678yy', 1, NULL, NULL, NULL),
(4, 12, NULL, 'cbvcx', 'eerr3343', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `description` mediumtext NOT NULL,
  `price` double DEFAULT NULL,
  `isDatePermit` tinyint(1) NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `name`, `duration`, `description`, `price`, `isDatePermit`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Platinum', '0', '<p><strong>remote: Enumerating objects: 4, done.<br />remote: Counting objects: 100% (4/4), done.<br />remote: Compressing objects: 100% (3/3), done.</strong><br />remote: Total 3 (delta 1), reused 0 (delta 0), pack-reused 0<br />Unpacking objects: 100% (3/3), done.<br /><em>From https://github.com/RahulPhpDev/1996_online_exam_20_5_96<br />&nbsp; &nbsp;420edf8..41f085e &nbsp;master &nbsp; &nbsp; -&gt; origin/master</em></p>', 250, 1, '2018-10-23', '2018-11-30', 1, '2018-10-27 07:00:10', '2018-10-27 07:00:10'),
(2, 'Goldan', '6', '<p>gfhdf fghdfh fdhgsdfh</p>', 320, 0, NULL, NULL, 1, '2018-10-28 10:15:12', '2018-10-28 10:15:12');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_user`
--

CREATE TABLE `subscription_user` (
  `id` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription_user`
--

INSERT INTO `subscription_user` (`id`, `subscription_id`, `user_id`, `start_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2018-10-28', 1, '2018-10-28', '2018-10-28 15:54:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` smallint(5) NOT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `add_date` date DEFAULT NULL,
  `add_by` int(11) DEFAULT NULL,
  `edit_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `username`, `email`, `password`, `user_type`, `phone_no`, `last_login`, `status`, `profile_image`, `add_date`, `add_by`, `edit_date`, `remember_token`) VALUES
(1, 'Rahul', 'Chauhan', NULL, 'rahul@gmail.com', '$2y$10$DBa5IzGhi6Mi2eICYl9ZfuYx10SxdrUkfm.XTytpG7n4s3IqpEENe', 1, '8388607', NULL, 1, NULL, '2018-09-26', NULL, '2018-09-26 16:05:25', 'r2lUX4V96uwMjU0Ab9T0ZNzwGEqbBojOpZSKh65MxXC1axw4u4esAysFrLUS'),
(7, 'Saurabh', 'Chauhan', 'Saurabh002', 'saurabh@gmail.com', '$2y$10$DBa5IzGhi6Mi2eICYl9ZfuYx10SxdrUkfm.XTytpG7n4s3IqpEENe', 3, '08126270308', NULL, 1, NULL, '2018-10-27', NULL, '2018-10-27 06:58:58', NULL),
(8, 'Rahul', 'Singh', NULL, '1rahul@gmail.com', '$2y$10$kMHrdgOx3UATr31W/eicb.3uqa7wd0nWljGzKXdE/N0qt7uzGKuMK', 3, NULL, NULL, 1, NULL, '2018-10-28', NULL, '2018-10-28 05:52:31', 'mZZ4fuV0ewkOhSWIGpXcmZb98WA5DmDxqKIf0wsK9Q1Wb3PooaOyBUf5Pmmz'),
(9, 'Sandeep', 'Panwar', NULL, 'Sandeep@gmail.com', '$2y$10$V/VMyAQFTbfquxi5pBE2J.nVQhnPD.qDva.sdqhtUO5Q4s1fLPyf.', 3, NULL, NULL, 1, NULL, '2018-10-28', NULL, '2018-10-28 05:57:50', 'TArgNUSZf4MOFYrJ3dXnXgUFxdKPmoPv6ap86tXl29PmWUrRvyabtXButUaV'),
(10, 'Sandeep', 'Panwar', NULL, 'Sandeew1p@gmail.com', '$2y$10$.INPCu91o98QZxbUzSu2POR14Z1QTrnhqSNMsYXO6iaJuylR1tdFm', 3, NULL, NULL, 1, NULL, '2018-10-28', NULL, '2018-10-28 06:02:45', NULL),
(11, 'Sandeep', 'Panwar', NULL, 'Sandee1p@gmail.com', '$2y$10$zij6wt7leKLvNMcRCAB5s.sHNTSIy5sRmhvhTqfke4FXBW1soRuoi', 3, NULL, NULL, 1, NULL, '2018-10-28', NULL, '2018-10-28 06:06:45', 'GWCm4D2eI6KgVbHDapg6b9PpXPoPIKZzKAFOkrLEUeYPMXhFairuTPtHqbdb'),
(12, 'Amrish', 'KKK', NULL, 'amrish@gmail.com', '$2y$10$g.fi6Y.6hqRDrPhGBm6W4OreKw1gG/zKvWzPxqxiYsB6DzWvA7Hgy', 3, NULL, NULL, 1, NULL, '2018-10-28', NULL, '2018-10-28 10:12:05', 'Psc20tYdAUSmuayiWlQ7Ht3BnLSDpfUNjlcHYLfPZsbMsY6VbtxGfJXRW5U1');

-- --------------------------------------------------------

--
-- Table structure for table `user_exam`
--

CREATE TABLE `user_exam` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `subscription_id` int(12) NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_exam`
--

INSERT INTO `user_exam` (`id`, `user_id`, `exam_id`, `subscription_id`, `start_date`, `end_date`, `status`) VALUES
(1, 7, 1, 0, '2018-10-28', NULL, 1),
(2, 7, 3, 0, '2018-10-28', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_wallet`
--

CREATE TABLE `user_wallet` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `amount` double DEFAULT NULL,
  `processing_amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_exam`
--
ALTER TABLE `course_exam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_question`
--
ALTER TABLE `exam_question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_subscription`
--
ALTER TABLE `exam_subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_type`
--
ALTER TABLE `exam_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `institutions`
--
ALTER TABLE `institutions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_options`
--
ALTER TABLE `question_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_right_answer`
--
ALTER TABLE `question_right_answer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_user_id_index` (`user_id`),
  ADD KEY `role_user_role_id_index` (`role_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_user`
--
ALTER TABLE `subscription_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_exam`
--
ALTER TABLE `user_exam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_wallet`
--
ALTER TABLE `user_wallet`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course_exam`
--
ALTER TABLE `course_exam`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exam_question`
--
ALTER TABLE `exam_question`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `exam_subscription`
--
ALTER TABLE `exam_subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `exam_type`
--
ALTER TABLE `exam_type`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `institutions`
--
ALTER TABLE `institutions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `question_options`
--
ALTER TABLE `question_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `question_right_answer`
--
ALTER TABLE `question_right_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscription_user`
--
ALTER TABLE `subscription_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_exam`
--
ALTER TABLE `user_exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_wallet`
--
ALTER TABLE `user_wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
