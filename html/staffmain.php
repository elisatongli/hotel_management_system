<?php

session_start();

$user = $_SESSION['username'];

echo "Welcome ".$user;

include ("staffreport.php");




?>