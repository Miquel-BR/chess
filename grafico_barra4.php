<?php

//define('__ROOT__', dirname(dirname(__FILE__)));
//require_once ('class/gestio_projectesBBDD.php');
//require_once('class/distribuciofrecuencies.php');
//require_once('class/projectes.php');

require('class/projectes.php');
require('class/calculs.php');
$varTemp1="Sin vector";
//if(isset($_GET['varTemp1'])){
	//$varunserTemp1=$_GET['varTemp1'];
	//$vTemp1=stripslashes($varunserTemp1); 
	//$vTemp1 = urldecode($vTemp1); 
	//$vTemp1 = unserialize($vTemp1);
	
	//}

$varTemp2="Sin vector";
//if(isset($_GET['varTemp2'])){
	//$varunserTemp2=$_GET['varTemp2'];
	//$vTemp2=stripslashes($varunserTemp2); 
	//$vTemp2 = urldecode($vTemp2); 
	//$vTemp2 = unserialize($vTemp2);
	
	//}

if(isset($_GET['nomarchivo'])){
	$nomarchivo=$_GET['nomarchivo'];
	//$arrayTemp=resultats::leerarchivotemps($nomarchivoDT);
	
	$filas=file($nomarchivo); 

	$i=0; $k=0;
	$numero_fila=0; 
	$arrayTemp = array("numhora","hora","dia","mes","year","Ta1","Ta2");
	$text="";
	while($filas[$i]!=NULL && $i<=17519){ 
		$row = $filas[$i]; 
		$sql = explode("|",$row); 
		if($i>8760){
		$vTemp1[$k]=(float)$sql[14];
		$vTemp2[$k]=(float)$sql[22];
		if ($vTemp1[$k]<0)
			{
			$text=$text.",".$i;
			}
		//$arrayTemp[$i]=array("numhora"=>$i,"hora"=>$sql[1],"dia"=>$sql[2],"mes"=>$sql[3],"year"=>$sql[4],"Ta1"=>$sql[14],"Ta2"=>$sql[22]);
		$k++;
		}
		$i++; $numero_fila++;
		}
$i=1;
//foreach ($arrayTemp as $aux)
//	{
	
		$datay1=array($vTemp1[0]);
		$datay2=array($vTemp2[0]);
	
	while($i<$k){
		
			array_push($datay1,$vTemp1[$i]);
			array_push($datay2,$vTemp2[$i]);
			
		$i++;
		}

}



require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');
require_once ('jpgraph/src/jpgraph_bar.php');
require_once ('jpgraph/src/jpgraph_error.php');



//$datay1 = array(1,2,3,4,5,6,45,10,5,45,60,7,8);
//$datay1 = array($DTTotal[1],$DTTotal[2],$DTTotal[3],$DTTotal[4],$DTTotal[5],$DTTotal[6],$DTTotal[7],$DTTotal[8],$DTTotal[9],$DTTotal[10],$DTTotal[11],$DTTotal[12]);
//$datay2 = array(12,9,12,8,41,15,30,8,48,36,14,25);
//$datay3 = array(5,17,32,24,4,2,36,2,9,24,21,23);
//$datay2 = array($DTHeating[1],$DTHeating[2],$DTHeating[3],$DTHeating[4],$DTHeating[5],$DTHeating[6],$DTHeating[7],$DTHeating[8],$DTHeating[9],$DTHeating[10],$DTHeating[11],$DTHeating[12]);
//$datay3 = array($DTHotwater[1],$DTHotwater[2],$DTHotwater[3],$DTHotwater[4],$DTHotwater[5],$DTHotwater[6],$DTHotwater[7],$DTHotwater[8],$DTHotwater[9],$DTHotwater[10],$DTHotwater[11],$DTHotwater[12]);
//$data1=array($vTemp1[1],$vTemp1[2],$vTemp1[3],$vTemp1[4],$vTemp1[5],$vTemp1[6],$vTemp1[7],$vTemp1[8],$vTemp1[9],$vTemp1[10],$vTemp1[11],$vTemp1[12]);
//$data2=array($vTemp2[1],$vTemp2[2],$vTemp2[3],$vTemp2[4],$vTemp2[5],$vTemp2[6],$vTemp2[7],$vTemp2[8],$vTemp2[9],$vTemp2[10],$vTemp2[11],$vTemp2[12]);
// Setup the graph
$graph = new Graph(800,350);
//$graph->SetScale("textlin");
$graph->SetScale('linlin',0,0,0,8760);
$theme_class=new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set("Temperature Evolution");
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");

$graph->xaxis->SetTickLabels(array('Ene','Feb','Mar','Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'));

$graph->xgrid->SetColor('#E3E3E3');


// Creamos barras de datos a partir del array de datos
//$bplot = new BarPlot($datosy);
 
// Configuramos color de las barras
//$bplot->SetFillColor('#479CC9');
 
//Añadimos barra de datos al grafico
//$grafico->Add($bplot);
 
// Queremos mostrar el valor numerico de la barra
//$bplot->value->Show();

// Create the first line

$p1 = new LinePlot($datay1);
$graph->Add($p1);
$p1->SetColor("#6495ED");
//$p1->SetFillColor("#6495ED");
$p1->SetLegend('Deposit Use Tank');



// Create the second line
//$p2 = new BarPlot($datay2);
$p2 = new LinePlot($datay2);
$graph->Add($p2);
$p2->SetColor("#B22222");
$p2->SetLegend('Seasonal Deposit');

// Create the third line
//$p3 = new BarPlot($datay3);
//$graph->Add($p3);
//$p3->SetColor("#FF1493");
//$p3->SetLegend('Hot Water');

$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();



?>