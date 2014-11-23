<?php
session_start();
?>
<?php
include('connexion.php');

function contenu_commande($id){
    global $bdd;
    $req = $bdd -> prepare("SELECT * from jeux, commandefinale where jeux.IDJeux = commandefinale.IDJeux and IDCommande = '$id'");
    $req -> execute();
    $contenu_commande = $req -> fetchAll();
    return $contenu_commande;
}

$idcommande = $_POST["id"];

$lstJeux = contenu_commande($idcommande);
?>
    <p class='ajax'>
<?php foreach($lstJeux as $unJeu): 
    $idjeu = $unJeu['IDJeux'];
    $nomjeu = $unJeu['NomJeu'];
    
?>
    <a href='detail_jeu.php?id=<?php echo $idjeu; ?>' class='lienbasique'><?php echo $nomjeu; ?></a>
    <br/>
<?php endforeach; ?>
    </p>