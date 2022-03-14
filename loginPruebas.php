<!doctype html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
	
	<link rel="stylesheet" type="text/css" href="style/style.css" />
    <link rel="stylesheet" type="text/css" href="style/fixed.css" title="fixed" media="screen" />
	
	<title>Sistema de control de projectes</title>

        <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <!--[if !IE 7]><style>#wrap {display:table;height:100%}</style><![endif]-->
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>

</head>
<body>
	<script type="text/javascript"> 
    $(document).ready(function(){ 
       $("#boton").click(function(){
          var nombre = $("#nombre").val();
          $("#saludo").html('Hola ' + nombre);
       }); 
	   $("#theDropdown").change (function() {
		var aux = $('select[name=theDropdown]').val();
		$("#texto").val(aux)});
    }); 
 </script>
 
 <script type="text/javascript">

    // obtenemos el array de valores mediante la conversion a json del

    // array de php

    var arrayJS=<?php echo json_encode($arrayPHP);?>;

 

    // Mostramos los valores del array

    for(var i=0;i<arrayJS.length;i++)

    {

        document.write("<br>"+arrayJS[i]);

    }

</script>

<form id="theForm">
<select name="theDropdown" id="theDropdown" >
<option value="biology">Biology</option>
<option value="chemistry">Chemistry</option>
<option value="english">English</option>
</select>

<input type="text" id="nombre" />
       <input type="button" id="boton" value="Mostrar nombre" />
       <div id="saludo"></div>
<input type="text" name="texto" id="texto" value=100>

</form>

<?php
if(isset($_POST['var_php'])){
$var=$_POST['var_php'];
echo "pasado variable:".$var;}
else{
echo "<script language='javascript'>
	var la_cantidad;
	var varinput;
	varinput=document.getElementById('texto').value;
	//la_cantidad=prompt('Introduce la cantidad',varinput);
	
     </script> ";

//Ya tenemos capturada la variable con javascript
 
echo "<form action=$_SERVER[PHP_SELF] method=post name=enviar>
              <input type=hidden name=\"var_php\" id=\"var_php\"></form>";

echo "<script language='javascript'>
              document.enviar.var_php.value=la_cantidad;
              document.enviar.submit();
</script>";
}
?> 
<div name="resultsGoHere" id="resultsGoHere"></div>



<script type="text/javascript">
$(document).ready(function() {
		$("#theDropdown").on("change", function() {
		//$('#theDropdown').change(function(){
		alert($("#texto").val("hola"));
    //$('#theDropdown').change (function(){
    //  var qString = '{sub: ' + $('#theDropdown option:selected').text() + '}';
    //   $.post('auxialiar.php', qString, processResponse);
       // $('#resultsGoHere').html(qString);
    //});

    function processResponse(data) {
        $('#resultsGoHere').html(data);
    }
	
	function mifuncion(dato){
		$('#resultsGoHere').html(dato);
		}
	
});
</script>
 

</body>
</html>

        