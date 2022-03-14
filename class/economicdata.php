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

//require_once("./class/projecte.php");
gestio_projectesBBDD::setup();

if(isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}	
if(isset($_GET['invest'])){$invest=$_GET['invest'];}
else{if(isset($_POST['invest'])){$invest=$_POST['invest'];}}
if(isset($_GET['totalinvest'])){$totalinvest=$_GET['totalinvest'];}
else{if(isset($_POST['totalinvest'])){$totalinvest=$_POST['totalinvest'];}}
if(isset($_GET['mantenance'])){$mantenance=$_GET['mantenance'];}
else{if(isset($_POST['mantenance'])){$mantenance=$_POST['mantenance'];}}

if(isset($_GET['ratsolarpanel'])){$ratioSP=$_GET['ratsolarpanel'];}
else{if(isset($_POST['ratsolarpanel'])){$ratioSP=$_POST['ratsolarpanel'];}}
if(isset($_GET['ratheatpump'])){$ratioHP=$_GET['ratheatpump'];}
else{if(isset($_POST['ratheatpump'])){$ratioHP=$_POST['ratheatpump'];}}
if(isset($_GET['ratdistsystem'])){$ratioDS=$_GET['ratdistsystem'];}
else{if(isset($_POST['ratdistsystem'])){$ratioDS=$_POST['ratdistsystem'];}}
if(isset($_GET['ratgasboiler'])){$ratioGB=$_GET['ratgasboiler'];}
else{if(isset($_POST['ratgasboiler'])){$ratioGB=$_POST['ratgasboiler'];}}

if(isset($_GET['ratdirecttank'])){$ratioDTU=$_GET['ratdirecttank'];}
else{if(isset($_POST['ratdirecttank'])){$ratioDTU=$_POST['ratdirecttank'];}}
if(isset($_GET['ratstosystem'])){$ratioSTO=$_GET['ratstosystem'];}
else{if(isset($_POST['ratstosystem'])){$ratioSTO=$_POST['ratstosystem'];}}
//$aux=projectes::getprojecteactual();
//$projecte=$aux['nomproject'];
$projecte=$projh;
$opcion=$_POST['addbtn'];
echo "<br>$projecte,$totalinvest,$invest,$mantenance,$ratioSP,$ratioSTO,$ratioHP,$ratioDTU,$ratioDS,$ratioGB";
if(isset($_POST['addbtn'])){
	//insertar suma final inversión y sumafinal de mantenimiento
	//echo "$projecte,$invest,$mantenance";
    $retorno=projectes::addpressupost($projecte,$invest,$mantenance,$ratioSP,$ratioSTO,$ratioHP,$ratioDTU,$ratioDS,$ratioGB);
	
}
else {//Mensaje de falta por script
?>
	<!--<script type="text/javascript">
	alert('Empty Values!');
	</script>-->

<?php
	}
$arrayEcData = array("solarrat","storagerat","heatpumprat","directusetankrat","distributionrat","gasboilerrat","manteinancerat");
$panellsolar=components::getpanellsolarprojecte($projecte);
$stosystem=components::getdadesseasonalstoragesystem($projecte);
$directusetank=components::getdadesdirectusetank($projecte);
$distributionsys=components::getdadesdistributionsystem($projecte);
$auxiliary=components::getauxiliarysourceproject($projecte);
$heatpump=components::getdadesheatpump($projecte);

$supsolar=$panellsolar[0]['superficie_solar'];
$nomsolar=$panellsolar[0]['nom_panell'];
$volumsto=$stosystem[0]['volumen'];
$nomsto=$stosystem[0]['storage_system'];
$powheatpump=$heatpump[0]['power'];
$voldirtank=$directusetank[0]['volumen'];
$longdist=$distributionsys[0]['long1'];
$longdist=$longdist+$distributionsys[0]['long2'];
$powgasboiler=$auxiliary[0]['power_direct_use_tank'];
$tipusauxiliar=$auxiliary[0]['tipo_source_direct_use_tank'];
$tipusauxiliarsto=$auxiliary[0]['tipo_source_storage_system'];
$powauxsto=$auxiliary[0]['power_storage_system'];
$auxnum=pow($supsolar,-0.0077);
//echo "$ratioSTO";
//Entrada datos Solar Panel
if($ratioSP==""){
	if($nomsolar=="Flat ST panel")
	{

		if($supsolar<=400){$ratioSP=250;}
		else{$ratioSP=397*pow($supsolar,-0.0077);}
	}
	else{
		if($nomsolar=="PVT panel" || $nomsolar=="Vacuum tube panel")
			{
				if($supsolar<=400){$ratioSP=500;}
				else{$ratioSP=397*pow(pow($supsolar,-0.0077),2);}
			}
		else{$ratioSP="";}
	}
}
if($ratioSP!=""){$totalSP=$ratioSP*$supsolar;$ratioSPman=number_format($ratioSP*0.02,2);$totalSPman=round($totalSP*0.02,2);$ratioSP=number_format($ratioSP,2);$totalSP=round($totalSP,2);}
else{$totalSP="";$ratioSPman="";$totalSPman="";}

