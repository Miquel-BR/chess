

<?php
if(isset($_GET['sidebar'])){
    include('s_header.php');
} else {
    include('header.php');
}

require_once("./class/demandas.php");


$vectordemand=demandas::consultademandas();
$numdemand=count($vectordemand)-1;

?>
<ul class="breadcrumbs">
    <li><a href="#">Administraci&oacute;</a></li>
    <li><a href="#">Inici</a></li>
    <li class="active"><a href="#">Inici </a></li>
</ul>

   <div class="grid_16 widget first">
        <div class="widget_title clearfix">
            <h2>Llistat informatiu </h2>
        </div>
        <div class="widget_body">
                <div id="table1">
		<form method="POST" action="validarconsultademandas.php?t=Inici">
                  <table class='simple'>
 		<tr>
		<td><label>Choose a existing tipology:</label></td>
		</tr><tr>
		<td><select id="demands" name="demands" style="width:100px;" onchange="rellenar()";>
		<?php			
			$i=0;
			if($numdemand==0){ echo "<option value=\"0\">No Data</option>";}
			foreach($vectordemand as $aux)
				{
				echo "<option value='".$aux['nom_demand']."'>".$aux['nom_demand']."</option>";
				if($i==0)
					{
					$aux1=$aux['observacio'];
					}
					$i++;
				}
		?>
		</select></td>
		</tr>
		<tr><label>Choose a demand type:</label>
		</tr>
		<tr>
		
				<input type="radio" name="eleccio" value="1" checked><label style="color:red;" for="1">Heating</label>
				<input type="radio" name="eleccio" value="2">Hot Water
				<input type="radio" name="eleccio" value="3">Cooling
				<input type="radio" name="eleccio" value="4">Electric appliances
		
		</tr>

		</table>

		<input type="submit" class="btn blue right" name="submit" value="Consult distribution">
						
                    
	         </form>					
		<div class="clear"></div>
            </div>
        </div>
    </div>
<script>
 function rellenar(){

	var jaux = $('select[name=demands]').val();
	var jpais;
	var jlatit;
	var jlong;
	
	
}            
</script>
<?php include("footer.php") ?>