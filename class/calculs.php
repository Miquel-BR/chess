<?php
require_once("gestio_projectesBBDD.php");
require_once('class/distribuciofrecuencies.php');
require_once('class/projectes.php');

class calculs {
	
public static function obtenerDT($projecte,$iddistribucio,$sendnomdistribucio,$sendlocalitat)
	{
	$i=0;
		$filas=file("BBDD.txt"); 
		$arrayTemp = array("nameBBDD","host","user","pass");
		foreach($filas as $fila){
		if($i==0){
			$sql = explode("|",$fila);		
		}
		$i++; 
		}
	//$mysqli=new mysqli('localhost','root','','scacs2');
	$mysqli=new mysqli($sql[1],$sql[2],$sql[3],$sql[0]);
	if(mysqli_connect_errno()){$texto="No db";}
	
	$arraydata = array("hora","dia","mes","valor","numhora");
	//$arraydata2
	$query2="select * from projectedemandes where projecte='$projecte'";
	//echo "<br>query2: $query2,<br>";
	$result2=$mysqli->query($query2);
	//while ($row=$result2->fetch_assoc()){
	while($row = $result2->fetch_object()){
            $auxheat=$row->heatingdemand;
			$auxhotwater=$row->hotwaterdemand;
			$auxcool=$row->coolingdemand;
			$auxelec=$row->electricappdemand;
            $numviviendas=$row->numhomes;
        } 
		
		if($iddistribucio==4){$quantitatI=$auxheat;}
		if($iddistribucio==5){$quantitatI=$auxhotwater;}
		if($iddistribucio==6){$quantitatI=$auxcool;}
		if($iddistribucio==7){$quantitatI=$auxelec;}
		$quantitatI=$quantitatI*$numviviendas;
	$result2->free();

	
	
	
	$tipotabla1="distribucions_anuals_projectes";$tipotabla2="distribucions_diaries_projectes";
	$campoprojecto=" and projecte='".$projecte."'";
	$tipocampo="demand";
	//if($tipograf=="mes")
	//{
	$query = "select valor from $tipotabla1 where idDistribucio_anual='$iddistribucio' and $tipocampo='$sendlocalitat' $campoprojecto group by mes order by mes";
	//$query = "select valor from distribucions_anuals where idDistribucio_anual='$iddistribucio'";
	//}
	//echo "<br>query: $query,<br>";
	echo "<br>Acquiring Demand Data<br>"; 
	$result=$mysqli->query($query);
	$i=1;$k=1;
	while($row = $result->fetch_object()){
        if($row->valor != null)
		{$auxq[$i]=$row->valor;}  
        else {$auxq[$i]=0;}
		$i++;   
        }
	$result->free();
	if($i>1){
	$numdadesdismesdemandaproj=count($auxq)-1;
			}
	else {$numdadesdismesdemandaproj=0;}
	if($numdadesdismesdemandaproj>0)
		{
		
		}
	else {$auxq=1;}
	
	//Para cada mes
	for ($sendmes=1;$sendmes<=12;$sendmes++)
		{
		if($sendmes==1){$numday=31;$quantitat=$quantitatI*($auxq[$sendmes]/100)/31;}
			if($sendmes==2){$numday=28;$quantitat=$quantitatI*($auxq[$sendmes]/100)/28;}
			if($sendmes==3){$numday=31;$quantitat=$quantitatI*($auxq[$sendmes]/100)/31;}
			if($sendmes==4){$numday=30;$quantitat=$quantitatI*($auxq[$sendmes]/100)/30;}
			if($sendmes==5){$numday=31;$quantitat=$quantitatI*($auxq[$sendmes]/100)/31;}
			if($sendmes==6){$numday=30;$quantitat=$quantitatI*($auxq[$sendmes]/100)/30;}
			if($sendmes==7){$numday=31;$quantitat=$quantitatI*($auxq[$sendmes]/100)/31;}
			if($sendmes==8){$numday=31;$quantitat=$quantitatI*($auxq[$sendmes]/100)/31;}
			if($sendmes==9){$numday=30;$quantitat=$quantitatI*($auxq[$sendmes]/100)/30;}
			if($sendmes==10){$numday=31;$quantitat=$quantitatI*($auxq[$sendmes]/100)/31;}
			if($sendmes==11){$numday=30;$quantitat=$quantitatI*($auxq[$sendmes]/100)/30;}
			if($sendmes==12){$numday=31;$quantitat=$quantitatI*($auxq[$sendmes]/100)/31;}
			
	
	
	
		//$query2 = "select valor from $tipotabla2 where idDistribucio_diaria='$iddistribucio' and $tipocampo='$sendnomdistribucio' and mes=$sendmes $campoprojecto order by hora";
		//$resultado=$mysqli->query($query2);
		for($j=1;$j<=$numday;$j++){
			$i=1;
			$query2 = "select valor from $tipotabla2 where idDistribucio_diaria='$iddistribucio' and $tipocampo='$sendnomdistribucio' and mes=$sendmes $campoprojecto order by hora";
			$resultado=$mysqli->query($query2);

			if(!$resultado){$texto="No resultado";}
			
			while ($data=$resultado->fetch_object()){
				$texto=$data->valor;
				$texto=($texto*$quantitat)/100;		
				//array_push($arraydata,$texto);
				
				
				//$arraydata[]=array("hora"=>$i,"dia"=>$j,"mes"=>$sendmes,"valor"=>$texto,"numhora"=>$k);
				$arraydata2[$k]=$texto;
				$k++;
				$i++;
				}
			$resultado->free();
			}
		

		}
	if($i>1){
	return $arraydata2;}
	else{ return 0;}
	
}

public static function obtenerDTmensual($projecte,$iddistribucio,$sendnomdistribucio)
	{
		$i=0;
		$filas=file("BBDD.txt"); 
		$arrayTemp = array("nameBBDD","host","user","pass");
		foreach($filas as $fila){
		if($i==0){
			$sql = explode("|",$fila);		
		}
		$i++; 
		}
	//$mysqli=new mysqli('localhost','root','','scacs2');
	$mysqli=new mysqli($sql[1],$sql[2],$sql[3],$sql[4]);
	
	
	
	//$mysqli=new mysqli('localhost','root','','scacs2');
	if(mysqli_connect_errno()){$texto="No db";}
	
	$query2="select * from projectedemandes where projecte='$projecte'";
	
	$result2=$mysqli->query($query2);
	//while ($row=$result2->fetch_assoc()){
	while($row = $result2->fetch_object()){
            $auxheat=$row->heatingdemand;
			$auxhotwater=$row->hotwaterdemand;
			$auxcool=$row->coolingdemand;
			$auxelec=$row->electricappdemand;
            $numviviendas=$row->numhomes;
        } 
		
		if($iddistribucio==4){$quantitatI=$auxheat;}
		if($iddistribucio==5){$quantitatI=$auxhotwater;}
		if($iddistribucio==6){$quantitatI=$auxcool;}
		if($iddistribucio==7){$quantitatI=$auxelec;}
		$quantitatI=$quantitatI*$numviviendas;
	$result2->free();

	
	
	
	$tipotabla1="distribucions_anuals_projectes";//$tipotabla2="distribucions_diaries_projectes";
	$campoprojecto=" and projecte='".$projecte."'";
	$tipocampo="demand";
	//if($tipograf=="mes")
	//{
	$query = "select valor from $tipotabla1 where idDistribucio_anual='$iddistribucio' and $tipocampo='$sendnomdistribucio' $campoprojecto group by mes order by mes";
	//$query = "select valor from distribucions_anuals where idDistribucio_anual='$iddistribucio'";
	//}
	
	$result=$mysqli->query($query);
	$i=1;$k=1;
	while($row = $result->fetch_object()){
        $auxq[$i]=$row->valor;
		$auxq[$i]=$quantitatI*$auxq[$i]/100;
        $i++;   
        }
	$result->free();

	return $auxq;
	
}


public static function cargardatosdeposit2($projecte)
	{
	$i=1;
	$aux=array("heatcapacity","surface2","u2","volumen2","mintempa2","density","maxtempa2");
	$query = "select tank_surface,heat_transfer,volumen,heatcapacity,mintemp,density,maxtemp from subsistemes_seasonal_storage_system where projecte='$projecte'";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $aux=array("heatcapacity"=>$row[$i]['heatcapacity'],"maxtempa2"=>$row[$i]['maxtemp'],"location"=>$row[$i]['location'],"surface2"=>$row[$i]['tank_surface'],"u2"=>$row[$i]['heat_transfer'],"volumen2"=>$row[$i]['volumen'],"mintempa2"=>$row[$i]['mintemp'],"density"=>$row[$i]['density']);$i++; }
	mysql_free_result($result);
		
