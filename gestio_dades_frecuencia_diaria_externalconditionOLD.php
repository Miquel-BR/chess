<?php

include('header.php');
// INCLUDES
require_once("./class/gestio_projectesBBDD.php");
require_once("./class/usuari.php");
require_once("./class/distribuciofrecuencies.php");
require_once("./class/projectes.php");

gestio_projectesBBDD::setup();

/*
if(isset($_GET['nomdemand'])){$senddistribucio=$_GET['nomdemand'];}
if(isset($_POST['nomdemand'])){$senddistribucio=$_POST['nomdemand'];}
if(isset($_GET['iddemand'])){$iddistribucio=$_GET['iddemand'];}
if(isset($_POST['iddemand'])){$iddistribucio=$_POST['iddemand'];}
if(isset($_GET['demanda'])){$senddemanda=$_GET['demanda'];}
if(isset($_POST['demanda'])){$senddemanda=$_POST['demanda'];}
*/

if(isset($_POST['locals'])){$sendlocalitat=$_POST['locals'];}
if(isset($_GET['locals'])){$sendlocalitat=$_GET['locals'];}	
	
if(isset($_POST['tipusdis']))
{$iddistribucio=$_POST['tipusdis'];}
if(isset($_GET['tipusdis']))
{$iddistribucio=$_GET['tipusdis'];}

if(isset($_POST['mes'])){$sendmes=$_POST['mes'];$envio="POST";}
if(isset($_GET['mes'])){$sendmes=$_GET['mes'];$envio="GET";}
if(isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}

//$aux=projectes::getprojecteactual();
//$projecte=$aux['nomproject'];
$projecte=$projh;


$replicacio=0;
$nommesgraf="";
if($sendmes=="1"){$nommesgraf="  JANUARY   ";}
if($sendmes=="2"){$nommesgraf="  FEBRUARY  ";}
if($sendmes=="3"){$nommesgraf="   MARCH   ";}
if($sendmes=="4"){$nommesgraf="   APRIL   ";}
if($sendmes=="5"){$nommesgraf="    MAY    ";}
if($sendmes=="6"){$nommesgraf="   JUNE    ";}
if($sendmes=="7"){$nommesgraf="   JULY    ";}
if($sendmes=="8"){$nommesgraf="  AUGUST   ";}
if($sendmes=="9"){$nommesgraf=" SEPTEMBER ";}
if($sendmes=="10"){$nommesgraf="  OCTOBER  ";}
if($sendmes=="11"){$nommesgraf=" NOVEMBER  ";}
if($sendmes=="12"){$nommesgraf=" DECEMBER  ";}


$senddistribucio=distribuciofrecuencies::obtenirnomdistribucio($iddistribucio);
$unitatfrecuencia=distribuciofrecuencies::getunitat($senddistribucio);


//Variar funciones
$valorsdistribuciodiaria=distribuciofrecuencies::getdadesdistribuciodiariaprojecte($iddistribucio,$sendmes,$sendlocalitat,$projecte);
$numvalorsdistribuciodiaria=count($valorsdistribuciodiaria)-1;
if($numvalorsdistribuciodiaria>0)
	{
	for($i=0;$i<=23;$i++){
		
		$valorsdistribuciodiariames=distribuciofrecuencies::getdadesdistribuciodiariamesprojecte($iddistribucio,$sendlocalitat,$sendmes,$i,$projecte);
		$numvalordistribuciodiariames=count($valorsdistribuciodiariames)-1;
		if($numvalordistribuciodiariames>0){
			$valor[$i]=$valorsdistribuciodiariames[1]['valor'];}
		else {$valor[$i]="";}
		}
	}
else 
	{
	for($i=0;$i<=23;$i++){
		
		//Mirar si existen valores de ref
		//$k=$i-1;
		$valordistribuciodiariamesref=distribuciofrecuencies::getdadesdistribuciodiariameshora($iddistribucio,$sendlocalitat,$sendmes,$i);
		$numvalordistribuciodiariaref=count($valordistribuciodiariamesref)-1;
		if($numvalordistribuciodiariaref>0){
			$valor[$i]=$valordistribuciodiariamesref[1]['valor'];}
		else {$valor[$i]="";}
		}
	}







