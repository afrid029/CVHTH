<?php 
if(isset($_POST['submit'])){
    include('DBConnectivity.php');
    SESSION_START();

    $email = $_POST['email'];
    $current = $_POST['current'];
    $new = $_POST['new'];
    $re = $_POST['re'];

    // echo $email;

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($db, $query);

    $countRows = mysqli_num_rows($result);
    if($countRows == 1) {
        $row = mysqli_fetch_assoc($result);
        if(password_verify($current, $row['password'])) {
            if($new === $re) {
                $newPass = password_hash($new, PASSWORD_DEFAULT);
                $query = "UPDATE users SET password = '$newPass', new = false WHERE email = '$email'";
                $result = mysqli_query($db, $query);
                if($result) {
                    $_SESSION['fromAction'] = true;
                    $_SESSION['message'] = 'Password reset successful';
                    $_SESSION['status'] = true;
                    mysqli_close($db);
                    header('Location: /');
                }else {
                    $_SESSION['fromAction'] = true;
                    $_SESSION['message'] = 'Password reset failed. Try again later';
                    $_SESSION['status'] = false;
                    mysqli_close($db);
                    header('Location: /');
                }
            }else {
                $_SESSION['fromAction'] = true;
                $_SESSION['message'] = 'Passwords do not match';
                $_SESSION['status'] = false;
                mysqli_close($db);
                header('Location: /');
            }
        }else {
            $_SESSION['fromAction'] = true;
            $_SESSION['message'] = 'Incorrect password';
            $_SESSION['status'] = false;
            mysqli_close($db);
            header('Location: /');
        }

    }else {
        $_SESSION['fromAction'] = true;
        $_SESSION['message'] = 'Multiple users '. $countRows .' found with the same email. Contact Admin';
        $_SESSION['status'] = false;
        mysqli_close($db);
        // header('Location: /');
    }
}else {

    $_SESSION['fromAction'] = true;
    $_SESSION['message'] = 'Multiple users found with the same email. Contact Admin';
    $_SESSION['status'] = false;
  
    // header('Location: /');
 
}


?>