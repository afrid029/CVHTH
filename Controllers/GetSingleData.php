<?php


include('DBConnectivity.php');

// Get the current page from the URL, default to 1 if not set
$type = urldecode($_GET['type']);
$ID = $_GET['ID'];

if ($type === 'donation') {

    $query = "SELECT dr.ID, dr.date, dr.amount, dr.Donor_ID, concat(u.firstname, ' ', u.lastname) as name
    from donationreceived dr
    JOIN users u ON dr.Donor_ID = u.ID
    where dr.ID = '$ID'";

    $result = mysqli_query($db, $query);

    $data = array();


    // $html = '';

    if (mysqli_num_rows($result) == 1) {

        $data = mysqli_fetch_assoc($result);
       
    } else {
        // $html .= "<tr><td colspan='2'>No results found.</td></tr>";
    }
}


// Return the results and pagination links as JSON
echo json_encode([
    'data' => $data,

]);

mysqli_close($db);
