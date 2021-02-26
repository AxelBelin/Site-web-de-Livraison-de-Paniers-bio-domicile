<?php
require_once("../modeles/bd.php") ;
require_once("../modeles/produit.php") ;

$cobd = new BD("projettutore") ;
$co = $cobd->connexion() ;

  $numPanier = $_GET["numProduit"] ;
  // echo $numPanier ;

    $reqSupprimerPan = "DELETE FROM produit WHERE numProduit = '$numProduit'" ;
    $reqResultSupprimerPan = mysqli_query($co, $reqSupprimerPan) or die(mysqli_error($co)) ;

    header("Location: ../vues/gererStock.php") ;
?>