<!doctype html>
<html>
<head>
<?php
	require_once("logincheck.php");
?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
	
	<link rel="stylesheet" type="text/css" href="style/style.css" />
        <link rel="stylesheet" type="text/css" href="style/fixed.css" title="fixed" media="screen" />
	
	<title>Chess Setup Simulator</title>

        <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <!--[if !IE 7]><style>#wrap {display:table;height:100%}</style><![endif]-->

</head>
<body id="loginpage">

        <div class="container_16 clearfix">
            <div class="push_5 grid_6">
                <!--<a href="#"><img src="images/logo-BCNecologia-340x77.png" ></a>-->
				<a href="#"><img src="CHESS_SETUP_LOGO 5.png" ></a>
            </div>
            <div class="clear"></div>
            <div class="widget push_5 grid_6" id="login">
                <div class="widget_title">
                    <h2>CHESS SETUP SIMULATOR</h2>
                </div>
                <div class="widget_body">
                    <div class="widget_content">
                        <form method="POST" action="validar.php">
						<label class="block" for="usuari">User:</label>
                        <input type="text" name="usuari" class="large"/>
                        <label class="block" for="password">Password:</label>
                        <input type="password" name="password" class="large" />

                        <div style="margin-top:10px">
                            <input type="submit" class="btn blue right" name="submit" value="Entrar">
                        </div>
						</form>
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

        </div>
    </div> <!-- main -->
</div> <!-- wrap -->

</body>
</html>

        