
<?php

// array for JSON response
$response = array();

$fields = array();
$fields['nameObject']=$_POST['nameObject'];
$fields['descObject']=$_POST['descObject'];
//$fields['imagePathObject']=$_POST['imagePathObject'];
//$fields['smCategory_idCategory']=$_POST['smCategory_idCategory'];
//$fields['smUser_idUser']=$_POST['smUser_idUser'];


// check for required fields
if (isset($_POST['nameObject']) && isset($_POST['descObject']) /*&& isset($_POST['imagePathObject']) && isset($_POST['smCategory_idCategory'])&& isset($_POST['smUser_idUser'])*/) {

    $nameObject = $_POST['nameObject'];
    $descObject = $_POST['descObject'];
    //$imagePathObject = $_POST['imagePathObject'];
    //$smCategory_idCategory = $_POST['smCategory_idCategory'];
    //$smUser_idUser = $_POST['smUser_idUser'];
    $dateRegistration;

// include db connect class
    require '../controller/db_connect.php';

// connecting to db
    $db = new DB_CONNECT();
    mysql_query('SET CHARACTER SET utf8');

    // mysql update row with matched pid
    $result = mysql_query("INSERT INTO smobject (`idObject`, `nameObject`, `brandObject`, `descObject`, `latObject`, `longObject`, `yearObject`, `imagePath1Object`, `imagePath2Object`, `imagePath3Object`, `addedDateTimeObject`, `smCity_idCity`, `smUser_idUser`, `smCategory_idCategory`) VALUES (NULL, '$nameObject', NULL, '$descObject', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL,NULL,NULL)");

    // check if row inserted or not
    if ($result) {
        // successfully updated
        $response["success"] = 1;
        $response["message"] = "Objet ajoute.";

        // echoing JSON response
        echo json_encode($response);
    } else {
        $response["success"] = 2;
        $response["message"] = "Requête incorrecte.";
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
?>
