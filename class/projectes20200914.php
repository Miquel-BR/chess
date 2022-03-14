<?php
require_once("gestio_projectesBBDD.php");

class projectes {
	
public static function add($loc,$long,$lat)
	{
	}
public static function addprojecte($proj,$usuario,$IDsession)
	{
	$_SESSION['projecte']=$proj;				
	$i=0;
	$query="select count(*) as num from projects where nomproject='$proj' and usuari!='$usuario'";
	$resultado=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
	while ($row[$i] = mysqli_fetch_assoc($resultado)) { $i++; }
	mysqli_free_result($resultado);
	
	if($row[0]['num']==0)
	{
	$query = "INSERT INTO projects (nomproject,usuari,IDsession) VALUES ('$proj','$usuario',$IDsession)";
	
	$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
	$query="UPDATE projects SET actual=0";
	$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
	$query="UPDATE projects SET actual=1 WHERE nomproject='$proj'"; 
	$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
	
	//$query="UPDATE projects SET usuari='".$usuario."' WHERE nomproject='$proj'";
	return 1;
	//$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
	}
	else {return 0;}
	
	}

public static function addpressupost($proj,$invest,$manteniment,$ratioSP,$ratioSTO,$ratioHP,$ratioDTU,$ratioDS,$ratioGB)
	{
	$_SESSION['projecte']=$proj;				
	$i=0;
	$query="select count(*) as num from economicdata where projecte='$proj'";
	$resultado=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
	while ($row[$i] = mysqli_fetch_assoc($resultado)) { $i++; }
	mysqli_free_result($resultado);
	
	if($row[0]['num']==0)
	{
	$query = "INSERT INTO economicdata (projecte,invest,mantenance,solarpanelrat,storagerat,heatpumprat,directusetankrat,distributionrat,gasboilerrat) VALUES ('$proj',$invest,$manteniment,$ratioSP,$ratioSTO,$ratioHP,$ratioDTU,$ratioDS,$ratioGB)";
	
	}
	else
	{
	
	$query="UPDATE economicdata SET invest='$invest',mantenance='$manteniment',solarpanelrat=$ratioSP,storagerat=$ratioSTO,heatpumprat=$ratioHP,directusetankrat=$ratioDTU,distributionrat=$ratioDS,gasboilerrat=$ratioGB where projecte='$proj'";
	
	}
	$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
	//$query="UPDATE projects SET usuari='".$usuario."' WHERE nomproject='$proj'";
	return 1;
	//$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
	
	
	}


public static function eliminaranteriores($user,$IDsession)
	{
	//Con el ID de la sessión quitarle un dia, considerar que para cambios de mes, primer día, no pasa a 0 sino a 30 o 31
	//Hemos hecho el ID session con time() ahora le restaremos un día
	
	$fecha = date('Y-m-j H:i:s',$IDsession);
	$nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
	//$nuevafecha = strtotime ( '-1 minute' , strtotime ( $fecha ) ) ;
 
	//echo "$nuevafecha,$IDsession";
	//Buscar todos los proyectos con IDsesion <nueva fecha. BUscar los nombres. 
	$query = "select nomproject,IDsession from projects where usuari='demo'";
	
	$i=0;
	$resultado=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
	while ($row[$i] = mysqli_fetch_assoc($resultado)) { $i++; }
	mysqli_free_result($resultado);
	for ($j=0;$j<=$i;$j++)
		{
		if(date($row[$j]['IDsession'])<date($nuevafecha))
		{
		
		
		$nomarxiu=$row[$j]['nomproject'];
		//Borrarlos
		
		$query ="delete from projects where usuari='demo' and nomproject='$nomarxiu'";
		
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		//Para cada nombre buscar el archivo y borrarlo
		
		
			//Borrar las otras tablas
			$nomarxiu=$row[$j]['nomproject'];
			$query ="delete from distribucions_anuals_projecte where project='$nomarxiu'";
			$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
			$query ="delete from distribucions_diaries_projecte where project='$nomarxiu'";
			$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
			$query ="delete from subsistemes_aux_energy_sources where project='$nomarxiu'";
			$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
			$query ="delete from subsistemes_direct_use_tank where project='$nomarxiu'";
			$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
			$query ="delete from subsistemes_heat_pump where project='$nomarxiu'";
			$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
			$query ="delete from subsistemes_seasonal_storage_system where project='$nomarxiu'";
			$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
			$query ="delete from subsistemes_solar where project='$nomarxiu'";
			$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);	
			$query ="delete from subsistemes_distribution_system where project='$nomarxiu'";
			$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
			//Borrar archivos
			$nomarxiu=$nomarxiu.".txt";
			
			if (file_exists($nomarxiu))
			 {unlink($nomarxiu);}
			
		 }
	}
	}

public static function getprojectes($usuario)
	{
	$i=0;
	$query = "select * from projects where usuari='$usuario'";
	$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
	while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
	mysqli_free_result($result);
	return $row;

	}

public static function getprojecteactual()
	{
	$i=0;
	$query = "select nomproject,localitat,nomdemanda from projects where actual=1";
	$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
	while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
	mysqli_free_result($result);
	return $row[0];

	}

public static function getprojecteactualdades($projecte)
	{
	$i=0;
	$query = "select nomproject,localitat,nomdemanda from projects where nomproject='$projecte'";
	$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
	while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
	mysqli_free_result($result);
	return $row[0];

	}

public static function getlatitut($proj,$usuario)
	{
	//esta función debe ir antes de addprojecte 
	$i=0;
	$query="select count(*) as num from projects where nomproject='$proj' and usuari!='$usuario'";
	$resultado=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
	while ($row[$i] = mysqli_fetch_assoc($resultado)) { $i++; }
	mysqli_free_result($resultado);
	if($row[0]['num']>0)
		{
		$j=0;
		$query="select latitut from projects,localitzacions where localitat=nom_localitzacio and nomproject='$proj' and usuari!='$usuario'";
		$resultado2=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$j] = mysqli_fetch_assoc($resultado)) { $j++; }
		mysqli_free_result($resultado);
		return $row[0]['latitut'];

		}
	else
		{return "";}
	
	}

public static function getlong($proj,$usuario)
	{
		//esta función debe ir antes de addprojecte 
	$i=0;
	$query="select count(*) as num from projects where nomproject='$proj' and usuari!='$usuario'";
	$resultado=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
	while ($row[$i] = mysqli_fetch_assoc($resultado)) { $i++; }
	mysqli_free_result($resultado);
	if($row[0]['num']>0)
		{
		$j=0;
		$query="select longitut from projects,localitzacions where localitat=nom_localitzacio and nomproject='$proj' and usuari!='$usuario'";
		$resultado2=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$j] = mysqli_fetch_assoc($resultado)) { $j++; }
		mysqli_free_result($resultado);
		return $row[0]['latitut'];

		}
	else
		{return "";}	

	}

}

?>
