/*
Navicat MySQL Data Transfer

Source Server         : erp
Source Server Version : 100424
Source Host           : localhost:3306
Source Database       : feedback_core

Target Server Type    : MYSQL
Target Server Version : 100424
File Encoding         : 65001

Date: 2023-02-08 14:32:47
*/

SET
FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for queues
-- ----------------------------
DROP TABLE IF EXISTS `queues`;
CREATE TABLE `queues`
(
    `id`          int(11) NOT NULL AUTO_INCREMENT,
    `channel`     varchar(255) DEFAULT NULL,
    `job`         blob NOT NULL,
    `pushed_at`   int(11) NOT NULL,
    `ttr`         int(11) NOT NULL,
    `delay`       int(11) NOT NULL,
    `priority`    int(11) unsigned NOT NULL DEFAULT 1024,
    `reserved_at` int(11) DEFAULT NULL,
    `attempt`     int(11) DEFAULT NULL,
    `done_at`     int(11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY           `channel` (`channel`),
    KEY           `reserved_at` (`reserved_at`),
    KEY           `priority` (`priority`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for queues
-- ----------------------------
DROP TABLE IF EXISTS `queue_create_tenants`;
CREATE TABLE `queue_create_tenants`
(
    `id`          int(11) NOT NULL AUTO_INCREMENT,
    `channel`     varchar(255) DEFAULT NULL,
    `job`         blob NOT NULL,
    `pushed_at`   int(11) NOT NULL,
    `ttr`         int(11) NOT NULL,
    `delay`       int(11) NOT NULL,
    `priority`    int(11) unsigned NOT NULL DEFAULT 1024,
    `reserved_at` int(11) DEFAULT NULL,
    `attempt`     int(11) DEFAULT NULL,
    `done_at`     int(11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY           `channel` (`channel`),
    KEY           `reserved_at` (`reserved_at`),
    KEY           `priority` (`priority`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4;