<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Bike Result</title>
</head>

<body>
    <div class="sidenav">
    <a href="Home.php">Home</a>
        <a href="AddBike.php">Add Bike</a>
        <a href="SearchBike.php">Search Bike</a>
        <a href="BuyerInterest.php">Buyer Interest</a>
    </div>

    <div class="SearchBike">
        <h1><b>Bike Result: </b></h1>
            <?php 
        $serialNo = $_POST["serialNo"];
        echo "<h1>" . "<u>". $serialNo. "</u>"."</h1>". "<br>";
  
          $listError = "Bike Serial No Not found!";

          //If Empty input 
          if(empty($_POST["serialNo"])){    
              $listError = "Please Enter the Product Serial No!";
          }
          //Else , Check the Serial No
          else{
             $serialNo = $_POST["serialNo"];
              $listheader = array("Serial No", "Bike Type", "Year of Manufacuture", "Characteristics", "Condition","Seller Name", "Phone No", "Email" );
              $productID = [];
              $row = 0;
              //Read "BikesforSale.txt" file 
              if(($fp = fopen("BikesforSale.txt", "r")) !== FALSE){
                  while(($d = fgetcsv($fp,1000,","))!== FALSE){
                      $num = count($d);
                      $productID[$row] = $d[0];   //Get every row of Product Serial No
                      $row++;
                  }
              }
              rewind($fp);

              //Read data from Buyer Int - "ExpInerest.txt" file 
              $BproductID = [];
              $row2 = 0;
              $BuyerCount = 0;
              if(($Bfile = fopen("ExpInterest.txt", "r"))!== FALSE)
			  {
                  while($Bdata = fgetcsv($Bfile, 1000,",") )
				  {
                      $num2 = count($Bdata);  //nos of line 
                      $BproductID[$row2] = $Bdata[0];   //Get every row of Product Serial No and store in an array
					//Count the nos of times "SerialNo" occurs in the string					  
                      $BuyerCount += substr_count($Bdata[0],$serialNo); 
                      $row2++;
                  }
              }
              rewind($Bfile);
              
     //Display the data 
    $c = 0;
    $row1 = 0;
    $validator = false;
    for ($i=0; $i < $row; $i++)  //Loop through all the rows from BikesforSale.txt 
    {            
      if ($productID[$i]== $serialNo) //If Serial No from BikesforSale.txt == userInput 
      {   
        $validator = true; 
        if ($validator) 
        {
          while(($data = fgetcsv($fp,1000,",")) !==false) //Get the data from "BikesforSale" file
          {
            if ($row1==$c)  //To get the correct bike data, If $row1 == c, then show that specific data   
             {
              $num1 = count($data);
              for ($a=0; $a < $num1 ; $a++) 
              { 
                $listError = "";
                echo "<label>" . "<span style='font-size:20px; color:blue;'>" .  
				$listheader[$a] . ": " 
				. "</span>" ."<span>" . $data[$a] . "</span>" . "</label>" . "<br>"."<br>";
              }
              echo "<label>" . "<span style='font-size:20px; color:blue;'>" . 
			  "No of buyer(s) interested in this product" . ": " . 
			  "</span>" . "<span>" . $BuyerCount . "</span>" . "</label>" . "<br>";
            }
            $row1++;     //If row1 != $c , then $row++    
          }   
      }
    } 
    else    //If Validator == False , then $c++ 
    {
      $c++;      
    }
  }
    fclose($fp);
    fclose($Bfile);
}
  
?>
    <label><span>
      <?php echo "<span style='color:red; font-size:30px;'>" .$listError. "</span>" ?>
   </span></label>
    </div>
</body>
</html>