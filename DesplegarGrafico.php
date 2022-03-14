<?php

include('header.php');
?>
<?php
// INCLUDES
require_once("class/gestio_projectesBBDD.php");
require_once("class/distribuciofrecuencies.php");
require_once("class/graficos.php");
require_once("class/projectes.php");
require_once("class/demandas.php");

gestio_projectesBBDD::setup();
//paso por POST de la distribucionparagraficar

//Paso de la distribucion elegida
$error="Sin error";
if(isset($_POST['distribuciografiques']))
	{
	$iddistribucio=$_POST['distribuciografiques'];
	}
if(isset($_GET['distribuciografiques']))
	{
	$iddistribucio=$_GET['distribuciografiques'];
	}
if(isset($_POST['localitatsgrafiques'])){$sendlocalitat=$_POST['localitatsgrafiques'];}
if(isset($_GET['localitatsgrafiques'])){$sendlocalitat=$_GET['localitatsgrafiques'];}
if(isset($_POST['tipograf'])){$tipografico=$_POST['tipograf'];}
if(isset($_GET['tipograf'])){$tipografico=$_GET['tipograf'];}
if(isset($_GET['tipusdis'])){$tipusdis=$_GET['tipusdis'];}
if(isset($_POST['tipusdis'])){$tipusdis=$_POST['tipusdis'];}
if (isset($_POST['mesgraf'])){$mesgraf=$_POST['mesgraf'];} else { $mesgraf=1;}
if(isset($_POST['btn1']) || isset($_POST['btn2']) || isset($_POST['anterior']) || isset($_POST['posterior'])) {	
	if(isset($_POST['iddistribucio'])){
		$iddistribucio=$_POST['iddistribucio'];}
	else{$error="no ha pasado iddis";}
	}
if (isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}

//if(isset($_POST['tipusdistribucio'])){
//		$tipusdistribucio=$_POST['tipusdistribucio'];}
//	else{$error="no ha pasado tipusdistribucio";}
//if(isset($_POST['quantitat'])){
//		$quantitat=$_POST['quantitat'];}
//	else{$error="no ha pasado quantitats";}


//$aux=projectes::getprojecteactual();
//$projecte=$aux['nomproject'];
$projecte=$projh;


//$numdishoraria=distribuciofrecuencies::checkdistribuciodiaria($iddistribucio,$sendlocalitat);
//$numdismensual=distribuciofrecuencies::checkdistribucioanual($iddistribucio,$sendlocalitat);
$typodist=distribuciofrecuencies::gettipoporid($iddistribucio);
if($typodist==1)
	{//Buscar demanda
	$demandaprojhorarray=demandas::getdemandaproject2($projecte);
	$demandaprojhor=$demandaprojhorarray['nomdemanda'];
	}
else {$demandaprojhor=$sendlocalitat;}
//$valordishoraria=distribuciofrecuencies::getdistribucioproj($iddistribucio,$sendlocalitat,$projecte,'hor');
$valordishoraria=distribuciofrecuencies::getdistribucioproj($iddistribucio,$demandaprojhor,$projecte,'hor');
$valordismensual=distribuciofrecuencies::getdistribucioproj($iddistribucio,$sendlocalitat,$projecte,'mes');
$numdishoraria=count($valordishoraria)-1;
$numdismensual=count($valordismensual)-1;


if($numdishoraria=="0"){$hiddenbtn1="hidden";}
else{$hiddenbtn1="";}
if($numdismensual=="0"){$hiddenbtn2="hidden";}
else{$hiddenbtn2="";}
//Buscar si existe la distribucion horaria, la mensual o ambas

//obtener datos del array

$nomdistribucio=distribuciofrecuencies::obtenirnomdistribucio($iddistribucio);
//$tipusdistribucio=distribuciofrecuencies::gettipo($nomdistribucio);
//$quantitat=demandas::getquantitat($iddistribucio,$projecte);
$quantitat=1;
//Solo cuando tengamos demanda+projecto $quantitat=distribuciofrecuencies::getquantitat($nomdistribucio);


