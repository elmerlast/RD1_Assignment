<?php

require_once "./sql/onnDB.php";

//從資料庫抓出縣市資料表，新增一個縣市名稱對照縣市編號的陣列
$sql = "select Cos_name from tbl_counties";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_row($result)) {
    $rows[] = $row;
}
$rows1d = array_column($rows, 0); //二維陣列降為一維陣列
$arrayCosId = array_flip($rows1d);

//從資料庫抓出鄉鎮資料表，新增一個鄉鎮名稱對照鄉鎮編號的陣列
$sql = "select twn_name from tbl_towns";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_row($result)) {
    $twnrows[] = $row;
}
$rows1d = array_column($twnrows, 0); //二維陣列降為一維陣列
$arrayTwnId = array_flip($rows1d);

function insert_7_days_forecast()
{
    global $arrayCosId, $link;

    //確認資料庫是否存在資料，且如果不是最新的資料刪除全部的資料表紀錄
    $sql = "SELECT startTime FROM `tbl_7_days_forecast` where 7_days_id = 1";

    $result = mysqli_query($link, $sql);
    $nums = mysqli_num_rows($result);
    if ($nums > 0) {

        //確認資料庫中的資料是否為最新資料，如果確認的結果式最新資料結束此次函式的呼叫
        $url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-8964077E-C7F6-4914-BC85-C744B782392D&limit=1&elementName=PoP12h';
        $str = file_get_contents($url);
        $json = json_decode($str, true);
        $apiDataCheck = $json["records"]["locations"][0]["location"][0]["weatherElement"][0]["time"][0]["startTime"];
        $dbDataCheck = mysqli_fetch_assoc($result);
        if($apiDataCheck == $dbDataCheck["startTime"]){
            return;
        }

    

        $sql = "delete FROM `tbl_7_days_forecast`";
        mysqli_query($link, $sql) or die("刪除失敗");
    
        $sql = "ALTER TABLE `tbl_7_days_forecast` AUTO_INCREMENT= 1 ;";
        mysqli_query($link, $sql);
    }



    //新增縣市未來一週天氣預報的資料表記錄
    $url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-8964077E-C7F6-4914-BC85-C744B782392D';
    $str = file_get_contents($url);
    $json = json_decode($str, true);



    $sqlStatement = <<<sql
    INSERT INTO `tbl_7_days_forecast` (`Cos_id`, `PoP12h`, `T`, `RH`, `WS`, `Wx`, `MinT`,`WeatherDescription`,`MaxT`,`WD`,`startTime`,`endTime`)
    VALUES
    sql;
    for ($cosIndex = 0; $cosIndex <= 21; $cosIndex++) {
        for ($time = 0; $time <= 13; $time++) {
            $weatherElement = $json["records"]["locations"][0]["location"][$cosIndex]["weatherElement"];
            $locationName = $json["records"]["locations"][0]["location"][$cosIndex]["locationName"];
            $Cos_id = $arrayCosId[$locationName] + 1;
            $PoP12h = $weatherElement[0]["time"][$time]["elementValue"][0]["value"];
            $T = $weatherElement[1]["time"][$time]["elementValue"][0]["value"];
            $RH = $weatherElement[2]["time"][$time]["elementValue"][0]["value"];
            $WS = $weatherElement[4]["time"][$time]["elementValue"][0]["value"];
            $Wx = $weatherElement[6]["time"][$time]["elementValue"][0]["value"];
            $MinT = $weatherElement[8]["time"][$time]["elementValue"][0]["value"];
            $WeatherDescription = $weatherElement[10]["time"][$time]["elementValue"][0]["value"];
            $MaxT = $weatherElement[12]["time"][$time]["elementValue"][0]["value"];
            $WD = $weatherElement[13]["time"][$time]["elementValue"][0]["value"];
            $startTime = $weatherElement[13]["time"][$time]["startTime"];
            $endTime = $weatherElement[13]["time"][$time]["endTime"];

            $sqlStatement = $sqlStatement . "({$Cos_id},'{$PoP12h}','{$T}','{$RH}','{$WS}','{$Wx}','{$MinT}','{$WeatherDescription}','{$MaxT}','{$WD}','{$startTime}','{$endTime}'),";
        }
    }
    $sqlStatement = substr($sqlStatement, 0, -1);
    mysqli_query($link, $sqlStatement) or die("新增失敗！");
}

