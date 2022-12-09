<?php 
require("functions.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
// $email = $_SESSION['valid_user'];
// $id = $_POST['content_id'];
// $date_added = $_POST['date_added'];

// $query_str = "INSERT INTO watchlists (email, content_id) VALUES (?, ?, ?)";

// $stmt = $connection->prepare($query_str);
// $stmt->bind_param('sss',$_SESSION['valid_user'], $id, $date_added);
// $stmt->execute();
// $stmt->free_result();
// $connection->close();

if (isset($_POST['content_id'])){
$content_id = $_POST['content_id'] ;
}
else {
	echo "empty";
}

$date_added = $_POST['date_added'];

if(!isset($_SESSION['valid_user'])) {
	$_SESSION['callback_url'] = 'add.php';
	$_SESSION['content_id'] = $content_id;
	direct_to('login.php');
} 

$email = $_SESSION['valid_user'];
if (isset($_SESSION['callback_url']) && $_SESSION['callback_url'] == 'add.php') {
	$content_id = $_SESSION['content_id'];
	unset($_SESSION['callback_url'],$_SESSION['content_id']);
}

$message = "";
if (!is_in_watchlist($content_id)) {
    
	$query = "INSERT INTO watchlists (email, content_id, date_added) VALUES (?,?,?)";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('sss',$email,$content_id,$date_added);
	$stmt->execute();
	if ($connection->error) {
		die($connection->error);
	}
	$message = "The model has been added to your <a href=\"watchlist.php\">watchlist</a>.";
}
echo $message;
//page wont direct
//fetch the watchlist for the user
//direct_to("content_detail.php?content_id=$content_id&message=$message");


?>

