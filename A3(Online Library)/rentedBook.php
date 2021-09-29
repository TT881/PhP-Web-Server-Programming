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
	
		// Searched By 
		$searchISBN="";
		$searchTitle="";
		$searchAuthor="";
		$searchStatus="";
		
		//TO SEARCH for Book by ( ISBN, Title, Author, Status)
		if(isset($_GET['searchISBN']) AND
			isset($_GET['searchTitle']) 
			AND isset($_GET['searchAuthor']) 
			AND isset($_GET['searchStatus']))
		{
				$searchISBN = $_GET['searchISBN']; // grab keyword
				$searchTitle = $_GET['searchTitle'];
				$searchAuthor = $_GET['searchAuthor'];
				$searchStatus = $_GET['searchStatus'];

		    //This statement is for borrowed and borrowed before
		  	$sql ="SELECT DISTINCT loan.bookID AS 'Book ID',      /* If user Search By Keywords, Display the specific Info */
				 books.ISBN AS 'ISBN', 
				 books.Title AS 'Title', 
				 books.Author AS 'Author', 
				 books.Publisher AS 'Publisher',
				 books.status AS 'status' 
				 FROM books 
				 INNER JOIN loan 
				 ON books.id = loan.bookID 
				 WHERE (books.ISBN LIKE '%$searchISBN%' 
				 AND books.Title LIKE '%$searchTitle%' 
				 AND books.Author LIKE '%$searchAuthor%' 
				 AND books.status LIKE '%$searchStatus%')";
		}else
		    $sql ="SELECT DISTINCT                      /* Else, Display the book lists from table loan */
				loan.bookID AS 'Book ID', 
				books.ISBN AS 'ISBN', 
				books.Title AS 'Title', 
				books.Author AS 'Author',
				books.Publisher AS 'Publisher',
				books.status AS 'status' 
				FROM books 
				INNER JOIN loan ON books.id = loan.bookID";

	    $result = mysqli_query($dbc, $sql); 
?>
<br>
</div>
<div id="container">
<br>
<h1>Borrowed Books</h1><br><br><br>

<form action ="" method="GET">
		<input type="text" name="searchISBN" class="form-control" placeholder="ISBN" value="<?php echo "$searchISBN"; ?>" >
		<input type="text" name="searchTitle" class="form-control" placeholder="Title" value="<?php echo "$searchTitle"; ?>" >
		<input type="text" name="searchAuthor" class="form-control" placeholder="Author" value="<?php echo "$searchAuthor"; ?>" >
		<input type="text" name="searchStatus" class="form-control" placeholder="status" value="<?php echo "$searchStatus"; ?>" >
		<button class="btn">Search</button>
	</form>
<?php
	
	echo " <table bgcolor='#000000' border= 1 width='70%'>
	<tr>
			<th>#</th>
	    <th>ISBN</th>
      <th>Title</th>
			<th>Author</th>
			<th>Publisher</th>
			<th>Status</th>
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