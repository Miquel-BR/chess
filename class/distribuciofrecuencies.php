<?php

require_once("gestio_projectesBBDD.php");

class distribuciofrecuencies {
		
	
	public static function getalldistribucions() {
				
			$i=0;
			$query = "select * from tipus_distribucio ";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
			mysql_free_result($result);
		
	return $row;
	}

	public static function getalldistribucionspercalcular() {
				
			$i=0;
			$query = "select * from tipus_distribucio where exists (select * from distribucions_anuals,tipus_distribucio where idDistribucio_anual=tipus_distribucio.id_distribucio) and exists (select * from distribucions_diaries,tipus_distribucio where idDistribucio_diaria=tipus_distribucio.id_distribucio) and not exists (select * from distribucio_anual_diaria,tipus_distribucio where distribucio_anual_diaria.id_distribucio=tipus_distribucio.id_distribucio) group by tipus_distribucio.id_distribucio";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
			mysql_free_result($result);
		
	return $row;
	
	}

	public static function getalldistribucionscalculades()
		{
				
			$i=0;
			$query = "SELECT distribucio_anual_diaria.id_distribucio,nom_distribucio FROM `distribucio_anual_diaria`,tipus_distribucio where tipus_distribucio.id_distribucio=distribucio_anual_diaria.id_distribucio group by id_distribucio";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
			mysql_free_result($result);
		
		return $row;
		
		}
	public static function obteniriddistribucio ($distribucio)
	{
		$i=0;
		$query="select id_distribucio from tipus_distribucio where nom_distribucio='$distribucio'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($result);
		$numero=mysql_num_rows($result);
		mysql_free_result($result);
		return $row['id_distribucio'];
		
	}

	public static function obtenirnomdistribucio ($iddistribucio)
	{
		$i=0;
		$query="select nom_distribucio from tipus_distribucio where id_distribucio='$iddistribucio'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($result);
		$numero=mysql_num_rows($result);
		mysql_free_result($result);
		return $row['nom_distribucio'];
		
	}

	public static function obtenirnumdistribucioanualmes($mes,$iddistribucio,$localitat)
	{
		$i=0;
		//if($iddistribucio==1 || $iddistribucio==2 || $iddistribucio==3 || $iddistribucio==8){
		$query= "select * from distribucions_anuals where mes=$mes and idDistribucio_anual=$iddistribucio and localitat='$localitat'";
		//}
		//if($iddistribucio==4 || $iddistribucio==5 || $iddistribucio==6 || $iddistribucio==7){
		//	$query= "select * from distribucions_anuals where mes=$mes and idDistribucio_anual=$iddistribucio and demand='$localitat'";}
		//echo "$query";
		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		while ($row[$i] = mysql_fetch_assoc($resultado)) { $i++; }
		
		
		mysql_free_result($resultado);
		return $row;
	}

	public static function obtenirnumdistribucioanualmesprojecte($mes,$iddistribucio,$localitat,$projecte)
	{
		//$query= "select * from distribucions_anuals_projectes where mes=$mes and idDistribucio_anual=$iddistribucio and localitat='$localitat' and projecte='$projecte'";
		$query= "select * from distribucions_anuals_projectes where mes=$mes and idDistribucio_anual=$iddistribucio and projecte='$projecte'";

		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		
		
		mysql_free_result($resultado);
		return $row;
	}

	public static function obtenirnumdistribucioanualmesprojecteloc($mes,$iddistribucio,$localitat,$projecte)
	{
		
		$query= "select * from distribucions_anuals_projectes where mes=$mes and idDistribucio_anual=$iddistribucio and localitat='$localitat' and projecte='$projecte'";
		//if($iddistribucio==4 || $iddistribucio==5 || $iddistribucio==6 || $iddistribucio==7){
		//	$query= "select * from distribucions_anuals_projectes where mes=$mes and idDistribucio_anual=$iddistribucio and demand='$localitat' and projecte='$projecte'";}

		
		//$query= "select * from distribucions_anuals_projectes where mes=$mes and idDistribucio_anual=$iddistribucio and projecte='$projecte'";

		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		
		
		mysql_free_result($resultado);
		return $row;
	}
	
	public static function obtenirnumdistribuciodiariameshoraprojecte($mes,$hora,$iddistribucio,$localitat,$projecte)
	{
		//$query= "select * from distribucions_diaries_projectes where mes=$mes and hora=$hora and idDistribucio_diaria=$iddistribucio and localitat='$localitat' and projecte='$projecte'";
		$query= "select * from distribucions_diaries_projectes where mes=$mes and hora=$hora and idDistribucio_diaria=$iddistribucio and projecte='$projecte'";

		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		
		
		mysql_free_result($resultado);
		return $row;
	}
	public static function obtenirnumdistribuciodiariameshoraprojecteloc($mes,$hora,$iddistribucio,$localitat,$projecte)
	{
		$query= "select * from distribucions_diaries_projectes where mes=$mes and hora=$hora and idDistribucio_diaria=$iddistribucio and localitat='$localitat' and projecte='$projecte'";
		//$query= "select * from distribucions_diaries_projectes where mes=$mes and hora=$hora and idDistribucio_diaria=$iddistribucio and projecte='$projecte'";

		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		
		
		mysql_free_result($resultado);
		return $row;
	}
	
