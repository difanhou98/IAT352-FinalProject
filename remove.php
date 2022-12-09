<?php 
require('functions.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$message = "";
if (!empty($_POST['content_id']) && !empty($_SESSION['valid_user'])){
    $query = "DELETE FROM watchlists WHERE email=? AND content_id =?";
    $stmt = $connection->prepare($query);
	$stmt->bind_param('ss',$_SESSION['valid_user'],$_POST['content_id']);
	$stmt->execute();
			  
	$message = "The model has been removed from to your <a href=\"showwatchlist.php\">watchlist</a>.";
    $connection->close();
    $stmt->free_result();
}
else {
    $id_status = "not empty";
    if (empty($_POST['content_id'])){
        $id_status = "empty";
    }
    
    $user_status = empty($_SESSION['valid_user']);
    echo $id_status;
    //echo $user_status;
    //echo $message;
}
?>
