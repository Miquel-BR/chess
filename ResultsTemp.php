<?php

include('header.php');
// INCLUDES
require_once("class/gestio_projectesBBDD.php");
require_once("class/graficos.php");
require_once("./class/projectes.php");
require_once("./class/calculs.php");
require_once("./class/resultats.php");

gestio_projectesBBDD::setup();

if(isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}
$projecte=$projh;
$aux=projectes::getprojecteactualdades($projecte);
//$projecte=$aux['nomproject'];
$localitat=$aux['localitat'];
$demanda=$aux['nomdemanda'];
	
$nomarchivoDT=$projecte.'.txt';
//$arrayTemp=resultats::leerarchivotemps($nomarchivoDT);
//vTemp1=array[];
//vTemp2=array[];
$i=0;
//$numarrayTemp=count($arrayTemp);

//foreach ($arrayTemp as $aux)
//	{
	
	//if($i>0){
		//if($i<10){print_r($aux['Ta1']);}
//		$vTemp1[$i]=(float)$aux['Ta1'];
//		$vTemp2[$i]=(float)$aux['Ta2'];
	//}
//	$i++;
//	}
//$numtemp1=count($vTemp1);
//$numtemp2=count($vTemp2);


//$vserTemp1=serialize($vTemp1);
//$vserTemp2=serialize($vTemp2);

?>
<ul class="breadcrumbs first">
    <li><a href="#">Temperature Evolution</a></li>
    <li class="active"><a href="#">Data & Graphics </a></li>
</ul>


<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Data & Graphics </h2>
    </div>
    <div class="widget_body">

	<form name="validacio" method="POST" action="ResultTemp.php?t=Graphics&projh=<?php echo $projh;?>" id="validacio">

	<!--<td><img src="grafico_barra4.php?<?php echo "varTemp1=$vserTemp1&varTemp2=$vserTemp2";?>" alt="" border="0"></td></tr>-->
	<td><img src="grafico_barra4.php?<?php echo "nomarchivo=$nomarchivoDT";?>" alt="" border="0"></td></tr>


	</table>
	<br><br>
	<label><h5>&emsp;SOME TIPS:</h5></label><br>
	<label>&emsp;    -  When the temperature of the seasonal storage system gets values greater than the maximum temperature defined, you must increase <br>&emsp;the size of the seasonal system or reduce the solar panel surface.</label>
	<br>
	<label>&emsp;    -  When the temperature of the buffer is not stable you should increase the buffer tank size, increase the heat pump power or auxiliary<br>&emsp; system power.</label>
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


<?php include("footer.php") ?>