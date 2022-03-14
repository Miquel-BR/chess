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
gestio_projectesBBDD::setup();

if(isset($_SESSION['locali'])){
$sendlocalitat=$_SESSION['locali'];}
else {$sendlocalitat="";}

if(isset($_POST['locals'])){$sendlocalitat=$_POST['locals'];}
if(isset($_GET['locals'])){$sendlocalitat=$_GET['locals'];}


//$iddistribucio="1";
if(isset($_POST['tipusdis'])){$iddistribucio=$_POST['tipusdis'];}
if(isset($_GET['tipusdis'])){$iddistribucio=$_GET['tipusdis'];}
if (isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}


//$aux=projectes::getprojecteactual();
//$projecte=$aux['nomproject'];
$projecte=$projh;

$senddistribucio=distribuciofrecuencies::obtenirnomdistribucio("$iddistribucio");
$unitatfrecuencia=distribuciofrecuencies::getunitat($senddistribucio);


$valorsdistribucioanual=distribuciofrecuencies::getdadesdistribucioanualprojecte($iddistribucio,$sendlocalitat,$projecte);
$numvalorsdistribucioanual=count($valorsdistribucioanual)-1;

if($numvalorsdistribucioanual>0)
	{
	for($i=1;$i<=12;$i++){
		$valorsdistribucioanualmes=distribuciofrecuencies::getdadesdistribucioanualmesprojecte($iddistribucio,$sendlocalitat,$projecte,$i);
		$numvalordistribucioanualmes=count($valorsdistribucioanualmes)-1;
		if($numvalordistribucioanualmes>0){
			$valor[$i]=$valorsdistribucioanualmes[1]['valor'];}
		else {if($iddistribucio==1){$valor[$i]=0;}else{$valor[$i]="";}}
		}
	}
else 
	{
	for($i=1;$i<=12;$i++){
		
		//Mirar si existen los valores para de libreria para esa localidad
		$valordistribucioanualmesref=distribuciofrecuencies::getdadesdistribucioanualmes($iddistribucio,$sendlocalitat,$i);
		$numvalordistribucioanualref=count($valordistribucioanualmesref)-1;
		if($numvalordistribucioanualref>0){
			$valor[$i]=$valordistribucioanualmesref[1]['valor'];}
		else {$valor[$i]="";}
		}
	}


	
if(isset($_POST['add'])) {
	/*
	    $dbhost = 'localhost';
            $dbuser = 'root';
            $dbpass = '';
            $conn = @mysql_connect($dbhost, $dbuser, $dbpass);
            
            if(! $conn ) {
               die('Could not connect: ' . mysql_error());
            }
            mysql_select_db('scacs2');*/
if($iddistribucio!=1){
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
	


$mes=1;
while ($mes<=12)
		{
		//Caso de Radiación, Radiación como suma de valores diarios
		if($iddistribucio==1)
			{
			//Para el mes mirar si existen todos los valores horarios
			
		
			}
		//Si Existe para ese mes la distribucion anual
		$auxe=distribuciofrecuencies::obtenirnumdistribucioanualmes ($mes,$iddistribucio,$sendlocalitat);
		$existe=count($auxe)-1;
		$valmes=$valor[$mes];
		if ($existe==0)
			{
			
			$sentencia = "insert into distribucions_anuals (idDistribucio_anual,mes,valor,localitat) VALUES (".$iddistribucio.",".$mes.",".$valmes.",'".$sendlocalitat."')";			
            		$retval = mysql_query( $sentencia, gestio_projectesBBDD::$dbconn );
 			
			$sentencia = "insert into distribucions_anuals_projectes (idDistribucio_anual,mes,valor,localitat,projecte) VALUES (".$iddistribucio.",".$mes.",".$valmes.",'".$sendlocalitat."','".$projecte."')";			
            		$retval = mysql_query( $sentencia, gestio_projectesBBDD::$dbconn );
			
			}
		else {
			$auxf=distribuciofrecuencies::obtenirnumdistribucioanualmesprojecte ($mes,$iddistribucio,$sendlocalitat,$projecte);
			$existe2=count($auxf)-1;
			if($existe2>0){
			$sentencia= "UPDATE distribucions_anuals_projectes SET valor=$valmes,localitat='$sendlocalitat' WHERE idDistribucio_anual=".$iddistribucio." and mes=".$mes." and projecte='".$projecte."'";
			}
			else{$sentencia= "insert into distribucions_anuals_projectes (idDistribucio_anual,mes,valor,localitat,projecte) VALUES (".$iddistribucio.",".$mes.",".$valmes.",'".$sendlocalitat."','".$projecte."')";}			

			$retval = mysql_query( $sentencia, gestio_projectesBBDD::$dbconn );
 			}
		//echo " $sentencia , $mes ";
		$mes++;
		
		}
	
	}

//echo "$existe,$existe2,$sentencia";            

}
//Presentacion para radiacion iddistribucio=1
if($iddistribucio==1){$typeinput="disabled"; }
else {$typeinput="";}

