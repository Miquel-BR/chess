<?php

include('header.php');
// INCLUDES
require_once("./class/gestio_projectesBBDD.php");
require_once("./class/usuari.php");
require_once("./class/distribuciofrecuencies.php");
require_once("./class/projectes.php");

gestio_projectesBBDD::setup();

if(isset($_GET['nomdemand'])){$senddistribucio=$_GET['nomdemand'];}
if(isset($_POST['nomdemand'])){$senddistribucio=$_POST['nomdemand'];}
if(isset($_GET['iddemand'])){$iddistribucio=$_GET['iddemand'];}
if(isset($_POST['iddemand'])){$iddistribucio=$_POST['iddemand'];}
if(isset($_GET['demanda'])){$senddemanda=$_GET['demanda'];}
if(isset($_POST['demanda'])){$senddemanda=$_POST['demanda'];}
if(isset($_POST['mes'])){$sendmes=$_POST['mes'];$envio="POST";}
if(isset($_GET['mes'])){$sendmes=$_GET['mes'];$envio="GET";}

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

if(isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}

$aux=projectes::getprojecteactual();
//$projecte=$aux['nomproject'];
$projecte=$projh;

$localitat=$aux['localitat'];

$replicacio=0;
$ajuste=0;

//forzamos que sea radiacion, con iddistribucio="1"
$senddistribucio=distribuciofrecuencies::obtenirnomdistribucio($iddistribucio);
$unitatfrecuencia=distribuciofrecuencies::getunitat($senddistribucio);
if($iddistribucio==4){$senddistribucio=$senddistribucio." Fraction of hourly Demand (%).";}

//Variar funciones

$valorsdistribuciodiaria=distribuciofrecuencies::getdadesdistribuciodiariaprojectedemanda($iddistribucio,$sendmes,$senddemanda,$projecte);
$numvalorsdistribuciodiaria=count($valorsdistribuciodiaria)-1;
if($numvalorsdistribuciodiaria>0)
	{
	for($i=0;$i<=23;$i++){
		$valorsdistribuciodiariames=distribuciofrecuencies::getdadesdistribuciodiariamesprojectedemanda($iddistribucio,$senddemanda,$sendmes,$i,$projecte);
		$numvalordistribuciodiariames=count($valorsdistribuciodiariames)-1;
		if($numvalordistribuciodiariames>0){
			$valor[$i]=$valorsdistribuciodiariames[1]['valor'];}
		else {$valor[$i]="";}
		}


	}
else 
	{
	for($i=0;$i<=23;$i++){
		
		$valordistribuciodiariamesref=distribuciofrecuencies::getdadesdistribuciodiariameshorademanda($iddistribucio,$senddemanda,$sendmes,$i);
		$numvalordistribuciodiariaref=count($valordistribuciodiariamesref)-1;
		//print_r($valordistribuciodiariamesref);
		
		
		if($numvalordistribuciodiariaref>0){
			$valor[$i]=$valordistribuciodiariamesref[1]['valor'];
			}
		else {$valor[$i]="";}
		}
	}





$sentencia="Sin sentencia";$existe="Sin tratar";

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

$valor=distribuciofrecuencies::ajustpercentatges($valor,24);

