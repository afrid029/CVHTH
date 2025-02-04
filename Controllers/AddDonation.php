<?php 

if(isset($_POST['submit'])){

    if (!isset($_COOKIE['user'])) {
        header('Location: /');
        exit();
    }

    SESSION_START();
    $updatedby = $_SESSION['fname'] . '-' . $_SESSION['role'];
    include('DBConnectivity.php');
    $donor = $_POST['donor'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];



    $query = "SELECT COUNT(*) cnt from donationreceived";

    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);

    $randomId = rand(100, 999);
    $ID = 'don_'.$row['cnt']. $randomId;

    $query = "INSERT INTO donationreceived VALUES('$ID','$donor', '$date', '$amount', '$updatedby' )";
    $result = mysqli_query($db, $query);
    if($result) {
        mysqli_close($db);
        $_SESSION['message'] = "Donation entered successfully!";
        $_SESSION['status'] = true;
        $_SESSION['fromAction'] = true;
        header('Location: /donation');
        exit();
    }else {
        mysqli_close($db);
        $_SESSION['message'] = "Unable to enter the info. Try Again Later!";
        $_SESSION['status'] = false;
        $_SESSION['fromAction'] = true;
        header('Location: /donation');
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
    $donor = $_POST['donor'];
    $date = $_POST['date'];
    $amount = $_POST['amount'];

    $query = "UPDATE donationreceived 
    SET donor_id = '$donor', 
    date = '$date', 
    amount = '$amount',
    updatedby = '$updatedby' 
    WHERE ID = '$ID'";

    $result = mysqli_query($db, $query);

    if($result) {
        mysqli_close($db);
        $_SESSION['message'] = "Donation updated successfully!";
        $_SESSION['status'] = true;
        $_SESSION['fromAction'] = true;
        header('Location: /donation');
        exit();
    }else {
        mysqli_close($db);
        $_SESSION['message'] = "Unable to update. Try again later!";
        $_SESSION['status'] = false;
        $_SESSION['fromAction'] = true;
        header('Location: /donation');
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
    $query = "DELETE FROM donationreceived WHERE ID = '$ID'";
    $result = mysqli_query($db, $query);

    if($result){
        $affected_row = mysqli_affected_rows($db);
        if($affected_row === 1){
            $query = "INSERT INTO activitylog (action, actionby, impact, old) VALUE ('D', '$updatedby', 'Received.Don $ID', 'Deleted')";
            $result =  mysqli_query($db, $query);

            if($result) {
                mysqli_commit($db);
                mysqli_close($db);
                $_SESSION['message'] = "Donation info Deleted successfully!";
                $_SESSION['status'] = true;
                $_SESSION['fromAction'] = true;
                header('Location: /donation');
                exit();
            }else {
                mysqli_rollback($db);
                mysqli_close($db);
                $_SESSION['message'] = "DB is suffering from multiple transactions. Try again Later";
                $_SESSION['status'] = false;
                $_SESSION['fromAction'] = true;
                header('Location: /donation');
                exit();
            }
            
        }else {
            mysqli_rollback($db);
            mysqli_close($db);
            $_SESSION['message'] = "Found Multiple Entries. Contact Adminstrator";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            header('Location: /donation');
            exit();
        }
    }else {
        mysqli_rollback($db);
            mysqli_close($db);
            $_SESSION['message'] = "Unable to delete. Try again later";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            header('Location: /donation');
            exit();
    }
    
}else {
    header('Location: /');
    exit();
}



?>

