<?php
if(isset($_GET['sidebar'])){
    include('s_header.php');
} else {
    include('header.php');
}
?>




<?php
error_reporting(0);
//session_start();
$aux=$_SESSION['usuari'];
// INCLUDES
require_once("./class/gestio_projectesBBDD.php");
require_once("./class/localitat.php");
require_once("./class/usuari.php");
require_once("./scripts/jvscriptevents.php");
require_once("./class/projectes.php");
require_once("./class/botones.php");
require_once("./class/usuari.php");
$tipouser=usuari::gettipousuari($aux);
if($tipouser==2){$textbutton="disabled";$tipobtn="btn grey";}
else {$textbutton="";$tipobtn="btn";}

$sendlocalitat="";$sendlongitut=2.00;$sendlatitut=43.00;$envio="";
if (isset($_POST['localitat'])) {
	$sendlocalitat=$_POST['localitat'];
	$sendlongitut=$_POST['longitut'];
	$sendlatitut=$_POST['latitut'];
	$projh=$_POST['projh'];
	$envio="post";
	
} 
if (isset($_GET['localitat'])){
	$sendlocalitat=$_GET['localitat'];
	$sendlongitut=$_GET['longitut'];
	$sendlatitut=$_GET['latitut'];
	$projh=$_GET['projh'];
	$envio="get";
	}



gestio_projectesBBDD::setup();

$numloc=localitat::numlocalitats();
$vectorloc=localitat::consultalocalitats();
$localitatdefecte=localitat::getlocalitatproject();
$selected="";
//print_r($vectorloc);
//Parte en la que checkeamos si existen las distribiciones para tipus 1, 2 y 3
//necesitamos localitat $sendlocalitat, $projecte, $tipusdis, $mes
//$aux=projectes::getprojecteactual();
//$projecte=$aux['nomproject'];
$projecte=$projh;


//$projecte=$_SESSION['projecte'];
$vectorlocaux=localitat::getlocalitatdisproject($projecte);
//print_r($vectorlocauxref);
$numvectorlocaux=count($vectorlocaux)-1;
//print_r($vectorlocaux);

$auxbtn1=botones::checkanualdisloc(1,$localitatdefecte['localitat'],$projecte);
$auxbtn2=botones::checkanualdisloc(2,$localitatdefecte['localitat'],$projecte);
$auxbtn3=botones::checkanualdisloc(3,$localitatdefecte['localitat'],$projecte);
$auxbtn8=botones::checkanualdisloc(8,$localitatdefecte['localitat'],$projecte);
//print_r($auxbtn1);
if($auxbtn1[0]['count']<12){$auxcolor1="red";}
	else{
	$auxcolor1="green";
	for($i=1;$i<=12;$i++)
		{
		$auxbtn11=botones::checkmesdisloc(1,$localitatdefecte['localitat'],$i,$projecte);
		//print_r($auxbtn11);
		if($auxbtn11[0]['count']<24)
				{
				$auxcolor1="red";
				//funciones de con vectrolocaux para ref. 
				}
		}
	}

if($auxbtn2[0]['count']<12){$auxcolor2="red";}
	else{
		$auxcolor2="green";
		for($i=1;$i<=12;$i++)
			{
			$auxbtn22=botones::checkmesdisloc(2,$localitatdefecte['localitat'],$i,$projecte);
			if($auxbtn22[0]['count']<24){$auxcolor2="red";}
		}
	}
	
if($auxbtn3[0]['count']<12){$auxcolor3="red";}else{
	$auxcolor3="green";
	for($i=1;$i<=12;$i++)
		{
		$auxbtn33=botones::checkmesdisloc(3,$localitatdefecte['localitat'],$i,$projecte);
		if($auxbtn33[0]['count']<24){$auxcolor3="red";}
		}
	}
if($auxbtn8[0]['count']<12){$auxcolor8="red";}else{
	$auxcolor8="green";
	for($i=1;$i<=12;$i++)
		{
		$auxbtn88=botones::checkmesdisloc(8,$localitatdefecte['localitat'],$i,$projecte);
		if($auxbtn88[0]['count']<24){$auxcolor8="red";}
		}
	}
$auxcolorref1=" red\" disabled";$auxcolorref2=" red\" disabled";$auxcolorref3=" red\" disabled";$auxcolorref4=" red\" disabled";


$countaux1=$auxbtn1[0]['count'];
$countaux2=$auxbtn2[0]['count'];
$countaux3=$auxbtn3[0]['count'];
$countaux8=$auxbtn8[0]['count'];
if($auxcolor1=="green" && $auxcolor2=="green" && $auxcolor3=="green" && $auxcolor8=="green")
	{
	$auxbtnvalidar=" class=\"btn blue\"";
	}
