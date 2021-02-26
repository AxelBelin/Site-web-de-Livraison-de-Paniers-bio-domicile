<?php
session_start() ;

require_once("../modeles/bd.php") ;
require_once("../modeles/produit.php") ;
require_once("../modeles/client.php") ;

if(empty($_POST["approvisionnerProduit"]))
{
    die("veuillez saisir une quantité de ce produit en KG à ajouter à votre commande") ;
}

if(isset($_POST["approvisionnerProduit"]) && isset($_POST["prodId"]) && isset($_POST["numCo"]))
{
    if($_POST["approvisionnerProduit"] > 0)
    {
        $qte = $_POST["approvisionnerProduit"] ;
        $qte = strtr($qte, ",", ".") ;
    } else {
        die("veuillez saisir une quantité de produit à ajouter valide en KG") ;
    }
    
    $numProduit = $_POST["prodId"] ;
    $numCommande = $_POST["numCo"] ;

    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;
    
    $reqVerifStock = "SELECT quantite FROM produit WHERE numProduit = '$numProduit' AND quantite > '$qte'" ;
    $resultVerifStock = mysqli_query($co, $reqVerifStock) or die(mysqli_error($co)) ;
      
    if(mysqli_num_rows($resultVerifStock) >= 1)
    {
        $reqMajQteCom = "UPDATE commandeproduit SET quantite = quantite + '$qte' WHERE numCommande = '$numCommande'" ;
        mysqli_query($co, $reqMajQteCom) or die(mysqli_error($co)) ;

        $reqRecupPanClient = "SELECT commandeproduit.quantite, produit.prixproduit FROM commande, commandeproduit, produit WHERE commandeproduit.numCommande = commande.numCommande AND produit.numProduit = commandeproduit.numProduit AND commande.numCommande = '$numCommande'" ;
        $resultRecupPanClient = mysqli_query($co, $reqRecupPanClient) or die(mysqli_error($co)) ;
        
        if(mysqli_num_rows($resultRecupPanClient) >= 1)
        {
          foreach($resultRecupPanClient as $pro)
          {
              $qteTot = $pro['quantite'] ;
              $prixTot = $pro['prixproduit'] ;
          }

          $nvPrixtotanet = $qteTot * $prixTot *1.2 ;

          $reqMajPrixTot = "UPDATE commande SET prixtotalnet = '$nvPrixtotanet' WHERE numCommande = '$numCommande'" ;
          mysqli_query($co, $reqMajPrixTot) or die(mysqli_error($co)) ;

        header("Location: ../vues/recapCommande.php") ;
        } else {
            die("erreur impossible de Mettre à jour le prix total net") ;
        }
    } else {
        die("quantité insuffisante de ce produit en stock veuillez diminuer votre quantité") ;
    }
} else {
    die("impossible d'ajouter des produits à votre commande") ;
}
?>