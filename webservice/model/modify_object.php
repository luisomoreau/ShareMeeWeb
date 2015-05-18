<?php

// array for JSON response
$response = array();

$fields = array();
$fields['idObject'] = $_POST['idObject'];
$fields['nameObject'] = $_POST['nameObject'];
$fields['descObject'] = $_POST['descObject'];
$fields['latObject'] = $_POST['latObject'];
$fields['longObject'] = $_POST['longObject'];
$fields['smUser_idUser'] = $_POST['smUser_idUser'];
$fields['smCategory_idCategory'] = $_POST['smCategory_idCategory'];
$fields['imagePath1Object'] = $_POST['imagePath1Object'];

// check for required fields
if (isset($_POST['idObject']) && isset($_POST['nameObject']) && isset($_POST['descObject']) && isset($_POST['latObject']) && isset($_POST['longObject']) && isset($_POST['smUser_idUser']) && isset($_POST['smCategory_idCategory'])) {

    $idObject = intval($_POST['idObject']);
    $nameObject = mysql_real_escape_string($_POST['nameObject']);
    $descObject = mysql_real_escape_string($_POST['descObject']);
    $latObject = mysql_real_escape_string($_POST['latObject']);
    $longObject = mysql_real_escape_string($_POST['longObject']);
    $idUser = mysql_real_escape_string($_POST['smUser_idUser']);
    $idCategory = mysql_real_escape_string($_POST['smCategory_idCategory']);

    if (isset($_POST['imagePath1Object'])) {
        $imagePath1Object = mysql_real_escape_string($_POST['imagePath1Object']);
    } else {
        $imagePath1Object = "NULL";
    }
    $dateRegistration;

// include db connect class
    require '../controller/db_connect.php';

// connecting to db
    $db = new DB_CONNECT();
    mysql_query('SET CHARACTER SET utf8');

    // mysql update row with matched pid
    $result = mysql_query("UPDATE smObject SET nameObject = '$nameObject', descObject = '$descObject', latObject = $latObject, longObject = $longObject, imagePath1Object = '$imagePath1Object', smCategory_idCategory = $idCategory WHERE idObject = $idObject;");

    // check if row inserted or not
    if ($result) {
        // successfully updated
        $response["success"] = 1;
        $response["message"] = "Objet mis à jour.";

        // echoing JSON response
        echo json_encode($response);
    } else {
        echo mysql_error();
        $response["success"] = 2;
        $response["message"] = "Requête incorrecte.";
        $response["fields"] = array();
        array_push($response["fields"], $fields);

        echo json_encode($response);
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