if(isset($_POST['add'])) {
	    /*$dbhost = 'localhost';
            $dbuser = 'root';
            $dbpass = '';
            $conn = @mysql_connect($dbhost, $dbuser, $dbpass);
            
            if(! $conn ) {
               die('Could not connect: ' . mysql_error());
            }
			mysql_select_db('scacs2');*/
        $valor[0]=$_POST['una'];
        $valor[1]=$_POST['dos'];
		$valor[2]=$_POST['tres'];
		$valor[3]=$_POST['qtr'];
		$valor[4]=$_POST['cinc'];
		$valor[5]=$_POST['sis'];
		$valor[6]=$_POST['set'];
		$valor[7]=$_POST['vuit'];
		$valor[8]=$_POST['nou'];
		$valor[9]=$_POST['deu'];
		$valor[10]=$_POST['deu1'];
		$valor[11]=$_POST['deu2'];
		$valor[12]=$_POST['deu3'];
        $valor[13]=$_POST['deu4'];
		$valor[14]=$_POST['deu5'];
		$valor[15]=$_POST['deu6'];
		$valor[16]=$_POST['deu7'];
		$valor[17]=$_POST['deu8'];
		$valor[18]=$_POST['deu9'];
		$valor[19]=$_POST['vint'];
		$valor[20]=$_POST['vint1'];
		$valor[21]=$_POST['vint2'];
		$valor[22]=$_POST['vint3'];
		$valor[23]=$_POST['vint4'];
	
//$val=distribuciofrecuencies::validacio($senddistribucio);

//Replicacion de valores para todos los meses
$replicacio=$_POST['validacio1'];
$existe2=111;$existe=112;$sentencia="Sin";
if($replicacio=="1")
	{
	for($a_mes=1;$a_mes<=12;$a_mes++)
		{
		if ($a_mes!=$sendmes)
			{
			//Encontrar si para ese mes ya existe, si existe update, sino insert
			
			//$sentencia="DELETE FROM distribucions_diaries WHERE mes='$a_mes' and localitat='$sendlocalitat' and idDistribucio_diaria='$iddistribucio'";
			
			for($a_hora=0;$a_hora<=23;$a_hora++)
				{
				$existe=distribuciofrecuencies::obtenirnumdistribucioanualhora ($a_hora,$iddistribucio,$a_mes,$sendlocalitat);
				$valhora=$valor[$a_hora];
				
				
				if($existe==0)
					{	$sentencia = "insert into distribucions_diaries (idDistribucio_diaria,hora,valor,mes,localitat) VALUES (".$iddistribucio.",".$a_hora.",".$valhora.",".$a_mes.",'".$sendlocalitat."')";
						$retval = mysql_query( $sentencia, $conn );
						$sentencia = "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,valor,mes,localitat,projecte) VALUES (".$iddistribucio.",".$a_hora.",".$valhora.",".$a_mes.",'".$sendlocalitat."','".$projecte."')";
						$retval = mysql_query( $sentencia, $conn );	
					}
				else
					{
					$auxf=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojecte ($a_mes,$a_hora,$iddistribucio,$sendlocalitat,$projecte);
					$existe2=count($auxf)-1;
					
					if($existe2>0){
						//$sentencia= "UPDATE distribucions_diaries_projectes SET valor=".$valhora." WHERE idDistribucio_diaria=".$iddistribucio." and hora=".$a_hora." and mes=".$a_mes." and localitat='".$sendlocalitat."' and projecte='".$projecte."'";
						$sentencia= "UPDATE distribucions_diaries_projectes SET valor=".$valhora.",localitat='$sendlocalitat' WHERE idDistribucio_diaria=".$iddistribucio." and hora=".$a_hora." and mes=".$a_mes." and projecte='".$projecte."'";

						}
					else{$sentencia= "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,mes,valor,localitat,projecte) VALUES (".$iddistribucio.",".$a_hora.",".$a_mes.",".$valhora.",'".$sendlocalitat."','".$projecte."')";}			

					//$sentencia="UPDATE distribucions_diaries_projectes SET valor=$valhora WHERE idDistribucio_diaria=".$iddistribucio." and hora=".$a_hora." and mes=".$a_mes." and localitat='".$sendlocalitat."' and projecte='".$projecte."'";
					$retval=mysql_query($sentencia,$conn);
					}
				}
			}
			
		
		}
	
	$replicacio="2";
	}



	$hora=0;
	$Sumtotal=0;
	
	while ($hora<24)
		{
		//Si Existe para ese mes la distribucion diaria
		
		$existe=distribuciofrecuencies::obtenirnumdistribucioanualhora ($hora,$iddistribucio,$sendmes,$sendlocalitat);
		$valhora=$valor[$hora];
		$Sumtotal=$Sumtotal+$valhora;
		if ($existe=="0")
			{
			
			$sentencia = "insert into distribucions_diaries (idDistribucio_diaria,hora,valor,mes,localitat) VALUES (".$iddistribucio.",".$hora.",".$valhora.",".$sendmes.",'".$sendlocalitat."')";
           		$retval = mysql_query( $sentencia, $conn );
			$sentencia = "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,valor,mes,localitat,projecte) VALUES (".$iddistribucio.",".$hora.",".$valhora.",".$sendmes.",'".$sendlocalitat."','".$projecte."')";
           		$retval = mysql_query( $sentencia, $conn );

             		//mysql_close($conn);
			}
		else {
			$auxf=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojecte ($sendmes,$hora,$iddistribucio,$sendlocalitat,$projecte);
			$existe2=count($auxf)-1;
					
					if($existe2>0){
						//$sentencia= "UPDATE distribucions_diaries_projectes SET valor=".$valhora." WHERE idDistribucio_diaria=".$iddistribucio." and hora=".$hora." and mes=".$sendmes." and localitat='".$sendlocalitat."' and projecte='".$projecte."'";
						$sentencia= "UPDATE distribucions_diaries_projectes SET valor=".$valhora.",localitat='".$sendlocalitat."' WHERE idDistribucio_diaria=".$iddistribucio." and hora=".$hora." and mes=".$sendmes." and projecte='".$projecte."'";
			
						}
					else{$sentencia= "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,mes,valor,localitat,projecte) VALUES (".$iddistribucio.",".$hora.",".$sendmes.",".$valhora.",'".$sendlocalitat."','".$projecte."')";}			

					//$sentencia="UPDATE distribucions_diaries_projectes SET valor=$valhora WHERE idDistribucio_diaria=".$iddistribucio." and hora=".$a_hora." and mes=".$a_mes." and localitat='".$sendlocalitat."' and projecte='".$projecte."'";
					$retval=mysql_query($sentencia,gestio_projectesBBDD::$dbconn);			
					}
		$hora++;

		}
	//Caso especial para radiaci?n: integridad de suma para el valor mensual
	//echo $iddistribucio;
	if($iddistribucio==1)
		{
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
		$Sumtotal=$Sumtotal*$numdias;
		//buscar para ese proyecto, mes, localidad, 
		$existemes=distribuciofrecuencies::checkdistribucioanualprojecterad($projecte,$sendmes);
		$existemesref=distribuciofrecuencies::checkdistribucioanualprojecteradref($sendlocalitat,$sendmes);
		$sumexistente=distribuciofrecuencies::getdistribucioanualprojectesrad ($projecte,$sendmes);
		//echo "<br>var: $existemes,$existemesref,$sumexistente,$Sumtotal";
		if($sumexistente!=$Sumtotal)
			{
			if($existemes==0)
				{
				$sentencia = "insert into distribucions_anuals_projectes (idDistribucio_anual,mes,valor,localitat,projecte) VALUES (".$iddistribucio.",".$sendmes.",".$Sumtotal.",'".$sendlocalitat."','".$projecte."')";			
            	$retval = mysql_query( $sentencia, gestio_projectesBBDD::$dbconn );
				if($existemesref==0)
					{
					$sentencia = "insert into distribucions_anuals (idDistribucio_anual,mes,valor,localitat) VALUES (".$iddistribucio.",".$sendmes.",".$Sumtotal.",'".$sendlocalitat."')";			
            		$retval = mysql_query( $sentencia, gestio_projectesBBDD::$dbconn );
 
					}
				}
			else
				{
				$sentencia= "UPDATE distribucions_anuals_projectes SET valor=$Sumtotal,localitat='$sendlocalitat' WHERE idDistribucio_anual=".$iddistribucio." and mes=".$sendmes." and projecte='".$projecte."'";
				$retval = mysql_query( $sentencia, gestio_projectesBBDD::$dbconn );
				
				}
			}
		}	
$Sumtotal=0;
}
            
