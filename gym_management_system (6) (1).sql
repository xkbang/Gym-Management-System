-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-04-02 03:19:24
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `gym_management_system`
--

-- --------------------------------------------------------

--
-- 資料表結構 `coaches`
--

CREATE TABLE `coaches` (
  `coach_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `specialty` varchar(255) DEFAULT NULL,
  `identity_card_no` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 傾印資料表的資料 `coaches`
--

INSERT INTO `coaches` (`coach_id`, `first_name`, `last_name`, `email`, `phone`, `hire_date`, `specialty`, `identity_card_no`) VALUES
(1140001, 'Isabella', 'Anderson', 'isabella.anderson@example.com', '9012345678', '2024-05-15', 'Dance Fitness', '3799890935'),
(1140386, 'David', 'Brown', 'davidbrown@example.com', '666666666', '2020-03-01', 'Zumba', '8049899347'),
(1140387, 'Daniel', 'Brown', 'daniel.brown@example.com', '4567890123', '2023-12-15', 'Crossfit', '2574112892'),
(1141156, 'David', 'Davis', 'david.davis@example.com', '6789012345', '2024-02-10', 'Boxing', '3370840450'),
(1143466, 'Michael', 'Johnson', 'michaeljohnson@example.com', '444444444', '2020-01-01', 'Yoga', '8777722296'),
(1143467, 'Sarah', 'Johnson', 'sarah.johnson@example.com', '1234567890', '2023-09-15', 'Strength Training', '7619657486'),
(1144621, 'Sophia', 'Miller', 'sophia.miller@example.com', '7890123456', '2024-03-20', 'Zumba', '0198295265'),
(1146931, 'Michael', 'Smith', 'michael.smith@example.com', '2345678901', '2023-10-01', 'Yoga', '3948589697'),
(1147316, 'Olivia', 'Taylor', 'olivia.taylor@example.com', '5678901234', '2024-01-02', 'Cardio Kickboxing', '2218635764'),
(1147317, 'Aiden', 'Thomas', 'aiden.thomas@example.com', '0123456789', '2024-06-25', 'Tai Chi', '6362589128'),
(1148471, 'Sarah', 'Wilson', 'sarahwilson@example.com', '555555555', '2020-02-01', 'Pilates', '0876613185'),
(1148472, 'Jessica', 'Williams', 'jessica.williams@example.com', '3456789012', '2023-11-07', 'Pilates', '6883976335'),
(1148473, 'Ethan', 'Wilson', 'ethan.wilson@example.com', '8901234567', '2024-04-05', 'Functional Training', '0878955284');

--
-- 觸發器 `coaches`
--
DELIMITER $$
CREATE TRIGGER `before_insert_coach` BEFORE INSERT ON `coaches` FOR EACH ROW BEGIN
  DECLARE last_name_first_char CHAR(1);
  DECLARE last_name_count INT;
  SET last_name_first_char = UPPER(LEFT(NEW.last_name, 1));
  SET last_name_count = (SELECT COUNT(*) FROM Coaches WHERE last_name REGEXP CONCAT('^', last_name_first_char, '[A-Za-z]*$'));

  CASE last_name_first_char
    WHEN 'A' THEN SET NEW.coach_id = last_name_count + 1140001;
    WHEN 'B' THEN SET NEW.coach_id = last_name_count + 1140386;
    WHEN 'C' THEN SET NEW.coach_id = last_name_count + 1140771;
    WHEN 'D' THEN SET NEW.coach_id = last_name_count + 1141156;
    WHEN 'E' THEN SET NEW.coach_id = last_name_count + 1141541;
    WHEN 'F' THEN SET NEW.coach_id = last_name_count + 1141926;
    WHEN 'G' THEN SET NEW.coach_id = last_name_count + 1142311;
    WHEN 'H' THEN SET NEW.coach_id = last_name_count + 1142696;
    WHEN 'I' THEN SET NEW.coach_id = last_name_count + 1143081;
    WHEN 'J' THEN SET NEW.coach_id = last_name_count + 1143466;
    WHEN 'K' THEN SET NEW.coach_id = last_name_count + 1143851;
    WHEN 'L' THEN SET NEW.coach_id = last_name_count + 1144236;
    WHEN 'M' THEN SET NEW.coach_id = last_name_count + 1144621;
    WHEN 'N' THEN SET NEW.coach_id = last_name_count + 1145006;
    WHEN 'O' THEN SET NEW.coach_id = last_name_count + 1145391;
    WHEN 'P' THEN SET NEW.coach_id = last_name_count + 1145776;
    WHEN 'Q' THEN SET NEW.coach_id = last_name_count + 1146161;
    WHEN 'R' THEN SET NEW.coach_id = last_name_count + 1146546;
    WHEN 'S' THEN SET NEW.coach_id = last_name_count + 1146931;
    WHEN 'T' THEN SET NEW.coach_id = last_name_count + 1147316;
    WHEN 'U' THEN SET NEW.coach_id = last_name_count + 1147701;
    WHEN 'V' THEN SET NEW.coach_id = last_name_count + 1148086;
    WHEN 'W' THEN SET NEW.coach_id = last_name_count + 1148471;
    WHEN 'X' THEN SET NEW.coach_id = last_name_count + 1148856;
    WHEN 'Y' THEN SET NEW.coach_id = last_name_count + 1149241;
    WHEN 'Z' THEN SET NEW.coach_id = last_name_count + 1149626;
    ELSE SET NEW.coach_id = last_name_count + 1140000; -- Default case if the first letter is not A-Z
  END CASE;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 資料表結構 `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `course_time` varchar(255) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 傾印資料表的資料 `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_time`, `capacity`, `coach_id`, `member_id`) VALUES
