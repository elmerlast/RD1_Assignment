<?php

require_once "./sql/onnDB.php";
// $sql = "select * from tbl_counties";
// $result = mysqli_query($link, $sql);
// $rows = mysqli_fetch_assoc($result);  

$str = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization=CWB-8964077E-C7F6-4914-BC85-C744B782392D');
$json = json_decode($str, true);







//從資料庫抓出縣市資料表，新增一個縣市名稱對照縣市編號的陣列
$sql = "select Cos_name from tbl_counties";
$result = mysqli_query($link, $sql);
while($row = mysqli_fetch_row($result)){
    $rows[]=$row;
}
$rows1d = array_column($rows,0); //二維陣列降為一維陣列
$arrayCosId = array_flip($rows1d);


//檢查欲新增縣市鄉鎮參數是否重複
$sql = "select c.Cos_name, t.twn_name from tbl_counties as c INNER join tbl_towns as t on c.Cos_id = t.Cos_id;";
$result = mysqli_query($link, $sql);

$cosTwnname =array();
while($row = mysqli_fetch_assoc($result)){
    $rows = $row["Cos_name"].$row["twn_name"];
    array_push($cosTwnname,$rows);
}



$location = $json["records"]["location"];

$sqlStatement = <<<sql
INSERT INTO `tbl_towns` (`Cos_id`,`twn_name`)
VALUES
sql;





for($i=0 ; $i<count($location); $i++ ) { 
    $cityName = $json["records"]["location"][$i]["parameter"][0]["parameterValue"];
    $addCos_id = $arrayCosId[$cityName]+1;


    $addTwn_Name = $location[$i]["parameter"][2]["parameterValue"];
    $addCosTwnName = "$cityName"."$addTwn_Name";


    array_push($cosTwnname,$addCosTwnName);

    if (count($cosTwnname) != count(array_unique($cosTwnname))) {
        array_pop($cosTwnname);
        continue;
    }
    $sqlStatement = $sqlStatement."({$addCos_id},'{$addTwn_Name}'),";

}

$sqlStatement = substr($sqlStatement,0,-1);
 echo (count($location));
 echo "{$sqlStatement}";





// //從資料庫抓出縣市資料表，新增一個縣市名稱對照縣市編號的陣列
// $sql = "select Cos_name from tbl_counties";
// $result = mysqli_query($link, $sql);
// while($row = mysqli_fetch_row($result)){
//     $rows[]=$row;
// }
// $rows1d = array_column($rows,0); //二維陣列降為一維陣列
// $arrayCosId = array_flip($rows1d);

// foreach($location as $value) {

    

// echo($json["records"]["location"][0]["parameter"][2]["parameterValue"]);







    





// );



// $str = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-059?Authorization=CWB-8964077E-C7F6-4914-BC85-C744B782392D');
// $json = json_decode($str, true);
// // var_dump($json, true);

// echo count($json["records"]["locations"][0]["location"]);

?>