ALTER TABLE `feedback` ADD `initiat_by` INT(11) NOT NULL DEFAULT '0' AFTER `email`;

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `expiry` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1=>log,2=>unlogin,0=>delete',
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback_meta`
--
ALTER TABLE `feedback_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
