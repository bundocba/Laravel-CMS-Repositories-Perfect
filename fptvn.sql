/*
MySQL Data Transfer
Source Host: 127.0.0.1
Source Database: fptvn
Target Host: 127.0.0.1
Target Database: fptvn
Date: 7/6/2016 2:40:34 PM
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for admin_menu_links
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu_links`;
CREATE TABLE `admin_menu_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `controller` varchar(50) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for admin_menus
-- ----------------------------
DROP TABLE IF EXISTS `admin_menus`;
CREATE TABLE `admin_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `menu_link_id` int(11) DEFAULT NULL,
  `link_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for admin_user_preferences
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_preferences`;
CREATE TABLE `admin_user_preferences` (
  `id` int(11) NOT NULL,
  `two_factor_auth` tinyint(4) DEFAULT NULL,
  `secret_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for admin_user_tokens
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_tokens`;
CREATE TABLE `admin_user_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `agent` varchar(2000) DEFAULT NULL,
  `expired_date` datetime DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `FK_admin_roles` (`role_id`),
  CONSTRAINT `FK_admin_users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for content_types
-- ----------------------------
DROP TABLE IF EXISTS `content_types`;
CREATE TABLE `content_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for district
-- ----------------------------
DROP TABLE IF EXISTS `district`;
CREATE TABLE `district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_district_province` (`province_id`),
  CONSTRAINT `FK_district_province` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=705 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for language
-- ----------------------------
DROP TABLE IF EXISTS `language`;
CREATE TABLE `language` (
  `code` varchar(10) NOT NULL DEFAULT '',
  `date_format` varchar(50) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for menu_links
-- ----------------------------
DROP TABLE IF EXISTS `menu_links`;
CREATE TABLE `menu_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `target` varchar(10) DEFAULT NULL,
  `lang` varchar(5) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `content_type_id` int(11) DEFAULT NULL,
  `content_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `lang` varchar(5) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(2000) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `path` varchar(2000) DEFAULT NULL,
  `intro_text` varchar(2000) DEFAULT NULL,
  `body` blob,
  `content_type_id` int(11) DEFAULT NULL,
  `lang` varchar(5) DEFAULT NULL,
  `allow_comment` tinyint(4) DEFAULT NULL,
  `thumb_url` varchar(2000) DEFAULT NULL,
  `comment_count` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `sticked` tinyint(4) DEFAULT NULL,
  `promoted` tinyint(4) DEFAULT NULL,
  `published_date` datetime DEFAULT NULL,
  `view_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for posts_terms
-- ----------------------------
DROP TABLE IF EXISTS `posts_terms`;
CREATE TABLE `posts_terms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `term_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for province
-- ----------------------------
DROP TABLE IF EXISTS `province`;
CREATE TABLE `province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(11) COLLATE utf8_vietnamese_ci NOT NULL DEFAULT '',
  `payload` varchar(2000) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `last_activity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `value` varchar(1024) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for slugs
-- ----------------------------
DROP TABLE IF EXISTS `slugs`;
CREATE TABLE `slugs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(5) DEFAULT NULL,
  `url` varchar(2000) DEFAULT NULL,
  `alias` varchar(2000) DEFAULT NULL,
  `path` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for taxonomy
-- ----------------------------
DROP TABLE IF EXISTS `taxonomy`;
CREATE TABLE `taxonomy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `weight` varchar(50) DEFAULT NULL,
  `lang` varchar(5) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for terms
-- ----------------------------
DROP TABLE IF EXISTS `terms`;
CREATE TABLE `terms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `path` varchar(2000) DEFAULT NULL,
  `url` varchar(2000) DEFAULT NULL,
  `thumb_url` varchar(2000) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `lang` varchar(5) DEFAULT NULL,
  `taxonomy_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `admin_menu_links` VALUES ('1', 'Dashboard', 'backend::global.dashboard', null, '1', '/dashboard/index', 'fa fa-dashboard', null, null, '1', '1', 'dashboard', null);
INSERT INTO `admin_menu_links` VALUES ('2', 'Content', 'backend::global.content', null, '1', '', 'fa fa-file', null, null, '2', '1', null, null);
INSERT INTO `admin_menu_links` VALUES ('3', 'Staff', 'backend::global.staff', null, '1', '', 'fa fa-users', null, null, '3', '1', null, null);
INSERT INTO `admin_menu_links` VALUES ('4', 'Users', 'backend::global.users', null, '1', '', 'fa fa-user', null, null, '4', '0', null, null);
INSERT INTO `admin_menu_links` VALUES ('5', 'Menu links', 'backend::global.menu_links', '2', '1', '/menu_link/list', 'fa fa-circle-o', null, null, '2', '1', 'menulink', null);
INSERT INTO `admin_menu_links` VALUES ('6', 'Categories', 'backend::global.categories', '2', '1', '/term/list/1', 'fa fa-circle-o', null, null, '3', '1', 'term', null);
INSERT INTO `admin_menu_links` VALUES ('7', 'Posts', 'backend::global.posts', '2', '1', '/post/list', 'fa fa-circle-o', null, null, '4', '1', 'post', null);
INSERT INTO `admin_menu_links` VALUES ('8', 'Roles', 'backend::global.roles', '3', '1', '/role/list', 'fa fa-circle-o', null, null, '1', '1', 'role', null);
INSERT INTO `admin_menu_links` VALUES ('9', 'Admins', 'backend::global.admins', '3', '1', '/admin_user/list', 'fa fa-circle-o', null, null, '2', '1', 'adminuser', null);
INSERT INTO `admin_menu_links` VALUES ('10', 'Users', 'backend::global.users', '4', '1', '/user/list', 'fa fa-circle-o', null, null, null, '0', 'user', null);
INSERT INTO `admin_menu_links` VALUES ('11', 'Slugs', 'backend::global.slugs', '2', '1', '/slug/list', 'fa fa-circle-o', null, null, '4', '1', 'slug', null);
INSERT INTO `admin_menu_links` VALUES ('12', 'Posts', 'backend::global.posts', '7', '0', '/post/list', null, null, null, null, '1', 'article', null);
INSERT INTO `admin_menu_links` VALUES ('13', 'Posts', 'backend::global.posts', '7', '0', '/post/list', null, null, null, null, '1', 'page', null);
INSERT INTO `admin_menu_links` VALUES ('14', 'Menus', 'backend::global.menus', '2', '1', '/menu/list', 'fa fa-circle-o', null, null, '0', '1', 'menu', null);
INSERT INTO `admin_permissions` VALUES ('1', '2', '1', null, '1');
INSERT INTO `admin_permissions` VALUES ('2', '2', '2', null, '1');
INSERT INTO `admin_permissions` VALUES ('3', '2', '3', null, '1');
INSERT INTO `admin_permissions` VALUES ('4', '2', '6', null, '1');
INSERT INTO `admin_permissions` VALUES ('5', '2', '7', null, '1');
INSERT INTO `admin_permissions` VALUES ('6', '2', '9', null, '1');
INSERT INTO `admin_permissions` VALUES ('7', '8', '1', null, '1');
INSERT INTO `admin_permissions` VALUES ('8', '8', '2', null, '1');
INSERT INTO `admin_permissions` VALUES ('9', '8', '6', null, '1');
INSERT INTO `admin_permissions` VALUES ('10', '8', '7', null, '1');
INSERT INTO `admin_permissions` VALUES ('11', '8', '5', null, '1');
INSERT INTO `admin_permissions` VALUES ('12', '2', '5', null, '1');
INSERT INTO `admin_user_tokens` VALUES ('22', '1', '5', null, 'azs8uvjzpesung6k3jqesm2067am160zp39a3uo9gzd4pdxl6kdvojeqlp1cq2xf', null, '2016-07-21 15:35:19', '2016-06-21 15:35:19', '0');
INSERT INTO `admin_user_tokens` VALUES ('23', '1', '5', null, '7tzm80nqcrnsy89o3z5p64jp7762md9kf7im2s61iqx5940t8j5ex3ipbdv3tggf', null, '2016-07-21 16:30:44', '2016-06-21 16:30:44', '0');
INSERT INTO `admin_user_tokens` VALUES ('24', '1', '5', null, '3fdplm3pbdoieg2mk9q73mnsnvajhvl0ay3aazoz88v6ammh8hez8m691ffftq42', null, '2016-07-21 16:56:17', '2016-06-21 16:56:17', '0');
INSERT INTO `admin_user_tokens` VALUES ('25', '1', '5', null, 'us7rnxb1le3h3plbyuh9hasily6tlcneceuz7mvpyzcezxa84fcvpykmmhm76giq', null, '2016-07-21 17:00:37', '2016-06-21 17:00:37', '0');
INSERT INTO `admin_user_tokens` VALUES ('26', '1', '5', null, '5xrdgrh7k5hcuhu04r8vpgm8hhpqrekmf3rms2ezpb2cj9uz3velqnqebkh553q1', null, '2016-07-21 17:03:10', '2016-06-21 17:03:10', '0');
INSERT INTO `admin_user_tokens` VALUES ('27', '1', '5', null, 'k7sknyfvja9yeg5rs6ftsnz22l3xmamf3dx1k3uon6quftfjhr97y83rcy8rt3k5', null, '2016-06-22 18:05:36', '2016-06-21 18:05:36', '0');
INSERT INTO `admin_user_tokens` VALUES ('28', '1', '5', null, 'jxerbmlam1elfpg27r2hxtva1y68iplpu8fk04d4efm83sy8gaizjh3sriuk4zil', null, '2016-06-24 09:26:01', '2016-06-23 09:26:01', '0');
INSERT INTO `admin_user_tokens` VALUES ('29', '1', '5', null, '17v1lh1koybpu81u8m21dsqmezxoxvxn0rlh8aanqpu53qmedmge71omn752ct74', null, '2016-06-29 08:17:31', '2016-06-28 08:17:31', '0');
INSERT INTO `admin_user_tokens` VALUES ('30', '1', '5', null, 'rthaxhpjdj091yz578oeqbqrzn9hr9s8gkh9vlv8fq3fu1qjkxusec4xotj4aaq3', null, '2016-06-29 11:07:56', '2016-06-28 11:07:56', '0');
INSERT INTO `admin_users` VALUES ('5', 'truongankhang@gmail.com', '579646aad11fae4dd295812fb4526245', '1', 'Khang Truong', '1', null, null, '2016-06-10 15:07:25', '5');
INSERT INTO `admin_users` VALUES ('7', 'khangta@fpt.com.vn', '579646aad11fae4dd295812fb4526245', '2', 'Test Test', '1', '2016-06-27 11:33:36', '5', '2016-06-27 16:16:47', '5');
INSERT INTO `content_types` VALUES ('1', 'Bài viết cơ bản', 'backend::content_type:basic_page', 'Use basic pages for your static content, such as an \'About us\' page.', '1');
INSERT INTO `content_types` VALUES ('2', 'Bản tin', 'backend::content_type:article', 'Use articles for time-sensitive content like news, press releases or blog posts.', '1');
INSERT INTO `content_types` VALUES ('3', 'Contact', 'backend::content_type:contact', null, '0');
INSERT INTO `district` VALUES ('1', 'Quận Ba Đình', '1', null, '1');
INSERT INTO `district` VALUES ('2', 'Quận Hoàn Kiếm', '1', null, '1');
INSERT INTO `district` VALUES ('3', 'Quận Hai Bà Trưng', '1', null, '1');
INSERT INTO `district` VALUES ('4', 'Quận Đống Đa', '1', null, '1');
INSERT INTO `district` VALUES ('5', 'Quận Tây Hồ', '1', null, '1');
INSERT INTO `district` VALUES ('6', 'Quận Cầu Giấy', '1', null, '1');
INSERT INTO `district` VALUES ('7', 'Quận Thanh Xuân', '1', null, '1');
INSERT INTO `district` VALUES ('8', 'Quận Hoàng Mai', '1', null, '1');
INSERT INTO `district` VALUES ('9', 'Quận Long Biên', '1', null, '1');
INSERT INTO `district` VALUES ('10', 'Huyện Từ Liêm', '1', null, '1');
INSERT INTO `district` VALUES ('11', 'Huyện Thanh Trì', '1', null, '1');
INSERT INTO `district` VALUES ('12', 'Huyện Gia Lâm', '1', null, '1');
INSERT INTO `district` VALUES ('13', 'Huyện Đông Anh', '1', null, '1');
INSERT INTO `district` VALUES ('14', 'Huyện Sóc Sơn', '1', null, '1');
INSERT INTO `district` VALUES ('15', 'Quận Hà Đông', '1', null, '1');
INSERT INTO `district` VALUES ('16', 'Thị xã Sơn Tây', '1', null, '1');
INSERT INTO `district` VALUES ('17', 'Huyện Ba Vì', '1', null, '1');
INSERT INTO `district` VALUES ('18', 'Huyện Phúc Thọ', '1', null, '1');
INSERT INTO `district` VALUES ('19', 'Huyện Thạch Thất', '1', null, '1');
INSERT INTO `district` VALUES ('20', 'Huyện Quốc Oai', '1', null, '1');
INSERT INTO `district` VALUES ('21', 'Huyện Chương Mỹ', '1', null, '1');
INSERT INTO `district` VALUES ('22', 'Huyện Đan Phượng', '1', null, '1');
INSERT INTO `district` VALUES ('23', 'Huyện Hoài Đức', '1', null, '1');
INSERT INTO `district` VALUES ('24', 'Huyện Thanh Oai', '1', null, '1');
INSERT INTO `district` VALUES ('25', 'Huyện Mỹ Đức', '1', null, '1');
INSERT INTO `district` VALUES ('26', 'Huyện Ứng Hòa', '1', null, '1');
INSERT INTO `district` VALUES ('27', 'Huyện Thường Tín', '1', null, '1');
INSERT INTO `district` VALUES ('28', 'Huyện Phú Xuyên', '1', null, '1');
INSERT INTO `district` VALUES ('29', 'Huyện Mê Linh', '1', null, '1');
INSERT INTO `district` VALUES ('30', 'Quận 1', '2', '1', '1');
INSERT INTO `district` VALUES ('31', 'Quận 2', '2', '2', '1');
INSERT INTO `district` VALUES ('32', 'Quận 3', '2', '3', '1');
INSERT INTO `district` VALUES ('33', 'Quận 4', '2', '4', '1');
INSERT INTO `district` VALUES ('34', 'Quận 5', '2', '5', '1');
INSERT INTO `district` VALUES ('35', 'Quận 6', '2', '6', '1');
INSERT INTO `district` VALUES ('36', 'Quận 7', '2', '7', '1');
INSERT INTO `district` VALUES ('37', 'Quận 8', '2', '8', '1');
INSERT INTO `district` VALUES ('38', 'Quận 9', '2', '9', '1');
INSERT INTO `district` VALUES ('39', 'Quận 10', '2', '10', '1');
INSERT INTO `district` VALUES ('40', 'Quận 11', '2', '11', '1');
INSERT INTO `district` VALUES ('41', 'Quận 12', '2', '12', '1');
INSERT INTO `district` VALUES ('42', 'Quận Gò Vấp', '2', '13', '1');
INSERT INTO `district` VALUES ('43', 'Quận Tân Bình', '2', '14', '1');
INSERT INTO `district` VALUES ('44', 'Quận Tân Phú', '2', '15', '1');
INSERT INTO `district` VALUES ('45', 'Quận Bình Thạnh', '2', '16', '1');
INSERT INTO `district` VALUES ('46', 'Quận Phú Nhuận', '2', '17', '1');
INSERT INTO `district` VALUES ('47', 'Quận Thủ Đức', '2', '18', '1');
INSERT INTO `district` VALUES ('48', 'Quận Bình Tân', '2', '19', '1');
INSERT INTO `district` VALUES ('49', 'Huyện Bình Chánh', '2', '29', '1');
INSERT INTO `district` VALUES ('50', 'Huyện Củ Chi', '2', '21', '1');
INSERT INTO `district` VALUES ('51', 'Huyện Hóc Môn', '2', '22', '1');
INSERT INTO `district` VALUES ('52', 'Huyện Nhà Bè', '2', '23', '1');
INSERT INTO `district` VALUES ('53', 'Huyện Cần Giờ', '2', '24', '1');
INSERT INTO `district` VALUES ('55', 'Quận Hồng Bàng', '3', null, '1');
INSERT INTO `district` VALUES ('56', 'Quận Lê Chân', '3', null, '1');
INSERT INTO `district` VALUES ('57', 'Quận Ngô Quyền', '3', null, '1');
INSERT INTO `district` VALUES ('58', 'Quận Kiến An', '3', null, '1');
INSERT INTO `district` VALUES ('59', 'Quận Hải An', '3', null, '1');
INSERT INTO `district` VALUES ('60', 'Quận Đồ Sơn', '3', null, '1');
INSERT INTO `district` VALUES ('61', 'Huyện An Lão', '3', null, '1');
INSERT INTO `district` VALUES ('62', 'Huyện Kiến Thụy', '3', null, '1');
INSERT INTO `district` VALUES ('63', 'Huyện Thủy Nguyên', '3', null, '1');
INSERT INTO `district` VALUES ('64', 'Huyện An Dương', '3', null, '1');
INSERT INTO `district` VALUES ('65', 'Huyện Tiên Lãng', '3', null, '1');
INSERT INTO `district` VALUES ('66', 'Huyện Vĩnh Bảo', '3', null, '1');
INSERT INTO `district` VALUES ('67', 'Huyện Cát Hải', '3', null, '1');
INSERT INTO `district` VALUES ('68', 'Huyện Bạch Long Vĩ', '3', null, '1');
INSERT INTO `district` VALUES ('69', 'Quận Dương Kinh', '3', null, '1');
INSERT INTO `district` VALUES ('70', 'Quận Hải Châu', '4', null, '1');
INSERT INTO `district` VALUES ('71', 'Quận Thanh Khê', '4', null, '1');
INSERT INTO `district` VALUES ('72', 'Quận Sơn Trà', '4', null, '1');
INSERT INTO `district` VALUES ('73', 'Quận Ngũ Hành Sơn', '4', null, '1');
INSERT INTO `district` VALUES ('74', 'Quận Liên Chiểu', '4', null, '1');
INSERT INTO `district` VALUES ('75', 'Huyện Hoà Vang', '4', null, '1');
INSERT INTO `district` VALUES ('76', 'Quận Cẩm Lệ', '4', null, '1');
INSERT INTO `district` VALUES ('77', 'TP. Hà Giang', '5', null, '1');
INSERT INTO `district` VALUES ('78', 'Huyện Đồng Văn', '5', null, '1');
INSERT INTO `district` VALUES ('79', 'Huyện Mèo Vạc', '5', null, '1');
INSERT INTO `district` VALUES ('80', 'Huyện Yên Minh', '5', null, '1');
INSERT INTO `district` VALUES ('81', 'Huyện Quản Bạ', '5', null, '1');
INSERT INTO `district` VALUES ('82', 'Huyện Vị Xuyên', '5', null, '1');
INSERT INTO `district` VALUES ('83', 'Huyện Bắc Mê', '5', null, '1');
INSERT INTO `district` VALUES ('84', 'Huyện Hoàng Su Phì', '5', null, '1');
INSERT INTO `district` VALUES ('85', 'Huyện Xín Mần', '5', null, '1');
INSERT INTO `district` VALUES ('86', 'Huyện Bắc Quang', '5', null, '1');
INSERT INTO `district` VALUES ('87', 'Huyện Quang Bình', '5', null, '1');
INSERT INTO `district` VALUES ('88', 'TP. Cao Bằng', '6', null, '1');
INSERT INTO `district` VALUES ('89', 'Huyện Bảo Lạc', '6', null, '1');
INSERT INTO `district` VALUES ('90', 'Huyện Thông Nông', '6', null, '1');
INSERT INTO `district` VALUES ('91', 'Huyện Hà Quảng', '6', null, '1');
INSERT INTO `district` VALUES ('92', 'Huyện Trà Lĩnh', '6', null, '1');
INSERT INTO `district` VALUES ('93', 'Huyện Trùng Khánh', '6', null, '1');
INSERT INTO `district` VALUES ('94', 'Huyện Nguyên Bình', '6', null, '1');
INSERT INTO `district` VALUES ('95', 'Huyện Hoà An', '6', null, '1');
INSERT INTO `district` VALUES ('96', 'Huyện Quảng Uyên', '6', null, '1');
INSERT INTO `district` VALUES ('97', 'Huyện Thạch An', '6', null, '1');
INSERT INTO `district` VALUES ('98', 'Huyện Hạ Lang', '6', null, '1');
INSERT INTO `district` VALUES ('99', 'Huyện Bảo Lâm', '6', null, '1');
INSERT INTO `district` VALUES ('100', 'Huyện Phục Hoà', '6', null, '1');
INSERT INTO `district` VALUES ('101', 'TP. Lai Châu', '7', null, '1');
INSERT INTO `district` VALUES ('102', 'Huyện Tam Đường', '7', null, '1');
INSERT INTO `district` VALUES ('103', 'Huyện Phong Thổ', '7', null, '1');
INSERT INTO `district` VALUES ('104', 'Huyện Sìn Hồ', '7', null, '1');
INSERT INTO `district` VALUES ('105', 'Huyện Mường Tè', '7', null, '1');
INSERT INTO `district` VALUES ('106', 'Huyện Than Uyên', '7', null, '1');
INSERT INTO `district` VALUES ('107', 'Huyện Tân Uyên', '7', null, '1');
INSERT INTO `district` VALUES ('108', 'Thành phố Lào Cai', '8', null, '1');
INSERT INTO `district` VALUES ('109', 'Huyện Xi Ma Cai', '8', null, '1');
INSERT INTO `district` VALUES ('110', 'Huyện Bát Xát', '8', null, '1');
INSERT INTO `district` VALUES ('111', 'Huyện Bảo Thắng', '8', null, '1');
INSERT INTO `district` VALUES ('112', 'Huyện Sa Pa', '8', null, '1');
INSERT INTO `district` VALUES ('113', 'Huyện Văn Bàn', '8', null, '1');
INSERT INTO `district` VALUES ('114', 'Huyện Bảo Yên', '8', null, '1');
INSERT INTO `district` VALUES ('115', 'Huyện Bắc Hà', '8', null, '1');
INSERT INTO `district` VALUES ('116', 'Huyện Mường Khương', '8', null, '1');
INSERT INTO `district` VALUES ('117', 'TP. Tuyên Quang', '9', null, '1');
INSERT INTO `district` VALUES ('118', 'Huyện Na Hang', '9', null, '1');
INSERT INTO `district` VALUES ('119', 'Huyện Chiêm Hoá', '9', null, '1');
INSERT INTO `district` VALUES ('120', 'Huyện Hàm Yên', '9', null, '1');
INSERT INTO `district` VALUES ('121', 'Huyện Yên Sơn', '9', null, '1');
INSERT INTO `district` VALUES ('122', 'Huyện Sơn Dương', '9', null, '1');
INSERT INTO `district` VALUES ('123', 'Thành phố Lạng Sơn', '10', null, '1');
INSERT INTO `district` VALUES ('124', 'Huyện Văn Lãng', '10', null, '1');
INSERT INTO `district` VALUES ('125', 'Huyện Bắc Sơn', '10', null, '1');
INSERT INTO `district` VALUES ('126', 'Huyện Lộc Bình', '10', null, '1');
INSERT INTO `district` VALUES ('127', 'Huyện Chi Lăng', '10', null, '1');
INSERT INTO `district` VALUES ('128', 'Huyện Tràng Định', '10', null, '1');
INSERT INTO `district` VALUES ('129', 'Huyện Bình Gia', '10', null, '1');
INSERT INTO `district` VALUES ('130', 'Huyện Văn Quan', '10', null, '1');
INSERT INTO `district` VALUES ('131', 'Huyện Cao Lộc', '10', null, '1');
INSERT INTO `district` VALUES ('132', 'Huyện Đình Lập', '10', null, '1');
INSERT INTO `district` VALUES ('133', 'Huyện Hữu Lũng', '10', null, '1');
INSERT INTO `district` VALUES ('134', 'Thị xã Bắc Kạn', '11', null, '1');
INSERT INTO `district` VALUES ('135', 'Huyện Chợ Đồn', '11', null, '1');
INSERT INTO `district` VALUES ('136', 'Huyện Bạch Thông', '11', null, '1');
INSERT INTO `district` VALUES ('137', 'Huyện Na Rì', '11', null, '1');
INSERT INTO `district` VALUES ('138', 'Huyện Ngân Sơn', '11', null, '1');
INSERT INTO `district` VALUES ('139', 'Huyện Ba Bể', '11', null, '1');
INSERT INTO `district` VALUES ('140', 'Huyện Chợ Mới', '11', null, '1');
INSERT INTO `district` VALUES ('141', 'Huyện Pác Nặm', '11', null, '1');
INSERT INTO `district` VALUES ('143', 'TP. Thái Nguyên', '12', null, '1');
INSERT INTO `district` VALUES ('144', 'Thị xã Sông Công', '12', null, '1');
INSERT INTO `district` VALUES ('145', 'Huyện Định Hoá', '12', null, '1');
INSERT INTO `district` VALUES ('146', 'Huyện Phú Lương', '12', null, '1');
INSERT INTO `district` VALUES ('147', 'Huyện Võ Nhai', '12', null, '1');
INSERT INTO `district` VALUES ('148', 'Huyện Đại Từ', '12', null, '1');
INSERT INTO `district` VALUES ('149', 'Huyện Đồng Hỷ', '12', null, '1');
INSERT INTO `district` VALUES ('150', 'Huyện Phú Bình', '12', null, '1');
INSERT INTO `district` VALUES ('151', 'Huyện Phổ Yên', '12', null, '1');
INSERT INTO `district` VALUES ('152', 'Thành phố Yên Bái', '13', null, '1');
INSERT INTO `district` VALUES ('153', 'Thị xã Nghĩa Lộ', '13', null, '1');
INSERT INTO `district` VALUES ('154', 'Huyện Văn Yên', '13', null, '1');
INSERT INTO `district` VALUES ('155', 'Huyện Yên Bình', '13', null, '1');
INSERT INTO `district` VALUES ('156', 'Huyện Mù Cang Chải', '13', null, '1');
INSERT INTO `district` VALUES ('157', 'Huyện Văn Chấn', '13', null, '1');
INSERT INTO `district` VALUES ('158', 'Huyện Trấn Yên', '13', null, '1');
INSERT INTO `district` VALUES ('159', 'Huyện Trạm Tấu', '13', null, '1');
INSERT INTO `district` VALUES ('160', 'Huyện Lục Yên', '13', null, '1');
INSERT INTO `district` VALUES ('161', 'TP. Sơn La', '14', null, '1');
INSERT INTO `district` VALUES ('162', 'Huyện Quỳnh Nhai', '14', null, '1');
INSERT INTO `district` VALUES ('163', 'Huyện Mường La', '14', null, '1');
INSERT INTO `district` VALUES ('164', 'Huyện Thuận Châu', '14', null, '1');
INSERT INTO `district` VALUES ('165', 'Huyện Bắc Yên', '14', null, '1');
INSERT INTO `district` VALUES ('166', 'Huyện Phù Yên', '14', null, '1');
INSERT INTO `district` VALUES ('167', 'Huyện Mai Sơn', '14', null, '1');
INSERT INTO `district` VALUES ('168', 'Huyện Yên Châu', '14', null, '1');
INSERT INTO `district` VALUES ('169', 'Huyện Sông Mã', '14', null, '1');
INSERT INTO `district` VALUES ('170', 'Huyện Mộc Châu', '14', null, '1');
INSERT INTO `district` VALUES ('171', 'Huyện Sốp Cộp', '14', null, '1');
INSERT INTO `district` VALUES ('172', 'TP. Việt Trì', '15', null, '1');
INSERT INTO `district` VALUES ('173', 'Thị xã Phú Thọ', '15', null, '1');
INSERT INTO `district` VALUES ('174', 'Huyện Đoan Hùng', '15', null, '1');
INSERT INTO `district` VALUES ('175', 'Huyện Thanh Ba', '15', null, '1');
INSERT INTO `district` VALUES ('176', 'Huyện Hạ Hoà', '15', null, '1');
INSERT INTO `district` VALUES ('177', 'Huyện Cẩm Khê', '15', null, '1');
INSERT INTO `district` VALUES ('178', 'Huyện Yên Lập', '15', null, '1');
INSERT INTO `district` VALUES ('179', 'Huyện Thanh Sơn', '15', null, '1');
INSERT INTO `district` VALUES ('180', 'Huyện Phù Ninh', '15', null, '1');
INSERT INTO `district` VALUES ('181', 'Huyện Lâm Thao', '15', null, '1');
INSERT INTO `district` VALUES ('182', 'Huyện Tam Nông', '15', null, '1');
INSERT INTO `district` VALUES ('183', 'Huyện Thanh Thủy', '15', null, '1');
INSERT INTO `district` VALUES ('184', 'Huyện Tân Sơn', '15', null, '1');
INSERT INTO `district` VALUES ('186', 'Thành phố Vĩnh Yên', '16', null, '1');
INSERT INTO `district` VALUES ('187', 'Huyện Tam Dương', '16', null, '1');
INSERT INTO `district` VALUES ('188', 'Huyện Lập Thạch', '16', null, '1');
INSERT INTO `district` VALUES ('189', 'Huyện Vĩnh Tường', '16', null, '1');
INSERT INTO `district` VALUES ('190', 'Huyện Yên Lạc', '16', null, '1');
INSERT INTO `district` VALUES ('191', 'Huyện Bình Xuyên', '16', null, '1');
INSERT INTO `district` VALUES ('192', 'Thị xã Phúc Yên', '16', null, '1');
INSERT INTO `district` VALUES ('193', 'Huyện Tam Đảo', '16', null, '1');
INSERT INTO `district` VALUES ('194', 'TP. Hạ Long', '17', null, '1');
INSERT INTO `district` VALUES ('195', 'Thị xã Cẩm Phả', '17', null, '1');
INSERT INTO `district` VALUES ('196', 'TP. Uông Bí', '17', null, '1');
INSERT INTO `district` VALUES ('197', 'TP. Móng Cái', '17', null, '1');
INSERT INTO `district` VALUES ('198', 'Huyện Bình Liêu', '17', null, '1');
INSERT INTO `district` VALUES ('199', 'Huyện Đầm Hà', '17', null, '1');
INSERT INTO `district` VALUES ('200', 'Huyện Hải Hà', '17', null, '1');
INSERT INTO `district` VALUES ('201', 'Huyện Tiên Yên', '17', null, '1');
INSERT INTO `district` VALUES ('202', 'Huyện Ba Chẽ', '17', null, '1');
INSERT INTO `district` VALUES ('203', 'Huyện Đông Triều', '17', null, '1');
INSERT INTO `district` VALUES ('204', 'Huyện Yên Hưng', '17', null, '1');
INSERT INTO `district` VALUES ('205', 'Huyện Hoành Bồ', '17', null, '1');
INSERT INTO `district` VALUES ('206', 'Huyện Vân Đồn', '17', null, '1');
INSERT INTO `district` VALUES ('207', 'Huyện Cô Tô', '17', null, '1');
INSERT INTO `district` VALUES ('208', 'Thành phố Bắc Giang', '18', null, '1');
INSERT INTO `district` VALUES ('209', 'Huyện Yên Thế', '18', null, '1');
INSERT INTO `district` VALUES ('210', 'Huyện Lục Ngạn', '18', null, '1');
INSERT INTO `district` VALUES ('211', 'Huyện Sơn Động', '18', null, '1');
INSERT INTO `district` VALUES ('212', 'Huyện Lục Nam', '18', null, '1');
INSERT INTO `district` VALUES ('213', 'Huyện Tân Yên', '18', null, '1');
INSERT INTO `district` VALUES ('214', 'Huyện Hiệp Hoà', '18', null, '1');
INSERT INTO `district` VALUES ('215', 'Huyện Lạng Giang', '18', null, '1');
INSERT INTO `district` VALUES ('216', 'Huyện Việt Yên', '18', null, '1');
INSERT INTO `district` VALUES ('217', 'Huyện Yên Dũng', '18', null, '1');
INSERT INTO `district` VALUES ('219', 'Thành phố Bắc Ninh', '19', null, '1');
INSERT INTO `district` VALUES ('220', 'Huyện Yên Phong', '19', null, '1');
INSERT INTO `district` VALUES ('221', 'Huyện Quế Võ', '19', null, '1');
INSERT INTO `district` VALUES ('222', 'Huyện Tiên Du', '19', null, '1');
INSERT INTO `district` VALUES ('223', 'Thị xã Từ Sơn', '19', null, '1');
INSERT INTO `district` VALUES ('224', 'Huyện Thuận Thành', '19', null, '1');
INSERT INTO `district` VALUES ('225', 'Huyện Gia Bình', '19', null, '1');
INSERT INTO `district` VALUES ('226', 'Huyện Lương Tài', '19', null, '1');
INSERT INTO `district` VALUES ('227', 'Thành phố Hải Dương', '20', null, '1');
INSERT INTO `district` VALUES ('228', 'Huyện Chí Linh', '20', null, '1');
INSERT INTO `district` VALUES ('229', 'Huyện Nam Sách', '20', null, '1');
INSERT INTO `district` VALUES ('230', 'Huyện Kinh Môn', '20', null, '1');
INSERT INTO `district` VALUES ('231', 'Huyện Gia Lộc', '20', null, '1');
INSERT INTO `district` VALUES ('232', 'Huyện Tứ Kỳ', '20', null, '1');
INSERT INTO `district` VALUES ('233', 'Huyện Thanh Miện', '20', null, '1');
INSERT INTO `district` VALUES ('234', 'Huyện Ninh Giang', '20', null, '1');
INSERT INTO `district` VALUES ('235', 'Huyện Cẩm Giàng', '20', null, '1');
INSERT INTO `district` VALUES ('236', 'Huyện Thanh Hà', '20', null, '1');
INSERT INTO `district` VALUES ('237', 'Huyện Kim Thành', '20', null, '1');
INSERT INTO `district` VALUES ('238', 'Huyện Bình Giang', '20', null, '1');
INSERT INTO `district` VALUES ('239', 'TP. Hưng Yên', '21', null, '1');
INSERT INTO `district` VALUES ('240', 'Huyện Kim Động', '21', null, '1');
INSERT INTO `district` VALUES ('241', 'Huyện Ân Thi', '21', null, '1');
INSERT INTO `district` VALUES ('242', 'Huyện Khoái Châu', '21', null, '1');
INSERT INTO `district` VALUES ('243', 'Huyện Yên Mỹ', '21', null, '1');
INSERT INTO `district` VALUES ('244', 'Huyện Tiên Lữ', '21', null, '1');
INSERT INTO `district` VALUES ('245', 'Huyện Phù Cừ', '21', null, '1');
INSERT INTO `district` VALUES ('246', 'Huyện Mỹ Hào', '21', null, '1');
INSERT INTO `district` VALUES ('247', 'Huyện Văn Lâm', '21', null, '1');
INSERT INTO `district` VALUES ('248', 'Huyện Văn Giang', '21', null, '1');
INSERT INTO `district` VALUES ('249', 'Thành phố Hoà Bình', '22', null, '1');
INSERT INTO `district` VALUES ('250', 'Huyện Đà Bắc', '22', null, '1');
INSERT INTO `district` VALUES ('251', 'Huyện Mai Châu', '22', null, '1');
INSERT INTO `district` VALUES ('252', 'Huyện Tân Lạc', '22', null, '1');
INSERT INTO `district` VALUES ('253', 'Huyện Lạc Sơn', '22', null, '1');
INSERT INTO `district` VALUES ('254', 'Huyện Kỳ Sơn', '22', null, '1');
INSERT INTO `district` VALUES ('255', 'Huyện Lương Sơn', '22', null, '1');
INSERT INTO `district` VALUES ('256', 'Huyện Kim Bôi', '22', null, '1');
INSERT INTO `district` VALUES ('257', 'Huyện Lạc Thuỷ', '22', null, '1');
INSERT INTO `district` VALUES ('258', 'Huyện Yên Thuỷ', '22', null, '1');
INSERT INTO `district` VALUES ('259', 'Huyện Cao Phong', '22', null, '1');
INSERT INTO `district` VALUES ('260', 'Thành phố Phủ Lý', '23', null, '1');
INSERT INTO `district` VALUES ('261', 'Huyện Duy Tiên', '23', null, '1');
INSERT INTO `district` VALUES ('262', 'Huyện Kim Bảng', '23', null, '1');
INSERT INTO `district` VALUES ('263', 'Huyện Lý Nhân', '23', null, '1');
INSERT INTO `district` VALUES ('264', 'Huỵện Thanh Liêm', '23', null, '1');
INSERT INTO `district` VALUES ('265', 'Huyện Bình Lục', '23', null, '1');
INSERT INTO `district` VALUES ('266', 'TP. Nam Định', '24', null, '1');
INSERT INTO `district` VALUES ('267', 'Huyện Mỹ Lộc', '24', null, '1');
INSERT INTO `district` VALUES ('268', 'Huyện Xuân Trường', '24', null, '1');
INSERT INTO `district` VALUES ('269', 'Huyện Giao Thủy', '24', null, '1');
INSERT INTO `district` VALUES ('270', 'Huyện ý Yên', '24', null, '1');
INSERT INTO `district` VALUES ('271', 'Huyện Vụ Bản', '24', null, '1');
INSERT INTO `district` VALUES ('272', 'Huyện Nam Trực', '24', null, '1');
INSERT INTO `district` VALUES ('273', 'Huyện Trực Ninh', '24', null, '1');
INSERT INTO `district` VALUES ('274', 'Huyện Nghĩa Hưng', '24', null, '1');
INSERT INTO `district` VALUES ('275', 'Huyện Hải Hậu', '24', null, '1');
INSERT INTO `district` VALUES ('276', 'Thành phố Thái Bình', '25', null, '1');
INSERT INTO `district` VALUES ('277', 'Huyện Quỳnh Phụ', '25', null, '1');
INSERT INTO `district` VALUES ('278', 'Huyện Hưng Hà', '25', null, '1');
INSERT INTO `district` VALUES ('279', 'Huyện Đông Hưng', '25', null, '1');
INSERT INTO `district` VALUES ('280', 'Huyện Vũ Thư', '25', null, '1');
INSERT INTO `district` VALUES ('281', 'Huyện Kiến Xương', '25', null, '1');
INSERT INTO `district` VALUES ('282', 'Huyện Tiền Hải', '25', null, '1');
INSERT INTO `district` VALUES ('283', 'Huyện Thái Thuỵ', '25', null, '1');
INSERT INTO `district` VALUES ('284', 'Thành phố Ninh Bình', '26', null, '1');
INSERT INTO `district` VALUES ('285', 'Thị xã Tam Điệp', '26', null, '1');
INSERT INTO `district` VALUES ('286', 'Huyện Nho Quan', '26', null, '1');
INSERT INTO `district` VALUES ('287', 'Huyện Gia Viễn', '26', null, '1');
INSERT INTO `district` VALUES ('288', 'Huyện Hoa Lư', '26', null, '1');
INSERT INTO `district` VALUES ('289', 'Huyện Yên Mô', '26', null, '1');
INSERT INTO `district` VALUES ('290', 'Huyện Kim Sơn', '26', null, '1');
INSERT INTO `district` VALUES ('291', 'Huyện Yên Khánh', '26', null, '1');
INSERT INTO `district` VALUES ('292', 'TP.Thanh Hoá', '27', null, '1');
INSERT INTO `district` VALUES ('293', 'Thị xã Bỉm Sơn', '27', null, '1');
INSERT INTO `district` VALUES ('294', 'Thị xã Sầm Sơn', '27', null, '1');
INSERT INTO `district` VALUES ('295', 'Huyện Quan Hoá', '27', null, '1');
INSERT INTO `district` VALUES ('296', 'Huyện Quan Sơn', '27', null, '1');
INSERT INTO `district` VALUES ('297', 'Huyện Mường Lát', '27', null, '1');
INSERT INTO `district` VALUES ('298', 'Huyện Bá Thước', '27', null, '1');
INSERT INTO `district` VALUES ('299', 'Huyện Thường Xuân', '27', null, '1');
INSERT INTO `district` VALUES ('300', 'Huyện Như Xuân', '27', null, '1');
INSERT INTO `district` VALUES ('301', 'Huyện Như Thanh', '27', null, '1');
INSERT INTO `district` VALUES ('302', 'Huyện Lang Chánh', '27', null, '1');
INSERT INTO `district` VALUES ('303', 'Huyện Ngọc Lặc', '27', null, '1');
INSERT INTO `district` VALUES ('304', 'Huyện Thạch Thành', '27', null, '1');
INSERT INTO `district` VALUES ('305', 'Huyện Cẩm Thủy', '27', null, '1');
INSERT INTO `district` VALUES ('306', 'Huyện Thọ Xuân', '27', null, '1');
INSERT INTO `district` VALUES ('307', 'Huyện Vĩnh Lộc', '27', null, '1');
INSERT INTO `district` VALUES ('308', 'Huyện Thiệu Hoá', '27', null, '1');
INSERT INTO `district` VALUES ('309', 'Huyện Triệu Sơn', '27', null, '1');
INSERT INTO `district` VALUES ('310', 'Huyện Nông Cống', '27', null, '1');
INSERT INTO `district` VALUES ('311', 'Huyện Đông Sơn', '27', null, '1');
INSERT INTO `district` VALUES ('312', 'Huyện Hà Trung', '27', null, '1');
INSERT INTO `district` VALUES ('313', 'Huyện Hoằng Hoá', '27', null, '1');
INSERT INTO `district` VALUES ('314', 'Huyện Nga Sơn', '27', null, '1');
INSERT INTO `district` VALUES ('315', 'Huyện Hậu Lộc', '27', null, '1');
INSERT INTO `district` VALUES ('316', 'Huyện Quảng Xương', '27', null, '1');
INSERT INTO `district` VALUES ('317', 'Huyện Tĩnh Gia', '27', null, '1');
INSERT INTO `district` VALUES ('318', 'Huyện Yên Định', '27', null, '1');
INSERT INTO `district` VALUES ('319', 'Thành phố Vinh', '28', null, '1');
INSERT INTO `district` VALUES ('320', 'Thị xã Cửa Lò', '28', null, '1');
INSERT INTO `district` VALUES ('321', 'Huyện Quỳ Châu', '28', null, '1');
INSERT INTO `district` VALUES ('322', 'Huyện Quỳ Hợp', '28', null, '1');
INSERT INTO `district` VALUES ('323', 'Huyện Nghĩa Đàn', '28', null, '1');
INSERT INTO `district` VALUES ('324', 'Huyện Quỳnh Lưu', '28', null, '1');
INSERT INTO `district` VALUES ('325', 'Huyện Kỳ Sơn', '28', null, '1');
INSERT INTO `district` VALUES ('326', 'Huyện Tương Dương', '28', null, '1');
INSERT INTO `district` VALUES ('327', 'Huyện Con Cuông', '28', null, '1');
INSERT INTO `district` VALUES ('328', 'Huyện Tân Kỳ', '28', null, '1');
INSERT INTO `district` VALUES ('329', 'Huyện Yên Thành', '28', null, '1');
INSERT INTO `district` VALUES ('330', 'Huyện Diễn Châu', '28', null, '1');
INSERT INTO `district` VALUES ('331', 'Huyện Anh Sơn', '28', null, '1');
INSERT INTO `district` VALUES ('332', 'Huyện Đô Lương', '28', null, '1');
INSERT INTO `district` VALUES ('333', 'Huyện Thanh Chương', '28', null, '1');
INSERT INTO `district` VALUES ('334', 'Huyện Nghi Lộc', '28', null, '1');
INSERT INTO `district` VALUES ('335', 'Huyện Nam Đàn', '28', null, '1');
INSERT INTO `district` VALUES ('336', 'Huyện Hưng Nguyên', '28', null, '1');
INSERT INTO `district` VALUES ('337', 'Huyện Quế Phong', '28', null, '1');
INSERT INTO `district` VALUES ('338', 'Thành phố Hà Tĩnh', '29', null, '1');
INSERT INTO `district` VALUES ('339', 'Thị xã Hồng Lĩnh', '29', null, '1');
INSERT INTO `district` VALUES ('340', 'Huyện Hương Sơn', '29', null, '1');
INSERT INTO `district` VALUES ('341', 'Huyện Đức Thọ', '29', null, '1');
INSERT INTO `district` VALUES ('342', 'Huyện Nghi Xuân', '29', null, '1');
INSERT INTO `district` VALUES ('343', 'Huyện Can Lộc', '29', null, '1');
INSERT INTO `district` VALUES ('344', 'Huyện Hương Khê', '29', null, '1');
INSERT INTO `district` VALUES ('345', 'Huyện Thạch Hà', '29', null, '1');
INSERT INTO `district` VALUES ('346', 'Huyện Cẩm Xuyên', '29', null, '1');
INSERT INTO `district` VALUES ('347', 'Huyện Kỳ Anh', '29', null, '1');
INSERT INTO `district` VALUES ('348', 'Huyện Vũ Quang', '29', null, '1');
INSERT INTO `district` VALUES ('349', 'Huyện Lộc Hà', '29', null, '1');
INSERT INTO `district` VALUES ('350', 'Thành phố Đồng Hới', '30', null, '1');
INSERT INTO `district` VALUES ('351', 'Huyện Tuyên Hoá', '30', null, '1');
INSERT INTO `district` VALUES ('352', 'Huyện Minh Hoá', '30', null, '1');
INSERT INTO `district` VALUES ('353', 'Huyện Quảng Trạch', '30', null, '1');
INSERT INTO `district` VALUES ('354', 'Huyện Bố Trạch', '30', null, '1');
INSERT INTO `district` VALUES ('355', 'Huyện Quảng Ninh', '30', null, '1');
INSERT INTO `district` VALUES ('356', 'Huyện Lệ Thuỷ', '30', null, '1');
INSERT INTO `district` VALUES ('357', 'TP. Đông Hà', '31', null, '1');
INSERT INTO `district` VALUES ('358', 'Thị xã Quảng Trị', '31', null, '1');
INSERT INTO `district` VALUES ('359', 'Huyện Vĩnh Linh', '31', null, '1');
INSERT INTO `district` VALUES ('360', 'Huyện Gio Linh', '31', null, '1');
INSERT INTO `district` VALUES ('361', 'Huyện Cam Lộ', '31', null, '1');
INSERT INTO `district` VALUES ('362', 'Huyện Triệu Phong', '31', null, '1');
INSERT INTO `district` VALUES ('363', 'Huyện Hải Lăng', '31', null, '1');
INSERT INTO `district` VALUES ('364', 'Huyện Hướng Hoá', '31', null, '1');
INSERT INTO `district` VALUES ('365', 'Huyện Đăk Rông', '31', null, '1');
INSERT INTO `district` VALUES ('366', 'Huyện đảo Cồn cỏ', '31', null, '1');
INSERT INTO `district` VALUES ('367', 'Thành phố Huế', '32', null, '1');
INSERT INTO `district` VALUES ('368', 'Huyện Phong Điền', '32', null, '1');
INSERT INTO `district` VALUES ('369', 'Thị xã Hương Trà', '32', null, '1');
INSERT INTO `district` VALUES ('370', 'Huyện Phú Vang', '32', null, '1');
INSERT INTO `district` VALUES ('371', 'Thị xã Hương Thủy', '32', null, '1');
INSERT INTO `district` VALUES ('372', 'Huyện Nam Đông', '32', null, '1');
INSERT INTO `district` VALUES ('373', 'Huyện A Lưới', '32', null, '1');
INSERT INTO `district` VALUES ('374', 'Huyện Quảng Điền', '32', null, '1');
INSERT INTO `district` VALUES ('375', 'Thành phố Tam Kỳ', '33', null, '1');
INSERT INTO `district` VALUES ('376', 'Thị xã Hội An', '33', null, '1');
INSERT INTO `district` VALUES ('377', 'Huyện Duy Xuyên', '33', null, '1');
INSERT INTO `district` VALUES ('378', 'Huyện Điện Bàn', '33', null, '1');
INSERT INTO `district` VALUES ('379', 'Huyện Đại Lộc', '33', null, '1');
INSERT INTO `district` VALUES ('380', 'Huyện Quế Sơn', '33', null, '1');
INSERT INTO `district` VALUES ('381', 'Huyện Hiệp Đức', '33', null, '1');
INSERT INTO `district` VALUES ('382', 'Huyện Thăng Bình', '33', null, '1');
INSERT INTO `district` VALUES ('383', 'Huyện Núi Thành', '33', null, '1');
INSERT INTO `district` VALUES ('384', 'Huyện Tiên Phước', '33', null, '1');
INSERT INTO `district` VALUES ('385', 'Huyện Bắc Trà My', '33', null, '1');
INSERT INTO `district` VALUES ('386', 'Huyện Đông Giang', '33', null, '1');
INSERT INTO `district` VALUES ('387', 'Huyện Nam Giang', '33', null, '1');
INSERT INTO `district` VALUES ('388', 'Huyện Phước Sơn', '33', null, '1');
INSERT INTO `district` VALUES ('389', 'Huyện Nam Trà My', '33', null, '1');
INSERT INTO `district` VALUES ('390', 'Huyện Tây Giang', '33', null, '1');
INSERT INTO `district` VALUES ('391', 'Huyện Phú Ninh', '33', null, '1');
INSERT INTO `district` VALUES ('392', 'Huyện Nông Sơn', '33', null, '1');
INSERT INTO `district` VALUES ('393', 'TP.Quảng Ngãi', '34', null, '1');
INSERT INTO `district` VALUES ('394', 'Huyện Lý Sơn', '34', null, '1');
INSERT INTO `district` VALUES ('395', 'Huyện Bình Sơn', '34', null, '1');
INSERT INTO `district` VALUES ('396', 'Huyện Trà Bồng', '34', null, '1');
INSERT INTO `district` VALUES ('397', 'Huyện Sơn Tịnh', '34', null, '1');
INSERT INTO `district` VALUES ('398', 'Huyện Sơn Hà', '34', null, '1');
INSERT INTO `district` VALUES ('399', 'Huyện Tư Nghĩa', '34', null, '1');
INSERT INTO `district` VALUES ('400', 'Huyện Nghĩa Hành', '34', null, '1');
INSERT INTO `district` VALUES ('401', 'Huyện Minh Long', '34', null, '1');
INSERT INTO `district` VALUES ('402', 'Huyện Mộ Đức', '34', null, '1');
INSERT INTO `district` VALUES ('403', 'Huyện Đức Phổ', '34', null, '1');
INSERT INTO `district` VALUES ('404', 'Huyện Ba Tơ', '34', null, '1');
INSERT INTO `district` VALUES ('405', 'Huyện Sơn Tây', '34', null, '1');
INSERT INTO `district` VALUES ('406', 'Huyện Tây Trà', '34', null, '1');
INSERT INTO `district` VALUES ('407', 'Thị xã KonTum', '35', null, '1');
INSERT INTO `district` VALUES ('408', 'Huyện Đăk Glei', '35', null, '1');
INSERT INTO `district` VALUES ('409', 'Huyện Ngọc Hồi', '35', null, '1');
INSERT INTO `district` VALUES ('410', 'Huyện Đăk Tô', '35', null, '1');
INSERT INTO `district` VALUES ('411', 'Huyện Sa Thầy', '35', null, '1');
INSERT INTO `district` VALUES ('412', 'Huyện Kon Plông', '35', null, '1');
INSERT INTO `district` VALUES ('413', 'Huyện Đăk Hà', '35', null, '1');
INSERT INTO `district` VALUES ('414', 'Huyện Kon Rẫy', '35', null, '1');
INSERT INTO `district` VALUES ('415', 'Huyện Tu Mơ Rông', '35', null, '1');
INSERT INTO `district` VALUES ('416', 'Thành phố Quy Nhơn', '36', null, '1');
INSERT INTO `district` VALUES ('417', 'Huyện An Lão', '36', null, '1');
INSERT INTO `district` VALUES ('418', 'Huyện Hoài Ân', '36', null, '1');
INSERT INTO `district` VALUES ('419', 'Huyện Hoài Nhơn', '36', null, '1');
INSERT INTO `district` VALUES ('420', 'Huyện Phù Mỹ', '36', null, '1');
INSERT INTO `district` VALUES ('421', 'Huyện Phù Cát', '36', null, '1');
INSERT INTO `district` VALUES ('422', 'Huyện Vĩnh Thạnh', '36', null, '1');
INSERT INTO `district` VALUES ('423', 'Huyện Tây Sơn', '36', null, '1');
INSERT INTO `district` VALUES ('424', 'Huyện Vân Canh', '36', null, '1');
INSERT INTO `district` VALUES ('425', 'Thị xã An Nhơn', '36', null, '1');
INSERT INTO `district` VALUES ('426', 'Huyện Tuy Phước', '36', null, '1');
INSERT INTO `district` VALUES ('427', 'Thành phố Pleiku', '37', null, '1');
INSERT INTO `district` VALUES ('428', 'Huyện Chư Păh', '37', null, '1');
INSERT INTO `district` VALUES ('429', 'Huyện Mang Yang', '37', null, '1');
INSERT INTO `district` VALUES ('430', 'Huyện Kbang', '37', null, '1');
INSERT INTO `district` VALUES ('431', 'Thị xã An Khê', '37', null, '1');
INSERT INTO `district` VALUES ('432', 'Huyện Kông Chro', '37', null, '1');
INSERT INTO `district` VALUES ('433', 'Huyện Đức Cơ', '37', null, '1');
INSERT INTO `district` VALUES ('434', 'Huyện Chưprông', '37', null, '1');
INSERT INTO `district` VALUES ('435', 'Huyện Chư Sê', '37', null, '1');
INSERT INTO `district` VALUES ('436', 'Thị xã AyunPa', '37', null, '1');
INSERT INTO `district` VALUES ('437', 'Huyện Krông Pa', '37', null, '1');
INSERT INTO `district` VALUES ('438', 'Huyện Ia Grai', '37', null, '1');
INSERT INTO `district` VALUES ('439', 'Huyện Đăk Đoa', '37', null, '1');
INSERT INTO `district` VALUES ('440', 'Huyện Ia Pa', '37', null, '1');
INSERT INTO `district` VALUES ('441', 'Huyện Đăk Pơ', '37', null, '1');
INSERT INTO `district` VALUES ('442', 'Huyện Phú Thiện', '37', null, '1');
INSERT INTO `district` VALUES ('443', 'TP. Tuy Hòa', '38', null, '1');
INSERT INTO `district` VALUES ('444', 'Huyện Đồng Xuân', '38', null, '1');
INSERT INTO `district` VALUES ('445', 'Thị xã Sông Cầu', '38', null, '1');
INSERT INTO `district` VALUES ('446', 'Huyện Tuy An', '38', null, '1');
INSERT INTO `district` VALUES ('447', 'Huyện Sơn Hoà', '38', null, '1');
INSERT INTO `district` VALUES ('448', 'Huyện Sông Hinh', '38', null, '1');
INSERT INTO `district` VALUES ('449', 'Huyện Đông Hoà', '38', null, '1');
INSERT INTO `district` VALUES ('450', 'Huyện Phú Hoà', '38', null, '1');
INSERT INTO `district` VALUES ('451', 'Huyện Tây Hoà', '38', null, '1');
INSERT INTO `district` VALUES ('452', 'TP.Buôn Ma Thuột', '39', null, '1');
INSERT INTO `district` VALUES ('453', 'Huyện Ea H Leo', '39', null, '1');
INSERT INTO `district` VALUES ('454', 'Huyện Krông Buk', '39', null, '1');
INSERT INTO `district` VALUES ('455', 'Huyện Krông Năng', '39', null, '1');
INSERT INTO `district` VALUES ('456', 'Huyện Ea Súp', '39', null, '1');
INSERT INTO `district` VALUES ('457', 'Huyện Cư M gar', '39', null, '1');
INSERT INTO `district` VALUES ('458', 'Huyện Krông Pắc', '39', null, '1');
INSERT INTO `district` VALUES ('459', 'Huyện Ea Kar', '39', null, '1');
INSERT INTO `district` VALUES ('460', 'Huyện M\'Đrăk', '39', null, '1');
INSERT INTO `district` VALUES ('461', 'Huyện Krông Ana', '39', null, '1');
INSERT INTO `district` VALUES ('462', 'Huyện Krông Bông', '39', null, '1');
INSERT INTO `district` VALUES ('463', 'Huyện Lăk', '39', null, '1');
INSERT INTO `district` VALUES ('464', 'Huyện Buôn Đôn', '39', null, '1');
INSERT INTO `district` VALUES ('465', 'Huyện Cư Kuin', '39', null, '1');
INSERT INTO `district` VALUES ('466', 'Thành phố Nha Trang', '40', null, '1');
INSERT INTO `district` VALUES ('467', 'Huyện Vạn Ninh', '40', null, '1');
INSERT INTO `district` VALUES ('468', 'Thị xã Ninh Hòa', '40', null, '1');
INSERT INTO `district` VALUES ('469', 'Huyện Diên Khánh', '40', null, '1');
INSERT INTO `district` VALUES ('470', 'Huyện Khánh Vĩnh', '40', null, '1');
INSERT INTO `district` VALUES ('471', 'TP. Cam Ranh', '40', null, '1');
INSERT INTO `district` VALUES ('472', 'Huyện Khánh Sơn', '40', null, '1');
INSERT INTO `district` VALUES ('473', 'Huyện Trường Sa', '40', null, '1');
INSERT INTO `district` VALUES ('474', 'Huyện Cam Lâm', '40', null, '1');
INSERT INTO `district` VALUES ('475', 'Thành phố Đà Lạt', '41', null, '1');
INSERT INTO `district` VALUES ('476', 'TP. Bảo Lộc', '41', null, '1');
INSERT INTO `district` VALUES ('477', 'Huyện Đức Trọng', '41', null, '1');
INSERT INTO `district` VALUES ('478', 'Huyện Di Linh', '41', null, '1');
INSERT INTO `district` VALUES ('479', 'Huyện Đơn Dương', '41', null, '1');
INSERT INTO `district` VALUES ('480', 'Huyện Lạc Dương', '41', null, '1');
INSERT INTO `district` VALUES ('481', 'Huyện Đạ Huoai', '41', null, '1');
INSERT INTO `district` VALUES ('482', 'Huyện Đạ Tẻh', '41', null, '1');
INSERT INTO `district` VALUES ('483', 'Huyện Cát Tiên', '41', null, '1');
INSERT INTO `district` VALUES ('484', 'Huyện Lâm Hà', '41', null, '1');
INSERT INTO `district` VALUES ('485', 'Huyện Bảo Lâm', '41', null, '1');
INSERT INTO `district` VALUES ('486', 'Huyện Đam Rông', '41', null, '1');
INSERT INTO `district` VALUES ('487', 'Thị xã Đồng Xoài', '42', null, '1');
INSERT INTO `district` VALUES ('488', 'Huyện Đồng Phú', '42', null, '1');
INSERT INTO `district` VALUES ('489', 'Huyện Chơn Thành', '42', null, '1');
INSERT INTO `district` VALUES ('490', 'Thị xã Bình Long', '42', null, '1');
INSERT INTO `district` VALUES ('491', 'Huyện Lộc Ninh', '42', null, '1');
INSERT INTO `district` VALUES ('492', 'Huyện Bù Đốp', '42', null, '1');
INSERT INTO `district` VALUES ('493', 'Thị xã Phước Long', '42', null, '1');
INSERT INTO `district` VALUES ('494', 'Huyện Bù Đăng', '42', null, '1');
INSERT INTO `district` VALUES ('495', 'TP. Thủ Dầu Một', '43', null, '1');
INSERT INTO `district` VALUES ('496', 'Thị xã Bến Cát', '43', null, '1');
INSERT INTO `district` VALUES ('497', 'Thị xã Tân Uyên', '43', null, '1');
INSERT INTO `district` VALUES ('498', 'Thị xã Thuận An', '43', null, '1');
INSERT INTO `district` VALUES ('499', 'Thị xã Dĩ An', '43', null, '1');
INSERT INTO `district` VALUES ('500', 'Huyện Phú Giáo', '43', null, '1');
INSERT INTO `district` VALUES ('501', 'Huyện Dầu Tiếng', '43', null, '1');
INSERT INTO `district` VALUES ('502', 'TP.Phan Rang - Tháp Chàm', '44', null, '1');
INSERT INTO `district` VALUES ('503', 'Huyện Ninh Sơn', '44', null, '1');
INSERT INTO `district` VALUES ('504', 'Huyện Ninh Hải', '44', null, '1');
INSERT INTO `district` VALUES ('505', 'Huyện Ninh Phước', '44', null, '1');
INSERT INTO `district` VALUES ('506', 'Huyện Bác ái', '44', null, '1');
INSERT INTO `district` VALUES ('507', 'Huyện Thuận Bắc', '44', null, '1');
INSERT INTO `district` VALUES ('508', 'TP. Tây Ninh', '45', null, '1');
INSERT INTO `district` VALUES ('509', 'Huyện Tân Biên', '45', null, '1');
INSERT INTO `district` VALUES ('510', 'Huyện Tân Châu', '45', null, '1');
INSERT INTO `district` VALUES ('511', 'Huyện Dương Minh Châu', '45', null, '1');
INSERT INTO `district` VALUES ('512', 'Huyện Châu Thành', '45', null, '1');
INSERT INTO `district` VALUES ('513', 'Huyện Hoà Thành', '45', null, '1');
INSERT INTO `district` VALUES ('514', 'Huyện Bến Cầu', '45', null, '1');
INSERT INTO `district` VALUES ('515', 'Huyện Gò Dầu', '45', null, '1');
INSERT INTO `district` VALUES ('516', 'Huyện Trảng Bàng', '45', null, '1');
INSERT INTO `district` VALUES ('517', 'Thành phố Phan Thiết', '46', null, '1');
INSERT INTO `district` VALUES ('518', 'Huyện Tuy Phong', '46', null, '1');
INSERT INTO `district` VALUES ('519', 'Huyện Bắc Bình', '46', null, '1');
INSERT INTO `district` VALUES ('520', 'Huyện Hàm Thuận Bắc', '46', null, '1');
INSERT INTO `district` VALUES ('521', 'Huyện Hàm Thuận Nam', '46', null, '1');
INSERT INTO `district` VALUES ('522', 'Huyện Hàm Tân', '46', null, '1');
INSERT INTO `district` VALUES ('523', 'Huyện Đức Linh', '46', null, '1');
INSERT INTO `district` VALUES ('524', 'Huyện Tánh Linh', '46', null, '1');
INSERT INTO `district` VALUES ('525', 'Huyện đảo Phú Quý', '46', null, '1');
INSERT INTO `district` VALUES ('526', 'Thị xã LaGi', '46', null, '1');
INSERT INTO `district` VALUES ('527', 'Thành phố Biên Hoà', '47', null, '1');
INSERT INTO `district` VALUES ('528', 'Huyện Vĩnh Cửu', '47', null, '1');
INSERT INTO `district` VALUES ('529', 'Huyện Tân Phú', '47', null, '1');
INSERT INTO `district` VALUES ('530', 'Huyện Định Quán', '47', null, '1');
INSERT INTO `district` VALUES ('531', 'Huyện Thống Nhất', '47', null, '1');
INSERT INTO `district` VALUES ('532', 'Thị xã Long Khánh', '47', null, '1');
INSERT INTO `district` VALUES ('533', 'Huyện Xuân Lộc', '47', null, '1');
INSERT INTO `district` VALUES ('534', 'Huyện Long Thành', '47', null, '1');
INSERT INTO `district` VALUES ('535', 'Huyện Nhơn Trạch', '47', null, '1');
INSERT INTO `district` VALUES ('536', 'Huyện Trảng Bom', '47', null, '1');
INSERT INTO `district` VALUES ('537', 'Huyện Cẩm Mỹ', '47', null, '1');
INSERT INTO `district` VALUES ('538', 'TP. Tân An', '48', null, '1');
INSERT INTO `district` VALUES ('539', 'Huyện Vĩnh Hưng', '48', null, '1');
INSERT INTO `district` VALUES ('540', 'Huyện Mộc Hoá', '48', null, '1');
INSERT INTO `district` VALUES ('541', 'Huyện Tân Thạnh', '48', null, '1');
INSERT INTO `district` VALUES ('542', 'Huyện Thạnh Hoá', '48', null, '1');
INSERT INTO `district` VALUES ('543', 'Huyện Đức Huệ', '48', null, '1');
INSERT INTO `district` VALUES ('544', 'Huyện Đức Hoà', '48', null, '1');
INSERT INTO `district` VALUES ('545', 'Huyện Bến Lức', '48', null, '1');
INSERT INTO `district` VALUES ('546', 'Huyện Thủ Thừa', '48', null, '1');
INSERT INTO `district` VALUES ('547', 'Huyện Châu Thành', '48', null, '1');
INSERT INTO `district` VALUES ('548', 'Huyện Tân Trụ', '48', null, '1');
INSERT INTO `district` VALUES ('549', 'Huyện Cần Đước', '48', null, '1');
INSERT INTO `district` VALUES ('550', 'Huyện Cần Giuộc', '48', null, '1');
INSERT INTO `district` VALUES ('551', 'Huyện Tân Hưng', '48', null, '1');
INSERT INTO `district` VALUES ('552', 'Thành phố Cao Lãnh', '49', null, '1');
INSERT INTO `district` VALUES ('553', 'TP. Sa Đéc', '49', null, '1');
INSERT INTO `district` VALUES ('554', 'Huyện Tân Hồng', '49', null, '1');
INSERT INTO `district` VALUES ('555', 'Thị xã Hồng Ngự', '49', null, '1');
INSERT INTO `district` VALUES ('556', 'Huyện Tam Nông', '49', null, '1');
INSERT INTO `district` VALUES ('557', 'Huyện Thanh Bình', '49', null, '1');
INSERT INTO `district` VALUES ('558', 'Huyện Cao Lãnh', '49', null, '1');
INSERT INTO `district` VALUES ('559', 'Huyện Lấp Vò', '49', null, '1');
INSERT INTO `district` VALUES ('560', 'Huyện Tháp Mười', '49', null, '1');
INSERT INTO `district` VALUES ('561', 'Huyện Lai Vung', '49', null, '1');
INSERT INTO `district` VALUES ('562', 'Huyện Châu Thành', '49', null, '1');
INSERT INTO `district` VALUES ('563', 'TP.Long Xuyên', '50', null, '1');
INSERT INTO `district` VALUES ('564', 'TP. Châu Đốc', '50', null, '1');
INSERT INTO `district` VALUES ('565', 'Huyện An Phú', '50', null, '1');
INSERT INTO `district` VALUES ('566', 'Thị xã Tân Châu', '50', null, '1');
INSERT INTO `district` VALUES ('567', 'Huyện Phú Tân', '50', null, '1');
INSERT INTO `district` VALUES ('568', 'Huyện Tịnh Biên', '50', null, '1');
INSERT INTO `district` VALUES ('569', 'Huyện Tri Tôn', '50', null, '1');
INSERT INTO `district` VALUES ('570', 'Huyện Châu Phú', '50', null, '1');
INSERT INTO `district` VALUES ('571', 'Huyện Chợ Mới', '50', null, '1');
INSERT INTO `district` VALUES ('572', 'Huyện Châu Thành', '50', null, '1');
INSERT INTO `district` VALUES ('573', 'Huyện Thoại Sơn', '50', null, '1');
INSERT INTO `district` VALUES ('574', 'Thành phố Vũng Tàu', '51', null, '1');
INSERT INTO `district` VALUES ('575', 'Thị xã Bà Rịa', '51', null, '1');
INSERT INTO `district` VALUES ('576', 'Huyện Xuyên Mộc', '51', null, '1');
INSERT INTO `district` VALUES ('577', 'Huyện Long Điền', '51', null, '1');
INSERT INTO `district` VALUES ('578', 'Huyện Côn Đảo', '51', null, '1');
INSERT INTO `district` VALUES ('579', 'Huyện Tân Thành', '51', null, '1');
INSERT INTO `district` VALUES ('580', 'Huyện Châu Đức', '51', null, '1');
INSERT INTO `district` VALUES ('581', 'Huyện Đất Đỏ', '51', null, '1');
INSERT INTO `district` VALUES ('582', 'Thành phố Mỹ Tho', '52', null, '1');
INSERT INTO `district` VALUES ('583', 'Thị xã Gò Công', '52', null, '1');
INSERT INTO `district` VALUES ('584', 'Huyện Cái Bè', '52', null, '1');
INSERT INTO `district` VALUES ('585', 'Thị xã Cai Lậy', '52', null, '1');
INSERT INTO `district` VALUES ('586', 'Huyện Châu Thành', '52', null, '1');
INSERT INTO `district` VALUES ('587', 'Huyện Chợ Gạo', '52', null, '1');
INSERT INTO `district` VALUES ('588', 'Huyện Gò Công Tây', '52', null, '1');
INSERT INTO `district` VALUES ('589', 'Huyện Gò Công Đông', '52', null, '1');
INSERT INTO `district` VALUES ('590', 'Huyện Tân Phước', '52', null, '1');
INSERT INTO `district` VALUES ('591', 'Huyện Tân Phú Đông', '52', null, '1');
INSERT INTO `district` VALUES ('592', 'Thành phố Rạch Giá', '53', null, '1');
INSERT INTO `district` VALUES ('593', 'Thị xã Hà Tiên', '53', null, '1');
INSERT INTO `district` VALUES ('594', 'Huyện Kiên Lương', '53', null, '1');
INSERT INTO `district` VALUES ('595', 'Huyện Hòn Đất', '53', null, '1');
INSERT INTO `district` VALUES ('596', 'Huyện Tân Hiệp', '53', null, '1');
INSERT INTO `district` VALUES ('597', 'Huyện Châu Thành', '53', null, '1');
INSERT INTO `district` VALUES ('598', 'Huyện Giồng Riềng', '53', null, '1');
INSERT INTO `district` VALUES ('599', 'Huyện Gò Quao', '53', null, '1');
INSERT INTO `district` VALUES ('600', 'Huyện An Biên', '53', null, '1');
INSERT INTO `district` VALUES ('601', 'Huyện An Minh', '53', null, '1');
INSERT INTO `district` VALUES ('602', 'Huyện Vĩnh Thuận', '53', null, '1');
INSERT INTO `district` VALUES ('603', 'Huyện Phú Quốc', '53', null, '1');
INSERT INTO `district` VALUES ('604', 'Huyện Kiên Hải', '53', null, '1');
INSERT INTO `district` VALUES ('605', 'Huyện U minh Thượng', '53', null, '1');
INSERT INTO `district` VALUES ('606', 'Quận Ninh Kiều', '54', null, '1');
INSERT INTO `district` VALUES ('607', 'Quận Bình Thuỷ', '54', null, '1');
INSERT INTO `district` VALUES ('608', 'Quận Cái Răng', '54', null, '1');
INSERT INTO `district` VALUES ('609', 'Quận Ô Môn', '54', null, '1');
INSERT INTO `district` VALUES ('610', 'Huyện Phong Điền', '54', null, '1');
INSERT INTO `district` VALUES ('611', 'Huyện Cờ Đỏ', '54', null, '1');
INSERT INTO `district` VALUES ('612', 'Huyện Vĩnh Thạnh', '54', null, '1');
INSERT INTO `district` VALUES ('613', 'Huỵện Thốt Nốt', '54', null, '1');
INSERT INTO `district` VALUES ('614', 'TP. Bến Tre', '55', null, '1');
INSERT INTO `district` VALUES ('615', 'Huyện Châu Thành', '55', null, '1');
INSERT INTO `district` VALUES ('616', 'Huyện Chợ Lách', '55', null, '1');
INSERT INTO `district` VALUES ('617', 'Huyện Mỏ Cày', '55', null, '1');
INSERT INTO `district` VALUES ('618', 'Huyện Giồng Trôm', '55', null, '1');
INSERT INTO `district` VALUES ('619', 'Huyện Bình Đại', '55', null, '1');
INSERT INTO `district` VALUES ('620', 'Huyện Ba Tri', '55', null, '1');
INSERT INTO `district` VALUES ('621', 'Huyện Thạnh Phú', '55', null, '1');
INSERT INTO `district` VALUES ('622', 'TP. Vĩnh Long', '56', null, '1');
INSERT INTO `district` VALUES ('623', 'Huyện Long Hồ', '56', null, '1');
INSERT INTO `district` VALUES ('624', 'Huyện Mang Thít', '56', null, '1');
INSERT INTO `district` VALUES ('625', 'Thị xã Bình Minh', '56', null, '1');
INSERT INTO `district` VALUES ('626', 'Huyện Tam Bình', '56', null, '1');
INSERT INTO `district` VALUES ('627', 'Huyện Trà Ôn', '56', null, '1');
INSERT INTO `district` VALUES ('628', 'Huyện Vũng Liêm', '56', null, '1');
INSERT INTO `district` VALUES ('629', 'Huyện Bình Tân', '56', null, '1');
INSERT INTO `district` VALUES ('630', 'TP. Trà Vinh', '57', null, '1');
INSERT INTO `district` VALUES ('631', 'Huyện Càng Long', '57', null, '1');
INSERT INTO `district` VALUES ('632', 'Huyện Cầu Kè', '57', null, '1');
INSERT INTO `district` VALUES ('633', 'Huyện Tiểu Cần', '57', null, '1');
INSERT INTO `district` VALUES ('634', 'Huyện Châu Thành', '57', null, '1');
INSERT INTO `district` VALUES ('635', 'Huyện Trà Cú', '57', null, '1');
INSERT INTO `district` VALUES ('636', 'Huyện Cầu Ngang', '57', null, '1');
INSERT INTO `district` VALUES ('637', 'Huyện Duyên Hải', '57', null, '1');
INSERT INTO `district` VALUES ('638', 'Thành phố Sóc Trăng', '58', null, '1');
INSERT INTO `district` VALUES ('639', 'Huyện Kế Sách', '58', null, '1');
INSERT INTO `district` VALUES ('640', 'Huyện Mỹ Tú', '58', null, '1');
INSERT INTO `district` VALUES ('641', 'Huyện Mỹ Xuyên', '58', null, '1');
INSERT INTO `district` VALUES ('642', 'Huyện Thạnh Trị', '58', null, '1');
INSERT INTO `district` VALUES ('643', 'Huyện Long Phú', '58', null, '1');
INSERT INTO `district` VALUES ('644', 'Huyện Vĩnh Châu', '58', null, '1');
INSERT INTO `district` VALUES ('645', 'Huyện Cù Lao Dung', '58', null, '1');
INSERT INTO `district` VALUES ('646', 'Huyện Ngã Năm', '58', null, '1');
INSERT INTO `district` VALUES ('647', 'Huyện Châu Thành', '58', null, '1');
INSERT INTO `district` VALUES ('648', 'Thị xã Bạc Liêu', '59', null, '1');
INSERT INTO `district` VALUES ('649', 'Huyện Vĩnh Lợi', '59', null, '1');
INSERT INTO `district` VALUES ('650', 'Huyện Hồng Dân', '59', null, '1');
INSERT INTO `district` VALUES ('651', 'Huyện Giá Rai', '59', null, '1');
INSERT INTO `district` VALUES ('652', 'Huyện Phước Long', '59', null, '1');
INSERT INTO `district` VALUES ('653', 'Huyện Đông Hải', '59', null, '1');
INSERT INTO `district` VALUES ('654', 'Huyện Hoà Bình', '59', null, '1');
INSERT INTO `district` VALUES ('655', 'Thành phố Cà Mau', '60', null, '1');
INSERT INTO `district` VALUES ('656', 'Huyện Thới Bình', '60', null, '1');
INSERT INTO `district` VALUES ('657', 'Huyện U Minh', '60', null, '1');
INSERT INTO `district` VALUES ('658', 'Huyện Trần Văn Thời', '60', null, '1');
INSERT INTO `district` VALUES ('659', 'Huyện Cái Nước', '60', null, '1');
INSERT INTO `district` VALUES ('660', 'Huyện Đầm Dơi', '60', null, '1');
INSERT INTO `district` VALUES ('661', 'Huyện Ngọc Hiển', '60', null, '1');
INSERT INTO `district` VALUES ('662', 'Huyện Năm Căn', '60', null, '1');
INSERT INTO `district` VALUES ('663', 'Huyện Phú Tân', '60', null, '1');
INSERT INTO `district` VALUES ('664', 'TP. Điện Biên Phủ', '61', null, '1');
INSERT INTO `district` VALUES ('665', 'Thị xã Mường Lay', '61', null, '1');
INSERT INTO `district` VALUES ('666', 'Huyện Điện Biên', '61', null, '1');
INSERT INTO `district` VALUES ('667', 'Huyện Tuần Giáo', '61', null, '1');
INSERT INTO `district` VALUES ('668', 'Huyện Mường Chà', '61', null, '1');
INSERT INTO `district` VALUES ('669', 'Huyện Tủa Chùa', '61', null, '1');
INSERT INTO `district` VALUES ('670', 'Huyện Điện Biên Đông', '61', null, '1');
INSERT INTO `district` VALUES ('671', 'Huyện Mường Nhé', '61', null, '1');
INSERT INTO `district` VALUES ('672', 'Huyện Mường Ảng', '61', null, '1');
INSERT INTO `district` VALUES ('673', 'Thị xã Gia Nghĩa', '62', null, '1');
INSERT INTO `district` VALUES ('674', 'Huyện Đăk R\'Lấp', '62', null, '1');
INSERT INTO `district` VALUES ('675', 'Huyện Đăk Mil', '62', null, '1');
INSERT INTO `district` VALUES ('676', 'Huyện Cư Jút', '62', null, '1');
INSERT INTO `district` VALUES ('677', 'Huyện Đăk Song', '62', null, '1');
INSERT INTO `district` VALUES ('678', 'Huyện Krông Nô', '62', null, '1');
INSERT INTO `district` VALUES ('679', 'Huyện Đăk Glong', '62', null, '1');
INSERT INTO `district` VALUES ('680', 'Huyện Tuy Đức', '62', null, '1');
INSERT INTO `district` VALUES ('681', 'TP. Vị Thanh', '63', null, '1');
INSERT INTO `district` VALUES ('682', 'Huyện Vị Thuỷ', '63', null, '1');
INSERT INTO `district` VALUES ('683', 'Huyện Long Mỹ', '63', null, '1');
INSERT INTO `district` VALUES ('684', 'Huyện Phụng Hiệp', '63', null, '1');
INSERT INTO `district` VALUES ('685', 'Huyện Châu Thành', '63', null, '1');
INSERT INTO `district` VALUES ('686', 'Huyện Châu Thành A', '63', null, '1');
INSERT INTO `district` VALUES ('687', 'Thị xã Ngã Bảy', '63', null, '1');
INSERT INTO `district` VALUES ('688', 'Quận Nam Từ Liêm', '1', null, '1');
INSERT INTO `district` VALUES ('689', 'Quận Bắc Từ Liêm', '1', null, '1');
INSERT INTO `district` VALUES ('690', 'Huyện Bù Gia Mập', '42', null, '1');
INSERT INTO `district` VALUES ('691', 'Huyện Hớn Quản', '42', null, '1');
INSERT INTO `district` VALUES ('692', 'Huyện Thới Lai', '54', null, '1');
INSERT INTO `district` VALUES ('693', 'Huyện đảo Hoàng Sa', '4', null, '1');
INSERT INTO `district` VALUES ('694', 'Thị xã Buôn Hồ', '39', null, '1');
INSERT INTO `district` VALUES ('695', 'Nậm Pồ', '61', null, '1');
INSERT INTO `district` VALUES ('696', 'Huyện Nậm Nhùn', '7', null, '1');
INSERT INTO `district` VALUES ('697', 'Thị xã Kiến Tường', '48', null, '1');
INSERT INTO `district` VALUES ('698', 'Thị xã Thái Hòa', '28', null, '1');
INSERT INTO `district` VALUES ('699', 'Huyện Thuận Nam', '44', null, '1');
INSERT INTO `district` VALUES ('700', 'Thị xã Quảng Yên', '17', null, '1');
INSERT INTO `district` VALUES ('701', 'Huyện Vân Hồ', '14', null, '1');
INSERT INTO `district` VALUES ('702', 'Huyện Phú Lộc', '32', null, '1');
INSERT INTO `district` VALUES ('703', 'Huyện Lâm Bình', '9', null, '1');
INSERT INTO `district` VALUES ('704', 'Huyện Sông Lô', '16', null, '1');
INSERT INTO `language` VALUES ('cn', 'Y-m-d H:i', '3', '1');
INSERT INTO `language` VALUES ('en', 'm-d-Y H:i', '1', '1');
INSERT INTO `language` VALUES ('vi', 'd-m-Y H:i', '2', '1');
INSERT INTO `menu_links` VALUES ('1', '345345', '0', '1', '1', '/term/list/2', '_self', 'vi', '1', '1', '2', '35t2345234');
INSERT INTO `menu_links` VALUES ('2', '3344', '1', '1', '', '', '_self', 'vi', '1', '1', '0', '');
INSERT INTO `menu_links` VALUES ('3', '34566', '2', '1', '', '', '_self', 'vi', '1', '1', '0', '');
INSERT INTO `menu_links` VALUES ('4', '354345234', '0', '1', '', '', '_self', 'vi', '1', '1', '0', '');
INSERT INTO `menus` VALUES ('1', 'Main navigation', '', 'vi', '1');
INSERT INTO `menus` VALUES ('2', 'Auxiliary', 'adddd', 'vi', '1');
INSERT INTO `menus` VALUES ('3', 'Menu chính', '345345', null, '1');
INSERT INTO `province` VALUES ('1', 'Hà Nội', '1', '1');
INSERT INTO `province` VALUES ('2', 'TP. Hồ Chí Minh', '2', '1');
INSERT INTO `province` VALUES ('3', 'Hải phòng', '3', '1');
INSERT INTO `province` VALUES ('4', 'Đà Nẵng', '3', '1');
INSERT INTO `province` VALUES ('5', 'Hà Giang', '3', '1');
INSERT INTO `province` VALUES ('6', 'Cao Bằng', '3', '1');
INSERT INTO `province` VALUES ('7', 'Lai Châu', '3', '1');
INSERT INTO `province` VALUES ('8', 'Lào Cai', '3', '1');
INSERT INTO `province` VALUES ('9', 'Tuyên Quang', '3', '1');
INSERT INTO `province` VALUES ('10', 'Lạng Sơn', '3', '1');
INSERT INTO `province` VALUES ('11', 'Bắc Kạn', '3', '1');
INSERT INTO `province` VALUES ('12', 'Thái Nguyên', '3', '1');
INSERT INTO `province` VALUES ('13', 'Yên Bái', '3', '1');
INSERT INTO `province` VALUES ('14', 'Sơn La', '3', '1');
INSERT INTO `province` VALUES ('15', 'Phú Thọ', '3', '1');
INSERT INTO `province` VALUES ('16', 'Vĩnh Phúc', '3', '1');
INSERT INTO `province` VALUES ('17', 'Quảng Ninh', '3', '1');
INSERT INTO `province` VALUES ('18', 'Bắc Giang', '3', '1');
INSERT INTO `province` VALUES ('19', 'Bắc Ninh', '3', '1');
INSERT INTO `province` VALUES ('20', 'Hải Dương', '3', '1');
INSERT INTO `province` VALUES ('21', 'Hưng Yên', '3', '1');
INSERT INTO `province` VALUES ('22', 'Hòa Bình', '3', '1');
INSERT INTO `province` VALUES ('23', 'Hà Nam', '3', '1');
INSERT INTO `province` VALUES ('24', 'Nam Định', '3', '1');
INSERT INTO `province` VALUES ('25', 'Thái Bình', '3', '1');
INSERT INTO `province` VALUES ('26', 'Ninh Bình', '3', '1');
INSERT INTO `province` VALUES ('27', 'Thanh Hóa', '3', '1');
INSERT INTO `province` VALUES ('28', 'Nghệ An', '3', '1');
INSERT INTO `province` VALUES ('29', 'Hà Tĩnh', '3', '1');
INSERT INTO `province` VALUES ('30', 'Quảng Bình', '3', '1');
INSERT INTO `province` VALUES ('31', 'Quảng Trị', '3', '1');
INSERT INTO `province` VALUES ('32', 'Thừa Thiên Huế', '3', '1');
INSERT INTO `province` VALUES ('33', 'Quảng Nam', '3', '1');
INSERT INTO `province` VALUES ('34', 'Quảng Ngãi', '3', '1');
INSERT INTO `province` VALUES ('35', 'Kontum', '3', '1');
INSERT INTO `province` VALUES ('36', 'Bình Định', '3', '1');
INSERT INTO `province` VALUES ('37', 'Gia Lai', '3', '1');
INSERT INTO `province` VALUES ('38', 'Phú Yên', '3', '1');
INSERT INTO `province` VALUES ('39', 'Đăk Lăk', '3', '1');
INSERT INTO `province` VALUES ('40', 'Khánh Hòa', '3', '1');
INSERT INTO `province` VALUES ('41', 'Lâm Đồng', '3', '1');
INSERT INTO `province` VALUES ('42', 'Bình Phước', '3', '1');
INSERT INTO `province` VALUES ('43', 'Bình Dương', '3', '1');
INSERT INTO `province` VALUES ('44', 'Ninh Thuận', '3', '1');
INSERT INTO `province` VALUES ('45', 'Tây Ninh', '3', '1');
INSERT INTO `province` VALUES ('46', 'Bình Thuận', '3', '1');
INSERT INTO `province` VALUES ('47', 'Đồng Nai', '3', '1');
INSERT INTO `province` VALUES ('48', 'Long An', '3', '1');
INSERT INTO `province` VALUES ('49', 'Đồng Tháp', '3', '1');
INSERT INTO `province` VALUES ('50', 'An Giang', '3', '1');
INSERT INTO `province` VALUES ('51', 'Bà Rịa - Vũng Tàu', '3', '1');
INSERT INTO `province` VALUES ('52', 'Tiền Giang', '3', '1');
INSERT INTO `province` VALUES ('53', 'Kiên Giang', '3', '1');
INSERT INTO `province` VALUES ('54', 'Cần Thơ', '3', '1');
INSERT INTO `province` VALUES ('55', 'Bến Tre', '3', '1');
INSERT INTO `province` VALUES ('56', 'Vĩnh Long', '3', '1');
INSERT INTO `province` VALUES ('57', 'Trà Vinh', '3', '1');
INSERT INTO `province` VALUES ('58', 'Sóc Trăng', '3', '1');
INSERT INTO `province` VALUES ('59', 'Bạc Liêu', '3', '1');
INSERT INTO `province` VALUES ('60', 'Cà Mau', '3', '1');
INSERT INTO `province` VALUES ('61', 'Điện Biên', '3', '1');
INSERT INTO `province` VALUES ('62', 'Đăk Nông', '3', '1');
INSERT INTO `province` VALUES ('63', 'Hậu Giang', '3', '1');
INSERT INTO `roles` VALUES ('1', 'Super administrator', '', '1', '1');
INSERT INTO `roles` VALUES ('2', 'Administrator', '', '2', '1');
INSERT INTO `roles` VALUES ('8', 'Editor', '', '3', '1');
INSERT INTO `settings` VALUES ('16', 'site_name', 'CMS', null);
INSERT INTO `settings` VALUES ('18', 'time_zone', 'Asia/Ho_Chi_Minh', null);
INSERT INTO `settings` VALUES ('23', 'copyright', 'Copyright 2016 - 2017. All rights reserved.', null);
INSERT INTO `settings` VALUES ('28', 'base_url', 'http://localhost/fptvn', null);
INSERT INTO `settings` VALUES ('29', 'description', 'Just Another CMS', null);
INSERT INTO `settings` VALUES ('30', 'url_rewrite', '1', null);
INSERT INTO `settings` VALUES ('32', 'date_format', 'm-d-Y', null);
INSERT INTO `settings` VALUES ('33', 'date_time_format', 'm-d-Y H:i', null);
INSERT INTO `settings` VALUES ('34', 'per_page', '5', null);
INSERT INTO `settings` VALUES ('35', 'lang_code', 'en', null);
INSERT INTO `settings` VALUES ('36', 'friendly_url', '1', null);
INSERT INTO `settings` VALUES ('37', 'ckeditor_url', '/assets/backend/ckeditor', null);
INSERT INTO `settings` VALUES ('38', 'ckfinder_url', '/assets/backend/ckfinder_v2', null);
INSERT INTO `settings` VALUES ('39', 'thumb_base_url', '/storage/upload/images', null);
INSERT INTO `settings` VALUES ('40', 'meta_tags', '<meta name=\"robots\" content=\"noindex, nofollow\">', null);
INSERT INTO `taxonomy` VALUES ('1', null, '', null, null, '1');
INSERT INTO `taxonomy` VALUES ('2', null, '', null, null, '1');
INSERT INTO `taxonomy` VALUES ('3', null, '', null, null, '1');
INSERT INTO `taxonomy` VALUES ('4', null, '', null, null, '1');
INSERT INTO `taxonomy` VALUES ('5', null, '', null, null, '1');
INSERT INTO `taxonomy` VALUES ('6', null, '', null, null, '1');
INSERT INTO `taxonomy` VALUES ('7', null, '', null, null, '1');
INSERT INTO `taxonomy` VALUES ('8', null, '', null, null, '1');
INSERT INTO `terms` VALUES ('1', 'asdfasdf', null, null, '/term/list/1', '', '0', null, '1', 'vi', '1', '0');
