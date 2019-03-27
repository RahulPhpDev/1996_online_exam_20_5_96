
RENAME TABLE `exam`.`notification_params` TO `exam`.`notification_alerts`;

ALTER TABLE `notification_alerts` CHANGE `content_params` `notification_params` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;




git add app/Http/Controllers/Auth/UserController.php
git add app/Http/Controllers/HomeController.php
git add app/Notifications/notifyExamSubmission.php
git add database/changes_file.sql
git add resources/views/layouts/partials/header.blade.php
git add resources/views/permit/exam/attempt-exam.blade.php
git add routes/web.php


git add app/Http/Controllers/Admin/AdminNotifyController.php
git add app/Http/Controllers/NotificationController.php
git add app/Model/NotificationAlert.php
git add resources/views/admin/notify/
