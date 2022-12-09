<?php
require ("functions.php");

if (isset($_SESSION))
$query_str = "SELECT contents.name, contents.year, contents.rate, contents.votes, contents.content_type, contents.genre, tags.nudity_level, tags.violence_level, tags.profanity_level, tags.alcohol_level, tags.frightening_level, contents.content_id FROM contents INNER JOIN tags ON contents.content_id = tags.content_id";

$query_str_where = "";
$query_str_order = "";
//retrieve data from ajax post 
$keyword = $_POST['keyword'];
$category_arr = $_POST['category_arr'];
$nudity_level = $_POST['nudity_filter'];
$violence_level = $_POST['violence_filter'];
$profanity_level = $_POST['profanity_filter'];
$alcohol_level = $_POST['alcohol_filter'];
$frightening_level = $_POST['frightening_filter'];
$type_filter = $_POST['type_filter'];
$popularity_filter = $_POST['popularity_filter'];

//keyword query
if (!empty($keyword)){
    $query_str_where .= " WHERE contents.name LIKE '%$keyword'";
}

//category query (genre)
foreach ($category_arr as $value){
    //check if where clause is empty to add AND accordingly
    if (!empty($query_str_where)){
        $query_str_where .= " AND contents.genre LIKE '%$value%'";
    }
    else {
        $query_str_where .= " WHERE contents.genre LIKE '%$value%'";
    }
}
// nudity_level query
if ($nudity_level != "default"){
    if (!empty($query_str_where)){
        $query_str_where .= " AND tags.nudity_level = '$nudity_level'";
    }
    else {
        $query_str_where .= " WHERE tags.nudity_level = '$nudity_level'";
    }
}

// violence_level query
if ($violence_level != "default"){
    if (!empty($query_str_where)){
        $query_str_where .= " AND tags.violence_level = '$violence_level'";
    }
    else {
        $query_str_where .= " WHERE tags.violence_level = '$violence_level'";
    }
}

// profanity_level query
if ($profanity_level != "default"){
    if (!empty($query_str_where)){
        $query_str_where .= " AND tags.profanity_level = '$profanity_level'";
    }
    else {
        $query_str_where .= " WHERE tags.profanity_level = '$profanity_level'";
    }
}

// alcohol_level query
if ($alcohol_level != "default"){
    if (!empty($query_str_where)){
        $query_str_where .= " AND tags.alcohol_level = '$alcohol_level'";
    }
    else {
        $query_str_where .= " WHERE tags.alcohol_level = '$alcohol_level'";
    }
}

// frightening_level query
if ($frightening_level != "default"){
    if (!empty($query_str_where)){
        $query_str_where .= " AND tags.frightening_level = '$frightening_level'";
    }
    else {
        $query_str_where .= " WHERE tags.frightening_level = '$frightening_level'";
    }
}
// type query
if ($type_filter == "film" || $type_filter == "series"){
    if (!empty($query_str_where)){
        $query_str_where .= " AND contents.content_type = '$type_filter'";
    }
    else {
        $query_str_where .= " WHERE contents.content_type = '$type_filter'";
    }
}

// popularity query
if ($popularity_filter == "year"){
    $query_str_order = " ORDER BY contents.year DESC";  
}
else if ($popularity_filter == "rate"){
    $query_str_order = " ORDER BY contents.rate DESC"; 
}
else if ($popularity_filter == "votes"){
    $query_str_order = " ORDER BY contents.votes DESC";
}

//combine query string for process
$query_str .= $query_str_where . $query_str_order;

$res = $connection->query($query_str);

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
            <th><?php echo "<a class=\"table-link\"href=\"content_detail.php?content_id=".$row[12] ."&message=\"\"" . "\">" . "Detail". "</a>"?></th>
        </tr>
    <?php
    }
    $res->free_result();
    $connection->close();
    ?>
</table>
</body>
</html>