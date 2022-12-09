<?php
require("functions.php");

use_http();
use_http();
error_reporting(E_ALL);
ini_set('display_errors',1);
//stored query string variable
$query_str_user = "SELECT contents.name, contents.year, contents.rate, contents.votes, watchlists.date_added, watchlists.content_id FROM contents INNER JOIN watchlists ON contents.content_id = watchlists.content_id";
$query_str_order = "";

//retrieve data from ajax post 
$user_custom_filter = $_POST['user_custom_filter'];

//modify query string based on selection

if ($user_custom_filter =="year"){
    $query_str_order = " ORDER BY contents.year DESC";
}
else if ($user_custom_filter =="votes"){
    $query_str_order = " ORDER BY contents.votes DESC";
}
else if ($user_custom_filter =="rate"){
    $query_str_order = " ORDER BY contents.rate DESC";
}
else if ($user_custom_filter =="date_added"){
    $query_str_order = " ORDER BY watchlists.date_added DESC";
}
else {
    $query_str_order = "";
}

$query_str_user .= $query_str_order;



$res = $connection->query($query_str_user);
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
<?php echo $query_str_user ?>
<table>
    <tr>
        <th>Name</th>
        <th>Release Year</th>
        <th>Rate</th>
        <th>Votes</th>
        <th>Date Added</th>
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
            <th><?php echo "<a class=\"table-link\"href=\"content_detail.php?content_id=\"".$row[5]."\">" . "Detail". "</a>"?></th>
        </tr>
    <?php
    }
    $res->free_result();
    $connection->close();
    ?>
</table>
</body>
</html>