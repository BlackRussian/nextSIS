-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.21 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for nextsis
DROP DATABASE IF EXISTS `nextsis`;
CREATE DATABASE IF NOT EXISTS `nextsis` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `nextsis`;

-- Dumping data for table nextsis.course_comments: ~0 rows (approximately)
DELETE FROM `course_comments`;
/*!40000 ALTER TABLE `course_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_comments` ENABLE KEYS */;

-- Dumping data for table nextsis.course_nonreport_grade: ~0 rows (approximately)
DELETE FROM `course_nonreport_grade`;
/*!40000 ALTER TABLE `course_nonreport_grade` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_nonreport_grade` ENABLE KEYS */;

-- Dumping data for table nextsis.grade_book: ~6 rows (approximately)
DELETE FROM `grade_book`;
/*!40000 ALTER TABLE `grade_book` DISABLE KEYS */;
INSERT INTO `grade_book` (`grade_id`, `grade_type_id`, `student_id`, `points`) VALUES
	(1, 1, 5, 1.00),
	(3, 2, 5, 2.00),
	(4, 2, 8, 4.50),
	(9, 1, 8, 6.00),
	(10, 5, 5, 5.00),
	(11, 5, 8, 8.00);
/*!40000 ALTER TABLE `grade_book` ENABLE KEYS */;

-- Dumping data for table nextsis.grade_type: ~3 rows (approximately)
DELETE FROM `grade_type`;
/*!40000 ALTER TABLE `grade_type` DISABLE KEYS */;
INSERT INTO `grade_type` (`grade_type_id`, `title`, `weight`, `term_course_id`) VALUES
	(1, 'Final Exam', 9.00, 1),
	(2, 'Term Mark', 2.00, 1),
	(5, 'Mid term exam', 5.00, 1);
/*!40000 ALTER TABLE `grade_type` ENABLE KEYS */;

-- Dumping data for table nextsis.language: ~8 rows (approximately)
DELETE FROM `language`;
/*!40000 ALTER TABLE `language` DISABLE KEYS */;
INSERT INTO `language` (`id`, `code`, `subtag`, `name`, `region`) VALUES
	(1, 'en', 'US', 'English', 'American'),
	(2, 'en', 'GB', 'English', 'British'),
	(3, 'ko', 'KR', 'Korean', NULL),
	(4, 'km', 'KH', 'Central Khmer', 'Cambodia'),
	(5, 'zh', 'CN', 'Chinese', 'China'),
	(6, 'es', 'ES', 'Spanish', 'Spain'),
	(7, 'fr', 'CA', 'French', 'Canada'),
	(8, 'ja', 'JP', 'Japanese', NULL);
/*!40000 ALTER TABLE `language` ENABLE KEYS */;

-- Dumping data for table nextsis.marking_period_id_generator: ~0 rows (approximately)
DELETE FROM `marking_period_id_generator`;
/*!40000 ALTER TABLE `marking_period_id_generator` DISABLE KEYS */;
/*!40000 ALTER TABLE `marking_period_id_generator` ENABLE KEYS */;

