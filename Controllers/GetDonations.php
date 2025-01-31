<?php


include('DBConnectivity.php');


$results_per_page = 10;

// Get the current page from the URL, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($page - 1) * $results_per_page;

// Get the total number of records
$sql = "SELECT COUNT(*) AS total FROM donationreceived";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
$total_records = $row['total'];

$total_received = '';
$total_sent = '';
$current_bal='';
if ($page === 1) {
    $sql = "SELECT sum(amount) AS total_received FROM donationreceived";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_received = $row['total_received'];

    $sql = "SELECT sum(amount) AS total_sent FROM donationsent";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_sent = $row['total_sent'];

    $current_bal = $total_received - $total_sent;
}

$query = "SELECT dr.ID, dr.amount, dr.date, NVL(u.firstname,'<i>Deleted</i>') firstname, NVL(u.lastname, '<i>Donor</i>') lastname
        from donationreceived dr
        LEFT JOIN users u ON dr.donor_ID = u.ID 
        ORDER BY dr.date desc , u.firstname asc 
        LIMIT $offset, $results_per_page";

$result = mysqli_query($db, $query);


$html = '';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "
                    <div class='table-row'>
                   
                    
                                <div>" . $row['firstname'] . " ".$row['lastname']."</div>
                                <div style='text-align: end'>" . $row['amount'] . "</div>
                                <div style='text-align: end'>" . $row['date'] . "</div>
                                <div class='buttons'>
                                         <div onclick=Edit('" . $row['ID'] . "') class='btn edit'>
                                                Edit
                                            </div>
                                            <div  onclick=Delete('" . $row['ID'] . "') class='btn del'>
                                                Delete
                                            </div>  
                                </div>
                            </div>
                            <hr>";
    }
} else {
     $html .= "<div class='table-row'>
                <div style='grid-column: span 4; text-align: center; font-size: 12px; font-weight:700;'>No Donations Found.</div>
                </div>";
}

// $html .= '</tbody></table>';

// Calculate total pages
$total_pages = ceil($total_records / $results_per_page);

// Generate pagination links
$pagination = "<div class='pagination'>";
if ($page > 1) {
    $pagination .= "<span class='textPagi' href='javascript:void(0);' onclick='loadPage(" . ($page - 1) . ")'>Previous</span> ";
}

for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        $pagination .= "<strong class='selected'>$i</strong> ";
    } else if ($i == 1) {
        $pagination .= "<span href='javascript:void(0);' onclick='loadPage($i)'>$i</span> ";
    } else if ($i == $total_pages) {
        $pagination .= "<span href='javascript:void(0);' onclick='loadPage($i)'>$i</span> ";
    } else if (abs($i - $page) < 3) {
        $pagination .= "<span href='javascript:void(0);' onclick='loadPage($i)'>$i</span> ";
    } else {
        if (substr($pagination, -3) !== '...') {
            $pagination .= ".";
        }
    }

    // if ($i == $page) {
    //     $pagination .= "<strong>$i</strong> ";
    // } else {
    //     $pagination .= "<a href='javascript:void(0);' onclick='loadPage($i)'>$i</a> ";
    // }
}

if ($page < $total_pages) {
    $pagination .= "<span class='textPagi' href='javascript:void(0);' onclick='loadPage(" . ($page + 1) . ")'>Next</span>";
}

$pagination .= "</div>";

// Return the results and pagination links as JSON
echo json_encode([
    'html' => $html,
    'pagination' => $pagination,
    'total' => $total_records,
    'total_received' => $total_received,
    'total_sent' => $total_sent,
    'current_bal' => $current_bal,
]);

mysqli_close($db);
