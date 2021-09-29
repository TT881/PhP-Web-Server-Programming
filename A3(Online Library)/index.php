<?php
	require 'dbconfig.php';    

	// Create db connection
	$conn = mysqli_connect($servername, $username, $password);
	// Check connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}

	// Create database
	$sql = "CREATE DATABASE Library";
	if (mysqli_query($conn, $sql)) {
	  //echo "Database created successfully";
	} else {
	  //echo "Error creating database: " . mysqli_error($conn);
		mysqli_error($conn);
	}

	mysqli_close($conn);

	// Create connection to database 
	$con = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if ($con->connect_error) {
	  die("Connection failed: " . $con->connect_error);
	}

	// sql to create user table
	$user = "CREATE TABLE Users (
	id int AUTO_INCREMENT PRIMARY KEY,       /* User ID */
	username varchar(30) UNIQUE NOT NULL,
	password varchar(50) NOT NULL,
	name varchar(30) NOT NULL,
	surname varchar(30) NOT NULL,
	phone int(8) NOT NULL,
	email varchar(50) NOT NULL,
	type varchar(50) DEFAULT 'Librarian'
	)";

	// sql to create Books table
	$books = "CREATE TABLE Books (  
    id int AUTO_INCREMENT PRIMARY KEY,       /* Book ID */
    ISBN varchar(50) NOT NULL,
    Title varchar(50) NOT NULL,
    Author varchar(50) NOT NULL,
    Publisher varchar(50) NOT NULL,
    status varchar(20) DEFAULT 'Available',
    costPerDay int NOT NULL,
    extendedCostPerDay int NOT NULL,
    rentedBy varchar(30) NULL
	)";

	// sql to create Loan table
	$loan = "CREATE TABLE loan (
    id int AUTO_INCREMENT PRIMARY KEY,  
    loanID int,          /*loan ID = Book ID*/
    username varchar(50),
    borrowedDate date,
    ExtendedDate date NULL,
    totalCost int NULL
	)";


	//CREATE Librian account 
	$insert = "INSERT INTO `users` (id, username, password, name, surname, phone, email, type) 
	VALUES (NULL, 'Ting', '1234', 'Ting', 'Ting', '91234567', 'TT@mail.com', 'Librarian')";


	if ($con->query($user) === TRUE) {
	  //echo "Table Users created successfully";
	} else {
	  //echo "Error creating table: " . $con->error;
		$con->error;
	}

	if ($con->query($books) === TRUE) {
	  //echo "Table Books created successfully";
	} else {
	  //echo "Error creating table: " . $con->error;
		$con->error;
	}

	if ($con->query($loan) === TRUE) {
	  //echo "Table loan created successfully";
	} else {
	  //echo "Error creating table: " . $con->error;
		$con->error;
	}

	if ($con->query($insert) === TRUE) {
	  //echo "Librarian User Created Successfully";
	} else {
	 //echo "Error Creating User: " . $con->error;
		$con->error;
	}
	//mysqli_close($con);

	$con -> close();

	//session_start();
	$dbc = mysqli_connect($servername, $username, $password, $dbname);
	
	if(isset($_POST['submit'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$_SESSION['username'] = $_POST['username'];

		$user=mysqli_query($dbc,"SELECT * FROM users WHERE username='$username' AND password='$password'");

		$sql= "(SELECT * FROM `users` where username='$username' && password='$password')";

		$result = mysqli_query($dbc, $sql);
	    $row = mysqli_fetch_array($result);

			$username = $row['username'];
			$type = $row['type'];
		
			$_SESSION["username"] = $row["username"];
			$_SESSION["type"] = $row["type"];

			if(mysqli_num_rows($user)==1){
				$_SESSION["username"] = $row["username"];
				header("Location:listBook.php");            // Redirect 
					//echo "logged in";
				die('should have redirected by now');
			}

			else {
			echo "Error! No user found.";
			}

		}

			if (isset($_POST['register']))            //If new user Register 
			{
				header("Location: register.php");			//redirect "register.php" 
			}

		mysqli_query($dbc, $sql);
		//mysqli_close( $dbc );
		$dbc -> close();
	
?>

<html>
	<head>
	<title>Music-to-Go</title>
	<link href="stylesheet.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
	<div id="container">
	<br>
	<h1>Login Page</h1>
	<br><br><br>
    <form method="post" action=""> 
        <fieldset>
            <table>
                <tr>
                    <td><label for="username">Username:</label></td>
                    <td><input type="text" id="username" name="username"/></td>
                </tr>
                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="password" id="password" name="password"/></td>
                </tr>
                <tr>
                    <td colspan='2' style='text-align:center;'>
                        <br><input type="submit" value="Login" name="submit"/>
                        <input type="submit" name="register" value="Register Here">
                    </td>
                </tr>
                
            </table>
         </fieldset>
    </form>
	</div>
</body>
</html>