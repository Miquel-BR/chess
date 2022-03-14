<?php
set_time_limit(1200);
ini_set('memory_limit', '1024M');
// INCLUDES
require_once("./class/gestio_projectesBBDD.php");
require_once("./class/usuari.php");
require_once("./class/demandas.php");
require_once("./class/distribuciofrecuencies.php");
require_once("./class/projectes.php");
require_once("./class/botones.php");
require_once("./class/calculs.php");
require_once("./class/resultats.php");

gestio_projectesBBDD::setup();

if(isset($_POST['projecte'])){$projecte=$_POST['projecte'];}
if(isset($_GET['projecte'])){$projecte=$_GET['projecte'];}
if(isset($_POST['demanda'])){$demanda=$_POST['demanda'];}
if(isset($_GET['demanda'])){$demanda=$_GET['demanda'];}
if(isset($_POST['localitat'])){$localitat=$_POST['localitat'];}
if(isset($_GET['localitat'])){$localitat=$_GET['localitat'];}
if(isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}
//obtener datos DT heating
//echo "$projecte,4,$demanda,$localitat<br>";
$DTHeating=calculs::obtenerDT($projecte,4,$demanda,$localitat);
$DTHotwater=calculs::obtenerDT($projecte,5,$demanda,$localitat);
$vRad=calculs::obtenerVarClima($projecte,1);
$vIrr=calculs::obtenerVarClima($projecte,8);
$vText=calculs::obtenerVarClima($projecte,2);
$vTground=calculs::obtenerVarClima($projecte,3);

//$vTground::calculs::obtenerVarClima($projecte,3);
//Temperatura del suelo:: debería ser el vector pero hay que revisarlo, de momento lo ponemos como constante
$Tground=15;
//obtener datos DT hotwater
//sumar vectores valores con dia año mes
$numDTHeating=count($DTHeating)-1;
$numDTHotwater=count($DTHotwater)-1;
$numvText=count($vText)-1;
$numvRad=count($vRad)-1;
$numvIrr=count($vIrr)-1;
//echo "$numDTHeating,$numDTHeating,";
//echo "$numvText,$numvRad,$numvIrr<br>";

$i=1;

if($numDTHeating>0){
foreach($DTHeating as $ar)
	{
	$DTTotal[$i]=$ar*1000;
	$i++;
	}
	
if($numDTHotwater>0)
	{
	$i=1;
	foreach($DTHotwater as $ar)
		{
		$DTTotal[$i]=$DTTotal[$i]+$ar*1000;
		$i++;
		}
	}
}

$i2=1;
if($numDTHotwater>0 && $numDTHeating==0)
{
foreach($DTHotwater as $ar)
	{
	$DTTotal[$i2]=$ar*1000;
	$i2++;
	}
}


//$m=1;
//for($i=1;$i<=12;$i++)
//	{
//	if($i==1){$numday=31;}
//	if($i==2){$numday=28;}
//	if($i==3){$numday=31;}
//	if($i==4){$numday=30;}
//	if($i==5){$numday=31;}
//	if($i==6){$numday=30;}
//	if($i==7){$numday=31;}
//	if($i==8){$numday=31;}
//	if($i==9){$numday=30;}
//	if($i==10){$numday=31;}
//	if($i==11){$numday=30;}
//	if($i==12){$numday=31;}
//	for($j=1;$j<=$numday;$j++)
//		{
//		for($k=1;$k<=24;$k++)
//			{
			
//			$DTTotal[$m]=$DTHeating[$m]['valor']+$DTHotwater[$m]['valor'];
//			$m++;
//			}
//		}
//	}

//Sacar las constantes de sistema
echo "<br>Compiling data<br>";
$Dep1=calculs::cargardatosdeposit1($projecte);
$Dep2=calculs::cargardatosdeposit2($projecte);
$HeatPump=calculs::cargardatosheatpump($projecte);
$SolarPanel=calculs::cargardatossolarpanel($projecte);
$AuxSource=calculs::cargardatosauxsource($projecte);
$AuxDist=calculs::cargardatosdistribucion($projecte);
//print_r($AuxDist);

