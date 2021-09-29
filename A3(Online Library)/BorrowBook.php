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
<?php echo 'Welcome, ' .$_SESSION['username'].' ' ?>    
<a href="logout.php" style="color:black">Log Out</a>
</div>
<div class="nav">
<ul>
<?php
	//Menu ( Navigation )
	if($_SESSION["type"] == "Librarian") {      //If Librarian 
	echo '<li class="menu"><a href="allUsers.php">All Users</a></li>
	<li class="menu"><a href="listBook.php">All Books
        <ul>
			<li><a href="insertBook.php">Insert a Book</a></li>
			<li><a href="availBook.php">Available Book Resources</a></li></ul>

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
	//Connect to database 
	$dbc = mysqli_connect($servername, $username, $password, $dbname);
	$rentedBy = "";

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
					echo 'Invalid Book!';
				}
			}
				else{ echo 'Result Error';
			}
			$sql = mysqli_query ($dbc, "select * from books WHERE id = '$id' ");

		$check = mysqli_fetch_array($sql);

			if (isset($_POST['borrow']))     //when User Click 'Borrow'
			{
				$username= $_SESSION["username"]; //Get username from session.
				$borrowedDate = date('Y-m-d H:i:s');   				// Get Today Date 
        
				//Update the database table --> Update ( status & RentedBy who? )
				$rent = "UPDATE books 
				SET status='Not Available',
				rentedBy ='$username' 
				WHERE id='$id'";

				//Insert borrowed info into table "loan"
				$loan ="INSERT INTO `loan` 
				(`id`, `bookID`, `username`, `borrowedDate`, `ExtendedDate`, `totalCost`) 
				VALUES(NULL, '$id', '$username', CURDATE(), NULL , $costPerDay)";  
		
				$update_Result = mysqli_query($dbc, $rent);   //Update the table "book" 
				$update_Result = mysqli_query($dbc, $loan);   //Update the table "loan" 
				header("Location: successBorrow.php?ID=$id");			//Redirect page 
			}

			if (isset($_POST['back']))                    // If user click Back
			{
				header("Location: listBook.php");							//Redirect Page
			}
?>
<div id="container">
<br>
<h1><u>Borrow a Book</u></h1><br><br><br>

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
				<td><input style = "width:100px; height:30px; background-color:#43e6de;" type="submit" name="borrow" value="Borrow Book"></td>
				<td><input style = "width:100px; height:30px; background-color:#eb7a78;" type="submit" name="back" value="Cancel"></td>
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