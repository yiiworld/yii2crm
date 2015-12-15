<!doctype html>
<html>
  <head>
    <style>
      * { margin: 0; padding: 0; box-sizing: border-box; }
      body { font: 13px Helvetica, Arial; }
      /*form { background: #000; padding: 3px; position: fixed; bottom: 0; width: 70%; }*/
      /*form input { border: 0; padding: 10px; width: 90%; margin-right: .5%; }*/
      /*form button { width: 9%; background: rgb(130, 224, 255); border: none; padding: 10px; }*/
      #messages { list-style-type: none; margin: 0; padding: 0; }
      #messages li { padding: 5px 10px; }
      #messages li:nth-child(odd) { background: #eee; }
    </style> 
  </head>
  <body>
    <h1>Users Logs</h1>
    <ul id="messages"></ul>
<!--<form action="">
      <input id="m" autocomplete="off" /><button>Send</button>
    </form> -->
  </body>
  <script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
  <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
  <script>
    var socket = io.connect('http://vm12721.hv8.ru:9090');
    // $('form').submit(function(){
    //   socket.emit('message', $('#m').val());
    //   $('#m').val('');
    //   return false;
    // });
    socket.on('message', function(msg){
      $('#messages').append($('<li>').text(msg));
    });
</script>
</html>