//print_r($AuxDist);
//definir las constantes
$Ta1i=70;$Ta1i1=70;
$Ta2i=40;$Ta2i1=40;
$Celiq=$Dep1['heatcapacity'];
$Tdts=50;
$Tst1s=49.50;
$Ta1e=49.50;
$Tst2s=50;
$perdidas=0.01;
$Tsts=50; //G40
//Para cada hora desde el principio, por dos veces. 
$ma1=$Dep1['volumen1']*$Dep1['density'];
//Afagit per ordres de dalt: corregir el factor de timestep
$ma1=$ma1*4;
$ma2=$Dep2['volumen2']*$Dep2['density'];
$index=1;
$vResultDT=array("DT","mdt","Tdts","Tdte","Pdistr");
$vResultAcum1=array("Ta1s","Ta1e","Ta1i","Ta1i1","Ta1","Tst1s","Tst1e","mst1","Qa1","Pa1");
$vResultAcum2=array("Ta2i","Ta2i1","Ta2","Tst2s","Tst2e","mst2","Qa2","Pa2");
$vResultCapSolar=array("Rad","Irr","Text","mst","Tsts","Tste","mst1","Tst1s","Tst1e","mst2","Tst2s","Tst2e","Tcol","Rend","Est","Ps","RendFV");
$vResultHeatPump=array("Qa1","Qa2","Ee","COP");
$vResultAuxSource=array("Qaux");
$vResultDist=array("Pdist2","Pd34");
$vResultBalance=array("BalanceDT","BalanceDep2","BalanceSolarTDep1","BalanceSolarTDep2","BalanceDep1");
$PAcum=0;
echo "<br>Begining calculation<br>";
for ($year=1;$year<=2;$year++)
	{
	echo "<br>Calculation for year $year<br>";
	for($hora=1;$hora<=8760;$hora++)
		{
		if(($hora>=1 && $hora<1950)||($hora>=8520 && $hora<=8760))
			{$Tsts=$SolarPanel['tempwinter'];}
		if(($hora>=1950 && $hora<4140)||($hora>=6330 && $hora<8520))
			{$Tsts=$SolarPanel['temprest'];}
		if(($hora>=4140 && $hora<6330))
			{$Tsts=$SolarPanel['tempsummer'];}
		$Tst2s=$Tsts;

		//Definiciones periodo,cambios valores de periodo
		//Para cada iteración
		$Tground=$vTground[$hora]['valor'];
		for($iter=1;$iter<=4;$iter++)
			{
			$Ta1=($Ta1i+$Ta1i1)/2;
			$Ta2=($Ta2i+$Ta2i1)/2;
			$Tste=$Ta2;
			$auxh=$vText[$hora]['valor'];
			$mst=calculs::iteracion_mst($vRad[$hora]['valor'],$SolarPanel['stp_b'],$SolarPanel['stp_a1'],$Tsts,$Ta2,$auxh,$vIrr[$hora]['valor'],$SolarPanel['stp_a2'],$SolarPanel['surfacesolar'],$Celiq,$Tst2s,$Dep2['maxtempa2']);
			$mst1=0;
			$mst2=$mst-$mst1;
			//$mst2=$mst;
			$auxDT=$DTTotal[$hora];
			if($Dep2['location']=="Underground"){$auxTperd=$Tground;}
			else{$auxTperd=$auxh;}
			$mdt=calculs::iteracion_mdt($auxDT,$Celiq,$Ta1,$Tdts,$perdidas);
			$COP=calculs::iteracion_cop($Ta1,$Ta2,$HeatPump['efficiency'],$HeatPump['TCOPmax'],$HeatPump['COPmax'],$HeatPump['TCOPmin'],$HeatPump['COPmin'],$HeatPump['TCOPmid'],$HeatPump['COPmid'],$HeatPump['bottonCOP']);
			//$COPreal=calculs::iteracion_cop_real($COP,$HeatPump['efficiency']);
			$COPreal=$COP;
			//echo "$COPreal,$Dep1['mintempa1'],$Dep2['mintempa2'],$HeatPump['power'],$Ta1i,$Ta2i";
			$Qa2=calculs::iteracion_Qa2($COPreal,$Dep1['mintempa1'],$Dep2['mintempa2'],$HeatPump['power'],$Ta1i,$Ta2i);
			
			$Ee=calculs::calculEe($Dep1['mintempa1'],$Dep2['mintempa2'],$HeatPump['power'],$Ta1i,$Ta2i);
			$Qa1=calculs::iteracion_Qa1($Ee,$Qa2);
			$Qaux=calculs::iteracion_Qaux($Dep1['mintempa1'],$Dep2['mintempa2'],$AuxSource['Qaux1'],$Ta1i,$Ta2i);
			
			
			$P1=calculs::iteracion_P1($Ta1,$Dep1['surface1'],$Dep1['u1'],$auxh);
			
			$P2=calculs::iteracion_P2($Ta2,$Dep2['surface2'],$Dep2['u2'],$auxTperd);
			
			$Ta1i1=calculs::iteracion_Ta1i1($Tst1s,$Ta1,$mst1,$Celiq,$Ta1e,$mdt,$Qa1,$Qaux,$P1,$Ta1i,$ma1);
			$Ta2i1=calculs::iteracion_Ta2i1($Tst2s,$Ta2,$mst2,$Qa2,$P2,$ma2,$Celiq,$Ta2i);
			}
		$Ta1=($Ta1i1+$Ta1i)/2;
		$Ta2=($Ta2i+$Ta2i1)/2;
		$Tdte=$Ta1*0.99;
		$stp_b=$SolarPanel['stp_b'];$stp_a1=$SolarPanel['stp_a1'];$stp_a2=$SolarPanel['stp_a2'];$Irr=$vIrr[$hora]['valor'];
		//Cargar todos los resultados en el vector de resultados
		$Pdistr=$mdt*$Celiq*($Tdte+$Ta1e-$Tdts-$Ta1)/1000;
		//Pérdidas entre la placa y el dep2 grande y entre el dep2 grande y el dep1 de buffer
		//$Pdistr2=-($AuxDist[0]['u2']*(Tsts-$auxh)+($AuxDist[0]['u1']*(Ta2-$Tground)))/1000;
		
		$vResultDT[$index]=array("DT"=>$DTTotal[$hora],"mdt"=>$mdt,"Tdts"=>$Tdts,"Tdte"=>$Ta1*0.99,"Pdistr"=>$Pdistr);
		$vResultAcum1[$index]=array("Ta1s"=>$Ta1,"Ta1e"=>$Ta1e,"Ta1i"=>$Ta1i,"Ta1i1"=>$Ta1i1,"Ta1"=>$Ta1,"Tst1s"=>$Tst1s,"Tst1e"=>$Ta1,"mst1"=>$mst1,"Qa1"=>$Qa1,"Pa1"=>$P1);
		$vResultAcum2[$index]=array("Ta2i"=>$Ta2i,"Ta2i1"=>$Ta2i1,"Ta2"=>$Ta2,"Tst2s"=>$Tst2s,"Tst2e"=>$Ta2,"mst2"=>$mst,"Qa2"=>$Qa2,"Pa2"=>$P2);
		$Tcol=($Tsts+$Ta2)/2;
		$Rend=calculs::calculRendSolar($vRad[$hora]['valor'],$SolarPanel['stp_b'],$SolarPanel['stp_a1'],$SolarPanel['stp_a2'],$Tcol,$vText[$hora]['valor'],$vIrr[$hora]['valor']);
		$Est=calculs::calculEst($vRad[$hora]['valor'],$Rend,$SolarPanel['surfacesolar']);
		$Ps=calculs::calculPs($mst,$Celiq,$Tsts,$Tst1s);
		$r2_1=($AuxDist[0]['diametro2']/2+$AuxDist[0]['aislamiento2'])/100;
		$r2_2=($AuxDist[0]['diametro1']/2+$AuxDist[0]['aislamiento1'])/100;
		if($mdt>0){
		$P1d=calculs::calcularperdidapipe($Tdts,20,10,$AuxDist[0]['long2'],$mdt,$AuxDist[0]['transferenciacalor2'],$AuxDist[0]['diametro2']/200,$r2_1,$Celiq);
		$P2d=calculs::calcularperdidapipe($Ta1,20,10,$AuxDist[0]['long2'],$mdt,$AuxDist[0]['transferenciacalor2'],$AuxDist[0]['diametro2']/200,$r2_1,$Celiq);
		}
		else {$P1d=0;$P2d=0;}
		if($mst>0){
		$P3d=calculs::calcularperdidapipe($Ta2,$auxh,20,$AuxDist[0]['long1'],$mst,$AuxDist[0]['transferenciacalor1'],$AuxDist[0]['diametro1']/200,$r2_2,$Celiq);
		$P4d=calculs::calcularperdidapipe($Tsts,$auxh,20,$AuxDist[0]['long1'],$mst,$AuxDist[0]['transferenciacalor1'],$AuxDist[0]['diametro1']/200,$r2_2,$Celiq);
        }
		else {$P3d=0;$P4=0;}
		$Pdistr2=$P1d+$P2d+$P3d+$P4d;
		$Pd34=$P3d+$P4d;
		$PAcum=$PAcum+$Pdistr2;
		
		
		$EsFV=$SolarPanel['RendFV']*$vRad[$hora]['valor']*$SolarPanel['surfacesolar'];
		
		//if($hora==1000 or $hora==3000){echo "<br>".$Pdistr2.",".$PAcum.",".$EsFV.",".$SolarPanel['RendFV'].",".$vRad[$hora]['valor'].",".$SolarPanel['surfacesolar'].",".$r2_1.",".$r2_2.",".$P1d.",".$P2d.",".$P3d.",".$P4d.",".$P1.",".$P2;}
		//if($Pdistr2<-3000){echo "<br>Pdis: $hora,$Pdistr2,$P1d,$P2d,$P3d,$P4d,$r2_1,$r2_2<br>";}
		$vResultCapSolar[$index]=array("Rad"=>$vRad[$hora]['valor'],"Irr"=>$vIrr[$hora]['valor'],"Text"=>$vText[$hora]['valor'],"mst"=>$mst,"Tsts"=>$Tsts,"Tste"=>$Tste,"mst1"=>$mst1,"Tst1s"=>$Tst1s,"Tst1e"=>$Ta1,"mst2"=>$mst,"Tst2s"=>$Tst2s,"Tst2e"=>$Ta2,"Tcol"=>$Tcol,"Rend"=>$Rend,"Est"=>$Est,"Ps"=>$Ps,"RendFV"=>$EsFV);
		$vResultHeatPump[$index]=array("Qa1"=>$Qa1,"Qa2"=>$Qa2,"Ee"=>$Ee,"COP"=>$COP);
		$vResultAuxSource[$index]=array("Qaux"=>$Qaux);
		$vResultDist[$index]=array("Pdist2"=>$Pdistr2,"Pd34"=>$Pd34);
		//if($index==1000 or $index==3000){echo "<br>".$Pdistr2.";$Tdts,20,10,$mst,$mdt,$Celiq,$r2_1,$r2_2,$P1,$P2,$P3,$P4<br>";}
		$term1=($Ta1-$Ta1e)*$Celiq*$mdt;//Balance demanda
		$term2=($Ta2i1-$Ta2i)*$Celiq*$ma2;//Balance deposito 2
		$term3=($Tsts-$Ta2)*$Celiq*$mst2;//Balance solar dep 2
		$term4=($Tst1s-$Ta1)*$Celiq*$mst1;//Balance solar dep 1
		$term5=($Ta1i1-$Ta1i)*$ma1*$Celiq;//Balance dep 1
		$vResultBalance[$index]=array("BalanceDT"=>$term1,"BalanceDep2"=>$term2,"BalanceSolarTDep1"=>$term4,"BalanceSolarTDep2"=>$term3,"BalanceDep1"=>$term5);
		
		/*if($index>=9 && $index<=9) {
			$auxx=$vResultCapSolar[$index]['Est'];
			echo "<br>$index<br>";
			echo "$DTTotal[$hora],$auxDT,$Celiq,$Ta1,$Tdts";
			
			echo "<br>$Ta1,$Ta2,$mdt,$P1,$P2,$Ta1i,$Ta2i,$Ta1i1,$Ta2i1";
			echo "<br>$Tst1s,$Ta1,$mst1,$Celiq,$Ta1e,$mdt,$Qa1,$Qaux,$P1,$Ta1i,$ma1";
			echo "<br>$Qa1,$Ee,$Qa2,$COP,$COPreal";
			echo "<br>$Pdistr,$mdt,$Celiq,$Tdte,$Ta1e,$Tdts,$Ta1";
			echo "<br>$Rend,$Tcol,$Tsts,$Tste,$Ta2,$stp_b,$stp_a1,$stp_a2,$Irr";
			
			}
			*/
		

		$index++;
		$Ta1i=$Ta1i1;
		$Ta2i=$Ta2i1;
		//if($hora==110){
		  //$auxes1=$SolarPanel['stp_a2']; $auxes2=$SolarPanel['surfacesolar'];$auxes3=$vRad[$hora]['valor'];$auxes4=$vIrr[100]['valor'];
		  //echo "$Ta2i,$Ta1i,$auxh,$mst,$mdt,$Qa1,$P1,$P2,$Pdistr,$Qa1,$Qa2,$COPreal";
		  //echo "<br>$auxes3,$Tsts,$Ta2,$auxh,$auxes4,$auxes1,$auxes2,$Celiq,$Tst2s";
		  //echo "$SolarPanel['surfacesolar']";
		  
		 //}
		}
	
	echo "<br>Listo<br>";
	}
	//Entrar datos en BBDD: tablas de resultados para cada parte
	echo "<br>Making .txt and .csv files<br>";
	$aux=resultats::prepararDT($projecte);
	$nomarchivoDT=$projecte.'.txt';
	$aux=resultats::creararchivoDT($nomarchivoDT);
	//for ($i=0;$i<$index;$i++)
	
	//Crear CSV
				//fwrite($archivo,utf8_decode($linea)."\n");
		//fin de la creación CSV
		//fclose($archivo);
	$nomfitxer="informe_usuari_horario.csv";
		//crear tabla relleno
		//$archivo = fopen ($nomfitxer, "w+");
		if (!$handle = fopen($nomfitxer, "w+")) {  
			echo "Cannot open file";  
			exit;  
			} 
	//Contabilizar numero y preparar un string para dinamizar la escritura en la primera fila del CSV 
	$linea="Direct Use Tank Temperature;Seasonal Deposit Temperature;Total Demand;Heat Pump Energy;Solar Panel Energy Production;Auxiliary Energy;Efficiency Heap Pump(COP);Distrubution Waste;Direct Use Tank Waste;Seasonal Storage Diposit Waste";

	
	
	for ($i=0;$i<$index;$i++)
		//Encontrar dato hora,dia,mes,año,cuidado porque el index empieza en 1 y la i en 0
		{
		$hora=($i%24);
		$dias=floor($i/24)+1;
		
		$year2=floor($dias/365)+1;
		if($dias==365)
			{$year2=1;}
		if($dias==730)
			{$year2=2;}
		if($year2>1)
			{
			$diasrest=$dias-(365*($year2-1));
			
			}
		else {$diasrest=$dias;}
		
		$numdias[1]=31;$numdias[2]=28;$numdias[3]=31;$numdias[4]=30;$numdias[5]=31;$numdias[6]=30;
		$numdias[7]=31;$numdias[8]=31;$numdias[9]=30;$numdias[10]=31;$numdias[11]=30;$numdias[12]=31;
		$j=1;$sumdias=0;$mes=$j;
		while($sumdias<$diasrest )
			{$dia=$diasrest-$sumdias;
			$sumdias=$sumdias+$numdias[$j];
			$j++;}
		$mes=$j-1;
		
		//insertar para cada hora,mes,dia,año,horabruta, los datos de DT en tabla results_dt
		//$vResultDT=array("DT","mdt","Tdts","Tdte","Pdistr");
		//$vResultAcum1=array("Ta1s","Ta1e","Ta1i","Ta1i1","Ta1","Tst1s","Tst1e","mst1","Qa1","Pa1");
		//$vResultAcum2=array("Ta2i","Ta2i1","Ta2","Tst2s","Tst2e","mst2","Qa2","Pa2");
		//$vResultCapSolar=array("Rad","Irr","Text","mst","Tsts","Tste","mst1","Tst1s","Tst1e","mst2","Tst2s","Tst2e","Tcol","Rend","Est","Ps");
		//$vResultHeatPump=array("Qa1","Qa2","Ee","COP");
		//$vResultAuxSource=array("Qaux");
		$ii=$i+1;
		$iii=$i+1;
		
		if($ii>=8761){$ii=$ii-8760;}
		
		if($iii<=17520){
		$aux1=$vResultDT[$iii]['DT'];
		$aux2=$vResultDT[$iii]['mdt'];
		$aux3=$vResultDT[$iii]['Tdts'];
		$aux4=$vResultDT[$iii]['Tdte'];
		$aux5=$vResultDT[$iii]['Pdistr'];
		$aux6=$vResultAcum1[$iii]['Ta1s'];$aux7=$vResultAcum1[$iii]['Ta1e'];$aux8=$vResultAcum1[$iii]['Ta1i'];$aux9=$vResultAcum1[$iii]['Ta1i1'];$aux10=$vResultAcum1[$iii]['Ta1'];
		$aux11=$vResultAcum1[$iii]['Tst1s'];$aux12=$vResultAcum1[$iii]['Tst1e'];$aux13=$vResultAcum1[$iii]['mst1'];$aux14=$vResultAcum1[$iii]['Qa1'];$aux15=$vResultAcum1[$iii]['Pa1'];
		$aux16=$vResultAcum2[$iii]['Ta2i'];$aux17=$vResultAcum2[$iii]['Ta2i1'];$aux18=$vResultAcum2[$iii]['Ta2'];$aux19=$vResultAcum2[$iii]['Tst2s'];
		$aux20=$vResultAcum2[$iii]['Tst2e'];$aux21=$vResultAcum2[$iii]['mst2'];$aux22=$vResultAcum2[$iii]['Qa2'];$aux23=$vResultAcum2[$iii]['Pa2'];
		$aux24=$vResultCapSolar[$iii]['Rad'];$aux25=$vResultCapSolar[$iii]['Irr'];$aux26=$vResultCapSolar[$iii]['Text'];$aux27=$vResultCapSolar[$iii]['mst'];
		$aux28=$vResultCapSolar[$iii]['Tsts'];$aux29=$vResultCapSolar[$iii]['Tste'];$aux30=$vResultCapSolar[$iii]['mst1'];$aux31=$vResultCapSolar[$iii]['Tst1s'];
		$aux32=$vResultCapSolar[$iii]['Tst1e'];$aux33=$vResultCapSolar[$iii]['mst2'];$aux34=$vResultCapSolar[$iii]['Tst2s'];$aux35=$vResultCapSolar[$iii]['Tst2e'];
		$aux36=$vResultCapSolar[$iii]['Tcol'];$aux37=$vResultCapSolar[$iii]['Rend'];$aux38=$vResultCapSolar[$iii]['Est'];$aux39=$vResultCapSolar[$iii]['Ps'];
		$aux40=$vResultHeatPump[$iii]['Qa1'];$aux41=$vResultHeatPump[$iii]['Qa2'];$aux42=$vResultHeatPump[$iii]['Ee'];$aux43=$vResultHeatPump[$iii]['COP'];
		$aux44=$vResultAuxSource[$iii]['Qaux'];
		$aux45=$vResultBalance[$iii]['BalanceDT'];$aux46=$vResultBalance[$iii]['BalanceSolarTDep1'];$aux47=$vResultBalance[$iii]['BalanceSolarTDep2'];$aux48=$vResultBalance[$iii]['BalanceDep1'];$aux49=$vResultBalance[$iii]['BalanceDep2'];
		
		$aux50=$vResultDist[$iii]['Pdist2'];
		$aux51=$vResultCapSolar[$iii]['RendFV'];
		$aux52=$vResultDist[$iii]['Pd34'];
		//$linea2=number_format($aux10,2).";".number_format($aux18,2).";".number_format($aux1,2).";".number_format($aux42,2).";".number_format($aux46,2).";".number_format($aux44,2).";".number_format($aux18,2).";".number_format($aux43,2).";".number_format($aux5,2).";".number_format($aux15,2).";".number_format($aux23,2).";";
		//if($iii==1000){echo "<br>$aux50";}
		}
		//$intro=resultats::insertar($projecte,$ii,$hora,$dia,$mes,$year2,$aux1,$aux2,$aux3,$aux4,$aux5,$aux6,$aux7,$aux8,$aux9,$aux10,$aux11,$aux12,$aux13,$aux14,$aux15,$aux16,$aux17,$aux18,$aux19,$aux20,$aux21,$aux22,$aux23,$aux24,$aux25,$aux26,$aux27,$aux28,$aux29,$aux36,$aux37,$aux38,$aux39,$aux42,$aux43,$aux44);
		$linea="$iii"."|".$hora."|".$dia."|".$mes."|".$year2."|".$aux1."|".$aux2."|".$aux3."|".$aux4."|".$aux5."|".$aux6."|".$aux7."|".$aux8."|".$aux9."|".$aux10."|".$aux11."|".$aux12."|".$aux13."|".$aux14."|".$aux15."|".$aux16."|".$aux17."|".$aux18."|".$aux19."|".$aux20."|".$aux21."|".$aux22."|".$aux23."|".$aux24."|".$aux25."|".$aux26."|".$aux27."|".$aux28."|".$aux29."|".$aux36."|".$aux37."|".$aux38."|".$aux39."|".$aux42."|".$aux43."|".$aux44."|".$aux45."|".$aux46."|".$aux47."|".$aux48."|".$aux49."|".$aux50."|".$aux51;
		$intro=resultats::escribirañadirDT($nomarchivoDT,$linea);
		//Rellenar lineas CSV
		
		$linea2=number_format($aux10,2).";".number_format($aux18,2).";".number_format($aux1,2).";".number_format($aux42,2).";".number_format($aux46,2).";".number_format($aux44,2).";".number_format($aux18,2).";".number_format($aux43,2).";".number_format($aux5,2).";".number_format($aux15,2).";".number_format($aux23,2)."\n";
		if (fwrite($handle, utf8_decode($linea2).PHP_EOL) === FALSE) {  
			echo "Cannot write to file";  
			exit;  
			}  
		

		}
	fclose($handle);
	//header("location:ResultEnergySupply.php?t=Results Energy Supply&projh=$projh");
	print "<meta http-equiv=Refresh content=\"2 ; url=ResultEnergySupply.php?t=Energy Demand Results&projh=$projh\">";

	
?>