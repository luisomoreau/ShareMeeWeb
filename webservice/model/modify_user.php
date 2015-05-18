<?php

// array for JSON response
$response = array();

$fields = array();
$fields['idUser'] = $_POST['idUser'];
$fields['nameUser'] = $_POST['nameUser'];
$fields['surnameUser'] = $_POST['surnameUser'];
$fields['mailUser'] = $_POST['mailUser'];
$fields['passwordUser'] = $_POST['passwordUser'];
$fields['profilPictureUser'] = $_POST['profilPictureUser'];

// check for required fields
if (isset($_POST['nameUser']) && isset($_POST['idUser']) && isset($_POST['surnameUser']) && isset($_POST['mailUser']) && isset($_POST['passwordUser'])) {

// include db connect class
    require '../controller/db_connect.php';

// connecting to db
    $db = new DB_CONNECT();
    mysql_query('SET CHARACTER SET utf8');

    $idUser = intval($_POST['idUser']);
    $nameUser = mysql_real_escape_string($_POST['nameUser']);
    $surnameUser = mysql_real_escape_string($_POST['surnameUser']);
    $mailUser = mysql_real_escape_string($_POST['mailUser']);
    $passwordUser = mysql_real_escape_string($_POST['passwordUser']);

    $hashSecure = md5(PREFIX_SALT.$passwordUser.SUFFIX_SALT);

    if (isset($_POST['profilPictureUser'])) {
        $profilPictureUser = mysql_real_escape_string($_POST['profilPictureUser']);
    } else {
        $profilPictureUser = "NULL";
    }
    $dateRegistration;


    // mysql update row with matched pid
    $result = mysql_query("UPDATE smUser SET nameUser='$nameUser',surnameUser='$surnameUser',mailUser='$mailUser',passwordUser='$hashSecure',profilPictureUser='$profilPictureUser' WHERE idUser=$idUser");

    // check if row inserted or not
    if ($result) {
        // successfully updated
        $response["success"] = 1;
        $response["message"] = "Profil mis à jour.";

        // echoing JSON response
        echo json_encode($response);
    } else {
        echo mysql_error();
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
