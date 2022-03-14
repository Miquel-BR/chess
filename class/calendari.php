<?php
require_once("gestio_projectesBBDD.php");
require_once("usuari.php");

class calendari {
	public static function addblockedday($data) {
		$query = "insert into dies_bloquejats_general (
				data)
				VALUES (
				'$data')";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			if (!$result) {
				$message  = 'Error en query: ' . mysql_error() . "\n";
				$message .= 'Query: ' . $query;
				die($message);
			}
	}
	
	public static function addblockeddaybyuser($data,$iduser,$motiu) {
		$query = "insert into dies_bloquejats_usuari (
				data,
				motiu,
				Usuari_idUsuari)
				VALUES (
				'$data',
				'$motiu',
				'$iduser')";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			if (!$result) {
				$message  = 'Error en query: ' . mysql_error() . "\n";
				$message .= 'Query: ' . $query;
				die($message);
			}
	}
	
	
	public static function getallblocked() {
		$i=0;
		$query = "select * from dies_bloquejats_general";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
		return $row;
	}
	
	public static function isblockedday($user,$data) {
		$query = "select * from dies_bloquejats_general where data='$data' ";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$numero = mysql_num_rows($result);
		mysql_free_result($result);
		$query = "select * from dies_bloquejats_usuari where Usuari_idUsuari='$user' and data='$data'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$numero = $numero + mysql_num_rows($result);
		mysql_free_result($result);
		return $numero;
	}
	
	public static function isblockedday_general($data) {
		$query = "select * from dies_bloquejats_general where data='$data' ";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$numero = mysql_num_rows($result);
		mysql_free_result($result);
		return $numero;
	}
	
	public static function isblockedday_user($user,$data) {	
		$query = "select * from dies_bloquejats_usuari where Usuari_idUsuari='$user' and data='$data'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);
		return $row['motiu'];
	}
	
	public static function getallblockedbyuser($user) {
		$i=0;
		$query = "select * from dies_bloquejats_usuari where Usuari_idUsuari='$user'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		while ($row[$i] = mysql_fetch_assoc($result)) { $i++; }
		mysql_free_result($result);
		return $row;
	}
	
	public static function totalblockeddays() {
		$query = "select * from dies_bloquejats_general";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$numero = mysql_num_rows($result);
		mysql_free_result($result);
		return $numero;
	}
	
	public static function totalblockeddaysbyuser($usuari) {
		$query = "select * from dies_bloquejats_usuari where Usuari_idUsuari='$usuari'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$numero = mysql_num_rows($result);
		mysql_free_result($result);
		return $numero;
	}
	
	public static function totalblockeddaysbaixabyuser($usuari,$any) {
		$data_inici=$any."-01-01";
		$data_fi=$any."-12-31";
		$query = "select * from dies_bloquejats_usuari where Usuari_idUsuari='$usuari' and motiu='baixa' and data between '$data_inici' and '$data_fi'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$numero = mysql_num_rows($result);
		mysql_free_result($result);
		return $numero;
	}
	
	public static function totalblockeddayspropisbyuser($usuari,$any) {
		$data_inici=$any."-01-01";
		$data_fi=$any."-12-31";
		$query = "select * from dies_bloquejats_usuari where Usuari_idUsuari='$usuari' and motiu='dia propi' and data between '$data_inici' and '$data_fi'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$numero = mysql_num_rows($result);
		mysql_free_result($result);
		return $numero;
	}
	
	public static function totalblockeddayspermisbyuser($usuari,$any) {
		$data_inici=$any."-01-01";
		$data_fi=$any."-12-31";
		$query = "select * from dies_bloquejats_usuari where Usuari_idUsuari='$usuari' and motiu='dia permis' and data between '$data_inici' and '$data_fi'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$numero = mysql_num_rows($result);
		mysql_free_result($result);
		return $numero;
	}
	
	public static function totalblockeddaysmaternitatbyuser($usuari,$any) {
		$data_inici=$any."-01-01";
		$data_fi=$any."-12-31";
		$query = "select * from dies_bloquejats_usuari where Usuari_idUsuari='$usuari' and motiu='maternitat-paternitat' and data between '$data_inici' and '$data_fi'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$numero = mysql_num_rows($result);
		mysql_free_result($result);
		return $numero;
	}
	
	public static function deleteblockedday($data) {
		$query = "DELETE FROM dies_bloquejats_general where data='$data'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$message  = 'Error en query: ' . mysql_error() . "\n";
			$message .= 'Query: ' . $query;
			return $message;
		}
	}
	
	public static function deleteblockeddaybyuser($data,$user) {
		$query = "DELETE FROM dies_bloquejats_usuari where data='$data' and Usuari_idUsuari='$user'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$message  = 'Error en query: ' . mysql_error() . "\n";
			$message .= 'Query: ' . $query;
			return $message;
		}
	}
	
	public static function getsummerperiod() {
		$query = "select * from periode_estiu";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);
		return $row;
	}
	
	public static function gethoursfromuserbyperiod($userid,$data) {
		// hores setmanales programades (fiexes) de l'usuari si es estiu o no
		$estiu=self::getsummerperiod();
		$data = strtotime($data);
		$datainici = strtotime($estiu['data_inici']);
		$datafi = strtotime($estiu['data_fi']);
		$usuari=usuari::getuser($userid);
		if ($data >= $datainici && $data <= $datafi) {
			return $usuari['hores_setmanals_estiu'];
		} else {
			return $usuari['hores_setmanals'];
		}
	}
	
	public static function nextworkingday($userid,$data) {
		$daynum=0;
		// saltem al dia seguent
		$data = strtotime($data);
		$data=$data+86400;
		$data=date("Y/m/d",$data);
		while (self::isblockedday_general($data) || calendari::isblockedday_user($userid,$data) || $daynum>365) { // mentre no trobi un dia laborable o no passi un any
			$data = strtotime($data);
			$data=$data+86400;
			$data=date("Y/m/d",$data);
			$daynum++;
		}
	return $data;
	}
	
	public static function prevworkingday($userid,$data) {
		$daynum=0;
		// saltem al dia seguent
		$data = strtotime($data);
		$data=$data-86400;
		$data=date("Y/m/d",$data);
		while (self::isblockedday_general($data) || calendari::isblockedday_user($userid,$data) || $daynum>365) { // mentre no trobi un dia laborable o no passi un any
			$data = strtotime($data);
			$data=$data-86400;
			$data=date("Y/m/d",$data);
			$daynum++;
		}
	return $data;
		
	}
	
	public static function addsummerperiod($datainici,$datafi) {
		$query = "update periode_estiu set
				data_inici='$datainici',
				data_fi='$datafi'";
		$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
		if (!$result) {
			$message  = 'Error en query: ' . mysql_error() . "\n";
			$message .= 'Query: ' . $query;
			die($message);
		}
	}
	
}
?>