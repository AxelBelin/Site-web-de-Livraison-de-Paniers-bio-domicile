<?php

require_once("../modeles/bd.php") ;
require_once("../modeles/panier.php") ;

if(empty($_POST["qteProduit"]))
{
    die("veuillez saisir une quantité à ajouter pour ce produit en KG") ;
}

if(isset($_POST["nomPanier"]) && isset($_POST["nomProduit"]) && isset($_POST["qteProduit"]))
{
    if($_POST["qteProduit"] > 0)
    {
        $qte = $_POST["qteProduit"] ;
        $qte = strtr($qte, ",", ".") ;
    } else {
        die("veuillez saisir une quantité à ajouter en KG valide") ;
    }

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
            die("veuillez sélectionner le nom du produit a ajouter") ;
        break ;
        default :
        $reqRecupQteProd = "SELECT quantite FROM produit WHERE numProduit = '$nomProduit'" ;
        $resultRecupQteProd = mysqli_query($co, $reqRecupQteProd) or die(mysqli_error($co)) ;

        foreach($resultRecupQteProd as $qtePro)
        {
            $qteProd = $qtePro['quantite'] ;
        }

        if($qte <= $qteProd)
        {
            $panier->ajouterContenuPanier($nomProduit, $qte) ;
            header("Location: ../vues/composerPanier.php") ;
        } else {
            die("erreur quantité insuffisante en stock pour ce produit. Veuillez approvisionner votre stock") ;
        }
    }
} else {
    die("erreur impossible d'ajouter ce produit au panier") ;
}
?>