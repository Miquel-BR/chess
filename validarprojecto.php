<?php
// INCLUDES
require("./class/gestio_projectesBBDD.php");
require("./class/usuari.php");
require("./class/projectes.php");
gestio_projectesBBDD::setup();


if($_POST['project']!="" && $_POST['project']!="0")
	{
	//Entrar project en BBDD
	session_start();
	$IDsession=session_id();
	$_SESSION['projecte']=$_POST['project'];
	$proj=$_POST['project'];
	//insertar en la BBDD
	$latitut=projectes::getlatitut($proj,$_POST['iduser']);
	$longitut=projectes::getlong($proj,$_POST['iduser']);
	$tipousuari=usuari::gettipousuari($_POST['iduser']);
	if($tipousuari==2){
	projectes::eliminaranteriores($_POST['iduser'],$IDsession);
	}
	$aux=projectes::addprojecte($_POST['project'],$_POST['iduser'],$IDsession);
	//$idsesion=projectes::getidsesion($_POST['project']);
	//$_SESSION['idsesion']=$idsesion;
	if($aux==1)
	{header("location:chooselocation.php?t=Choose Location&longitut=$longitut&latitut=$latitut&projh=$proj");
	}
	else {header("location:home.php?t=Choose Project&u=1");}
	}
else
	{
	$_SESSION['projecte']="Choose a project";
	header("location:home.php?t=Choose Project");
	}

?>