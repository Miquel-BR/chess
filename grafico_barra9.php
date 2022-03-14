<?php

if(isset($_GET['nomarchivo'])){
	$nomarchivo=$_GET['nomarchivo'];
	//$arrayTemp=resultats::leerarchivotemps($nomarchivoDT);
	
	$filas=file($nomarchivo); 

	$i=0; 
	$numero_fila=0; 
	$arrayTemp = array("mes","year","Ee","Qaux","Est","DT");
	while($filas[$i]!=NULL && $i<=17519){ 
		$row = $filas[$i]; 
		$sql = explode("|",$row);
		
		$arrayTemp[$i]=array("mes"=>$sql[3],"year"=>$sql[4],"Ee"=>$sql[38],"Qaux"=>$sql[40],"Est"=>$sql[36],"DT"=>$sql[5]);
		$i++; 
		}
$i=1;$Sum1=0;$Sum2=0;$Sum3=0;$mesant=1;$inicio=1;
	foreach ($arrayTemp as $aux)
	{

	
	//leer mes
	$year=$aux['year'];
	if($year==2)
		{
		$mes=$aux['mes'];
		$Ee=$aux['Ee'];
		$Qaux=$aux['Qaux'];
		$Est=$aux['Est'];
		$DT=$aux['DT'];
	
	
		$Sum1=$Sum1+$Ee;
		$Sum2=$Sum2+$Qaux;
		//$Sum3=$Sum3+$Est;
		$Sum3=$Sum3+$DT;
		}
	}
	
	
	$Sum1=$Sum1/1000000;
	$Sum2=$Sum2/1000000;
	$Sum3=$Sum3/1000000;
	$Sum4=$Sum3-$Sum2-$Sum1;
			$datay1=array($Sum1);
			array_push($datay1,$Sum2);
			array_push($datay1,$Sum4);
			

}





require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');
require_once ('jpgraph/src/jpgraph_bar.php');
require_once ('jpgraph/src/jpgraph_error.php');

require_once ("jpgraph/src/jpgraph_pie.php");
 
// Se define el array de valores y el array de la leyenda
$datos = array(40,60,21,33);
$leyenda = array("Morenas","Rubias","Pelirrojas","Otras");
$datos2 = array(40,60,21,33);
$leyenda2 = array("Morenas","Rubias","Pelirrojas","Otras");

$leyenda3=array("Heat Pump","Auxiliar","Solar Contribution");
//Se define el grafico
$grafico = new PieGraph(400,300);
 
//Definimos el titulo
$grafico->title->Set("Energy Supply");
$grafico->title->SetFont(FF_FONT1,FS_BOLD);

//Añadimos el titulo y la leyenda
$p1 = new PiePlot($datay1);
$p1->SetLegends($leyenda3);
$p1->SetCenter(50,0.4);
$p1->SetSliceColors("#6495ED","#B22222","#E3E3E3");
//Añadimos el titulo y la leyenda
//$p2 = new PiePlot($datos2);
//$p2->SetLegends($leyenda2);
//$p2->SetCenter(50,0.4);
 
//Se muestra el grafico
$grafico->Add($p1);
//$grafico->Add($p2);
$grafico->Stroke();





?>