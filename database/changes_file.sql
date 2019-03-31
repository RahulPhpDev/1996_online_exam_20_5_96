
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `notification_alerts` (
  `id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subject_param` varchar(255) DEFAULT NULL,
  `notification_params` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `notification_alerts` (`id`, `template_id`, `title`, `subject_param`, `notification_params`) VALUES
(1, 1, 'Exam Attempt By User', '(==user==),(==exam==)', '(==user==),(==exam==),(==date==),(==result==)');


CREATE TABLE `notification_template` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `notification_template` (`id`, `subject`, `message`, `status`) VALUES
(1, '(==user==) has taken (==exam==)', '<div>\r\n(==user==) has taken (==exam==) on (==date==) and here is the result\r\n<div class = \"nopadding\">\r\n (==result==)\r\n</div>\r\n</div>', 1);

ALTER TABLE `notification_alerts`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `notification_template`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `notification_alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `notification_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
