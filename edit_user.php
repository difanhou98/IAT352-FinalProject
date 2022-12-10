<?php 
require("functions.php");
include("nav.php");

//check login
if(!isset($_SESSION['valid_user']) || empty($_SESSION['valid_user'])) {
	$_SESSION['callback_url'] = 'edit_user.php';
	direct_to('login.php');
} 
$email = $_SESSION['valid_user'];
if (isset($_SESSION['callback_url']) && $_SESSION['callback_url'] == 'edit_user.php') {
	unset($_SESSION['callback_url']);
}

$user_query_str = "SELECT * FROM `users` WHERE `email` = '$email';";

$res = $connection->query($user_query_str);
$user_row = $res->fetch_row();

$res->free_result();



//see if hit submit
if (isset($_POST['submit'])){
    $fname = !empty($_POST["fname"]) ? trim($_POST["fname"]) : "";
    $lname = !empty($_POST["lname"]) ? trim($_POST["lname"]) : "";
    $password = !empty($_POST["password"]) ? $_POST["password"] : "";
    
    if(empty($fname) || empty($lname) || empty($password)){
        $message = "Please fill out all fields";
    }
    else {
        $password_hash = sha1($password);
        $query = "UPDATE `users` SET `first_name` = '$fname', `last_name` ='$lname',`password_hash` ='$password_hash' WHERE `email` = '$email';";
        $stmt = $connection->prepare($query);
       
        $stmt->execute();
        $stmt->free_result();
        $_SESSION['valid_user'] = $email;
        //echo $query;
        $callback_url = "frontpage.php";
        if (isset($_SESSION['callback_url']))
        $callback_url = $_SESSION['callback_url'];
        direct_to($callback_url);
    }
    
}
else{
    $fname = "";
    $lname = "";
    $password = "";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel= "stylesheet" href = "style\style.css">
    <script src="jquery.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $(".EditPicButton").click(function(e){
                e.preventDefault();

                $.get($(this).attr("href"),function(data){
                    $("#editPic").html(data);
                });

            });

        });
    </script>

    <title>Document</title>
</head>
<body>
<form class="form-container" method="POST" > 
        <div class="user-image">
    
            <img src="uploads/<?php echo $user_row[4];?>" width="200" height="200">          
        </div>
        <div class ="button-block" id="editPic">
            <a href="edit_pic.php" class="button EditPicButton">Edit Profile Picture</a>
        </div>

        <div class="form-item">
            <label for="fname">First Name: </label>
            <input type="text" value="<?php echo $user_row[2]; ?>" id="fname" name="fname" >
        </div>
        <div class="form-item">
            <label for="lname">last Name: </label>
            <input type="text" value="<?php echo $user_row[3]; ?>" id="lname" name="lname" >
        </div>

        <div class="form-item">
            <label for="password">Password: </label>
            <input type="text" id="password" name="password" >
        </div>
        <div class="form-item button">
            <input  type="submit" value="submit" name="submit">
        </div>
        <?php 
        if (!empty($message)){
            echo "<p>". $message . "</p>";
        }
        else {
            echo "<p>"."no message"."</p>";
        }
        ?>


    </form>
</body>
</html>