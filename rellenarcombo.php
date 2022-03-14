<?php
// INCLUDES
require("./class/gestio_projectesBBDD.php");
require("./class/usuari.php");
gestio_projectesBBDD::setup();


header("location:gestio_dades_solar.php?t=Components");
	
?>