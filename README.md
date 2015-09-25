Sample Channel Guide Application using Symfony2
========================

APPLICATION BACKGROUND
  1. We have various sets of channels available in the different regions of the country. Each channel has a number and a title, which sometimes differs from region to region
  2. We	also have three packages (S/M/L), so that all channels in a given package are present in all the larger ones. (And obviously S<M<L)
  3. The packages are the same in all regions

APPLICATION REQUIRMENTS
  1. Create a channel guide for customer using Symfony2
  2. Keep it simple, so it will be web only and needs a simple web interface
  3. As a user, I want to see the list of channels, for the selected region and package.
  Upon changing the region or package selection, the page should refresh itself without loading.

SYSTEM REQUIREMENTS:
----------------------------------

1. PHP5.4
2. MySQL 5.5.x

HOW TO RUN:
----------------------------------

1. git clone https://github.com/mesme/channel_guide.git
2. change directory into channel_guide
3. type "composer.phar update"
4. type "app/console doctrine:database:create" to create the database
5. type "app/console doctrine:schema:update --force" to create the schema
6. type "mysql -uroot -ppassword symfony < channel.sql" to import sample data needed to run the application
7. type "ifconfig" in linux box and note the IP address of the machine e.g 192.168.2.10:8080
8. type "app/console server:run 192.168.3.10:8080"
9. now go to browser e.g chrome or firefox http://192.168.3.10:8080 to see it working

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
