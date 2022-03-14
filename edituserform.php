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
gestio_projectesBBDD::setup();
if($_GET['usuari']!=0){
$usuari=usuari::getuser($_GET['usuari']);}
else
{//Calcular el identificador de usuario. 
$maxid=usuari::getmaxid();
$maxid=$maxid+1;
$usuari=array("idusuari"=>$maxid,"identificador"=>"","nom"=>"","cognom"=>"","correu"=>"","actiu"=>0,"tipousuari"=>2);
}

?>
<ul class="breadcrumbs first">
    <li><a href="#">User Management</a></li>
    <li><a href="#">Users</a></li>
    <li class="active"><a href="#">Edit User</a></li>
</ul>


<div class="grid_16 widget first">

    <div class="widget_title clearfix">
		
        <h2>Edit User <?php echo $usuari['identificador']; ?></h2>
    </div>
	
    <div class="widget_body">
		
        <form name="validation" method="POST" action="./scripts/edituser.php" id="editUserForm">
        <table>
            <tr>
                <td width="20%"><label>Identificator</label></td>
                <td>
                        <input id="required_field" class="medium :required" type="text" name="identificador" value="<?php echo $usuari['identificador']; ?>"/>
                        <span class="infobar">Required Field.</span>
                </td>
            </tr>
            <tr>
                <td><label>Name</label></td>
                <td>
                        <input class="medium :required" type="text" name="nom" value="<?php echo $usuari['nom']; ?>"/>
                        <span class="infobar"Required Field.</span>
                </td>
            </tr>
            <tr>
                <td><label>Primer Cognom</label></td>
                <td>
                        <input class="medium :required" type="text" name="cognom" value="<?php echo $usuari['cognom']; ?>"/>
                        <span class="infobar">Required Field.</span>
                </td>
            </tr>
            <!--<tr>
                <td><label>Segon Cognom</label></td>
                <td>
                        <input class="medium" type="text" name="cognom2" value="<?php echo $usuari['cognom_2']; ?>"/>
                        
                </td>
            </tr>-->
            <!--<tr>
                <td><label>Cost Hora</label></td>
                <td>
                        <input class="medium :float :required" type="text" name="costhora" value="<?php echo $usuari['cost_hora']; ?>"/>
                        <span class="infobar">Aquest camp es obligatori.</span>
                </td>
            </tr>-->
            <tr>
                <td><label>Mail</label></td>
                <td>
                        <input id="email" class="medium :email :required" type="text" name="correu" value="<?php echo $usuari['correu']; ?>">
						<span class="infobar">Required Field.</span>
						
                </td>
            </tr>
			<!--<tr>
                <td><label>Rol</label></td>
                <td>
                    <select name="rol">
					<?php
					if ($usuari['rol']=="Usuari") {
						echo "<option selected>Usuari</option>";
						echo "<option>Administrador</option>";
					} else {
						echo "<option>Usuari</option>";
						echo "<option selected>Administrador</option>";
					}
					?>
                </select>
                </td>
            </tr>-->
            <tr>
                <td><label>Active</label></td>
                <td>
                    <select  name="actiu">
					<?php
					if ($usuari['actiu']==0) {
						echo "<option value=\"0\" selected>No</option>";
						echo "<option value=\"1\">Si</option>";
					} else {
						echo "<option value=\"0\">No</option>";
						echo "<option value=\"1\" selected>Si</option>";
					}
					?>
					</select>
                </td>
            </tr>
			<tr>
                <td><label>User Type</label></td>
                <td>
                    <select  name="type">
					<?php
					if ($usuari['tipousuari']==1) {
						echo "<option value=\"1\" selected>Admin</option>";
						echo "<option value=\"2\">Guest</option>";
						echo "<option value=\"3\">Insider</option>";
					} else {
						if($usuari['tipousuari']==3){
							echo "<option value=\"1\">Admin</option>";
							echo "<option value=\"2\" >Guest</option>";
							echo "<option value=\"3\" selected>Insider</option>";
							}
						else {echo "<option value=\"1\">Admin</option>";
							echo "<option value=\"2\" selected>Guest</option>";
							echo "<option value=\"3\">Insider</option>";}
						
					}
					?>
					</select>
                </td>
            </tr>
			<!--<tr>
                <td><label>Historic</label></td>
                <td>
                    <select  name="historic">
					<?php
					if ($usuari['historic']==0) {
						echo "<option value=\"0\" selected>No</option>";
						echo "<option value=\"1\">Si</option>";
					} else {
						echo "<option value=\"0\">No</option>";
						echo "<option value=\"1\" selected>Si</option>";
					}
					?>
					</select>
                </td>
            </tr>-->
			<!--<tr>
                <td><label>Hores setmanals</label></td>
                <td>
                        <input class="medium :float :required" type="text" name="hsetmanals" value="<?php echo $usuari['hores_setmanals']; ?>"/>
                        <span class="infobar">Aquest camp es obligatori.</span>
                </td>
            </tr>-->
			<!--<tr>
                <td><label>Hores setmanals estiu</label></td>
                <td>
                        <input class="medium :float :required" type="text" name="hsetmanals_estiu" value="<?php echo $usuari['hores_setmanals_estiu']; ?>"/>
                        <span class="infobar">Aquest camp es obligatori.</span>
                </td>
            </tr>-->
			<!--<tr>
                <td><label>Data d'inici laboral</label></td>
                <td>
                        <input class="datepicker_custom medium :required" type="text" name="datainicilaboral" value="<?php echo $usuari['data_inici_laboral']; ?>"/>
                        <span class="infobar">Aquest camp es obligatori.</span>
                </td>
            </tr>-->
			<!--<tr>
                <td><label>Foto</label></td>
                <td>
                        <input id="pujarfoto" name="pujarfoto" type="file" />
                </td>
            </tr>-->
            <tr>
                <td></td>
                <td>
                        <input type="hidden" name="iduser" value="<?php echo $usuari['idusuari']; ?>">
						<input type="submit" class="btn blue" name="submit" value="Save">
                </td>
            </tr>
        </table>
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
<script>
// script que fa el POST amb totes les dades del formulari a la url definida en l'action del form i defineix el comportament dels errors.
  $('form').submit(function(event) {
	event.preventDefault();
	//alert($(this).serialize());
	var $form = $( this ),
        //term = $form.serialize(),
        url = $form.attr( 'action' );
	$.post( url, $form.serialize() ,
      function( data ) {
		//alert(data);
		if (data!="ok") {
			$('#div_errors').css('display','block');
			$('#missatge_err').append(data);
			//$('#missatge_err').append('Aquest usuari ja existeix');
			//$('#div_errors').fadeOut(5000);
			}
		else {
			$('#div_ok').css('display','block');
			$('#missatge_ok').append('Usuari editat correctament.');
			$('#div_ok').fadeOut(5000);
			window.location.replace("./showusers.php?t=Usuaris");
			}
      }
    );
});
</script>
<?php include("footer.php") ?>