<?php
if(isset($_GET['sidebar'])){
    include('s_header.php');
} else {
    include('header.php');
}
?>
<?php
// INCLUDES
require_once("./class/gestio_projectesBBDD.php");
require_once("./class/localitat.php");
//require_once("./class/parte.php");
require_once("./class/usuari.php");
//require_once("./class/tasca.php");
require_once("./class/projectes.php");
$localusuari=$_SESSION['usuari'];
if(isset($_GET['usuario'])){
	$localusuari=$_GET['usuario'];
	}
$nomprojectes=projectes::getprojectes($localusuari);
$numprojectes=count($nomprojectes)-1;
$auxoptions2="";
if($numprojectes==0)
	{$auxoptions2="<option value=\"0\">No existing projects</option>";}
else{$auxoptions2="<option value=\"1\">Project Selection</option>";}
$i=1;
foreach ($nomprojectes as $aux){
$auxoptions2.=" <option value='".$aux['nomproject']."'>".$aux['nomproject']."</option>";
$i++;
}
//Si viene de validarprojecto
if(isset($_GET['u']))
	{if($_GET['u']==1){echo "<script>alert('Project name is in use: choose another name');</script>";}}
?>
<ul class="breadcrumbs">
        <li><a href="#">Choose Project-New Project</a></li>
    
</ul>
<div class="grid_16 widget first">
    <div class="widget_title clearfix">
        <h2>General Information:</h2>
    </div>
    <div class="widget_body">
        <div class="widget_content">
            <div style="width: 80%; display: inline-block;zoom: 1;*display:inline;">
            <ul class="list-tick">   
            </ul>
            <!--<ul class="list-cross">-->
			<ul>
				<li>Welcome to the CHESS SETUP simulation software. You are about to start your path to a buildings' self-sufficiency. 

At this stage, you need to name the project you will be working from then/now on.

Type a NAME for your new project. In case you have been working before in a specific project, go to the select-bar menu and choose your assignment.  </li>
            </ul>
            </div>
        </div>
		
    </div>
</div>
    <div class="grid_16 widget first">
        <div class="widget_title clearfix">
            <h2>Choose a new name for your simulation or choose a simulation from list.</h2>
        </div>
        <div class="widget_body">
            <div id="table1">
            <form method="POST" action="validarprojecto.php">
			
			<table>
			
			<tr>  <td>   <label class="block" for="project" style="background:grey"> ARE YOU ALREADY WORKING IN ANY PARTICULAR PROJECT?: </label></td>
			</tr><tr></tr>  
			<tr>  <td>	 <select id="projects" style="width:300px;" name="projects"><?php echo $auxoptions2;?></select></td>
			</tr><tr></tr>
            <tr>  <td>   <label class="block" for="project" style="background:grey">START YOUR NEW PROJECT  </label></td>
			</tr><tr></tr>
			<tr>  <td>   <input type="text" name="project" id="project" style="width:300px;"/></td>
			</tr><tr></tr>
			</table>
			<br>
			<table >
			<tr>
                <th class="align-left" style="width:50px;background: rgba(128, 255, 0, 0.3); border: 1px solid rgba(100, 200, 0, 0.3);">User:</th>
                <th class="align-left" style="width:50px;background: rgba(128, 255, 0, 0.3); border: 1px solid rgba(100, 200, 0, 0.3);">Place:</th>
				<th class="align-left" style="width:50px;background: rgba(128, 255, 0, 0.3); border: 1px solid rgba(100, 200, 0, 0.3);">Demand Type:</th>
                
                                    
                            
			</tr>
			
			<td style="width:50px;"><div id="infuser" name="infuser" style="width:200px;"><?php echo $localusuari;?></div></td>
			<td style="width:50px;"><div id="infloc" name="infloc" style="width:200px;"></div></td>
			<td style="width:50px;"><div id="infdemand" name="infdemand" style="width:200px;"></div></td>
			</tr>
			<tr></tr>
            </table>
			<br><br>
			<table >
			<tr><td style="width:100px;"></td><td style="width:100px;"></td><td style="width:100px;"></td><td style="width:100px;"><input align="right" type="submit" class="btn blue medium" name="submit" value="Next"></td></tr>
			</table>
			<input type="hidden" name="iduser" value="<?php echo $localusuari; ?>">
			<!--<input type="hidden" name="idproj" value="<?php echo $_SESSION['projecte']; ?>">-->
			
						
		</form>
		<br><br>
		<div class="clear"></div>
	<?php
						
	if (isset($_GET['error'])) {
						
	?>
						
	<div id="div_errors" style="display:block">
							
	<div class="msg failure">
								
	<span id="missatge_err">Error in User or Password.</span>
								
	<a href="#" class="close">x</a>
							
	</div>
						
	<?php } ?>
						
	</div>
            </div>
        </div>
    </div>

    <div class="clear"></div>
 
<script type="text/javascript">
	$(document).ready(function(){
	$("#projects").change (function () {
    var jaux = $("#projects").val();
	var juser;
	var jloc;
	var jdemand;
	if(jaux!=""){
		$("#project").val(jaux);}
	var arrayJS=<?php echo json_encode($nomprojectes) ?>;
	for (var i=0;i<arrayJS.length;i++)
		{
		if(arrayJS[i]['nomproject']==jaux)
			{
			jloc=arrayJS[i]['localitat'];
			jdemand=arrayJS[i]['nomdemanda'];
			
			}
		
		}
	$("#infloc").html(jloc);
	$("#infdemand").html(jdemand);
	
        });
	
	});
	
</script>
 
 
 <script>
   function valueselect(sel) {
      var value = sel.options[sel.selectedIndex].value;
	  
   }
</script>



<?php include("footer.php") ?>
