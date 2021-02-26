<?php

require_once("../modeles/bd.php") ;

if(empty($_POST["cat"]))
{
    die("veuillez saisir une categorie") ;
}

if(isset($_POST["saison"]) && isset($_POST["cat"]) && isset($_POST["type"]))
{
    if($_POST["saison"] == "été")
    {
        $saison = "ete" ;
    } else {
        $saison = $_POST["saison"] ;
    }

    $categorie = $_POST["cat"] ;
    $type = $_POST["type"] ;

    $categorie = addslashes($categorie) ;

    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;

    $reqVerifFamille = "SELECT * FROM famille WHERE categorie = '$categorie'" ;
    $resultVerifFamille = mysqli_query($co, $reqVerifFamille) or die(mysqli_error($co)) ;
    if(mysqli_num_rows($resultVerifFamille) >= 1)
    {
        die("erreur vous avez deja saisi cette famille") ;
    } else {
        switch($saison)
        {
        case "ete" :
            // $ete = htmlspecialchars("été") ;
            $reqInsertFamille = "INSERT INTO famille(saison, categorie) VALUES('été', '$categorie')" ;
            mysqli_query($co, $reqInsertFamille) or die(mysqli_error($co)) ;
            $numfamille = mysqli_insert_id($co) ;
        break ;
        case "hiver" :
            $reqInsertFamille = "INSERT INTO famille(saison, categorie) VALUES('hiver', '$categorie')" ;
            mysqli_query($co, $reqInsertFamille) or die(mysqli_error($co)) ;
            $numfamille = mysqli_insert_id($co) ;
        break ;
        case "automne" :
            $reqInsertFamille = "INSERT INTO famille(saison, categorie) VALUES('automne', '$categorie')" ;
            mysqli_query($co, $reqInsertFamille) or die(mysqli_error($co)) ;
            $numfamille = mysqli_insert_id($co) ;
        break ;
        case "printemps" :
            $reqInsertFamille = "INSERT INTO famille(saison, categorie) VALUES('printemps', '$categorie')" ;
            mysqli_query($co, $reqInsertFamille) or die(mysqli_error($co)) ;
            $numfamille = mysqli_insert_id($co) ;
        break ;
        case "toutes" :
            $reqInsertFamille = "INSERT INTO famille(saison, categorie) VALUES('toutes', '$categorie')" ;
            mysqli_query($co, $reqInsertFamille) or die(mysqli_error($co)) ;
            $numfamille = mysqli_insert_id($co) ;
        break ;
        case "nulle" :
            die("erreur veuillez selectionner une saison") ;
        break ;
    }

    switch($type)
    {
        case "Fruit" :
            $reqInsertCompoFamille = "INSERT INTO compofamille(numTypeProduit, numFamille) VALUES(1, '$numfamille')" ;
            mysqli_query($co, $reqInsertCompoFamille) or die(mysqli_error($co)) ;
            header("Location: ../vues/ajouterproduit.html") ; // Creer une page listeArticle dans les vues
        break ;
        case "Legume" :
            $reqInsertCompoFamille = "INSERT INTO compofamille(numTypeProduit, numFamille) VALUES(2, '$numfamille')" ;
            mysqli_query($co, $reqInsertCompoFamille) or die(mysqli_error($co)) ;
            header("Location: ../vues/ajouterproduit.html") ;
        break ;
        case "cereale" :
            $reqInsertCompoFamille = "INSERT INTO compofamille(numTypeProduit, numFamille) VALUES(3, '$numfamille')" ;
            mysqli_query($co, $reqInsertCompoFamille) or die(mysqli_error($co)) ;
            header("Location: ../vues/ajouterproduit.html") ;
        break ;
        case "plante" :
            $reqInsertCompoFamille = "INSERT INTO compofamille(numTypeProduit, numFamille) VALUES(4, '$numfamille')" ;
            mysqli_query($co, $reqInsertCompoFamille) or die(mysqli_error($co)) ;
            header("Location: ../vues/ajouterproduit.html") ;
        break ;
        case "autre" :
            $reqInsertCompoFamille = "INSERT INTO compofamille(numTypeProduit, numFamille) VALUES(5, '$numfamille')" ;
            mysqli_query($co, $reqInsertCompoFamille) or die(mysqli_error($co)) ;
            header("Location: ../vues/ajouterproduit.html") ;
        break ;
        case "nulle" :
            die("erreur veuillez selectionner un type de produit") ;
    }
    }
} else {
    die("impossible dajouter cette famille dans la BD") ;
}
?>