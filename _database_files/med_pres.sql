/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50624
Source Host           : localhost:3306
Source Database       : med_pres

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2023-09-26 12:17:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `images`
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(45) NOT NULL,
  `prescription_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_images_prescription1_idx` (`prescription_id`),
  CONSTRAINT `fk_images_prescription1` FOREIGN KEY (`prescription_id`) REFERENCES `prescription` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images
-- ----------------------------
INSERT INTO `images` VALUES ('1', 'assets/images/uploads/5_1695377923_0.jpg', '5');
INSERT INTO `images` VALUES ('2', 'assets/images/uploads/5_1695377923_1.jpg', '5');
INSERT INTO `images` VALUES ('3', 'assets/images/uploads/5_1695377923_2.jpg', '5');
INSERT INTO `images` VALUES ('4', 'assets/images/uploads/6_1695377998_0.jpg', '6');
INSERT INTO `images` VALUES ('5', 'assets/images/uploads/6_1695377998_1.jpg', '6');
INSERT INTO `images` VALUES ('6', 'assets/images/uploads/6_1695377998_2.jpg', '6');
INSERT INTO `images` VALUES ('7', 'assets/images/uploads/6_1695377998_3.jpg', '6');
INSERT INTO `images` VALUES ('8', 'assets/images/uploads/6_1695377998_4.jpg', '6');
INSERT INTO `images` VALUES ('9', 'assets/images/uploads/7_1695702667_0.jpg', '7');
INSERT INTO `images` VALUES ('10', 'assets/images/uploads/7_1695702667_1.jpg', '7');
INSERT INTO `images` VALUES ('11', 'assets/images/uploads/7_1695702667_2.jpg', '7');
INSERT INTO `images` VALUES ('12', 'assets/images/uploads/7_1695702667_3.jpg', '7');
INSERT INTO `images` VALUES ('13', 'assets/images/uploads/8_1695707448_0.jpg', '8');
INSERT INTO `images` VALUES ('14', 'assets/images/uploads/8_1695707448_1.jpg', '8');
INSERT INTO `images` VALUES ('15', 'assets/images/uploads/8_1695707448_2.jpg', '8');
INSERT INTO `images` VALUES ('16', 'assets/images/uploads/8_1695707448_3.jpg', '8');
INSERT INTO `images` VALUES ('17', 'assets/images/uploads/8_1695707448_4.jpg', '8');

-- ----------------------------
-- Table structure for `prescription`
-- ----------------------------
DROP TABLE IF EXISTS `prescription`;
CREATE TABLE `prescription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note` text NOT NULL,
  `delivery_address` varchar(255) NOT NULL,
  `delivery_time` varchar(45) NOT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_prescription_users1_idx` (`users_id`),
  CONSTRAINT `fk_prescription_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of prescription
