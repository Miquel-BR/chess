<?php
require("./class/gestio_projectesBBDD.php");
require("./class/components.php");

gestio_projectesBBDD::setup();


if(isset($_GET['model'])){$modelo=$_GET['model'];}else{$modelo="sin paso get";}

if(isset($_GET['numreg'])){$max=$_GET['numreg'];}
if(isset($_GET['pos'])){
if ($_GET['pos']<=$max){
	$pos=$_GET['pos']+1;}
else {$pos=$_GET['pos'];}
}
//buscar tf,tc,cop
//$tf="";$tc="";$cop="";
//if($model!="" && $pos!="")
//	{
	
//	$array=components::grtcoppos($pos,$model);
//	$num=count($array)-1;
//	if($num>0){																
//		$tf=$array['tf'];
//		$tc=$array['tc'];
//		$cop=$array['COP'];
//		}
//	header("location:gestio_dades_heat_pump.php?t='component'&pos=$pos&tf=$tf&tc=$tc&cop=$cop");
//	}
//else
//	{
//	
//	}


echo "var:".$max.",".$pos.",".$modelo;

//header("location:gestio_dades_heat_pump.php?t='Component'&pos=$pos&model=$modelo");
?>