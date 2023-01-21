<html>
<head>
</head>
<body>
<p>Howdy - Lets get a JSON list</p>
<script type="text/javascript" src="jquery.min.js">
</script>
<script type="text/javascript">
$(document).ready( function () {
  $.getJSON('getjson.php', function(data) {
      for (var i = 0; i < data.length; i++) {
         document.write(data[i].dkey + " " + data[i].dvalue + "<br>");
      }
    })
  }
);
</script>
</body>
