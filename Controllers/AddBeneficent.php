<?php 

if(isset($_POST['submit'])){
    include('DBConnectivity.php');
    SESSION_START();

    $query = "SELECT COUNT(*) cnt from beneficiant";

    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $randomId = rand(100, 999);

    $ID = 'Bene_'.$row['cnt']. $randomId;
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $nic = $_POST['nic'];
    $gender = $_POST['gender'];
    $date = $_POST['date'];
    $address = $_POST['address'];
    $gs = $_POST['gs'];

    $grade = isset($_POST['grade']) && strlen($_POST['grade']) > 0 ? $_POST['grade'] : NULL;
    $school = isset($_POST['school']) && strlen($_POST['school']) > 0 ? $_POST['school'] : NULL;

    mysqli_begin_transaction($db);

    $query = "INSERT INTO beneficiant VALUES('$ID', '$fname', '$lname', '$nic', '$gender', '$date', '$address', '$gs',". ($school === NULL ? "NULL" : "'$school'") . ", " . 
    ($grade === NULL ? "NULL" : "'$grade'") . ")";

    $result = mysqli_query($db, $query);

    $dependant = isset($_POST['dependant']) ? $_POST['dependant'] : '';
    $result1 = true;

    if($dependant !== ''){
        $dependants = explode(', ',$dependant);
        foreach($dependants as $dep) {
            $nameRel = explode('-', $dep);
            $query = "INSERT INTO beneficiantdependency VALUES('$ID', '$nameRel[1]', '$nameRel[0]')";
            $res = mysqli_query($db, $query);
            $result1 = $result1 && $res;
        }
    }
   

    $result2 = true;
    $project = isset($_POST['project']) ? $_POST['project'] : '';

    if($project !== ''){
        $projects = explode(', ', $project);
        foreach($projects as $proj) {
            $query = "INSERT INTO projectbeneficiant VALUES ('$proj', '$ID')";
            $res = mysqli_query($db, $query);
            $result2 = $result2 && $res;
        }
    }
    

    $result3 = true;

    $targetDirectory = "Public/Benificiants";
    $customFolder = $ID.' '.$fname;
    $targetDirectory =  $targetDirectory . '/' . $customFolder . '/';

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

            $query = "INSERT INTO beneficiantimages VALUES ('$ID', '$targetFile')";
            $res = mysqli_query($db, $query);

            $result3 = $result3 && $res;
        } else {
            $_SESSION['message'] = "Failed to upload Images. Try again later!";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            mysqli_rollback($db);
            mysqli_close($db);
            header('Location: /beneficent');
            break;
        }
    }

    if($result && $result1 && $result2 && $result3){
        mysqli_commit($db);
        mysqli_close($db);
        $_SESSION['message'] = "Beneficiary Created successfully!";
        $_SESSION['status'] = true;
        $_SESSION['fromAction'] = true;
        header('Location: /beneficent');
    }else {
        mysqli_rollback($db);
        mysqli_close($db);
        $_SESSION['message'] = "Unable to create. Try Again Later!";
        $_SESSION['status'] = false;
        $_SESSION['fromAction'] = true;
        header('Location: /beneficent');
    }

}else if(isset($_POST['edit-submit'])){
    include('DBConnectivity.php');
    SESSION_START();

    $ID = $_POST['ID'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $nic = $_POST['nic'];
    $gender = $_POST['gender'];
    $date = $_POST['date'];
    $address = $_POST['address'];
    $gs = $_POST['gs'];


    $grade = isset($_POST['grade']) && strlen($_POST['grade']) > 0 ? $_POST['grade'] : NULL;
    $school = isset($_POST['school']) && strlen($_POST['school']) > 0 ? $_POST['school'] : NULL;

    mysqli_begin_transaction($db);

    $query = "UPDATE beneficiant 
              SET firstname = '$fname', 
              lastname = '$lname', 
              nic = '$nic', 
              sex = '$gender', 
              dob = '$date', 
              address = '$address', 
              gsdivision = '$gs', 
              school = ". ($school === NULL ? "NULL" : "'$school'") . ", 
              grade = " .($grade === NULL ? "NULL" : "'$grade'"). "
              WHERE ID = '$ID'";


    $result = mysqli_query($db, $query);

    
    $query = "DELETE from beneficiantdependency 
    WHERE Beneficiant_ID = '$ID'";
    $delete2 = mysqli_query($db, $query);

    $dependant = isset($_POST['dependant']) ? $_POST['dependant'] : '';
    $result1 = true;

    if($dependant !== ''){
        $dependants = explode(', ',$dependant);
        foreach($dependants as $dep) {
            $nameRel = explode('-', $dep);
            $query = "INSERT INTO beneficiantdependency VALUES('$ID', '$nameRel[1]', '$nameRel[0]')";
            $res = mysqli_query($db, $query);
            $result1 = $result1 && $res;
        }
    }



    $query = "DELETE from projectbeneficiant 
    WHERE Beneficiant_ID = '$ID'";
    $delete1 = mysqli_query($db, $query);
   
    $result2 = true;
    $project = isset($_POST['project']) ? $_POST['project'] : '';

    if($project !== ''){
        $projects = explode(', ', $project);
        foreach($projects as $proj) {
            $query = "INSERT INTO projectbeneficiant VALUES ('$proj', '$ID')";
            $res = mysqli_query($db, $query);
            $result2 = $result2 && $res;
        }
    }

    if($result && $result1 && $result2 && $delete1 && $delete2){
        mysqli_commit($db);
        mysqli_close($db);
        $_SESSION['message'] = "Beneficiary Updated successfully!";
        $_SESSION['status'] = true;
        $_SESSION['fromAction'] = true;
        header('Location: /beneficent');
    }else {
        mysqli_rollback($db);
        mysqli_close($db);
        $_SESSION['message'] = "Unable to update. Try Again Later!";
        $_SESSION['status'] = false;
        $_SESSION['fromAction'] = true;
        header('Location: /beneficent');
    }
    

}else if (isset($_POST['del-submit'])){

    include('DBConnectivity.php');
    SESSION_START();

    mysqli_begin_transaction($db);

    $ID = $_POST['ID'];

    $query = "SELECT image from beneficiantimages WHERE Beneficiant_ID = '$ID'";
    $images = mysqli_query($db,$query);

    $query = "DELETE FROM beneficiant WHERE ID = '$ID'";
    $result = mysqli_query($db, $query);

    // print_r($result);

    if($result){
        $affected_row = mysqli_affected_rows($db);
        if($affected_row === 1){
            mysqli_commit($db);
            
        
            while($row = mysqli_fetch_assoc($images)){
                // print_r($row['image']);
                unlink($row['image']);
            }
        
            mysqli_close($db);

            $_SESSION['message'] = "Beneficiary Deleted successfully!";
            $_SESSION['status'] = true;
            $_SESSION['fromAction'] = true;
            header('Location: /beneficent');
        }else {
            mysqli_rollback($db);
            mysqli_close($db);
            $_SESSION['message'] = "Found Multiple Entries. Contact Adminstrator";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            header('Location: /beneficent');
        }
    }else {
        mysqli_rollback($db);
            mysqli_close($db);
            $_SESSION['message'] = "Unable to delete. Try again later";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            header('Location: /beneficent');
    }
    
}else {
    header('Location: /');
}

?>