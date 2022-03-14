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
require_once("./class/distribuciofrecuencies.php");
require_once("./scripts/jvscriptevents.php");
require_once("./class/components.php");
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

$tpower1="";$tpower2="";$tpower3="";$tpower4="";$tpower5="";$tpower6="";$tpower7="";$tpower8="";
$ttemp1="";$ttemp2="";$ttemp3="";$ttemp4="";$ttemp5="";$ttemp6="";$ttemp7="";$ttemp8="";
$toper1="";$toper2="";$toper3="";$toper4="";$toper5="";$toper6="";$toper7="";$toper8="";
$selected1="";$selected2="";$selected3="";$selected4="";$selected5="";$selected6="";$selected7="";$selected8="";

//$aux=projectes::getprojecteactual();
//$projecte=$aux['nomproject'];
$projecte=$projh;

$auxcolor1=botones::colorbotonsubsistemes(1,$projecte);
$auxcolor2=botones::colorbotonsubsistemes(2,$projecte);
$auxcolor3=botones::colorbotonsubsistemes(3,$projecte);
$auxcolor4=botones::colorbotonsubsistemes(4,$projecte);
$auxcolor5=botones::colorbotonsubsistemes(5,$projecte);
if($auxcolor1[0]['num']==0){$color1="red";}else{$color1="green";};
if($auxcolor2[0]['num']==0){$color2="red";}else{$color2="green";};
if($auxcolor3[0]['num']==0){$color3="red";}else{$color3="green";};
if($auxcolor4[0]['num']==0){$color4="red";}else{$color4="green";};
if($auxcolor5[0]['num']==0){$color5="red";}else{$color5="green";};
		
		
$falta="1";
//Boton validar, entrar datos
if(isset($_POST['addbtn'])){
//inserta los valores en la BBDD

if(isset($_POST['election1'])){$sendelection1=$_POST['election1'];}else{$sendelection1="";}
if(isset($_POST['election2'])){$sendelection2=$_POST['election2'];}else{$sendelection2="";}

if($sendelection1!="")
	{
	$i=1;
	while($i<=5)
		{
		if($sendelection1=="$i"){
			$indicepower="power".$i;$indicetemperature="temperature".$i;$indiceoperation="operation".$i;
			if(null!==$_POST[$indicepower]){$sendpower1=$_POST[$indicepower];}else{$sendpower1="";}
			
			if(isset($_POST[$indicetemperature])){$sendtemperature1=$_POST[$indicetemperature];}else{$sendtemperature1="";}
			if(isset($_POST[$indiceoperation])){$sendoperation1=$_POST[$indiceoperation];}else{$sendoperation1="";}
			if($i==1){$selected1="checked";$tpower1=$sendpower1;$ttemp1=$sendtemperature1;$toper1=$sendoperation1;}
			if($i==2){$selected2="checked";$tpower2=$sendpower1;$ttemp2=$sendtemperature1;$toper2=$sendoperation1;}
			if($i==3){$selected3="checked";$tpower3=$sendpower1;$ttemp3=$sendtemperature1;$toper3=$sendoperation1;}
			if($i==4){$selected4="checked";$tpower4=$sendpower1;$ttemp4=$sendtemperature1;$toper4=$sendoperation1;}
			if($i==5){$selected5="checked";$tpower5=$sendpower1;$ttemp5=$sendtemperature1;$toper5=$sendoperation1;}
			}
		$i++;
		}
	}
if($sendelection2!="")
	{
	$i=6;
	while($i<=8)
		{
		if($sendelection2=="$i"){
			$indicepower="power".$i;$indicetemperature="temperature".$i;$indiceoperation="operation".$i;
			if(isset($_POST[$indicepower])|| ($_POST[$indicepower]!="")){$sendpower2=$_POST[$indicepower];}else{$sendpower2="";}
			if(isset($_POST[$indicetemperature])){$sendtemperature2=$_POST[$indicetemperature];}else{$sendtemperature2="";}
			if(isset($_POST[$indiceoperation])){$sendoperation2=$_POST[$indiceoperation];}else{$sendoperation2="";}
			if($i==6){$selected6="checked";$tpower6=$sendpower2;$ttemp6=$sendtemperature2;$toper6=$sendoperation2;}
			if($i==7){$selected7="checked";$tpower7=$sendpower2;$ttemp7=$sendtemperature2;$toper7=$sendoperation2;}
			if($i==8){$selected8="checked";$tpower8=$sendpower2;$ttemp8=$sendtemperature2;$toper8=$sendoperation2;}
			}
		$i++;
		}
	}


	

//if($sendpower1=="" || $sendelection1=="" || $sendtemperature1=="" || $sendoperation1=="" || $sendpower2=="" || $sendtemperature2=="" || $sendoperation2=="" || $sendelection2=="")
if($sendpower1=="" || $sendelection1=="" || $sendpower2=="" || $sendelection2=="")
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
$aux=components::addauxiliaryenergysource($projecte,$sendelection1,$sendpower1,$sendelection2,$sendpower2);
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
$v_dadesenergysource=components::getauxiliarysourceproject($projecte);
$numdadesnergysource=count($v_dadesenergysource)-1;
if($numdadesnergysource>0)
	{
	$sendelec1=$v_dadesenergysource[0]['tipo_source_storage_system'];
	$sendelec2=$v_dadesenergysource[0]['tipo_source_direct_use_tank'];
	
	$i=1;
	while($i<=5)
		{
		if($sendelec1==$i){
			//$indicepower1="power".$i;$indicetemperature="temperature".$i;$indiceoperation="operation".$i;
			//if($v_dadesenergysource[0]['power_storage_system']!=null){$sendpower1=$v_dadesenergysource[0]['power_storage_system'];}
			//if($v_dadesenergysource[0]['temp_storage_system']!=null){$sendtemperature1=$v_dadesenergysource[0]['temp_storage_system'];}
			//if($v_dadesenergysource[0]['operation_storage_system']!=null){$sendoperation1=$v_dadesenergysource[0]['operation_storage_system'];}
			
			if($i==1){$selected1="checked";$tpower1=$v_dadesenergysource[0]['power_storage_system'];$ttemp1=$v_dadesenergysource[0]['temp_storage_system'];$toper1=$v_dadesenergysource[0]['operation_storage_system'];}else{$selected1="";$tpower1=null;$ttemp1=null;$toper1=null;}
			if($i==2){$selected2="checked";$tpower2=$v_dadesenergysource[0]['power_storage_system'];$ttemp2=$v_dadesenergysource[0]['temp_storage_system'];$toper2=$v_dadesenergysource[0]['operation_storage_system'];}else{$selected2="";$tpower2="";$ttemp2="";$toper2="";}
			if($i==3){$selected3="checked";$tpower3=$v_dadesenergysource[0]['power_storage_system'];$ttemp3=$v_dadesenergysource[0]['temp_storage_system'];$toper3=$v_dadesenergysource[0]['operation_storage_system'];}else{$selected3="";$tpower3="";$ttemp3="";$toper3="";}
			if($i==4){$selected4="checked";$tpower4=$v_dadesenergysource[0]['power_storage_system'];$ttemp4=$v_dadesenergysource[0]['temp_storage_system'];$toper4=$v_dadesenergysource[0]['operation_storage_system'];}else{$selected4="";$tpower4="";$ttemp4="";$toper4="";}
			if($i==5){$selected5="checked";$tpower5=$v_dadesenergysource[0]['power_storage_system'];$ttemp5=$v_dadesenergysource[0]['temp_storage_system'];$toper5=$v_dadesenergysource[0]['operation_storage_system'];}else{$selected5="";$tpower5="";$ttemp5="";$toper5="";}
			
			}
		$i++;
		}



	$i=6;
	while($i<=8)
		{
		if($sendelec2==$i){
			//$indicepower2="power".$i;$indicetemperature="temperature".$i;$indiceoperation="operation".$i;
			if($v_dadesenergysource[0]['power_direct_use_tank']!=null){$sendpower2=$v_dadesenergysource[0]['power_direct_use_tank'];}
			if($v_dadesenergysource[0]['temp_direct_use_tank']!=null){$sendtemperature2=$v_dadesenergysource[0]['temp_direct_use_tank'];}
			//if($v_dadesenergysource[0]['operation_storage_system']!=null){$sendoperation2=$v_dadesenergysource[0]['operation_direct_use_tank'];}
			//if($i==6){$selected6="checked";$tpower6=$sendpower2;$ttemp6=$sendtemperature2;$toper6=$sendoperation2;}else{$selected6="";$tpower6="";$ttemp6="";$toper6="";}
			//if($i==7){$selected7="checked";$tpower7=$sendpower2;$ttemp7=$sendtemperature2;$toper7=$sendoperation2;}else{$selected7="";$tpower7="";$ttemp7="";$toper7="";}
			//if($i==8){$selected8="checked";$tpower8=$sendpower2;$ttemp8=$sendtemperature2;$toper8=$sendoperation2;}else{$selected8="";$tpower8="";$ttemp8="";$toper8="";}
			if($i==6){$selected6="checked";$tpower6=$sendpower2;$ttemp6=$sendtemperature2;}else{$selected6="";$tpower6="";$ttemp6="";}
			if($i==7){$selected7="checked";$tpower7=$sendpower2;$ttemp7=$sendtemperature2;}else{$selected7="";$tpower7="";$ttemp7="";}
			if($i==8){$selected8="checked";$tpower8=$sendpower2;$ttemp8=$sendtemperature2;}else{$selected8="";$tpower8="";$ttemp8="";}

			}
		$i++;
		}
	}
include('header.php');
?>
<div id="popup_window_id_AES1" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">Please select one auxiliar system for one or both storage systems<br>Recomended value of 1-2 kW for each MWh of heat demand.<br>In this phase only values for the Direct Use Tank will be considered for calculs.</div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>

<ul class="breadcrumbs first">
    <li><a href="#">System Details</a></li>
    <li class="active"><a href="#">Auxiliary Energy Source</a></li>
</ul>


<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Data Management </h2>
    </div>
    <div class="widget_body">

	<form name="validacio" method="POST" action="gestio_dades_auxiliary_energy_source.php?t=Component Details&projh=<?php echo $projh;?>" id="validacio">
        
	
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
		<td><a href="gestio_dades_auxiliary_energy_source.php?t=Component Details&projh=<?php echo $projh;?>" class="btn grey <?php echo "$color7"; ?> right" style="width:200px;">Absorption Machine</a></td>
		<td><a href="gestio_dades_auxiliary_energy_source.php?t=Component Details&projh=<?php echo $projh;?>" class="btn grey <?php echo "$color8"; ?> right" style="width:200px;">Cold Water Tank</a></td>
-->


		</tr>
		
              <tr>
                <td></td>
                <td>
			
			
                </td>
            </tr>
        </table>
	<table>
	<tr><td style="width:100px;"></td><th style="width:100px;">TO THE SEASONAL STORAGE SYSTEM</th><td style="width:100px;"></td><td style="width:100px;"></td>
	</tr>
	<tr><td style="width:100px;"><input type=image src="images/info.png" width="20" height="20"  onclick="popup_window_show('#popup_window_id_AES1', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;"></td><td style="width:100px;"></td><td><label>Power</label></td><!--<td style="width:100px;"><label>Temperature</label></td><td style="width:100px;"><label>Operation</label>--><td style="width:100px;"></td><td style="width:100px;"></td>
	</tr>
	<tr><td style="width:100px;"><label>Electric resistance &nbsp;&nbsp;</label ></td><td><input type="radio" name="election1" id="election1" value="1" <?php echo $selected1; ?> onclick="vaciar1()"></td><td><input type="text" name="power1" id="power1" style="width:150px;" value="<?php echo round($tpower1,2); ?>"> <label>kW</label></td><!--<td><input type="text" name="temperature1" id="temperature1" style="width:150px;" value="<?php echo $ttemp1; ?>"><label>ºC</label></td><td><input type="text" name="operation1" id="operation1" style="width:150px;" value="<?php echo $toper1; ?>">--><td style="width:100px;"></td><td style="width:100px;"></td>
	</tr>
	<tr><td style="width:100px;"><label>Gas boiler &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label ></td><td><input type="radio" name="election1" id="election1" value="2" <?php echo $selected2; ?> onclick="vaciar1()"></td><td><input type="text" name="power2" id="power2" style="width:150px;" value="<?php echo round($tpower2,2); ?>"> <label>kW</label></td><!--<td><input type="text" name="temperature2" id="temperature2" style="width:150px;" value="<?php echo $ttemp2; ?>"><label>ºC</label></td><td><input type="text" name="operation2" id="operation2" style="width:150px;" value="<?php echo $toper2; ?>">--><td style="width:100px;"></td><td style="width:100px;"></td>
	</tr>
	<tr><td style="width:100px;"><label>Biomass boiler &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label ></td><td><input type="radio" name="election1" id="election1" value="3" <?php echo $selected3; ?> onclick="vaciar1()"></td><td><input type="text" name="power3" id="power3" style="width:150px;" value="<?php echo round($tpower3,2); ?>"> <label>kW</label></td><!--<td><input type="text" name="temperature3" id="temperature3" style="width:150px;" value="<?php echo $ttemp3; ?>"><label>ºC</label></td><td><input type="text" name="operation3" id="operation3" style="width:150px;" value="<?php echo $toper3; ?>">--><td style="width:100px;"></td><td style="width:100px;"></td>
	</tr>
	<tr><td style="width:100px;"><label>Heat waste &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label ></td><td><input type="radio" name="election1" id="election1" value="4" <?php echo $selected4; ?> onclick="vaciar1()"></td><td><input type="text" name="power4" id="power4" style="width:150px;" value="<?php echo round($tpower4,2); ?>"> <label>kW</label></td><!--<td><input type="text" name="temperature4" id="temperature4" style="width:150px;" value="<?php echo $ttemp4; ?>"><label>ºC</label></td><td><input type="text" name="operation4" id="operation4" style="width:150px;" value="<?php echo $toper4; ?>">--><td style="width:100px;"></td><td style="width:100px;"></td>
	</tr>
	<tr><td style="width:100px;"><label>Geothermal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label ></td><td><input type="radio" name="election1" id="election1" value="5" <?php echo $selected5; ?> onclick="vaciar1()"></td><td><input type="text" name="power5" id="power5" style="width:150px;" value="<?php echo round($tpower5,2); ?>"> <label>kW</label></td><!--<td><input type="text" name="temperature5" id="temperature5" style="width:150px;" value="<?php echo $ttemp5; ?>"><label>ºC</label></td><td><input type="text" name="operation5" id="operation5" style="width:150px;" value="<?php echo $toper5; ?>">--><td style="width:100px;"></td><td style="width:100px;"></td>
	</tr>
	</table>
	<table>
	<tr><td style="width:100px;"></td><th style="width:100px;">TO THE DIRECT USE TANK</th><td style="width:100px;"></td><td style="width:100px;"></td>
	</tr>

	<tr><td style="width:100px;"></td><td></td><td style="width:100px;"><label>Power</label></td><!--<td style="width:100px;"><label>Temperature</label></td><td style="width:100px;"><label>Operation</label>--><td style="width:100px;"></td><td style="width:100px;"></td>
	</tr>

	<tr><td style="width:100px;"><label>Electric resistance &nbsp;&nbsp;</label ></td><td><input type="radio" name="election2" id="election2" value="6" <?php echo $selected6; ?> onclick="vaciar2()"></td><td><input type="text" name="power6" id="power6" style="width:150px;" value="<?php echo round($tpower6,2); ?>"> <label>kW</label></td><!--<td><input type="text" name="temperature6" id="temperature6" style="width:150px;" value="<?php echo $ttemp6; ?>"><label>ºC</label></td><td><input type="text" name="operation6" id="operation6" style="width:150px;" value="<?php echo $toper6; ?>">--><td style="width:100px;"></td><td style="width:100px;"></td>
	</tr>
	<tr><td style="width:100px;"><label>Gas boiler &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label ></td><td><input type="radio" name="election2" id="election2" value="7" <?php echo $selected7; ?> onclick="vaciar2()"></td><td><input type="text" name="power7" id="power7" style="width:150px;" value="<?php echo round($tpower7,2); ?>"> <label>kW</label></td><!--<td><input type="text" name="temperature7" id="temperature7" style="width:150px;" value="<?php echo $ttemp7; ?>"><label>ºC</label></td><td><input type="text" name="operation7" id="operation7" style="width:150px;" value="<?php echo $toper7; ?>">--><td style="width:100px;"></td><td style="width:100px;"></td>
	</tr>
	<tr><td style="width:100px;"><label>Biomass boiler &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label ></td><td><input type="radio" name="election2" id="election2" value="8" <?php echo $selected8; ?>></td><td><input type="text" name="power8" id="power8" style="width:150px;" value="<?php echo round($tpower8,2); ?>" onclick="vaciar2()"> <label>kW</label></td><!--<td><input type="text" name="temperature8" id="temperature8" style="width:150px;" value="<?php echo $ttemp8; ?>"><label>ºC</label></td><td><input type="text" name="operation8" id="operation8" style="width:150px;" value="<?php echo $toper8; ?>">--><td style="width:100px;"></td><td style="width:100px;"></td>
	</tr>
    <tr>
    <td></td><td></td><td></td>	
	<td>
	<input type="submit" class="btn blue right" name="addbtn" width="60px" id="addbtn" value=" Next ">
	</td>		
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
<script>
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

            
</script>

<?php include("footer.php") ?>