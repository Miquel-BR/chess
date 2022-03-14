<?php

//$con = mysql_connect("localhost","rongilmo_ron","******");
//if(!$con) { die('Could not connect: ' . mysql_error()); }
//mysql_select_db("rongilmo_databases", $con);
$sub = $_POST['theDropdown'];

//$q = "SELECT dbs.db_name, dbs.db_url FROM dbs, subjects, subjects_databases
//WHERE subjects.subject_id=subjects_databases.subject_id
//AND subjects_databases.database_id=dbs.db_id
//AND subjects.subject_name='$sub'";

//$r = mysql_query($q);
//$array = mysql_fetch_row($r);
echo "Hola";

?>