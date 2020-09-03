<?php

require_once "./sql/onnDB.php";
$url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-8964077E-C7F6-4914-BC85-C744B782392D';
$str = file_get_contents($url);
$json = json_decode($str, true);





//從資料庫抓出縣市資料表，新增一個縣市名稱對照縣市編號的陣列
$sql = "select Cos_name from tbl_counties";
$result = mysqli_query($link, $sql);
while($row = mysqli_fetch_row($result)){
    $rows[]=$row;
}
$rows1d = array_column($rows,0); //二維陣列降為一維陣列
$arrayCosId = array_flip($rows1d);




//新增縣市未來一週天氣預報的資料表記錄
$sqlStatement = <<<sql
INSERT INTO `tbl_7_days_forecast` (`Cos_id`, `PoP12h`, `T`, `RH`, `WS`, `Wx`, `MinT`,`WeatherDescription`,`MaxT`,`WD`,`startTime`,`endTime`)
VALUES
sql;
for($cosIndex=0 ; $cosIndex<=21; $cosIndex++ ) { 
    for($time=0 ; $time<=13; $time++ ) { 
        $weatherElement = $json["records"]["locations"][0]["location"][$cosIndex]["weatherElement"];
        $locationName = $json["records"]["locations"][0]["location"][$cosIndex]["locationName"];
        $Cos_id = $arrayCosId[$locationName]+1;
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

        $sqlStatement = $sqlStatement."({$Cos_id},'{$PoP12h}','{$T}','{$RH}','{$WS}','{$Wx}','{$MinT}','{$WeatherDescription}','{$MaxT}','{$WD}','{$startTime}','{$endTime}'),";
    }
}
$sqlStatement = substr($sqlStatement,0,-1);
mysqli_query($link, $sqlStatement) or die("新增失敗！");



//新增縣市未來3天天氣預報的資料表記錄
$url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-8964077E-C7F6-4914-BC85-C744B782392D';
$str = file_get_contents($url);
$json = json_decode($str, true);


 $sqlStatement = <<<sql
INSERT INTO `tbl_3_days_forecast` (`Cos_id`, `PoP12h`, `PoP6h`, `AT`, `T`, `RH`, `CI`, `WeatherDescription`,`WS`,`WD`,`startTime`,`endTime`)
VALUES
sql;
for($cosIndex=0 ; $cosIndex<=21; $cosIndex++ ) { 
    for($time=0 ; $time<=23; $time++ ) { 
        $weatherElement = $json["records"]["locations"][0]["location"][$cosIndex]["weatherElement"];
        $locationName = $json["records"]["locations"][0]["location"][$cosIndex]["locationName"];
        $Cos_id = $arrayCosId[$locationName]+1;
        $PoP12htime = floor($time/4);
        $PoP12h = $weatherElement[0]["time"][$PoP12htime]["elementValue"][0]["value"];
        $PoP6htime = floor($time/2);
        $PoP6h = $weatherElement[7]["time"][$PoP6htime]["elementValue"][0]["value"];
        $AT = $weatherElement[2]["time"][$time]["elementValue"][0]["value"];
        $T = $weatherElement[3]["time"][$time]["elementValue"][0]["value"];
        $RH = $weatherElement[4]["time"][$time]["elementValue"][0]["value"];
        $CI = $weatherElement[5]["time"][$time]["elementValue"][0]["value"];
        $WeatherDescription = $weatherElement[6]["time"][$time]["elementValue"][0]["value"];
        $WS = $weatherElement[8]["time"][$time]["elementValue"][0]["value"];
        $WD = $weatherElement[9]["time"][$time]["elementValue"][0]["value"];
        $startTime = $weatherElement[1]["time"][$time]["startTime"];
        $endTime = $weatherElement[1]["time"][$time]["endTime"];

        $sqlStatement = $sqlStatement."({$Cos_id},'{$PoP12h}','{$PoP6h}','{$AT}','{$T}','{$RH}','{$CI}','{$WeatherDescription}','{$WS}','{$WD}','{$startTime}','{$endTime}'),";
    }
}
$sqlStatement = substr($sqlStatement,0,-1);
 mysqli_query($link, $sqlStatement) or die("新增失敗！");




//新增縣市天天氣預報的資料表記錄
$url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0003-001?Authorization=CWB-8964077E-C7F6-4914-BC85-C744B782392D';
$str = file_get_contents($url);
$json = json_decode($str, true);


 $sqlStatement = <<<sql
INSERT INTO `tbl_3_days_forecast` (`Cos_id`, `PoP12h`, `PoP6h`, `AT`, `T`, `RH`, `CI`, `WeatherDescription`,`WS`,`WD`,`startTime`,`endTime`)
VALUES
sql;
for($cosIndex=0 ; $cosIndex<=21; $cosIndex++ ) { 
    for($time=0 ; $time<=23; $time++ ) { 
        $weatherElement = $json["records"]["locations"][0]["location"][$cosIndex]["weatherElement"];
        $locationName = $json["records"]["locations"][0]["location"][$cosIndex]["locationName"];
        $Cos_id = $arrayCosId[$locationName]+1;
        $PoP12htime = floor($time/4);
        $PoP12h = $weatherElement[0]["time"][$PoP12htime]["elementValue"][0]["value"];
        $PoP6htime = floor($time/2);
        $PoP6h = $weatherElement[7]["time"][$PoP6htime]["elementValue"][0]["value"];
        $AT = $weatherElement[2]["time"][$time]["elementValue"][0]["value"];
        $T = $weatherElement[3]["time"][$time]["elementValue"][0]["value"];
        $RH = $weatherElement[4]["time"][$time]["elementValue"][0]["value"];
        $CI = $weatherElement[5]["time"][$time]["elementValue"][0]["value"];
        $WeatherDescription = $weatherElement[6]["time"][$time]["elementValue"][0]["value"];
        $WS = $weatherElement[8]["time"][$time]["elementValue"][0]["value"];
        $WD = $weatherElement[9]["time"][$time]["elementValue"][0]["value"];
        $startTime = $weatherElement[1]["time"][$time]["startTime"];
        $endTime = $weatherElement[1]["time"][$time]["endTime"];

        $sqlStatement = $sqlStatement."({$Cos_id},'{$PoP12h}','{$PoP6h}','{$AT}','{$T}','{$RH}','{$CI}','{$WeatherDescription}','{$WS}','{$WD}','{$startTime}','{$endTime}'),";
    }
}
$sqlStatement = substr($sqlStatement,0,-1);
 mysqli_query($link, $sqlStatement) or die("新增失敗！");












?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
<!-- Custom styles for this template -->
<!-- <link rel="stylesheet" type="text/css" href="/RD5_Assignment/CSS/grid.css"> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<body>
    

</body>

<script>

</script>




</html>
