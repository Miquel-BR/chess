<?php
// Crear csv
$nomfitxer="informe_projectes_usuari.csv";
//crear tabla relleno
$archivo = fopen ($nomfitxer, "w+");
//Crear listado de nombres de ficheros para los ficheros existentes
$numprojectes=count($taulaprojectesperdata);
$taulausuaris=tasca::getallusuarisperdata($sendAny,$sendMes,$sendTipo);
$numusuaris=count($taulausuaris);
$i=0;
$nomlistaprojectes="Usuaris;";
while ($i<count($taulausuaris)-2)
{
$vectorusuari=usuari::getuser($taulausuaris[$i]['Usuari_idUsuari']);
$nomlistausuaris=$nomlistausuaris.$vectorusuari['identificador'].";";
$horestotals=$horestotals.$taulausuaris[$i]['sum(hores_reals)'].";";

$i++;
}
$vectorusuari=usuari::getuser($taulausuaris[$i]['Usuari_idUsuari']);
$nomlistausuaris="Projectes-Usuaris:".$sendMes."-".$sendAny.";".$nomlistausuaris.$vectorusuari['identificador'];
$horestotals="Hores totals;".$horestotals.$taulausuaris[$i]['sum(hores_reals)'];

//Contabilizar numero y preparar un string para dinamizar la escritura en la primera fila del CSV (Primera celda: Usuaris)
fwrite($archivo,utf8_decode($nomlistausuaris)."\n");
$j=0;
//Listado de usuarios

while ($j<$numprojectes-1) {
	//encontrar el nombre del usuario
	$vectorprojecte=projecte::getproject($taulaprojectesperdata[$j]['projecte_idProjecte']);
	fwrite($archivo,utf8_decode($vectorprojecte['nom_codi']).";");
	//fwrite($archivo,utf8_decode($vectorprojecte['idProjecte']).";");
	//rellenar el resto de las celdas
	$taulausuarisperprojecte=tasca::getallusuarisperdataprojecte($sendAny,$sendMes,$taulaprojectesperdata[$j]['projecte_idProjecte']);
	$numusuarisperprojecte=count($taulausuarisperprojecte)-1;
	$i2=0;
	$numtotalusuaris=count($taulausuaris)-1;
	while($i2<($numusuarisperprojecte))
		{
		$j2=0;
		while($j2<($numtotalusuaris))
			{
			if($taulausuaris[$j2]['Usuari_idUsuari']==$taulausuarisperprojecte[$i2]['Usuari_idUsuari']){
				$posusuari=$j2;
				$sum=$taulausuarisperprojecte[$i2]['sum(hores_tasca.hores_reals)'];
				}
			$j2++;
			}
		$vectorpos[$i2]=$posusuari;
		$vectorsum[$i2]=round($sum,2);
		//fwrite($archivo,$vectorsum[$i2].";");
		$i2++;	
		}
	//crear el string para el write: las posiciones y sum se han de ordenar, ir buscando la más baja a partir de la posición indicada
	$i3=0;
	while($i3<$numtotalusuaris)
		{
		$j3=0;
		$escrito=0;
		while ($j3<$numusuarisperprojecte)
			{
			if($i3==$vectorpos[$j3])
				{
				$aux=str_replace('.',',',$vectorsum[$j3]);
				fwrite($archivo,$aux.";");
				$escrito=1;
				}
			
				
			$j3++;
			
			}
		if($escrito==0){
			fwrite($archivo,";");
			}
		$i3++;
		}

	fwrite($archivo,"\n");
	//fwrite($archivo,utf8_decode($taulaprojectes[$i]['nom_codi']).";");
	//fwrite($archivo,date("Y/m/d",strtotime($taulaprojectes[$i]['data_inici_administrativa'])).";");
	//fwrite($archivo,date("Y/m/d",strtotime($taulaprojectes[$i]['data_fi_administrativa'])).";");
	//fwrite($archivo,utf8_decode($taulaprojectes[$i]['tipus']).";");
	//fwrite($archivo,$totalhores.";");
	//fwrite($archivo,gestio_projectesBBDD::bool2string($taulaprojectes[$i]['actiu']).PHP_EOL);
	$j++;
}
//Escribir total horas
fwrite($archivo,utf8_decode($horestotals)."\n");
fclose($archivo);
//Fin CSV
?>