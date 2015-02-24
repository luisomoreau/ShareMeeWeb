<?php
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=sharemee;charset=utf8', 'root', 'mysql');
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);