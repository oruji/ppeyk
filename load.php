<?php
	$myRead = fopen("history.txt", "r") or die("Unable to open Read file!");
  if (filesize("history.txt") !== 0) {
    $html = fread($myRead, filesize("history.txt"));
    fclose($myRead);
    
    $html = str_replace("\r", "", $html);
    $html = str_replace("\n", "", $html);
    
    echo gethostbyaddr($_SERVER['REMOTE_ADDR']) . "~^" . $html;
  }
?>