-- Dumping data for table nextsis.person: ~6 rows (approximately)
DELETE FROM `person`;
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
INSERT INTO `person` (`id`, `local_id`, `surname`, `first_name`, `middle_name`, `common_name`, `title_id`, `gender_id`, `username`, `password`, `default_schoolId`, `classId`) VALUES
	(5, 'NX-1', 'Smith', 'John', 'Andrew', 'Sprat', 4, 2, 'admin', 'c2ab1dbf445c7aafec65ee0d94ccd05d43e90a9a2b12e6bae8e32e924ba4a0245664350b0e8320a326faa38a93e5fbef36113bbbb72f0c4aa8b046c84c5a09b2', 1, NULL),
	(6, NULL, 'Case', 'Omarie', '', 'Mari', 4, 2, 'ocase', '3a615c4f2a19dd7cfe06b8044bb70d9103530f0be6b9b8993417e1a65131e8988c4cfeec12f1e3130b50a073798e97e966b64c68fdc1f9d93ce3a85b61b545cc', 1, NULL),
	(7, NULL, 'Hinds', 'Dayne', '', 'Datoni', 4, 2, 'Dayne.Hinds', 'e66c94380aaab8e7a7e6805212dcc99cb6be559752c278a53ccdec85909f8d214fdcf8a63445ad0c4b8604c9bf7107a9205f97e53cc196d6594061acdb364e26', 1, NULL),
	(8, NULL, 'Everett', 'Noel', NULL, NULL, 4, 2, 'Noel.Everett', 'sssss', 1, 1),
	(9, NULL, 'Dickson', 'Glenford', 'Big', 'Grimm', 1, 2, 'grimm', 'c2ab1dbf445c7aafec65ee0d94ccd05d43e90a9a2b12e6bae8e32e924ba4a0245664350b0e8320a326faa38a93e5fbef36113bbbb72f0c4aa8b046c84c5a09b2', 1, NULL),
	(22, NULL, 'Burchenson', 'Rory', '', '', 1, 2, 'rburche', '48c6ce76b326fbd101a9b2c0d3df476a9cd45d252bf0825f0a91951774ff37e7e5ed7ff66d38bcbc1050aee130432dcfac6f1f886886ba06aaf3fad3b782c1ba', 1, NULL);
/*!40000 ALTER TABLE `person` ENABLE KEYS */;

-- Dumping data for table nextsis.person_course: ~2 rows (approximately)
DELETE FROM `person_course`;
/*!40000 ALTER TABLE `person_course` DISABLE KEYS */;
INSERT INTO `person_course` (`person_id`, `term_course_id`) VALUES
	(5, 1),
	(8, 1);
/*!40000 ALTER TABLE `person_course` ENABLE KEYS */;

-- Dumping data for table nextsis.person_gender: ~2 rows (approximately)
DELETE FROM `person_gender`;
/*!40000 ALTER TABLE `person_gender` DISABLE KEYS */;
INSERT INTO `person_gender` (`id`, `language_id`, `label`) VALUES
	(1, 1, 'Female'),
	(2, 1, 'Male');
/*!40000 ALTER TABLE `person_gender` ENABLE KEYS */;

-- Dumping data for table nextsis.person_role: ~11 rows (approximately)
DELETE FROM `person_role`;
/*!40000 ALTER TABLE `person_role` DISABLE KEYS */;
INSERT INTO `person_role` (`person_id`, `role_id`, `school_id`) VALUES
	(5, 1, NULL),
	(5, 2, NULL),
	(5, 3, NULL),
	(6, 1, NULL),
	(6, 2, NULL),
	(6, 3, NULL),
	(6, 4, NULL),
	(7, 3, NULL),
	(9, 2, NULL),
	(22, 1, NULL),
	(22, 2, NULL);
/*!40000 ALTER TABLE `person_role` ENABLE KEYS */;

-- Dumping data for table nextsis.person_school: ~0 rows (approximately)
DELETE FROM `person_school`;
/*!40000 ALTER TABLE `person_school` DISABLE KEYS */;
/*!40000 ALTER TABLE `person_school` ENABLE KEYS */;

-- Dumping data for table nextsis.person_title: ~5 rows (approximately)
DELETE FROM `person_title`;
/*!40000 ALTER TABLE `person_title` DISABLE KEYS */;
INSERT INTO `person_title` (`id`, `language_id`, `label`) VALUES
	(1, 1, 'Dr.'),
	(2, 1, 'Miss'),
	(3, 1, 'Ms.'),
	(4, 1, 'Mr.'),
	(5, 1, 'Mrs.');
/*!40000 ALTER TABLE `person_title` ENABLE KEYS */;

-- Dumping data for table nextsis.profile_property: ~0 rows (approximately)
DELETE FROM `profile_property`;
/*!40000 ALTER TABLE `profile_property` DISABLE KEYS */;
/*!40000 ALTER TABLE `profile_property` ENABLE KEYS */;

-- Dumping data for table nextsis.rating_scale: ~0 rows (approximately)
DELETE FROM `rating_scale`;
/*!40000 ALTER TABLE `rating_scale` DISABLE KEYS */;
/*!40000 ALTER TABLE `rating_scale` ENABLE KEYS */;

