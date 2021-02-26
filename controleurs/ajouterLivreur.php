<?php
session_start();
require_once("../modeles/bd.php") ;
require_once("../modeles/compte.php") ;
require_once("../modeles/livreur.php") ;

if(empty($_POST["nomLiv"]))
{
	die("veuillez saisir votre nom") ;
}

if(empty($_POST["prenomLiv"]))
{
	die("veuillez saisir votre prénom") ;
}

if(empty($_POST["telLiv"]))
{
	die("veuillez saisir votre numéro de téléphone") ;
}

if(empty($_POST["mailLiv"]))
{
	die("veuillez saisir votre adresse mail") ;
}

if (isset($_POST["nomLiv"]) && isset($_POST["prenomLiv"]) && isset($_POST["telLiv"]) && isset($_POST["mailLiv"]) && isset($_SESSION["numCompte"]))
{
	$nom = $_POST["nomLiv"] ;
	$prenom = $_POST["prenomLiv"] ;
	$tel = $_POST["telLiv"] ;
	$mail = $_POST["mailLiv"] ;
	$numCompte = $_SESSION["numCompte"] ;

	$nom = htmlspecialchars($nom) ;
	$prenom = htmlspecialchars($prenom) ;
	$tel = htmlspecialchars($tel) ;
	$mail = htmlspecialchars($mail) ;
	
	$cobd = new BD("projettutore") ;
	$co = $cobd->connexion() ;

	$reqVerifLivreur = "SELECT * FROM livreur WHERE numCompte = '$numCompte'" ;
    $resultVerifLivreur = mysqli_query($co, $reqVerifLivreur) or die(mysqli_error($co)) ;
	if(mysqli_num_rows($resultVerifLivreur) >= 1)
	{
		die("un livreur est déjà associé à ce compte") ;
	} else {
		if(empty($numCompte))
		{
			die("erreur de session") ;
		} else {
			$regexNom = '/^[a-zA-Z]{1,55}[a-zA-Z -]*$/' ;
			$regexPrenom = '/^[a-zA-Z]{1,40}[a-zA-Z -]*$/' ;
			$regexTel = '/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/' ;
			$regexMail = '/^[a-z]{2,}\@[a-z -]{3,}\.[a-z]{2,3}$/' ;

			if(preg_match($regexNom, $nom) && preg_match($regexPrenom, $prenom) && preg_match($regexTel, $tel) && preg_match($regexMail, $mail))
			{
					$livreur = new Livreur($co, $numCompte, $nom, $prenom, $tel, $mail) ;
					$livreur->connexionLivreur() ;
					header("Location: ../vues/connexion.html") ;
			} else {
				die("erreur : un ou plusieurs champs ont mal été saisis veuillez réessayer (surement le téléphone et le mail)") ;
			}
		}
	}
} else {
	die("erreur impossible de créer le compte livreur") ;
}

?>