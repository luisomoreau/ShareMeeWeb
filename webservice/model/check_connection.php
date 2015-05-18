<?php

// array for JSON response
$response = array();

$fields = array();
$fields['mailUser'] = $_POST['mailUser'];
$fields['passwordUser'] = $_POST['passwordUser'];

// check for required fields
if (isset($_POST['mailUser']) && isset($_POST['passwordUser'])) {

    // include db connect class
    require '../controller/db_connect.php';

// connecting to db
    $db = new DB_CONNECT();
    mysql_query('SET CHARACTER SET utf8');

    $mailUser = mysql_real_escape_string($_POST['mailUser']);
    $passwordUser = mysql_real_escape_string($_POST['passwordUser']);

    // mysql update row with matched pid
    $result = mysql_query("SELECT passwordUser, idUser FROM smUser WHERE mailUser = '$mailUser'") or die(mysql_error());
    // check for empty result
    if ($result) {
        $row = $row = mysql_fetch_array($result);
        $passwordHash = $row["passwordUser"];
        $id = $row["idUser"];

        $hashSecure1 = md5(PREFIX_SALT.$passwordUser.SUFFIX_SALT);


        if ($hashSecure1 == $passwordHash) {
            // success
            $response["success"] = 1;
            $response["idUser"] = $id;
            $response["mailUser"] = $mailUser;
            $response["message"] = "Login successfull";
            // echoing JSON response
            echo json_encode($response);

        } else {
            //password incorrect
            $response["success"] = 2;
            $response["message"] = "Incorrect password";

            // echoing JSON response
            echo json_encode($response);

        }
    } else {
        // no user found
        $response["success"] = 3;
        $response["message"] = "User not found";

        // echo no users JSON
        echo json_encode($response);
    }
} else {
    // missing fields
    $response["success"] = 4;
    $response["message"] = "Missing fields";

    // echo no users JSON
    echo json_encode($response);
}