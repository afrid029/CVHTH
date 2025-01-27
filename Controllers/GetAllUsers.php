<?php


include('DBConnectivity.php');

// Get the current page from the URL, default to 1 if not set
$role = urldecode($_GET['role']);

if($role === 'donor'){
    $query = "SELECT u.ID, u.firstname, u.lastname, (NVL(SUM(dr.amount), 0) - NVL( (SELECT SUM(amount) from donationsent ds where ds.Donor_ID = u.ID ), 0)) balance
from users u
LEFT JOIN donationreceived dr ON u.ID = dr.Donor_ID
WHERE role = 'donor'
GROUP BY u.ID, u.firstname, u.lastname
Order BY balance desc, firstname";
}else {
    $query = "SELECT u.ID, u.firstname, u.lastname from users u
         WHERE u.role = '$role' ORDER BY  u.firstname asc";
}



$result = mysqli_query($db, $query);

$data =array();


$html = '';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
} else {
    // $html .= "<tr><td colspan='2'>No results found.</td></tr>";
}

// Return the results and pagination links as JSON
echo json_encode([
    'data' => $data,
  
]);

mysqli_close($db);
