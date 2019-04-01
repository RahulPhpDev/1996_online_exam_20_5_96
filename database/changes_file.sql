
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




ALTER TABLE `exams` ADD `is_new` ENUM('yes','no') NOT NULL DEFAULT 'no' AFTER `edit_date`;


alter table exams add exam_ref varchar(10) default null after exam_name;
update exams set exam_ref = concat('MOT_', (CASE when length(id) = 1 then '00' when length(id) = 2 then '0' end) ,id )
 
update users set user_ref = concat('MOT_', (select lpad(id,3,0) from users));
update users set user_ref = (concat('MOT_',lpad(id, 3, 0)));
