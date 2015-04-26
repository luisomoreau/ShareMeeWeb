<?php

// array for JSON response
$response = array();

$fields = array();
$fields['nameObject']=$_POST['nameObject'];
$fields['descObject']=$_POST['descObject'];
$fields['latObject'] = $_POST['latObject'];
$fields['longObject'] = $_POST['longObject'];
//$fields['imagePathObject']=$_POST['imagePathObject'];
$fields['smUser_idUser']=$_POST['smUser_idUser'];
$fields['smCategory_idCategory']=$_POST['smCategory_idCategory'];



// check for required fields
if (isset($_POST['nameObject']) && isset($_POST['descObject']) /*&& isset($_POST['imagePathObject'])*/ && isset($_POST['smCategory_idCategory'])&& isset($_POST['smUser_idUser'])) {

    $nameObject = $_POST['nameObject'];
    $descObject = $_POST['descObject'];
    $latObject = $_POST['latObject']+1.1;
    $longObject = $_POST['longObject']+1.1;
    //$imagePathObject = $_POST['imagePathObject'];
    $smUser_idUser = $_POST['smUser_idUser']+0;
    $smCategory_idCategory = $_POST['smCategory_idCategory']+0;

    $latObject=$latObject-1.1;
    $longObject=$longObject-1.1;
    $champs=array();
    $champs['nameObject']=$nameObject;
    $champs['descObject']=$descObject;
    $champs['latObject']=$latObject;
    $champs['longObject']=$longObject;
    $champs['smUser_idUser']=$smUser_idUser;
    $champs['smCategory_idCategory']=$smCategory_idCategory;

// include db connect class
    require '../controller/db_connect.php';

// connecting to db
    $db = new DB_CONNECT();
    mysql_query('SET CHARACTER SET utf8');

    // mysql update row with matched pid
    $result = mysql_query("INSERT INTO smobject (idObject, nameObject, brandObject, descObject, latObject, longObject, yearObject, imagePath1Object, imagePath2Object, imagePath3Object, addedDateTimeObject, smCity_idCity, smUser_idUser, smCategory_idCategory) VALUES (NULL,'$nameObject',NULL,'$descObject', $latObject, $longObject,NULL ,NULL ,NULL ,NULL ,NULL,NULL ,$smUser_idUser,$smCategory_idCategory)");

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
        $response["fields"]=array();
        array_push($response["fields"], $fields);
        $response["champs"]=array();
        array_push($response["champs"], $champs);

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

