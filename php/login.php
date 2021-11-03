<?php
    include_once("database.php");
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    if(isset($postdata) && !empty($postdata))
    {
        $uid = mysqli_real_escape_string($mysqli, trim($request->userId));
        $pwd = mysqli_real_escape_string($mysqli, trim($request->password));
        
        $sql = "SELECT id,uid,created,status FROM login WHERE uid='$uid' AND pwd='$pwd'";
        $result = mysqli_query($mysqli,$sql);
        
        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
            echo json_encode(array("user" => $data));
        } else {
            $error = ['message' => 'User does not exist, please enter different credentials.', 'code' => '1001'];
            echo json_encode(array("error" => $error));
        }
    }
?>