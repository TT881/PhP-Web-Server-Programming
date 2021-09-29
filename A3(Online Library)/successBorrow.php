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

			$id = $_GET["ID"];					//Get ID from URL
			
			$sql = "SELECT books.id AS 'Book ID', 
			loan.bookID AS 'Loan ID', 
			books.costPerDay AS 'costPerDay', 
			books.extendedCostPerDay AS 'extendedCostPerDay', 
			loan.borrowedDate AS 'borrowedDate', 
			loan.ExtendedDate AS 'ERD'
			FROM books 
			INNER JOIN loan ON books.id = loan.bookID";
			
			$search_Result = mysqli_query($dbc, $sql);
			
			if($search_Result)
			{		
				if(mysqli_num_rows($search_Result))
				{	
					while($row = mysqli_fetch_array($search_Result)) 
					{    
						$bookID = $row['Book ID'];
						$loanID = $row['Loan ID'];
						$costPerDay = $row['costPerDay'];
						$extendedCostPerDay = $row['extendedCostPerDay'];
						$borrowedDate = $row['borrowedDate'];
						$ExtendedDate = $row['ERD'];            // If user Extend 
					}	
				}else
				{
					echo 'Invalid Book!';
				}
				}
					else{ echo 'Result Error';
				}

		$sql = mysqli_query ($dbc, $sql);

		$check = mysqli_fetch_array($sql);
		$borrowdate = date('Y-m-d');   	// Get Today Borrow Date 
		$Duedate = date("Y-m-d", strtotime("+ 7 days"));   //Due Date 
		
			if (isset($_POST['home']))
			{
				header("Location: listBook.php");				//redirect page 
			}
?>
<div id="container">
<br>
<?php
$message = "The cost per day for this book is $" .$costPerDay ;
echo "<script type='text/javascript'>alert('$message');</script>";   // Alert the message to user 
?>

<h1>Borrow Successful</h1><br><br><br>
<p style="color:black;"><big><b>REMINDER!!</b><br><br> 
The cost each day for this Book is : <b>$<?php echo $costPerDay?></b>  <br> <br> 
You Borrowed this book on: <b><?php echo $borrowdate?></b><br><br> 
Your Should return the book after one week from the date of borrowing , which is on : <b><?php echo $Duedate ?></b></big><br>
<br>
<big style="color: blue;">If you want to Extend the date, the Extend cost per day is <b>
	$<?php echo $extendedCostPerDay ?><br></big></p><br><br>
	
<div id="form">
		<form action="" method="post" enctype="multipart/form-data">
			<input type="hidden" name="loanID">				<!-- rentedBy-->
			<input style="width:100px; height:30px; background-color:#34ebc3;"
			type="submit" name="home" value="Return Home">
		</form>
	</div>
	</body>
</html>
<?php  	
	mysqli_close( $dbc ) ;
?>