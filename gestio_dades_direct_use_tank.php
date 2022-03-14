<?php
/*require_once("admincheck.php");
if(isset($_GET['sidebar'])){
    include('s_header.php');
} else {
    include('header.php');
}*/
//include('header.php');
?>
<?php
// INCLUDES
require_once("./class/gestio_projectesBBDD.php");
require_once("./class/usuari.php");
require_once("./class/components.php");
require_once("./class/distribuciofrecuencies.php");
require_once("./scripts/jvscriptevents.php");
require_once("./class/projectes.php");
require_once("./class/botones.php");
//require_once("./class/projecte.php");
gestio_projectesBBDD::setup();
if(isset($_POST['solarpanels']) || isset($_POST['seasonelstoragesystem']) || isset($_POST['heatpump']) || isset($_POST['directusetank']) || isset($_POST['distributionsystem']) || isset($_POST['auxiliaryenergysystem']) || isset($_POST['absorptionmachine']) || isset($_POST['coldwatertank'])  ) {	
	if(isset($_POST['solarpanels'])){
		$color1="red";
	}
	else{ $color1="blue";}
	if(isset($_POST['seasonelstoragesystem'])){
		$color2="red";
	}
	else{ $color2="blue";}
	if(isset($_POST['heatpump'])){
		$color3="red";
	}
	else{ $color3="blue";}
	if(isset($_POST['directusetank'])){
		$color4="red";
	}
	else{ $color4="blue";}
	if(isset($_POST['distributionsystem'])){
		$color5="red";
	}
	else{ $color5="blue";}
	if(isset($_POST['auxiliaryenergysystem'])){
		$color6="red";
	}
	else{ $color6="blue";}
	if(isset($_POST['absorptionmachine'])){
		$color7="red";
	}
	else{ $color7="blue";}
	if(isset($_POST['coldwatertank'])){
		$color8="red";
	}
	else{ $color8="blue";}
	





}
else{$color1="blue";$color2="blue";$color3="blue";$color4="blue";$color5="blue";$color6="blue";$color7="blue";$color8="blue";}		
if(isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}

//$aux=projectes::getprojecteactual();
//$projecte=$aux['nomproject'];
$projecte=$projh;

$auxoptions="";$densitatmaterial="";$capacitatcalormaterial="";

$auxcolor1=botones::colorbotonsubsistemes(1,$projecte);
$auxcolor2=botones::colorbotonsubsistemes(2,$projecte);
$auxcolor3=botones::colorbotonsubsistemes(3,$projecte);
$auxcolor5=botones::colorbotonsubsistemes(5,$projecte);
$auxcolor6=botones::colorbotonsubsistemes(6,$projecte);
if($auxcolor1[0]['num']==0){$color1="red";}else{$color1="green";};
if($auxcolor2[0]['num']==0){$color2="red";}else{$color2="green";};
if($auxcolor3[0]['num']==0){$color3="red";}else{$color3="green";};
if($auxcolor5[0]['num']==0){$color5="red";}else{$color5="green";};
if($auxcolor6[0]['num']==0){$color6="red";}else{$color6="green";};

//Insertar valores en BBDD desde el boton de add
if(isset($_POST['addbtn'])){
	if(isset($_POST['volume'])){$w_volume=$_POST['volume'];} 
	if(isset($_POST['storagesystem'])){$storagesystem=$_POST['storagesystem'];}
	//if(isset($_POST['location'])){$locationstorage=$_POST['location'];} 
	if(isset($_POST['material'])){$material=$_POST['material'];} 
	if(isset($_POST['density'])){$densitatmaterial=$_POST['density'];}
	if(isset($_POST['heatcapacity'])){$capacitatcalormaterial=$_POST['heatcapacity'];}
	if(isset($_POST['maxtemp'])){$maxtemp=$_POST['maxtemp'];}
	if(isset($_POST['mintemp'])){$mintemp=$_POST['mintemp'];}
	if(isset($_POST['tanksurface'])){$tanksurface=$_POST['tanksurface'];}
	if(isset($_POST['heattransfer'])){$heattransfer=$_POST['heattransfer'];}
if($w_volume!="" && $storagesystem!="" && $storagesystem!="" && $material!="" && $densitatmaterial!="" && $capacitatcalormaterial!="" && $maxtemp!="" && $mintemp!="" && $tanksurface!="" && $heattransfer!="")
	{
	$auxadd=components::adddirectusetank($projecte,$storagesystem,$w_volume,$material,$densitatmaterial,$capacitatcalormaterial,$maxtemp,$mintemp,$tanksurface,$heattransfer);
	//header("location:gestio_dades_distribution_system.php?t=Components Details&projh=$projh",false,301);
	//exit();
	print "<meta http-equiv=Refresh content=\"2 ; url=gestio_dades_distribution_system.php?t=Components Details&projh=$projh\">";

	}

}


