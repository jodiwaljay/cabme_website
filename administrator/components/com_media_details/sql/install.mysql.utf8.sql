CREATE TABLE IF NOT EXISTS `#__media_details` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`publication_name` VARCHAR(255)  NOT NULL ,
`publication_image` VARCHAR(255)  NOT NULL ,
`headline` VARCHAR(255)  NOT NULL ,
`link` VARCHAR(255)  NOT NULL ,
`shortdesc` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