//Entrada datos storage
IF($ratioSTO=="")
	{
	if($nomsto=="TTES")
	{
		if($volumsto<=2000){$ratioSTO=220;}
		else{
			if($volumsto<=10000){$ratioSTO=3162.8*pow($volumsto,-0.3505);}
			else{$ratioSTO=125;}}
			}

	if($nomsto=="PTES")
		{
		if($volumsto<=2000){$ratioSTO=175;}
		else{if($volumsto<=10000){$ratioSTO=2834.5*pow($volumsto,-0.363);}else{$ratioSTO=100;}}
		}

		if($nomsto=="BTES" || $nomsto=="ATES")
			{
				if($volumsto<=2000){$ratioSTO=128;}
				else{if($volumsto<=10000){$ratioSTO=4800.9*pow($volumsto,-0.477);}else{$ratioSTO=60;}
				}
			}
		if($nomsto!="TTES" && $nomsto!="PTES" && $nomsto!="ATES" && $nomsto!="BTES"){$ratioSTO="";}
	}
//echo "<br>$ratioSTO,$volumsto";
if($ratioSTO!=""){$totalSTO=$ratioSTO*$volumsto;$ratioSTOman=round($ratioSTO*0.02,2);$totalSTOman=round($totalSTO*0.02,2);$totalSTO=round($totalSTO,2);$ratioSTO=number_format($ratioSTO,2);}
else{$totalSTO="";$ratioSTOman="";$totalSTOman="";}
//echo "<br>$ratioSTO,$volumsto,$totalSTO";
if($ratioDTU==""){$ratioDTU=200;}
if($voldirtank!=null)
{$totalDTU=200*$voldirtank;$ratioDTUman=number_format($ratioDTU*0.02,2);$totalDTUman=round($ratioDTUman*$voldirtank,2);$totalDTU=round($totalDTU,2);$ratioDTU=number_format($ratioDTU,2);}
else{$ratioDTU="";$totalDTU="";$ratioDTUman="";$totalDTUman="";}

if($ratioDS==0){$ratioDS=1;}
if($longdist!=null)
{$totalDS=$ratioDS*$longdist;$ratioDSman=number_format($ratioDS*0.02,2);$totalDSman=round($ratioDSman*$longdist,2);$totalDS=round($totalDS,2);$ratioDS=number_format($ratioDS,2);}
else{$ratioDS="";$totalDS="";$ratioDSman="";$totalDSman="";}


//Entrada datos heatpump
if($ratioHP==""){
if($powheatpump!=""){
if($powheatpump<=20){$ratioHP=1000;}
else{$ratioHP=2720.1*pow($powheatpump,-0.334);}
}
else{$ratioHP="";}
}
if($ratioHP!=""){$totalHP=$ratioHP*$powheatpump;$ratioHPman=round($ratioHP*0.02,2);$totalHP=round($totalHP,2);$totalHPman=round($totalHP*0.02,2);$ratioHP=number_format($ratioHP,2);}
else{$totalHP="";$ratioHPman="";$totalHPman="";$totalHPman="";}
/*
if($tipusauxiliar==7)
{$ratioGB=1700;$totalGB=$ratioGB*$powgasboiler;$ratioGBman=number_format($ratioGB*0.02,2);$totalGBman=number_format($totalGB*0.02,2);$totalGB=number_format($totalGB,2);}
else{$ratioGB="";$totalGB="";$ratioGBman="";$totalGBman="";}
*/
if($ratioGB==""){$ratioGB=250;}
if($powgasboiler>0){$PowerAux=$powgasboiler;}else{$PowerAux=0;$ratioGBman=0;}
if($powauxsto>0){
	$PowerTotal=$PowerAux; //+$powauxsto;
	$ratioGBman=number_format($ratioGB*0.02,2);
	}
if($PowerTotal>0){$totalGB=$ratioGB*$PowerTotal;$totalGBman=round($ratioGBman*$PowerTotal,2);}else{$totalGB=0;$totalGBman=0;}
$totalinvest=$totalGB+$totalHP+$totalDS+$totalSTO+$totalDTU+$totalSP;
$totalman=$totalGBman+$totalHPman+$totalDSman+$totalSTOman+$totalDTUman+$totalSPman;

