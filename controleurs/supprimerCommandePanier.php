<?php
require_once("../modeles/bd.php") ;
require_once("../modeles/panier.php") ;

$cobd = new BD("projettutore") ;
$co = $cobd->connexion() ;

  $numCommande = $_GET["numCommande"] ;

    $reqSupprimerCli = "UPDATE client SET numCommande = NULL WHERE numCommande = '$numCommande'" ;
    $reqResultSupprimerCli = mysqli_query($co, $reqSupprimerCli) or die(mysqli_error($co)) ;

    $reqSupcommandepanier = "DELETE FROM commandepanier WHERE numCommande = '$numCommande'" ;
    $reqResultSupCP = mysqli_query($co, $reqSupcommandepanier) or die(mysqli_error($co)) ;

    $reqSupprimerCom = "DELETE FROM commande WHERE numCommande = '$numCommande'" ;
    $reqResultSupprimerCom = mysqli_query($co, $reqSupprimerCom) or die(mysqli_error($co)) ;

    header("Location: ../vues/recapCommande.php") ;
?>