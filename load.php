<?php
$rfile = "history.txt";
	$myRead = fopen($rfile, "r") or die("Unable to open Read file!");

  if (filesize($rfile) !== 0) {
    $html = fread($myRead, filesize($rfile));
    fclose($myRead);

    $html = str_replace("\r", "", $html);
    $html = str_replace("\n", "", $html);
    
    // reverse output
    $myArr = explode("</div>",$html);    
    $myArr = array_reverse($myArr);
    $html = join("</div>",$myArr);

    echo $_SERVER['REMOTE_ADDR'] . "~^" . $html;
  }
?>