<?php

/*
 * Following code will list all the products
 */

$user = 'Louis';

// array for JSON response
$response = array();


// include db connect class
require_once __DIR__ . '../controller/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// get all products from products table
$result = mysql_query("SELECT * FROM smObject INNER JOIN smUser ON smUser.idUser = smObject.smUser_idUser WHERE smUser.nameUser='$user'") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["objects"] = array();

    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $object = array();
        $object["idObject"] = $row["idObject"];
        $object["nameObject"] = $row["nameObject"];
        $object["brandObject"] = $row["brandObject"];
        $object["descObject"] = $row["descObject"];
        $object["latObject"] = $row["latObject"];
        $object["longObject"] = $row["longObject"];
        $object["YearObject"] = $row["YearObject"];
        $object["idCity"] = $row["smCity_idCity"];
        $object["idCategory"] = $row["smCategory_idCategory"];

        // push single product into final response array
        array_push($response["objects"], $object);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No object found";

    // echo no users JSON
    echo json_encode($response);
}

