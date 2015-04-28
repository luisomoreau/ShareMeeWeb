<?php

// array for JSON response
$response = array();

$fields = array();
$fields['idUser']=$_POST['idUser'];
$fields['nameUser']=$_POST['nameUser'];
$fields['surnameUser']=$_POST['surnameUser'];
$fields['mailUser']=$_POST['mailUser'];
$fields['passwordUser']=$_POST['passwordUser'];
$fields['profilPictureUser']=$_POST['profilPictureUser'];

// check for required fields
if (isset($_POST['nameUser']) && isset($_POST['idUser']) && isset($_POST['surnameUser']) && isset($_POST['mailUser']) && isset($_POST['passwordUser'])) {

    $idUser = $_POST['idUser'];
    $nameUser = $_POST['nameUser'];
    $surnameUser = $_POST['surnameUser'];
    $mailUser = $_POST['mailUser'];
    $passwordUser = $_POST['passwordUser'];

    if(isset($_POST['profilPictureUser'])){
        $profilPictureUser = $_POST['profilPictureUser'] ;
    }
    else{
        $profilPictureUser ="NULL";
    }
    $dateRegistration;

// include db connect class
    require '../controller/db_connect.php';

// connecting to db
    $db = new DB_CONNECT();
    mysql_query('SET CHARACTER SET utf8');

    // mysql update row with matched pid
    $result = mysql_query("UPDATE smUser SET nameUser='$nameUser',surnameUser='$surnameUser',mailUser='$mailUser',passwordUser='$passwordUser',profilPictureUser='$profilPictureUser' WHERE idUser=$idUser");

    // check if row inserted or not
    if ($result) {
        // successfully updated
        $response["success"] = 1;
        $response["message"] = "Profile mis à jour.";

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
    $response["fields"]=array();
    array_push($response["fields"], $fields);

    // echoing JSON response
    echo json_encode($response);
}
