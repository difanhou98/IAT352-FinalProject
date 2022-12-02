<?php 
require("functions.php");
include("nav.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])){
    $fname = !empty($_POST["fname"]) ? trim($_POST["fname"]) : "";
    $lname = !empty($_POST["lname"]) ? trim($_POST["lname"]) : "";
    $email = !empty($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = !empty($_POST["password"]) ? $_POST["password"] : "";
    $password2 = !empty($_POST["password2"]) ? $_POST["password2"] : "";
    
    if(empty($fname) || empty($lname) || empty($email) || empty($password) || empty($password2)){
        $message = "Please fill out all fields";
    }
    else if ($password != $password2){
        $message = "password you entered do not matched, please try again";
    }
    else {
        $password_hash = sha1($password);
        $query = "INSERT INTO users(email, password_hash, first_name, last_name)";
        $query .=" VALUES (?,?,?,?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param('ssss', $email, $password_hash, $fname, $lname);
        // query validation: https://stackoverflow.com/questions/26751296/mysqli-prepare-statement-insert-not-inserting
        // if(!$stmt->execute()){trigger_error("there was an error....".$connection->error, E_USER_WARNING);}
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
    $email = "";
    $password = "";
    $password2 = "";
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
<form class="form-container" action="register.php" method="POST">
        <div class="form-item">
            <label for="fname">First Name:</label> 
            <input name="fname" type="text" value="<?php $fname ?>">
        </div>

        <div class="form-item">
            <label for="lname">Last Name: </label>
            <input type="text" name="lname">
        </div>

        <div class="form-item">
            <label for="email">Email Address: </label>
            <input type="email" name="email">
        </div>  

        <div class="form-item">
            <label for="password">Password: </label>
            <input type="password" name="password">
        </div>

        <div class="form-item">
            <label for="password2">Confirm Password: </label>
            <input type="password" name="password2">
        </div>
        
        <div class="form-item button">
            <input type="submit" name="submit" value="Register">
            <?php if(!empty($message)) echo '<p>' . $message . '</p>' ?>
        </div>
    </form>
</body>
</html>