<?php
require_once "./sql/onnDB.php";
require_once "./storage.php";
session_start();
insert_current_weather();

$sqlStatement = "SELECT * FROM `tbl_counties`";
$countiesResult = mysqli_query($link, $sqlStatement);

$sqlStatement = "SELECT * FROM `tbl_towns`";
$townsResult = mysqli_query($link, $sqlStatement);

//從資料庫抓出縣市資料表，新增一個縣市名稱對照縣市編號的陣列
$arraygetCosId =array();
while($row = mysqli_fetch_assoc($townsResult)){
    $arraygetCosId[$row["twn_id"]] = $row["Cos_id"];
}
mysqli_data_seek($townsResult,0);




if (isset($_POST["selTown"])) {
  $_POST["selCounties"] = $arraygetCosId[$_POST["selTown"]];
  
  $sqlStatement = <<<mulity
  select wx_id, Cos_id, twn_id, location_name,`ELEV`, `WDIR`, `WDSD`, `TEMP`, `HUMD`,`H_UVI`,`D_TX`,`D_TN`
  from  tbl_current_weather
  where twn_id = {$_POST["selTown"]};
  mulity;
  $result = mysqli_query($link, $sqlStatement);

}else{
  $_POST["selCounties"] = 10;
  $_POST["selTown"] = 311;
  $sqlStatement = <<<mulity
  select wx_id, Cos_id, twn_id, location_name,`ELEV`, `WDIR`, `WDSD`, `TEMP`, `HUMD`,`H_UVI`,`D_TX`,`D_TN`
  from  tbl_current_weather
  where Cos_id = 10 and twn_id = 311;
  mulity;
  $result = mysqli_query($link, $sqlStatement);
}

$_SESSION["twnid"] = $_POST["selTown"];

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>個人氣象站</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="\PID_Assignment\css\bootstrap.min.css">
  <link rel="stylesheet" href="\PID_Assignment\css\store_index.css">
  <script src="\PID_Assignment\js\jquery.min.js"></script>
  <script src="\PID_Assignment\js\bootstrap.min.js"></script>

</head>

<body>


  <nav class="navbar navbar-expand-sm navbar-light sticky-top" style="background-color: #e3f2fd;">
    <div class="navbar-brand">個人氣象站</div>
    <li style="list-style-type:none" class="nav-item dropdown">
        <div class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            當前天氣
        </div>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="rainfall.php">雨量觀測</a>
          <a class="dropdown-item" href="index.php">天氣預報</a>
        </div>
    </li>
  </nav>




  <div class="container">
    <h1 style="text-align:center;">縣市當前天氣即時資訊</h1>
    <form method="post" action="">
      <div class="row">
          <div class="col-2">
            <select class="form-control" name="selCounties" id="selCounties">
              <?php while ($row = mysqli_fetch_assoc($countiesResult)) {?>
              <option value="<?=$row["Cos_id"]?>" <?php if ($row["Cos_id"] == $_POST["selCounties"]) {echo "selected";}?>>
                <?=$row["Cos_name"]?></option>
              <?php $arrayCosImg[$row["Cos_id"]] = $row["Cos_img"];
              }?>
            </select>&nbsp;&nbsp;
          </div>
          <div class="col-2">
            <select class="form-control" name="selTown" id="selTown">
              <?php while ($row = mysqli_fetch_assoc($townsResult)) {?>
              <option value="<?=$row["twn_id"]?>" <?php if ($row["twn_id"] == $_POST["selTown"]) {echo "selected";}?>>
                <?=$row["twn_name"]?></option>
              <?php }?>
            </select>&nbsp;&nbsp;
          </div>
          <div class="col">
            <button type="submit" class="btn btn-info" name="btnCounties" id="btnCounties" value="btnCounties">確定</button>
          </div>
          <div class="col text-right">
            <img class="card-img-top" src="<?php if(isset($_POST["selCounties"])){echo("{$arrayCosImg[$_POST["selCounties"]]}");}else{echo('img/taipei.jpg');}?>" alt="沒有圖片">
          </div>

      </div>
    </form>



        </div>

  </div>

      </div>
  <div class="container">
    <table class="table ">
      <thead class="thead-light">
        <tr style="text-align:center;">
          <th scope="col">名稱</th>
          <th scope="col">站點高度</th>
          <th scope="col">溫度</th>
          <th scope="col">濕度</th>
          <th scope="col">風向(度)</th>
          <th scope="col">風速</th>
          <th scope="col">日最高溫</th>
          <th scope="col">日最低溫</th>




        </tr>
      </thead>
      <tbody>
        
          <?php while ($row = mysqli_fetch_assoc($result)){?>
          <tr style="text-align: center;">
            <td scope="col"><?=$row["location_name"] ?></td>
            <td scope="col"><?=isdatanull($row["ELEV"])?></td>
            <td scope="col"><?=isdatanull($row["TEMP"]) ?></td>
            <td scope="col"><?=isdatanull($row["HUMD"]) ?></td>
            <td scope="col"><?=isdatanull($row["WDIR"]) ?></td>
            <td scope="col"><?=isdatanull($row["WDSD"]) ?></td>
            <td scope="col"><?=isdatanull($row["D_TX"]) ?></td>
            <td scope="col"><?=isdatanull($row["D_TN"]) ?></td>
            </tr>
          <?php } ?>
      </tbody>
    </table>
  </div>
    







</body>
<script type="text/javascript">

$(document).ready(init);


function init() {
	$("#selCounties").change(countySelect);
}

function countySelect() {
	var s = $("#selCounties option:selected").val();
	$.get('selCounty.php?county=' + s, townListBack)
}

function townListBack(data) {
	$("#selTown").html(data);
}

</script>

<?php if (isset($_POST["selCounties"])) {  
  echo "<script type='text/javascript'>
            countySelect();
        </script>";
} ?>

</html>