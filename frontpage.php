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
    <script src="js/user_frontpage.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>

<!-- registered user customization chart page -->
<?php 
$count = 0;
if (isset($_SESSION['valid_user'])){
    echo "<div>";
    echo "<label for=\"user-custom-filter\">Ranked By</label>";
    echo "<select name=\"user-custom-filter\" id=\"user-custom-filter\">";
    echo "<option value=\"none\" selected>None</option>";
    echo "<option value=\"year\" >Published Year</option>";
    echo "<option value=\"votes\" >Votes</option>";
    echo "<option value=\"rate\" >Rate</option>";
    echo "<option value=\"date_added\">Date Added</option>";
    echo "</select>";
    echo "</div>";
    
    $query_str_count = "SELECT COUNT(*) from watchlists WHERE email =?";
    $stmt_user = $connection->prepare($query_str_count);
    $stmt_user->bind_param("s", $_SESSION['valid_user']);
    $stmt_user->execute();
    $stmt_user->bind_result($count);
    $stmt_user->fetch();
    $stmt_user->free_result();
    //display table if count is not 0
    if ($count != 0){
        echo "watchlist not empty";
        $query_str_user = "SELECT contents.name, contents.year, contents.rate, contents.votes, watchlists.date_added, watchlists.content_id FROM contents INNER JOIN watchlists ON contents.content_id = watchlists.content_id ";
        echo "<table id=\"user-custom-table\">";
        echo "<tr>";
        echo "<th>Name</th>";
        echo "<th>Release Year</th>";
        echo "<th>Rate</th>";
        echo "<th>Votes</th>";
        echo "<th>Date Added</th>";
        echo "<th>Link</th>";
        echo "</tr>";
        $res_user = $connection->query($query_str_user);
        while ($row_user = $res_user->fetch_row()){
            echo "<tr>";
            echo "<th>$row_user[0]</th>";
            echo "<th>$row_user[1]</th>";
            echo "<th>$row_user[2]</th>";
            echo "<th>$row_user[3]</th>";
            echo "<th>$row_user[4]</th>";
            echo "<th><a class=\"table-link\"href=\"content_detail.php?content_id=$row_user[5]\">" . "Detail". "</a></th>";
            echo "</tr>";
            
        }
        echo "</table>"; 
        $res_user->free_result();
        //$connection->close();
    }
    else {
        echo "<p>Watchlist is currently Empty!</p>";
    }
}

?>

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
    $query_str = "SELECT name, year, rate, votes, content_type,content_id FROM contents LIMIT 10";
    $res = $connection->query($query_str);
    while ($row = $res->fetch_row()){
    ?>
        
        <tr>
            <th><?php echo $row[0] ?></th>
            <th><?php echo $row[1] ?></th>
            <th><?php echo $row[2] ?></th>
            <th><?php echo $row[3] ?></th>
            <th><?php echo $row[4] ?></th>
            <th><?php echo "<a class=\"table-link\"href=\"content_detail.php?content_id= $row[5]  \">" . "Detail". "</a>"?></th>
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