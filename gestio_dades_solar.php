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

//if(!$_SESSION['sistema'])
//	{$sendsistema="Generic";}
//else{
//	if($_SESSION['sistema']==""){$sendsistema="Generic";}
//	else{$sendsistema=$_SESSION['sistema'];}
//	}
$num=1000;
if(isset($_POST['paneltypes'])){$sendpanelsolar=$_POST['paneltypes'];}else{$sendpanelsolar="no data";}
//if(isset($_POST['selected'])){$sendpanelsolar=$_POST['selected'];}else{$sendpanelsolar="no data";}
if(isset($_GET['selected'])){$sendpanelsolar=$_GET['selected'];}else{$sendpanelsolar="no data";} //lo pasa por GET 
if(isset($_POST['inclinacio'])){$sendinclinacio=$_POST['inclinacio'];}else{$sendinclinacio="no data";}
if(isset($_POST['azimuth'])){$sendazimuth=$_POST['azimuth'];}else{$sendazimuth="no data";}
if(isset($_POST['superficie'])){$sendsuperficie=$_POST['superficie'];}else{$sendsuperficie="no data";}
if(isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}


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

$sendpaneltype="";$sendinclinacio="";$sendazimuth="";$sendsolarsurface="";$sendstp_b="";$sendstp_a1="";$sendstp_a2="";$sendtemp_summer="";$sendtemp_rest="";$sendtemp_winter=""; $sendefficiency="";


$nompanellsexistents=components::getpanellsolars();
$numpanells=count($nompanellsexistents)-1;

$aux=projectes::getprojecteactual();
$projecte=$aux['nomproject'];
$projecte=$projh;
$sendlocalitat=$aux['localitat'];

$auxcolor2=botones::colorbotonsubsistemes(2,$projecte);
$auxcolor3=botones::colorbotonsubsistemes(3,$projecte);
$auxcolor4=botones::colorbotonsubsistemes(4,$projecte);
$auxcolor5=botones::colorbotonsubsistemes(5,$projecte);
$auxcolor6=botones::colorbotonsubsistemes(6,$projecte);
if($auxcolor2[0]['num']==0){$color2="red";}else{$color2="green";};
if($auxcolor3[0]['num']==0){$color3="red";}else{$color3="green";};
if($auxcolor4[0]['num']==0){$color4="red";}else{$color4="green";};
if($auxcolor5[0]['num']==0){$color5="red";}else{$color5="green";};
if($auxcolor6[0]['num']==0){$color6="red";}else{$color6="green";};

$aux1="";$aux2="";$aux3="";$aux4="";$aux5="";$aux6="";

$dadesprojectepanelsolar=components::getpanellsolarprojecte($projecte);
$numdadesprojectepanelsolar=count($dadesprojectepanelsolar)-1;
if($numdadesprojectepanelsolar>0)
	{
	$sendpaneltype=$dadesprojectepanelsolar[0]['nom_panell'];
	$sendinclinacio=$dadesprojectepanelsolar[0]['inclinacio'];
	$sendazimuth=$dadesprojectepanelsolar[0]['azimut'];
	$sendsolarsurface=$dadesprojectepanelsolar[0]['superficie_solar'];
	$sendstp_b=$dadesprojectepanelsolar[0]['stp_b'];
	$sendstp_a1=$dadesprojectepanelsolar[0]['stp_a1'];
	$sendstp_a2=$dadesprojectepanelsolar[0]['stp_a2'];
	$sendtemp_summer=$dadesprojectepanelsolar[0]['temp_summer'];
	$sendtemp_rest=$dadesprojectepanelsolar[0]['temp_rest'];
	$sendtemp_winter=$dadesprojectepanelsolar[0]['temp_winter'];
	$sendefficiency=$dadesprojectepanelsolar[0]['efficiency'];
	}
else {}

$valorsdistribucioanual=distribuciofrecuencies::getdadesdistribucioanualprojecte(1,$sendlocalitat,$projecte);

$numvalorsdistribucioanual=count($valorsdistribucioanual)-1;

if($numvalorsdistribucioanual>0)
for($i=1;$i<=12;$i++)
	{
	$mes[$i]="";
	}
for($i=1;$i<=12;$i++)
	{		$valorsdistribucioanualmes=distribuciofrecuencies::getdadesdistribucioanualmesprojecte(1,$sendlocalitat,$projecte,$i);
		$numvalordistribucioanualmes=count($valorsdistribucioanualmes)-1;
		
		if($numvalordistribucioanualmes>0){
			$mes[$i]=$valorsdistribucioanualmes[1]['valor'];}
		else {$mes[$i]="";}
}


