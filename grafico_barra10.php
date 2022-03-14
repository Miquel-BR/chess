<?php

if(isset($_GET['nomarchivo'])){
	$nomarchivo=$_GET['nomarchivo'];
	//$arrayTemp=resultats::leerarchivotemps($nomarchivoDT);
	
	$filas=file($nomarchivo); 

	$i=0; 
	$numero_fila=0; 
	$arrayTemp = array("mes","year","Ee","Qaux","Est","DT","Qa2","Pa2","Pd34");
	while($filas[$i]!=NULL && $i<=17519){ 
		$row = $filas[$i]; 
		$sql = explode("|",$row);
		
		$arrayTemp[$i]=array("mes"=>$sql[3],"year"=>$sql[4],"Ee"=>$sql[38],"Qaux"=>$sql[40],"Est"=>$sql[36],"DT"=>$sql[5],"Qa2"=>$sql[26],"Pa2"=>$sql[27],"Pa1"=>$sql[19],"Pdistr2"=>$sql[46],"Pd34"=>$sql[48]);
		$i++; 
		}
$i=1;$Sum1=0;$Sum2=0;$Sum3=0;$Sum5=0;$mesant=1;$inicio=1;
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
		$Qa2=$aux['Qa2'];
		$Pa2=$aux['Pa2'];
		$Pa1=$aux['Pa1'];
		$Pdistr2=$aux['Pdistr2'];
		$Pd34=$aux['Pd34'];
	
		$Sum1=$Sum1+$Ee;
		$Sum2=$Sum2+$Qaux;
		//$Sum3=$Sum3+$Est;
		$Sum3=$Sum3+$DT;
		//$Sum5=$Sum5+($Est-$Qa2-$Pa2-$Pd34);
		$Sum5=$Sum5+($Est-($DT-$Ee-$Qaux)-abs($Pa2)-abs($Pa1)-abs($Pdistr2));
		//$Sum5=$Sum5+($Est-($DT-$Ee-$Qaux));
		}
	}
	
	
	$Sum1=$Sum1/1000000;
	$Sum2=$Sum2/1000000;
	$Sum3=$Sum3/1000000;
	$Sum5=$Sum5/1000000;
	$Sum4=$Sum3-$Sum1-$Sum2;
			$datay1=array($Sum1,0,0,0,0);
			$datay2=array(0,($Sum2),0,0,0);
			$datay3=array(0,0,$Sum4,0,0);
			$datay4=array(0,0,0,$Sum3,0);
			$datay5=array(0,0,0,0,$Sum5);

}





require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');
require_once ('jpgraph/src/jpgraph_bar.php');
require_once ('jpgraph/src/jpgraph_error.php');

require_once ("jpgraph/src/jpgraph_pie.php");
 
// Se define el array de valores y el array de la leyenda
//$datos = array(40,60,21,33);
//$leyenda = array("Morenas","Rubias","Pelirrojas","Otras");
//$datos2 = array(40,60,21,33);
//$leyenda2 = array("Morenas","Rubias","Pelirrojas","Otras");

$leyenda3=array("Heat Pump","Auxiliar","Solar");
//Se define el grafico
$grafico = new Graph(400,300);
$grafico->SetScale('textint');

$theme_class=new UniversalTheme;

//$graph->SetTheme($theme_class);
$grafico->img->SetAntiAliasing(false);


//Definimos el titulo
$grafico->title->Set("Energy Supply");
$grafico->title->SetFont(FF_FONT1,FS_BOLD);
 
//Añadimos el titulo y la leyenda
//$p1 = new BarPlot($datay1);
//$p1->SetLegends($leyenda3);
//$p1->SetCenter(50,0.4);

$p1 = new BarPlot($datay1);
$grafico->Add($p1);
$p1->SetFillColor("#6495ED");
//$p1->SetFillColor("#6495ED");
$p1->SetLegend('Heat Pump');

$p2 = new BarPlot($datay3);
$grafico->Add($p2);
//$p2->SetFillColor("#E3E3E3");
$p2->SetFillColor("#00E699");
//$p1->SetFillColor("#00E699");
$p2->SetLegend('Solar Contribution');

$p3 = new BarPlot($datay2);
$grafico->Add($p3);
//$p2->SetFillColor("#FF69B4");
//$p3->SetFillColor("#B22222");
$p3->SetFillColor("#FF69B4");
$p3->SetLegend('Auxiliar');

$p4 = new BarPlot($datay4);
$grafico->Add($p4);
//$p2->SetFillColor("#FF69B4");
//$p3->SetFillColor("#B22222");
$p4->SetFillColor("#B22222");
$p4->SetLegend('Total');
//Añadimos el titulo y la leyenda
//$p2 = new PiePlot($datos2);
//$p2->SetLegends($leyenda2);
//$p2->SetCenter(50,0.4);
 
$p5 = new BarPlot($datay5);
$grafico->Add($p5);
//$p2->SetFillColor("#FF69B4");
//$p3->SetFillColor("#B22222");
$p5->SetFillColor("#000000");
$p5->SetLegend('Solar Dissipated');
 
//Se muestra el grafico
//$grafico->Add($p1);
//$grafico->Add($p2);
$grafico->Stroke();





?>