<?php

require_once("../modeles/bd.php") ;
require_once("../modeles/panier.php") ;

if(empty($_POST["panier"]))
{
    die("veuillez saisir un nom pour ce panier") ;
}

if(empty($_POST["produit"]))
{
    die("veuillez indiquer le nombre de produits contenu dans ce panier") ;
}

if(empty($_POST["quantite"]))
{
    die("veuillez indiquer une quantité initiale en stock pour ce panier") ;
}

if(empty($_POST["prix"]))
{
    die("veuillez indiquer un prix unitaire HT pour ce panier") ;
}

if(isset($_POST["panier"]) && isset($_POST["produit"]) && isset($_POST["quantite"]) && isset($_POST["prix"]))
{
    if($_POST["prix"] > 0)
    {
        $prix = $_POST["prix"] ;
        $prix = strtr($prix, ",", ".") ;
    } else {
        die("erreur veuillez indiquer un prix unitaire en euros valide pour ce panier") ;
    }

    if($_POST["poids"] > 0)
    {
        $poids = $_POST["poids"] ;
        $poids = strtr($poids, ",", ".") ;
    } else {
        die("erreur veuillez indiquer un poids en KG valide pour ce panier") ;
    }

    $qte = $_POST["quantite"] ;
    $nbProduit = $_POST["produit"] ;
    $saison = $_POST["saison"] ;
    $nom = $_POST["panier"] ;
    $img = $_POST["img"] ;

    /* echo mb_detect_encoding($nom) ;
    echo mb_detect_encoding($img) ;
    // $convNom = iconv($nom) ;
    // $convImg = utf8_encode() */

    $nomConv = addslashes($nom) ;
    $nom = htmlspecialchars($nomConv) ;

    $imgConv = addslashes($img) ;
    $img = htmlspecialchars($imgConv) ;

    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;

    $reqVerifPanier = "SELECT * FROM panier WHERE nomPanier = '$nom' AND nbProduit = '$nbProduit' AND quantite = '$qte' AND prixpanier = '$prix'" ;
    $resultVerifPanier = mysqli_query($co, $reqVerifPanier) or die(mysqli_error($co)) ;
    if(mysqli_num_rows($resultVerifPanier) >= 1)
    {
        die("erreur vous avez deja ajouté ce panier dans la BD") ;
    } else {
            switch($saison)
            {
            case "été" :
                $panier = new Panier($co, $nom, $nbProduit, $qte, $prix) or die("erreur panier") ;
                // $saison = "ete" ;
                $panier->insertSaisonPanier($saison) ;
                if(!empty($poids))
                {
                    $panier->insertPoidsPanier($poids) ;
                }
    
                if(!empty($img))
                {
                    $panier->insertImgPanier($img) ;
                }
    
                header("Location: ../vues/composerPanier.php") ;
        break ;
        case "hiver" :
                $panier = new Panier($co, $nom, $nbProduit, $qte, $prix) or die("erreur panier") ;
                $saison = "hiver" ;
                $panier->insertSaisonPanier($saison) ;
                if(!empty($poids))
                {
                    $panier->insertPoidsPanier($poids) ;
                }
    
                if(!empty($img))
                {
                    $panier->insertImgPanier($img) ;
                }
    
                header("Location: ../vues/composerPanier.php") ;
        break ;
        case "automne" :
            $panier = new Panier($co, $nom, $nbProduit, $qte, $prix) or die("erreur panier") ;
            $saison = "automne" ;
            $panier->insertSaisonPanier($saison) ;
            if(!empty($poids))
            {
                $panier->insertPoidsPanier($poids) ;
            }

            if(!empty($img))
            {
                $panier->insertImgPanier($img) ;
            }

            header("Location: ../vues/composerPanier.php") ;
        break ;
        case "printemps" :
            $panier = new Panier($co, $nom, $nbProduit, $qte, $prix) or die("erreur panier") ;
            $saison = "printemps" ;
            $panier->insertSaisonPanier($saison) ;
            if(!empty($poids))
            {
                $panier->insertPoidsPanier($poids) ;
            }

            if(!empty($img))
            {
                $panier->insertImgPanier($img) ;
            }

            header("Location: ../vues/composerPanier.php") ;
        break ;
        case "toutes" :
            $panier = new Panier($co, $nom, $nbProduit, $qte, $prix) or die("erreur panier") ;
            $saison = "toutes" ;
            $panier->insertSaisonPanier($saison) ;
            if(!empty($poids))
            {
                $panier->insertPoidsPanier($poids) ;
            }

            if(!empty($img))
            {
                $panier->insertImgPanier($img) ;
            }

            header("Location: ../vues/composerPanier.php") ;
        break ;
        case "nulle" :
            $panier = new Panier($co, $nom, $nbProduit, $qte, $prix) or die("erreur panier") ;

            if(!empty($poids))
            {
                $panier->insertPoidsPanier($poids) ;
            }

            if(!empty($img))
            {
                $panier->insertImgPanier($img) ;
            }

            header("Location: ../vues/composerPanier.php") ;
    }
    }
} else {
    die("impossible dajouter ce panier dans la BD") ;
}

?>