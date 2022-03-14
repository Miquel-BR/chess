<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
	
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<link rel="stylesheet" type="text/css" href="style/fluid.css" title="fluid" media="screen" />
        
	<title>Chameleon Circuit | Admin Panel from Themio</title>
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
        <script type="text/javascript" src="js/styleswitch.js"></script>

        <script type="text/javascript" src="js/fullcalendar.min.js"></script>
        <script type="text/javascript" src="js/jquery.uploadify.v2.1.4.min.js"></script>
        <script type="text/javascript" src="js/uploadify.js"></script>
        <script type="text/javascript" src="js/jquery.tipsy.js"></script>

        <script type="text/javascript" src="js/gcal.js"></script>
        <script type="text/javascript" src="js/swfobject.js"></script>
        <script type="text/javascript" src="js/jquery.pnotify.min.js"></script>
        <script type="text/javascript" src="js/examples.js"></script>

        <script type="text/javascript" src="js/sidemenu.js">// Strictly for sidebar </script>

        <!-- Toolbar for Demo Only -->
        <link rel="stylesheet" type="text/css" href="demo/toolbar.css" />
        <link rel="stylesheet" media="screen" type="text/css" href="demo/colorpicker/css/colorpicker.css" />
        <script type="text/javascript" src="demo/colorpicker/js/colorpicker.js"></script>
        <!-- Demo js Only -->
        <script type="text/javascript" src="js/demo.js"></script>

        <!--[if lt IE 9]>
            <script type="text/javascript" src="js/html5.js"></script>
        <![endif]-->
        
        <!--[if IE 7]>
            <link rel="stylesheet" type="text/css" href="style/IE7.css" />
        <![endif]-->

	

</head>
<body>

    <div id="sidebar">
        <nav>
            <div id="user" class="clearfix">
                <img src="demo/avatar.png" alt="" />
                <strong class="username">Welcome, <a href="#">Administrator</a></strong>
                <ul class="piped">
                    <li><a href="#">My Account</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </div>
            <ul id="sidemenu">
                <li class="<?php if (($_GET['t']=='dashboard') OR ($_GET['t']=='')) echo "active"; ?>">
                    <a href="home.php?sidebar" class="clearfix">
                        <span class="icon"><img src="images/menu/dashboard.png" /></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="<?php if ($_GET['t']=='tables') echo "active" ?>">
                    <a href="tables.php?sidebar&t=tables" class="clearfix">
                        <span class="icon"><img src="images/menu/tables.png" /></span>
                        <span class="title">Tables</span>
                    </a>
                </li>
                <li class="<?php if ($_GET['t']=='form Elements') echo "active" ?>">
                    <a href="forms.php?sidebar&t=form+Elements" class="clearfix">
                        <span class="icon"><img src="images/menu/form.png" /></span>
                        <span class="title">Form Elements</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="clearfix">
                        <span class="icon"><img src="images/menu/styles.png" /></span>
                        <span class="title">Styles</span>
                    </a>
                        <ul>
                            <li><a href="home.php">Close Sidebar</a></li>
                            <li><a href="home.php">Close Sidebar</a></li>
                            <li><a href="home.php">Close Sidebar</a></li>
                        </ul>
                </li>
                <li class="<?php if ($_GET['t']=='pages') echo "active" ?>">
                    <a href="pages.php?sidebar&t=pages" class="clearfix">
                        <span class="icon"><img src="images/menu/pages.png" /></span>
                        <span class="title">Sample Pages</span>
                    </a>
                </li>
                <li class="<?php if ($_GET['t']=='gallery') echo "active" ?>">
                    <a href="gallery.php?sidebar&t=gallery" class="clearfix">
                        <span class="icon"><img src="images/menu/gallery.png" /></span>
                        <span class="title">Gallery</span>
                    </a>
                </li>
                <li class="<?php if ($_GET['t']=='charts') echo "active" ?>">
                    <a href="charts.php?sidebar&t=charts" class="clearfix">
                        <span class="icon"><img src="images/menu/charts.png" /></span>
                        <span class="title">Statistics</span>
                    </a>
                </li>
                <li class="sep" class="clearfix">
                    <a href="" class="clearfix">
                        <span class="icon"><img src="images/menu/settings.png" /></span>
                        <span class="title">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="clearfix">
                        <span class="notification">3</span>
                        <span class="icon"><img src="images/menu/msg.png" /></span>
                        <span class="title">Messages</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

<div id="wrap" class="sidebarred">
    <div id="main">
        
        <div id="toolbar"> <!-- used for demo purpose only. Remove -->
            <div class="container_16 clearfix">
                <div class="grid_4">
                    <span class="left">Header Color</span> <div id="in-header" class="picker"></div>
                </div>
                <div class="grid_4">
                    <span class="left">Navigation Color</span> <div id="in-nav" class="picker"></div>
                </div>
                <div class="grid_4">
                    <span class="left">Widget Color</span> <div id="in-widget" class="picker"></div>
                </div>
                <div class="grid_4">
                    <span class="left">Select Preset</span> 
                        <select name="colors" id="colorChanger">
                            <option value="222936,162033,222936">Dark Azure</option>
                            <option value="300108,4D0713,000000">Royal Red</option>
                            <option value="1b282b,1b4352,212121">Ice Blue</option>
                            <option value="000F1F,002047,1c1c1c">Bright Navy</option>
                            <option value="022100,002e21,373823">Green Earth</option>
                            <option value="210a00,470f01,2e2e2e">Saffron</option>
                            <option value="070021,140e42,1f1c42">Indigo</option>
                            <option value="1a150e,5c1d06,524235">Chocolate Brown</option>
                            <option value="000000,3a093d,7a7a7a">Purple Black</option>
                            <option value="000000,000000,000000">Pure Black</option>
                        </select>
                </div>
            </div>
        </div>
        
        <header>
            <div class="container_16 clearfix">
                <div class="clearfix">
                    <a id="logo" href="index.php?t=dashboard"></a>
                    <input type="text" class="search" title="Search..."/>
                </div>
                
                
                <div id="pagetitle" class="clearfix">
                    <h1 class="left">
                        <?php if ($_GET['t']=='') {
                            echo "Dashboard"; 
                        } else {
                            echo ucfirst($_GET['t']);
                        }    
                        ?>
                        
                    </h1>
                    <a class="btn grey right medium"><span>View Site</span></a>
                </div>
            </div>
        </header>
        <div class="container_16 clearfix" id="actualbody">

        
