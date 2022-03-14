<?php
function conectar()
{
	@mysqli_connect("localhost", "root", "");
	mysqli_select_db("ajax");
}

function desconectar()
{
	mysqli_close();
}
?>
