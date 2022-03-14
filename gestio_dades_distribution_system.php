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


$auxcolor1=botones::colorbotonsubsistemes(1,$projecte);
$auxcolor2=botones::colorbotonsubsistemes(2,$projecte);
$auxcolor3=botones::colorbotonsubsistemes(3,$projecte);
$auxcolor4=botones::colorbotonsubsistemes(4,$projecte);
$auxcolor6=botones::colorbotonsubsistemes(6,$projecte);
if($auxcolor1[0]['num']==0){$color1="red";}else{$color1="green";};
if($auxcolor2[0]['num']==0){$color2="red";}else{$color2="green";};
if($auxcolor3[0]['num']==0){$color3="red";}else{$color3="green";};
if($auxcolor4[0]['num']==0){$color4="red";}else{$color4="green";};
if($auxcolor6[0]['num']==0){$color6="red";}else{$color6="green";};


$falta="1";
//Boton validar, entrar datos
if(isset($_POST['addbtn'])){
//inserta los valores en la BBDD

if(isset($_POST['lenght1'])){$sendlength1=$_POST['lenght1'];}else{$sendlength1="";}
if(isset($_POST['diameter1'])){$senddiameter1=$_POST['diameter1'];}else{$senddiameter1="";}
if(isset($_POST['isolationwidth1'])){$sendisolationwidth1=$_POST['isolationwidth1'];}else{$sendisolationwidth1="";}
if(isset($_POST['heattransfer1'])){$sendheattransfer1=$_POST['heattransfer1'];}else{$sendheattransfer1="";}
if(isset($_POST['length2'])){$sendlength2=$_POST['length2'];}else{$sendlength2="";}
if(isset($_POST['diameter2'])){$senddiameter2=$_POST['diameter2'];}else{$senddiameter2="";}
if(isset($_POST['isolationwidth2'])){$sendisolationwidth2=$_POST['isolationwidth2'];}else{$sendisolationwidth2="";}
if(isset($_POST['heattransfer2'])){$sendheattransfer2=$_POST['heattransfer2'];}else{$sendheattransfer2="";}
if($sendlength1=="" || $senddiameter1=="" || $sendisolationwidth1=="" || $sendheattransfer1=="" || $sendlength2=="" || $senddiameter2=="" || $sendisolationwidth2=="" || $sendheattransfer2=="")
	{$falta="0";}
//echo "$sendlength1,$senddiameter1,$sendisolationwidth1,$sendheattransfer1,$sendlength2,$senddiameter2,$sendisolationwidth2,$sendheattransfer2";
echo "Some data are empty.";
//comprobar que haya datos 
if ($falta=="1"){
$aux=components::adddistributionsystem($projecte,$sendlength1,$senddiameter1,$sendisolationwidth1,$sendheattransfer1,$sendlength2,$senddiameter2,$sendisolationwidth2,$sendheattransfer2);
	//header("location:gestio_dades_auxiliary_energy_source.php?t=Components Details&projh=$projh",false,301);
	//exit();
	print "<meta http-equiv=Refresh content=\"2 ; url=gestio_dades_auxiliary_energy_source.php?t=Components Details&projh=$projh\">";

}
else {//Mensaje de falta por script
?>
	<script type="text/javascript">
	alert('Empty Values!');
	</script>
<?php
	}
}

//Cargar los datos si existen en la base de datos 
$v_dadesdistribuciosystem=components::getdadesdistributionsystem($projecte);
$numdadesdistribuciosystem=count($v_dadesdistribuciosystem)-1;
if($numdadesdistribuciosystem>0)
	{
	$length1=$v_dadesdistribuciosystem[0]['long1'];
	//$locationstorage=$v_dadesdirectusetank[0]['location'];
	$diameter1=$v_dadesdistribuciosystem[0]['diametro1'];
	$isolation1=$v_dadesdistribuciosystem[0]['aislamiento1'];
	$heattransfer1=$v_dadesdistribuciosystem[0]['transferenciacalor1'];
	$length2=$v_dadesdistribuciosystem[0]['long2'];
	$diameter2=$v_dadesdistribuciosystem[0]['diametro2'];
	$isolation2=$v_dadesdistribuciosystem[0]['aislamiento2'];
	$heattransfer2=$v_dadesdistribuciosystem[0]['transferenciacalor2'];
	$percen=($length1*$diameter1/100*3.1416*$heattransfer1)+($length2*$diameter2/100*3.1416*$heattransfer2);
	}

