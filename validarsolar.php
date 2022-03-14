<?php
// INCLUDES
require_once("./class/gestio_projectesBBDD.php");
require_once("./class/usuari.php");
require_once("./class/distribuciofrecuencies.php");
require_once("./scripts/jvscriptevents.php");
//require_once("./class/projecte.php");
require_once("./class/components.php");
require_once("./class/projectes.php");
require_once("./class/botones.php");
if(isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}
gestio_projectesBBDD::setup();

$aux=projectes::getprojecteactual();
$projecte=$aux['nomproject'];
$projecte=$projh;
$sendlocalitat=$aux['localitat'];

$dadesprojectepanelsolar=components::getpanellsolarprojecte($projecte);
$numdadesprojectepanelsolar=count($dadesprojectepanelsolar)-1;
if($numdadesprojectepanelsolar>0)
	{
	$sendpaneltype=$dadesprojectepanelsolar[0]['nom_panell'];
	$sendinclinacio=$dadesprojectepanelsolar[0]['inclinacio'];
	$sendazimuth=$dadesprojectepanelsolar[0]['azimut'];
	$sendsolarsurface=$dadesprojectepanelsolar[0]['superficie_solar'];
	$sendstp_b=$dadesprojectepanelsolar[0]['stp_b'];
	$sendstp_a1=$dadesprojectepanelsolar[0]['stp_a1'];
	$sendstp_a2=$dadesprojectepanelsolar[0]['stp_a2'];
	$sendtemp_summer=$dadesprojectepanelsolar[0]['temp_summer'];
	$sendtemp_rest=$dadesprojectepanelsolar[0]['temp_rest'];
	$sendtemp_winter=$dadesprojectepanelsolar[0]['temp_winter'];
	$sendefficiency=$dadesprojectepanelsolar[0]['efficiency'];
	}
else {}

$valorsdistribucioanual=distribuciofrecuencies::getdadesdistribucioanualprojecte(1,$sendlocalitat,$projecte);

$numvalorsdistribucioanual=count($valorsdistribucioanual)-1;

if($numvalorsdistribucioanual>0)
for($i=1;$i<=12;$i++)
	{
	$mes[$i]="";
	}
for($i=1;$i<=12;$i++)
	{		$valorsdistribucioanualmes=distribuciofrecuencies::getdadesdistribucioanualmesprojecte(1,$sendlocalitat,$projecte,$i);
		$numvalordistribucioanualmes=count($valorsdistribucioanualmes)-1;
		
		if($numvalordistribucioanualmes>0){
			$mes[$i]=$valorsdistribucioanualmes[1]['valor'];}
		else {$mes[$i]="";}
}

if(isset($_POST['paneltypes'])){$sendpaneltype=$_POST['paneltypes'];}else{$sendpaneltype="";}
if(isset($_POST['inclinacio'])){$sendinclinacio=$_POST['inclinacio'];}else{$sendinclinacio="";}
if(isset($_POST['azimuth'])){$sendazimuth=$_POST['azimuth'];}else{$sendazimuth="";}
if(isset($_POST['superficie'])){$sendsolarsurface=$_POST['superficie'];}else{$sendsolarsurface="";}
if(isset($_POST['stp_b'])){$sendstp_b=$_POST['stp_b'];}else{$sendstp_b="";}
if(isset($_POST['stp_a1'])){$sendstp_a1=$_POST['stp_a1'];}else{$sendstp_a1="";}
if(isset($_POST['stp_a2'])){$sendstp_a2=$_POST['stp_a2'];}else{$sendstp_a2="";}
if(isset($_POST['temp_summer'])){$sendtemp_summer=$_POST['temp_summer'];}else{$sendtemp_summer="";}
if(isset($_POST['temp_rest'])){$sendtemp_rest=$_POST['temp_rest'];}else{$sendtemp_rest="";}
if(isset($_POST['temp_winter'])){$sendtemp_winter=$_POST['temp_winter'];}else{$sendtemp_winter="";}
if(isset($_POST['efficiency'])){$sendefficiency=$_POST['efficiency'];}else{$sendefficiency="";}

if(isset($_POST['gen'])){$sendmes[1]=$_POST['gen'];}else{$sendmes[1]="";}
if(isset($_POST['feb'])){$sendmes[2]=$_POST['feb'];}else{$sendmes[2]="";}
if(isset($_POST['mar'])){$sendmes[3]=$_POST['mar'];}else{$sendmes[3]="";}
if(isset($_POST['apr'])){$sendmes[4]=$_POST['apr'];}else{$sendmes[4]="";}
if(isset($_POST['may'])){$sendmes[5]=$_POST['may'];}else{$sendmes[5]="";}
if(isset($_POST['jun'])){$sendmes[6]=$_POST['jun'];}else{$sendmes[6]="";}
if(isset($_POST['jul'])){$sendmes[7]=$_POST['jul'];}else{$sendmes[7]="";}
if(isset($_POST['aug'])){$sendmes[8]=$_POST['aug'];}else{$sendmes[8]="";}
if(isset($_POST['sep'])){$sendmes[9]=$_POST['sep'];}else{$sendmes[9]="";}
if(isset($_POST['oct'])){$sendmes[10]=$_POST['oct'];}else{$sendmes[10]="";}
if(isset($_POST['nov'])){$sendmes[11]=$_POST['nov'];}else{$sendmes[11]="";}
if(isset($_POST['dec'])){$sendmes[12]=$_POST['dec'];}else{$sendmes[12]="";}


if($sendpaneltype!="" && $sendpaneltype!="0" && $sendinclinacio!="" && $sendazimuth!="" && $sendsolarsurface!="" && $sendstp_b!="" && $sendstp_a1!="" && $sendstp_a2!="" && $sendtemp_summer!="" && $sendtemp_rest!="" && $sendtemp_winter!="" && $sendefficiency!="")
	{ 	$aux=components::addpanelsolar($projecte,$sendpaneltype,$sendinclinacio,$sendazimuth,$sendsolarsurface,$sendstp_b,$sendstp_a1,$sendstp_a2,$sendtemp_summer,$sendtemp_rest,$sendtemp_winter,$sendefficiency);
	//Comparar $sendmes y $mes, si alguno es diferente update de la base de datos de radiación anual y mensual
	$diferente=0;
	for($i=1;$i<=12;$i++)
		{
		if($mes[$i]!=$sendmes[$i])
			{
			$diferente=1;
			//calcular k, factor de multiplicacion
			$k=$sendmes[$i]/$mes[$i];
			//Actualizar data de mes
			$aux=distribuciofrecuencies::actualizarvalormes(1,$sendlocalitat,$projecte,$i,$sendmes[$i]);
			$aux=distribuciofrecuencies::actualizarvalorhorasmes(1,$sendlocalitat,$projecte,$i,$k);
			
			}
		}
	//Hacer que las $mes sean las $sendmes (para que aparezcan en la grid de valores)
	for($i=1;$i<=12;$i++)
		{
		$mes[$i]=$sendmes[$i];
		}
	}



	header("location:gestio_dades_seasonal_storage_system.php?t=COmponents Details&projh=projh");


?>