<?php
if (isset($_POST['submit'])) {

    if (!isset($_COOKIE['user'])) {
        header('Location: /');
        exit();
    }

    SESSION_START();
    $updatedby = $_SESSION['fname'] . '-' . $_SESSION['role'];
    include('DBConnectivity.php');

    $query = "SELECT COUNT(*) cnt from donationsent";

    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);

    $randomId = rand(100, 999);

    $ID = 'DS_' . $row['cnt'] . $randomId;
    $donor = $_POST['donor'];
    $date = $_POST['date'];
    $project = $_POST['project'];
    $beneficent = $_POST['beneficent'];
    $amount = $_POST['amount'];
    $purpose = $_POST['purpose'];

    mysqli_begin_transaction($db);


    $query = "INSERT INTO donationsent VALUES ('$ID', '$donor', '$date', '$amount', '$purpose', '$project', '$beneficent','$updatedby')";

    $result = mysqli_query($db, $query);

   

    $result2 = true;

    $targetDirectory = "Public/Donations";
    $year = date('Y');
    $targetDirectory =  $targetDirectory . '/' . $year . '/';

    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory);
    }

    $length = count($_FILES["image"]["name"]);

    

    for ($i = 0; $i < $length; $i++) {
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"][$i], PATHINFO_EXTENSION));

        $timestamp = time(); // Current timestamp (seconds since Unix epoch)
        $randomNumber = rand(1000, 9999); // Random number to add some variability
        $targetFile = $targetDirectory . $ID . "_" . $timestamp . "_" . $randomNumber . "." . $imageFileType;

        if (move_uploaded_file($_FILES["image"]["tmp_name"][$i], $targetFile)) {
            // echo "The file has been uploaded successfully as: " . basename($targetFile);

            $query = "INSERT INTO donationevidence VALUES ('$ID', '$targetFile','$updatedby')";
            $res = mysqli_query($db, $query);

            $result2 = $result2 && $res;

        } else {
            $_SESSION['message'] = "Failed to upload Images. Try again later!";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            mysqli_rollback($db);
            mysqli_close($db);
            echo json_encode([
                "redirect" => "/sentdonation"
            ]);
            exit();
            break;
            return;
        }
    }

    if ($result && $result2) {
        $_SESSION['message'] = "Record saved successfully!";
        $_SESSION['status'] = true;
        $_SESSION['fromAction'] = true;
        mysqli_commit($db);
        mysqli_close($db);
        echo json_encode([
            "redirect" => "/sentdonation"
        ]);
        exit();
    } else {
        $_SESSION['message'] = "Unable to insert. Try again later!";
        $_SESSION['status'] = false;
        $_SESSION['fromAction'] = true;
        mysqli_rollback($db);
        mysqli_close($db);
        echo json_encode([
            "redirect" => "/sentdonation"
        ]);
        exit();
    }

  

}else if(isset($_POST['edit-submit'])){

    if (!isset($_COOKIE['user'])) {
        header('Location: /');
        exit();
    }

    SESSION_START();
    $updatedby = $_SESSION['fname'] . '-' . $_SESSION['role'];
    include('DBConnectivity.php');

    $ID = $_POST['ID'];
    $amount = $_POST['amount'];
    $donor = $_POST['donor'];
    $date = $_POST['date'];
    $project = $_POST['project'];
    $beneficent = $_POST['beneficent'];
    $purpose = $_POST['purpose'];

    $query = "UPDATE donationsent 
              SET Donor_ID = '$donor', 
              date = '$date', 
              amount = '$amount', 
              purpose = '$purpose', 
              project_id = '$project', 
              Beneficiant_ID = '$beneficent',
              updatedby = '$updatedby'
               WHERE ID = '$ID'";
    
    $result = mysqli_query($db, $query);

    if($result) {
        mysqli_close($db);
        $_SESSION['message'] = "Sent Donation updated successfully!";
        $_SESSION['status'] = true;
        $_SESSION['fromAction'] = true;
        header('Location: /sentdonation');
        exit();
    }else {
        mysqli_close($db);
        $_SESSION['message'] = "Unable to update. Try again later!";
        $_SESSION['status'] = false;
        $_SESSION['fromAction'] = true;
        header('Location: /sentdonation');
        exit();
    }


}else if (isset($_POST['del-submit'])){
    if (!isset($_COOKIE['user'])) {
        header('Location: /');
        exit();
    }

    SESSION_START();
    $updatedby = $_SESSION['fname'] . '-' . $_SESSION['role'];

    include('DBConnectivity.php');
   

    mysqli_begin_transaction($db);

    $ID = $_POST['ID'];

    $query = "SELECT image from donationevidence WHERE DS_ID = '$ID'";
    $images = mysqli_query($db,$query);

    $query = "DELETE FROM donationsent WHERE ID = '$ID'";
    $result = mysqli_query($db, $query);

    // print_r($result);

    if($result){
        $affected_row = mysqli_affected_rows($db);
        if($affected_row === 1){

            $query = "INSERT INTO activitylog (action, actionby, impact, old) VALUE ('D', '$updatedby', 'Distri.Don $ID', 'Deleted')";
            $result =  mysqli_query($db, $query);

            $result2 = true;

            while($row = mysqli_fetch_assoc($images)){
                // print_r($row['image']);
                $imgLink = $row['image'];
            
                $query = "INSERT INTO activitylog (action, actionby, impact, old) VALUE ('D', '$updatedby', 'D.DonationEvidence $ID', '$imgLink')";
                $res =  mysqli_query($db, $query);

                $result2 = $result2 && $res;
            }

            if($result && $result2) {
                mysqli_commit($db);
                while($row = mysqli_fetch_assoc($images)){
               
                    unlink($row['image']);
                }
                mysqli_close($db);
                $_SESSION['message'] = "Disbursed Donation Deleted successfully!";
                $_SESSION['status'] = true;
                $_SESSION['fromAction'] = true;
                header('Location: /sentdonation');
                exit();
            }else {
                mysqli_rollback($db);
                mysqli_close($db);
                $_SESSION['message'] = "DB is suffering from multiple transactions. Try again Later";
                $_SESSION['status'] = false;
                $_SESSION['fromAction'] = true;
                header('Location: /sentdonation');
                exit();
            }
           
        }else {
            mysqli_rollback($db);
            mysqli_close($db);
            $_SESSION['message'] = "Found Multiple Entries. Contact Adminstrator";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            header('Location: /sentdonation');
            exit();
        }
    }else {
        mysqli_rollback($db);
            mysqli_close($db);
            $_SESSION['message'] = "Unable to delete. Try again later";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            header('Location: /sentdonation');
            exit();
    }
    
}else {
    header('Location: /');
    exit();
}

?>
