<html>
<head>
<title>Lan Messenger</title>
<script src="jquery.js"></script>

<style>
*{font-size:15pt}

div {
  padding-top: 5px;
  padding-bottom: 5px;
}

#myText {
  margin-bottom: 5px;
  width:70%;
  height: 30px;
  border-radius: 5px;
}
#mySend {width:18%;max-width:100px;height:30px}
.myUser {font-weight:bold}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<script>
$(document).on("click", "#mySend", function() {
  var myText = $("#myText").val();
  var myHistory = $("#myHistory").html();
  if(myText != "" && myText !== null) {
    $.ajax({
      type: 'POST',
      url: 'chat.php', 
      async: false,
      data: { 
        'myText': toLink(myText),
        'myHistory': myHistory
      },
      scriptCharset: "utf-8" ,
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      success: function(msg) {
        loadSimple();
        $("#myText").val("");
      }
    });
  }
});

$(document).ready(function(){
  $.ajax({
    type: 'POST',
    url: 'load.php', 
    scriptCharset: "utf-8" ,
    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
    success: function(msg) {
      $("#myHistory").html(toLink(msg.split("~^")[1]));
    }
  });  
  
  // press enter send message
  var input = document.getElementById("myText");
  input.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
      event.preventDefault();
      document.getElementById("mySend").click();
    }
  });

$('[id^="emo_"]').each(function() {
    $(this).click(function(){
      $("#myText").val($("#myText").val()+$(this).text());
    });
});

});

function myLoad() {
  var myHistory = $("#myHistory").html();
  $.ajax({
    type: 'POST',
    url: 'load.php', 
    data: { 
      'myHistory': myHistory
    },
    scriptCharset: "utf-8" ,
    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
    success: function(msg) {
      $owner = msg.split("~^")[0];
      $matn = msg.split("~^")[1];
      if ($owner !== undefined && $matn !== undefined) {
        $("#myHistory").html($matn);
        document.title = $matn.split("</div>")[1].split("</span>")[1];
        if (!$matn.startsWith("</div><div class=\"" + $owner)) {
          playAudio();          
        }
      }
    }
  });
}

function loadSimple() {
  $.ajax({
    type: 'POST',
    url: 'load.php',
    async: false,
    scriptCharset: "utf-8" ,
    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
    success: function(msg) {
      $owner = msg.split("~^")[0];
      $matn = msg.split("~^")[1];
      if ($owner !== undefined && $matn !== undefined) {
        $("#myHistory").html($matn);
      }
    }
  });
}

$myChange = "";

window.setInterval(function(){
  
    $.ajax({
    type: 'POST',
    url: 'fileChange.php',
    async: false,
    scriptCharset: "utf-8" ,
    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
    success: function(msg) {
      if ($myChange !== msg) {
        myLoad();
        $myChange = msg;
      }      
    }
  });
}, 1000);

function toLink(text) {

  return (text || "").replace(
    /([^\S]|^)(((https?\:\/\/)|(www\.))(\S+))/gi,
    function(match, space, url){
      var hyperlink = url;
      if (!hyperlink.match('^https?:\/\/')) {
        hyperlink = 'http://' + hyperlink;
      }

      // image support
      if (hyperlink.toLowerCase().endsWith(".png")
        || hyperlink.toLowerCase().endsWith(".jpg")
        || hyperlink.toLowerCase().endsWith(".gif")
        || hyperlink.toLowerCase().endsWith(".svg")) {
          
        var mysrc = '<img style="max-width:96px;vertical-align: middle;" src="'+ hyperlink +'" />';
        
        return space + '<a target="_blank" href="' + hyperlink + '">' + mysrc + '</a>';
      }

      // video support
      if (hyperlink.toLowerCase().endsWith(".mp4")
        || hyperlink.toLowerCase().endsWith(".mkv")
        || hyperlink.toLowerCase().endsWith(".avi")
        || hyperlink.toLowerCase().endsWith(".wmv")
        || hyperlink.toLowerCase().endsWith(".mov")) {
          
        var mysrc = '<a href="' + hyperlink + ".html" + '"><video style="max-width: 300px;vertical-align: middle;max-height: 170px;width: 300px;" controls><source src="' + hyperlink + '" type="video/mp4"></video></a>';
        
        return mysrc;
      }

      // audio support
      if (hyperlink.toLowerCase().endsWith(".m4a")
        || hyperlink.toLowerCase().endsWith(".mp3")
        || hyperlink.toLowerCase().endsWith(".wma")
        || hyperlink.toLowerCase().endsWith(".wav")
        || hyperlink.toLowerCase().endsWith(".wav")
        || hyperlink.toLowerCase().endsWith(".ogg")) {
          
        var mysrc = '<audio style="max-width:300px;vertical-align: middle;" controls><source src="' + hyperlink + '" type="audio/mpeg"></audio><a href="' + hyperlink + ".html" + '">link</a>';
        
        return mysrc;
      }
      
      
      
      return space + '<a target="_blank" href="' + hyperlink + '">' + url + '</a>';
    }
  );
};

