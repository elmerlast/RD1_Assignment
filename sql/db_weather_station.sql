CREATE DATABASE db_weather_station DEFAULT CHARACTER SET utf8;

use db_weather_station;


--
-- 建立縣市(tbl_category)資料表結構
--

CREATE TABLE `tbl_counties` (
  `Cos_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Cos_name` varchar(100) NOT NULL,
  PRIMARY KEY (`Cos_id`)
)ENGINE=InnoDB;



--
-- 新增縣市(tbl_category)資料表記錄
--

INSERT INTO `tbl_counties` (`Cos_name`)
VALUES
('雲林縣'),
('南投縣'),
('連江縣'),
('臺東縣'),
('金門縣'),
('宜蘭縣'),
('屏東縣'),
('苗栗縣'),
('澎湖縣'),
('臺北市'),
('新竹縣'),
('花蓮縣'),
('高雄市'),
('彰化縣'),
('新竹市'),
('新北市'),
('基隆市'),
('臺中市'),
('臺南市'),
('桃園市'),
('嘉義縣'),
('嘉義市');


--
-- 建立鄉鎮(tbl_towns)資料表結構
--

CREATE TABLE `tbl_towns` (
  `twn_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `twn_name` varchar(100) NOT NULL,
  PRIMARY KEY (`twn_id`)
)ENGINE=InnoDB;




--
-- 建立未來一週天氣預報(tbl_7_days_forecast)資料表結構
--

CREATE TABLE `tbl_7_days_forecast` (
    `7_days_id` int(10) NOT NULL AUTO_INCREMENT,
    `Cos_id` int(11) UNSIGNED NOT NULL,
    `PoP12h` varchar(10) NOT NULL,
    `T` varchar(10) NOT NULL,
    `RH` varchar(10) NOT NULL,
    `WS` varchar(10) NOT NULL,
    `MinT` varchar(10) NOT NULL,
    `MaxT` varchar(10) NOT NULL,
    `Wx` varchar(50) NOT NULL,
    `WeatherDescription` varchar(150) NOT NULL,
    `WD` varchar(20) NOT NULL,
    `startTime` varchar(30) NOT NULL,
    `endTime` varchar(30) NOT NULL,
    PRIMARY KEY (`7_days_id`),
    constraint `fk_7_days_forecast_counties` foreign key (Cos_id) references `tbl_counties` (Cos_id) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB ;




--
-- 建立未來3天天氣預報(tbl_3_days_forecast)資料表結構
--

CREATE TABLE `tbl_3_days_forecast` (
    `3_days_id` int(10) NOT NULL AUTO_INCREMENT,
    `Cos_id` int(11) UNSIGNED NOT NULL,
    `PoP12h` varchar(10) NOT NULL,
    `PoP6h` varchar(10) NOT NULL,
    `AT` varchar(10) NOT NULL,
    `T` varchar(10) NOT NULL,
    `RH` varchar(10) NOT NULL,
    `CI` varchar(10) NOT NULL,
    `WeatherDescription` varchar(150) NOT NULL,
    `WS` varchar(10) NOT NULL,
    `WD` varchar(15) NOT NULL,
    `startTime` varchar(30) NOT NULL,
    `endTime` varchar(30) NOT NULL,
    PRIMARY KEY (`3_days_id`),
    constraint `fk_3_days_forecast_counties` foreign key (Cos_id) references `tbl_counties` (Cos_id) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB ;


CREATE TABLE `tbl_3_days_forecast` (
    `3_days_id` int(10) NOT NULL AUTO_INCREMENT,
    `Cos_id` int(11) UNSIGNED NOT NULL,
    `PoP12h` varchar(10) NOT NULL,
    `PoP6h` varchar(10) NOT NULL,
    `AT` varchar(10) NOT NULL,
    `T` varchar(10) NOT NULL,
    `RH` varchar(10) NOT NULL,
    `CI` varchar(10) NOT NULL,
    `WeatherDescription` varchar(150) NOT NULL,
    `WS` varchar(10) NOT NULL,
    `WD` varchar(15) NOT NULL,
    `startTime` varchar(30) NOT NULL,
    `endTime` varchar(30) NOT NULL,
    PRIMARY KEY (`3_days_id`),
    constraint `fk_3_days_forecast_counties` foreign key (Cos_id) references `tbl_counties` (Cos_id) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB ;


















