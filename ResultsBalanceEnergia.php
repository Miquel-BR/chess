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

$Dep1=calculs::cargardatosdeposit1($projecte);
$ma1=$Dep1['volumen1']*$Dep1['density'];
$Ce1=$Dep1['heatcapacity'];

$nomarchivoDT=$projecte.'.txt';
$arrayTemp=resultats::leerarchivoenergy($nomarchivoDT);
//vTemp1=array[];
//vTemp2=array[];
$i=1;
$numarrayTemp=count($arrayTemp);
$Ta1=0;
$Ta2=0;
$mesant=1;
$summst1=0;
$summst2=0;
$summst3=0;$summst4=0;$summst5=0;$summst6=0;$summst7=0;$summst8=0;$summst9=0;$summst10=0;$summst11=0;$summst12=0;
$summst13=0;$summst14=0;$summst15=0;$summst16=0;$summst17=0;$summst18=0;$summst19=0;$summst20=0;$summst21=0;$summst22=0;$summst23=0;$summst24=0;
$j=1;$k=1;
$nomarchivoEnBalance=$projecte.'EnergyBalance.txt';
$aux2=resultats::creararchivoDT($nomarchivoEnBalance);
foreach ($arrayTemp as $aux)
	{

	
	//leer mes
	$mes=$aux['mes'];
	$mst1=$aux['mst1'];
	$mst2=$aux['mst2'];
	
	$Ta1=$aux['Ta1'];
	$Ta2=$aux['Ta2'];
	$Est=$aux['Est'];
	$Qa1=$aux['Qa1'];
	$Qa2=$aux['Qa2'];
	$DT=$aux['DT'];
	$Pdistr=$aux['Pdistr'];
	$Qaux=$aux['Qaux'];
	$Pa1=$aux['Pa1'];
	$Pa2=$aux['Pa2'];
	$Ps=$aux['Ps'];
	$Ee=$aux['Ee'];
	
	$Ta1s=$aux['Ta1s'];
	$Ta1e=$aux['Ta1e'];
	$Ta1i=$aux['Ta1i'];
	$Ta1i1=$aux['Ta1i1'];
	$Tst1s=$aux['Tst1s'];
	$Tst1e=$aux['Tst1e'];
	
	$mdt=$aux['mdt'];
	$BalanceDT=$aux['BalanceDT'];
	//"BalanceDT","BalanceST1","BalanceST2","BalanceDep1","BalanceDep2"
	$BalanceDep1=$aux['BalanceDep1'];$BalanceST1=$aux['BalanceST1'];$BalanceST2=$aux['BalanceST2'];$BalanceDep2=$aux['BalanceDep2'];
	
	
	if($i==1)
		{
		//$linea="$j"."|".$i."|".$mesant."|".$mes."|".$DT."|".$summst6."|".$Qaux."|".$summst8."|".$Ta1."|".$Ta2;
		//$intro=resultats::escribirañadirDT($nomarchivoEnBalance,$linea);

		}
	//si mes es el mismo que el anterior: sumar

	if($mes==$mesant)
		{
		// sumar
		$summst1=$summst1+$mst1;
		$summst2=$summst2+$mst2;
		$summst3=$summst3+$Est;
		$summst4=$summst4+$Qa1;
		$summst5=$summst5+$Qa2;
		$summst6=$summst6+$DT;
		$summst7=$summst7+$Pdistr;
		$summst8=$summst8+$Qaux;
		$summst9=$summst9+$Pa1;
		$summst10=$summst10+$Pa2;
		$summst11=$summst11+$Ps;
		$summst12=$summst12+$Ee;
		

		
		$summst19=$summst19+$mdt;
		$summst20=$summst20+$BalanceDT;
		$summst21=$summst21+$BalanceDep1;$summst22=$summst22+$BalanceST1;$summst23=$summst23+$BalanceST2;$summst24=$summst24+$BalanceDep2;
		$k++;
		}
	else{
		//si es diferente iniciar suma, dejar la suma anterior como registro y sumar indice de registro, deberían haber 24,inicializar sumas a cero, mirar las Ta1 y Ta2 

		
		$linea="$j"."|".$i."|".$mesant."|".$mes."|";
		$intro=resultats::escribirañadirDT($nomarchivoEnBalance,$linea);
		$linea=$summst1."|".$summst2."|".$summst3."|".$summst4."|".$summst5."|".$summst6."|".$summst7."|".$summst8."|".$summst9."|".$summst10."|".$summst11."|".$summst12."|".$Ta1."|".$Ta2;
		$intro=resultats::escribirañadirDT($nomarchivoEnBalance,$linea);
		
		//Calculo terminos de balance para Acumulador 1, deposito intermedio
		
		$Sum1=$summst22+$summst4+$summst8;
		$Sum2=$summst21+$summst20-$summst9;
		$intro=resultats::escribirañadirDT($nomarchivoEnBalance,"Balances:");
		$linea=$summst22."|".$summst4."|".$summst8."|".$summst21."|".$summst20."|".$summst9."|".$Sum1."|".$Sum2;
		$intro=resultats::escribirañadirDT($nomarchivoEnBalance,$linea);
		$Sum3=$summst20+$summst7;
		$linea="Energy Demand:".$summst20."|".$summst7."|".$Sum3."|".$summst6;
		$intro=resultats::escribirañadirDT($nomarchivoEnBalance,$linea);
		$Sum4=$summst24-$summst10+$summst5;
		$linea="Deposit 2:".$summst24."|".$summst10."|".$summst5."|".$summst23."|".$Sum4."|".$summst3;
		$intro=resultats::escribirañadirDT($nomarchivoEnBalance,$linea);
		$linea="Bomba:".$summst12."|".$summst4."|".$summst5;
		$intro=resultats::escribirañadirDT($nomarchivoEnBalance,$linea);

		$intro=resultats::escribirañadirDT($nomarchivoEnBalance,"");
		$mesant=$mes;
		$summst1=$aux['mst1'];$summst2=$aux['mst2'];
		
		
		$summst3=$Est;
		$summst4=$Qa1;
		$summst5=$Qa2;
		$summst6=$DT;
		$summst7=$Pdistr;
		$summst8=$Qaux;
		$summst9=$Pa1;
		$summst10=$Pa2;
		$summst11=$Ps;
		$summst12=$Ee;
		
		$summst13=$Ta1s;
		$summst14=$Ta1e;
		$summst15=$Ta1i;
		$summst16=$Ta1i1;
		$summst17=$Tst1s;
		$summst18=$Tst1e;
		
		$summst19=$mdt;
		$summst20=$BalanceDT;
		$summst21=$BalanceDep1;$summst22=$BalanceST1;$summst23=$BalanceST2;$summst24=$BalanceDep2;
		
		
	
	
		
		$i++;
		$k=1;
	}
	
	//$vTemp1[$i]=(float)$aux['Ta1'];
	//$vTemp2[$i]=(float)$aux['Ta2'];
	
	$j++;
	}
	$linea="$j"."|".$i."|".$mesant."|".$mes."|";
	$intro=resultats::escribirañadirDT($nomarchivoEnBalance,$linea);
	
	$linea=$summst1."|".$summst2."|".$summst3."|".$summst4."|".$summst5."|".$summst6."|".$summst7."|".$summst8."|".$summst9."|".$summst10."|".$summst11."|".$summst12."|".$Ta1."|".$Ta2;
	$intro=resultats::escribirañadirDT($nomarchivoEnBalance,$linea);
	$intro=resultats::escribirañadirDT($nomarchivoEnBalance,"");
	
	
	$Sum1=$summst22+$summst4+$summst8;
	$Sum2=$summst21+$summst20-$summst9;
	$intro=resultats::escribirañadirDT($nomarchivoEnBalance,"Balances:");
	$linea=$summst22."|".$summst4."|".$summst8."|".$summst21."|".$summst20."|".$summst9."|".$Sum1."|".$Sum2;
	$intro=resultats::escribirañadirDT($nomarchivoEnBalance,$linea);
	$Sum3=$summst20+$summst7;
	$linea="Energy Demand:".$summst20."|".$summst7."|".$Sum3."|".$summst6;
	$intro=resultats::escribirañadirDT($nomarchivoEnBalance,$linea);
		$Sum4=$summst24-$summst10+$summst5;
		$linea="Deposit 2:".$summst24."|".$summst10."|".$summst5."|".$summst23."|".$Sum4."|".$summst3;
		$intro=resultats::escribirañadirDT($nomarchivoEnBalance,$linea);
		$linea="Bomba:".$summst12."|".$summst4."|".$summst5;
		$intro=resultats::escribirañadirDT($nomarchivoEnBalance,$linea);

	$intro=resultats::escribirañadirDT($nomarchivoEnBalance,"");

	
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
	<!--<td><img src="grafico_barra4.php?<?php echo "nomarchivo=$nomarchivoDT";?>" alt="" border="0"></td></tr>-->


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