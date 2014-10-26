<!DOCTYPE html>
<?php
    include_once('entete.php');
?>
<?php
    function Jeux5($today){
        global $bdd;
        $req = $bdd -> prepare("SELECT * from jeux where DateDeSortie <= '$today' order by DateDeSortie desc limit 5;");
        $req -> execute();
        $get_jeux5 = $req -> fetchAll();
        return $get_jeux5;
    }
    function Sortie3($today){
        global $bdd;
        $req = $bdd -> prepare("SELECT * from jeux where DateDeSortie > '$today' order by DateDeSortie limit 3");
        $req -> execute();
        $get_sortie3 = $req -> fetchAll();
        return $get_sortie3;
    }
    function dateFR($datePHP1)
    {
        list($AAAA, $MM, $JJ) = explode("-", $datePHP1);
        $datePHP2 = $JJ."-".$MM."-".$AAAA;

        return $datePHP2;
    }
?>
<article>
    
    <p>
        Bonjour et bienvenue sur le site de Vull !<br/>
        Nous vous présentons moult jeux, du simple jeu de société, au dernier jeu vidéo !
    </p>
    <?php
        $date=date("Y-m-d");
        $lstJeux = Jeux5($date);
        $lstSortie = Sortie3($date);
    ?>
    <table>
        <tr>
    <?php
        foreach($lstJeux as $unJeu):
            $id = $unJeu['IDJeux'];
            $nom = $unJeu['Nom'];
            $prix = $unJeu['Prix'];
            $img = "images/".$unJeu['Image'];
            $link = "jeux.php?id=$id";
    ?>
        
            <a href="<?php echo $link;?>"><td>
                <img src="<?php echo $img;?>" alt="miniature de <?php echo $nom; ?>" class="miniature"/><br/>
                <span class="nomnew"><?php echo $nom;?></span><br/>
                <span class="prixnew"><?php echo $prix;?></span>
            </td></a>
        
    <?php
        endforeach;
    ?>
        </tr>
    </table>
    <br/>
    <a href="jeux.php" class="lienbasique">>>Voir tous les jeux<<</a>
    <br/><br/>
    <table>
        <tr>
    <?php
        foreach($lstSortie as $uneSortie):
            $id = $uneSortie['IDJeux'];
            $nom = $uneSortie['Nom'];
            $img = "images/".$uneSortie['Image'];
            $date = dateFR($uneSortie['DateDeSortie']);
            $link = "jeux.php?id=$id";
            
    ?>
        
        <a href="<?php echo $link;?>"><td>
                <img src="<?php echo $img;?>" alt="miniature de <?php echo $nom;?>" class="miniature"/><br/>
                <span class="nomnew"><?php echo $nom;?></span><br/>
                <span class="sortienew"><?php echo $date;?></span>
            </td></a>
        
    <?php
        endforeach;
    ?>
        </tr>
    </table>
    <br/>
    <a href="a_venir.php" class="lienbasique">>>Voir toutes les sorties<<</a>
</article>

<?php
    include_once('foot.php');
?>