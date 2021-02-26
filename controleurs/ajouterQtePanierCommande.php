<?php
session_start() ;

require_once("../modeles/bd.php") ;
require_once("../modeles/panier.php") ;
require_once("../modeles/client.php") ;

if(empty($_POST["approvisionnerPanier"]))
{
    die("veuillez saisir une quantité de ce panier à ajouter à votre commande") ;
}

if(isset($_POST["approvisionnerPanier"]) && isset($_POST["prodId"]) && isset($_POST["numCo"]))
{
    
    $qte = $_POST["approvisionnerPanier"] ;
    $numPanier = $_POST["prodId"] ;
    $numCommande = $_POST["numCo"] ;

    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;
    
    $reqVerifStock = "SELECT quantite FROM panier WHERE numPanier = '$numPanier' AND quantite > '$qte'" ;
    $resultVerifStock = mysqli_query($co, $reqVerifStock) or die(mysqli_error($co)) ;
      
    if(mysqli_num_rows($resultVerifStock) >= 1)
    {
        $reqMajQteCom = "UPDATE commandepanier SET quantite = quantite + '$qte' WHERE numCommande = '$numCommande'" ;
        mysqli_query($co, $reqMajQteCom) or die(mysqli_error($co)) ;

        $reqRecupPanClient = "SELECT commandepanier.quantite, panier.prixpanier FROM commande, commandepanier, panier WHERE commandepanier.numCommande = commande.numCommande AND panier.numPanier = commandepanier.numPanier AND commande.numCommande = '$numCommande'" ;
        $resultRecupPanClient = mysqli_query($co, $reqRecupPanClient) or die(mysqli_error($co)) ;
        
        if(mysqli_num_rows($resultRecupPanClient) >= 1)
        {
          foreach($resultRecupPanClient as $pan)
          {
              $qteTot = $pan['quantite'] ;
              $prixTot = $pan['prixpanier'] ;
          }

          $nvPrixtotanet = $qteTot * $prixTot *1.2 ;

          $reqMajPrixTot = "UPDATE commande SET prixtotalnet = '$nvPrixtotanet' WHERE numCommande = '$numCommande'" ;
          mysqli_query($co, $reqMajPrixTot) or die(mysqli_error($co)) ;

        header("Location: ../vues/recapCommande.php") ;
        } else {
            die("erreur impossible de Mettre à jour le prix total net") ;
        }
    } else {
        die("quantité insuffisante de ce panier en stock veuillez diminuer votre quantité") ;
    }
} else {
    die("impossible d'ajouter des paniers à votre commande") ;
}
?>