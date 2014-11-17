<!DOCTYPE html>
<?php
    include_once('entete.php');
?>
<?php
    function Jeux5($today){ // récupère les 5 jeux dernièrement sortis
        global $bdd;
        $req = $bdd -> prepare("SELECT * from jeux where DateDeSortie <= '$today' order by DateDeSortie desc limit 5;");
        $req -> execute();
        $get_jeux5 = $req -> fetchAll();
        return $get_jeux5;
    }
    function Sortie3($today){ // récupère les 3 prochaines sorties
        global $bdd;
        $req = $bdd -> prepare("SELECT * from jeux where DateDeSortie > '$today' order by DateDeSortie limit 3");
        $req -> execute();
        $get_sortie3 = $req -> fetchAll();
        return $get_sortie3;
    }
    function dateFR($datePHP1) // transforme la date anglaise (de la base) en date française
    {
        list($AAAA, $MM, $JJ) = explode("-", $datePHP1);
        $datePHP2 = $JJ."-".$MM."-".$AAAA;

        return $datePHP2;
    }
?>
<article class='bienvenue'>
    
    <p class='para_acceuil'>
        Bonjour et bienvenue sur le site de Vull !<br/>
        Nous vous présentons moult jeux, du simple jeu de société, au dernier jeu vidéo !
    </p>
    <br/><br/><br/><br/>
    <?php
        $date=date("Y-m-d"); //date d'aujourd'hui
        $lstJeux = Jeux5($date); // lance la fonction de récupération
        $lstSortie = Sortie3($date); //lance la fonction de récupération
    ?>
    <table>
        <tr>
    <?php
        foreach($lstJeux as $unJeu): // pour chaque jeu associe aux variables d'affichage les variables sortantes de la base
            $id = $unJeu['IDJeux'];
            $nom = $unJeu['NomJeu'];
            $prix = $unJeu['Prix'];
            $img = "images/".$unJeu['Image'];
            $link = "jeux.php?id=$id";
            
            //affichage de chaque jeu
    ?>
            <a href="<?php echo $link;?>"><td class='contenu_case'>
                <a class="" href="detail_jeu.php?id=<?php echo $id; ?>"><img src="<?php echo $img; ?>"/></a><br/>
                <span class="nomnew"><?php echo $nom;?></span><br/>
                <span class="prixnew"><?php echo $prix;?></span>
            </td></a>
        
    <?php
        endforeach;
    ?>
        </tr>
    </table>
    <br/>
    <a href="jeux.php" class="lienbasique">>>Voir tous les jeux<<</a> <!-- redirection vers l'ensemble des jeux sortis -->
    <br/><br/>
    <table>
        <tr>
    <?php
        foreach($lstSortie as $uneSortie): // pour chaque jeu associe aux variables d'affichage les variables sortantes de la base
            $id = $uneSortie['IDJeux'];
            $nom = $uneSortie['NomJeu'];
            $img = "images/".$uneSortie['Image'];
            $date = dateFR($uneSortie['DateDeSortie']);
            $link = "jeux.php?id=$id";
            
            //affichage de chaque jeu        
    ?>
        
        <a href="<?php echo $link;?>"><td class='contenu_case'>
               <a class="" href="detail_jeu.php?id=<?php echo $id; ?>"><img src="<?php echo $img; ?>"/></a><br/>
                <span class="nomnew"><?php echo $nom;?></span><br/>
                <span class="sortienew"><?php echo $date;?></span>
            </td></a>
        
    <?php
        endforeach;
    ?>
        </tr>
    </table>
    <br/>
    <a href="a_venir.php" class="lienbasique">>>Voir toutes les sorties<<</a> <!-- redirection vers l'ensemble des jeux qui vont sortir -->
</article>

<?php
    include_once('foot.php');
?>