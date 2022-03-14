<?php
require_once("gestio_projectesBBDD.php");

class usuari {

    private $db;

    public function __construct() {
        $this->db = gestio_projectesBBDD::$dbconn;
    }


    public static function add($iduser,$identificador,$password,$nom,$cognom1,$cognom2,$cost_hora,$correu,$rol,$actiu,$hores_set,$hores_set_estiu,$datalaboral,$historic) {
		//$uuid=gestio_projectesBBDD::createUuid();
		$identificador=htmlspecialchars($identificador,ENT_QUOTES);
		$nom=htmlspecialchars($nom,ENT_QUOTES);
		$cognom1=htmlspecialchars($cognom1,ENT_QUOTES);
		$cognom2=htmlspecialchars($cognom2,ENT_QUOTES);
		$foto=$iduser.".image";
		$password=sha1($password);
		$query = "insert into usuari (
				idUsuari,
				nom,
				password,
				actiu,
				historic,
				foto,
				data_inici_laboral,
				identificador,
				cognom_1,
				cognom_2,
				cost_hora,
				correu,
				rol,
				hores_setmanals,
				hores_setmanals_estiu)
				VALUES (
				'$iduser',
				'$nom',
				'$password',
				$actiu,
				$historic,
				'$foto',
				'$datalaboral',
				'$identificador',
				'$cognom1',
				'$cognom2',
				$cost_hora,
				'$correu',
				'$rol',
				$hores_set,
				$hores_set_estiu)";
			$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
			if (!$result) {
				$message  = 'Error en query: ' . mysqli_error() . "\n";
				$message .= 'Query: ' . $query;
				die("Error a l'insertar usuari. Suggerencia: Segurament aquest usuari ja existeix.");
			}
			// en aquest punt només arribem si s'ha creat l'usuari, llavors creem el cv
			$uuidcv=gestio_projectesBBDD::createUuid();
			$query = "insert into cv (idCv) VALUES ('$uuidcv')";
			$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
			// afegim l'idcv a la taula d'usuaris
			if ($result) {
				$query = "update usuari set cv_idCv='$uuidcv' where idUsuari='$iduser'";
				$result_user=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
			}
	}

	public static function updateuser($iduser,$identificador,$nom,$cognom1,$cognom2,$cost_hora,$correu,$rol,$actiu,$hores_set,$hores_set_estiu,$datalaboral,$historic) {
		//$uuid=gestio_projectesBBDD::createUuid();
		$identificador=htmlspecialchars($identificador,ENT_QUOTES);
		$nom=htmlspecialchars($nom,ENT_QUOTES);
		$cognom1=htmlspecialchars($cognom1,ENT_QUOTES);
		$cognom2=htmlspecialchars($cognom2,ENT_QUOTES);
		$foto=$iduser.".image";
		$query = "update usuari set 
				nom='$nom',
				actiu=$actiu,
				historic=$historic,
				foto='$foto',
				data_inici_laboral='$datalaboral',
				identificador='$identificador',
				cognom_1='$cognom1',
				cognom_2='$cognom2',
				cost_hora=$cost_hora,
				correu='$correu',
				rol='$rol',
				hores_setmanals=$hores_set,
				hores_setmanals_estiu=$hores_set_estiu
				where idUsuari='$iduser'";
			$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
			if (!$result) {
				$message  = 'Error en query: ' . mysqli_error() . "\n";
				$message .= 'Query: ' . $query;
				die($message);
			}
	}

	public static function updatepassword($iduser,$password) {
		$password=sha1($password);
		$query = "update usuari set 
				password='$password'
				where idUsuari='$iduser'";
			$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
			if (!$result) {
				$message  = 'Error en query: ' . mysqli_error() . "\n";
				$message .= 'Query: ' . $query;
				die($message);
			}
	}

	public static function getall() {
		$i=0;
		//$query = "select * from usuari where historic=0 order by identificador";
		$query = "select * from usuari order by identificador";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
		mysqli_free_result($result);
		return $row;
	}

	public static function getadmins() {
		$i=0;
		$query = "select * from usuari where rol='Administrador'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
		mysqli_free_result($result);
		return $row;
	}

	public static function getallactive() {
		$i=0;
		$query = "select * from usuari where actiu=1 order by identificador";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
		mysqli_free_result($result);
		return $row;
	}

	public static function getallhistoric() {
		$i=0;
		$query = "select * from usuari where historic=1 order by identificador";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		while ($row[$i] = mysqli_fetch_assoc($result)) { $i++; }
		mysqli_free_result($result);
		return $row;
	}

	public static function totalusers() {
		//$query = "select * from usuari where historic=0";
		$query = "select * from usuari";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}

	public static function totaladmins() {
		$query = "select * from usuari where rol='Administrador'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}

	public static function isadmin($user) {
		$query = "select * from usuari  where identificador='$user' and tipousuari=1";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}

	public static function totalactiveusers() {
		$query = "select * from usuari where actiu=1";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}

	public static function totalhistoricusers() {
		$query = "select * from usuari where historic=1";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}

	public static function validate($user,$password) {
		//$password=sha1($password);
		$query = "select * from usuari where identificador='$user' and password='$password' and actiu=1";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$numero = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $numero;
	}

	public static function getuser($identificador) {
		$query = "select * from usuari where idUsuari='$identificador'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$row = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $row;
	}

	public static function getuserbyidentificador($identificador) {
		$query = "select * from usuari where identificador='$identificador'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$row = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $row;
	}

	public static function delete($uuid) {
		$query = "DELETE FROM usuari where idUsuari='$uuid'";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		if (!$result) {
			$message  = 'Error en query: ' . mysqli_error() . "\n";
			$message .= 'Query: ' . $query;
			return $message;
		}
	}

	public static function getmaxid() {
		$query = "select max(idusuari) as maximo from usuari ";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$row = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $row['maximo'];
	}

	public static function gettipousuari($usuari) {
		$query = "select tipousuari from usuari where nom='$usuari' ";
		$result=mysqli_query(gestio_projectesBBDD::$dbconn, $query);
		$row = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $row['tipousuari'];


	}

}
?>
