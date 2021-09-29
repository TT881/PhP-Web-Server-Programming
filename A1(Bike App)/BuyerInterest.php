<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Buyer Interest</title>
</head>

<body>
    <div class="sidenav">
    <a href="Home.php">Home</a>
        <a href="AddBike.php">Add Bike</a>
        <a href="SearchBike.php">Search Bike</a>
        <a href="BuyerInterest.php">Buyer Interest</a>
    </div>
    <div class="BuyerInterest">
        <h1><b>Buyer Interest</b></h1>
        <?php 
           
           if (isset($_POST['submit']))
           {
               //Read the data from "BikesforSale.txt" file 
                $data = file('BikesforSale.txt');
                $accessData = array();
                foreach($data as $line){
                    list($id,$type) = explode(',', $line);  
                    $accessData[trim($id)] = trim($type);   //Want to get the Bike ID 
                        //echo $id. "<br>";
                }
                //Parse from user input 
                $dataInput = isset($_POST['serialNo'])? $_POST['serialNo']:'';

                //Variable to store the data entered by the user 
                $serialNo = $_POST['serialNo'];
                $price = $_POST['price'];
                $name = $_POST['name'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];

                //Validate the Serial No format  
                if(!preg_match("/^[0-9]{2}-[0-9]{3}-[a-z]{3}$/", $serialNo)){    
                    $serialNoError = "Invalid Serial No Format! Please Enter again!";
                }
                //Validate the Phone No format
                elseif(!preg_match("/^[6|9|8][0-9]{7}$/",$phone)){
                    $PhoneError = "Invalid Contact No Format!Please Enter again!";
                }
                //Validate Price 
                elseif(!preg_match("/^[1-9][0-9]*$/",$price))
                {
                    $priceError = "Invalid Price! Please Enter again!";
                }
                //Validate Email address 
                elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid Email format! Please Enter again!";
                } 
                //Check serialNo its exists or not
                elseif (array_key_exists($dataInput, $accessData) ) //Compare the Key value from $accessData array 
                {
                          echo "";
                          $serialNo = $_POST['serialNo'];     // Get the user input 
                          $price = $_POST['price'];
                          $name = $_POST['name'];
                          $phone = $_POST['phone'];
                          $email = $_POST['email'];
              
                          $AddInterest = $serialNo.",". $price. ",". $name . "," .$phone . "," . $email. "\r\n";
                          $buyerFile = "ExpInterest.txt";
              
                          //Write the data to the "ExpInterest.txt" file 
                          $myfile = fopen($buyerFile, "a") or die ("Unable to open file!");    //Append data to the file
                          fwrite($myfile,$AddInterest ."\n");
                          fclose($myfile);
                          echo "<p style='color:green; font-size:20px;'>" ."Found the Serial No." . "</p>";
                          echo "<p style='color:green; font-size:20px;'>" ."Successfully Submitted!" . "</p>";
                }
                else{
                    $WrongSerialNo = "Serial Number Doesn't Exists! Please Enter again!";
                }
            }
            ?>
              <br> 
            <?php  
                    if (isset($serialNoError)){ ?>
                        <p><?php echo "<p style='color:red; font-size:20px;'>". $serialNoError; ?></p>
                   <?php } ?>
                    <?php
                    if(isset($PhoneError)){ ?>
                       <p><?php echo "<p style='color:red; font-size:20px;'>".$PhoneError; ?> </p>
                    <?php } ?>
                    <?php 
                    if(isset($emailErr)){ ?> 
                       <p> <?php echo "<p style='color:red; font-size:20px;'>".$emailErr; ?> </p>
                    <?php } ?>
                    
                    <?php if ( isset($WrongSerialNo)){?>
                    <p> <?php echo "<p style='color:red; font-size:20px;'>".$WrongSerialNo; ?> </p> 
                    <?php }?>

                    <?php if ( isset($priceError)){?>
                    <p> <?php echo "<p style='color:red; font-size:20px;'>".$priceError; ?> </p> 
                    <?php }?>
                            
        <form action="BuyerInterest.php" method="POST">
            <label for="serialNo">Bike Serial No:</label><br>
            <input type="text" id="serialNo" name="serialNo" placeholder="yy-nnn-ccc" required><br><br>

            <label>Propose Price ($):</label><br>
            <input type="text" id="price" name="price" size="15" required><br><br>

            <label>Name: </label><br>
            <input type="text" id="name" name="name" size="15" required><br><br>

            <label>Phone No:</label><br>
            <input type="text" id="phone" name="phone" size="15" required><br><br>

            <label>Email: </label><br>
            <input type="text" id="email" name="email" size="15" required><br><br>

            <input class="submit" type="submit" name="submit" value="submit">
            </form>   
       </div>
       
</body>
</html>