else{$auxbtnvalidar=" class=\"btn red\" disabled";}

//echo "$auxbtnvalidar,$auxcolor1,$auxcolor2,$auxcolor2,$auxcolor8,".$localitatdefecte['localitat'].",".$projecte.",".$auxbtn3[0]['count'].",".$auxbtn8[0]['count'];
//$aux=iniciarmapa($senlatitut,$sendlongitut);
$auxmap1=45;$auxmap2=44;
$localitatinicial=localitat::getlocalitatproject2($projh);
$auxx=$localitatinicial['localitat'];

if($localitatinicial['localitat']!=null){$auxmap1=$localitatinicial['latitut'];$auxmap2=$localitatinicial['longitut'];}

$vectorlocauxref=localitat::getlocalitatdisref($auxx);
$dis1="";$dis2="";$dis3="";$dis8="";
if($auxcolor1=="red"){if($vectorlocauxref[0]['discompleta']!=0){$auxcolorref1="green";$dis1=$vectorlocauxref[0]['discompleta'];}}
if($auxcolor2=="red"){if($vectorlocauxref[1]['discompleta']!=0){$auxcolorref2="green";$dis2=$vectorlocauxref[1]['discompleta'];}}
if($auxcolor3=="red"){if($vectorlocauxref[2]['discompleta']!=0){$auxcolorref3="green";$dis3=$vectorlocauxref[2]['discompleta'];}}
if($auxcolor8=="red"){if($vectorlocauxref[3]['discompleta']!=0){$auxcolorref4="green";$dis8=$vectorlocauxref[3]['discompleta'];}}


?>

