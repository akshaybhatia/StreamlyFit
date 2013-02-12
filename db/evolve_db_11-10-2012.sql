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

/*Table structure for table `evlove_chat_list` */

DROP TABLE IF EXISTS `evlove_chat_list`;

CREATE TABLE `evlove_chat_list` (
  `chat_list_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `friend_id` bigint(20) DEFAULT NULL,
  `friend_name` varchar(100) DEFAULT NULL,
  `log_count` int(1) DEFAULT '0',
  `chat_status` int(1) DEFAULT '4' COMMENT '1=>Online; 2>Away; 3=> Busy; 4=>Offline',
  PRIMARY KEY (`chat_list_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11655 DEFAULT CHARSET=latin1;

/*Table structure for table `evolve_chat` */

DROP TABLE IF EXISTS `evolve_chat`;

CREATE TABLE `evolve_chat` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `from_id` bigint(20) NOT NULL,
  `to_id` bigint(20) NOT NULL,
  `message` text NOT NULL,
  `sent` bigint(20) NOT NULL,
  `recd` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

/*Table structure for table `evolve_current_playlist` */

DROP TABLE IF EXISTS `evolve_current_playlist`;

CREATE TABLE `evolve_current_playlist` (
  `current_playlist_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `video_id` varchar(500) DEFAULT NULL,
  `sort_order` int(20) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `last_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`current_playlist_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Table structure for table `evolve_friend_list` */

DROP TABLE IF EXISTS `evolve_friend_list`;

CREATE TABLE `evolve_friend_list` (
  `friend_list_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `from_user_id` bigint(20) DEFAULT NULL,
  `to_user_id` bigint(20) DEFAULT NULL,
  `friend_status` enum('R','A','B') DEFAULT 'R',
  PRIMARY KEY (`friend_list_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Table structure for table `evolve_invitation` */

DROP TABLE IF EXISTS `evolve_invitation`;

CREATE TABLE `evolve_invitation` (
  `inv_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `from_user_id` bigint(20) DEFAULT NULL,
  `to_email_id` varchar(100) DEFAULT NULL,
  `access_token` varchar(100) DEFAULT NULL,
  `is_accept` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`inv_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `evolve_log` */

DROP TABLE IF EXISTS `evolve_log`;

CREATE TABLE `evolve_log` (
  `log_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Foreign Key (evlove_user)',
  `visitor_id` varchar(100) DEFAULT NULL,
  `login_log_id` bigint(20) DEFAULT NULL,
  `log_type_id` int(3) DEFAULT NULL COMMENT 'Foreign Key (evlove_log_type)',
  `log_date` bigint(20) DEFAULT NULL,
  `sub_row_id` bigint(20) DEFAULT '0',
  `ip_addr` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;

/*Table structure for table `evolve_log_login` */

DROP TABLE IF EXISTS `evolve_log_login`;

CREATE TABLE `evolve_log_login` (
  `login_log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `visitor_id` varchar(100) DEFAULT NULL,
  `start_date` bigint(20) DEFAULT NULL,
  `end_date` bigint(20) DEFAULT NULL,
  `duration` bigint(20) DEFAULT NULL,
  `is_login` enum('Y','N') DEFAULT 'N',
  `chat_status` int(1) DEFAULT '4' COMMENT '1=>Online; 2>Away; 3=> Busy; 4=>Offline',
  `ip_addr` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`login_log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `evolve_log_type` */

DROP TABLE IF EXISTS `evolve_log_type`;

CREATE TABLE `evolve_log_type` (
  `log_type_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `log_type_name` varchar(50) DEFAULT NULL,
  `level` enum('H','M','L') DEFAULT 'H' COMMENT 'H=> High, M=> Medium, L=> Low',
  PRIMARY KEY (`log_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

/*Table structure for table `evolve_setting` */

DROP TABLE IF EXISTS `evolve_setting`;

CREATE TABLE `evolve_setting` (
  `setting_id` int(2) NOT NULL AUTO_INCREMENT,
  `fb_app_id` varchar(200) DEFAULT NULL,
  `fb_app_secret` varchar(200) DEFAULT NULL,
  `google_client_id` varchar(200) DEFAULT NULL,
  `google_client_secret` varchar(200) DEFAULT NULL,
  `site_email_id` varchar(200) DEFAULT NULL,
  `site_email_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `evolve_user` */

DROP TABLE IF EXISTS `evolve_user`;

CREATE TABLE `evolve_user` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `email_id` varchar(100) DEFAULT NULL COMMENT 'Email Id (Should be unique)',
  `user_pwd` varchar(100) DEFAULT NULL COMMENT 'User Password',
  `screen_name` varchar(50) DEFAULT NULL COMMENT 'Screen name will displayed on screen',
  `first_name` varchar(100) DEFAULT NULL COMMENT 'First Name',
  `last_name` varchar(100) DEFAULT NULL COMMENT 'Last Name',
  `gender` enum('M','F') DEFAULT NULL,
  `birthday` date DEFAULT NULL COMMENT 'Date of birth',
  `profile_picture` varchar(500) DEFAULT NULL,
  `access_token` varchar(500) DEFAULT NULL,
  `oauth_id` varchar(200) DEFAULT NULL COMMENT 'ID return from Oauth (open standard for authorization)',
  `is_active` enum('Y','N') DEFAULT 'Y' COMMENT 'Y=>Active User, N=> Blocked User',
  `is_verified` enum('Y','N') DEFAULT 'N' COMMENT 'Y=>Email verified, N=> Email not verified (Only required for those user who signup through the website)',
  `signup_type` enum('S','F','G','T') DEFAULT NULL COMMENT 'S=>Site, F=> Facebook Signup, T=>Twitter Signup, G=>Google Signup',
  `membership_type` enum('F','P','T') DEFAULT 'F' COMMENT 'F=>Free, P=>Paid, T=>Trial',
  `last_activity` bigint(20) DEFAULT NULL,
  `health_waiver_form` enum('N','Y') DEFAULT 'N' COMMENT 'Y=>Accepted, N=>Not Accepted',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `evolve_video_invite` */

DROP TABLE IF EXISTS `evolve_video_invite`;

CREATE TABLE `evolve_video_invite` (
  `video_invite_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Video Invite id',
  `view_id` bigint(20) NOT NULL COMMENT 'View Id',
  `video_id` bigint(20) NOT NULL COMMENT 'Video id',
  `user_id` bigint(20) NOT NULL COMMENT 'User id',
  `friend_id` bigint(20) NOT NULL COMMENT 'Friend id',
  `send_date` datetime DEFAULT NULL COMMENT 'Send date',
  `invite_status` enum('A','S') DEFAULT 'S' COMMENT 'A=>Accepted, S=>Send',
  PRIMARY KEY (`video_invite_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `evolve_video_playlist` */

DROP TABLE IF EXISTS `evolve_video_playlist`;

CREATE TABLE `evolve_video_playlist` (
  `playlist_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Playlist id',
  `playlist_title` varchar(255) DEFAULT NULL COMMENT 'Playlist title',
  `user_id` bigint(20) NOT NULL COMMENT 'User id',
  `playlist_cr_dt` datetime DEFAULT NULL COMMENT 'Playlist create time & date',
  `playlist_type` enum('0','1') DEFAULT '0' COMMENT '0=>Normal, 1=>Current/Active playlist',
  `playlist_status` enum('Y','N') DEFAULT 'Y' COMMENT 'Y=>Active, N=>Inactive',
  PRIMARY KEY (`playlist_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Table structure for table `evolve_video_playlist_videos` */

DROP TABLE IF EXISTS `evolve_video_playlist_videos`;

CREATE TABLE `evolve_video_playlist_videos` (
  `playlist_video_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Playlist video id',
  `playlist_id` bigint(20) NOT NULL COMMENT 'Playlist id',
  `video_id` bigint(20) NOT NULL COMMENT 'Video id',
  `sort_order` int(20) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL COMMENT 'Date added',
  `playlist_video_status` enum('Y','N') DEFAULT 'Y' COMMENT 'Y=>Active, N=>Inactive',
  PRIMARY KEY (`playlist_video_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

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

/*Table structure for table `evolve_videos` */

DROP TABLE IF EXISTS `evolve_videos`;

CREATE TABLE `evolve_videos` (
  `video_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Video Id. Primary key. auto increment',
  `video_caption` varchar(255) DEFAULT NULL COMMENT 'Video Caption',
  `video_url` varchar(255) DEFAULT NULL COMMENT 'Video URL',
  `video_sample` varchar(255) DEFAULT NULL COMMENT 'Video Sample',
  `video_image` varchar(255) DEFAULT NULL COMMENT 'Video Thumbnail Image',
  `video_cr_dt` datetime DEFAULT NULL COMMENT 'Video Add Date',
  `video_status` enum('A','I') DEFAULT 'A' COMMENT 'A=>active,I=>inactive',
  `video_complexity_rating` tinyint(2) DEFAULT NULL,
  `video_intensity_rating` tinyint(2) DEFAULT NULL,
  `video_overall_rating` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`video_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Table structure for table `evolve_view_videos` */

DROP TABLE IF EXISTS `evolve_view_videos`;

CREATE TABLE `evolve_view_videos` (
  `view_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key. Auto increment',
  `vid_id` bigint(20) DEFAULT NULL COMMENT 'Video Id. Foreign Key',
  `view_mode` enum('A','WC','WF') DEFAULT NULL COMMENT 'A=>Only video,WC=>video with webcam,WF=>video with friends',
  `viewer_id` bigint(20) DEFAULT NULL COMMENT 'User id who is viewing the video',
  `vid_sess_id` varchar(550) DEFAULT NULL COMMENT 'Tok Box session Id if the viewer opens his cam',
  `buddy_id` bigint(20) DEFAULT NULL COMMENT 'Viewer''s buddy id',
  `view_dt` datetime DEFAULT NULL COMMENT 'Video View date&time',
  `is_buddy_in` enum('Y','N') DEFAULT 'N' COMMENT 'Y=>Buddy shared the web cam, N=>Buddy didn''t share the web cam',
  `buddy_status` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`view_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `evolve_vote_attribs` */

DROP TABLE IF EXISTS `evolve_vote_attribs`;

CREATE TABLE `evolve_vote_attribs` (
  `attrib_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Attribute Id. Primary Key.Auto Increment',
  `atrib_caption` varchar(100) DEFAULT NULL COMMENT 'Attribute caption',
  `cr_dt` datetime DEFAULT NULL COMMENT 'Create date',
  PRIMARY KEY (`attrib_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
