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
  `Cos_id` int(11) UNSIGNED NOT NULL,
  `twn_name` varchar(100) NOT NULL,
  PRIMARY KEY (`twn_id`),
  constraint `fk_towns_counties` foreign key (Cos_id) references `tbl_counties` (Cos_id) ON UPDATE CASCADE ON DELETE CASCADE

)ENGINE=InnoDB;


--
-- 新增縣市鄉鎮(tbl_category)資料表記錄
--


INSERT INTO `tbl_towns` (`twn_id`, `Cos_id`, `twn_name`) VALUES
(1, 16, '烏來區'),
(2, 19, '安平區'),
(3, 4, '東河鄉'),
(4, 16, '貢寮區'),
(5, 2, '仁愛鄉'),
(6, 21, '大林鎮'),
(7, 12, '玉里鎮'),
(8, 22, '東區'),
(9, 6, '頭城鎮'),
(10, 16, '平溪區'),
(11, 1, '斗六市'),
(12, 2, '魚池鄉'),
(13, 4, '海端鄉'),
(14, 7, '竹田鄉'),
(15, 8, '造橋鄉'),
(16, 16, '石門區'),
(17, 8, '頭屋鄉'),
(18, 19, '下營區'),
(19, 7, '萬丹鄉'),
(20, 16, '三峽區'),
(21, 14, '大城鄉'),
(22, 18, '大里區'),
(23, 18, '西屯區'),
(24, 4, '鹿野鄉'),
(25, 21, '太保市'),
(26, 19, '學甲區'),
(27, 7, '新園鄉'),
(28, 18, '清水區'),
(29, 19, '新化區'),
(30, 18, '石岡區'),
(31, 7, '枋山鄉'),
(32, 7, '滿州鄉'),
(33, 7, '恆春鎮'),
(34, 20, '楊梅區'),
(35, 4, '卑南鄉'),
(36, 21, '六腳鄉'),
(37, 1, '斗南鎮'),
(38, 19, '北區'),
(39, 1, '古坑鄉'),
(40, 7, '內埔鄉'),
(41, 4, '太麻里鄉'),
(42, 6, '礁溪鄉'),
(43, 16, '樹林區'),
(44, 19, '官田區'),
(45, 13, '燕巢區'),
(46, 6, '南澳鄉'),
(47, 14, '溪州鄉'),
(48, 14, '伸港鄉'),
(49, 1, '土庫鎮'),
(50, 12, '壽豐鄉'),
(51, 19, '將軍區'),
(52, 13, '永安區'),
(53, 2, '草屯鎮'),
(54, 21, '竹崎鄉'),
(55, 7, '屏東市'),
(56, 2, '國姓鄉'),
(57, 16, '石碇區'),
(58, 18, '豐原區'),
(59, 10, '北投區'),
(60, 16, '五股區'),
(61, 12, '豐濱鄉'),
(62, 1, '褒忠鄉'),
(63, 12, '卓溪鄉'),
(64, 6, '大同鄉'),
(65, 4, '成功鎮'),
(66, 13, '旗津區'),
(67, 2, '南投市'),
(68, 13, '大樹區'),
(69, 9, '西嶼鄉'),
(70, 7, '高樹鄉'),
(71, 21, '梅山鄉'),
(72, 4, '延平鄉'),
(73, 18, '和平區'),
(74, 8, '卓蘭鎮'),
(75, 19, '楠西區'),
(76, 7, '崁頂鄉'),
(77, 14, '二水鄉'),
(78, 7, '春日鄉'),
(79, 19, '大內區'),
(80, 7, '車城鄉'),
(81, 4, '達仁鄉'),
(82, 19, '南區'),
(83, 13, '美濃區'),
(84, 14, '芬園鄉'),
(85, 16, '鶯歌區'),
(86, 19, '南化區'),
(87, 19, '仁德區'),
(88, 18, '北屯區'),
(89, 21, '水上鄉'),
(90, 13, '鼓山區'),
(91, 12, '瑞穗鄉'),
(92, 12, '光復鄉'),
(93, 14, '鹿港鎮'),
(94, 19, '左鎮區'),
(95, 6, '員山鄉'),
(96, 12, '秀林鄉'),
(97, 18, '潭子區'),
(98, 20, '大園區'),
(99, 14, '福興鄉'),
(100, 13, '楠梓區'),
(101, 16, '汐止區'),
(102, 7, '潮州鎮'),
(103, 11, '竹東鎮'),
(104, 2, '集集鎮'),
(105, 12, '富里鄉'),
(106, 20, '大溪區'),
(107, 11, '尖石鄉'),
(108, 19, '西港區'),
(109, 14, '北斗鎮'),
(110, 4, '關山鎮'),
(111, 18, '神岡區'),
(112, 20, '平鎮區'),
(113, 13, '桃源區'),
(114, 21, '義竹鄉'),
(115, 16, '坪林區'),
(116, 8, '獅潭鄉'),
(117, 1, '大埤鄉'),
(118, 14, '田中鎮'),
(119, 1, '臺西鄉'),
(120, 13, '仁武區'),
(121, 18, '南屯區'),
(122, 16, '新店區'),
(123, 13, '阿蓮區'),
(124, 7, '牡丹鄉'),
(125, 7, '新埤鄉'),
(126, 18, '后里區'),
(127, 16, '瑞芳區'),
(128, 7, '鹽埔鄉'),
(129, 18, '烏日區'),
(130, 21, '阿里山鄉'),
(131, 14, '芳苑鄉'),
(132, 7, '林邊鄉'),
(133, 19, '六甲區'),
(134, 16, '雙溪區'),
(135, 7, '琉球鄉'),
(136, 19, '新市區'),
(137, 13, '橋頭區'),
(138, 16, '中和區'),
(139, 7, '麟洛鄉'),
(140, 19, '善化區'),
(141, 16, '三芝區'),
(142, 13, '三民區'),
(143, 19, '佳里區'),
(144, 14, '花壇鄉'),
(145, 16, '萬里區'),
(146, 6, '羅東鎮'),
(147, 4, '大武鄉'),
(148, 13, '杉林區'),
(149, 5, '金寧鄉'),
(150, 18, '大肚區'),
(151, 1, '北港鎮'),
(152, 7, '瑪家鄉'),
(153, 13, '六龜區'),
(154, 4, '長濱鄉'),
(155, 4, '金峰鄉'),
(156, 13, '湖內區'),
(157, 16, '深坑區'),
(158, 1, '崙背鄉'),
(159, 2, '名間鄉'),
(160, 21, '大埔鄉'),
(161, 14, '埔心鄉'),
(162, 15, '東區'),
(163, 8, '後龍鎮'),
(164, 12, '吉安鄉'),
(165, 2, '信義鄉'),
(166, 14, '二林鎮'),
(167, 13, '大寮區'),
(168, 4, '蘭嶼鄉'),
(169, 20, '桃園區'),
(170, 13, '林園區'),
(171, 10, '士林區'),
(172, 1, '水林鄉'),
(173, 11, '關西鎮'),
(174, 8, '南庄鄉'),
(175, 19, '歸仁區'),
(176, 10, '南港區'),
(177, 1, '元長鄉'),
(178, 19, '後壁區'),
(179, 16, '新莊區'),
(180, 19, '山上區'),
(181, 18, '大甲區'),
(182, 7, '萬巒鄉'),
(183, 8, '竹南鎮'),
(184, 10, '內湖區'),
(185, 18, '太平區'),
(186, 19, '安南區'),
(187, 21, '民雄鄉'),
(188, 10, '松山區'),
(189, 13, '甲仙區'),
(190, 4, '池上鄉'),
(191, 16, '金山區'),
(192, 19, '玉井區'),
(193, 20, '復興區'),
(194, 8, '大湖鄉'),
(195, 17, '中正區'),
(196, 6, '三星鄉'),
(197, 14, '埔鹽鄉'),
(198, 18, '東勢區'),
(199, 16, '林口區'),
(200, 12, '鳳林鎮'),
(201, 7, '佳冬鄉'),
(202, 1, '莿桐鄉'),
(203, 2, '埔里鎮'),
(204, 19, '鹽水區'),
(205, 17, '七堵區'),
(206, 7, '九如鄉'),
(207, 13, '鳳山區'),
(208, 13, '茂林區'),
(209, 7, '獅子鄉'),
(210, 1, '林內鄉'),
(211, 13, '彌陀區'),
(212, 6, '五結鄉'),
(213, 19, '北門區'),
(214, 8, '苑裡鎮'),
(215, 1, '虎尾鎮'),
(216, 21, '溪口鄉'),
(217, 11, '寶山鄉'),
(218, 7, '東港鎮'),
(219, 8, '西湖鄉'),
(220, 14, '埤頭鄉'),
(221, 14, '竹塘鄉'),
(222, 16, '土城區'),
(223, 14, '線西鄉'),
(224, 21, '中埔鄉'),
(225, 7, '枋寮鄉'),
(226, 13, '大社區'),
(227, 8, '頭份市'),
(228, 13, '左營區'),
(229, 19, '七股區'),
(230, 1, '四湖鄉'),
(231, 21, '朴子市'),
(232, 15, '香山區'),
(233, 21, '東石鄉'),
(234, 11, '新豐鄉'),
(235, 19, '新營區'),
(236, 1, '東勢鄉'),
(237, 13, '旗山區'),
(238, 14, '社頭鄉'),
(239, 1, '二崙鄉'),
(240, 12, '萬榮鄉'),
(241, 18, '新社區'),
(242, 20, '蘆竹區'),
(243, 2, '水里鄉'),
(244, 10, '文山區'),
(245, 7, '南州鄉'),
(246, 8, '通霄鎮'),
(247, 11, '橫山鄉'),
(248, 1, '西螺鎮'),
(249, 12, '新城鄉'),
(250, 16, '八里區'),
(251, 21, '番路鄉'),
(252, 13, '小港區'),
(253, 8, '泰安鄉'),
(254, 13, '梓官區'),
(255, 8, '苗栗市'),
(256, 14, '溪湖鎮'),
(257, 5, '金沙鎮'),
(258, 19, '安定區'),
(259, 2, '鹿谷鄉'),
(260, 19, '白河區'),
(261, 8, '三灣鄉'),
(262, 14, '員林市'),
(263, 19, '東山區'),
(264, 10, '信義區'),
(265, 3, '莒光鄉'),
(266, 19, '麻豆區'),
(267, 7, '三地門鄉'),
(268, 20, '中壢區'),
(269, 9, '望安鄉'),
(270, 18, '龍井區'),
(271, 13, '岡山區'),
(272, 14, '秀水鄉'),
(273, 20, '觀音區'),
(274, 21, '新港鄉'),
(275, 7, '霧臺鄉'),
(276, 19, '關廟區'),
(277, 1, '口湖鄉'),
(278, 11, '新埔鎮'),
(279, 19, '柳營區'),
(280, 8, '銅鑼鄉'),
(281, 18, '外埔區'),
(282, 18, '大雅區'),
(283, 4, '綠島鄉'),
(284, 13, '路竹區'),
(285, 21, '鹿草鄉'),
(286, 13, '內門區'),
(287, 11, '湖口鄉'),
(288, 13, '茄萣區'),
(289, 6, '冬山鄉'),
(290, 14, '田尾鄉'),
(291, 7, '里港鄉'),
(292, 7, '長治鄉'),
(293, 6, '壯圍鄉'),
(294, 21, '布袋鎮'),
(295, 2, '竹山鎮'),
(296, 13, '田寮區'),
(297, 20, '龜山區'),
(298, 4, '臺東市'),
(299, 2, '中寮鄉'),
(300, 19, '龍崎區'),
(301, 8, '三義鄉'),
(302, 16, '永和區'),
(303, 7, '來義鄉'),
(304, 11, '峨眉鄉'),
(305, 16, '蘆洲區'),
(306, 16, '三重區'),
(307, 11, '五峰鄉'),
(308, 22, '西區'),
(309, 8, '公館鄉'),
(310, 10, '大安區'),
(311, 10, '中正區'),
(312, 9, '白沙鄉'),
(313, 20, '新屋區'),
(314, 18, '霧峰區'),
(315, 18, '梧棲區'),
(316, 13, '前鎮區'),
(317, 18, '沙鹿區'),
(318, 17, '仁愛區'),
(319, 14, '彰化市'),
(320, 18, '北區'),
(321, 14, '大村鄉'),
(322, 11, '竹北市'),
(323, 16, '淡水區'),
(324, 5, '烈嶼鄉'),
(325, 9, '馬公市'),
(326, 16, '板橋區'),
(327, 6, '宜蘭市'),
(328, 6, '蘇澳鎮'),
(329, 1, '麥寮鄉'),
(330, 5, '金城鎮'),
(331, 5, '金湖鎮'),
(332, 14, '和美鎮'),
(333, 19, '中西區'),
(334, 12, '花蓮市'),
(335, 3, '南竿鄉'),
(336, 19, '永康區'),
(337, 20, '八德區'),
(338, 10, '中山區'),
(339, 15, '北區'),
(340, 10, '大同區'),
(341, 20, '龍潭區'),
(342, 10, '萬華區'),
(343, 11, '芎林鄉'),
(344, 13, '新興區'),
(345, 13, '那瑪夏區'),
(346, 11, '北埔鄉'),
(347, 13, '苓雅區'),
(348, 18, '大安區'),
(349, 7, '泰武鄉');





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



