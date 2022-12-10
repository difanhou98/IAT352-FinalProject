<?php
require ("functions.php");
error_reporting(E_ALL);
ini_set('display_errors',1);

//if (isset($_SESSION))
//clear all search results stored by previous search
$clear_table = "DELETE FROM `search_results`";
$res = $connection->query($clear_table);


//prepare query
$query_str = "INSERT INTO search_results (name, year, rate, votes, content_type, genre, nudity_level, violence_level, profanity_level, alcohol_level, frightening_level, content_id) SELECT contents.name, contents.year, contents.rate, contents.votes, contents.content_type, contents.genre, tags.nudity_level, tags.violence_level, tags.profanity_level, tags.alcohol_level, tags.frightening_level, contents.content_id FROM contents INNER JOIN tags ON contents.content_id = tags.content_id";

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
//add result into search_results for pagination
$res2 = $connection->query($query_str);
//$res2->free_result();
echo $query_str;


//assign pagination related variable
$content_per_page = 10;
$page = '';
$output = '';
if(isset($_POST["page"])){
    $page = $_POST["page"];
}
else {
    $page = 1;
}
//define which row to start displaying
$start_from = ($page - 1) * $content_per_page;

//prepare query for display
$query_display = "SELECT * FROM search_results LIMIT $start_from, $content_per_page";
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
    while ($row = $res2->fetch_row()){
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
            <th><?php echo "<a class=\"table-link\"href=\"content_detail.php?content_id=".$row[12] ."&message=\"\"" . "\">" . "Detail". "</a>"?></th>
        </tr>
    <?php
    }
    $res2->free_result();

    //get total number of contents and calculate total pages needed for pagination
    $query_page = "SELECT * FROM search_results";
    $res = $connection->query($query_page);
    $total_rows = $res->num_rows;
    //total pages needed
    $total_pages = ceil($total_rows/$content_per_page);
    ?>
</table>
<?php 
for ($i= 1; $i<=$total_pages; $i++){
    echo "<span class='pagination-link' id='".$i."'>".$i."</span>";
}
$res->free_result();
$connection->close();
?>
</body>
</html>

<!-- <script>
$(document).ready(function(){
    load_data();
    function load_data(page){
        $.ajax({
            url:"search_process2.php",
            method:"POST",
            data:{page:page},
            success:function(data){
                $("#search-table").html(data);
            }
        })
    }
})
</script> -->