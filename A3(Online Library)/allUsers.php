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
<a href="logout.php" style="color:black">Log Out</a></big>
</div>
<div class="nav">
<ul>
<?php
	//Menu
	if($_SESSION["type"] == "Librarian") { 
		echo '<li class="menu"><a href="allUsers.php">All Users</a></li>   
		<li class="menu"><a href="listProd.php">All Books
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
    
    $sql = "SELECT * FROM users ORDER BY id ASC";     //Display Order by ID in ASC 
	
		$result = mysqli_query($dbc, $sql);

?>
<br>
</div>
<div id="container">
<br><br>
<h1>All Users</h1><br><br><br>
<?php
	
	echo " <table bgcolor='#000000' border= 1 width='70%'>
	<tr>
			<th>ID#</th>
	    <th>Username</th>
      <th>Name</th>
			<th>Surname</th>
			<th>Phone</th>
			<th>Email</th>
			<th>Type</th>
  </tr>";
			
        while($row = mysqli_fetch_array($result)) {       //fetch all the data in an array 
		    $id = $row['id'];	
?>
            <tr>
			<td><?php echo $row["id"];?></td>
			<td><center><?php echo $row["username"];?></td> 
			<td><center><?php echo $row["name"];?></td>
			<td><center><?php echo $row["surname"];?></td>
			<td><center><?php echo $row["phone"];?></td>
			<td><center><?php echo $row["email"];?></td>
			<td><center><?php echo $row["type"];?></td>
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