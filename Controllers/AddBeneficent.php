<?php 
// print_r($_FILES["image"]["tmp_name"]);
// var_dump($_POST);
// exit();

if(isset($_POST['submit'])){

    if (!isset($_COOKIE['user'])) {
        header('Location: /');
        exit();
    }

    SESSION_START();
    $updatedby = $_SESSION['fname'] . '-' . $_SESSION['role'];

    include('DBConnectivity.php');

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
    ($grade === NULL ? "NULL" : "'$grade'") . ", '$updatedby')";

    $result = mysqli_query($db, $query);


    $dependant = isset($_POST['dependant']) ? $_POST['dependant'] : '';
    $result1 = true;
    $resultx = true;

    if($dependant !== ''){
        $dependants = explode(', ',$dependant);
        foreach($dependants as $dep) {
            $nameRel = explode('-', $dep);
            $query = "INSERT INTO beneficiantdependency VALUES('$ID', '$nameRel[1]', '$nameRel[0]')";
            $res = mysqli_query($db, $query);
            $result1 = $result1 && $res;

            
        }

        $query = "INSERT INTO activitylog(action, actionby, impact, value, new) VALUES('I', '$updatedby', 'Beneficiary - $fname', 'Dependants', 'Inserted as => $dependant')";
        $resultx = mysqli_query($db, $query);
    }
   

    $result2 = true;
    $resulty = true;
    $project = isset($_POST['project']) ? $_POST['project'] : '';

    if($project !== ''){
        $projects = explode(', ', $project);
        foreach($projects as $proj) {
            $query = "INSERT INTO projectbeneficiant VALUES ('$proj', '$ID')";
            $res = mysqli_query($db, $query);
            $result2 = $result2 && $res;
        }

        $query = "INSERT INTO activitylog(action, actionby, impact, value, new) VALUES('I', '$updatedby', 'Beneficiary - $fname', 'Project', 'Inserted as => $project')";
        $resulty = mysqli_query($db, $query);
    }
    

    $result3 = true;

    $targetDirectory = "Public/Benificiants";
    $customFolder = $ID.' '.$fname;
    $targetDirectory =  $targetDirectory . '/' . $customFolder . '/';

    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory);
    }

    $length = count($_FILES["image"]["name"]);

    // print_r($_FILES["image"]);

    

    for ($i = 0; $i < $length; $i++) {
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"][$i], PATHINFO_EXTENSION));

        $timestamp = time(); // Current timestamp (seconds since Unix epoch)
        $randomNumber = rand(1000, 9999); // Random number to add some variability
        $targetFile = $targetDirectory . $ID . "_" . $timestamp . "_" . $randomNumber . "." . $imageFileType;

        if (move_uploaded_file($_FILES["image"]["tmp_name"][$i], $targetFile)) {
            // echo "The file has been uploaded successfully as: " . basename($targetFile);

            $query = "INSERT INTO beneficiantimages VALUES ('$ID', '$targetFile', '$updatedby')";
            $res = mysqli_query($db, $query);

            $result3 = $result3 && $res;
        } else {
            $_SESSION['message'] = "Failed to upload Images. Try again later!";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            mysqli_rollback($db);
            mysqli_close($db);
            echo json_encode([
                "redirect" => "/beneficent"
            ]);
            exit();
            break;
            return;
        }
    }

    if($result && $result1 && $result2 && $result3 && $resultx && $resulty){
        mysqli_commit($db);
        mysqli_close($db);
        $_SESSION['message'] = "Beneficiary Created successfully!";
        $_SESSION['status'] = true;
        $_SESSION['fromAction'] = true;
        echo json_encode([
            "redirect" => "/beneficent"
        ]);
        exit();
        // header('Location: /beneficent');

    }else {
        mysqli_rollback($db);
        mysqli_close($db);
        $_SESSION['message'] = "Unable to create. Try Again Later!";
        $_SESSION['status'] = false;
        $_SESSION['fromAction'] = true;
        echo json_encode([
            "redirect" => "/beneficent"
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
              grade = " .($grade === NULL ? "NULL" : "'$grade'"). ",
              updatedby = '$updatedby'
              WHERE ID = '$ID'";


    $result = mysqli_query($db, $query);


    $query = "SELECT * FROM beneficiantdependency 
    WHERE Beneficiant_ID = '$ID'";
    $SelectResult = mysqli_query($db, $query);


    $query = "DELETE from beneficiantdependency 
    WHERE Beneficiant_ID = '$ID'";
    $delete2 = mysqli_query($db, $query);

    $dependant = isset($_POST['dependant']) ? $_POST['dependant'] : '';
    $result1 = true;
    $resultx = true;

    
    $selectedArray = array();
    while ($row = mysqli_fetch_assoc($SelectResult)){
        $selectedArray[] = $row['Name'].'-'.$row['Relation'];
    }
    $array = str_split(implode(', ', $selectedArray));
    array_walk($array, function(&$char) {
        $char = strtolower($char);
    });
    sort($array);


    $array1 = str_split($dependant); 
    array_walk($array1, function(&$char) {
        $char = strtolower($char);
    });
    sort($array1);


    $depchange = implode(', ', $array) !== implode(', ', $array1);

  

    if($dependant !== ''){
        $dependants = explode(', ',$dependant);
        foreach($dependants as $dep) {
            $nameRel = explode('-', $dep);
            $query = "INSERT INTO beneficiantdependency VALUES('$ID', '$nameRel[1]', '$nameRel[0]')";
            $res = mysqli_query($db, $query);
            $result1 = $result1 && $res;
        }

        if($depchange) {
            $query = "INSERT INTO activitylog(action, actionby, impact, value, new) VALUES('U', '$updatedby', 'Beneficiary - $fname', 'Dependants', 'Updated as => $dependant')";
            $resultx = mysqli_query($db, $query);
        }
    }else {
        if(mysqli_num_rows($SelectResult) > 0){
            $query = "INSERT INTO activitylog(action, actionby, impact, value, new) VALUES('D', '$updatedby', 'Beneficiary - $fname', 'Dependants', 'All Dependants Deleted')";
            $resultx = mysqli_query($db, $query);
        }
    }


    $query = "SELECT * FROM projectbeneficiant 
    WHERE Beneficiant_ID = '$ID'";
    $SelectResult = mysqli_query($db, $query);


    $query = "DELETE from projectbeneficiant 
    WHERE Beneficiant_ID = '$ID'";
    $delete1 = mysqli_query($db, $query);
   
    $result2 = true;
    $resulty = true;
    $project = isset($_POST['project']) ? $_POST['project'] : '';

    $selectedArray = array();
    while ($row = mysqli_fetch_assoc($SelectResult)){
        $selectedArray[] = $row['Project_ID'];
    }
    



    if($project !== ''){
        $projects = explode(', ', $project);
        foreach($projects as $proj) {
            $query = "INSERT INTO projectbeneficiant VALUES ('$proj', '$ID')";
            $res = mysqli_query($db, $query);
            $result2 = $result2 && $res;
        }
        sort($projects);
        sort($selectedArray);
        if($projects != $selectedArray){
            $query = "INSERT INTO activitylog(action, actionby, impact, value, new) VALUES('U', '$updatedby', 'Beneficiary - $fname', 'Projects', 'Updated as => $project')";
            $resulty = mysqli_query($db, $query);
        }
    }else {
        if(mysqli_num_rows($SelectResult) > 0){
            $query = "INSERT INTO activitylog(action, actionby, impact, value, new) VALUES('D', '$updatedby', 'Beneficiary - $fname', 'Projects', 'All Projects Deleted')";
            $resulty = mysqli_query($db, $query);
        }
    }

    if($result && $result1 && $result2 && $delete1 && $delete2 && $resultx && $resulty){
        mysqli_commit($db);
        mysqli_close($db);
        $_SESSION['message'] = "Beneficiary Updated successfully!";
        $_SESSION['status'] = true;
        $_SESSION['fromAction'] = true;
        header('Location: /beneficent');
        exit();
    }else {
        mysqli_rollback($db);
        mysqli_close($db);
        $_SESSION['message'] = "Unable to update. Try Again Later!";
        $_SESSION['status'] = false;
        $_SESSION['fromAction'] = true;
        header('Location: /beneficent');
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

    $query = "SELECT image from beneficiantimages WHERE Beneficiant_ID = '$ID'";
    $images = mysqli_query($db,$query);


    $selectQuery = "SELECT firstName from beneficiant where  ID = '$ID'";
    $selectResult = mysqli_query($db, $selectQuery);

    $selectOutput = mysqli_fetch_assoc($selectResult);
    $sfname = $selectOutput['firstName'];

    $query = "DELETE FROM beneficiant WHERE ID = '$ID'";
    $result = mysqli_query($db, $query);

    // print_r($result);

    if($result){
        $affected_row = mysqli_affected_rows($db);
        if($affected_row === 1){


            $query = "INSERT INTO activitylog (action, actionby, impact, old) VALUE ('D', '$updatedby', '$sfname-Beneficiary', 'Deleted')";
            $result =  mysqli_query($db, $query);

            $result2 = true;

            while($row = mysqli_fetch_assoc($images)){
                // print_r($row['image']);
                $imgLink = $row['image'];
            
                $query = "INSERT INTO activitylog (action, actionby, impact, old) VALUE ('D', '$updatedby', '$sfname-BeneficiaryImage', '$imgLink')";
                $res =  mysqli_query($db, $query);

                $result2 = $result2 && $res;
            }

            if($result && $result2){
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
                exit();
            }else {
                mysqli_rollback($db);
                mysqli_close($db);
                $_SESSION['message'] = "DB is suffering from multiple transactions. Try again Later";
                $_SESSION['status'] = false;
                $_SESSION['fromAction'] = true;
                header('Location: /beneficent');
                exit();
            }

          
        }else {
            mysqli_rollback($db);
            mysqli_close($db);
            $_SESSION['message'] = "Found Multiple Entries. Contact Adminstrator";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            header('Location: /beneficent');
            exit();
        }

    }else {
        mysqli_rollback($db);
            mysqli_close($db);
            $_SESSION['message'] = "Unable to delete. Try again later";
            $_SESSION['status'] = false;
            $_SESSION['fromAction'] = true;
            header('Location: /beneficent');
            exit();
    }
    
}else {
    header('Location: /');
    exit();
}

?>