//Boton validar, entrar datos


?>

<div id="popup_window_id_ED1" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">Solar thermal pannels			Hibrid solar pannels		<br>Equation			Equation		<br>S<400 m2	250	&#8364/m2	S<400 m2	500	&#8364/m2<br>S>400 m2	243	&#8364/m2	S>400 m2	485	&#8364/m2<br>S=2000 m2	228	&#8364/m2	</div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>
<div id="popup_window_id_ED2" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">Equation			Equation			Equation		<br>V<2000 m3	220	&#8364/m3	V<2000 m3	175	&#8364/m3	V<2000 m3	128	&#8364/m3<br>V>2000 m3	150	&#8364/m3	V>2000 m3	180	&#8364/m3	V>2000 m3	76	&#8364/m3<br>V>10000m3	125	&#8364/m3	V>10000m3	100	&#8364/m3	V>10000m3	60	&#8364/m3</div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>
<div id="popup_window_id_ED3" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">Equation		<br>P<20 kW	1000	&#8364/kW<br>P>20 kW	463	&#8364/kW</div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>
<div id="popup_window_id_ED4" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">200 &#8364/m3</div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>
<div id="popup_window_id_ED5" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">1 &#8364/m</div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>
<div id="popup_window_id_ED6" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">250 &#8364/kw</div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>


<ul class="breadcrumbs first">
    <li><a href="#">Economic Data</a></li>
    <li class="active"><a href="#">Economic Data</a></li>
</ul>


