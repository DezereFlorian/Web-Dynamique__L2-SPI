<?php
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;">
<?php
include('connexion2.php');
//include('creationMail.php');
function get_verif($pseudo,$mdp){ //vérifie que le pseudo et le mot de passe donnés lors de la connexion correspondent à un couple pseudo/mdp de la base
    global $bdd;
    $req = $bdd -> prepare("SELECT * from client where Pseudo = '".$pseudo."' and Mdp = '".$mdp."'");
    $req -> execute();
    $get_verif = $req -> fetch();
    return $get_verif;
}
function get_verify($pseudo,$mail){ //vérifie lors de l'inscription que le pseudo et le mail n'ont pas déjà été utilisés
    global $bdd;
    $req = $bdd -> prepare("SELECT * from client where Pseudo = '".$pseudo."'");
    $req -> execute();
    $get_verif = $req -> fetch();
    $ok = 0;
    if(isset($get_verif['IDClient'])):
        $ok = 1;
        return $ok;
    endif;
    $req2 = $bdd -> prepare("SELECT * from client where AdresseMail = '".$mail."'");
    $req2 -> execute();
    $get_verif2 = $req2 -> fetch();
    if(isset($get_verif2['IDClient'])):
        $ok = 2;
        return $ok;
    endif;
}
function set_membre($mail, $pseudo, $mdp, $code, $nom, $prenom, $adresse){ // insère un nouveau client avec toutes ses coordonnées
    global $bdd;
    $req = $bdd -> prepare("INSERT INTO client VALUES(NULL,'$nom', '$prenom', '$mail', '$pseudo','$mdp','$adresse','$code',0)");
    $req -> execute();
    $req2 = $bdd -> prepare("SELECT * from client where Pseudo = '$pseudo' and AdresseMail = '$mail'");
    $req2 -> execute();
    $verify = $req2 -> fetch();
    if($verify['Mdp']==$mdp):
        return $verify['IDClient'];
    else:
        return false;
    endif;
}

if ($_POST['status']==1): //cas de connexion
    $pseudo = (isset($_POST["pseudo"])) ? addslashes($_POST["pseudo"]) : NULL;
    $mdp = (isset($_POST["mdp"])) ? addslashes($_POST["mdp"]) : NULL;

    if (!empty($pseudo) && !empty($mdp)): //si le pseudo et le mdp ne sont pas vides
            $verif = get_verif($pseudo,$mdp);
            if (!empty($verif['IDClient'])): //vérifie qu'il existe bien le couple pseudo/mdp dans la base par l'existence d'un ID
                $_SESSION['pseudo'] = $verif['Pseudo'];
                $_SESSION['id'] = $verif['IDClient'];
                $_SESSION['panier'] = array(); //initialisation du panier
                if($verif['ClientActif']==0): //adresse mail activée ou non
                    $_SESSION['actif'] = 0;
                else:
                    $_SESSION['actif'] = 1;
                endif;?>
                <script>
                    alert('Vous \u00eates connect\u00e9'); 
                    var adresse = 'index.php'; 
                    window.location = adresse;
                </script>";
            <?php else: ?> <!-- si le couple pseudo/mdp n'existe pas dans la base -->
                <script>
                    alert('Vous n\'avez pas saisi les bons identifiants');
                </script>
            <?php endif;
    endif;
else:
    if($_POST['status']==2): //dans le cas d'une inscription
        //vérification que tous les champions soient bien remplis et les affecte à des variables pour une réutilisation plus facile
        $mail = (isset($_POST['mail'])) ? addslashes($_POST['mail']) : NULL;
        $pseudo = (isset($_POST["pseudo"])) ? addslashes($_POST["pseudo"]) : NULL;
        $mdp = (isset($_POST["mdp"])) ? addslashes($_POST["mdp"]) : NULL;
        $nom = (isset($_POST["nom"])) ? addslashes($_POST["nom"]) : NULL;
        $prenom = (isset($_POST["prenom"])) ? addslashes($_POST["prenom"]) : NULL;
        $adresse = (isset($_POST["adresse"])) ? addslashes($_POST["adresse"]) : NULL;
        $test = get_verify($pseudo,$mail); //teste du pseudo et mail existant
        if($test==2): //si mail existe déjà ?>
            <script>
                alert('L\'adresse mail est déjà utilis\u00e9e');
            </script>
        <?php elseif($test==1): //si pseudo existe déjà ?>
            <script>
                alert('Le pseudo est d\u00e9j\u00e0 utilis\u00e9</p>');
            </script>
        <?php else:
            $codeActivation = ''; //préparation du code d'activation
            for($i=1;$i<=10;$i++):
                $codeActivation = $codeActivation.rand(0,9);
            endfor;
            $set = set_membre($mail, $pseudo, $mdp, $codeActivation, $nom, $prenom, $adresse);
            //confirmMail($mail,$pseudo,$codeActivation);
            if($set!=false): //si l'ajout dans la base a bien marché, client identifié.
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['id'] = $set;
                $_SESSION['actif'] = 0;?>
            <script>
                alert('Vous \u00eates inscrit(e)'); 
                alert('Vous venez de recevoir un mail d\'activation de votre compte, veuillez cliquer sur le lien qui vous est fourni pour activer votre compte et pouvoir passer des commandes');
            </script>
            <?php else: ?>
                <script>
                    alert('Une erreur s\'est produite');
                </script>
            <?php endif;
        endif;
    endif;
endif;
?>