if(isset($_POST['validar'])){
//Comprobar si están todos los datos
if(isset($_POST['paneltypes'])){$sendpaneltype=$_POST['paneltypes'];}else{$sendpaneltype="";}
if(isset($_POST['inclinacio'])){$sendinclinacio=$_POST['inclinacio'];}else{$sendinclinacio="";}
if(isset($_POST['azimuth'])){$sendazimuth=$_POST['azimuth'];}else{$sendazimuth="";}
if(isset($_POST['superficie'])){$sendsolarsurface=$_POST['superficie'];}else{$sendsolarsurface="";}
if(isset($_POST['stp_b'])){$sendstp_b=$_POST['stp_b'];}else{$sendstp_b="";}
if(isset($_POST['stp_a1'])){$sendstp_a1=$_POST['stp_a1'];}else{$sendstp_a1="";}
if(isset($_POST['stp_a2'])){$sendstp_a2=$_POST['stp_a2'];}else{$sendstp_a2="";}
if(isset($_POST['temp_summer'])){$sendtemp_summer=$_POST['temp_summer'];}else{$sendtemp_summer="";}
if(isset($_POST['temp_rest'])){$sendtemp_rest=$_POST['temp_rest'];}else{$sendtemp_rest="";}
if(isset($_POST['temp_winter'])){$sendtemp_winter=$_POST['temp_winter'];}else{$sendtemp_winter="";}
if(isset($_POST['efficiency'])){$sendefficiency=$_POST['efficiency'];}else{$sendefficiency="";}

if(isset($_POST['gen'])){$sendmes[1]=$_POST['gen'];}else{$sendmes[1]="";}
if(isset($_POST['feb'])){$sendmes[2]=$_POST['feb'];}else{$sendmes[2]="";}
if(isset($_POST['mar'])){$sendmes[3]=$_POST['mar'];}else{$sendmes[3]="";}
if(isset($_POST['apr'])){$sendmes[4]=$_POST['apr'];}else{$sendmes[4]="";}
if(isset($_POST['may'])){$sendmes[5]=$_POST['may'];}else{$sendmes[5]="";}
if(isset($_POST['jun'])){$sendmes[6]=$_POST['jun'];}else{$sendmes[6]="";}
if(isset($_POST['jul'])){$sendmes[7]=$_POST['jul'];}else{$sendmes[7]="";}
if(isset($_POST['aug'])){$sendmes[8]=$_POST['aug'];}else{$sendmes[8]="";}
if(isset($_POST['sep'])){$sendmes[9]=$_POST['sep'];}else{$sendmes[9]="";}
if(isset($_POST['oct'])){$sendmes[10]=$_POST['oct'];}else{$sendmes[10]="";}
if(isset($_POST['nov'])){$sendmes[11]=$_POST['nov'];}else{$sendmes[11]="";}
if(isset($_POST['dec'])){$sendmes[12]=$_POST['dec'];}else{$sendmes[12]="";}


if($sendpaneltype!="" && $sendpaneltype!="0" && $sendinclinacio!="" && $sendazimuth!="" && $sendsolarsurface!="" && $sendstp_b!="" && $sendstp_a1!="" && $sendstp_a2!="" && $sendtemp_summer!="" && $sendtemp_rest!="" && $sendtemp_winter!="" && $sendefficiency!="")
	{ 	$aux=components::addpanelsolar($projecte,$sendpaneltype,$sendinclinacio,$sendazimuth,$sendsolarsurface,$sendstp_b,$sendstp_a1,$sendstp_a2,$sendtemp_summer,$sendtemp_rest,$sendtemp_winter,$sendefficiency);
	//Comparar $sendmes y $mes, si alguno es diferente update de la base de datos de radiación anual y mensual
	$diferente=0;
	for($i=1;$i<=12;$i++)
		{
		if($mes[$i]!=$sendmes[$i])
			{
			$diferente=1;
			//calcular k, factor de multiplicacion
			$k=$sendmes[$i]/$mes[$i];
			//Actualizar data de mes
			$aux=distribuciofrecuencies::actualizarvalormes(1,$sendlocalitat,$projecte,$i,$sendmes[$i]);
			$aux=distribuciofrecuencies::actualizarvalorhorasmes(1,$sendlocalitat,$projecte,$i,$k);
			
			}
		}
	//Hacer que las $mes sean las $sendmes (para que aparezcan en la grid de valores)
	for($i=1;$i<=12;$i++)
		{
		$mes[$i]=$sendmes[$i];
		}
	//Ir a la siguiente página
	//header("location:gestio_dades_seasonal_storage_system.php?t=Components Details&projh=$projh",false);
	//exit();
	print "<meta http-equiv=Refresh content=\"2 ; url=gestio_dades_seasonal_storage_system.php?t=Components Details&projh=$projh\">"; 
	}
}

