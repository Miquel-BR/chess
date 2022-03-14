<?php

if(isset($_GET['nomarchivo'])){
	$nomarchivo=$_GET['nomarchivo'];
	//$arrayTemp=resultats::leerarchivotemps($nomarchivoDT);
	
	$filas=file($nomarchivo); 

	$i=0; $k=0;
	$numero_fila=0; 
	$arrayTemp = array("mes","BalanceDep2","Pa2","Qa2","BalanceST2","Est");
	while($filas[$i]!=NULL && $i<=17519){ 
		$row = $filas[$i]; 
		$sql = explode("|",$row);
		if($i>8760){
		$arrayTemp[$k]=array("mes"=>$sql[3],"BalanceDep2"=>$sql[45],"Pa2"=>$sql[27],"Qa2"=>$sql[26],"BalanceST2"=>$sql[43],"Est"=>$sql[36]);
		$k++;}
		$i++; 
		}
	$i=1;$Sum1=0;$Sum2=0;$Sum3=0;$mesant=1;$inicio=1;$Sum4=0;$Sum5=0;$Sum6=0;
	foreach ($arrayTemp as $aux)
	{

	
	//leer mes
	$mes=$aux['mes'];
	$BalanceDep2=$aux['BalanceDep2'];
	$Pa2=$aux['Pa2'];
	$Qa2=$aux['Qa2'];
	$BalanceST2=$aux['BalanceST2'];
	$Est=$aux['Est'];
	
	if($mes==$mesant)
		{
		$Sum1=$Sum1+$BalanceDep2;
		$Sum2=$Sum2+$Pa2;
		$Sum3=$Sum3+$Qa2;
		$Sum4=$Sum4+$BalanceST2;
		$Sum5=$Sum5+$Est;
		//$Sum6=$Sum6+$Pa1;
		}
	
	else
		{
		if($inicio==1){
			$Sum1=$Sum1/1000000;
			$Sum2=$Sum2/1000000;
			$Sum3=$Sum3/1000000;
			$Sum4=$Sum4/1000000;
			$Sum5=$Sum5/1000000;
			//$Sum6=$Sum6/1000000;
			$datay1=array($Sum1);
			$datay2=array($Sum2);
			$datay3=array($Sum3);
			$datay4=array(0);
			//$datay5=array(0);
			//$datay6=array(0);
			array_push($datay1,0);
			array_push($datay2,0);
			array_push($datay3,0);
			array_push($datay4,$Sum4);
			//array_push($datay5,$Sum5);
			//array_push($datay6,$Sum6);
			$inicio=0;
			}
		else{
			$Sum1=$Sum1/1000000;
			$Sum2=$Sum2/1000000;
			$Sum3=$Sum3/1000000;
			$Sum4=$Sum4/1000000;
			$Sum5=$Sum5/1000000;
			//$Sum6=$Sum6/1000000;

			array_push($datay1,$Sum1);
			array_push($datay2,$Sum2);
			array_push($datay3,$Sum3);
			array_push($datay4,0);
			//array_push($datay5,0);
			//array_push($datay6,0);

			array_push($datay1,0);
			array_push($datay2,0);
			array_push($datay3,0);
			array_push($datay4,$Sum4);
			//array_push($datay5,$Sum5);
			//array_push($datay6,$Sum6);
	
			}
		$mesant=$mes;
		$Sum1=$BalanceDep2;
		$Sum2=$Pa2;
		$Sum3=$Qa2;
		$Sum4=$BalanceST2;
		$Sum5=$Est;
		//$Sum6=$Pa1;
		}
	
	}
	
	
			$Sum1=$Sum1/1000000;
			$Sum2=$Sum2/1000000;
			$Sum3=$Sum3/1000000;
			$Sum4=$Sum4/1000000;
			$Sum5=$Sum5/1000000;
			//$Sum6=$Sum6/1000000;

			array_push($datay1,$Sum1);
			array_push($datay2,$Sum2);
			array_push($datay3,$Sum3);
			array_push($datay4,0);
			//array_push($datay5,0);
			//array_push($datay6,0);

			array_push($datay1,0);
			array_push($datay2,0);
			array_push($datay3,0);
			array_push($datay4,$Sum4);
			//array_push($datay5,$Sum5);
			//array_push($datay6,$Sum6);


}





require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');
require_once ('jpgraph/src/jpgraph_bar.php');
require_once ('jpgraph/src/jpgraph_error.php');



