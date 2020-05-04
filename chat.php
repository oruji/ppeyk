<?php
  include("jalali.php");
  
  $myText = $_POST['myText'];

  $myDate = gregorian_to_jalali (date("Y"), date("m"), date("d"), "Y/m/d");

  $dayName = date("D");

  $myUser = $_SERVER['REMOTE_ADDR'];

  $myFinal = "<div class=\"$myUser\" title=\"$dayName - $myDate\"><span class=\"myUser\">" . $myUser . " (" . date("H:i") . "): </span>".$myText."</div>";

  $fp = fopen('history.txt', 'a') or die("Unable to open Write file!");
  fwrite($fp, $myFinal);  
  fclose($fp);  
?>

