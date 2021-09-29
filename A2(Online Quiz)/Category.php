<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
     <link rel="stylesheet" href="style.css">
    <title>Score It!</title>
    <style>
        .center {
            margin-left: 500px;
        }
    </style>
</head>
<nav class="navbar navbar-light bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="Quiz.png" alt="" width="80" height="80">
            <h3 class="text-center" style="color:white;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Choose One Subject</h3>
        </a>
    </div>
</nav><br/><br/>

<!-- After Submit-->
<?php 
session_start();  
if(isset($_SESSION['name'])) {      //Get user name
  echo "<h2 style='text-align:center;'>" . "Welcome: <u>" . $_SESSION["name"] . "</u></h2><br/>\n\n"; 
}
if(isset($_POST['submit']))         //If user submit 
{ 
      if($_POST['options'] == "Math"){
        header('location:MathQuiz.php');
      }
      elseif ($_POST['options'] == "Eng") {
        header('location:EngQuiz.php');
      }      
}   
if(isset($_POST['exit']))
{
    header('location:Exit.php');    //Or Back to Main Page
}
?>
<form method="POST">
    <div class="form container-fluid center"> 
        <!--Choose Subj(Option)-->
        <b><h4>Please Choose Any Subject:</h4></br></b>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="options" value="Math">
            <label class="form-check-label" for="flexRadioDefault1">
           Mathematics
          </label>
        </div><br>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="options" value="Eng" checked>
            <label class="form-check-label" for="flexRadioDefault2">
            English Literature
          </label>
        </div>

        <!--Submit / Reset -->
        <br/><br/>
        <input type="submit" name="submit" value="Start Test" class="btn btn-success">
        <input style='width:100px;'type="submit" name="exit" value="Exit" class="btn btn-danger">
    </div>
</form>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js " integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf " crossorigin="anonymous "></script>
</body>

</html>
