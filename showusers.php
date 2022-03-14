<?php
//require_once("admincheck.php");
//if(isset($_GET['sidebar'])){
//    include('s_header.php');
//} else {
    include('header.php');
//}
?>

<?php
// INCLUDES
require_once("./class/gestio_projectesBBDD.php");
require_once("./class/usuari.php");
require_once("./class/parte.php");
gestio_projectesBBDD::setup();
$taulausuaris=usuari::getall();
?>
<ul class="breadcrumbs">
    <li><a href="#">Management</a></li>
    <li><a href="#">Usuers</a></li>
    <li class="active"><a href="#">User Management</a></li>
</ul>
	<div class="grid_16 first">
        <!--<a href="adduserform.php?t=Usuaris" class="btn grey right">New User</a>-->
		<a href="edituserform.php?t=Usuaris&usuari=0" class="btn grey right">New User</a>

    <!--<div class="grid_16 widget first">-->
        <!--<div class="widget_title clearfix">-->
            <h2>User List</h2>
        <!--</div>-->
        <div class="widget_body">
                <div id="table1">
                <table class='dataTable'>
                    <thead>
                            <tr>
                                    <th class="align-left">Nom</th>
                                    <!--<th class="align-left">Cognom</th>-->
                                    <th class="align-left">Identifier</th>
                                    <th class="align-left">E-mail</th>
                                    <th class="align-left">Active</th>
									<!--<th class="align-left">Rol</th>
									<th class="align-center">Partes pendents</th>-->
									<th class="align-left">Opcions</th>
                            </tr>
                        </thead>
                        <tbody>
						<?php
							$i=0;
							while ($i<usuari::totalusers()) {
								if ($taulausuaris[$i]['identificador']!="Administrador") {
								echo "<tr class=\"gradeX\">";
                                echo "<td>".$taulausuaris[$i]['nom']."</td>";
								//echo "<td>".$taulausuaris[$i]['cognom_1']."</td>";
								echo "<td>".$taulausuaris[$i]['identificador']."</td>";
								echo "<td>".$taulausuaris[$i]['correu']."</td>";
								echo "<td>".gestio_projectesBBDD::bool2string($taulausuaris[$i]['actiu'])."</td>";
								//echo "<td>".$taulausuaris[$i]['rol']."</td>";
								//echo "<td class=\"center\">".parte::dayspending($taulausuaris[$i]['idUsuari'])."</td>";
								echo "<td><a href=\"edituserform.php?t=Usuaris&usuari=".$taulausuaris[$i]['idusuari']."\"><img src=\"./icons2/pencil.png\" title=\"Editar usuari\"></a><a href=\"changepassword.php?t=Usuaris&usuari=".$taulausuaris[$i]['idusuari']."\"><img src=\"./icons2/key.png\" title=\"Canviar password\"></a> <a href=\"./scripts/deleteuser.php?id=".$taulausuaris[$i]['idusuari']."\"><img src=\"./icons2/minus-circle.png\" title=\"Delete User\"></a></td>";
								echo "</tr>";
								}
								$i++;
							}
							?>
                        </tbody>
                    </table>
                <div class="clear"></div>
            </div>
        </div>
    <!--</div>-->

    <div class="clear"></div>
	<?php
	if (isset($_GET['error_delete'])) { 
	?>
					<div id="div_errors">
						<div class="msg failure">
							<span id="missatge_err">It's not possible to eliminate this user.</span>            
						</div>
					</div>
	<?php } ?>  
    


<?php include("footer.php") ?>