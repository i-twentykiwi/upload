<?php
    include_once("database.php");
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    if(isset($postdata) && !empty($postdata))
    {
        $mid = mysqli_real_escape_string($mysqli, trim($request->userId));
        
        $sql = "SELECT * FROM users WHERE mid='$mid'";
        $result = mysqli_query($mysqli,$sql);
        
        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
            echo json_encode(array("user" => $data));
        } else {
            $error = ['message' => 'Invalid credentials', 'code' => '404', 'userId' => $mid];
            echo json_encode(array("error" => $error));
        }
    }
?>