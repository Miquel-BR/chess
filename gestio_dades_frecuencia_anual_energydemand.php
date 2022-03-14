<?php
/*require_once("admincheck.php");
if(isset($_GET['sidebar'])){
    include('s_header.php');
} else {
    include('header.php');
}*/
include('header.php');
?>
<?php
// INCLUDES
require_once("./class/gestio_projectesBBDD.php");
require_once("./class/usuari.php");
require_once("./class/distribuciofrecuencies.php");
require_once("./class/projectes.php");
//require_once("./class/projecte.php");
gestio_projectesBBDD::setup();


//Tipo distribucio es rígida: Heating
if(isset($_GET['nomdemand'])){$senddistribucio=$_GET['nomdemand'];}
if(isset($_POST['nomdemand'])){$senddistribucio=$_POST['nomdemand'];}
if(isset($_GET['iddemand'])){$iddistribucio=$_GET['iddemand'];}
if(isset($_POST['iddemand'])){$iddistribucio=$_POST['iddemand'];}
if(isset($_GET['demanda'])){$senddemanda=$_GET['demanda'];}
if(isset($_POST['demanda'])){$senddemanda=$_POST['demanda'];}
if(isset($_GET['localitat'])){$localitat=$_GET['localitat'];}
if(isset($_POST['localitat'])){$localitat=$_POST['localitat'];}

if (isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}

//$iddistribucio=$_SESSION['iddemand'];
//$senddistribucio=$_SESSION['nomdemand'];
$aux=projectes::getprojecteactual();
//$projecte=$aux['nomproject'];
$projecte=$projh;

$localitat=$aux['localitat'];

//Sustituir todos los $senddemanda por $localitat
$senddemanda2=$localitat;

$valorsdistribucioanual=distribuciofrecuencies::getdadesdistribucioanualdemanda($senddistribucio,$senddemanda2,2);
$numvalorsdistribucioanual=count($valorsdistribucioanual)-1;
$numvalordistribucioanualref=111;
if($numvalorsdistribucioanual>0)
	{
	for($i=1;$i<=12;$i++){

		$valorsdistribucioanualmes=distribuciofrecuencies::getdadesdistribucioanualmesdemandaprojecte($iddistribucio,$senddemanda2,$i,$projecte);
		$numvalordistribucioanualmes=count($valorsdistribucioanualmes)-1;
		if($numvalordistribucioanualmes>0){
			$valor[$i]=$valorsdistribucioanualmes[1]['valor'];}
		else {
			$valordistribucioanualmesref=distribuciofrecuencies::getdadesdistribucioanualmesdemanda($iddistribucio,$senddemanda2,$i);
			$numvalordistribucioanualref=count($valordistribucioanualmesref)-1;
			if($numvalordistribucioanualref>0){
				$valor[$i]=$valordistribucioanualmesref[1]['valor'];}
			else {$valor[$i]="";}
			}
		}
	}
else
	{

	for($i=1;$i<=12;$i++){
		//$valor[$i]="";
		//Mirar si existen los valores para de libreria para esa localidad
		$valordistribucioanualmesref=distribuciofrecuencies::getdadesdistribucioanualmesdemanda($iddistribucio,$senddemanda2,$i);
		$numvalordistribucioanualref=count($valordistribucioanualmesref)-1;
		if($numvalordistribucioanualref>0){
			$valor[$i]=$valordistribucioanualmesref[1]['valor'];}
		else {$valor[$i]="";}

		}
	}


$existe=0;$existe2=0;$sentencia="Sin sentencia";

