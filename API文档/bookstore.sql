-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017-04-11 12:19:49
-- 服务器版本: 5.5.53-0ubuntu0.14.04.1
-- PHP 版本: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `bookstore`
--

-- --------------------------------------------------------

--
-- 表的结构 `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `activity_id` int(10) unsigned zerofill NOT NULL,
  `activity_name` varchar(45) NOT NULL,
  `activity_starttime` varchar(45) NOT NULL,
  `activity_lasttime` varchar(45) NOT NULL,
  `activity_content` text NOT NULL,
  `activity_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `activity_message`
--

CREATE TABLE IF NOT EXISTS `activity_message` (
  `activity_message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity_message_content` varchar(45) NOT NULL,
  `activity_message_time` varchar(45) NOT NULL,
  `activity_message_reuser` int(11) DEFAULT NULL,
  `activity_id` int(10) unsigned zerofill NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`activity_message_id`),
  KEY `fk_activity_activity1_idx` (`activity_id`),
  KEY `fk_activity_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(45) NOT NULL,
  `admin_power` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `book`
--

CREATE TABLE IF NOT EXISTS `book` (
  `book_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_number` tinyint(4) NOT NULL COMMENT '商品数量',
  `book_content` varchar(255) NOT NULL,
  `book_name` varchar(45) NOT NULL,
  `book_state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0为上架状态,1为下架状态,2为已经卖光状态',
  `book_time` varchar(45) NOT NULL COMMENT '上架时间',
  `book_grade` varchar(45) DEFAULT NULL,
  `book_sys` varchar(45) DEFAULT NULL,
  `book_urls` varchar(255) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `book_buyerid` int(11) DEFAULT NULL COMMENT '购买者',
  `book_isdel` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'del默认为0，为1时表示已删除',
  `type_id` int(10) unsigned NOT NULL,
  `book_isname` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0为不匿名，1为匿名',
  `book_old` tinyint(4) NOT NULL DEFAULT '7',
  `book_author` varchar(15) NOT NULL DEFAULT '未知',
  `book_price` tinyint(4) NOT NULL DEFAULT '10',
  PRIMARY KEY (`book_id`),
  KEY `fk_book_user_idx` (`user_id`),
  KEY `fk_book_type1_idx` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `book`
--

INSERT INTO `book` (`book_id`, `book_number`, `book_content`, `book_name`, `book_state`, `book_time`, `book_grade`, `book_sys`, `book_urls`, `user_id`, `book_buyerid`, `book_isdel`, `type_id`, `book_isname`, `book_old`, `book_author`, `book_price`) VALUES
(1, 1, 'java程序设计大一下课程用书', 'java程序设计', 0, '1491481947', '2015', '电软系', 'jisuanji.jpg', 1, NULL, 0, 1, 0, 7, '未知', 10),
(2, 1, 'java大一下课程用书', 'java程序设计', 0, '1491481947', '2015', '电软系', 'jisuanji.jpg', 2, NULL, 0, 1, 0, 7, '未知', 10),
(3, 1, 'java大一下课程用书', 'java程序设计', 0, '1491481947', '2015', '电软系', 'jisuanji.jpg', 2, NULL, 0, 1, 0, 7, '未知', 10),
(4, 1, 'java大一下课程用书', 'java程序设计', 0, '1491481947', '2015', '电软系', 'jisuanji.jpg', 2, NULL, 0, 1, 0, 7, '未知', 10),
(5, 1, 'c语言大一下课程用书', 'c语言', 0, '1491481947', '2015', '电软系', 'jisuanji.jpg', 2, NULL, 0, 1, 0, 7, '未知', 10),
(6, 1, 'c++大一下课程用书', 'c++', 0, '1491481947', '2015', '电软系', 'jisuanji.jpg', 2, NULL, 0, 1, 0, 7, '未知', 10),
(7, 1, 'c++大一下课程用书', 'c++', 0, '1491481947', '2015', '电软系', 'jisuanji.jpg', 2, NULL, 0, 1, 0, 7, '未知', 10),
(8, 1, 'c++大一下课程用书', 'c++', 0, '1491481947', '2015', '电软系', 'jisuanji.jpg', 2, NULL, 0, 1, 0, 7, '未知', 10),
(9, 1, 'c++大一下课程用书', 'c++', 0, '1491481947', '2015', '电软系', 'jisuanji.jpg', 2, NULL, 0, 1, 0, 7, '未知', 10),
(10, 1, '312', '1231', 0, '1491481947', '2', '123', 'jisuanji.jpg', 1, NULL, 0, 1, 0, 7, '未知', 10),
(11, 1, '312', '1231', 0, '1491481947', '2', '123', 'jisuanji.jpg', 1, NULL, 0, 1, 0, 7, '未知', 10),
(12, 1, '312', '1231', 0, '1491481947', '2', '123', 'jisuanji.jpg', 1, NULL, 0, 1, 0, 7, '未知', 10);

