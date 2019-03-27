
RENAME TABLE `exam`.`notification_params` TO `exam`.`notification_alerts`;

ALTER TABLE `notification_alerts` CHANGE `content_params` `notification_params` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;


