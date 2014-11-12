<?php
    include_once('entete.php');
    
    function get_jeux($date){ //récupère tous les jeux
        global $bdd;
        $req = $bdd -> prepare("SELECT * from jeux as j, categorie as c, age as a where DateDeSortie > $date and j.IDCateg = c.IDCategorie and j.IDAge = a.IDAge order by DateDeSortie;");
        $req -> execute();
        $get_jeux = $req -> fetchAll();
        return $get_jeux;
    }
    function dateFR($datePHP1) // transforme la date anglaise (de la base) en date française
    {
        list($AAAA, $MM, $JJ) = explode("-", $datePHP1);
        $datePHP2 = $JJ."-".$MM."-".$AAAA;

        return $datePHP2;
    }
    $date=date("Y-m-d"); //date d'aujourd'hui
    $lstJeux = get_jeux($date); // lance la fonction de récupération des jeux

    
    // affichage du tableau avec tous les jeux
    ?>
<table>
    <tr>
        <th>Nom</th>
        <th>Image</th>
        <th>Description</th>
        <th>Date de sortie</th>
        <th>Prix</th>
        <th>Catégorie</th>
        <th>Age</th>
        <th></th>
    </tr>
    <?php
        foreach($lstJeux as $unJeu): // Pour chaque jeu, associer dans les variables correspondantes pour l'affichage
            $id = $unJeu['IDJeux'];
            $nom = $unJeu['NomJeu'];
            $desc = $unJeu['Descriptif'];
            $prix = $unJeu['Prix'];
            $img = "images/".$unJeu['Image'];
            $sortie = dateFR($unJeu['DateDeSortie']);
            $categ = $unJeu['NomCateg'];
            $age = $unJeu['TrancheAge'];
// affichage de chaque jeu
    ?>
        <tr>
            <td><span class="cache"><?php echo $id; ?></span><?php echo $nom; ?></td> <!-- mets le span en caché avec visibility : hidden -->
            <td><img src="<?php echo $img; ?>"/></td>
            <td><?php echo $desc; ?></td>
            <td><?php echo $sortie; ?></td>
            <td><?php echo $prix; ?></td>
            <td><?php echo $categ; ?></td>
            <td><?php echo $age; ?></td>
            <td class='cachepanier'><img id='addpanier' src='images/panier_fleche.jpg'/></td> <!-- ajout au panier via jQuery -->
        </tr>
    <?php
        endforeach;
    ?>
</table>

<?php 
    include_once('foot.php');
?>