	public static function obtenirnumdistribuciodiariameshoraprojectedemanda($mes,$hora,$iddistribucio,$demanda,$projecte)
	{
		//$query= "select * from distribucions_diaries_projectes where mes=$mes and hora=$hora and idDistribucio_diaria=$iddistribucio and demand='$demanda' and projecte='$projecte'";
		$query= "select * from distribucions_diaries_projectes where mes=$mes and hora=$hora and idDistribucio_diaria=$iddistribucio and projecte='$projecte'";

		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		
		
		mysql_free_result($resultado);
		return $row;
	}
	
	public static function obtenirnumdistribuciodiariameshoraprojectedemandaloc($mes,$hora,$iddistribucio,$demanda,$projecte)
	{
		$query= "select * from distribucions_diaries_projectes where mes=$mes and hora=$hora and idDistribucio_diaria=$iddistribucio and demand='$demanda' and projecte='$projecte'";
		//$query= "select * from distribucions_diaries_projectes where mes=$mes and hora=$hora and idDistribucio_diaria=$iddistribucio and projecte='$projecte'";

		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		
		
		mysql_free_result($resultado);
		return $row;
	}
	
	public static function obtenirnumdistribucioanualmesprojectedemanda($mes,$iddistribucio,$demanda,$projecte)
	{
		$query= "select * from distribucions_anuals_projectes where mes=$mes and idDistribucio_anual=$iddistribucio and demand='$demanda' and projecte='$projecte'";
		//$query= "select * from distribucions_anuals_projectes where mes=$mes and idDistribucio_anual=$iddistribucio and projecte='$projecte'";

		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		
		
		mysql_free_result($resultado);
		return $row;
	}
	
	public static function obtenirnumdistribucioanualmesprojectedemandaloc($mes,$iddistribucio,$demanda,$projecte)
	{
		$query= "select * from distribucions_anuals_projectes where mes=$mes and idDistribucio_anual=$iddistribucio and demand='$demanda' and projecte='$projecte'";
		//$query= "select * from distribucions_anuals_projectes where mes=$mes and idDistribucio_anual=$iddistribucio and projecte='$projecte'";

		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		
		
		mysql_free_result($resultado);
		return $row;
	}
	
	public static function obtenirnumdistribucioanualmesdemanda ($mes,$iddistribucio,$demanda)
	{
		$i=1;
		$query= " select * from distribucions_anuals where mes=$mes and idDistribucio_anual=$iddistribucio and demand='$demanda'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
        return $row;

	}

	public static function checkdistribucioanual($iddistribucio,$localitat)
		{
		$query= " select count(*) as count from distribucions_anuals where idDistribucio_anual='$iddistribucio' and localitat='$localitat'";
		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		
		$aux=$resultado;
		mysql_free_result($resultado);
		return $row['count'];
		}

	public static function checkdistribucioanualdemanda($iddistribucio,$demanda)
		{
		$query= " select count(*) as count from distribucions_anuals where idDistribucio_anual='$iddistribucio' and demand='$demanda'";
		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		
		$aux=$resultado;
		mysql_free_result($resultado);
		return $row['count'];
		}

	public static function checkdistribuciodiaria($iddistribucio,$localitat)
		{
		$query= " select count(*) as count from distribucions_diaries where idDistribucio_diaria='$iddistribucio' and localitat='$localitat'"; 
		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		
		$aux=$resultado;
		mysql_free_result($resultado);
		return $row['count'];
		}
		
	public static function getdistribucioref($iddistribucio,$nom,$tipograf)
		{
		$query= " select tipo from tipus_distribucio where id_distribucio='$iddistribucio'";
		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		$aux=$row['tipo'];
		mysql_free_result($resultado);
		if($aux==2){
			if($tipograf=='hor'){
				$query= " select * from distribucions_diaries where idDistribucio_diaria='$iddistribucio' and localitat='$nom'"; 
				}
			if($tipograf=='mes'){
				$query= " select * from distribucions_anuals where idDistribucio_anual='$iddistribucio' and localitat='$nom'"; 
				}
			}
		if($aux==1){
			if($tipograf=='hor'){
				$query= " select * from distribucions_diaries where idDistribucio_diaria='$iddistribucio' and demand='$nom'"; 
				}
			if($tipograf=='mes'){
				$query= " select * from distribucions_anuals where idDistribucio_anual='$iddistribucio' and demand='$nom'"; 
				}
		}
		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		
		$aux=$resultado;
		mysql_free_result($resultado);
		return $row;
		}
	

	
	public static function getdistribucioproj($iddistribucio,$nom,$projecte,$tipograf)
		{
		$query= " select tipo from tipus_distribucio where id_distribucio='$iddistribucio'";
		
		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		$aux=$row['tipo'];
		mysql_free_result($resultado);
		if($aux==2){
			if($tipograf=='hor'){
				$query= " select * from distribucions_diaries_projectes where idDistribucio_diaria='$iddistribucio' and localitat='$nom' and projecte='$projecte'"; 
				}
			if($tipograf=='mes'){
				$query= " select * from distribucions_anuals_projectes where idDistribucio_anual='$iddistribucio' and localitat='$nom' and projecte='$projecte'"; 

				}
			}
		if($aux==1){
			if($tipograf=='hor'){
					
					$query= " select *  from distribucions_diaries_projectes where idDistribucio_diaria='$iddistribucio' and demand='$nom' and projecte='$projecte'"; 
					
					}
			if($tipograf=='mes'){
					$query= " select *  from distribucions_anuals_projectes where idDistribucio_anual='$iddistribucio' and demand='$nom' and projecte='$projecte'"; 
					}
		}
		
		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		
		$aux=$resultado;
		mysql_free_result($resultado);
		return $row;
		}
	