if(isset($_POST['add'])) {
	    /*$dbhost = 'localhost';
            $dbuser = 'root';
            $dbpass = '';
            $conn = @mysqli_connect($dbhost, $dbuser, $dbpass);

            if(! $conn ) {
               die('Could not connect: ' . mysqli_error());
            }
            mysqli_select_db('scacs2');*/
		$valor[1]=$_POST['gen'];
        $valor[2]=$_POST['feb'];
		$valor[3]=$_POST['mar'];
		$valor[4]=$_POST['apr'];
		$valor[5]=$_POST['mai'];
		$valor[6]=$_POST['jun'];
		$valor[7]=$_POST['jul'];
		$valor[8]=$_POST['ago'];
		$valor[9]=$_POST['sep'];
		$valor[10]=$_POST['oct'];
		$valor[11]=$_POST['nov'];
		$valor[12]=$_POST['dec'];


$valor=distribuciofrecuencies::ajustpercentatgesmes($valor,12);
//Ver si ya existe
//if ($numvalorsdistribucioanual>0)
//	{

	$mes=1;
	while ($mes<=12)
		{
		//Si Existe para ese mes la distribucion anual
		$auxe=distribuciofrecuencies::obtenirnumdistribucioanualmesdemanda ($mes,$iddistribucio,$senddemanda2);
		$existe=count($auxe)-1;
		$valmes=$valor[$mes];
		if ($existe==0)
			{
			$sentencia = "insert into distribucions_anuals (idDistribucio_anual,mes,valor,demand) VALUES (".$iddistribucio.",".$mes.",".$valmes.",'".$senddemanda2."')";
            $retval = mysqli_query(gestio_projectesBBDD::$dbconn, $sentencia);
			$sentencia = "insert into distribucions_anuals_projectes (idDistribucio_anual,mes,valor,demand,projecte) VALUES (".$iddistribucio.",".$mes.",".$valmes.",'".$senddemanda2."','".$projecte."')";
            $retval = mysqli_query(gestio_projectesBBDD::$dbconn, $sentencia);

 			}
		else {
			//$sentencia= "UPDATE distribucions_anuals_projectes SET valor=$valmes WHERE idDistribucio_anual=".$iddistribucio." and mes=".$mes." and demand='".$senddemanda2."' and projecte='".$projecte."'";
            //$retval = mysqli_query(gestio_projectesBBDD::$dbconn, $sentencia);
			$auxf=distribuciofrecuencies::obtenirnumdistribucioanualmesprojectedemanda ($mes,$iddistribucio,$senddemanda2,$projecte);
			$existe2=count($auxf)-1;
			if($existe2>0){
			//$sentencia= "UPDATE distribucions_anuals_projectes SET valor=$valmes WHERE idDistribucio_anual=".$iddistribucio." and mes=".$mes." and demand='".$senddemanda2."' and projecte='".$projecte."'";
			$sentencia= "UPDATE distribucions_anuals_projectes SET valor=$valmes,demand='$senddemanda2' WHERE idDistribucio_anual=".$iddistribucio." and mes=".$mes." and projecte='".$projecte."'";

			}
			else
			{
			$sentencia= "insert into distribucions_anuals_projectes (idDistribucio_anual,mes,valor,demand,projecte) VALUES (".$iddistribucio.",".$mes.",".$valmes.",'".$senddemanda2."','".$projecte."')";
			}

			$retval = mysqli_query(gestio_projectesBBDD::$dbconn, $sentencia);



			}
		$mes++;
		}
//	}
//else
//	{
//	$mes=1;
//	while ($mes<=12)
//		{
//		$valmes=$valor[$mes];
//		$sentencia = "insert into distribucions_anuals (idDistribucio_anual,mes,valor,demand) VALUES (".$iddistribucio.",".$mes.",".$valmes.",'".$senddemanda2."')";
//        $retval = mysqli_query(gestio_projectesBBDD::$dbconn, $sentencia);
//		$mes++;
//		}
//	}


}
//echo "var:$existe,$existe2,$sentencia";
?>
<ul class="breadcrumbs first">
    <li><a href="choosedemand.php?t=Energy Demand&projh=<?php echo $projh;?>">Energy Demand</a></li>
    <li class="active"><a href="#">Monthly Data Energy Demand</a></li>
</ul>


