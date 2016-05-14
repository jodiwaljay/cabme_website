CREATE TABLE IF NOT EXISTS `#__upload_resume` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`job_id` VARCHAR(255)  NOT NULL ,
`job_title` VARCHAR(255)  NOT NULL ,
`job_location` VARCHAR(255)  NOT NULL ,
`your_name` VARCHAR(255)  NOT NULL ,
`email_id` VARCHAR(255)  NOT NULL ,
`mobile_number` VARCHAR(255)  NOT NULL ,
`select_image` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`created_by` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;


INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Resume','com_upload_resume.resume','{"special":{"dbtable":"#__upload_resume","key":"id","type":"Resume","prefix":"Upload ResumeTable"}}', '{"formFile":"administrator\/components\/com_upload_resume\/models\/forms\/resume.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"description"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_upload_resume.resume')
) LIMIT 1;
