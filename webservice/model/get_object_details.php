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

if (isset($_GET["idObject"])) {
    $idObject = intval($_GET['idObject']);

// get all products from products table
    $result = mysql_query("SELECT * FROM smObject INNER JOIN smUser ON smUser.idUser = smObject.smUser_idUser INNER JOIN smCategory ON smObject.smCategory_idCategory=smCategory.idCategory WHERE idObject = $idObject") or die(mysql_error());

    if (!empty($result)) {
        // check for empty result
        if (mysql_num_rows($result) > 0) {

            $result = mysql_fetch_array($result);
            //add query's result into an array
            $object = array();
            $object["idObject"] = $result["idObject"];
            $object["nameObject"] = $result["nameObject"];
            $object["descObject"] = $result["descObject"];
            $object["latObject"] = $result["latObject"];
            $object["longObject"] = $result["longObject"];
            $object["imagePath1Object"] = $result["imagePath1Object"];
            $object["addedDateTimeObject"] = $result["addedDateTimeObject"];
            $object["idUser"] = $result["idUser"];
            $object["nameUser"] = $result["nameUser"];
            $object["surnameUser"] = $result["surnameUser"];
            $object["idCategory"] = $result["idCategory"];
            $object["nameCategory"] = $result["nameCategory"];

            // success
            $response["success"] = 1;

            // user node
            $response["object"] = array();

            // push single product into final response array
            array_push($response["object"], $object);


            // echoing JSON response
            echo json_encode($response);
        } else {
            // no product found
            $response["success"] = 0;
            $response["message"] = "No product found";

            // echo no users JSON
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    } else {
        // no product found
        $response["success"] = 0;
        $response["message"] = "No product found";

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