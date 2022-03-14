<?php
error_reporting(0);
require_once ("seguretat.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
	
    <link rel="stylesheet" type="text/css" href="style/style.css" />
	<link rel="stylesheet" type="text/css" href="uploadify/uploadify.css" />
	<link id='sfluid' class="sswitch" rel="stylesheet" type="text/css" href="style/fluid.css" title="fluid" media="screen" />
	<link id='sfixed' class="sswitch" rel="stylesheet" type="text/css" href="style/fixed.css" title="fluid" media="screen" />
	<!--Codigo de popup-->
	<link rel="stylesheet" type="text/css" href="/css/popup-window.css" />
	<script type="text/javascript" src="/jquery/jquery.js"></script>
	<script type="text/javascript" src="/js/popup-window.js"></script>
        
	<title>Sistema de gestió de dades projecte SCACS</title>
	
        <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.14.custom.min.js"></script>
        
        <script type="text/javascript" src="js/excanvas.min.js"></script>
        <script type="text/javascript" src="js/jquery.flot.min.js"></script>
        <script type="text/javascript" src="js/jquery.flot.pie.min.js"></script>
        <script type="text/javascript" src="js/jquery.flot.stack.min.js"></script>
        
        <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/jquery.labelify.js"></script>
        <script type="text/javascript" src="js/iphone-style-checkboxes.js"></script>
        <script type="text/javascript" src="js/jquery.ui.selectmenu.js"></script>
        <script type="text/javascript" src="js/vanadium-min.js"></script>
        <script type="text/javascript" src="js/jquery.cleditor.min.js"></script>
        <script type="text/javascript" src="js/superfish.js"></script>
        <script type="text/javascript" src="js/jquery.colorbox-min.js"></script>
        <script type="text/javascript" src="js/jquery.tipsy.js"></script>
       
        <script type="text/javascript" src="js/fullcalendar.min.js"></script>
		<script type="text/javascript" src="./uploadify/jquery.uploadify.js"></script>

        <script type="text/javascript" src="js/gcal.js"></script>
        <script type="text/javascript" src="js/swfobject.js"></script>
        <script type="text/javascript" src="js/jquery.pnotify.min.js"></script>
        <script type="text/javascript" src="js/examples.js"></script>

        <script type="text/javascript" src="js/sidemenu.js">// Strictly for sidebar </script>
        <script type="text/javascript" src="js/styleswitch.js">//Chaning the Stylesheet</script>

	<script type="text/javascript" language="javascript" src="js/funciones.js"></script> 	  
		 
		
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#pujarfoto').uploadify({
				'uploader' : './uploadify/uploadify.php?iduser='+$('[name=iduser]').val(),
				'fileExt'   : '*.jpg;*.gif;*.png',
				'fileDesc'  : 'Image Files (.JPG, .GIF, .PNG)',
				'cancelImage'	: './uploadify/cancel.png',
				'checkExisting'   : './uploadify/uploadify-check-exists.php',
				'swf'      : './uploadify/uploadify.swf',
				'auto' : true,
				'buttonText' : 'Buscar imatge'
				});
				$('.datepicker_custom').datepicker({
					onSelect: function() { $('.datepicker_custom').trigger("blur");},
					firstDay: 1,
					changeYear: true,
					yearRange: "-20:+5",
					monthNames: ["Gener","Febrer","Mar&ccedil;","Abril","Maig","Juny","Juliol","Agost","Setembre","Octubre","Novembre","desembre"],
					dayNamesMin: ["Do","Lu", "Ma", "Mi", "Ju", "Vi", "Sa"]
				});
				$('.datepicker_cv').datepicker({
					onSelect: function() { $('.datepicker_cv').trigger("blur");},
					firstDay: 1,
					changeYear: true,
					yearRange: "-20:+5",
					monthNames: ["Gener","Febrer","Mar&ccedil;","Abril","Maig","Juny","Juliol","Agost","Setembre","Octubre","Novembre","desembre"],
					dayNamesMin: ["Do","Lu", "Ma", "Mi", "Ju", "Vi", "Sa"]
				});
				$('#pujardocument').uploadify({
				'uploader' : './uploadify/uploadify_doc.php?iddoc='+$('[name=iddoc]').val(),
				'fileExt'   : '*.doc;*.docx;*.pdf',
				'fileDesc'  : 'Image Files (.DOC, .DOCX, .PDF)',
				'cancelImage'	: './uploadify/cancel.png',
				'checkExisting'   : './uploadify/uploadify-check-exists.php',
				'swf'      : './uploadify/uploadify.swf',
				'auto' : true,
				'buttonText' : 'Buscar document'
				});
				$('#editardocument').uploadify({
				'uploader' : './uploadify/uploadify_doc.php?iddoc='+$('[name=idbiblioteca]').val(),
				'fileExt'   : '*.doc;*.docx;*.pdf',
				'fileDesc'  : 'Image Files (.DOC, .DOCX, .PDF)',
				'cancelImage'	: './uploadify/cancel.png',
				'checkExisting'   : './uploadify/uploadify-check-exists.php',
				'swf'      : './uploadify/uploadify.swf',
				'auto' : true,
				'buttonText' : 'Nou document'
				});
			});
		</script>
	<!--<style type="text/css">
	.radioinput {
 	color: red;
 	background-color: #ccc;        
	}
	</style>-->
		
        <!--[if lt IE 9]>
            <script type="text/javascript" src="js/html5.js"></script>
        <![endif]-->
        
        <!--[if IE 7]>
            <link rel="stylesheet" type="text/css" href="style/IE7.css" />
        <![endif]-->

