<?php
session_start();
require_once("../modeles/bd.php") ;
require_once("../modeles/compte.php") ;
require_once("../modeles/client.php") ;

if(empty($_POST["nomCli"]))
{
	die("veuillez saisir votre nom") ;
}

if(empty($_POST["prenomCli"]))
{
	die("veuillez saisir votre prénom") ;
}

if(empty($_POST["mailCli"]))
{
	die("veuillez saisir votre adresse mail") ;
}

if(empty($_POST["adresse"]))
{
	die("veuillez saisir votre adresse de livraison") ;
}

if(empty($_POST["cp"]))
{
	die("veuillez saisir votre code Postal") ;
}

if(empty($_POST["telCli"]))
{
	die("veuillez saisir votre numéro de téléphone") ;
}

if (isset($_POST["nomCli"]) && isset($_POST["prenomCli"]) && isset($_POST["mailCli"]) && isset($_POST["adresse"]) && isset($_POST["cp"]) && isset($_POST["telCli"]) && isset($_POST["quartier"]) && isset($_SESSION["numCompte"]))
{
	$nom = $_POST["nomCli"] ;
	$prenom = $_POST["prenomCli"] ;
	$mail = $_POST["mailCli"] ;
	$adresse = $_POST["adresse"] ;
	$cp = $_POST["cp"] ;
	$tel = $_POST["telCli"] ;
	$quartier = $_POST["quartier"] ;
	$numCompte = $_SESSION["numCompte"] ;
	$limitePrix = $_POST["limitePrix"] ;
	$groupe = $_POST["groupe"] ;

	// var_dump($numCompte) ;

	$nom = htmlspecialchars($nom) ;
	$prenom = htmlspecialchars($prenom) ;
	$mail = htmlspecialchars($mail) ;
	$adresse = htmlspecialchars($adresse) ;
	$tel = htmlspecialchars($tel) ;
	
	$cobd = new BD("projettutore") ;
	$co = $cobd->connexion() ;

	$reqVerifClient = "SELECT * FROM client WHERE numCompte = '$numCompte'" ;
    $resultVerifClient = mysqli_query($co, $reqVerifClient) or die(mysqli_error($co)) ;
	if(mysqli_num_rows($resultVerifClient) >= 1)
	{
		die("un client est déjà associé à ce compte") ;
	} else {
		if(empty($numCompte))
		{
			die("erreur de session") ;
		} else {
			$regexNom = '/^[a-zA-Z]{1,55}[a-zA-Z -]*$/' ;
			$regexPrenom = '/^[a-zA-Z]{1,40}[a-zA-Z -]*$/' ;
			$regexTel = '/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/' ;
			$regexMail = '/^[a-z]{2,}\@[a-z -]{3,}\.[a-z]{2,3}$/' ;
			$regexAdresse = '/^[0-9]{1,4} [a-zA-Z]{3,10} [a-zA-Z -]{2,30}$/' ;

			if(preg_match($regexNom, $nom) && preg_match($regexPrenom, $prenom) && preg_match($regexTel, $tel) && preg_match($regexMail, $mail) && preg_match($regexAdresse, $adresse))
			{
				$idClient = $_SESSION['idCompte'] ;	
				$client = new Client($co, $idClient, $mail, $nom, $prenom, $adresse, $tel, $numCompte) ;
				
				$client->insertCoordonneesLivraison($cp, $quartier) ;

				if(!empty($limitePrix))
				{
					$client->insertBudget($limitePrix) ;
				}

				if(!empty($groupe))
				{
					$client->insertGroupe($groupe) ;
				}

				$client->connexionClient() ;
				header("Location: ../vues/connexion.html") ;
			} else {
				die("erreur : un ou plusieurs champs ont mal été saisis veuillez réessayer (surement le téléphone, le mail ou l'adresse...)") ;
			}
		}
	}
} else {
	die("erreur impossible de créer le compte client") ;
}

?>