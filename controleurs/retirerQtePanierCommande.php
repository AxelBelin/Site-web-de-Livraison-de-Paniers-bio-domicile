<?php
session_start() ;

require_once("../modeles/bd.php") ;
require_once("../modeles/panier.php") ;
require_once("../modeles/client.php") ;

if(empty($_POST["retirerPanier"]))
{
    die("veuillez saisir une quantité de ce panier à retirer de votre commande") ;
}

if(isset($_POST["retirerPanier"]) && isset($_POST["prodRetId"]) && isset($_POST["numCom"]))
{
    $qte = $_POST["retirerPanier"] ;
    $numPanier = $_POST["prodRetId"] ;
    $numCommande = $_POST["numCom"] ;

    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;
    
    $reqVerifStock = "SELECT quantite FROM panier WHERE numPanier = '$numPanier' AND quantite > '$qte'" ;
    $resultVerifStock = mysqli_query($co, $reqVerifStock) or die(mysqli_error($co)) ;
      
    if(mysqli_num_rows($resultVerifStock) >= 1)
    {
        $reqMajQteCom = "UPDATE commandepanier SET quantite = quantite - '$qte' WHERE numCommande = '$numCommande'" ;
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
        die("erreur quantité insufisante") ;
    }
} else {
    die("impossible de retirer des paniers à votre commande") ;
}
?>