<?php
require_once ('./jpgraph/src/jpgraph.php');
require_once ('./jpgraph/src/jpgraph_line.php');
require_once ('./jpgraph/src/jpgraph_bar.php');
require_once ('./jpgraph/src/jpgraph_pie.php');
require_once ('./jpgraph/src/jpgraph_pie3d.php');

class graficos{

public function __construct(){
}

public function crear_grafico($escalaX,$escalaY,$titulgrf,$tituleixX,$tituleixY,$arrayticksX){
	$grafico=new Graph($escalaX,$escalaY,'auto');
	$grafico->SetScale("textlin");
	//hay que ajustas los márgenes 
	$grafico->SetMargin(50,30,30,50);
	$grafico->title->Set($titulgrf);
	$grafico->xaxis->title->Set=$tituleixX;
	$grafico->xaxis->SetTickLabels=$arrayticksX;
	$grafico->yaxis->title->Set=$tituleixY;

	$grafico->xgrid->Show();
	$grafico->xgrid->SetLinesStyle("solid");
	$grafico->xgrid->SetColor('#E3E3E3');
	$grafico->legend->SetFrameWeight(1);
	$grafico->title->SetFont(FF_FONT1,FS_BOLD);
	$grafico->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
	$grafico->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
	return $grafico;
}

public function desplegargrafico ($grafico)
	{
	$grafico->Stroke();
	
	}



public function introducir_linea($grafico,$nomlinea,$arraypuntos){
	$p1=new LinePlot($arraypuntos);
	$grafico->Add($p1);
	$p1->value->Show();
	$p1->SetColor("#B22222");
	$p1->SetLegend($nomlinea);
	}
}
?>