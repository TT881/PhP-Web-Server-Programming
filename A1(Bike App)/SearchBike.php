<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Search Bike</title>
</head>

<body>
    <div class="sidenav">
    <a href="Home.php">Home</a>
        <a href="AddBike.php">Add Bike</a>
        <a href="SearchBike.php">Search Bike</a>
        <a href="BuyerInterest.php">Buyer Interest</a>
    </div>

    <div class="SearchBike">
        <h1><b>Search Bike</b></h1><br>
            <form action="SearchResult.php" method="POST">    <!-- Redirect to SearchResult.php -->
                <label for="serialNo">Search By Serial No:</label><br>
                <input type="text" id="serialNo" name="serialNo" placeholder="yy-nnn-ccc" required>&nbsp;
                <input class="submit" type="submit" value="Search"><br><br>
            </form>

            <?php 
            $listheader = array("Serial No", "Bike Type", "Year of Manufacuture", "Characteristics", "Condition","Seller Name", "Phone No", "Email" );
            $row = 0;
            if(file_exists("BikesforSale.txt") &&($fp = fopen("BikesforSale.txt", "r"))!== FALSE)  //Read file 
            {
                while(($data = fgetcsv($fp, 1000, ","))!== FALSE){
                    $num = count($data);
                    //See what system has read 
                    for ($c= 0; $c < $num; $c++)
                    {
                       // echo "<label>". "<span class='header'>". $listheader[$c]. ":" . "</span>". 
                        //"<span>".$data[$c]. "</span>". "</label>". "<br>" ; 

                        echo "<table style = \"width: 100%; border = 1;\">";
                        echo "<tr>";  
                            echo "<th style = \" text-align: left; width: 50%;\">". $listheader[$c] . "</th>"; //1st Col 
                            echo "<td style=\" text-align:left; \">". $data[$c]. "</td>"; //2nd Col 
                            echo "</tr>";
                        echo "</table>";
                    }
                    echo "<br>";
                }
                fclose($fp);   //Close the file 
            }
            else{
                echo "No Such file". "<br>";
            }         
            ?>                      
    </div>
</body>

</html>