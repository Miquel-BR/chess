<?php

//define('__ROOT__', dirname(dirname(__FILE__)));
require_once ('class/gestio_projectesBBDD.php');
require_once('class/distribuciofrecuencies.php');
//include ('jpgraph/src/db.inc");
require_once('class/projectes.php');

$iddistribucio=1;
$x=0;




$titulgraf="Evolucio";
$sendlocalitat="No localitat";
if(isset($_GET['distribucio'])){
	$distribucio=$_GET['distribucio'];}
if(isset($_GET['iddistribucio'])){
	$iddistribucio=$_GET['iddistribucio'];}
if(isset($_GET['tipograf'])){
	$tipograf=$_GET['tipograf'];}

if(isset($_GET['tipusdistribucio'])){
	$tipusdistribucio=$_GET['tipusdistribucio'];}
if(isset($_GET['quantitat'])){
	$quantitat=$_GET['quantitat'];}
if(isset($_GET['localitat'])){
	$sendnomdistribucio=$_GET['localitat'];}
if(isset($_GET['mes'])){
	$sendmes=$_GET['mes'];}
if(isset($_GET['projecte'])){
	$projecte=$_GET['projecte'];}

$db="scacs2";
$con="";
$count="No inicializado";
$texto="No inicializado";

//$aux=projectes::getprojecteactual();
//$projecte=$aux['nomproject'];
$query="";$query4="sin datos";
//BBDD link inicial
		$i=0;
		$filas=file("BBDD.txt"); $arrayTemp = array("nameBBDD","host","user","pass");
		foreach($filas as $fila){
			if($i==0){$sql = explode("|",$fila);}
			$i++; 
		}
//$mysqli=new mysqli('localhost','root','','scacs2');
$mysqli=new mysqli($sql[1],$sql[2],$sql[3],$sql[0]);
if(mysqli_connect_errno()){$texto="No db";}
//BBDD link a la clase

// Some data
//Diferentes casos:
if($tipusdistribucio=="ref")
{$tipotabla1="distribucions_anuals";$tipotabla2="distribucions_diaries";$campoprojecto="";}
if($tipusdistribucio=="proj")
{$tipotabla1="distribucions_anuals_projectes";$tipotabla2="distribucions_diaries_projectes";$campoprojecto=" and projecte='".$projecte."'";}
//if(($iddistribucio==1) || ($iddistribucio==2) || ($iddistribucio==3) || ($iddistribucio==8))
//	{$tipocampo="localitat";}
//if(($iddistribucio==4) || ($iddistribucio==5) || ($iddistribucio==6) || ($iddistribucio==7))
//	{$tipocampo="demand";}
		
		//$tipocampo="localitat";
		$query3="select tipo from tipus_distribucio where id_distribucio='$iddistribucio'";
		$result3=$mysqli->query($query3);
		while($row3 = $result3->fetch_object())
			{$auxtipus=$row3->tipo;}
		
		if($auxtipus=='2'){$tipocampo="localitat";}
		if($auxtipus=='1'){$tipocampo="demand";}
		
		$result3->free();
//Si es tipo demand dará % y por lo tanto hay que ir a buscar cantidades
if($tipograf=="mes")
	{
	$query = "select valor from $tipotabla1 where idDistribucio_anual='$iddistribucio' and $tipocampo='$sendnomdistribucio' $campoprojecto group by mes order by mes";
	//$query = "select valor from distribucions_anuals where idDistribucio_anual='$iddistribucio'";
	}
if($tipograf=="hor")
	{
	$query = "select valor from $tipotabla2 where idDistribucio_diaria='$iddistribucio' and $tipocampo='$sendnomdistribucio' and mes=$sendmes $campoprojecto group by hora order by hora";
	//$query = "select valor from distribucions_diaries where idDistribucio_diaria='$iddistribucio'";
	$query4 = "select max(valor) as maximo from $tipotabla2 where idDistribucio_diaria='$iddistribucio' and $tipocampo='$sendnomdistribucio' $campoprojecto group by hora order by hora";

	}

$textq=$query;
//$textq="n";
$ydata = array();
$i=1;


$query2="sin datos";
$quantitat=1;
if($tipocampo=="demand")
	{
	$query2="select * from projectedemandes where projecte='$projecte'";
	$result2=$mysqli->query($query2);
	//while ($row=$result2->fetch_assoc()){
	while($row = $result2->fetch_object()){
            $auxheat=$row->heatingdemand;
			$auxhotwater=$row->hotwaterdemand;
			$auxcool=$row->coolingdemand;
			$auxelec=$row->electricappdemand;
            
        } 
	
		if($iddistribucio==4){$quantitat=$auxheat;}
		if($iddistribucio==5){$quantitat=$auxhotwater;}
		if($iddistribucio==6){$quantitat=$auxcool;}
		if($iddistribucio==7){$quantitat=$auxelec;}
		//$quantitat=$quantitat/100;
		$result2->free();
		//$i=1;
		//$query3 = "select valor from distribucions_anuals_projectes where idDistribucio_anual='$iddistribucio' and demand='$sendnomdistribucio' and projecte='$projecte' order by mes";
		
		//$result=$mysqli->query($query3);//($query,gestio_projectesBBDD::$dbconn);
		//while ($row = $result->fetch_assoc()) {
        //$aux1[$i]['valor']=($row->valor)*$quantitat;
		//$i++;
		//}
		//$result->free();
		
		
	
	
	}
	
