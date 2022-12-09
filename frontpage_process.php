<?php
require("functions.php");

use_http();
//stored query string variable
$query_str = "SELECT contents.name, contents.year, contents.rate, contents.votes, contents.content_type, contents.content_id FROM contents";
$query_str_where = "";
$query_str_order = "";
$query_str_limit = " LIMIT 10";
//retrieve data from ajax post 
$type_filter = $_POST['type_filter'];
$popularity_filter = $_POST['popularity_filter'];

//modify query string based on selection
if ($type_filter =="film"){
    $query_str_where = " WHERE content_type = 'film'";
    if ($popularity_filter == "year"){
        $query_str_order = " ORDER BY year DESC";   
    }
    else if ($popularity_filter == "rate"){
        $query_str_order = " ORDER BY rate DESC"; 
    }
    else if ($popularity_filter == "votes"){
        $query_str_order = " ORDER BY votes DESC";
    }
    else {
        $query_str_order = "";
    }
    $query_str .= $query_str_where . $query_str_order. $query_str_limit;
}
else if ($type_filter == "series"){
    $query_str_where = " WHERE content_type = 'series'";
    if ($popularity_filter == "year"){
        $query_str_order = " ORDER BY year DESC";   
    }
    else if ($popularity_filter == "rate"){
        $query_str_order = " ORDER BY rate DESC"; 
    }
    else if ($popularity_filter == "votes"){
        $query_str_order = " ORDER BY votes DESC";
    }
    else {
        $query_str_order = "";
    }
    $query_str .= $query_str_where . $query_str_order . $query_str_limit;
}
else if ($type_filter == "*"){
    $query_str_where = "";
    if ($popularity_filter == "year"){
        $query_str_order = " ORDER BY year DESC";   
    }
    else if ($popularity_filter == "rate"){
        $query_str_order = " ORDER BY rate DESC"; 
    }
    else if ($popularity_filter == "votes"){
        $query_str_order = " ORDER BY votes DESC";
    }
    else {
        $query_str_order = "";
    }
    $query_str .= $query_str_where . $query_str_order  . $query_str_limit;
}

$res = $connection->query($query_str);
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
<?php echo $query_str ?>
<table>
    <tr>
        <th>Name</th>
        <th>Release Year</th>
        <th>Rate</th>
        <th>Votes</th>
        <th>Type</th>
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
            <!-- <th><?php echo $row[5] ?></th> -->
            <th><?php echo "<a class=\"table-link\"href=\"content_detail.php?content_id=".$row[5] ."\">" . "Detail". "</a>"?></th>
        </tr>
    <?php
    }
    $res->free_result();
    $connection->close();
    ?>
</table>
</body>
</html>