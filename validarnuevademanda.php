<?php
// INCLUDES
require("./class/gestio_projectesBBDD.php");
require("./class/usuari.php");
require("./class/demandas.php");
gestio_projectesBBDD::setup();
if (isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}
if(isset($_POST['tipology']) && isset($_POST['observation']))
	{
	//echo "var:".$_POST['tipology'].",".$_POST['observation'];
	if($_POST['observation']!="")
		{
		$observation=$_POST['observation'];
		}
	else {$observation="No Observation";}
	if (($_POST['tipology']!="")) // && ($_POST['observation']!=""))
		{
		$aux=demandas::adddemanda($_POST['tipology'],$observation);
		
		}


	}
else {echo "var:No entra";}

header("location:choosedemand.php?t=Inici&projh=$projh");
?>