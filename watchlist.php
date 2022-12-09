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

$query_str = "SELECT contents.name, contents.year, contents.rate, contents.votes, contents.content_type, contents.genre, tags.nudity_level, tags.violence_level, tags.profanity_level, tags.alcohol_level, tags.frightening_level, contents.content_id, watchlists.date_added FROM contents INNER JOIN tags ON contents.content_id = tags.content_id INNER JOIN watchlists ON contents.content_id = watchlists.content_id WHERE watchlists.email = ?";


$stmt = $connection->prepare($query_str);
// echo $_SESSION['valid_user'];
$stmt->bind_param('s',$_SESSION['valid_user']);
if ($stmt){
$stmt->execute();
$result = $stmt->get_result();

}
// else {
//     echo "empty";
// }

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
    <script src="jquery.js"></script>
    <script src="js/remove.js"></script>
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
        <th>Date Added</th>
    </tr>
    <?php 
    while (($row = $result->fetch_assoc())){
    ?>
    <tr class="content-row">
            <th><?php echo $row['name'] ?></th>
            <th><?php echo $row['year'] ?></th>
            <th><?php echo $row['rate'] ?></th>
            <th><?php echo $row['votes'] ?></th>
            <th><?php echo $row['content_type'] ?></th>
            <th><?php echo $row['genre'] ?></th>
            <th><?php echo $row['nudity_level'] ?></th>
            <th><?php echo $row['violence_level'] ?></th>
            <th><?php echo $row['profanity_level'] ?></th>
            <th><?php echo $row['alcohol_level'] ?></th>
            <th><?php echo $row['frightening_level'] ?></th>
            <th><?php echo $row['date_added'] ?></th>
            <!-- <th><?php echo $row[12] ?></th> -->
            <th><?php echo "<a class=\"table-link\"href=\"content_detail.php?content_id=".$row['content_id'] . "\">" . "Detail". "</a>"?></th>
            <th><?php echo "<a class=\"" . $row['content_id'] ." delete-button\"". " href=\"remove.php\">" . "Remove". "</a>"?></th>
        </tr>
    <?php
    }
    $stmt->free_result();
    $connection->close();
    echo "<p id='msg'></p>";
    ?>
</table>

</body>
</html>