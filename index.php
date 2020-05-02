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
.Amin {
  background: #ecfaff;
}

.Fatemeh {
  background: #ffe6f0;
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
      data: { 
        'myText': toLink(myText),
        'myHistory': myHistory
      },
      scriptCharset: "utf-8" ,
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      success: function(msg) {
        myLoad();
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
      if ($owner !== undefined && $matn !== undefined && $matn.trim() !== $("#myHistory").html().trim().split("&lt;").join("<").split("&gt;").join(">")) {
        $("#myHistory").html($matn);
        document.title = $matn.split("</div>")[0].split("</span>")[1];
        if (!$matn.startsWith("<div class=\"" + $owner)) {
          playAudio();          
        }
      }
    }
  });
}

window.setInterval(function(){
  myLoad();
}, 1000);

function toLink(text) {

  return (text || "").replace(
    /([^\S]|^)(((https?\:\/\/)|(www\.))(\S+))/gi,
    function(match, space, url){
      var hyperlink = url;
      if (!hyperlink.match('^https?:\/\/')) {
        hyperlink = 'http://' + hyperlink;
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
<button id="mySend">Send</button>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>
<div id="myHistory"></div>
<?php
if(isset($_POST['submit'])){ //check if form was submitted
  echo "<script>myLoad();</script>";

  $target_dir = "file/";
  $target_name = basename($_FILES["fileToUpload"]["name"]);
  $target_ip = "192.168.1.52";
  
  $counter = 1;
  while (file_exists($target_dir.$target_name)) {
    //$target_name = substr_replace($target_name, $counter, -4, 0);
    $target_name = $counter . $target_name;
    
    $counter++;
  }
  
  // Check if file already exists
//  if (file_exists($target_dir.$target_name)) {
//    $target_name = "new_".$target_name;
    
    //echo "Sorry, file already exists.";
//  }

  $target_url = "http://" . $target_ip . "/" . $target_dir . $target_name;

  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir.$target_name)) {
      echo "The file <a target=_blank $target_url \">". $target_name . "</a> has been uploaded.";
      
      echo "
      <script>
      $(document).ready(function(){
        $(\"#myText\").val(\"$target_url\");
        $(\"#mySend\").click();
  });
      </script>";

  } else {
      echo "Sorry, there was an error uploading your file.";
  }
}
?>
</body>
</html>