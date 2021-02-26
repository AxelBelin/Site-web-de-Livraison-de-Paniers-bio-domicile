<?php

require_once("../modeles/bd.php") ;
require_once("../modeles/produit.php") ;

if(empty($_POST["nom"]))
{
    die("veuillez saisir un nom pour ce produit") ;
}

if(empty($_POST["quantite"]))
{
    die("veuillez indiquer une quanité initiale en stock pour ce produit") ;
}

if(empty($_POST["prix"]))
{
    die("veuillez saisir le prix au kilo de ce produit") ;
}

if(isset($_POST["nom"]) && isset($_POST["quantite"]) && isset($_POST["prix"]) && isset($_POST["type"]))
{
    if($_POST["quantite"] > 0)
    {
        $qte = $_POST["quantite"] ;
        $qte = strtr($qte, ",", ".") ;
    } else {
        die("erreur veuillez indiquer une quantité initiale valide pour ce produit") ;
    }

    if($_POST["prix"] > 0)
    {
        $prix = $_POST["prix"] ;
        $prix = strtr($prix, ",", ".") ;
    } else {
        die("erreur veuillez indiquer une prix au kilo en euros valide pour ce produit") ;
    }

    $nom = $_POST["nom"] ;
    $type = $_POST["type"] ;
    $categorie = $_POST["categorie"] ;
    $img = $_POST["img"] ;

    $nomConv = addslashes($nom) ;
    $nom = htmlspecialchars($nomConv) ;

    $imgConv = addslashes($img) ;
    $img = htmlspecialchars($imgConv) ;

    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;

    if(!empty($categorie))
    {
        $reqRecupNumTypeprod = "SELECT compofamille.numTypeProduit, compofamille.numFamille FROM compofamille, famille WHERE famille.numFamille = compofamille.numFamille AND famille.categorie = '$categorie'" ;
        $resultRecupNumType = mysqli_query($co, $reqRecupNumTypeprod) or die(mysqli_error($co)) ;
        foreach($resultRecupNumType as $numType)
        {
            $numTypePro = $numType["numTypeProduit"] ;
            $numfam = $numType["numFamille"] ;
        }
    }

    $reqVerifProduit = "SELECT * FROM produit WHERE nomproduit = '$nom'" ;
    $resultVerifProduit = mysqli_query($co, $reqVerifProduit) or die(mysqli_error($co)) ;
    if(mysqli_num_rows($resultVerifProduit) >= 1)
    {
        die("erreur vous avez deja ajouté ce produit dans la BD") ;
    } else {
        switch($type)
        {
        case "Fruit" :
            $produit = new Produit($co, $nom, $qte, $prix, 1) or die("erreur produit") ;

            if(!empty($categorie))
            {
                $reqMajCat = "UPDATE compofamille SET nomProduit = '$nom' WHERE numTypeProduit  = '$numTypePro' AND numFamille = '$numfam'" ; // A changer on peut ajouter un seul produit par famille
                mysqli_query($co, $reqMajCat) or die(mysqli_error($co)) ;
            }

            if(!empty($img))
            {
                $produit->insertImgProduit($img) ;
            }

            header("Location: ../vues/ajouterpanier.html") ; // Creer une page listeArticle.php dans les vues
        break ;
        case "Legume" :
            $produit = new Produit($co, $nom, $qte, $prix, 2) or die("erreur produit") ;
            if(!empty($categorie))
            {
                $reqMajCat = "UPDATE compofamille SET nomProduit = '$nom' WHERE numTypeProduit  = '$numTypePro' AND numFamille = '$numfam'" ;
                mysqli_query($co, $reqMajCat) or die(mysqli_error($co)) ;
            }

            if(!empty($img))
            {
                $produit->insertImgProduit($img) ;
            }

            header("Location: ../vues/ajouterpanier.html") ; // Creer une page listeArticle.php dans les vues
        break ;
        case "cereale" :
            $produit = new Produit($co, $nom, $qte, $prix, 3) or die("erreur produit") ;
            if(!empty($categorie))
            {
                $reqMajCat = "UPDATE compofamille SET nomProduit = '$nom' WHERE numTypeProduit  = '$numTypePro' AND numFamille = '$numfam'" ;
                mysqli_query($co, $reqMajCat) or die(mysqli_error($co)) ;
            }

            if(!empty($img))
            {
                $produit->insertImgProduit($img) ;
            }

            header("Location: ../vues/ajouterpanier.html") ; // Creer une page listeArticle.php dans les vues
        break ;
        case "plante" :
            $produit = new Produit($co, $nom, $qte, $prix, 4) or die("erreur produit") ;
            if(!empty($categorie))
            {
                $reqMajCat = "UPDATE compofamille SET nomProduit = '$nom' WHERE numTypeProduit  = '$numTypePro' AND numFamille = '$numfam'" ;
                mysqli_query($co, $reqMajCat) or die(mysqli_error($co)) ;
            }

            if(!empty($img))
            {
                $produit->insertImgProduit($img) ;
            }

            header("Location: ../vues/ajouterpanier.html") ; // Creer une page listeArticle.php dans les vues
        break ;
        case "autre" :
            $produit = new Produit($co, $nom, $qte, $prix, 5) or die("erreur produit") ;
            if(!empty($categorie))
            {
                $reqMajCat = "UPDATE compofamille SET nomProduit = '$nom' WHERE numTypeProduit  = '$numTypePro' AND numFamille = '$numfam'" ;
                mysqli_query($co, $reqMajCat) or die(mysqli_error($co)) ;
            }

            if(!empty($img))
            {
                $produit->insertImgProduit($img) ;
            }

            header("Location: ../vues/ajouterpanier.html") ; // Creer une page listeArticle.php dans les vues
        break ;
        case "nulle" :
            die("erreur veuillez selectionner un type de produit pour ce produit") ;
    }
    }
} else {
    die("impossible dajouter ce produit dans la BD") ;
}

?>