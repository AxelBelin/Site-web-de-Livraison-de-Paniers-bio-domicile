<?php
session_start() ;

require_once("../modeles/bd.php") ;
require_once("../modeles/produit.php") ;
require_once("../modeles/producteur.php") ;

if(empty($_POST["approvisionnerProduit"]))
{
    die("veuillez saisir une quantité en KG à ajouter en stock pour ce produit") ;
}

if(isset($_POST["approvisionnerProduit"]) && isset($_POST["produitId"]))
{
    if($_POST["approvisionnerProduit"] > 0)
    {
        $qte = $_POST["approvisionnerProduit"] ;
        $qte = strtr($qte, ",", ".") ;
    } else {
        die("veuillez saisir une quantité à ajouter en KG valide pour ce produit") ;
    }
    
    $numProduit = $_POST["produitId"] ;

    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;
    
    $reqVerifStock = "SELECT * FROM produit WHERE numProduit = '$numProduit'" ;
    $resultVerifStock = mysqli_query($co, $reqVerifStock) or die(mysqli_error($co)) ;
      
    if(mysqli_num_rows($resultVerifStock) >= 1)
    {
        foreach($resultVerifStock as $produit)
        {
            $nom = $produit['nomproduit'] ;
            $qtePan = $produit['quantite'] ;
        }

        $produit = new Produit($co, $numProduit, $nom, $qtePan) ;
        $produit->approvisionnerProduit($numProduit, $qte) ;

        header("Location: ../vues/gererStock.php") ;
    } else {
        die("erreur produit inexistant") ;
    }
} else {
    die("impossible d'approvisionner le stock de ce produit") ;
}
?>