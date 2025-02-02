<?php
// if(isset($_POST['submit'])){
//     session_start();
//     $_SESSION['email'] = $_POST['email'];

//     // echo $_SESSION['email'];

//     header("Location: /reset-password");
// }else {
//     // header("Location: /");
//     echo 'Hii';
// }

// Start the session to handle session data
session_start();

// Check if the 'email' parameter is present in the query string
if (isset($_GET['email'])) {
    // Store the email in the session for further use
    $_SESSION['email'] = $_GET['email'];
    header("Location: /reset-password");

    // Optionally, you can add a redirect to another page (uncomment below if needed)
    // header("Location: /reset-password");

    // For debugging, you can echo the session email (remove in production)
    // echo "Email stored in session: " . htmlspecialchars($_SESSION['email']);
} else {
    // If the 'email' parameter is not present, handle accordingly
    echo "Error: No email parameter provided.";
    // Optionally, redirect or handle the error
    // header("Location: /");
}

?>