//Replicacion de valores para todos los meses
$replicacio=$_POST['validacio1'];
if($replicacio=="1")
	{
	for($a_mes=1;$a_mes<=12;$a_mes++)
		{
		if ($a_mes!=$sendmes)
			{
			
			for($a_hora=0;$a_hora<=23;$a_hora++)
				{
				$existe=distribuciofrecuencies::obtenirnumdistribucioanualhorademanda ($a_hora,$senddistribucio,$a_mes,$senddemanda);
				$valhora=$valor[$a_hora];
				if($existe=="0")
					{$sentencia="insert into distribucions_diaries (idDistribucio_diaria,hora,valor,mes,demand) VALUES (".$iddistribucio.",".$a_hora.",".$valhora.",".$a_mes.",'".$senddemanda."')";
					$retval=mysql_query($sentencia,gestio_projectesBBDD::$dbconn);
					$sentencia = "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,valor,mes,demand,projecte) VALUES (".$iddistribucio.",".$a_hora.",".$valhora.",".$a_mes.",'".$senddemanda."','".$projecte."')";
					$retval = mysql_query( $sentencia, gestio_projectesBBDD::$dbconn );	

					}
				else
					{
					$auxf=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojectedemanda ($a_mes,$a_hora,$iddistribucio,$senddemanda,$projecte);
					$existe2=count($auxf)-1;
					
					if($existe2>0){
						//$sentencia= "UPDATE distribucions_diaries_projectes SET valor=".$valhora." WHERE idDistribucio_diaria=".$iddistribucio." and hora=".$a_hora." and mes=".$a_mes." and demand='".$senddemanda."' and projecte='".$projecte."'";
						$sentencia= "UPDATE distribucions_diaries_projectes SET valor=".$valhora.",demand='$senddemanda' WHERE idDistribucio_diaria=".$iddistribucio." and hora=".$a_hora." and mes=".$a_mes." and projecte='".$projecte."'";
						
						}
					else{$sentencia= "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,mes,valor,demand,projecte) VALUES (".$iddistribucio.",".$a_hora.",".$a_mes.",".$valhora.",'".$senddemanda."','".$projecte."')";}			

					//$sentencia="UPDATE distribucions_diaries_projectes SET valor=$valhora WHERE idDistribucio_diaria=".$iddistribucio." and hora=".$a_hora." and mes=".$a_mes." and localitat='".$sendlocalitat."' and projecte='".$projecte."'";
					$retval=mysql_query($sentencia,gestio_projectesBBDD::$dbconn);				
					}
				}
		
			}
		}
	$replicacio="2";
	}


	$hora=0;
	while ($hora<=23)
		{
		//Si Existe para ese mes la distribucion diaria
		
		$existe=distribuciofrecuencies::obtenirnumdistribucioanualhorademanda ($hora,$senddistribucio,$sendmes,$senddemanda);
		$valhora=$valor[$hora];
		echo $existe;
		if ($existe=="0")
			{
			
			$sentencia = "insert into distribucions_diaries (idDistribucio_diaria,hora,valor,mes,demand) VALUES (".$iddistribucio.",".$hora.",".$valhora.",".$sendmes.",'".$senddemanda."')";
           		$retval = mysql_query( $sentencia, gestio_projectesBBDD::$dbconn );
             		//mysql_close($conn);
			$sentencia = "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,valor,mes,demand,projecte) VALUES (".$iddistribucio.",".$hora.",".$valhora.",".$sendmes.",'".$senddemanda."','".$projecte."')";
           		$retval = mysql_query( $sentencia, gestio_projectesBBDD::$dbconn );

			}
		else {
			$auxf=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojectedemanda ($sendmes,$hora,$iddistribucio,$senddemanda,$projecte);
			$existe2=count($auxf)-1;
					
			if($existe2>0){
			//$sentencia= "UPDATE distribucions_diaries_projectes SET valor=".$valhora." WHERE idDistribucio_diaria=".$iddistribucio." and hora=".$hora." and mes=".$sendmes." and demand='".$senddemanda."' and projecte='".$projecte."'";
			$sentencia= "UPDATE distribucions_diaries_projectes SET valor=".$valhora.",demand='$senddemanda' WHERE idDistribucio_diaria=".$iddistribucio." and hora=".$hora." and mes=".$sendmes." and projecte='".$projecte."'";
			
			}
					else{$sentencia= "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,mes,valor,demand,projecte) VALUES (".$iddistribucio.",".$hora.",".$sendmes.",".$valhora.",'".$senddemanda."','".$projecte."')";}			

					//$sentencia="UPDATE distribucions_diaries_projectes SET valor=$valhora WHERE idDistribucio_diaria=".$iddistribucio." and hora=".$a_hora." and mes=".$a_mes." and localitat='".$sendlocalitat."' and projecte='".$projecte."'";
					$retval=mysql_query($sentencia,gestio_projectesBBDD::$dbconn);			
			}
		
		$hora++;
		}
	
}
//echo "$sentencia";            
?>
<ul class="breadcrumbs first">
    
    
    <li><a href="choosedemand.php?t=Location&projh=<?php echo $projh;?>">Choose Demand</a></li>
	<li><a href="gestio_dades_frecuencia_anual_energydemand.php?t=Monthly Data&tipusdis=<?php echo $iddistribucio;?>&demanda=<?php echo $senddemanda;?>&nomdemand=<?php echo $senddistribucio;?>&iddemand=<?php echo $iddistribucio;?>&projh=<?php echo $projh;?>">Monthly Data Energy Demand</a></li>
    <li class="active"><a href="#">Dialy Data Energy Demand</a></li>

	</ul>


