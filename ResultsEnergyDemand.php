<?php

include('header.php');
// INCLUDES
require_once("class/gestio_projectesBBDD.php");
require_once("class/graficos.php");
require("./class/projectes.php");
require("./class/calculs.php");

gestio_projectesBBDD::setup();
if(isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}
$projecte=$projh;

$aux=projectes::getprojecteactualdades($projecte);
//$projecte=$aux['nomproject'];
$localitat=$aux['localitat'];
$demanda=$aux['nomdemanda'];

	
	$mysqli=new mysqli('localhost','root','','scacs2');
	if(mysqli_connect_errno()){$texto="No db";}
	$query2="select * from projectedemandes where projecte='$projecte'";
	$result2=$mysqli->query($query2);
	//while ($row=$result2->fetch_assoc()){
	while($row = $result2->fetch_object()){
            $auxheat=$row->heatingdemand;
			$auxhotwater=$row->hotwaterdemand;
			$auxcool=$row->coolingdemand;
			$auxelec=$row->electricappdemand;
            $numviviendas=$row->numhomes;
        } 

$DTHeating=calculs::obtenerDTmensual($projecte,4,$localitat);
$DTHotwater=calculs::obtenerDTmensual($projecte,5,$localitat);
$i=1;

foreach($DTHeating as $ar)
	{
	$aux[$i]=$ar;
	$i++;
	}
$i=1;
foreach($DTHotwater as $ar)
	{
	$DTTotal[$i]=($aux[$i]+$ar);
	$i++;
	}
	
//session_start();
$vserDTTotal=serialize($DTTotal);
$vserDTHeating=serialize($DTHeating);
$vserDTHotwater=serialize($DTHotwater);

?>
<ul class="breadcrumbs first">
    <li><a href="#">Energy Demand</a></li>
    <li class="active"><a href="#">Data & Graphics </a></li>
</ul>


<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Data & Graphics </h2>
    </div>
    <div class="widget_body">

	<form name="validacio" method="POST" action="ResultEnergyDemand.php?t=Graphics&projh=<?php echo $projh;?>" id="validacio">
	<table>

	<table><tr><td style="border:2px solid green;"><strong><big>Use</big></strong></td><td style="border:2px solid green;"><strong><big>Demand (Kwh/year)</big></strong></td><td style="width:500px;"></td><td></td></tr><tr><td>Heating</td><td><?php echo $auxheat;?></td><td style="width:500px;"></td></tr><tr><td>Hot Water</td><td><?php echo $auxhotwater;?></td><td style="width:500px;"></td></tr><tr><td>Cooling</td><td></td><td style="width:500px;"></td></tr><tr><td>Electric Appliances</td><td></td><td style="width:500px;"></td></tr><tr><td>Total:</td><td></td><td style="width:500px;"></td></tr>
	</table>
	<td><img src="grafico_barra3.php?<?php echo "varpaso1=$vserDTTotal&varpaso2=$vserDTHeating&varpaso3=$vserDTHotwater";?>" alt="" border="0"></td></tr>
		<!--<input type="hidden" name="nomdistribucioselected" id="nomdistribucioselected" value="<?php echo $iddistribucio; ?>">
		<input type="hidden" name="iddistribucio" id="iddistribucio" value="<?php echo $iddistribucio;?>">
		<input type="hidden" name="localitatsgrafiques" id="localitatsgrafiques" value="<?php echo $sendlocalitat;?>">-->
		<!--<input type="hidden" name="tipograf" id="tipograf" value="<?php echo $tipografico;?>">-->
		<!--<input type="hidden" name="mesgraf" id="mesgraf" value="<?php echo $mesgraf;?>">-->
		<!--<input type="hidden" name="tipusdis" id="tipusdis" value="<?php echo $tipusdis;?>">-->

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