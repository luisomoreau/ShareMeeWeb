<?php

/*
 * Following code will list all the products
 */

// array for JSON response
$response = array();

$fields = array();
$fields['search_field'] = $_POST['search_field'];
$fields['category'] = $_POST['category'];

// check for required fields
if (isset($_POST['search_field']) && isset($_POST['category'])) {

    $searchField = mysql_real_escape_string($_POST['search_field']);
    $category = mysql_real_escape_string($_POST['category']);

    $searchField = utf8_encode($searchField);
    $category = utf8_encode($category);


    // include db connect class
    require '../controller/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();
    mysql_query('SET CHARACTER SET utf8');

    if ($category == "Toutes catégories") {
        // get products from products table
        $result = mysql_query("SELECT idObject, nameObject, descObject, latObject, longObject, imagePath1Object, idUser ,nameUser, idCategory, nameCategory
    FROM smObject INNER JOIN smUser ON smUser.idUser = smObject.smUser_idUser
    INNER JOIN smCategory ON smObject.smCategory_idCategory=smCategory.idCategory WHERE smObject.nameObject LIKE '%$searchField%' AND smObject.descObject LIKE '%$searchField%'
    ORDER BY addedDateTimeObject DESC;") or die(mysql_error());
    } else {
        // get products from products table
        $result = mysql_query("SELECT idObject, nameObject, descObject, latObject, longObject, imagePath1Object, idUser ,nameUser, idCategory, nameCategory
    FROM smObject INNER JOIN smUser ON smUser.idUser = smObject.smUser_idUser
    INNER JOIN smCategory ON smObject.smCategory_idCategory=smCategory.idCategory WHERE smCategory.nameCategory LIKE '%$category%' AND smObject.nameObject LIKE '%$searchField%' AND smObject.descObject LIKE '%$searchField%'
    ORDER BY addedDateTimeObject DESC;") or die(mysql_error());
    }

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
            $object["imagePath1Object"] = $row["imagePath1Object"];
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
        $response["fields"] = array();
        array_push($response["fields"], $fields);

        // echo no users JSON
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

