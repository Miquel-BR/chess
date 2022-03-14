<?php
require_once("gestio_projectesBBDD.php");
require_once("usuari.php");
require_once("calendari.php");

class parte {
	public static function add($idusuari,$idtasca,$data,$hores,$descripcio) {
		$descripcio=htmlspecialchars($descripcio,ENT_QUOTES);
		$query = "insert into hores_tasca (
				Usuari_idUsuari,
				tasca_idtasca,
				data,
				hores_reals,
				descripcio,
				validat)
				VALUES (
				'$idusuari',
				'$idtasca',
				'$data',
				$hores,
				'$descripcio',
				0)";
			$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
			if (!$result) {
				$message  = 'Error en query: ' . mysqli_error() . "\n";
				$message .= 'Query: ' . $query;
				die($message);
			}
	}

	public static function validate($tasca,$user,$data) {
		$query = "update hores_tasca set
				validat=1
				where Usuari_idUsuari='$user' and tasca_idtasca='$tasca' and data='$data'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		if (!$result) {
			$message  = 'Error en query: ' . mysqli_error() . "\n";
			$message .= 'Query: ' . $query;
			die($message);
		}
	}

	public static function massivevalidate($data) {
		$query = "update hores_tasca set
				validat=1
				where data <= '$data'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		if (!$result) {
			$message  = 'Error en query: ' . mysqli_error() . "\n";
			$message .= 'Query: ' . $query;
			die($message);
		}
	}

	public static function invalidate($tasca,$user,$data) {
		$query = "update hores_tasca set
				validat=0
				where Usuari_idUsuari='$user' and tasca_idtasca='$tasca' and data='$data'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		if (!$result) {
			$message  = 'Error en query: ' . mysqli_error() . "\n";
			$message .= 'Query: ' . $query;
			die($message);
		}
	}

	public static function massiveinvalidate($data) {
		$query = "update hores_tasca set
				validat=0
				where data <= '$data'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		if (!$result) {
			$message  = 'Error en query: ' . mysqli_error() . "\n";
			$message .= 'Query: ' . $query;
			die($message);
		}
	}

	public static function getall() {
		$i=0;
		$query = "select * from hores_tasca";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
		mysqli_free_result($result);
		return $row;
	}

	public static function getallbyuser($user) {
		$i=0;
		$query = "select * from hores_tasca where Usuari_idUsuari='$user'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
		mysqli_free_result($result);
		return $row;
	}

	public static function getallpendingbyuser($user) {
		$i=0;
		$query = "select * from hores_tasca where Usuari_idUsuari='$user' and validat=0 order by data ASC";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
		mysqli_free_result($result);
		return $row;
	}

	public static function getallpendingbytask($tasca) {
		$i=0;
		$query = "select * from hores_tasca where tasca_idtasca='$tasca' and validat=0 order by data ASC";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
		mysqli_free_result($result);
		return $row;
	}

	public static function getallvalidatedbyuser($user) {
		$i=0;
		$query = "select * from hores_tasca where Usuari_idUsuari='$user' and validat=1";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
		mysqli_free_result($result);
		return $row;
	}

	public static function getallvalidatedbytask($tasca) {
		$i=0;
		$query = "select * from hores_tasca where tasca_idtasca='$tasca' and validat=1";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
		mysqli_free_result($result);
		return $row;
	}

	public static function gethoursbydatetaskuser($user,$tasca,$data) {
		$query = "select * from hores_tasca where Usuari_idUsuari='$user' and tasca_idtasca='$tasca' and data='$data'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$row = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $row;
	}

	public static function gethoursbetweendates($user,$datainici,$datafi) {
		$i=0;
		$hores=0;
		$query = "select * from hores_tasca where Usuari_idUsuari='$user' and data between '$datainici' and '$datafi'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) {
			$hores=$hores+$row[$i]['hores_reals'];
			$i++;
		}
		mysqli_free_result($result);
		return $hores;
	}

	public static function getallbyuseranday($user,$data) {
		$i=0;
		$query = "select * from hores_tasca where Usuari_idUsuari='$user' and data='$data'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
		mysqli_free_result($result);
		return $row;
	}

	public static function getallbytask($tasca) {
		$i=0;
		$query = "select * from hores_tasca where tasca_idtasca='$tasca'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
		mysqli_free_result($result);
		return $row;
	}

	public static function totaltasks() {
		$query = "select * from hores_tasca";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}

	public static function totalbyuser($user) {
		$query = "select * from hores_tasca where Usuari_idUsuari='$user'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}

	public static function totalpendingbyuser($user) {
		$query = "select * from hores_tasca where Usuari_idUsuari='$user' and validat=0";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}

	public static function totaluserswithspendinghours() {
		$query = "select distinct Usuari_idUsuari from hores_tasca where validat=0";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}

	public static function totaltaskswithspendinghours() {
		$query = "select distinct tasca_idtasca from hores_tasca where validat=0";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}

	public static function totalpendingbytask($tasca) {
		$query = "select * from hores_tasca where tasca_idtasca='$tasca' and validat=0";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}

	public static function totalvalidatedbyuser($user) {
		$query = "select * from hores_tasca where Usuari_idUsuari='$user' and validat=1";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}



	public static function totalvalidatedbytask($tasca) {
		$query = "select * from hores_tasca where tasca_idtasca='$tasca' and validat=1";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}

	public static function totalbyuserandday($user,$data) {
		$query = "select * from hores_tasca where Usuari_idUsuari='$user' and data='$data'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}

	public static function totalbytask($tasca) {
		$query = "select * from hores_tasca where tasca_idtasca='$tasca'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}


	public static function delete($user,$tasca,$data) {
		$query = "DELETE FROM hores_tasca where tasca_idtasca='$tasca' and Usuari_idUsuari='$user' and data='$data' and validat=0";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		if (!$result) {
			$message  = 'Error en query: ' . mysqli_error() . "\n";
			$message .= 'Query: ' . $query;
			return $message;
		}
	}

	public static function updatejob($user,$tasca,$data,$hores,$descripcio) {
		$descripcio=htmlspecialchars($descripcio,ENT_QUOTES);
		$query = "update hores_tasca set
				hores_reals='$hores',
				descripcio='$descripcio'
				where Usuari_idUsuari='$user' and tasca_idtasca='$tasca' and data='$data' and validat=0";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		if (!$result) {
			$message  = 'Error en query: ' . mysqli_error() . "\n";
			$message .= 'Query: ' . $query;
			return $message;
		}
	}

	public static function getuserhoursbytask($tasca,$iduser) {
		$i=0;
		$dedicacio_total=0;
		$query= "select * from hores_tasca where tasca_idtasca='$tasca' and Usuari_idUsuari='$iduser'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) {
			$dedicacio_total=$dedicacio_total+$row[$i]['hores_reals'];
			$i++;
		}
		return $dedicacio_total;
	}

	public static function getuserhoursbytaskbetweendates($tasca,$iduser,$datainici,$datafi) {
		$i=0;
		$dedicacio_total=0;
		$query= "select * from hores_tasca where tasca_idtasca='$tasca' and Usuari_idUsuari='$iduser' and data between '$datainici' and '$datafi'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) {
			$dedicacio_total=$dedicacio_total+$row[$i]['hores_reals'];
			$i++;
		}
		return $dedicacio_total;
	}

	public static function gettasksinfobetweendates($tasca,$iduser,$datainici,$datafi) {
		$i=0;
		$query= "select * from hores_tasca where tasca_idtasca='$tasca' and Usuari_idUsuari='$iduser' and data between '$datainici' and '$datafi'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
		mysqli_free_result($result);
		return $row;
	}

	public static function getuserhoursbyday($data,$iduser) {
		$i=0;
		$dedicacio_total=0;
		$query= "select * from hores_tasca where data='$data' and Usuari_idUsuari='$iduser'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) {
			$dedicacio_total=$dedicacio_total+$row[$i]['hores_reals'];
			$i++;
		}
		return $dedicacio_total;
	}

	public static function getworkeddays($iduser) {
		$i=0;
		$query = "select distinct data from hores_tasca where Usuari_idUsuari='$iduser'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
		mysqli_free_result($result);
		return $row;
	}

	public static function numberofdaysworkedbyuser($iduser) {
		$query = "select distinct data from hores_tasca where Usuari_idUsuari='$iduser'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}

	public static function numberofhourstovalidatebyuser($iduser) {
		$i=0;
		$hores=0;
		$query= "select * from hores_tasca where Usuari_idUsuari='$iduser' and validat=0";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) {
			$hores=$hores+$row[$i]['hores_reals'];
			$i++;
		}
		return $hores;
	}

	public static function numberofhoursvalidatedbyuser($iduser) {
		$i=0;
		$hores=0;
		$query= "select * from hores_tasca where Usuari_idUsuari='$iduser' and validat=1";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) {
			$hores=$hores+$row[$i]['hores_reals'];
			$i++;
		}
		return $hores;
	}

	public static function numberofhourstovalidatebytask($tasca) {
		$i=0;
		$hores=0;
		$query= "select * from hores_tasca where tasca_idtasca='$tasca' and validat=0";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) {
			$hores=$hores+$row[$i]['hores_reals'];
			$i++;
		}
		return $hores;
	}

	public static function numberofhoursvalidatedbytask($tasca) {
		$i=0;
		$hores=0;
		$query= "select * from hores_tasca where tasca_idtasca='$tasca' and validat=1";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) {
			$hores=$hores+$row[$i]['hores_reals'];
			$i++;
		}
		return $hores;
	}

	public static function totaldayspending() {
		$taulausuaris=usuari::getall();
		$i=0;
		$totalhores=0;
		while ($i<usuari::totalusers()) {
			$totalhores=$totalhores+self::dayspending($taulausuaris[$i]['idUsuari']);
			$i++;
		}
		return $totalhores;
	}

	public static function dayspending($user) {
		$partespendents=0;
		$usuari=usuari::getuser($user);
		$datainiciusuari=strtotime($usuari['data_inici_laboral']);
		$datainicifuncionament=strtotime("2014-01-01");
		if ($datainiciusuari>$datainicifuncionament) { $datainici=$datainiciusuari; } else { $datainici=$datainicifuncionament; }
		$dataactual=time();
		while ($datainici<=$dataactual) {
			$datainici_formatejada=date('Y-m-d',$datainici);
			if (calendari::isblockedday($user,$datainici_formatejada)==0 && self::totalbyuserandday($user,$datainici_formatejada)==0) {
				$partespendents=$partespendents+1;
			}
			// sumem un dia
			$datainici=$datainici+86400;
		}
		return $partespendents;
	}


	public static function omplirCalendari($usuari,$data) {
		// Aquesta funcio ja esta implementada a calendari, igualment, per poder 'compartimentar' el millor es fer les queries en funcions separades, no es obligatori, pero en general, recomanable.
		if (calendari::isblockedday_general($data)) {
			return "Dia bloquejat";
			// No cal que continuem, retornem sense fer mes queries
		}
		// fem el mateix per els dies bloquejats de l'usuari
		$motiu=calendari::isblockedday_user($usuari,$data);
		if ($motiu) {
			return $motiu;
			// No cal que continuem, retornem sense fer mes queries
		}
		// La query no ha de tenir el condicional de validat=1, i podem utilitzar la funcio ja feta, que retorna 0 hores en cas de no trobar cap entrada
		$hores=parte::getuserhoursbyday($data,$usuari);
		return $hores." hores";
	}

}
?>
