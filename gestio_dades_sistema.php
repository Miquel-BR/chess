<?php
/*require_once("admincheck.php");
if(isset($_GET['sidebar'])){
    include('s_header.php');
} else {
    include('header.php');
}*/
include('header.php');
?>
<?php
// INCLUDES
require_once("./class/gestio_projectesBBDD.php");
require_once("./class/usuari.php");
require_once("./class/distribuciofrecuencies.php");
require_once("./scripts/jvscriptevents.php");
//require_once("./class/projecte.php");
gestio_projectesBBDD::setup();
if(isset($_POST['nomsistema']))
	{
	$_SESSION['sistema']=$_POST['nomsistema'];
	//$nomsistemaaux=$_SESSION['sistema'];
	}
if($_SESSION['sistema']!="")
	{
	$nomsistemaaux=$_SESSION['sistema'];
	}
else{$nomsistemaaux="";}

?>
<ul class="breadcrumbs first">
    <li><a href="#">Gesti&oacute de dades</a></li>
    <li class="active"><a href="#">Gesti&oacute dades sistema</a></li>
</ul>


<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>Gesti&oacute de dades</h2>
    </div>
    <div class="widget_body">
        <label><h4>      Systems</h4></label>
	<form name="validacio" method="POST" action="gestio_dades_sistema.php?t=System Configuration" id="validacio">
        
	
	<table>
            <tr>
  
		
	
            </tr>
    	    <tr>
		<td></td>
		<!--<td><img src="HeatingSystem.jpg" alt="Icono" height="200" width="200"></td>
		<td><img src="HeatingCoolingSystem.jpg" alt="Icono" height="200" width="200"></td>-->

		<td><input type=image src="HeatingSystem.jpg" width="200" height="200"></td>
		<td><input type=image src="HeatingCoolingSystem.jpg" width="200" height="200"></td>
            </tr>	
		
            <tr>
                <td></td>
		<td><label>Centralized</label></td>
		<td><label>No Centralized</label></td>

	    </tr>
		<tr>
			<td></td><td><label>Nom sistema:</label></td><td><input type="text" name="nomsistema" id="nomsistema" style="width:150px;" value=<?php echo $nomsistemaaux; ?>></td>
		</tr>
                <td>
			
			<input type="submit" class="btn blue" name="submit" value="Consultar">
			
			
                </td>
            </tr>
        </table>
		<!--<input type="hidden" name="nomdistribucioselected" value="0">-->
		
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

<script type="text/javascript">
	
	function addComboB(idsel)
		{
		
		var x = document.getElementById('distribucio');
		var texto= document.getElementById('novadistribucio').value;
		var x2=document.createElement('SELECT');
		x2.id="combo";
		x2.name="combo2";
		//var opcionSeleccionada=x.selected_val;
		
		var opt = document.createElement('OPTION');
		alert(x[0].text);
		opt.value = texto;
		opt.text=texto;
		opt.innerHTML=texto;
		//x.options[0]= new Option(texto,"1");
		x.options.add(opt);
		
		x.disabled=false;
		
		
		x2.options[0]=opt;
		x2.disabled=true;
		//document.getElementById('novadistribucio').text="cambiado";
                alert(x[0].text);
		//x.disabled=true;
		//sel.submit.value="Consultar2";
		//document.location.reload();//recarga la página
		return x;		
}
function nomselected(obj)
	{
	var nomselected=obj.Option[obj.SelectedIndex].text;
	return nomselected;
	}
</script>

<?php include("footer.php") ?>