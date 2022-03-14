<?php
require_once("gestio_projectesBBDD.php");

class valoresreferencia {
	
public static function getvaloresref()
	{
	$i=0;
	$query = "select * from valoresreferencia ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;
	}

public static function getenergycost($projh)
	{
	$i=0;
	$query = "select * from energy_cost where projecto='$projh'";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;
	
	
	}
	
public static function addenergycost($projecte,$cost0,$cost1,$cost2,$cost3,$cost4)
	{
			$i=0;
			
			$query="select * from energy_cost where projecto='$projecte'";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
			mysql_free_result($result);
			$num=count($row)-1;
			if($num==0){
			$query="insert into energy_cost (projecto,cost0,cost1,cost2,cost3,cost4) VALUES ('$projecte','$cost0','$cost1','$cost2','$cost3','$cost4')";
			}
			else
				{$query="UPDATE energy_cost SET cost0='$cost0',cost1='$cost1',cost2='$cost2',cost3='$cost3',cost4='$cost4' WHERE projecto='$projecte'";

				}
			
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			//mysql_free_result($result);
			$aux=self::getenergycost($projecte);
			return $aux;

	}
	
	
	
	
}
?>