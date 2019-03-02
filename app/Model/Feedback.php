<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $guarded = [];
    public $timestamps = false;
}



// CREATE TABLE `email_forward` (
//   `id` int(11) NOT NULL,
//   `user_id` int(11) NOT NULL,
//   `email` varchar(255) NOT NULL,
//   `alert_id` int(11) NOT NULL,
//   `sujbect` mediumtext NOT NULL,
//   `message` longtext NOT NULL,
//   `send_date` datetime NOT NULL,
//   `status` tinyint(4) NOT NULL DEFAULT '0'
// ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

// --
// -- Indexes for dumped tables
// --

// --
// -- Indexes for table `email_forward`
// --
// ALTER TABLE `email_forward`
//   ADD PRIMARY KEY (`id`);

// --
// -- AUTO_INCREMENT for dumped tables
// --

// --
// -- AUTO_INCREMENT for table `email_forward`
// --
// ALTER TABLE `email_forward`
//   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
// COMMIT;
