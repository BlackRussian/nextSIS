/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

USE `A987074_nextsisdemo`;


-- Dumping structure for table nextsis.course_comments
CREATE TABLE IF NOT EXISTS `course_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) unsigned NOT NULL,
  `course_id` mediumint(8) unsigned NOT NULL,
  `comment_id` int(11) NOT NULL,
  `conduct_id` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_course_comments_person` (`student_id`),
  KEY `FK_course_comments_subject_course` (`course_id`),
  CONSTRAINT `FK_course_comments_person` FOREIGN KEY (`student_id`) REFERENCES `person` (`id`),
  CONSTRAINT `FK_course_comments_subject_course` FOREIGN KEY (`course_id`) REFERENCES `subject_course` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table nextsis.course_nonreport_grade
CREATE TABLE IF NOT EXISTS `course_nonreport_grade` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` mediumint(8) unsigned NOT NULL,
  `gradetype_id` mediumint(8) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `grade_title` varchar(75) NOT NULL,
  `grade` decimal(3,2) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_course_nonreport_grade_subject_course` (`course_id`),
  KEY `FK_course_nonreport_grade_person` (`student_id`),
  CONSTRAINT `FK_course_nonreport_grade_person` FOREIGN KEY (`student_id`) REFERENCES `person` (`id`),
  CONSTRAINT `FK_course_nonreport_grade_subject_course` FOREIGN KEY (`course_id`) REFERENCES `subject_course` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table nextsis.grade_book
