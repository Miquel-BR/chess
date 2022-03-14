<?php
if(isset($_GET['sidebar'])){
    include('s_header.php');
} else {
    include('header.php');
}
?>




<?php

// INCLUDES
require_once("./class/gestio_projectesBBDD.php");
require_once("./class/demandas.php");
require_once("./class/usuari.php");
require_once("./scripts/jvscriptevents.php");
require_once("./class/botones.php");
require_once("./class/projectes.php");
require_once("./class/localitat.php");
require_once("./class/valoresreferencia.php");

if(isset($_SESSION['projecte'])){$project=$_SESSION['projecte'];}
if (isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}

gestio_projectesBBDD::setup();

$usuario=$_SESSION['usuari'];
$tipouser=usuari::gettipousuari($usuario);
if($tipouser==2){$textbutton="disabled";$tipobtn="btn grey";}
else {$textbutton="";$tipobtn="btn";}

$vectorvaloresref=valoresreferencia::getvaloresref();
$valorrefdemand1=$vectorvaloresref[0]['valorrefdemand1'];
$vectordatosdemand=demandas::consultaproyectodemandaproj($projh);
$numvectordatosdemand=count($vectordatosdemand)-1;
if($numvectordatosdemand>0)
	{
	//foreach ($vectordatosdemand as $datos)
	//	{
		$projecte=$vectordatosdemand[0]['projecte'];
		//$lastnumhomes=$vectordatosdemand[0]['numhomes'];
		$numhomes=1;
		$lastheatingdemand=$vectordatosdemand[0]['heatingdemand'];
		$lasthotwaterdemand=$vectordatosdemand[0]['hotwaterdemand'];
		$lastcoolingdemand=$vectordatosdemand[0]['coolingdemand'];
		$lastelectricappdemand=$vectordatosdemand[0]['electricappdemand'];
		$lastheatingtemp=$vectordatosdemand[0]['heatingtemp'];
		$lasthotwatertemp=$vectordatosdemand[0]['hotwatertemp'];
		$lastcoolingtemp=$vectordatosdemand[0]['coolingtemp'];
		$suma=$lastheatingdemand+$lasthotwaterdemand+$lastcoolingdemand+$lastelectricappdemand;
	//	}
	}
else
	{
	//$lastnumhomes="";
	$numhomes=1;
	$lastheatingdemand="";
	$lasthotwaterdemand="";
	$lastcoolingdemand=0;
	$lastelectricappdemand=0;
	$lastheatingtemp="";
	$lasthotwatertemp="";
	$lastcoolingtemp=0;
	$suma=0;
	}
$vectordemand=demandas::consultademandas();
$numdemand=count($vectordemand)-1;
$demandaselected=demandas::getdemandaproject();
$demandaproject=$demandaselected['nomdemanda'];
$localitatselec=localitat::getlocalitatproject();
$localitat=$localitatselec['localitat'];

//Parte en la que checkeamos si existen las distribiciones para tipus 1, 2 , 3 y 4
//necesitamos projecte, demanda, tipusdis,
//$aux=projectes::getprojecteactual();
//$projecte=$aux['nomproject'];
$projecte=$projh;


$vectorlocaux=demandas::getdemandadisproject($projecte);

$numvectorlocaux=count($vectorlocaux)-1;
//print_r($vectorlocaux);
$auxbtn1=botones::checkanualdisdemand(4,$localitat,$projecte);
$auxbtn2=botones::checkanualdisdemand(5,$localitat,$projecte);
$auxbtn3=botones::checkanualdisdemand(6,$localitat,$projecte);
$auxbtn4=botones::checkanualdisdemand(7,$localitat,$projecte);

if($auxbtn1[0]['count']<12){$auxcolor1="red";}else{
	$auxcolor1="green";
	for($i=1;$i<=12;$i++)
		{
		$auxbtn11=botones::checkmesdisdemand(4,$demandaselected['nomdemanda'],$i,$projecte);
		if($auxbtn11[0]['count']<24){$auxcolor1="red";}
		}
	}
if($auxbtn2[0]['count']<12){$auxcolor2="red";}else{
	$auxcolor2="green";
	for($i=1;$i<=12;$i++)
		{
		$auxbtn22=botones::checkmesdisdemand(5,$demandaselected['nomdemanda'],$i,$projecte);
		if($auxbtn22[0]['count']<24){$auxcolor2="red";}
		}
	}