--
-- 建立縣市當前天氣狀況(tbl_current_weather)資料表結構
--

CREATE TABLE `tbl_current_weather` (
    `wx_id` int(10) NOT NULL AUTO_INCREMENT,
    `Cos_id` int(11) UNSIGNED NOT NULL,
    `twn_id` int(11) UNSIGNED NOT NULL,
    `location_name` varchar(50) NOT NULL,
    `ELEV` varchar(10) NOT NULL,
    `WDIR` varchar(10) NOT NULL,
    `WDSD` varchar(10) NOT NULL,
    `TEMP` varchar(10) NOT NULL,
    `HUMD` varchar(10) NOT NULL,
    `PRES` varchar(150) NOT NULL,
    `H_24R` varchar(10) NOT NULL,
    `H_FX` varchar(15) NOT NULL,
    `H_XD` varchar(30) NOT NULL,
    `H_FXT` varchar(30) NOT NULL,
    `H_UVI` varchar(30) DEFAULT NULL,
    `D_TX` varchar(30) NOT NULL,
    `D_TN` varchar(30) NOT NULL,
    PRIMARY KEY (`wx_id`),
    constraint `fk_current_weather_counties` foreign key (Cos_id) references `tbl_counties` (Cos_id) ON UPDATE CASCADE ON DELETE CASCADE,
    constraint `fk_current_weather_towns` foreign key (twn_id) references `tbl_towns` (twn_id) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB ;




--
-- 建立各縣市觀測站過去1小時、24小時累積雨量(tbl_rainfall_report)資料表結構
--

CREATE TABLE `tbl_rainfall_report` (
    `rf_id` int(10) NOT NULL AUTO_INCREMENT,
    `Cos_id` int(11) UNSIGNED NOT NULL,
    `twn_id` int(11) UNSIGNED NOT NULL,
    `location_name` varchar(50) NOT NULL,
    `ELEV` varchar(20) NOT NULL,
    `RAIN` varchar(20) NOT NULL,
    `HOUR_24` varchar(20) NOT NULL,
    `NOW` varchar(20) NOT NULL,
    PRIMARY KEY (`rf_id`),
    constraint `fk_rainfall_report_counties` foreign key (Cos_id) references `tbl_counties` (Cos_id) ON UPDATE CASCADE ON DELETE CASCADE,
    constraint `fk_rainfall_report_towns` foreign key (twn_id) references `tbl_towns` (twn_id) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB ;









//檢查欲新增縣市鄉鎮參數是否重複
$sql = "select c.Cos_name, t.twn_name from tbl_counties as c INNER join tbl_towns as t on c.Cos_id = t.Cos_id;";
$result = mysqli_query($link, $sql);

$cosTwnname =array();
while($row = mysqli_fetch_assoc($result)){
    $rows = $row["Cos_name"].$row["twn_name"];
    array_push($cosTwnname,$rows);
}












