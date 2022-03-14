<?php
// INCLUDES
require("./class/gestio_projectesBBDD.php");
require("./class/usuari.php");
require("./class/localitat.php");
gestio_projectesBBDD::setup();
//echo "var:".$_POST['newloc'].",".$_POST['newpais'].",".$_POST['newlatit'].",".$_POST['newlong'];
if (isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}
if(isset($_POST['newloc']) && isset($_POST['newpais']) && isset($_POST['newlatit']) && isset($_POST['newlong']))
	{
	
//	echo "var:".$_POST['newloc'].",".$_POST['newpais'].",".$_POST['newlatit'].",".$_POST['newlong'];
	if (($_POST['newloc']!="") && ($_POST['newpais']!="") && (is_numeric($_POST['newlatit'])) && (is_numeric($_POST['newlong'])))
		{
		$aux=localitat::addlocalitat($_POST['newloc'],$_POST['newpais'],$_POST['newlatit'],$_POST['newlong']);
		
		}


	}


header("location:chooselocation.php?t=Inici&projh=$projh");
?>