<?php

session_start();

require_once("../modeles/bd.php");
require_once("../modeles/client.php");

if(isset($_SESSION["numClient"]))
{
    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;    

$numClient = $_SESSION["numClient"];

$client = new Client($co, $numClient) ;
$client->deconnexionClient() ;
session_destroy() ;
header('Location:../vues/accueil.html') ;
} else {
    die("impossible de vous déconnecter") ;
}

?>