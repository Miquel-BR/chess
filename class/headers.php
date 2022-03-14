<?php


class headers {
	

	


public static function comprobararchivo($projecte)
	{
	$nomfile=$projecte.".txt";
	if (file_exists($nomfile)){return 1;}
	else {return 0;}
	}



}	

?>