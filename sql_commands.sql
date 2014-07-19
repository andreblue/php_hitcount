--The history table.
CREATE TABLE IF NOT EXISTS `history` (
  `time_visted` text COLLATE latin1_general_ci NOT NULL,
  `ip` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--This creates the table for storing hits.
CREATE TABLE IF NOT EXISTS `hits` (
  `page` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `hitcount` int(11) NOT NULL,
  UNIQUE KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;