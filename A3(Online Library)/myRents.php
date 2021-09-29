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

	$username= $_SESSION["username"]; //Get username from session.

	$sql ="SELECT DISTINCT books.id AS 'Book ID',
	  books.ISBN AS 'ISBN', 
	  books.Title AS 'Title', 
	  books.Author AS 'Author', 
	  books.Publisher AS 'Publisher', 
	  books.status AS 'status', 
	  books.costPerDay AS 'costPerDay',  
		books.extendedCostPerDay AS 'extendedCostPerDay', 
	  loan.borrowedDate AS 'Borrow Date'  
		FROM books INNER JOIN loan 
		ON books.id = loan.bookID 
		WHERE books.rentedBy='$username' ORDER BY books.id ASC";
	
    $result = mysqli_query($dbc, $sql);    //Execute Query 

?>
<br>
</div>
<div id="container">
<br>
<h1>My Borrowed Books</h1><br><br><br>
<?php
	
	echo " <table bgcolor='#000000' border= 1 width='85%'>
	<tr>
	<th>#</th>
	<th>ISBN</th>
	<th>Title</th>
	<th>Author</th>
	<th>Publisher</th>
	<th>Status</th>
	<th>Cost Per Day</th>
	<th>Extend Cost Per Day</th>
	<th>Borrowed Date</th>
	<th width='15%'>Action</th>
</tr>";
			
        while($row = mysqli_fetch_array($result)) {     

		    $id = $row['Book ID'];
?>
            <tr>
			<td><?php echo $row["Book ID"];?></td>
			<td><?php echo $row["ISBN"];?></td> 
			<td><?php echo $row["Title"];?></td>
			<td><?php echo $row["Author"];?></td>
			<td><?php echo $row["Publisher"];?></td>
			<td><?php echo $row["status"];?></td>
			<td><center><?php echo $row["costPerDay"];?></td>
			<td><center><?php echo $row["extendedCostPerDay"];?></td>
			<td><center><?php echo $row["Borrow Date"];?></td>

			<td>
			<?php 
				$username = $_SESSION['username'];
				$extendedCostPerDay = $row['extendedCostPerDay'];
			?>
			<a href='extendRent.php?ID=<?php echo $id;?>&payID=<?php echo $extendedCostPerDay;?>'><center><br>
				<button style='color:black; width:100px; height:30px; background-color:#34eb93;'>Extend Rent</button><br><br></a>
	
			</td>
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