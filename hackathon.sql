-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2017 at 07:11 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hackathon`
--

-- --------------------------------------------------------

--
-- Table structure for table `ad`
--

CREATE TABLE `ad` (
  `ad_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `pay` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `duration` varchar(200) DEFAULT NULL,
  `what_we_offer` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ad`
--

INSERT INTO `ad` (`ad_id`, `company_id`, `date_from`, `date_to`, `sex`, `age`, `pay`, `title`, `duration`, `what_we_offer`) VALUES
(1, 1, '2017-07-03', NULL, 1, 15, NULL, 'Neki opis poslaaa', NULL, 'nudimo svasta nesto lepo'),
(2, 1, '2017-07-01', '2017-07-04', 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `logo_url` varchar(500) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `contact` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `email`, `password`, `name`, `address`, `logo_url`, `description`, `contact`) VALUES
(1, 'com@radi.com', 'jeej', 'Belit', 'Trg Nikole Pasica 9', NULL, 'Druga najbolja IT firma na trgu nikole pasica', '064 548-58-96');

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `criteria_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `education_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `school` varchar(200) NOT NULL,
  `education_level` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`education_id`, `user_id`, `school`, `education_level`) VALUES
(1, 1, 'Fon', 'mnogo zajeban'),
(2, 1, 'ETF', 'neki zahtev znaci haos');

-- --------------------------------------------------------

--
-- Table structure for table `experience_company`
--

CREATE TABLE `experience_company` (
  `experience_company_id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `years` int(11) NOT NULL,
  `position` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `experience_company`
--

INSERT INTO `experience_company` (`experience_company_id`, `ad_id`, `years`, `position`) VALUES
(2, 1, 2, 'Hr covek'),
(3, 2, 1, 'Zna sve covek');

-- --------------------------------------------------------

--
-- Table structure for table `experience_user`
--

CREATE TABLE `experience_user` (
  `experience_user_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `position` varchar(200) NOT NULL,
  `company` varchar(200) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `experience_user`
--

INSERT INTO `experience_user` (`experience_user_id`, `user_id`, `position`, `company`, `date_from`, `date_to`, `description`) VALUES
(1, 1, 'HR manager', 'Dulo', '2016-07-04', NULL, 'Ovo je opis pozicije'),
(2, 1, 'PR covek', 'Pr comp', '2017-07-10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

CREATE TABLE `picture` (
  `picture_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `requirements`
--

CREATE TABLE `requirements` (
  `requirements_id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `text` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requirements`
--

INSERT INTO `requirements` (`requirements_id`, `ad_id`, `text`) VALUES
(2, 1, 'neki zahtev mnogo zajeban');

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE `skill` (
  `skill_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `skill_name` varchar(200) NOT NULL,
  `skill_level` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `skill`
--

INSERT INTO `skill` (`skill_id`, `user_id`, `skill_name`, `skill_level`) VALUES
(1, 1, 'neki zahtev mnogo ', 'idemoooo'),
(2, 1, 'to je to mnogo neki', 'ma da da');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `tag_id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tag_id`, `name`) VALUES
(1, 'Pekar'),
(2, 'Radnik na trafici'),
(3, 'Kasir');

-- --------------------------------------------------------

--
-- Table structure for table `tag_ad`
--

CREATE TABLE `tag_ad` (
  `tag_id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag_ad`
--

INSERT INTO `tag_ad` (`tag_id`, `ad_id`) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tag_company`
--

CREATE TABLE `tag_company` (
  `tag_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tag_user`
--

CREATE TABLE `tag_user` (
  `tag_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag_user`
--

INSERT INTO `tag_user` (`tag_id`, `user_id`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `address` int(11) DEFAULT NULL,
  `can_company_contact` tinyint(1) NOT NULL DEFAULT '0',
  `about_me` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `name`, `address`, `can_company_contact`, `about_me`) VALUES
(1, 'radi@radi.com', '1234', '', NULL, 0, NULL),
(2, 'dule', 'dule', '', NULL, 0, NULL),
(3, 'dukili', 'jeej', '', NULL, 0, NULL),
(4, 'dule', 'dule', '', NULL, 0, NULL),
(5, 'dule', 'dule', '', NULL, 0, NULL),
(6, 'dule', 'dule', '', NULL, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ad`
--
ALTER TABLE `ad`
  ADD PRIMARY KEY (`ad_id`,`company_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`criteria_id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`education_id`,`user_id`);

--
-- Indexes for table `experience_company`
--
ALTER TABLE `experience_company`
  ADD PRIMARY KEY (`experience_company_id`,`ad_id`),
  ADD KEY `ad_id` (`ad_id`);

--
-- Indexes for table `experience_user`
--
ALTER TABLE `experience_user`
  ADD PRIMARY KEY (`experience_user_id`,`user_id`);

--
-- Indexes for table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`picture_id`,`company_id`);

--
-- Indexes for table `requirements`
--
ALTER TABLE `requirements`
  ADD PRIMARY KEY (`ad_id`,`requirements_id`),
  ADD KEY `requirements_id` (`requirements_id`,`ad_id`);

--
-- Indexes for table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`skill_id`,`user_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `tag_ad`
--
ALTER TABLE `tag_ad`
  ADD PRIMARY KEY (`tag_id`,`ad_id`);

--
-- Indexes for table `tag_company`
--
ALTER TABLE `tag_company`
  ADD PRIMARY KEY (`tag_id`,`company_id`);

--
-- Indexes for table `tag_user`
--
ALTER TABLE `tag_user`
  ADD PRIMARY KEY (`tag_id`,`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ad`
--
ALTER TABLE `ad`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `criteria_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `education_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `experience_company`
--
ALTER TABLE `experience_company`
  MODIFY `experience_company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `experience_user`
--
ALTER TABLE `experience_user`
  MODIFY `experience_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `picture`
--
ALTER TABLE `picture`
  MODIFY `picture_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `requirements`
--
ALTER TABLE `requirements`
  MODIFY `requirements_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `skill`
--
ALTER TABLE `skill`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `experience_company`
--
ALTER TABLE `experience_company`
  ADD CONSTRAINT `ad_id` FOREIGN KEY (`ad_id`) REFERENCES `ad` (`ad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
