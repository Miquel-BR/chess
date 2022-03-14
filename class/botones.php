<?php
require_once("gestio_projectesBBDD.php");

class botones {
	
public static function add($loc,$long,$lat)
	{
	}
public static function checkanualdisloc($tipusdis,$location,$projecte)
	{
					
	$i=0;
	$query="SELECT count(*) as count FROM distribucions_anuals_projectes WHERE idDistribucio_anual='$tipusdis' and projecte='$projecte' and localitat='$location'";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;

	}

public static function getanualdisloc($tipusdis,$location,$projecte){
//if($tipusdis==1 || $tipusdis==2 || $tipusdis==3){
//	$query="SELECT localitat,count(*) FROM distribucions_anuals_projectes,localitzacions WHERE nom_localitzacio=localitat and idDistribucio_anual=$tipusdis and projecte='$projecte' group by localitat";
//}
//if($tipusdis==4 || $tipusdis==5 || $tipusdis==6 || $tipusdis==7){
	$query="SELECT localitat,count(*) as num FROM distribucions_anuals_projectes,localitzacions WHERE nom_localitzacio=localitat and idDistribucio_anual=$tipusdis and projecte='$projecte' and nom_localitzacio='$location'";
//	}
$i=1;
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;

}

public static function getanualdislocref($tipusdis,$location){
//if($tipusdis==1 || $tipusdis==2 || $tipusdis==3){
//	$query="SELECT localitat,count(*) FROM distribucions_anuals_projectes,localitzacions WHERE nom_localitzacio=localitat and idDistribucio_anual=$tipusdis and projecte='$projecte' group by localitat";
//}
//if($tipusdis==4 || $tipusdis==5 || $tipusdis==6 || $tipusdis==7){
	$query="SELECT localitat,count(*) as num FROM distribucions_anuals,localitzacions WHERE nom_localitzacio=localitat and idDistribucio_anual=$tipusdis and nom_localitzacio='$location'";
//	}
$i=1;
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;

}

public static function getanualdisdemand($tipusdis,$demand,$projecte){
	$query="SELECT nom_demand,count(*) as num FROM distribucions_anuals_projectes,demandas WHERE nom_demand=demand and idDistribucio_anual=$tipusdis and projecte='$projecte' and nom_demand='$demand' group by demand";
	$i=1;
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;
}

public static function getanualdisdemandref($tipusdis,$demand){
	//$query="SELECT nom_demand,count(*) as num FROM distribucions_anuals,demandas WHERE nom_demand=demand and idDistribucio_anual=$tipusdis and nom_demand='$demand' group by demand";
	$query="SELECT count(*) as num FROM distribucions_anuals WHERE idDistribucio_anual=$tipusdis and demand='$demand' group by demand";

	$i=1;
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;
}


public static function checkmesdisloc($tipusdis,$location,$mes,$projecte)
	{
	
	$i=0;
	$query="SELECT count(*) as count FROM distribucions_diaries_projectes WHERE idDistribucio_diaria='$tipusdis' and projecte='$projecte' and localitat='$location' and mes='$mes'";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;

	}
	
public static function getmesdisloc($tipusdis,$location,$mes,$projecte){
	$query="SELECT localitat,count(*) as num FROM distribucions_diaries_projectes,localitzacions WHERE nom_localitzacio=localitat and idDistribucio_diaria=$tipusdis and projecte='$projecte' and mes=$mes group by localitat";

$i=1;
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;
//devuelve el nombre de localitat y el numero de registros para un mes, debería ser de 24
}

public static function getmesdislocref($tipusdis,$location,$mes){
	$query="SELECT localitat,count(*) as num FROM distribucions_diaries,localitzacions WHERE nom_localitzacio=localitat and idDistribucio_diaria=$tipusdis and mes=$mes and localitat='".$location."'";

	$i=1;
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;
//devuelve el nombre de localitat y el numero de registros para un mes, debería ser de 24
}

public static function getmesdisdemand($tipusdis,$demand,$mes,$projecte){
	$query="SELECT demand,count(*) as num FROM distribucions_diaries_projectes,demandas WHERE nom_demand=demand and idDistribucio_diaria='$tipusdis' and projecte='$projecte' and mes='$mes' group by demand";	
	$i=1;
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;
	//devuelve el nombre de localitat y el numero de registros para un mes, debería ser de 24
}

public static function getmesdisdemandref($tipusdis,$demand,$mes){
	$query="SELECT count(*) as num FROM distribucions_diaries WHERE  idDistribucio_diaria=$tipusdis and mes=$mes and demand='".$demand."'";	
	$i=1;
	
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;
//devuelve el nombre de localitat y el numero de registros para un mes, debería ser de 24
}

public static function checkanualdisdemand($tipusdis,$demanda,$projecte)
	{
	
	$i=0;
	$query="SELECT count(*) as count FROM distribucions_anuals_projectes WHERE idDistribucio_anual='$tipusdis' and projecte='$projecte' and demand='$demanda'";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;

	}

public static function checkmesdisdemand($tipusdis,$demanda,$mes,$projecte)
	{
	$i=0;
	$query="SELECT count(*) as count FROM distribucions_diaries_projectes WHERE idDistribucio_diaria='$tipusdis' and projecte='$projecte' and demand='$demanda' and mes='$mes'";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;
	}

public static function colorbotonsubsistemes($tiposubsistema,$projecte)
	{
	$i=0;
	if($tiposubsistema==1){$query="select count(*) as num from subsistemes_solar where projecte='$projecte'";}
	if($tiposubsistema==2){$query="select count(*) as num from subsistemes_seasonal_storage_system where projecte='$projecte'";}
	if($tiposubsistema==3){$query="select count(*) as num from subsistemes_heat_pump where projecte='$projecte'";}
	if($tiposubsistema==4){$query="select count(*) as num from subsistemes_direct_use_tank where projecte='$projecte'";}
	if($tiposubsistema==5){$query="select count(*) as num from subsistemes_distribution_system where projecte='$projecte'";}
	if($tiposubsistema==6){$query="select count(*) as num from subsistemes_aux_energy_sources where projecte='$projecte'";}
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;
	}

}

?>