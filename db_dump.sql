DROP DATABASE IF EXISTS `jvrms`;
CREATE DATABASE IF NOT EXISTS `jvrms`;
USE `jvrms`;
DROP TABLE IF EXISTS `inmates`;
CREATE TABLE IF NOT EXISTS `inmates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `cell_number` varchar(100) NOT NULL,
  `case_number` varchar(255) NOT NULL,
  `crime` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table jvrms.inmates: ~2 rows (approximately)
INSERT INTO `inmates` (`id`, `first_name`, `last_name`, `gender`, `cell_number`, `case_number`, `crime`) VALUES
	(1, 'Ernesto', 'Kriminal', 'Male', '104-CELL-303', 'C-943-A', 'Stealing'),
	(2, 'Emmanuel', 'Barrido', 'Male', '104-CELL-304', 'A-215-C', 'Nagmahal ng... wagas');

-- Dumping structure for table jvrms.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `access_level` tinyint(3) unsigned NOT NULL COMMENT '1 = Visitor, 2 = Officer, 3 = Admin',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table jvrms.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `access_level`, `username`, `password`) VALUES
	(1, 3, 'admin', '$2y$10$be1bwfuPSjDEDPusc2rXj.v/tvzdg.QbALmjoHFYiIzaKWaduOB.e'),
	(2, 2, 'officer', '$2y$10$xAV6thZhch1e1rBnOVQVfuTKvvWIbahSRV13IojWqmoFcuz8VO2ai');

-- Dumping structure for table jvrms.visits
DROP TABLE IF EXISTS `visits`;
CREATE TABLE IF NOT EXISTS `visits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inmate_id` int(10) unsigned NOT NULL,
  `date` date NOT NULL DEFAULT curdate(),
  `time_in` time NOT NULL DEFAULT curtime(),
  `time_out` time NOT NULL,
  `visitor_name` varchar(255) NOT NULL,
  `contact_number` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table jvrms.visits: ~2 rows (approximately)
INSERT INTO `visits` (`id`, `inmate_id`, `date`, `time_in`, `time_out`, `visitor_name`, `contact_number`) VALUES
	(1, 1, '2020-03-07', '10:44:00', '10:50:00', 'Cecilia Kriminal', '09169258735'),
	(2, 2, '2020-03-09', '08:50:00', '09:38:00', 'Ambok', '09182847385');
