<?php 
require("functions.php");
$id = $_GET['content_id'];
$query_str = "DELETE FROM watchlists WHERE content_id = $id AND email = ?";

$stmt = $connection->prepare($query_str);
$stmt->bind_param('s',$_SESSION['valid_user']);
$stmt->execute();
$stmt->free_result();
$connection->close();

?>