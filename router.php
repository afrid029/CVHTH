
<?php
// Get the current URL path
$request = $_SERVER['REQUEST_URI'];

// Define routes
switch ($request) {
    case '/':
        require 'index.php';  // Home page
        break;
    case '/donation':
        require 'Pages/AllDonations.php'; // About page
        break;
    case '/users':
        require 'Pages/AllUsers.php'; // Contact page
        break;
    case '/sentdonation':
        require 'Pages/AllSentDonation.php'; // Contact page
        break;
    case '/project':
        require 'Pages/AllProjects.php'; // Contact page
        break;
    case '/beneficent':
        require 'Pages/AllBeneficent.php'; // Contact page
        break;
    case '/donors':
        require 'Pages/DonorHome.php'; // Contact page
        break;
    case '/forgot-password':
        require 'Pages/ForgotPassword.php'; // Contact page
        break;
    case '/reset-password':
        require 'Pages/ResetPassword.php'; // Contact page
        break;
    case '/add-donation':
        require 'Controllers/AddDonation.php'; // Contact page
        break;
    case '/login':
        require 'Controllers/Login.php'; // Contact page
        break;
    case '/add-sentdonation':
        require 'Controllers/AddSentDonation.php'; // Contact page
        break;
    case '/add-user':
        require 'Controllers/AddUsers.php'; // Contact page
        break;
    case '/add-beneficiary':
        require 'Controllers/AddBeneficent.php'; // Contact page
        break;
    case '/add-project':
        require 'Controllers/AddProject.php'; // Contact page
        break;
    case '/generate-password':
        require 'Controllers/PasswordRegenerte.php'; // Contact page
        break;
    case '/reset':
        require 'Controllers/ResetPassword.php'; // Contact page
        break;
    case '/logout':
        require 'Controllers/Logout.php'; // Contact page
        break;
    default:
        http_response_code(404); // Not Found
        require 'error.php';
        break;
}

?>
