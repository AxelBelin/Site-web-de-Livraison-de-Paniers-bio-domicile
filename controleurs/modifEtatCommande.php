<?php
session_start() ;

require_once("../modeles/bd.php") ;
require_once("../modeles/panier.php") ;

if(isset($_POST["selectEtat"]) && isset($_POST["prodId"]))
{
    $etat = $_POST["selectEtat"] ;
    $numCommande = $_POST["prodId"] ;

    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;
    
    switch($etat)
    {
        case "nulle":
            die("veuillez sélectionner un etat à mettre à jour") ;
        break ;
        default:
        $reqMajEtat = "UPDATE commande SET etatCommande = '$etat' WHERE numCommande = '$numCommande'" ;
        mysqli_query($co, $reqMajEtat) or die(mysqli_error($co)) ;

        header("Location: ../vues/consulterCommande_Producteur.php") ;
    }

} else {
    die("erreur impossible de mettre à jour l'état de cette commande") ;
    } 
?>