	return $aux;
	}

public static function cargardatosdeposit1($projecte)
	{
	$i=1;
	$aux=array("heatcapacity","surface1","u1","volumen1","mintempa1","density");
	$query = "select tank_surface,heat_transfer,volumen,heatcapacity,mintemp,density from subsistemes_direct_use_tank where projecte='$projecte' ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) { $aux=array("heatcapacity"=>$row[$i]['heatcapacity'],"surface1"=>$row[$i]['tank_surface'],"u1"=>$row[$i]['heat_transfer'],"volumen1"=>$row[$i]['volumen'],"mintempa1"=>$row[$i]['mintemp'],"density"=>$row[$i]['density']);$i++; }
	mysql_free_result($result);
	return $aux;
	}
	
public static function cargardatosheatpump($projecte)
	{
	$i=1;
	$aux=array("power","efficiency","TCOPmax","COPmax","TCOPmid","COPmid","TCOPmin","COPmin","bottonCOP");
	$query = "select power,carnot_efficiency,TCOPmax,COPmax,TCOPmid,COPmid,TCOPmin,COPmin,bottonCOP from subsistemes_heat_pump where projecte='$projecte' ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) {$aux=array("power"=>$row[$i]['power'],"efficiency"=>$row[$i]['carnot_efficiency'],"TCOPmax"=>$row[$i]['TCOPmax'],"COPmax"=>$row[$i]['COPmax'],"TCOPmid"=>$row[$i]['TCOPmid'],"COPmid"=>$row[$i]['COPmid'],"TCOPmin"=>$row[$i]['TCOPmin'],"COPmin"=>$row[$i]['COPmin'],"bottonCOP"=>$row[$i]['bottonCOP']); $i++; }
	mysql_free_result($result);
		
	return $aux;
	}	