(1, 'Yoga Basics', 'Monday 18:00-19:30', 20, 1140386, 2241156),
(2, 'Cardio Kickboxing', 'Tuesday 19:30-21:00', 15, 1140387, 2241157),
(3, 'Pilates Fusion', 'Wednesday 09:00-10:30', 12, 1141156, 2242696),
(4, 'Strength Training', 'Thursday 17:00-18:30', 18, 1143466, 2242696),
(5, 'Zumba Fitness', 'Friday 18:30-20:00', 25, 1143467, 2243466),
(6, 'Functional Training', 'Saturday 10:00-11:30', 20, 1144621, 2243851),
(7, 'Dance Cardio', 'Sunday 11:30-13:00', 15, 1146931, 2244621),
(8, 'Boxing', 'Monday 19:00-20:30', 15, 1147316, 2246931),
(9, 'Tai Chi for Beginners', 'Thursday 09:30-11:00', 12, 1147317, 2247316),
(10, 'Cycling HIIT', 'Saturday 09:00-10:30', 18, 1148471, 2248471),
(11, 'Yoga Class', 'Sunday 10:00-11:30', 20, 1148472, 2248472),
(12, 'Pilates Class', 'Friday 14:00-15:30', 15, 1148473, 2242696),
(13, 'Zumba Class', 'Monday 18:00-19:30', 25, 1146931, 2242311),
(14, 'Yoga Basics', 'Thursday 14:00-15:30', 20, 1148471, 2242696),
(1, 'Yoga Basics', 'Monday 18:00-19:30', 20, 1140386, 2247317),
(2, 'Cardio Kickboxing', 'Tuesday 19:30-21:00', 15, 1140387, 2247317),
(3, 'Pilates Fusion', 'Wednesday 09:00-10:30', 12, 1141156, 2247317),
(4, 'Strength Training', 'Thursday 17:00-18:30', 18, 1143466, 2247317),
(5, 'Zumba Fitness', 'Friday 18:30-20:00', 25, 1143467, 2247317),
(6, 'Functional Training', 'Saturday 10:00-11:30', 20, 1144621, 2247317),
(7, 'Dance Cardio', 'Sunday 11:30-13:00', 15, 1146931, 2247317);

-- --------------------------------------------------------

--
-- 資料表結構 `equipment`
--

