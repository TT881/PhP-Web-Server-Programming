<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <title>Score It ! Math Quiz</title>
</head>
<body>
<h1 class="text-center" style="background-color:#414a4f; color:white;">Math Quiz!<hr/></h1>
<div class="form-style">
<?php 
session_start();
echo "<h2>" . "Welcome: <u>" . $_SESSION["name"] . "</u></h2>";
echo "<i> For every correct answer, 5 points will be added to your  total score. </i><br>";
echo "<i> For every wrong answer, 3 points will be deducted from your total score. </i>";
echo "<hr/><br/>";

//Total 10 Ques , put it in Associative Array
$MathQues = array(
  "How much is 4 + 2?" => "6",
  "How much Square root of 144?" => "12",
  "How much is 80 divided by 10?" => "8",
  "How much is 6-4?" => "2",
  "How much is 10/2?"  => "5",
  "How much is 40 x 2?"   => "80",
  "How much Square root of 100? " => "10",
  "What is (6 - 5) equal to?" => "1",
  "What is (15 / 3) equal to?" => "5",
  "What is (25 / 5)" => "5",  
				);

$RandQues = array_rand($MathQues,4);    

//to calculate the score
function calculatescore($correct,$wrong) {
	$total = ($correct * 5)-($wrong * 3);
	return $total;
}

$wrong = 0;
$correct = 0;
$counter = 1;
$displayscore = 0;
if (isset($_POST['submit'])) {
	$Answers = $_POST['ans'];         //Get User's Ans Input value 
	if (is_array($Answers)) {
		foreach ($Answers as $Questions => $Response) {   //Iterate through Each user's Input Value for that ques
			$Response = stripslashes($Response);
			if (strlen($Response)>0) {
				if (strcasecmp($MathQues["$Questions"],$Response)==0) {     //Compare with $MathQues-Array's Value 
          echo "<span style='color:green;'><label>You have answered correctly! ' $Questions ' is " . $MathQues[$Questions] . ".</label></span><br /><br />\n";
					$correct++;
				}
				else {
					echo "<span style='color:red;'><label>Sorry, your answer is incorrect!  The correct answer for ' $Questions '  is :" . $MathQues[$Questions] ." .</label></span><br /><br />\n";
					$wrong++;
				}		
			}
			else {
				echo "<label>You did not answer $Questions.</label><br /><br />\n";
			} 			
		}
	}
    //To Display Score 
	$displayscore = calculatescore($correct,$wrong); 
	if ($displayscore > 0) {                                //If User get Score 
		if (empty($_SESSION["MathScore"])) {
			$_SESSION["MathScore"] = $displayscore;       
		}

		elseif ($displayscore > $_SESSION["MathScore"]) {    //Update User's Score 
			$_SESSION["MathScore"] = $displayscore;
		}
	}
	else if ($displayscore < 0){    //Instead of showing a -ve score, show the score as 0.
			$displayscore = '0';
			$_SESSION["MathScore"] = $displayscore;
	}

	echo "<h1 style='color:blue;'>You scored :" . $displayscore . "/20</h1><br/><br/>";
	echo "<button onclick=\"window.location.href = 'Category.php';\" >Select Other Subject</button>&nbsp;";
	echo "<button onclick=\"window.location.href = 'MathQuiz.php';\" >Re-attempt Quiz</button>&nbsp;";
	echo "<button onclick=\"window.location.href = 'Exit.php';\">End Quiz</button>";
}

else {           //Display the Category Page
 
  echo "<button onclick=\"window.location.href = 'Category.php';\" >Choose Another Subject</button><br><br>";
  echo "<h4 style='color:black; font-weight:bold; margin-left:250px; padding:20px;'> Please Answer the following questions: </h4>";
	
  if(!empty($_SESSION["MathScore"])){     //If user already get Score,, Display Current points
    echo "<b style='color:blue;'> Your Current Highest Score is:  </b>";
		echo "<span style='color:blue; font-weight:bold;'>" .$_SESSION["MathScore"];
		echo "/20</span><br/><br/>";
	}

  //Display 4-Attempt Questions
	echo "<form action='MathQuiz.php' method='POST' autocomplete='off'>\n";
	for ($i=0; $i < 4 ; $i++) { 
		echo "<p style='font-weight:bold;'>$counter. ";   
		echo "$RandQues[$i].</p>";
		echo "<input type='text' required pattern='[0-9]\d*' name='ans[" . $RandQues[$i] . "]' /><br /><br />";    //Get user input
		$counter++;
	}
	
  echo "<input style= 'width:200px; background-color: green;' type='submit' name='submit' value='Submit Answers' />"; 
  echo "&nbsp;&nbsp;&nbsp;";
  echo "<input type='submit' name='clear' value='Clear'/>";
  echo "<br/><br/>";
  echo "</form>\n";
	
}
?>

</div>
<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js " integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf " crossorigin="anonymous "></script>
</body>
</html>
