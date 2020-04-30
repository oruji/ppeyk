<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="jquery.js"></script>
<script>
$(document).on("click", "#mySend", function() {
  var myText = $("#myText").val();
  var myHistory = $("#myHistory").text();
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
  myLoad();
  
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
    $.ajax({
      type: 'POST',
      url: 'load.php', 
      scriptCharset: "utf-8" ,
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      success: function(msg) {
        $("#myHistory").html(msg);
      }
    });   
}

window.setInterval(function(){
  myLoad();
}, 1000);

</script>

<input type="text" id="myText" autofocus />
<button id="mySend">Send</button>
<pre id="myHistory"></pre>