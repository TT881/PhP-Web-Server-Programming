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
	//connect to database
    $dbc = mysqli_connect($servername, $username, $password, $dbname);

   //Display all the Updated table loan
		$sql = "SELECT * FROM loan";
		
		$result = mysqli_query($dbc, $sql);
?>
<br>
</div>
<div id="container">
<br>
<h1>Extended List</h1><br><br><br>

<?php
	
	echo " <table bgcolor='#000000' border= 1 width='80%'>
		<tr>
			<th>#</th>
			<th>bookID</th>
			<th>Name</th>
			<th>Borrowed Date</th>
			<th>Extended Date</th>
			<th>Total Cost</th>
		</tr>";
			
        while($row = mysqli_fetch_array($result)) {     
		    $id = $row['id']; 
?>
        <tr>
					<td><center><?php echo $row["id"];?></td>
					<td><center><?php echo $row["bookID"];?></td>
					<td><center><?php echo $row["username"];?></td> 
					<td><center><?php echo $row["borrowedDate"];?></td>
					<td><center><?php echo $row["ExtendedDate"];?></td>
					<td><center><?php echo $row["totalCost"];?></td>
			</tr>
<?php			
            echo "</tr>";
			}     
			echo "</table>";
			echo "</br></br>";	
?>
</br></br>
	</div>
	</div>
</body>
</html>