<script>
	$(function{iniciarmapa(<?php echo $auxmap1;?>,<?php echo $auxmap2;?>);};

</script>




<ul class="breadcrumbs">
    <!--<li><a href="#">Managament</a></li>-->
    <li><a href="home.php?t=Choose Project">Project Choice</a></li>
    <li class="active"><a href="#">Location Choice</a></li>
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
		<li>  Climate condition definition is based on the location of your project.

For site selection, provide the name, country, latitude and longitude. 

For radiation, air temperature, ground temperature and irradiation; fill in required data related to the climate. Some existing libraries might be of your interest at this stage. </li>
            </ul>
            </div>
        </div>
    </div>
</div>
    <div class="grid_16 widget first">
        <div class="widget_title clearfix">
            <h2>Data Introduction </h2>
        </div>
        <div class="widget_body">
                <div id="table1">
		<form method="POST" action="validarlocalizaciones.php?t=Inici&projh=<?php echo $projh;?>">
                <table class='simple'>
                    
						 
							
						
							
			<tr>
                <th class="align-left">Place</th>
                <th class="align-left">Country</th>
				<th class="align-left">Latitude</th>
                            <th class="align-left">Longitude</th>
                                    
                            </tr>
							

			
					<tr><td>
					<select id="locals" style="width:200px;" name="locals" onChange="rellenar()">
					<!--<select id="locals" style="haight:50px; width:200px;" name="locals" value="Select option:" onchange="location='validarlocalizaciones.php?t=Inici'">-->
					<?php			
					
					$i=0;
								foreach($vectorloc as $aux)
									{
									$auxx=$aux['nom_localitzacio'];
									
									if (($aux['nom_localitzacio']==$localitatdefecte['localitat']) || ($i==0))
										{$selected="selected";}
									else{$selected="";}
									echo "<option $selected value='".$aux['nom_localitzacio']."'>".$aux['nom_localitzacio']."</option>";
									if($selected!="")
										{
										$aux1=$aux['pais'];$aux2=$aux['latitut'];$aux3=$aux['longitut'];
										}
									$i++;
									}
									?>
								<script>
									$(function{iniciarmapa(<?php echo $aux2;?>,<?php echo $aux3;?>);};
									//$(function{rellenar2(<?php echo $auxx;?>);};
								</script>
								</select></td>
								<td><div id="pais" name="pais" style="width:100px;"><?php echo $aux1;?></div></td>
								<td><div id="latit" name="latit" style="width:100px;"><?php echo $aux2;?></div></td>
								<td><div id="long" name="long" style="width:100px;"><?php echo $aux3;?></div></td>
								
							<!--	</tr>
							
							<tr style="height:50px;"><td></td><td></td></td></td><td></td></tr>
							<tr><td></td><td></td></td></td><td></td></tr>
							
							<tr><td></td><td></td><td></td>-->
							<td>
							<!--<input style="margin:12px 0 12 px 0;font-size:18px;padding:4px;" type="button" value="Add Clima" onclick="location='formularionuevalocalizacion.php?t=Inici'">-->
							<input type="button" class="<?php echo "$tipobtn";?>" value="Add Clima" onclick="location='formularionuevalocalizacion.php?t=New Clima&projh=<?php echo $projh;?>'" <?php echo "$textbutton";?>>
							</td>
							<td>
							<div id="mostrar" name="mostrar" style="width:100px;">
							</td>
							</tr>
							
							
						
					</table>
					
<br><br>
							<!--<label>Place:</label><label><?php echo $sendlocalitat; ?></label><br>
							<label>Latitude:</label><label><?php echo $sendlatitut; ?></label><br>
							<label>Longitude:</label><label><?php echo $sendlongitut; ?></label><br>-->
						
							
							
							
						<br>
						<!--<label>Choosed Place:</label><br><br>-->
						
							<!--<input style="margin:12px 0 12 px 0;font-size:18px;padding:4px;" type="button" value="Cargar mapa" onclick="iniciarmapa(<?php echo $sendlatitut.",".$sendlongitut; ?>)">
						<br>-->
						
						 <div id="map3" style="width:360px;height:200px;border:2px solid violet;"></div>
						<br><br>
						<input style="margin:12px 0 12 px 0;font-size:14px;padding:4px;" type="submit" name="radiationref" id="radiationref" class="btn <?php echo $auxcolorref1; ?>" value="Radiation Ref" >
						<input style="margin:12px 0 12 px 0;font-size:14px;padding:4px;" type="submit" name="airtempref" id="airtempref" class="btn <?php echo $auxcolorref2; ?>" value="Air Temperature Ref" >
						<input style="margin:12px 0 12 px 0;font-size:14px;padding:4px;" type="submit" name="airgroundref" id="airgroundref" class="btn <?php echo $auxcolorref3; ?>" value="Ground Temperature Ref" >
						<input style="margin:12px 0 12 px 0;font-size:14px;padding:4px;" type="submit" name="irradiationref" id="irradiationref" class="btn <?php echo $auxcolorref4; ?>" value="Irradiation Ref" >
						<input type="submit"  name="btnreset" id="btnreset" value="Reset" >
						
						<br><br>
						<input style="margin:12px 0 12 px 0;font-size:18px;padding:4px;" type="submit" name="radiation" id="radiation" class="btn <?php echo $auxcolor1; ?>" value="Radiation" >
						<input style="margin:12px 0 12 px 0;font-size:18px;padding:4px;" type="submit" name="airtemp" id="airtemp" class="btn <?php echo $auxcolor2; ?>" value="Air Temperature" >
						<input style="margin:12px 0 12 px 0;font-size:18px;padding:4px;" type="submit" name="airground" id="airground" class="btn <?php echo $auxcolor3; ?>" value="Ground Temperature" >
						<input style="margin:12px 0 12 px 0;font-size:18px;padding:4px;" type="submit" name="irradiation" id="irradiation" class="btn <?php echo $auxcolor8; ?>" value="Irradiation" >

						<!--<td><div id="color1" name="color1" style="width:200px;">Hola</div></td>-->
						<!--<td><div id="color2" name="color2" style="width:200px;">Hola</div></td>-->
						<!--<td><div id="color3" name="color3" style="width:200px;">Hola</div></td>-->
						<input type="submit"  name="btnsubmit" id="btnsubmit" value="Next" <?php echo $auxbtnvalidar;?> >
						<!--<div id="wait" name="wait"><label> </label></div>-->
						<!--<input type="text" name="colorbtn" id="colorbtn" style="width:50px;">-->
						<input type="hidden" name="dis1" id="dis1" value="<?php echo $dis1;?>">
						<input type="hidden" name="dis2" id="dis2" value="<?php echo $dis2;?>">
						<input type="hidden" name="dis3" id="dis3" value="<?php echo $dis3;?>">
						<input type="hidden" name="dis8" id="dis8" value="<?php echo $dis8;?>">
						
						<br><br>
                   
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
	?> 


<script src="http://maps.google.com/maps/api/js?sensor=false">
</script>
<script async defer
<script 
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7n4DAEixRm8Z3KWGDfz6-5gd8CN7ecUA&callback=initMap" >
 </script>
 
 <script type="text/javascript">
function iniciarmapa(lat,lng) {
var mapOptions = {
center: new google.maps.LatLng(lat, lng),
zoom: 10,
mapTypeId: google.maps.MapTypeId.ROADMAP};
var map = new google.maps.Map(document.getElementById("map3"),mapOptions);} 
$( document ).ready( iniciarmapa(<?php echo $auxmap1;?>,<?php echo $auxmap2;?>) );




function rellenar(){
	
	var jaux = $('select[name=locals]').val();
	var jpais;
	var jlatit;
	var jlong;
	var jaux1=0;
	var jaux2=0;
	var jaux3=0;
	var jaux8=0;
	var arrayJS=<?php echo json_encode($vectorloc) ?>;
	var arrayAux=<?php echo json_encode($vectorlocaux) ?>;
	for(var i=0;i<arrayJS.length;i++)
	{
		if(arrayJS[i]['nom_localitzacio']==jaux){
			//document.write("<br>"+arrayJS[i]['COP']);
			jpais=arrayJS[i]['pais'];
			jlatit=arrayJS[i]['latitut'];
			jlong=arrayJS[i]['longitut'];			
			}		
    	
	$("#pais").html(jpais);
	$("#latit").html(jlatit);
	$("#long").html(jlong);
	$("#newpais").val(document.getElementById("locals").value);
	iniciarmapa(jlatit,jlong);
	//$("#color1").html("green");
	}
	for (var j=0;j<arrayAux.length;j++)
			{
			var jaux5=arrayAux[j]['discompleta'];
			if(arrayAux[j]['localitat']==jaux && arrayAux[j]['tipusdis']==1)
				{
				var jauxmostrar=arrayAux[j]['discompleta'];
				if(arrayAux[j]['discompleta']==0)
					{
					jaux1=1;
					//$("#color1").html("red");
					$("#radiationref").removeClass();
					$("#radiationref").addClass("btn red");
					}
				else
					{
					jaux1=0;
					//$("#color1").html("green");
					$("#radiationref").removeClass();
					$("#radiationref").addClass("btn green");
					}
				$("#dis1").val(jaux5);
				//$("#mostrar").html(jauxmostrar);
				}
			if(arrayAux[j]['localitat']==jaux && arrayAux[j]['tipusdis']==2)
				{
				var jauxmostrar=arrayAux.length;
				
				if(arrayAux[j]['discompleta']==0)
					{
					jaux2=1;
					//$("#color2").html("red");
					$("#airtempref").removeClass();
					$("#airtempref").addClass("btn red");
					}
				else
					{
					jaux2=0;
					//$("#color2").html("green");
					$("#airtempref").removeClass();
					$("#airtempref").addClass("btn green");
					}
				$("#dis2").val(jaux5);
				//$("#mostrar").html(jauxmostrar);
				}
			if(arrayAux[j]['localitat']==jaux && arrayAux[j]['tipusdis']==3)
				{
				if(arrayAux[j]['discompleta']==0)
					{
					jaux3=1;
					//$("#color3").html("red");
					$("#airgroundref").removeClass();
					$("#airgroundref").addClass("btn red");
					}
				else
					{
					jaux3=0;
					//$("#color3").html("green");
					$("#airgroundref").removeClass();
					$("#airgroundref").addClass("btn green");
					}
				$("#dis3").val(jaux5);
				}
			if(arrayAux[j]['localitat']==jaux && arrayAux[j]['tipusdis']==8)
				{
				if(arrayAux[j]['discompleta']==0)
					{
					jaux8=1;
					//$("#color1").html("red");
					$("#irradiationref").removeClass();
					$("#irradiationref").addClass("btn red");
					}
				else
					{
					jaux8=0;
					//$("#color1").html("green");
					$("#irradiationref").removeClass();
					$("#irradiationref").addClass("btn green");
					}
				$("#dis8").val(jaux5);
				}
			}
			var jaux10=jaux1+jaux2+jaux3+jaux8;
			//$("#colorbtn").val(jaux10);
			if(jaux10==0)
					{
					$("#submit").attr('disabled',false);
					$("#submit").removeClass();
					$("#submit").addClass("btn blue");
					}
			else
				{
				$("#submit").attr('disabled',true);
				$("#submit").removeClass();
				$("#submit").addClass("btn red");
				}
			
			
	
	
}   

function rellenar2(jlocalitat){
	
	var jaux = jlocalitat;
	var jpais;
	var jlatit;
	var jlong;
	var jaux1=0;
	var jaux2=0;
	var jaux3=0;
	var jaux8=0;
	var arrayJS=<?php echo json_encode($vectorloc) ?>;
	var arrayAux=<?php echo json_encode($vectorlocaux) ?>;
	for(var i=0;i<arrayJS.length;i++)
	{
		if(arrayJS[i]['nom_localitzacio']==jaux){
			//document.write("<br>"+arrayJS[i]['COP']);
			jpais=arrayJS[i]['pais'];
			jlatit=arrayJS[i]['latitut'];
			jlong=arrayJS[i]['longitut'];			
			}		
    	
	$("#pais").html(jpais);
	$("#latit").html(jlatit);
	$("#long").html(jlong);
	$("#newpais").val(document.getElementById("locals").value);
	iniciarmapa(jlatit,jlong);
	//$("#color1").html("green");
	}
	for (var j=0;j<arrayAux.length;j++)
			{
			var jaux5=arrayAux[j]['discompleta'];
			if(arrayAux[j]['localitat']==jaux && arrayAux[j]['tipusdis']==1)
				{
				var jauxmostrar=arrayAux[j]['discompleta'];
				if(arrayAux[j]['discompleta']==0)
					{
					jaux1=1;
					//$("#color1").html("red");
					$("#radiationref").removeClass();
					$("#radiationref").addClass("btn red");
					}
				else
					{
					jaux1=0;
					//$("#color1").html("green");
					$("#radiationref").removeClass();
					$("#radiationref").addClass("btn green");
					}
				$("#dis1").val(jaux5);
				//$("#mostrar").html(jauxmostrar);
				}
			if(arrayAux[j]['localitat']==jaux && arrayAux[j]['tipusdis']==2)
				{
				var jauxmostrar=arrayAux.length;
				
				if(arrayAux[j]['discompleta']==0)
					{
					jaux2=1;
					//$("#color2").html("red");
					$("#airtempref").removeClass();
					$("#airtempref").addClass("btn red");
					}
				else
					{
					jaux2=0;
					//$("#color2").html("green");
					$("#airtempref").removeClass();
					$("#airtempref").addClass("btn green");
					}
				$("#dis2").val(jaux5);
				//$("#mostrar").html(jauxmostrar);
				}
			if(arrayAux[j]['localitat']==jaux && arrayAux[j]['tipusdis']==3)
				{
				if(arrayAux[j]['discompleta']==0)
					{
					jaux3=1;
					//$("#color3").html("red");
					$("#airgroundref").removeClass();
					$("#airgroundref").addClass("btn red");
					}
				else
					{
					jaux3=0;
					//$("#color3").html("green");
					$("#airgroundref").removeClass();
					$("#airgroundref").addClass("btn green");
					}
				$("#dis3").val(jaux5);
				}
			if(arrayAux[j]['localitat']==jaux && arrayAux[j]['tipusdis']==8)
				{
				if(arrayAux[j]['discompleta']==0)
					{
					jaux8=1;
					//$("#color1").html("red");
					$("#irradiationref").removeClass();
					$("#irradiationref").addClass("btn red");
					}
				else
					{
					jaux8=0;
					//$("#color1").html("green");
					$("#irradiationref").removeClass();
					$("#irradiationref").addClass("btn green");
					}
				$("#dis8").val(jaux5);
				}
			}
			var jaux10=jaux1+jaux2+jaux3+jaux8;
			//$("#colorbtn").val(jaux10);
			if(jaux10==0)
					{
					$("#submit").attr('disabled',false);
					$("#submit").removeClass();
					$("#submit").addClass("btn blue");
					}
			else
				{
				$("#submit").attr('disabled',true);
				$("#submit").removeClass();
				$("#submit").addClass("btn red");
				}
			
			
	
	
}   

  
         
</script>

<script type="text/javascript">
//<![CDATA[  
google.load('maps', '2' {callback:cargarmapa});var map;	
function cargarmapa(){	
if (GBrowserIsCompatible()) { 
function createMarker(point,html) {
var marker = new GMarker(point);
GEvent.addListener(marker, "click", function() {
marker.openInfoWindowHtml(html);});
return marker;}			
var map = new GMap2(document.getElementById("map3"));
map.addControl(new GLargeMapControl());
map.addControl(new GMapTypeControl());	  
map.setCenter(new GLatLng(23.1311,-82.3726),13);}	  
var point = new GLatLng(23.1351,-82.3598);
var marker = createMarker(point,'<div style="width:240px">El Capitolio de la Habana <a href="http://norfipc.com">Pagina web<\/a> con mas información<\/div>')
map.addOverlay(marker);
var point = new GLatLng(23.1368,-82.3816);
var marker = createMarker(point,'La Universidad de la Habana')
map.addOverlay(marker);}
window.onload=function(){cargarmapa();}
//]]>
</script>




<?php include("footer.php") ?>
