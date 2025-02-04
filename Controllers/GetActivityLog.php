<?php


include('DBConnectivity.php');


$results_per_page = 25;

// Get the current page from the URL, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($page - 1) * $results_per_page;

$sql = "SELECT COUNT(*) AS total FROM activitylog";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
$total_records = $row['total'];


$query = "SELECT ac.action, ac.actionby, ac.impact, ac.value, ac.old, ac.new, ac.time
        FROM activitylog ac
        ORDER BY ac.time desc
        LIMIT $offset, $results_per_page";

$result = mysqli_query($db, $query);


$html = '';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "
                    <div class='table-row'>
                                <div style='text-align: center'>" . $row['action'] ."</div>
                                <div style='text-align: center'>" . $row['actionby'] . "</div>
                                <div style='text-align: center'>" . $row['impact'] . "</div>
                                <div style='text-align: center'>" . $row['value'] . "</div>
                                <div style='text-align: center'>" . $row['old'] . "</div>
                                <div style='text-align: center'>" . $row['new'] . "</div>
                                <div style='text-align: center'>" . $row['time'] . "</div>
                               
                            </div>
                            <hr>";
    }
} else {
     $html .= "<div class='table-row'>
                <div style='grid-column: span 4; text-align: center; font-size: 12px; font-weight:700;'>NO Activity Logs Found</div>
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

mysqli_close($db);

echo json_encode([
    'html' => $html,
    'pagination' => $pagination
]);


