<?php
	// Load the required files
	require_once 'dbconfig.php';
	
	//connect to database
     $dbc = mysqli_connect($servername, $username, $password, $dbname);
	
	$username = $_SESSION["username"];
	$name = $_SESSION["name"];
	$session_id = $_SESSION['session_id'];
	
	//$update = mysqli_query($dbc,"UPDATE session SET lo_time=now() WHERE emp_id='$emp_id' AND id=".$session_id); //update via id session and not the session emp_id

	unset($_SESSION['username']);    //Unset the user name 
	session_destroy();							 //destory the session 
	
	Header('Location:index.php');    //Back to Home page 
?>