	public static function checkdistribuciodiariademanda($iddistribucio,$demanda,$mes)
		{
		$query= " select count(*) as count from distribucions_diaries where idDistribucio_diaria='$iddistribucio' and demand='$demanda' and mes='$mes'"; 
		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		
		$aux=$resultado;
		mysql_free_result($resultado);
		return $row['count'];
		}

	public static function obtenirnumdistribucioanualhora ($hora,$iddistribucio,$mes,$localitat)
	{

		$query= " select count(*) as count from distribucions_diaries where idDistribucio_diaria='$iddistribucio' and hora='$hora' and mes='$mes' and localitat='$localitat'";

		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		
		$aux=$resultado;
		mysql_free_result($resultado);
		return $row['count'];
	}
	
	public static function obtenirdistribucioanualhora ($hora,$iddistribucio,$mes,$localitat)
	{
		$i=0;
		
		$query= " select * from distribucions_diaries where idDistribucio_diaria='$iddistribucio' and hora='$hora' and mes='$mes' and localitat='$localitat'";
		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		while ($row[$i] = mysql_fetch_assoc($resultado)) { $i++; }
		

		mysql_free_result($resultado);
		return $row;
	}

	public static function obtenirnumdistribucioanualhorademanda ($hora,$distribucio,$mes,$demanda)
	{
		$query= " select count(*) as count from distribucions_diaries, tipus_distribucio where id_distribucio=idDistribucio_diaria and hora='$hora' and nom_distribucio='$distribucio' and mes='$mes' and demand='$demanda'";
		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_assoc($resultado);
		
		$aux=$resultado;
		mysql_free_result($resultado);
		return $row['count'];
	}
	
	public static function obtenirdistribucioanualhorademanda ($hora,$iddistribucio,$mes,$localitat)
	{
		$i=0;
		
		$query= " select * from distribucions_diaries where idDistribucio_diaria='$iddistribucio' and hora='$hora' and mes='$mes' and demand='$localitat'";
		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		while ($row[$i] = mysql_fetch_assoc($resultado)) { $i++; }
		

		mysql_free_result($resultado);
		return $row;
	}
	
	
	

	public static function omplirdadesdistribucioanual($iddistribucio)
	{


		//return vector binario de datos 2x12
		$i=0;
		$query = "select * from distribucions_anuals where idDistribucio_anual='$iddistribucio'";
		$resultado=mysql_query($query,gestio_projectesBBDD::$dbconn);
		while ($row[$i] = mysql_fetch_assoc($resultado)) { $i++; }
		mysql_free_result($resultado);
		return $row;
	}

	public static function omplirdadesdistribuciodiaria($iddistribucio)
	 {
		//return vector binario de datos 2x24
		$i=0;
		$query = "select * from distribucions_diaries where idDistribucio_diaria='$iddistribucio'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
		return $row;


	}
	
	public static function borrardistribucioanual($iddistribucio)
	{
		$i=0;
		$query="delete from distribucions_anuals where idDistribucio_anual='$iddistribucio'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		mysql_free_result($result);
		$query="delete from distribucio_anual_diaria where id_distribucio='$iddistribucio'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		mysql_free_result($result);

	}
	public static function borrardistribuciodiaria($iddistribucio)
	{
		
		$query="delete from distribucions_diaries where idDistribucio_diaria='$iddistribucio'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		mysql_free_result($result);
		$query="delete from distribucio_anual_diaria where id_distribucio=".$iddistribucio;
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		mysql_free_result($result);

	}

	public static function adddistribucioanual($iddistribucio,$nomdistribucio,$valors)
		{
		//buscar si existe esta distribucion, si no existe crearla en tipos distribucion
		$iddis=obteniriddistribucio($nomdistribucio);
		if ($iddis=="")
			{
			//crear uno nuevo
			$query="insert into tipus_distribucio (nom_distribucio,id_distribucio) VALUES ('$nomdistribucio','$iddistribucio')";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			mysql_free_result($result);
			}
		else
			{
			if($iddis!=$iddistribucio)
				{$iddistribucio=$iddis;}
			}
		
		//insertar los datos
		$i=1;
		while ($i<=12)
			{
			$j=$i-1;
			$query="insert into distribucions_anuals (idDistribucio_anual,mes,valor) VALUES ('$iddistribucio','$i','$valors[$j]')";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			mysql_free_result($result);
			$i++;
			}

		
		
		
		}