?>
<ul class="breadcrumbs first">
    <li><a href="chooselocation.php?t=Location Choice&projh=<?php echo $projh;?>">Location Choice</a></li>
    <li class="active"><a href="#">Monthly Data Clima Condition</a></li>
</ul>


<div class="grid_16 widget first">
        <div class="widget_title clearfix">
            <h2>Time Data </h2>
        </div>
        <div class="widget_body">
	<form name="validation" method="POST" action = "gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data Clima Condition&projh=<?php echo $projh;?>" id="gestion_frecuencia_anual2">
                <div id="table1">
                <table >
                <!--<thead>-->
		    
			
			    <tr>
				<td width="16%" colspan="10"><label>Distibution Variable: <h2><?php echo "$senddistribucio"; ?></h2></label></td>
				<td width="16%" colspan="10"><label>Location: <h2><?php echo "$sendlocalitat"; ?></h2></label></td>
				<td width="16%" colspan="10"><label>Project: <h2><?php echo "$projecte"; ?></h2></label></td>
				<td width="16%" colspan="10"></td>
				<td width="16%" colspan="10"></td>
				<td width="16%" colspan="10"></td>
			</tr>
			<tr>
				<td width="16%" colspan="10"><label>Distribution Unit: </label></td>
				<td width="16%" colspan="10"><input class="medium :required" type="text" name="unitats" id="unitats" style="width:50px;"  value="<?php echo utf8_encode($unitatfrecuencia); ?>" <?php echo $typeinput; ?>><span class="infobar">Required field</span></td>
				<td width="16%" colspan="10"></td><td width="16%" colspan="10"></td><td width="16%" colspan="10"></td>
				<td width="16%" colspan="10"></td>
				
			</tr>
			<!--</thead>-->
			<!--<tbody>-->
				
                            <tr>
				     <td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_externalcondition.php?t=Dialy Data Clima Condition&mes=1&locals=<?php echo $sendlocalitat;?>&tipusdis=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  January </a> </td>
                     <td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_externalcondition.php?t=Dialy Data Clima Condition&mes=2&locals=<?php echo $sendlocalitat;?>&tipusdis=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  February  </a></td>
                     <td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_externalcondition.php?t=Dialy Data Clima Condition&mes=3&locals=<?php echo $sendlocalitat;?>&tipusdis=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  March </a> </td>
                     <td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_externalcondition.php?t=Dialy Data Clima Condition&mes=4&locals=<?php echo $sendlocalitat;?>&tipusdis=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  April </a> </td>
					<td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_externalcondition.php?t=Dialy Data Clima Condition&mes=5&locals=<?php echo $sendlocalitat;?>&tipusdis=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  May </a>  </td>
					<td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_externalcondition.php?t=Dialy Data Clima Condition&mes=6&locals=<?php echo $sendlocalitat;?>&tipusdis=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  June  </a> </td>
						
                            </tr>
                        
						<?php
							
								echo "<tr>";
								echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"gen\" id=\"gen\" style=\"width:50px;\"  value=\"".$valor[1]."\" ".$typeinput."><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"feb\" id=\"feb\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[2]."\" ".$typeinput."><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"mar\" id=\"mar\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[3]."\" ".$typeinput."><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"apr\" id=\"apr\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[4]."\" ".$typeinput."><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"mai\" id=\"mai\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[5]."\" ".$typeinput."><span class=\"infobar\">Required Field</span></td>";
								
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"jun\" id=\"jun\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[6]."\" ".$typeinput."><span class=\"infobar\">Required Field</span></td>";
								
								
							
						?>
				<tr>
					<td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_externalcondition.php?t=Inici&mes=7&locals=<?php echo $sendlocalitat;?>&tipusdis=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  July </a> </td>
					<td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_externalcondition.php?t=Inici&mes=8&locals=<?php echo $sendlocalitat;?>&tipusdis=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  August </a> </td>
					<td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_externalcondition.php?t=Inici&mes=9&locals=<?php echo $sendlocalitat;?>&tipusdis=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  September </a> </td>
					<td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_externalcondition.php?t=Inici&mes=10&locals=<?php echo $sendlocalitat;?>&tipusdis=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  October </a> </td>
					<td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_externalcondition.php?t=Inici&mes=11&locals=<?php echo $sendlocalitat;?>&tipusdis=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  November </a> </td>
					<td  width="16%" colspan="10"><a href="gestio_dades_frecuencia_diaria_externalcondition.php?t=Inici&mes=12&locals=<?php echo $sendlocalitat;?>&tipusdis=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">  December </a> </td>
				</tr>
				<tr>
					<?php
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"jul\" id=\"jul\" style=\"width:50px;\" value=\"".$valor[7]."\" ".$typeinput."><span class=\"infobar\">Required Field</span></td>";
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"ago\" id=\"ago\" style=\"width:50px;\" value=\"".$valor[8]."\" ".$typeinput."><span class=\"infobar\">Required Field</span></td>";
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"sep\" id=\"sep\" style=\"width:50px;\" value=\"".$valor[9]."\" ".$typeinput."><span class=\"infobar\">Required Field</span></td>";
								
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"oct\" id=\"oct\" style=\"width:50px;\" value=\"".$valor[10]."\" ".$typeinput."><span class=\"infobar\">Required Field</span></td>";
								
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"nov\" id=\"nov\" style=\"width:50px;\" value=\"".$valor[11]."\" ".$typeinput."><span class=\"infobar\">Required Field</span></td>";
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"dec\" id=\"dec\" style=\"width:50px;\" value=\"".$valor[12]."\" ".$typeinput."><span class=\"infobar\">Required Field</span></td>";
						echo "</tr>";
								
							
						?>
				<tr>
				<td width="16%" colspan="10">
				<input type="submit" class="btn blue" style="width:100px;" name="add" id="add" value="Next"></td>
				
				
			
				<td width="16%" colspan="10"><a href="DesplegarGrafico.php?t=Graphics&distribuciografiques=<?php echo $iddistribucio;?>&localitatsgrafiques=<?php echo $sendlocalitat; ?>&tipograf=mes&tipusdis=proj&projh=<?php echo $projh;?>" class="btn blue right" style="width:100px;">Graphics </a></td>
			
				</td><td width="16%" colspan="10"></td><td width="16%" colspan="10"></td><td width="16%" colspan="10"></td><td width="16%" colspan="10"></td>
				</tr>
				<div class="grid_16 first">
				</div>
				<div class="clear"></div>
                     <!--   </tbody>-->
			
                    </table>
			
                
            
		
		
		</div>
		<input type="hidden" name="locals" id="locals" value="<?php echo $sendlocalitat; ?>">
		<input type="hidden" name="tipusdis" id="tipusdis" value="<?php echo $iddistribucio; ?>">
		<input type="hidden" name="projh" id="projh" value="<?php echo $projh; ?>">
		
	</form>
        </div>
    </div>
	
         
            <?php
         //}
      ?>

<?php include("footer.php") ?>