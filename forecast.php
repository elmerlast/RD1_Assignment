<?php
require_once "./sql/onnDB.php";
require_once "./storage.php";


insert_3_days_forecast();



$sqlStatement = "SELECT * FROM `tbl_counties`";
$countiesResult = mysqli_query($link, $sqlStatement);



if (isset($_POST["selCounties"])) {
  $sqlStatement = <<<mulity
  select 3_days_id , Cos_id , T, AT, RH, PoP6h, WS, WD, Wx, startTime, endTime
  from tbl_3_days_forecast
  where Cos_id = {$_POST["selCounties"]}
  ORDER BY `tbl_3_days_forecast`.`3_days_id` ASC;
  mulity;
  $result = mysqli_query($link, $sqlStatement);

}else{
  $_POST["selCounties"] = 10;
  $sqlStatement = <<<mulity
  select 3_days_id , Cos_id , T, AT, RH, PoP6h, WS, WD, Wx, startTime, endTime
  from tbl_3_days_forecast
  where Cos_id = 10
  ORDER BY `tbl_3_days_forecast`.`3_days_id` ASC;
  mulity;
  $result = mysqli_query($link, $sqlStatement);
}



?>




<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>個人氣象站</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="\PID_Assignment\css\bootstrap.min.css">
  <link rel="stylesheet" href="\PID_Assignment\css\store_index.css">
  <script src="\PID_Assignment\js\jquery.min.js"></script>
  <script src="\PID_Assignment\js\bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="\PID_Assignment\js\jquery.mycart.js"></script>

</head>

<body>


<nav class="navbar navbar-expand-sm navbar-light sticky-top" style="background-color: #e3f2fd;">
    <div class="navbar-brand">個人氣象站</div>
    <li style="list-style-type:none" class="nav-item dropdown">
        <div class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          天氣預報
        </div>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="current_weather.php">當前天氣</a>
          <a class="dropdown-item" href="rainfall.php">雨量觀測</a>
        </div>
    </li>
  </nav>




  <div class="container">
    <h1 style="text-align:center;">各縣市未來2天天氣預報</h1>
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
          <div class="col">
            <button type="submit" class="btn btn-info" name="btnCounties" id="btnCounties" value="btnCounties">確定</button>
          </div>
          <div class="col text-right">
            <img class="card-img-top" src="<?php if(isset($_POST["selCounties"])){echo("{$arrayCosImg[$_POST["selCounties"]]}");}else{echo('img/taipei.jpg');}?>" alt="沒有圖片">
          </div>

      </div>
    </form>

            <form class="form-inline pull-left" role="form" id="form_7_days" name="form_7_days" action = "index.php" method="POST" >
             <?php if (isset($_POST["selCounties"])) {?>
              <input type="submit" class="btn btn-link" id="selCounties" name="selCounties" value="未來一週天氣預報">
              <input type="hidden" id="selCounties" name="selCounties" value="<?= $_POST["selCounties"] ?>"/>
             <?php }else{ ?>
              <input type="submit" class="btn btn-link" id="selCounties" name="selCounties">
             <?php } ?>
		        </form>
            
            <form class="form-inline pull-left" role="form" id="form_3_days" name="form_3_days" action = "forecast.php" method="POST" >
             <?php if (isset($_POST["selCounties"])) {?>
              <input type="submit" class="btn btn-link" id="selCounties" name="selCounties" value="未來2天天氣預報">
              <input type="hidden" id="selCounties" name="selCounties" value="<?= $_POST["selCounties"] ?>"/>
             <?php }else{ ?>
              <input type="submit" class="btn btn-link" id="selCounties" name="selCounties">
             <?php } ?>
		        </form>

        </div>

  </div>

      </div>
  <div class="container">
    <table class="table ">
      <thead class="thead-light">
        <tr style="text-align:center;">
          <th scope="col">時間</th>
          <th scope="col">00時~03時</th>
          <th scope="col">03時~06時</th>
          <th scope="col">06時~09時</th>
          <th scope="col">09時~12時</th>
          <th scope="col">12時~15時</th>
          <th scope="col">15時~18時</th>
          <th scope="col">18時~21時</th>
          <th scope="col">21時~00時</th>
        </tr>
      </thead>
      <tbody>
      <tr>
      <?php
          $ForecastTime = date("Y-m-d H:i:s",strtotime("+1 day")+ 3600 * 8);
          $weekday = get_chinese_weekday($ForecastTime);
          $timeth = strtr(substr($ForecastTime,5,5),"-","/").'<br/><h6 >'."$weekday".'</h6>'; ?>

          <th scope="col"><?=$timeth?></th>
      <?php
          $dayForecast ="";
          $ForecastStartTime = strtotime(substr_replace (date("Y-m-d H:i:s",strtotime("+1 day")+ 3600 * 8),"00:00:00", 11));
          $ForecastEndTime = strtotime(substr_replace (date("Y-m-d H:i:s",strtotime("+2 day")+ 3600 * 8),"00:00:00", 11));          
          while ($row = mysqli_fetch_assoc($result)){
            if(strtotime($row["startTime"]) >= $ForecastStartTime && strtotime($row["startTime"]) < $ForecastEndTime){
              $dayForecast = $dayForecast.
              '<td scope="col">'.
              "
              溫度：{$row["T"]}<br/>
              天氣：{$row["Wx"]} <br/>
              降雨機率：{$row["PoP6h"]}%<br/>
              濕度：{$row["RH"]} <br/>
              風向：{$row["WD"]} <br/>
              風速：{$row["WS"]} <br/>
              "
              .'</td>';
            }
          }
          echo $dayForecast;
          mysqli_data_seek($result,0);
      ?>
      </tr>
      <tr>
      <?php
          $ForecastTime = date("Y-m-d H:i:s",strtotime("+2 day")+ 3600 * 8);
          $weekday = get_chinese_weekday($ForecastTime);
          $timeth = strtr(substr($ForecastTime,5,5),"-","/").'<br/><h6 >'."$weekday".'</h6>'; ?>

          <th scope="col"><?=$timeth?></th>
      <?php
          $dayForecast ="";
          $ForecastStartTime = strtotime(substr_replace (date("Y-m-d H:i:s",strtotime("+2 day")+ 3600 * 8),"00:00:00", 11));
          $ForecastEndTime = strtotime(substr_replace (date("Y-m-d H:i:s",strtotime("+3 day")+ 3600 * 8),"00:00:00", 11));          
          while ($row = mysqli_fetch_assoc($result)){
            if(strtotime($row["startTime"]) >= $ForecastStartTime && strtotime($row["startTime"]) < $ForecastEndTime){
              $dayForecast = $dayForecast.
              '<td scope="col">'.
              "
              溫度：{$row["T"]}<br/>
              天氣：{$row["Wx"]} <br/>
              降雨機率：{$row["PoP6h"]}%<br/>
              濕度：{$row["RH"]} <br/>
              風向：{$row["WD"]} <br/>
              風速：{$row["WS"]} <br/>
              "
              .'</td>';
            }
          }
          echo $dayForecast;
          mysqli_data_seek($result,0);
      ?>
      </tr>
      </tbody>
    </table>
  </div>
    







</body>

</html>