<?php session_start();
$arrcopy = array();
for($i=0;$i<10;$i++){
	$temp = array();
	for($j=0;$j<10;$j++){
		array_push($temp,$_POST[$i.$j]);
	}
	array_push($arrcopy,$temp);
}
function printarray($arr){
            for($i=1;$i<10;$i++){
              for($j=1;$j<10;$j++){
                echo $arr[$i][$j];
                echo "     ";
                }
                echo "<br>";
              }
          }
include("home.php");


$arr2 = $_SESSION['arr'];
//printarray($arr2);
function check($arrcopy,$arr2){
	for($i=0;$i<10;$i++){
		for($j=0;$j<10;$j++){
			if($arrcopy[$i][$j] != $arr2[$i][$j]){
				return false;
			}
		}
	}
	return true;
}

if(check($arrcopy,$arr2)){
echo "yeah you won the puzzle";
echo "<br>";
echo "click on Genrate Crossword to play again";
}
else{
echo "oops! you are wrong";
echo "<br>";
echo "click on Genrate Crossword to try again";
}			
?>
