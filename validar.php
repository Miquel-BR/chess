<?php
// INCLUDES
require("./class/gestio_projectesBBDD.php");
require("./class/usuari.php");

gestio_projectesBBDD::setup();
echo "hola";
$existeix=usuari::validate($_POST['usuari'],$_POST['password']);
echo "$existeix";
$existeix==0;
$aux1="";
$aux2="";
$aux3="";
$aux4="";
if ($existeix==0) {
	header("location:login.php?error");
	} else {
	/*$fecha=getdate();
	
	$segtotal=$fecha['seconds']+$fecha['minutes']*60+$fecha['hours']*60*60;
	if($segtotal<10){$aux4="0000";$aux4=$aux4.$segtotal;} 
	else {
		if($segtotal<100){$aux4="000";$aux4=$aux4.$segtotal;}
			else{
			if($segtotal<1000){$aux4="00";$aux4=$aux4.$segtotal;}
				else{
					if($segtotal<10000){$aux4="0";$aux4=$aux4.$segtotal;}
					else {$aux4=$segtotal;}
				}
			}
		}
	
	if($fecha['mday']<10){$aux1="0";$aux1=$aux1.$fecha['mday'];} else {$aux1=$fecha['mday'];}
	if($fecha['mon']<10){$aux2="0";$aux2=$aux2.$fecha['mon'];} else {$aux2=$fecha['mon'];}
	$aux3=$fecha['year'];
	$codetime=$aux3.$aux2.$aux1.$aux4;*/
	//O más sencillo que el anterior para normalizar después
	$codetime=time();
	session_id($codetime);
	session_start();
	//echo 'ID Session:'.session_id();
	
	//echo "<br>$codetime";
	$_SESSION['validat']="ok";
	$_SESSION['usuari']=$_POST['usuari'];
	$GLOBALS['usuario']=$_POST['usuari'];
	$usuario=$_POST['usuari'];
	$_SESSION['sistema']="";
	$_SESSION['pos']=2;
	$_SESSION['locali']="";
	if (usuari::isadmin($_POST['usuari'])) {
		$_SESSION['admin']="si";
		} else {
		$_SESSION['admin']="no";
	}
	//session_write_close();
	header("location:home.php?t=Choose Project&usuario=$usuario");
	}
?>