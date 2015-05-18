<?php

// array for JSON response
$response = array();

//Storing JSON POST fields into array
$fields = array();
$fields['nameObject'] = $_POST['nameObject'];
$fields['descObject'] = $_POST['descObject'];
$fields['latObject'] = $_POST['latObject'];
$fields['longObject'] = $_POST['longObject'];
$fields['imagePath1Object'] = $_POST['imagePath1Object'];
$fields['smUser_idUser'] = $_POST['smUser_idUser'];
$fields['smCategory_idCategory'] = $_POST['smCategory_idCategory'];


// check for required fields
if (isset($_POST['nameObject']) && isset($_POST['descObject']) && isset($_POST['smCategory_idCategory']) && isset($_POST['smUser_idUser'])) {

    //Store POST fields into variables
    $nameObject = mysql_real_escape_string($_POST['nameObject']);
    $descObject = mysql_real_escape_string($_POST['descObject']);
    $latObject = mysql_real_escape_string($_POST['latObject']);
    $longObject = mysql_real_escape_string($_POST['longObject']);
    $smUser_idUser = mysql_real_escape_string($_POST['smUser_idUser']);
    $smCategory_idCategory = mysql_real_escape_string($_POST['smCategory_idCategory']);

    //check if an image name has been set
    if (isset($_POST['imagePath1Object'])) {
        $imagePath1Object = mysql_real_escape_string($_POST['imagePath1Object']);
    } else {
        $imagePath1Object = "NULL";
    }


    //Include db connect class
    require '../controller/db_connect.php';

    //Connecting to db
    $db = new DB_CONNECT();
    mysql_query('SET CHARACTER SET utf8');

    // mysql update row with matched pid
    $result = mysql_query("INSERT INTO smObject (idObject, nameObject, descObject, latObject, longObject, imagePath1Object, addedDateTimeObject, smCity_idCity, smUser_idUser, smCategory_idCategory) VALUES (NULL,'$nameObject','$descObject', $latObject, $longObject,'$imagePath1Object' ,NOW(),NULL ,$smUser_idUser,$smCategory_idCategory)");

    // check if row inserted or not
    if ($result) {
        // successfully updated
        $response["success"] = 1;
        $response["message"] = "Objet ajoute.";

        // echoing JSON response
        echo json_encode($response);
    } else {
        echo(mysql_error());
        $response["success"] = 2;
        $response["message"] = "Requête incorrecte.";

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

