<?php
  include("jalali.php");
  
  $myText = $_POST['myText'];
  $myHistory = $_POST['myHistory'];

  $myWrite = fopen("history.txt", "w") or die("Unable to open Write file!");

//$myHistory = str_replace("<br />", "\r\n", $myHistory);

  $myDate = gregorian_to_jalali (date("Y"), date("m"), date("d"), "Y/m/d") . " " . date("H:i");

  fwrite($myWrite, gethostbyaddr($_SERVER['REMOTE_ADDR']). " (" . $myDate . "): ".$myText."\r\n".$myHistory);
  fclose($myWrite);
?>