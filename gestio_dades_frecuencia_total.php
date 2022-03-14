<?php

include('header.php');
?>
<?php
// INCLUDES
require_once("./class/gestio_projectesBBDD.php");
require_once("./class/usuari.php");
require_once("./class/distribuciofrecuencies.php");
require_once("./scripts/jvscriptevents.php");
require_once("./class/localitat.php");


gestio_projectesBBDD::setup();
$nomdistribucionsexistents=distribuciofrecuencies::getalldistribucionspercalcular();
$numdistribucions=count($nomdistribucionsexistents)-1;
$iddistribucioselected=$nomdistribucionsexistents[0]['id_distribucio'];
//$nomdistribucionscalculades=distribuciofrecuencies::getalldistribucionscalculades();
$nomdistribucionscalculades=distribuciofrecuencies::getalldistribucions();
$numdistribucionscalculades=count($nomdistribucionscalculades)-1;

$numloc=localitat::numlocalitats();
$vectorloc=localitat::consultalocalitats();
?>

<ul class="breadcrumbs first">
    <li><a href="#">Gesti&oacute de dades</a></li>
    <li class="active"><a href="#">Gesti&oacute dades frecuencia anual</a></li>
</ul>


<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Gesti&oacute de dades <?php echo " $numdistribucions"; ?></h2>
    </div>
    <div class="widget_body">

	<form name="validacio" method="POST" action="DesplegarGrafico.php?t=Inici" id="validacio">
        
	
	<table>
            <tr>
                <td><label>Distribucions existents sense calcular</label></td>
		<td>
			<select id="distribuciototals" style="width:200px;" name="distribuciototals" onchange=document.getElementByName("iddistribucioselected").text=this.options[this.selectedIndex].value>
			<?php
				if($numdistribucions=="0")
					{ 
					echo "<option value=1>".$numdistribucions."</option>";
					}
				else{
					$i=0;
					$iddistribucioselected=$nomdistribucionsexistents[$i]['id_distribucio'];
					while($i<$numdistribucions)
						{ echo "<option value=\"".$nomdistribucionsexistents[$i]['id_distribucio']."\">".$nomdistribucionsexistents[$i]['nom_distribucio']."</option>";
						$i++;
						}
					}
			?>
			
			</select>
                </td>
		
            </tr>


            <tr>
                <td></td>
                <td>
			
			<a href="<?php distribuciofrecuencies::calcularfrecuenciatotal($iddistribucioselected) ?>" class="btn blue"> Calcular frecuencia </a> 
                </td>
            </tr>
		<tr>
		
		<td><label>Distribucions calculades </label></td>
		<!--<?php echo " $nomdistribucionscalculades[0]['tipus_distribucio.id_distribucio']"; ?>-->
		<td>
			<select id="distribuciografiques" style="width:200px;" name="distribuciografiques" class "medium" onchange=document.getElementByName("iddistribucioselected").text=this.options[this.selectedIndex].value>
			<?php
				//echo "<option value=1>Calculadas</option>";
				if($numdistribucionscalculades=="0")
					{ 
					echo "<option value=1>".$numdistribucionscalculades."</option>";
					}
				else{
					$i=0;
					$iddistribucioselected=$nomdistribucionscalculades[$i]['id_distribucio'];
					
					while($i<$numdistribucionscalculades)
						{ echo "<option value=\"".$nomdistribucionscalculades[$i]['id_distribucio']."\">".$nomdistribucionscalculades[$i]['nom_distribucio']."</option>";
						$i++;
						}
					}
				
			?>
		
			</select>

		</td>
		
		</tr>
		<tr>
			<td><label>Localitats </label></td>
			<td>
				<select id="localitatsgrafiques" style="width:200px;" name="localitatsgrafiques" class "medium" onchange=document.getElementByName("localitatselected").text=this.options[this.selectedIndex].value>
			<?php
				//echo "<option value=1>Calculadas</option>";
				if($numloc=="0")
					{ 
					echo "<option value=1>".$numloc."</option>";
					}
				else{
					$i=0;
					$localitatselected=$vectorloc[$i]['nom_localitzacio'];
					
					while($i<$numloc)
						{ echo "<option value=\"".$vectorloc[$i]['nom_localitzacio']."\">".$vectorloc[$i]['nom_localitzacio']."</option>";
						$i++;
						}
					}
				
			?>
		
			</select>
			</td>
		</tr>
		<tr>
                <td></td>
                <td>
			
			<?php
			
			
			echo "<input type=\"submit\" class=\"btn blue\" name=\"submit\" value=\"Graficar\">";

			?> 
                </td>
            </tr>
        </table>
	
		<input type="hidden" name="iddistribucioselected">
		<input type="hidden" name="localitatselected">
	
		
        </form>
		<div id="div_errors" style="display:none">
			<div class="msg failure">
                    <span id="missatge_err"></span>            
			</div>
		</div>
		<div id="div_ok" style="display:none">
			<div class="msg success">
                    <span id="missatge_ok"></span>
			</div>
		</div>
    </div>
</div>


<?php include("footer.php") ?>
