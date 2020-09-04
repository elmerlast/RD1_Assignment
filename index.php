<?php
require_once "./insertdata.php";

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>訂購項目</title>

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
    <!-- Brand/logo -->
    <a class="navbar-brand" href="/PID_Assignment/index.php">個人氣象站</a>

    <!-- Links -->
 
  </nav>




  <div class="container">
    <h1 style="text-align:center;">各縣市當前天氣狀況</h1>
    <form method="post" action="http://exec.hostzi.com/echo.php">
        <div class="row">
            <div class="col-2">
                <select class="form-control" name="selCounties" id="selCounties">
                <?php while ($row = mysqli_fetch_assoc($catResult)) { //將抓取出來的分類名稱資料轉換成下拉式選單標籤?>
                  <option value="<?=$row["ca_name"]?>"
                    <?php if ($row["ca_name"] == $_POST["Categories"]) {echo "selected";}?>> <?=$row["ca_name"]?>
                  </option>
                  <?php }?>
		        </select>&nbsp;&nbsp; 
            </div>

            <div class="col-2">
                <button type="submit" class="btn btn-info" name="btnPlaceOrder" id="btnPlaceOrder" value="btnPlaceOrder">確定</button>
            </div>
            <div class="col-6 text-right">
                <img class="card-img-top" src="<?=$row["prd_images"]?>" alt="沒有圖片">
            </div>


        </div>
	</form>
    <table class="table table-hover">
  <thead class="thead-light">
    <tr>
      <th scope="col">當前溫度</th>
      <th scope="col">風向</th>
      <th scope="col">風速</th>
      <th scope="col">溫度</th>
      <th scope="col">相對濕度</th>
      <th scope="col">測站氣壓，單位</th>


    </tr>
  </thead>
  <tbody>
   <?php while ($row = mysqli_fetch_assoc($result)){
             if($row["m_id"] != $mId) {die('<h2 style="color:red;">錯誤！權限不足。</h2>');}?>
      <tr>
        <th scope="row"><?=$row["dets_name"] ?></th>
           <td><?=$row["dets_unitprice"]?></td>
           <td><?=$row["dets_quantity"]?></td>  
           <td><?=($row["dets_unitprice"] * $row["dets_quantity"])?></td>  
      </tr>
      <?php $orderTotal += ($row["dets_unitprice"] * $row["dets_quantity"]); //計算訂單總額 ?>
   <?php } ?>
  </tbody>
</table>
<div class="row"><div class="col-10"></div><div class="col-2"><h6>&nbsp;總計&nbsp;&nbsp;&nbsp;&nbsp;$<?=$orderTotal?></h6></div></div>
<div class="row">
    <div class="col-10"></div>
    <div class="col-2">
        <button type="submit" class="btn btn-info" name="btnPlaceOrder" id="btnPlaceOrder" value="btnPlaceOrder">確定</button>
    </div>
</div>



  </div> 


</body>
</html>