CREATE TABLE IF NOT EXISTS `grade_book` (
  `grade_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `grade_type_id` mediumint(8) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `points` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`grade_id`),
  KEY `FK_grade_book_person` (`student_id`),
  KEY `FK_grade_book_grade_type` (`grade_type_id`),
  CONSTRAINT `FK_grade_book_grade_type` FOREIGN KEY (`grade_type_id`) REFERENCES `grade_type` (`grade_type_id`),
  CONSTRAINT `FK_grade_book_person` FOREIGN KEY (`student_id`) REFERENCES `person` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table nextsis.grade_type
CREATE TABLE IF NOT EXISTS `grade_type` (
  `grade_type_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `weight` decimal(6,2) DEFAULT NULL,
  `term_course_id` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`grade_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table nextsis.language
CREATE TABLE IF NOT EXISTS `language` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The language primary key (0-65,535).',
  `code` varchar(2) DEFAULT NULL COMMENT 'ISO 639-1 language codes.',
  `subtag` varchar(10) NOT NULL COMMENT 'Tags as defined by IETF BCP 47.',
  `name` varchar(40) NOT NULL COMMENT 'The name of the language.',
  `region` varchar(40) DEFAULT NULL COMMENT 'The region (country or area) spoken in if applicable.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `subtag` (`subtag`),
  UNIQUE KEY `description` (`name`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Language list table.';

-- Data exporting was unselected.


-- Dumping structure for view nextsis.marking_period
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `marking_period` (
	`marking_period_id` MEDIUMINT(9) NOT NULL,
	`syear` INT(11) NULL,
	`school_id` MEDIUMINT(9) NULL,
	`mp_type` VARCHAR(8) NOT NULL COLLATE 'utf8_general_ci',
	`title` VARCHAR(50) NULL COLLATE 'utf8_unicode_ci',
	`short_name` VARCHAR(10) NULL COLLATE 'utf8_unicode_ci',
	`parent_id` BIGINT(20) NULL,
	`grandparent_id` BIGINT(20) NULL,
	`start_date` DATE NULL,
	`end_date` DATE NULL,
	`post_start_date` DATE NULL,
	`post_end_date` DATE NULL
) ENGINE=InnoDB;


-- Dumping structure for table nextsis.marking_period_id_generator
CREATE TABLE IF NOT EXISTS `marking_period_id_generator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table nextsis.person
CREATE TABLE IF NOT EXISTS `person` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key (4,294,967,295 possible values). This can serve as a public or internal identifier.',
  `local_id` varchar(20) DEFAULT NULL,
  `surname` varchar(60) DEFAULT NULL COMMENT 'The surname of the person.',
  `first_name` varchar(40) DEFAULT NULL COMMENT 'This stores the first name of the person.',
  `middle_name` varchar(40) DEFAULT NULL COMMENT 'This is to store a person''s middle name.',
  `common_name` varchar(40) DEFAULT NULL COMMENT 'The name the person is commonly known by.',
  `title_id` smallint(5) unsigned NOT NULL COMMENT 'Foreign key from person_title table.',
  `gender_id` smallint(3) unsigned NOT NULL COMMENT 'Foreign key from the person_gender table.',
  `username` varchar(80) NOT NULL COMMENT 'The person''s nextSIS username.',
  `password` varchar(252) NOT NULL COMMENT 'The person''s nextSIS password (encrypted).',
  `default_schoolId` mediumint(9) DEFAULT NULL,
  `classId` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `local_id` (`local_id`),
  KEY `surname` (`surname`),
  KEY `first_name` (`first_name`),
  KEY `title_id` (`title_id`),
  KEY `gender_id` (`gender_id`),
  CONSTRAINT `person_ibfk_1` FOREIGN KEY (`title_id`) REFERENCES `person_title` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `person_ibfk_2` FOREIGN KEY (`gender_id`) REFERENCES `person_gender` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Person table (stores all people - students, staff, parents, administrators...)';

-- Data exporting was unselected.


-- Dumping structure for table nextsis.person_course
CREATE TABLE IF NOT EXISTS `person_course` (
  `person_id` int(8) unsigned NOT NULL COMMENT 'Foreign key from the person table.',
  `term_course_id` int(11) NOT NULL COMMENT 'Foreign key form the course table.',
  PRIMARY KEY (`person_id`,`term_course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Link table between person and course for many-to-many.';

-- Data exporting was unselected.


-- Dumping structure for table nextsis.person_gender
CREATE TABLE IF NOT EXISTS `person_gender` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key (0-65,535).',
  `language_id` smallint(5) unsigned NOT NULL COMMENT 'The primary key from the language table.',
  `label` varchar(40) NOT NULL COMMENT 'The gender of a person.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `label` (`label`),
  KEY `language_id` (`language_id`),
  CONSTRAINT `person_gender_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='A person''s gender.';

-- Data exporting was unselected.


-- Dumping structure for table nextsis.person_role
CREATE TABLE IF NOT EXISTS `person_role` (
  `person_id` int(10) unsigned NOT NULL COMMENT 'Foreign key from the person table.',
  `role_id` smallint(5) unsigned NOT NULL COMMENT 'Foreign key from the role table.',
  `school_id` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`person_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `person_role_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `person_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Link table between person and role to support many-to-many.';

-- Data exporting was unselected.


-- Dumping structure for table nextsis.person_school
CREATE TABLE IF NOT EXISTS `person_school` (
  `person_id` int(10) unsigned NOT NULL COMMENT 'Foreign key from person table',
  `school_id` mediumint(8) unsigned NOT NULL COMMENT 'Foriegn key from school table',
  `udf1` varchar(50) DEFAULT NULL,
  `udf2` varchar(50) DEFAULT NULL,
  `udf3` varchar(50) DEFAULT NULL,
  `udf4` varchar(50) DEFAULT NULL,
  `udf5` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`person_id`,`school_id`),
  KEY `school_id` (`school_id`),
  CONSTRAINT `person_school_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `person_school_ibfk_3` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Link table between person and school for many-to-many';

-- Data exporting was unselected.


-- Dumping structure for table nextsis.person_title
CREATE TABLE IF NOT EXISTS `person_title` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key (0-255).',
  `language_id` smallint(5) unsigned NOT NULL COMMENT 'The primary key from the language table.',
  `label` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `label` (`label`),
  KEY `language_id` (`language_id`),
  CONSTRAINT `person_title_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Titles a person can be known by.';

-- Data exporting was unselected.


-- Dumping structure for table nextsis.profile_property
CREATE TABLE IF NOT EXISTS `profile_property` (
  `school_id` mediumint(8) unsigned NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `FK_profile_property_school` (`school_id`),
  CONSTRAINT `FK_profile_property_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table nextsis.rating_scale
CREATE TABLE IF NOT EXISTS `rating_scale` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` mediumint(8) unsigned DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rating_scale_school` (`school_id`),
  CONSTRAINT `FK_rating_scale_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table nextsis.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key.',
  `label` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `RoleName_UNIQUE` (`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores people''s roles (student, teacher, parent, administrator etc.)';

-- Data exporting was unselected.


-- Dumping structure for table nextsis.school
CREATE TABLE IF NOT EXISTS `school` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `syear` int(11) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `principal` varchar(45) DEFAULT NULL,
  `www_address` varchar(45) DEFAULT NULL,
  `anchor` varchar(45) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `schoolcol` varchar(45) DEFAULT NULL,
  `reporting_gp_scale` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `schoolname_UNIQUE` (`title`,`anchor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores school details (to support multiple schools)';

-- Data exporting was unselected.


-- Dumping structure for table nextsis.school_class
CREATE TABLE IF NOT EXISTS `school_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_id` mediumint(9) DEFAULT NULL,
  `gradelevel_id` mediumint(8) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table nextsis.school_gradelevels
CREATE TABLE IF NOT EXISTS `school_gradelevels` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `school_id` mediumint(9) NOT NULL,
  `title` varchar(45) NOT NULL,
  `next_grade_id` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Store school levels';

-- Data exporting was unselected.


-- Dumping structure for table nextsis.school_periods
CREATE TABLE IF NOT EXISTS `school_periods` (
  `period_id` int(10) NOT NULL AUTO_INCREMENT,
  `syear` decimal(4,0) DEFAULT NULL,
  `school_id` decimal(10,0) DEFAULT NULL,
  `sort_order` decimal(10,0) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `short_name` varchar(10) DEFAULT NULL,
  `length` decimal(10,0) DEFAULT NULL,
  `block` varchar(10) DEFAULT NULL,
  `ignore_scheduling` varchar(1) DEFAULT NULL,
  `attendance` varchar(1) DEFAULT NULL,
  `rollover_id` decimal(10,0) DEFAULT NULL,
  `start_time` varchar(15) DEFAULT NULL,
  `end_time` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`period_id`),
  KEY `school_periods_ind1` (`period_id`,`syear`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table nextsis.school_quarter
CREATE TABLE IF NOT EXISTS `school_quarter` (
  `marking_period_id` mediumint(8) NOT NULL,
  `syear` int(11) DEFAULT NULL,
  `school_id` mediumint(8) DEFAULT NULL,
  `semester_id` mediumint(8) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `short_name` varchar(10) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `post_start_date` date DEFAULT NULL,
  `post_end_date` date DEFAULT NULL,
  PRIMARY KEY (`marking_period_id`),
  KEY `school_quarter_ind1` (`semester_id`) USING BTREE,
  KEY `school_quarter_ind2` (`syear`,`school_id`,`start_date`,`end_date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table nextsis.school_semester
CREATE TABLE IF NOT EXISTS `school_semester` (
  `marking_period_id` mediumint(8) NOT NULL,
  `syear` int(11) DEFAULT NULL,
  `school_id` mediumint(8) DEFAULT NULL,
  `year_id` mediumint(8) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `short_name` varchar(10) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `post_start_date` date DEFAULT NULL,
  `post_end_date` date DEFAULT NULL,
  PRIMARY KEY (`marking_period_id`),
  KEY `school_semesters_ind1` (`year_id`) USING BTREE,
  KEY `school_semesters_ind2` (`syear`,`school_id`,`start_date`,`end_date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table nextsis.school_year
CREATE TABLE IF NOT EXISTS `school_year` (
  `marking_period_id` mediumint(8) NOT NULL,
  `syear` int(11) DEFAULT NULL,
  `school_id` mediumint(8) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `short_name` varchar(10) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `post_start_date` date DEFAULT NULL,
  `post_end_date` date DEFAULT NULL,
  PRIMARY KEY (`marking_period_id`),
  KEY `school_years_ind2` (`syear`,`school_id`,`start_date`,`end_date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table nextsis.student_profile_comment
CREATE TABLE IF NOT EXISTS `student_profile_comment` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) unsigned NOT NULL DEFAULT '0',
  `student_id` int(11) unsigned NOT NULL DEFAULT '0',
  `comment` varchar(250) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_student_profile_comment_person` (`teacher_id`),
  KEY `FK_student_profile_comment_person_2` (`student_id`),
  CONSTRAINT `FK_student_profile_comment_person` FOREIGN KEY (`teacher_id`) REFERENCES `person` (`id`),
  CONSTRAINT `FK_student_profile_comment_person_2` FOREIGN KEY (`student_id`) REFERENCES `person` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table nextsis.student_report_profile
CREATE TABLE IF NOT EXISTS `student_report_profile` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `property_id` mediumint(8) unsigned NOT NULL,
  `rating` varchar(50) DEFAULT NULL,
  `term_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_student_report_profile_profile_property` (`property_id`),
  KEY `FK_student_report_profile_term` (`term_id`),
  CONSTRAINT `FK_student_report_profile_profile_property` FOREIGN KEY (`property_id`) REFERENCES `profile_property` (`id`),
  CONSTRAINT `FK_student_report_profile_term` FOREIGN KEY (`term_id`) REFERENCES `term_old` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table nextsis.subject
CREATE TABLE IF NOT EXISTS `subject` (
  `subject_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key.',
  `syear` int(11) unsigned NOT NULL DEFAULT '0',
  `school_id` mediumint(8) unsigned NOT NULL,
  `short_name` varchar(75) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`subject_id`),
  KEY `FK_subject_school` (`school_id`),
  CONSTRAINT `FK_subject_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores subject names and details.';

-- Data exporting was unselected.


-- Dumping structure for table nextsis.subject_course
CREATE TABLE IF NOT EXISTS `subject_course` (
  `course_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `subject_id` mediumint(8) unsigned NOT NULL,
  `syear` int(11) NOT NULL,
  `grade_level` mediumint(8) unsigned NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `short_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`course_id`),
  KEY `FK_subject_course_subject` (`subject_id`),
  KEY `syear_courseid_KEY` (`syear`,`course_id`),
  CONSTRAINT `FK_subject_course_subject` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for view nextsis.subject_course_count
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `subject_course_count` (
	`subject_id` MEDIUMINT(8) UNSIGNED NOT NULL COMMENT 'Primary key.',
	`school_id` MEDIUMINT(8) UNSIGNED NOT NULL,
	`title` VARCHAR(250) NULL COLLATE 'utf8_unicode_ci',
	`short_name` VARCHAR(75) NULL COLLATE 'utf8_unicode_ci',
	`course_count` BIGINT(21) NOT NULL
) ENGINE=InnoDB;


-- Dumping structure for table nextsis.term_course
CREATE TABLE IF NOT EXISTS `term_course` (
  `term_course_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `marking_period_id` mediumint(8) unsigned DEFAULT NULL,
  `mp` varchar(3) DEFAULT NULL,
  `course_id` mediumint(8) unsigned DEFAULT NULL,
  `teacher_id` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`term_course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table nextsis.udf_categories
CREATE TABLE IF NOT EXISTS `udf_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table nextsis.udf_data
CREATE TABLE IF NOT EXISTS `udf_data` (
  `udf_data_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `udf_id` mediumint(8) NOT NULL,
  `udf_value` varchar(500) DEFAULT NULL,
  `fk_id` mediumint(8) NOT NULL,
  PRIMARY KEY (`udf_data_id`),
  KEY `FK_udf_data_udf_definition` (`udf_id`),
  CONSTRAINT `FK_udf_data_udf_definition` FOREIGN KEY (`udf_id`) REFERENCES `udf_definition` (`udf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table nextsis.udf_definition
CREATE TABLE IF NOT EXISTS `udf_definition` (
  `udf_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `school_id` mediumint(8) unsigned NOT NULL,
  `type` varchar(10) DEFAULT NULL,
  `title` varchar(30) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `select_options` varchar(10000) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `validation` varchar(500) DEFAULT NULL,
  `default_selection` varchar(255) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`udf_id`),
  KEY `FK_udf_definition_udf_categories` (`category_id`),
  KEY `FK_udf_definition_school` (`school_id`),
  CONSTRAINT `FK_udf_definition_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`),
  CONSTRAINT `FK_udf_definition_udf_categories` FOREIGN KEY (`category_id`) REFERENCES `udf_categories` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for view nextsis.marking_period
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `marking_period`;
CREATE VIEW `marking_period` AS SELECT q.marking_period_id, q.syear,
 	q.school_id, 'quarter' AS mp_type, q.title, q.short_name,
	q.semester_id AS parent_id,
 	s.year_id AS grandparent_id, q.start_date,
 	q.end_date, q.post_start_date,
 	q.post_end_date
     FROM school_quarter q
     JOIN school_semester s ON q.semester_id = s.marking_period_id
 UNION
     SELECT marking_period_id, syear,
	  	school_id, 'semester' AS mp_type, title, short_name,
		year_id AS parent_id, -1 AS grandparent_id, start_date,
		end_date, post_start_date, post_end_date
     FROM school_semester
 UNION
     SELECT marking_period_id, syear,
 			school_id, 'year' AS mp_type, title, short_name,
 			-1 AS parent_id,
 			-1 AS grandparent_id, start_date,
 			end_date, post_start_date,
 			post_end_date
     FROM school_year ;


-- Dumping structure for view nextsis.student_subjects_vw
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `student_subjects_vw`;
CREATE VIEW `student_subjects_vw` AS select concat_ws(' ',p.first_name, p.middle_name, p.surname) as student, p.id as studentid,pc.term_course_id,sc.title  from 
person as p 
inner join person_course pc on p.id = pc.person_id
inner join term_course tc on pc.term_course_id = tc.term_course_id
inner join subject_course sc on tc.course_id = sc.course_id ;


-- Dumping structure for view nextsis.subject_course_count
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `subject_course_count`;
CREATE VIEW `subject_course_count` AS select s.subject_id, s.school_id, s.title, s.short_name, count(sc.course_id) as course_count from subject s
left join subject_course sc
on s.subject_id = sc.subject_id
group by s.subject_id, s.school_id, s.title, s.short_name ;


-- Dumping structure for view nextsis.teachersubjects_vw
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `teachersubjects_vw`;
CREATE VIEW `teachersubjects_vw` AS select sc.course_id as subjectcourse_id, sc.title as subjectcourse_title,pc.person_id as personid, marking_period.syear from 
term_course as tc 
inner join marking_period on tc.term_course_id = marking_period.marking_period_id
inner join subject_course as sc on tc.course_id = sc.course_id
inner join person_course as pc on tc.term_course_id = pc.term_course_id ;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;


-- Add Test Data

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*!40000 ALTER TABLE `school` DISABLE KEYS */;
REPLACE INTO `school` (`id`, `title`, `syear`, `address`, `city`, `state`, `phone`, `principal`, `www_address`, `anchor`, `email`, `schoolcol`, `reporting_gp_scale`) VALUES
	(1, 'Paul Bogle High School', 2014, NULL, NULL, NULL, NULL, NULL, NULL, 'pbhs', NULL, NULL, NULL);
/*!40000 ALTER TABLE `school` ENABLE KEYS */;

/*!40000 ALTER TABLE `person_title` DISABLE KEYS */;
REPLACE INTO `person_title` (`id`, `language_id`, `label`) VALUES
	(1, 1, 'Dr.'),
	(2, 1, 'Miss'),
	(3, 1, 'Ms.'),
	(4, 1, 'Mr.'),
	(5, 1, 'Mrs.');
/*!40000 ALTER TABLE `person_title` ENABLE KEYS */;

-- Dumping data for table nextsis.role: ~4 rows (approximately)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
REPLACE INTO `role` (`id`, `label`) VALUES
	(1, 'Administrator'),
	(4, 'Parent'),
	(3, 'Student'),
	(2, 'Teacher');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

/*!40000 ALTER TABLE `person_role` DISABLE KEYS */;
REPLACE INTO `person_role` (`person_id`, `role_id`, `school_id`) VALUES
	(1, 1, NULL);
/*!40000 ALTER TABLE `person_role` ENABLE KEYS */;

/*!40000 ALTER TABLE `person` DISABLE KEYS */;
REPLACE INTO `person` (`id`, `local_id`, `surname`, `first_name`, `middle_name`, `common_name`, `title_id`, `gender_id`, `username`, `password`, `default_schoolId`, `classId`) VALUES
	(1, 'NX-1', 'Smith', 'John', 'Andrew', 'Sprat', 4, 2, 'admin', 'c2ab1dbf445c7aafec65ee0d94ccd05d43e90a9a2b12e6bae8e32e924ba4a0245664350b0e8320a326faa38a93e5fbef36113bbbb72f0c4aa8b046c84c5a09b2', 1, NULL);
/*!40000 ALTER TABLE `person` ENABLE KEYS */;


/*!40000 ALTER TABLE `person_gender` DISABLE KEYS */;
REPLACE INTO `person_gender` (`id`, `language_id`, `label`) VALUES
	(1, 1, 'Female'),
	(2, 1, 'Male');
/*!40000 ALTER TABLE `person_gender` ENABLE KEYS */;


/*!40000 ALTER TABLE `language` DISABLE KEYS */;
REPLACE INTO `language` (`id`, `code`, `subtag`, `name`, `region`) VALUES
	(1, 'en', 'US', 'English', 'American'),
	(2, 'en', 'GB', 'English', 'British'),
	(3, 'ko', 'KR', 'Korean', NULL),
	(4, 'km', 'KH', 'Central Khmer', 'Cambodia'),
	(5, 'zh', 'CN', 'Chinese', 'China'),
	(6, 'es', 'ES', 'Spanish', 'Spain'),
	(7, 'fr', 'CA', 'French', 'Canada'),
	(8, 'ja', 'JP', 'Japanese', NULL);
/*!40000 ALTER TABLE `language` ENABLE KEYS */;


/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;