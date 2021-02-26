<?php
session_start();
require_once("../modeles/bd.php") ;
require_once("../modeles/compte.php") ;
require_once("../modeles/client.php") ;

if(empty($_POST["choixGroupe"]))
{
	die("veuillez choisir si vous passez la commande seul ou groupée") ;
}

if(empty($_POST["choixHebdo"]))
{
	die("veuillez choisir si vous passez une commande ponctuelle ou hebdomadaire") ;
}

if(empty($_POST["prodId"]))
{
    die("erreur pas de numéro de commande") ;
}

if (isset($_POST["choixGroupe"]) && isset($_POST["choixHebdo"]) && isset($_SESSION["numClient"]))
{
	$isGroupee = $_POST["choixGroupe"] ;
    $isHebdo = $_POST["choixHebdo"] ;
    $jourhebdo = $_POST["selectJour"] ;
    $nbGroupe = $_POST["nbGroupe"] ;
    $numCommande = $_POST["prodId"] ;
	$numClient = $_SESSION["numClient"] ;
	
	$cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;

    switch($jourhebdo)
    {
        case "nulle":
            if($isHebdo == "ponctuelle")
            {
                if(!empty($nbGroupe))
                {
                    if($isGroupee == "groupee")
                    {
                        $reqMajCoGroupePonctuelle = "UPDATE commande SET commandegroupe = 1, hebdomadaire = 0, etatCommande = 'en préparation', datecommande = NOW() WHERE numCommande = '$numCommande'" ;
                        mysqli_query($co, $reqMajCoGroupePonctuelle) or die(mysqli_error($co)) ;

                        header("Location: ../vues/confirmationCommande.html") ;
                    } else {
                        die("Veuillez ne pas saisir un nombre de peronne d'un groupe si la commande n'est pas groupée") ;
                    }
                } else {
                    $reqMajCoSeulePonctuelle = "UPDATE commande SET commandegroupe = 0, hebdomadaire = 0, etatCommande = 'en préparation', datecommande = NOW() WHERE numCommande = '$numCommande'" ;
                    mysqli_query($co, $reqMajCoSeulePonctuelle) or die(mysqli_error($co)) ;

                    header("Location: ../vues/confirmationCommande.html") ;
                }
            } else {
                die("veuillez saisir un jour de livraison hebdomadaire si la commande est hebdomadaire") ;
            }
        break ;
        default:
        if($isHebdo == "hebdo")
        {
                if(!empty($nbGroupe))
                {
                    if($isGroupee == "groupee")
                    {
                        $reqMajCoGroupeHebdo = "UPDATE commande SET commandegroupe = 1, jourlivrasion = '$jourhebdo', hebdomadaire = 1, etatCommande = 'en préparation', datecommande = NOW() WHERE numCommande = '$numCommande'" ;
                        mysqli_query($co, $reqMajCoGroupeHebdo) or die(mysqli_error($co)) ;

                        header("Location: ../vues/confirmationCommande.html") ;
                    } else {
                        die("Veuillez ne pas saisir un nombre de peronne d'un groupe si la commande n'est pas groupée") ;
                    }
                } else {
                    $reqMajCoSeuleHebdo = "UPDATE commande SET commandegroupe = 0, jourlivrasion = '$jourhebdo', hebdomadaire = 1, etatCommande = 'en préparation', datecommande = NOW() WHERE numCommande = '$numCommande'" ;
                    mysqli_query($co, $reqMajCoSeuleHebdo) or die(mysqli_error($co)) ;

                    header("Location: ../vues/confirmationCommande.html") ;
                }
        } else {
            die("veuillez ne pas saisir de jour de livraison si la commande est ponctuelle") ;
        }
    }
} else {
    die("erreur impossible de valider la commande") ;
}
?>