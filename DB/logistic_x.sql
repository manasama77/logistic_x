/*
 Navicat Premium Data Transfer

 Source Server         : MySql Local
 Source Server Type    : MySQL
 Source Server Version : 100421
 Source Host           : localhost:3306
 Source Schema         : logistic_x

 Target Server Type    : MySQL
 Target Server Version : 100421
 File Encoding         : 65001

 Date: 16/09/2022 21:27:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for x_admins
-- ----------------------------
DROP TABLE IF EXISTS `x_admins`;
CREATE TABLE `x_admins`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `role` enum('Staff','Admin','IT','SVP','Asmen','Manager','Purchasing','HRD','General Manager','Owner') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `division_id` bigint UNSIGNED NULL DEFAULT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `forgot_password_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `cookies` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of x_admins
-- ----------------------------
INSERT INTO `x_admins` VALUES (1, 'admin', '$2y$10$3VFXbyD2VJbmDEWppM1dd.gBm8fJBnBn7vn1W46C2Ze1tZ7poUCDu', 'adam.pm77@gmail.com', 'Adam Ganteng', 'Admin', '082114578976', 1, 'yes', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', '2021-06-06 00:35:15', '2022-09-14 21:19:56', NULL, NULL, 1, NULL);
INSERT INTO `x_admins` VALUES (2, 'Test', '$2y$10$Drft/stRJ7/bUYkf5Fu1Vevg/ST3dCLTXFSlzYFNo7znVXsNwTRqO', 'test@gmail.com', 'test', 'Staff', '082114578976', 1, 'yes', NULL, NULL, NULL, NULL, '2022-08-26 01:32:49', '2022-08-26 01:40:50', '2022-08-26 01:40:50', 1, 1, 1);
INSERT INTO `x_admins` VALUES (3, 'test', '$2y$10$N7f7bHU9LLF60nYeSZtdnuOwcI7y6pV49T1cNBts8DTj3zLORT3iq', 'test@gmail.com', 'test', 'Staff', 'test', 1, 'no', NULL, NULL, NULL, NULL, '2022-08-26 01:41:57', '2022-08-26 01:49:58', NULL, 1, 1, NULL);

-- ----------------------------
-- Table structure for x_categories
-- ----------------------------
DROP TABLE IF EXISTS `x_categories`;
CREATE TABLE `x_categories`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of x_categories
-- ----------------------------
INSERT INTO `x_categories` VALUES (1, 'Peralatan Kantor');
INSERT INTO `x_categories` VALUES (2, 'Elektronik');

-- ----------------------------
-- Table structure for x_divisions
-- ----------------------------
DROP TABLE IF EXISTS `x_divisions`;
CREATE TABLE `x_divisions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of x_divisions
-- ----------------------------
INSERT INTO `x_divisions` VALUES (1, 'Gudang');

-- ----------------------------
-- Table structure for x_items
-- ----------------------------
DROP TABLE IF EXISTS `x_items`;
CREATE TABLE `x_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `merk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `qty` int NOT NULL,
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `unit_id` bigint UNSIGNED NOT NULL,
  `location_id` bigint UNSIGNED NOT NULL,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of x_items
-- ----------------------------
INSERT INTO `x_items` VALUES (1, '123456789', 'Lorem ipsum dolor sit amet.', 'test', 0, '1a2878e4e94512d587ba6a29b9ee684d.jpg', 1, 3, 1, 1, '2022-08-28 00:38:58', '2022-08-28 01:05:48', NULL, 1, 1, NULL);
INSERT INTO `x_items` VALUES (2, '1234567890', 'test', 'test', 0, '', 2, 1, 1, 1, '2022-08-28 01:06:18', '2022-08-28 01:06:32', NULL, 1, 1, NULL);

-- ----------------------------
-- Table structure for x_locations
-- ----------------------------
DROP TABLE IF EXISTS `x_locations`;
CREATE TABLE `x_locations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `shelf_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of x_locations
-- ----------------------------
INSERT INTO `x_locations` VALUES (1, 'Gudang 1', '#1');

-- ----------------------------
-- Table structure for x_stock_in_request_items
-- ----------------------------
DROP TABLE IF EXISTS `x_stock_in_request_items`;
CREATE TABLE `x_stock_in_request_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `stock_in_request_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `qty_request` bigint UNSIGNED NOT NULL,
  `qty_receive` bigint UNSIGNED NOT NULL,
  `datetime_receive` datetime NULL DEFAULT NULL,
  `state_item` enum('Menunggu','Terima','Tolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of x_stock_in_request_items
-- ----------------------------
INSERT INTO `x_stock_in_request_items` VALUES (3, 1, 1, 101, 101, '2022-09-14 02:30:00', 'Terima', NULL, '2022-09-13 20:35:13', '2022-09-13 20:35:13', NULL, 1, 1, NULL);
INSERT INTO `x_stock_in_request_items` VALUES (7, 2, 1, 500, 0, NULL, 'Menunggu', NULL, '2022-09-14 21:22:37', '2022-09-14 21:22:37', NULL, 1, 1, NULL);

-- ----------------------------
-- Table structure for x_stock_in_request_sequences
-- ----------------------------
DROP TABLE IF EXISTS `x_stock_in_request_sequences`;
CREATE TABLE `x_stock_in_request_sequences`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code_date` date NOT NULL,
  `seq` bigint UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of x_stock_in_request_sequences
-- ----------------------------
INSERT INTO `x_stock_in_request_sequences` VALUES (1, '2022-09-12', 1);
INSERT INTO `x_stock_in_request_sequences` VALUES (2, '2022-09-14', 1);

-- ----------------------------
-- Table structure for x_stock_in_requests
-- ----------------------------
DROP TABLE IF EXISTS `x_stock_in_requests`;
CREATE TABLE `x_stock_in_requests`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `request_datetime` datetime NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_po` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_do` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `state` enum('Menunggu','Proses','Tolak','Partial','Selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of x_stock_in_requests
-- ----------------------------
INSERT INTO `x_stock_in_requests` VALUES (1, '2022-09-12 15:42:00', 'IN-20220912-0001', '123', '456', 'Selesai', 'test 1', '2022-09-12 15:42:45', '2022-09-13 20:35:13', NULL, 1, 1, NULL);
INSERT INTO `x_stock_in_requests` VALUES (2, '2022-09-14 21:20:00', 'IN-20220914-0001', NULL, NULL, 'Menunggu', 'test', '2022-09-14 21:20:51', '2022-09-14 21:22:37', NULL, 1, 1, NULL);

-- ----------------------------
-- Table structure for x_suppliers
-- ----------------------------
DROP TABLE IF EXISTS `x_suppliers`;
CREATE TABLE `x_suppliers`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_active` enum('Aktif','Tidak Aktif') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of x_suppliers
-- ----------------------------
INSERT INTO `x_suppliers` VALUES (1, '123456789', 'Supplier 1', '08123456789', 'supplier1@gmail.com', 'Aktif');
INSERT INTO `x_suppliers` VALUES (2, '123456789', 'Supplier 2', '08123456789', 'supplier2@gmail.com', 'Aktif');
INSERT INTO `x_suppliers` VALUES (4, '123456789', 'Supplier 3', '08123456789', 'supplier3@gmail.com', 'Aktif');

-- ----------------------------
-- Table structure for x_units
-- ----------------------------
DROP TABLE IF EXISTS `x_units`;
CREATE TABLE `x_units`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of x_units
-- ----------------------------
INSERT INTO `x_units` VALUES (1, 'Cm');
INSERT INTO `x_units` VALUES (2, 'M');
INSERT INTO `x_units` VALUES (3, 'Pcs');

SET FOREIGN_KEY_CHECKS = 1;
