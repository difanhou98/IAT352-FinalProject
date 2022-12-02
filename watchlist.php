<?php
require("functions.php");
include("nav.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_SESSION['valid_user']) || empty($_SESSION['valid_user'])) {
	$_SESSION['callback_url'] = 'watchlist.php';
	direct_to('login.php');
} 
$email = $_SESSION['valid_user'];
if (isset($_SESSION['callback_url']) && $_SESSION['callback_url'] == 'watchlist.php') {
	unset($_SESSION['callback_url']);
}

$query_str = "SELECT contents.name, contents.year, contents.rate, contents.votes, contents.content_type, contents.genre, tags.nudity_level, tags.violence_level, tags.profanity_level, tags.alcohol_level, tags.frightening_level, contents.content_id, watchlists.date_added FROM contents INNER JOIN tags ON contents.content_id = tags.content_id INNER JOIN watchlists ON contents.id = watchlists.content_id WHERE watchlists.email = ?";

$stmt = $connection->prepare($query_str);
$stmt->bind_param('s',$_SESSION['valid_user']);
$stmt->execute();


if ($connection->error) {
    die($connection->error);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php echo $query_str;?>
<table>
    <tr>
        <th>Name</th>
        <th>Release Year</th>
        <th>Rate</th>
        <th>Votes</th>
        <th>Type</th>
        <th>Genre</th>
        <th>Nudity Level</th>
        <th>Violence Level</th>
        <th>Profanity Level</th>
        <th>Alcohol Level</th>
        <th>Frightening Level</th>
        <th>Link</th>
        <th>Date Added</th>
        <th>Remove From List</th>
    </tr>
    <?php 
    while ($row = $res->fetch_row()){
    ?>
    <tr>
            <th><?php echo $row[0] ?></th>
            <th><?php echo $row[1] ?></th>
            <th><?php echo $row[2] ?></th>
            <th><?php echo $row[3] ?></th>
            <th><?php echo $row[4] ?></th>
            <th><?php echo $row[5] ?></th>
            <th><?php echo $row[6] ?></th>
            <th><?php echo $row[7] ?></th>
            <th><?php echo $row[8] ?></th>
            <th><?php echo $row[9] ?></th>
            <th><?php echo $row[10] ?></th>
            <th><?php echo $row[11] ?></th>
            <!-- <th><?php echo $row[12] ?></th> -->
            <th><?php echo "<a class=\"table-link\"href=\"content_detail.php?content_id=".$row[12] . "\">" . "Detail". "</a>"?></th>
            <th><?php echo "<a class=\"table-link\"href=\"detele.php?content_id=".$row[12] . "\">" . "Remove". "</a>"?></th>
        </tr>
    <?php
    }
    $res->free_result();
    $connection->close();
    ?>
</table>
</body>
</html>