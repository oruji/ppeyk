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
<div id="myHistory"></div>
</body>
</html>