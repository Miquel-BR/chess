

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
    <li><a href="choosedemand.php?t=Choose Location&projh=<?php echo $projh;?>">Energy Demand</a></li>
    <li class="active"><a href="#">New Demand </a></li>
</ul>

   <div class="grid_16 widget first">
        <div class="widget_title clearfix">
            <h2>Data Introduction </h2>
        </div>
        <div class="widget_body">
                <div id="table1">
		<form method="POST" action="validarnuevademanda.php?t=Inici&projh=<?php echo $projh?>">
                  <table class='simple'>
 		<tr><td><label>New Typology</label></td><td><input type="text" name="tipology" id="tipology" style="width:100px;"></td></tr>
		<tr><td><label >Observation:</label></td><td><input type="text" name="observation" id="observation" style="width:460px;"></td>
		</tr>   
		<tr><td></td><td></td><td>
		</td>				 
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