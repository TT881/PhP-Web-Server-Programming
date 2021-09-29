<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

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
            <h2 class="text-center" style="color:white;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quiz Test! Score It ....</h2>
        </a>
    </div>
</nav><br/><br/>

<!-- After Submit-->
<?php
	session_start();

	$nameErr = "";
	$name = "";

	// Validate form
	$fields = array('name');
	$error = false; //No errors yet

	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{		
		//$_SESSION["name"] = $_POST['name'];

		if (empty($_POST["name"])) {
			$nameErr = "Please enter your name";
		} else {
			$name = test_input($_POST["name"]);
			//check if name only contans letters and whitespace
			if (!preg_match("/^[a-zA-Z ]*$/", $name)){
				$nameErr = "Only letters and white space allowed";
				$error = true;
			}
		}
			foreach ($fields AS $fieldname) { //Loop trough each field
				if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
			    $error = true; //error is present
			}
		}
        
        //If Got Error 
		if($error == true)  
		{
			echo "<p style='text-align:center; font-weight:bold; font-size:20px; color:red;'>" . $nameErr. "</p>";
		}else{
			header('location:Category.php');     //Else, Redirect to Category page
			$_SESSION['name'] = $name;
		}
	}
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
<form action="Start.php" method="POST">
    <div class="form container-fluid center">
        <!--Enter Name-->
        <b><label class="col-form-label">Please Enter Your Name: </label></b>
        <input style="width:300px;" type="text" name = "name" class="form-control" required>
        <br/>

        <!--Submit -->
        <br/><br/>
        <input style='width:150px;'type="submit" name="submit" value="Enter" class="btn btn-success">
    </div>
</form>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js " integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf " crossorigin="anonymous "></script>
</body>

</html>
