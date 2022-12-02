<?php 
require("functions.php");
include("nav.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

@$email = trim($_POST['email']);
@$password = trim($_POST['password']);
$message = "";

if (!empty($email) && !empty($password)){
    
    $pass_hash = sha1($password);
    $query = "SELECT COUNT(*) FROM users";
    $query.=" WHERE email = ? AND password_hash = '$pass_hash'";
    echo "<p>".$query."</p>";
    $stmt = $connection->prepare($query);
    
	$stmt->bind_param('s',$email);
	$stmt->execute();
    if(!$stmt->bind_param('s',$email)){trigger_error("there was an error....".$connection->error, E_USER_WARNING);}
	$stmt->bind_result($count);
    
    if($stmt->fetch() && $count > 0) {
		$_SESSION['valid_user'] = $email;
        $callback_url = "frontpage.php";
        if (isset($_SESSION['callback_url'])){
        	$callback_url = $_SESSION['callback_url'];
        }
        $stmt->free_result();
        direct_to($callback_url);
	} else {
	    $message = "Sorry, email and password combination not registered.";
        
	}
    
}


$connection->close();
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
<form class="form-container" method="POST" > 
        <div class="form-item">
            <label for="email">Email: </label>
            <input type="text" id="email" name="email" >
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
        <div class="form-item">
            <a class="button" href="register.php">Register Here</a>
        </div>

    </form>
</body>
</html>