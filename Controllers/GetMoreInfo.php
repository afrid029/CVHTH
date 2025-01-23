<?php

use function PHPSTORM_META\type;

include('DBConnectivity.php');

// Get the current page from the URL, default to 1 if not set
$type = urldecode($_GET['type']);
$ID = $_GET['ID'];


if ($type === 'user') {

    $role = $_GET['role'];

    if($role === 'project manager'){
        $query = "SELECT
                    u.ID,
                    u.firstname,
                    u.lastname,
                    u.email,
                    u.contactno,
                    u.role,
                    GROUP_CONCAT(
                        DISTINCT CONCAT(us.firstname, ' ', us.lastname) SEPARATOR ', '
                    ) AS donors
                FROM
                    users u
                    LEFT JOIN projectmanager pm ON u.ID = pm.Manager_ID
                    LEFT JOIN project p ON pm.Project_ID = p.ID
                    LEFT JOIN projectmanagerdonor pmd ON u.ID = pmd.Manager_ID
                    LEFT JOIN users us ON us.ID = pmd.Donor_ID 
                WHERE
                    u.role = '$role'
                    AND u.ID = '$ID'
                GROUP BY
                    u.ID;";
    
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
    
    
    }else if($role === 'donor') {
        $query = "SELECT
                    u.ID,
                    u.firstname,
                    u.lastname,
                    u.email,
                    u.contactno,
                    u.role,
                    NVL (u.dob, '<i>Not provided</i>') dob,
                    GROUP_CONCAT(
                        DISTINCT CONCAT(dr.date, ' ', dr.amount) SEPARATOR ', '
                    ) AS donation,
                    GROUP_CONCAT(
                        DISTINCT CONCAT(
                            b.firstName,
                            ' ',
                            b.lastName,
                            '/',
                            ds.amount,
                            '/',
                            p.name
                        ) SEPARATOR ', '
                    ) AS donationsent
                FROM
                    users u
                    LEFT JOIN donationreceived dr ON u.ID = dr.Donor_ID
                    LEFT JOIN donationsent ds ON u.ID = ds.Donor_ID
                    LEFT JOIN beneficiant b ON ds.Beneficiant_ID = b.ID
                    LEFT JOIN project p ON ds.Project_ID = p.ID
                WHERE
                    u.role = '$role'
                    AND u.ID = '$ID'
                GROUP BY
                    u.ID;";
    
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
    }

}else if($type === 'donationsent') {
    $query = "SELECT
            ds.ID,
            ds.date,
            ds.amount,
            ds.purpose,
            CONCAT(u.firstname, ' ', u.firstname) donor,
            CONCAT(b.firstName, ' ', b.lastName) beneficent,
            p.name,
            GROUP_CONCAT(DISTINCT de.image SEPARATOR ', ') evidence
        FROM
            donationsent ds
            LEFT JOIN users u ON ds.Donor_ID = u.ID
            LEFT JOIN beneficiant b ON ds.Beneficiant_ID = b.ID
            LEFT JOIN project p ON ds.Project_ID = p.ID
            LEFT JOIN donationevidence de ON ds.ID = de.DS_ID
        WHERE
            ds.ID = '$ID'";

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
        $query = "SELECT
                p.ID,
                p.name,
                p.description,
                GROUP_CONCAT(
                    DISTINCT CONCAT(u.firstname, ' ', u.lastname) SEPARATOR ', '
                ) manager,
                GROUP_CONCAT(
                    DISTINCT CONCAT(b.firstName, ' ', b.lastName) SEPARATOR ', '
                ) beneficent
            FROM
                project p
                LEFT JOIN projectmanager pm ON p.ID = pm.Project_ID
                LEFT JOIN users u ON pm.Manager_ID = u.ID
                LEFT JOIN projectbeneficiant pb ON p.ID = pb.Project_ID
                LEFT JOIN beneficiant b ON pb.Beneficiant_ID = b.ID
            WHERE
                p.ID = '$ID'";

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
            $query = "SELECT
            b.ID,
            b.firstName,
            b.lastName,
            b.NIC,
            b.sex,
            b.dob,
            b.address,
            b.gsDivision,
            NVL(b.school, '<i>Not Provided</i>') school,
            NVL(b.grade, '<i>Not Provided</i>') grade,
            GROUP_CONCAT(
                DISTINCT CONCAT(ds.date, '#', ds.amount, '#', ds.purpose) SEPARATOR ' '
            ) sent,
            GROUP_CONCAT(DISTINCT bi.image SEPARATOR ', ') images
        FROM
            beneficiant b
            LEFT JOIN donationsent ds ON b.ID = ds.Beneficiant_ID
            LEFT JOIN beneficiantimages bi ON b.ID = bi.Beneficiant_ID
        WHERE
            b.ID = '$ID'";

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
}


// Return the results and pagination links as JSON


mysqli_close($db);
