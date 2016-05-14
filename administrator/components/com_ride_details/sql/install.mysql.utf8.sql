CREATE TABLE IF NOT EXISTS `#__ride_details` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`userimg` VARCHAR(255)  NOT NULL ,
`name` VARCHAR(255)  NOT NULL ,
`rides` VARCHAR(255)  NOT NULL ,
`rating` VARCHAR(255)  NOT NULL ,
`date` DATE NOT NULL DEFAULT '0000-00-00',
`time` TIME NOT NULL ,
`srcaddress` VARCHAR(255)  NOT NULL ,
`dstaddress` VARCHAR(255)  NOT NULL ,
`pickuppoint` VARCHAR(255)  NOT NULL ,
`cartype` VARCHAR(255)  NOT NULL ,
`allowed` VARCHAR(255)  NOT NULL ,
`verified` VARCHAR(255)  NOT NULL ,
`price` VARCHAR(255)  NOT NULL ,
`seats` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;


INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'ridedetail','com_ride_details.ridedetail','{"special":{"dbtable":"#__ride_details","key":"id","type":"ridedetail","prefix":"Ride DetailsTable"}}', '{"formFile":"administrator\/components\/com_ride_details\/models\/forms\/ridedetail.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_ride_details.ridedetail')
) LIMIT 1;
