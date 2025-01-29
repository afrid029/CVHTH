<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require '../vendor/autoload.php';
// require 'C/PHPMailer/src/Exception.php';
require 'Controllers/PHPMailer/src/Exception.php';
// require './PHPMailer/src/PHPMailer.php';
require 'Controllers/PHPMailer/src/PHPMailer.php';
// require './PHPMailer/src/SMTP.php';
require 'Controllers/PHPMailer/src/SMTP.php';

if(isset($_POST['submit'])){

    include("DBConnectivity.php");
    SESSION_START();
    $email = $_POST['email'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($db, $query);

    if(mysqli_num_rows($result) == 1){
        $user = mysqli_fetch_assoc($result);
        $password = generateRandomPassword();
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = '$passwordHash', new = true WHERE email = '$email'";
        $result = mysqli_query($db, $query);

        if($result){
            mysqli_close($db);
            mailSend($user, $password);
    
        }else{
            $_SESSION['message'] = "Unable to reset password. Try again later!";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            mysqli_close($db);
            header('Location: /');
        }
       
    }else if(mysqli_num_rows($result) > 1){
        $_SESSION['message'] = "Multiple email found. Contact admin!";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            mysqli_close($db);
            header('Location: /');

    }else{ 
        $_SESSION['message'] = "Email not registered.";
        $_SESSION['status'] = false;
        $_SESSION['fromAction'] = true;
        mysqli_close($db);
        header('Location: /forgot-password');
    }


    
}else {
    header('Location: /');
}


function generateRandomPassword($length = 8) {
    // Define the character set (letters, numbers, and symbols)
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&';
    
    $charactersLength = strlen($characters);
    $randomPassword = '';
    
    // Generate the random string
    for ($i = 0; $i < $length; $i++) {
        // Get a random character from the character set
        $randomPassword .= $characters[random_int(0, $charactersLength - 1)];
    }
    
    return $randomPassword;
}

function mailSend($user, $password){
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();  // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to send through (e.g., Gmail, Mailgun, etc.)
        $mail->SMTPAuth = true;  // Enable SMTP authentication
        $mail->Username = 'mafrid029@gmail.com';  // SMTP username (email)
        $mail->Password = '';  // SMTP password -- App Password from Gmail 2FA
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption, `PHPMailer::ENCRYPTION_SMTPS` for SSL
        $mail->Port = 587;  // SMTP port (587 for TLS, 465 for SSL)


        $sentName = $user['firstname'].' '.$user['lastname'];

        //Recipients
        $mail->setFrom('tmislam@gmail.com', 'CVHTH');  // Set the sender's email address and name
        $mail->addAddress($user['email'], $sentName);  // Add recipient's email address and name
        //$mail->addReplyTo('another_email@example.com', 'Reply-to Name');  // Optional: Set a reply-to email address

        //Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = 'Password Reset Email | CVHTH ';
        $mail->Body    = "<h5>Hi $sentName,</h5>
                            <h5> You have successfully reset your password</h5>
                            <h5>Your new password is: $password</h5>
                            <h5 style = 'color: red'>Create new password in your next login</h5>
                            <h5>With Regards,<br>CVHTH<br>Admin.</h5>";

        // Debugging (optional, turn off in production)
        //$mail->SMTPDebug = 2;  // Set this to 2 for verbose debugging output (0 = off, 1 = client, 2 = client and server)

        // Send the email
        if ($mail->send()) {
            echo 'Message has been sent';
            $_SESSION['message'] = 'Password reset email has been sent to your email';
            $_SESSION['status'] = true;
            $_SESSION['fromAction'] = true;
            header("Location: /");
        } else {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;  // Display the error message if mail fails

            $_SESSION['message'] = $mail->ErrorInfo;
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            header("Location: /");
        }
    } catch (Exception $e) {
        // Catch any exceptions
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        $_SESSION['message'] = $mail->ErrorInfo;
        $_SESSION['status'] = false;
        $_SESSION['fromAction'] = true;
        header("Location: /");
    }
}
    
?>