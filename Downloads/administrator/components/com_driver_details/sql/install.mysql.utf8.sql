CREATE TABLE IF NOT EXISTS `#__driver_details` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`duid` VARCHAR(255)  NOT NULL ,
`ducat` VARCHAR(255)  NOT NULL ,
`dname` VARCHAR(255)  NOT NULL ,
`demail` VARCHAR(255)  NOT NULL ,
`dmobile` VARCHAR(255)  NOT NULL ,
`dpass` VARCHAR(255)  NOT NULL ,
`dgen` VARCHAR(255)  NOT NULL ,
`daddr` TEXT NOT NULL ,
`cab_no` VARCHAR(255)  NOT NULL ,
`cab_type` VARCHAR(255)  NOT NULL ,
`price_per_km` VARCHAR(255)  NOT NULL ,
`license_no` VARCHAR(255)  NOT NULL ,
`license_copy` VARCHAR(255)  NOT NULL ,
`route_prefer` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;


INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Driver Detail','com_driver_details.driverdetail','{"special":{"dbtable":"#__driver_details","key":"id","type":"Driver Detail","prefix":"Driver DetailsTable"}}', '{"formFile":"administrator\/components\/com_driver_details\/models\/forms\/driverdetail.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"daddr"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_driver_details.driverdetail')
) LIMIT 1;
