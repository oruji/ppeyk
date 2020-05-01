<style>
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

#myText {width:70%;    height: 30px;
    border-radius: 5px;}
#mySend {width:18%;max-width:100px;height:30px}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="jquery.js"></script>
<script>
$(document).on("click", "#mySend", function() {
  var myText = $("#myText").val();
  var myHistory = $("#myHistory").html();
  if(myText != "" && myText !== null) {
    $.ajax({
      type: 'POST',
      url: 'chat.php', 
      data: { 
        'myText': myText,
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
      $("#myHistory").html(toLink(msg));
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
      if (msg.trim() !== $("#myHistory").html().trim()) {
        $("#myHistory").html(toLink(msg));
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
      return space + '<a href="' + hyperlink + '">' + url + '</a>';
    }
  );
};

</script>

<input type="text" id="myText" autofocus />
<button id="mySend">Send</button>
<div id="myHistory"></div>