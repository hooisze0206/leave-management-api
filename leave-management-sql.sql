-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               8.0.43 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for leave_management_system
CREATE DATABASE IF NOT EXISTS `leave_management_system` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `leave_management_system`;

-- Dumping structure for table leave_management_system.active_users
CREATE TABLE IF NOT EXISTS `active_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `password` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.active_users: ~3 rows (approximately)
INSERT INTO `active_users` (`id`, `user_id`, `password`) VALUES
	(24, 'admin', 'YWRtaW4='),
	(25, 'jessica', 'MTIzNDU2'),
	(26, 'sams', 'MTIzNDU2');

-- Dumping structure for table leave_management_system.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `connection` text COLLATE utf8mb4_general_ci NOT NULL,
  `queue` text COLLATE utf8mb4_general_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table leave_management_system.feedbacks
CREATE TABLE IF NOT EXISTS `feedbacks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `feedback_type` int NOT NULL,
  `feature` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `feedback` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.feedbacks: ~4 rows (approximately)
INSERT INTO `feedbacks` (`id`, `user_id`, `feedback_type`, `feature`, `feedback`, `created_date`, `status`) VALUES
	(20, 'jessica', 1, 'Leave Application', 'I hope the approval can speed up', '2025-08-05 13:33:19', 0),
	(21, 'jessica', 4, '3', 'Overall is good but the approval time need to speed up', '2025-08-05 13:33:22', 0),
	(22, 'jessica', 2, 'others', 'I found a bug regarding .....', '2025-08-05 13:33:25', 0),
	(23, 'jessica', 3, 'department', 'Can i know more about this?', '2025-08-05 13:33:27', 0);

