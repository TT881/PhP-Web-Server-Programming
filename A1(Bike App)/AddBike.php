<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Add Bike</title>

</head>

<body>
    <div class="sidenav">
        <a href="Home.php">Home</a>
        <a href="AddBike.php">Add Bike</a>
        <a href="SearchBike.php">Search Bike</a>
        <a href="BuyerInterest.php">Buyer Interest</a>
    </div>

    <div class="AddBike">
        <h1><b>Add Bike</b></h1>
        <?php 
          if (isset($_POST['Submit']))
           {
                //Variable to store the data entered by the user 
				$serialNo = $_POST['serialNo'];
				$type = $_POST['type'];
				$year = $_POST['year'];
				$chara = $_POST['chara'];
				$condition = $_POST['condition'];
                $name = $_POST['name'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];

                $checkYear  =  substr($year, -2);      //Get the Last 2 Digits only 
                //echo $checkYear;
                $checkSerialNo = substr($serialNo,0,2);  //Get the first 2 Digits only 
                //echo $checkSerialNo; 

                 //Parse from user input 
                 $dataInput = isset($_POST['serialNo'])? $_POST['serialNo']:'';

				//Read the data from "BikesforSale.txt" file 
                $data = file('BikesforSale.txt');  //Read entire file into an array 
                $accessData = array();
                foreach($data as $line){
                    list($id,$type) = explode(',', $line);  
                    $accessData[trim($id)] = trim($type);   
                        //echo $id. "<br>";
                }
                //Validate the Serial No format  
                if(!preg_match("/^[0-9]{2}-[0-9]{3}-[a-z]{3}$/", $serialNo)){ 
                    $serialNoError = "Invalid Serial No Format! Please Enter again!";   
                }
                elseif($checkYear != $checkSerialNo)        //Check the ID & Year 
                {
                    $serialNoError2 = "Please enter the First 2 Serial No digits (yy-nnnn-cc with yy being the last 2 digits of manufacturing year)!";
                }
                //Validate the Phone No format
                elseif(!preg_match("/^[6|9|8][0-9]{7}$/",$phone)){
                    $PhoneError = "Invalid Contact No Format!Please Enter again!";
                }
                //Validate year	
				elseif(!preg_match("/^[1|2|][0-9]{3}$/",$year)){
                    $YearError = "Invalid year!Please Enter again!";
                }
                //Validate Email address 
                elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
				{
                    $emailErr = "Invalid Email format! Please Enter again!";
                } 
                //Check Duplicate serialNo 
                elseif(array_key_exists($dataInput, $accessData)) 
                {
					$WrongSerialNo = "Serial Number Already Exists! Please Enter again!";        
                }
                else
				{
                    echo "";
					$serialNo = $_POST['serialNo'];
					$type = $_POST['type'];
					$year = $_POST['year'];
					$chara = $_POST['chara'];
					$condition = $_POST['condition'];
					$name = $_POST['name'];
					$phone = $_POST['phone'];
					$email = $_POST['email'];
				  
					$BikeTxt = $serialNo . "," . $type . "," . $year . "," . $chara . "," . $condition . "," . $name . "," . $phone . "," . $email."\n" ;
				  
					//Write the data to the "BikesforSale.txt" file 
					$myfile = fopen("BikesforSale.txt", "a") or die ("Unable to open file!");    //Append data to the file
					fwrite($myfile,$BikeTxt);
					fclose($myfile);
					echo "<p style='color:green; font-size:20px;'>" ."Successfully Submitted!" . "</p>";
                }
            }       
            ?>
			<br> 
            <?php  
                    if (isset($serialNoError)){ ?>
                        <p><?php echo "<p style='color:red; font-size:20px;'>". $serialNoError; ?></p>
                   <?php } ?>

                   <?php
                    if(isset($serialNoError2)){ ?>
                       <p><?php echo "<p style='color:red; font-size:20px;'>".$serialNoError2; ?> </p>
                    <?php } ?>

                    <?php
                    if(isset($PhoneError)){ ?>
                       <p><?php echo "<p style='color:red; font-size:20px;'>".$PhoneError; ?> </p>
                    <?php } ?>

					 <?php
                    if(isset($YearError)){ ?>
                       <p><?php echo "<p style='color:red; font-size:20px;'>".$YearError; ?> </p>
                    <?php } ?>

                    <?php 
                    if(isset($emailErr)){ ?> 
                       <p> <?php echo "<p style='color:red; font-size:20px;'>".$emailErr; ?> </p>
                    <?php } ?>
                    
                    <?php if ( isset($WrongSerialNo)){?>
                    <p> <?php echo "<p style='color:red; font-size:20px;'>".$WrongSerialNo; ?> </p> 
                    <?php }?>

        <form action="AddBike.php" method="POST">
            <label for="serialNo">Bike Serial No:</label><br>
            <input type="text" id="serialNo" name="serialNo" placeholder="yy-nnn-ccc" required><br><br>

            <label for="type">Bike Type:</label><br>
            <input type="text" id="type" name="type" value="" required><br><br>

            <label for="year">Year of Manufacture:</label><br>
            <input type="text" id="year" name="year" value="" required><br><br>

            <label for="chara">Characteristics:</label><br>
            <textarea id="chara" name="chara" rows="4" cols="50" required></textarea><br><br>

            <label for="condition">Condition:</label><br>
            <textarea id="condition" name="condition" rows="4" cols="50" required></textarea><br><br>

            <label>Seller Name: </label><br>
            <input type="text" id="name" name="name" size="15" required><br><br>

            <label>Phone No:</label><br>
            <input type="text" id="phone" name="phone" size="15" required><br><br>

            <label>Email: </label><br>
            <input type="text" id="email" name="email" size="15" required><br><br>

            <input class="submit" type="submit" name = "Submit" value="Submit">
        </form>
    </div>
</body>
</html>