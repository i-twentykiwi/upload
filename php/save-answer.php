<?php
    include_once("database.php");
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    
    if(isset($postdata) && !empty($postdata)) {
        
        $mid = mysqli_real_escape_string($mysqli, trim($request->userId));
        $field = mysqli_real_escape_string($mysqli, trim($request->field));
        $value = mysqli_real_escape_string($mysqli, trim($request->value));
        
        $qry = "UPDATE users SET $field='$value' WHERE mid = '$mid'";
        
        if($mysqli->query($qry) === TRUE) {
            $success = ['message' => 'Answer submitted successfully!'];
            echo json_encode(array("success" => $success));
        } else {
            $error = ['message' => 'Something went wrong. Please try again!', 'code' => '404'];
            echo json_encode(array("error" => $error));
        }
    }
    
?>    