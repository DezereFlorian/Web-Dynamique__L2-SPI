<?php
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;">
<?php
include('connexion2.php');

function set_commande($date, $heure, $id, $nbmois){ //ajoute la commande à la bdd
    global $bdd;
    $req = $bdd -> prepare("INSERT INTO commande VALUES(NULL, '$date',DATE_ADD(DateCommande, INTERVAL $nbmois MONTH), '$heure', '$id', '$nbmois')");
    $req -> execute();
    $req2 = $bdd -> prepare("SELECT IDCommande from commande order by IDCommande desc limit 1");
    $req2 -> execute();
    $get_commande = $req2 -> fetchColumn();
    return $get_commande;
}

function set_commandefinale($idCommande, $idjeu){ //ajoute les jeux de la commande à la bdd
    global $bdd;
    $req = $bdd -> prepare("INSERT INTO commandefinale VALUES(NULL, '$idCommande', '$idjeu')");
    $req -> execute();
    $req2 = $bdd -> prepare("SELECT Count(*) from commandefinale where IDCommande = '$idCommande'");
    $req2 -> execute();
    $get_nbjeuxcommande = $req2 -> fetchColumn();
    return $get_nbjeuxcommande;
}
// récupération des données envoyées par AJAX
$nbmois = (isset($_POST["nbmois"])) ? addslashes($_POST["nbmois"]) : NULL;
$date = (isset($_POST["date"])) ? addslashes($_POST["date"]) : NULL;
$heure = (isset($_POST["heure"])) ? addslashes($_POST["heure"]) : NULL;
$idclient = $_SESSION['id'];

$idcommande = set_commande($date, $heure, $idclient, $nbmois);
foreach($_SESSION['panier'] as $unJeu):
    $nbajout = set_commandefinale($idcommande, $unJeu);?>
<?php endforeach; 
$_SESSION['panier'] = array(); //vide le panier après avoir ajouté tous les jeux de la commande
?>
<script>
    alert('<?php echo $nbajout; ?> jeu(x) ajouté(s)');
    var adresse = 'panier.php'; 
    window.location = adresse;
</script>