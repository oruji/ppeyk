<?php
	$myRead = fopen("history.txt", "r") or die("Unable to open Read file!");
	
	$html = fread($myRead, filesize("history.txt"));
  
	fclose($myRead);
  
  echo $html;
?>