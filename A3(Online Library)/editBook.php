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
	if($_SESSION["type"] == "Librarian") { 
	echo '<li class="menu"><a href="allUsers.php">All Users</a></li>   
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
				<li><a href="ExtendedList.php">Extended Rents</a></li></ul>
			</ul>';
	}
	//connect to database 
  $dbc = mysqli_connect($servername, $username, $password, $dbname);

	//TO SEARCH for Book by ( ISBN, Title, Author, Status)
	if(isset($_GET['searchISBN']) 
	AND isset($_GET['searchTitle']) AND isset($_GET['searchAuthor']) AND isset($_GET['searchStatus'])){
		$searchISBN = $_GET['searchISBN']; // grab keyword
		$searchTitle = $_GET['searchTitle'];
	  $searchAuthor = $_GET['searchAuthor'];
		$searchStatus = $_GET['searchStatus'];
		
		$sql ="SELECT * FROM books 
					WHERE status='Available' AND 
					(ISBN LIKE '%$searchISBN%' AND Title LIKE '%$searchTitle%' 
					AND Author LIKE '%$searchAuthor%' AND status LIKE '%$searchStatus%') 
					ORDER BY id ASC";
}else
		$sql = "SELECT * FROM books 
						WHERE status='Available' 
						ORDER BY id ASC";
		$result = mysqli_query($dbc, $sql);

?>
<br>
</div>
<div id="container">
<br>
<h1>Edit Books</h1><br><br><br>
<?php

	$dbc = mysqli_connect($servername, $username, $password, $dbname);
			$id = $_GET["ID"];//Get ID from URL
			
			$sql = "SELECT * FROM books WHERE id ='$id'";

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

			if (isset($_POST['update']))      //If user Updated the Info , Update the database table 
			{
				$ISBN = $_POST['ISBN'];          //Get user updated info 
				$Title = $_POST['Title'];
				$Author = $_POST['Author'];
				$Publisher = $_POST['Publisher'];
				$status = $_POST['status'];
				$costPerDay = $_POST['costPerDay'];
				$extendedCostPerDay = $_POST['extendedCostPerDay'];
				
				if($status == 'Available'){      //If user set to Avaliable,   Update accordingly
					$update = "UPDATE books 
					SET ISBN='$ISBN', 
					Title='$Title', 
					Author='$Author', 
					Publisher='$Publisher', 
					status='$status', 
					costPerDay='$costPerDay', 
					extendedCostPerDay='$extendedCostPerDay', 
					rentedBy=NULL 
					WHERE id='$id'";
				}
				else if ($status == 'Not Available')    //If user set to Avaliable , Update accordingly
				{
					$update = "UPDATE books 
					SET ISBN='$ISBN', 
					Title='$Title', 
					Author='$Author', 
					Publisher='$Publisher', 
					status='$status', 
					costPerDay='$costPerDay', 
					extendedCostPerDay='$extendedCostPerDay' 
					WHERE id='$id'";
				}

				$update_Result = mysqli_query($dbc, $update);
				header("Location: listBook.php");				//redirect page
			}
?>

<div id="form">
<form action="" method="post" enctype="multipart/form-data">
      <table border=0>
			<tr>
				<td>Book ID</td>
				<td style="color: black;"><?php echo $id;?></td> 
			</tr>
			<tr>
			<td>ISBN: </td>
				<td><input type="text" name="ISBN" required maxlength="100" size="30" rows="7" cols="50"</td>
			</tr>
			</tr><br>
			<tr>
			<td>Title: </td>
				<td><input type="text" name="Title" required maxlength="100" size="30" rows="7" cols="50"</td>
			</tr>
			</tr>
			<tr>
			<td>Author: </td>
				<td><input type="text" name="Author" required maxlength="100" size="30" rows="7" cols="50"</td>
			</tr>
			</tr>
			<tr>
			<td>Publisher :</td>
				<td><input type="text" name="Publisher" required maxlength="100" size="30" rows="7" cols="50"</td>
			</tr>
			</tr>
			<tr>
				<td>Status:</td>
					<td><select id="status" name="status">
					<option value="Available">Available</option>
					<option value="Not Available">Not Available</option>
				</select></td>
			</tr>
			<tr>
				<td>Cost Per Day:</td>
				<td><input type="text" name="costPerDay" required maxlength="100" size="30" rows="7" cols="50"</td>
			</tr>
			<tr>
				<td>Extended Cost Per Day: </td>
				<td><input type="text" required name="extendedCostPerDay" </td>
			</tr>
			<tr>
				<td><input style="width:100px; height:30px; background-color:#43e6c5;"type="submit" name="update" value="Update"></td>
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