<?php

include('header.php');
// INCLUDES
require_once("class/gestio_projectesBBDD.php");
require_once("class/graficos.php");
require("./class/projectes.php");
require("./class/calculs.php");
require("./class/resultats.php");
require("./class/components.php");


gestio_projectesBBDD::setup();
if(isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}
$projecte=$projh;

$aux=projectes::getprojecteactualdades($projecte);
//$projecte=$aux['nomproject'];


$localitat=$aux['localitat'];
$demanda=$aux['nomdemanda'];
	
$nomarchivoDT=$projecte.'.txt';

$arraypanel=components::getpanellsolarprojecte($projecte);
$solarpaneltype=$arraypanel[0]['nom_panell'];
$surface=$arraypanel[0]['superficie_solar'];
$efficiency=$arraypanel[0]['efficiency'];
$arrayheatpump=components::getdadesheatpump($projecte);
$powerHP=$arrayheatpump[0]['power'];
$arrayauxiliary=components::getauxiliarysourceproject($projecte);
$arrayseasonal=components::getdadesseasonalstoragesystem($projecte);
$arraycostenergy=components::getenergycost($projecte);
$arrayeconomicdata=components::geteconomicdata($projecte);


//print_r($arrayauxiliary);

$tipoauxsource="";$costCO2Aux=0;$costCO2GN=0.252;$costCO2BM=0.018;$costCO2Elec=0.357;
$auxtipo=$arrayauxiliary[0]['tipo_source_direct_use_tank'];
if ($auxtipo==6)
	{$tipoauxsource="Electric Resistance";$costQaux1=$arraycostenergy[0]['cost1'];$costCO2Aux=$costCO2Elec;}
if ($auxtipo==7)
	{$tipoauxsource="Gas Boiler";$costQaux1=$arraycostenergy[0]['cost2'];$costCO2Aux=$costCO2GN;}
if ($auxtipo==8)
	{$tipoauxsource="Biomass Boiler";$costQaux1=$arraycostenergy[0]['cost0'];$costCO2Aux=$costCO2BM;}

$auxtipo=$arrayauxiliary[0]['tipo_source_storage_system'];
if ($auxtipo==1)
	{$tipoauxsource2="Electric Resistance";$costQaux2=$arraycostenergy[0]['cost1'];}
if ($auxtipo==2)
	{$tipoauxsource2="Gas Boiler";$costQaux2=$arraycostenergy[0]['cost2'];}
if ($auxtipo==3)
	{$tipoauxsource2="Biomass Boiler";$costQaux2=$arraycostenergy[0]['cost0'];}
if ($auxtipo==3)
	{$tipoauxsource2="Heat Waste";$costQaux2=$arraycostenergy[0]['cost3'];}
if ($auxtipo==3)
	{$tipoauxsource2="Geothermal";$costQaux2=$arraycostenergy[0]['cost4'];}

$volume=$arrayseasonal[0]['volumen'];
$storage_material=$arrayseasonal[0]['storage_material'];

	
	
$filas=file($nomarchivoDT); 

$i=0; 
$numero_fila=0; 
$arrayTemp = array("mes","year","Est","Ee","Qaux","Qa1","Qa2","T1","T2","P1","P2","hora","Pdistr","Pdistr2","DT","RendFV","Pd34");
	while($filas[$i]!=NULL && $i<=17519){ 
		$row = $filas[$i]; 
		$sql = explode("|",$row);
		$arrayTemp[$i]=array("mes"=>$sql[3],"year"=>$sql[4],"Est"=>$sql[36],"Ee"=>$sql[38],"Qaux"=>$sql[40],"Qa1"=>$sql[18],"Qa2"=>$sql[26],"hora"=>$sql[0],"Pdistr"=>$sql[9],"Pdistr2"=>$sql[46],"T1"=>$sql[14],"P2"=>$sql[27],"P1"=>$sql[19],"T2"=>$sql[22],"DT"=>$sql[5],"RendFV"=>$sql[47],"Pd34"=>$sql[48]);
		//if($i=1000){echo "$sql[46],";}
		$i++; 
		}