function insert_3_days_forecast()
{

        global $arrayCosId, $link;

        //確認資料庫是否存在資料，且如果不是最新的資料刪除全部的資料表紀錄
        $sql = "SELECT startTime FROM `tbl_3_days_forecast` where 3_days_id = 1";

        $result = mysqli_query($link, $sql);
        $nums = mysqli_num_rows($result);
        if ($nums > 0) {

        //確認資料庫中的資料是否為最新資料，如果確認的結果式最新資料結束此次函式的呼叫
        $url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-8964077E-C7F6-4914-BC85-C744B782392D&limit=1&elementName=PoP12h';
        $str = file_get_contents($url);
        $json = json_decode($str, true);
        $apiDataCheck = $json["records"]["locations"][0]["location"][0]["weatherElement"][0]["time"][0]["startTime"];
        $dbDataCheck = mysqli_fetch_assoc($result);
        if($apiDataCheck == $dbDataCheck["startTime"]){
            return;
        }
        $sql = "delete FROM `tbl_3_days_forecast`";
        mysqli_query($link, $sql) or die("刪除失敗");

        $sql = "ALTER TABLE `tbl_3_days_forecast` AUTO_INCREMENT= 1 ;";
        mysqli_query($link, $sql);
    }






    //新增縣市未來3天天氣預報的資料表記錄
    $url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-8964077E-C7F6-4914-BC85-C744B782392D';
    $str = file_get_contents($url);
    $json = json_decode($str, true);


    $sqlStatement = <<<sql
    INSERT INTO `tbl_3_days_forecast` (`Cos_id`, `PoP12h`, `PoP6h`, `AT`, `T`, `RH`, `CI`, `WeatherDescription`,`WS`,`WD`,`Wx`, `startTime`,`endTime`)
    VALUES
    sql;
    for ($cosIndex = 0; $cosIndex <= 21; $cosIndex++) {
        for ($time = 0; $time <= 23; $time++) {
            $weatherElement = $json["records"]["locations"][0]["location"][$cosIndex]["weatherElement"];
            $locationName = $json["records"]["locations"][0]["location"][$cosIndex]["locationName"];
            $Cos_id = $arrayCosId[$locationName] + 1;
            $PoP12htime = floor($time / 4);
            $PoP12h = $weatherElement[0]["time"][$PoP12htime]["elementValue"][0]["value"];
            $PoP6htime = floor($time / 2);
            $PoP6h = $weatherElement[7]["time"][$PoP6htime]["elementValue"][0]["value"];
            $AT = $weatherElement[2]["time"][$time]["elementValue"][0]["value"];
            $T = $weatherElement[3]["time"][$time]["elementValue"][0]["value"];
            $RH = $weatherElement[4]["time"][$time]["elementValue"][0]["value"];
            $CI = $weatherElement[5]["time"][$time]["elementValue"][0]["value"];
            $WeatherDescription = $weatherElement[6]["time"][$time]["elementValue"][0]["value"];
            $WS = $weatherElement[8]["time"][$time]["elementValue"][0]["value"];
            $WD = $weatherElement[9]["time"][$time]["elementValue"][0]["value"];
            $Wx = $weatherElement[1]["time"][$time]["elementValue"][0]["value"];
            $startTime = $weatherElement[1]["time"][$time]["startTime"];
            $endTime = $weatherElement[1]["time"][$time]["endTime"];

            $sqlStatement = $sqlStatement . "({$Cos_id},'{$PoP12h}','{$PoP6h}','{$AT}','{$T}','{$RH}','{$CI}','{$WeatherDescription}','{$WS}','{$WD}','{$Wx}','{$startTime}','{$endTime}'),";
        }
    }
    $sqlStatement = substr($sqlStatement, 0, -1);
    mysqli_query($link, $sqlStatement) or die("新增失敗！");

}

