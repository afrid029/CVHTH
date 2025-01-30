<?php 
if(isset($_POST['submit'])){
    SESSION_START();
    include ('DBConnectivity.php');

    $query = "SELECT COUNT(*) cnt FROM project";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $random = random_int(100,999);
    

    mysqli_begin_transaction($db);

    $ID = 'Proj_'.$row['cnt'].$random;
    $name = $_POST['name'];
    $description = $_POST['description'];

    // echo $ID;

    $query = "INSERT INTO project VALUES('$ID', '$name', '$description')";
    $result = mysqli_query($db, $query);
   
   

    $result1 = true;
    // echo $result1;
    $manager = isset($_POST['manager']) ? $_POST['manager'] : '';
    if($manager !== ''){
         $managers = explode(', ', $manager);
        foreach($managers as $mgr) {
            $query = "INSERT INTO projectmanager VALUES ('$ID', '$mgr')";
            $res = mysqli_query($db, $query);
            $result1 = $result1 && $res;
        }
    }
   

    $result2 = true;
    $beneficent = isset($_POST['beneficent']) ? $_POST['beneficent'] : '';
    
   if($beneficent !== '') {
    $beneficents = explode(', ', $beneficent);
    // print_r(sizeof($beneficents));
    foreach($beneficents as $bene) {
        // echo $bene;
        $query = "INSERT INTO projectbeneficiant VALUES ('$ID', '$bene')";
        $res = mysqli_query($db, $query);
        // echo mysqli_error($db);
        $result2 = $result2 && $res;
    }
   }

    // echo $result. ' one';
    // echo $result1. ' two';
    //  echo $result2. 'three';

    if($result && $result1 && $result2) {
        mysqli_commit($db);
        mysqli_close($db);
        $_SESSION['message'] = "Project Created successfully!";
        $_SESSION['status'] = true;
        $_SESSION['fromAction'] = true;
        header('Location: /project');
    }else {
        mysqli_rollback($db);
        mysqli_close($db);
        $_SESSION['message'] = "Unable to create Project. Try Again Later";
        $_SESSION['status'] = false;
        $_SESSION['fromAction'] = true;
        header('Location: /project');
    }

}else if(isset($_POST['edit-submit'])){

    include('DBConnectivity.php');
    SESSION_START();
    $ID = $_POST['ID'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    mysqli_begin_transaction($db);

    $query = "UPDATE project 
    SET name='$name', 
    description='$description' 
    WHERE id = '$ID'";

    $result = mysqli_query($db, $query);

    $result1 = true;
    $query = "DELETE FROM projectmanager WHERE Project_ID = '$ID'";
    $delete1 = mysqli_query($db, $query);
    // echo $result1;
    $manager = isset($_POST['manager']) ? $_POST['manager'] : '';
    if($manager !== ''){
         $managers = explode(', ', $manager);
        foreach($managers as $mgr) {
            $query = "INSERT INTO projectmanager VALUES ('$ID', '$mgr')";
            $res = mysqli_query($db, $query);
            $result1 = $result1 && $res;
        }
    }
   

    $result2 = true;
    $query = "DELETE FROM projectbeneficiant WHERE Project_ID = '$ID'";
    $delete2 = mysqli_query($db, $query);

    $beneficent = isset($_POST['beneficent']) ? $_POST['beneficent'] : '';
   if($beneficent !== '') {
    $beneficents = explode(', ', $beneficent);
    // print_r(sizeof($beneficents));
    foreach($beneficents as $bene) {
        // echo $bene;
        $query = "INSERT INTO projectbeneficiant VALUES ('$ID', '$bene')";
        $res = mysqli_query($db, $query);
        // echo mysqli_error($db);
        $result2 = $result2 && $res;
    }
   }

   if($result && $result1 && $result2 && $delete1 && $delete2) {
        mysqli_commit($db);
        mysqli_close($db);
        $_SESSION['message'] = "Project updated successfully!";
        $_SESSION['status'] = true;
        $_SESSION['fromAction'] = true;
        header('Location: /project');   
    }else {
        mysqli_rollback($db);
        mysqli_close($db);
        $_SESSION['message'] = "Unable to update. Try Again Later";
        $_SESSION['status'] = false;
        $_SESSION['fromAction'] = true;
        header('Location: /project');
    }


}else if (isset($_POST['del-submit'])){

    include('DBConnectivity.php');
    SESSION_START();

    mysqli_begin_transaction($db);

    $ID = $_POST['ID'];
    $query = "DELETE FROM project WHERE ID = '$ID'";
    $result = mysqli_query($db, $query);

    if($result){
        $affected_row = mysqli_affected_rows($db);
        if($affected_row === 1){
            mysqli_commit($db);
            mysqli_close($db);
            $_SESSION['message'] = "Project Deleted successfully!";
            $_SESSION['status'] = true;
            $_SESSION['fromAction'] = true;
            header('Location: /project');
        }else {
            mysqli_rollback($db);
            mysqli_close($db);
            $_SESSION['message'] = "Found Multiple Entries. Contact Adminstrator";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            header('Location: /project');
        }
    }else {
        mysqli_rollback($db);
            mysqli_close($db);
            $_SESSION['message'] = "Unable to delete. Try again later";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            header('Location: /project');
    }
    
}else {
    header('Location: /');
}
?>