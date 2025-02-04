<?php

session_start();


if (isset($_GET['email'])) {
    $_SESSION['email'] = $_GET['email'];
    header("Location: /reset-password");
} else {
  
    echo "Error: No email parameter provided.";
    header("Location: /");
}

?>