function insert_current_weather()
{


    global $arrayCosId, $arrayTwnId, $link;

    //確認資料庫是否存在資料，且如果不是最新的資料刪除全部的資料表紀錄
    $sql = "SELECT obsTime FROM `tbl_current_weather` where wx_id  = 1";

    $result = mysqli_query($link, $sql);
    $nums = mysqli_num_rows($result);
    if ($nums > 0) {
        // 確認資料庫中的資料是否為最新資料，如果確認的結果式最新資料結束此次函式的呼叫
        $nowTime = strtotime("now")+ 3600 * 8;
        if(isset($_SESSION["currentWeatherUpdateTime"]) && $nowTime < $_SESSION["currentWeatherUpdateTime"]){
            return;
        }
        $sql = "delete FROM `tbl_current_weather`";
        mysqli_query($link, $sql) or die("刪除失敗");

        $sql = "ALTER TABLE `tbl_current_weather` AUTO_INCREMENT= 1 ;";
        mysqli_query($link, $sql);
    }


    //新增縣市當前天氣狀況的資料表記錄
    $url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0003-001?Authorization=CWB-8964077E-C7F6-4914-BC85-C744B782392D';
    $str = file_get_contents($url);
    $json = json_decode($str, true);


    $sqlStatement = <<<sql
    INSERT INTO `tbl_current_weather` (`Cos_id`, `twn_id`, `location_name`, `obsTime`, `ELEV`, `WDIR`, `WDSD`, `TEMP`, `HUMD`, `PRES`,`H_24R`,`H_FX`,`H_XD`,`H_FXT`,`H_UVI`,`D_TX`,`D_TN`)
    VALUES
    sql;

    $locationTimes = $json["records"]["location"];
    for ($locationIndex = 0; $locationIndex <= (count($locationTimes) - 1); $locationIndex++) {

        // 透過資料記錄中的城市名稱獲取縣市的編號
        $cityName = $json["records"]["location"][$locationIndex]["parameter"][0]["parameterValue"];
        $Cos_id = $arrayCosId[$cityName] + 1;

        // 透過資料記錄中的鄉鎮名稱獲取鄉鎮的編號
        $townName = $json["records"]["location"][$locationIndex]["parameter"][2]["parameterValue"];
        $twn_id = $arrayTwnId[$townName] + 1;

        $weatherElement = $json["records"]["location"][$locationIndex]["weatherElement"];
        $locationName = $json["records"]["location"][$locationIndex]["locationName"];
        $obsTime = $json["records"]["location"][0]["time"]["obsTime"];
        $ELEV = $weatherElement[0]["elementValue"];
        $WDIR = $weatherElement[1]["elementValue"];
        $WDSD = $weatherElement[2]["elementValue"];
        $TEMP = $weatherElement[3]["elementValue"];
        $HUMD = $weatherElement[4]["elementValue"];
        $PRES = $weatherElement[5]["elementValue"];
        $H_24R = $weatherElement[6]["elementValue"];
        $H_FX = $weatherElement[7]["elementValue"];
        $H_XD = $weatherElement[8]["elementValue"];
        $H_FXT = $weatherElement[9]["elementValue"];
        $H_UVI = $weatherElement[13]["elementValue"];
        $D_TX = $weatherElement[14]["elementValue"];
        $D_TN = $weatherElement[16]["elementValue"];

        $sqlStatement = $sqlStatement . "({$Cos_id},{$twn_id},'{$locationName}','{$obsTime}','{$ELEV}','{$WDIR}','{$WDSD}','{$TEMP}','{$HUMD}','{$PRES}','{$H_24R}','{$H_FX}','{$H_XD}','{$H_FXT}','{$H_UVI}','{$D_TX}','{$D_TN}'),";
    }
    $sqlStatement = substr($sqlStatement, 0, -1);
    // echo "$sqlStatement";
    mysqli_query($link, $sqlStatement) or die("新增失敗");

    $url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0001-001?Authorization=CWB-8964077E-C7F6-4914-BC85-C744B782392D';
    $str = file_get_contents($url);
    $json = json_decode($str, true);

    $sqlStatement = <<<sql
    INSERT INTO `tbl_current_weather` (`Cos_id`, `twn_id`, `location_name`, `obsTime`, `ELEV`, `WDIR`, `WDSD`, `TEMP`, `HUMD`, `PRES`,`H_24R`,`H_FX`,`H_XD`,`H_FXT`,`D_TX`,`D_TN`)
    VALUES
    sql;

    $locationTimes = $json["records"]["location"];
    for ($locationIndex = 0; $locationIndex <= (count($locationTimes) - 1); $locationIndex++) {

        // 透過資料記錄中的城市名稱獲取縣市的編號
        $cityName = $json["records"]["location"][$locationIndex]["parameter"][0]["parameterValue"];
        $Cos_id = $arrayCosId[$cityName] + 1;

        // 透過資料記錄中的鄉鎮名稱獲取鄉鎮的編號
        $townName = $json["records"]["location"][$locationIndex]["parameter"][2]["parameterValue"];
        $twn_id = $arrayTwnId[$townName] + 1;

        $weatherElement = $json["records"]["location"][$locationIndex]["weatherElement"];
        $locationName = $json["records"]["location"][$locationIndex]["locationName"];
        $obsTime = $json["records"]["location"][0]["time"]["obsTime"];
        $ELEV = $weatherElement[0]["elementValue"];
        $WDIR = $weatherElement[1]["elementValue"];
        $WDSD = $weatherElement[2]["elementValue"];
        $TEMP = $weatherElement[3]["elementValue"];
        $HUMD = $weatherElement[4]["elementValue"];
        $PRES = $weatherElement[5]["elementValue"];
        $H_24R = $weatherElement[6]["elementValue"];
        $H_FX = $weatherElement[7]["elementValue"];
        $H_XD = $weatherElement[8]["elementValue"];
        $H_FXT = $weatherElement[9]["elementValue"];
        $D_TX = $weatherElement[10]["elementValue"];
        $D_TN = $weatherElement[12]["elementValue"];

        $sqlStatement = $sqlStatement . "({$Cos_id},{$twn_id},'{$locationName}','{$obsTime}','{$ELEV}','{$WDIR}','{$WDSD}','{$TEMP}','{$HUMD}','{$PRES}','{$H_24R}','{$H_FX}','{$H_XD}','{$H_FXT}','{$D_TX}','{$D_TN}'),";
    }
    $sqlStatement = substr($sqlStatement, 0, -1);
    // echo "$sqlStatement";
    mysqli_query($link, $sqlStatement) or die("新增失敗");

    $_SESSION["currentWeatherUpdateTime"] = strtotime(substr_replace (date("Y-m-d H:i:s",strtotime("+10 minutes")+ 3600 * 8),"0:00", 15));


}

