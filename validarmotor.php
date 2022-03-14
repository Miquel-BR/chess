<?php
// INCLUDES
require("./class/gestio_projectesBBDD.php");
require("./class/usuari.php");
require("./class/demandas.php");
require("./class/distribuciofrecuencies.php");
require("./class/projectes.php");
require("./class/botones.php");
require("./class/calculs.php");

gestio_projectesBBDD::setup();
if(isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}
$projecte=$projh;
$aux=projectes::getprojecteactualdades($projecte);
//$projecte=$aux['nomproject'];
$localitat=$aux['localitat'];
$demanda=$aux['nomdemanda'];
//echo $projecte.",".$localitat.",".$demanda;
//Para external condition-location
$auxbtn1=botones::checkanualdisloc(1,$localitat,$projecte);
$auxbtn2=botones::checkanualdisloc(2,$localitat,$projecte);
$auxbtn3=botones::checkanualdisloc(3,$localitat,$projecte);
$auxbtn8=botones::checkanualdisloc(8,$localitat,$projecte);
if($auxbtn1[0]['count']<12){$auxcolor1="red";}else{
	$auxcolor1="green";
	for($i=1;$i<=12;$i++)
		{
		$auxbtn11=botones::checkmesdisloc(1,$localitat,$i,$projecte);
		if($auxbtn11[0]['count']<24){$auxcolor1="red";}
		}
	}
if($auxbtn2[0]['count']<12){$auxcolor2="red";}
	else{
		$auxcolor2="green";
		for($i=1;$i<=12;$i++)
			{
			$auxbtn22=botones::checkmesdisloc(2,$localitat,$i,$projecte);
			if($auxbtn22[0]['count']<24){$auxcolor2="red";}
		}
	}
	
if($auxbtn3[0]['count']<12){$auxcolor3="red";}else{
	$auxcolor3="green";
	for($i=1;$i<=12;$i++)
		{
		$auxbtn33=botones::checkmesdisloc(3,$localitat,$i,$projecte);
		if($auxbtn33[0]['count']<24){$auxcolor3="red";}
		}
	}
if($auxbtn8[0]['count']<12){$auxcolor8="red";}else{
	$auxcolor8="green";
	for($i=1;$i<=12;$i++)
		{
		$auxbtn88=botones::checkmesdisloc(8,$localitat,$i,$projecte);
		if($auxbtn88[0]['count']<24){$auxcolor8="red";}
		}
	}
if($auxcolor1=="green" && $auxcolor2=="green" && $auxcolor3=="green" && $auxcolor8=="green")
	{
	//Pasamos a verde1
	$verde1="green";
	}
else{
//Mensaje de alerta, no está completo
$verde1="red";//Elegiremos el mensaje al final
}

//Para energy demand
//Cambiamos $demanda por $localitat para checkear en proyectos anuales de demanda
$auxbtn1=botones::checkanualdisdemand(4,$localitat,$projecte);
$auxbtn2=botones::checkanualdisdemand(5,$localitat,$projecte);
$auxbtn3=botones::checkanualdisdemand(6,$localitat,$projecte);
$auxbtn4=botones::checkanualdisdemand(7,$localitat,$projecte);
//cambiamos la demanda por la localidad 
$demanda2=$localitat;
//echo "<br>".$auxbtn1[0]['count'].",".$auxbtn2[0]['count'].",".$auxbtn3[0]['count'].",".$auxbtn4[0]['count']."<br>";
echo "<br>Wait a moment while we calculate, thanks<br>";
if($auxbtn1[0]['count']<12){$auxcolor21="red";}else{
	$auxcolor21="green";
	for($i=1;$i<=12;$i++)
		{
		$auxbtn11=botones::checkmesdisdemand(4,$demanda,$i,$projecte);
	
		if($auxbtn11[0]['count']<24){$auxcolor21="red";}
		}
	}
if($auxbtn2[0]['count']<12){$auxcolor22="red";}else{
	$auxcolor22="green";
	for($i=1;$i<=12;$i++)
		{
		$auxbtn22=botones::checkmesdisdemand(5,$demanda,$i,$projecte);
		if($auxbtn22[0]['count']<24){$auxcolor22="red";}
		}
	}
if($auxbtn3[0]['count']<12){$auxcolor23="red";}else{
	$auxcolor23="green";
	for($i=1;$i<=12;$i++)
		{
		$auxbtn33=botones::checkmesdisdemand(6,$demanda,$i,$projecte);
		if($auxbtn33[0]['count']<24){$auxcolor23="red";}
		}
	}
if($auxbtn4[0]['count']<12){$auxcolor24="red";}else{
	$auxcolor24="green";
	for($i=1;$i<=12;$i++)
		{
		$auxbtn44=botones::checkmesdisdemand(7,$demanda,$i,$projecte);
		if($auxbtn44[0]['count']<24){$auxcolor24="red";}
		}
	}
//Cambiamos las && por || para permitir solo una demanda
if($auxcolor21=="green" || $auxcolor22=="green" || $auxcolor23=="green" || $auxcolor24=="green")
	{
	$verde2="green";
	}
else{$verde2="red";}

//Para componentes
$auxcolor1=botones::colorbotonsubsistemes(1,$projecte);
$auxcolor2=botones::colorbotonsubsistemes(2,$projecte);
$auxcolor3=botones::colorbotonsubsistemes(3,$projecte);
$auxcolor4=botones::colorbotonsubsistemes(4,$projecte);
$auxcolor5=botones::colorbotonsubsistemes(5,$projecte);
$auxcolor6=botones::colorbotonsubsistemes(6,$projecte);
if($auxcolor1[0]['num']==0){$color1="red";}else{$color1="green";};
if($auxcolor2[0]['num']==0){$color2="red";}else{$color2="green";};
if($auxcolor3[0]['num']==0){$color3="red";}else{$color3="green";};
if($auxcolor4[0]['num']==0){$color4="red";}else{$color4="green";};
if($auxcolor5[0]['num']==0){$color5="red";}else{$color5="green";};
if($auxcolor6[0]['num']==0){$color6="red";}else{$color6="green";};
if($color1=="green" && $color2=="green" && $color3=="green" && $color4=="green" && $color5=="green" && $color6=="green")
	{$verde3="green";}
else {$verde3="red";}

if($verde1=="green" && $verde2=="green" && $verde3=="green")
	{
	echo "<script>alert('All is OK');</script>";
	//header("location:MotorCalculs.php?t=Motor&projecte=$projecte&demanda=$demanda&localitat=$localitat&projh=$projh");
	print "<meta http-equiv=Refresh content=\"2 ; url=MotorCalculs.php?t=Motor&projecte=$projecte&demanda=$demanda&localitat=$localitat&projh=$projh\">";

	}

if($verde1!="green" || $verde2!="green" || $verde3!="green")
	{
	echo "<br>Location part:$verde1 <br> Demand part:$verde2 <br> System Details Part:$verde3<br>";
	echo "<script>alert('You need complete some parts of your system. Check it');</script>";
	}





?>