<div class="grid_16 widget first">
        <div class="widget_title clearfix">
            <h2>Data Management </h2>
        </div>
        <div class="widget_body">
	<form name="validation" method="POST" action = "<?php $_PHP_SELF ?>" id="gestion_frecuencia_anual2">
                <div id="table1">
                <table >



			    <tr>
				<td width="16%" colspan="10"><label>Type Data: <?php echo $senddistribucio; ?></label></td>
				<td width="16%" colspan="10"><label>Tipology: <?php echo $senddemanda; ?></label></td>
				<td width="16%" colspan="10"><label>Project: <?php echo $projecte; ?></label></td>
				<td width="16%" colspan="10"><label>Location: <?php echo $localitat; ?></label></td>
				<td width="16%" colspan="10"></td>
				<td width="16%" colspan="10"></td>
				</tr>


                            <tr>
				     <td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_energydemand.php?t=Energy&mes=1&demanda=<?php echo $senddemanda;?>&nomdemand=<?php echo $senddistribucio;?>&iddemand=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  Jan. </a> </td>
                     <td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_energydemand.php?t=Energy&mes=2&demanda=<?php echo $senddemanda;?>&nomdemand=<?php echo $senddistribucio;?>&iddemand=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  Feb.  </a></td>
                     <td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_energydemand.php?t=Energy&mes=3&demanda=<?php echo $senddemanda;?>&nomdemand=<?php echo $senddistribucio;?>&iddemand=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  March. </a> </td>
                     <td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_energydemand.php?t=Energy&mes=4&demanda=<?php echo $senddemanda;?>&nomdemand=<?php echo $senddistribucio;?>&iddemand=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  April. </a> </td>
					<td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_energydemand.php?t=Energy&mes=5&demanda=<?php echo $senddemanda;?>&nomdemand=<?php echo $senddistribucio;?>&iddemand=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  May. </a>  </td>
					<td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_energydemand.php?t=Energy&mes=6&demanda=<?php echo $senddemanda;?>&nomdemand=<?php echo $senddistribucio;?>&iddemand=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  June.  </a> </td>

                            </tr>

						<?php

								echo "<tr>";
								echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"gen\" id=\"gen\" style=\"width:50px;\"  value=\"".$valor[1]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"feb\" id=\"feb\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[2]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"mar\" id=\"mar\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[3]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"apr\" id=\"apr\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[4]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"mai\" id=\"mai\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[5]."\"><span class=\"infobar\">Required Field</span></td>";

								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"jun\" id=\"jun\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[6]."\"><span class=\"infobar\">Camp obligatori</span></td>";



						?>
				<tr>
					<td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_energydemand.php?t=Energy&mes=7&demanda=<?php echo $senddemanda;?>&nomdemand=<?php echo $senddistribucio;?>&iddemand=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  July. </a> </td>
					<td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_energydemand.php?t=Energy&mes=8&demanda=<?php echo $senddemanda;?>&nomdemand=<?php echo $senddistribucio;?>&iddemand=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  Aug. </a> </td>
					<td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_energydemand.php?t=Energy&mes=9&demanda=<?php echo $senddemanda;?>&nomdemand=<?php echo $senddistribucio;?>&iddemand=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  Septm. </a> </td>
					<td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_energydemand.php?t=Energy&mes=10&demanda=<?php echo $senddemanda;?>&nomdemand=<?php echo $senddistribucio;?>&iddemand=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  Octob. </a> </td>
					<td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_energydemand.php?t=Energy&mes=11&demanda=<?php echo $senddemanda;?>&nomdemand=<?php echo $senddistribucio;?>&iddemand=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  Novem. </a> </td>
					<td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_energydemand.php?t=Energy&mes=12&demanda=<?php echo $senddemanda;?>&nomdemand=<?php echo $senddistribucio;?>&iddemand=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  Decem. </a> </td>
				</tr>
				<tr>
					<?php
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"jul\" id=\"jul\" style=\"width:50px;\" value=\"".$valor[7]."\"><span class=\"infobar\">Required Field</span></td>";
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"ago\" id=\"ago\" style=\"width:50px;\" value=\"".$valor[8]."\"><span class=\"infobar\">Required Field</span></td>";
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"sep\" id=\"sep\" style=\"width:50px;\" value=\"".$valor[9]."\"><span class=\"infobar\">Required Field</span></td>";

						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"oct\" id=\"oct\" style=\"width:50px;\" value=\"".$valor[10]."\"><span class=\"infobar\">Required Field</span></td>";

						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"nov\" id=\"nov\" style=\"width:50px;\" value=\"".$valor[11]."\"><span class=\"infobar\">Required Field</span></td>";
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"dec\" id=\"dec\" style=\"width:50px;\" value=\"".$valor[12]."\"><span class=\"infobar\">Required Field</span></td>";
						echo "</tr>";


						?>
			<tr>
				<td width="16%" colspan="10">
				<input type="submit" class="btn blue" style="width:100px;" name="add" id="add" value="Next">

				</td>
				<td width="16%" colspan="10"><a href="DesplegarGrafico.php?t='Graphic Monthly Energy Demand'&distribuciografiques=<?php echo $iddistribucio;?>&localitatsgrafiques=<?php echo $senddemanda2; ?>&tipograf=mes&tipusdis=proj&projh=<?php echo $projh;?>" class="btn blue right" style="width:100px;">Graphics </a></td>

				</tr>
				<div class="grid_16 first">
				</div>
				<div class="clear"></div>


                    </table>





		</div>
		<input type="hidden" name="nomdemand" id="nomdemand" value="<?php echo $senddistribucio; ?>">
		<input type="hidden" name="iddemand" id="iddemand" value="<?php echo $iddistribucio; ?>">
		<input type="hidden" name="demanda" id="demanda" value="<?php echo $senddemanda; ?>">
		<input type="hidden" name="localitat" id="localitat" value="<?php echo $localitat; ?>">
		<input type="hidden" name="projh" id="projh" value="<?php echo $projh; ?>">

	</form>
        </div>
    </div>


            <?php

      ?>

<?php include("footer.php") ?>
