<?php
require("functions.php");
include("nav.php");
use_http();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery.js"></script>
    <script src="js/frontpage.js"></script>
    <title>Document</title>
</head>
<body>
<h1 id="ranking-title">Top 10 Most Voted Contents</h1>

<!-- filtered by content types -->
<div>
    <label for="type-filter">Content Type:</label>
    <select name="type-filter" id="type-filter">
        <option value="*" selected>All</option>
        <option value="film" >Film</option>
        <option value="series">Series</option>
    </select>
</div>

<!-- ranked by rating and votes -->
<div>
    <label for="popularity-filter">Ranked By:</label>
    <select name="popularity-filter" id="popularity-filter">
        <option value="none">None</option>
        <option value="year">Published Year</option>
        <option value="rate" >Rate</option>
        <option value="votes" selected>Votes</option>
    </select>
</div>

<div>
    <table id="frontpage-table">
    <tr>
            <th>Name</th>
            <th>Release Year</th>
            <th>Rate</th>
            <th>Votes</th>
            <th>Type</th>
            <th>Link</th>
        </tr>
    <?php 
    $query_str = "SELECT name, year, rate, votes, content_type,content_id FROM contents";
    $res = $connection->query($query_str);
    while ($row = $res->fetch_row()){
    ?>
        
        <tr>
            <th><?php echo $row[0] ?></th>
            <th><?php echo $row[1] ?></th>
            <th><?php echo $row[2] ?></th>
            <th><?php echo $row[3] ?></th>
            <th><?php echo $row[4] ?></th>
            <th><?php echo "<a class=\"table-link\"href=\"content_detail.php?content_id=".$row[5] . "\">" . "Detail". "</a>"?></th>
        </tr>
    <?php 
    }
    $res->free_result();
    $connection->close();
    ?>
    </table>
</div>
</body>
</html>