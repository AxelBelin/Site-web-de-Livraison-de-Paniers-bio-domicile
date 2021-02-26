<?php
session_start() ;

require_once("../modeles/bd.php") ;
require_once("../modeles/panier.php") ;
require_once("../modeles/producteur.php") ;

if(empty($_POST["approvisionnerPanier"]))
{
    die("veuillez saisir une quantité à ajouter en stock pour ce panier") ;
}

if(isset($_POST["approvisionnerPanier"]) && isset($_POST["prodId"]))
{
    
    $qte = $_POST["approvisionnerPanier"] ;
    $numPanier = $_POST["prodId"] ;

    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;
    
    $reqVerifStock = "SELECT * FROM panier WHERE numPanier = '$numPanier'" ;
    $resultVerifStock = mysqli_query($co, $reqVerifStock) or die(mysqli_error($co)) ;
      
    if(mysqli_num_rows($resultVerifStock) >= 1)
    {
        foreach($resultVerifStock as $panier)
        {
            $nom = $panier['nomPanier'] ;
            $nbProduit = $panier['nbProduit'] ;
            $saison = $panier['saison'] ;
            $poids = $panier['poids'] ;
            $prixpanier = $panier['prixpanier'] ;
        }

        $panier = new Panier($co, $numPanier, $nbProduit) ;
        $panier->approvisionnerPanier($numPanier, $qte) ;

        header("Location: ../vues/gererStock.php") ;
    } else {
        die("erreur panier inexistant") ;
    }
} else {
    die("impossible d'approvisionner le stock de ce panier") ;
}
?>