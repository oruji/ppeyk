<?php
  include("jalali.php");
  
  $myText = $_POST['myText'];
  $myHistory = $_POST['myHistory'];

  $myWrite = fopen("history.txt", "w") or die("Unable to open Write file!");

  $myDate = gregorian_to_jalali (date("Y"), date("m"), date("d"), "Y/m/d");

$dayName = date("D");

  $myUser = gethostbyaddr($_SERVER['REMOTE_ADDR']);

  $myFinal = "<div class=\"$myUser\" title=\"$dayName - $myDate\"><span class=\"myUser\">" . $myUser . " (" . date("H:i") . "): </span>".$myText."</div>".$myHistory;

  if (strlen($myHistory) < strlen($myFinal)) {
    fwrite($myWrite, $myFinal);
  }
  
  fclose($myWrite);
?>