-- --------------------------------------------------------

--
-- 表的结构 `code`
--

CREATE TABLE IF NOT EXISTS `code` (
  `code_id` int(11) NOT NULL AUTO_INCREMENT,
  `code_phone` varchar(11) COLLATE utf8_esperanto_ci NOT NULL,
  `code_time` int(11) NOT NULL,
  `code_code` int(11) NOT NULL,
  PRIMARY KEY (`code_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hole`
--

CREATE TABLE IF NOT EXISTS `hole` (
  `hole_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hole_message` varchar(255) NOT NULL,
  `hole_time` varchar(45) NOT NULL,
  `hole_url` varchar(100) DEFAULT NULL,
  `hole_anonymous` tinyint(4) NOT NULL DEFAULT '1' COMMENT '默认1匿名,0为不匿名',
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`hole_id`),
  KEY `fk_hole_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `holemessage`
--

CREATE TABLE IF NOT EXISTS `holemessage` (
  `holemessage_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `holemessage_reuser` int(11) DEFAULT NULL COMMENT '被回复人',
  `holemessage_user` int(11) NOT NULL COMMENT '回复人',
  `holemessage_time` varchar(45) NOT NULL,
  `holemessage_message` varchar(100) NOT NULL,
  `holemessage_anonymous` tinyint(4) NOT NULL,
  `hole_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`holemessage_id`),
  KEY `fk_holemessage_hole1_idx` (`hole_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message_content` varchar(60) NOT NULL,
  `message_time` varchar(45) NOT NULL,
  `book_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL COMMENT '回复人id',
  `reuser_id` int(11) DEFAULT NULL COMMENT '被回复人id',
  PRIMARY KEY (`message_id`),
  KEY `fk_message_book1_idx` (`book_id`),
  KEY `fk_message_user1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `message`
--

INSERT INTO `message` (`message_id`, `message_content`, `message_time`, `book_id`, `user_id`, `reuser_id`) VALUES
(1, '4354354', '4325354', 1, 1, NULL),
(2, '12412', '2342', 12, 2, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_time` varchar(45) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `book_id` int(10) unsigned NOT NULL,
  `order_remark` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `fk_order_user1_idx` (`user_id`),
  KEY `fk_order_book1_idx` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `type_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '书籍类别',
  `type_name` varchar(45) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `type`
--

INSERT INTO `type` (`type_id`, `type_name`) VALUES
(1, '计算机'),
(2, '经济管理'),
(3, '考试教育'),
(4, '人文社科'),
(5, '生活休闲'),
(6, '外语学习'),
(7, '文学艺术'),
(8, '医学'),
(9, '自然科学');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(18) NOT NULL,
  `user_cookie` varchar(255) DEFAULT NULL,
  `user_photo` varchar(45) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_integral` int(11) NOT NULL DEFAULT '0',
  `user_grade` varchar(10) DEFAULT NULL,
  `user_sys` varchar(20) DEFAULT NULL,
  `user_time` varchar(45) NOT NULL COMMENT '注册时间',
  `user_password` varchar(32) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_cookie`, `user_photo`, `user_phone`, `user_integral`, `user_grade`, `user_sys`, `user_time`, `user_password`) VALUES
(1, '大白菜', NULL, 'dabaicai.jpg', '13217554571', 0, NULL, NULL, '12312421', '123'),
(2, '小白菜', NULL, 'dabaicai.jpg', '13217554571', 0, NULL, NULL, '123', '123');

--
-- 限制导出的表
--

--
-- 限制表 `activity_message`
--
ALTER TABLE `activity_message`
  ADD CONSTRAINT `fk_activity_activity1` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_activity_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `fk_book_type1` FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_book_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `hole`
--
ALTER TABLE `hole`
  ADD CONSTRAINT `fk_hole_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `holemessage`
--
ALTER TABLE `holemessage`
  ADD CONSTRAINT `fk_holemessage_hole1` FOREIGN KEY (`hole_id`) REFERENCES `hole` (`hole_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_book1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_message_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_book1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_order_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
