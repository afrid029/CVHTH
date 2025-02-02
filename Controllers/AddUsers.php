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
    include('DBConnectivity.php');
    session_start();

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $contact = $_POST['contact'];
    $password = generateRandomPassword();
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $query = "SELECT COUNT(*) cnt from users";

    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);

    $randomId = rand(100, 999);
    $ID = 'user_'.$row['cnt']. $randomId;

    if($role === 'admin'){

        $query = "INSERT INTO users (ID, username, firstname, lastname, email, role, contactno, new, password, temp_password) VALUES ('$ID', '$ID', '$fname', '$lname', '$email', '$role', '$contact', true, '$passwordHash', '$passwordHash')";

        $result = mysqli_query($db, $query);

        if($result) {
            mysqli_close($db);
            // header('Location: /users');
        }else {
            $_SESSION['message'] = "Unable to create user. Try Again Later! ".mysqli_error($db);
            // $_SESSION['message'] = mysqli_error($db);
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            // echo mysqli_error($db);
            mysqli_close($db);
            header('Location: /users');
            exit();
        }

    }else if($role === 'donor'){

        $dobCheck = $_POST['dob'] !== '' ? true : false;

        // echo $dobCheck;
        // echo $_POST['dob'];

        if($dobCheck) {
            $dob = $_POST['dob'];
            $query = "INSERT INTO users (ID, username, firstname, lastname, email, role, contactno, new, password, dob, temp_password) VALUES('$ID', '$ID', '$fname', '$lname', '$email', '$role', '$contact', true, '$passwordHash', '$dob', '$passwordHash' )";
        }else {
            $query = "INSERT INTO users (ID, username, firstname, lastname, email, role, contactno, new, password, temp_password) VALUES('$ID', '$ID', '$fname', '$lname', '$email', '$role', '$contact', true, '$passwordHash', '$passwordHash' )";
        }

        $result = mysqli_query($db, $query);

        if($result) {
            mysqli_close($db);
            // $_SESSION['message'] = "User created successfully!";
            // $_SESSION['status'] = true;
            // $_SESSION['fromAction'] = true;
            // header('Location: /users');
        }else {
            
            $_SESSION['message'] = "Unable to create user. ".mysqli_error($db);
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            mysqli_close($db);
            header('Location: /users');
            exit();
        }
        
    }else {

        mysqli_begin_transaction($db);

        $query = "INSERT INTO users (ID, username, firstname, lastname, email, role, contactno, new, password, temp_password) VALUES('$ID', '$ID', '$fname', '$lname', '$email', '$role', '$contact', true, '$passwordHash', '$passwordHash' )";

        $result1 = mysqli_query($db, $query);


        $project = isset($_POST['project']) ? $_POST['project'] : '';
        $result2 = true;

        if($project !== ''){
            $projects = explode(', ', $project);

            foreach ($projects as $pr){
                $query = "INSERT INTO projectmanager VALUES('$pr', '$ID')";
                $res = mysqli_query($db, $query);
                $result2 = $result2 && $res;
            }
        }

    

        $result3 = true;
        $donor = isset($_POST['donor']) ? $_POST['donor'] : '';
     

        if($donor !== ''){
            $donors = explode(', ', $donor);

            foreach($donors as $don) {
                $query = "INSERT INTO projectmanagerdonor VALUES('$ID', '$don')";
                $res = mysqli_query($db, $query);
                $result3 = $result3 && $res;
            }
           
        }

    


        if($result1 && $result2 && $result3) {

            mysqli_commit($db);
            mysqli_close($db);
            // $_SESSION['message'] = "User created successfully!";
            // $_SESSION['status'] = true;
            // $_SESSION['fromAction'] = true;
            // header('Location: /users');
        }else {
            mysqli_rollback($db);
            // echo mysqli_error($db);
            mysqli_close($db);
            $_SESSION['message'] = "Unable to create user. Try Again Later!";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;

            header('Location: /users');
            exit();
        }
    }

    mailSend($email, $fname, $lname, $role, $password);
    

}else if (isset($_POST['edit-submit'])) {
    include ('DBConnectivity.php');
    SESSION_START();
    $ID = $_POST['ID'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $contact = $_POST['contact'];

    $query = "SELECT role from users where ID = '$ID'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);

    if($row['role'] === 'admin'){
     
        if($role === 'admin'){
            $query = "UPDATE users 
            SET firstname = '$fname', 
            lastname = '$lname', 
            email = '$email', 
            contactno='$contact',
            updatedat=current_timestamp()
            WHERE ID = '$ID'";

            $result = mysqli_query($db, $query);

            if($result) {
                $_SESSION['message'] = "User updated successfully!";
                $_SESSION['status'] = true;
                $_SESSION['fromAction'] = true;
                mysqli_close($db);
                header('Location: /users');
            }else {
                $_SESSION['message'] = "Unable to update. try again later! ".mysqli_error($db);
                $_SESSION['status'] = false;
                $_SESSION['fromAction'] = true;
                mysqli_close($db);
                header('Location: /users');
            }
        }else if($role === 'donor'){
            $dob = $_POST['dob'] === '' ? '' : $_POST['dob'];

            if($dob === ''){
                $query = "UPDATE users 
                SET firstname = '$fname', 
                lastname = '$lname', 
                email = '$email', 
                contactno='$contact',
                role='donor',
                dob=NULL,
                updatedat=current_timestamp()
                WHERE ID = '$ID'";
            }else {
                $query = "UPDATE users 
                SET firstname = '$fname', 
                lastname = '$lname', 
                email = '$email', 
                contactno='$contact',
                role='donor',
                updatedat=current_timestamp(),
                dob='$dob'
                WHERE ID = '$ID'";
            }

            $result = mysqli_query($db, $query);

            if($result) {
                $_SESSION['message'] = "User updated successfully!";
                $_SESSION['status'] = true;
                $_SESSION['fromAction'] = true;
                mysqli_close($db);
                header('Location: /users');
            }else {
                $_SESSION['message'] = "Unable to update. try again later! ".mysqli_error($db);
                $_SESSION['status'] = false;
                $_SESSION['fromAction'] = true;
                mysqli_close($db);
                header('Location: /users');
            }
        } else if($role === 'project manager'){
            mysqli_begin_transaction($db);

            $query = "UPDATE users 
            SET firstname = '$fname', 
            lastname = '$lname', 
            email = '$email', 
            contactno='$contact',
            role = '$role',
            updatedat=current_timestamp()
            WHERE ID = '$ID'";

            $result1 = mysqli_query($db, $query);

            echo mysqli_error($db);

            $project = isset($_POST['project']) ? $_POST['project'] : '';
            $result2 = true;
    
            if($project !== ''){
                $projects = explode(', ', $project);
    
                foreach ($projects as $pr){
                    $query = "INSERT INTO projectmanager VALUES('$pr', '$ID')";
                    $res = mysqli_query($db, $query);
                    echo mysqli_error($db);
                    $result2 = $result2 && $res;
                }
            }
    
            $result3 = true;
            $donor = isset($_POST['donor']) ? $_POST['donor'] : '';
         
    
            if($donor !== ''){
                $donors = explode(', ', $donor);
    
                foreach($donors as $don) {
                    $query = "INSERT INTO projectmanagerdonor VALUES('$ID', '$don')";
                    $res = mysqli_query($db, $query);
                    echo mysqli_error($db);
                    $result3 = $result3 && $res;
                }
               
            }
    
            if($result1 && $result2 && $result3) {
    
                mysqli_commit($db);
                mysqli_close($db);
                $_SESSION['message'] = "User updated successfully!";
                $_SESSION['status'] = true;
                $_SESSION['fromAction'] = true;
                header('Location: /users');
            }else {
                mysqli_rollback($db);
                $_SESSION['message'] = "Unable to update user. Try Again Later! ".mysqli_error($db);
                $_SESSION['status'] = false;
                $_SESSION['fromAction'] = true;
                mysqli_close($db);
    
                header('Location: /users');
            }
        }
    }else if($row['role'] === 'donor'){
        if($role === 'donor'){
            $dob = $_POST['dob'] === '' ? '': $_POST['dob'] ;

            if($dob === ''){
                $query = "UPDATE users 
                SET firstname = '$fname', 
                lastname = '$lname', 
                email = '$email', 
                contactno='$contact',
                dob=NULL,
                updatedat=current_timestamp()
                WHERE ID = '$ID'";
            }else {
                $query = "UPDATE users 
                SET firstname = '$fname', 
                lastname = '$lname', 
                email = '$email', 
                contactno='$contact',
                updatedat=current_timestamp(),
                dob='$dob'
                WHERE ID = '$ID'";
            }

            $result = mysqli_query($db, $query);

            if($result) {
                $_SESSION['message'] = "User updated successfully!";
                $_SESSION['status'] = true;
                $_SESSION['fromAction'] = true;
                mysqli_close($db);
                header('Location: /users');
            }else {
                $_SESSION['message'] = "Unable to update. try again later! ".mysqli_error($db);
                $_SESSION['status'] = false;
                $_SESSION['fromAction'] = true;
                mysqli_close($db);
                header('Location: /users');
            }
        }else {

            mysqli_begin_transaction($db);

            $query = "DELETE from projectmanagerdonor WHERE donor_ID = '$ID'";
            $delete = mysqli_query($db, $query);

            if ($role === 'admin') {
                $query = "UPDATE users 
                SET firstname = '$fname', 
                lastname = '$lname', 
                email = '$email', 
                contactno='$contact',
                role='$role',
                dob=NULL,
                updatedat=current_timestamp()
                WHERE ID = '$ID'";
    
                $result = mysqli_query($db, $query);
    
                if($result && $delete) {
                    $_SESSION['message'] = "User updated successfully!";
                    $_SESSION['status'] = true;
                    $_SESSION['fromAction'] = true;
                    mysqli_commit($db);
                    mysqli_close($db);
                    header('Location: /users');
                }else {
                    $_SESSION['message'] = "Unable to update. try again later! ".mysqli_error($db);
                    $_SESSION['status'] = false;
                    $_SESSION['fromAction'] = true;
                    mysqli_rollback($db);
                    mysqli_close($db);
                    header('Location: /users');
                }
            }else if($role === 'project manager'){
               
    
                $query = "UPDATE users 
                SET firstname = '$fname', 
                lastname = '$lname', 
                email = '$email', 
                contactno='$contact',
                role = '$role',
                dob=NULL,
                updatedat=current_timestamp()
                WHERE ID = '$ID'";
    
                $result1 = mysqli_query($db, $query);
    
                $project = isset($_POST['project']) ? $_POST['project'] : '';
                $result2 = true;
        
                if($project !== ''){
                    $projects = explode(', ', $project);
        
                    foreach ($projects as $pr){
                        $query = "INSERT INTO projectmanager VALUES('$pr', '$ID')";
                        $res = mysqli_query($db, $query);
                        $result2 = $result2 && $res;
                    }
                }
        
                $result3 = true;
                $donor = isset($_POST['donor']) ? $_POST['donor'] : '';
             
        
                if($donor !== ''){
                    $donors = explode(', ', $donor);
        
                    foreach($donors as $don) {
                        $query = "INSERT INTO projectmanagerdonor VALUES('$ID', '$don')";
                        $res = mysqli_query($db, $query);
                        $result3 = $result3 && $res;
                    }
                   
                }
        
                if($delete && $result1 && $result2 && $result3) {
        
                    mysqli_commit($db);
                    mysqli_close($db);
                    $_SESSION['message'] = "User updated successfully!";
                    $_SESSION['status'] = true;
                    $_SESSION['fromAction'] = true;
                    header('Location: /users');
                }else {
                    mysqli_rollback($db);
                    $_SESSION['message'] = "Unable to update user. Try Again Later! ".mysqli_error($db);
                    $_SESSION['status'] = false;
                    $_SESSION['fromAction'] = true;
                    mysqli_close($db);
        
                    header('Location: /users');
                }
            }
        }
    } else if ($row['role'] === 'project manager'){
        if($role === 'project manager') {
            mysqli_begin_transaction($db);

            $query = "UPDATE users 
            SET firstname = '$fname', 
            lastname = '$lname', 
            email = '$email', 
            contactno='$contact',
            updatedat=current_timestamp()
            WHERE ID = '$ID'";

            $result1 = mysqli_query($db, $query);

            $query = "DELETE from projectmanager WHERE manager_ID = '$ID'";

            $delete1 = mysqli_query($db, $query);

            $project = isset($_POST['project']) ? $_POST['project'] : '';
            $result2 = true;
    
            if($project !== ''){
                $projects = explode(', ', $project);
    
                foreach ($projects as $pr){
                    $query = "INSERT INTO projectmanager VALUES('$pr', '$ID')";
                    $res = mysqli_query($db, $query);
                    $result2 = $result2 && $res;
                }
            }

            
            $query = "DELETE from projectmanagerdonor WHERE manager_ID = '$ID'";

            $delete2 = mysqli_query($db, $query);
    
            $result3 = true;
            $donor = isset($_POST['donor']) ? $_POST['donor'] : '';
         
    
            if($donor !== ''){
                $donors = explode(', ', $donor);
    
                foreach($donors as $don) {
                    $query = "INSERT INTO projectmanagerdonor VALUES('$ID', '$don')";
                    $res = mysqli_query($db, $query);
                    $result3 = $result3 && $res;
                }
               
            }
    
    
    
            if($delete1 && $delete2 && $result1 && $result2 && $result3) {
    
                mysqli_commit($db);
                mysqli_close($db);
                $_SESSION['message'] = "User updated successfully!";
                $_SESSION['status'] = true;
                $_SESSION['fromAction'] = true;
                header('Location: /users');
            }else {
                mysqli_rollback($db);
               
                $_SESSION['message'] = "Unable to update user. Try Again Later! ".mysqli_error($db);
                $_SESSION['status'] = false;
                $_SESSION['fromAction'] = true;
                mysqli_close($db);
    
                header('Location: /users');
            }


        } else {
            mysqli_begin_transaction($db);

            $query = "DELETE from projectmanager WHERE manager_ID = '$ID'";
            $delete1 = mysqli_query($db, $query);
            // echo mysqli_error($db);

            $query = "DELETE from projectmanagerdonor WHERE manager_ID = '$ID'";
            $delete2 = mysqli_query($db, $query);
            // echo mysqli_error($db);

            if($role === 'admin'){
                $query = "UPDATE users 
                SET firstname = '$fname', 
                lastname = '$lname', 
                email = '$email', 
                contactno='$contact',
                role='$role',
                updatedat=current_timestamp()
                WHERE ID = '$ID'";

                $result = mysqli_query($db, $query);

                if($result && $delete1 && $delete2) {
                    $_SESSION['message'] = "User updated successfully!";
                    $_SESSION['status'] = true;
                    $_SESSION['fromAction'] = true;
                    mysqli_commit($db);
                    mysqli_close($db);
                    header('Location: /users');
                }else {
                    $_SESSION['message'] = "Unable to update. try again later! ".mysqli_error($db);
                    $_SESSION['status'] = false;
                    $_SESSION['fromAction'] = true;
                    mysqli_rollback($db);
                    mysqli_close($db);
                    header('Location: /users');
                }
            }else if($role === 'donor'){
                $dob = $_POST['dob'] === '' ? '' : $_POST['dob'];

                if($dob === ''){
                    $query = "UPDATE users 
                    SET firstname = '$fname', 
                    lastname = '$lname', 
                    email = '$email', 
                    contactno='$contact',
                    dob=NULL,
                    role='$role',
                    updatedat=current_timestamp()
                    WHERE ID = '$ID'";
                }else {
                    $query = "UPDATE users 
                    SET firstname = '$fname', 
                    lastname = '$lname', 
                    email = '$email', 
                    contactno='$contact',
                    role='$role',
                    updatedat=current_timestamp(),
                    dob='$dob'
                    WHERE ID = '$ID'";
                }
    
                $result = mysqli_query($db, $query);
              
    
                if($result && $delete1 && $delete2) {
                    $_SESSION['message'] = "User updated successfully!";
                    $_SESSION['status'] = true;
                    $_SESSION['fromAction'] = true;
                    mysqli_commit($db);
                    mysqli_close($db);
                    header('Location: /users');
                }else {
                    $_SESSION['message'] = "Unable to update. try again later!  ".mysqli_error($db);
                    $_SESSION['status'] = false;
                    $_SESSION['fromAction'] = true;
                    mysqli_rollback($db);
                    mysqli_close($db);
                    header('Location: /users');
                }
            }
        }
    }
}else if (isset($_POST['del-submit'])){

    include('DBConnectivity.php');
    SESSION_START();

    mysqli_begin_transaction($db);

    $ID = $_POST['ID'];
    $query = "DELETE FROM users WHERE ID = '$ID'";
    $result = mysqli_query($db, $query);

    if($result){
        $affected_row = mysqli_affected_rows($db);
        if($affected_row === 1){
            mysqli_commit($db);
            mysqli_close($db);
            $_SESSION['message'] = "User Deleted successfully!";
            $_SESSION['status'] = true;
            $_SESSION['fromAction'] = true;
            header('Location: /users');
        }else {
            mysqli_rollback($db);
            mysqli_close($db);
            $_SESSION['message'] = "Found Multiple Entries. Contact Adminstrator";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            header('Location: /users');
        }
    }else {
        mysqli_rollback($db);
            mysqli_close($db);
            $_SESSION['message'] = "Unable to delete. Try again later";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            header('Location: /users');
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

function mailSend($email, $fname, $lname, $role, $password){
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


        $sentName = $fname.' '.$lname;
        $rolename = strtoupper($role);

        //Recipients
        $mail->setFrom('tmislam@gmail.com', 'CVHTH');  // Set the sender's email address and name
        $mail->addAddress($email, $sentName);  // Add recipient's email address and name
        //$mail->addReplyTo('another_email@example.com', 'Reply-to Name');  // Optional: Set a reply-to email address

        //Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = 'Welcome to CVHTH ';
        $mail->Body    = "<h4>Hi $sentName,</h4>
                            <h3 style='text-align: center'>Welcome to Chulipuram Vasantham Helping The Helpless - CVHTH.</h3>
                            <br>
                            <h4>Congratulations. You have been registered as $rolename. </h4>
                            <h4>Your password is: $password</h4>
                            <h4><a href='http://localhost/' target='_blank'>Home | CVHTH</a></h4>
                            <h4 style = 'color: red'>Create new password in your first login</h4>
                            <h4>With Regards,<br>CVHTH<br>Admin.</h4>";


        // Debugging (optional, turn off in production)
        //$mail->SMTPDebug = 2;  // Set this to 2 for verbose debugging output (0 = off, 1 = client, 2 = client and server)

        // Send the email
        if ($mail->send()) {
            echo 'Message has been sent';
            $_SESSION['message'] = 'User Created. Password has been sent to the user email';
            $_SESSION['status'] = true;
            $_SESSION['fromAction'] = true;
            header("Location: /users");
        } else {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;  // Display the error message if mail fails

            $_SESSION['message'] = 'User Created. Unable to send password due to => '.$mail->ErrorInfo;
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            header("Location: /users");
        }
    } catch (Exception $e) {
        // Catch any exceptions
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        $_SESSION['message'] = 'User Created. Unable to send password due to => '.$mail->ErrorInfo;
        $_SESSION['status'] = false;
        $_SESSION['fromAction'] = true;
        header("Location: /users");
    }
}

?>