//echo "var:".$sendpanelsolar.",".$sendpaneltype,",".$numpanells.",".$projecte;
include('header.php');
?>

<div id="popup_window_id_SP1" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">As  lower is the output temperature, higher efficiencies  are achieved by the solar panels.<br>As higher is the output temperature, lower seasonal tank size is required.<br>Output temperature is commonly lower in winter than summer.<br>For PVT solar panels  are recomended output temperatures lower than 50&#176C.</div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>
<div id="popup_window_id_SP2" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body"><img src="formula.png" /><br><br>Where:<br>

DT: Total heat demand (kWh/year)<br>

R: Yearly solar radiation (kWh/year)<br>

&#951;col: Solar panel yearly efficiency (%). If you don't have data use 50%.<br>

Eloss: year energy losses of the system (%). You can use a value between 20-30%.<br>

 </div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>

<ul class="breadcrumbs first">
    <li><a href="#">System Details</a></li>
    <li class="active"><a href="#">Solar Panels </a></li>
</ul>


<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Data Management</h2>
    </div>
    <div class="widget_body">

	<form name="validacio" method="POST" id="validacio" action="gestio_dades_solar.php?t=Components Details&projh=<?php echo $projh;?>" >
        
	
	<table>
		<tr>
		<td><a href="gestio_dades_solar.php?t=Components Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color1"; ?> right" style="width:200px;">Solar Panels</a></td>
		<td><a href="gestio_dades_seasonal_storage_system.php?t=Components Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color2"; ?> right" style="width:200px;">Seasonal Storage System</a></td>
		<td><a href="gestio_dades_heat_pump.php?t=Components Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color3"; ?> right" style="width:200px;">Heat Pump</a></td>
		<td><a href="gestio_dades_direct_use_tank.php?t=Components Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color4"; ?> right" style="width:200px;">Direct Use Tank</a></td>
		</tr>
		<tr>
		<td><a href="gestio_dades_distribution_system.php?t=Components Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color5"; ?> right" style="width:200px;"> Distribution System </a></td>
		<td><a href="gestio_dades_auxiliary_energy_source.php?t=Components Details&projh=<?php echo $projh;?>" class="btn  <?php echo "$color6"; ?> right" style="width:200px;">Auxiliary Energy System</a></td>
		<!--
		<td><a href="gestio_dades_solar.php?t=Components Details&projh=<?php echo $projh;?>" class="btn grey <?php echo "$color7"; ?> right" style="width:200px;" disabled="true">Absorption Machine</a></td>
		<td><a href="gestio_dades_solar.php?t=Components Details&projh=<?php echo $projh;?>" class="btn grey <?php echo "$color8"; ?> right" style="width:200px;" disabled="true">Cold Water Tank</a></td>
		-->


		</tr>
		<tr>
	</table>
	<table>
		
	<pre style="width:900px; height:120px;">
			<input type=image src="solar.jpg" width="100" height="100" align="left">	<label>Solar Panel Type:  </label><select id="paneltypes" style="width:200px;" name="paneltypes" onchange="javascript:valueselect(this)">
		
			<?php
				if($numpanells=="0")
					{ 
					echo "<option value=1>".$numpanells."</option>";
					}
				else{
					$i=0;
					if($sendpanelsolar==$sendpaneltype || ($sendpanelsolar=="no data" && $sendpaneltype!="") )
						{
						//datos del proyecto
						foreach($nompanellsexistents as $aux)
							{
							if($sendpaneltype==$aux['nom_panell'])
										{
										echo "<option selected value=\"".$aux['nom_panell']."\">".$aux['nom_panell']."</option>";
										}
								else {echo "<option value=\"".$aux['nom_panell']."\">".$aux['nom_panell']."</option>";}
							}
										$aux1=$sendstp_b;
										$aux2=$sendstp_a1;
										$aux3=$sendtemp_summer;
										$aux4=$sendtemp_winter;
										$aux5=$sendtemp_rest;
										$aux6=$sendefficiency;
										$aux7=$sendstp_a2;
						}
					else
						{
						$i=0;
						foreach($nompanellsexistents as $aux)
							{
							if($sendpanelsolar==$aux['nom_panell'] || ($sendpanelsolar=="no data" && $i==0))
								{
								echo "<option selected value=\"".$aux['nom_panell']."\">".$aux['nom_panell']."</option>";
								$aux1=$aux['stp_b'];
								$aux2=$aux['stp_a1'];
								$aux3=$aux['temp_summer'];
								$aux4=$aux['temp_winter'];
								$aux5=$aux['temp_rest'];
								$aux6=$aux['efficiency'];
								$aux7=$aux['stp_a2'];
								}
							else {
								echo "<option value=\"".$aux['nom_panell']."\">".$aux['nom_panell']."</option>";
								}
							$i++;
							}
						}
					}
				?>
				
		</select>
		<!--<noscript><input type="submit" value="Submit"></noscript>-->
		
	<label>Inclination:   &nbsp;&nbsp;&nbsp;</label><input type="text" name="inclinacio" id="inclinacio" style="width:50px;" value="<?php echo $sendinclinacio;?>"><label>&nbsp;&nbsp;&nbsp; Azimuth: </label><input type="text" name="azimuth" id="azimuth" style="width:50px;" value="<?php echo $sendazimuth;?>"><label>Solar surface: </label><input type="text" name="superficie" id="superficie" style="width:50px;" value="<?php echo $sendsolarsurface;?>"><label>&nbsp; m2 </label><input type=image src="images/info.png" width="20" height="20"  onclick="popup_window_show('#popup_window_id_SP2', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;">	
	</pre>
	<pre style="width:900px; height:150px;" align="middle">