-- Dumping data for table nextsis.role: ~4 rows (approximately)
DELETE FROM `role`;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` (`id`, `label`) VALUES
	(1, 'Administrator'),
	(4, 'Parent'),
	(3, 'Student'),
	(2, 'Teacher');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

-- Dumping data for table nextsis.school: ~2 rows (approximately)
DELETE FROM `school`;
/*!40000 ALTER TABLE `school` DISABLE KEYS */;
INSERT INTO `school` (`id`, `title`, `syear`, `address`, `city`, `state`, `phone`, `principal`, `www_address`, `anchor`, `email`, `schoolcol`, `reporting_gp_scale`) VALUES
	(1, 'Paul Bogle High School', 2014, NULL, NULL, NULL, NULL, NULL, NULL, 'pbhs', NULL, NULL, NULL),
	(2, 'Ferncourt High School', 2014, NULL, NULL, NULL, NULL, NULL, NULL, 'fhs', NULL, NULL, NULL);
/*!40000 ALTER TABLE `school` ENABLE KEYS */;

-- Dumping data for table nextsis.school_classes: ~2 rows (approximately)
DELETE FROM `school_classes`;
/*!40000 ALTER TABLE `school_classes` DISABLE KEYS */;
INSERT INTO `school_classes` (`id`, `school_id`, `title`, `schoolgradelevels_id`) VALUES
	(1, 1, '10P', 4),
	(2, 1, '10A', 2);
/*!40000 ALTER TABLE `school_classes` ENABLE KEYS */;

-- Dumping data for table nextsis.school_gradelevels: ~5 rows (approximately)
DELETE FROM `school_gradelevels`;
/*!40000 ALTER TABLE `school_gradelevels` DISABLE KEYS */;
INSERT INTO `school_gradelevels` (`id`, `school_id`, `title`, `next_grade_id`) VALUES
	(1, 1, 'Grade 7', 2),
	(2, 1, 'Grade 8', 3),
	(3, 1, 'Grade 9', 4),
	(4, 1, 'Grade 10', 5),
	(5, 1, 'Grade 11', NULL);
/*!40000 ALTER TABLE `school_gradelevels` ENABLE KEYS */;

-- Dumping data for table nextsis.school_periods: ~3 rows (approximately)
DELETE FROM `school_periods`;
/*!40000 ALTER TABLE `school_periods` DISABLE KEYS */;
INSERT INTO `school_periods` (`period_id`, `syear`, `school_id`, `sort_order`, `title`, `short_name`, `length`, `block`, `ignore_scheduling`, `attendance`, `rollover_id`, `start_time`, `end_time`) VALUES
	(11, 2014, 1, 1, 'First Period', 'FP', 60, NULL, NULL, NULL, NULL, '7:00 AM', '8:00AM'),
	(12, 2014, 1, 0, 'Second Period', 'P2', 60, NULL, '0', '1', NULL, '9:00 AM', '10:00 AM'),
	(13, 2014, 1, 2, 'Period 3', 'P3', 60, NULL, '0', '1', NULL, '10:00 AM', '11:00 AM');
/*!40000 ALTER TABLE `school_periods` ENABLE KEYS */;

-- Dumping data for table nextsis.school_quarter: 0 rows
DELETE FROM `school_quarter`;
/*!40000 ALTER TABLE `school_quarter` DISABLE KEYS */;
/*!40000 ALTER TABLE `school_quarter` ENABLE KEYS */;

-- Dumping data for table nextsis.school_semester: 0 rows
DELETE FROM `school_semester`;
/*!40000 ALTER TABLE `school_semester` DISABLE KEYS */;
/*!40000 ALTER TABLE `school_semester` ENABLE KEYS */;

-- Dumping data for table nextsis.school_year: ~0 rows (approximately)
DELETE FROM `school_year`;
/*!40000 ALTER TABLE `school_year` DISABLE KEYS */;
/*!40000 ALTER TABLE `school_year` ENABLE KEYS */;

-- Dumping data for table nextsis.student_profile_comment: ~0 rows (approximately)
DELETE FROM `student_profile_comment`;
/*!40000 ALTER TABLE `student_profile_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_profile_comment` ENABLE KEYS */;

-- Dumping data for table nextsis.student_report_profile: ~0 rows (approximately)
DELETE FROM `student_report_profile`;
/*!40000 ALTER TABLE `student_report_profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_report_profile` ENABLE KEYS */;

-- Dumping data for table nextsis.subject: ~4 rows (approximately)
DELETE FROM `subject`;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` (`subject_id`, `syear`, `school_id`, `short_name`, `title`) VALUES
	(1, 0, 1, 'ENG', 'English'),
	(2, 0, 1, 'MTH', 'Mathematics'),
	(3, 0, 2, 'GEO', 'Geographics'),
	(4, 0, 1, 'ESP', 'Spanish');
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;