-- ----------------------------
INSERT INTO `prescription` VALUES ('5', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam a ullamcorper sem. Donec eget aliquam arcu. Nulla eget nisi lobortis, pretium orci id, bibendum odio. Aenean egestas ornare nisi, eget scelerisque nisl. Proin posuere nulla ex, a vestibulum nisi laoreet cursus. Sed arcu neque, rhoncus a nisl non, faucibus pulvinar tellus. Ut semper elit massa, a porta eros ultricies eu. Cras ornare faucibus pretium.', 'Kandy', '15:48', '1');
INSERT INTO `prescription` VALUES ('6', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam a ullamcorper sem. Donec eget aliquam arcu. Nulla eget nisi lobortis, pretium orci id, bibendum odio. Aenean egestas ornare nisi, eget scelerisque nisl. Proin posuere nulla ex, a vestibulum nisi laoreet cursus. Sed arcu neque, rhoncus a nisl non, faucibus pulvinar tellus. Ut semper elit massa, a porta eros ultricies eu. Cras ornare faucibus pretium.', 'Kandy', '15:49', '1');
INSERT INTO `prescription` VALUES ('7', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam a ullamcorper sem. Donec eget aliquam arcu. Nulla eget nisi lobortis, pretium orci id, bibendum odio. Aenean egestas ornare nisi, eget scelerisque nisl. Proin posuere nulla ex, a vestibulum nisi laoreet cursus. Sed arcu neque, rhoncus a nisl non, faucibus pulvinar tellus. Ut semper elit massa, a porta eros ultricies eu. Cras ornare faucibus pretium.', 'Kandy', '22:00', '1');
INSERT INTO `prescription` VALUES ('8', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Kandy', '11:00', '6');

-- ----------------------------
-- Table structure for `quotes`
-- ----------------------------
DROP TABLE IF EXISTS `quotes`;
CREATE TABLE `quotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total` double NOT NULL,
  `prescription_id` int(11) NOT NULL,
  `quote_status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_quotes_prescription1_idx` (`prescription_id`),
  KEY `fk_quotes_quote_status1_idx` (`quote_status_id`),
  CONSTRAINT `fk_quotes_prescription1` FOREIGN KEY (`prescription_id`) REFERENCES `prescription` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_quotes_quote_status1` FOREIGN KEY (`quote_status_id`) REFERENCES `quote_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of quotes
-- ----------------------------
INSERT INTO `quotes` VALUES ('1', '774', '5', '1');
INSERT INTO `quotes` VALUES ('2', '2601', '6', '3');
INSERT INTO `quotes` VALUES ('3', '200', '6', '2');
INSERT INTO `quotes` VALUES ('4', '442.75', '8', '2');

-- ----------------------------
-- Table structure for `quote_items`
-- ----------------------------
DROP TABLE IF EXISTS `quote_items`;
CREATE TABLE `quote_items` (
  `idquote_items` int(11) NOT NULL AUTO_INCREMENT,
  `drug` varchar(100) NOT NULL,
  `unit_price` double NOT NULL,
  `qty` double NOT NULL,
  `price` double NOT NULL,
  `quotes_id` int(11) NOT NULL,
  PRIMARY KEY (`idquote_items`),
  KEY `fk_quote_items_quotes1_idx` (`quotes_id`),
  CONSTRAINT `fk_quote_items_quotes1` FOREIGN KEY (`quotes_id`) REFERENCES `quotes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of quote_items
-- ----------------------------
INSERT INTO `quote_items` VALUES ('1', 'Drug 01', '15', '10', '150', '1');
INSERT INTO `quote_items` VALUES ('2', 'Drug 02', '12', '52', '624', '1');
INSERT INTO `quote_items` VALUES ('3', 'Drug 01', '15', '15', '225', '2');
INSERT INTO `quote_items` VALUES ('4', 'Drug 02', '65', '22', '1430', '2');
INSERT INTO `quote_items` VALUES ('5', 'Drug 03', '22', '43', '946', '2');
INSERT INTO `quote_items` VALUES ('6', 'Test 01', '20', '10', '200', '3');
INSERT INTO `quote_items` VALUES ('7', 'Drug 01', '10.5', '13', '136.5', '4');
INSERT INTO `quote_items` VALUES ('8', 'Drug 02', '12.25', '25', '306.25', '4');

-- ----------------------------
-- Table structure for `quote_status`
-- ----------------------------
DROP TABLE IF EXISTS `quote_status`;
CREATE TABLE `quote_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of quote_status
-- ----------------------------
INSERT INTO `quote_status` VALUES ('1', 'Pending');
INSERT INTO `quote_status` VALUES ('2', 'Accepted');
INSERT INTO `quote_status` VALUES ('3', 'Declined');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(45) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_user_type_idx` (`user_type_id`),
  CONSTRAINT `fk_users_user_type` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Uditha Bandara', 'Peradeniya', '0755414368', '2023-09-21', 'udithabandara9@gmail.com', '01bdd802154001faf143846d3b145fcb', '1');
INSERT INTO `users` VALUES ('2', 'Uditha Bandara', 'Peradeniya', '0715727804', '2023-09-22', 'udithabandara9@gmail.com', '01bdd802154001faf143846d3b145fcb', '1');
INSERT INTO `users` VALUES ('3', 'Uditha', null, null, null, 'uditha@gmail.com', '01bdd802154001faf143846d3b145fcb', '2');
INSERT INTO `users` VALUES ('4', 'Uditha Bandara', 'Peradeniya', '0755414368', '2023-09-27', 'udithabandara90@gmail.com', '01bdd802154001faf143846d3b145fcb', '1');
INSERT INTO `users` VALUES ('5', 'Uditha Bandara', 'Peradeniya', '0755414368', '2023-09-28', 'udithabandara99@gmail.com', '01bdd802154001faf143846d3b145fcb', '1');
INSERT INTO `users` VALUES ('6', 'Nipuni Subasinghe', 'Kandy', '0701234567', '2023-09-29', 'nipuni@gmail.com', '01bdd802154001faf143846d3b145fcb', '1');
INSERT INTO `users` VALUES ('7', 'Waruna', 'Kandy', '0701234567', '2023-09-27', 'waruna@gmail.com', '01bdd802154001faf143846d3b145fcb', '1');

-- ----------------------------
-- Table structure for `user_type`
-- ----------------------------
DROP TABLE IF EXISTS `user_type`;
CREATE TABLE `user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_type
-- ----------------------------
INSERT INTO `user_type` VALUES ('1', 'User');
INSERT INTO `user_type` VALUES ('2', 'Pharmacy');