	public static function adddistribuciodiaria($iddistribucio,$nomdistribucio,$valors)
		{
		//buscar si existe esta distribucion, si no existe crearla en tipos distrubucion
		$iddis=obteniriddistribucio($nomdistribucio);
		if ($iddis=="")
			{
			//crear uno nuevo
			$query="insert into tipus_distribucio (nom_distribucio,id_distribucio) VALUES ('$nomdistribucio','$iddistribucio')";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			mysql_free_result($result);
			}
		else
			{
			if($iddis!=$iddistribucio)
				{$iddistribucio=$iddis;}
			}
		
		//insertar los datos
		$i=1;
		while ($i<=24)
			{
			$j=$i-1;
			$query="insert into distribucions_diaries (idDistribucio_diaria,hora,valor) VALUES ('$iddistribucio','$i','$valors[$j]')";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			mysql_free_result($result);
			$i++;
			}

		
		
		
		}


	public static function updatedistribucioanual($iddistribucio,$valors)
		{
		$i=1;
		while ($i<=12)
			{
			$query="update distribucions_anuals SET idDistribucio_anual=".$iddistribucio.",mes=".$i.",valor=".$valor[$i];
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			mysql_free_result($result);
			$i++;
			}
		}

	public static function updatedistribuciodiaria($iddistribucio,$valors)
		{
		$i=1;
		while ($i<=24)
			{
			$query="update distribucions_diaries SET idDistribucio_diaria=".$iddistribucio.",hora=".$i.",valor=".$valor[$i];
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			mysql_free_result($result);
			$i++;
			}
		}

	public static function validacio($distribucio)
		{
			
			$query = "select count(*) as count from tipus_distribucio where nom_distribucio='$distribucio'";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			$row=mysql_fetch_assoc($result);
		
			
			mysql_free_result($result);
			return $row['count'];
			
		}
	
	public static function validaciodetalls($distribucio,$localitat)
		{
			
			$query = "select count(*) as count from tipus_distribucio,tipus_distribucio_detalls where tipus_distribucio.id_distribucio=tipus_distribucio_detalls.id_distribucio and nom_distribucio='$distribucio' and localitat='$localitat'";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			$row=mysql_fetch_assoc($result);
		
			
			mysql_free_result($result);
			return $row['count'];
			
		}


