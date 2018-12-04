
CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
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

INSERT INTO `alerts` (`id`, `email_template_id`, `email_subject_params`, `email_params`, `notification_template_id`, `notification_title_params`, `notification_params`) VALUES
(1, 1, NULL, '(==username==),(==email==),(==password==)\r\n', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_forward`
--

CREATE TABLE `email_forward` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `alert_id` int(11) NOT NULL,
  `sujbect` mediumtext NOT NULL,
  `message` longtext NOT NULL,
  `send_date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'Here are your user credentials ', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<style type=\"text/css\">\r\n	body{width:80%;margin:auto;font-size:17px; font-family: Arial, Helvetica, sans-serif;}\r\n	.common_msg>p,.footer-section,.welcome_note{margin-left:10px}\r\n	.regard_user{font-size:19px}\r\n	.msg_section{margin:10px}\r\n	.common_msg>p{font-size:16px}\r\n	.footer-section{font-size:18px}\r\n	.regard{margin-bottom:4px}\r\n	.login{padding:3px;font-size: 18px}\r\n</style>\r\n<body>\r\n<div class = \"regard_user\">\r\n<h3>\r\nDear (==username==) </h3>\r\n</div>\r\n<div class = \"welcome_note\">\r\n welcome, we thank you for your registration at (##SiteName##)\r\n</div>\r\n\r\n<div class =\"msg_section\">\r\n  here are login credentials \r\n  <p>\r\n    User Name : (==email==)\r\n  </p>\r\n  <p>\r\n  Password : (==password==)\r\n  </p>\r\n\r\n</div>\r\n<div class = \"common_msg\">\r\n  <p> please click <i> <a class = \"login\" href = \"dfjl\" target=\"_blank\"> Login  </a></i> login in your account </p>\r\n</div>\r\n\r\n<div class=\"footer-section\">\r\n  <h4 class = \"regard\" style=\"margin-bottom: 3px\"> Warm Regard </h4>\r\n  Customer Care <br>  \r\n  (##SiteName##)\r\n  </div>\r\n</body>\r\n</html>', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_forward`
--
ALTER TABLE `email_forward`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_template`
--
ALTER TABLE `email_template`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email_forward`
--
ALTER TABLE `email_forward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_template`
--
ALTER TABLE `email_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
