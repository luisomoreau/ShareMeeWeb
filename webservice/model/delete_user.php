<?php

// array for JSON response
$response = array();

$fields = array();
$fields['idUser'] = $_POST['idUser'];


// check for required fields
if (isset($_POST['idUser'])) {

    $idUser = intval($_POST['idUser']);


// include db connect class
    require '../controller/db_connect.php';

// connecting to db
    $db = new DB_CONNECT();
    mysql_query('SET CHARACTER SET utf8');

    // mysql update row with matched pid
    $result = mysql_query("DELETE FROM smObject WHERE smUser_idUser=$idUser");


    // check if row deleted or not
    if ($result) {
        // successfully updated
        $response["success"] = 1;
        $response["message"] = "Objets Supprimés";

        // echoing JSON response
        echo json_encode($response);

        $result1 = mysql_query("DELETE FROM smUser WHERE idUser=$idUser");

        if ($result1) {
            // successfully updated
            $response1["success"] = 1;
            $response1["message"] = "User Supprimé.";

            // echoing JSON response
            echo json_encode($response1);
        } else {
            echo mysql_error();
            $response1["success"] = 2;
            $response1["message"] = "Requête incorrecte.";
        }

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