if(isset($_POST['btn1']) || isset($_POST['btn2']) || isset($_POST['anterior']) || isset($_POST['posterior'])) {	
	
	if(isset($_POST['btn1'])){
		$tipografico="hor";
		$valor=distribuciofrecuencies::getdadesdistribuciodiaria($iddistribucio,1,$demandaprojhor,$projecte);
		$sendlocalitat=$demandaprojhor;
		$mesgraf=1;
		
		}
	if(isset($_POST['btn2'])){
		//Preparación valores para gráfica diaria
		$tipografico="mes";
		$valor=distribuciofrecuencies::getdadesdistribucioanual($iddistribucio,$sendlocalitat,$projecte);
		}
	if(isset($_POST['anterior']) && $tipografico=="hor"){
			if($mesgraf>1){
				$mesgraf--;
				$valor=distribuciofrecuencies::getdadesdistribuciodiaria($iddistribucio,$mesgraf,$demandaprojhor,$projecte);
				}
			else{$valor=distribuciofrecuencies::getdadesdistribuciodiaria($iddistribucio,1,$demandaprojhor,$projecte);}
		}
		if(isset($_POST['posterior']) && $tipografico=="hor"){
			if($mesgraf<12){
				$mesgraf++;
				$valor=distribuciofrecuencies::getdadesdistribuciodiaria($iddistribucio,$mesgraf,$demandaprojhor,$projecte);
				}
			else {$valor=distribuciofrecuencies::getdadesdistribuciodiaria($iddistribucio,12,$demandaprojhor,$projecte);}
		}
	if((isset($_POST['posterior']) || isset($_POST['anterior'])) && $tipografico=="mes")
		{
		$tipografico="mes";
		$valor=distribuciofrecuencies::getdadesdistribucioanual($iddistribucio,$sendlocalitat,$projecte);

		}
	}
else{
	//Ver si existen las distribuciones
	$tipografico="mes";
	$valor=distribuciofrecuencies::getdadesdistribucioanual($iddistribucio,$sendlocalitat,$projecte);
	if($numdismensual=="0" && $numdishoraria>0){
		$tipografico="hor";
		$valor=distribuciofrecuencies::getdadesdistribuciodiaria($iddistribucio,$mesgraf,$demandaprojhor,$projecte);
		}
	
	
	}

//Buscar los valores según la distribucio y el tipo. 
$tipusdistribucio="proj";
if($mesgraf=="1"){$nommesgraf="  JANUARY   ";}
if($mesgraf=="2"){$nommesgraf="  FEBRUARY  ";}
if($mesgraf=="3"){$nommesgraf="   MARCH   ";}
if($mesgraf=="4"){$nommesgraf="   APRIL   ";}
if($mesgraf=="5"){$nommesgraf="    MAY    ";}
if($mesgraf=="6"){$nommesgraf="   JUNE    ";}
if($mesgraf=="7"){$nommesgraf="   JULY    ";}
if($mesgraf=="8"){$nommesgraf="  AUGUST   ";}
if($mesgraf=="9"){$nommesgraf=" SEPTEMBER ";}
if($mesgraf=="10"){$nommesgraf="  OCTOBER  ";}
if($mesgraf=="11"){$nommesgraf=" NOVEMBER  ";}
if($mesgraf=="12"){$nommesgraf=" DECEMBER  ";}
$hidden2="";
$hidden1="";
if($tipografico=="'mes'" || $tipografico=="mes")
{$hidden1="style=\"display:none\";";
$hidden2=" display:none;";}
?>
<ul class="breadcrumbs first">
    <li><a href="gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>&locals=<?php echo $sendlocalitat;?>">Monthly Data</a></li>
    <li class="active"><a href="#">Graphics </a></li>
</ul>


