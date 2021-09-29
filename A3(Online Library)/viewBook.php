<?php
	// Load the required files
	require_once 'dbconfig.php';
?>
<html>
<head>
<title>Digital Library</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div id="login">
<br><br>
<?php echo '<big>Welcome, ' .$_SESSION['username'].' ';?>
<a href="logout.php" style="color:black">Log Out</a></big>
</div>
<div class="nav">
<ul>
<?php
	//Menu
	if($_SESSION["type"] == "Administrator") { 
	echo '<li class="menu"><a href="allUsers.php">All Users</a></li>
	<li><a href="rentPayment.php">Payment Records</a></li>
	<li class="menu"><a href="listBook.php">All Books
        <ul>
			<li><a href="insertBook.php">Insert a Book</a></li>
			<li><a href="availBook.php">Available Books</a></li></ul>

			<li class="menu"><a href="" onclick="return false;">Rents
	    	<ul>
				<li><a href="rentedBook.php">Rented Books</a></li>
				<li><a href="ExtendedList.php">Extended Rents</a></li></ul>
			</ul>';
	}

	if($_SESSION["type"] == "Borrower") { 
		echo '<li class="menu"><a href="listBook.php">All Book Resources</a>
				<ul><li><a href="availBook.php">Available Books</a></li></ul>
			<li class="menu"><a href="" onclick="return false;">Check History
				<ul>
				<li><a href="myRents.php">Current Borrowing</a></li>
				<li><a href="ExtendedList.php">Extended Resources</a></li></ul>
			</ul>';
	}
    $dbc = mysqli_connect($servername, $username, $password, $dbname);
	
	// //TO SEARCH FOR BOOK
	// $searchKey="";
	// 	if(isset($_GET['search'])){
	// 			$searchKey="";
	// 	    $searchKey = $_GET['search']; // grab keyword
	// 	    $sql ="SELECT * FROM books WHERE status='Available' 
	// 			AND (ISBN LIKE '%$searchKey%' OR Title LIKE '%$searchKey%' ) ORDER BY id ASC";
	// 	}else
	// 	    $sql = "SELECT * FROM books WHERE status='Available' ORDER BY id ASC";

	//     	$result = mysqli_query($dbc, $sql);

?>
<br>
</div>
<div id="container">
<br>
<h1><u>View Book Detail:</u></h1><br><br><br>
<?php

	$dbc = mysqli_connect($servername, $username, $password, $dbname);        //connect to database
			$id = $_GET["ID"];//Get ID from URL
			
			$sql = "SELECT * FROM books WHERE id ='$id'";     //View Specific Book 

			$search_Result = mysqli_query($dbc, $sql);
			
			if($search_Result)
			{		
				if(mysqli_num_rows($search_Result))
				{	
					while($row = mysqli_fetch_array($search_Result)) 
					{    
						$id = $row['id'];
						$ISBN = $row['ISBN'];
						$Title = $row['Title'];
						$Author = $row['Author'];
						$Publisher = $row['Publisher'];
						$status = $row['status'];
						$costPerDay = $row['costPerDay'];
						$extendedCostPerDay = $row['extendedCostPerDay'];
						$rentedBy = $row['rentedBy'];
					}	
				}else
				{
					echo 'Invalid Book';
				}
			}
				else{ echo 'Result Error';
			}
			$sql = mysqli_query ($dbc, "SELECT * FROM books WHERE id = '$id' ");

		$check = mysqli_fetch_array($sql);

			if (isset($_POST['home']))      
			{
				header("Location: listBook.php");			//redirect  page 
			}
?>

<div id="form">
<form action="" method="post" enctype="multipart/form-data">
      <table border=0>
			<tr>
				<td>Bookd ID:</td>
				<td style="color: black;"><?php echo $id;?></td>			
			</tr>
			<tr>
				<td>ISBN:</td>
				<td style="color: black;"><?php echo $ISBN;?></td>
			</tr>
			<tr>
				<td>Title:</td>
				<td style="color: black;"><?php echo $Title;?></td>
			</tr>
			<tr>
				<td>Author:</td>
				<td style="color: black;"><?php echo $Author;?></td>
			</tr>
			<tr>
				<td>Publisher:</td>
				<td style="color: black;"><?php echo $Publisher;?></td>
			</tr>
			<tr>
				<td>Status:</td>
				<td style="color: black;"><?php echo $status;?></td>
			</tr>
			<tr>
				<td>Cost Per Day:</td>
				<td style="color: black;"><?php echo $costPerDay;?></td>
			</tr>
			<tr>
				<td>Extended Cost Per Day :</td>
				<td style="color: black;"><?php echo $extendedCostPerDay;?></td>
			</tr>
			<tr>
				<td><input style="width:130px; height:30px; background-color:#43e6c5;"type="submit" name="home" value="Back To Home"></td>
			</tr>
			<br>
<?php  	
	mysqli_close( $dbc ) ;
?>			
        </table>
    </form>
</div>
	</body>
</html>