public static function cargardatossolarpanel($projecte)
	{
	$i=1;
	$aux=array("stp_b","stp_a1","stp_a2","surfacesolar","tempwinter","tempsummer","temprest","RendFV");
	$query = "select superficie_solar,stp_b,stp_a1,stp_a2,temp_winter,temp_summer,temp_rest,efficiency from subsistemes_solar where projecte='$projecte' ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) {$aux=array("stp_b"=>$row[$i]['stp_b'],"surfacesolar"=>$row[$i]['superficie_solar'],"stp_a1"=>$row[$i]['stp_a1'],"stp_a2"=>$row[$i]['stp_a2'],"tempwinter"=>$row[$i]['temp_winter'],"tempsummer"=>$row[$i]['temp_summer'],"temprest"=>$row[$i]['temp_rest'],"RendFV"=>$row[$i]['efficiency']); $i++; }
	mysql_free_result($result);
		
	return $aux;	
	}	
	
public static function obtenernumviviendas($projecte) 
	{
	
	}

public static function cargardatosauxsource($projecte)
	{
	$i=1;
	$aux=array("Qaux1","Qaux2");
	$query = "select power_storage_system,power_direct_use_tank from subsistemes_aux_energy_sources where projecte='$projecte' ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) {$aux=array("Qaux1"=>$row[$i]['power_direct_use_tank'],"Qaux2"=>$row[$i]['power_storage_system']); $i++; }
	mysql_free_result($result);
		
	return $aux;	
	}

