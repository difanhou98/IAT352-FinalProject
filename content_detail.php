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
    <script src="jquery.js"></script>
    <script src="js/add.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
<?php 
if (isset($_GET['content_id'])){
$id = $_GET['content_id'];
}
$query_str = "SELECT contents.content_id, contents.name, contents.year, contents.rate, contents.votes, contents.genre, contents.duration, contents.content_type, contents.certificate, contents.episodes, tags.nudity_level, tags.violence_level, tags.profanity_level, tags.alcohol_level, tags.frightening_level FROM contents INNER JOIN tags ON contents.content_id = tags.content_id WHERE contents.content_id = ?";
// $query_str = "SELECT * FROM contents WHERE contents.content_id = ?";
$stmt = $connection->prepare($query_str);
$stmt->bind_param('s',$id);
$stmt->execute();
$stmt->bind_result($content_id, $name, $year, $rate, $votes, $genre, $duration, $type, $certificate, $episodes, $nudity_level, $violence_level, $profanity_level, $alcohol_level, $frightening_level);

//replace . with , for genre (not working)
//str_replace('.', ' ,', $genre);

if($stmt->fetch()){
    
    echo "<h3>$name</h3>";
    echo "<p>Released Year: $year</p>\n";
    echo "<p>Rating: $rate</p>\n";
    echo "<p>Votes: $votes</p>\n";
    echo "<p>Genre: ". str_replace('.', ' ,', $genre). "</p>\n";
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
$stmt->free_result();
//to do: add to watchlist button

//problem: addtowatchlist button still shows after user refresh the page
if (is_logged_in()){
    if (!is_in_watchlist($id)){
        echo "<form method=\"post\">\n";
        echo "<input type=\"submit\" class=$id action =\"add.php\"
    id=\"add-button\" value=\"Add To Watchlist\">";
        echo "</form>\n";
    // $id_status = is_in_watchlist($id);
    // if ($id_status){
    // echo "in";
    // }
    // else {
    //     echo "not in";
    //     echo $id;
    // }
    }
    else {
        echo "This model is already in your <a href=\"watchlist.php\">watchlist</a>.";
    }
}
else {
    echo "not logged in";
}

echo "<p id='msg'></p>";
$stmt->free_result();
$connection->close();

?>

<script type="text/javascript">
  var id = <?php echo json_encode($id); ?>;
</script>
<!-- comment text selection -->
<br />
 
  <br />
  <div class="container">
   <form method="POST" id="comment_form">
    <div class="form-group">
     <input type="text" name="comment_name" id="comment_name" class="form-control" placeholder="Enter Name" />
    </div>
    <div class="form-group">
     <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5"></textarea>
    </div>
    <div class="form-group">
     <input type="hidden" name="comment_id" id="comment_id" value="0" />
     <input type="hidden" name="content_id" id="content_id" value="<?php echo $id; ?>" />
     <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
    </div>
   </form>
   <span id="comment_message"></span>
   <br />
   <div id="display_comment"></div>
  </div>
</body>
</html>


<script>
$(document).ready(function(){
var id = $("#content_id").val();

 $('#comment_form').on('submit', function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
   url:"add_comment.php",
   method:"POST",
   data:form_data,
   dataType:"JSON",
   success:function(data)
   {
    if(data.error != '')
    {
     $('#comment_form')[0].reset();
     $('#comment_message').html(data.error);
     $('#comment_id').val('0');
    
     load_comment();
    }
   }
  })
 });

 load_comment();

 function load_comment()
 {
  $.ajax({
   url:"fetch_comment.php",
   method:"POST",
   data: {
	id: id,
	},
   success:function(data)
   {
    $('#display_comment').html(data);
   }
  })
 }
});


</script>
