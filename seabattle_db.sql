-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2013 at 07:16 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `seabattle_db`
--
CREATE DATABASE IF NOT EXISTS `seabattle_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `seabattle_db`;

-- --------------------------------------------------------

--
-- Table structure for table `active_users`
--

CREATE TABLE IF NOT EXISTS `active_users` (
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `current_games`
--

CREATE TABLE IF NOT EXISTS `current_games` (
  `game_id` int(11) NOT NULL AUTO_INCREMENT,
  `player_one_id` int(11) NOT NULL,
  `player_two_id` int(11) NOT NULL,
  PRIMARY KEY (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `board_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `board` varchar(2000) NOT NULL,
  `free_ships` varchar(10) NOT NULL,
  `submit` varchar(3) NOT NULL,
  `turn` varchar(11) NOT NULL,
  `winner` varchar(11) NOT NULL,
  `kills` int(11) NOT NULL,
  `misses` int(11) NOT NULL,
  PRIMARY KEY (`board_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `total_games` int(11) NOT NULL,
  `lost_games` int(11) NOT NULL,
  `won_games` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role`, `username`, `password`, `nickname`, `total_games`, `lost_games`, `won_games`) VALUES
(1, 'admin', 'admin', 'Admin1%', 'admin', 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
