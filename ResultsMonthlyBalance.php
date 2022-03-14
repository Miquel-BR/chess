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
//Preparar para las tablas


	$nomarchivo=$nomarchivoDT;
	//$arrayTemp=resultats::leerarchivotemps($nomarchivoDT);
	
	$filas=file($nomarchivo); 

	$i=0; $k=0;
	$numero_fila=0; 
	$arrayTemp = array("year","mes","BalanceDT","Pdistr","DT","Est","Ee","Qaux");
	while($filas[$i]!=NULL && $i<=17519){ 
		$row = $filas[$i]; 
		$sql = explode("|",$row);
		if($i>8760){
			$arrayTemp[$k]=array("year"=>$sql[4],"mes"=>$sql[3],"BalanceDT"=>$sql[41],"Pdistr"=>$sql[9],"DT"=>$sql[5],"Est"=>$sql[36],"Ee"=>$sql[38],"Qaux"=>$sql[40]);
			$k++;
			}
		$i++;
		}
//$i=1;
	$Sum1=0;$Sum2=0;$Sum3=0;$Sum4=0;$mesant=1;$inicio=1;
	foreach ($arrayTemp as $aux)
	{

	
	//leer mes
	$mes=$aux['mes'];
	$BalanceDT=$aux['BalanceDT'];
	$Pdistr=$aux['Pdistr'];
	$DT=$aux['DT'];
	$Est=$aux['Est'];
	$Ee=$aux['Ee'];
	$Qaux=$aux['Qaux'];
	$year=$aux['year'];
	
	if($mes==$mesant)
		{
		$Sum1=$Sum1+$DT;
		$Sum2=$Sum2+$Est;
		$Sum3=$Sum3+$Ee;
		$Sum4=$Sum4+$Qaux;
		
		}
	else
		{
		if($inicio==1){
			$Sum1=$Sum1/1000000;
			$Sum2=$Sum2/1000000;
			$Sum3=$Sum3/1000000;
			$Sum4=$Sum4/1000000;
			$datay1=array($Sum1);
			$datay2=array($Sum2);
			$datay3=array($Sum3);
			$datay4=array($Sum4);
			
			$inicio=0;
		}
		else{
			$Sum1=$Sum1/1000000;
			$Sum2=$Sum2/1000000;
			$Sum3=$Sum3/1000000;
			$Sum4=$Sum4/1000000;
			array_push($datay1,$Sum1);
			

			
			array_push($datay2,$Sum2);
			
			array_push($datay3,$Sum3);
			
			array_push($datay4,$Sum4);
			}
		
		$mesant=$mes;
		$Sum1=$DT;
		$Sum2=$Est;
		$Sum3=$Ee;
		$Sum4=$Qaux;
	
		}
	
	}
			$Sum1=$Sum1/1000000;
			$Sum2=$Sum2/1000000;
			$Sum3=$Sum3/1000000;
			$Sum4=$Sum4/1000000;
			
			array_push($datay1,$Sum1);
			
			array_push($datay2,$Sum2);
			
			array_push($datay3,$Sum3);
			
			array_push($datay4,$Sum4);
			
	

?>
<ul class="breadcrumbs first">
    <li><a href="#">Energy Monthly Balance</a></li>
    <li class="active"><a href="#">Data & Graphics</a></li>
</ul>


<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Data & Graphics</h2>
    </div>
    <div class="widget_body">

	<form name="validacio" method="POST" action="ResultsMonthlyBalance.php?t=Graphics&projh=<?php echo $projh;?>" id="validacio">

	<!--<td><img src="grafico_barra4.php?<?php echo "varTemp1=$vserTemp1&varTemp2=$vserTemp2";?>" alt="" border="0"></td></tr>-->
	<td><img src="grafico_barra11.php?<?php echo "nomarchivo=$nomarchivoDT";?>" alt="" border="0"></td></tr>


	</table>
    	<h4     >   VALUE TABLE</h4>
	<table style="border:2px solid violet;">
	<?php
	
	echo "<tr style=\"border:2px solid green;\"><th>Variables</th><th>Gen.</th><th>Feb.</th><th>Mar.</th><th>Apr.</th><th>May.</th><th>Jun.</th><th>Jul.</th><th>Agt.</th><th>Spt.</th><th>Oct.</th><th>Nov.</th><th>Dec.</th></tr>";
	$acum="<tr><td>Demand (DT)</td>";
	//for ($i=1;$i<=12;$i++)
	//	{
	//	$aux=('$valor[$i]');
	//	}
	$i=0;
	foreach($datay1 as $val)
		{if($i<12){$acum=$acum."<td style=\"text-align:center;\">".number_format($val,2)."</td>";}
		$i++;
		}
	$acum=$acum."</tr><tr></tr>";
	echo $acum;
		$acum="<tr><td>Energy Solar Panel (Est)</td>";
	//for ($i=1;$i<=12;$i++)
	//	{
	//	$aux=('$valor[$i]');
	//	}
	$i=0;
	foreach($datay2 as $val)
		{if($i<12){$acum=$acum."<td style=\"text-align:center;\">".number_format($val,2)."</td>";}
		$i++;
		}
	$acum=$acum."</tr><tr></tr>";
	echo $acum;
		$acum="<tr><td>Energy Heat Pump (Ee)</td>";
	//for ($i=1;$i<=12;$i++)
	//	{
	//	$aux=('$valor[$i]');
	//	}
	$i=0;
	foreach($datay3 as $val)
		{if($i<12){$acum=$acum."<td style=\"text-align:center;\">".number_format($val,2)."</td>";}
		$i++;
		}
	$acum=$acum."</tr><tr></tr>";
	echo $acum;
		$acum="<tr><td>Energy Auxiliary (Eaux)</td>";
	//for ($i=1;$i<=12;$i++)
	//	{
	//	$aux=('$valor[$i]');
	//	}
	$i=0;
	foreach($datay4 as $val)
		{if($i<12){$acum=$acum."<td style=\"text-align:center;\">".number_format($val,2)."</td>";}
		$i++;
		}
	$acum=$acum."</tr><tr></tr>";
	echo $acum;

	?>
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