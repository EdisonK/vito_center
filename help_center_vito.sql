/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50505
 Source Host           : localhost
 Source Database       : help_center_vito

 Target Server Type    : MySQL
 Target Server Version : 50505
 File Encoding         : utf-8

 Date: 03/12/2018 14:01:20 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `admin_users`
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) CHARACTER SET utf8 NOT NULL COMMENT '姓名',
  `username` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '登录名',
  `password` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT '用户登录密码md5加密',
  `rand_code` int(11) NOT NULL COMMENT '登录密码随机的四位数',
  `email` varchar(32) CHARACTER SET utf8 DEFAULT NULL COMMENT '用户的email',
  `phone` varchar(16) CHARACTER SET utf8 NOT NULL COMMENT '手机号码',
  `create_at` datetime NOT NULL,
  `from` int(11) NOT NULL COMMENT '来自哪里，1表示自己注册',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `admin_users`
-- ----------------------------
BEGIN;
INSERT INTO `admin_users` VALUES ('2', '管理员', 'admin', 'de16a8ade11bf729a3080097d95d6bc1', '9604', 'zhd@thinkerx.com', '15895348728', '2018-02-01 19:48:50', '1');
COMMIT;

-- ----------------------------
--  Table structure for `category`
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(16) NOT NULL COMMENT '问题类别',
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '同表的父级id',
  `product_id` int(11) NOT NULL COMMENT '产品的id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `category`
-- ----------------------------
BEGIN;
INSERT INTO `category` VALUES ('1', '产品1的类别1', '0', '1'), ('2', '产品1的类别2', '1', '1'), ('3', '产品1的类别3', '0', '1'), ('4', '产品1的类别2的子类1', '1', '1'), ('5', '产品1的类别2的子类2', '2', '1'), ('6', '产品1的类别2的子类1', '4', '1'), ('7', '产品1的类别1的子类4', '1', '1');
COMMIT;

-- ----------------------------
--  Table structure for `products`
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL COMMENT '产品名称',
  `image_url` varchar(100) DEFAULT NULL COMMENT '图标地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `products`
-- ----------------------------
BEGIN;
INSERT INTO `products` VALUES ('1', '产品1', null), ('2', '产品2', null), ('3', '产品3', null), ('4', '产品4', null);
COMMIT;

-- ----------------------------
--  Table structure for `questions`
-- ----------------------------
DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL COMMENT '类别id',
  `title` varchar(512) NOT NULL,
  `answer` longtext,
  `logo` varchar(256) DEFAULT NULL,
  `vedio_url` varchar(512) DEFAULT NULL,
  `good` int(11) NOT NULL DEFAULT '0' COMMENT '赞的数量',
  `bad` int(11) NOT NULL DEFAULT '0' COMMENT '坏的数量',
  `is_show` int(4) NOT NULL DEFAULT '1' COMMENT '表示是否显示，0表示不显示，1表示显示',
  `z_index` int(11) NOT NULL DEFAULT '0' COMMENT '排序规则',
  `is_comm` int(11) NOT NULL DEFAULT '0' COMMENT '该问题是否是常见问题',
  `views` int(11) NOT NULL DEFAULT '0' COMMENT '查看的数量',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `questions`
-- ----------------------------
BEGIN;
INSERT INTO `questions` VALUES ('1', '1', '问题名称1', '问题答案1', null, null, '2', '1', '1', '0', '0', '3', '2018-02-05 11:01:36', null), ('2', '3', '问题名称2', '问题答案2', null, null, '0', '0', '1', '0', '0', '0', '2018-02-05 14:05:44', null), ('3', '2', '问题名称3', '问题答案3', null, null, '0', '0', '1', '0', '1', '0', '2018-02-05 14:06:08', null), ('4', '1', '问题名称4', '问题答案4', null, null, '0', '0', '1', '0', '1', '0', '2018-02-05 14:06:33', null), ('5', '1', '问题名称5', '问题答案5', null, null, '0', '0', '1', '1', '0', '0', '2018-02-05 14:07:11', null), ('6', '5', '问题名称6', '问题答案6', null, null, '0', '0', '1', '2', '0', '0', '2018-02-05 14:12:20', null);
COMMIT;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) CHARACTER SET utf8 NOT NULL COMMENT '姓名',
  `username` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '登录名',
  `password` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT '用户登录密码md5加密',
  `rand_code` int(11) NOT NULL COMMENT '登录密码随机的四位数',
  `email` varchar(32) CHARACTER SET utf8 DEFAULT NULL COMMENT '用户的email',
  `phone` varchar(16) CHARACTER SET utf8 NOT NULL COMMENT '手机号码',
  `create_at` datetime NOT NULL,
  `from` int(11) NOT NULL COMMENT '来自哪里，1表示自己注册，2表示来自生态圈转跳',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', '维托柯里昂', 'vito', 'aeb4244c3579aaf830baef5fb67f8412', '5080', 'zhd@thinkerx.com', '15895348728', '2018-02-01 15:24:30', '1'), ('2', '维托柯里昂', 'vito2', '3d209f5124e3775e7971a1fe8b929ce1', '7503', 'zhd@thinkerx.com', '15895348728', '2018-02-06 09:56:22', '1');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
