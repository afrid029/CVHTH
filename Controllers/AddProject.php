<?php 
if(isset($_POST['submit'])){
    if (!isset($_COOKIE['user'])) {
        header('Location: /');
        exit();
    }
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

    $updatedby = $_SESSION['fname'] . '-' . $_SESSION['role'];

    $query = "INSERT INTO project VALUES('$ID', '$name', '$description', '$updatedby')";
    $result = mysqli_query($db, $query);
   
   

    $result1 = true;
    $resulty = true;
    // echo $result1;
    $manager = isset($_POST['manager']) ? $_POST['manager'] : '';
    if($manager !== ''){
         $managers = explode(', ', $manager);
        foreach($managers as $mgr) {
            $query = "INSERT INTO projectmanager VALUES ('$ID', '$mgr')";
            $res = mysqli_query($db, $query);
            $result1 = $result1 && $res;
        }

        $query = "INSERT INTO activitylog(action, actionby, impact, value, new) VALUES('I', '$updatedby', 'Project - $name', 'Manager', 'Inserted as => $manager')";
        $resulty = mysqli_query($db, $query);
    }
   

    $result2 = true;
    $resultx = true;
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
    $query = "INSERT INTO activitylog(action, actionby, impact, value, new) VALUES('I', '$updatedby', 'Project - $name', 'Beneficiary', 'Inserted => $beneficent')";
    $resultx = mysqli_query($db, $query);
   }


    if($result && $result1 && $result2 && $resultx && $resulty) {
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

    if (!isset($_COOKIE['user'])) {
        header('Location: /');
        exit();
    }



    include('DBConnectivity.php');
    SESSION_START();

    $updatedby = $_SESSION['fname'] . '-' . $_SESSION['role'];
    $ID = $_POST['ID'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    mysqli_begin_transaction($db);

    $query = "UPDATE project 
    SET name='$name', 
    description='$description',
    updatedby='$updatedby'
    WHERE id = '$ID'";

    $result = mysqli_query($db, $query);

    $query = "SELECT * from projectmanager Where Project_ID = '$ID'";
    $selectedResult = mysqli_query($db, $query);

    $result1 = true;
    $resulty = true;
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

        $query = "INSERT INTO activitylog(action, actionby, impact, value, new) VALUES('U', '$updatedby', 'Project - $name', 'Manager', 'Updated as => $manager')";
        $resulty = mysqli_query($db, $query);
    }else {
        if(mysqli_num_rows($selectedResult) > 0) {
            $query = "INSERT INTO activitylog(action, actionby, impact, value, new) VALUES('D', '$updatedby', 'Project - $name', 'Manager', 'All Managers Deleted')";
            $resulty = mysqli_query($db, $query);
        }
    }
   
    $query = "SELECT Beneficiant_ID from projectbeneficiant WHERE Project_ID = '$ID'";
    $selectResult = mysqli_query($db, $query);

    $result2 = true;
    $resultx = true;
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
        $query = "INSERT INTO activitylog(action, actionby, impact, value, new) VALUES('U', '$updatedby', 'Project - $name', 'Beneficiary', 'Updated As => $beneficent')";
        $resultx = mysqli_query($db, $query);
   }else {
    if(mysqli_num_rows($selectResult) > 0) {
        $query = "INSERT INTO activitylog(action, actionby, impact, value, new) VALUES('D', '$updatedby', 'Project - $name', 'Beneficiary', 'All Beneficiaries Deleted')";
        $resultx = mysqli_query($db, $query);
    }
   }

   if($result && $result1 && $result2 && $delete1 && $delete2 && $resultx && $resulty) {
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
    if (!isset($_COOKIE['user'])) {
        header('Location: /');
        exit();
    }

   

    include('DBConnectivity.php');
    SESSION_START();
    $updatedby = $_SESSION['fname'] . '-' . $_SESSION['role'];
    mysqli_begin_transaction($db);

    $ID = $_POST['ID'];

    $selectQuery = "SELECT name from project where  ID = '$ID'";
    $selectResult = mysqli_query($db, $selectQuery);

    $selectOutput = mysqli_fetch_assoc($selectResult);
    $sname = $selectOutput['name'];

    $query = "DELETE FROM project WHERE ID = '$ID'";
    $result = mysqli_query($db, $query);

    if($result){
        $affected_row = mysqli_affected_rows($db);
        if($affected_row === 1){
            $query = "INSERT INTO activitylog (action, actionby, impact, old) VALUE ('D', '$updatedby', '$sname-Project', 'Deleted')";
            $result =  mysqli_query($db, $query);

            if($result) {
                mysqli_commit($db);
                mysqli_close($db);
                $_SESSION['message'] = "Project Deleted successfully!";
                $_SESSION['status'] = true;
                $_SESSION['fromAction'] = true;
                header('Location: /project');
                exit();
            } else {
                mysqli_rollback($db);
                mysqli_close($db);
                $_SESSION['message'] = "DB is suffering from multiple transactions. Try again Later";
                $_SESSION['status'] = false;
                $_SESSION['fromAction'] = true;
                header('Location: /project');
                exit();
            }
            
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