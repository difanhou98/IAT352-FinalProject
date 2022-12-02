<?php 
require("functions.php");
include("nav.php");

use_http();
error_reporting(E_ALL);
ini_set('display_errors',1);
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
<?php 
$id = $_GET['content_id'];
$query_str = "SELECT contents.content_id, contents.name, contents.year, contents.rate, contents.votes, contents.genre, contents.duration, contents.content_type, contents.certificate, contents.episodes, tags.nudity_level, tags.violence_level, tags.profanity_level, tags.alcohol_level, tags.frightening_level FROM contents INNER JOIN tags ON contents.content_id = tags.content_id WHERE contents.content_id = ?";
// $query_str = "SELECT * FROM contents WHERE contents.content_id = ?";
$stmt = $connection->prepare($query_str);
$stmt->bind_param('s',$id);
$stmt->execute();
$stmt->bind_result($content_id, $name, $year, $rate, $votes, $genre, $duration, $type, $certificate, $episodes, $nudity_level, $violence_level, $profanity_level, $alcohol_level, $frightening_level);

//replace . with , for genre (not working)
str_replace('.', ' ,', $genre);

if($stmt->fetch()){
    
    echo "<h3>$name</h3>";
    echo "<p>Released Year: $year</p>\n";
    echo "<p>Rating: $rate</p>\n";
    echo "<p>Votes: $votes</p>\n";
    echo "<p>Genre: $genre</p>\n";
    echo "<p>Duration: $duration mins</p>\n";
    echo "<p>Type: $type</p>\n";
    echo "<p>Certificate: $certificate</p>\n";
    echo "<p>Episodes: $episodes</p>\n";
    echo "<p>Nudity Level: $nudity_level</p>\n";
    echo "<p>Violence Level: $violence_level</p>\n";
    echo "<p>Profanity Level: $profanity_level</p>\n";
    echo "<p>Alcohol Level: $alcohol_level</p>\n";
    echo "<p>Frightening Level: $frightening_level</p>\n";
}

//to do: add to watchlist button

echo "<a class=\"table-link\"href=\"add.php?content_id=".$id . "\">" . "Remove". "</a>";

$stmt->free_result();
$connection->close();
?>
</body>
</html>