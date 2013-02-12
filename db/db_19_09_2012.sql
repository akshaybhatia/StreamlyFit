/*
SQLyog Ultimate v8.55 
MySQL - 5.1.33-community : Database - evolve
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`evolve` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `evolve`;

/*Table structure for table `evolve_log` */

DROP TABLE IF EXISTS `evolve_log`;

CREATE TABLE `evolve_log` (
  `log_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Foreign Key (evlove_user)',
  `log_type_id` int(3) DEFAULT NULL COMMENT 'Foreign Key (evlove_log_type)',
  `log_date` datetime DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `evolve_log` */

/*Table structure for table `evolve_log_type` */

DROP TABLE IF EXISTS `evolve_log_type`;

CREATE TABLE `evolve_log_type` (
  `log_type_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `log_type_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`log_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `evolve_log_type` */

insert  into `evolve_log_type`(`log_type_id`,`log_type_name`) values (1,'Sign Up'),(2,'Sign In'),(3,'Signout'),(4,'Account verification'),(5,'User account activation'),(8,'Friend request approved'),(6,'User account blocking'),(7,'Friend request send');

/*Table structure for table `evolve_user` */

DROP TABLE IF EXISTS `evolve_user`;

CREATE TABLE `evolve_user` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `email_id` varchar(100) DEFAULT NULL COMMENT 'Email Id (Should be unique)',
  `user_pwd` varchar(100) DEFAULT NULL COMMENT 'User Password',
  `screen_name` varchar(50) DEFAULT NULL COMMENT 'Screen name will displayed on screen',
  `first_name` varchar(100) DEFAULT NULL COMMENT 'First Name',
  `last_name` varchar(100) DEFAULT NULL COMMENT 'Last Name',
  `is_active` enum('Y','N') DEFAULT 'Y' COMMENT 'Y=>Active User, N=> Blocked User',
  `is_verified` enum('Y','N') DEFAULT 'N' COMMENT 'Y=>Email verified, N=> Email not verified (Only required for those user who signup through the website)',
  `signup_type` enum('S','F','G','T') DEFAULT NULL COMMENT 'S=>Site, F=> Facebook Signup, T=>Twitter Signup, G=>Google Signup',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `evolve_user` */

/*Table structure for table `evolve_video_votes` */

DROP TABLE IF EXISTS `evolve_video_votes`;

CREATE TABLE `evolve_video_votes` (
  `vote_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `video_id` bigint(20) DEFAULT NULL,
  `vote_type` enum('A','U') DEFAULT 'U' COMMENT 'A=>Anonymous,U=>User',
  `user_id` bigint(20) DEFAULT NULL,
  `vote_attrib_id` int(11) DEFAULT NULL,
  `val` decimal(8,2) DEFAULT NULL,
  `vote_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`vote_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `evolve_video_votes` */

/*Table structure for table `evolve_videos` */

DROP TABLE IF EXISTS `evolve_videos`;

CREATE TABLE `evolve_videos` (
  `vid_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vid_caption` varchar(255) DEFAULT NULL,
  `vid_url` varchar(255) DEFAULT NULL,
  `cr_dt` datetime DEFAULT NULL,
  `status` enum('A','I') DEFAULT 'A',
  PRIMARY KEY (`vid_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `evolve_videos` */

/*Table structure for table `evolve_view_videos` */

DROP TABLE IF EXISTS `evolve_view_videos`;

CREATE TABLE `evolve_view_videos` (
  `view_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vid_id` bigint(20) DEFAULT NULL,
  `view_mode` enum('A','WC','WF') DEFAULT NULL COMMENT 'A=>Only video,WC=>video with webcam,WF=>video with friends',
  `viewer_id` bigint(20) DEFAULT NULL,
  `vid_sess_id` varchar(255) DEFAULT NULL,
  `buddy_id` bigint(20) DEFAULT NULL,
  `view_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`view_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `evolve_view_videos` */

/*Table structure for table `evolve_vote_attribs` */

DROP TABLE IF EXISTS `evolve_vote_attribs`;

CREATE TABLE `evolve_vote_attribs` (
  `attrib_id` int(11) NOT NULL AUTO_INCREMENT,
  `atrib_caption` varchar(100) DEFAULT NULL,
  `cr_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`attrib_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `evolve_vote_attribs` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
