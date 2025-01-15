<?php


$db = mysqli_connect('localhost', 'root', '', 'CVHTH');

$results_per_page = 10;

// Get the current page from the URL, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($page - 1) * $results_per_page;

// Get the total number of records
$sql = "SELECT COUNT(*) AS total FROM donation";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
$total_records = $row['total'];

$result = mysqli_query($db, "Select * from donation LIMIT $offset, $results_per_page");


$html = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= "<div class='table-row'>
                                <div>".$row['name']."</div>
                                <div style='text-align: end'>".$row['amount']."</div>
                                <div style='text-align: end'>".$row['date']."</div>
                                <div class='buttons'>
                                        <div class='btn edit'>
                                            Edit
                                        </div>
                                        <div class='btn del'>
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
    if($i == $page) {
        $pagination .= "<strong class='selected'>$i</strong> ";
        
    } else if ($i == 1) {
        $pagination .= "<span href='javascript:void(0);' onclick='loadPage($i)'>$i</span> ";
    } else if($i == $total_pages) {
        $pagination .= "<span href='javascript:void(0);' onclick='loadPage($i)'>$i</span> ";
    }else if(abs($i - $page) < 3){
        $pagination .= "<span href='javascript:void(0);' onclick='loadPage($i)'>$i</span> ";
    }else {
        if(substr($pagination, -3) !== '...'){
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
    'pagination' => $pagination
]);

mysqli_close($db);
?>
