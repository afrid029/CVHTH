<?php


include('DBConnectivity.php');

// Get the current page from the URL, default to 1 if not set


$query = "SELECT b.ID, b.firstname, b.lastname,  pb.project_id
from beneficiant b 
JOIN projectbeneficiant pb ON b.ID = pb.Beneficiant_ID
ORDER BY b.firstName";

$result = mysqli_query($db, $query);

$data = array();

$html = '';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
} else {
    // $html .= "<tr><td colspan='2'>No results found.</td></tr>";
}

$forPm = isset($_GET['pmID']) ? true : false;

if($forPm){
    $pmID = $_GET['pmID'];
    $query = "SELECT DISTINCT p.ID, p.name
    from projectbeneficiant pb 
    JOIN project p ON pb.Project_ID = p.ID
    JOIN projectmanager pm ON pm.Project_ID = p.ID
    Where pm.Manager_ID = '$pmID'
    ORDER BY p.name";

}else{
    $query = "SELECT DISTINCT p.ID, p.name
    from projectbeneficiant pb 
    JOIN project p ON pb.Project_ID = p.ID
    ORDER BY p.name";
}

$result = mysqli_query($db, $query);

$data1 = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data1[] = $row;
    }
} else {
    // $html .= "<tr><td colspan='2'>No results found.</td></tr>";
}

// Return the results and pagination links as JSON
echo json_encode([
    'data' => $data,
    'data1' => $data1

]);

mysqli_close($db);
