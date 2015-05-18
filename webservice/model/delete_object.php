<?php

// array for JSON response
$response = array();

$fields = array();
$fields['idObject'] = $_POST['idObject'];


// check for required fields
if (isset($_POST['idObject'])) {

    $idObject = mysql_real_escape_string($_POST['idObject']);


// include db connect class
    require '../controller/db_connect.php';

// connecting to db
    $db = new DB_CONNECT();
    mysql_query('SET CHARACTER SET utf8');

    // mysql update row with matched pid
    $result = mysql_query("DELETE FROM smObject WHERE idObject=$idObject");

    // check if row inserted or not
    if ($result) {
        // successfully updated
        $response["success"] = 1;
        $response["message"] = "Object Supprimé.";

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
