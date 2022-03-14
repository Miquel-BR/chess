<?php

include('header.php');
?>
<?php
// INCLUDES
require_once("class/gestio_projectesBBDD.php");
require_once("class/distribuciofrecuencies.php");
require_once("class/graficos.php");

gestio_projectesBBDD::setup();
//paso por POST de la distribucionparagraficar

//Paso de la distribucion elegida
$error="Sin error";
if(isset($_POST['distribuciografiques']))
	{
	$iddistribucio=$_POST['distribuciografiques'];
	}

if(isset($_POST['btn1']) || isset($_POST['btn2'])) {	
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
		



$numdishoraria=distribuciofrecuencies::checkdistribuciodiaria($iddistribucio);
$numdismensual=distribuciofrecuencies::checkdistribucioanual($iddistribucio);
if($numdishoraria=="0"){$hiddenbtn1="hidden";}
else{$hiddenbtn1="";}
if($numdismensual=="0"){$hiddenbtn2="hidden";}
else{$hiddenbtn2="";}
//Buscar si existe la distribucion horaria, la mensual o ambas

//obtener datos del array

$nomdistribucio=distribuciofrecuencies::obtenirnomdistribucio($iddistribucio);
$tipusdistribucio=distribuciofrecuencies::gettipo($nomdistribucio);
$quantitat=distribuciofrecuencies::getquantitat($nomdistribucio);

if(isset($_POST['btn1']) || isset($_POST['btn2'])) {	
	
	if(isset($_POST['btn1'])){
		$tipografico="hor";
		$valor=distribuciofrecuencies::getdadesdistribuciodiaria($nomdistribucio);
		
		}
	if(isset($_POST['btn2'])){
		//Preparación valores para gráfica diaria
		$tipografico="mes";
		$valor=distribuciofrecuencies::getdadesdistribucioanual($nomdistribucio);
		}
	}
else{
	//Ver si existen las distribuciones
	$tipografico="mes";
	$valor=distribuciofrecuencies::getdadesdistribucioanual($nomdistribucio);
	if($numdismensual=="0" && $numdishoraria>0){
		$tipografico="hor";
		$valor=distribuciofrecuencies::getdadesdistribuciodiaria($nomdistribucio);
		}
	
	
	}

//Buscar los valores según la distribucio y el tipo. 


?>
<ul class="breadcrumbs first">
    <li><a href="#">Gesti&oacute de dades</a></li>
    <li class="active"><a href="#">Grafics <?php echo ",$iddistribucio,$numdishoraria,$numdismensual,$hiddenbtn1,$hiddenbtn2,$error";?></a></li>
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
				
				</td>
	</tr>	
	<tr><td><img src="favicon.ico" alt="Icono" height="42" width="42"></td></tr>
	<!-- si es nuevo o si es desde add-->
	
	<tr><td><img src="grafico_barra2.php?<?php echo "distribucio=$nomdistribucio&tipograf=$tipografico&iddistribucio=$iddistribucio&tipusdistribucio=$tipusdistribucio&quantitat=$quantitat";?>" alt="" border="0"></td></tr>

	
        </table>
	<h4     >   TABLA DE VALORES MOSTRADOS</h4>
	<table border="1">
	<?php
	if($tipografico=="mes"){
	echo "	<tr><th>Gen.</th><th>Feb.</th><th>Mar.</th><th>Apr.</th><th>May.</th><th>Jun.</th><th>Jul.</th><th>Agt.</th><th>Spt.</th><th>Oct.</th><th>Nov.</th><th>Dec.</th></tr>";
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
		<input type="hidden" name="nomdistribucioselected" value="<?php echo $iddistribucio; ?>">
		<input type="hidden" name="iddistribucio" value="<?php echo $iddistribucio;?>">


		
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

