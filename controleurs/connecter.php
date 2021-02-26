<?php
session_start();
require_once("../modeles/bd.php") ;
require_once("../modeles/compte.php") ;
require_once("../modeles/client.php") ;
require_once("../modeles/livreur.php") ;

if(empty($_POST["id"]))
{
	die("veuillez saisir votre identifiant") ;
}

if(empty($_POST["mail"]))
{
	die("veuillez saisir votre adresse mail") ;
}

if(empty($_POST["mdp"]))
{
	die("veuillez saisir votre mot de passe") ;
}

if (isset($_POST["profil"]) && isset($_POST["id"]) && isset($_POST["mail"]) && isset($_POST["mdp"]))
{
	$profil = $_POST["profil"] ;
	$id = $_POST["id"] ;
	$mail = $_POST["mail"] ;
	$mdp = $_POST["mdp"] ;

	$mail = htmlspecialchars($mail) ;
	$mdp = htmlspecialchars($mdp) ;
	
	$hashMdp = md5($mdp) ;
	
	$cobd = new BD("projettutore") ;
	$co = $cobd->connexion() or die(mysqli_error($co)) ;

	switch($profil) 
		{
		case "Client":
			$reqVerifCompteClient = "SELECT compte.numCompte, compte.profil, compte.indentifiant, compte.motdepasse, numClient, mail FROM compte, client WHERE client.numCompte = compte.numCompte AND compte.profil = 'Client' AND indentifiant = '$id' AND mail = '$mail' AND motdepasse = '$hashMdp'" ;
    		$resultVerifCompteClient = mysqli_query($co, $reqVerifCompteClient) or die(mysqli_error($co)) ;
			if(mysqli_num_rows($resultVerifCompteClient) == 1)
			{
				$client = new Client($co, $id, $mail, $mdp) ;
				$client->connexionClient() ;
				header("Location: ../vues/consulterPaniers_Client.php") ;
			} else {
				die("identifiant ou mot de passe incorrect pour ce compte client") ;
			}
		break ;
		case "Livreur":
			$reqVerifCompteLivreur = "SELECT compte.numCompte, compte.profil, compte.indentifiant, compte.motdepasse, numLivreur, mailLivreur FROM compte, livreur WHERE livreur.numCompte = compte.numCompte AND compte.profil = 'Livreur' AND indentifiant = '$id' AND mailLivreur = '$mail' AND motdepasse = '$hashMdp'" ;
    		$resultVerifCompteLivreur = mysqli_query($co, $reqVerifCompteLivreur) or die(mysqli_error($co)) ;
			if(mysqli_num_rows($resultVerifCompteLivreur) == 1)
			{
				$livreur = new Livreur($co, $id, $mail, $mdp) ;
				$livreur->connexionLivreur() ;
				header("Location: ../vues/consulterCommande_Livreur.php") ;
			} else {
				die("identifiant ou mot de passe incorrect pour ce compte livreur") ;
			}
		break;
		case "nulle":
			die("veuillez sélectionner votre profil") ;
		break ;
		}
	}
?>