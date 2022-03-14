<?php
/*require_once("admincheck.php");
if(isset($_GET['sidebar'])){
    include('s_header.php');
} else {
    include('header.php');
}*/
include('header.php');
?>
<?php
// INCLUDES
require_once("./class/gestio_projectesBBDD.php");
require_once("./class/usuari.php");
require_once("./class/distribuciofrecuencies.php");
require_once("./scripts/jvscriptevents.php");
require_once("./class/components.php");
require_once("./class/projectes.php");
require_once("./class/botones.php");
require_once("./class/valoresreferencia.php");

//require_once("./class/projecte.php");
gestio_projectesBBDD::setup();

if(isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}	
//$aux=projectes::getprojecteactual();
//$projecte=$aux['nomproject'];
$projecte=$projh;
$falta="1";
$vdatossaving=valoresreferencia::getenergycost($projh);

//Boton validar, entrar datos
if(isset($_POST['addbtn'])){
//inserta los valores en la BBDD
if(isset($_POST['cost1'])){$cost1=$_POST['cost1'];}else{$cost1="";}
if(isset($_POST['cost0'])){$cost0=$_POST['cost0'];}else{$cost0="";}
if(isset($_POST['cost2'])){$cost2=$_POST['cost2'];}else{$cost2="";}
if(isset($_POST['cost3'])){$cost3=$_POST['cost3'];}else{$cost3="";}
if(isset($_POST['cost4'])){$cost4=$_POST['cost4'];}else{$cost4="";}
//if($sendpower1=="" || $sendelection1=="" || $sendtemperature1=="" || $sendoperation1=="" || $sendpower2=="" || $sendtemperature2=="" || $sendoperation2=="" || $sendelection2=="")

if($cost0=="" || $cost1=="" || $cost2=="" || $cost3=="" || $cost4=="")
{$falta="0";}

//if(!$_SESSION['sistema'])
//	{
//	$sendsistema="Generic";
//	}
//else
//	{
//	if($_SESSION['sistema']==""){$sendsistema="Generic";}
//	else{$sendsistema=$_SESSION['sistema'];}
//	}
//echo "$projecte,$sendelection1,$sendpower1,$sendtemperature1,$sendoperation1,$sendelection2,$sendpower2,$sendtemperature2,$sendoperation2";
//comprobar que haya datos 
if ($falta=="1"){
//$aux=components::addauxiliaryenergysource($projecte,$sendelection1,$sendpower1,$sendtemperature1,$sendoperation1,$sendelection2,$sendpower2,$sendtemperature2,$sendoperation2);


$vdatossaving=$vdatossaving::addenergycost($projecte,$cost0,$cost1,$cost2,$cost3,$cost4);
//header("location:gestio_dades_solar.php?t=Components Details&projh=$projh",false,301);
//exit();
print "<meta http-equiv=Refresh content=\"2 ; url=gestio_dades_solar.php?t=Components Details&projh=$projh\">";
//$aux=components::addauxiliaryenergysource($sendelection2,$sendpower2,$sendtemperature2,$sendoperation2);
}
else {//Mensaje de falta por script
?>
	<script type="text/javascript">
	alert('Empty Values!');
	</script>
<?php
	}
}

?>



<ul class="breadcrumbs first">
    <li><a href="#">Economic Data</a></li>
    <li class="active"><a href="#">Energy Costs</a></li>
</ul>


<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Data Management </h2>
    </div>
    <div class="widget_body">

	<form name="validacio" method="POST" action="savings.php?t=Economic Data&projh=<?php echo $projh;?>" id="validacio">
        
	

	<table>
	<tr><th style="width:80px;" ><div align="center">ENERGY COST</div></th><th style="width:80px;"><div align="center">Current cost &#8364/kwh</div></th><th style="width:80px;"><div align="center">Annual Increase</div></th>
	</tr>
	<tr><td style="width:80px;" ><div align="center">Natural Gas</div></td><td style="width:80px;"><div align="center">0.080</div><input type="text" name="cost2" id="cost2" style="width:50px;" value="<?php echo $vdatossaving[0]['cost2'];?>"></td><td style="width:80px;"><div align="center">2%</div><input type="text" name="mantenence2" id="maintenence2" style="width:50px;" align="center" value="<?php echo $vdatossaving[2]['per_maintenance'];?>"></td>
	</tr>
	<tr><td style="width:80px;" ><div align="center">Electricity</div></td><td style="width:80px;"><div align="center">0.150</div><input type="text" name="cost1" id="cost1" style="width:50px;" value="<?php echo $vdatossaving[0]['cost1'];?>"></td><td style="width:80px;"><div align="center">2%</div><input type="text" name="mantenence1" id="maintenence1" style="width:50px;" value="<?php echo $vdatossaving[1]['per_maintenance'];?>"></td>
	</tr>
	<tr><td style="width:80px;" ><div align="center">Biomass</div></td><td style="width:80px;"><div align="center">0.050</div><input type="text" name="cost0" id="cost0" style="width:50px;" value="<?php echo $vdatossaving[0]['cost0'];?>"></td><td style="width:80px;"><div align="center">1%</div><input type="text" name="mantenence0" id="maintenence0" style="width:50px;" value="<?php echo $vdatossaving[0]['per_maintenance'];?>"></td>
	</tr>
	<tr><td style="width:80px;" ><div align="center">Heat Waste</div></td><td style="width:80px;"><div align="center">0.050</div><input type="text" name="cost3" id="cost3" style="width:50px;" value="<?php echo $vdatossaving[0]['cost3'];?>"></td><td style="width:80px;"><div align="center">1%</div><input type="text" name="mantenence3" id="maintenence3" style="width:50px;" value="<?php echo $vdatossaving[3]['per_maintenance'];?>"></td>
	</tr>
	<tr><td style="width:80px;" ><div align="center">Geothermal</div></td><td style="width:80px;"><div align="center">0.050</div><input type="text" name="cost4" id="cost4" style="width:50px;" value="<?php echo $vdatossaving[0]['cost4'];?>"></td><td style="width:80px;"><div align="center">1%</div><input type="text" name="mantenence4" id="maintenence4" style="width:50px;" value="<?php echo $vdatossaving[4]['per_maintenance'];?>"></td>
	</tr>
	
	
	</table>

	<br>
	<table>
		<tr></tr>
         <tr>
                <td style="width:750px;"></td><td>
			
			<input type="submit" class="btn blue medium" name="addbtn" id="addbtn" value="   Next   ">
			<input type="hidden" name="projh" id="projh" value="<?php echo $projh; ?>">
                </td>
            </tr>

	</table>


		<!--<input type="hidden" name="nomdistribucioselected" value="0">-->
		
        </form>
		<div id="div_errors" style="display:none">
			<div class="msg failure">
                    <span id="missatge_err"></span>            
			</div>
		</div>
		<div id="div_ok" style="display:none">
			<div class="msg success">
                    <span id="missatge_ok"></span>
			</div>
		</div>
    </div>
</div>


<script type="text/javascript">

</script>

<?php include("footer.php") ?>