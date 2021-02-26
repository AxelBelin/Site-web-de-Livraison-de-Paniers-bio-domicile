<?php
require_once("../modeles/bd.php") ;
require_once("../modeles/panier.php") ;

$cobd = new BD("projettutore") ;
$co = $cobd->connexion() ;

  $numPanier = $_GET["numPanier"] ;
  // echo $numPanier ;

    $reqSupprimerPan = "DELETE FROM panier WHERE numPanier = '$numPanier'" ;
    $reqResultSupprimerPan = mysqli_query($co, $reqSupprimerPan) or die(mysqli_error($co)) ;

    header("Location: ../vues/gererStock.php") ;
?>