$v_dadesdirectusetank=components::getdadesdirectusetank($projecte);
$numdadesdirectusetank=count($v_dadesdirectusetank)-1;
if($numdadesdirectusetank>0)
	{
	$storagesystem=$v_dadesdirectusetank[0]['storage_system'];
	//$locationstorage=$v_dadesdirectusetank[0]['location'];
	$w_volume=$v_dadesdirectusetank[0]['volumen'];
	$material=$v_dadesdirectusetank[0]['storage_material'];
	$densitatmaterial=$v_dadesdirectusetank[0]['density'];
	$capacitatcalormaterial=$v_dadesdirectusetank[0]['heatcapacity'];
	$maxtemp=$v_dadesdirectusetank[0]['maxtemp'];
	$mintemp=$v_dadesdirectusetank[0]['mintemp'];
	$tanksurface=$v_dadesdirectusetank[0]['tank_surface'];
	$heattransfer=$v_dadesdirectusetank[0]['heat_transfer'];
	}

else {$storagesystem="";$material="";$densitatmaterial="";$capacitatcalormaterial="";$w_volume="";$maxtemp="";$mintemp="";$tanksurface="";$heattransfer="";}



//Rellenar combo materiales
$v_storagematerial=components::getstoragematerials(2);
$num_storagematerial=count($v_storagematerial)-1;

$i=1;
	foreach ($v_storagematerial as $aux){
		if($material==$aux['nom']){$selected="selected";}else{$selected="";}
		$auxoptions.=" <option ".$selected." value='".$aux['nom']."'>".$aux['nom']."</option>";
		if($densitatmaterial=="" && $capacitatcalormaterial=="" && $material!=""){
			if ($i=="1"){$densitatmaterial=$aux['densitat'];$capacitatcalormaterial=$aux['capacitatcalor'];}
			}
		$i++;
	}
//Fin relleno combo materiales: colocamos la variables auxoptions dentro del select

//Rellenar combo storagesystem
$v_storagesystem=components::getstoragesystem(2);
$num_storagesystem=count($v_storagesystem)-1;
$auxoptions2="";
$i=1;
	foreach ($v_storagesystem as $aux){
		if($storagesystem==$aux['storage_system']){$selected="selected";}else{$selected="";}
		$auxoptions2.=" <option ".$selected." value='".$aux['storage_system']."'>".$aux['storage_system']."</option>";
	$i++;
	}

include('header.php');
?>

<!-- Anchor start
<a href="#" onclick="popup_window_show('#popup_window_id_270B0FFFBD2A4FA462FA44271BF60E23', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;">Open popup window</a>
Anchor end -->

<!-- Popup Window start -->
<div id="popup_window_id_DUT2" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">Minimum temperature: it should be equal or higher than the heat demand supply temperature (minimal 50&#176;).</div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>
<div id="popup_window_id_270B0FFFBD2A4FA462FA44271BF60E23" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">The tank volume should fulfill next relation:<br> 50<=V/A<180 <br><br>Where:<br>V: volume of the acumulator<br>A: surface of the solar pannels</div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>

<!-- Popup Window end -->

<ul class="breadcrumbs first">
    <li><a href="#">System Details</a></li>
    <li class="active"><a href="#">Direct Use Tank</a></li>
</ul>


<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Data Management</h2>
    </div>
    <div class="widget_body">

	<form name="validacio" method="POST" action="gestio_dades_direct_use_tank.php?t=Component Details&projh=<?php echo $projh;?>" id="validacio">
        
	
	<table>
		<tr>
		
		<td><a href="gestio_dades_solar.php?t=Component Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color1"; ?> right" style="width:200px;">     Solar Panels </a></td>
		<td><a href="gestio_dades_seasonal_storage_system.php?t=Component Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color2"; ?> right" style="width:200px;">Seasonal Storage System</a></td>
		<td><a href="gestio_dades_heat_pump.php?t=Component Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color3"; ?> right" style="width:200px;">Heat Pump</a></td>
		<td><a href="gestio_dades_direct_use_tank.php?t=Component Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color4"; ?> right" style="width:200px;">Direct Use Tank</a></td>
		</tr>
		<tr>
		<td><a href="gestio_dades_distribution_system.php?t=Component Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color5"; ?> right" style="width:200px;"> Distribution System </a></td>
		<td><a href="gestio_dades_auxiliary_energy_source.php?t=Component Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color6"; ?> right" style="width:200px;">Auxiliary Energy System</a></td>
		<!--
		<td><a href="gestio_dades_direct_use_tank.php?t=Component Details&projh=<?php echo $projh;?>" class="btn grey <?php echo "$color7"; ?> right" style="width:200px;">Absorption Machine</a></td>
		<td><a href="gestio_dades_direct_use_tank.php?t=Component Details&projh=<?php echo $projh;?>" class="btn grey <?php echo "$color8"; ?> right" style="width:200px;">Cold Water Tank</a></td>
