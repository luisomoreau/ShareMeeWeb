<?php

/*
 * Following code will list all the products
 */

// array for JSON response
$response = array();


// include db connect class
require_once __DIR__ . '../controller/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// get all products from products table
$result = mysql_query("SELECT * FROM smCategory") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["categories"] = array();

    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $category = array();
        $category["idCategory"] = $row["idCategory"];
        $category["nameCategory"] = $row["nameCategory"];


        // push single product into final response array
        array_push($response["categories"], $category);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No category found";

    // echo no users JSON
    echo json_encode($response);
}

