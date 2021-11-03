<?php
    include_once("database.php");
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    if(isset($postdata) && !empty($postdata))
    {
        $phoneNumber = mysqli_real_escape_string($mysqli, trim($request->phoneNumber));
        
        $sql = "SELECT * FROM partners WHERE phone_number='$phoneNumber'";
        $result = mysqli_query($mysqli,$sql);
        
        if (mysqli_num_rows($result) > 0) {
            echo true;
        } else {
            echo false;
        }
    }
?>