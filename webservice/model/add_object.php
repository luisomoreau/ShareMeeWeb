<?php

// array for JSON response
$response = array();

$fields = array();
$fields['nameObject']=$_POST['nameObject'];
$fields['descObject']=$_POST['descObject'];
$fields['latObject'] = $_POST['latObject'];
$fields['longObject'] = $_POST['longObject'];
$fields['imagePathObject']=$_POST['imagePathObject'];
$fields['smUser_idUser']=$_POST['smUser_idUser'];
$fields['smCategory_idCategory']=$_POST['smCategory_idCategory'];



// check for required fields
if (isset($_POST['nameObject']) && isset($_POST['descObject']) && isset($_POST['smCategory_idCategory'])&& isset($_POST['smUser_idUser'])) {

    $nameObject = $_POST['nameObject'];
    $descObject = $_POST['descObject'];
    $latObject = $_POST['latObject'];
    $longObject = $_POST['longObject'];
    $smUser_idUser = $_POST['smUser_idUser'];
    $smCategory_idCategory = $_POST['smCategory_idCategory'];

    if(isset($_POST['imagePathObject'])){
        $imagePathObject = $_POST['imagePathObject'];
    }
    else{
        $imagePathObject = null;
    }



// include db connect class
    require '../controller/db_connect.php';

// connecting to db
    $db = new DB_CONNECT();
    mysql_query('SET CHARACTER SET utf8');

    // mysql update row with matched pid
    $result = mysql_query("INSERT INTO smObject (idObject, nameObject, descObject, latObject, longObject, imagePath1Object, addedDateTimeObject, smCity_idCity, smUser_idUser, smCategory_idCategory) VALUES (NULL,'$nameObject','$descObject', $latObject, $longObject,NULL ,NOW(),NULL ,$smUser_idUser,$smCategory_idCategory)");

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
    $response["fields"]=array();
    array_push($response["fields"], $fields);

    // echoing JSON response
    echo json_encode($response);
}

