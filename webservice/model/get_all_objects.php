<?php

/*
 * Following code will list all the products
 */

// array for JSON response
$response = array();


// include db connect class
require '../controller/db_connect.php';

// connecting to db
$db = new DB_CONNECT();
mysql_query('SET CHARACTER SET utf8');

// get all products from products table
$result = mysql_query("SELECT idObject, nameObject, descObject, latObject, longObject, imagePath1Object, idUser ,nameUser, idCategory, nameCategory, idCity, nameCity
FROM smObject INNER JOIN smUser ON smUser.idUser = smObject.smUser_idUser
INNER JOIN smCategory ON smObject.smCategory_idCategory=smCategory.idCategory
ORDER BY addedDateTimeObject DESC;") or die(mysql_error());

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
        $object["descObject"] = $row["descObject"];
        $object["latObject"] = $row["latObject"];
        $object["longObject"] = $row["longObject"];
        $object["imagePath1Object"]=$row["imagePath1Object"];
        $object["idUser"] = $row["idUser"];
        $object["nameUser"] = $row["nameUser"];
        $object["idCategory"] = $row["idCategory"];
        $object["nameCategory"] = $row["nameCategory"];


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

