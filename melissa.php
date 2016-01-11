<html>
<head>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
$(document).ready(function() {
  $("#convertbutton").click(function(){
		// Testing
		var oldcode = $("#gcode").val();
		var newcode = oldcode.replace(/[zZ]\-[\d\.]*/g,"Z-.002");
		$("#gcode").val(newcode);
		return;
	});
 });

</script>
</head>
<body>

<textarea id='gcode' cols="80" rows="20">Put input G-code here</textarea><br>
<input type='button' value='convert' id="convertbutton"/>
</body>
</html>