<?php
require_once("gestio_projectesBBDD.php");
//require_once("localitat.php");

class demandas {
	
public static function add($loc,$long,$lat)
	{
	}
public static function numdemandas()
	{
					
	$i=0;
	$query = "select count(*) as num from demandas ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	$row=mysql_fetch_assoc($result);
	mysql_free_result($result);
	return $row['num'];

	}

public static function consultademandas()
	{
	$i=0;
	$query = "select * from demandas ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;

	}


public static function adddemanda($nomdemanda,$observacio)
	{


	$query = "INSERT INTO demandas (nom_demand, observacio) VALUES ('$nomdemanda','$observacio')";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	}

public static function addprojectdemanda($heatingdemand,$heatingtemp,$hotwaterdemand,$hotwatertemp,$coolingdemand,$coolingtemp,$electricappdemand,$numhomes,$demanda,$projecte)
	{
	$i=0;

	
	//Saber si ya existe
	$query = "select count(*) as aux from projectedemandes where projecte='".$projecte."'";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	$row=mysql_fetch_assoc($result);
	mysql_free_result($result);
	if($row['aux']==0)
		{
		$query = "INSERT INTO projectedemandes (projecte,numhomes,heatingdemand,heatingtemp,hotwaterdemand,hotwatertemp,coolingdemand,coolingtemp,electricappdemand) VALUES ('$projecte',$numhomes,$heatingdemand,$heatingtemp,$hotwaterdemand,$hotwatertemp,$coolingdemand,$coolingtemp,$electricappdemand)";
		
		}
	else
		{$query = "UPDATE `projectedemandes` SET `numhomes`=$numhomes,`heatingdemand`=$heatingdemand,`heatingtemp`=$heatingtemp,`hotwaterdemand`=$hotwaterdemand,`hotwatertemp`=$hotwatertemp,`coolingdemand`=$coolingdemand,`electricappdemand`=$electricappdemand,`coolingtemp`=$coolingtemp  WHERE projecte='$projecte'";}
	
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	$query = "UPDATE projects SET nomdemanda='$demanda' WHERE actual=1";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);

	}

public static function consultaproyectodemanda()
	{
	$i=0;
	$query = "select * from projectedemandes,projects where nomproject=projecte and actual=1 ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;

	}
	
public static function consultaproyectodemandaproj($proj)
	{
	$i=0;
	$query = "select * from projectedemandes,projects where nomproject=projecte and projecte='$proj' ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row;

	}

public static function getquantitat($id,$projecte)

	{
	if($id==4 || $id==5 || $id==6 || $id==7)
		{
		if($id==4){$tipodem="heatingdemand";}
		if($id==5){$tipodem="hotwaterdemand";}
		if($id==6){$tipodem="coolingdemand";}
		if($id==7){$tipodem="electricappdemand";}
		$i=0;		
		$query = "select $tipodem as tipo from projectedemandes where projecte='$projecte' ";
		
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
		$quantitat=$row[0]['tipo'];

		}
        else
		{$quantitat=1;}
	return $quantitat;
	}


public static function getdemandaproject()
	{
	$i=0;
	$query = "select nomdemanda from projects where actual=1 ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row[0];

	
	} 
	
public static function getdemandaproject2($projecte)
	{
	$i=0;
	$query = "select nomdemanda from projects where nomproject='$projecte' ";
	
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	return $row[0];

	
	} 
	
public static function getdemandadisproject($projecte)	
	{
	$i=0;
	$query = "select * from demandas ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	$query = "select localitat from projects where nomproject='$projecte' ";
	$i=0;
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row2[$i] = mysql_fetch_assoc($result)) { $i++; }
	mysql_free_result($result);
	$localitat=$row2[0]['localitat'];
	//print_r($row);
	$auxarray=array("localitat","observacio","tipusdis","discompleta");
	$x=0;
	foreach ($row as $ar)
		{
		
		for($i=4;$i<=7;$i++)
			{
			$distribuciocompleta=1;
			$aux1=botones::getanualdisdemand($i,$ar['nom_demand'],$projecte);
			//$aux1=botones::getanualdisdemand($i,$localitat,$projecte);
			if($aux1[1]['num']==0)
				{ 
				
				$distribuciocompleta=0;
				}
			else {
				for($j=1;$j<=12;$j++)
					{
					$aux2=botones::getmesdisdemand($i,$ar['nom_demand'],$j,$projecte);
					if($aux2[1]['num']==0)
						{ $distribuciocompleta=0;}
					}
			
				}
			if($distribuciocompleta==0)
				{
				$distribuciocompleta=2;
				//Mirar si hay por referencia
				
				//$aux3=botones::getanualdisdemandref($i,$ar['nom_demand']);
				$aux3=botones::getanualdisdemandref($i,$localitat);
				//if($aux3[1]['num']=0)
				$auxnomdemand=$localitat;
				//Cambio para no considerar anual
				
				if($aux3[1]['num']<12 || !$aux3)
					{ 
				
					$distribuciocompleta=0;
					}
				else {
					for($j=1;$j<=12;$j++)
						{
						$aux4=botones::getmesdisdemandref($i,$ar['nom_demand'],$j);
						//if($aux4[1]['num']==0)
						
                            if($aux4[1]['num']<24)
							{ $distribuciocompleta=0;}
						}
			
					}
				}
			//asignar $distribuciocompleta al tipusdis y a la localitat
			//$auxarray[$x]["localitat"]=$ar['nom_localitzacio'];
			//$auxarray[$x]["tipusdis"]=$i;
			//$auxarray[$x]["discompleta"]=$distribuciocompleta;
			if($ar['nom_demand']!=null){
			$auxarray[$x] = array("localitat" => $ar['nom_demand'],"observacio"=>$ar['observacio'],"tipusdis" => $i,"discompleta"=>$distribuciocompleta);
			//echo "var:".$aux1[1]['num'].",".$ar['nom_demand'].",".$i.",".$distribuciocompleta;
			//echo " vec:".$x.",".$auxarray[$x]['localitat'].",".$auxarray[$x]['tipusdis'].",".$auxarray[$x]['discompleta'];
			}
			$x++;
			}
		
		}
	return $auxarray;
	}

}

?>