<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Data Management </h2>
    </div>
    <div class="widget_body">

	<form name="validacio" method="POST" action="economicdata.php?t=Economic Data&projh=<?php echo $projh;?>" id="validacio">
        
	

	<table>
	<tr><td style="width:190px;" ><div align="center">INVESTMENT</div></td><td style="width:180px;"><div align="center">O.M.</div></td>
	</tr>
	
	</table>
	<table>
	<tr><td style="width:60px;"></td><td style="width:60px;"><label align="center">Ratio</label></td><td style="width:20px;"></td><td style="width:60px;"><label>Total Amount</label></td><td style="width:20px;"></td><td style="width:60px;"><label align="center">Ratio</label></td><td style="width:30x;"></td><td style="width:60px;"><label>Total Amount</label></td><td style="width:30px;"></td>
	</tr>
	<tr><td style="width:60px;"><label>Solar Panel</label></td><td style="width:60px;"><input type="text" name="ratsolarpanel" id="ratsolarpanel" style="width:60px;" value="<?php echo $ratioSP;?>" > <input type=image src="images/info.png" width="20" height="20"  onclick="popup_window_show('#popup_window_id_ED1', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;"></td><td style="width:30px;"><div >&#8364/m2</div></td><td style="width:60px;"><div name="solidtotal" id="solidtotal" style="width:60px;" ><?php echo round($totalSP,0);?></div></td><td style="width:20px;border-right:2px solid black;" >&#8364 </td><td style="width:60px;"><input type="text" name="ratsolarpanelman" id="ratsolarpanelman" style="width:60px;" value="<?php echo $ratioSPman;?>"></td><td style="width:30px;"><label>&#8364/m2/year</label></td><td style="width:60px;"><div name="solidtotalman" id="solidtotalman" style="width:60px;"><?php echo $totalSPman;?></div></td><td style="width:30px;"><label>&#8364/year</label></td>
	</tr>
	<tr><td style="width:60px;"><label>Storage System</label></td><td style="width:60px;"><input type="text" name="ratstosystem" id="ratstosystem" style="width:60px;" value="<?php echo $ratioSTO;?>"> <input type=image src="images/info.png" width="20" height="20"  onclick="popup_window_show('#popup_window_id_ED2', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;"></td><td style="width:30px;"><div >&#8364/m3</div></td><td style="width:60px;"><div name="ratstosystemtot" id="ratstosystemtot" style="width:60px;" ><?php echo $totalSTO;?></div></td><td style="width:20px;border-right:2px solid black;">&#8364 </td><td style="width:60px;"><input type="text" name="ratstosystemman" id="ratstosystemman" style="width:60px;" value="<?php echo $ratioSTOman;?>"></td><td style="width:30px;"><label>&#8364/m3/year</label></td><td style="width:60px;"><div name="ratstosystemtotman" id="ratstosystemtotman" style="width:60px;" ><?php echo $totalSTOman;?></div></td><td style="width:30px;"><label>&#8364/year</label></td>
	</tr>

	<tr><td style="width:60px;"><label>Heat Pump</label></td><td style="width:60px;"><input type="text" name="ratheatpump" id="ratheatpump" style="width:60px;" value="<?php echo $ratioHP;?>"> <input type=image src="images/info.png" width="20" height="20"  onclick="popup_window_show('#popup_window_id_ED3', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;"></td><td style="width:30x;"><div >&#8364/Kw</div></td><td style="width:60px;"><div name="ratheatpumptot" id="ratheatpumptot" style="width:60px;" ><?php echo $totalHP;?></div></td><td style="width:20px;border-right:2px solid black;">&#8364 </td><td style="width:60px;"><input type="text" name="ratheatpumpman" id="ratheatpumpman" style="width:60px;" value="<?php echo $ratioHPman;?>"></td><td style="width:30px;"><label>&#8364/Kw/year</label></td><td style="width:60px;"><div name="ratheatpumptotman" id="ratheatpumptotman" style="width:60px;" ><?php echo round($totalHPman,2);?></div></td><td style="width:30px;"><label>&#8364/year</label></td>
	</tr>

	<tr><td style="width:60px;"><label>Direct Use Tank</label></td><td style="width:60px;"><input type="text" name="ratdirecttank" id="ratdirecttank" style="width:60px;" value="<?php echo $ratioDTU;?>"> <input type=image src="images/info.png" width="20" height="20"  onclick="popup_window_show('#popup_window_id_ED4', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;"></td><td style="width:30px;"><div >&#8364/m3</div></td><td style="width:60px;"><div name="ratdirecttanktot" id="ratdirecttanktot" style="width:60px;"><?php echo $totalDTU;?></div></td><td style="width:20px;border-right:2px solid black;">&#8364 </td><td style="width:60px;"><input type="text" name="ratdirecttankman" id="ratdirecttankman" style="width:60px;" value="<?php echo $ratioDTUman;?>"></td><td style="width:30px;"><label>&#8364/m3/year</label></td><td style="width:60px;"><div name="ratdirecttanktotman" id="ratdirecttanktotman" style="width:60px;" ><?php echo $totalDTUman;?></div></td><td style="width:30px;"><label>&#8364/year</label></td>
	</tr>

	<tr><td style="width:60px;"><label>Distribution System</label></td><td style="width:60px;"><input type="text" name="ratdistsystem" id="ratdistsystem" style="width:60px;" value="<?php echo $ratioDS;?>"> <input type=image src="images/info.png" width="20" height="20"  onclick="popup_window_show('#popup_window_id_ED5', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;"></td><td style="width:30px;"><div >&#8364/m</div></td><td style="width:60px;"><div name="ratdistsystemtot" id="ratdistsystemtot" style="width:60px;" ><?php echo $totalDS;?></div></td><td style="width:20px;border-right:2px solid black;">&#8364 </td><td style="width:60px;"><input type="text" name="ratdistsystemman" id="ratdistsystemman" style="width:60px;" value="<?php echo $ratioDSman;?>"></td><td style="width:30px;"><label>&#8364/m/year</label></td><td style="width:60px;"><div name="ratdistsystemtotman" id="ratdistsystemtotman" style="width:60px;"><?php echo $totalDSman;?></div></td><td style="width:30px;" ><label>&#8364/year</label></td>
	</tr>

	<tr><td style="width:60px;"><label>Power Auxiliar</label></td><td style="width:60px;"><input type="text" name="ratgasboiler" id="ratgasboiler" style="width:60px;" value="<?php echo $ratioGB;?>"> <input type=image src="images/info.png" width="20" height="20"  onclick="popup_window_show('#popup_window_id_ED6', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;"></td><td style="width:30px;"><div >&#8364/kw</div></td><td style="width:60px;"><div name="ratgasboilertot" id="ratgasboilertot" style="width:60px;"><?php echo $totalGB;?></div></td><td style="width:20px;border-right:2px solid black;">&#8364 </td><td style="width:60px;"><input type="text" name="ratgasboilerman" id="ratgasboilerman" style="width:60px;" value="<?php echo $ratioGBman;?>"></td><td style="width:30px;"><label>&#8364/kw/year</label></td><td style="width:60px;"><div name="ratgasboilertotman" id="ratgasboilertotman" style="width:60px;"><?php echo $totalGBman;?></div></td><td style="width:30px;" <label>&#8364/year</label></td>
	</tr>
	<tr><td style="width:60px;"></td><td style="width:60px;"></td><td style="width:30px;"></td><td style="width:60px;"><div name="invest" id="invest" style="width:60px;"><?php echo $totalinvest;?></div></td><td style="width:20px;border-right:2px solid black;">&#8364 </td><td style="width:60px;"></td><td style="width:30px;"></td><td style="width:60px;"><div name="mantenance" id="mantenance" style="width:60px;"><?php echo $totalman;?></div></td><td style="width:30px;" <label>&#8364/year</label></td>
	</tr>

	<!--	<tr><td style="width:60px;"><label>Reference System</label></td><td style="width:60px;"></td><td style="width:30px;"><div ></div></td><td style="width:60px;"><div name="refsystemtotal" id="refsystemtotal" style="width:60px;"></div></td><td style="width:20px;border-right:2px solid black;">&#8364 </td><td style="width:60px;"></td><td style="width:30px;"><label></label></td><td style="width:60px;"><div name="refsystemtotman" id="refsystemtotlman" style="width:60px;"></div></td><td style="width:30px;"><label>&#8364/year</label></td>
	</tr>-->

	<!--<tr><td style="width:100px;"><label>Storage System</label></td><td style="width:50px;"><input type="text" name="ratstosystem" id="ratstosystem" style="width:70px;" value=""></td><td style="width:30px;"><label>&#8364/m2</label></td><td><label></label></td><td style="width:100px;"><input type="text" name="ratstosystemman" id="ratstosystemman" style="width:150px;" value=""></td><td style="width:100px;"><label>&#8364/m2/year</label></td><td></td><td style="width:100px;"><label></label></td><td><label>&#8364/m2/year</label></td>
	</tr>
	<tr><td style="width:100px;"><label>Heat Pump</label></td><td style="width:50px;"><input type="text" name="ratheatpump" id="ratheatpump" style="width:70px;" value=""></td><td style="width:30px;"><label>&#8364/m2</label></td><td><label></label></td><td style="width:100px;"><input type="text" name="ratheatpumpman" id="ratheatpumpman" style="width:150px;" value=""></td><td style="width:100px;"><label>&#8364/m2/year</label></td><td></td><td style="width:100px;"><label></label></td><td><label>&#8364/m2/year</label></td>
	</tr>
	<tr><td style="width:100px;"><label>Direct Use Tank</label></td><td style="width:50px;"><input type="text" name="ratdirecttank" id="ratdirecttan" style="width:70px;" value=""></td><td style="width:30px;"><label>&#8364/m2</label></td><td><label></label></td><td style="width:100px;"><input type="text" name="ratdirecttanman" id="ratdirecttanman" style="width:150px;" value=""></td><td style="width:100px;"><label>&#8364/m2/year</label></td><td></td><td style="width:100px;"><label></label></td><td><label>&#8364/m2/year</label></td>
	</tr>
	<tr><td style="width:100px;"><label>Distribution System</label></td><td style="width:50px;"><input type="text" name="ratdistrsystem" id="ratdistrsystem" style="width:70px;" value=""></td><td style="width:30px;"><label>&#8364/m2</label></td><td><label></label></td><td style="width:100px;"><input type="text" name="ratdistrsystemman" id="ratdistrsystemman" style="width:150px;" value=""></td><td style="width:100px;"><label>&#8364/m2/year</label></td><td></td><td style="width:100px;"><label></label></td><td><label>&#8364/m2/year</label></td>
	</tr>
	<tr><td style="width:100px;"><label>Gas Boiler</label></td><td style="width:50px;"><input type="text" name="ratgasboiler" id="ratgasboiler" style="width:70px;" value=""></td><td style="width:30px;"><label>&#8364/m2</label></td><td><label></label></td><td style="width:100px;"><input type="text" name="ratgasboilerman" id="ratgasboilerman" style="width:150px;" value=""></td><td style="width:100px;"><label>&#8364/m2/year</label></td><td></td><td style="width:100px;"><label></label></td><td><label>&#8364/m2/year</label></td>
	</tr>
	<tr><td style="width:100px;"><label>Reference System</label></td><td style="width:50px;"></td><td style="width:100px;"><label>&#8364/m2</label></td><td><label></label></td><td style="width:100px;"></td><td style="width:30px;"><label>&#8364/m2/year</label></td><td></td><td style="width:100px;"><label></label></td><td><label>&#8364/m2/year</label></td>
	</tr>-->

	</table>
	<br>
	<table>
		<tr></tr>
         <tr>
                <td style="width:750px;"></td><td>
			
			<input type="submit" class="btn blue medium" name="addbtn" id="addbtn" value="   Save Values   " style="width:100px">
			<input type="hidden" name="projh" id="projh" value="<?php echo $projh; ?>">
			<input type="hidden" name="invest" id="invest" value="<?php echo $totalinvest; ?>">
			<input type="hidden" name="mantenance" id="mantenance" value="<?php echo $totalman; ?>">
			
			<input type="hidden" name="SPrat" id="SPrat" value="<?php echo $ratioSP; ?>">
			<input type="hidden" name="HPrat" id="HTrat" value="<?php echo $ratioHP; ?>">
			<input type="hidden" name="distrat" id="distrat" value="<?php echo $ratioDS; ?>">
			<input type="hidden" name="auxrat" id="auxrat" value="<?php echo $ratioGB; ?>">
			<input type="hidden" name="DTUrat" id="DTUrat" value="<?php echo $ratioDTU; ?>">
			<input type="hidden" name="STOrat" id="STOrat" value="<?php echo $ratioSTO; ?>">
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
<!--<script>
function vaciar1(){

	//$(":text").each(function(){	
	//		$($(this)).val('');
	//});
    var vacio="";
	$("#power1").val('');
	$("#power2").val('');
	$("#power3").val('');
	$("#power4").val('');
	$("#power5").val('');
	$("#temperature1").val('');$("#temperature2").val('');$("#temperature3").val('');$("#temperature4").val('');$("#temperature5").val('');
	$("#operation1").val('');$("#operation2").val('');$("#operation3").val('');$("#operation4").val('');$("#operation5").val('');
	
	}
