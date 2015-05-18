<?php

// array for JSON response
$response = array();

$fields = array();
$fields['nameUser'] = $_POST['nameUser'];
$fields['surnameUser'] = $_POST['surnameUser'];
$fields['mailUser'] = $_POST['mailUser'];
$fields['passwordUser'] = $_POST['passwordUser'];

// check for required fields
if (isset($_POST['nameUser']) && isset($_POST['surnameUser']) && isset($_POST['mailUser']) && isset($_POST['passwordUser'])) {

    $nameUser = mysql_real_escape_string($_POST['nameUser']);
    $surnameUser = mysql_real_escape_string($_POST['surnameUser']);
    $mailUser = mysql_real_escape_string($_POST['mailUser']);
    $passwordUser = mysql_real_escape_string($_POST['passwordUser']);
    $dateRegistration;

    $hashSecure = md5(PREFIX_SALT.$passwordUser.SUFFIX_SALT);

// include db connect class
    require '../controller/db_connect.php';

// connecting to db
    $db = new DB_CONNECT();
    mysql_query('SET CHARACTER SET utf8');

    // mysql update row with matched pid
    $result = mysql_query("INSERT INTO smUser (idUser, nameUser, surnameUser, mailUser, passwordUser,dateRegistration,profilPictureUser) VALUES (NULL ,'$nameUser','$surnameUser','$mailUser','$hashSecure', NOW(), NULL)");

    // check if row inserted or not
    if ($result) {
        // successfully updated
        $response["success"] = 1;
        $response["message"] = "Utilisateur cree.";


        // echoing JSON response
        echo json_encode($response);
    } else {
        $response["success"] = 2;
        $response["message"] = "Requête incorrecte.";
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
    $response["fields"] = array();
    array_push($response["fields"], $fields);

    // echoing JSON response
    echo json_encode($response);
}

