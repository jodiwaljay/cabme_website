DROP TABLE IF EXISTS `#__bookacab`;

DROP TABLE IF EXISTS `#__cab_type`;

DROP TABLE IF EXISTS `#__postacab`;

DELETE FROM `#__content_types` WHERE (type_alias LIKE 'com_bookacab.%');