public static function cargardatosdistribucion($projecte)	
{
	$i=0;
	$query = "select * from subsistemes_distribution_system where projecte='$projecte' ";
	$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
	while ($row[$i] = mysql_fetch_assoc($result)) {$i++; }
	mysql_free_result($result);
	//echo "$query";
	//print_r($row);
	return $row;	

}

public static function calcularperdidapipe($Tent,$Text,$h,$Long,$m,$u,$r1,$r2,$Ce)
{
$k=2*(3.1416)/(($m*$Ce)*((log(($r2/$r1),2.71828)/$u)+(1/($r2*$h))));
$result=$m*$Ce*($Tent-$Text)*(1-(1/(exp($k*$Long))));
//if($result<-3000){echo "$result,$k,$Tent,$Text,$h,$Long,$m,$u,$r1,$r2,$Ce<br>";}
return $result;
}

public static function obtenerVarClima($projecte,$iddistribucio)
	{
	$i=1;$k=1;
	//$aux = array("dia","mes","hora","valor","numhora");
	for ($sendmes=1;$sendmes<=12;$sendmes++)
		{
			if($sendmes==1){$numday=31;}
			if($sendmes==2){$numday=28;}
			if($sendmes==3){$numday=31;}
			if($sendmes==4){$numday=30;}
			if($sendmes==5){$numday=31;}
			if($sendmes==6){$numday=30;}
			if($sendmes==7){$numday=31;}
			if($sendmes==8){$numday=31;}
			if($sendmes==9){$numday=30;}
			if($sendmes==10){$numday=31;}
			if($sendmes==11){$numday=30;}
			if($sendmes==12){$numday=31;}
			
		//$resultado=$mysqli->query($query);
		$i=1;
		for($j=1;$j<=$numday;$j++)
			{
			$query = "select valor from distribucions_diaries_projectes where projecte='$projecte' and idDistribucio_diaria=$iddistribucio and mes=$sendmes order by hora ";
			$result=mysql_query($query,gestio_projectesBBDD::$dbconn);
			while ($row[$i] = mysql_fetch_assoc($result)) {
				$texto=$row[$i]['valor'];
				$aux[$k]=array("hora"=>$i,"dia"=>$j,"mes"=>$sendmes,"valor"=>$texto,"numhora"=>$k);
				$i++;$k++;
				}
			mysql_free_result($result);
			}
		
		}	
	return $aux;	
	}
	

	
public static function iteracion_mst($Rad,$stp_b,$stp_a1,$Tsts,$Ta2,$Text,$Irr,$stp_a2,$Scol,$Celiq,$Tst2s,$maxtemp)
	{
	 if($Rad>0 && $Ta2<$maxtemp && $Ta2<$Tst2s){
		$base=($Tsts+$Ta2)/2-$Text;
		$res=pow($base,2);
		$result=$Rad*($stp_b-($stp_a1*$base/$Irr)-($stp_a2*$res/$Irr))*$Scol/($Celiq*($Tsts-$Ta2));
		}
	 else {$result=0;}
	 return $result;
	}
	
public static function iteracion_mdt($demandDT,$Celiq,$Ta1,$Tdts,$perdidas)
	{
	 $result=$demandDT/($Celiq*(($Ta1*(1-$perdidas))-$Tdts));
	 return $result;
	}	

public static function iteracion_cop($Ta1,$Ta2,$kHeatpump,$Tcopmax,$COPmax,$Tcopmin,$COPmin,$Tcopmid,$COPmid,$bottonCOP)	
	{
	if($Ta2<$Tcopmin){$result=$bottonCOP;}
	if($Ta2>=$Tcopmin && $Ta2<=$Tcopmid){$result=(($Ta2-$Tcopmin)*($COPmid-$COPmin)/($Tcopmid-$Tcopmin))+$COPmin;}
	if($Ta2>$Tcopmid && $Ta2<=$Tcopmax){$result=(($Ta2-$Tcopmid)*($COPmax-$COPmid)/($Tcopmax-$Tcopmid))+$COPmid;}
	if($Ta2>$Tcopmax){$result=$COPmax;}
	//$result=($Ta1+273.15)/(($Ta1-$Ta2)/$kHeatpump);
	return $result;
	}