?>
<ul class="breadcrumbs first">
    <li><a href="chooselocation.php?t=Location&projh=<?php echo $projh;?>">Choose Location</a></li>
	<li><a href="gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">Monthly Data External Conditions</a></li>
    <li class="active"><a href="#">Dialy Data External Conditions</a></li>
</ul>


<div class="grid_16 widget first">
        <div class="widget_title clearfix">
            <h2>Data Introducing </h2>
        </div>
        <div class="widget_body">
	<form name="validation" method="POST" action = "<?php $_PHP_SELF ?>" id="gestion_frecuencia_diaria2">
                <div id="table1">
                <table >
                    <thead>
		    </thead>
			<tbody>
			    <tr>
				<td width="16%" colspan="10"><label>Type Data: <h2><?php echo "$senddistribucio"; ?></h2></label></td>
				<td width="16%" colspan="10"><label>Place: <h2><?php echo "$sendlocalitat"; ?></h2></label></td>
				<td width="16%" colspan="10"><label>Month:<h2><?php echo "$nommesgraf"; ?></h2></label></td>
				<td width="16%" colspan="10"></td>
				<td width="16%" colspan="10"></td>
				<td width="16%" colspan="10"></td>
				
			</tr>
			<tr>
				<td width="16%" colspan="10"><label>Unit measurement: </label></td>
				<td width="16%" colspan="10"><input class="medium :required" type="text" name="unitats" id="unitats" style="width:50px;"  value="<?php echo utf8_encode($unitatfrecuencia); ?>"><span class="infobar">Camp obligatori</span></td>
				<td width="16%" colspan="10"></td>
				<td width="16%" colspan="10"></td>
				<td width="16%" colspan="10"></td>
				<td width="16%" colspan="10"></td>			
	
			</tr>
				
                            <tr>
                                    <td  width="16%" colspan="10">  00  </td>
                                    <td  width="16%" colspan="10">  01  </td>
                                    <td  width="16%" colspan="10">  02  </td>
                                    <td  width="16%" colspan="10">  03  </td>
					<td  width="16%" colspan="10">  04   </td>
					<td  width="16%" colspan="10">  05   </td>
						
                            </tr>
                        
						<?php
							
								echo "<tr>";
								echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"una\" id=\"una\" style=\"width:50px;\"  value=\"".$valor[0]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"dos\" id=\"dos\" style=\"width:50px;\"  value=\"".$valor[1]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"tres\" id=\"tres\" style=\"width:50px;\"  value=\"".$valor[2]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"qtr\" id=\"qtr\" style=\"width:50px;\"  value=\"".$valor[3]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"cinc\" id=\"cinc\" style=\"width:50px;\"  value=\"".$valor[4]."\"><span class=\"infobar\">Required Field</span></td>";
								
								echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"sis\" id=\"sis\" style=\"width:50px;\"  value=\"".$valor[5]."\"><span class=\"infobar\">Required Field</span></td>";
								
								
							
						?>
				<tr>
					<td width="16%" colspan="10">  06  </td>
					<td width="16%" colspan="10">  07  </td>
					<td width="16%" colspan="10">  08  </td>
					<td width="16%" colspan="10">  09  </td>
					<td width="16%" colspan="10">  10  </td>
					<td width="16%" colspan="10">  11  </td>
				</tr>
				<tr>
					<?php
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"set\" id=\"set\" style=\"width:50px;\" value=\"".$valor[6]."\"><span class=\"infobar\">Required Field</span></td>";
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"vuit\" id=\"vuit\" style=\"width:50px;\" value=\"".$valor[7]."\"><span class=\"infobar\">Required Field</span></td>";
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"nou\" id=\"nou\" style=\"width:50px;\" value=\"".$valor[8]."\"><span class=\"infobar\">Required Field</span></td>";
								
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"deu\" id=\"deu\" style=\"width:50px;\" value=\"".$valor[9]."\"><span class=\"infobar\">Required Field</span></td>";
								
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"deu1\" id=\"deu1\" style=\"width:50px;\" value=\"".$valor[10]."\"><span class=\"infobar\">Required Field</span></td>";
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"deu2\" id=\"deu2\" style=\"width:50px;\" value=\"".$valor[11]."\"><span class=\"infobar\">Required Field</span></td>";
						echo "</tr>";
								
							
						?>
					
                            <tr>
                                    <td  width="16%" colspan="10">  12  </td>
                                    <td  width="16%" colspan="10">  13  </td>
                                    <td  width="16%" colspan="10">  14  </td>
                                    <td  width="16%" colspan="10">  15  </td>
					<td  width="16%" colspan="10">  16   </td>
					<td  width="16%" colspan="10">  17   </td>
						
                            </tr>
                        
						<?php
							
								echo "<tr>";
								echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"deu3\" id=\"deu3\" style=\"width:50px;\"  value=\"".$valor[12]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"deu4\" id=\"deu4\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[13]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"deu5\" id=\"deu5\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[14]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"deu6\" id=\"deu6\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[15]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"deu7\" id=\"deu7\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[16]."\"><span class=\"infobar\">Required Field</span></td>";
								
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"deu8\" id=\"deu8\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[17]."\"><span class=\"infobar\">Required Field</span></td>";
								
								
							
						?>
				<tr>
					<td width="16%" colspan="10">  18  </td>
					<td width="16%" colspan="10">  19 </td>
					<td width="16%" colspan="10">  20  </td>
					<td width="16%" colspan="10">  21  </td>
					<td width="16%" colspan="10">  22  </td>
					<td width="16%" colspan="10">  23  </td>
				</tr>
				<tr>
					<?php
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"deu9\" id=\"deu9\" style=\"width:50px;\" value=\"".$valor[18]."\"><span class=\"infobar\">Required Field</span></td>";
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"vint\" id=\"vint\" style=\"width:50px;\" value=\"".$valor[19]."\"><span class=\"infobar\">Required Field</span></td>";
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"vint1\" id=\"vint1\" style=\"width:50px;\" value=\"".$valor[20]."\"><span class=\"infobar\">Required Field</span></td>";
								
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"vint2\" id=\"vint2\" style=\"width:50px;\" value=\"".$valor[21]."\"><span class=\"infobar\">Required Field</span></td>";
								
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"vint3\" id=\"vint3\" style=\"width:50px;\" value=\"".$valor[22]."\"><span class=\"infobar\">Required Field</span></td>";
						echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"vint4\" id=\"vint4\" style=\"width:50px;\" value=\"".$valor[23]."\"><span class=\"infobar\">Required Field</span></td>";
						echo "</tr>";
								
							
						?>
				<tr><td><label style="width:50px;"> Options :</label></td></tr>
				
				<tr><td><label style="width:50px;"> Replay :</label></td></tr>
				<tr>
					
					<td width="16%" colspan="10"><input type="radio" name="validacio1" style="width:50px;" value="1" >Replay months</td>
					<td width="16%" colspan="10"><input type="radio" name="validacio1" style="width:50px;" value="2" checked>No Replay</td>
				</tr>
			
				<tr>
				<td>
				<input type="submit" class="btn blue" style="width:100px;" name="add" id="add" value="Next">
				
				</td>
				</tr>
				<div class="grid_16 first">
						</div>
				<div class="clear"></div>
                        
		
			
		</td>
	    </tr>
		</tbody>
                    </table>
			
                
            
		
		
		</div>
		<input type="hidden" name="tipusdis" id="tipusdis" value="<?php echo $iddistribucio; ?>">
		<input type="hidden" name="mes" id="mes" value="<?php echo $sendmes; ?>">
		<input type="hidden" name="locals" id="locals" value="<?php echo $sendlocalitat; ?>">
		
		<!--<input type="hidden" name="nomdemand" id="nomdemand" value="<?php echo $senddistribucio; ?>">-->
		<input type="hidden" name="iddistribucio" id="iddistribucio" value="<?php echo $iddistribucio; ?>">
		<!--<input type="hidden" name="demanda" id="demanda" value="<?php echo $senddemanda; ?>">-->
		<input type="hidden" name="projh" id="projh" value="<?php echo $projh; ?>">

	</form>
        </div>
    </div>
	
         
            <?php
         //}
      ?>

<?php include("footer.php") ?>