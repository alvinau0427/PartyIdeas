-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2016-08-11 16:17:36
-- 伺服器版本: 10.1.13-MariaDB
-- PHP 版本： 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `partyideas_db`
--
DROP DATABASE IF EXISTS `partyideas_db`;
CREATE DATABASE IF NOT EXISTS `partyideas_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `partyideas_db`;

-- --------------------------------------------------------

--
-- 資料表結構 `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `LoginAccount` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `admin`
--

INSERT INTO `admin` (`AdminID`, `Name`, `LoginAccount`) VALUES
(1, 'admin', 'publicstatics@gmail.com'),
(2, 'JK', 'johnnykwong@yahoo.com.hk'),
(3, 'Partyideas', 'partyideas.hk@gmail.com'),
(4, 'Lemon', 'just_lemonly@yahoo.com.hk');

-- --------------------------------------------------------

--
-- 資料表結構 `blacklist`
--

CREATE TABLE `blacklist` (
  `BlacklistID` int(11) NOT NULL,
  `Account` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL,
  `BlackListDate` date DEFAULT NULL,
  `Admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `boardgame`
--

CREATE TABLE `boardgame` (
  `BoardGameID` int(11) NOT NULL,
  `BoardGameName` varchar(100) NOT NULL,
  `BoardGameDetail` varchar(1000) DEFAULT NULL,
  `BoardGameType` int(11) NULL NULL,
  `Year` year(4) NOT NULL,
  `Price` double(10,2) NOT NULL DEFAULT '0.00',
  `Quantity` int(11) NOT NULL DEFAULT '0',
  `Player_Minimum` int(11) NOT NULL DEFAULT '1',
  `Player_Maximum` int(11) DEFAULT NULL,
  `LimitationAge` int(3) DEFAULT NULL,
  `Photo` varchar(100) DEFAULT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `boardgamebooking`
--

CREATE TABLE `boardgamebooking` (
  `BookingID` int(11) NOT NULL,
  `BoardGameID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL DEFAULT '1',
  `TotalPrice` double(20,2) NOT NULL DEFAULT '0.00',
  `MemberName` varchar(100) NOT NULL,
  `Contact` char(8) NOT NULL,
  `OrderDate` date NOT NULL,
  `OrderTime` time NOT NULL,
  `ReceiptDate` date DEFAULT NULL,
  `ReceiptTime` time DEFAULT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `boardgametype`
--

CREATE TABLE `boardgametype` (
  `ID` int(11) NOT NULL,
  `Type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `boardgametype`
--

INSERT INTO `boardgametype` (`ID`, `Type`) VALUES
(1, '現貨'),
(2, '預訂貨品'),
(3, '中古品'),
(4, '咭套及其他周邊產品');

-- --------------------------------------------------------

--
-- 資料表結構 `calendar_event`
--

CREATE TABLE `calendar_event` (
  `id` int(11) NOT NULL,
  `event` varchar(300) DEFAULT NULL,
  `description` text NOT NULL,
  `day` int(8) DEFAULT NULL,
  `month` int(8) DEFAULT NULL,
  `year` int(8) DEFAULT NULL,
  `time_from` varchar(10) NOT NULL,
  `time_until` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `gatheringbattle`
--

CREATE TABLE `gatheringbattle` (
  `EventID` int(11) NOT NULL,
  `BoardGameID` int(11) NOT NULL,
  `MemberName` varchar(100) NOT NULL,
  `Account` varchar(200) NOT NULL,
  `Contact` char(8) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `EndTime` time NOT NULL,
  `Place` int(11) NOT NULL,
  `ParticipantRequirement` int(11) NOT NULL DEFAULT '1',
  `Status` int(11) NOT NULL,
  `JoinedParticipant` varchar(500) DEFAULT '',
  `JoinedParticipantToken` varchar(200) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `gatheringbattleprice`
--

CREATE TABLE `gatheringbattleprice` (
  `PriceID` int(11) NOT NULL,
  `Monday` double(11, 2) NOT NULL,
  `Tuesday` double(11, 2) NOT NULL,
  `Wednesday` double(11, 2) NOT NULL,
  `Thursday` double(11, 2) NOT NULL,
  `Friday` double(11, 2) NOT NULL,
  `Saturday` double(11, 2) NOT NULL,
  `Sunday` double(11, 2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `gatheringbattleprice`
--

INSERT INTO `gatheringbattleprice` (`PriceID`, `Monday`, `Tuesday`, `Wednesday`, `Thursday`, `Friday`, `Saturday`, `Sunday`) VALUES
(1, 45.00, 45.00, 45.00, 45.00, 50.00, 50.00, 50.00);

-- --------------------------------------------------------

--
-- 資料表結構 `indexSetting`
--

CREATE TABLE `indexsetting` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `ShowItem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `indexsetting`
--

INSERT INTO `indexsetting` (`ID`, `Name`, `ShowItem`) VALUES
(1, 'boardgame', 6),
(2, 'gatheringbattle', 5);

-- --------------------------------------------------------

--
-- 資料表結構 `location`
--

CREATE TABLE `location` (
  `LocationID` int(11) NOT NULL,
  `Place` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `location`
--

INSERT INTO `location` (`LocationID`, `Place`) VALUES
(1, '旺角道13號藝旺商業大廈14A (13樓出lift轉右再上一層)');

-- --------------------------------------------------------

--
-- 資料表結構 `message`
--

CREATE TABLE `message` (
  `ID` int(11) NOT NULL,
  `SuccessTitle` varchar(100) NOT NULL,
  `CancelTitle` varchar(100) NOT NULL,
  `SuccessBody` varchar(300) NOT NULL,
  `CancelBody` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `message` (`ID`, `SuccessTitle`, `CancelTitle`, `SuccessBody`, `CancelBody`) VALUES
(1, '[PartyIdeas]約戰申請', '[PartyIdeas]約戰申請', '你的約戰申請已被接受, 請到PI app 查詢', '你的約戰申請已被拒絕, 詳情可聯絡我們'),
(2, '[PartyIdeas]私人包場', '[PartyIdeas]私人包場', '你的包場申請已被接受', '你的包場申請已被拒絶, 詳情可聯絡我們');

-- --------------------------------------------------------

--
-- 資料表結構 `notification`
--

CREATE TABLE `notification` (
  `NotificationID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Body` varchar(300) NOT NULL,
  `Uid` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Date` Datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `photo`
--

CREATE TABLE `photo` (
  `ID` int(11) NOT NULL,
  `PhotoName` varchar(200) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `photo` (`ID`, `PhotoName`, `Status`) VALUES
(1, 'Main.jpg', 1),
(2, 'JapaneseLanguage.jpg', 1),
(3, 'MidAutumn.jpg', 1),
(4, 'price_list.png', 2);

-- --------------------------------------------------------

--
-- 資料表結構 `privatebooking`
--

CREATE TABLE `privatebooking` (
  `BookingID` int(11) NOT NULL,
  `MemberName` varchar(100) NOT NULL,
  `Account` varchar(200) NOT NULL,
  `Contact` char(8) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `EndTime` time NOT NULL,
  `Place` int(11) NOT NULL,
  `NumberOfPeople` int(11) NOT NULL DEFAULT '1',
  `TotalPrice` double(11,2) NOT NULL DEFAULT '0.00',
  `Discount` double(11,2) DEFAULT '0.00',
  `Remark` varchar(200) DEFAULT NULL,
  `Photo` varchar(40) DEFAULT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `privatebookingprice`
--

CREATE TABLE `privatebookingprice` (
  `PriceID` int(11) NOT NULL,
  `BasicPrice` double(11,2) NOT NULL,
  `BasicPeople` int(11) NOT NULL,
  `BasicHour` int(11) NOT NULL,
  `ExtraFoodPricePerPeople` double(11,2) NOT NULL,
  `ExtraPricePerHour` double(11,2) NOT NULL,
  `ExtraPricePerPeople` double(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `privatebookingprice`
--

INSERT INTO `privatebookingprice` (`PriceID`, `BasicPrice`, `BasicPeople`, `BasicHour`, `ExtraFoodPricePerPeople`, `ExtraPricePerHour`, `ExtraPricePerPeople`) VALUES
(1, 600.00, 6, 4, 60.00, 100.00, 100.00);

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `ID` int(20) NOT NULL,
  `Token` varchar(200) NOT NULL,
  `Account` varchar(200) DEFAULT NULL,
  `ReceiveNotification` char(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- 資料表索引 `blacklist`
--
ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`BlacklistID`),
  ADD KEY `blacklist_fk1` (`Admin`);

--
-- 資料表索引 `boardgame`
--
ALTER TABLE `boardgame`
  ADD PRIMARY KEY (`BoardGameID`),
  ADD KEY `boardgame_fk1` (`BoardGameType`);

--
-- 資料表索引 `boardgamebooking`
--
ALTER TABLE `boardgamebooking`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `boardgamebooking_fk1` (`BoardGameID`);
  
--
-- 資料表索引 `boardgametype`
--
ALTER TABLE `boardgametype`
  ADD PRIMARY KEY (`ID`);
  
--
-- 資料表索引 `calendar_event`
--
ALTER TABLE `calendar_event`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `gatheringbattle`
--
ALTER TABLE `gatheringbattle`
  ADD PRIMARY KEY (`EventID`),
  ADD KEY `gatheringbattle_fk1` (`BoardGameID`),
  ADD KEY `gatheringbattle_fk2` (`Place`);
  
--
-- 資料表索引 `gatheringbattleprice`
--
ALTER TABLE `gatheringbattleprice`
  ADD PRIMARY KEY (`PriceID`);
  
--
-- 資料表索引 `indexsetting`
--
ALTER TABLE `indexsetting`
  ADD PRIMARY KEY (`ID`);
  
--
-- 資料表索引 `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`LocationID`);
  
--
-- 資料表索引 `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`ID`);
  
--
-- 資料表索引 `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`NotificationID`);

--
-- 資料表索引 `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`ID`);
  
--
-- 資料表索引 `privatebooking`
--
ALTER TABLE `privatebooking`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `privatebooking_fk1` (`Place`);
  
--
-- 資料表索引 `privatebookingprice`
--
ALTER TABLE `privatebookingprice`
  ADD PRIMARY KEY (`PriceID`);
  
--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 使用資料表 AUTO_INCREMENT `blacklist`
--
ALTER TABLE `blacklist`
  MODIFY `BlacklistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 使用資料表 AUTO_INCREMENT `boardgame`
--
ALTER TABLE `boardgame`
  MODIFY `BoardGameID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- 使用資料表 AUTO_INCREMENT `boardgamebooking`
--
ALTER TABLE `boardgamebooking`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- 使用資料表 AUTO_INCREMENT `boardgametype`
--
ALTER TABLE `boardgametype`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 使用資料表 AUTO_INCREMENT `calendar_event`
--
ALTER TABLE `calendar_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- 使用資料表 AUTO_INCREMENT `gatheringbattle`
--
ALTER TABLE `gatheringbattle`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- 使用資料表 AUTO_INCREMENT `gatheringbattleprice`
--
ALTER TABLE `gatheringbattleprice`
  MODIFY `PriceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- 使用資料表 AUTO_INCREMENT `indexsetting`
--
ALTER TABLE `indexsetting`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- 使用資料表 AUTO_INCREMENT `location`
--
ALTER TABLE `location`
  MODIFY `LocationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- 使用資料表 AUTO_INCREMENT `message`
--
ALTER TABLE `message`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- 使用資料表 AUTO_INCREMENT `notification`
--
ALTER TABLE `notification`
  MODIFY `NotificationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- 使用資料表 AUTO_INCREMENT `photo`
--
ALTER TABLE `photo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- 使用資料表 AUTO_INCREMENT `privatebooking`
--
ALTER TABLE `privatebooking`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- 使用資料表 AUTO_INCREMENT `privatebookingprice`
--
ALTER TABLE `privatebookingprice`
  MODIFY `PriceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- 使用資料表 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- 已匯出資料表的限制(Constraint)
--
  
--
-- 資料表的 Constraints `blacklist`
--
ALTER TABLE `blacklist`
  ADD CONSTRAINT `blacklist_fk1` FOREIGN KEY (`Admin`) REFERENCES `admin` (`AdminID`);
  
--
-- 資料表的 Constraints `boardgame`
--
ALTER TABLE `boardgame`
  ADD CONSTRAINT `boardgame_fk1` FOREIGN KEY (`BoardGameType`) REFERENCES `boardgametype` (`ID`);

--
-- 資料表的 Constraints `boardgamebooking`
--
ALTER TABLE `boardgamebooking`
  ADD CONSTRAINT `boardgamebooking_fk1` FOREIGN KEY (`BoardGameID`) REFERENCES `boardgame` (`BoardGameID`);

--
-- 資料表的 Constraints `gatheringbattle`
--
ALTER TABLE `gatheringbattle`
  ADD CONSTRAINT `gatheringbattle_fk1` FOREIGN KEY (`BoardGameID`) REFERENCES `boardgame` (`BoardGameID`),
  ADD CONSTRAINT `gatheringbattle_fk2` FOREIGN KEY (`Place`) REFERENCES `location` (`LocationID`);
  
--
-- 資料表的 Constraints `privatebooking`
--
ALTER TABLE `privatebooking`
  ADD CONSTRAINT `privatebooking_fk1` FOREIGN KEY (`Place`) REFERENCES `location` (`LocationID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