<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Graphics </h2>
    </div>
    <div class="widget_body">

	<form name="validacio" method="POST" action="DesplegarGrafico.php?t=Graphics&projh=<?php echo $projh?>" id="validacio">
	<table>
	<tr>
				<td>
				
				
				<input <?php echo "$hiddenbtn1"; ?> type="submit" class="btn blue medium" style="width:100px;" name="btn1" id="btn1" value="Dialy">
				
				
				<input <?php echo "$hiddenbtn2"; ?> type="submit" class="btn blue medium" style="width:100px;" name="btn2" id="btn2" value="Monthly">
				<input type="submit" class="btn white right" style="width:100px;<?php echo $hidden2;?>" name="posterior" id="posterior" value="->">
				<label class="right" <?php echo $hidden1;?>><h2><?php echo "&nbsp;&nbsp;&nbsp; $nommesgraf &nbsp;&nbsp;&nbsp;";?></h2></label>
				<input type="submit" class="btn white right" style="width:100px;<?php echo $hidden2;?>" name="anterior" id="anterior" value="<-">
				</td>
	</tr>	
	<!--<tr><td><img src="favicon.ico" alt="Icono" height="42" width="42"></td></tr>-->
	<!-- si es nuevo o si es desde add-->
	
	<tr><td><label><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"?></label><img src="grafico_barra2.php?<?php echo "distribucio=$nomdistribucio&tipograf=$tipografico&iddistribucio=$iddistribucio&tipusdistribucio=$tipusdistribucio&quantitat=$quantitat&localitat=$sendlocalitat&mes=$mesgraf&projecte=$projecte";?>" alt="" border="0"></td></tr>

	
        </table>
	<h4     >   VALUE TABLE</h4>
	<table style="border:2px solid violet;">
	<?php
	if($tipografico=="mes"){
	echo "<tr style=\"border:2px solid green;\"><th>Jan.</th><th>Feb.</th><th>Mar.</th><th>Apr.</th><th>May.</th><th>Jun.</th><th>Jul.</th><th>Agt.</th><th>Spt.</th><th>Oct.</th><th>Nov.</th><th>Dec.</th></tr>";
	$acum="<tr>";
	//for ($i=1;$i<=12;$i++)
	//	{
	//	$aux=('$valor[$i]');
	//	}
	$i=0;
	foreach($valor as $val)
		{if($i<12){$acum=$acum."<td style=\"text-align:center;\">".number_format($val['valor'],2)."</td>";}
		$i++;
		}
	$acum=$acum."</tr><tr></tr>";
	echo $acum;
	}
	if($tipografico=="hor"){
	$acum="<tr>";
	for ($i=0;$i<12;$i++)
		{$acum=$acum."<th>$i</th>";}
	$acum=$acum."</tr><tr>";
	$i=0;
	foreach($valor as $val)
		{if($i<12){$acum=$acum."<td style=\"text-align:center;\">".number_format($val['valor'],2)."</td>";}
		$i++;
		
		}
	$acum=$acum."</tr><tr>";
	for ($i=12;$i<24;$i++)
		{$acum=$acum."<th>$i</th>";}
	$acum=$acum."</tr><tr>";
	$i=0;
	foreach($valor as $val)
		{if($i>=12 && $i<=23){$acum=$acum."<td style=\"text-align:center;\">".number_format($val['valor'],2)."</td>";}
		$i++;
		
		}
	$acum=$acum."</tr><tr></tr>";
	echo $acum;
	}
	?>
	</table>
		<input type="hidden" name="nomdistribucioselected" id="nomdistribucioselected" value="<?php echo $iddistribucio; ?>">
		<input type="hidden" name="iddistribucio" id="iddistribucio" value="<?php echo $iddistribucio;?>">
		<input type="hidden" name="localitatsgrafiques" id="localitatsgrafiques" value="<?php echo $sendlocalitat;?>">
		<input type="hidden" name="tipograf" id="tipograf" value="<?php echo $tipografico;?>">
		<input type="hidden" name="mesgraf" id="mesgraf" value="<?php echo $mesgraf;?>">
		<!--<input type="hidden" name="tipusdis" id="tipusdis" value="<?php echo $tipusdis;?>">-->
		<input type="hidden" name="projh" id="projh" value="<?php echo $projh;?>">
		
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

