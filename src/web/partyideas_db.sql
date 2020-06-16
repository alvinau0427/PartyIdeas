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
-- 資料表的匯出資料 `boardgamebooking`
--

INSERT INTO `admin` (`AdminID`, `Name`, `LoginAccount`) VALUES
(1, 'admin', 'publicstatics@gmail.com');

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

--
-- 資料表的匯出資料 `boardgamebooking`
--

INSERT INTO `blacklist` (`BlacklistID`, `Account`, `Status`, `BlackListDate`, `Admin`) VALUES
(1, 'Tom@gmail.com', 1, '2016-08-15', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `boardgame`
--

CREATE TABLE `boardgame` (
  `BoardGameID` int(11) NOT NULL,
  `BoardGameName` varchar(100) NOT NULL,
  `BoardGameDetail` varchar(1000) DEFAULT NULL,
  `Year` year(4) NOT NULL,
  `Price` double(10,2) NOT NULL DEFAULT '0.00',
  `Quantity` int(11) NOT NULL DEFAULT '0',
  `Player_Minimum` int(11) NOT NULL DEFAULT '1',
  `Player_Maximum` int(11) DEFAULT NULL,
  `LimitationAge` int(3) DEFAULT NULL,
  `Photo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `boardgame`
--

INSERT INTO `boardgame` (`BoardGameID`, `BoardGameName`, `BoardGameDetail`, `Year`, `Price`, `Quantity`, `Player_Minimum`, `Player_Maximum`, `LimitationAge`, `Photo`) VALUES
(1, '花札\nFlower Cards はなふだ', '花札亦稱為花牌、花鬪，是源於日本，後於朝鮮王朝後期傳到朝鮮半島的一種傳統紙牌遊戲。目前一般的花札都是所謂的「八八花」，卡片上畫有12個月份的花草，每種各4張，整組48張。一般兩人玩的叫「來來」（日語：こいこい，兩人以上玩的叫「花合わせ」（羅馬字：Hana-awase），不過在日本花札愛好者之中屬八八的玩法最受歡迎。南韓則以GO-STOP玩法最熱門，並且在日本與朝鮮半島的許多地區都有本地的獨特玩法。', 1901, 30.00, 10, 2, 6, 8, 'game_flower_cards.png'),
(2, '【任天堂】花札\nFlower Cards はなふだ', '花札亦稱為花牌、花鬪，是源於日本，後於朝鮮王朝後期傳到朝鮮半島的一種傳統紙牌遊戲。目前一般的花札都是所謂的「八八花」，卡片上畫有12個月份的花草，每種各4張，整組48張。一般兩人玩的叫「來來」（日語：こいこい，兩人以上玩的叫「花合わせ」（羅馬字：Hana-awase），不過在日本花札愛好者之中屬八八的玩法最受歡迎。南韓則以GO-STOP玩法最熱門，並且在日本與朝鮮半島的許多地區都有本地的獨特玩法。', 1901, 100.00, 10, 2, 6, 8, 'game_flower_cards_nintendo.png'),
(3, '小王子 : 給我一個星球\nThe Little Prince : Make Me a Planet', '慶祝小王子70週年，GoKids 玩樂小子獨家代理 The Little Prince 小王子桌遊 (中文版)，重新邂逅和小王子初識的溫暖。\n\n透過圖卡重新溫習星球上發生的大小事，跟隨小王子獨到的觀察力，創造一個屬於你的星球。 遊戲中會遭遇許多星球居民，固執的燈夫、好命令別人的國王、愛慕虛榮的人，代表著許多不同的價值觀，試著理解居民的需求，幫助你的星球獲得最高分數。\n\n由桌遊界兩大設計師 Antoine Bauza，Bruno Cathala (設計 MOW, Dice Town 等桌遊) 聯手設計，內附中文及英文遊戲說明書，適合2~5人，七歲以上的孩子及成人，遊戲規則簡單易上手，要有高度觀察力才能精通。 欲擒故縱的全盤策略思考過程中，透過觀察指定下一位玩者抽牌，透過資源的分配，轉變為對自己有利的局勢以獲得勝利，遊戲極富重複可玩性。 是一款適合全家共同玩樂的遊戲。', 2013, 215.00, 10, 2, 5, 8, 'game_the_little_prince.png'),
(4, '璀璨寶石\nSplendor', '由Asmodee核心創辦人所設計的璀璨寶石，榮獲 2014 年度最佳遊戲 2014 Golden Geek Board Game of the Year。 獲得 2014 Spiel des Jahres Nominee 德國桌遊年度大獎提名殊榮，本遊戲適合8歲以上，2~4人遊玩。\n\n璀璨寶石 桌上遊戲，擁有優雅華麗的美術風格，引領玩家進入文藝復興的歐洲地區，擁有最多的寶石將會吸引貴族前往投資。利用手上的資源獲取礦脈、運輸方式以及工匠，工匠將會把你手上的原石冶煉成完美無瑕的寶石！於10月中上市的中文版遊戲，對於色弱玩家更方便辨識！\n\n玩法容易、遊戲卻不簡單，考驗玩家的邏輯思考，以及手牌分配，需要良好的策略管理，才有辦法從遊戲中勝出，成為文藝復興的大富豪！', 2014, 285.00, 10, 2, 4, 9, 'game_splendor.png'),
(5, '彩色島\nBurano', '《彩色島》是由桌遊愛樂事原創的歐式策略遊戲。從機制、插圖、平衡和測試，全部都由台灣人一手打造。你將操控獨特的「方塊塔」，安排家族成員出海捕魚或編織蕾絲，使彩色島名揚海外！\n\n布拉諾島，俗稱「彩色島」，是位於義大利威尼斯鄰近潟湖上的一個島嶼。島上排列著外牆漆成亮色的房屋，這些七彩斑斕的房屋一幢連著一幢，組成彩虹一般的小巷，夾著清澈的河道彎曲延伸，有如童話故事書中的場景。 \n\n島上的居民常年以捕魚為業，一出海就是很長一段時間。思念丈夫的妻子們閒來無事就圍坐在一起，仿造漁網的紋路用棉線編織花邊，繡在衣服上來代表對丈夫的思念。中世紀時，彩色島的蕾絲織品成為皇室的御用品。島上的男人們年復一年出海捕魚維持家計；妻子們則辛勤地編織蕾絲，讓這項手工藝外銷出去。 \n\n身為島上其中一個家族領袖的你，必須妥善地安排家族成員進行合適的工作，使居民們安居樂業，以此來逐步建立起家族的名聲，讓這座沒沒無聞的小島名揚海外，並成為島上的第一家族！', 2015, 480.00, 10, 2, 4, 12, 'game_burano.png'),
(6, '勃根地城堡\nThe Castles of Burgundy', '參賽者分得遊戲金錢，憑擲骰子前進，並利用一些交易策略或方法例如、買地、建樓以賺取租金。遊戲中有多種道具、卡片使用，另外觸發一些「特別事件」。主要通過購買房產，收取對方的路費、租金，來導致對手破產，最後擁有最多資金者獲勝。', 2012, 130.00, 10, 1, 4, 12, 'game_the_castles_of_burgundy.png');

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

--
-- 資料表的匯出資料 `boardgamebooking`
--

INSERT INTO `boardgamebooking` (`BookingID`, `BoardGameID`, `Quantity`, `TotalPrice`, `MemberName`, `Contact`, `OrderDate`, `OrderTime`, `ReceiptDate`, `ReceiptTime`, `Status`) VALUES
(1, 3, 2, 430.00, 'Tom', '12345678', '2016-08-08', '20:00:00', '2016-08-20', '15:00:00', 2);

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

--
-- 資料表的匯出資料 `gatheringbattle`
--

INSERT INTO `gatheringbattle` (`EventID`, `BoardGameID`, `MemberName`, `Account`, `Contact`, `Date`, `Time`, `EndTime`, `Place`, `ParticipantRequirement`, `Status`, `JoinedParticipant`, `JoinedParticipantToken`) VALUES
(1, 1, 'Tom', 'Tom@gmail.com', '12345678', '2016-08-25', '16:00:00', '19:00:00', 1, 4, 0, '[{"nickName":"Tom","extraPeople":""}, {"nickName":"Ken","extraPeople":"2"}]', '[{"token":"Tom@gmail.com"}, {"token":"Ken@gmail.com"}]'),
(2, 3, 'Peter', 'Peter@yahoo.com.hk', '12345678', '2016-08-28', '16:00:00', '20:00:00', 1, 5, -1, '[{"nickName":"Peter","extraPeople":""}, {"nickName":"David","extraPeople":"1"}, {"nickName":"John","extraPeople":""}]', '[{"token":"Peter@yahoo.com.hk"}, {"token":"David@gmail.com"}, {"token":"John@gmail.com"}]'),
(3, 6, 'Mary', 'Mary@gmail.com', '12345678', '2016-08-31', '16:00:00', '17:30:00', 1, 4, -1, '[{"nickName":"Mary","extraPeople":""}]', '[{"token":"Mary@gmail.com"}]');

-- --------------------------------------------------------

--
-- 資料表結構 `indexphoto`
--

CREATE TABLE `indexphoto` (
  `ID` int(11) NOT NULL,
  `PhotoName` varchar(200) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `indexphoto` (`ID`, `PhotoName`, `Status`) VALUES
(1, 'img1.jpg', 1),
(2, 'img2.jpg', 1),
(3, 'img3.jpg', 1),
(4, 'img4.jpg', 1);

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

INSERT INTO `notification` (`NotificationID`, `Title`, `Body`, `Uid`, `Name`, `Date`) VALUES
(1, 'title', 'body', 'UID', 'Name', '2016-08-08');

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

--
-- 資料表的匯出資料 `privatebooking`
--

INSERT INTO `privatebooking` (`BookingID`, `MemberName`, `Account`, `Contact`, `Date`, `Time`, `EndTime`, `Place`, `NumberOfPeople`, `TotalPrice`, `Discount`, `Remark`, `Photo`, `Status`) VALUES
(1, 'Ken', 'Ken@gmail.com', '12345678', '2016-07-23', '12:00:00', '21:00:00', 1, 20, 3340.00, 0.00, '想問有冇飲品食物供應?', NULL, 0);

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
-- 資料表的匯出資料 `users`
--

INSERT INTO `users` (`ID`, `Token`, `Account`, `ReceiveNotification`) VALUES
(1, 'asdasdwX0h2TU-MHJOLWigNmZZtbOKpR6ejW9GFsDqY_IEgBGzbiJ2ulfRSbhqzn9qDZ0f3AKBSAeAb36jAplIoOQLTA9pBVPbByn5UYiwexXJhLDvbvpCSFOKN6p791PgJVbfvddvdsvsdvsvsdvsso', 'Tom@gmail.com', '0'),
(2, 'd1sdfdsfH8F0:APA91bGqHZseKwX0h2TU-MHJOLWigNmZZtbOKpR6ejW9GFsDqY_IEgBGzbiJ2ulfRSbhqzn9qDZ0f3AKBSAeAb36jAplIoOQLTA9pBVPbByn5UYiwexXJhLDvbvpCSFOKN6p79PgJVo', 'Peter@yahoo.com.hk', '0'),
(3, 'd1cxvcxvHH8F0:APA91bGqHZseKwX0h2TU-MHJOLWigNmZZtbOKpR6ejW9GFsDqY_IEgBGzbiJ2ulfRSbhqzn9qDZ0f3AKBSAeAb36jAplIoOQLTA9pBVPbByn5UYiwexXJhLDvbvpCSFOKN6p791PgJ', 'Mary@gmail.com', '0'),
(4, 'dasdasdLwBOHH8F0:APA91bGqHZseKwX0h2TU-MHJOLWigNmZZtbOKpR6ejW9GFsDqY_IEgBGzbiJ2ulfRSbhqzn9qDZ0f3AKBSAeAb36jAplIoOQLTA9pBVPbByn5UYiwexXJhLDvbvpCSFOKN6p7Vo', 'Ken@gmail.com', '0'),
(5, 'dasdasdLwBOHH8F0:APA91bGqHZseKwX0h2TU-MHJOLWigNmZZtbOKpR6ejWfgbfgb_IEgBGzbiJ2ulfRSbhqzn9qDZ0f3AKBSAeAb36jAplIoOQLTA9pBVPbByn5UYiwexXJhLDvbvpCSdFOKN6p7Vo', 'David@gmail.com', '0'),
(6, 'dasdasdLwBOHH8F0:APA91bGqHZseKwX0h2TU-MHJOLWigNmZZtbOKpfvsvsvsDqY_IEgBGzbiJ2ulfRSbhqzn9qDZ0f3AKBSAeAb36jAplIoOQLTA9pBVPbByn5UYiwexXJhLDvbvpCffSFOKN6p7Vo', 'John@gmail.com', '0');

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
  ADD PRIMARY KEY (`BoardGameID`);

--
-- 資料表索引 `boardgamebooking`
--
ALTER TABLE `boardgamebooking`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `boardgamebooking_fk1` (`BoardGameID`);
  
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
-- 資料表索引 `indexphoto`
--
ALTER TABLE `indexphoto`
  ADD PRIMARY KEY (`ID`);
  
--
-- 資料表索引 `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`LocationID`);
  
--
-- 資料表索引 `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`NotificationID`);

--
-- 資料表索引 `privatebooking`
--
ALTER TABLE `privatebooking`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `privatebooking_fk1` (`Place`);
  
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
-- 使用資料表 AUTO_INCREMENT `location`
--
ALTER TABLE `location`
  MODIFY `LocationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- 使用資料表 AUTO_INCREMENT `notification`
--
ALTER TABLE `notification`
  MODIFY `NotificationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- 使用資料表 AUTO_INCREMENT `privatebooking`
--
ALTER TABLE `privatebooking`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
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
