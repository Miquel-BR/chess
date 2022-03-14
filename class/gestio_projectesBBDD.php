<?php

class gestio_projectesBBDD {
	public static $dbconn;
	public static function setup() {

		self::$dbconn = mysqli_connect("localhost", "j71qo2pj_chess","YE99yd(M+V?V","j71qo2pj_chesetup_scacs2");

		if (!self::$dbconn) {
			echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
			echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
			echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
			exit;
		}

	}

	public static function createUuid() {
		return strtoupper(sprintf( '%04x%04x%04x%04x%04x%04x%04x%04x',mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),mt_rand( 0, 0xffff ),mt_rand( 0, 0x0fff ) | 0x4000,mt_rand( 0, 0x3fff ) | 0x8000,mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )));
	}
	public static function bool2string($valor) {
		if ($valor==0) { return "No"; } else { return "Si"; }
	}
}
?>
