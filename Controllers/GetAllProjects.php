<?php
include('DBConnectivity.php');

$results_per_page = 10;

// Get the current page from the URL, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($page - 1) * $results_per_page;

// Get the total number of records
$sql = "SELECT COUNT(*) AS total FROM project";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
$total_records = $row['total'];

$total_received = '';
// if ($page === 1) {
//     $sql = "SELECT sum(amount) AS total_received FROM project";
//     $result = mysqli_query($db, $sql);
//     $row = mysqli_fetch_assoc($result);
//     $total_received = $row['total_received'];
// }

$query="SELECT 
    p.ID,
    p.name AS projectName,
    p.description AS projectDescription,
    NVL(GROUP_CONCAT( DISTINCT CONCAT(u.firstname, ' ', u.lastname) SEPARATOR ', '), '<i>Not Assigned</i>') AS managers,
    (SELECT COUNT(*) 
     FROM projectbeneficiant pb_sub 
     WHERE pb_sub.Project_ID = p.ID) AS beneCount
FROM 
    project p
LEFT JOIN 
    projectmanager pm ON p.ID = pm.Project_ID
LEFT JOIN 
    users u ON u.ID = pm.Manager_ID
GROUP BY 
    p.ID, p.name, p.description
ORDER BY 
    p.name ASC
LIMIT $offset, $results_per_page";

$result = mysqli_query($db, $query);
// echo $result;

$html = '';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "
                    <div class='table-row'>
                   
                    
                                <div >
                            <img style='cursor: pointer' onclick = moreInfo('project'," . $row['ID'] . ") src='/Assets/Images/infoyellow.png' alt='info'></div>
                                <div>" . $row['projectName'] . "</div>
                                <div>" . $row['projectDescription'] . "</div>
                                <div >" . $row['managers'] . "</div>
                                <div style='text-align:center' > " . $row['beneCount'] . " </div>
                                <div class='buttons'>
                                        <div onclick=Edit(" . $row['ID'] . ") class='btn edit'>
                                                Edit
                                            </div>
                                            <div  onclick=Delete(" . $row['ID'] . ") class='btn del'>
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
    'total' => $total_records
]);

mysqli_close($db);