-->


		</tr>
		
              <tr>
                <td></td>
                <td>
			
			
			
                </td>
            </tr>
        </table>
	<input type=image src="UseTank.jpg" width="120" height="120" align="left">
	<pre style="width:600px; height:100px;">
		<label>Storage System:  </label><select id="storagesystem" style="width:200px;" name="storagesystem"><?php echo $auxoptions2;?>
		<!--//Rellenar el select con la libreria de sistemas de almacenaje-->
		</select>

		<label>Volume:   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text" name="volume" id="volume" style="width:50px;" value="<?php echo round($w_volume,0); ?>"><label>&nbsp;&nbsp;&nbsp;m&#179 &nbsp;&nbsp;&nbsp;</label><input type=image src="images/info.png" width="20" height="20"  onclick="popup_window_show('#popup_window_id_270B0FFFBD2A4FA462FA44271BF60E23', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;">
		<!--<label>Volume:   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text" name="volume" id="volume" style="width:50px;" value="<?php echo $w_volume; ?>"><label>&nbsp;&nbsp;&nbsp; m3   &nbsp;&nbsp;&nbsp;</label>  <input type=image src="images/info.png" width="20" height="20"  onmouseover="alert('The tank volume should fulfill next relation:\n 50<=V/A<180\n\nWhere:\nV: volume of the acumulator\nA: surface of the solar pannels');">
		-->
		</pre>
	<br>

	<table>
		<tr><th width="100">Storage Material:</th><th width="200" class="left"></th><th width="100">Tank parameters:</th><th width="200" class="left"><label></label></th>
		</tr>
		<tr><td width="100">Material:</td><td width="200"><select id="material" style="width:150px;" name="material"><?php echo $auxoptions;?></select></td><td width="100"><label>Max. Temperature</label></td><td width="100"><input type="text" name="maxtemp" id="maxtemp" style="width:50px;" value="<?php echo round($maxtemp,2);?>"><label>&#176C </label></td>
		</tr>
		<tr><td width="200"><label>Density:</label></td><td><input type="text" name="density" id="density" style="width:50px;" value="<?php echo round($densitatmaterial,2);?>"><label>Kg/m&#179;</label></td><td><label>Min. Temperature</label></td><td width="100"><input type="text" name="mintemp" id="mintemp" style="width:50px;" value="<?php echo round($mintemp,2);?>"><label>&#176C </label>   <input type=image src="images/info.png" width="20" height="20"  onclick="popup_window_show('#popup_window_id_DUT2', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;"></td>

		</tr>
		<tr><td width="200"><label>Heat Capacity:</label></td><td width="100"><input type="text" name="heatcapacity" id="heatcapacity" style="width:50px;" value="<?php echo round($capacitatcalormaterial,2);?>"><label>Wh/Kg&#176C</label></td><td width="100"><label>Tank Surface:</label></td><td width="100"><input type="text" name="tanksurface" id="tanksurface" style="width:50px;" value="<?php echo round($tanksurface,0);?>"><label>m&#178; </label></td>

		</tr>
		<tr><td width="200"></td><td width="100"></td><td width="100"><label>Heat Transfer (U):</label></td><td><input type="text" name="heattransfer" id="heattransfer" style="width:50px;" value="<?php echo round($heattransfer,2);?>"><label>W/&#176C.m&#178;</label></td>
		</tr>
		<tr></tr>
		<tr><td></td><td></td><td></td><td><input type="submit" class="btn blue" name="addbtn" value="Next"></td></tr>
	</table>



		<input type="hidden" name="nomdistribucioselected" value="0">
		<input type="hidden" name="projh" id="projh" value="<?php echo $projh; ?>">
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
	$(document).ready(function(){
	$("#material").change (function () {
    var jaux = $("#material").val();
	var jdensitat;
	var jheatcapacitat;
	
	var arrayJS=<?php echo json_encode($v_storagematerial);?>;

 

    // Mostramos los valores del array

    for(var i=0;i<arrayJS.length;i++)

    {
		if(arrayJS[i]['nom']==jaux){
			//document.write("<br>"+arrayJS[i]['COP']);
			jdensitat=arrayJS[i]['densitat'];
			jheatcapacitat=arrayJS[i]['capacitatcalor'];
			
			
			}
		$("#density").val(jdensitat);
		$("#heatcapacity").val(jheatcapacitat);
		
    }
	});
	
	$("#storagesystem").change (function () {
    var jaux = $("#storagesystem").val();
	var jdensitat;
	var jheatcapacitat;
	
	var arrayJS=<?php echo json_encode($v_storagesystem);?>;

 

    // Mostramos los valores del array

    for(var i=0;i<arrayJS.length;i++)

    {
		if(arrayJS[i]['storage_system']==jaux){
			//document.write("<br>"+arrayJS[i]['COP']);
			jtempmax=arrayJS[i]['tempmax'];
			jtempmin=arrayJS[i]['tempmin'];
			jheattransfer=arrayJS[i]['heattransfer'];
			jlocation=arrayJS[i]['location'];
			jstoragematerial=arrayJS[i]['storagematerial'];
			
			}
		$("#maxtemp").val(jtempmax);
		$("#mintemp").val(jtempmin);
		$("#heattransfer").val(jheattransfer);
		$("#location").val(jlocation);
		$("#material").val(jstoragematerial);
    }
	});
	
	});
	
</script>
<?php include("footer.php") ?>