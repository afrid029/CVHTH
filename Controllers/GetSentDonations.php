<?php


include('DBConnectivity.php');


$results_per_page = 10;

// Get the current page from the URL, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($page - 1) * $results_per_page;

// Get the total number of records
$sql = "SELECT COUNT(*) AS total FROM donationsent";
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

$query = "SELECT ds.ID, NVL(b.firstname, '<i>Deleted</i>') AS ben_fn, NVL(b.lastname,  '<i>Beneficiary</i>') AS ben_ln, NVL(u.firstname, '<i>Deleted</i>') AS u_fn, NVL(u.lastname,  '<i>Donor</i>') AS u_ln, ds.amount, ds.date
from donationsent ds 
LEFT JOIN beneficiant b ON ds.Beneficiant_ID = b.ID
LEFT JOIN users u ON ds.Donor_ID = u.ID
ORDER BY ds.date DESC, b.firstName ASC
 LIMIT $offset, $results_per_page";

 $forPm = isset($_GET['pmID']) ? true : false;

 if($forPm){
    $pmID = $_GET['pmID'];
    $query = "SELECT ds.ID, NVL(b.firstname, '<i>Deleted</i>') AS ben_fn, NVL(b.lastname,  '<i>Beneficiary</i>') AS ben_ln, NVL(u.firstname, '<i>Deleted</i>') AS u_fn, NVL(u.lastname,  '<i>Donor</i>') AS u_ln, ds.amount, ds.date, pm.Manager_ID
    from donationsent ds 
    LEFT JOIN beneficiant b ON ds.Beneficiant_ID = b.ID
    LEFT JOIN users u ON ds.Donor_ID = u.ID
    LEFT JOIN projectmanager pm on pm.Project_ID = ds.Project_ID
    WHERE pm.Manager_ID = '$pmID'
    ORDER BY ds.date DESC, b.firstName ASC
    LIMIT $offset, $results_per_page";
 }



$result = mysqli_query($db, $query);


$html = '';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "
                    <div class='table-row'>
                   
                                 <div >
                            <img style='cursor: pointer' onclick = moreInfo('donationsent','" . $row['ID'] . "') src='/Assets/Images/infogreen.png' alt='info'></div>
                                <div>" . $row['ben_fn'] . " ".$row['ben_ln']."</div>
                                <div>" . $row['u_fn'] . " ".$row['u_ln']."</div>
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
    // $html .= "<tr><td colspan='2'>No results found.</td></tr>";
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
