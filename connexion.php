<?php
//ATTENTION, CECI EST LA CONNEXION VIA L'HEBERGEUR
    try
        {
            $bdd = new PDO('mysql:host=db554162307.db.1and1.com;dbname=db554162307', 'dbo554162307', 'ludothequevullfac', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        }
        catch(PDOException $e)
        {
            die('Erreur : '.$e->getMessage());
        }
?>

