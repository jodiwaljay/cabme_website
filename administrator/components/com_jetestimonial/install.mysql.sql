CREATE TABLE IF NOT EXISTS `#__jetestimonial_testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `companyname` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `avatar_image` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `lvideo` varchar(255) NOT NULL,
  `laudio` varchar(255) NOT NULL,
  `catid` int(11) NOT NULL,
  `published` tinyint(3) NOT NULL,
  `access` tinyint(3) NOT NULL,
  `ordering` int(11) NOT NULL,
  `language` char(7) NOT NULL,
  `posted_date` datetime NOT NULL,
  `modified_by` varchar(255) NOT NULL,
  `modified_date` datetime NOT NULL,
  `checked_out` int(10) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `ip_address` varchar(200) NOT NULL,
  `releasedate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Used to Store Testmonials';

CREATE TABLE IF NOT EXISTS `#__jetestimonial_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme` int(11) NOT NULL,
  `orderby` varchar(100) NOT NULL,
  `sortby` varchar(100) NOT NULL,
  `image_resize` tinyint(3) NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `image_position` varchar(100) NOT NULL,
  `show_introtext` tinyint(3) NOT NULL,
  `cat_image_resize` tinyint(3) NOT NULL,
  `cat_image_height` int(11) NOT NULL,
  `cat_image_width` int(11) NOT NULL,
  `show_image` tinyint(3) NOT NULL,
  `show_pagination_jextn` tinyint(3) NOT NULL,
  `pagination_limit` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Used to Store Settings for JE Testimonial';

CREATE TABLE IF NOT EXISTS `#__jetestimonial_themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `themes` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Used to Store themes';