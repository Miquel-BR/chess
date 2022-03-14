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
//require_once("./class/projecte.php");
require_once("./class/components.php");
require_once("./class/projectes.php");
require_once("./class/botones.php");

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

//Definir el sistema
//$aux=projectes::getprojecteactual();
//$projecte=$aux['nomproject'];
$projecte=$projh;

$auxcolor1=botones::colorbotonsubsistemes(1,$projecte);
$auxcolor2=botones::colorbotonsubsistemes(2,$projecte);
$auxcolor4=botones::colorbotonsubsistemes(4,$projecte);
$auxcolor5=botones::colorbotonsubsistemes(5,$projecte);
$auxcolor6=botones::colorbotonsubsistemes(6,$projecte);
if($auxcolor1[0]['num']==0){$color1="red";}else{$color1="green";};
if($auxcolor2[0]['num']==0){$color2="red";}else{$color2="green";};
if($auxcolor4[0]['num']==0){$color4="red";}else{$color4="green";};
if($auxcolor5[0]['num']==0){$color5="red";}else{$color5="green";};
if($auxcolor6[0]['num']==0){$color6="red";}else{$color6="green";};
	
if(isset($_GET['model'])){$sendmodel=$_GET['model'];}else{$sendmodel="Sin Modelo";}

$nomreg=components::getcop($sendmodel);
$numreg=count($nomreg)-1;

$nomregcopall=components::getallcop();
$numregcopall=count($nomregcopall)-1;


$sendtf="";$sendtc="";$sendcop="";


if(isset($_GET['pos'])){
	$sendpos=$_GET['pos'];
	//cargar todos los COPs, cargar
}
else{
	if($numreg==0){
		$sendpos='1';$sendtf="";$sendtc="";$sendcop="";}
	else{$sendpos=1;}
}
//if(!$_SESSION['pos']){$_SESSION=$sendpos;}
//else {$sendpos=$_SESSION['pos'];}
if($numreg>0){
foreach($nomreg as $aux)
		{
		if($aux['numordre']==$sendpos)
			{
			$sendtf=$aux['tf'];
			$sendtc=$aux['tc'];
			$sendcop=$aux['COP'];
				
			}
		}
}

$num="zzz";	
if(isset($_POST['validar'])){
$falta="1";
//Comprobar si están todos los datos
if(isset($_POST['model'])){$sendmodel=$_POST['model'];}else{$sendmodel="";}
if(isset($_POST['power'])){$sendpower=$_POST['power'];}else{$sendpower="";}
if(isset($_POST['evaporator'])){$sendevaporator=$_POST['evaporator'];}else{$sendevaporator="";}
if(isset($_POST['outputtemperature'])){$sendoutputtemp=$_POST['outputtemperature'];}else{$sendoutputtemp="";}
if(isset($_POST['carnotefficiency'])){$sendcarnot=$_POST['carnotefficiency'];}else{$sendcarnot="";}
if(isset($_POST['maxintemp'])){$num=$_POST['maxintemp'];}else{$num="";}

if(isset($_POST['maxintemp'])){$num=$_POST['maxintemp'];}else{$num="";}

if(isset($_POST['TminCOP'])){$sendTminCOP=$_POST['TminCOP'];}else{$sendTminCOP="";}
if(isset($_POST['MinCOP'])){$sendMinCOP=$_POST['MinCOP'];}else{$sendMinCOP="";}
if(isset($_POST['TmidCOP'])){$sendTmidCOP=$_POST['TmidCOP'];}else{$sendTmidCOP="";}
if(isset($_POST['MidCOP'])){$sendMidCOP=$_POST['MidCOP'];}else{$sendMidCOP="";}
if(isset($_POST['TmaxCOP'])){$sendTmaxCOP=$_POST['TmaxCOP'];}else{$sendTmaxCOP="";}
if(isset($_POST['MaxCOP'])){$sendMaxCOP=$_POST['MaxCOP'];}else{$sendMaxCOP="";}
if(isset($_POST['bottonCOP'])){$sendbottonCOP=$_POST['bottonCOP'];}else{$sendbottonCOP="";}

if(isset($_POST['tf'])){$sendtf=$_POST['tf'];}else{$sendtf="";}
if(isset($_POST['tc'])){$sendtc=$_POST['tc'];}else{$sendtc="";}
if(isset($_POST['cop'])){$sendcop=$_POST['cop'];}else{$sendcop="";}



if($sendmodel=="" || $sendpower=="" || $sendoutputtemp=="" || $sendcarnot=="")
	{
	if($sendMinCOP=="" || $sendMinCOP="" || $sendTmaxCOP="" || $sendMaxCOP="" || $sendTidCOP="" || $sendMidCOP="" || $sendbottonCOP="")
		{$falta="0";}
	}


//echo "variables pasada de insercion:$falta,$num ";
//comprobar que haya datos 


if ($falta=="1"){
//echo "$sendTminCOP,$sendMinCOP,$sendTmaxCOP,$sendMaxCOP";
//$aux=components::addheatpump($projecte,$sendmodel,$sendpower,$sendevaporator,$sendoutputtemp,$sendcarnot,$num,$sendTminCOP,$sendMinCOP,$sendTmidCOP,$sendMidCOP,$sendTmaxCOP,$sendMaxCOP,$sendbottonCOP);
$aux=components::addheatpump($projecte,$sendmodel,$sendpower,$sendoutputtemp,$sendcarnot,$sendTminCOP,$sendMinCOP,$sendTmidCOP,$sendMidCOP,$sendTmaxCOP,$sendMaxCOP,$sendbottonCOP);
	//header("location:gestio_dades_direct_use_tank.php?t=Components Details&projh=$projh",false,301);
	//exit();
	print "<meta http-equiv=Refresh content=\"2 ; url=gestio_dades_direct_use_tank.php?t=Components Details&projh=$projh\">";

}
}		




