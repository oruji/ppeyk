<?php
	$myRead = fopen("history.txt", "r") or die("Unable to open Read file!");
  error_log(filesize("history.txt"));
	$html = fread($myRead, filesize("history.txt"));
	fclose($myRead);
  
  $html = str_replace("\r", "", $html);
  $html = str_replace("\n", "", $html);
  echo $html;
?>