</head>
<body>
<?php
require_once("./class/gestio_projectesBBDD.php");
require_once("./class/usuari.php");
require_once("./class/demandas.php");
require_once("./class/headers.php");
gestio_projectesBBDD::setup();
$demanda="";
$projecte="SP1";
if (isset($_GET['projh']))
{$projh=$_GET['projh'];}
else{
if(isset($_POST['projh'])){$projh=$_POST['projh'];}
else{$projh="SP2";}
}
if($projh!="SP2" && $projh!="SP1")
{
$dem=demandas::getdemandaproject2($projh);
if($dem){
$demanda=$dem['nomdemanda'];}
else {$demanda="";}
}
$archivo=headers::comprobararchivo($projh);
if($archivo==1){}
else{}
?>
<div id="wrap">
    <div id="main">
        
        
        <header>
            <div class="container_16 clearfix">
                <div class="clearfix">
                    <!--<a id="logo" href="http://www.bcnecologia.net" target="_blank"></a>-->
					<div id="logo2">
						<img src="CHESS_SETUP_LOGO 5.png" target="_blank" />
						<label>  </label>
						<img src="ECH2020 4.png" target="_blank" />
					
					<div id="user" class="clearfix">
                        <!--<img src="./users_img/<?php echo $usuari['foto']; ?>" alt="" /> -->
                        <strong class="username">Welcome, <a href="#"><?php echo $_SESSION['usuari']; ?>!</a></strong>
						<!--<strong class="username">Welcome, <a href="#"><?php echo $localusuari; ?>!</a></strong>-->
                        <ul class="piped">
                            <li><a href="logout.php">Log Out</a><br>
							Project:<?php if (isset($_GET['projh'])) echo $_GET['projh']; ?></li>
                        </ul>
                    </div>
				</div>	
                
                
                <nav>
                    <div id="navcontainer" class="clearfix">
                    <div id="navclose"></div>
                    <ul class="sf-menu">
				<li class="<?php if (($_GET['t']=='Start') OR ($_GET['t']=='')) echo "active"; ?>">
                            <a>
                                <span class="icon"><img src="images/menu/tables.png" /></span>
                                <span class="title">File/Start</span>
                            </a>
							<ul>
				<li><a href="home.php?t=Inici">Choose Project/New Project</a></li>
                                
								
							</ul>
                        </li>
						
				<li class="<?php if ($_GET['t']=='External condition') echo "active" ?>">
                            <a href="#">
                                <span class="icon"><img src="images/menu/tables.png" /></span>
                                <span class="title">Climate Condition </span>
                            </a>
							<ul>
							<li><a href="chooselocation.php?t=Inici&projh=<?php echo $projh;?>">Location Choice</a></li>
                            <!--<li><a href="gestio_dades_frecuencia_anual.php?t=anual">Frecuencia anual</a></li>-->
							<!--<li><a href="gestio_dades_frecuencia_mensual.php?t=mensual">Frecuencia mensual</a></li>-->
							<!--<li><a href="gestio_dades_frecuencia_diaria.php?t=diaria">Frecuencia horaria</a></li>-->
							<li><a href="gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=1&projh=<?php echo $projh;?>">Solar Radiation</a></li>
							<li><a href="gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=2&projh=<?php echo $projh;?>">Air Temperature</a></li>
							<li><a href="gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=3&projh=<?php echo $projh;?>">Ground Temperature</a></li>
							<li><a href="gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=8&projh=<?php echo $projh;?>">Irradiation</a></li>
							<!--<li><a href="gestio_dades_frecuencia_total.php?t=diaria">C&agrave;lculs i gr&agrave;fics </a></li>-->
                            </ul>
                        </li>		
				<li class="<?php if ($_GET['t']=='Energy Demand') echo "active"; ?>">
                            <a href="#">
                                <span class="icon"><img src="images/menu/tables.png" /></span>
                                <span class="title">Energy Demand</span>
							</a>
							<ul>
								<li><a href="choosedemand.php?t=Energy&projh=<?php echo $projh;?>">Energy Demand</a></li>
								<li><a href="gestio_dades_frecuencia_anual_energydemand.php?t=Energy&nomdemand=Heating&iddemand=4&demanda=<?php echo $demanda;?>&projh=<?php echo $projh;?>">Heating</a></li>
								<li><a href="gestio_dades_frecuencia_anual_energydemand.php?t=Energy&nomdemand=Hot Water&iddemand=5&demanda=<?php echo $demanda;?>&projh=<?php echo $projh;?>">Hot Water</a></li>
								
								<!--<li><a href="gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=4&projh=<?php echo $projh;?>">Heating</a></li>
								<li><a href="gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=5&projh=<?php echo $projh;?>">Hot Water </a></li>
								
								<li><a href="gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=6&projh=<?php echo $projh;?>">Cooling </a></li>
								<li><a href="gestio_dades_frecuencia_anual_externalcondition.php?t=Monthly Data&tipusdis=7&projh=<?php echo $projh;?>">Electricity </a></li>-->
							</ul>
                        </li>
						<li class="<?php if ($_GET['t']=='Gestio 2') echo "active"; ?>">
                            <a href="#">
                                <span class="icon"><img src="images/menu/tables.png" /></span>
                                <span class="title">System details</span>
							</a>
							<ul>
								
								<!--<li><a href="gestio_dades_sistema.php?t=SystemConfiguration&projh=<?php echo $projh;?>">System configuration</a></li>-->
								<!--<li><a href="gestio_dades_components.php?t=ComponentDetails">Component details</a></li>-->
								<li><a href="gestio_dades_solar.php?t=Component Details&projh=<?php echo $projh;?>">Solar Panels</a></li>
								<li><a href="gestio_dades_seasonal_storage_system.php?t=Component Details&projh=<?php echo $projh;?>">Seasonal Storage System</a></li>
								<li><a href="gestio_dades_heat_pump.php?t=Component Details&projh=<?php echo $projh;?>">Heat Pump</a></li>
								<li><a href="gestio_dades_direct_use_tank.php?t=Component Details&projh=<?php echo $projh;?>">Direct Use Tank</a></li>
								<li><a href="gestio_dades_distribution_system.php?t=Component Details&projh=<?php echo $projh;?>">Distribution System</a></li>
								<li><a href="gestio_dades_auxiliary_energy_source.php?t=Component Details&projh=<?php echo $projh;?>">Auxiliary Energy Source</a></li>

							</ul>
                        </li>
                        <li class="<?php if (($_GET['t']=='Gestió 4') OR ($_GET['t']=='')) echo "active"; ?>">
                            <a href="managereport.php?t=Partes">
                                <span class="icon"><img src="images/menu/dashboard.png" /></span>
                                <span class="title">Economic Data</span>
                            </a>
							<ul>
								
								<li><a href="economicdata.php?t=Economic Data&projh=<?php echo $projh;?>">Economic Data</a></li>
								<li><a href="savings.php?t=Energy Prices&projh=<?php echo $projh;?>">Energy Costs</a></li>
							</ul>
                        </li>
						<?php if($_SESSION['usuari']=="admin")
							{
							?>
                        <li class="<?php if ($_GET['t']=='Usuaris') echo "active" ?>">
                            <a href="#">
                                <span class="icon"><img src="images/menu/tables.png" /></span>
                                <span class="title">User Management</span>
                            </a>
							<ul>
                                <li><a href="showusers.php?t=User Manager"&projh=<?php echo $projh;?>>User Management</a></li>
								<!--<li><a href="generic.php?t=Usuaris">Gestionar usuaris actius</a></li>
								<li><a href="generic.php?t=Usuaris">Gestionar usuaris historics</a></li>-->
								
                            </ul>
                        </li>
						<?php } ?>
						
						
						
                        
			
			
                        <li class="<?php if ($_GET['t']=='Informes') echo "active" ?>">
                            <a href="#">
                                <span class="icon"><img src="images/menu/charts.png" /></span>
                                <span class="title">Results</span>
                            </a>
							<ul>
								<li><a href="validarmotor.php?t=Calculation&projh=<?php echo $projh;?>">RESULT MOTOR</a></li>
								<?php
								if($archivo==1){
								?>
								<li><a href="ResultsMonthlyBalance.php?t=Energy Demand Results&projh=<?php echo $projh;?>">Energy Demand Results</a></li>
								<!--<li><a href="ResultsEnergyDemand.php?t=Results Energy Demand&projh=<?php echo $projh;?>">Results Energy Demand</a></li>-->
								<li><a href="ResultsTemp.php?t=Storage Temperatures&projh=<?php echo $projh;?>">Storage Temperatures</a></li>
								<!--<li><a href="ResultsBalanceEnergia.php?t=Energy Balance&projh=<?php echo $projh;?>">Energy Balance Report</a></li>
								<li><a href="ResultsDT.php?t=Energy Supply&projh=<?php echo $projh;?>">Energy Balance Supply Graph</a></li>
								<li><a href="ResultsDirectUseTank.php?t=Energy Direct Use Tank&projh=<?php echo $projh;?>">Energy Balance Direct Use Tank Graph</a></li>
								<li><a href="ResultsSeasonalStorageSystem.php?t=Energy Seasonal Storage System&projh=<?php echo $projh;?>">Energy Balance Seasonal Storage System Graph</a></li>
								<li><a href="ResultsHeatPump.php?t=Energy Heat Pump&projh=<?php echo $projh;?>">Energy Balance Heat Pump Graph</a></li>-->
								<li><a href="ResultEnergySupply.php?t=Results&projh=<?php echo $projh;?>">Results</a></li>
								<?php
								}
								?>
								
							</ul>
                        </li>
						
                    </ul>
                    </div>
                </nav>
				
                <div id="pagetitle" class="clearfix">
                    <h1 class="left">
                        <?php if ($_GET['t']=='') {
                            echo "Welcome"; 
                        } else {
                            echo ucfirst($_GET['t']);
                        }    
                        ?>
                        
                    </h1>
                </div>
            </div>
			<input type="hidden" name="projh" id="projh" value="<?php echo $projh; ?>">
        </header>
        <div class="container_16 clearfix" id="actualbody">

        
<?php
    $sidebar = 1;
?>