<?php
require_once("../modeles/bd.php") ;
require_once("../modeles/producteur.php") ;

if(empty($_POST["idPro"]))
{
    die("erreur veuillez saisir votre identifiant") ;
}

if(empty($_POST["mdpPro"]))
{
    die("erreur veuillez saisir votre mot de passe") ;
}

if(isset($_POST["idPro"]) && isset($_POST["mdpPro"]))
{
    $id = $_POST["idPro"] ;
    $mdp = $_POST["mdpPro"] ;

    $coBD = new BD("projettutore") ;
    $co = $coBD->connexion() or die("erreur de connexion") ;

    $reqVerifprod = "SELECT * FROM producteur WHERE identifiant = '$id' AND mdp = '$mdp'" ;
    $resultVerifProd = mysqli_query($co, $reqVerifprod) or die(mysqli_error($co)) ;
    
    if(mysqli_num_rows($resultVerifProd) == 1)
    {
        $prod = new Producteur($co, $id, $mdpProd) ;
        $prod->connexionPro() ;
        header("Location: ../vues/consulterCommande_Producteur.php") ;
    } else {
        die("erreur identifiant ou mot de passe saisis incorrects") ;
    }
}

?>