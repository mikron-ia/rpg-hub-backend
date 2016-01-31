CREATE TABLE `description_pack` (
  `description_pack_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  PRIMARY KEY (`description_pack_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `description` (
  `description_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description_pack_id` int(10) unsigned NOT NULL,
  `title` varchar(80) NOT NULL,
  `code` varchar(40) NOT NULL,
  `public_text` text NOT NULL,
  `private_text` text NOT NULL,
  `lang` varchar(8) NOT NULL,
  PRIMARY KEY (`description_id`),
  KEY `description_pack_id` (`description_pack_id`),
  CONSTRAINT `description_ibfk_1` FOREIGN KEY (`description_pack_id`) REFERENCES `description_pack` (`description_pack_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `character` (
  `character_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(80) NOT NULL,
  `name` varchar(120) NOT NULL,
  `data` text NOT NULL,
  `person_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`character_id`),
  KEY `person_id` (`person_id`),
  CONSTRAINT `character_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `group` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(80) NOT NULL,
  `name` varchar(120) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `person` (
  `person_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(80) NOT NULL,
  `name` varchar(120) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `recap` (
  `recap_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(80) NOT NULL,
  `name` varchar(120) NOT NULL,
  `data` text NOT NULL,
  `time` DATETIME NOT NULL,
  PRIMARY KEY (`recap_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `story` (
  `story_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(80) NOT NULL,
  `name` varchar(120) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`story_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
