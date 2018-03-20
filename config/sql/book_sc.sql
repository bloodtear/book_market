/*
SQLyog 企业版 - MySQL GUI v8.14 
MySQL - 5.5.20-log : Database - book_sc
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`book_sc` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `book_sc`;

/*Table structure for table `address` */

DROP TABLE IF EXISTS `address`;

CREATE TABLE `address` (
  `ship_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '收货地址ID',
  `customerid` int(10) unsigned NOT NULL COMMENT '用户的ID可重复',
  `is_default` int(1) NOT NULL COMMENT '是否是默认地址',
  `ship_person` varchar(20) NOT NULL COMMENT '收货人',
  `ship_city` varchar(20) NOT NULL COMMENT '收货城市/省',
  `ship_district` char(20) NOT NULL COMMENT '收货地区/县',
  `ship_addr` char(30) NOT NULL COMMENT '收货详细地址',
  `ship_zip` char(6) DEFAULT NULL COMMENT '收货邮编',
  `ship_tel` char(11) NOT NULL COMMENT '联系电话',
  `ship_tel2` char(11) DEFAULT NULL COMMENT '备用联系电话',
  `ship_email` char(30) DEFAULT NULL COMMENT '收货的email',
  `submit_time` char(40) NOT NULL COMMENT '收货地址提交的时间，为时间戳形式',
  PRIMARY KEY (`ship_id`),
  KEY `customerid` (`customerid`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

/*Data for the table `address` */

insert  into `address`(`ship_id`,`customerid`,`is_default`,`ship_person`,`ship_city`,`ship_district`,`ship_addr`,`ship_zip`,`ship_tel`,`ship_tel2`,`ship_email`,`submit_time`) values (1,1,1,'123','1','1','12321312','312312','123213','12321312','3123','1'),(19,1,0,'12321','1','1','12321312321','','1','','','1456717597');

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `username` char(16) NOT NULL COMMENT '用户姓名',
  `PASSWORD` char(40) NOT NULL COMMENT '密码',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `admin` */

insert  into `admin`(`username`,`PASSWORD`) values ('admin','admin'),('管理员','admin');

/*Table structure for table `books` */

DROP TABLE IF EXISTS `books`;

CREATE TABLE `books` (
  `isbn` char(13) NOT NULL COMMENT 'isbn号码，主键',
  `author` char(100) DEFAULT NULL COMMENT '作者',
  `title` char(100) DEFAULT NULL COMMENT '标题',
  `catid` int(10) unsigned DEFAULT NULL COMMENT '分类ID',
  `price` float(6,2) NOT NULL COMMENT '价格',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`isbn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `books` */

insert  into `books`(`isbn`,`author`,`title`,`catid`,`price`,`description`) values ('9787020037704','唐浩明','曾国藩（上中下）',2,1234.04,'长篇历史小说《曾国藩》既写曾国藩的文韬武略，也写他的待人处民与生活态度；既写他的困厄与成功，也写他的得宠与失宠。曾国藩制胜的兵法、治军行政的方针，他独特的人生观、处世哲学，他的文化素养和人格品位等等，都在作品中得以表现。'),('9787508601632','约翰·S. 戈登','伟大的博弈',1,39.00,'《伟大的博弈》是一部讲述以华尔街为代表的美国资本市场发展历史的著作。这本书以华尔街为主线展示了美国资本市场发展的全过程。它生动地讲述了华尔街从一条普普通通的小街发展成为世界金融中心的传奇般的历史，展现了以华尔街为代表的美国资本市场在美国经济发展和腾飞过程中的巨大作用。书中大量的历史事实和经济数据，让读者可以更全面和准确地认识美国资本市场的发展过程。'),('9787508646572','吴晓波','激荡三十年：中国企业1978~2008. 下',1,99.99,'本书是《激荡三十年》修订版。尽管任何一段历史都有它不可替代的独特性，可是，1978年—2008年的中国，却是最不可能重复的。作者站在民间的角度，以真切而激扬的写作手法描绘了中国企业在改革开放年代走向市场、走向世界的成长、发展之路。改革开放初期汹涌的商品大潮；国营企业、民营企业、外资企业，这三种力量此消彼长、互相博弈的曲折发展；整个社会的躁动和不安……整部书稿中都体现得极为真切和实在。作者用激扬的文字再现出人们在历史创造中的激情、喜悦、呐喊、苦恼和悲愤。'),('9787544270878','东野圭吾','解忧杂货店',2,39.50,'现代人内心流失的东西，这家杂货店能帮你找回——僻静的街道旁有一家杂货店，只要写下烦恼投进卷帘门的投信口，第二天就会在店后的牛奶箱里得到回答。因男友身患绝症，年轻女孩静子在爱情与梦想间徘徊；克郎为了音乐梦想离家漂泊，却在现实中寸步难行；少年浩介面临家庭巨变，挣扎在亲情与未来的迷茫中……他们将困惑写成信投进杂货店，随即奇妙的事情竟不断发生。生命中的一次偶然交会，将如何演绎出截然不同的人生？如今回顾写作过程，我发现自己始终在思考一个问题：站在人生的岔路口，人究竟应该怎么做？我希望读者能在掩卷时喃喃自语：我从未读'),('9787560970189','Marty Cagan','启示录',3,12.99,'为什么市场上那么多软件产品无人问津，成功的产品凤毛麟角？怎样发掘有价值的产品？拿什么说服开发团队接受你的产品设计？如何将敏捷方法融入产品开发？过去二十多年，Marty Cagan作为高级产品经理人为多家一流企业工作过，包括惠普、网景、美国在线、eBay。他亲历了个人电脑 、互联网、 电子商务的起落沉浮。《启示录：打造用户喜爱的产品》从人员、流程、产品三个角度介绍了现代软件（互联网）产品管理的实践经验和理念。七印部落正在翻译作者的博客和授课视频，欢迎访问微博：http://weibo.com/7seals');

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `catid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `catname` char(60) NOT NULL COMMENT '分类名称',
  PRIMARY KEY (`catid`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `categories` */

insert  into `categories`(`catid`,`catname`) values (1,'经济'),(2,'文学'),(3,'产品设计'),(12,'科学'),(13,'我是类别'),(14,'WOW'),(15,'14'),(16,'15'),(17,'16123'),(18,'16123'),(19,'16123'),(20,'文学'),(21,'文学'),(22,'产品设计'),(23,'产品设计'),(24,'产品设计'),(25,'经济'),(26,'文学'),(27,'文学'),(28,'文学'),(29,'文学'),(30,'经济');

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `customerid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '客户id',
  `username` varchar(60) NOT NULL COMMENT '用户名',
  `email` varchar(80) NOT NULL COMMENT 'email',
  `password` char(30) NOT NULL COMMENT '密码',
  PRIMARY KEY (`customerid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `customers` */

insert  into `customers`(`customerid`,`username`,`email`,`password`) values (1,'xiaoyu','xiaoyu@126.com','xiaoyu'),(4,'liuyan','xiaoyu1120520@126.com','liuyan'),(5,'xiaoyu1','xiaoyu1120520@126.com','xiaoyu1'),(6,'xiaoshiyue','123123@12','xiaoshiyue');

/*Table structure for table `helps` */

DROP TABLE IF EXISTS `helps`;

CREATE TABLE `helps` (
  `helpid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `have_img` char(255) NOT NULL,
  `type` char(255) NOT NULL,
  `is_pop` int(2) NOT NULL,
  PRIMARY KEY (`helpid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `helps` */

/*Table structure for table `order_items` */

DROP TABLE IF EXISTS `order_items`;

CREATE TABLE `order_items` (
  `orderid` int(10) unsigned NOT NULL,
  `isbn` char(1) NOT NULL,
  `item_price` float(4,2) NOT NULL,
  `quantity` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`orderid`,`isbn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `order_items` */

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `orderid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customerid` int(10) unsigned NOT NULL,
  `amount` float(6,2) DEFAULT NULL,
  `DATE` date NOT NULL,
  `ship_name` char(60) NOT NULL,
  `ship_address` char(60) NOT NULL,
  `ship_city` char(30) NOT NULL,
  `ship_state` char(20) DEFAULT NULL,
  `ship_zip` char(10) DEFAULT NULL,
  `ship_country` char(20) NOT NULL,
  PRIMARY KEY (`orderid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `orders` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
