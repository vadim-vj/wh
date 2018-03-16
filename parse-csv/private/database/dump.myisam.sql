
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pattern` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (1,'Pallas',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (2,'CCM',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (3,'Reebok','reebok|rbk');
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (5,'Bauer','bauer|nbh');
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (7,'Tackla',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (8,'Torspo',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (9,'Easton',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (10,'TAC',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (11,'TPS',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (12,'GRAF',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (13,'Salming',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (14,'Koho',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (15,'GRIT',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (16,'Vegum',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (17,'Mad Guy','mad\\s*guy');
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (18,'Jofa',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (19,'Montreal',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (20,'Mission',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (21,'Sher-Wood','sher[\\-\\s]+?wood');
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (22,'Kosa',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (23,'OXDOG',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (24,'Wall',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (25,'FORTUNA',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (26,'SSM',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (27,'Gufex',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (28,'Viking',NULL);
INSERT INTO `brands` (`id`, `name`, `pattern`) VALUES (29,'OAKLEY',NULL);
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pattern` varchar(128) DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`parent_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (1,'Защита','защита',NULL);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (2,'Шлемы','шлем',1);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (3,'Маски, визоры','маска\\s*-\\s*визор|визор\\s*-\\s*маска|маска|визор|защита\\s+лица',1);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (4,'Нагрудники','нагрудник',1);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (5,'Налокотники','налокотник|защита\\s+локтя',1);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (6,'Щитки','щитки|защита\\s+голени',1);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (7,'Перчатки','перчатк(?:а|и)?',1);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (8,'Трусы','трусы|ремень\\s+для\\s+трусов',1);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (9,'Клюшки','клюшк(?:а|и)?',NULL);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (10,'Взрослые','(клюшк(?:а|и)?)\\s+.*\\bSR',9);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (11,'Юниорские','(клюшк(?:а|и)?)\\s+.*\\bJR',9);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (12,'Детские','(клюшк(?:а|и)?)\\s+.*\\bYTH',9);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (13,'Палки, крюки','трубка|рукоят(?:ь|ка)?|крюк|лопаст(?:ь|и)?',9);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (14,'Коньки','коньки',NULL);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (15,'Взрослые','(коньки)\\s+.*\\bSR',14);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (16,'Юниорские','(коньки)\\s+.*\\bJR',14);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (17,'Детские','(коньки)\\s+.*\\bYTH',14);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (18,'Стаканы, лезвия','стакан|лезви(?:е|я)',14);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (19,'Сумки','сумка',NULL);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (20,'Одежда, обувь',NULL,NULL);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (21,'Белье нательное','белье',20);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (22,'Майки тренировочные','майка|рубашка',20);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (23,'Костюмы','костюм|куртка',20);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (24,'Футболки','футболка|поло|футболка\\s+-\\s+поло',20);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (25,'Кофты, толстовки','кофта|толстовка|джемпер|свитер',20);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (26,'Брюки спортивные','брюки',20);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (27,'Обувь','сандали|тапочки',1);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (28,'Аксессуары',NULL,NULL);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (29,'Гамаши','гамаши',28);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (30,'Бандаж','бандаж|шорты(?:\\s*-\\s*бандаж)?|паховая\\s+защита|раковина',28);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (31,'Защита шеи','защита\\s+(?:шеи|горла)',28);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (32,'Защита запястья','защита\\s+запястья',28);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (33,'Пояс для гамаш','пояс\\s+для\\s+гамаш',28);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (34,'Подтяжки','подтяжки',28);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (35,'Шайбы и мячи','шайб(?:а|ы)|мячи?',28);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (36,'Шнурки','шнурки',28);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (37,'Чехлы для коньков','чехлы\\s+для\\s+коньков',28);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (38,'Экипировка вратаря',NULL,NULL);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (39,'Блины','блин',38);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (40,'Ловушки','ловушка',38);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (41,'Блокеры','блокер',38);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (42,'Сетки и гасители','сетка|гаситель',NULL);
INSERT INTO `categories` (`id`, `name`, `pattern`, `parent_id`) VALUES (43,'Защита плеч','защита\\s+плеч',1);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `article` varchar(16) NOT NULL,
  `brand_id` int(10) unsigned DEFAULT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `size` text,
  `color` text,
  `orient` text,
  PRIMARY KEY (`id`),
  KEY `brand_id` (`brand_id`),
  KEY `category_id` (`category_id`),
  KEY `name` (`name`,`model`,`article`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

