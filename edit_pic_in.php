<?php
include_once('functions.php');

//check login
if(!isset($_SESSION['valid_user']) || empty($_SESSION['valid_user'])) {
	$_SESSION['callback_url'] = 'edit_user.php';
	direct_to('login.php');
} 
$email = $_SESSION['valid_user'];
if (isset($_SESSION['callback_url']) && $_SESSION['callback_url'] == 'edit_user.php') {
	unset($_SESSION['callback_url']);
}

if(isset($_FILES['file']['name'])){

    $uploadDir = "uploads/";

    if(!empty($_FILES['file']['name'])){

        $maxDim = 100;
        $file_name = $_FILES['file']['name'];
        list($width, $height, $type, $attr) = getimagesize( $file_name );
        if ( $width > $maxDim || $height > $maxDim ) {
        $target_filename = $file_name;
        $ratio = $width/$height;
        if( $ratio > 1) {
        $new_width = $maxDim;
        $new_height = $maxDim/$ratio;
        } else {
        $new_width = $maxDim*$ratio;
        $new_height = $maxDim;
        }
        $src = imagecreatefromstring( file_get_contents( $file_name ) );
        $dst = imagecreatetruecolor( $new_width, $new_height );
        imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
        imagedestroy( $src );
        imagepng( $dst, $target_filename ); // adjust format as needed
        imagedestroy( $dst );
        }

        $fileToUpload = $uploadDir.basename($_FILES['file']['name']);
        

        if(move_uploaded_file($_FILES['file']['tmp_name'], $fileToUpload)){

            $file = htmlspecialchars($_FILES['file']['name']);
            $query = "UPDATE `users` SET `image` = '$file' WHERE `email` = '$email';";
            //"UPDATE `users` SET `first_name` = '$fname', `last_name` ='$lname',`password_hash` ='$password_hash' WHERE `email` = '$email';";
            $stmt = $connection->prepare($query);
	        //prepare execute of statement
	        $stmt ->execute();
            $stmt->free_result();
            echo  "<script>alert('Updated');window.location='edit_user.php'</script>";
        }else{
            echo  "<script>alert('Failed to updated');window.location='edit_user.php'</script>";
        }
    }
}

?>