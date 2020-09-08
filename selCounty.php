<?php
require_once "./sql/onnDB.php";
session_start();

$county = "";
if (!isset($_GET["county"])) {
	die("no county found.");
}
$countyId = $_GET["county"];


$sqlStatement = "SELECT * FROM `tbl_towns` WHERE Cos_id = {$countyId}";
$townsResult = mysqli_query($link, $sqlStatement);

$townList = "";
while ($row = mysqli_fetch_assoc($townsResult)) {
    if($row["twn_id"] == $_SESSION["twnid"]){
        $townList .= sprintf("<option value='%s' selected>%s</option>", $row["twn_id"],$row["twn_name"]);
        continue;
    }
    $townList .= sprintf("<option value='%s'>%s</option>", $row["twn_id"],$row["twn_name"]);
}

echo $townList;
?>