<?php

require_once("../modeles/bd.php") ;

if(empty($_POST["nomQuartier"]))
{
    die("veuillez saisir le nom du quartier que vous souhaitez ajouter") ;
}

if(isset($_POST["nomVille"]) && isset($_POST["nomQuartier"]) && isset($_POST["lien"]))
{
    $nomVille = $_POST["nomVille"] ;
    $nomQuartier = $_POST["nomQuartier"] ;
    $lien = $_POST["lien"] ;

    $nomVilleConv = addslashes($nomVille) ;
    $nomVille = htmlspecialchars($nomVilleConv) ;

    $nomQuartierConv = addslashes($nomQuartier) ;
    $nomQuartier = htmlspecialchars($nomQuartierConv) ;

    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;

    switch($nomVille)
    {
        case "nulle" :
            die("veuillez sélectionner la ville dans laquelle ajouter le quartier") ;
        break ;
        default :
        if(!empty($lien))
        {
            $reqInsertQuartier = "INSERT INTO quartier(nomCartier, lienMaps, numVille) VALUES('$nomQuartier', '$lien', '$nomVille')" ;
            mysqli_query($co, $reqInsertQuartier) or die(mysqli_error($co)) ;
            header("Location: ../vues/ajouterQuartier.php") ;
        } else {
            $reqInsertQuartier = "INSERT INTO quartier(nomCartier, numVille) VALUES('$nomQuartier', '$nomVille')" ;
            mysqli_query($co, $reqInsertQuartier) or die(mysqli_error($co)) ;
            header("Location: ../vues/ajouterQuartier.php") ;
        }
    }
} else {
    die("erreur impossible d'ajouter ce quartier dans la BD") ;
}

?>