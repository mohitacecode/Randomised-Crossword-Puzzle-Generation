<!--___________________________________________________HTML PART___________________________________________________________-->

<html>
<head>
<style>
#submit1{
width:200;
}
#test{
width:180;
}
#equal{
  width:200;
}
input{
width:50;
}
table{
width:80%;
}
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 15px;
  text-align: left;
}
col:nth-child(odd) {
  background: gray;
}

col:nth-child(even) {
  background: white;
}
</style>
<body>
<?php $arrcopy = array();
	include("home.php");
	$arrcopy = $arr1;
?>
<center>
	<table border="3">
		<colgroup>
			<col>
			<col>
			<col>
			<col>
			<col>
			<col>
			<col>
			<col>
			<col>
			<col>
  		</colgroup>
<center>
  <tbody>	<tr>
  <?php for($i=0;$i<10;$i++){  ?>
    <?php if($i == 0) {?> <th><?php echo " "; ?></th> <?php } ?>
	<th><?php echo $i; ?></th>
<?php }?>
	</tr>

	<form method = "POST" action = "equal.php" >
		<?php for($i=0;$i<10;$i++) { ?>
			<tr><th> <?php echo $i; ?></th>
				<?php for($j=0;$j<10;$j++){ $id = $i.$j;
        			if ($arr1[$i][$j]=='*' or $arr1[$i][$j]=='-' ){?>
					<center>
					<td>
	<input type = "text" maxlength = "1" name= <?php echo $id; ?> value = <?php echo $arr1[$i][$j]; ?>  style="background-color: black"readonly>
					</td>
					</center>

				<?php } else { ?>
	 				<center>
					<td>
					<input type = "text" maxlength = "1" name= <?php echo $id; ?> >
					</td>
					</center>
				<?php } } ?>
				</tr>
				<?php }  ?>




</tbody>
</center>
</table>
</center>
<br>
	<center>
	<input type="submit" name="equal" id="equal" value="SUBMIT CROSSWORD" width="100" height="20" />
	</center>
</form>


	<table>
	<tr>
	<th>Row</th>
	<th>Col</th>
	<th>Horizontal</th>
	</tr>
	<?php foreach($crosscom as $word){
		$temp = $indexes[$word];
		$row = $temp[0];
		$col = $temp[1];
		$align = $temp[2];
		if($align == 0){
		?><tr>
			<td><?php echo $row ?>
			<td><?php echo $col ?>
			<td><?php echo $info[$word] ?></td>
		</tr>
	<?php } }?>
	</table>
	<table>
	<tr>
	<th>Row</th>
	<th>Col</th>
	<th>Vertical</th>
	</tr>
	<?php foreach($crosscom as $word){
		$temp = $indexes[$word];
		$row = $temp[0];
		$col = $temp[1];
		$align = $temp[2];
		if($align == 1){
		?><tr>
			<td><?php echo $row ?>
			<td><?php echo $col ?>
			<td><?php echo $info[$word] ?></td>
		</tr>
<?php } } ?>



</table>