	public static function getdadesdistribucioanual($iddistribucio,$nomdist,$proj)
		{
		$i=0;
		$query3="select tipo from tipus_distribucio where id_distribucio=$iddistribucio";
		$result3=mysql_query($query3,gestio_projectesBBDD::$dbconn);
		while ($row3[$i] = mysql_fetch_assoc($result3)) { $i++; }
		if($row3[0]['tipo']==2){$tipusdis="localitat";}
		if($row3[0]['tipo']==1){$tipusdis="demand";}
		mysql_free_result($result3);
		//if(($iddistribucio==1) || ($iddistribucio==2) || ($iddistribucio==3) || ($iddistribucio==8))
		//	{$tipusdis="localitat";}
		//if (($iddistribucio==4) || ($iddistribucio==5) || ($iddistribucio==6) || ($iddistribucio==7))
		//	{$tipusdis="demand";}
		$quantitat=1;
		//Pasar de porcetaje a cantidades
		if($tipusdis=="demand")
			{
			//Buscar cantidad
			$i=0;
			$query2="select * from projectedemandes where projecte='$proj'";
			$result2=mysql_query($query2,gestio_projectesBBDD::$dbconn);
			while ($row2[$i] = mysql_fetch_assoc($result2)) { $i++; }
			$num=count($row2)-1;
			mysql_free_result($result2);
			
			if($num>0){
				if($iddistribucio==4){$quantitat=$row2[0]['heatingdemand'];}
				if($iddistribucio==5){$quantitat=$row2[0]['hotwaterdemand'];}
				if($iddistribucio==6){$quantitat=$row2[0]['coolingdemand'];}
				if($iddistribucio==7){$quantitat=$row2[0]['electricappdemand'];}
				}
			else {$quantitat=1;}
			$quantitat=$quantitat/100;
			
			}	
			
		//echo "$quantitat";
		
		$i=1;
		$query = "select valor from distribucions_anuals_projectes where idDistribucio_anual='$iddistribucio' and $tipusdis='$nomdist' and projecte='$proj' group by mes order by mes";
		
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
		$i=1;
		foreach($row as $ar)
			{
			$aux1[$i]['valor']=$ar['valor']*$quantitat;$i++;
			}
		 //return $row;
		 return $aux1;
                
			}
		}

	public static function getdadesdistribucioanualprojecte($iddistribucio,$localitat,$projecte)
		{
		//para datos externos-localidades
		$i=1;
		$query = "select valor from distribucions_anuals_projectes where  idDistribucio_anual='$iddistribucio' and localitat='$localitat' and projecte='$projecte' order by mes";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
                return $row;
			}
		}

	public static function getdadesdistribucioanualdemanda($distribucio,$demanda,$tipo)
		{
		$i=1;
		$query = "select valor from tipus_distribucio,distribucions_anuals where tipus_distribucio.id_distribucio=distribucions_anuals.idDistribucio_anual and nom_distribucio='$distribucio' and demand='$demanda' order by mes";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
                return $row;
			}
		}


	public static function getdadesdistribucioanualmesprojecte($iddistribucio,$localitat,$projecte,$mes)
		{
		$i=1;
		$query = "select valor from distribucions_anuals_projectes where idDistribucio_anual='$iddistribucio' and localitat='$localitat' and projecte='$projecte' and mes='$mes'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
                return $row;
			}
		}

	public static function getdadesdistribucioanualmesdemanda($iddistribucio,$demanda,$mes)
		{
		$i=1;
		$query = "select valor from distribucions_anuals where idDistribucio_anual=$iddistribucio and demand='$demanda' and mes=$mes";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
                return $row;
			}
		}
		
	public static function getdadesdistribucioanualmesdemandaprojecte($iddistribucio,$demanda,$mes,$projecte)
		{

		$i=1;
		$query = "select valor from distribucions_anuals_projectes where idDistribucio_anual='$iddistribucio' and demand='$demanda' and mes='$mes' and projecte='$projecte'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
                return $row;
			}
		}

	public static function getdadesdistribucioanualmes($iddistribucio,$localitat,$mes)
		{
		
		$i=1;
		$query = "select valor from distribucions_anuals where  iDdistribucio_anual='$iddistribucio' and localitat='$localitat' and mes='$mes'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
                return $row;
			}
		}

	public static function getdadesdistribuciodiaria($iddistribucio,$mes,$nomdist,$proj)
		{
		
		//if($iddistribucio==1 || $iddistribucio==2 || $iddistribucio==3)
		//	{$tipusdis="localitat";}
		//if($iddistribucio==4 || $iddistribucio==5 || $iddistribucio==6 || $iddistribucio==7)
		//	{$tipusdis="demand";}
		$i=0;
		$query3="select tipo from tipus_distribucio where id_distribucio=$iddistribucio";
		$result3=mysql_query($query3,gestio_projectesBBDD::$dbconn);
		while ($row3[$i] = mysql_fetch_assoc($result3)) { $i++; }
		if($row3[0]['tipo']==2){$tipusdis="localitat";}
		if($row3[0]['tipo']==1){$tipusdis="demand";}
		mysql_free_result($result3);
		$i=1;
		$quantitat=1;
		//Pasar de porcetaje a cantidades
		if($tipusdis=="demand")
			{
			//Buscar cantidad
			$i=0;
			$query2="select * from projectedemandes where projecte='$proj'";
			$result=mysql_query($query2,gestio_projectesBBDD::$dbconn);
			while ($row2[$i] = mysql_fetch_assoc($result)) { $i++; }
			$num=count($row2)-1;
			mysql_free_result($result);
			
			if($num>0){
				if($iddistribucio==4){$quantitat=$row2[0]['heatingdemand']/100;}
				if($iddistribucio==5){$quantitat=$row2[0]['hotwaterdemand']/100;}
				if($iddistribucio==6){$quantitat=$row2[0]['coolingdemand']/100;}
				if($iddistribucio==7){$quantitat=$row2[0]['electricappdemand']/100;}
				}
			else {$quantitat=1;}
			$v_dadesdismesdemandaproj=distribuciofrecuencies::getdadesdistribucioanualmesdemandaprojecte($iddistribucio,$nomdist,$mes,$proj);
			$numdadesdismesdemandaproj=count($v_dadesdismesdemandaproj)-1;
			if($numdadesdismesdemandaproj>0)
				{$auxq=$v_dadesdismesdemandaproj[1]['valor'];
				}
			else {$auxq=1;}
			if($mes==1){$quantitat=$quantitat*($auxq/100)/31;}
			if($mes==2){$quantitat=$quantitat*($auxq/100)/28;}
			if($mes==3){$quantitat=$quantitat*($auxq/100)/31;}
			if($mes==4){$quantitat=$quantitat*($auxq/100)/30;}
			if($mes==5){$quantitat=$quantitat*($auxq/100)/31;}
			if($mes==6){$quantitat=$quantitat*($auxq/100)/30;}
			if($mes==7){$quantitat=$quantitat*($auxq/100)/31;}
			if($mes==8){$quantitat=$quantitat*($auxq/100)/31;}
			if($mes==9){$quantitat=$quantitat*($auxq/100)/30;}
			if($mes==10){$quantitat=$quantitat*($auxq/100)/31;}
			if($mes==11){$quantitat=$quantitat*($auxq/100)/30;}
			if($mes==12){$quantitat=$quantitat*($auxq/100)/31;}
			
			}	
			
		//echo "$quantitat,$auxq";
		$query = "select * from distribucions_diaries_projectes where idDistribucio_diaria=$iddistribucio and mes='$mes' and $tipusdis='$nomdist' and projecte='$proj' order by hora";
		$result2=mysql_query($query,gestio_projectesBBDD::$dbconn);
		
		if (!$result2) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result2)) { $i++; }
		mysql_free_result($result2);
		$i=1;
		foreach($row as $ar)
			{
			$aux1[$i]['valor']=$ar['valor']*$quantitat;$i++;
			}
		 //return $row;
		 return $aux1;
			}

		}
	
	public static function getdadesdistribucioanualref($iddistribucio,$loc,$mes,$proj)
		{
		$i=0;
		$query3="select tipo from tipus_distribucio where id_distribucio=$iddistribucio";
		$result3=mysql_query($query3,gestio_projectesBBDD::$dbconn);
		while ($row3[$i] = mysql_fetch_assoc($result3)) { $i++; }
		if($row3[0]['tipo']==2){$tipusdis="localitat";}
		if($row3[0]['tipo']==1){$tipusdis="demand";}
		mysql_free_result($result3);
		$i=1;$quantitat=1;
		if($tipusdis=="demand")
			{
			//Buscar cantidad
			$i=0;
			$query2="select * from projectedemandes where projecte='$proj'";
			$result=mysql_query($query2,gestio_projectesBBDD::$dbconn);
			while ($row2[$i] = mysql_fetch_assoc($result)) { $i++; }
			$num=count($row2)-1;
			mysql_free_result($result);
			
			if($num>0){
				if($iddistribucio==4){$quantitat=$row2[0]['heatingdemand']/100;}
				if($iddistribucio==5){$quantitat=$row2[0]['hotwaterdemand']/100;}
				if($iddistribucio==6){$quantitat=$row2[0]['coolingdemand']/100;}
				if($iddistribucio==7){$quantitat=$row2[0]['electricappdemand']/100;}
				}
			}
		//Pasar de porcetaje a cantidades
		//La cantidad es nula porque estamos indicando referencias y para eso necesitaríamos un projecto pero se puede pasar un projecto
		if($tipusdis=="demand"){
		 $valor=distribuciofrecuencies::getdadesdistribucioanualmesdemanda($iddistribucio,$loc,$mes);}	
		if($tipusdis=="localitat"){
		 $valor=distribuciofrecuencies::getdadesdistribucioanualmes($iddistribucio,$loc,$mes);}
		//print_r($valor);echo "<br>";
		$valor[1]['valor']=$valor[1]['valor']*$quantitat;
		return $valor[1];
		}
		
	public static function getdadesdistribuciodiariaprojecte($iddistribucio,$mes,$localitat,$projecte)
		{
		$i=1;
		$query = "select valor from distribucions_diaries_projectes where idDistribucio_diaria='$iddistribucio' and mes='$mes' and localitat='$localitat' and projecte='$projecte' order by hora";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
                return $row;
			}

		}

	public static function getdadesdistribuciodiariaprojectedemanda($iddistribucio,$mes,$demanda,$projecte)
		{
		$i=1;
		$query = "select valor from distribucions_diaries_projectes where idDistribucio_diaria='$iddistribucio' and mes='$mes' and demand='$demanda' and projecte='$projecte' order by hora";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
                return $row;
			}

		}
		
	public static function getdadesdistribuciodiariademanda($distribucio,$mes,$demanda)
		{
		$i=1;
		$query = "select valor from tipus_distribucio,distribucions_diaries where tipus_distribucio.id_distribucio=distribucions_diaries.idDistribucio_diaria and nom_distribucio='$distribucio' and mes='$mes' and demand='$demanda' order by hora";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
                return $row;
			}

		}

	public static function getdadesdistribuciodiariames($distribucio,$localitat,$mes,$hora)
		{
		$i=1;
		$query = "select valor from tipus_distribucio,distribucions_diaries where tipus_distribucio.id_distribucio=distribucions_diaries.idDistribucio_diaria and nom_distribucio='$distribucio' and mes='$mes' and localitat='$localitat' and hora='$hora'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
                return $row;
			}

		}
	public static function getdadesdistribuciodiariameshora($iddistribucio,$localitat,$mes,$hora)
		{
		$i=1;
		$query = "select valor from distribucions_diaries where idDistribucio_diaria='$iddistribucio' and mes='$mes' and localitat='$localitat' and hora='$hora'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
                return $row;
			}

		}
		
	public static function getdadesdistribuciodiariameshorademanda($iddistribucio,$demanda,$mes,$hora)
		{
		$i=1;
		$query = "select valor from distribucions_diaries where idDistribucio_diaria='$iddistribucio' and mes='$mes' and demand='$demanda' and hora='$hora'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
                return $row;
			}

		}
	
	public static function getdadesdistribuciodiariamesprojecte($iddistribucio,$localitat,$mes,$hora,$projecte)
		{
		$i=1;
		$query = "select valor from distribucions_diaries_projectes where idDistribucio_diaria='$iddistribucio' and mes='$mes' and localitat='$localitat' and hora='$hora' and projecte='$projecte'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
                return $row;
			}

		}
	
	public static function getdadesdistribuciodiariamesprojectedemanda($iddistribucio,$demanda,$mes,$hora,$projecte)
		{
		$i=1;
		$query = "select valor from distribucions_diaries_projectes where idDistribucio_diaria='$iddistribucio' and mes='$mes' and demand='$demanda' and hora='$hora' and projecte='$projecte'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
                return $row;
			}

		}

	public static function getdadesdistribuciodiariamesdemanda($distribucio,$demanda,$mes,$hora)
		{
		$i=1;
		$query = "select valor from tipus_distribucio,distribucions_diaries where tipus_distribucio.id_distribucio=distribucions_diaries.idDistribucio_diaria and nom_distribucio='$distribucio' and mes='$mes' and demand='$demanda' and hora='$hora'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$row="";
    			return $row;
			}
		else{
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
                return $row;
			}

		}	


	public static function getunitat($distribucio)
		{
		$i=1;
		$query = "select unitat_distribucio from tipus_distribucio where nom_distribucio='$distribucio'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		mysql_free_result($result);
                return $aux;
		}
	public static function getquantitat($distribucio)
		{
		//buscar que tipo de distribucion es. Tiene que ser de frecuencia 1 y para cada ID de la 4 a la 7 darle un tipo
		$i=1;
		$query = "select id_distribucio from tipus_distribucio where nom_distribucio='$distribucio' and tipo='1'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		mysql_free_result($result);
		
		if($aux==4){$aux2="heatingdemand";}
		if($aux==5){$aux2="hotwaterdemand";}
		if($aux==6){$aux2="coolingdemand";}
		if($aux==7){$aux2="electricappdemand";}
		$i=1;
		if($aux!=""){
		$query = "select '$aux2' from projectedemandes,projects where nomproject=projecte and actual=1  ";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		mysql_free_result($result);
		}
		else {$aux=0;}
                return $aux;

		}
		
	public static function getquantitatdetalls($distribucio,$localitat)
		{
		$i=1;
		$query = "select tipus_distribucio_detalls.quantitat from tipus_distribucio,tipus_distribucio_detalls where tipus_distribucio.id_distribucio=tipus_distribucio_detalls.id_distribucio and nom_distribucio='$distribucio' and localitat='$localitat'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		mysql_free_result($result);
                return $aux;

		}

	public static function getquantitatvivendes($distribucio)
		{
		$i=1;
		$query = "select quantitat_vivendes from tipus_distribucio where nom_distribucio='$distribucio'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		mysql_free_result($result);
                return $aux;

		}
	
	public static function getquantitatvivendesdetalls($distribucio,$localitat)
		{
		$i=1;
		$query = "select tipus_distribucio_detalls.quantitat_vivendes from tipus_distribucio,tipus_distribucio_detalls where tipus_distribucio.id_distribucio=tipus_distribucio_detalls.id_distribucio and nom_distribucio='$distribucio' and localitat='$localitat'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		mysql_free_result($result);
                return $aux;

		}

	public static function gettipo($distribucio)
		{
		$i=1;
		$query = "select tipo from tipus_distribucio where nom_distribucio='$distribucio'";
		
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		mysql_free_result($result);
                return $aux;

		}
	public static function gettipoporid($distribucio)
		{
		$i=1;
		$query = "select tipo from tipus_distribucio where id_distribucio='$distribucio'";
		
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		mysql_free_result($result);
                return $aux;

		}

	public static function addtipofrecuencia($distribucio,$unitat)
		{
		
		$query="select max(id_distribucio) from tipus_distribucio";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if($result!=null){
		$i=$result+1;}
		else {$i=1;}
		mysql_free_result($result);
		
		$query="insert into tipus_distribucio (nom_distribucio,id_distribucio,unitat_distribucio) VALUES ('$distribucio','$i','$unitat')";
		
		
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		mysql_free_result($result);
		
		}
	
	public static function calcularfrecuenciatotal($iddistribucio)
		{
			
		if($iddistribucio!=0){				
			for($i=1;$i<=12;$i++){
				//Buscar valormes
				//$valormes=CalcularValorMes($iddistribucio,$i);
					
					$query = "select valor from distribucions_anuals where idDistribucio_anual='$iddistribucio' and mes='$i'";
					$result1=mysql_query($query,gestio_projectesBBDD::$dbconn);
					$row=mysql_fetch_row($result1);
					$valormes=$row[0];
					mysql_free_result($result1);	
					
				for($j=1;$j<=24;$j++){
					//Buscar valordia
					//$valordia=CalcularValorDia($iddistribucio,$j);
					$query = "select valor from distribucions_diaries where idDistribucio_diaria='$iddistribucio' and hora='$j'";
					$result2=mysql_query($query,gestio_projectesBBDD::$dbconn);
					$row=mysql_fetch_row($result2);
					$valordia=$row[0];	
					mysql_free_result($result2);
		
					$valor=$valordia*$valormes;
					$query="insert into distribucio_anual_diaria (id_distribucio,hora,mes,valor) VALUES ('$iddistribucio','$j','$i','$valor')";
					$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
					//mysql_free_result($result);					

					}
				}
			
			//$query="insert into distribucions_diaries (idDistribucio_diaria,hora,valor) VALUES ('$iddistribucio','$i','$valors[$j]')";
			//$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			//mysql_free_result($result);
			}
		}

	public static function ajustpercentatges($array,$num)
		{
		$sum=0;
		for($i=0;$i<$num;$i++)
			{$sum=$array[$i]+$sum;}
		$valor=100/$sum;
		for($i=0;$i<$num;$i++)
			{
			$row[$i]=$valor*$array[$i];}
		return $row;


		}
	
	public static function ajustpercentatgesmes($array,$num)
		{
		$sum=0;
		for($i=1;$i<=$num;$i++)
			{$sum=$array[$i]+$sum;}
		$valor=100/$sum;
		for($i=1;$i<=$num;$i++)
			{
			$row[$i]=$valor*$array[$i];}
		return $row;


		}


	public static function checkdistanuallocalitat($tipodis,$projecte,$localitat)
		{	
		
		$i=1;
		$query = "SELECT count(*) as count FROM distribucions_anuals_projectes WHERE idDistribucio_anual='$tipusdis' and projecte='$projecte' and localitat='$localitat' ";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		mysql_free_result($result);
                return $aux;

		}

	public static function checkdistdiarialocalitat($tipodis,$projecte,$localitat,$mes)
		{	
		
		$i=1;
		$query = "SELECT count(*) as count FROM distribucions_diaries_projectes WHERE mes='$mes' and idDistribucio_diaria='$tipusdis' and projecte='$projecte' and localitat='$localitat' ";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		mysql_free_result($result);
                return $aux;

		}

	public static function checkdistanualdemanda($tipodis,$projecte,$demanda)
		{	
		
		$i=1;
		$query = "SELECT count(*) as count FROM distribucions_anuals_projectes WHERE idDistribucio_anual='$tipusdis' and projecte='$projecte' and demand='$demanda' ";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		mysql_free_result($result);
                return $aux;

		}

	public static function checkdistdiariademanda($tipodis,$projecte,$demanda,$mes)
		{	
		
		$i=1;
		$query = "SELECT count(*) as count FROM distribucions_diaries_projectes WHERE mes='$mes' and idDistribucio_diaria='$tipusdis' and projecte='$projecte' and demand='$demanda' ";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		mysql_free_result($result);
        return $aux;

		}

	public static function checkdistribucioanualprojecterad($projecte,$mes)
		{
		$i=1;
		$query="SELECT count(*) FROM distribucions_anuals_projectes WHERE idDistribucio_anual=1 and projecte='".$projecte."' and mes=$mes"; 
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		mysql_free_result($result);
        return $aux;
		}
	
	public static function checkdistribucioanualprojecteradref($localitat,$mes)
		{
		$i=1;
		$query="SELECT count(*) FROM distribucions_anuals WHERE idDistribucio_anual=1 and localitat='".$localitat."' and mes=$mes"; 
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		mysql_free_result($result);
        return $aux;
		}
	
	public static function getdistribucioanualprojectesrad ($projecte,$mes)
		{
		$i=1;
		$query="SELECT valor FROM distribucions_anuals_projectes WHERE idDistribucio_anual=1 and projecte='".$projecte."' and mes=$mes"; 
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		mysql_free_result($result);
        return $aux;
		
		}
	
	public static function actualizarvalormes($iddistribucio,$localitat,$projecte,$mes,$valor)
		{
		
		$query="UPDATE distribucions_anuals_projectes SET valor=$valor WHERE idDistribucio_anual=".$iddistribucio." and mes=".$mes." and projecte='".$projecte."' and localitat='".$localitat."' ";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		return "";
		
		}
		
	public static function actualizarvalorhorasmes($iddistribucio,$localitat,$projecte,$mes,$k)
		{
		
			
			$query="UPDATE distribucions_diaries_projectes SET valor=valor*$k WHERE idDistribucio_diaria=".$iddistribucio." and mes=".$mes." and projecte='".$projecte."' and localitat='".$localitat."' ";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			//echo "<br>$query";
		
		return "";
		
		
		}
		
	public static function summensualref($iddistribucio,$localitat,$mes)
		{
		$i=0;
		$query="SELECT sum(valor) FROM distribucions_diaries WHERE localitat='".$localitat."' and idDistribucio_diaria=".$iddistribucio." and mes=".$mes;
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		mysql_free_result($result);
			if($mes==1){$aux=$aux*31;}
			if($mes==2){$aux=$aux*28;}
			if($mes==3){$aux=$aux*31;}
			if($mes==4){$aux=$aux*30;}
			if($mes==5){$aux=$aux*31;}
			if($mes==6){$aux=$aux*30;}
			if($mes==7){$aux=$aux*31;}
			if($mes==8){$aux=$aux*31;}
			if($mes==9){$aux=$aux*30;}
			if($mes==10){$aux=$aux*31;}
			if($mes==11){$aux=$aux*30;}
			if($mes==12){$aux=$aux*31;}
		return $aux;
		
		}
	
	public static function medmensualref($iddistribucio,$localitat,$mes)
		{
		$i=0;
		$query="SELECT avg(valor) FROM distribucions_diaries WHERE localitat='".$localitat."' and idDistribucio_diaria=".$iddistribucio." and mes=".$mes;
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		$aux=$row[0];
		return $aux;
		
		}
		
	public static function insertmensualref($iddistribucio,$localitat,$mes,$valor)
		{
		//mirar si existe entonces update, de lo contrario insert
		$i=1;
		$query="SELECT count(*) FROM distribucions_anuals WHERE idDistribucio_anual=".$iddistribucio." and mes=$mes and localitat='".$localitat."' " ; 
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row=mysql_fetch_row($result);
		if ($row[0]>0){$query="UPDATE distribucions_anuals SET valor=$valor WHERE localitat='".$localitat."' and mes=$mes and idDistribucio_anual=$iddistribucio";}
		else{
		$query="INSERT INTO distribucions_anuals(idDistribucio_anual, mes, valor, localitat) VALUES (".$iddistribucio.",".$mes.",".$valor.",'".$localitat."')";
		}
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);

		}
	
	}
?>
