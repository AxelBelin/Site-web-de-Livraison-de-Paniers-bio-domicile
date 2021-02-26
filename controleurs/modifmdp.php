<?php
session_start() ; // Dans un premier temps : Démarrage d'une session pour éviter les bugs et récupérer les variables de session initialisées à la connection
require_once("../modeles/bd.php") ; // require_once permet d'arrêter le script en cas d'erreur avec la claasse BD
require_once("../modeles/membre.php") ; // require_once permet d'arrêter le script en cas d'erreur avec la classe Membre

if(isset($_POST['modif']) && isset($_SESSION['pseudo']) && isset($_POST['NVmdp'])) // Verifier si l'utilisateur a bien cliqué sur le bouton mofifier son mdp + a bien saisi son nv mdp + si les variables de session sont set
    {
        $nvMdp = $_POST["NVmdp"] ;

        if(empty($nvMdp)) {
            die("erreur, veuillez saisir un nouveau mot de passe valide") ;
        }
        
        $coModif = new BD("espace_membres") ; // Créer un nouvel onjet pour se connecter à la BD
        $co = $coModif->connexion() ; // Connection à la BD pour faire les requetes
        $user = $_SESSION['pseudo'] ; // Copie de la variable de session qui contient le pseudo
        $reqModif = "SELECT mdpasse FROM membres WHERE pseudo = '$user'" ; // Requete pour récupérer le mdp du membre connecté sur le site web
        $resultModif = mysqli_query($co, $reqModif) or die(mysqli_error($co)) ;

        // foreach($resultModif as $unMembre)
        while($row = mysqli_fetch_assoc($resultModif)) // Parcours de toutes les lignes retournées par la requete
        {
            $passwd = $row['mdpasse'] ; // Pour chaque ligne retournée : récupération du mdp
            $membreModif = new Membre($co, $user, $passwd) ; // Création d'un nouvel objet membre pour modifier son mdp
            $membreModif->modif_mdepasse($nvMdp) ; // Appel de la méthode de la classe Membre pour modifier le mdp du membre appelant : elle prend le nv mdp en paramètres
        }
        // header("Location: ../vues/formulaire_inscription.php") ;
        echo "<h3>Votre mot de passe a bien été modifié <a href='../vues/espace_membre.php'> Retour à votre espace membre</a></h3>" ;
    } else { // Affichage d'un message de confirmation. Sinon erreur et on exit le script.
        die("erreur, impossible de modifier votre mot de passe") ;
    }
?>