if($auxbtn3[0]['count']<12){$auxcolor3="red";}else{
	$auxcolor3="green";
	for($i=1;$i<=12;$i++)
		{
		$auxbtn33=botones::checkmesdisdemand(6,$demandaselected['nomdemanda'],$i,$projecte);
		if($auxbtn33[0]['count']<24){$auxcolor3="red";}
		}
	}
if($auxbtn4[0]['count']<12){$auxcolor4="red";}else{
	$auxcolor4="green";
	for($i=1;$i<=12;$i++)
		{
		$auxbtn44=botones::checkmesdisdemand(7,$demandaselected['nomdemanda'],$i,$projecte);
		if($auxbtn44[0]['count']<24){$auxcolor4="red";}
		}
	}
//if($auxcolor1=="green" && $auxcolor2=="green" && $auxcolor3=="green" && $auxcolor4=="green")
if($auxcolor1=="green" || $auxcolor2=="green" || $auxcolor3=="green" || $auxcolor4=="green")
	{
	$auxbtnvalidar="class=\"btn blue\"";
	}
else{$auxbtnvalidar=" class=\"btn red\" disabled";}
//echo $vectorlocaux[0]['discompleta'].",".$vectorlocaux[1]['discompleta'].",".$vectorlocaux[2]['discompleta'].",".$vectorlocaux[3]['discompleta'].",".$vectorlocaux[4]['discompleta'].",".$vectorlocaux[5]['discompleta'];

?>
<div id="popup_window_id_CD1" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">According to your distribution system next values are reomended:<br>- Convectional radiators: 60-70&#176C <br>- Low temperature radiators: 40-65&#176C <br>- Radiant floor: 30-50&#176C <br>- Fan coils: 30-45&#176C </div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>
<div id="popup_window_id_CD2" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">60&#176C recomended.</div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>
<div id="popup_window_id_CD3" class="popup_window_css"><table class="popup_window_css"><tr><td class="popup_window_css"><div class="popup_window_css_head"><img src="/images/close.gif" alt="" width="9" height="9" />Info</div><div class="popup_window_css_body">10&#176C lower than supply temperature.</div><div class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="/images/about.gif" alt="" width="6" height="6" /></a></div></td></tr></table></div>


<ul class="breadcrumbs">
    <!--<li><a href="#">Management</a></li>-->
    <li><a href="#">Energy Demand</a></li>
    <!--<li class="active"><a href="#">Inici </a></li>-->
</ul>
<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Information</h2>
    </div>
    <div class="widget_body">
        <div class="widget_content">
            <div style="width: 80%; display: inline-block;zoom: 1;*display:inline;">
            <ul class="list-tick">   
            </ul>
            <!--<ul class="list-cross">-->
			<ul>
				<li>Energy demand  is related to the typology of your building and the climate conditions of your location.
Once your building's tipology is defined, provide required information about heating, hot water, cooling and electric appliances' yearly demand. Some existing libraries might be of your interest at this stage. </li>
            </ul>
            </div>
        </div>
    </div>
