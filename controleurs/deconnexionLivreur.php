<?php

session_start();

require_once("../modeles/bd.php");
require_once("../modeles/livreur.php");

if(isset($_SESSION["idCompteLivreur"]) && isset($_SESSION["mailLivreur"]) && isset($_SESSION["mdpLivreur"]))
{
    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;    

    $numLivreur = $_SESSION["numLivreur"] ;
    $id = $_SESSION["idCompteLivreur"] ;
    $mail = $_SESSION["mailLivreur"] ;
    $mdp = $_SESSION["mdpLivreur"] ;

    $livreur = new Livreur($co, $id, $mail, $mdp) ;
    $livreur->deconnexionLivreur() ;
    session_destroy() ;
header('Location:../vues/accueil.html') ;
} else {
    // die("impossible de vous déconnecter") ;
    header('Location:../vues/accueil.html') ;
}
?>