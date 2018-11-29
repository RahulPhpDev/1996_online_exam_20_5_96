

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
(1, NULL, NULL, NULL, 0, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;





<?php
echo '<pre>';
$subjectParams = "";
$subjectTemplate = "Your User Creditatls ";
$subjectInputParms = '';


if($subjectInputParms){
$arrSubjectParams = explode(',', $subjectParams);
print_r($arrSubjectParams);
        foreach ($arrSubjectParams as $key => $p) {
            $value = $subjectInputParms[$key] ;
            $subjectTemplate = str_replace($p, trim($value), $subjectTemplate);
        
        }
        }
echo $subjectTemplate.'<br>';


$params = "(==email==),(==password==)";
$template = "your email is (==email==) and password is (==password==)";
$inputParms = array('mrrahul2016@gmail.com', '12234');
$finalText = '';
$arrParams = explode(',', $params);

        foreach ($arrParams as $key => $p) {
            $value = $inputParms[$key] ;
            $template = str_replace($p, trim($value), $template);
          
        }
echo $template ;
