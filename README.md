Sample Channel Guide Application
========================

The application can be accessed at http://guide.gofarming.org/

REQUIREMENTS:
----------------------------------

1. PHP5.4
2. MySQL 5.5.x


Service Class
----------------------------------
   1. The service class that populates the channel list is located at \src/VirginMedia\ChannelGuideBundle\Service\ChannelGuide.php which is injected
      from app/config/services.yml


For the packages (S<M<L), Adjacency List (the "parent" column) has been used as below

CREATE TABLE `package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `closure_table` (
  `ancestor_id` int(11) NOT NULL,
  `descendant_id` int(11) NOT NULL,
  PRIMARY KEY (`ancestor_id`,`descendant_id`),
  KEY `IDX_F5B3CB2C671CEA1` (`ancestor_id`),
  KEY `IDX_F5B3CB21844467D` (`descendant_id`),
  CONSTRAINT `FK_F5B3CB21844467D` FOREIGN KEY (`descendant_id`) REFERENCES `package` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_F5B3CB2C671CEA1` FOREIGN KEY (`ancestor_id`) REFERENCES `package` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `closure_table` VALUES (1,1),(1,2),(1,3),(2,2),(2,3),(3,3);


e.g Channels 1 to 30 are assigned to package "S"
    Channels 31 to 79 are assigned to package "M"
    Channels 80 to 109 are assigned to package "L"

    Hence, package L will contain channels 1 to 109 and M will contain 1 to 79 and S will contain 1 to 30.
