(4, '(==crone==) on (==date==)', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n  <title></title>\r\n</head>\r\n<style type=\"text/css\">\r\n  body{width:80%;margin:auto;font-size:21px; font-family: Arial, Helvetica, sans-serif;}\r\n  .common_msg>p,.footer-section,.welcome_note{margin-left:10px}\r\n  .regard_user{font-size:19px}\r\n  .msg_section{margin:10px}\r\n  .common_msg>p{font-size:16px}\r\n  .footer-section{font-size:18px}\r\n  .regard{margin-bottom:4px}\r\n  .footer_div{    margin-top:10px;  }\r\n  .footer_div p, .footer_div span{    display: inline-block !important;  }\r\n  .footer_div p{ width:5%;text-align: left;  }\r\n .footer_div span{  padding-left: 2px;}\r\ntable, th, td { border: 1px solid black;  border-collapse: collapse;}\r\nth, td {  padding: 10px;  text-align: left;}\r\n</style>\r\n<body>\r\n<div class = \"regard_user\">\r\n<h3>\r\nDear Super Admin </h3>\r\n</div>\r\n<div class = \"welcome_note\">\r\nThis is (==crone==) Crone\r\n</div>\r\n\r\n<div class =\"msg_section\">\r\n  on (==date==) (==count==) user register in our portal here is list\r\n</div>\r\n<div class = \"common_msg\">\r\n (==userlist==)\r\n</div>\r\n\r\n<div class=\"footer-section\">\r\n\r\n<div class =\"footer_div\"> <p class =\"footer_para\"> Crone : </p> <span class=\"footer_span\">(==crone==)  </span> </div>\r\n<div class =\"footer_div\"> <p class =\"footer_para\"> Date : </p> <span class=\"footer_span\"> (==date==) </span>  </div>\r\n\r\n  <h4 class = \"regard\" style=\"margin-bottom: 3px\"> Warm Regard </h4>\r\n   <br>  \r\n  MaaRula OnlineTest\r\n  </div>\r\n</body>\r\n</html>', 1);
(4, 4, '(==crone==),(==date==)', '(==crone==),(==date==),(==count==),(==userlist==),(==crone==),(==date==)', 0, NULL, NULL);

CREATE TABLE `extra_attempt` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `attempt` tinyint(4) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `message` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `extra_attempt`
--
ALTER TABLE `extra_attempt`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `extra_attempt`
--
ALTER TABLE `extra_attempt`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
