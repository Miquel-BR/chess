<?php
error_reporting(0);
session_start();
if ($_SESSION['validat']=="ok") 
    header("location:home.php?t=Inici");
?> 