<!-- _______________________________________________ALGORITHM_____________________________________________________________ -->
		<?php /*set_time_limit(0);
//____________________________________________DECLERATION OF VARIABLES________________________________________________________
			//BACKEND CROSSWORD GRID
			$arr = array(['-','-','-','-','-','-','-','-','-','-'],['-','-','-','-','-','-','-','-','-','-'],['-','-','-','-','-','-','-','-','-','-'],['-','-','-','-','-','-','-','-','-','-'],['-','-','-','-','-','-','-','-','-','-'],['-','-','-','-','-','-','-','-','-','-'],['-','-','-','-','-','-','-','-','-','-'],['-','-','-','-','-','-','-','-','-','-'],['-','-','-','-','-','-','-','-','-','-'],['-','-','-','-','-','-','-','-','-','-']);

			$arrcom = array();
			$horarr = array(0,0,0,0,0,0,0,0,0,0);
			$verarr = array(0,0,0,0,0,0,0,0,0,0);
			$crosscom = array();
      $indexes = array();
//________________________________________________________DATABASE ACCESS_____________________________________________________
			$host        = "host = 127.0.0.1";
			$port        = "port = 5432";
			$dbname      = "dbname = command";
			$credentials = "user = mohitgupta password=mohit";

			$db = pg_connect( "$host $port $dbname $credentials");

//___________________________________________FUNCTIONS REQUIRED FOR GENRATING CROSSWORD_______________________________________

			//FUNCTION FOR UPDATING HOR AND VER ARRAY COUNT
      function updateindexes($indexes,$word,$num1,$num2,$align){
        $indexes += [$word => array($num1,$num2,$align)];
        return $indexes;
        }
			function updatecount($arr){
				$horarr = array(0,0,0,0,0,0,0,0,0,0);
				$verarr = array(0,0,0,0,0,0,0,0,0,0);
				for($i=0;$i<10;$i++){
					$counting = array();
					$count = 0;
					$max = 0;
					for($j=0;$j<10;$j++){
						if ($arr[$i][$j] == '-'){
							$count+=1;
						}
						else{
							array_push($counting,$count);
							$count = 0;
						}
					}
					array_push($counting,$count);
					$horarr[$i] = max($counting);
				}
				for($i=0;$i<10;$i++){
					$counting = array();
					$max = 0;
					$count = 0;
					for($j=0;$j<10;$j++){
						if ($arr[$j][$i] == '-'){
							$count+=1;
						}
						else{
							array_push($counting,$count);
							$count = 0;
						}
					}
					array_push($counting,$count);
					$verarr[$i] = max($counting);
				}
				return array($verarr,$horarr);
			}

			//FUNCTION START => CHECK SPACE AVAILABLITY
			function checkspace($arr,$word,$num1,$num2,$align){
				$length = strlen($word);
				if($align == 0){
					for($i=$num2-1;$i<$num2+$length+1;$i++){
						if($arr[$num1][$i] != '-'){
							return false;
						}
					}
					return(true);
				}
				else{
					for($i=$num1-1;$i<$num1+$length+1;$i++){
						if($arr[$i][$num2] != '-'){
							return false;
						}
					}
					return (true);
				}
			}
      function checkspace1($arr,$word,$num1,$num2,$align){
				$length = strlen($word);
				if($align == 0){
					for($i=$num2-1;$i<$num2+$length+1;$i++){
            if($i == $num2){
                continue;
              }
						if($arr[$num1][$i] != '-'){
							return false;
						}
					}
					return(true);
				}
				else{
					for($i=$num1-1;$i<$num1+$length+1;$i++){
            if($i==$num1){
              continue;
              }
						if($arr[$i][$num2] != '-'){
							return false;
						}
					}
					return (true);
				}
			}
			//FUNCTION END => CHECK SPACE AVAILABLITY

			//FUNCTION START => FUNCTION TO MAKE A LIST OF COMMANDS
		   	function command($db){
				$sql = "select * from command order by random() limit 1";
				$ret = pg_query($db,$sql);
				$row = pg_fetch_row($ret);
				return $row[1];
			}
			//FUNCTION END => FUNCTION TO MAKE A LIST OF COMMANDS

			//FUNCTION START => FUNCTION TO GENRATE ROW AND COLUMN
			function random2gen(){
				$num1 = rand(1,8);
				$num2 = rand(1,8);
		    		return array($num1,$num2);
			}
			//FUNCTION END => FUNCTION TO GENRATE ROW AND COLUMN

			//FUNCTION START => FUNCTION TO GENRATE ALIGNMENT OF WORD 0 -> HORIZONTAL 1 -> VERTICAL
			function random1gen(){
				$num1 = rand(0,1);
		    		return $num1;
			}
			//FUNCTION END => FUNCTION TO GENRATE ALIGNMENT OF WORD 0 -> HORIZONTAL 1 -> VERTICAL

			//FUNTION START => FUNCTION TO GENRATE ARRAY OF RANDOM COMMAND
			function randomcommand($arrcom,$db){
				while(sizeof($arrcom) != 20){
					$word = command($db);
					if(!in_array($word,$arrcom)){
						array_push($arrcom,$word);
					}
				}
				return ($arrcom);
			}
			//FUNTION END => FUNCTION TO GENRATE ARRAY OF RANDOM COMMAND

			//ARRAY OF COMMANDS
			$arrcom = randomcommand($arrcom,$db);

			//FUNCTION START => FUNCTION TO FILL THE SPACE IN THE BACKEND GRID
			function fillup($word,$align,$arr,$num1,$num2,$crosscom){
				$count = 0;
				$wordlength = strlen($word);
				if($align==0){
					for($i=$num2;$i<$num2+$wordlength;$i++){
						$arr[$num1][$i] = $word[$count];
						$count++;
					}
					if($num2+$wordlength != 10){
						$arr[$num1][$num2+$wordlength] = '*';
					}
					if($num2!=0){
						$arr[$num1][$num2-1] = '*';
					}
					return $arr;
				}
				else{
					for($i=$num1;$i<$num1+$wordlength;$i++){
								$arr[$i][$num2] = $word[$count];
								$count++;
							}
							if($num1+$wordlength != 10){
								$arr[$num1+$wordlength][$num2] = '*';
							}
							if($num1!=0){
								$arr[$num1-1][$num2] = '*';
							}
					return $arr;
				}
			}
			//FUNCTION END=> FUNCTION TO FILL THE SPACE IN THE BACKEND GRID

			//FUNCTION START => FUNCTION TO FIND WORD STARTING WITH A PARTICULAR CHARACTER
			function word($word,$arrcom){
				$match = array();
				$chars = str_split($word);
				foreach($chars as $char){
					foreach($arrcom as $com){
						if($com[0] == $char){
							array_push($match,$com);
						}
					}
				}
				return $match;
			}
			//FUNCTION END => FUNCTION TO FIND WORD STARTING WITH A PARTICULAR CHARACTER

			function minimum($arrcom){
				$length1 = array_map('strlen',$arrcom);
				$minword = max($length1);
				return $minword;
			}

			function maximum($horarr,$verarr){
				$max1 = max($horarr);
        $max2 = max($verarr);
        return max($max1,$max2);
			}

			function remove($arrcom,$word){
				unset($arrcom[array_search($word,$arrcom)]);
				$arrcom = array_values($arrcom);
				return $arrcom;
			}

      function index($word,$char,$indexes){
        $index = $indexes[$word];
        $pos = strpos($word, $char);
          if ($index[2] == 0){
            $num1 = $index[0];
            $num2 = $index[1]+$pos;
            $align = 1;
          }
          else{
            $num1 = $index[0]+$pos;
            $num2 = $index[1];
            $align = 0;
            }
        return array($num1,$num2,$align);





        }


			//FUNCTION START => FUNCTION TO GENRATE CROSSWORD
			function genratecrossword($arrcom,$db,$arr,$crosscom,$horarr,$verarr,$indexes){$temparr = updatecount($arr);$horarr = $temparr[0];$verarr = $temparr[1];
				$maxim = maximum($horarr,$verarr);
        $minlen = minimum($arrcom);$i=0;
				while($i < 30){
					if(sizeof($crosscom) == 0){$lastwords = array();
						$word  = $arrcom[array_rand($arrcom,1)];
						$align = random1gen();
						$num = random2gen();
						$num1 = $num[0];
						$num2 = $num[1];
						if($align==0){
							while($num2+strlen($word) >= 9){
								$num = random2gen();
								$num1 = $num[0];
								$num2 = $num[1];
							}
						}
						else{
							while($num1+strlen($word) >= 9){
								$num = random2gen();
								$num1 = $num[0];
								$num2 = $num[1];
							}
						}
						$arr = fillup($word,$align,$arr,$num1,$num2,$crosscom);
            $indexes = updateindexes($indexes,$word,$num1,$num2,$align);
						$arrcom = remove($arrcom,$word);
            array_push($crosscom,$word);
            $temp = updatecount($arr);
            $horarr = $temp[1];
            $verarr = $temp[0];
					}
					else{
            $words = word($crosscom[sizeof($crosscom)-1],$arrcom);
            if(sizeof($words)!=0 and $words!=$lastwords){$lastwords = $words;
              foreach($words as $word){
                  $num = index($crosscom[sizeof($crosscom)-1],$word[0],$indexes);
                  $num1 = $num[0];
                  $num2 = $num[1];
                  $align = $num[2];
                  if($num2+strlen($word) >= 9 or $num1+strlen($word) >= 9){
                    continue;
                    }
                  else{
                    if(checkspace1($arr,$word,$num1,$num2,$align)){
                      $arr = fillup($word,$align,$arr,$num1,$num2,$crosscom);
                      $indexes = updateindexes($indexes,$word,$num1,$num2,$align);
                      $arrcom = remove($arrcom,$word);
                      array_push($crosscom,$word);
                      $temp = updatecount($arr);
                      $horarr = $temp[1];
                      $verarr = $temp[0];
                      }
                    }
              }
            }
            if(sizeof($arrcom)!=0){
              $word  = $arrcom[array_rand($arrcom,1)];
              $wordlength = strlen($word);
              $align = random1gen();
              $num = random2gen();
              $num1 = $num[0];
              $num2 = $num[1];
              if($align==0){
                while($num2+$wordlength >= 9){
                  $num = random2gen();
                  $num1 = $num[0];
                  $num2 = $num[1];
                }
              }
              else{
                while($num1+$wordlength >= 9){
                $num = random2gen();
                $num1 = $num[0];
                $num2 = $num[1];
                }
              }
               if(checkspace($arr,$word,$num1,$num2,$align)){
                 $arr = fillup($word,$align,$arr,$num1,$num2,$crosscom);
                 $indexes = updateindexes($indexes,$word,$num1,$num2,$align);
                 $arrcom = remove($arrcom,$word);
                 array_push($crosscom,$word);
                 $temp = updatecount($arr);
                 $horarr = $temp[1];
                 $verarr = $temp[0];
                 }
            }
          }$maxim = maximum($horarr,$verarr);
          $minlen = minimum($arrcom);$i++;
        }return $arr;
      }




        $arr = genratecrossword($arrcom,$db,$arr,$crosscom,$horarr,$verarr,$indexes);
        printarray($arr);
        echo "<br";
        function printarray($arr){
            for($i=0;$i<9;$i++){
              for($j=0;$j<9;$j++){
                echo $arr[$i][$j];
                echo "     ";
                }
                echo "<br>";
              }
          }
      //  print_r($arr);
			//CLOSE DATABASE CONNECTION
			pg_close($db);*/


		?>
</body>
</html>
