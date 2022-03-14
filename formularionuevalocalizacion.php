

<?php
if(isset($_GET['sidebar'])){
    include('s_header.php');
} else {
    include('header.php');
}
if (isset($_GET['projh'])){$projh=$_GET['projh'];}
else{if(isset($_POST['projh'])){$projh=$_POST['projh'];}else $projh="";}

?>
<ul class="breadcrumbs">
    
    <li><a href="chooselocation.php?t=Choose Location&projh=<?php echo $projh;?>">Location</a></li>
    <li class="active"><a href="#">New Location </a></li>
</ul>

   <div class="grid_16 widget first">
        <div class="widget_title clearfix">
            <h2>Data Introduction</h2>
        </div>
        <div class="widget_body">
                <div id="table1">
		<form method="POST" action="validarnuevalocalizacion.php?t=Inici&projh=<?php echo $projh?>">
                  <table class='simple'>
 		<tr>
		<th class="align-left"> New Place</th>
                <th class="align-left">Country</th>
		<th class="align-left">Latitude</th>
                <th class="align-left">Longitude</th>
		</tr>
		<tr>
		<td><input type="text" name="newloc" id="newloc" style="width:100px;"></td>
		<td><input type="text" name="newpais" id="newpais" style="width:100px;"></td>
		<td><input type="text" name="newlatit" id="newlatit" style="width:100px;"></td>
		<td><input type="text" name="newlong" id="newlong" style="width:100px;"></td>
		</tr>
		</table>

		<input type="submit" class="btn blue right" name="submit" value="Add New Type">
		<input type="hidden" name="projh" id="projh" value="<?php echo $projh; ?>">		
                    
	         </form>					
		<div class="clear"></div>
            </div>
        </div>
    </div>

<?php include("footer.php") ?>