<?php
  $myText = $_POST['myText'];
  $myHistory = $_POST['myHistory'];

  $myWrite = fopen("history.txt", "w") or die("Unable to open Write file!");

//$myHistory = str_replace("<br />", "\r\n", $myHistory);

  fwrite($myWrite, gethostbyaddr($_SERVER['REMOTE_ADDR']).": ".$myText."\r\n".$myHistory);
  fclose($myWrite);
?>