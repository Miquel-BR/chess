<?php
set_time_limit(2400);
ini_set('memory_limit', '2048M');
// INCLUDES
require("./class/gestio_projectesBBDD.php");
require("./class/usuari.php");
require("./class/localitat.php");
require_once("./class/projectes.php");
require_once("./class/distribuciofrecuencies.php");
gestio_projectesBBDD::setup();
$locals="";
if (isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}
if (isset($_GET['tipusdis'])){$tipodis=$_GET['tipusdis'];}
else{if(isset($_POST['tipusdis'])){$tipodis=$_POST['tipusdis'];}}
if (isset($_GET['dis'])){$dis=$_GET['dis'];}
else{if(isset($_POST['dis'])){$dis=$_POST['dis'];}}
if (isset($_GET['locals'])){$locals=$_GET['locals'];}
else{if(isset($_POST['locals'])){$locals=$_POST['locals'];}}
$projecte=$projh;
//echo "$locals,$tipodis,$dis,$projh,$projecte";

	if($locals!="" and $dis!="" and $tipodis!="")
		{ 
		$localitat=$locals;
		$aux=localitat::addlocalitatproject($localitat);
		
		
		if($dis==2)	
				{
				
				//Si existe la referencia para cada mes
				for ($i=1;$i<=12;$i++)
					{
					$vectorvaloresanualref=distribuciofrecuencies::obtenirnumdistribucioanualmes($i,$tipodis,$localitat);
					$numvectorvalanualref=count($vectorvaloresanualref)-1;
					$vectorvaloresanualproj=distribuciofrecuencies::obtenirnumdistribucioanualmesprojecte($i,$tipodis,$localitat,$projecte);
					$numvectorvalanualproj=count($vectorvaloresanualproj)-1;
					
					//comprobar que no existe el anual-projecto: se necesita projecto,mes,localitat,valor,iddis=1
					$vectorvaloresanualprojloc=distribuciofrecuencies::obtenirnumdistribucioanualmesprojecteloc($i,$tipodis,$localitat,$projecte);
					$numvectorvalanualprojloc=count($vectorvaloresanualprojloc)-1;	
						//if($numvectorvalanualref==0)
					//	{
						//Crear la mensual, para la id, localitat mes: sumar los valores para ese dia mes localidad, iddistribucio
						$summesref=distribuciofrecuencies::summensualref($tipodis,$localitat,$i);
						$auxinsert=distribuciofrecuencies::insertmensualref($tipodis,$localitat,$i,$summesref);
						$vectorvaloresanualref=distribuciofrecuencies::obtenirnumdistribucioanualmes($i,$tipodis,$localitat);
						$numvectorvalanualref=count($vectorvaloresanualref)-1;
					//echo "<br>$numvectorvalanualref,$numvectorvalanualproj,$numvectorvalanualprojloc,$numvectorvalanualref";					
					

					//	}
					if($numvectorvalanualref>0)
						{
						if($numvectorvalanualprojloc==0)
							{
							
								//Pasar los datos de la ref al anual para cada mes
								foreach ($vectorvaloresanualref as $ar)
								{
								$auxvalor=$ar["valor"];
								if($auxvalor!=""){
									if($numvectorvalanualproj==0){
										
										$sentencia = "insert into distribucions_anuals_projectes (idDistribucio_anual,mes,valor,localitat,projecte) VALUES (".$tipodis.",".$i.",".$auxvalor.",'".$localitat."','".$projecte."')";			
										}
										else{$sentencia="UPDATE distribucions_anuals_projectes SET valor=".$auxvalor.",localitat='".$localitat."' WHERE mes=".$i." and idDistribucio_anual=".$tipodis." and projecte='$projecte'";
											
										}
									//echo "<br>$sentencia";
									//$retval = mysqli_query(gestio_projectesBBDD::$dbconn, $sentencia);
									$resultado=mysqli_query(gestio_projectesBBDD::$dbconn, $sentencia);
									
									}
								}
							
								
							}
						
						//Para cada mes, hora
						}
						
					
					$x=1;
					for($j=0;$j<=23;$j++)
						{
						$vectorvaloresdiarioref=distribuciofrecuencies::obtenirdistribucioanualhora($j,$tipodis,$i,$localitat);
						$numvectorvaldiaref=count($vectorvaloresdiarioref)-1;

						
						
						if($numvectorvaldiaref>0)
							{
							$vectorvaloresdiaproj=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojecte($i,$j,$tipodis,$localitat,$projecte);
							$numvectorvaldiaproj=count($vectorvaloresdiaproj)-1;
							$vectorvaloresdiaprojloc=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojecteloc($i,$j,$tipodis,$localitat,$projecte);
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
											$sentencia = "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,valor,mes,localitat,projecte) VALUES (".$tipodis.",".$j.",".$auxvalor.",".$i.",'".$localitat."','".$projecte."')";
											}
										else
											{$sentencia="UPDATE distribucions_diaries_projectes SET valor=".$auxvalor.",localitat='".$localitat."' WHERE mes=".$i." and hora=".$j." and idDistribucio_diaria=".$tipodis." and projecte='".$projecte."'";
											}
										
										$resultado=mysqli_query(gestio_projectesBBDD::$dbconn, $sentencia);
										$x++;
										}
									}
								}
							}	
						}
					}
				}
	
		}
header("location: chooselocation.php?t=Location&projh=$projh");	 
//header("location:chooselocation.php?error");

?>
