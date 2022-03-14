<?php

class gestio_projectesBBDD {
	public static $dbconn;
	public static function setup() {
		//$file = fopen("BBDD.txt", "r") or exit("Unable to open file!");
		$i=0;
		$filas=file("BBDD.txt"); 

	
		$arrayTemp = array("nameBBDD","host","user","pass");
		foreach($filas as $fila){
		//while($filas[$i]!=NULL && $i==0){ 
		//$row = $filas[$i]; 
		//$sql = explode("|",$row);
		if($i==0){
		$sql = explode("|",$fila);		
		//print_r($sql);
		//$arrayTemp[$i]=array("nameBBDD"=>$sql[0],"host"=>$sql[1],"user"=>$sql[2],"pass"=>$sql[3]);
		}
		$i++; 
		}
		//echo ",$i,";
		//self::$dbconn = @mysql_connect("localhost","root","");
		//self::$dbconn = @mysql_connect($sql[1],$sql[2],$sql[3]);
		self::$dbconn = @mysql_connect('localhost','chesetup_bcneco','bcneco');
		//mysql_select_db($sql[0],self::$dbconn); 
		mysql_select_db('chesetup_scacs2',self::$dbconn);
		}
		
	public static function createUuid() {
		return strtoupper(sprintf( '%04x%04x%04x%04x%04x%04x%04x%04x',mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),mt_rand( 0, 0xffff ),mt_rand( 0, 0x0fff ) | 0x4000,mt_rand( 0, 0x3fff ) | 0x8000,mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )));
	}
	public static function bool2string($valor) {
		if ($valor==0) { return "No"; } else { return "Si"; }
	}
}
?>