if(isset($_POST['addcop'])){
//inserta los valores en la BBDD
//comprobar que $sendpos sea la última
if(isset($_POST['pos'])){$sendpos=$_POST['pos'];}else{$sendpos='1';}
if(isset($_POST['tf'])){$sendtf=$_POST['tf'];}else{$sendtf='0';}
if(isset($_POST['tc'])){$sendtc=$_POST['tc'];}else{$sendtc='0';}
if(isset($_POST['cop'])){$sendcop=$_POST['cop'];}else{$sendcop='0';}
//echo "variables pasada de insercion: $sendpos,$numreg,$sendmodel,$sendtf,$sendtc,$sendcop";


if($sendpos>$numreg){

//comprobar que haya datos $sendmodel, $sendtf,$sendtc,$sendcop
if ($sendmodel!="" && $sendtf!="" && $sendtc!="" && $sendcop!=""){
$aux=components::addcop($sendmodel,$sendpos,$sendtf,$sendtc,$sendcop);}
$sendpos=$sendpos+1;$sendtf="";$sendtc="";$sendcop="";
}
$nomreg=components::getcop($sendmodel);
$numreg=count($nomreg)-1;
$nomregcopall=components::getallcop();
$numregcopall=count($nomregcopall)-1;
}

if(isset($_GET['varpaso'])){$varpaso=$_GET['varpaso'];}
else
{$varpaso=$sendmodel;}

$v_dadesheatpump=components::getdadesheatpump($projecte);
$numdadesheatpump=count($v_dadesheatpump)-1;
if($numdadesheatpump>0)
	{
	$sendmodel=$v_dadesheatpump[0]['model'];
	$power=$v_dadesheatpump[0]['power'];
	$evap=$v_dadesheatpump[0]['max_temp_evaporator'];
	$outputtemp=$v_dadesheatpump[0]['output_temp'];
	$carnoteff=$v_dadesheatpump[0]['carnot_efficiency'];
	$max_inlet_temp=$v_dadesheatpump[0]['max_inlet_temp'];
	$vTminCOP=$v_dadesheatpump[0]['TCOPmin'];
	$vMinCOP=$v_dadesheatpump[0]['COPmin'];
	$vTmidCOP=$v_dadesheatpump[0]['TCOPmid'];
	$vMidCOP=$v_dadesheatpump[0]['COPmid'];
	$vTmaxCOP=$v_dadesheatpump[0]['TCOPmax'];
	$vMaxCOP=$v_dadesheatpump[0]['COPmax'];
	$vBottonCOP=$v_dadesheatpump[0]['bottonCOP'];
	}
else
	{
	$sendmodel="Sin Modelo";$power="";$evap="";$outputtemp="";$carnoteff="";$max_inlet_temp="";$vTminCOP="";$vMinCOP="";$vTmidCOP="";$vMidCOP="";$vTmaxCOP="";$vMaxCOP="";$vBottonCOP="";
	
	}

