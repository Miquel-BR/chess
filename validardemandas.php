<?php
//set_time_limit(1200);
//ini_set('memory_limit', '1024M');
// INCLUDES
require("./class/gestio_projectesBBDD.php");
require("./class/usuari.php");
require("./class/demandas.php");
require("./class/distribuciofrecuencies.php");
require_once("./class/projectes.php");
gestio_projectesBBDD::setup();
$aux="sin data";$aux2="sin data2";
if(isset($_POST['demands'])){$demanda=$_POST['demands'];}
if (isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}
//$aux=projectes::getprojecteactual();
//$projecte=$aux['nomproject'];
$projecte=$projh;
//if(isset($_POST['hotwaterdemand']) && isset ($_POST['hotwatertemp']) && isset($_POST['heatingdemand']) && isset($_POST['heatingtemp']) && isset($_POST['coolingdemand']) && isset($_POST['coolingtemp']) && isset($_POST['electricappdemand'])  && isset($_POST['numhomes']) && isset($_POST['demands']))
//echo "var:".$_POST['hotwaterdemand'].",".$_POST['hotwatertemp'].",".$_POST['heatingdemand'].",".$_POST['heatingtemp'].",".$_POST['coolingdemand'].",".$_POST['coolingtemp'].",".$_POST['electricappdemand'].",".$_POST['numhomes'].",".$_POST['demands'];

