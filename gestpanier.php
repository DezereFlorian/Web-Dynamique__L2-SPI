<?php
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;">
<?php
include('connexion2.php');

$idjeu = $_POST["id"];


if (isset($_SESSION['id'])): //vérifie qu'il existe une connexion active
    if ($_POST['status']==1): //status est une variable aidant à définir si on veut ajouter (1) ou retirer (2) au panier
        if (sizeof($_SESSION['panier'])<3): //vérifie que le panier possède moins de 3 jeux
            if(in_array($idjeu, $_SESSION['panier'])==true)://vérifie que le jeu n'est pas déjà présent dans le panier
            ?>
                <script>
                    alert('Le jeu est déjà dans le panier');
                </script>
            <?php else:
                $_SESSION['panier'][] = $idjeu; ?> <!-- ajoute le jeu -->
                <script>
                    alert('Le jeu a bien été ajouté !');
                </script>";
            <?php endif;   
        else:?> <!-- dans le cas où le panier est déjà plein -->
        <script>
            if(confirm('Votre panier est plein, vous ne pouvez pas ajouter plus de 3 jeux à votre commande.\nAppuyez sur Ok pour \u00eatre redirig\u00e9 vers votre panier, Annuler pour rester sur cette page.'))
            {
                var adresse = 'panier.php'; 
                window.location = adresse; //redirection vers la page panier si l'utilisateur clique sur Ok
            }
        </script>
        <?php endif;
    else: //cas où on retire le jeu du panier
        $idjeuretire = array_search($idjeu, $_SESSION['panier']); //recherche l'emplacement du jeu dans le tableau
        unset($_SESSION['panier'][$idjeuretire]); // le retire du tableau
        $_SESSION['panier'] = array_values($_SESSION['panier']); //réajustement du tableau pour ne pas avoir de trou dans les clés 
        ?>
        <script>
            alert('Le jeu a bien été retiré !');
            var adresse = 'panier.php';
            window.location = adresse;
        </script>";
    <?php endif;
else: //cas où l'utilisateur n'est pas connecté
    ?>
<script>
    if(confirm('Vous n\'\u00eates pas connect\u00e9.\nAppuyez sur Ok pour \u00eatre redirig\u00e9 vers la page de connexion, Annuler pour rester sur cette page.'))
    {
        var adresse = 'seconnecter.php';
        window.location = adresse; //redirige l'utilisateur vers la page de connexion si il clique sur Ok
    } 
</script>";

<?php endif;

?>