$carnotefficiency=1;
$i=1;$auxoptions="";
$vheatpumps=components::getallheatpumps();
$numvheatpumps=count($vheatpumps)-1;
//if($material==""){$auxoptions.="<option selected value=\"0\">Select Option</option>";}
	$auxoptions="<option selected value='Your values'>Your values</option>";
	foreach ($vheatpumps as $aux){
		if($sendmodel==$aux['model']){$selected=" selected";}else{$selected="";}
		
		$auxoptions.=" <option ".$selected." value='".$aux['model']."'>".$aux['model']."</option>";
		//if($densitatmaterial=="" && $capacitatcalormaterial=="" && $material!=""){
		//	if ($i=="1"){$densitatmaterial=$aux['densitat'];$capacitatcalormaterial=$aux['capacitatcalor'];}
		//	}
		$i++;
	}
include('header.php');
?>
<div id="popup_window_id_HP1" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">Heat pump suply temperature: this temperatrue should be equal or higher than the supply temperature defined in the Heat demand screen. In our system output temperature would be direct use tank working temperature. 60&#176C. </div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>
<div id="popup_window_id_HP2" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">Max. Temp. of evaporator: higher inlet temperature in the heat pump. It should be lower than the maximum temperature of the seasonal storage system (recomended value of 40&#176C) Min. Temp. of evaporator: higher inlet temperature in the heat pump. It corresponds at the minimum tempertare of the seasonal storage system (recomended value of 15&#176C).</div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>

<ul class="breadcrumbs first">
    <li><a href="#">System Details</a></li>
    <li class="active"><a href="#">Heat Pump</a></li>
</ul>


<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Data Management</h2>
    </div>
    <div class="widget_body">

	<form name="validacio" method="POST" action="gestio_dades_heat_pump.php?t=Components Details&projh=<?php echo $projh;?>" id="validacio">
        
	
	<table>
		<tr>
		<td><a href="gestio_dades_solar.php?t=Components Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color1"; ?> right" style="width:200px;">     Solar Panels </a></td>
		<td><a href="gestio_dades_seasonal_storage_system.php?t=Components Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color2"; ?> right" style="width:200px;">Seasonal Storage System</a></td>
		<td><a href="gestio_dades_heat_pump.php?t=Components Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color3"; ?> right" style="width:200px;">Heat Pump</a></td>
		<td><a href="gestio_dades_direct_use_tank.php?t=Components Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color4"; ?> right" style="width:200px;">Direct Use Tank</a></td>
		</tr>
		<tr>
		<td><a href="gestio_dades_distribution_system.php?t=Components Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color5"; ?> right" style="width:200px;"> Distribution System </a></td>
		<td><a href="gestio_dades_auxiliary_energy_source.php?t=Components Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color6"; ?> right" style="width:200px;">Auxiliary Energy System</a></td>
		<!--
		<td><a href="gestio_dades_heat_pump.php?t=Components Details&projh=<?php echo $projh;?>" class="btn grey <?php echo "$color7"; ?> right" style="width:200px;" disabled>Absorption Machine</a></td>
		<td><a href="gestio_dades_heat_pump.php?t=Components Details&projh=<?php echo $projh;?>" class="btn grey <?php echo "$color8"; ?> right" style="width:200px;" disabled>Cold Water Tank</a></td>
-->
		</tr>
              <tr>
                <td></td>
                <td>
			
			
			
                </td>
            </tr>
        </table>
	<table>
	
	<tr><td><input type=image src="heatpump.jpg" width="140" height="140" align="left"></td>
	<td><pre style="width:500px; height:140px;">
	<label>Model: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label ><!--<input type="text" name="model" id="model" style="width:150px;" value="<?php echo "$sendmodel"; ?>">--><select id="model" style="width:200px; height:50px;" name="model"><?php echo $auxoptions;?></select>
	
	<label>Power:   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text" name="power" id="power" style="width:50px;" value="<?php echo "$power"; ?>"><label>&nbsp;&nbsp;&nbsp; KW   &nbsp;&nbsp;&nbsp;</label>
	</pre>
	<!--<label>Max Temp. of evaporator:   &nbsp;&nbsp;&nbsp;</label><input type="text" name="evaporator" id="evaporator" style="width:50px;" value="<?php echo "$evap"; ?>"><label>&nbsp;&nbsp;&nbsp; ºC   &nbsp;&nbsp;&nbsp;</label>-->
	<!--<label>Carnot efficiency factor:   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text" name="carnotefficiency" id="carnotefficiency" style="width:50px;" value="<?php echo "$carnoteff"; ?>"><label>&nbsp;&nbsp;&nbsp; %   &nbsp;&nbsp;&nbsp;</label>-->
	<!--<label>Maximum inlet temp.:   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text" name="maxintemp" id="maxintemp" style="width:50px;" value="<?php echo "$max_inlet_temp"; ?>"><label>&nbsp;&nbsp;&nbsp;  ºC  &nbsp;&nbsp;&nbsp;</label>-->
	</td></tr></table>
