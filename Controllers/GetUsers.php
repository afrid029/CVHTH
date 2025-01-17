<?php


$db = mysqli_connect('localhost', 'root', '', 'CVHTH');

$role = urldecode($_GET['user']);

// echo $role;

$addonClass = '';
$loadFunc = '';

if ($role === 'admin') {
    $addonClass = 'table-row-admin';
    $loadFunc = 'adminsload';
} else if ($role === 'project manager') {
    $addonClass = 'table-row-pm';
    $loadFunc = 'pmsload';
} else if ($role === 'donor') {
    $addonClass = 'table-row-donor';
    $loadFunc = 'donorload';
}
$results_per_page = 10;

// Get the current page from the URL, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($page - 1) * $results_per_page;

// Get the total number of records


$total_received = '';

$sql = "SELECT COUNT(*) AS total FROM users WHERE role='$role'";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
$total_records = $row['total'];


$html = '';

if ($role === 'admin') {
    $query = "SELECT u.ID, u.firstname, u.lastname, u.email, u.contactno from users u
         WHERE role = '$role' ORDER BY u.firstname LIMIT $offset, $results_per_page";

    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $html .= "
                            <div class='table-row $addonClass'>
                           
                            
                                        <div>" . $row['firstname'] . " " . $row['lastname'] . "</div>
                                        <div >" . $row['email'] . "</div>
                                        <div>" . $row['contactno'] . "</div>
                                        <div style='text-align: center' class='buttons'>
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
} else if ($role === 'project manager') {
    // echo("into PM");
    $query = "SELECT u.ID, u.firstname, u.lastname, u.email, u.contactno, GROUP_CONCAT(p.name SEPARATOR ', ') AS name
        FROM users u, projectmanager pm, project p
        WHERE u.ID = pm.manager_id
        AND pm.project_ID = p.ID
        AND role = '$role' 
        GROUP BY u.ID
        ORDER BY u.firstname
        LIMIT $offset, $results_per_page";

    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $html .= "
                            <div class='table-row $addonClass'>
                           
                            
                                        <div>" . $row['firstname'] . " " . $row['lastname'] . "</div>
                                        <div >" . $row['email'] . "</div>
                                        <div >" . $row['contactno'] . "</div>
                                        <div >" . $row['name'] . "</div>
                                        <div style='text-align: center' class='buttons'>
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
} else if ($role === 'donor') {
    $query = "SELECT sq.ID, sq.firstname, sq.lastname, sq.contactno, sq.dob, NVL(amount, 0) AS donation from (SELECT u.id, u.firstname, u.lastname, u.contactno, u.dob, SUM(dr.amount) OVER (PARTITION BY u.ID) as amount, ROW_NUMBER() Over (PARTITION BY U.ID) rownum from users u LEFT JOIN donationreceived dr ON u.ID = dr.Donor_ID) sq where sq.rownum = 1 ORDER BY sq.firstname LIMIT $offset, $results_per_page";

    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $html .= "
                            <div class='table-row $addonClass'>
                           
                                        <div>More</div>
                                        <div>" . $row['firstname'] . " " . $row['lastname'] . "</div>
                                        <div >" . $row['contactno'] . "</div>
                                        <div >" . $row['donation'] . "</div>
                                        <div >" . $row['dob'] . "</div>
                                        <div style='text-align: center' class='buttons'>
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
}











// $html .= '</tbody></table>';

// Calculate total pages
$total_pages = ceil($total_records / $results_per_page);

// Generate pagination links
$pagination = "<div class='pagination'>";
if ($page > 1) {
    $pagination .= "<span class='textPagi' href='javascript:void(0);' onclick='$loadFunc(" . ($page - 1) . ")'>Previous</span> ";
}

for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        $pagination .= "<strong class='selected'>$i</strong> ";
    } else if ($i == 1) {
        $pagination .= "<span href='javascript:void(0);' onclick='$loadFunc($i)'>$i</span> ";
    } else if ($i == $total_pages) {
        $pagination .= "<span href='javascript:void(0);' onclick='$loadFunc($i)'>$i</span> ";
    } else if (abs($i - $page) < 3) {
        $pagination .= "<span href='javascript:void(0);' onclick='$loadFunc($i)'>$i</span> ";
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
    $pagination .= "<span class='textPagi' href='javascript:void(0);' onclick='$loadFunc(" . ($page + 1) . ")'>Next</span>";
}

$pagination .= "</div>";

// Return the results and pagination links as JSON
echo json_encode([
    'html' => $html,
    'pagination' => $pagination,
    'total_received' => $total_records
]);


mysqli_close($db);
