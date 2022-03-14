<?php

require_once("gestio_projectesBBDD.php");

class components {

public static function getpanellsolars()
	{
	$i=0;
	$query="select * from panells_solars";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
		
	return $row;
	}
	
public static function getallheatpumps()
	{
	$i=0;
	$query="select * from lib_subsistemes_heat_pump";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
		
	return $row;
	}

public static function getpanellsolarprojecte($projecte)
	{
	$i=0;
	$query="select * from subsistemes_solar where projecte='$projecte'";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
		
	return $row;
	
	}

public static function addsistemasolar($sistema,$solarpanel,$inclinacion,$azimut,$superficiesolar)
	{
			$i=0;
			$query="select * from subsistemes_solar where sistema='$sistema'";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
			mysql_free_result($result);
			$num=count($row)-1;
			if($num==0){
			$query="insert into subsistemes_solar (sistema,nom_panell,inclinacio,azimut,superficie_solar) VALUES ('$sistema','$solarpanel','$inclinacion','$azimut','$superficiesolar')";
			}
			else
				{$query="UPDATE subsistemes_solar SET nom_panell='$solarpanel',inclinacio='$inclinacion',azimut='$azimut',superficie_solar='$superficiesolar' WHERE sistema='$sistema'";

				}
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			//mysql_free_result($result);
			

	}

public static function addpanelsolar($projecte,$paneltype,$inclinacio,$azimuth,$solarsurface,$stp_b,$stp_a1,$stp_a2,$temp_summer,$temp_rest,$temp_winter,$efficiency)
	{
		
			$i=0;
			$query= "select * from subsistemes_solar where projecte='$projecte'";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			while ($row[$i] = mysql_fetch_assoc($result)) 
				{ $i++; }
			mysql_free_result($result);
			$num=count($row)-1;
			if($num==0){
			$query="insert into subsistemes_solar (projecte,nom_panell,inclinacio,azimut,superficie_solar,stp_b,stp_a1,stp_a2,temp_summer,temp_rest,temp_winter,efficiency) VALUES ('$projecte','$paneltype','$inclinacio','$azimuth','$solarsurface',$stp_b,$stp_a1,$stp_a2,$temp_summer,$temp_rest,$temp_winter,$efficiency)";
			}
			else
				{$query="UPDATE subsistemes_solar SET nom_panell='$paneltype',inclinacio='$inclinacio',azimut='$azimuth',superficie_solar='$solarsurface',stp_b=$stp_b,stp_a1=$stp_a1,stp_a2=$stp_a2,temp_summer='$temp_summer',temp_rest='$temp_rest',temp_winter='$temp_winter',efficiency='$efficiency' WHERE projecte='$projecte'";

				}
			//echo "$query";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			//mysql_free_result($result);
			

	}


public static function getsistemasolar($sistema)
	{
	$i=0;
	$query="select * from subsistemes_solar where sistema='$sistema'";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
		
	return $row;
	}


public static function getcoppos($pos,$model)
	{
	$i=0;
	$query="SELECT * FROM cops WHERE model='$model' and numordre=$pos order by numordre";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
		
	return $row;

	}

public static function getcop($model)
	{
	$i=0;
	$query="SELECT * FROM cops WHERE model='$model' order by numordre";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
		
	return $row;

	}

public static function getallcop()
	{
	$i=0;
	$query="SELECT model,numordre,COP,tf,tc FROM cops order by model,numordre";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
		
	return $row;

	}

public static function addcop($model,$numordre,$tf,$tc,$cop)
	{
	if($model==""){$model="Sin Modelo";}
	if($model!="Sin Modelo")
		{
		$query="UPDATE cops SET model='$model' where model='Sin Modelo'";
		$result1=mysql_query($query,gestio_projectesBBDD::$dbconn);
		}
	$query="INSERT INTO cops (model,numordre,tf,tc,COP) VALUES ('$model',$numordre,$tf,$tc,$cop)";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	}

public static function getstoragematerials($tipo)
	{
	$i=0;
	if($tipo==1){$aux=" where depositouso=1 or depositouso=2";}
	if($tipo==2){$aux=" where depositouso=1 or depositouso=3";}

	$query="SELECT * FROM storage_material".$aux;
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
		
	return $row;

	}

//public static function addauxiliaryenergysource($projecte,$tiposourcestoragesystem,$powerstoragesystem,$tempstoragesystem,$operationstoragesystem,$tiposourcedirectusetank,$powerdirectusetank,$tempdirectusetank,$operationdirectusetank)
public static function addauxiliaryenergysource($projecte,$tiposourcestoragesystem,$powerstoragesystem,$tiposourcedirectusetank,$powerdirectusetank)
	{
	$query="select * from subsistemes_aux_energy_sources where projecte='$projecte'";
	$i=0;
	
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	$num=count($row)-1;
	if($num==0){$query="insert into subsistemes_aux_energy_sources (projecte,tipo_source_storage_system,power_storage_system,tipo_source_direct_use_tank,power_direct_use_tank) VALUES ('$projecte','$tiposourcestoragesystem','$powerstoragesystem','$tiposourcedirectusetank','$powerdirectusetank')";}
	else {$query="UPDATE subsistemes_aux_energy_sources SET tipo_source_storage_system='$tiposourcestoragesystem',power_storage_system='$powerstoragesystem',tipo_source_direct_use_tank='$tiposourcedirectusetank',power_direct_use_tank='$powerdirectusetank' WHERE projecte='$projecte'";}
		
	$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
	//mysql_free_result($result);

	}
	
public static function adddistributionsystem($projecte,$length1,$diameter1,$isolation1,$heattrasnfer1,$length2,$diameter2,$isolation2,$heattrasnfer2)
	{
	$query="select * from subsistemes_distribution_system where projecte='$projecte'";
	$i=0;
	
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	$num=count($row)-1;
	//echo "$num,$projecte,$length1,$diameter1,$isolation1,$heattrasnfer1,$length2,$diameter2,$isolation2,$heattrasnfer2";
	if($num==0){$query="insert into subsistemes_distribution_system (projecte,long1,diametro1,aislamiento1,transferenciacalor1,long2,diametro2,aislamiento2,transferenciacalor2) VALUES ('$projecte','$length1','$diameter1','$isolation1','$heattrasnfer1','$length2','$diameter2','$isolation2','$heattrasnfer2')";}
	else {$query="UPDATE subsistemes_distribution_system SET long1='$length1',diametro1='$diameter1',aislamiento1='$isolation1',transferenciacalor1='$heattrasnfer1',long2='$length2',diametro2='$diameter2',aislamiento2='$isolation2',transferenciacalor2='$heattrasnfer2' WHERE projecte='$projecte'";}
	//echo "<br>$query";	
	$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
	//mysql_free_result($result);

	}
	
public static function getdadesdistributionsystem($projecte)
	{
		$i=0;
		$query="SELECT * FROM subsistemes_distribution_system where projecte='$projecte'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
		
		return $row;
	}
	
public static function addheatpump($projecte,$sendmodel,$sendpower,$sendoutputtemp,$sendcarnot,$sendTminCOP,$sendMinCOP,$sendTmidCOP,$sendMidCOP,$sendTmaxCOP,$sendMaxCOP,$sendbottonCOP)
	{
			$query="select * from subsistemes_heat_pump where projecte='$projecte'";
			$i=0;
	
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
			mysql_free_result($result);
			$num=count($row)-1;
			if($num==0){$query="insert into subsistemes_heat_pump (projecte,model,power,output_temp,carnot_efficiency,TCOPmin,COPmin,TCOPmid,COPmid,TCOPmax,COPmax,bottonCOP) VALUES ('$projecte','$sendmodel',$sendpower,$sendoutputtemp,$sendcarnot,$sendTminCOP,$sendMinCOP,$sendTmidCOP,$sendMidCOP,$sendTmaxCOP,$sendMaxCOP,$sendbottonCOP)";}
				else {$query="UPDATE subsistemes_heat_pump SET model='$sendmodel',power=$sendpower,output_temp=$sendoutputtemp,carnot_efficiency=$sendcarnot,TCOPmin=$sendTminCOP,COPmin=$sendMinCOP,TCOPmax=$sendTmaxCOP,COPmax=$sendMaxCOP,TCOPmid=$sendTmidCOP,COPmid=$sendMidCOP,bottonCOP=$sendbottonCOP WHERE projecte='$projecte'";}
			
			$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
	}
	
public static function getdadesheatpump($projecte)
	{
			$i=0;
			$query="SELECT * FROM subsistemes_heat_pump where projecte='$projecte'";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
			mysql_free_result($result);
		
			return $row;
	}
	
public static function getstoragesystem($tipo)
		{
		
			
		if($tipo==1){$aux=" where depositouso=1 or depositouso=2";}
		if($tipo==2){$aux=" where depositouso=1 or depositouso=3";}
		$i=0;
		$query="SELECT * FROM storage_systems".$aux;
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
		
		return $row;
		}

public static function getlocationstorage()
		{
		$i=0;
		$query="SELECT * FROM locations_storage";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
		
		return $row;
		}
public static function getauxiliarysourceproject($projecte)
			{
			$i=0;
			$query="SELECT * FROM subsistemes_aux_energy_sources where projecte='$projecte'";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
			mysql_free_result($result);
		
			return $row;
			}
			
public static function getenergycost($projecte)
{
	$i=0;
			$query="SELECT * FROM energy_cost where projecto='$projecte'";
			
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
			mysql_free_result($result);
			
			return $row;
}

public static function geteconomicdata($projecte)
	{
	$i=0;
			$query="SELECT * FROM economicdata where projecte='$projecte'";
			
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
			mysql_free_result($result);
			
			return $row;
	}
public static function getdadesseasonalstoragesystem($projecte)			
			{
			$i=0;
			$query="SELECT * FROM subsistemes_seasonal_storage_system where projecte='$projecte'";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
			mysql_free_result($result);
		
			return $row;
			}
			
public static function getdadesdirectusetank($projecte)
			{
			$i=0;
			$query="SELECT * FROM subsistemes_direct_use_tank where projecte='$projecte'";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
			mysql_free_result($result);
		
			return $row;
			}
			
public static function addseasonalstoragesystem($projecte,$storagesystem,$locationstorage,$w_volume,$material,$densitatmaterial,$capacitatcalormaterial,$maxtemp,$mintemp,$tanksurface,$heattransfer)
			{
			$query="select * from subsistemes_seasonal_storage_system where projecte='$projecte'";
			$i=0;
	
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
			mysql_free_result($result);
			$num=count($row)-1;
			if($num==0){$query="insert into subsistemes_seasonal_storage_system (projecte,storage_system,location,volumen,storage_material,maxtemp,mintemp,tank_surface,heat_transfer,density,heatcapacity) VALUES ('$projecte','$storagesystem','$locationstorage',$w_volume,'$material',$maxtemp,$mintemp,$tanksurface,$heattransfer,$densitatmaterial,$capacitatcalormaterial)";}
				else {$query="UPDATE subsistemes_seasonal_storage_system SET storage_system='$storagesystem',location='$locationstorage',volumen='$w_volume',storage_material='$material',maxtemp='$maxtemp',mintemp='$mintemp',tank_surface='$tanksurface',heat_transfer='$heattransfer',density='$densitatmaterial',heatcapacity='$capacitatcalormaterial' WHERE projecte='$projecte'";}
		
			$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
			
			}
			
public static function adddirectusetank($projecte,$storagesystem,$w_volume,$material,$densitatmaterial,$capacitatcalormaterial,$maxtemp,$mintemp,$tanksurface,$heattransfer)
			{
			$query="select * from subsistemes_direct_use_tank where projecte='$projecte'";
			$i=0;
	
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
			mysql_free_result($result);
			$num=count($row)-1;
			if($num==0){$query="insert into subsistemes_direct_use_tank (projecte,storage_system,volumen,storage_material,maxtemp,mintemp,tank_surface,heat_transfer,density,heatcapacity) VALUES ('$projecte','$storagesystem',$w_volume,'$material',$maxtemp,$mintemp,$tanksurface,$heattransfer,$densitatmaterial,$capacitatcalormaterial)";}
				else {$query="UPDATE subsistemes_direct_use_tank SET storage_system='$storagesystem',volumen='$w_volume',storage_material='$material',maxtemp='$maxtemp',mintemp='$mintemp',tank_surface='$tanksurface',heat_transfer='$heattransfer',density='$densitatmaterial',heatcapacity='$capacitatcalormaterial' WHERE projecte='$projecte'";}
		
			$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
			
			}
			
}


?>