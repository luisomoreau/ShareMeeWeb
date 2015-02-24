<?php
include '../controller/db_connect.php';
$user = 'Louis';

$reponse = $bdd->query("SELECT * FROM smObject INNER JOIN smUser ON smUser.idUser = smObject.smUser_idUser WHERE smUser.nameUser='$user'");
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Foundation</title>
    <link rel="stylesheet" href="../scss/app.css" />
    <script src="../bower_components/modernizr/modernizr.js"></script>
</head>
<body>

    <p>Objets de l'utilisateur :</p>
    <p><?php echo $user;?></p>

    <table>
        <tr>
            <td>idObjet</td>
            <td>Nom</td>
            <td>Marque</td>
            <td>Description</td>
            <td>latitude</td>
            <td>longitude</td>
            <td>Année</td>
            <td>Catégorie</td>
        </tr>

    <?php
    while ($donnees = $reponse->fetch()) {
        ?>
        <tr>
            <td><?php echo $donnees['idObject']?></td>
            <td><?php echo $donnees['nameObject']?></td>
            <td><?php echo $donnees['brandObject']?></td>
            <td><?php echo $donnees['descObject']?></td>
            <td><?php echo $donnees['latObject']?></td>
            <td><?php echo $donnees['longObject']?></td>
            <td><?php echo $donnees['YearObject']?></td>
            <td><?php echo $donnees['smCategory_idCategory']?></td>

        </tr>

    <?php
    }
    ?>
    </table>

    <?php
    $reponse->closeCursor(); // Termine le traitement de la requête
    ?>

    <iframe
        width="450"
        height="250"
        frameborder="0" style="border:0"
        src="https://www.google.fr/maps/embed/v1/place?key=AIzaSyCBKT8OiY-SD0zZLlDNyhTiTjZ6jT3IyPQ&qlocation=50.6333004,3.0430696">
    </iframe>
</body>
</html>