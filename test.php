<?php 
if (isset($_SESSION['valid_user'])){
    echo "<div>";
    echo "<label for=\"user-custom-filter\">Ranked By</label>";
    echo "<select name=\"user-custom-filter\" id=\"user-custom-filter\">";
    echo "<option value=\"votes\" selected>Votes</option>";
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
        echo "<table id=\"frontpage-table\">";
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
            echo "<th><?php echo $row_user[0] ?></th>";
            echo "<th><?php echo $row_user[1] ?></th>";
            echo "<th><?php echo $row_user[2] ?></th>";
            echo "<th><?php echo $row_user[3] ?></th>";
            echo "<th><?php echo $row_user[4] ?></th>";
            echo "<th><a class=\"table-link\"href=\"content_detail.php?content_id= $row_user[5]>" . "Detail". "</a></th>";
            echo "</tr>";
            $res_user->free_result();
        }
        echo "</table>"; 
    }
    else {
        echo "<p>Watchlist is currently Empty!</p>";
    }
}

?>
