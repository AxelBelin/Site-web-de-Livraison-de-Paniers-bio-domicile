<?php
// session_start();
require_once("../modeles/bd.php") ;
require_once("../modeles/compte.php") ;

if(empty($_POST["id"]))
{
	die("veuillez saisir un identifiant") ;
}

if(empty($_POST["testmdp"]))
{
	die("veuillez saisir un mot de passe une première fois") ;
}

if(empty($_POST["mdp"]))
{
	die("veuillez confirmer votre mot de passe") ;
}

if (isset($_POST["profil"]) && isset($_POST["id"]) && isset($_POST["testmdp"]) && isset($_POST["mdp"]))
{
	$profil = $_POST["profil"] ;
	$id = $_POST["id"] ;
	$testmdp = $_POST["testmdp"] ;
	$mdp = $_POST["mdp"] ;
	$cb = $_POST["cb"] ;

	$id = htmlspecialchars($id) ;
	$testmdp = htmlspecialchars($testmdp) ;
	$mdp = htmlspecialchars($mdp) ;
	$cb = htmlspecialchars($cb) ;
	
	$cobd = new BD("projettutore") ;
	$co = $cobd->connexion() ;

	$reqVerifCompte = "SELECT * FROM compte WHERE profil = '$profil' AND indentifiant = '$id'" ;
    $resultVerifCompte = mysqli_query($co, $reqVerifCompte) or die(mysqli_error($co)) ;
	if(mysqli_num_rows($resultVerifCompte) >= 1)
	{
		die("un compte existe déjà avec cet identifiant") ;
	} else {
		switch($profil) 
		{
		case "Client":
		if(!empty($cb))
		{
			if($testmdp == $mdp)
			{
				if(preg_match('/^[a-zA-Z]{6,12}[0-9]{1,10}$/', $mdp))
				{
					$compte = new Compte($co, "Client", $id, $mdp, $cb) ;
					$compte->connexionCompte() ;
					header("Location: ../vues/creerCompteClient.html") ;
				} else {
					die("erreur mdp : doit contenir 6 à 12 caractères majuscules et/ou minuscules suivis d'au moins 1 chiffre") ;
				}
			} else {
				die("les deux mots de passe saisis doivent être identiques") ;
			}
		} else {
			if($testmdp == $mdp)
			{
				if(preg_match('/^[a-zA-Z]{6,12}[0-9]{1,10}$/', $mdp))
				{
					$compte = new Compte($co, "Client", $id, $mdp) ;
					$compte->connexionCompte() ;
					header("Location: ../vues/creerCompteClient.php") ;
				} else {
					die("erreur mdp : doit contenir 6 à 12 caractères majuscules et/ou minuscules suivis d'au moins 1 chiffre") ;
				}
			} else {
				die("les deux mots de passe saisis doivent être identiques") ;
			}
		}
	break ;
	case "Livreur":
		if(!empty($cb))
		{
			die("un livreur ne doit pas renseigner son numéro de CB") ;
		} else {
			if($testmdp == $mdp)
			{
				if(preg_match('/^[a-zA-Z]{6,12}[0-9]{1,10}$/', $mdp))
				{
					$compte = new Compte($co, "Livreur", $id, $mdp) ;
					$compte->connexionCompte() ;
					header("Location: ../vues/creerCompteLivreur.html") ;
				} else {
					die("erreur mdp : doit contenir 6 à 12 caractères majuscules et/ou minuscules suivis d'au moins 1 chiffre") ;
				}
			} else {
				die("les deux mots de passe saisis doivent être identiques") ;
			}
		}
	break;
	case "nulle":
	die("veuillez sélectionner votre profil") ;
	}
	}
}

?>