<?php
set_time_limit(2400);
ini_set('memory_limit', '2048M');
// INCLUDES
require("./class/gestio_projectesBBDD.php");
require("./class/usuari.php");
require("./class/localitat.php");
require_once("./class/projectes.php");
require_once("./class/distribuciofrecuencies.php");
gestio_projectesBBDD::setup();
session_start();
//echo "var".$_SESSION['locali'].",".$_POST['locals'].",".$_POST['eleccio'];
$_SESSION['locali']="Sin localizacion";
$aux=projectes::getprojecteactual();
$projecte=$aux['nomproject'];
$sentencia="";
if (isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}

if(isset($_POST['dis1'])){$dis1=$_POST['dis1'];}
if(isset($_POST['dis2'])){$dis2=$_POST['dis2'];}
if(isset($_POST['dis3'])){$dis3=$_POST['dis3'];}
if(isset($_POST['dis8'])){$dis8=$_POST['dis8'];}
/*
?>
<script>
alert ('<?php echo "$projh,$_POST['locals'],$dis1";?>');
</script>
<?php
*/
$aux222=$_POST['airtemp'];
$aux111=$_POST['locals'];
//echo "$aux111,$aux222,$projh,";
if(isset($_POST['locals']))
	{
	
	if($_POST['locals']!="")
		{ 
		$_SESSION['locali']=$_POST['locals'];
		$localitat=$_POST['locals'];
		$aux=localitat::addlocalitatproject($localitat);
		if(isset($_POST['radiation']))
			{
			header("location:gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=1&projh=$projh&locals=$localitat");
			}	
		if(isset($_POST['airtemp']))
			{
			header("location:gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=2&projh=$projh&locals=$localitat");
			}	
		if(isset($_POST['airground']))
			{
			header("location:gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=3&projh=$projh&locals=$localitat");
			}
		if(isset($_POST['irradiation']))
			{
			header("location:gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=8&projh=$projh&locals=$localitat");
			}
		if(isset($_POST['radiationref']))
			{
			header("location:validarlocalizaciones2.php?t=Monthly Data&tipusdis=1&projh=$projh&locals=$localitat&dis=$dis1");
			}	
		if(isset($_POST['airtempref']))
			{
			header("location:validarlocalizaciones2.php?t=Monthly Data&tipusdis=2&projh=$projh&locals=$localitat&dis=$dis2");
			}	
		if(isset($_POST['airgroundref']))
			{
			header("location:validarlocalizaciones2.php?t=Monthly Data&tipusdis=3&projh=$projh&locals=$localitat&dis=$dis3");
			}
		if(isset($_POST['irradiationref']))
			{
			header("location:validarlocalizaciones2.php?t=Monthly Data&tipusdis=8&projh=$projh&locals=$localitat&dis=$dis8");
			}

		if(isset($_POST['btnsubmit']))
			{
			

			
			header("location: choosedemand.php?t=Energy Demand&projh=$projh");
			//header("location: chess-setup-similator.net/chooselocation.php?t=Inici&projh=$proj");
			//<meta http-equiv="refresh" content="0; url=http://www.aredireccionar.com"> 
			/*
			?>
			<script type="text/javascript">
			alert('Debería ir el header!');
			</script>
			<?php
			*/
			}
			if(isset($_POST['btnreset']))
			{
			$aux=localitat::resetlocalitatproject($localitat,$projh);

			
			header("location: chooselocation.php?t=Inici&projh=$projh");
			//header("location: chess-setup-similator.net/chooselocation.php?t=Inici&projh=$proj");
			//<meta http-equiv="refresh" content="0; url=http://www.aredireccionar.com"> 
			/*
			?>
			<script type="text/javascript">
			alert('Debería ir el header!');
			</script>
			<?php
			*/
			}
		}
	else {
		
		header("location:chooselocation.php?t=Location&projh=$projh");
		/*
		?>
		<script type="text/javascript">
		alert('2!');
		</script>
		<?php
		*/
		}
	}
else {
	 
	header("location:chooselocation.php?error");
	/*
	?>
		<script type="text/javascript">
		alert('3!');
		</script>
		<?php
	*/
	}
//echo "var".$localitat.",".$_POST['locals'].",".$sentencia;
?>