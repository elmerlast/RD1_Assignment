<?php

// require_once "./sql/onnDB.php";
// $sql = "select * from tbl_counties";
// $result = mysqli_query($link, $sql);
// $rows = mysqli_fetch_assoc($result);  

$str = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0003-001?Authorization=CWB-8964077E-C7F6-4914-BC85-C744B782392D');
$json = json_decode($str, true);

// var_dump($json);

$location = $json["records"]["location"];

echo count($location);


for($i=0 ; $i<count($location); $i++ ) { 
    echo($location[$i]["parameter"][2]["parameterValue"]);
}


// foreach($location as $value) {

    

// echo($json["records"]["location"][0]["parameter"][2]["parameterValue"]);







    





// );



// $str = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-059?Authorization=CWB-8964077E-C7F6-4914-BC85-C744B782392D');
// $json = json_decode($str, true);
// // var_dump($json, true);

// echo count($json["records"]["locations"][0]["location"]);

?>