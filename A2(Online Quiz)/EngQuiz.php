<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Score It! Eng Quiz</title>
</head>
<body>
<h1 class="text-center" style="background-color:#414a4f; color:white;">English Quiz!<hr/></h1>
<div class="form-style">
<?php 
session_start();
echo "<h2>" . "Welcome: <u>" . $_SESSION["name"] . "</u></h2>";
echo "<i> For every correct answer, 5 points will be added to your  total score. </i><br>";
echo "<i> For every wrong answer, 3 points will be deducted from your total score. </i>";
echo "<hr/><br/>";

$EngQues = array(
  "Who is the author of The Origin Of Species?" => "Darwin",
  "Tweedledum and Tweedledee are two characters of which Children’s book" => "Alice in Wonderland",
  "People of which religion consider ‘The Bhagavad Gita’ as their sacred text" => "Hinduism",
  "Who invented the character, Robinson Crusoe?" => "Daniel Defoe",
  "Name the mega-selling writer who has written “Deception Point”?"  => "Dan Brown",
  "‘The War of The World’s’ is a famous work of which author?"   => "HG Wells",
  "Name the Italian Astronomer who is the author of The Starry Messenger?" => "Galileo",
  "The ‘Almagest’ is a book written by a Greek Astronomer. What is the name of him?" => "Ptolemy",
  "Who is the author of “Roots” that inspired a TV blockbuster?" => "Alex Haley",
  "“Rites of Passage” is a novel written by?" => "William Golding",  
				);

$RandQues = array_rand($EngQues,4);

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
	$Answers = $_POST['ans'];
	if (is_array($Answers)) {
		foreach ($Answers as $Questions => $Response) {
			$Response = stripslashes($Response);
			if (strlen($Response)>0) {
				if (strcasecmp($EngQues["$Questions"],$Response)==0) {
          echo "<span style='color:green;'><label>You have answered correctly! ' $Questions ' is " . $EngQues[$Questions] . ".</label></span><br /><br />\n";
					$correct++;
				}
					
				else {
					echo "<span style='color:red;'><label>Sorry, your answer is incorrect!  The correct answer for ' $Questions '  is :" . $EngQues[$Questions] ." .</label></span><br /><br />\n";
					$wrong++;
				}
					
			}
			else {
				echo "<label>You did not answer $Questions.</label><br /><br />\n";
			} 
				
		}
	}
	$displayscore = calculatescore($correct,$wrong);
	if ($displayscore > 0) {
		
		if (empty($_SESSION["EngScore"])) {
			$_SESSION["EngScore"] = $displayscore;
		}

		elseif ($displayscore > $_SESSION["EngScore"]) {
			$_SESSION["EngScore"] = $displayscore;
		}
	}
	else if ($displayscore < 0){ //Instead of showing a negative score, show the score as 0.
			$displayscore = '0';
			$_SESSION["EngScore"] = $displayscore;
	}

	echo "<h1 style='color:blue;'>You scored :" . $displayscore . "/20</h1><br/><br/>";
	echo "<button onclick=\"window.location.href = 'Category.php';\" >Select Other Subject</button>&nbsp;";
	echo "<button onclick=\"window.location.href = 'EngQuiz.php';\" >Re-attempt Quiz</button>&nbsp;";
	echo "<button onclick=\"window.location.href = 'Exit.php';\">End Quiz</button>";
}

else {
 
	echo "<button onclick=\"window.location.href = 'Category.php';\" >Choose Another Subject</button><br><br>";
  echo "<h4 style='color:black; font-weight:bold; margin-left:250px; padding:20px;'> Please Answer the following questions: </h4>";
	
  if(!empty($_SESSION["EngScore"])){
    echo "<b style='color:blue;'> Your Current Highest Score is:  </b>";
		echo "<span style='color:blue; font-weight:bold;'>" .$_SESSION["EngScore"];
		echo "/20</span><br/><br/>";
	}

  //Display 4-Attempt  Questions
	echo "<form action='EngQuiz.php' method='POST' autocomplete='off'>\n";
	for ($i=0; $i < 4 ; $i++) { 
		echo "<p style='font-weight:bold;'>$counter. ";
		echo "$RandQues[$i].</p>";
		echo "<input type='text' required pattern='[a-zA-Z ]*' name='ans[" . $RandQues[$i] . "]' /><br /><br />";
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