function vaciar2(){
$("#power6").val('');$("#power7").val('');$("#power8").val('');
$("#temperature6").val('');$("#temperature7").val('');$("#temperature8").val('');
$("#operation6").val('');$("#operation7").val('');$("#operation8").val('');
}	

            
</script>-->

<script type="text/javascript">
	$(document).ready(function(){
	$("#ratsolarpanel").change(function () {
    var jaux = $("#ratsolarpanel").val();
	jauxnum=parseInt(jaux);
	var jsup=<?php echo $supsolar; ?>;
	jsupnum=parseInt(jsup);
	var jmul=parseInt(jauxnum*jsupnum);
	var jmul2=parseInt(jauxnum*0.02);
	var jmul3=parseInt(jmul2*jsupnum);
	
	$("#solidtotal").html(jmul);
	$("#ratsolarpanelman").val(jmul2);
	$("#solidtotalman").html(jmul3);
	var jsum1=$("#solidtotal").html();jsum1=parseFloat(jsum1);
	var jsum2=$("#ratstosystemtot").html();jsum2=parseFloat(jsum2);
	var jsum3=$("#ratheatpumptot").html();jsum3=parseFloat(jsum3);
	var jsum4=$("#ratdirecttanktot").html();jsum4=parseFloat(jsum4);
	var jsum5=$("#ratdistsystemtot").html();jsum5=parseFloat(jsum5);
	var jsum6=$("#ratgasboilertot").html();jsum6=parseFloat(jsum6);
	var sum=parseFloat(jsum1+jsum2+jsum3+jsum4+jsum5+jsum6);
	//var sum=parseInt(jsum1);
	$("#invest").html(sum);
	var jsum1=$("#solidtotalman").html();jsum1=parseFloat(jsum1);
	var jsum2=$("#ratstosystemtotman").html();jsum2=parseFloat(jsum2);
	var jsum3=$("#ratheatpumptotman").html();jsum3=parseFloat(jsum3);
	var jsum4=$("#ratdirecttanktotman").html();jsum4=parseFloat(jsum4);
	var jsum5=$("#ratdistsystemtotman").html();jsum5=parseFloat(jsum5);
	var jsum6=$("#ratgasboilertotman").html();jsum6=parseFloat(jsum6);
	var sum=parseFloat(jsum1+jsum2+jsum3+jsum4+jsum5+jsum6);
	//var sum=parseInt(jsum1);
	$("#mantenance").html(sum);
	});
	
	
	
	$("#ratstosystem").change (function () {
    var jaux = $("#ratstosystem").val();
	jauxnum=parseInt(jaux);
	var jsup=<?php echo $volumsto; ?>;
	jsupnum=parseInt(jsup);
	var jmul=parseInt(jauxnum*jsupnum);
	var jmul2=parseInt(jauxnum*0.02);
	var jmul3=parseInt(jmul2*jsupnum);

	$("#ratstosystemtot").html(jmul);
	$("#ratstosystemman").val(jmul2);
	$("#ratstosystemtotman").html(jmul3);
	var jsum1=$("#solidtotal").html();jsum1=parseFloat(jsum1);
	var jsum2=$("#ratstosystemtot").html();jsum2=parseFloat(jsum2);
	var jsum3=$("#ratheatpumptot").html();jsum3=parseFloat(jsum3);
	var jsum4=$("#ratdirecttanktot").html();jsum4=parseFloat(jsum4);
	var jsum5=$("#ratdistsystemtot").html();jsum5=parseFloat(jsum5);
	var jsum6=$("#ratgasboilertot").html();jsum6=parseFloat(jsum6);
	var sum=parseFloat(jsum1+jsum2+jsum3+jsum4+jsum5+jsum6);
	//var sum=parseInt(jsum1);
	$("#invest").html(sum);
	var jsum1=$("#solidtotalman").html();jsum1=parseFloat(jsum1);
	var jsum2=$("#ratstosystemtotman").html();jsum2=parseFloat(jsum2);
	var jsum3=$("#ratheatpumptotman").html();jsum3=parseFloat(jsum3);
	var jsum4=$("#ratdirecttanktotman").html();jsum4=parseFloat(jsum4);
	var jsum5=$("#ratdistsystemtotman").html();jsum5=parseFloat(jsum5);
	var jsum6=$("#ratgasboilertotman").html();jsum6=parseFloat(jsum6);
	var sum=parseFloat(jsum1+jsum2+jsum3+jsum4+jsum5+jsum6);
	//var sum=parseInt(jsum1);
	$("#mantenance").html(sum);
	});
	
	$("#ratheatpump").change (function () {
    var jaux = $("#ratheatpump").val();
	jauxnum=parseInt(jaux);
	var jsup=<?php echo $powheatpump; ?>;
	jsupnum=parseInt(jsup);
	var jmul=parseInt(jauxnum*jsupnum);
	var jmul2=parseInt(jauxnum*0.02);
	var jmul3=parseInt(jmul2*jsupnum);
	$("#ratheatpumptot").html(jmul);
	$("#ratheatpumpman").val(jmul2);
	$("#ratheatpumptotman").html(jmul3);
	var jsum1=$("#solidtotal").html();jsum1=parseFloat(jsum1);
	var jsum2=$("#ratstosystemtot").html();jsum2=parseFloat(jsum2);
	var jsum3=$("#ratheatpumptot").html();jsum3=parseFloat(jsum3);
	var jsum4=$("#ratdirecttanktot").html();jsum4=parseFloat(jsum4);
	var jsum5=$("#ratdistsystemtot").html();jsum5=parseFloat(jsum5);
	var jsum6=$("#ratgasboilertot").html();jsum6=parseFloat(jsum6);
	var sum=parseFloat(jsum1+jsum2+jsum3+jsum4+jsum5+jsum6);
	//var sum=parseInt(jsum1);
	$("#invest").html(sum);
	var jsum1=$("#solidtotalman").html();jsum1=parseFloat(jsum1);
	var jsum2=$("#ratstosystemtotman").html();jsum2=parseFloat(jsum2);
	var jsum3=$("#ratheatpumptotman").html();jsum3=parseFloat(jsum3);
	var jsum4=$("#ratdirecttanktotman").html();jsum4=parseFloat(jsum4);
	var jsum5=$("#ratdistsystemtotman").html();jsum5=parseFloat(jsum5);
	var jsum6=$("#ratgasboilertotman").html();jsum6=parseFloat(jsum6);
	var sum=parseFloat(jsum1+jsum2+jsum3+jsum4+jsum5+jsum6);
	//var sum=parseInt(jsum1);
	$("#mantenance").html(sum);
	});
	
	$("#ratdirecttank").change (function () {
    var jaux = $("#ratdirecttank").val();
	jauxnum=parseInt(jaux);
	var jsup=<?php echo $voldirtank; ?>;
	jsupnum=parseInt(jsup);
	var jmul=parseInt(jauxnum*jsupnum);
	var jmul2=parseInt(jauxnum*0.02);
	var jmul3=parseInt(jmul2*jsupnum);
	$("#ratdirecttanktot").html(jmul);
	$("#ratdirecttankman").val(jmul2);
	$("#ratdirecttanktotman").html(jmul3);
var jsum1=$("#solidtotal").html();jsum1=parseFloat(jsum1);
	var jsum2=$("#ratstosystemtot").html();jsum2=parseFloat(jsum2);
	var jsum3=$("#ratheatpumptot").html();jsum3=parseFloat(jsum3);
	var jsum4=$("#ratdirecttanktot").html();jsum4=parseFloat(jsum4);
	var jsum5=$("#ratdistsystemtot").html();jsum5=parseFloat(jsum5);
	var jsum6=$("#ratgasboilertot").html();jsum6=parseFloat(jsum6);
	var sum=parseFloat(jsum1+jsum2+jsum3+jsum4+jsum5+jsum6);
	//var sum=parseInt(jsum1);
	$("#invest").html(sum);
	var jsum1=$("#solidtotalman").html();jsum1=parseFloat(jsum1);
	var jsum2=$("#ratstosystemtotman").html();jsum2=parseFloat(jsum2);
	var jsum3=$("#ratheatpumptotman").html();jsum3=parseFloat(jsum3);
	var jsum4=$("#ratdirecttanktotman").html();jsum4=parseFloat(jsum4);
	var jsum5=$("#ratdistsystemtotman").html();jsum5=parseFloat(jsum5);
	var jsum6=$("#ratgasboilertotman").html();jsum6=parseFloat(jsum6);
	var sum=parseFloat(jsum1+jsum2+jsum3+jsum4+jsum5+jsum6);
	//var sum=parseInt(jsum1);
	$("#mantenance").html(sum);
	});
	
	$("#ratdistsystem").change (function () {
    var jaux = $("#ratdistsystem").val();
	jauxnum=parseInt(jaux);
	var jsup=<?php echo $longdist; ?>;
	jsupnum=parseInt(jsup);
	var jmul=parseInt(jauxnum*jsupnum);
	var jmul2=parseInt(jauxnum*0.02);
	var jmul3=parseInt(jmul2*jsupnum);
	$("#ratdistsystemtot").html(jmul);
	$("#ratdistsystemman").val(jmul2);
	$("#ratdistsystemtotman").html(jmul3);
var jsum1=$("#solidtotal").html();jsum1=parseFloat(jsum1);
	var jsum2=$("#ratstosystemtot").html();jsum2=parseFloat(jsum2);
	var jsum3=$("#ratheatpumptot").html();jsum3=parseFloat(jsum3);
	var jsum4=$("#ratdirecttanktot").html();jsum4=parseFloat(jsum4);
	var jsum5=$("#ratdistsystemtot").html();jsum5=parseFloat(jsum5);
	var jsum6=$("#ratgasboilertot").html();jsum6=parseFloat(jsum6);
	var sum=parseFloat(jsum1+jsum2+jsum3+jsum4+jsum5+jsum6);
	//var sum=parseInt(jsum1);
	$("#invest").html(sum);
	var jsum1=$("#solidtotalman").html();jsum1=parseFloat(jsum1);
	var jsum2=$("#ratstosystemtotman").html();jsum2=parseFloat(jsum2);
	var jsum3=$("#ratheatpumptotman").html();jsum3=parseFloat(jsum3);
	var jsum4=$("#ratdirecttanktotman").html();jsum4=parseFloat(jsum4);
	var jsum5=$("#ratdistsystemtotman").html();jsum5=parseFloat(jsum5);
	var jsum6=$("#ratgasboilertotman").html();jsum6=parseFloat(jsum6);
	var sum=parseFloat(jsum1+jsum2+jsum3+jsum4+jsum5+jsum6);
	//var sum=parseInt(jsum1);
	$("#mantenance").html(sum);
	});
	
	$("#ratgasboiler").change (function () {
    var jaux = $("#ratgasboiler").val();
	jauxnum=parseInt(jaux);
	var jsup=<?php echo $powgasboiler; ?>;
	jsupnum=parseInt(jsup);
	var jmul=parseInt(jauxnum*jsupnum);
	var jmul2=parseInt(jauxnum*0.02);
	var jmul3=parseInt(jmul2*jsupnum);
	$("#ratgasboilertot").html(jmul);
	$("#ratgasboilerman").val(jmul2);
	$("#ratgasboilertotman").html(jmul3);
var jsum1=$("#solidtotal").html();jsum1=parseFloat(jsum1);
	var jsum2=$("#ratstosystemtot").html();jsum2=parseFloat(jsum2);
	var jsum3=$("#ratheatpumptot").html();jsum3=parseFloat(jsum3);
	var jsum4=$("#ratdirecttanktot").html();jsum4=parseFloat(jsum4);
	var jsum5=$("#ratdistsystemtot").html();jsum5=parseFloat(jsum5);
	var jsum6=$("#ratgasboilertot").html();jsum6=parseFloat(jsum6);
	var sum=parseFloat(jsum1+jsum2+jsum3+jsum4+jsum5+jsum6);
	//var sum=parseInt(jsum1);
	$("#invest").html(sum);
	var jsum1=$("#solidtotalman").html();jsum1=parseFloat(jsum1);
	var jsum2=$("#ratstosystemtotman").html();jsum2=parseFloat(jsum2);
	var jsum3=$("#ratheatpumptotman").html();jsum3=parseFloat(jsum3);
	var jsum4=$("#ratdirecttanktotman").html();jsum4=parseFloat(jsum4);
	var jsum5=$("#ratdistsystemtotman").html();jsum5=parseFloat(jsum5);
	var jsum6=$("#ratgasboilertotman").html();jsum6=parseFloat(jsum6);
	var sum=parseFloat(jsum1+jsum2+jsum4+jsum5+jsum6);
	//var sum=parseInt(jsum1);
	$("#mantenance").html(sum);
	});
	
	});
	
</script>

<?php include("footer.php") ?>