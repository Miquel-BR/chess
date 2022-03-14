<?php

class gestio_projecte2sBBDD {
	public static $mysqli;
	public static function setup() {
		//bbdd wamp local
		//self::$dbconn = @mysql_connect("localhost","root","");
			
		//mysql_select_db("scacs2",self::$dbconn); 
		$i=0;
		$filas=file("BBDD.txt"); 
		foreach($filas as $fila){
		if($i==0){
		$sql = explode("|",$fila);		
		}
		$i++; 
		}
		
		
		self::$mysqli=new mysqli($sql[1],$sql[2],$sql[3],$sql[0]);
		if(mysqli_connect_errno()){$texto="No db";}

		}
	public static function createUuid() {
		return strtoupper(sprintf( '%04x%04x%04x%04x%04x%04x%04x%04x',mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),mt_rand( 0, 0xffff ),mt_rand( 0, 0x0fff ) | 0x4000,mt_rand( 0, 0x3fff ) | 0x8000,mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )));
	}
	public static function bool2string($valor) {
		if ($valor==0) { return "No"; } else { return "Si"; }
	}
	
	
}
?>