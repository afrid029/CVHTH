<?php

use function PHPSTORM_META\type;

include('DBConnectivity.php');

// Get the current page from the URL, default to 1 if not set
$type = urldecode($_GET['type']);
$ID = $_GET['ID'];

if ($type === 'donation') {

    $query = "SELECT dr.ID, dr.date, dr.amount, dr.Donor_ID, concat(u.firstname, ' ', u.lastname) as name
    from donationreceived dr
    LEFT JOIN users u ON dr.Donor_ID = u.ID
    where dr.ID = '$ID'";

    $result = mysqli_query($db, $query);

    $data = array();


    // $html = '';

    if (mysqli_num_rows($result) == 1) {

        $data = mysqli_fetch_assoc($result);
       
    } else {
        // $html .= "<tr><td colspan='2'>No results found.</td></tr>";
    }

    echo json_encode([
        'data' => $data,
    
    ]);
} else if($type === 'user'){
    $query = "SELECT u.ID, u.email, u.role, u.contactno, u.dob, u.firstname, u.lastname
              FROM users u 
              where u.ID = '$ID'";

    $result = mysqli_query($db, $query);

    $data = array();
    $projects = array();
    $donors = array();


    // $html = '';

    if (mysqli_num_rows($result) == 1) {

        $data = mysqli_fetch_assoc($result);
       
    } else {
        // $html .= "<tr><td colspan='2'>No results found.</td></tr>";
    }

    if($data['role'] === 'project manager'){
        $query = "SELECT GROUP_CONCAT(p.ID SEPARATOR ', ') ID, GROUP_CONCAT(p.name SEPARATOR ', ') name
                from projectmanager pm
                JOIN project p ON p.ID = pm.Project_ID
                WHERE pm.Manager_ID = '$ID'";

        $result = mysqli_query($db, $query);

        if (mysqli_num_rows($result) == 1) {

            $projects = mysqli_fetch_assoc($result);
           
        } else {
            // $html .= "<tr><td colspan='2'>No results found.</td></tr>";
            // $projects = '';
        }

        $query = "SELECT GROUP_CONCAT(CONCAT(u.firstname, ' ', u.lastname) SEPARATOR ', ') as name, GROUP_CONCAT(u.ID SEPARATOR ', ') ID
                from projectmanagerdonor pmd
                JOIN users u ON u.ID = pmd.Donor_ID
                WHERE pmd.Manager_ID = '$ID'";

        $result = mysqli_query($db, $query);

        if (mysqli_num_rows($result) == 1) {

            $donors = mysqli_fetch_assoc($result);
           
        } else {
            // $html .= "<tr><td colspan='2'>No results found.</td></tr>";
        }



    }

    echo json_encode([
        'data' => $data,
        'projects' => $projects,
        'donors' => $donors
    
    ]);
}else if($type === 'sentdonation'){

    $query = "SELECT ds.ID, ds.Donor_ID, ds.date, ds.Beneficiant_ID, ds.amount, ds.Project_ID,ds.purpose
             from donationsent ds
             Where ds.ID = '$ID'";

    $result = mysqli_query($db, $query);

    $data = array();


    // $html = '';

    if (mysqli_num_rows($result) == 1) {

        $data = mysqli_fetch_assoc($result);
       
    } else {
        // $html .= "<tr><td colspan='2'>No results found.</td></tr>";
    }

    echo json_encode([
        'data' => $data,
    
    ]);

}else if($type === 'project') {
    $query = "SELECT p.ID, p.name, p.description, GROUP_CONCAT(DISTINCT pm.Manager_ID SEPARATOR ', ') prid, GROUP_CONCAT(DISTINCT pb.Beneficiant_ID SEPARATOR ', ') benid
            from project p
            LEFT JOIN projectmanager pm ON p.ID = pm.Project_ID
            LEFT JOIN projectbeneficiant pb ON p.ID = pb.Project_ID
            where p.ID = '$ID'";

    $result = mysqli_query($db, $query);

    $data = array();


    // $html = '';

    if (mysqli_num_rows($result) == 1) {

        $data = mysqli_fetch_assoc($result);
       
    } else {
        // $html .= "<tr><td colspan='2'>No results found.</td></tr>";
    }

    echo json_encode([
        'data' => $data,
    
    ]);
}else if($type === 'beneficent') {

    $query = "SELECT b.ID, b.firstName, b.lastName, b.NIC, b.sex, b.dob, b.address, b.gsDivision, b.school, b.grade,
            GROUP_CONCAT(DISTINCT pb.Project_ID SEPARATOR ', ') prid, GROUP_CONCAT(DISTINCT p.name SEPARATOR ', ')prname, GROUP_CONCAT(DISTINCT CONCAT(bd.Name,' (',bd.Relation,')') SEPARATOR ', ') depnamedisplay,
            GROUP_CONCAT(DISTINCT CONCAT(bd.Name,'-',bd.Relation) SEPARATOR ', ') depname
            from beneficiant b
            LEFT JOIN projectbeneficiant pb ON b.ID = pb.Beneficiant_ID
            LEFT JOIN beneficiantdependency bd ON b.ID = bd.Beneficiant_ID
            LEFT JOIN project p ON pb.Project_ID = p.ID
            where b.ID = '$ID'
            GROUP BY b.ID";

    $result = mysqli_query($db, $query);

    $data = array();


    // $html = '';

    if (mysqli_num_rows($result) == 1) {

        $data = mysqli_fetch_assoc($result);
       
    } else {
        // $html .= "<tr><td colspan='2'>No results found.</td></tr>";
    }

  // $html .= "<tr><td colspan='2'>No results found.</td></tr>";
    

    echo json_encode([
        'data' => $data
    
    ]);
}


// Return the results and pagination links as JSON


mysqli_close($db);
