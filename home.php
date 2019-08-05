<form method="post" action = "test.php">
<br>
    <center><input type="submit" name="test" id="test" value="GENRATECROSSWORD" width="20" height="20" onclick = "alert('PLEASE START PLAYING')"/></center>
</form>
<?php include("genrate.php");

if(array_key_exists('test',$_POST)){session_start();
  $temparr = genratecrossword($arrcom,$db,$arr,$crosscom,$horarr,$verarr,$indexes);

  $arr1 = $temparr[0];
  $crosscom = $temparr[1];
  $indexes = $temparr[2];
  $_SESSION['arr'] = $arr1;
}
