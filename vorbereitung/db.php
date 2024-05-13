<?php

//  $username = define for >$stmt = bind_param()<;
//  have: id = i
//  have: uname = s
//  have: passwd = s


    require_once('dbaccess.php');


    $db_obj = new mysqli($host, $dbuser, $dbpassword, $database);

    if ($db_obj->connect_error) {
        echo "Connection Error: " . $db_obj->connect_error;
        exit();
    }

    $sql="SELECT * FROM admins WHERE uname = ?;";
    // $sql="SELECT * FROM admins WHERE uname = '$username';";
    $stmt = $db_obj->prepare($sql);
    
    // $stmt->bind_param('s', TYPE CODE HERE);  //s -> string, i -> integer, d -> double, b -> blob
    //  couldve first bind_param() then defined the $variables
    $stmt->execute();
    $result = $stmt->get_result();
    $user=$result->fetch_assoc();

    if($user){

        //


    }