-- Dumping structure for table leave_management_system.leave_balance
CREATE TABLE IF NOT EXISTS `leave_balance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `leave_type_id` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `leave_balance` int NOT NULL,
  `total_leave` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.leave_balance: ~18 rows (approximately)
INSERT INTO `leave_balance` (`id`, `user_id`, `leave_type_id`, `leave_balance`, `total_leave`) VALUES
	(52, '27', '1', 9, 14),
	(53, '27', '2', 9, 10),
	(54, '27', '3', 364, 365),
	(55, '28', '1', 13, 14),
	(56, '28', '2', 10, 10),
	(57, '28', '3', 365, 365),
	(58, '29', '1', 14, 14),
	(59, '29', '2', 10, 10),
	(60, '29', '3', 365, 365),
	(61, '30', '1', 14, 14),
	(62, '30', '2', 10, 10),
	(63, '30', '3', 365, 365),
	(64, '31', '1', 14, 14),
	(65, '31', '2', 10, 10),
	(66, '31', '3', 365, 365),
	(67, '32', '1', 14, 14),
	(68, '32', '2', 10, 10),
	(69, '32', '3', 365, 365);

-- Dumping structure for table leave_management_system.leave_request
CREATE TABLE IF NOT EXISTS `leave_request` (
  `id` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `leave_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `day` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `amount` int NOT NULL,
  `status` int NOT NULL,
  `current_progress` int NOT NULL,
  `request_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.leave_request: ~8 rows (approximately)
INSERT INTO `leave_request` (`id`, `user_id`, `leave_type`, `day`, `start_date`, `end_date`, `amount`, `status`, `current_progress`, `request_date`) VALUES
	('jessica188055', 'jessica', 'Annual Leave', 'All Day', '2023-09-26', '2023-09-26', 1, 1, 2, '2025-08-05 13:31:11'),
	('jessica233148', 'jessica', 'Annual Leave', 'All Day', '2023-09-20', '2023-09-20', 1, 1, 2, '2025-08-05 13:31:15'),
	('jessica240692', 'jessica', 'Unpaid Leave', 'All Day', '2023-09-14', '2023-09-14', 1, 1, 2, '2025-08-05 13:31:19'),
	('jessica384054', 'jessica', 'Annual Leave', 'All Day', '2025-08-18', '2025-08-18', 1, 1, 2, '2025-08-05 13:31:22'),
	('jessica438568', 'jessica', 'Annual Leave', 'All Day', '2025-08-25', '2025-08-25', 1, 2, 6, '2025-08-05 13:31:27'),
	('jessica640086', 'jessica', 'Annual Leave', 'All Day', '2023-09-12', '2023-09-12', 1, 1, 2, '2025-08-05 13:31:30'),
	('jessica793175', 'jessica', 'Sick Leave', 'All Day', '2023-09-11', '2023-09-11', 1, 1, 4, '2025-08-05 13:31:35'),
	('sams267700', 'sams', 'Annual Leave', 'All Day', '2023-09-12', '2023-09-12', 1, 1, 2, NULL);

-- Dumping structure for table leave_management_system.leave_request_status
CREATE TABLE IF NOT EXISTS `leave_request_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `leave_request_id` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `status_id` int NOT NULL,
  `updated_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.leave_request_status: ~22 rows (approximately)
INSERT INTO `leave_request_status` (`id`, `leave_request_id`, `status_id`, `updated_date`) VALUES
	(199, 'jessica640086', 1, '2025-08-05 13:31:45'),
	(200, 'jessica640086', 2, '2025-08-05 13:31:51'),
	(201, 'jessica793175', 1, '2025-08-05 13:31:56'),
	(202, 'jessica793175', 2, '2025-08-05 13:32:00'),
	(203, 'jessica240692', 1, '2025-08-05 13:32:04'),
	(204, 'jessica240692', 2, '2025-08-05 13:32:08'),
	(205, 'jessica233148', 1, '2025-08-05 13:32:12'),
	(206, 'jessica233148', 2, '2025-08-05 13:32:17'),
	(207, 'jessica188055', 1, '2025-08-05 13:32:21'),
	(208, 'jessica188055', 2, '2025-08-05 13:32:25'),
	(209, 'jessica793175', 3, '2025-08-05 13:32:30'),
	(210, 'jessica793175', 4, '2025-08-05 13:32:36'),
	(211, 'sams267700', 1, '2023-09-08 18:45:17'),
	(212, 'sams267700', 2, '2023-09-08 18:45:17'),
	(213, 'jessica384054', 1, '2025-08-05 13:32:40'),
	(214, 'jessica384054', 2, '2025-08-05 13:32:44'),
	(215, 'jessica438568', 1, '2025-08-05 13:32:51'),
	(216, 'jessica438568', 2, '2025-08-05 13:32:54'),
	(217, 'jessica438568', 3, '2025-08-05 13:32:59'),
	(218, 'jessica438568', 4, '2025-08-05 13:33:02'),
	(220, 'jessica438568', 5, '2025-08-05 13:33:05'),
	(221, 'jessica438568', 6, '2025-08-05 13:33:09');

-- Dumping structure for table leave_management_system.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.migrations: ~5 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2023_05_22_131814_create_user_details_table', 2);

-- Dumping structure for table leave_management_system.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table leave_management_system.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_general_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for procedure leave_management_system.sp_add_feedback_feature_request
DELIMITER //
CREATE PROCEDURE `sp_add_feedback_feature_request`(IN `user_id` VARCHAR(20), IN `feature` VARCHAR(100), IN `feedback` VARCHAR(500), IN `feedback_type` VARCHAR(30))
BEGIN
SET @feedbacktype_id = (SELECT ft.id FROM utils_feedback_type ft WHERE ft.feedback_type = feedback_type);

INSERT INTO feedbacks (user_id, feature, feedback, feedback_type) VALUES (user_id, feature, feedback, @feedbacktype_id);

END//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_add_leave_balance
DELIMITER //
CREATE PROCEDURE `sp_add_leave_balance`(IN `user_id` VARCHAR(20), IN `bal` VARCHAR(10), IN `type` VARCHAR(20))
BEGIN
SET @id := (SELECT ud.id FROM user_details ud WHERE ud.user_id = user_id);

INSERT INTO leave_balance (user_id, leave_type_id, leave_balance, total_leave) VALUES (@id, type, bal, bal);
END//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_add_leave_request
DELIMITER //
CREATE PROCEDURE `sp_add_leave_request`(IN `user_id` VARCHAR(20), IN `leave_type` VARCHAR(30), IN `leave_request_id` VARCHAR(20), IN `day` VARCHAR(20), IN `start_date` DATE, IN `end_date` DATE, IN `amount` INT)
BEGIN

SET @userid = (SELECT id from user_details ud where ud.user_id = user_id);

SET @leave_id = (SELECT id from utils_leave_type lt where lt.leave_type = leave_type);

SET @balance = (SELECT lb.leave_balance from leave_balance lb
left join 
utils_leave_type lt on lt.id = lb.leave_type_id
left join user_details ud on ud.id = lb.user_id
where ud.user_id = user_id and lt.leave_type = leave_type);

SET @new_balance = (@balance - amount);

INSERT INTO leave_request(id, user_id, leave_type, day, start_date, end_date, amount, status, current_progress) VALUES (leave_request_id, user_id, leave_type, day, start_date, end_date, amount, 1, 2);

INSERT INTO leave_request_status(leave_request_id, status_id) VALUES (leave_request_id, 1);
INSERT INTO leave_request_status(leave_request_id, status_id) VALUES (leave_request_id, 2);

UPDATE leave_balance lb 
SET lb.leave_balance = @new_balance
where lb.user_id = @userid and lb.leave_type_id = @leave_id;

END//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_add_new_department
DELIMITER //
CREATE PROCEDURE `sp_add_new_department`(IN `department` VARCHAR(50), IN `status` INT, IN `created_by` VARCHAR(20))
INSERT INTO utils_departments (department_name, status, created_by) VALUES (department, status, created_by)//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_add_new_employee
DELIMITER //
CREATE PROCEDURE `sp_add_new_employee`(IN `user_id` VARCHAR(20), IN `name` VARCHAR(100), IN `gender` VARCHAR(20), IN `email` VARCHAR(100), IN `phone` VARCHAR(30), IN `address` VARCHAR(1000), IN `department` VARCHAR(50), IN `position` VARCHAR(50), IN `user_role` VARCHAR(30), IN `status` VARCHAR(10), IN `created_by` VARCHAR(20), IN `pass` VARCHAR(50), IN `city` VARCHAR(30), IN `zip_code` VARCHAR(20))
BEGIN
SET @role_id := (SELECT ur.id FROM user_roles ur WHERE ur.roles = user_role);

INSERT INTO active_users (user_id, password) VALUES (user_id, pass);

INSERT INTO user_details (user_id, name, gender, email, phone, address, city, zip_code, department_id, position, user_roles_id, status, created_by) VALUES (user_id, name, gender, email, phone, address,city, zip_code, department, position, @role_id, status, created_by);


CALL sp_add_leave_balance (user_id, 14, 1);
CALL sp_add_leave_balance (user_id, 10, 2);
CALL sp_add_leave_balance (user_id, 365, 3);
END//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_get_all_pending_requested_leave
DELIMITER //
CREATE PROCEDURE `sp_get_all_pending_requested_leave`(IN `status` INT, IN `user` VARCHAR(30))
BEGIN
if (status = 2) THEN
SELECT lr.id, lr.user_id, lr.leave_type, lr.day, lr.start_date, lr.end_date, lr.amount, ls.status, ls.color FROM leave_request lr
LEFT JOIN utils_leave_status ls ON ls.id = lr.status
WHERE lr.current_progress = status
ORDER BY lr.start_date;

ELSEIF (status = 4) THEN
set @department = (select department_id from user_details ud where ud.user_id = user);

SELECT lr.id, lr.user_id, lr.leave_type, lr.day, lr.start_date, lr.end_date, lr.amount, ls.status, ls.color FROM leave_request lr
LEFT JOIN utils_leave_status ls ON ls.id = lr.status
left join user_details ud on ud.user_id = lr.user_id
WHERE lr.current_progress = status AND ud.department_id = @department
ORDER BY lr.start_date;
END IF;

END//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_get_all_requested_leave
DELIMITER //
CREATE PROCEDURE `sp_get_all_requested_leave`(IN `user` VARCHAR(20), IN `role` VARCHAR(20))
BEGIN

IF (role = 'Admin') THEN
SELECT lr.user_id, lr.leave_type, lr.day, lr.start_date, lr.end_date, lr.amount, ls.status, ls.color FROM leave_request lr
LEFT JOIN utils_leave_status ls ON ls.id = lr.status
ORDER BY lr.request_date;

ELSEIF (role = 'Manager') THEN
SET @department = (select department_id from user_details ud where ud.user_id = user);

SELECT lr.user_id, lr.leave_type, lr.day, lr.start_date, lr.end_date, lr.amount, ls.status, ls.color FROM leave_request lr
LEFT JOIN utils_leave_status ls ON ls.id = lr.status
LEFT JOIN user_details ud on ud.user_id = lr.user_id
where ud.department_id = @department
ORDER BY lr.request_date;
END IF;

END//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_get_all_requested_leave_report
DELIMITER //
CREATE PROCEDURE `sp_get_all_requested_leave_report`()
SELECT lr.user_id, lr.leave_type, lr.amount, lr.start_date, lr.end_date, ls.status
FROM user_details ud
left join leave_request lr ON lr.user_id = ud.user_id
left join utils_leave_status ls ON ls.id= lr.status
order by ud.user_id//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_get_annual_situation
DELIMITER //
CREATE PROCEDURE `sp_get_annual_situation`()
SELECT vw.user_id, YEAR(NOW()) as year, (vw.total_annual_leave - vw.annual_leave_balance) As annual_used, vw.annual_leave_balance, vw.total_annual_leave, (vw.total_sick_leave - vw.sick_leave_balance) As sick_used, vw.sick_leave_balance, vw.total_sick_leave,
(vw.total_unpaid_leave - vw.unpaid_leave_balance) as unpaid_used, vw.unpaid_leave_balance, vw.total_unpaid_leave from vw_leave_balance1 vw//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_get_feedback_by_status
DELIMITER //
CREATE PROCEDURE `sp_get_feedback_by_status`(IN `bool` VARCHAR(20))
BEGIN
SET @num = (SELECT CASE WHEN bool = 'true' THEN 1
ELSE 0
END AS num);

SELECT f.id, f.user_id, uf.feedback_type, f.feature, f.feedback, 
CASE WHEN f.status = 0 THEN 'Unread'
ELSE 'Read'
END AS status
FROM feedbacks f
left join utils_feedback_type uf ON uf.id =  f.feedback_type
where f.status = @num
ORDER BY f.id DESC;
END//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_get_feedback_by_user
DELIMITER //
CREATE PROCEDURE `sp_get_feedback_by_user`(IN `user` VARCHAR(20))
SELECT f.id, uf.feedback_type, f.feature, f.feedback FROM feedbacks f
left join utils_feedback_type uf 
ON uf.id =  f.feedback_type
WHERE user_id = user//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_get_holiday_and_leave
DELIMITER //
CREATE PROCEDURE `sp_get_holiday_and_leave`(IN `user` VARCHAR(20))
Select holiday as title, '1' as type, start_date as start, end_date as end, true as allDay 
from utils_holiday
UNION
SELECT leave_type as title, '2' as type, start_date as start, end_date as end, true as allDay 
FROM leave_request
where user_id = user AND status not in (3,4)//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_get_leave_information
DELIMITER //
CREATE PROCEDURE `sp_get_leave_information`(IN `user_id` VARCHAR(20))
SELECT * from vw_leave_balance1 lb WHERE lb.user_id = user_id//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_get_manager_details
DELIMITER //
CREATE PROCEDURE `sp_get_manager_details`(IN `user_id` VARCHAR(20))
BEGIN
SET @department = (SELECT ud.department_id
FROM user_details ud
where ud.user_id = user_id);

SELECT ud.name,ud.email from user_details ud where department_id = @department and user_roles_id = 3;
END//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_get_requested_leave
DELIMITER //
CREATE PROCEDURE `sp_get_requested_leave`(IN `user_id` VARCHAR(20))
SELECT lr.id, lr.user_id, lr.leave_type as title, '2' as type, lr.start_date as start, lr.end_date as end, lr.amount, ls.status, ls.color
FROM leave_request lr
LEFT JOIN utils_leave_status ls ON  ls.id = lr.status
where lr.user_id = user_id
order by request_date ASC//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_get_requested_leave_status
DELIMITER //
CREATE PROCEDURE `sp_get_requested_leave_status`(IN `leave_id` VARCHAR(20))
SELECT sta.leave_request_id, req.user_id, sta.updated_date, lg.status, req.amount,
CASE 
WHEN req.current_progress = sta.status_id THEN 'lightgreen'
ELSE 'lightgray' 
END AS color
FROM leave_request_status sta
LEFT JOIN leave_request req ON req.id = sta.leave_request_id
LEFT JOIN utils_leave_progress lg ON lg.id = sta.status_id
WHERE sta.leave_request_id = leave_id
ORDER BY sta.status_id//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_get_upcoming_holiday
DELIMITER //
CREATE PROCEDURE `sp_get_upcoming_holiday`(IN `user` VARCHAR(20))
Select holiday as title, '1' as type, start_date as start, end_date as end, true as allDay, '' as status, '' as status_color, '#A8DF8E' as type_color, amount
from utils_holiday 
where start_date <= (NOW() + INTERVAL 20 DAY) and start_date >= (NOW() - INTERVAL 1 DAY)
UNION
SELECT leave_type as title, '2' as type, start_date as start, end_date as end, true as allDay, ls.status as status, ls.color as status_color, '#75C2F6' as type_color, amount
FROM leave_request lr
left join utils_leave_status ls ON ls.id = lr.status
where start_date <= (NOW() + INTERVAL 20 DAY) and start_date >= (NOW() - INTERVAL 1 DAY) AND
user_id = user AND lr.status not in (3,4)
order by start//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_update_department
DELIMITER //
CREATE PROCEDURE `sp_update_department`(IN `department` VARCHAR(50), IN `status` INT, IN `update_by` VARCHAR(20))
UPDATE utils_departments
SET status = status,
updated_by = update_by
where department_name = department//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_update_leave_balance
DELIMITER //
CREATE PROCEDURE `sp_update_leave_balance`(IN `balance` INT, IN `user_id` VARCHAR(20), IN `leave_type` VARCHAR(30))
BEGIN

Update leave_balance lb 
set lb.leave_balance = balance
where lb.user_id = user_id and lb.leave_type_id = leave_type;

END//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_update_leave_request_status
DELIMITER //
CREATE PROCEDURE `sp_update_leave_request_status`(IN `user_id` VARCHAR(20), IN `leave_id` VARCHAR(20), IN `leave_type` VARCHAR(30), IN `amount` INT, IN `update_status` VARCHAR(20), IN `curr_action` VARCHAR(50))
BEGIN
set @status_id = (SELECT ls.id from utils_leave_status ls WHERE ls.status = update_status); 
set @user_id = (SELECT ud.id from user_details ud WHERE ud.user_id = user_id);
set @leave_type_id = (SELECT id from utils_leave_type lt WHERE lt.leave_type = leave_type);
set @curr_balance = (SELECT lb.leave_balance from leave_balance lb left join utils_leave_type lt on lt.id = lb.leave_type_id where lt.leave_type = leave_type and lb.user_id = @user_id);
 
IF (curr_action in ("Admin_Approved")) THEN 
set @current_progress = 4; set @add_progress = "3,4";
Update leave_request SET current_progress = @current_progress WHERE id = leave_id;
elseif(curr_action = "Manager_Approved") THEN 
set @status_id = 2;
set @current_progress = 6; set @add_progress = "5,6"; 
elseif(curr_action = "Rejected") THEN 
set @current_progress = 7; set @add_progress = 7; 
elseif(curr_action = "Cancelled") THEN 
set @current_progress = 8; set @add_progress = 8;
END IF; 

IF (curr_action IN ("Rejected", "Cancelled", "Manager_Approved")) THEN
     Update leave_request SET status = @status_id, current_progress = @current_progress WHERE id = leave_id;
END IF;

IF (curr_action IN ("Rejected", "Cancelled")) THEN
    set @new_bal = (CONVERT(@curr_balance, UNSIGNED INTEGER) + amount);
    CALL sp_update_leave_balance (@new_bal, @user_id, @leave_type_id);
END IF;

   
INSERT INTO leave_request_status(leave_request_id, status_id) 
SELECT leave_id, lp.id 
from utils_leave_progress lp 
WHERE FIND_IN_SET(lp.id, @add_progress);

END//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_update_user_detail
DELIMITER //
CREATE PROCEDURE `sp_update_user_detail`(IN `user_id` VARCHAR(20), IN `name` VARCHAR(100), IN `gender` VARCHAR(20), IN `email` VARCHAR(100), IN `phone` VARCHAR(30), IN `address` VARCHAR(1000), IN `department` VARCHAR(50), IN `position` VARCHAR(50), IN `user_role` VARCHAR(30), IN `status` VARCHAR(10), IN `update_by` VARCHAR(20), IN `city` VARCHAR(30), IN `zip_code` VARCHAR(20))
BEGIN
SET @role_id := (SELECT ur.id FROM user_roles ur WHERE ur.roles = user_role);

UPDATE user_details ud SET
user_id = user_id, name = name, gender = gender, email = email, phone = phone, address = address, city = city,
zip_code = zip_code, department_id = department, position = position, user_roles_id = @role_id, status = status, updated_by = update_by
where ud.user_id = user_id;

END//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_update_user_password
DELIMITER //
CREATE PROCEDURE `sp_update_user_password`(IN `user_id` VARCHAR(20), IN `pass` VARCHAR(30))
update active_users u
set u.password = pass
where u.user_id = user_id//
DELIMITER ;

-- Dumping structure for procedure leave_management_system.sp_user_login
DELIMITER //
CREATE PROCEDURE `sp_user_login`(IN `user_id` VARCHAR(20), IN `pass` VARCHAR(100))
BEGIN

SET @count = (SELECT COUNT(*) from active_users u where u.user_id = user_id and u.password = pass);


IF (@count >0) THEN
    SELECT ur.roles, ud.user_id, ud.name, ud.email FROM user_details ud 
    LEFT JOIN user_roles ur on ur.id = ud.user_roles_id
    WHERE ud.user_id = user_id;
END IF;

END//
DELIMITER ;

-- Dumping structure for table leave_management_system.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_by` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.users: ~1 rows (approximately)
INSERT INTO `users` (`id`, `user_id`, `email`, `password`, `created_by`, `updated_by`) VALUES
	(1, 'hooisze', 'hooisze0206@gmail.com', 'MTIzNDU2', 'hooisze', 'hooisze');

