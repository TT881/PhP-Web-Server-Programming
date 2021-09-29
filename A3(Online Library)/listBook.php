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
	
		// Searched By 
		$searchISBN="";
		$searchTitle="";
		$searchAuthor="";
		$searchStatus="";
		
	//TO SEARCH for Book by ( ISBN, Title, Author, Status)
	if(isset($_GET['searchISBN']) AND isset($_GET['searchTitle']) 
	AND isset($_GET['searchAuthor']) AND isset($_GET['searchStatus'])){
		$searchISBN = $_GET['searchISBN']; // grab keyword
		$searchTitle = $_GET['searchTitle'];
		$searchAuthor = $_GET['searchAuthor'];
		$searchStatus = $_GET['searchStatus'];
		
		$sql ="SELECT * FROM books 
		WHERE status='Available' 
		AND (ISBN LIKE '%$searchISBN%' 
		AND Title LIKE '%$searchTitle%' AND Author LIKE '%$searchAuthor%' AND status LIKE '%$searchStatus%') 
		ORDER BY id ASC";
}else                            //Else, Display all the Updated Avaliable books from database books table 
		$sql = "SELECT * FROM books 
		WHERE status='Available' 
		ORDER BY id ASC";
		
		$result = mysqli_query($dbc, $sql);
?>
<br>
</div>
<div id="container">
<br>
<h1>Books List</h1><br><br><br>

<form action ="" method="GET">
		<input type="text" name="searchISBN" class="form-control" placeholder="ISBN" value="<?php echo "$searchISBN"; ?>" >
		<input type="text" name="searchTitle" class="form-control" placeholder="Title" value="<?php echo "$searchTitle"; ?>" >
		<input type="text" name="searchAuthor" class="form-control" placeholder="Author" value="<?php echo "$searchAuthor"; ?>" >
		<input type="text" name="searchStatus" class="form-control" placeholder="Status" value="<?php echo "$searchStatus"; ?>" >
		<button class="btn">Search</button>
	</form>
<?php
	
	echo " <table bgcolor='#000000' border= 1 width='80%'>
		<tr>
			<th>#</th>
			<th>ISBN</th>
			<th>Title</th>
			<th>Author</th>
			<th>Publisher</th>
			<th>Status</th>
			<th>Cost Per Day</th>
			<th>Extend Cost Per Day</th>
			<th width='20%'>Action</th>
		</tr>";
			
        while($row = mysqli_fetch_array($result)) {     
		    $id = $row['id']; 
?>
        <tr>
					<td><?php echo $row["id"];?></td>
					<td><?php echo $row["ISBN"];?></td>
					<td><?php echo $row["Title"];?></td> 
					<td><?php echo $row["Author"];?></td>
					<td><?php echo $row["Publisher"];?></td>
					<td><?php echo $row["status"];?></td>
					<td><center><?php echo $row["costPerDay"];?></td>
					<td><center><?php echo $row["extendedCostPerDay"];?></td>
			<td style="height:70px;">
			<?php 
				if ($_SESSION["type"] == "Borrower" AND $row["status"] == "Available"){   //If user is Borrower 
			?>
				<a href='BorrowBook.php?ID=<?php echo $id;?>'><center><button style=' width:100px; height:50px; border-radius:5px; background-color:#43e6de;'
				>Borrow a Book</button></a>		
			<?php
			}
			//Extend the date 
				$username = $_SESSION['username'];
				if ($_SESSION["type"] == "Borrower" AND $row["status"] == "Not Available" AND $row["rentedBy"]){
			?>
				<a href='returnBook.php?ID=<?php echo $id;?>&payID=<?php echo $paymentID;?>'><center><button style='color:black'>Return</button></a>
			<?php 
			}	
			if ($_SESSION["type"] == "Librarian"){ 
				?>
					<a href='editBook.php?ID=<?php echo $id;?>'><center><button style='background-color:#40de9a; width:100px;float:center'>Edit</button></a><br><br>
					<a href='viewBook.php?ID=<?php echo $id;?>'><center><button style='background-color:#2874ed; width:100px;float:bottom'>View</button></a><br><br>
				<?php 
			}
			?>
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