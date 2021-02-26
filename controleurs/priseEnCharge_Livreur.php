<?php
session_start() ;

require_once("../modeles/bd.php") ;
require_once("../modeles/panier.php") ;

if(isset($_POST["prodDetailId"]))
{
    $numCommande = $_POST["prodDetailId"] ;

    // echo $numCommande ;

    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;
    
    $reqMajEtat = "UPDATE commande SET etatCommande = 'Livraison' WHERE numCommande = '$numCommande'" ;
    mysqli_query($co, $reqMajEtat) or die(mysqli_error($co)) ;

    header("Location: ../vues/consulterCommande_Livreur.php") ;

} else {
    die("erreur impossible de prendre en charge la livraison de cette commande") ;
    } 
?>