CREATE TABLE `equipment` (
  `equipment_id` int(11) NOT NULL,
  `equipment_name` varchar(255) DEFAULT NULL,
  `equipment_type` varchar(255) DEFAULT NULL,
  `maintenance_history` date DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 傾印資料表的資料 `equipment`
--

INSERT INTO `equipment` (`equipment_id`, `equipment_name`, `equipment_type`, `maintenance_history`, `purchase_date`, `staff_id`) VALUES
(1, 'Treadmill', 'Cardio', '2023-11-10', '2021-01-01', 3340001),
(2, 'Dumbbells', 'Strength', '2022-07-21', '2021-02-01', 3340386),
(3, 'Yoga Mats', 'Functional', '2022-08-31', '2021-03-01', 3341156),
(4, 'Treadmill', 'Cardio', '2023-12-05', '2022-02-15', 3340001),
(5, 'Dumbbells Set', 'Strength', '2024-01-10', '2023-03-20', 3340386),
(6, 'Elliptical Machine', 'Cardio', '2023-11-20', '2022-05-10', 3341157),
(7, 'Barbell Set', 'Strength', '2024-02-15', '2023-07-05', 3343466),
(8, 'Kettlebell Set', 'Strength', '2024-02-28', '2023-02-25', 3341156),
(9, 'Stair Climberxxxx', 'Cardio', '2023-08-20', '2022-04-05', 3346931),
(10, 'Resistance Bands Set1', 'Strength', '2024-01-20', '2023-06-15', 3346932),
(11, 'Stationary Bike', 'Cardio', '2023-10-25', '2022-09-18', 3344621),
(12, 'Weight Bench', 'Strength', '2024-03-05', '2023-11-30', 3341156);

-- --------------------------------------------------------

--
-- 資料表結構 `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `membership_status` varchar(255) DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `medical_conditions` varchar(255) DEFAULT NULL,
  `membership_duration` int(11) DEFAULT NULL,
  `identity_card_no` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `members`
--

INSERT INTO `members` (`member_id`, `first_name`, `last_name`, `phone`, `membership_status`, `registration_date`, `address`, `emergency_contact`, `email`, `date_of_birth`, `medical_conditions`, `membership_duration`, `identity_card_no`) VALUES
(2240001, 'Daniel', 'Vincent', '777888999', 'Active', '2022-08-01', '789 Elm Avenue', 'Emily Anderson', 'danielanderson@example.com', '1991-04-12', 'Allergies', 12, '9870123456'),
(2240002, 'xkbang', 'aaaaa', '65818302', 'active', '2024-01-04', 'Hong Kong', 'None', 'tangfamily@gmail.com', '2004-10-09', 'None', 6, '55555555555'),
(2241156, 'John', 'Doe', '123456789', 'Active', '2022-01-01', '123 Main Street', 'Jane Doe', 'johndoe@example.com', '1990-01-01', 'None', 12, '1234567890'),
(2241157, 'Emma', 'Davis', '999888777', 'Active', '2022-06-01', '789 Oak Avenue', 'Oliver Davis', 'emmadavis@example.com', '1996-11-10', 'None', 6, '7890123456'),
(2242311, 'Ethan', 'Garcia', '666777888', 'Active', '2022-10-01', '456 Maple Avenue', 'Olivia Garcia', 'ethangarcia@example.com', '1997-06-18', 'Asthma', 12, '9870123456'),
(2242696, 'Sunny', 'Hung', '92761158', 'Active', '2024-03-29', '10 Lo Ping Road JCSQ', 'Jack Hung', 'sunnyhung666@gmail.com', '2004-09-25', 'None', 36, '0123456789'),
(2243466, 'Mike', 'Johnson', '555555555', 'Inactive', '2022-03-01', '789 Oak Avenue', 'Sarah Johnson', 'mikejohnson@example.com', '1995-09-20', 'None', 3, '9876543210'),
(2243851, 'Emily', 'Kay', '555666777', 'Active', '2022-11-01', '789 Oak Avenue', 'John Kay', 'emilykay@example.com', '1994-03-12', 'None', 12, '9876543210'),
(2244621, 'Sophia', 'Martin', '222444555', 'Active', '2022-09-01', '123 Pine Street', 'Michael Martin', 'sophiamartin@example.com', '1993-12-20', 'None', 9, '7896541230'),
(2246931, 'Alice', 'Smith', '987654321', 'Active', '2022-02-01', '456 Elm Street', 'Bob Smith', 'alicesmith@example.com', '1985-05-10', 'Asthma', 6, '0987654321'),
(2247316, 'David', 'Thompson', '555444333', 'Active', '2022-05-01', '567 Maple Avenue', 'Jennifer Thompson', 'davidthompson@example.com', '1988-03-25', 'Diabetes', 12, '6543210987'),
(2247317, 'Vincent', 'Tang', '95483535', 'active', '2024-03-01', 'None', 'xkbang', 's11458020@s.eduhk.hk', '2004-10-09', 'None', 6, '1111111111'),
(2247318, 'test1234', 'test1234', '24697830', 'active', '2024-01-04', 'Hong Kong', 'test1', 'tang@gmail.com', '0000-00-00', 'test1', 6, '34870901'),
(2248471, 'Sarah', 'Wilson', '777777777', 'Active', '2022-04-01', '321 Pine Street', 'Michael Wilson', 'sarahwilson@example.com', '1992-07-15', 'None', 9, '1472583690'),
(2248472, 'Olivia', 'Wilson', '444333222', 'Active', '2022-07-01', '246 Oak Street', 'Sophia Wilson', 'oliviawilson@example.com', '1994-09-08', 'None', 12, '2109876543'),
(2249241, 'Wong', 'Yan', '65818302', 'active', '2024-01-04', 'Hong Kong', 'None', 'stevenwong5539@gmail.com', '2004-10-09', 'None', 6, '55555555555');

--
-- 觸發器 `members`
--
DELIMITER $$
CREATE TRIGGER `before_insert_member` BEFORE INSERT ON `members` FOR EACH ROW BEGIN
  DECLARE last_name_first_char CHAR(1);
  DECLARE last_name_count INT;
  DECLARE new_member_id INT;
  SET last_name_first_char = UPPER(LEFT(NEW.last_name, 1));
  SET last_name_count = (SELECT COUNT(*) FROM Members WHERE last_name REGEXP CONCAT('^', last_name_first_char, '[A-Za-z]*$'));

  CASE last_name_first_char
    WHEN 'A' THEN SET new_member_id = last_name_count + 2240001;
    WHEN 'B' THEN SET new_member_id = last_name_count + 2240386;
    WHEN 'C' THEN SET new_member_id = last_name_count + 2240771;
    WHEN 'D' THEN SET new_member_id = last_name_count + 2241156;
    WHEN 'E' THEN SET new_member_id = last_name_count + 2241541;
    WHEN 'F' THEN SET new_member_id = last_name_count + 2241926;
    WHEN 'G' THEN SET new_member_id = last_name_count + 2242311;
    WHEN 'H' THEN SET new_member_id = last_name_count + 2242696;
    WHEN 'I' THEN SET new_member_id = last_name_count + 2243081;
    WHEN 'J' THEN SET new_member_id = last_name_count + 2243466;
    WHEN 'K' THEN SET new_member_id = last_name_count + 2243851;
    WHEN 'L' THEN SET new_member_id = last_name_count + 2244236;
    WHEN 'M' THEN SET new_member_id = last_name_count + 2244621;
    WHEN 'N' THEN SET new_member_id = last_name_count + 2245006;
    WHEN 'O' THEN SET new_member_id = last_name_count + 2245391;
    WHEN 'P' THEN SET new_member_id = last_name_count + 2245776;
    WHEN 'Q' THEN SET new_member_id = last_name_count + 2246161;
    WHEN 'R' THEN SET new_member_id = last_name_count + 2246546;
    WHEN 'S' THEN SET new_member_id = last_name_count + 2246931;
    WHEN 'T' THEN SET new_member_id = last_name_count + 2247316;
    WHEN 'U' THEN SET new_member_id = last_name_count + 2247701;
    WHEN 'V' THEN SET new_member_id = last_name_count + 2248086;
    WHEN 'W' THEN SET new_member_id = last_name_count + 2248471;
    WHEN 'X' THEN SET new_member_id = last_name_count + 2248856;
    WHEN 'Y' THEN SET new_member_id = last_name_count + 2249241;
    WHEN 'Z' THEN SET new_member_id = last_name_count + 2249626;
  END CASE;

  -- Check if the generated member_id already exists in the table
  WHILE (SELECT COUNT(*) FROM Members WHERE member_id = new_member_id) > 0 DO
    SET new_member_id = new_member_id + 1;
  END WHILE;

  SET NEW.member_id = new_member_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 資料表結構 `members_attendance`
--

CREATE TABLE `members_attendance` (
  `attendance_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `attendance_date` date DEFAULT NULL,
  `attendance_type` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 傾印資料表的資料 `members_attendance`
--

INSERT INTO `members_attendance` (`attendance_id`, `member_id`, `attendance_date`, `attendance_type`, `rating`, `comments`, `duration`) VALUES
(1, 2241156, '2024-02-29', 'Check-in', 4, 'Good workout!', '3'),
(2, 2241157, '2024-03-09', 'Check-in', 5, 'Excellent session!', '3'),
(3, 2242311, '2024-03-10', 'Check-in', 3, 'Average workout', '3'),
(4, 2242696, '2024-01-29', 'Check-in', 4, 'Feeling energized!', '3'),
(5, 2243466, '2023-01-29', 'Check-in', 5, 'Great workout!', '3'),
(6, 2243851, '2023-05-29', 'Check-in', 3, 'Decent session', '3'),
(7, 2244621, '2023-09-25', 'Check-in', 4, 'Enjoyed the workout', '3'),
(8, 2247316, '2023-07-21', 'Check-in', 5, 'Awesome session!', '3'),
(9, 2248471, '2023-08-31', 'Check-in', 3, 'Good effort', '3'),
(10, 2246931, '2023-06-30', 'Check-in', 4, 'Productive workout', '3'),
(11, 2241156, '2022-01-01', 'Check-in', 4, 'Great workout!', '1'),
(12, 2241156, '2022-01-02', 'Check-in', 4, 'Enjoyed the session', '0.45'),
(13, 2241157, '2022-01-01', 'Check-in', 3, 'Nice instructor', '1'),
(18, 2247317, '2024-03-02', 'Check-in', 3, 'Great', '1'),
(18, 2247317, '2024-03-04', 'Check-in', 3, 'Great', '1'),
(18, 2247317, '2024-03-05', 'Check-in', 3, 'Great', '1'),
(18, 2247317, '2024-03-06', 'Check-in', 3, 'Great', '1'),
(18, 2247317, '2024-03-07', 'Check-in', 3, 'Great', '1'),
(18, 2247317, '2024-04-01', 'Check-in', 3, 'Great', '3');

-- --------------------------------------------------------

--
-- 資料表結構 `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 傾印資料表的資料 `payment`
--

INSERT INTO `payment` (`payment_id`, `member_id`, `amount`, `payment_date`, `payment_method`) VALUES
(1, 2241156, 599.00, '2024-03-01', 'Credit Card'),
(2, 2241157, 750.00, '2024-03-05', 'Cash'),
(3, 2242311, 1000.00, '2024-03-10', 'Debit Card'),
(4, 2242696, 699.00, '2024-03-15', 'Credit Card'),
(5, 2243466, 899.00, '2024-03-20', 'Cash'),
(6, 2243851, 999.00, '2024-03-25', 'Debit Card'),
(7, 2244621, 799.00, '2024-03-30', 'Credit Card'),
(8, 2246931, 599.00, '2024-04-02', 'Cash'),
(9, 2247316, 1000.00, '2024-04-05', 'Debit Card'),
(10, 2248471, 699.00, '2024-04-10', 'Credit Card'),
(11, 2241156, 49.99, '2022-01-15', 'Credit Card'),
(12, 2241156, 29.99, '2022-02-15', 'Credit Card'),
(13, 2241157, 39.99, '2022-03-15', 'PayPal'),
(14, 2247317, 599.00, '2024-03-30', 'Credit Card');

-- --------------------------------------------------------

--
-- 資料表結構 `promotion`
--

CREATE TABLE `promotion` (
  `promotion_id` int(11) NOT NULL,
  `promotion_name` varchar(255) DEFAULT NULL,
  `promotion_description` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `last_modified` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 傾印資料表的資料 `promotion`
--

INSERT INTO `promotion` (`promotion_id`, `promotion_name`, `promotion_description`, `start_date`, `end_date`, `course_id`, `staff_id`, `last_modified`) VALUES
(1, 'New Year Special', 'Get 20% off on all memberships!', '2024-01-01', '2024-01-31', 1, 3340001, '3346932'),
(2, 'Summer Fitness Deal', 'Join now and receive a free personal training session.', '2024-06-01', '2024-08-31', 10, 3340386, '3346932'),
(3, 'Holiday Wellness Offer', 'Enjoy discounted rates on spa services.', '2024-12-01', '2024-12-31', 3, 3341156, '3346932'),
(4, 'New Year Special', 'Get 20% off on all courses', '2024-01-01', '2024-01-31', 11, 3341157, '3346932'),
(5, 'Summer Fitness Sale', 'Enjoy discounted rates on selected courses', '2024-06-01', '2024-06-30', 11, 3343466, '3346932'),
(6, 'Refer a Friend', 'Refer a friend and get a free month of yoga course', '2024-02-15', '2024-12-31', 11, 3343467, '3346932'),
(7, 'Holiday Package', 'Sign up for 3 courses and get the 4th course free', '2024-12-01', '2024-12-31', 10, 3344621, '3346932'),
(9, 'Group Discount33333', 'Get 10% off when you sign up as a group of 5 or more to join any courses', '2024-04-01', '2024-04-30', 10, 3346932, '3340001'),
(11, 'Corporate Wellness Program', 'Customized fitness programs for corporate employees', '2024-01-01', '2024-12-31', 13, 3347317, '3346932'),
(12, 'Holiday Membership Special', 'Limited-time discounted rates on annual boxing plan', '2024-11-01', '2024-12-31', 8, 3348471, '3346932'),
(13, 'Loyalty Rewards', 'Earn points for every class attended and redeem for exciting rewards', '2024-01-01', '2024-12-31', 7, 3348472, '3346932'),
(16, 'test4', 'test4', '2024-03-02', '2024-03-10', 10, 3346932, '3340001');

-- --------------------------------------------------------

--
-- 資料表結構 `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `identity_card_no` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 傾印資料表的資料 `staff`
--

INSERT INTO `staff` (`staff_id`, `first_name`, `last_name`, `email`, `phone`, `hire_date`, `identity_card_no`) VALUES
(3340001, 'Isabella', 'Anderson', 'isabella.anderson@example.com', '95483535', '2024-05-15', '4602372138'),
(3340386, 'Daniel', 'Brown', 'daniel.brown@example.com', '65432109', '2023-12-15', '2081368492'),
(3341156, 'David', 'Davis', 'david.davis@example.com', '43210987', '2024-02-10', '6599726357'),
(3341157, 'Emily', 'Davis', 'emilydavis@example.com', '333333333', '2021-03-01', '6754526613'),
(3343466, 'Emily', 'Johnson', 'emily.johnson@example.com', '98765432', '2023-09-15', '3973454305'),
(3343467, 'Robert', 'Johnson', 'robertjohnson@example.com', '222222222', '2021-02-01', '9603691994'),
(3344621, 'Sophia', 'Miller', 'sophia.miller@example.com', '32109876', '2024-03-20', '6098097363'),
(3346931, 'Michael', 'Smith', 'michael.smith@example.com', '87654321', '2023-10-01', '1679411140'),
(3346932, 'Jane', 'Smith', 'janesmith@example.com', '111111111', '2021-01-01', '0102763921'),
(3347316, 'Olivia', 'Taylor', 'olivia.taylor@example.com', '54321098', '2024-01-02', '5475586490'),
(3347317, 'Aiden', 'Thomas', 'aiden.thomas@example.com', '09876543', '2024-06-25', '7069640995'),
(3348471, 'Jessica', 'Williams', 'jessica.williams@example.com', '76543210', '2023-11-07', '8921445812'),
(3348472, 'Ethan', 'Wilson', 'ethan.wilson@example.com', '21098765', '2024-04-05', '3398306382');

--
-- 觸發器 `staff`
--
DELIMITER $$
CREATE TRIGGER `before_insert_staff` BEFORE INSERT ON `staff` FOR EACH ROW BEGIN
  DECLARE last_name_first_char CHAR(1);
  DECLARE last_name_count INT;
  SET last_name_first_char = UPPER(LEFT(NEW.last_name, 1));
  SET last_name_count = (SELECT COUNT(*) FROM Staff WHERE last_name REGEXP CONCAT('^', last_name_first_char, '[A-Za-z]*$'));
  
  CASE last_name_first_char
    WHEN 'A' THEN SET NEW.staff_id = last_name_count + 3340001;
    WHEN 'B' THEN SET NEW.staff_id = last_name_count + 3340386;
    WHEN 'C' THEN SET NEW.staff_id = last_name_count + 3340771;
    WHEN 'D' THEN SET NEW.staff_id = last_name_count + 3341156;
    WHEN 'E' THEN SET NEW.staff_id = last_name_count + 3341541;
    WHEN 'F' THEN SET NEW.staff_id = last_name_count + 3341926;
    WHEN 'G' THEN SET NEW.staff_id = last_name_count + 3342311;
    WHEN 'H' THEN SET NEW.staff_id = last_name_count + 3342696;
    WHEN 'I' THEN SET NEW.staff_id = last_name_count + 3343081;
    WHEN 'J' THEN SET NEW.staff_id = last_name_count + 3343466;
    WHEN 'K' THEN SET NEW.staff_id = last_name_count + 3343851;
    WHEN 'L' THEN SET NEW.staff_id = last_name_count + 3344236;
    WHEN 'M' THEN SET NEW.staff_id = last_name_count + 3344621;
    WHEN 'N' THEN SET NEW.staff_id = last_name_count + 3345006;
    WHEN 'O' THEN SET NEW.staff_id = last_name_count + 3345391;
    WHEN 'P' THEN SET NEW.staff_id = last_name_count + 3345776;
    WHEN 'Q' THEN SET NEW.staff_id = last_name_count + 3346161;
    WHEN 'R' THEN SET NEW.staff_id = last_name_count + 3346546;
    WHEN 'S' THEN SET NEW.staff_id = last_name_count + 3346931;
    WHEN 'T' THEN SET NEW.staff_id = last_name_count + 3347316;
    WHEN 'U' THEN SET NEW.staff_id = last_name_count + 3347701;
    WHEN 'V' THEN SET NEW.staff_id = last_name_count + 3348086;
    WHEN 'W' THEN SET NEW.staff_id = last_name_count + 3348471;
    WHEN 'X' THEN SET NEW.staff_id = last_name_count + 3348856;
    WHEN 'Y' THEN SET NEW.staff_id = last_name_count + 3349241;
    WHEN 'Z' THEN SET NEW.staff_id = last_name_count + 3349626;
    ELSE SET NEW.staff_id = last_name_count + 3340000; -- Default case if the first letter is not A-Z
  END CASE;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 資料表結構 `supplement`
--

CREATE TABLE `supplement` (
  `supplement_id` int(11) NOT NULL,
  `item` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 傾印資料表的資料 `supplement`
--

INSERT INTO `supplement` (`supplement_id`, `item`, `price`, `description`, `member_id`) VALUES
(1, 'Protein Powder', 29.99, 'Whey protein isolate', 2241156),
(2, 'Multivitamin', 12.99, 'Daily essential nutrients', 2241156),
(3, 'Fish Oil', 9.99, 'Omega-3 fatty acids', 2242311),
(11, 'Protein Powder', 29.99, 'High-quality protein supplement for muscle recovery and growth', 2241156),
(12, 'Pre-Workout', 39.99, 'Enhances energy, focus, and performance during workouts', 2242311),
(13, 'Branched-Chain Amino Acids (BCAAs)', 24.99, 'Supports muscle recovery and reduces muscle fatigue', 2242696),
(14, 'Creatine Monohydrate', 19.99, 'Improves strength, power, and muscle mass', 2243466),
(15, 'Fish Oil', 14.99, 'Provides omega-3 fatty acids for heart and joint health', 2243851),
(16, 'Multivitamin', 24.99, 'Provides essential vitamins and minerals for overall health', 2244621),
(17, 'Glutamine', 19.99, 'Aids in muscle recovery and reduces muscle soreness', 2246931),
(18, 'Whey Protein Bars', 2.49, 'Convenient protein snack for on-the-go nutrition', 2247316),
(19, 'Fat Burner', 49.99, 'Supports fat loss and boosts metabolism', 2248471),
(20, 'Joint Support', 29.99, 'Promotes joint health and flexibility', 2248472),
(17, 'Glutamine', 19.99, 'Aids in muscle recovery and reduces muscle soreness', 2247317),
(16, 'Multivitamin', 24.99, 'Provides essential vitamins and minerals for overall health', 2247317),
(18, 'Whey Protein Bars', 2.49, 'Convenient protein snack for on-the-go nutrition', 2247317),
(19, 'Fat Burner', 49.99, 'Supports fat loss and boosts metabolism', 2247317),
(20, 'Joint Support', 29.99, 'Promotes joint health and flexibility', 2247317);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `coaches`
--
ALTER TABLE `coaches`
  ADD PRIMARY KEY (`coach_id`);

--
-- 資料表索引 `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`equipment_id`);

--
-- 資料表索引 `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`);

--
-- 資料表索引 `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`promotion_id`);

--
-- 資料表索引 `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `coaches`
--
ALTER TABLE `coaches`
  MODIFY `coach_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1148474;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `equipment`
--
ALTER TABLE `equipment`
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2249242;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `promotion`
--
ALTER TABLE `promotion`
  MODIFY `promotion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3348473;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
