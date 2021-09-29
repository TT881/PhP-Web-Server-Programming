<?php
	require 'dbconfig.php';

	if (isset($_POST['submit'])){
		// Connection to database
		$dbc = mysqli_connect($servername, $username, $password, $dbname);

		// Check connection
		if (!$dbc) {
		  die("Connection failed: " . mysqli_connect_error());
		}

		//variable      $_POST is for the one given in the HTML.
		$username = $_POST['username'];
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$type = $_POST['type'];

		//INSERT into "table name" followed by "names in mysql"  VALUES "the variables given from above"
		$sql = "INSERT INTO `users` (`id`, `username`, `password`, `name`, `surname`, `phone`, `email`, `type`) 
						VALUES (NULL, '$username', $password, '$name', '$surname', '$phone', '$email', '$type')";

		if (mysqli_query($dbc, $sql)) {
		  echo "New user record created successfully";
		} else {
		  echo "Error: " . $sql . "<br>" . mysqli_error($dbc);
		}

		header("Location: success.php");		//redirect to success.php page
	}
?>

<html>
	<head>
	<title>Digital Library</title>
	<link href="stylesheet.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
	<div id="container">
	<br>
	<h1>Registration Page</h1>
	<br><br><br>
            <form method="post"> 
                <fieldset>
                    <table>
                        <tr>
                            <input type="hidden" name="id" >			<!-- unique auto increment ID-->                                
                            <td><label >Username:</label></td>
                            <td><input type="text" required id="username" name="username"/></td>
                        </tr>
                        <tr>
                            <td><label>Password:</label></td>
                            <td><input type="password" required id="password" name="password"/></td>
                        </tr>
                        <tr>
                            <td><label>Name:</label></td>
                            <td><input type="text" required id="name" name="name"/></td>
                        </tr>
                        <tr>
                            <td><label>Surname:</label></td>
                            <td><input type="text" required id="surname" name="surname"/></td>
                        </tr>
                         <tr>
                            <td><label>Phone:</label></td>
                            <td><input type="text" required id="phone" name="phone"/></td>
                        </tr>
							<tr>
                            <td><label>Email:</label></td>
                            <td><input type="email" required id="email" name="email"/></td>
                        </tr>
                        <tr>
                        	<td><label>Type:</label></td>
                        	<td><select id="type" required name="type">
									<option value="Librarian">Librarian</option>
									<option value="Borrower">Borrower</option>
							</select></td>
                    	</tr>
                        <tr>
                            <td colspan='2' style='text-align:left;'><br>
                                <input type="submit" name="submit" value="Submit"/>
                            </td>
                        </tr>
                        
                    </table>
                 </fieldset>
            </form>
        </div>
	</body>
</html>