//$datay1 = array(1,2,3,4,5,6,45,10,5,45,60,7,8,1,2,3,4,5,6,45,10,5,45,60,1,2,3,4,5,6,45,10,5,45,60,7,8,1,2,3,4,5,6,45,10,5,45);
//$datay1 = array($DTTotal[1],$DTTotal[2],$DTTotal[3],$DTTotal[4],$DTTotal[5],$DTTotal[6],$DTTotal[7],$DTTotal[8],$DTTotal[9],$DTTotal[10],$DTTotal[11],$DTTotal[12]);
//$datay2 = array(12,9,12,8,41,15,30,8,48,36,14,25,12,9,12,8,41,15,30,8,48,36,14,25,12,9,12,8,41,15,30,8,48,36,14,25,12,9,12,8,41,15,30,8,48,36,14,25);
//$datay3 = array(5,17,32,24,4,2,36,2,9,24,21,23,5,17,32,24,4,2,36,2,9,24,21,23,5,17,32,24,4,2,36,2,9,24,21,23,5,17,32,24,4,2,36,2,9,24,21,23);
//$datay2 = array($DTHeating[1],$DTHeating[2],$DTHeating[3],$DTHeating[4],$DTHeating[5],$DTHeating[6],$DTHeating[7],$DTHeating[8],$DTHeating[9],$DTHeating[10],$DTHeating[11],$DTHeating[12]);
//$datay3 = array($DTHotwater[1],$DTHotwater[2],$DTHotwater[3],$DTHotwater[4],$DTHotwater[5],$DTHotwater[6],$DTHotwater[7],$DTHotwater[8],$DTHotwater[9],$DTHotwater[10],$DTHotwater[11],$DTHotwater[12]);
//$data1=array($vTemp1[1],$vTemp1[2],$vTemp1[3],$vTemp1[4],$vTemp1[5],$vTemp1[6],$vTemp1[7],$vTemp1[8],$vTemp1[9],$vTemp1[10],$vTemp1[11],$vTemp1[12]);
//$data2=array($vTemp2[1],$vTemp2[2],$vTemp2[3],$vTemp2[4],$vTemp2[5],$vTemp2[6],$vTemp2[7],$vTemp2[8],$vTemp2[9],$vTemp2[10],$vTemp2[11],$vTemp2[12]);
// Setup the graph
$graph = new Graph(800,350);
//$graph->SetScale("textlog");
$graph->SetScale('textint');

$theme_class=new UniversalTheme;
$titulo="Energy Balance:Seasonal Storage System";
//$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set($titulo);
$graph->SetBox(false);
$graph->SetFrame(false);
//$graph->yaxis->SetLabelMargin(20);
$graph->img->SetAntiAliasing();
//$graph->yaxis->scale->SetGrace(10,10);
//$graph->yaxis->SetTicklabelmargin(10);
//$graph->yaxis->SetLabelMargin(30);

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);
//$graph->yaxis->SetLabelPos(SIDE_RIGHT);
$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
//$graph->yaxis->SetTickSize(0,10000000);
$graph->yaxis->SetTitle('MWh ','middle'); 
//$graph->yaxis->SetTickLabels(array(5000000,10000000,15000000,20000000,25000000,30000000,35000000,40000000,45000000,50000000,55000000,60000000));
$graph->xaxis->SetTickLabels(array('Ene','','Feb','','Mar','','Abr','', 'May','', 'Jun','', 'Jul','', 'Ago','', 'Sep','', 'Oct','', 'Nov','', 'Dic','','Ene','','Feb','','Mar','','Abr','', 'May','', 'Jun','', 'Jul','', 'Ago','', 'Sep','', 'Oct','', 'Nov','', 'Dic',''));

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

$p1 = new BarPlot($datay1);
$graph->Add($p1);
$p1->SetFillColor("#6495ED");
//$p1->SetFillColor("#6495ED");
$p1->SetLegend('Seasonal Storage System');



// Create the second line
//$p2 = new BarPlot($datay2);
$p2 = new BarPlot($datay2);
$graph->Add($p2);
$p2->SetFillColor("#B22222");
$p2->SetLegend('Lose');

// Create the third line
$p3 = new BarPlot($datay3);
$graph->Add($p3);
$p3->SetFillColor("#FF1493");
$p3->SetLegend('Heat Pump');

$p4 = new BarPlot($datay4);
$graph->Add($p4);
$p4->SetFillColor("#edbc64");
//$p1->SetFillColor("#6495ED");
$p4->SetLegend('Solar');


/*
// Create the second line
//$p2 = new BarPlot($datay2);
$p5 = new BarPlot($datay5);
$graph->Add($p5);
$p5->SetFillColor("#95ed64");
$p5->SetLegend('Supply');

// Create the third line
$p6 = new BarPlot($datay6);
$graph->Add($p6);
$p6->SetFillColor("#dead64");
$p6->SetLegend('Lose');

$graph->legend->SetFrameWeight(1);
*/
// Output line
$graph->Stroke();



?>