-- Dumping structure for table leave_management_system.user_details
CREATE TABLE IF NOT EXISTS `user_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `city` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `zip_code` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `department_id` int DEFAULT NULL,
  `position` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `user_roles_id` int NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_by` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `notified` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.user_details: ~7 rows (approximately)
INSERT INTO `user_details` (`id`, `user_id`, `name`, `gender`, `email`, `phone`, `address`, `city`, `zip_code`, `department_id`, `position`, `user_roles_id`, `start_date`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`, `notified`) VALUES
	(24, 'admin', 'Admin', '', 'justapply409@gmail.com', NULL, NULL, '', '', NULL, '', 1, NULL, 1, NULL, '2023-09-08 11:00:11', NULL, '2023-09-08 11:00:11', 0),
	(27, 'jessica', 'Jessica Hee', 'Female', 'jessica@gmail.com', '0123456789', '-', 'Kedah', '05200', 8, '1', 2, NULL, 1, 'jessica', '2025-08-05 05:30:08', NULL, '2025-08-05 05:30:08', 0),
	(28, 'sams', 'Sam Smith', 'Male', 'samsmith@gmail.com', '0123456788', 'Alor Setar', 'Alor Setar', '05200', 8, '18', 3, NULL, 1, 'jessica', '2025-08-05 05:30:12', NULL, '2025-08-05 05:30:12', 0),
	(29, 'john12', 'Johnny Lee', 'Male', 'john12@gmail.com', '0123456789', 'Alor Setar', 'Alor Setar', '05200', 2, '17', 3, NULL, 1, 'jessica', '2025-08-05 05:30:15', NULL, '2025-08-05 05:30:15', 0),
	(30, 'shelin', 'Sharleen Ethelston', 'Female', 'sethelston1@rediff.com', '0123456789', 'Alor Setar', 'Alor Setar', '05200', 5, '10', 3, NULL, 1, 'jessica', '2025-08-05 05:30:17', NULL, '2025-08-05 05:30:17', 0),
	(31, 'tadd', 'Tadd Farenden', 'Male', 'tfarenden3@engadget.com', '0123456789', 'Alor Setar', 'Alor Setar', '05200', 2, '4', 2, NULL, 1, 'jessica', '2025-08-05 05:30:19', NULL, '2025-08-05 05:30:19', 0),
	(32, 'randie', 'Randie Fritchly', 'Male', 'rfritchly6@tinyurl.com', '0123456789', 'Alor Setar', 'Alor Setar', '05200', 5, '13', 2, NULL, 1, 'jessica', '2025-08-05 05:30:21', NULL, '2025-08-05 05:30:21', 0);

-- Dumping structure for table leave_management_system.user_roles
CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `roles` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.user_roles: ~3 rows (approximately)
INSERT INTO `user_roles` (`id`, `roles`) VALUES
	(1, 'Admin'),
	(2, 'Employee'),
	(3, 'Manager');

-- Dumping structure for table leave_management_system.utils_departments
CREATE TABLE IF NOT EXISTS `utils_departments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `department_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `status` int NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `updated_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `color` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.utils_departments: ~9 rows (approximately)
INSERT INTO `utils_departments` (`id`, `department_name`, `start_date`, `status`, `created_date`, `created_by`, `updated_by`, `updated_date`, `color`) VALUES
	(1, 'Accounting', '2023-07-03', 1, '2025-08-05 05:33:50', 'jessica', '', '2025-08-05 05:33:50', '#A076F9'),
	(2, 'Engineering', '2023-07-03', 1, '2025-08-05 05:33:52', 'jessica', '', '2025-08-05 05:33:52', '#982176'),
	(3, 'Customer Support', '2023-07-03', 1, '2025-08-05 05:33:54', 'jessica', '', '2025-08-05 05:33:54', '#CD6688'),
	(4, 'Human Resource', '2023-07-03', 1, '2025-08-05 05:33:56', 'jessica', '', '2025-08-05 05:33:56', '#35A29F'),
	(5, 'Marketing', '2023-07-10', 1, '2025-08-05 05:33:58', 'jessica', '', '2025-08-05 05:33:58', '#78C1F3'),
	(6, 'Finance', '2023-07-10', 1, '2025-08-05 05:33:59', 'jessica', '', '2025-08-05 05:33:59', '#9BE8D8'),
	(7, 'Sales', '2023-08-14', 2, '2025-08-05 05:34:01', 'jessica', '', '2025-08-05 05:34:01', '#3F2E3E'),
	(8, 'Information Technology', '2023-08-14', 1, '2025-08-05 05:34:02', 'jessica', '', '2025-08-05 05:34:02', '#4A55A2'),
	(9, 'Customer Support', NULL, 2, '2025-08-05 05:34:04', 'jessica', '', '2025-08-05 05:34:04', '');

-- Dumping structure for table leave_management_system.utils_feedback_type
CREATE TABLE IF NOT EXISTS `utils_feedback_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `feedback_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.utils_feedback_type: ~5 rows (approximately)
INSERT INTO `utils_feedback_type` (`id`, `feedback_type`, `color`) VALUES
	(1, 'Feature Request', ''),
	(2, 'Bug Report', ''),
	(3, 'Inquiry', ''),
	(4, 'Reviews', ''),
	(5, 'Others', '');

-- Dumping structure for table leave_management_system.utils_holiday
CREATE TABLE IF NOT EXISTS `utils_holiday` (
  `id` int NOT NULL AUTO_INCREMENT,
  `holiday` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `amount` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.utils_holiday: ~7 rows (approximately)
INSERT INTO `utils_holiday` (`id`, `holiday`, `start_date`, `end_date`, `amount`) VALUES
	(1, 'Hari Raya Haji', '2023-06-30', '2023-06-30', 1),
	(2, 'Awal Muharram', '2023-07-19', '2023-07-19', 1),
	(3, 'Merdeka Day', '2023-08-31', '2023-08-31', 1),
	(4, 'Malaysia Day', '2023-09-16', '2023-09-16', 1),
	(5, 'Deepavali', '2023-11-13', '2023-11-13', 1),
	(6, 'Christmas Day', '2023-12-25', '2023-12-25', 1),
	(11, 'Malaysia Day Holiday', '2023-09-18', '2023-09-18', 1);

-- Dumping structure for table leave_management_system.utils_leave_progress
CREATE TABLE IF NOT EXISTS `utils_leave_progress` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.utils_leave_progress: ~8 rows (approximately)
INSERT INTO `utils_leave_progress` (`id`, `status`) VALUES
	(1, 'Leave Request Submitted'),
	(2, 'Awaiting Approval from Admin'),
	(3, 'Admin approved the request'),
	(4, 'Awaiting Approval from Manager'),
	(5, 'Manager Approved the request'),
	(6, 'Approved'),
	(7, 'Rejected'),
	(8, 'Cancelled');

-- Dumping structure for table leave_management_system.utils_leave_status
CREATE TABLE IF NOT EXISTS `utils_leave_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `color` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.utils_leave_status: ~4 rows (approximately)
INSERT INTO `utils_leave_status` (`id`, `status`, `color`) VALUES
	(1, 'Pending', '#E0E0E0'),
	(2, 'Approved', '#AFFF99'),
	(3, 'Rejected', '#FF8585'),
	(4, 'Cancelled', '#FF8585');

-- Dumping structure for table leave_management_system.utils_leave_type
CREATE TABLE IF NOT EXISTS `utils_leave_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `leave_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `total_leave` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.utils_leave_type: ~3 rows (approximately)
INSERT INTO `utils_leave_type` (`id`, `leave_type`, `total_leave`) VALUES
	(1, 'Annual Leave', 14),
	(2, 'Sick Leave', 10),
	(3, 'Unpaid Leave', 365);

-- Dumping structure for table leave_management_system.utils_position
CREATE TABLE IF NOT EXISTS `utils_position` (
  `id` int NOT NULL AUTO_INCREMENT,
  `position` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `department_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table leave_management_system.utils_position: ~18 rows (approximately)
INSERT INTO `utils_position` (`id`, `position`, `department_id`) VALUES
	(1, 'Software Engineer', 8),
	(2, 'Solution Architect', 8),
	(3, 'Frontend Developer', 8),
	(4, 'Test Engineer', 2),
	(5, 'Tech Lead', 8),
	(6, 'Account Assistant', 1),
	(7, 'Accountant Executive', 1),
	(8, 'Sales Executive', 7),
	(9, 'Sales Manager', 7),
	(10, 'Marketing Manager', 5),
	(11, 'Finance Manager', 6),
	(12, 'Finance Executive', 6),
	(13, 'Marketing Executive', 5),
	(14, 'Senior Advertising Consultant', 5),
	(15, 'HR Executive', 4),
	(16, 'Human Resources Manager', 4),
	(17, 'Engineering Manager', 2),
	(18, 'IT Manager', 8);

-- Dumping structure for view leave_management_system.vw_get_all_leaves
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_get_all_leaves` (
	`user_id` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_general_ci',
	`leave_type` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_general_ci',
	`amount` INT NOT NULL,
	`start_date` DATE NOT NULL,
	`end_date` DATE NOT NULL,
	`status` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci'
);

-- Dumping structure for view leave_management_system.vw_get_leave_info_by_dept
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_get_leave_info_by_dept` (
	`annual` BIGINT NULL,
	`sick` BIGINT NULL,
	`unpaid` BIGINT NULL,
	`department_name` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci'
);

-- Dumping structure for view leave_management_system.vw_get_leave_summary_by_dept
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_get_leave_summary_by_dept` (
	`count` BIGINT NOT NULL,
	`department_name` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci'
);

-- Dumping structure for view leave_management_system.vw_get_leave_summary_by_leave_type
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_get_leave_summary_by_leave_type` (
	`count` BIGINT NOT NULL,
	`leave_type` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_general_ci'
);

-- Dumping structure for view leave_management_system.vw_leave_balance1
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_leave_balance1` (
	`user_id` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`annual_leave_balance` BIGINT NULL,
	`total_annual_leave` BIGINT NULL,
	`sick_leave_balance` BIGINT NULL,
	`total_sick_leave` BIGINT NULL,
	`unpaid_leave_balance` BIGINT NULL,
	`total_unpaid_leave` BIGINT NULL
);

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_get_all_leaves`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_get_all_leaves` AS select `lr`.`user_id` AS `user_id`,`lr`.`leave_type` AS `leave_type`,`lr`.`amount` AS `amount`,`lr`.`start_date` AS `start_date`,`lr`.`end_date` AS `end_date`,`ls`.`status` AS `status` from ((`leave_request` `lr` left join `user_details` `ud` on((`lr`.`user_id` = `ud`.`user_id`))) left join `utils_leave_status` `ls` on((`ls`.`id` = `lr`.`status`))) order by `ud`.`user_id`
;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_get_leave_info_by_dept`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_get_leave_info_by_dept` AS select max((case when (`t`.`leave_type` = 'Annual Leave') then `t`.`count` else 0 end)) AS `annual`,max((case when (`t`.`leave_type` = 'Sick Leave') then `t`.`count` else 0 end)) AS `sick`,max((case when (`t`.`leave_type` = 'Unpaid Leave') then `t`.`count` else 0 end)) AS `unpaid`,`t`.`department_name` AS `department_name` from (select count(`lr`.`leave_type`) AS `count`,`lr`.`leave_type` AS `leave_type`,`dept`.`department_name` AS `department_name` from ((`leave_request` `lr` left join `user_details` `ud` on((`ud`.`user_id` = `lr`.`user_id`))) left join `utils_departments` `dept` on((`dept`.`id` = `ud`.`department_id`))) group by `lr`.`leave_type`,`ud`.`department_id` order by `ud`.`department_id`) `t` group by `t`.`department_name`
;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_get_leave_summary_by_dept`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_get_leave_summary_by_dept` AS select count(0) AS `count`,`dept`.`department_name` AS `department_name` from ((`leave_request` `lr` left join `user_details` `ud` on((`ud`.`user_id` = `lr`.`user_id`))) left join `utils_departments` `dept` on((`dept`.`id` = `ud`.`department_id`))) group by `ud`.`department_id`
;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_get_leave_summary_by_leave_type`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_get_leave_summary_by_leave_type` AS select count(0) AS `count`,`lr`.`leave_type` AS `leave_type` from `leave_request` `lr` group by `lr`.`leave_type`
;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_leave_balance1`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_leave_balance1` AS select `ud`.`user_id` AS `user_id`,max((case when (`lt`.`leave_type` = 'Annual Leave') then `lb`.`leave_balance` else 0 end)) AS `annual_leave_balance`,max((case when (`lt`.`leave_type` = 'Annual Leave') then `lb`.`total_leave` else 0 end)) AS `total_annual_leave`,max((case when (`lt`.`leave_type` = 'Sick Leave') then `lb`.`leave_balance` else 0 end)) AS `sick_leave_balance`,max((case when (`lt`.`leave_type` = 'Sick Leave') then `lb`.`total_leave` else 0 end)) AS `total_sick_leave`,max((case when (`lt`.`leave_type` = 'Unpaid Leave') then `lb`.`leave_balance` else 0 end)) AS `unpaid_leave_balance`,max((case when (`lt`.`leave_type` = 'Unpaid Leave') then `lb`.`total_leave` else 0 end)) AS `total_unpaid_leave` from ((`leave_balance` `lb` left join `utils_leave_type` `lt` on((`lt`.`id` = `lb`.`leave_type_id`))) left join `user_details` `ud` on((`ud`.`id` = `lb`.`user_id`))) group by `ud`.`user_id`
;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