if(isset($_POST['hotwaterdemand']) && isset ($_POST['hotwatertemp']) && isset($_POST['heatingdemand']) && isset($_POST['heatingtemp']) && isset($_POST['coolingdemand']) && isset($_POST['coolingtemp']) && isset($_POST['electricappdemand'])  && isset($_POST['numhomes']) && isset($_POST['demands']))
{
	//echo "var:".$_POST['hotwaterdemand'].",".$_POST['hotwatertemp'].",".$_POST['heatingdemand'].",".$_POST['heatingtemp'].",".$_POST['coolingdemand'].",".$_POST['coolingtemp'].",".$_POST['electricappdemand'].",".$_POST['numhomes'].",".$_POST['demands'];
	if(($_POST['hotwaterdemand']!="") &&  ($_POST['hotwatertemp']!="") && ($_POST['heatingdemand']!="") && ($_POST['heatingtemp']!="") && ($_POST['coolingdemand']!="") && ($_POST['coolingtemp']!="") && ($_POST['electricappdemand']!="")  && ($_POST['numhomes']!="") && ($_POST['demands']!=""))
		{
		$_SESSION['demanda']=$_POST['demands'];
		$demanda=$_POST['demands'];
		
		$aux=demandas::addprojectdemanda($_POST['heatingdemand'],$_POST['heatingtemp'],$_POST['hotwaterdemand'],$_POST['hotwatertemp'],$_POST['coolingdemand'],$_POST['coolingtemp'],$_POST['electricappdemand'],$_POST['numhomes'],$_POST['demands'],$projecte);
		if(isset($_POST['heating']))
			{
			$aux=distribuciofrecuencies::obtenirnomdistribucio(4);
			$_SESSION['nomdemand']=$aux;
			$_SESSION['iddemand']=4;
			$aux2=$_POST['demands'];
			header("location:gestio_dades_frecuencia_anual_energydemand.php?t=Energy&nomdemand=$aux&iddemand=4&demanda=$aux2&projh=$projh");
			}
		if(isset($_POST['hotwater']))
			{
			$aux=distribuciofrecuencies::obtenirnomdistribucio(4);
			$_SESSION['nomdemand']=$aux;
			$_SESSION['iddemand']=5;
			$aux2=$_POST['demands'];
			header("location:gestio_dades_frecuencia_anual_energydemand.php?t=Energy&nomdemand=$aux&iddemand=5&demanda=$aux2&projh=$projh");
			}
		if(isset($_POST['cooling']))
			{
			$aux=distribuciofrecuencies::obtenirnomdistribucio(4);
			$_SESSION['nomdemand']=$aux;
			$_SESSION['iddemand']=6;
			$aux2=$_POST['demands'];
			header("location:gestio_dades_frecuencia_anual_energydemand.php?t=Energy&nomdemand=$aux&iddemand=6&demanda=$aux2&projh=$projh");
			}
		if(isset($_POST['electricapp']))
			{
			$aux=distribuciofrecuencies::obtenirnomdistribucio(4);
			$_SESSION['nomdemand']=$aux;
			$_SESSION['iddemand']=7;
			$aux2=$_POST['demands'];
			header("location:gestio_dades_frecuencia_anual_energydemand.php?t=Energy&nomdemand=$aux&iddemand=7&demanda=$aux2&projh=$projh");
			}
		if(isset($_POST['submit'])){
			//echo $_POST['dis4'].",".$_POST['dis5'].",".$_POST['dis6'].",".$_POST['dis7'];
			//si alguno de los cuatro es un 2 hay que pasar de referencia a proyecto
			$localitat=$_POST['localitat'];
			//echo $_POST['dis4'];
			//echo "<br>";
			if($_POST['dis4']==2)
				{
				//Si existe la referencia para cada mes
				for ($i=1;$i<=12;$i++)
					{
					//Para iddis=1 tomas datos de la ref datos anuales projecto
					$vectorvaloresanualref=distribuciofrecuencies::obtenirnumdistribucioanualmesdemanda($i,4,$localitat);
					$numvectorvalanualref=count($vectorvaloresanualref)-1;
					
					//print_r($vectorvaloresanualref);
					
					//print_r($vectorvaloresanualref);
					if($numvectorvalanualref>0)
						{
						$vectorvaloresanualproj=distribuciofrecuencies::obtenirnumdistribucioanualmesprojectedemanda($i,4,$localitat,$projecte);
						$numvectorvalanualproj=count($vectorvaloresanualproj)-1;
						//comprobar que no existe el anual-projecto: se necesita projecto,mes,localitat,valor,iddis=1
						$vectorvaloresanualprojloc=distribuciofrecuencies::obtenirnumdistribucioanualmesprojectedemanda($i,4,$localitat,$projecte);
						$numvectorvalanualprojloc=count($vectorvaloresanualprojloc)-1;
						
						
						//print_r($vectorvaloresanualprojloc);
						if($numvectorvalanualprojloc==0)
							{
							
								//Pasar los datos de la ref al anual para cada mes
								foreach ($vectorvaloresanualref as $ar)
								{
								$auxvalor=$ar["valor"];
								if($auxvalor== null){$auxvalor=0;}
								if($auxvalor!=""){
									if($numvectorvalanualproj==0){
										$sentencia = "insert into distribucions_anuals_projectes (idDistribucio_anual,mes,valor,demand,projecte) VALUES (4,".$i.",".$auxvalor.",'".$localitat."','".$projecte."')";			
										}
									    else{$sentencia="UPDATE distribucions_anuals_projectes SET valor=".$auxvalor.",demand='".$localitat."' WHERE mes=".$i." and idDistribucio_anual=4 and projecte='$projecte'";
										}
									//$retval = mysql_query( $sentencia, $conn );
									$resultado=mysql_query($sentencia,gestio_projectesBBDD::$dbconn);
									//echo "<Br>$sentencia";
									}
								
								}
							
								
							}
						
						//Para cada mes, hora
						}
					$x=1;
					for($j=0;$j<=23;$j++)
						{
						$vectorvaloresdiarioref=distribuciofrecuencies::obtenirdistribucioanualhorademanda($j,4,$i,$demanda);
						$numvectorvaldiaref=count($vectorvaloresdiarioref)-1;
						if($numvectorvaldiaref>0)
							{
							$vectorvaloresdiaproj=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojectedemanda($i,$j,4,$demanda,$projecte);
							$numvectorvaldiaproj=count($vectorvaloresdiaproj)-1;
							$vectorvaloresdiaprojloc=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojectedemandaloc($i,$j,4,$demanda,$projecte);
							$numvectorvaldiaprojloc=count($vectorvaloresdiaprojloc)-1;

							if($numvectorvaldiaprojloc==0)
								{
								//Para horario: tomar datos de la ref, localitat, iddis=1, mes, valor
								//Comprobar que no existe el diario-projecto: se necesita projecto, mes, hora, localitat, valor, iddis=1
								//Pasar los datos de la ref al projecto para cada mes hora: proyecto, mes, hora, localidad, valor, iddis=1
								foreach ($vectorvaloresdiarioref as $ar2)
									{
									$auxvalor=$ar2["valor"];
									if($auxvalor!=""){
										if($numvectorvaldiaproj==0){
											$sentencia = "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,valor,mes,demand,projecte) VALUES (4,".$j.",".$auxvalor.",".$i.",'".$demanda."','".$projecte."')";
											}
										else
											{$sentencia="UPDATE distribucions_diaries_projectes SET valor=".$auxvalor.",demand='".$demanda."' WHERE mes=".$i." and hora=".$j." and idDistribucio_diaria=4 and projecte='".$projecte."'";
											}
										
										$resultado=mysql_query($sentencia,gestio_projectesBBDD::$dbconn);
										//echo "<Br>$sentencia";
										$x++;
										}
									}
								}
							}	
						}
					}
				}
			if($_POST['dis5']==2)
				{
				//Si existe la referencia para cada mes
				for ($i=1;$i<=12;$i++)
					{
					//Para iddis=1 tomas datos de la ref datos anuales projecto
					$vectorvaloresanualref=distribuciofrecuencies::obtenirnumdistribucioanualmesdemanda($i,5,$localitat);
					$numvectorvalanualref=count($vectorvaloresanualref)-1;
					
					if($numvectorvalanualref>0)
						{
						$vectorvaloresanualproj=distribuciofrecuencies::obtenirnumdistribucioanualmesprojectedemanda($i,5,$localitat,$projecte);
						$numvectorvalanualproj=count($vectorvaloresanualproj)-1;
						//comprobar que no existe el anual-projecto: se necesita projecto,mes,localitat,valor,iddis=1
						$vectorvaloresanualprojloc=distribuciofrecuencies::obtenirnumdistribucioanualmesprojectedemanda($i,5,$localitat,$projecte);
						$numvectorvalanualprojloc=count($vectorvaloresanualprojloc)-1;
						
						
						
						if($numvectorvalanualprojloc==0)
							{
							
								//Pasar los datos de la ref al anual para cada mes
								foreach ($vectorvaloresanualref as $ar)
								{
								$auxvalor=$ar["valor"];
								if($auxvalor!=""){
									if($numvectorvalanualproj==0){
										$sentencia = "insert into distribucions_anuals_projectes (idDistribucio_anual,mes,valor,demand,projecte) VALUES (5,".$i.",".$auxvalor.",'".$localitat."','".$projecte."')";			
										}
									else{$sentencia="UPDATE distribucions_anuals_projectes SET valor=".$auxvalor.",demand='".$localitat."' WHERE mes=".$i." and idDistribucio_anual=5 and projecte='$projecte'";
										}
									//$retval = mysql_query( $sentencia, $conn );
									$resultado=mysql_query($sentencia,gestio_projectesBBDD::$dbconn);
									//echo "<Br>$sentencia";
									}
								}
							
								
							}
						
						//Para cada mes, hora
						}
					$x=1;
					for($j=0;$j<=23;$j++)
						{
						$vectorvaloresdiarioref=distribuciofrecuencies::obtenirdistribucioanualhorademanda($j,5,$i,$demanda);
						$numvectorvaldiaref=count($vectorvaloresdiarioref)-1;
						if($numvectorvaldiaref>0)
							{
							$vectorvaloresdiaproj=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojectedemanda($i,$j,5,$demanda,$projecte);
							$numvectorvaldiaproj=count($vectorvaloresdiaproj)-1;
							$vectorvaloresdiaprojloc=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojectedemandaloc($i,$j,5,$demanda,$projecte);
							$numvectorvaldiaprojloc=count($vectorvaloresdiaprojloc)-1;

							if($numvectorvaldiaprojloc==0)
								{
								//Para horario: tomar datos de la ref, localitat, iddis=1, mes, valor
								//Comprobar que no existe el diario-projecto: se necesita projecto, mes, hora, localitat, valor, iddis=1
								//Pasar los datos de la ref al projecto para cada mes hora: proyecto, mes, hora, localidad, valor, iddis=1
								foreach ($vectorvaloresdiarioref as $ar2)
									{
									$auxvalor=$ar2["valor"];
									if($auxvalor!=""){
										if($numvectorvaldiaproj==0){
											$sentencia = "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,valor,mes,demand,projecte) VALUES (5,".$j.",".$auxvalor.",".$i.",'".$demanda."','".$projecte."')";
											}
										else
											{$sentencia="UPDATE distribucions_diaries_projectes SET valor=".$auxvalor.",demand='".$demanda."' WHERE mes=".$i." and hora=".$j." and idDistribucio_diaria=5 and projecte='".$projecte."'";
											}
										
										$resultado=mysql_query($sentencia,gestio_projectesBBDD::$dbconn);
										//echo "<Br>$sentencia";
										$x++;
										}
									}
								}
							}	
						}
					}
				}
			if($_POST['dis6']==2)
				{
				//Si existe la referencia para cada mes
				for ($i=1;$i<=12;$i++)
					{
					//Para iddis=1 tomas datos de la ref datos anuales projecto
					$vectorvaloresanualref=distribuciofrecuencies::obtenirnumdistribucioanualmesdemanda($i,6,$localitat);
					$numvectorvalanualref=count($vectorvaloresanualref)-1;
					
					if($numvectorvalanualref>0)
						{
						$vectorvaloresanualproj=distribuciofrecuencies::obtenirnumdistribucioanualmesprojectedemanda($i,6,$localitat,$projecte);
						$numvectorvalanualproj=count($vectorvaloresanualproj)-1;
						//comprobar que no existe el anual-projecto: se necesita projecto,mes,localitat,valor,iddis=1
						$vectorvaloresanualprojloc=distribuciofrecuencies::obtenirnumdistribucioanualmesprojectedemandaloc($i,6,$localitat,$projecte);
						$numvectorvalanualprojloc=count($vectorvaloresanualprojloc)-1;
						
						
						
						if($numvectorvalanualprojloc==0)
							{
							
								//Pasar los datos de la ref al anual para cada mes
								foreach ($vectorvaloresanualref as $ar)
								{
								$auxvalor=$ar["valor"];
								if($auxvalor!=""){
									if($numvectorvalanualproj==0){
										$sentencia = "insert into distribucions_anuals_projectes (idDistribucio_anual,mes,valor,demand,projecte) VALUES (6,".$i.",".$auxvalor.",'".$localitat."','".$projecte."')";			
										}
									else{$sentencia="UPDATE distribucions_anuals_projectes SET valor=".$auxvalor.",demand='".$localitat."' WHERE mes=".$i." and idDistribucio_anual=6 and projecte='$projecte'";
										}
									//$retval = mysql_query( $sentencia, $conn );
									$resultado=mysql_query($sentencia,gestio_projectesBBDD::$dbconn);
									//echo "<Br>$sentencia";
									}
								}
							
								
							}
						
						//Para cada mes, hora
						}
					$x=1;
					for($j=0;$j<=23;$j++)
						{
						$vectorvaloresdiarioref=distribuciofrecuencies::obtenirdistribucioanualhorademanda($j,6,$i,$demanda);
						$numvectorvaldiaref=count($vectorvaloresdiarioref)-1;
						if($numvectorvaldiaref>0)
							{
							$vectorvaloresdiaproj=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojectedemanda($i,$j,6,$demanda,$projecte);
							$numvectorvaldiaproj=count($vectorvaloresdiaproj)-1;
							$vectorvaloresdiaprojloc=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojectedemandaloc($i,$j,6,$demanda,$projecte);
							$numvectorvaldiaprojloc=count($vectorvaloresdiaprojloc)-1;

							if($numvectorvaldiaprojloc==0)
								{
								//Para horario: tomar datos de la ref, localitat, iddis=1, mes, valor
								//Comprobar que no existe el diario-projecto: se necesita projecto, mes, hora, localitat, valor, iddis=1
								//Pasar los datos de la ref al projecto para cada mes hora: proyecto, mes, hora, localidad, valor, iddis=1
								foreach ($vectorvaloresdiarioref as $ar2)
									{
									$auxvalor=$ar2["valor"];
									if($auxvalor!=""){
										if($numvectorvaldiaproj==0){
											$sentencia = "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,valor,mes,demand,projecte) VALUES (6,".$j.",".$auxvalor.",".$i.",'".$demanda."','".$projecte."')";
											}
										else
											{$sentencia="UPDATE distribucions_diaries_projectes SET valor=".$auxvalor.",demand='".$demanda."' WHERE mes=".$i." and hora=".$j." and idDistribucio_diaria=6 and projecte='".$projecte."'";
											}
										
										$resultado=mysql_query($sentencia,gestio_projectesBBDD::$dbconn);
										//echo "<Br>$sentencia";
										$x++;
										}
									}
								}
							}	
						}
					}
				}
			if($_POST['dis7']==2)
				{
				//Si existe la referencia para cada mes
				for ($i=1;$i<=12;$i++)
					{
					//Para iddis=1 tomas datos de la ref datos anuales projecto
					$vectorvaloresanualref=distribuciofrecuencies::obtenirnumdistribucioanualmesdemanda($i,7,$localitat);
					$numvectorvalanualref=count($vectorvaloresanualref)-1;
					
					if($numvectorvalanualref>0)
						{
						$vectorvaloresanualproj=distribuciofrecuencies::obtenirnumdistribucioanualmesprojectedemanda($i,7,$localitat,$projecte);
						$numvectorvalanualproj=count($vectorvaloresanualproj)-1;
						//comprobar que no existe el anual-projecto: se necesita projecto,mes,localitat,valor,iddis=1
						$vectorvaloresanualprojloc=distribuciofrecuencies::obtenirnumdistribucioanualmesprojectedemandaloc($i,7,$localitat,$projecte);
						$numvectorvalanualprojloc=count($vectorvaloresanualprojloc)-1;
						
						
						
						if($numvectorvalanualprojloc==0)
							{
							
								//Pasar los datos de la ref al anual para cada mes
								foreach ($vectorvaloresanualref as $ar)
								{
								$auxvalor=$ar["valor"];
								if($auxvalor!=""){
									if($numvectorvalanualproj==0){
										$sentencia = "insert into distribucions_anuals_projectes (idDistribucio_anual,mes,valor,demand,projecte) VALUES (7,".$i.",".$auxvalor.",'".$localitat."','".$projecte."')";			
										}
									else{$sentencia="UPDATE distribucions_anuals_projectes SET valor=".$auxvalor.",demand='".$localitat."' WHERE mes=".$i." and idDistribucio_anual=7 and projecte='$projecte'";
										}
									//$retval = mysql_query( $sentencia, $conn );
									$resultado=mysql_query($sentencia,gestio_projectesBBDD::$dbconn);
									//echo "<Br>$sentencia";
									}
								}
							
								
							}
						
						//Para cada mes, hora
						}
					$x=1;
					for($j=0;$j<=23;$j++)
						{
						$vectorvaloresdiarioref=distribuciofrecuencies::obtenirdistribucioanualhorademanda($j,7,$i,$demanda);
						$numvectorvaldiaref=count($vectorvaloresdiarioref)-1;
						if($numvectorvaldiaref>0)
							{
							$vectorvaloresdiaproj=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojectedemanda($i,$j,7,$demanda,$projecte);
							$numvectorvaldiaproj=count($vectorvaloresdiaproj)-1;
							$vectorvaloresdiaprojloc=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojectedemandaloc($i,$j,7,$demanda,$projecte);
							$numvectorvaldiaprojloc=count($vectorvaloresdiaprojloc)-1;

							if($numvectorvaldiaprojloc==0)
								{
								//Para horario: tomar datos de la ref, localitat, iddis=1, mes, valor
								//Comprobar que no existe el diario-projecto: se necesita projecto, mes, hora, localitat, valor, iddis=1
								//Pasar los datos de la ref al projecto para cada mes hora: proyecto, mes, hora, localidad, valor, iddis=1
								foreach ($vectorvaloresdiarioref as $ar2)
									{
									$auxvalor=$ar2["valor"];
									if($auxvalor!=""){
										if($numvectorvaldiaproj==0){
											$sentencia = "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,valor,mes,demand,projecte) VALUES (7,".$j.",".$auxvalor.",".$i.",'".$demanda."','".$projecte."')";
											}
										else
											{$sentencia="UPDATE distribucions_diaries_projectes SET valor=".$auxvalor.",demand='".$demanda."' WHERE mes=".$i." and hora=".$j." and idDistribucio_diaria=7 and projecte='".$projecte."'";
											}
										
										$resultado=mysql_query($sentencia,gestio_projectesBBDD::$dbconn);
										//echo "<Br>$sentencia";
										$x++;
										}
									}
								}
							}	
						}
					}
				}
			//$dis4v=$_POST['dis4'];
			//echo "var:$dis4v";
			header("location:gestio_dades_solar.php?t=Inici&projh=$projh");
			}
		
		//header("location:choosedemand.php?t=Energy&projh=$projh");
		}
	  else{
		
		header("location:choosedemand.php?t=Energy&projh=$projh&mensaje=Empty Values");
		?>
		<script type="text/javascript">
		alert('Empty Values!');
		</script>
		<?php
		}
	}
else {
	header("location:choosedemand.php?error");
	}
//header("location:choosedemand.php?t=Energy&projh=$projh");
//echo "var".$_SESSION['locali'].",".$_POST['locals'].",".$_POST['eleccio'].",".$aux.",".$aux2;
?>