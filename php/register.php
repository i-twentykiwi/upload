<?php
    include_once("database.php");
    date_default_timezone_set("Asia/Kolkata");
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    if(isset($postdata) && !empty($postdata))
    {
        // receive all input values from the form
        $name = trim($request->name);
        $city = trim($request->city);
        $zone = trim($request->zone);
        $state = trim($request->state);
        $created = date( 'Y-m-d h:i:s');
        $storeName = trim($request->storeName);
        $status = 1; //Status is used for user availabililty.
        $pwd = strtok(trim($request->name), " ") . random_strings(4); // Creates 6 characters password;
        $uid = mysqli_real_escape_string($mysqli, trim($request->phoneNumber));
        $phoneNumber = mysqli_real_escape_string($mysqli, trim($request->phoneNumber));

        // first check the database to make sure 
        // a user does not already exist with the same uid
        $user_check_query = "SELECT uid FROM login WHERE uid='$uid' LIMIT 1";
        $user_exist = mysqli_query($mysqli, $user_check_query);

        if (mysqli_num_rows($user_exist) > 0) { // if user exists
            $error = ['message' => 'User is already exist', 'code' => '400'];
            echo json_encode(array("error" => $error));
        } else {
            $login_query = "INSERT INTO login (uid,pwd,created,status) VALUES ('$uid','$pwd','$created','$status')";
            $user_query = "INSERT INTO users (mid,name,store_name,phone_number,city,state,zone) VALUES ('$uid','$name','$storeName','$phoneNumber','$city','$state','$zone')";
            if ($mysqli->query($login_query) === TRUE && $mysqli->query($user_query) === TRUE) {
                $data = ['id' => mysqli_insert_id($mysqli),'userId' => $uid,'created' => $created];
                echo json_encode(array("user" => $data));
            }
        }
    }

    function random_strings($length_of_string)
    {
        $str_result = '0123456789';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }

?>