<?php
require("./class/gestio_projectesBBDD.php");
require("./class/components.php");

gestio_projectesBBDD::setup();
$tf="";$tc="";$cop="";
if(isset($_POST['pos'])){$pos=$_POST['pos']+1;}
if(isset($_POST['model'])){$model=$_POST['model'];}
if(isset($_POST['tf'])){$tf=$_POST['tf'];}
if(isset($_POST['tc'])){$tc=$_POST['tc'];}
if(isset($_POST['cop'])){$cop=$_POST['cop'];}
//buscar tf,tc,cop
echo "Elementos validar pos: $pos,$model,$tf,$tc,$cop";
if($model!="" && $pos!="")
	{
	
	$array=components::buscarpos($pos,$model);
	$num=count($array)-1;
	if($num>0){																
		$tf=$array['tf'];
		$tc=$array['tc'];
		$cop=$array['COP'];
		}
	header("location:gestio_dades_heat_pump.php?t='component'&pos=$pos&tf=$tf&tc=$tc&cop=$cop");
	}
else
	{
	header("location:gestio_dades_heat_pump.php?t='Component'");
	}

?>