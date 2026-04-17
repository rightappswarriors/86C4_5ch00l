-- Create table for Fetcher's ID Registration
-- Run this SQL in your database (e.g., phpMyAdmin)

CREATE TABLE IF NOT EXISTS `fetcher_registration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fetcher_data` text NOT NULL,
  `student_data` text NOT NULL,
  `notes` text,
  `registered_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;