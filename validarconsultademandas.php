<?php
// INCLUDES
require("./class/gestio_projectesBBDD.php");
require("./class/usuari.php");
require("./class/demandas.php");
require("./class/distribuciofrecuencies.php");
gestio_projectesBBDD::setup();
$_SESSION['nomdemand']="";
$_SESSION['iddemand']=0;
//session_start();
if(isset($_POST['demands']) && isset ($_POST['eleccio']))
	{
	if($_POST['demands']!="")
		{ 
		
		$_SESSION['demanda']=$_POST['demands'];
		if($_POST['eleccio']=="1")
			{
			//Seria mejor ir a buscar el nombre en la base de datos
			$aux=distribuciofrecuencies::obtenirnomdistribucio(4);
			$_SESSION['nomdemand']=$aux;
			$_SESSION['iddemand']=4;
			$aux2=$_POST['demands'];
			header("location:gestio_dades_frecuencia_anual_energydemand.php?t=Inici&nomdemand=$aux&iddemand=4&demanda=$aux2");
			}	
		if($_POST['eleccio']=="2")
			{
			
			$aux=distribuciofrecuencies::obtenirnomdistribucio(5);
			$_SESSION['nomdemand']=$aux;
			$_SESSION['iddemand']=5;
			header("location:gestio_dades_frecuencia_anual_energydemand.php?t=Inici&nomdemand='$aux'&iddemand=5&demanda='$aux2'");
			}	
		if($_POST['eleccio']=="3")
			{
			$aux=distribuciofrecuencies::obtenirnomdistribucio(6);
			$_SESSION['nomdemand']=$aux;
			$_SESSION['iddemand']=6;
			header("location:gestio_dades_frecuencia_anual_energydemand.php?t=Inici&nomdemand='$aux'&iddemand=6&demanda='$aux2'");
			}
		if($_POST['eleccio']=="4")
			{
			$aux=distribuciofrecuencies::obtenirnomdistribucio(7);
			$_SESSION['nomdemand']=$aux;
			$_SESSION['iddemand']=7;
			header("location:gestio_dades_frecuencia_anual_energydemand.php?t=Inici&nomdemand='$aux'&iddemand=7&demanda='$aux2'");
			}		
		}
	else {header("location:formularioconsultademanda.php?t=Inici");}
	}
else {
	header("location:formularioconsultademanda.php?error");
	}
echo "var".$_SESSION['demanda'].",".$_POST['demands'].",".$_POST['eleccio'].",".$aux;
?>