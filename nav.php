<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


echo "<div class=\"nav-container\">";
//echo "<img src=\"images/IMDBLogo.png\" class=\"logo\"";
echo "<div class=\"nav-item\"><a href=\"frontpage.php\">Home</a></div>";
echo "<div class=\"nav-item\"><a href=\"search.php\">Search</a></div>";
echo "<div class=\"nav-item\"><a href=\"watchlist.php\">Watchlist</a></div>";
echo "<div class=\"nav-item\"><a href=\"edit_user.php\">edit user</a></div>";
echo "<div class=\"nav-item\">";
        if (!isset($_SESSION['valid_user'])){
            
            echo "<a href=\"login.php\">Log In</a>";
        }
        else{
            echo "<a href=\"signout.php\">Sign Out</a>";
        }       
echo "</div></div>";
?>