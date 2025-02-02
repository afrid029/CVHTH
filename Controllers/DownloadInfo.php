<?php
if (isset($_POST['type'])) {
    $type = $_POST['type'];
    $from = $_POST['from'];
    $to = $_POST['to'];
    include('DBConnectivity.php');

    if ($type === 'donation') {
        $query = "SELECT dr.ID, NVL(CONCAT(u.firstname, ' ', u.lastname),'Deleted Donor') as name, dr.amount, dr.date
        from donationreceived dr
        LEFT JOIN users u ON dr.donor_ID = u.ID 
        WHERE date BETWEEN '$from' AND '$to'
        ORDER BY dr.date desc , u.firstname asc";

        $result = mysqli_query($db, $query);

        $data = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }

        mysqli_close($db);

        echo json_encode([
            'data' => $data
        ]);
    } else if ($type === 'sentdonation') {
        $query = "SELECT ds.ID, NVL(CONCAT(b.firstname, ' ',b.lastname),'Deleted Beneficiary') as benname, NVL(CONCAT(u.firstname, ' ',u.lastname), 'Deleted Donor') as donname, ds.amount, ds.date, ds.purpose
                from donationsent ds 
                LEFT JOIN beneficiant b ON ds.Beneficiant_ID = b.ID
                LEFT JOIN users u ON ds.Donor_ID = u.ID
                WHERE date BETWEEN '$from' AND '$to'
                ORDER BY ds.date DESC, b.firstName ASC";

        $result = mysqli_query($db, $query);

        $data = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }

        // echo "<script>console.log('Debug Objects: " . $data . "' );</script>";

        // print_r($data);

        mysqli_close($db);

        echo json_encode([
            'data' => $data
        ]);
    } else if ($type === 'donor') {

        $id = $_POST['ID'];

        $query = "SELECT dr.*
                FROM donationreceived dr
                WHERE dr.Donor_ID = '$id'
                AND date BETWEEN '$from' AND '$to'
                ORDER BY dr.date desc";

        $result = mysqli_query($db, $query);

        $data = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }

        mysqli_close($db);

        echo json_encode([
            'data' => $data
        ]);
    } else if ($type === 'beneficent'){
        $id = $_POST['ID'];

        $query = "SELECT ds.ID, ds.date, ds.amount, ds.purpose, p.name
                FROM donationsent ds
                LEFT JOIN users u ON ds.Donor_ID = u.ID
                LEFT JOIN project p ON ds.Project_ID = p.ID
                WHERE ds.Beneficiant_ID = '$id'
                ORDER BY ds.date desc";

        $result = mysqli_query($db, $query);

        $data = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }

        mysqli_close($db);

        echo json_encode([
            'data' => $data
        ]);   
    }
} else {
    header('Location: /donation');
}