$i=1;$Sum1=0;$Sum2=0;$Sum3=0;$Sum4=0;$Sum5=0;$mesant=1;$inicio=1;$SumPerdidas=0;$SumPerdidas1=0;$SumPerdidas2=0;$SumPerdidas3=0;$SumPerdidas4=0;$Tmin1=1000;$Tmax1=1000;$Tmin2=1000;$Tmax2=1000;$SumDT=0;
foreach ($arrayTemp as $aux)
	{
	//leer mes
	$year=$aux['year'];
	if($year==2)
		{
		$DT=$aux['DT'];
		$Est=$aux['Est'];
		$Ee=$aux['Ee'];
		$Qaux=$aux['Qaux'];
		$Qa1=$aux['Qa1'];
		$Qa2=$aux['Qa2'];
		$Pa1=$aux['P1'];
		$Pa2=$aux['P2'];
		$Pdistr=$aux['Pdistr'];
		
		$Pdistr2=round(($aux['Pdistr2']),4);
		//echo "$Pdistr2,<br>";
		$Ta1=$aux['T1'];
		$Ta2=$aux['T2'];
		$hora=$aux['hora'];
		$EsFV=$aux['RendFV'];
		$Pd34=$aux['Pd34'];
		$Sum1=$Sum1+$Est;
		$Sum2=$Sum2+$Ee;
		$Sum3=$Sum3+$Qaux;
		$Sum4=$Sum4+$Qa1;
		$Sum5=$Sum5+$Qa2;
		$Sum6=$Sum6+$EsFV;
		$SumPerdidas=$SumPerdidas+abs($Pa1)+abs($Pa2)+abs($Pdistr2);
		$SumDT=$SumDT+$DT;
		$SumPerdidas1=$SumPerdidas1+abs($Pa1);
		$SumPerdidas2=$SumPerdidas2+abs($Pa2);
		$SumPerdidas3=$SumPerdidas3+abs($Pdistr);
		$SumPerdidas4=$SumPerdidas4+abs($Pdistr2);
		$SumPerdidas5=$SumPerdidas5+abs($Pd34);
		if($Tmin2==1000){$Tmin2=$Ta2;$horamin=$hora;}
		else{if($Ta2<$Tmin2){$Tmin2=$Ta2;$horamin=$hora;}}
		if($Tmax2==1000){$Tmax2=$Ta2;$horamax=$hora;}
		else{if($Ta2>$Tmax2){$Tmax2=$Ta2;$horamax=$hora;}}

		}

	}
	$Sum1=$Sum1/1000;
	$Sum2=$Sum2/1000;
	$Sum3=$Sum3/1000;
	$Sum4=$Sum4/1000;
	$Sum5=$Sum5/1000;
	$Sum6=$Sum6/1000;
	$SumPerdidas=$SumPerdidas/1000;
		$SumPerdidas1=$SumPerdidas1/1000;
	$SumPerdidas2=$SumPerdidas2/1000;
	$SumPerdidas3=$SumPerdidas3/1000;
	$SumPerdidas4=$SumPerdidas4/1000;
	$SumPerdidas5=$SumPerdidas5/1000;
	$SumDT=$SumDT/1000;
	$autonomy=abs($horamax-$horamin)/24;
$balance=$Sum2*$arraycostenergy[0]['cost1']+$Sum3*$costQaux1;
	
$elecproduction=$Sum6;
$ratio=$Sum1/$surface;
if($Sum2!=0){
$COPyear=$Sum5/$Sum2;}
else{$COPyear=0;}
$ThermalSuff=1-($Sum3/$SumDT);
if($ThermalSuff<0){$ThermalSuff=0;}
$EnergyConSaving=($SumDT+$SumPerdidas)-($Sum3+$Sum2);
if($EnergyConSaving<0){$EnergyConSaving=0;}
//$Thermallosses=$SumPerdidas/($Sum3+$Sum2+$Sum1);
$Thermallosses=$SumPerdidas/($SumDT);
$Balance=$SumDT*($arraycostenergy[0]['cost2']+$arraycostenergy[0]['cost1'])/2;
$chessconsume=($Sum2*$arraycostenergy[0]['cost1'])+($Sum3*$costQaux1)-($elecproduction*$arraycostenergy[0]['cost1']);
$savings=$Balance-$chessconsume;
$invest=$arrayeconomicdata[0]['invest'];
$mantenance=$arrayeconomicdata[0]['mantenance'];
$payback=$arrayeconomicdata[0]['invest']/($savings-$arrayeconomicdata[0]['mantenance']);
$payback=round($payback,2);
if($payback<0){$payback="Error";}

//$Dis=$Sum1-$Sum5-$SumPerdidas;
if($Sum1>0){
$Dis=($Sum1-($SumDT-$Sum2-$Sum3)-$SumPerdidas)*100/($Sum1);
}
else {$Dis=0;}
if($Dis<0){$Dis=0;}
//echo "$SumDT,$costCO2GN,$Sum2,$costCO2Elec,$Sum3,$costCO2Aux,$elecproduction,$costCO2Elec";
$ceodos=(($SumDT)*(($costCO2GN+$costCO2Elec)/2)-(($Sum2*$costCO2Elec)+($Sum3*$costCO2Aux)-($elecproduction*$costCO2Elec)));
// Crear csv
$nomfitxer="informe_usuari.csv";
//crear tabla relleno
$archivo = fopen ($nomfitxer, "w+");

