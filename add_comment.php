<?php

//add_comment.php

include_once('functions.php');

$error = '';
$comment_name = '';
$comment_content = '';

if(empty($_POST["comment_name"]))
{
 $error .= '<p class="text-danger">Name is required</p>';
}
else
{
 $comment_name = $_POST["comment_name"];
}

if(empty($_POST["comment_content"]))
{
 $error .= '<p class="text-danger">Comment is required</p>';
}
else
{
 $comment_content = $_POST["comment_content"];
}

if(empty($_POST['content_id']))
{
 $error .= '<p class="text-danger">content id is required</p>';
}
else
{
    $content_id  = $_POST['content_id'];
}



if($error == '')
{
    $parent_comment_id = !empty($_POST['comment_id']) ? $_POST['comment_id'] : ""; 
    $comment = $comment_content;
    $comment_sender_name = $comment_name;
   
 $query_str = "INSERT INTO tbl_comment(parent_comment_id, comment,comment_sender_name,content_id) VALUES (?,?,?,?);";
 $sth = $connection->prepare($query_str);


	//sub the two strings
$sth ->bind_param('ssss',$parent_comment_id,$comment,$comment_sender_name,$content_id);

 $sth->execute();
 
 $error = '<label class="text-success">Comment Added</label>';
}


$data = array(
 'error'  => $error
);

echo json_encode($data);

$sth->free_result();
?>