public static function iteracion_cop_real($cop,$kHeatpump)	
	{
	if($cop<0){$result=20;}
	else{
		if($cop<10){$result=$cop;}
		else{$result=10;}
	}
	return $cop;
	
	}

public static function iteracion_Qa2($copreal,$Ta1min,$Ta2min,$PHeatPump,$Ta1i,$Ta2i)
		{
		if(($Ta1i<=$Ta1min) && ($Ta2i>=$Ta2min))
			{$result=($copreal*$PHeatPump*1000);}
		else {$result=0;}
		return $result;
		}
		
public static function calculEe($Ta1min,$Ta2min,$PHeatPump,$Ta1i,$Ta2i)		
		{
		if($Ta1i<=$Ta1min && $Ta2i>=$Ta2min)
			{$result=$PHeatPump*1000;}
		else {$result=0;}
		return $result;
		
		}
public static function iteracion_Qa1($Ee,$Qa2)
		{
		$result=$Ee+$Qa2;
		return $result;
		}

public static function iteracion_Qaux($Ta1min,$Ta2min,$Qauxsystem,$Ta1i,$Ta2i)
	{
	if($Ta1i<=$Ta1min && $Ta2i<=$Ta2min)
		{$result=$Qauxsystem*1000;}
		else {$result=0;}
		return $result;
	}

public static function iteracion_P1($Ta1,$Sa1,$Ua1,$Text)
		{
		$result=-$Sa1*$Ua1*($Ta1-$Text);
		return $result;
		}
public static function iteracion_P2($Ta2,$Sa2,$Ua2,$Tground)
		{
		$result=-$Sa2*$Ua2*($Ta2-$Tground);
		return $result;
		}
public static function iteracion_Ta1i1($Tst1s,$Ta1,$mst1,$Celiq,$Ta1e,$mdt,$Qa1,$Qaux,$P1,$Ta1i,$ma1)
		{
		$result=((($Tst1s-$Ta1)*$mst1*$Celiq)-(($Ta1-$Ta1e)*$mdt*$Celiq) + $Qa1 + $Qaux -abs($P1))/($ma1*$Celiq) + $Ta1i;
		return $result;
		}
public static function iteracion_Ta2i1($Tst2s,$Ta2,$mst2,$Qa2,$P2,$ma2,$Celiq,$Ta2i)
		{
		$result=(((($Tst2s-$Ta2)*$mst2*$Celiq)-$Qa2-abs($P2))/($ma2*$Celiq))+$Ta2i;
		return $result;
		}

public static function calculPd($mdt,$Ta1,$Tdte,$Tdts,$Ta1e)
			{
			$result=$mdt*($Ta1-$Tdte)-$mdt*($Tdts-$Ta1e);
			return $result;
			}
public static function calculRendSolar($Rad,$stp_b,$stp_a1,$stp_a2,$Tcol,$Text,$Irr)
	{
	$base=($Tcol-$Text);
	$res=pow($base,2);
	if($Rad>0){$result=($stp_b-($stp_a1*$base/$Irr)-($stp_a2*$res/$Irr));}
	else{$result=0;}
	return $result;
	}

public static function calculEst($Rad,$RendSolar,$Scol)
	{
	if($Rad<=0){$result=0;}
	//else{$result=$Rad*$RendSolar*$Scol;}
	else{$result=$Rad*$RendSolar*$Scol;}
	return $result;
	}

public static function calculPs($mst,$Celiq,$Tsts,$Tst1s)
		{
		$result=$mst*$Celiq*($Tsts-$Tst1s);
		return $result;
		}


		
}
?>