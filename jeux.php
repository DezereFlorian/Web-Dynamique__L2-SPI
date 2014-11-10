<?php
    include_once('entete.php');
    
    function get_jeux(){
        global $bdd;
        $req = $bdd -> prepare("SELECT * from jeux as j, categorie as c, age as a where j.IDCateg = c.IDCategorie and j.IDAge = a.IDAge order by DateDeSortie;");
        $req -> execute();
        $get_jeux = $req -> fetchAll();
        return $get_jeux;
    }
    function dateFR($datePHP1)
    {
        list($AAAA, $MM, $JJ) = explode("-", $datePHP1);
        $datePHP2 = $JJ."-".$MM."-".$AAAA;

        return $datePHP2;
    }
    
    $lstJeux = get_jeux();
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
            <td><span class="cache"></span><?php echo $nom; ?></td> <!-- mets le span en caché avec visibility : hidden -->
            <td><img src="<?php $img; ?>"/>Yop</td>
            <td><?php echo $desc; ?></td>
            <td><?php echo $sortie; ?></td>
            <td><?php echo $prix; ?></td>
            <td><?php echo $categ; ?></td>
            <td><?php echo $age; ?></td>
            <td><button onclick="setPanier();">Ajouter au panier</button></td> <!-- ajout au panier via jQuery -->
        </tr>
    <?php
        endforeach;
    ?>
</table>

