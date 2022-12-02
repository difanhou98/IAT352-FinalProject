<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('functions.php');
session_destroy();
direct_to("index.php");
?>