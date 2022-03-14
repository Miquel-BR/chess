<?php

include('header.php');
?>
<?php
// INCLUDES
require_once("class/gestio_projectesBBDD.php");
require_once("class/distribuciofrecuencies.php");
require_once("class/graficos.php");
require_once("class/projectes.php");

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
if (isset($_POST['mesgraf'])){$mesgraf=$_POST['mesgraf'];} else { $mesgraf=1;}
if(isset($_POST['btn1']) || isset($_POST['btn2']) || isset($_POST['anterior']) || isset($_POST['posterior'])) {	
	if(isset($_POST['iddistribucio'])){
		$iddistribucio=$_POST['iddistribucio'];}
	else{$error="no ha pasado iddis";}
	}
//if(isset($_POST['tipusdistribucio'])){
//		$tipusdistribucio=$_POST['tipusdistribucio'];}
//	else{$error="no ha pasado tipusdistribucio";}
//if(isset($_POST['quantitat'])){
//		$quantitat=$_POST['quantitat'];}
//	else{$error="no ha pasado quantitats";}

if($tipusdis=='proj'){
$aux=projectes::getprojecteactual();
$projecte=$aux['nomproject'];
}


$numdishoraria=distribuciofrecuencies::checkdistribuciodiaria($iddistribucio,$sendlocalitat);
$numdismensual=distribuciofrecuencies::checkdistribucioanual($iddistribucio,$sendlocalitat);
if($numdishoraria=="0"){$hiddenbtn1="hidden";}
else{$hiddenbtn1="";}
if($numdismensual=="0"){$hiddenbtn2="hidden";}
else{$hiddenbtn2="";}
//Buscar si existe la distribucion horaria, la mensual o ambas

//obtener datos del array

$nomdistribucio=distribuciofrecuencies::obtenirnomdistribucio($iddistribucio);
//$tipusdistribucio=distribuciofrecuencies::gettipo($nomdistribucio);

//Solo cuando tengamos demanda+projecto $quantitat=distribuciofrecuencies::getquantitat($nomdistribucio);


if(isset($_POST['btn1']) || isset($_POST['btn2']) || isset($_POST['anterior']) || isset($_POST['posterior'])) {	
	
	if(isset($_POST['btn1'])){
		$tipografico="hor";
		$valor=distribuciofrecuencies::getdadesdistribuciodiaria($nomdistribucio,1,$sendlocalitat);
		$mesgraf=1;
		
		}
	if(isset($_POST['btn2'])){
		//Preparación valores para gráfica diaria
		$tipografico="mes";
		$valor=distribuciofrecuencies::getdadesdistribucioanual($nomdistribucio,$sendlocalitat);
		}
	if(isset($_POST['anterior']) and $tipografico=="hor"){
			if($mesgraf>1){
				$mesgraf--;
				$valor=distribuciofrecuencies::getdadesdistribuciodiaria($nomdistribucio,$mesgraf,$sendlocalitat);
				
			}
		}
		if(isset($_POST['posterior']) and $tipografico=="hor"){
			if($mesgraf<12){
				$mesgraf++;
				$valor=distribuciofrecuencies::getdadesdistribuciodiaria($nomdistribucio,$mesgraf,$sendlocalitat);
				
			}
		}
	}
else{
	//Ver si existen las distribuciones
	$tipografico="mes";
	$valor=distribuciofrecuencies::getdadesdistribucioanual($nomdistribucio,$sendlocalitat);
	if($numdismensual=="0" && $numdishoraria>0){
		$tipografico="hor";
		$valor=distribuciofrecuencies::getdadesdistribuciodiaria($nomdistribucio,$mesgraf,$sendlocalitat);
		}
	
	
	}

//Buscar los valores según la distribucio y el tipo. 


?>
<ul class="breadcrumbs first">
    <li><a href="#">Gesti&oacute de dades</a></li>
    <li class="active"><a href="#">Grafics <?php echo ",$iddistribucio,$numdishoraria,$numdismensual,$hiddenbtn1,$hiddenbtn2,$error,$sendlocalitat";?></a></li>
</ul>


<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Graficos </h2>
    </div>
    <div class="widget_body">

	<form name="validacio" method="POST" action="DesplegarGrafico.php?t=Inicio" id="validacio">
	<table>
	<tr>
				<td>
				
				
				<input <?php echo "$hiddenbtn1"; ?> type="submit" class="btn blue medium" style="width:100px;" name="btn1" id="btn1" value="Horaria">
				
				
				<input <?php echo "$hiddenbtn2"; ?> type="submit" class="btn blue medium" style="width:100px;" name="btn2" id="btn2" value="Mensual">
				<input type="submit" class="btn white right" style="width:100px;" name="posterior" id="posterior" value="Posterior">
				<label class="right"><?php echo $mesgraf;?></label>
				<input type="submit" class="btn white right" style="width:100px;" name="anterior" id="anterior" value="Anterior">
				</td>
	</tr>	
	<tr><td><img src="favicon.ico" alt="Icono" height="42" width="42"></td></tr>
	<!-- si es nuevo o si es desde add-->
	
	<tr><td><img src="grafico_barra2.php?<?php echo "distribucio=$nomdistribucio&tipograf=$tipografico&iddistribucio=$iddistribucio&tipusdistribucio=$tipusdistribucio&quantitat=$quantitat&localitat=$sendlocalitat&mes=$mesgraf";?>" alt="" border="0"></td></tr>

	
        </table>
	<h4     >   TABLA DE VALORES MOSTRADOS</h4>
	<table style="border:2px solid violet;">
	<?php
	if($tipografico=="mes"){
	echo "	<tr style=\"border:2px solid green;\"><th>Gen.</th><th>Feb.</th><th>Mar.</th><th>Apr.</th><th>May.</th><th>Jun.</th><th>Jul.</th><th>Agt.</th><th>Spt.</th><th>Oct.</th><th>Nov.</th><th>Dec.</th></tr>";
	$acum="<tr>";
	//for ($i=1;$i<=12;$i++)
	//	{
	//	$aux=('$valor[$i]');
	//	}
	foreach($valor as $val)
		{$acum=$acum."<td>".$val['valor']."</td>";}
	$acum=$acum."</tr><tr></tr>";
	echo $acum;
	}
	if($tipografico=="hor"){
	$acum="<tr>";
	for ($i=0;$i<24;$i++)
		{$acum=$acum."<th>$i</th>";}
	$acum=$acum."</tr>";
	echo $acum;
		$acum="<tr>";
	//for ($i=1;$i<=24;$i++)
	//	{
	//	$aux=$valor[$i];
	//	$acum=$acum."<th>$aux</th>";
		
	//	}
	$val="";
	foreach($valor as $val)
		{$acum=$acum."<td>".$val['valor']."</td>";}
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
		<input type="hidden" name="tipusdis" id="tipusdis" value="<?php echo $tipusdis;?>">

		
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

