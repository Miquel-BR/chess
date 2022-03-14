<?php

include('header.php');
// INCLUDES
require_once("class/gestio_projectesBBDD.php");
require_once("class/graficos.php");
require("./class/projectes.php");
require("./class/calculs.php");
require("./class/resultats.php");

gestio_projectesBBDD::setup();
if(isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}
$projecte=$projh;
$aux=projectes::getprojecteactualdades($projecte);
$localitat=$aux['localitat'];
$demanda=$aux['nomdemanda'];
	
$nomarchivoDT=$projecte.'.txt';

?>
<ul class="breadcrumbs first">
    <li><a href="#">Energy Heat Pump</a></li>
    <li class="active"><a href="#">Data & Graphics </a></li>
</ul>


<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Data & Graphics </h2>
    </div>
    <div class="widget_body">

	<form name="validacio" method="POST" action="ResultHeatPump.php?t=Graphics&projh=<?php echo $projh;?>" id="validacio">

	<!--<td><img src="grafico_barra4.php?<?php echo "varTemp1=$vserTemp1&varTemp2=$vserTemp2";?>" alt="" border="0"></td></tr>-->
	<td><img src="grafico_barra8.php?<?php echo "nomarchivo=$nomarchivoDT";?>" alt="" border="0"></td></tr>


	</table>
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