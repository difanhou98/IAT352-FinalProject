<?php

session_start();
$connection = connect('localhost', 'root', '', 'imdb');

//http connection
function use_http(){
    if(isset($_SERVER['HTTPS']) &&  $_SERVER['HTTPS']== "on") {
        header("Location: http://" . $_SERVER['HTTP_HOST'] .
            $_SERVER['REQUEST_URI']);
        exit();
    }
}
//https connection
function use_https() {
	if($_SERVER['HTTPS'] != "on") {
		header("Location: https://" . $_SERVER['HTTP_HOST'] .
			$_SERVER['REQUEST_URI']);
		exit();
	}
}

//connection to db
function connect($dbhost, $dbuser, $dbpass, $dbname) {
    $connection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

    if (mysqli_connect_errno()){
        die(mysqli_connect_error());
    }
    return $connection;
}

//page redirect
function direct_to($url){
    header('Location: ' . $url);
    exit;
}

function is_logged_in(){
    return isset($_SESSION['valid_user']);
}

function is_in_watchlist($content_id){
    global $connection;
    if (isset($_SESSION['valid_user'])){
        $query = "SELECT COUNT(*) FROM watchlists WHERE user_id=? AND content_id=?";
        $stmt = $connection->prepare($query);
        if ($stmt != false){
            $stmt->bind_param("ss", $_SESSION['valid_user'], $content_id);
            $stmt->execute();
            $stmt->bind_result($count);
            return ($stmt->fetch() && $count > 0);
        }
    }
    if (!empty($stmt)){
    $stmt->free_result();
    }
    return false;
    
}
?>

