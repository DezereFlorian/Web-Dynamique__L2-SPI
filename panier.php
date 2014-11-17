<?php
    include_once('entete.php');
    
    function get_panier($nb, $articles){
        global $bdd;
        switch($nb):
            case 1:
                $req = $bdd -> prepare("Select * from jeux where IDJeux='$articles[0]'");
                break;
            case 2:
                $req = $bdd -> prepare("Select * from jeux where IDJeux='$articles[0] or IDJeux='$articles[1]'");
                break;
            case 3:
                $req = $bdd -> prepare("Select * from jeux where IDJeux='$articles[0] or IDJeux='$articles[1]' or IDJeux='$articles[2]'");
                break;
        endswitch;
        $req -> execute();
        $get_panier = $req -> fetchAll();
        return $get_panier;
    }
    
    $nb_articles = sizeof($_SESSION['panier']);
    $lstPanier = get_panier($nb_articles, $_SESSION['panier']);
    
    foreach($lstPanier as $unJeu):
        $id = $unJeu['IDJeux'];
            $nom = $unJeu['NomJeu'];
            $desc = $unJeu['Descriptif'];
            $prix = $unJeu['Prix'];
            $stock = $unJeu['Stock'];
            $img = "images/".$unJeu['Image'];
            $sortie = dateFR($unJeu['DateDeSortie']);
            $categ = $unJeu['NomCateg'];
            $age = $unJeu['TrancheAge'];
// affichage de chaque jeu
    ?>
        <tr>
            <td><span class="cache"><?php echo $id; ?></span><a class="liendetail" href="detail_jeu.php?id=<?php echo $id; ?>"><?php echo $nom; ?></a></td> <!-- mets le span en caché avec visibility : hidden -->
            <td><a class="" href="detail_jeu.php?id=<?php echo $id; ?>"><img src="<?php echo $img; ?>"/></a></td>
            <td class='contenu_case'><?php echo $desc; ?></td>
            <td class='contenu_case'><?php echo $sortie; ?></td>
            <td class='contenu_case'><?php echo $prix; ?></td>
            <td class='contenu_case'><?php echo $categ; ?></td>
            <td class='contenu_case'><?php echo $age; ?></td>
            <td class='cachepanier'>
                <?php if($stock > 0): ?>
                    <img class='retirepanier' id="<?php echo $id ?>" src='images/panier_fleche.jpg'/>
                <?php else: ?>
                    Indisponible
                <?php endif; ?>
            </td> <!-- ajout au panier via jQuery -->
        </tr>
    <?php
    endforeach;
?>
    
<?php
    include_once('foot.php');
?>