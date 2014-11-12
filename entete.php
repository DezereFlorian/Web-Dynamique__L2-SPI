<?php
    include_once('connexion.php');
    $connect = 1; // vérifie si on est connecté, afin d'afficher le menu de ça
?>
<html>
    <head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
     <link rel="stylesheet"  media="screen" type="text/css" title="design" href="global.css"/>
    <title>Ludotheque de Vull</title>
    
    </head>
    <banniere></banniere>
    <body>
    <nav> <!-- menu -->
        <ul>
            <li><a href="./index.php"> Accueil </a></li>
            <li>
                <a>Jeux</a>
                <ul>
                    <li><a href="./jeux.php"> Tous les jeux </a></li>
                    <li><a href="./a_venir.php"> Jeux a venir </a></li>
                </ul>
            </li>
            <li><a href="./seconnecter.php"> Connexion </a></li>
            <?php 
            if($connect==1):?>
            <li><a href="./panier.php"> Panier </a></li>
            <li><a href="./mon_profil.php"> Mon Profil </a></li>
            <li><a href="./index.php?seDeco=ok">Deconnexion</a></li>
            <?php endif;?>
        </ul>
    </nav>
        <section>