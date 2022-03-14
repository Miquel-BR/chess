<?php

//define('__ROOT__', dirname(dirname(__FILE__)));
//require_once ('class/gestio_projectesBBDD.php');
//require_once('class/distribuciofrecuencies.php');
//require_once('class/projectes.php');

require('class/projectes.php');
require('class/calculs.php');
$varunserDTTotal="Sin vector";
if(isset($_GET['varpaso1'])){
	$varunserDTTotal=$_GET['varpaso1'];
	$DTTotal=stripslashes($varunserDTTotal); 
	$DTTotal = urldecode($DTTotal); 
	$DTTotal = unserialize($DTTotal);
	
	}
$sumDTTotal=0;
for($i=1;$i<=12;$i++)
	{$sumDTTotal=$sumDTTotal+$DTTotal[$i];}
if(isset($_GET['varpaso2'])){
	$varunserDTHeating=$_GET['varpaso2'];
	$DTHeating=stripslashes($varunserDTHeating); 
	$DTHeating = urldecode($DTHeating); 
	$DTHeating = unserialize($DTHeating);
	
	}
$sumDTHeating=0;
for($i=1;$i<=12;$i++)
	{$sumDTHeating=$sumDTHeating+$DTHeating[$i];}

if(isset($_GET['varpaso3'])){
	$varunserDTHotwater=$_GET['varpaso3'];
	$DTHotwater=stripslashes($varunserDTHotwater); 
	$DTHotwater = urldecode($DTHotwater); 
	$DTHotwater = unserialize($DTHotwater);
	
	}
$sumDTHotwater=0;
for($i=1;$i<=12;$i++)
	{$sumDTHotwater=$sumDTHotwater+$DTHotwater[$i];}

//$aux=projectes::getprojecteactual();
//$projecte=$aux['nomproject'];
//$localitat=$aux['localitat'];
//$demanda=$aux['nomdemanda'];
//$titulgraf="Energy Demand";

//$db="scacs2";
//$con="";
//$count="No inicializado";
//$texto="No inicializado";
//$mysqli=new mysqli('localhost','root','','scacs2');
//if(mysqli_connect_errno()){$texto="No db";}

//$DTHeating=calculs::obtenerDTmensual($projecte,4,$demanda);
//$DTHotwater=calculs::obtenerDTmensual($projecte,5,$demanda);
$i=1;
$numDTTotal=count($DTTotal);
$text="SD";
$text=$text.",".$DTTotal[1].",".$DTTotal[2].",".$DTTotal[3].",".$DTTotal[4].",".$DTTotal[5].",".$DTTotal[12];
//foreach($DTHeating as $ar)
//	{
//	$aux[$i]=$ar;
//	$i++;
//	}
$i=1;
//foreach($DTHotwater as $ar)
//	{
//	$DTTotal[$i]=($aux[$i]+$ar)*1000;
//	$i++;
//	}
//session_start();
//$DTTotal=$_SESSION['SendDTTotal'];

require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');
require_once ('jpgraph/src/jpgraph_bar.php');
require_once ('jpgraph/src/jpgraph_error.php');



//$datay1 = array(1,2,3,4,5,6,45,10,5,45,60,7,8);
$datay1 = array(0,0,$DTTotal[1],0,0,$DTTotal[2],0,0,$DTTotal[3],0,0,$DTTotal[4],0,0,$DTTotal[5],0,0,$DTTotal[6],0,0,$DTTotal[7],0,0,$DTTotal[8],0,0,$DTTotal[9],0,0,$DTTotal[10],0,0,$DTTotal[11],0,0,$DTTotal[12]);
//$datay2 = array(12,9,12,8,41,15,30,8,48,36,14,25);
//$datay3 = array(5,17,32,24,4,2,36,2,9,24,21,23);
$datay2 = array($DTHeating[1],0,0,$DTHeating[2],0,0,$DTHeating[3],0,0,$DTHeating[4],0,0,$DTHeating[5],0,0,$DTHeating[6],0,0,$DTHeating[7],0,0,$DTHeating[8],0,0,$DTHeating[9],0,0,$DTHeating[10],0,0,$DTHeating[11],0,0,$DTHeating[12],0,0,);
$datay3 = array(0,$DTHotwater[1],0,0,$DTHotwater[2],0,0,$DTHotwater[3],0,0,$DTHotwater[4],0,0,$DTHotwater[5],0,0,$DTHotwater[6],0,0,$DTHotwater[7],0,0,$DTHotwater[8],0,0,$DTHotwater[9],0,0,$DTHotwater[10],0,0,$DTHotwater[11],0,0,$DTHotwater[12],0);


// Setup the graph
$graph = new Graph(800,350);
//$graph->SetScale("textlin");
$graph->SetScale('linlin',0,0,0,36);
$theme_class=new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set("Energy Demand");
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");

$graph->xaxis->SetTickLabels(array('','Gen','','','Feb','','','Mar','','','Apr','','','May','','','Jun','','','Jul','','','Ago','','','Sep','','','Oct','','','Nov','','','Dec',''));

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
//$p1 = new BarPlot($ydata);
$p1 = new BarPlot($datay1);
$graph->Add($p1);
$p1->SetFillColor("#6495ED");
$p1->SetLegend("Total");

// Create the second line
$p2 = new BarPlot($datay2);
$graph->Add($p2);
$p2->SetColor("#B22222");
$p2->SetLegend('Heating');

// Create the third line
$p3 = new BarPlot($datay3);
$graph->Add($p3);
$p3->SetColor("#FF1493");
$p3->SetLegend('Hot Water');

$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();



?>