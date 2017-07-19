/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.7.9 : Database - hackathon
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`hackathon` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `hackathon`;

/*Table structure for table `ad` */

DROP TABLE IF EXISTS `ad`;

CREATE TABLE `ad` (
  `ad_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `pay` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `duration` varchar(200) DEFAULT NULL,
  `what_we_offer` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`ad_id`,`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `ad` */

insert  into `ad`(`ad_id`,`company_id`,`date_from`,`date_to`,`sex`,`age`,`pay`,`title`,`duration`,`what_we_offer`) values (1,1,'2017-07-03',NULL,1,15,NULL,'Trazi se pekar za pravljenje, pomaganje na kasi i usluzivanje gostiju',NULL,'Nudimo veselu atmosferu i konkurentsku platu'),(2,2,'2017-07-01','2017-07-04',0,1,22000,'Radnik u trafici',NULL,NULL),(3,2,NULL,NULL,1,1,30000,'Trafika trazi radnika',NULL,'Dobre uslove rada;Redovna plata'),(4,4,NULL,NULL,1,0,40000,'Trazimo konobara',NULL,'Rad u dinamicnom okruzenju;Fleksibilno radno vreme'),(5,4,NULL,NULL,1,2,50000,'Trazi se radnik u kladionici',NULL,NULL),(6,3,NULL,NULL,1,2,30000,'Trazi se vulkanizer',NULL,NULL),(7,2,NULL,NULL,1,1,0,NULL,NULL,'Dobra plata;Prijatna atmosfera'),(8,2,NULL,NULL,1,6,0,NULL,NULL,'Redovna plata'),(9,2,NULL,NULL,1,6,0,NULL,NULL,'Dobar kolektiv'),(10,2,NULL,NULL,1,6,0,NULL,NULL,'Dobar kolektiv'),(11,2,NULL,NULL,1,6,0,NULL,NULL,'Dobar kolektiv'),(12,2,NULL,NULL,1,6,0,NULL,NULL,'Dobar kolektiv2'),(13,2,NULL,NULL,1,6,0,NULL,NULL,'');

/*Table structure for table `company` */

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `logo_url` varchar(500) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `contact` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `company` */

insert  into `company`(`company_id`,`email`,`password`,`name`,`address`,`logo_url`,`description`,`contact`) values (1,'d@d.d','aaaa','Pekara miki i sinovci','Trg Nikole Pasica 9',NULL,'Najbolje peciva u samom centru grada','064 548-58-96'),(2,'a@a.a','aaaa','Trafika Otas','Trg republike 2',NULL,'Najbolja trafika u gradu','065 231-23-32'),(3,'c@c.c','aaaa','Vulkanizer Doska','Seljasnica bb',NULL,'Popravlja i blok motora','064 213-32-32'),(4,'b@b.b','aaaa','Kafana i Kladionica Indirekt','Paunova 45',NULL,'Karirani stolnjaci kao u dobra stara vremena','065 231-32-19');

/*Table structure for table `criteria` */

DROP TABLE IF EXISTS `criteria`;

CREATE TABLE `criteria` (
  `criteria_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`criteria_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `criteria` */

/*Table structure for table `education` */

DROP TABLE IF EXISTS `education`;

CREATE TABLE `education` (
  `education_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `school` varchar(200) NOT NULL,
  `education_level` varchar(100) NOT NULL,
  PRIMARY KEY (`education_id`,`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `education` */

insert  into `education`(`education_id`,`user_id`,`school`,`education_level`) values (1,1,'4. bgd gimnazija','naucimo mnogo stvari koje sam posle mogao da primenim u zivotu'),(2,1,'ETF','neki zahtev znaci haos');

/*Table structure for table `experience_company` */

DROP TABLE IF EXISTS `experience_company`;

CREATE TABLE `experience_company` (
  `experience_company_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) NOT NULL,
  `years` int(11) NOT NULL,
  `position` varchar(200) NOT NULL,
  PRIMARY KEY (`experience_company_id`,`ad_id`),
  KEY `ad_id` (`ad_id`),
  CONSTRAINT `ad_id` FOREIGN KEY (`ad_id`) REFERENCES `ad` (`ad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `experience_company` */

insert  into `experience_company`(`experience_company_id`,`ad_id`,`years`,`position`) values (2,1,2,'Pekar'),(3,2,1,'Zna sve covek');

/*Table structure for table `experience_user` */

DROP TABLE IF EXISTS `experience_user`;

CREATE TABLE `experience_user` (
  `experience_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `position` varchar(200) NOT NULL,
  `company` varchar(200) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`experience_user_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `experience_user` */

insert  into `experience_user`(`experience_user_id`,`user_id`,`position`,`company`,`date_from`,`date_to`,`description`) values (1,1,'pekar , kasir','Dulo peciva','2012-07-04',NULL,'Radio u pekari 5 godina na raznim pozicijama'),(2,1,'PR covek','Pr comp','2017-07-10',NULL,NULL);

/*Table structure for table `picture` */

DROP TABLE IF EXISTS `picture`;

CREATE TABLE `picture` (
  `picture_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  PRIMARY KEY (`picture_id`,`company_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `picture` */

insert  into `picture`(`picture_id`,`company_id`,`url`) values (1,1,'http://localhost/hackathon-api/public/img/images.jpg'),(2,1,'http://localhost/hackathon-api/public/img/Keep-your-employees-safe-healthy-and-happy-through-these-four-HR-suggestions_386_6053672_0_14109651_1000.jpg'),(3,1,'http://localhost/hackathon-api/public/img/costco-workers-604cs040813-800x440-c-default.jpg'),(4,4,'http://mojkontakt.com/wp-content/uploads/2016/05/kladionica-1-800x415.jpg');

/*Table structure for table `requirements` */

DROP TABLE IF EXISTS `requirements`;

CREATE TABLE `requirements` (
  `requirements_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) NOT NULL,
  `text` varchar(500) NOT NULL,
  PRIMARY KEY (`ad_id`,`requirements_id`),
  KEY `requirements_id` (`requirements_id`,`ad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

/*Data for the table `requirements` */

insert  into `requirements`(`requirements_id`,`ad_id`,`text`) values (2,1,'bar 1 godina iskustva rada u pekari'),(3,3,'Znanje engleskog jezika'),(4,3,'Vozacka dozvola B kategorije'),(5,3,'Indeks telesne mase izmedju 18 i 25'),(6,3,'IQ preko 100'),(7,4,'Komunikativan'),(8,6,'Majstor sa velikim iskustvom'),(9,6,'Jak mladic'),(10,6,'Dobar vulkanizer'),(11,7,'Engleski jezik'),(12,7,'Dozvola B kategorije'),(13,8,'Komunikativan'),(14,8,'Snalazljiv'),(15,9,'Engleski jezik'),(16,9,'B kategorija'),(17,10,'Engleski jezik'),(18,10,'B kategorija'),(19,11,'Engleski jezik'),(20,11,'B kategorija'),(21,12,'Engleski jezik'),(22,12,'B kategorija'),(23,13,'dsad');

/*Table structure for table `skill` */

DROP TABLE IF EXISTS `skill`;

CREATE TABLE `skill` (
  `skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `skill_name` varchar(200) NOT NULL,
  `skill_level` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`skill_id`,`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `skill` */

insert  into `skill`(`skill_id`,`user_id`,`skill_name`,`skill_level`) values (1,1,'5  godina iskustva rada u pekari na raznim pozicijama',NULL),(2,1,'5 godina kao pomocnik i radnik na kasi u jednoj pekari na banjici','ma da da'),(3,6,'5 godina kao vulkanizer',NULL);

/*Table structure for table `tag` */

DROP TABLE IF EXISTS `tag`;

CREATE TABLE `tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `tag` */

insert  into `tag`(`tag_id`,`name`) values (1,'Pekar'),(2,'Radnik na trafici'),(3,'Kasir'),(4,'Mesar'),(5,'Radnik u kladionici'),(6,'Spremacica'),(7,'Vulkanizer'),(8,'Radnik na benziskoj pumpi');

/*Table structure for table `tag_ad` */

DROP TABLE IF EXISTS `tag_ad`;

CREATE TABLE `tag_ad` (
  `tag_id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  PRIMARY KEY (`tag_id`,`ad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tag_ad` */

insert  into `tag_ad`(`tag_id`,`ad_id`) values (1,1),(2,1),(2,2),(3,2);

/*Table structure for table `tag_company` */

DROP TABLE IF EXISTS `tag_company`;

CREATE TABLE `tag_company` (
  `tag_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`tag_id`,`company_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tag_company` */

insert  into `tag_company`(`tag_id`,`company_id`) values (1,2),(2,2),(3,2),(7,2);

/*Table structure for table `tag_user` */

DROP TABLE IF EXISTS `tag_user`;

CREATE TABLE `tag_user` (
  `tag_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`tag_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tag_user` */

insert  into `tag_user`(`tag_id`,`user_id`) values (1,1),(3,1);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `can_company_contact` tinyint(1) NOT NULL DEFAULT '0',
  `about_me` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`user_id`,`email`,`password`,`name`,`address`,`can_company_contact`,`about_me`) values (1,'dulerad94@gmail.com','1234','Dusan Radovanovic','Banjica, Beograd',1,'Radnik obezbedjenja'),(7,'micko@gmail.com','1234','Milan Stojevki','Pancevo',1,'Komunikativan i oran za rad. Pizza majstor'),(8,'doska@gmail.com','1234','Stefan Doskovic','Prijepolje',0,'Radnik u kladionici'),(9,'otas@gmail.com','1234','Marko Otasevic','Beograd',0,'Pekar');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
