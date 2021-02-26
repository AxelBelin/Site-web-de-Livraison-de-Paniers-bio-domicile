<?php

session_start();

require_once("../modeles/bd.php");
require_once("../modeles/producteur.php");

if(isset($_SESSION["idProducteur"]) && isset($_SESSION["mdpProducteur"]))
{
    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;    

$id = $_SESSION["idProducteur"] ;
$mdp = $_SESSION["mdpProducteur"] ;

$producteur = new Producteur($co, $id, $mdp) ;
$producteur->deconnexionPro() ;
session_destroy() ;
header('Location:../vues/accueil.html') ;
} else {
    // die("impossible de vous déconnecter") ;
    header('Location:../vues/accueil.html') ;
}

?>