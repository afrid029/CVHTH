<?php


include('DBConnectivity.php');

// Get the current page from the URL, default to 1 if not set


$query = "SELECT p.ID, p.name from project p
         ORDER BY  p.name asc";

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
