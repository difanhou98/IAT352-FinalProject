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
    <script src="js/search.js"></script>
    <title>Document</title>
</head>
<body>
<!-- <form action="" method="POST" id="search-form"> -->
<!-- keyword search -->
<div>
    <input type="text" name="keyword" id="keyword" placeholder="Keyword">
</div>
<!-- categories checkbox -->
<div>
    <input type="checkbox" name="category" value="Action" id="action">
    <label for="action">action</label><br>
    <input type="checkbox" name="category" value="Crime" id="crime">
    <label for="action">crime</label><br>
    <input type="checkbox" name="category" value="Drama" id="drama">
    <label for="action">drama</label><br>
    <input type="checkbox" name="category" value="Comedy" id="comedy">
    <label for="action">comedy</label><br>
    <input type="checkbox" name="category" value="Horror" id="horror">
    <label for="action">horror</label><br>
    <input type="checkbox" name="category" value="Romance" id="romance">
    <label for="action">romance</label><br>
</div>

<!-- content type -->
<div>
    <label for="type-filter">Content Type:</label>
    <select name="type-filter" id="type-filter">
        <option value="*" selected>All</option>
        <option value="film" >Film</option>
        <option value="series">Series</option>
    </select>
</div>

<!-- nudity tags -->
<div>
    <label for="nudity-filter">Nudity</label>
    <select name="nudity-filter" id="nudity-filter">
        <option value="default" selected>/</option>
        <option value="None">None</option>
        <option value="Mild">Mild</option>
        <option value="Moderate" >Moderate</option>
        <option value="Severe" >Severe</option>
        <option value="No Rate">No Rate</option>
    </select>
</div>

<!-- violence tags -->
<div>
    <label for="voilence-filter">Violence</label>
    <select name="violence-filter" id="violence-filter">
        <option value="default" selected>/</option>
        <option value="None">None</option>
        <option value="Mild">Mild</option>
        <option value="Moderate" >Moderate</option>
        <option value="Severe" >Severe</option>
        <option value="No Rate">No Rate</option>
    </select>
</div>

<!-- profanity tags -->
<div>
    <label for="profanity-filter">Profanity</label>
    <select name="profanity-filter" id="profanity-filter">
        <option value="default" selected>/</option>
        <option value="None">None</option>
        <option value="Mild">Mild</option>
        <option value="Moderate" >Moderate</option>
        <option value="Severe" >Severe</option>
        <option value="No Rate">No Rate</option>
    </select>
</div>

<!-- alcohol tags -->
<div>
    <label for="alcohol-filter">Alcohol</label>
    <select name="alcohol-filter" id="alcohol-filter">
        <option value="default" selected>/</option>
        <option value="None">None</option>
        <option value="Mild">Mild</option>
        <option value="Moderate" >Moderate</option>
        <option value="Severe" >Severe</option>
        <option value="No Rate">No Rate</option>
    </select>
</div>

<!-- frightening tags -->
<div>
    <label for="frightening-filter">Frightening</label>
    <select name="frightening-filter" id="frightening-filter">
        <option value="default" selected>/</option>
        <option value="None">None</option>
        <option value="Mild">Mild</option>
        <option value="Moderate" >Moderate</option>
        <option value="Severe" >Severe</option>
        <option value="No Rate">No Rate</option>
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
<!-- </form> -->

<!-- submit button -->
<button type="submit" value="Submit" id="search-button">Search</button>

<!-- table -->
<table id="search-table"></table>
</body>
</html>