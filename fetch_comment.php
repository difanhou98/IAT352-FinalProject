<?php

//fetch_comment.php

include_once('functions.php');


if(empty($_POST['id']))
{
 $error .= '<p class="text-danger">content id is required</p>';
}
else
{
    $content_id  = $_POST['id'];
}

$query = "
SELECT * FROM tbl_comment 
WHERE parent_comment_id = '0' && content_id = '$content_id'
ORDER BY comment_id DESC;
";

$statement = $connection->prepare($query);

$statement->execute();

$resultSet = $statement->get_result();
$result = $resultSet->fetch_all();
$output = '';
foreach($result as $row)
{
 $output .= '
 <div class="panel panel-default">
  <div class="panel-heading">By <b>'.$row[3].'</b> on <i>'.$row[4].'</i></div>
  <div class="panel-body">'.$row[2].'</div>
 </div>
 ';
 
}

echo $output;



?>