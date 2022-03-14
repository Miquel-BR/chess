<?php
require_once("gestio_projectesBBDD.php");
require_once('class/distribuciofrecuencies.php');
require_once('class/projectes.php');

class resultats {

public static function prepararDT($projecte)
	{
	$i=1;

	$query = "select * from results_dt where projecte='$projecte'";
	$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
	while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
	mysqli_free_result($result);
	$num=count($row);
	if($num>0)
		{
		$query2="DELETE FROM results_dt WHERE projecte='$projecte' ";
		$result2=mysqli_query(gestio_projectesBBDD::$dbconn, $query2);
		}

	//return $aux;

	}

public static function insertar($projecte,$ii,$hora,$dia,$mes,$year2,$aux1,$aux2,$aux3,$aux4,$aux5,$aux6,$aux7,$aux8,$aux9,$aux10,$aux11,$aux12,$aux13,$aux14,$aux15,$aux16,$aux17,$aux18,$aux19,$aux20,$aux21,$aux22,$aux23,$aux24,$aux25,$aux26,$aux27,$aux28,$aux29,$aux36,$aux37,$aux38,$aux39,$aux42,$aux43,$aux44)
	{
	$query="INSERT INTO resultats(projecte,horabruta,hora,dia,mes,year,DT,mdt,Tdts,Tdte,Pdistr,Ta1s,Ta1e,Ta1i,Ta1i1,Ta1,Tst1s,Tst1e,mst1,Qa1,Pa1,Ta2i,Ta2i1,Ta2,Tst2s,Tst2e,mst2,Qa2,Pa2,Rad,Irr,Text,mst,Tsts,Tste,Tcol,Rend,Est,Ps,Ee,COP,Qaux) VALUES ('$projecte',$ii,$hora,$dia,$mes,$year2,$aux1,$aux2,$aux3,$aux4,$aux5,$aux6,$aux7,$aux8,$aux9,$aux10,$aux11,$aux12,$aux13,$aux14,$aux15,$aux16,$aux17,$aux18,$aux19,$aux20,$aux21,$aux22,$aux23,$aux24,$aux25,$aux26,$aux27,$aux28,$aux29,$aux36,$aux37,$aux38,$aux39,$aux42,$aux43,$aux44)";
	$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);


	}

public static function creararchivoDT($nomarchivoDT)
	{
	$fp=fopen($nomarchivoDT,"w");
	//fputs($fp,"C:/wamp/wwww/Archivo datos DT".PHP_EOL);
	fclose($fp);
	}

public static function escribirañadirDT($nomarchivoDT,$linea)
	{
	$fp=fopen($nomarchivoDT,"a");
	fputs($fp,$linea.PHP_EOL);
	fclose($fp);
	}

public static function comprobararchivo($projecte)
	{
	$nomfile=$projecte.".txt";
	if (file_exists($nomfile)){return 1;}
	else {return 0;}
	}


public static function leerarchivotemps($nomarchivo)
	{


	$filas=file($nomarchivo);

	$i=0;
	$numero_fila=0;
	$arrayTemp = array("numhora","hora","dia","mes","year","Ta1","Ta2");
	while($filas[$i]!=NULL && $i<=17519){
		$row = $filas[$i];
		$sql = explode("|",$row);

		$arrayTemp[$i]=array("numhora"=>$i,"hora"=>$sql[1],"dia"=>$sql[2],"mes"=>$sql[3],"year"=>$sql[4],"Ta1"=>$sql[14],"Ta2"=>$sql[22]);
		$i++; $numero_fila++;
		}
	return $arrayTemp;

	}

public static function leerarchivoenergy($nomarchivo)
	{


	$filas=file($nomarchivo);

	$i=0;
	$numero_fila=0;
	$arrayTemp = array("numhora","hora","dia","mes","year","mdt","Ta1s","Ta1e","Ta1i","Ta1i1","Ta1","Tst1s","Tst1e","mst1","Ta2","mst1","mst2","Est","Qa1","Qa2","DT","Pdistr","Qaux","Pa1","Pa2","Ps","Ee","BalanceDT","BalanceST1","BalanceST2","BalanceDep1","BalanceDep2");
	while($filas[$i]!=NULL && $i<=17519){
		$row = $filas[$i];
		$sql = explode("|",$row);

		$arrayTemp[$i]=array("numhora"=>$i,"hora"=>$sql[1],"dia"=>$sql[2],"mes"=>$sql[3],"year"=>$sql[4],"mdt"=>$sql[6],"Ta1s"=>$sql[10],"Ta1e"=>$sql[11],"Ta1i"=>$sql[12],"Ta1i1"=>$sql[13],"Ta1"=>$sql[14],"Tst1s"=>$sql[15],"Tst1e"=>$sql[16],"mst1"=>$sql[19],"Ta2"=>$sql[22],"mst1"=>$sql[17],"mst2"=>$sql[25],"Est"=>$sql[36],"Qa1"=>$sql[18],"Qa2"=>$sql[26],"DT"=>$sql[5],"Pdistr"=>$sql[9],"Qaux"=>$sql[40],"Pa1"=>$sql[19],"Pa2"=>$sql[27],"Ps"=>$sql[37],"Ee"=>$sql[38],"BalanceDT"=>$sql[41],"BalanceST1"=>$sql[42],"BalanceST2"=>$sql[43],"BalanceDep1"=>$sql[44],"BalanceDep2"=>$sql[45]);
		$i++; $numero_fila++;
		}
	return $arrayTemp;

	}

}

?>