If you want to change data about radiation, with diferent inclination and azimuth in your solar panels, you can check for real data in this web:
				<h3>   <a href="http://re.jrc.ec.europa.eu/pvg_tools/en/tools.html#DR" style="width:50px;">Photovoltaic Geographical Information System</a></h3>
You can change your data coming from a 0&#176 inclination and 0&#176 azimuth position. If you change the monthly data automatically change the rest of the radiation data for your location. 
	</pre>
	
	
	<hr style="color: #0056b2;" />
	<table>
	<tr>
	<td ><label>Gen.            </td><td><label>Feb.            </label></td><td><label>Mar.              </label></td><td><label>Apr.             </label></td><td><label>May.             </label></td><td><label>Jun.             </label></td>
	</tr>
	<tr>
	<td style="width:150px;"><input type="text" name="gen" id="gen" style="width:80px;" value="<?php echo round($mes[1],2);?>"><label><?php echo utf8_encode(" (Wh/m²)");?></label></td><td style="width:150px;"><input type="text" name="feb" id="feb" style="width:80px;" value="<?php echo round($mes[3],2);?>"><label><?php echo utf8_encode(" (Wh/m²)");?></label></td><td style="width:150px;"><input type="text" name="mar" id="mar" style="width:80px;" value="<?php echo round($mes[3],2);?>"><label><?php echo utf8_encode(" (Wh/m²)");?></label></td><td style="width:150px;"><input type="text" name="apr" id="apr" style="width:80px;" value="<?php echo round($mes[4],2);?>"><label><?php echo utf8_encode(" (Wh/m²)");?></label></td><td style="width:150px;"><input type="text" name="may" id="may" style="width:80px;" value="<?php echo round($mes[5],2);?>"><label><?php echo utf8_encode(" (Wh/m²)");?></label></td><td style="width:150px;"><input type="text" name="jun" id="jun" style="width:80px;" value="<?php echo round($mes[6],2);?>"><label><?php echo utf8_encode(" (Wh/m²)");?></label></td>
	</tr>
	<tr>
	<td><label>Jul.             </label></td><td><label>Aug.             </label></td><td><label>Sep.             </label></td><td><label>Oct.             </label></td><td><label>Nov.             </label></td><td><label>Dec.             </label></td>
	</tr>
	<tr>
	<td><input type="text" name="jul" id="jul" style="width:80px;" value="<?php echo round($mes[7],2);?>"><label><?php echo utf8_encode(" (Wh/m²)");?></label></td><td><input type="text" name="aug" id="aug" style="width:80px;" value="<?php echo round($mes[8],2);?>"><label><?php echo utf8_encode(" (Wh/m²)");?></label></td><td><input type="text" name="sep" id="sep" style="width:80px;" value="<?php echo round($mes[9],2);?>"><label><?php echo utf8_encode(" (Wh/m²)");?></label></td><td><input type="text" name="oct" id="oct" style="width:80px;" value="<?php echo round($mes[10],2);?>"><label><?php echo utf8_encode(" (Wh/m²)");?></label></td><td><input type="text" name="nov" id="nov" style="width:80px;" value="<?php echo round($mes[11],2);?>"><label><?php echo utf8_encode(" (Wh/m²)");?></label></td><td><input type="text" name="dec" id="dec" style="width:80px;" value="<?php echo round($mes[12],2);?>"><label><?php echo utf8_encode(" (Wh/m²)");?></label></td>
	</tr>
	</table>
	
	<hr style="color: #0056b2;" />
	<h4>Characteristics:<input type=image src="images/info.png" width="20" height="20"  onclick="popup_window_show('#popup_window_id_SP1', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;"></h4>
	<table>
	
	<tr style="width:480px;">
	<td style="width:120px;"><label>Solar Thermal Permormance:</label></td>
	<td style="width:120px;"><label>&nbsp;&nbsp;&nbsp;&#951;&#730;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;</label><input type="text" name="stp_b" id="stp_b" style="width:50px;" value="<?php echo round($aux1,4);?>"></td>
	<td style="width:120px;"><label>&nbsp;&nbsp;&nbsp;a1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text" name="stp_a1" id="stp_a1" style="width:50px;" value="<?php echo round($aux2,4);?>"></td>
	<td style="width:120px;"><label>&nbsp;&nbsp;&nbsp;a2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text" name="stp_a2" id="stp_a2" style="width:50px;" value="<?php echo round($aux7,4);?>"></td>
	</tr>
	<tr>
	<td><label>Output Temperature:</label>
	<td style="width:120px;"><label>&nbsp;&nbsp;&nbsp;Summer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text" name="temp_summer" id="temp_summer" style="width:50px;" value="<?php echo round($aux3,2);?>"><label>&nbsp;&nbsp;&nbsp;&#176C&nbsp;&nbsp;&nbsp;</label></td>
	<td style="width:120px;"><label>&nbsp;&nbsp;&nbsp;Spring/Autumn&nbsp;&nbsp;&nbsp;</label><input type="text" name="temp_rest" id="temp_rest" style="width:50px;" value="<?php echo round($aux5,2);?>"><label>&nbsp;&nbsp;&nbsp;&#176C&nbsp;&nbsp;&nbsp;</label></td>
	<td style="width:120px;"><label>&nbsp;&nbsp;&nbsp;Winter&nbsp;&nbsp;&nbsp;</label><input type="text" name="temp_winter" id="temp_winter" style="width:50px;" value="<?php echo round($aux4,2);?>"><label>&nbsp;&nbsp;&nbsp;&#176C&nbsp;&nbsp;&nbsp;</label></td>
	</tr>
	<tr>
	<td><label>Solar Photovoltaic Performance:</label></td>
	<td style="width:120px;"><label>&nbsp;&nbsp;&nbsp;Efficiency (0-1)&nbsp;&nbsp;&nbsp;</label><input type="text" name="efficiency" id="efficiency" style="width:50px;" value="<?php echo round($aux6,2);?>"></td>
	<td></td><td></td>
	</tr>
	
	
	<br>		
		
       
			
	<tr><td></td><td></td><td></td><td>	<input type="submit" class="btn blue right" name="validar" id="validar" value="Next"></td></tr>
	
        </table>
		<!--<input type="hidden" name="nomcomboselected" value=<?php echo $sendsolarpanelselected; ?>>-->
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
    //variable para el modelo elegido
    var modelSelected;

    $(document).ready(function(){ //se ejecuta al cargar la página (OBLIGATORIO)

       ("#paneltypes").on("change", function(){ //se ejecuta al cambiar valor del select
       modelSelected = $(this).val(); //Asignamos el valor seleccionado

		

           if(modelSelected != ""){ //Si tiene un valor llenamos los campos 1 x 1
               $("#stp_b").val("1");
               $("#stp_a1").val("1");
			   $("#stp_a2").val("1");
               $("#summer").val("1");
               $("#spring").val("1");
               $("#winter").val("1");
               $("#efficiency").val("1");
           } else { //Si escogieron una opcion no valida ponemos los campos en blanco
               $("#stp_b").val("");
               $("#stp_a1").val("");
			   $("#stp_a2").val("");
               $("#summer").val("");
               $("#spring").val("");
               $("#winter").val("");
               $("#efficiency").val("");
           }

       });
       
    });
</script>
<script>
   function valueselect(sel) {
      var value = sel.options[sel.selectedIndex].value;
      window.location.href = "gestio_dades_solar.php?t=Component Details&selected="+value+"&projh=<?php echo $projh;?>";
   }
</script>



</body>

<?php include("footer.php") ?>