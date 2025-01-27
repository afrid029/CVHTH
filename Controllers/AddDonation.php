<?php 

if(isset($_POST['submit'])){

    SESSION_START();
    include('DBConnectivity.php');
    $donor = $_POST['donor'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];



    $query = "SELECT COUNT(*) cnt from donationreceived";

    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);

    $randomId = rand(100, 999);
    $ID = 'don_'.$row['cnt']. $randomId;

    $query = "INSERT INTO donationreceived VALUES('$ID','$donor', '$date', '$amount' )";
    $result = mysqli_query($db, $query);
    if($result) {
        mysqli_close($db);
        $_SESSION['message'] = "Donation entered successfully!";
        $_SESSION['status'] = true;
        $_SESSION['fromAction'] = true;
        header('Location: /donation');
    }else {
        mysqli_close($db);
        $_SESSION['message'] = "Unable to enter the info. Try Again Later!";
        $_SESSION['status'] = false;
        $_SESSION['fromAction'] = true;
        header('Location: /donation');
    }



    

}else if(isset($_POST['edit-submit'])){
    include('DBConnectivity.php');
    SESSION_START();

    $ID = $_POST['ID'];
    $donor = $_POST['donor'];
    $date = $_POST['date'];
    $amount = $_POST['amount'];

    $query = "UPDATE donationreceived 
    SET donor_id = '$donor', 
    date = '$date', 
    amount = '$amount' 
    WHERE ID = '$ID'";

    $result = mysqli_query($db, $query);

    if($result) {
        mysqli_close($db);
        $_SESSION['message'] = "Donation updated successfully!";
        $_SESSION['status'] = true;
        $_SESSION['fromAction'] = true;
        header('Location: /donation');
    }else {
        mysqli_close($db);
        $_SESSION['message'] = "Unable to update. Try again later!";
        $_SESSION['status'] = false;
        $_SESSION['fromAction'] = true;
        header('Location: /donation');
    }
}else if (isset($_POST['del-submit'])){

    include('DBConnectivity.php');
    SESSION_START();

    mysqli_begin_transaction($db);

    $ID = $_POST['ID'];
    $query = "DELETE FROM donationreceived WHERE ID = '$ID'";
    $result = mysqli_query($db, $query);

    if($result){
        $affected_row = mysqli_affected_rows($db);
        if($affected_row === 1){
            mysqli_commit($db);
            mysqli_close($db);
            $_SESSION['message'] = "Donation info Deleted successfully!";
            $_SESSION['status'] = true;
            $_SESSION['fromAction'] = true;
            header('Location: /donation');
        }else {
            mysqli_rollback($db);
            mysqli_close($db);
            $_SESSION['message'] = "Found Multiple Entries. Contact Adminstrator";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            header('Location: /donation');
        }
    }else {
        mysqli_rollback($db);
            mysqli_close($db);
            $_SESSION['message'] = "Unable to delete. Try again later";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            header('Location: /donation');
    }
    
}else {
    header('Location: /');
}



?>

