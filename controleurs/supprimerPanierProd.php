<?php

require_once("../modeles/bd.php") ;
require_once("../modeles/panier.php") ;

if(isset($_POST["nomPanier"]) && isset($_POST["nomProduit"]))
{
    $nomPanier = $_POST["nomPanier"] ;
    $nomProduit = $_POST["nomProduit"] ;

    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;

    switch($nomPanier)
    {
        case "nulle" :
            die("veuillez sélectionner le nom du panier") ;
        break ;
        default :
        $reqRecupNbProd = "SELECT nbProduit FROM panier WHERE numPanier = '$nomPanier'" ;
        $resultrecupNbprod = mysqli_query($co, $reqRecupNbProd) or die(mysqli_error($co)) ;

        foreach($resultrecupNbprod as $nbProd)
        {
            $nbprodPan = $nbProd['nbProduit'] ;
        }

        $panier = new Panier($co, $nomPanier, $nbprodPan) or die("erreur panier") ;
    }

    switch($nomProduit)
    {
        case "nulle" :
            die("veuillez sélectionner le nom du produit à supprimer") ;
        break ;
        default :
        $reqVerifQte = "SELECT * FROM compopanier WHERE numPanier = '$nomPanier' AND numProduit = '$nomProduit'" ;
        $resultVerfiQte = mysqli_query($co, $reqVerifQte) or die(mysqli_error($co)) ;
        if(mysqli_num_rows($resultVerfiQte) >= 1)
        {
            $panier->retirerContenuPanier($nomProduit) ;
            header("Location: ../vues/composerPanier.php") ;
        } else {
            die("erreur ce produit n'est pas dans ce panier. Veuillez choisir un produit valide") ;
        }
    }
} else {
    die("erreur impossible de supprimer ce produit du panier") ;
}
?>