</div>
    <div class="grid_16 widget first">
        <div class="widget_title clearfix">
            <h2>Data introducing </h2>
        </div>
        <div class="widget_body">
                <div id="table1">
		<form method="POST" action="validardemandas.php?t1=Inici&projh=<?php echo $projh;?>">
                <table class='simple'>
        <tr><td><h2>LOCATION</h2></td><td><h2><?php echo $localitat; ?></h2></td></tr> 
		<tr>
		<td><label>Choose a existing tipology:</label></td>
		<td><select id="demands" name="demands" style="width:100px;" onchange="rellenar()">
		<?php			
			$i=0;
			if($numdemand==0){ echo "<option value=\"0\">No Data</option>";}
			foreach($vectordemand as $aux)
				{
				if (($aux['nom_demand']==$demandaproject) || ($i==0))
						{$selected="selected";}
				else{$selected="";}
				echo "<option $selected value='".$aux['nom_demand']."'>".$aux['nom_demand']."</option>";
				if($i==0)
					{
					$aux1=$aux['observacio'];
					}
					$i++;
				}
		?>
		</select></td>
		<!--<td><input style="margin:12px 0 12 px 0;font-size:18px;padding:4px;" type="button" class="btn blue" value="Consult Demands" onclick="location='formularioconsultademanda.php?t=Inici'">-->
		<td><div  style="width:200px;" name="observation" id="observation"></div></td>
		</td>
		<td><input style="margin:12px 0 12 px 0;font-size:18px;padding:4px;" type="button" class="<?php echo "$tipobtn";?>" value="Add Demand" onclick="location='formularionuevademanda.php?t=New Demand Tipology&projh=<?php echo $projh;?>'" <?php echo "$textbutton";?>>
		</td>
		<tr>
		<!--<td><label>Number of homes</label></td><td><input type="text" name="numhomes" id="numhomes" style="width:100px;" value="<?php echo $lastnumhomes;?>"></td>-->
		</tr>
   
		<tr><td></td><td></td><td></td>
						 
		</tr>					
						
							
		<tr>
                <th class="align-left">  Use</th>
                <th class="align-left">Demand (kwh/year)</th>
				<th class="align-left">Supply Temperature (&#176C)</th>
                </tr>
							

			
					<tr>
					
					<td><div  style="width:200px;">Heating</div></td>
					<td><input type="text" name="heatingdemand" id="heatingdemand" style="width:100px;" value="<?php echo $lastheatingdemand;?>" onchange="javascript:sumar(this)"></td>
					<td><input type="text" name="heatingtemp" id="heatingtemp" style="width:100px;" value="<?php echo $lastheatingtemp;?>">&nbsp;&nbsp;&nbsp;<input type=image src="images/info.png" width="20" height="20"  onclick="popup_window_show('#popup_window_id_CD1', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;"></td>
								
					</tr>

					<tr>
					
					<td><div  style="width:200px;">Hot Water</div></td>
					<td><input type="text" name="hotwaterdemand" id="hotwaterdemand" style="width:100px;" value="<?php echo $lasthotwaterdemand;?>" onchange="javascript:sumar(this)"></td>
					<td><input type="text" name="hotwatertemp" id="hotwatertemp" style="width:100px;" value="<?php echo $lasthotwatertemp;?>">&nbsp;&nbsp;&nbsp;<input type=image src="images/info.png" width="20" height="20" onclick="popup_window_show('#popup_window_id_CD2', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;"></td>
								
					</tr>
<tr>
					
					<td><div  style="width:200px;">Cooling</div></td>
					<!--<td><input type="text" name="coolingdemand" id="coolingdemand" style="width:100px;" value="<?php echo $lastcoolingdemand;?>" onchange="javascript:sumar(this)"></td>
					<td><input type="text" name="coolingtemp" id="coolingtemp" style="width:100px;" value="<?php echo $lastcoolingtemp;?>">&nbsp;&nbsp;&nbsp;<input type=image src="images/info.png" width="20" height="20" onclick="popup_window_show('#popup_window_id_CD3', { pos : 'tag-top-right', parent : this, x : 0, y : 0, width : 'auto' }); return false;"></td>
					-->
					<td><div name="coolingdemand" id="coolingdemand" style="width:100px;" value="<?php echo $lastcoolingdemand;?>" onchange="javascript:sumar(this)"></div></td>
					<td><div name="coolingtemp" id="coolingtemp" style="width:100px;" value="<?php echo $lastcoolingtemp;?>"></div></td>
	
					</tr>
<tr>
					
					<td><div  style="width:200px;">Electric appliances</div></td>
					<td><div name="electricappdemand" id="electricappdemand" style="width:100px;" value="<?php echo $lastelectricappdemand;?>" onchange="javascript:sumar(this)"></div></td>
					<td></td>
								
					</tr>
					
					<tr>
					
					<td><div  style="width:200px;">Total</div></td>
					<td><div  style="width:200px;" name="suma" id="suma"><?php echo $suma;?></div></td>
					<td><div  style="width:200px;"></div></td>
					<!--<td><div  style="width:200px;" name="dis4" id="dis4">P</div>	</td>-->		
					</tr>		
						
						
					</table>
					
<br><br>
							
							
							
							

						<!--<H2>
						<input type="radio" name="eleccio" value="1" checked>Heating
						<input type="radio" name="eleccio" value="2">Hot Water
						<input type="radio" name="eleccio" value="3">Cooling
						<input type="radio" name="eleccio" value="4">Electric appliances
						</H2>-->
						<input style="margin:12px 0 12 px 0;font-size:18px;padding:4px;" type="submit" name="heating" id="heating" class="btn <?php echo $auxcolor1; ?>" value="Heating" >
						<input style="margin:12px 0 12 px 0;font-size:18px;padding:4px;" type="submit" name="hotwater" id="hotwater" class="btn <?php echo $auxcolor2; ?>" value="Hot Water" >
						<!--<input style="margin:12px 0 12 px 0;font-size:18px;padding:4px;" type="btn grey" name="cooling" id="cooling" class="btn <?php echo $auxcolor3; ?>" value="Cooling" >
						<input style="margin:12px 0 12 px 0;font-size:18px;padding:4px;" type="btn grey" name="electricapp" id="electricapp" class="btn <?php echo $auxcolor4; ?>" value="Electric Appliances" >
						-->
						<input style="margin:12px 0 12 px 0;font-size:18px;padding:4px;weight=50px;" type="button" class="btn grey" name="cooling" id="cooling"  value="Cooling" >
						<input style="margin:12px 0 12 px 0;font-size:18px;padding:4px;weight=50px;" type="button" class="btn grey" name="electricapp" id="electricapp"  value="Electric Appliances" >
	
						<!--<a href="gestio_dades_solar.php?t=Components Details&projh=<?php echo $projh;?>" class="btn grey right" style="margin:12px 0 12 px 0;font-size:18px;padding:4px;" disabled="true">Cooling</a></td>
						<a href="gestio_dades_solar.php?t=Components Details&projh=<?php echo $projh;?>" class="btn grey right" style="margin:12px 0 12 px 0;font-size:18px;padding:4px;" disabled="true">Hot Water</a></td>
						-->
						
						<input type="submit"  name="submit" id="submit" value="Next" <?php echo $auxbtnvalidar;?>>
						<input type="hidden" name="dis4" id="dis4">
						<input type="hidden" name="dis5" id="dis5">
						<input type="hidden" name="dis6" id="dis6">
						<input type="hidden" name="dis7" id="dis7">
						<input type="hidden" name="localitat" id="localitat" value="<?=$localitat ?>">
						<input type="hidden" name="projh" id="projh" value="<?php echo $projh;?>">
						<input type="hidden" name="numhomes" id="numhomes" value="<?=$numhomes ?>">
						<input type="hidden" name="coolingdemand" id="coolingdemand" value=0>
						<input type="hidden" name="coolingtemp" id="coolingtemp" value=0>
						<input type="hidden" name="electricappdemand" id="electricappdemand" value=0>
						<!--<input type="hidden" name="" id="" value="<?=$numhomes ?>">
						<input type="hidden" name="" id="" value="<?=$numhomes ?>">
						<input type="hidden" name="" id="" value="<?=$numhomes ?>">-->
						
                    
	         
			 
			 </form>






		<div class="clear"></div>
            </div>
        </div>
    </div>

    <div class="clear"></div>
    <?php
	if (isset($_GET['error_delete'])) { 
	?>
					<div id="div_errors">
						<div class="msg failure">
							<span id="missatge_err">No es possible borrar aquest projecte ja que te altres elements associats.</span>            
						</div>
					</div>
	<?php } 
	if(isset($_GET['mensaje'])){
?>
		<script type="text/javascript">
		alert('Empty Values!');
		</script>
		<?php
		}
	
	
	
	
	?> 




<script>  

function rellenar(){

	var jaux = $('select[name=demands]').val();
	//var jpais;
	//var jlatit;
	//var jlong;
	//var arrayJS=<?php echo json_encode($vectordemand) ?>;
	var arrayAux=<?php echo json_encode($vectorlocaux) ?>;
	var jaux1;
	var jaux2;
	var jaux3;
	var jaux4;
	//for(var i=0;i<arrayJS.length;i++)
	//{
	//	if(arrayJS[i]['nom_demand']==jaux){
			//document.write("<br>"+arrayJS[i]['COP']);
			//jpais=arrayJS[i]['pais'];
			//jlatit=arrayJS[i]['latitut'];
			//jlong=arrayJS[i]['longitut'];			
	//		}		
    	
	//$("#pais").html(jpais);
	//$("#latit").html(jlatit);
	//$("#long").html(jlong);
	//$("#newpais").val(document.getElementById("locals").value);
	//iniciarmapa(jlatit,jlong);
	//}
		for (var j=0;j<arrayAux.length;j++)
			{
			if(arrayAux[j]['localitat']==jaux)
				{
				var jobs=arrayAux[j]['observacio'];
				$("#observation").html(jobs);
				}
			var jaux5=arrayAux[j]['discompleta'];
			if(arrayAux[j]['localitat']==jaux && arrayAux[j]['tipusdis']==4)
				{
				if(arrayAux[j]['discompleta']==0)
					{
					jaux1=1;
					//$("#color1").html("red");
					$("#heating").removeClass();
					$("#heating").addClass("btn red");
					
					}
				else
					{
					jaux1=0;
					//$("#color1").html("green");
					$("#heating").removeClass();
					$("#heating").addClass("btn green");
					
					}
				
				//var j4=arrayAux[j]['discompleta'];
				//document.getElementsByName("dis4").value = j4;
				$("#dis4").val(jaux5);
				}
			if(arrayAux[j]['localitat']==jaux && arrayAux[j]['tipusdis']==5)
				{
				if(arrayAux[j]['discompleta']==0)
					{
					jaux2=1;
					//$("#color2").html("red");
					$("#hotwater").removeClass();
					$("#hotwater").addClass("btn red");
					
					}
				else
					{
					jaux2=0;
					//$("#color2").html("green");
					$("#hotwater").removeClass();
					$("#hotwater").addClass("btn green");
					}
				$("#dis5").val(jaux5);
				//var j5=arrayAux[j]['discompleta'];
				//document.getElementsByName("dis5").value = j5;
				}
			if(arrayAux[j]['localitat']==jaux && arrayAux[j]['tipusdis']==6)
				{
				if(arrayAux[j]['discompleta']==0)
					{
					jaux3=1;
					//$("#color3").html("red");
					//$("#cooling").removeClass();
					//$("#cooling").addClass("btn red");
					}
				else
					{
					jaux3=0;
					//$("#color3").html("green");
					//$("#cooling").removeClass();
					//$("#cooling").addClass("btn green");
					}
				$("#dis6").val(jaux5);
				//var j6=arrayAux[j]['discompleta'];
				//document.getElementsByName("dis6").value = j6;
				}
			if(arrayAux[j]['localitat']==jaux && arrayAux[j]['tipusdis']==7)
				{
				if(arrayAux[j]['discompleta']==0)
					{
					jaux4=1;
					//$("#color3").html("red");
					//$("#electricapp").removeClass();
					//$("#electricapp").addClass("btn red");
					}
				else
					{
					jaux4=0;
					//$("#color3").html("green");
					//$("#electricapp").removeClass();
					//$("#electricapp").addClass("btn green");
					}
				$("#dis7").val(jaux5);
				//var j7=arrayAux[j]['discompleta'];
				//document.getElementsByName("dis7").value = j7;
				}
			}
			var jaux10=jaux1+jaux2+jaux3+jaux4;
			//$('#suma').html(jaux10);
			if(jaux10==4)
					{
					$('#submit').attr('disabled',false);
					$("#submit").removeClass();
					$("#submit").addClass("btn red");
					}
			else
				{
				$('#submit').attr('disabled',false);
				$("#submit").removeClass();
				$("#submit").addClass("btn blue");
				}
}            
</script>
<script>
   function sumar(sel) {
      var value = parseFloat(sel.value);
      var jsum1=parseFloat($('#heatingdemand').val());
	  var jsum2=parseFloat($('#hotwaterdemand').val());
	  var jsum3=parseFloat($('#coolingdemand').val());
	  var jsum4=parseFloat($('#electricappdemand').val());
	  //var jsum5=jsum1+jsum2+jsum3+jsum4;
	  var jsum5=jsum1+jsum2;
	  $('#suma').html(jsum5);
	 
   }
</script>

<script type="text/javascript">
   function informacion1(){
	var jaux="According to your distribution system next values are reomended:";
	alert(jaux);
   
   }
   function informacion2(){
	var jaux="Gracias por pulsarme, el valor recomendado es:"+<?php echo $valorrefdemand2;?>;
	alert(jaux);
   
   }
   function informacion3(){
	var jaux="Gracias por pulsarme, el valor recomendado es:"+<?php echo $valorrefdemand3;?>;
	alert(jaux);
   
   }
</script>
<script language=javascript>
function ventanaSecundaria (URL){
   window.open(URL,"ventana1","width=120,height=300,scrollbars=NO")
}
</script> 

<?php include("footer.php") ?>
