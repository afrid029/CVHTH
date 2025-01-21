<?php


include('DBConnectivity.php');

// Get the current page from the URL, default to 1 if not set

$query = "SELECT b.ID, b.firstname, b.lastname, pb.Beneficiant_ID
from beneficiant b
LEFT JOIN projectbeneficiant pb ON  b.ID = pb.Beneficiant_ID
WHERE pb.Beneficiant_ID is NULL
ORDER BY b.firstname, b.lastname;";

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
