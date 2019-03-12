-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2019 at 03:36 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_maarula_exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email_template_id` int(11) DEFAULT NULL,
  `email_subject_params` mediumtext,
  `email_params` mediumtext,
  `notification_template_id` int(11) NOT NULL DEFAULT '0',
  `notification_title_params` mediumtext,
  `notification_params` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`id`, `name`, `email_template_id`, `email_subject_params`, `email_params`, `notification_template_id`, `notification_title_params`, `notification_params`) VALUES
(1, 'User Register', 1, NULL, '(==username==),(==email==),(==password==)\r\n', 0, NULL, NULL),
(2, 'Contact US', 2, '(==subject==)', '(==message==),(==name==),(==email==),(==date==)', 0, NULL, NULL),
(3, 'Contact US Reply', 3, '(==subject==)', '(==user==),(==message==),(==subject==),(==date==),(==link==)', 0, NULL, NULL),
(5, 'New Exam Alert', 5, '(==exam==)', '(==user==),(==exam==),(==totalQuestion==),(==time==),==exam==)', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

CREATE TABLE `email_template` (
  `id` int(11) NOT NULL,
  `subject` mediumtext NOT NULL,
  `message` longtext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_template`
--

INSERT INTO `email_template` (`id`, `subject`, `message`, `status`) VALUES
(1, 'Here are your user credentials ', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<style type=\"text/css\">\r\n	body{width:80%;margin:auto;font-size:21px; font-family: Arial, Helvetica, sans-serif;}\r\n	.common_msg>p,.footer-section,.welcome_note{margin-left:10px}\r\n	.regard_user{font-size:19px}\r\n	\r\n  .msg_section{margin:10px;width:70%;text-align: justify;letter-spacing: .5px}\r\n	.common_msg>p{font-size:16px}\r\n	.footer-section{font-size:18px}\r\n	.regard{margin-bottom:4px}\r\n	.login{padding:3px;font-size: 18px}\r\n</style>\r\n<body>\r\n<div class = \"regard_user\">\r\n<h3>\r\nDear (==username==) </h3>\r\n</div>\r\n<div class = \"welcome_note\">\r\n welcome, we thank you for your registration at MaaRula OnlineTest\r\n</div>\r\n\r\n<div class =\"msg_section\">\r\n  here are login credentials \r\n  <p>\r\n    User Name : (==email==)\r\n  </p>\r\n  <p>\r\n  Password : (==password==)\r\n  </p>\r\n\r\n</div>\r\n<div class = \"common_msg\">\r\n  <p> please click <i> <a class = \"login\" href = \"http://maarulaonlinetest.com/login\" target=\"_blank\"> Login  </a></i>  in your account </p>\r\n</div>\r\n\r\n<div class=\"footer-section\">\r\n  <h4 class = \"regard\" style=\"margin-bottom: 3px\"> Warm Regard </h4>\r\n  Customer Care <br>  \r\n  MaaRula OnlineTest\r\n  </div>\r\n</body>\r\n</html>', 1),
(2, '(==subject==)', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n  <title></title>\r\n</head>\r\n<style type=\"text/css\">\r\n  body{width:80%;margin:auto;font-size:21px; font-family: Arial, Helvetica, sans-serif;}\r\n  .footer-section,.welcome_note{margin-left:10px}\r\n  .regard_user{font-size:19px}\r\n  \r\n  .msg_section{margin:10px;width:70%;text-align: justify;letter-spacing: .5px}\r\n  .footer-section{font-size:18px}\r\n  .regard{margin-bottom:4px}\r\n  .login{padding:3px;font-size: 18px}\r\n</style>\r\n<body>\r\n<div class = \"regard_user\">\r\n<h3>\r\nDear  Super Admin </h3>\r\n</div>\r\n\r\n<div class =\"msg_section\">\r\n  (==message==)\r\n  </p>\r\n\r\n</div>\r\n\r\n\r\n<div class=\"footer-section\">\r\n  <h4 class = \"regard\" style=\"margin-bottom: 3px\">  </h4>\r\n   <p class=\"\"> Name : <span> (==name==)</span></p>\r\n   <p class=\"\"> Email :<span> (==email==)</span></p>\r\n   <p class=\"\"> Date :<span> (==date==)</span></p>\r\n   <span style=\"font-size:15px\"> Please send reply by website  <a href=\"http://www.maarulaonlinetest.com\"> Click</a></span>\r\n  </div>\r\n\r\n</body>\r\n</html>', 1),
(3, 'Reply On (==subject==)', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n  <title></title>\r\n</head>\r\n<style type=\"text/css\">\r\n  body{width:80%;margin:auto;font-size:19px; font-family: Arial, Helvetica, sans-serif;}\r\n  .footer-section,.welcome_note{margin-left:10px}\r\n  .regard_user{font-size:19px}\r\n  .msg_section{margin:10px;width:70%;text-align: justify;letter-spacing: .5px}\r\n  .footer-section{font-size:16px}\r\n  .regard{margin-bottom:4px}\r\n  .login{padding:3px;font-size: 18px}\r\n</style>\r\n<body>\r\n<div class = \"regard_user\">\r\n<h3>\r\nDear  (==user==) </h3>\r\n</div>\r\n\r\n\r\n<div class =\"msg_section\">\r\n  <p>\r\n    (==message==)</p>\r\n\r\n</div>\r\n\r\n<div class=\"footer-section\">\r\n  <h4 class = \"regard\" style=\"margin-bottom: 3px\">  </h4>\r\n   <p class=\"\"> Reply On  : <span> (==subject==)</span></p>\r\n   <p class=\"\">Previous Message Send On  : <span> (==date==)</span></p>\r\n\r\n </div>\r\n\r\n\r\n<span class=\"\"> Please  <a href=\"(==link==)\"> click here </a> to reply</span>\r\n<p><span style=\"font-size: 10px;font-style: italic;\" > Note: This link will be expiry after 12 hours and you can only send one message by clicking this  link </span></p>\r\n<div class=\"footer-section\">\r\n  \r\n  <h4 class = \"regard\" style=\"margin-bottom: 3px\">  </h4>\r\n  Warm Regard : MaaRulaOnline Test\r\n  </div>\r\n</body>\r\n</html>', 1),
(4, '(==crone==) on (==date==)', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n  <title></title>\r\n</head>\r\n<style type=\"text/css\">\r\n  body{width:80%;margin:auto;font-size:21px; font-family: Arial, Helvetica, sans-serif;}\r\n  .common_msg>p,.footer-section,.welcome_note{margin-left:10px}\r\n  .regard_user{font-size:19px}\r\n  .msg_section{margin:10px}\r\n  .common_msg>p{font-size:16px}\r\n  .footer-section{font-size:18px}\r\n  .regard{margin-bottom:4px}\r\n  .footer_div{    margin-top:10px;  }\r\n  .footer_div p, .footer_div span{    display: inline-block !important;  }\r\n  .footer_div p{ width:5%;text-align: left;  }\r\n .footer_div span{  padding-left: 2px;}\r\ntable, th, td { border: 1px solid black;  border-collapse: collapse;}\r\nth, td {  padding: 10px;  text-align: left;}\r\n</style>\r\n<body>\r\n<div class = \"regard_user\">\r\n<h3>\r\nDear Super Admin </h3>\r\n</div>\r\n<div class = \"welcome_note\">\r\nThis is (==crone==) Crone\r\n</div>\r\n\r\n<div class =\"msg_section\">\r\n  on (==date==) (==count==) user register in our portal here is list\r\n</div>\r\n<div class = \"common_msg\">\r\n (==userlist==)\r\n</div>\r\n\r\n<div class=\"footer-section\">\r\n\r\n<div class =\"footer_div\"> <p class =\"footer_para\"> Crone : </p> <span class=\"footer_span\">(==crone==)  </span> </div>\r\n<div class =\"footer_div\"> <p class =\"footer_para\"> Date : </p> <span class=\"footer_span\"> (==date==) </span>  </div>\r\n\r\n  <h4 class = \"regard\" style=\"margin-bottom: 3px\"> Warm Regard </h4>\r\n   <br>  \r\n  MaaRula OnlineTest\r\n  </div>\r\n</body>\r\n</html>', 1),
(5, 'explore new Exam (==exam==)', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n  <title></title>\r\n</head>\r\n<style type=\"text/css\">\r\n  body{width:80%;margin:auto;font-size:21px; font-family: Arial, Helvetica, sans-serif;}\r\n  .footer-section,.welcome_note{margin-left:10px}\r\n  .regard_user{font-size:19px}\r\n  .msg_section{margin:10px;width:70%;text-align: justify;letter-spacing: .5px}\r\n  .footer-section{font-size:18px}\r\n  .regard{margin-bottom:4px}\r\n  .login{padding:3px;font-size: 18px}\r\n  .left_span{    width: 21% !important;\r\n    display: inline-block;text-align: right;padding-right:20px;}\r\n    .welcome_note > p{line-height: 28px;font-size: 18px }\r\n</style>\r\n<body>\r\n<div class = \"regard_user\">\r\n<h3>\r\nDear  (==user==) </h3>\r\n</div>\r\n<div class = \"welcome_note\">\r\n  <p>\r\nWe are delight to inform that we have New Exam for you,\r\n<br>\r\nPut your knowledge to the test and prove your mastery by taking the Quiz...\r\n<br>\r\nby taking our  by taking this helpful Quiz!\r\n</p>\r\n\r\n</div>\r\n\r\n<div class =\"msg_section\">\r\n    <p> <span class =\"left_span\">Exam Name :</span>  <span> (==exam==) </span>\r\n    <p> <span class =\"left_span\"> Total Question :</span><span> (==totalQuestion==) </span>\r\n    <p><span class =\"left_span\"> Duration : </span><span> (==time==) Min. </span>\r\n</div>\r\n\r\n<p style=\"font-size:14px\"> For any inconvenience Click <a href = \"http://maarulaonlinetest.com/contactUs\"> Contact Us </a> to give us your feedback </p>\r\n\r\n<p > click <a href = \"http://maarulaonlinetest.com/\"> MaaRula Online Test </a> to explore (==exam==) Test </p>\r\n<div class=\"footer-section\">\r\n  \r\n  <h4 class = \"regard\" style=\"margin-bottom: 3px\">  </h4>\r\n  Warm Regard : MaaRulaOnline Test\r\n  </div>\r\n</body>\r\n</html>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `initiat_by` int(11) NOT NULL DEFAULT '0',
  `token` varchar(255) DEFAULT NULL,
  `expiry` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1=>log,2=>unlogin,0=>delete',
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `subject`, `name`, `email`, `initiat_by`, `token`, `expiry`, `status`, `created_date`) VALUES
(1, 'unable to take test', 'McKenzi', 'mckenji@yahoo.in', 0, 'Et3aH6GOemiGbV2pSMEGwNlB94tRj9vQf9d9YCAd3dZHoOPwg3', '2019-03-09 22:19:56', 2, '0000-00-00 00:00:00'),
(2, 'Login user', 'Rahul Chauhan', 'rahul@gmail.com', 35, 'WwG1O0tx45ki1WB0Qcmlkv7CZFz46FEmIv59X2YcpBetuM8GBu', '2019-03-09 22:21:42', 1, '0000-00-00 00:00:00'),
(3, 'Contact Us for Encypted', 'Rahul Chauhan', 'rahul@gmail.com', 35, NULL, NULL, 1, '0000-00-00 00:00:00'),
(4, 'Contact US', 'Rahul', 'rahul123@gmail.com', 0, '', '0000-00-00 00:00:00', 2, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_meta`
--

CREATE TABLE `feedback_meta` (
  `id` int(11) NOT NULL,
  `feedback_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `isRead` tinyint(1) DEFAULT '0',
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback_meta`
--

INSERT INTO `feedback_meta` (`id`, `feedback_id`, `message`, `sender`, `receiver`, `status`, `isRead`, `create_date`) VALUES
(1, 1, 'Hii, I am not able to take test. Please help.', 0, 1, 0, 1, '2019-03-09 20:13:01'),
(2, 1, 'Hi, Sorry for the inconvenience. Please give us some time to investigate your issue.', 1, 0, 0, 0, '2019-03-09 20:16:18'),
(3, 1, 'hii thanks', 0, 1, 0, 1, '2019-03-09 20:18:49'),
(4, 1, 'thanks for your message', 1, 0, 0, 0, '2019-03-09 20:19:56'),
(5, 2, 'this is message for you', 35, 1, 0, 1, '2019-03-09 20:20:58'),
(6, 2, 'fhfh gjhg tu', 1, 35, 0, 1, '2019-03-09 20:21:42'),
(7, 3, 'Contact Us for Encypted  Contact Us for Encypted  Contact Us for Encypted', 35, 1, 0, 1, '2019-03-09 21:20:37'),
(8, 2, 'her eis anothr one', 35, 1, 0, 1, '2019-03-09 22:08:59'),
(9, 4, 'Lorem Ipsum is simply dummy text of the printing and typesetting industryLorem Ipsum is simply dummy text of the printing and typesetting industryLorem Ipsum is simply dummy text of the printing and typesetting industryLorem Ipsum is simply dummy text of the printing and typesetting industry', 0, 1, 0, 1, '2019-03-11 00:00:21'),
(10, 4, 'ok get your message', 1, 0, 0, 0, '2019-03-11 00:25:01'),
(11, 4, 'ok get your message', 1, 0, 0, 0, '2019-03-11 00:25:45'),
(12, 4, 'here is another message', 1, 0, 0, 0, '2019-03-11 00:26:02'),
(13, 4, 'here is another message', 1, 0, 0, 0, '2019-03-11 00:26:47'),
(14, 4, 'here is another message', 1, 0, 0, 0, '2019-03-11 00:27:43'),
(15, 4, 'check this last', 1, 0, 0, 0, '2019-03-11 00:27:59'),
(16, 4, 'check this last', 1, 0, 0, 0, '2019-03-11 00:28:19'),
(17, 4, 'gjg gjgj ituig kggkjgk', 1, 0, 0, 0, '2019-03-11 00:29:13'),
(18, 4, 'here is reply on this', 1, 0, 0, 0, '2019-03-11 00:30:00'),
(19, 4, 'thanks', 0, 1, 0, 0, '2019-03-11 00:34:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_template`
--
ALTER TABLE `email_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback_meta`
--
ALTER TABLE `feedback_meta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `email_template`
--
ALTER TABLE `email_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedback_meta`
--
ALTER TABLE `feedback_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
