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
?>
<br>
</div>
<div id="container">
<br>
<h1>Extend Rents</h1><br><br><br>
<?php

	$dbc = mysqli_connect($servername, $username, $password, $dbname);
			$id = $_GET["ID"];//Get ID from URL
			
			$sql = "SELECT * FROM books 
              WHERE id ='$id'";
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

     //Execute loan Table 
     $sql1 ="SELECT DISTINCT loan.bookID AS 'bookID', 
     loan.username AS 'username', 
     loan.borrowedDate AS 'borrowedDate', 
     loan.totalCost AS 'totalCost', 
     loan.borrowedDate AS 'borrowedDate'  
     FROM loan INNER JOIN books
     ON books.id = loan.bookID";
   
     $search_Result1 = mysqli_query($dbc, $sql1);    //Execute Query 

			if($search_Result1)
			{		
				if(mysqli_num_rows($search_Result1))
				{	
					while($row1 = mysqli_fetch_array($search_Result1)) 
					{    
						$bookID = $row1['bookID'];                
						$username = $row1['username'];
						$borrowedDate = $row1['borrowedDate'];
						$totalCost = $row1['totalCost'];			
					}	
				}else
				{
					echo 'Invalid Loan';
				}
			}
				else{ echo 'Result Error';
			}

    //If user Extended the Date 
			if (isset($_POST['extend']))      
			{
        //Get info from loan 
        $id = $row1['id'];
        $bookID = $row1['bookID'];                
        $username = $row1['username'];
        $borrowedDate = $row1['borrowDate'];
        $totalCost = $row1['totalCost'];			
        
        $ExtendedDate = $_PSOT['Extenddate'];   //Get user's selected extended Date 
             echo $ExtendedDate;

      //Compute Due Date (after 1 week from borrowed Date)
      $date = new DateTime($borrowedDate);
      $date->modify('+1 week');
      $Duedate = $date->format('Y-m-d');    //DueDate from the date of borrowing ( 1 week)

      $earlier = new DateTime($borrowedDate);
      $later = new DateTime($Duedate);
      $diff = $later->diff($earlier)->format("%a");    // Get Date differences 
        //echo $diff;
      
      //Compute New Total Cost 
      $newCost = ($totalCost*7) + ($extendedCostPerDay * $diff);
        //echo $newCost;

      //Update the database table 'loan' 
        $update = "UPDATE loan 
                    SET ExtendedDate = '$ExtendedDate';  
                    totalCost = '$newCost';        
                    WHERE id='$id'";
				$update_Result = mysqli_query($dbc, $update);    //Excute query 
        if($update_Result)
        {
          echo "Successfully updated the loan table!";
        }
        else{
          echo 'Result Error';
        }
				header("Location: ExtendedList.php");				//Redirect page to Extended History Page 
			}

      $date = new DateTime($borrowedDate);
      $date->modify('+1 week');
      $Duedate = $date->format('Y-m-d');    //DueDate from the date of borrowing ( 1 week)
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
			   <td style="color: black;"><?php echo $ISBN;?></td>		
			</tr>
			</tr><br>
			<tr>
			<td>Title: </td>
			    <td style="color: black;"><?php echo $Title;?></td>
			</tr>
			</tr>
			<tr>
			<td>Author: </td>
         <td style="color: black;"><?php echo $Author;?></td>
			</tr>
			</tr>
			<tr>
			<td>Publisher :</td>
			    <td style="color: black;"><?php echo $Publisher;?></td>
			</tr>
			</tr>
			<tr>
				<td>Cost Per Day:</td>
        <td style="color: black;"><?php echo $costPerDay;?></td>
			</tr>
			<tr>
				<td>Extended Cost Per Day: </td>
        <td style="color: black;"><?php echo $extendedCostPerDay;?></td>
			</tr>
      <tr>
				<td>Your Borrowed Day: </td>
        <td style="color: black;"><?php echo $borrowedDate;?></td>
			</tr>
      <tr>
				<td style='color:red;'>Your Due Date (After one week from your borrowed date): </td>
        <td style="color: black;"><?php echo $Duedate;?></td>
			</tr>
      <tr>
				<td>Choose Extend Date: </td>
          <td><input type="date" id="Extenddate" name="Extenddate" required></td>
			</tr>
			<tr>
				<td><input style="width:100px; height:30px; background-color:#43e6c5;
        "type="submit" name="extend" value="Extend Rent"></td>
			</tr>
			<br>
<?php  	
	mysqli_close( $dbc ) ;
?>			
        </table>
    </form>
</div>
<script>
      document.getElementById('Extenddate').min = new Date() + 1 * 7;
</script>
	</body>
 
</html>