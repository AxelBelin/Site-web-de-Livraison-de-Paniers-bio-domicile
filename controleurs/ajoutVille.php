<?php

require_once("../modeles/bd.php") ;

if(empty($_POST["nom"]))
{
    die("veuillez saisir le nom de la ville que vous souhaitez ajouter") ;
}

if(empty($_POST["cp"]))
{
    die("veuillez saisir le code postal de la ville à ajouter") ;
}

if(isset($_POST["nom"]) && isset($_POST["cp"]))
{
    $nom = $_POST["nom"] ;
    $cp = $_POST["cp"] ;

    $nomConv = addslashes($nom) ;
    $nom = htmlspecialchars($nomConv) ;

    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;

    $reqVerifVille = "SELECT * FROM ville WHERE nomville = '$nom' AND CP = '$cp'" ;
    $resultVerifVille = mysqli_query($co, $reqVerifVille) or die(mysqli_error($co)) ;
    if(mysqli_num_rows($resultVerifVille) >= 1)
    {
        die("erreur vous avez deja saisi cette ville") ;
    } else {
        $reqInsertVille = "INSERT INTO ville(nomville, CP) VALUES('$nom', '$cp')" ;
        mysqli_query($co, $reqInsertVille) or die(mysqli_error($co)) ;
        header("Location: ../vues/ajouterQuartier.php") ;
    }
} else {
    die("erreur impossible d'ajouter cette ville dans la BD") ;
}

?>