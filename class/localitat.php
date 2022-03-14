<?php
require_once("gestio_projectesBBDD.php");
require_once("botones.php");

class localitat {
	
public static function add($loc,$long,$lat)
	{
	}
public static function numlocalitats()
	{
					
	$i=0;
	$query = "select count(*) as num from localitzacions ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	$row=mysql_fetch_assoc($result);
	mysql_free_result($result);
	return $row['num'];

	}

public static function consultalocalitats()
	{
	$i=0;
	$query = "select * from localitzacions ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;

	}

public static function resetlocalitatproject($localitat,$projh)
{
$query = "UPDATE `projects` SET localitat='' WHERE localitat='$localitat' and nomproject='$projh'";
$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
$query = "DELETE FROM `distribucions_anuals_projectes` WHERE `projecte`='$projh' and (`idDistribucio_anual`=1 or `idDistribucio_anual`=2 or `idDistribucio_anual`=3 or `idDistribucio_anual`=8)";
$result2=mysql_query($query,gestio_projectesBBDD::$dbconn);
$query = "DELETE FROM ``distribucions_diaries_projectes` WHERE `projecte`='$projh' and (`idDistribucio_anual`=1 or `idDistribucio_anual`=2 or `idDistribucio_anual`=3 or `idDistribucio_anual`=8)";
$result3=mysql_query($query,gestio_projectesBBDD::$dbconn);

}

public static function addlocalitat($localitat,$pais,$latitut,$longitut)
	{
	$query = "INSERT INTO localitzacions (nom_localitzacio, latitut, longitut, pais) VALUES ('$localitat',$latitut,$longitut,'$pais')";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	}
public static function addlocalitatproject($localitat)
	{
	$query = "UPDATE `projects` SET localitat='$localitat' WHERE actual=1";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);

	}

public static function getlocalitatproject()
	{
	$i=0;
	$query = "select localitat from projects where actual=1 ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row[0];

	}

public static function getlocalitatproject2($projecte)
	{
	$i=0;
	$query = "select localitat,latitut,longitut from projects,localitzacions where nom_localitzacio=localitat and nomproject='$projecte' ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row[0];

	}

public static function getlocalitatdisproject($projecte)	
	{
	$i=0;
	$query = "select * from localitzacions ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	$auxarray=array("localitat","tipusdis","discompleta");
	$x=0;
	foreach ($row as $ar)
		{
		
		for($i=1;$i<=4;$i++)
			{
			if($i==4){$k=8;}else{$k=$i;}
			$distribuciocompleta=1;
			$aux1=botones::getanualdisloc($k,$ar['nom_localitzacio'],$projecte);
			//Quitar este if si no es necesario tener las anuales
			if($aux1[1]['num']==0)
				{ $distribuciocompleta=0;}
			else {
				for($j=1;$j<=12;$j++)
					{
					$aux2=botones::getmesdisloc($k,$ar['nom_localitzacio'],$j,$projecte);
					if($aux2[1]['num']==0)
						{ $distribuciocompleta=0;}
					}
			
				}
			if($distribuciocompleta==0)
				{
				$distribuciocompleta=2;
				//Mirar si hay por referencia
				$aux3=botones::getanualdislocref($k,$ar['nom_localitzacio']);
				//Cambio para que no tenga en cuenta referencias mensuales, lo calcula al final
				//if($aux3[1]['num']==0)
				//{ 
				
				//$distribuciocompleta=0;
				//}
				//else {
				for($j=1;$j<=12;$j++)
					{
					$aux4=botones::getmesdislocref($k,$ar['nom_localitzacio'],$j);
					if($aux4[1]['num']==0)
						{ $distribuciocompleta=0;}
					}
			
				//}
				}
			//asignar $distribuciocompleta al tipusdis y a la localitat
			//$auxarray[$x]["localitat"]=$ar['nom_localitzacio'];
			//$auxarray[$x]["tipusdis"]=$i;
			//$auxarray[$x]["discompleta"]=$distribuciocompleta;
			if($ar['nom_localitzacio']!=null){
			$auxarray[$x] = array("localitat" => $ar['nom_localitzacio'],"tipusdis" => $k,"discompleta"=>$distribuciocompleta);
			//echo "var:".$aux1[1]['num'].",".$ar['nom_localitzacio'].",".$i.",".$distribuciocompleta;
			//echo " vec:".$x.",".$auxarray[$x]['localitat'].",".$auxarray[$x]['tipusdis'].",".$auxarray[$x]['discompleta'];
			}
			$x++;
			}
		
		}
	return $auxarray;
	}
	
public static function getlocalitatdisref($localitat)	
	{
		/*
	$i=0;
	$query = "select * from localitzacions ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	*/
	$auxarray=array("localitat","tipusdis","discompleta");
	$x=0;
	
	//foreach ($row as $ar)
	//	{
		
		for($i=1;$i<=4;$i++)
			{
			if($i==4){$k=8;}else{$k=$i;}
			$distribuciocompleta=1;
			/*$aux1=botones::getanualdisloc($k,$localitat,$projecte);
			//Quitar este if si no es necesario tener las anuales
			if($aux1[1]['num']==0)
				{ $distribuciocompleta=0;}
			else {
				for($j=1;$j<=12;$j++)
					{
					$aux2=botones::getmesdisloc($k,$localitat,$j,$projecte);
					if($aux2[1]['num']==0)
						{ $distribuciocompleta=0;}
					}
			
				}
			*/
			//if($distribuciocompleta==0)
			//	{
				$distribuciocompleta=2;
				//Mirar si hay por referencia
				$aux3=botones::getanualdislocref($k,$localitat);
				//Cambio para que no tenga en cuenta referencias mensuales, lo calcula al final
				if($aux3[1]['num']==0)
				{ 
				
				$distribuciocompleta=0;
				}
				//else {
				for($j=1;$j<=12;$j++)
					{
					$aux4=botones::getmesdislocref($k,$localitat,$j);
					if($aux4[1]['num']==0)
						{ $distribuciocompleta=0;}
					}
			
				//}
				//}
			//asignar $distribuciocompleta al tipusdis y a la localitat
			//$auxarray[$x]["localitat"]=$ar['nom_localitzacio'];
			//$auxarray[$x]["tipusdis"]=$i;
			//$auxarray[$x]["discompleta"]=$distribuciocompleta;
			if($localitat!=null){
			$auxarray[$x] = array("localitat" => $localitat,"tipusdis" => $k,"discompleta"=>$distribuciocompleta);
			//echo "var:".$aux1[1]['num'].",".$ar['nom_localitzacio'].",".$i.",".$distribuciocompleta;
			//echo " vec:".$x.",".$auxarray[$x]['localitat'].",".$auxarray[$x]['tipusdis'].",".$auxarray[$x]['discompleta'];
			}
			$x++;
			}
		
		//}
	return $auxarray;
	}	
}

?>