else {$length1="";$diameter1="";$isolation1="";$heattransfer1="";$length2="";$diameter2="";$isolation2="";$heattransfer2="";$percen=0;}


include('header.php');
?>

<div id="popup_window_id_DS1" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">The pipe diameter is related to the solar panel surface. Next conditions should be fulfilled:<br>- The velocity of th fluid should be lower than 2 m/s<br>- It is recomended a flow of 55 l/h for each m2 of solar pannel.<br><br>Recomended values:<br>10 m2 -> 500 l/h  -> 1 cm<br>20 m2 -> 1000 l/h -> 1,5 cm<br>40 m2 -> 2000 l/h -> 2 cm<br>100 m2 -> 5000 l/h -> 3,5 cm<br>200 m2 -> 10000 l/h -> 5 cm<br>400 m2 -> 20000 l/h -> 7 cm<br>1000 m2 -> 50000 l/h -> 10 cm</div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>
<div id="popup_window_id_DS2" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">Isolation width: recommended values between 2 and 4 cm<br>Heat transfer coefficient: recommended values between 0,03 and 0,04 W/m2&#176C</div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>

<ul class="breadcrumbs first">
    <li><a href="#">System Details</a></li>
    <li class="active"><a href="#">Distribution System</a></li>
</ul>


<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Data Management</h2>
    </div>
    <div class="widget_body">

	<form name="validacio" method="POST" action="gestio_dades_distribution_system.php?t=Component Details&projh=<?php echo $projh;?>" id="validacio">
        
	
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
		<td><a href="gestio_dades_distribution_system.php?t=Component Details&projh=<?php echo $projh;?>" class="btn grey <?php echo "$color7"; ?> right" style="width:200px;">Absorption Machine</a></td>
		<td><a href="gestio_dades_distribution_system.php?t=Component Details&projh=<?php echo $projh;?>" class="btn grey <?php echo "$color8"; ?> right" style="width:200px;">Cold Water Tank</a></td>
