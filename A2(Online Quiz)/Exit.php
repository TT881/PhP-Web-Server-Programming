<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <title>EIXT PAGE</title>
</head>
<body>
<h1 class="text-center" style="background-color:#1d3845; color:white;">TOTAL SCORE<hr/></h1>
<div class="form-style">
  <?php 
  session_start();
  if(isset($_SESSION["name"])){
    echo "<h3 style='text-align:center;'> Good Bye <u>". $_SESSION["name"]."</u></h3><br/>\n";

    if(!empty($_SESSION["MathScore"])){
      echo "<p style='color:blue; text-align:center; font-size:25px;'> <b>Math Total test points: ".$_SESSION['MathScore']. "</b></p>\n";
    }
    else{              //If Score = 0
      $_SESSION["MathScore"] = 0;
      echo "<p style='color:blue; text-align:center; font-size:25px;'> <b>Math Total test points: ".$_SESSION['MathScore']. "</b></p>\n";
    }
    if(!empty($_SESSION["EngScore"])){
      echo "<p style='color:blue; text-align:center; font-size:25px;'> <b>English Total test points: ".$_SESSION['EngScore']. "</b></p>\n";
    }
    else{            //If Score = 0
      $_SESSION["EngScore"] = 0;
      echo "<p style='color:blue; text-align:center; font-size:25px;'> <b>English Total test points: ".$_SESSION['EngScore']. "</b></p>\n";
    }
    if ($_SESSION["MathScore"] >= 0 && $_SESSION["EngScore"] >= 0) {       //Display Overall points
      $OverallPoints = $_SESSION["MathScore"] + $_SESSION["EngScore"] ;
      echo "<br>";
      echo "<h3 style='text-align:center; color:green; font-size:30px;'>Overall Points: " . $OverallPoints . "</h3><br/>\n\n";
    }
  }
  session_destroy();
?>
<button onclick="window.location.href ='Start.php';" style="display: block; margin-left:550px;">Back to Main Page</button>
</div>
<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js " integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf " crossorigin="anonymous "></script>
</body>
</html>