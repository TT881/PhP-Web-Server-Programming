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
?>
<body>
<div id="container">
<br>
<h1>Enter New Book Details</h1><br><br><br>
<?php
	//connect to database
    $dbc = mysqli_connect($servername, $username, $password, $dbname);
	if (isset($_POST['submit'])){      // If User submitted the Book Detail, insert into databse
 
	//In order to be inserted into the DB as a NULL value.
	$id = "";
	$ISBN = "";
	$Title = "";
	$Author = "";
	$Publisher = "";
	$status = "";
	$costPerDay = "";
	$extendedCostPerDay =" ";
	$rentedBy = "";

	//variable $_POST is for the one given in the HTML.
	//$id=$_POST['id'];
	//Get the entered value from user 
	$ISBN = $_POST['ISBN'];
  $Title = $_POST['Title'];
	$Author = $_POST['Author'];
	$Publisher = $_POST['Publisher'];
	$status = $_POST['status'];
	$costPerDay = $_POST['costPerDay'];
	$extendedCostPerDay = $_POST['extendedCostPerDay'];

	//INSERT into "table name" followed by "names in mysql"  VALUES "the variables given from above"
		$sql="INSERT INTO `books` (`id`, `ISBN`, `Title`, `Author`, `Publisher`, `status`, `costPerDay`, `extendedCostPerDay`, `rentedBy`)  
		VALUES(NULL, '$ISBN', '$Title', '$Author', '$Publisher' , '$status', '$costPerDay', '$extendedCostPerDay', NULL)";
		mysqli_query($dbc, $sql);

		header("Location: insertBook.php");//redirect page
		}
?>
<div id="form">
<form action="" method="post" enctype="multipart/form-data">
      <table border=0>
				<input type="hidden" name="id">
				<input type="hidden" name="status">
				<input type="hidden" name="rentedBy">

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
				<td><input style="width:100px; height:30px; background-color:#40de9a;"type="submit" name="submit" value="Submit"></td>
			</tr>
			<br>		
        </table>
    </form>

</div>
<div id="insertForm">
    <?php
	$sql= "SELECT * FROM books ORDER BY `id` ASC"; //show all the books from database 

	echo " <table border= 1 bgcolor='black' width='90%'>
	<tr>
			<th>#</th>
	    <th>ISBN</th>
      <th>Title</th>
			<th>Author</th>
			<th>Publisher</th>
			<th>Status</th>
			<th>Cost Per Day</th>
			<th>Extend Cost Per Day</th>
	</tr>";
			
		$result = mysqli_query($dbc, $sql);
    while($row = mysqli_fetch_array($result)) {     
?>
     <tr>
	      <td><?php echo $row["id"];?></td>
	      <td><?php echo $row["ISBN"];?></td>
				<td><?php echo $row["Title"];?></td> 
				<td><?php echo $row["Author"];?></td>
				<td><?php echo $row["Publisher"];?></td>
				<td><center><?php echo $row["status"];?></td>
				<td><center><?php echo $row["costPerDay"];?></td>
				<td><center><?php echo $row["extendedCostPerDay"];?></td>
			</tr>
<?php			
			}     
			echo "</table>";
			echo "</br></br>";	
?>

</div>
</body>
</html>