function insert_rainfall_report()
{
    global $arrayCosId, $arrayTwnId, $link;

    //確認資料庫是否存在資料，且如果不是最新的資料刪除全部的資料表紀錄
    $sql = "SELECT * FROM `tbl_rainfall_report` limit 1";

    $result = mysqli_query($link, $sql);
    $nums = mysqli_num_rows($result);
    if ($nums > 0) {
        // 確認資料庫中的資料是否為最新資料，如果確認的結果式最新資料結束此次函式的呼叫
        $nowTime = strtotime("now")+ 3600 * 8;
        if(isset($_SESSION["rainfallUpdateTime"]) && $nowTime < $_SESSION["rainfallUpdateTime"]){
            return;
        }
        $sql = "delete FROM `tbl_rainfall_report`";
        mysqli_query($link, $sql) or die("刪除失敗");

        $sql = "ALTER TABLE `tbl_rainfall_report` AUTO_INCREMENT= 1 ;";
        mysqli_query($link, $sql);
    }

    //新增各縣市觀測站過去1小時、24小時累積雨量的資料表記錄
    $url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization=CWB-8964077E-C7F6-4914-BC85-C744B782392D';
    $str = file_get_contents($url);
    $json = json_decode($str, true);



    $sqlStatement = <<<sql
    INSERT INTO `tbl_rainfall_report` (`Cos_id`, `twn_id`,`location_name`, `ELEV`, `RAIN`, `HOUR_24`, `NOW`)
    VALUES
    sql;

    $locationTimes = $json["records"]["location"];
    for ($locationIndex = 0; $locationIndex <= (count($locationTimes) - 1); $locationIndex++) {

        // 透過資料記錄中的城市名稱獲取縣市的編號
        $cityName = $json["records"]["location"][$locationIndex]["parameter"][0]["parameterValue"];
        $Cos_id = $arrayCosId[$cityName] + 1;

        // 透過資料記錄中的鄉鎮名稱獲取鄉鎮的編號
        $townName = $json["records"]["location"][$locationIndex]["parameter"][2]["parameterValue"];
        $twn_id = $arrayTwnId[$townName] + 1;

        $weatherElement = $json["records"]["location"][$locationIndex]["weatherElement"];
        $locationName = $json["records"]["location"][$locationIndex]["locationName"];
        $ELEV = $weatherElement[0]["elementValue"];
        $RAIN = $weatherElement[1]["elementValue"];
        $HOUR_24 = $weatherElement[6]["elementValue"];
        $NOW = $weatherElement[7]["elementValue"];
        $sqlStatement = $sqlStatement . "({$Cos_id},{$twn_id},'{$locationName}','{$ELEV}','{$RAIN}','{$HOUR_24}','{$NOW}'),";
    }
    $sqlStatement = substr($sqlStatement, 0, -1);
    // echo "$sqlStatement";
    mysqli_query($link, $sqlStatement) or die("新增失敗");
    $_SESSION["rainfallUpdateTime"] = strtotime(substr_replace (date("Y-m-d H:i:s",strtotime("+10 minutes")+ 3600 * 8),"0:00", 15));


}



function get_chinese_weekday($datetime)
{
    $weekday = date('w', strtotime($datetime));
    return '星期' . ['日', '一', '二', '三', '四', '五', '六'][$weekday];
}

function iszero($data)
{
    if($data < 0){
        $data = "0.00";
    }
    return $data;
}


