<?php

header('Content-Type: application/json; charset=utf-8');

/*
 * Following code will get single object details
 * An object is identified by object id (idObject)
 */

// array for JSON response
$response = array();

// include db connect class
require '../controller/db_connect.php';

// connecting to db
$db = new DB_CONNECT();
mysql_query('SET CHARACTER SET utf8');

if (isset($_GET["idUser"])) {
    $idUser = $_GET['idUser'];

// get all products from products table
$result = mysql_query("SELECT * FROM smUser WHERE idUser = $idUser") or die(mysql_error());

    if (!empty($result)) {
        // check for empty result
        if (mysql_num_rows($result) > 0) {

            $result = mysql_fetch_array($result);

            $user = array();
            $user["idUser"] = $result["idUser"];
            $user["nameUser"] = $result["nameUser"];
            $user["surnameUser"] = $result["surnameUser"];
            $user["mailUser"] = $result["mailUser"];
            $user["profilePictureUser"] = $result["profilePictureUser"];

            // success
            $response["success"] = 1;

            // user node
            $response["user"] = array();

            // push single product into final response array
            array_push($response["user"], $user);



            // echoing JSON response
            echo json_encode($response);
        } else {
            // no product found
            $response["success"] = 0;
            $response["message"] = "No user found";

            // echo no users JSON
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    } else {
        // no product found
        $response["success"] = 0;
        $response["message"] = "No user found";

        // echo no users JSON
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}