//Contabilizar numero y preparar un string para dinamizar la escritura en la primera fila del CSV 
$linea="CONCEPT;QUANTITY;UNIT";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Thermal self sufficiency:;".number_format($ThermalSuff,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Energy consumption saving: ;".number_format($EnergyConSaving,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Primary energy saving: ;".number_format($SumDT,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Balance economics: ;"."".";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="SOLAR PANEL ;"."".";;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Solar panel type:  ;".$solarpaneltype.";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Panel Surface: ;".number_format($surface,2).";  % ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Thermal yearly efficiency:  ;".$efficiency.";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Thermal production:  ;".number_format($Sum1,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea=" Electrical production:  ;".number_format($elecproduction,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Production ratio:  ;".number_format($ratio,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="HEAT PUMP  ;"." "."; ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Heat Pump:  ;".number_format($powerHP,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Yearly COP:  ;".number_format($COPyear,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Energy consumption:  ;".number_format($Sum2,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="AUXILIARY SYSTEM ;".""."; ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Auxiliary System:  ;".$tipoauxsource.";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Yearly Efficiency:   ;"."".";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Energy consumption:   ;".number_format($Sum3,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="SEASONAL STORAGE SYSTEM  ;"." "."; ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Storage System:    ;".$storage_material.";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Storage Volume:     ;".number_format($volume,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Max. Temperature(2 years):    ;".number_format($Tmax2,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Min. Temperature(2 years):     ;".number_format($Tmin2,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Autonomy Days:     ;".number_format($autonomy,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="LOSSES     ;"." "."; ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Thermal losses:     ;".number_format($Thermallosses,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Total losses:     ;".number_format($SumPerdidas,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Direct Tank Use losses:     ;".number_format($SumPerdidas1,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Storage Deposit losses:      ;".number_format($SumPerdidas2,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");
$linea="Distribution losses:      ;".number_format($SumPerdidas3,2).";	% ;";
fwrite($archivo,utf8_decode($linea)."\n");







fclose($archivo);
//Fin CSV
?>
<ul class="breadcrumbs first">
    <li><a href="#">Thermal and Energy Supply Distribution</a></li>
    <li class="active"><a href="#">Data & Graphics </a></li>
</ul>


<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Data & Graphics </h2>
    </div>
    <div class="widget_body">

	<form name="validacio" method="POST" action="ResultEnergySupply.php?t=Graphics&projh=<?php echo $projh;?>" id="validacio">
	
	<!--<td><img src="grafico_barra4.php?<?php echo "varTemp1=$vserTemp1&varTemp2=$vserTemp2";?>" alt="" border="0"></td></tr>-->
	<table><tr>
	<td><img src="grafico_barra9.php?<?php echo "nomarchivo=$nomarchivoDT";?>" alt="" border="0"></td>
	<td><img src="grafico_barra10.php?<?php echo "nomarchivo=$nomarchivoDT";?>" alt="" border="0"></td></tr>
	<tr><td><a href="<?php echo $nomfitxer; ?>" class="btn blue right">Download CSV</a></td></tr>
	<tr></tr>
	<tr><td><label style='background-color:blue;color:white'> GENERAL RESULTS: </label></td></tr>
	<tr><td><label> Thermal self sufficiency: </label></td><td><label><?php echo number_format($ThermalSuff*100,2); ?></label></td><td><label> % </label></td></tr>
	<tr><td><label> Energy consumption saving:    </label></td><td><label><?php echo number_format($EnergyConSaving,0); ?></label></td><td><label> kWh/year </label></td></tr>
	<tr><td><label> Total demand:    </label></td><td><label><?php echo number_format($SumDT,0); ?></label></td><td><label> kWh/year </label></td></tr>
	<!--<tr><td><label> Perdidas:    </label></td><td><label><?php echo $SumPerdidas4; ?></label></td><td><label>  </label></td></tr>-->
	<tr><td><label> Invest:    </label></td><td><label><?php echo number_format($invest,0); ?></label></td><td><label>Euros  </label></td></tr>
	<tr><td><label> O&M:    </label></td><td><label><?php echo number_format($mantenance,0); ?></label></td><td><label>Euros  </label></td></tr>
	<tr><td><label> Economic Saving:    </label></td><td><label><?php echo number_format($savings,0); ?></label></td><td><label>Euros/year  </label></td></tr>
	<tr><td><label>Payback:    </label></td><td><label><?php echo number_format($payback,2); ?></label></td><td><label> Years </label></td></tr>
	<tr><td><label> CO2 emissions reduction:    </label></td><td><label><?php echo number_format($ceodos,0); ?></label></td><td><label> kgCO2  </label></td></tr>

	<tr><td><label> Energy Cost:    </label></td><td><label><?php echo number_format($balance,0); ?></label></td><td><label> Euros/year </label></td></tr>
	<tr></tr>
	<tr><td></td><td></td><td></td></tr>
	<tr><td><label style='background-color:blue;color:white'> SOLAR PANEL </label></td></tr>
	<tr><td><label> Solar panel type: </label></td><td><label><?php echo $solarpaneltype; ?></label></td><td><label>  </label></td></tr>
	<tr><td><label> Panel Surface:    </label></td><td><label><?php echo $surface; ?></label></td><td><label> m2 </label></td></tr>
	<!--<tr><td><label> Thermal yearly efficiency:    </label></td><td><label><?php echo $efficiency*100; ?></label></td><td><label> % </label></td></tr>-->
	<tr><td><label> Thermal production:    </label></td><td><label><?php echo number_format($Sum1,0); ?></label></td><td><label> kWh/year </label></td></tr>
	<tr><td><label> Thermal energy dissipated:    </label></td><td><label><?php echo number_format($Dis,2); ?></label></td><td><label> % </label></td></tr>
	<tr><td><label> Electrical production:    </label></td><td><label><?php echo number_format($elecproduction,0); ?></label></td><td><label> kWh/year </label></td></tr>
	<!--<tr><td><label> Production ratio:    </label></td><td><label><?php echo number_format($ratio,2); ?></label></td><td><label> kWh/year/m2 </label></td></tr>
     -->
	<tr><td><label style='background-color:blue;color:white'> HEAT PUMP </label></td></tr>
	<tr><td><label> Heat Pump: </label></td><td><label><?php echo number_format($powerHP,2); ?></label></td><td><label> kW </label></td></tr>
	<tr><td><label> Yearly COP:    </label></td><td><label><?php echo number_format($COPyear,2); ?></label></td><td><label>  </label></td></tr>
	<tr><td><label> Energy consumption:    </label></td><td><label><?php echo number_format($Sum2,0); ?></label></td><td><label> kWh/year </label></td></tr>
	<tr><td><label style='background-color:blue;color:white'> AUXILIARY SYSTEM </label></td></tr>
	<tr><td><label> Auxiliary System Direct Use Tank: </label></td><td><label><?php echo $tipoauxsource; ?></label></td><td><label> </label></td></tr>
	<!--<tr><td><label> Auxiliary System Storage System: </label></td><td><label><?php echo $tipoauxsource2; ?></label></td><td><label> </label></td></tr>
-->
	<!--<tr><td><label> Yearly Efficiency:    </label></td><td><label><?php echo ""; ?></label></td><td><label> % </label></td></tr>-->
	<tr><td><label> Energy consumption:    </label></td><td><label><?php echo number_format($Sum3,0); ?></label></td><td><label> kWh/year </label></td></tr>
	<tr><td><label style='background-color:blue;color:white'> SEASONAL STORAGE SYSTEM </label></td></tr>
	<tr><td><label> Storage System: </label></td><td><label><?php echo $storage_material; ?></label></td><td><label> </label></td></tr>
	<tr><td><label> Storage Volume:    </label></td><td><label><?php echo number_format($volume,0); ?></label></td><td><label> m3 </label></td></tr>
	<tr><td><label> Max. Temperature:    </label></td><td><label><?php echo number_format($Tmax2,2); ?></label></td><td><label> &#176C </label></td></tr>
	<tr><td><label> Min. Temperature:    </label></td><td><label><?php echo number_format($Tmin2,2); ?></label></td><td><label> &#176C </label></td></tr>
	<!--<tr><td><label> Autonomy Days:    </label></td><td><label><?php echo number_format($autonomy,2); ?></label></td><td><label> kWh/year </label></td></tr>-->
	<tr><td><label style='background-color:blue;color:white'> LOSSES </label></td></tr>
	<tr><td><label> Thermal losses: </label></td><td><label><?php echo number_format($Thermallosses*100,2); ?></label></td><td><label> % </label></td></tr>
	<tr><td><label> Total losses:    </label></td><td><label><?php echo number_format($SumPerdidas,0); ?></label></td><td><label> kWh/year </label></td></tr>
	<tr><td><label> Direct Tank Use losses:    </label></td><td><label><?php echo number_format($SumPerdidas1,0); ?></label></td><td><label> kWh/year </label></td></tr>
	<tr><td><label> Storage Deposit losses:    </label></td><td><label><?php echo number_format($SumPerdidas2,0); ?></label></td><td><label> kWh/year </label></td></tr>
	<!--<tr><td><label> Distribution losses:    </label></td><td><label><?php echo number_format($SumPerdidas3,0); ?></label></td><td><label> kWh/year </label></td></tr>
	-->
	<tr><td><label> Distribution losses:    </label></td><td><label><?php echo number_format($SumPerdidas4,0); ?></label></td><td><label> kWh/year </label></td></tr>

	
	
	</table>
	
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


<?php include("footer.php") ?>