if($sendmes==1){$numdias=31;}
if($sendmes==2){$numdias=28;}
if($sendmes==3){$numdias=31;}
if($sendmes==4){$numdias=30;}
if($sendmes==5){$numdias=31;}
if($sendmes==6){$numdias=30;}
if($sendmes==7){$numdias=31;}
if($sendmes==8){$numdias=31;}
if($sendmes==9){$numdias=30;}
if($sendmes==10){$numdias=31;}
if($sendmes==11){$numdias=30;}
if($sendmes==12){$numdias=31;}

if($tipocampo=="demand" && $tipograf=="hor")
	{
	$i=1;
	//$v_dadesdismesdemandaproj=distribuciofrecuencies::getdadesdistribucioanualmesdemandaprojecte($iddistribucio,$sendnomdistribucio,$sendmes,$projecte);
	$query3 = "select valor from distribucions_anuals_projectes where idDistribucio_anual='$iddistribucio' and demand='$sendnomdistribucio' and mes='$sendmes' and projecte='$projecte'";
	
	$result3=$mysqli->query($query3);
	//while ($row=$result2->fetch_assoc()){
	while($row[$i] = $result3->fetch_object()){
            $auxq=$row[$i]->valor;
			$i++;
            
       } 

	
	$numdadesdismesdemandaproj=count($row)-1;
	if($numdadesdismesdemandaproj>0)
		{
		foreach($row as $ar)
			{	
			//$auxcool=$row->coolingdemand;
			//$auxq=$ar->valor;
			//$auxq=1;
			}
		}
	else {$auxq=1;}
	$quantitat=$quantitat*($auxq/100)/$numdias;
			
	//		}
	$result3->free();
	}






$queryname=$query;
$resultado=$mysqli->query($query);
if(!$resultado){$texto="No resultado";}
$maxy=0;
while ($data=$resultado->fetch_assoc()){
	$texto=$data["valor"];
	if($tipocampo=="demand")
		{
		$texto=($texto*$quantitat)/100;		
		//if($texto>$maxy){$maxy=$texto;}
		}
	//array_push($ydata,$texto);
	$ydata[]=$texto;
	}


$resultado->free();
$texto1=0;
$maxy=0;
if($tipocampo!="demand" && $tipograf=="hor"){
	if($query4!="sin datos")
	{
	$resultado=$mysqli->query($query4);
	if(!$resultado){$texto1="No resultado";}
	while ($data=$resultado->fetch_assoc()){
		$texto1=$data['maximo'];
		if($texto1>$maxy){$maxy=$texto1;};
		}
	}
$maxy=$maxy*1.1;
//echo "$query4,$maxy";
$resultado->free();
}



$txttitul="";
$query="select unitat_distribucio from tipus_distribucio where id_distribucio='$iddistribucio'";
$resultado=$mysqli->query($query);
if(!$resultado){$texto="No resultado consulta 2";}
while ($data2=$resultado->fetch_assoc()){
	$unitat=$data2["unitat_distribucio"];}
$resultado->free();

//mysqli->close();

if($tipograf=="mes"){$txttitul="Yearly distribution. ".$unitat;}
if($tipograf=="hor"){$txttitul="Daily distribution. ".$unitat;}
if($tipusdistribucio=="1"){$txttitul=$txttitul." Yearly Quantity: ".$quantitat." (Percentage distribution)";}

$titulgraf=$distribucio.": ".$txttitul;

require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');
require_once ('jpgraph/src/jpgraph_bar.php');
require_once ('jpgraph/src/jpgraph_error.php');



$datay1 = array(1,2,3,4,5,6,45,10,5,45,60,7);
$datay2 = array(12,9,12,8,41,15,30,8,48,36,14,25);
$datay3 = array(5,17,32,24,4,2,36,2,9,24,21,23);


// Setup the graph
$graph = new Graph(900,350);
if($maxy>0){
$graph->SetScale("textlin",0,$maxy);}
else {$graph->SetScale("textlin");}

$theme_class=new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set($titulgraf);
//$graph->title->Set($queryname);
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->scale->SetGrace(20);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);
$graph->SetMargin(80,40,20,80);
$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
if($tipograf=="mes"){
	$graph->xaxis->SetTickLabels(array('Ene','Feb','Mar','Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'));
	}
else {
	$graph->xaxis->SetTickLabels(array('1','2','3','4', '5', '6', '7', '8', '9', '10', '11', '12','13','14','15','16','17','18','19','20','21','22','23','24'));
	}
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
$p1 = new BarPlot($ydata);
$graph->Add($p1);
$p1->SetFillColor("#6495ED");
$p1->SetLegend($distribucio);

// Create the second line
$p2 = new LinePlot($datay2);
//$graph->Add($p2);
$p2->SetColor("#B22222");
$p2->SetLegend('Tienda 2');

// Create the third line
$p3 = new LinePlot($datay3);
//$graph->Add($p3);
$p3->SetColor("#FF1493");
$p3->SetLegend('Tienda 3');

$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();

?>