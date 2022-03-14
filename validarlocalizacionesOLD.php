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
session_start();
//echo "var".$_SESSION['locali'].",".$_POST['locals'].",".$_POST['eleccio'];
$_SESSION['locali']="Sin localizacion";
$aux=projectes::getprojecteactual();
$projecte=$aux['nomproject'];
$sentencia="";
if (isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}}
		
if(isset($_POST['locals']))
	{
	
	if($_POST['locals']!="")
		{ 
		$_SESSION['locali']=$_POST['locals'];
		$localitat=$_POST['locals'];
		$aux=localitat::addlocalitatproject($localitat);
		if(isset($_POST['radiation']))
			{
			header("location:gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=1&projh=$projh&locals=$localitat");
			}	
		if(isset($_POST['airtemp']))
			{
			header("location:gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=2&projh=$projh&locals=$localitat");
			}	
		if(isset($_POST['airground']))
			{
			header("location:gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=3&projh=$projh&locals=$localitat");
			}
		if(isset($_POST['irradiation']))
			{
			header("location:gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=8&projh=$projh&locals=$localitat");
			}
		if(isset($_POST['submit']))
			{
			
			
			if($_POST['dis1']==2)
				{
				
				//Si existe la referencia para cada mes
				for ($i=1;$i<=12;$i++)
					{
					$vectorvaloresanualref=distribuciofrecuencies::obtenirnumdistribucioanualmes($i,1,$localitat);
					$numvectorvalanualref=count($vectorvaloresanualref)-1;
					$vectorvaloresanualproj=distribuciofrecuencies::obtenirnumdistribucioanualmesprojecte($i,1,$localitat,$projecte);
					$numvectorvalanualproj=count($vectorvaloresanualproj)-1;
					
					//comprobar que no existe el anual-projecto: se necesita projecto,mes,localitat,valor,iddis=1
					$vectorvaloresanualprojloc=distribuciofrecuencies::obtenirnumdistribucioanualmesprojecteloc($i,1,$localitat,$projecte);
					$numvectorvalanualprojloc=count($vectorvaloresanualprojloc)-1;				
					//if($numvectorvalanualref==0)
					//	{
						//Crear la mensual, para la id, localitat mes: sumar los valores para ese dia mes localidad, iddistribucio
						$summesref=distribuciofrecuencies::summensualref(1,$localitat,$i);
						$auxinsert=distribuciofrecuencies::insertmensualref(1,$localitat,$i,$summesref);
						$vectorvaloresanualref=distribuciofrecuencies::obtenirnumdistribucioanualmes($i,1,$localitat);
						$numvectorvalanualref=count($vectorvaloresanualref)-1;

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
										
										$sentencia = "insert into distribucions_anuals_projectes (idDistribucio_anual,mes,valor,localitat,projecte) VALUES (1,".$i.",".$auxvalor.",'".$_SESSION['locali']."','".$projecte."')";			
										}
										else{$sentencia="UPDATE distribucions_anuals_projectes SET valor=".$auxvalor.",localitat='".$localitat."' WHERE mes=".$i." and idDistribucio_anual=1 and projecte='$projecte'";
											
										}
									
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
						$vectorvaloresdiarioref=distribuciofrecuencies::obtenirdistribucioanualhora($j,1,$i,$localitat);
						$numvectorvaldiaref=count($vectorvaloresdiarioref)-1;

						
						
						if($numvectorvaldiaref>0)
							{
							$vectorvaloresdiaproj=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojecte($i,$j,1,$localitat,$projecte);
							$numvectorvaldiaproj=count($vectorvaloresdiaproj)-1;
							$vectorvaloresdiaprojloc=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojecteloc($i,$j,1,$localitat,$projecte);
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
											$sentencia = "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,valor,mes,localitat,projecte) VALUES (1,".$j.",".$auxvalor.",".$i.",'".$localitat."','".$projecte."')";
											}
										else
											{$sentencia="UPDATE distribucions_diaries_projectes SET valor=".$auxvalor.",localitat='".$localitat."' WHERE mes=".$i." and hora=".$j." and idDistribucio_diaria=1 and projecte='".$projecte."'";
											}
										
										$resultado=mysqli_query(gestio_projectesBBDD::$dbconn, $sentencia);
										$x++;
										}
									}
								}
							}	
						}
					}
					/*
					?>
<script type="text/javascript">
//alert('<?php echo $_POST['dis1'];?>');
alert('Hecho dis1');
</script>
<?php
*/
				}
			
			if($_POST['dis2']==2)
				{
				for ($i=1;$i<=12;$i++)
					{
					//Para iddis=1 tomas datos de la ref datos anuales projecto
					$vectorvaloresanualref=distribuciofrecuencies::obtenirnumdistribucioanualmes($i,2,$localitat);
					$numvectorvalanualref=count($vectorvaloresanualref)-1;
					$vectorvaloresanualproj=distribuciofrecuencies::obtenirnumdistribucioanualmesprojecte($i,2,$localitat,$projecte);
					$numvectorvalanualproj=count($vectorvaloresanualproj)-1;
					
					//comprobar que no existe el anual-projecto: se necesita projecto,mes,localitat,valor,iddis=1
					$vectorvaloresanualprojloc=distribuciofrecuencies::obtenirnumdistribucioanualmesprojecteloc($i,2,$localitat,$projecte);
					$numvectorvalanualprojloc=count($vectorvaloresanualprojloc)-1;
					
					if($numvectorvalanualref==0)
						{
						//Crear la mensual, para la id, localitat mes: sumar los valores para ese dia mes localidad, iddistribucio
						//$summesref=distribuciofrecuencies::summensualref(2,$localitat,$i);
						$summesref=distribuciofrecuencies::medmensualref(2,$localitat,$i);
						$auxinsert=distribuciofrecuencies::insertmensualref(2,$localitat,$i,$summesref);
						$vectorvaloresanualref=distribuciofrecuencies::obtenirnumdistribucioanualmes($i,2,$localitat);
						
						}
						
						
						
						if($numvectorvalanualprojloc==0)
							{
							
								//Pasar los datos de la ref al anual para cada mes
								foreach ($vectorvaloresanualref as $ar)
								{
								$auxvalor=$ar["valor"];
								if($auxvalor!=""){
									if($numvectorvalanualproj==0){
										$sentencia = "insert into distribucions_anuals_projectes (idDistribucio_anual,mes,valor,localitat,projecte) VALUES (2,".$i.",".$auxvalor.",'".$_SESSION['locali']."','".$projecte."')";			
										}
									else{$sentencia="UPDATE distribucions_anuals_projectes SET valor=".$auxvalor.",localitat='".$localitat."' WHERE mes=".$i." and idDistribucio_anual=2 and projecte='$projecte'";
										}
									//$retval = mysqli_query(gestio_projectesBBDD::$dbconn, $sentencia);
									$resultado=mysqli_query(gestio_projectesBBDD::$dbconn, $sentencia);
									
									}
								}
							
								
							}
						
						//Para cada mes, hora
					
					$x=1;
					for($j=0;$j<=23;$j++)
						{
						$vectorvaloresdiarioref=distribuciofrecuencies::obtenirdistribucioanualhora($j,2,$i,$localitat);
						$numvectorvaldiaref=count($vectorvaloresdiarioref);
						
						if($numvectorvaldiaref>0)
							{
							$vectorvaloresdiaproj=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojecte($i,$j,2,$localitat,$projecte);
							$numvectorvaldiaproj=count($vectorvaloresdiaproj)-1;
							$vectorvaloresdiaprojloc=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojecteloc($i,$j,2,$localitat,$projecte);
							$numvectorvaldiaprojloc=count($vectorvaloresdiaprojloc)-1;
							//echo "num2:$numvectorvaldiaref,$numvectorvaldiaprojloc,$i,$j,2,$localitat,$projecte,<br>";
							//print_r($vectorvaloresdiaprojloc);
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
											$sentencia = "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,valor,mes,localitat,projecte) VALUES (2,".$j.",".$auxvalor.",".$i.",'".$localitat."','".$projecte."')";
											}
										else
											{$sentencia="UPDATE distribucions_diaries_projectes SET valor=".$auxvalor.",localitat='".$localitat."' WHERE mes=".$i." and hora=".$j." and idDistribucio_diaria=2 and projecte='".$projecte."'";
											}
										//echo "sent:$sentencia";
										$resultado=mysqli_query(gestio_projectesBBDD::$dbconn, $sentencia);
										$x++;
										}
									}
								}
							}	
						}
					}
	
				}
				
			
			if($_POST['dis3']==2)
				{
				for ($i=1;$i<=12;$i++)
					{
					//Para iddis=1 tomas datos de la ref datos anuales projecto
					$vectorvaloresanualref=distribuciofrecuencies::obtenirnumdistribucioanualmes($i,3,$localitat);
					$numvectorvalanualref=count($vectorvaloresanualref)-1;
											$vectorvaloresanualproj=distribuciofrecuencies::obtenirnumdistribucioanualmesprojecte($i,3,$localitat,$projecte);
						$numvectorvalanualproj=count($vectorvaloresanualproj)-1;
						//comprobar que no existe el anual-projecto: se necesita projecto,mes,localitat,valor,iddis=1
						$vectorvaloresanualprojloc=distribuciofrecuencies::obtenirnumdistribucioanualmesprojecteloc($i,3,$localitat,$projecte);
						$numvectorvalanualprojloc=count($vectorvaloresanualprojloc)-1;

					if($numvectorvalanualref==0)
						{
						//Crear la mensual, para la id, localitat mes: sumar los valores para ese dia mes localidad, iddistribucio
						//$summesref=distribuciofrecuencies::summensualref(3,$localitat,$i);
						$summesref=distribuciofrecuencies::medmensualref(3,$localitat,$i);
						$auxinsert=distribuciofrecuencies::insertmensualref(3,$localitat,$i,$summesref);
						$vectorvaloresanualref=distribuciofrecuencies::obtenirnumdistribucioanualmes($i,3,$localitat);

						}
						
						
						if($numvectorvalanualprojloc==0)
							{
							
								//Pasar los datos de la ref al anual para cada mes
								foreach ($vectorvaloresanualref as $ar)
								{
								$auxvalor=$ar["valor"];
								if($auxvalor!=""){
									if($numvectorvalanualproj==0){
										$sentencia = "insert into distribucions_anuals_projectes (idDistribucio_anual,mes,valor,localitat,projecte) VALUES (3,".$i.",".$auxvalor.",'".$_SESSION['locali']."','".$projecte."')";			
										}
									else{$sentencia="UPDATE distribucions_anuals_projectes SET valor=".$auxvalor.",localitat='".$localitat."' WHERE mes=".$i." and idDistribucio_anual=3 and projecte='$projecte'";
										}
									//$retval = mysqli_query(gestio_projectesBBDD::$dbconn, $sentencia);
									$resultado=mysqli_query(gestio_projectesBBDD::$dbconn, $sentencia);
									
									}
								}
							
								
							}
						
						//Para cada mes, hora
						
					$x=1;
					for($j=0;$j<=23;$j++)
						{
						$vectorvaloresdiarioref=distribuciofrecuencies::obtenirdistribucioanualhora($j,3,$i,$localitat);
						$numvectorvaldiaref=count($vectorvaloresdiarioref)-1;
						if($numvectorvaldiaref>0)
							{
							$vectorvaloresdiaproj=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojecte($i,$j,3,$localitat,$projecte);
							$numvectorvaldiaproj=count($vectorvaloresdiaproj)-1;
							$vectorvaloresdiaprojloc=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojecteloc($i,$j,3,$localitat,$projecte);
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
											$sentencia = "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,valor,mes,localitat,projecte) VALUES (3,".$j.",".$auxvalor.",".$i.",'".$localitat."','".$projecte."')";
											}
										else
											{$sentencia="UPDATE distribucions_diaries_projectes SET valor=".$auxvalor.",localitat='".$localitat."' WHERE mes=".$i." and hora=".$j." and idDistribucio_diaria=3 and projecte='".$projecte."'";
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
			
			
			if($_POST['dis8']==2)
				{
				for ($i=1;$i<=12;$i++)
					{
					//Para iddis=1 tomas datos de la ref datos anuales projecto
					$vectorvaloresanualref=distribuciofrecuencies::obtenirnumdistribucioanualmes($i,8,$localitat);
					$numvectorvalanualref=count($vectorvaloresanualref)-1;
					$vectorvaloresanualproj=distribuciofrecuencies::obtenirnumdistribucioanualmesprojecte($i,8,$localitat,$projecte);
					$numvectorvalanualproj=count($vectorvaloresanualproj)-1;
					//comprobar que no existe el anual-projecto: se necesita projecto,mes,localitat,valor,iddis=1
					$vectorvaloresanualprojloc=distribuciofrecuencies::obtenirnumdistribucioanualmesprojecteloc($i,8,$localitat,$projecte);
					$numvectorvalanualprojloc=count($vectorvaloresanualprojloc)-1;

					if($numvectorvalanualref==0)
						{
						//Crear la mensual, para la id, localitat mes: sumar los valores para ese dia mes localidad, iddistribucio
						//$summesref=distribuciofrecuencies::summensualref(8,$localitat,$i);
						$summesref=distribuciofrecuencies::medmensualref(8,$localitat,$i);
						$auxinsert=distribuciofrecuencies::insertmensualref(8,$localitat,$i,$summesref);
						$vectorvaloresanualref=distribuciofrecuencies::obtenirnumdistribucioanualmes($i,8,$localitat);

						}						
						
						
						if($numvectorvalanualprojloc==0)
							{
							
								//Pasar los datos de la ref al anual para cada mes
								foreach ($vectorvaloresanualref as $ar)
								{
								$auxvalor=$ar["valor"];
								if($auxvalor!=""){
									if($numvectorvalanualproj==0){
										$sentencia = "insert into distribucions_anuals_projectes (idDistribucio_anual,mes,valor,localitat,projecte) VALUES (8,".$i.",".$auxvalor.",'".$_SESSION['locali']."','".$projecte."')";			
										}
									else{$sentencia="UPDATE distribucions_anuals_projectes SET valor=".$auxvalor.",localitat='".$localitat."' WHERE mes=".$i." and idDistribucio_anual=8 and projecte='$projecte'";
										}
									//$retval = mysqli_query(gestio_projectesBBDD::$dbconn, $sentencia);
									$resultado=mysqli_query(gestio_projectesBBDD::$dbconn, $sentencia);
									
									}
								}
							
								
							}
						
						//Para cada mes, hora
						
					$x=1;
					for($j=0;$j<=23;$j++)
						{
						$vectorvaloresdiarioref=distribuciofrecuencies::obtenirdistribucioanualhora($j,8,$i,$localitat);
						$numvectorvaldiaref=count($vectorvaloresdiarioref)-1;
						if($numvectorvaldiaref>0)
							{
							$vectorvaloresdiaproj=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojecte($i,$j,8,$localitat,$projecte);
							$numvectorvaldiaproj=count($vectorvaloresdiaproj)-1;
							$vectorvaloresdiaprojloc=distribuciofrecuencies::obtenirnumdistribuciodiariameshoraprojecteloc($i,$j,8,$localitat,$projecte);
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
											$sentencia = "insert into distribucions_diaries_projectes (idDistribucio_diaria,hora,valor,mes,localitat,projecte) VALUES (8,".$j.",".$auxvalor.",".$i.",'".$localitat."','".$projecte."')";
											}
										else
											{$sentencia="UPDATE distribucions_diaries_projectes SET valor=".$auxvalor.",localitat='".$localitat."' WHERE mes=".$i." and hora=".$j." and idDistribucio_diaria=8 and projecte='".$projecte."'";
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
			
			header("location: choosedemand.php?t=Energy Demand&projh=$projh");
			//header("location: chess-setup-similator.net/chooselocation.php?t=Inici&projh=$proj");
			//<meta http-equiv="refresh" content="0; url=http://www.aredireccionar.com"> 
			/*
			?>
			<script type="text/javascript">
			alert('Debería ir el header!');
			</script>
			<?php
			*/
			}
			
		}
	else {
		header("location:chooselocation.php?t=Location&projh=$projh");
		/*
		?>
		<script type="text/javascript">
		alert('2!');
		</script>
		<?php
		*/
		}
	}
else {
	 
	header("location:chooselocation.php?error");
	/*
	?>
		<script type="text/javascript">
		alert('3!');
		</script>
		<?php
	*/
	}
//echo "var".$localitat.",".$_POST['locals'].",".$sentencia;
?>