-- Dumping data for table nextsis.subject_course: ~0 rows (approximately)
DELETE FROM `subject_course`;
/*!40000 ALTER TABLE `subject_course` DISABLE KEYS */;
INSERT INTO `subject_course` (`course_id`, `subject_id`, `syear`, `grade_level`, `title`, `short_name`) VALUES
	(1, 1, 2014, 1, 'English Language', 'ENG01');
/*!40000 ALTER TABLE `subject_course` ENABLE KEYS */;

-- Dumping data for table nextsis.term_course: ~0 rows (approximately)
DELETE FROM `term_course`;
/*!40000 ALTER TABLE `term_course` DISABLE KEYS */;
INSERT INTO `term_course` (`term_course_id`, `marking_period_id`, `mp`, `course_id`, `teacher_id`) VALUES
	(1, 1, NULL, 1, 9);
/*!40000 ALTER TABLE `term_course` ENABLE KEYS */;

-- Dumping data for table nextsis.term_old: ~2 rows (approximately)
DELETE FROM `term_old`;
/*!40000 ALTER TABLE `term_old` DISABLE KEYS */;
INSERT INTO `term_old` (`id`, `school_id`, `syear`, `title`, `startdate`, `enddate`, `schoolyear_id`) VALUES
	(1, 1, 2014, 'Xmas Term', '2014-09-01', '2014-12-01', NULL),
	(2, 1, 2014, 'Easter Term', '2015-01-01', '2015-03-01', NULL);
/*!40000 ALTER TABLE `term_old` ENABLE KEYS */;

-- Dumping data for table nextsis.udf_categories: ~1 rows (approximately)
DELETE FROM `udf_categories`;
/*!40000 ALTER TABLE `udf_categories` DISABLE KEYS */;
INSERT INTO `udf_categories` (`category_id`, `title`) VALUES
	(1, 'Person');
/*!40000 ALTER TABLE `udf_categories` ENABLE KEYS */;

-- Dumping data for table nextsis.udf_data: ~0 rows (approximately)
DELETE FROM `udf_data`;
/*!40000 ALTER TABLE `udf_data` DISABLE KEYS */;
INSERT INTO `udf_data` (`udf_data_id`, `udf_id`, `udf_value`, `fk_id`) VALUES
	(1, 3, 'dacoman', 22),
	(2, 1, 'Red', 22);
/*!40000 ALTER TABLE `udf_data` ENABLE KEYS */;

-- Dumping data for table nextsis.udf_definition: ~2 rows (approximately)
DELETE FROM `udf_definition`;
/*!40000 ALTER TABLE `udf_definition` DISABLE KEYS */;
INSERT INTO `udf_definition` (`udf_id`, `school_id`, `type`, `title`, `description`, `sort_order`, `select_options`, `category_id`, `validation`, `default_selection`, `hide`) VALUES
	(1, 1, 'select', 'House', 'House colors', 2, 'Blue\r\nRed\r\nGreen\r\nOrange', 1, 'required', '', 0),
	(3, 1, 'text', 'Alias', 'Test', 1, '', 1, 'required', '', 1);
/*!40000 ALTER TABLE `udf_definition` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