-->


		</tr>
		
              <tr>
                <td></td>
                <td>
			
			
			
                </td>
            </tr>
        </table>
	 
		<input type=image src="distributionsystem.jpg" width="100" height="100" align="left">
		
	<!--<pre style="width:600px; height:200px;">--> 
	<table><tr><th width="110"></th><th width="100" class="left">Solar Pannel to Storage System:</th><th width="100"></th><th width="100" class="left">Storage System to Demand:</th>
		</tr>
		<tr><td width="110"><label>Length:</label></td><td width="100"><input type="text" name="lenght1" id="length1" style="width:60px;" value="<?php echo round($length1,2); ?>" onchange="myFunction(this.value,1)"><label>m</label></td><td width="100"><label>Lenght</label></td><td width="100"><input type="text" name="length2" id="length2" style="width:80px;" value="<?php echo round($length2,2); ?>" onchange="myFunction(this.value,4)"><label>m</label></td>
		</tr>
		<tr><td width="110"><label>Diameter:</label></td><td><input type="text" name="diameter1" id="diameter1" style="width:60px;" value="<?php echo round($diameter1,2); ?>" onchange="myFunction(this.value,2)"><label>cm</label>  <input type=image src="images/info.png" width="20" height="20"  onclick="popup_window_show('#popup_window_id_DS1', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;"></td><td><label>Diameter:</label></td><td width="100"><input type="text" name="diameter2" id="diameter2" style="width:80px;" value="<?php echo round($diameter2,2); ?>" onchange="myFunction(this.value,5)"><label>cm</label></td>

		</tr>
		<tr><td width="110"><label>Insulation Width:</label></td><td width="100"><input type="text" name="isolationwidth1" id="isolationwidth1" style="width:60px;" value="<?php echo round($isolation1,0); ?>"><label>cm</label>  <input type=image src="images/info.png" width="20" height="20"  onclick="popup_window_show('#popup_window_id_DS2', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;"></td><td width="100"><label>Insulation Width:</label></td><td width="100"><input type="text" name="isolationwidth2" id="isolationwidth2" style="width:80px;" value="<?php echo round($isolation2,0); ?>"><label>cm</label></td>

		</tr>
		<tr><td width="110"><label>Heat Transfer (Lambda):</label></td><td><input type="text" name="heattransfer1" id="heattransfer1" style="width:60px;" value="<?php echo round($heattransfer1,4); ?>" onchange="myFunction(this.value,3)"><label>W/&#176C.m</label></td><td width="100"><label>Heat Transfer (Lambda):</label></td><td><input type="text" name="heattransfer2" id="heattransfer2" style="width:80px;" value="<?php echo round($heattransfer2,4); ?>" onchange="myFunction(this.value,6)"><label>W/&#176C.m</label></td>
		</tr>
		<tr><td></td><td><label></label></td><td><div name="per" id="per" style="width:60px;"></div></td><td><input type="submit" class="btn blue" name="addbtn" id="addbtn" value="Next"></td></tr>
	</table>



	<!--</pre>-->
		<input type="hidden" name="nomdistribucioselected" value="0">
		<input type="hidden" name="projh" id="projh" value="<?php echo $projh; ?>">
		<input type="hidden" name="cal" id="cal" value="0">
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
/*$(document).ready(function(){
	alert("hh");
	$("#lenght1").on(change,function (){
    var jaux = $("#lenght1").val();
	var jauxnum=parseInt(jaux);
	$("#per").html(jauxnum);
	});
});
*/
function myFunction(val,tipo) {
  //alert("The input value has changed. The new value is: " + val);
//if(!is_numeric(val)){val=0;}
  var jauxnum=parseInt($("#length1").val());
  var jdiametre1=parseInt($("#diameter1").val());
  var jheattransfer1=parseFloat($("#heattransfer1").val());
  //var jauxnum2=parseInt($("#length2").val());
  //var jdiametre2=parseFloat($("#diameter2").val());
  //var jheattransfer2=parseFloat($("#heattransfer2").val());
  var jauxnum2=parseInt($("#length2").val());
  var jdiametre2=parseInt($("#diameter2").val());
  var jheattransfer2=parseFloat($("#heattransfer2").val());

  if(tipo==1){
  var jauxnum=parseInt(val);
  var jdiametre1=parseInt($("#diameter1").val());
  var jheattransfer1=parseFloat($("#heattransfer1").val());
  }
  if(tipo==2){
  var jauxnum=parseInt($("#length1").val());
  var jdiametre1=parseInt(val);
  var jheattransfer1=parseFloat($("#heattransfer1").val());
  }
  if(tipo==3){
  var jauxnum=parseInt($("#length1").val());
  var jdiametre1=parseInt($("#diameter1").val());
  var jheattransfer1=parseFloat(val);
   }
  
  if(tipo==4){
  //if(isNan(val)) {alert("Alert1");}
  var jauxnum2=parseInt(val);
  //var jdiametre2=parseInt($("#diameter2").val());
  //var jheattransfer2=parseFloat($("#heattransfer2").val());
  }
  if(tipo==5){
	//  if(isNan(val)) {alert("Alert2");}
  //var jauxnum2=parseInt($("#length2").val());
  var jdiametre2=parseInt(val);
  //var jheattransfer2=parseFloat($("#heattransfer2").val());
  }
   if(tipo==6){
	//   if(isNan(val)) {alert("Alert3");}
  //var jauxnum2=parseInt($("#length2").val());
  //var jdiametre2=parseFloat($("#diameter2").val());
  var jheattransfer2=parseFloat(val);
  }
 
  var total=(jauxnum*jdiametre1*3.1416/100*jheattransfer1)+(jauxnum2*jdiametre2*3.1416/100*jheattransfer2);
   //var total=jauxnum2toPrecion;
	
	//$("#per").html(total.toPrecision(2));
  }
</script>

<?php include("footer.php") ?>