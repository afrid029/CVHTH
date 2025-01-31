<?php 
if(isset($_POST['submit'])){
    include('DBConnectivity.php');
    SESSION_START();

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($db, $query);
    $countRows = mysqli_num_rows($result);
    if($countRows == 1){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row['password'])){


            $data = [
                'email' => $email,
                'ID' => $row['ID'],
                'fname' => $row['firstname'],
                'lname' => $row['lastname'],
                'role' => $row['role'],
                'new' => $row['new'],
            ];

            if($data['new'] == 1){
                mysqli_close($db);
                $_SESSION['email'] = $email;
                header('Location: /reset-password');
                return;
            }

            $iv = openssl_random_pseudo_bytes(16);  // AES block size is 16 bytes

        // Encrypt the email using AES-256-CBC encryption
            $key = '6f5473b5b16a3fd9576b907b2b2dcb3f07b3d59eecac4f5649356be45b5fce99811';
            $encryptedData = openssl_encrypt(serialize($data), 'aes-256-cbc', $key, 0, $iv);
        
            // Combine the IV with the encrypted email to store both together
            $encryptedWithWithIv = base64_encode($iv . $encryptedData);

            setcookie('user', $encryptedWithWithIv, time() + 3600, '/');

            $_SESSION['isLoggedIn'] = true;


            if($data['role'] == 'donor'){
                $_SESSION['fromAction'] = true;
                $_SESSION['message'] = 'Login successful!';
                $_SESSION['status'] = true;
                mysqli_close($db);
                header('Location: /donors');
            }else if($data['role'] === 'admin' || $data['role'] === 'superadmin'){
                $_SESSION['fromAction'] = true;
                $_SESSION['message'] = 'Login successful!';
                $_SESSION['status'] = true;
                mysqli_close($db);
                header('Location: /donation');
            } else if($data['role'] === 'project manager') {
                $_SESSION['fromAction'] = true;
                $_SESSION['message'] = 'Login successful!';
                $_SESSION['status'] = true;
                mysqli_close($db);
                header('Location: /sentdonation');
            }

        }else {
            $_SESSION['fromAction'] = true;
            $_SESSION['message'] = 'Incorrect password!';
            $_SESSION['status'] = false;
            mysqli_close($db);
            header('Location: /');
        }

    }else if($countRows > 1){
        $_SESSION['fromAction'] = true;
        $_SESSION['message'] = 'Multiple emails found. Contact admin!';
        $_SESSION['status'] = false;
        mysqli_close($db);
        header('Location: /');
    }else {
        $_SESSION['fromAction'] = true;
        $_SESSION['message'] = 'Email not found!';
        $_SESSION['status'] = false;
        mysqli_close($db);
        header('Location: /');
    }
}else {
    header('Location: /');
}
?>