</script>
</head>
<body>

<audio id="myAudio">
  <source src="ding.mp3" type="audio/mpeg">
</audio>

<script>
var x = document.getElementById("myAudio"); 

function playAudio() { 
  x.play(); 
} 
</script>

<div>
<span id="emo_">😂</span>
<span id="emo_">😬</span>
<span id="emo_">👍</span>
<span id="emo_">🙏</span>
<span id="emo_">😢</span>
<span id="emo_">😑</span>
<span id="emo_">😮</span>
<span id="emo_">😋</span>
<span id="emo_">😙</span>
<span id="emo_">😴</span>
<span id="emo_">😲</span>
<span id="emo_">👏</span>
<span id="emo_">💋</span>
<span id="emo_">✔</span>
<span id="emo_">🤢</span>
<span id="emo_">😭</span>
<span id="emo_">✋</span>
<span id="emo_">👌</span>
<span id="emo_">👆</span>
<span id="emo_">👇</span>
<span id="emo_">👈</span>
<span id="emo_">👉</span>
<span id="emo_">💪</span>
<span id="emo_">👀</span>
<span id="emo_">🍓</span>
<span id="emo_">🍑</span>
<span id="emo_">🍒</span>
<span id="emo_">🍌</span>
<span id="emo_">🍉</span>
<span id="emo_">🍇</span>
</div>

<input type="text" id="myText" autofocus emoji />
<button id="mySend">Send</button><a href="http://192.168.1.52/file/">file</a>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Send File" name="upload">
</form>
<div id="myHistory"></div>
<?php
if(isset($_POST['upload'])){ //check if form was submitted
  $target_dir = "file/";
  $target_name = basename($_FILES["fileToUpload"]["name"]);
  $target_name = str_replace(" ", "_", $target_name);
  $target_ip = $_SERVER['SERVER_ADDR'];
  
  $counter = 1;
  while (file_exists($target_dir.$target_name)) {
    //$target_name = substr_replace($target_name, $counter, -4, 0);
    $target_name = $counter . $target_name;
    
    $counter++;
  }

  $target_url = "http://" . $target_ip . "/" . $target_dir . $target_name;

  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir.$target_name)) {
      echo "The file <a target=_blank $target_url \">". $target_name . "</a> has been uploaded.";

      // create html page for new tab
      $result = '<script src="/jquery.js"></script>';
      $result = $result . '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
      $result = $result . '<meta name="viewport" content="width=device-width, initial-scale=1" />';
      $myWrite = fopen($target_dir . $target_name . ".html", "w") or die("Unable to open Write file!");
      $result = $result . '<video id="myvid" style="vertical-align: middle;" controls><source src="' . $target_url . '" type="video/mp4"></video>';
      $result = $result . '<script>$("#myvid").css("width", screen.width-20);$("#myvid").css("height", screen.height-130);</script>';
      fwrite($myWrite, $result);
      fclose($myWrite);

      echo "
        <script>
          $(\"#myText\").val(\"$target_url\");
          $(\"#mySend\").click();
          window.location = 'index.php';
        </script>
      ";

  } else {
      echo "Sorry, there was an error uploading your file.";
  }
}
?>
</body>
</html>