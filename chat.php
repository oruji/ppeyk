<?php
  include("jalali.php");
  
  $myText = $_POST['myText'];
  $myHistory = $_POST['myHistory'];

  $myWrite = fopen("history.txt", "w") or die("Unable to open Write file!");

  $myDate = gregorian_to_jalali (date("Y"), date("m"), date("d"), "Y/m/d") . " " . date("H:i");

  $myFinal = gethostbyaddr($_SERVER['REMOTE_ADDR']). " (" . $myDate . "): ".$myText."\r\n".$myHistory;

  if (strlen($myHistory) < strlen($myFinal))
    fwrite($myWrite, $myFinal);
  
  fclose($myWrite);
?>