<table><tr><td><pre style="width:600px; height:280px;">

<label>Condenser Temperature (Output Heat Pump Temp.):   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text" name="outputtemperature" id="outputtemperature" style="width:50px;" value="<?php echo "$outputtemp"; ?>"><label>&nbsp;&nbsp;&nbsp; &#176C   &nbsp;&nbsp;&nbsp;</label><input type=image src="images/info.png" width="20" height="20"  onclick="popup_window_show('#popup_window_id_HP1', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;">

<label>COP DATA:   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type=image src="images/info.png" width="20" height="20"  onclick="popup_window_show('#popup_window_id_HP2', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;">
<table><tr>
<td><label>   </label></td><td></td><td><label>COP min.:   </label></td><td><input type="text" name="bottonCOP" id="bottonCOP" style="width:50px;" value="<?php echo "$vBottonCOP"; ?>"></td>
</tr>
<tr><td><label>Ta (Min. Input Temperature): </label></td><td><input type="text" name="TminCOP" id="TminCOP" style="width:50px;" value="<?php echo "$vTminCOP"; ?>"><label>&nbsp;&nbsp;&nbsp; &#176C   &nbsp;&nbsp;&nbsp;</label></td><td><label>COPa:</label></td><td><input type="text" name="MinCOP" id="MinCOP" style="width:50px;" value="<?php echo "$vMinCOP"; ?>"></td>
</tr>
<tr><td><label>Tb (Middle Input Temperature):</label></td><td><input type="text" name="TmidCOP" id="TmidCOP" style="width:50px;" value="<?php echo "$vTmidCOP"; ?>"><label>&nbsp;&nbsp;&nbsp; &#176C   &nbsp;&nbsp;&nbsp;</label></td><td><label>COPb:</label></td><td><input type="text" name="MidCOP" id="MidCOP" style="width:50px;" value="<?php echo "$vMidCOP"; ?>"></td>
</tr>
<tr><td><label>Tc (Max. Input Temperature): </label></td><td><input type="text" name="TmaxCOP" id="TmaxCOP" style="width:50px;" value="<?php echo "$vTmaxCOP"; ?>"><label>&nbsp;&nbsp;&nbsp; &#176C   &nbsp;&nbsp;&nbsp;</label></td><td><label>COPc:</label></td><td><input type="text" name="MaxCOP" id="MaxCOP" style="width:50px;" value="<?php echo "$vMaxCOP"; ?>"></td>
</tr></table>
</pre></td><td>Distribution COP exemple:<input type=image src="COP grafic.jpg" width="245" height="220" align="left"></td></tr></table></td>
	</tr>
	</table>
	<table>
		
		<!--<pre><input type="button" class="btn blue " name="retroceder" id="retroceder" value="<<"><input type="text" name="pos" id="pos" style="width:50px;" disable value="<?php echo $sendpos;?>"><input type="text" name="tf" id="tf" style="width:50px;" value="<?php echo "$sendtf";?>"><input type="text" name="tc" id="tc" style="width:50px;" value="<?php echo "$sendtc";?>"><input type="text" name="cop" id="cop" style="width:50px;" value="<?php echo "$sendcop";?>"><!--<a href="avanzar_pos.php?pos=<?php echo $sendpos; ?>&numreg=<?php echo $numreg; ?>&model=<?php echo $varpaso; ?>" class="btn blue" id="btnAva"> <?php echo ">"; ?> </a><input type="button" class="btn blue" name="avanza" id="avanza" value=">>"><input type="submit" class="btn blue" name="addcop" value="Next COP">
		</pre> -->
            <tr>
                <td width="120"></td>
				<td width="120"></td>
				<td width="120"></td>
                <td width="120">
			
			<input type="submit" class="btn blue right " name="validar" id="validar" value="Next">
			
                </td>
            </tr>
	</table>
		<input type="hidden" name="nomdistribucioselected" id="nomdistribucioselected" value="0">
		<input type="hidden" name="varpaso" id="varpaso" value="0">
		<input type="hidden" name="projh" id="projh" value="<?php echo $projh; ?>">
		<input type="hidden" name="carnotefficiency" id="carnotefficiency" value="<?php echo $carnotefficiency; ?>">
		
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
	$("#model").change (function () {
    
	//document.validacio.submit();
    
	var jaux = $("#model").val();
	var arrayJS=<?php echo json_encode($vheatpumps);?>;
	var arrayJS2=<?php echo json_encode($v_dadesheatpump);?>;
 

    // Mostramos los valores del array
	
	if(jaux=="Your values"){
			
			 
				jaux2=arrayJS2[0]['output_temp'];
				jaux3=arrayJS2[0]['TCOPmax'];
				jaux4=arrayJS2[0]['COPmax'];
				jaux5=arrayJS2[0]['TCOPmid'];
				jaux6=arrayJS2[0]['COPmid'];
				jaux7=arrayJS2[0]['TCOPmin'];
				jaux8=arrayJS2[0]['COPmin'];
				jaux9=arrayJS2[0]['bottonCOP'];
				
			}
	else
		{
		for(var i=0;i<arrayJS.length;i++)

			{
			if(arrayJS[i]['model']==jaux){
			//document.write("<br>"+arrayJS[i]['COP']);
			//jaux1=arrayJS[i]['power'];
				jaux2=arrayJS[i]['output_temp'];
				jaux3=arrayJS[i]['TCOPmax'];
				jaux4=arrayJS[i]['COPmax'];
				jaux5=arrayJS[i]['TCOPmid'];
				jaux6=arrayJS[i]['COPmid'];
				jaux7=arrayJS[i]['TCOPmin'];
				jaux8=arrayJS[i]['COPmin'];
				jaux9=arrayJS[i]['bottonCOP'];
				}
			}
		}
		//$("#power").val(jaux1);
		$("#outputtemperature").val(jaux2);
		$("#TmaxCOP").val(jaux3);
		$("#MaxCOP").val(jaux4);
		$("#TmidCOP").val(jaux5);
		$("#MidCOP").val(jaux6);
		$("#TminCOP").val(jaux7);
		$("#MinCOP").val(jaux8);
		$("#bottonCOP").val(jaux9);
	
	
	
	});

	$("#avanza").click( function(){
		var jmodel = $("#model").val();
		var jpos=$("#pos").val();
		var jtf="";
		var jtc="";
		var jcop="";
		var jmax=<?php echo $numreg;?>;
		jmax=parseInt(jmax);
		jpos=parseInt(jpos);
		if(jpos<=jmax)
			{jpos=jpos+1;}
		$("#pos").val(jpos);
		var arrayJS=<?php echo json_encode($nomregcopall);?>;

 

    // Mostramos los valores del array

    for(var i=0;i<arrayJS.length;i++)

    {
		if(arrayJS[i]['numordre']==jpos && arrayJS[i]['model']==jmodel){
			//document.write("<br>"+arrayJS[i]['COP']);
			jcop=arrayJS[i]['COP'];
			jtf=arrayJS[i]['tf'];
			jtc=arrayJS[i]['tc'];
			
			}
		$("#cop").val(jcop);
		$("#tf").val(jtf);
		$("#tc").val(jtc);
    }
	});	
	
$("#retroceder").click( function(){
		var jmodel = $("#model").val();
		var jpos=$("#pos").val();
		var jcop="";
		var jtf="";
		var jtc="";
		
		jpos=parseInt(jpos);
		if(jpos>1)
			{jpos=jpos-1;}
		$("#pos").val(jpos);
		var arrayJS=<?php echo json_encode($nomregcopall);?>;

 

    // Mostramos los valores del array

    for(var i=0;i<arrayJS.length;i++)

    {
		if(arrayJS[i]['numordre']==jpos && arrayJS[i]['model']==jmodel){
			//document.write("<br>"+arrayJS[i]['COP']);
			jcop=arrayJS[i]['COP'];
			jtf=arrayJS[i]['tf'];
			jtc=arrayJS[i]['tc'];
			
			
			}
			$("#cop").val(jcop);
			$("#tf").val(jtf);
			$("#tc").val(jtc);
    }
	});	
});

</script>




<?php include("footer.php") ?>