<?php
require_once "./sql/onnDB.php";

$county = "";
if (!isset($_GET["county"])) {
	die("no county found.");
}
$countyId = $_GET["county"];

$sqlStatement = "SELECT * FROM `tbl_towns` WHERE Cos_id = {$countyId}";
$townsResult = mysqli_query($link, $sqlStatement);

$townList = "";
while ($row = mysqli_fetch_assoc($townsResult)) {
    $townList .= sprintf("<option value='%s'>%s</option>", $row["twn_id"],$row["twn_name"]);
}

echo $townList;
?>