<div class="grid_16 widget first">
        <div class="widget_title clearfix">
            <h2>Data Management </h2>
        </div>
        <div class="widget_body">
	<form name="validation" method="POST" action = "<?php $_PHP_SELF ?>" id="gestion_frecuencia_diaria2">
                <div id="table1">
                <table >
                    <thead>
		    </thead>
			<tbody>
			    <tr>
				<td width="16%" colspan="10"><label>Type Data: <!--<h2>--><?php echo $senddistribucio; ?><!--</h2>--></label></td>
				<td width="16%" colspan="10"><label>Tipology:<h2><?php echo $senddemanda;?> </h2></label></td>
				<td width="16%" colspan="10"><label>Month:<h2><?php echo $nommesgraf; ?></h2></label></td></td>
				<td width="16%" colspan="10"></td>
				<td width="16%" colspan="10"></td>
				<td width="16%" colspan="10"></td>
			</tr>
			<tr>
				
			</tr>
				
                            <tr>
                            <td  width="16%" colspan="10">  00  </td>
                            <td  width="16%" colspan="10">  01  </td>
                            <td  width="16%" colspan="10">  02  </td>
                            <td  width="16%" colspan="10">  03  </td>
							<td  width="16%" colspan="10">  04  </td>
							<td  width="16%" colspan="10">  05  </td>
						
                            </tr>
                        
						<?php
							
								echo "<tr>";
								echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"una\" id=\"gen\" style=\"width:50px;\"  value=\"".$valor[0]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"dos\" id=\"gen\" style=\"width:50px;\"  value=\"".$valor[1]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"tres\" id=\"gen\" style=\"width:50px;\"  value=\"".$valor[2]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"qtr\" id=\"gen\" style=\"width:50px;\"  value=\"".$valor[3]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"cinc\" id=\"gen\" style=\"width:50px;\"  value=\"".$valor[4]."\"><span class=\"infobar\">Required Field</span></td>";
								
								echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"sis\" id=\"gen\" style=\"width:50px;\"  value=\"".$valor[5]."\"><span class=\"infobar\">Required Field</span></td>";
								
								
							
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
									<td  width="16%" colspan="10">  16  </td>
									<td  width="16%" colspan="10">  17  </td>
						
                            </tr>
                        
						<?php
							
								echo "<tr>";
								echo "<td width=\"16%\" colspan=\"10\"><input class=\"medium :required\" type=\"text\" name=\"deu3\" id=\"deu3\" style=\"width:50px;\"  value=\"".$valor[12]."\"><span class=\"infobar\">Camp obligatori</span></td>";
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"deu4\" id=\"deu4\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[13]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"deu5\" id=\"deu5\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[14]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"deu6\" id=\"deu6\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[15]."\"><span class=\"infobar\">Required Field</span></td>";
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"deu7\" id=\"deu7\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[16]."\"><span class=\"infobar\">Required Field</span></td>";
								
								echo "<td width=\"16%\" colspan=\"10\" ><input class=\"medium :required\" type=\"text\" name=\"deu8\" id=\"deu8\" style=\"width:50px;\" width=\"100%\" value=\"".$valor[17]."\"><span class=\"infobar\">Required Field</span></td>";
								
								
							
						?>
				<tr>
					<td width="16%" colspan="10">  18  </td>
					<td width="16%" colspan="10">  19  </td>
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
				
				<tr><td><label style="width:50px;"> Reply Monthly:</label></td></tr>
				<tr>
					
					<td width="16%" colspan="10"><input type="radio" name="validacio1" style="width:50px;" value="1" >Reply</td>
					<td width="16%" colspan="10"><input type="radio" name="validacio1" style="width:50px;" value="2" checked>No Reply</td>
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
		<input type="hidden" name="mes" id="mes" value="<?php echo $sendmes; ?>">
		<input type="hidden" name="nomdemand" id="nomdemand" value="<?php echo $senddistribucio; ?>">
		<input type="hidden" name="iddemand" id="iddemand" value="<?php echo $iddistribucio; ?>">
		<input type="hidden" name="demanda" id="demanda" value="<?php echo $senddemanda; ?>">
		<input type="hidden" name="projh" id="projh" value="<?php echo $projh; ?>">

	</form>
        </div>
    </div>
	
         
            <?php
         
      ?>

<?php include("footer.php") ?>