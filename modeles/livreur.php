<?php

require_once("bd.php") ; // require_once permet d'arrêter le script en cas d'erreur avec la claasse BD
require_once("compte.php") ;

class Livreur {
    private $co ;
    private $numLivreur ; // Clé primaire de la table Livreur
    private $numCompteLivreur ; // Clé étrangère de la table Livreur vers numCompte table Compte
    private $idLivreur ;
    private $mdpLivreur ;
    private $nomLivreur ;
    private $prenomLivreur ;
    private $dateLivraison ;
    private $telLivreur ;
    private $mailLivreur ;

public function __construct()
{
    //compter le nombre d'arguments du constructeur via fonction func_num_args
    $cpt = func_num_args() ;
    //recuperer les arguments du constructeur via fonction func_get_args
    $args = func_get_args() ;

    switch($cpt)
    {
        case 4:
            $co = $args[0] ;
            $idLivreur = $args[1] ;
            $mailLivreur = $args[2] ;
            $mdpLivreur = $args[3] ;

            $hashMdpLivreur = md5($mdpLivreur) ;

            // Cas ou le livreur existe deja
            $reqVerifId = "SELECT numCompte FROM compte WHERE indentifiant = '$idLivreur' AND motdepasse = '$hashMdpLivreur'" ;
            $resultVerifId = mysqli_query($co, $reqVerifId) or die(mysqli_error($co)) ;
            if(mysqli_num_rows($resultVerifId) >= 1) // Ou == 1
            {
                $reqCoLivreur = "SELECT numLivreur, nomlivreur, prenomLivreur, datelivraison, telLivreur, numCompte FROM livreur WHERE mailLivreur = '$mailLivreur'" ;
                $resultCoLivreur = mysqli_query($co, $reqCoLivreur) or die(mysqli_error($co)) ;
                if(mysqli_num_rows($resultCoLivreur) >= 1) // Ou == 1
                {
                    foreach($resultCoLivreur as $livreur)
                    {
                    $this->co = $co ;
                    $this->idLivreur = $idLivreur ;
                    $this->mailLivreur = $mailLivreur ;
                    // $this->mdpLivreur = $hashMdpLivreur ;
                    $this->numLivreur = $livreur['numLivreur'] ;
                    $this->numCompteLivreur = $livreur['numCompte'] ;
                    $this->nomLivreur = $livreur['nomlivreur'] ;
                    $this->prenomLivreur = $livreur['prenomLivreur'] ;
                    $this->dateLivraison = $livreur['datelivraison'] ;
                    $this->telLivreur = $livreur['telLivreur'] ;
                    }
                } else {
                    die("erreur adresse mail saisie incorrecte ou mauvais profil") ;
                }
            } else {
                die("erreur identifiant ou mot de passe saisi incorrect ou mauvais profil") ;
            }
        break ;
        case 6:
            $co = $args[0] ;
            $idLivreur = $args[1] ;
            $nomLivreur = $args[2] ;
            $prenomLivreur = $args[3] ;
            $telLivreur = $args[4] ;
            $mailLivreur = $args[5] ;

            // hashMdpLivreur = md5($mdpLivreur) ;
            
            // Cas ou le livreur nexiste pas
            /* $reqVerifId = "SELECT numCompte FROM compte WHERE identifiant = '$idLivreur' AND motdepasse = '$hashMdpLivreur'" ;
            $resultVerifId = mysqli_query($co, $reqVerifId) or die("erreur verif identifiant du livreur") ;
            if(mysqli_num_rows($resultVerifId) >= 1) // Ou == 1
            {
                foreach($resultVerifId as $liv)
                {
                    $numCptlivreur = $liv['numCompte'] ; // !! SI recup du num de compte livreur ne fonctionne pas utiliser les variables de session pour le récup
                } */

                $this->numCompteLivreur = $idLivreur ;

                $reqInsertLivreur = "INSERT INTO livreur(nomlivreur, prenomLivreur, telLivreur, mailLivreur, numCompte) VALUES('$nomLivreur', '$prenomLivreur', '$telLivreur', '$mailLivreur', '$idLivreur')" ;
                mysqli_query($co, $reqInsertLivreur) or die(mysqli_error($co)) ;
                $this->co = $co ;
                $this->mailLivreur = $mailLivreur ;
                $this->numLivreur = mysqli_insert_id($co) ;
                $this->nomLivreur = $nomLivreur ;
                $this->prenomLivreur = $prenomLivreur ;
                $this->telLivreur = $telLivreur ;
        break ;
    }
}

public function connexionLivreur()
{
    session_start() ;
    $_SESSION['profil'] = "Livreur" ; // A retirer si erreur
    $_SESSION['numLivreur'] = $this->numLivreur ;
    $_SESSION['numCompteLivreur'] = $this->numCompteLivreur ;
    $_SESSION['idCompteLivreur'] = $this->idLivreur ;
    $_SESSION['mailLivreur'] = $this->mailLivreur ;
    $_SESSION['mdpLivreur'] = $this->mdpLivreur ;
}

public function deconnexionLivreur()
{
    session_destroy() ;
    mysqli_close($this->co) ;
}

public function insertDateLivraison($nvDateLivraison)
{
    $numLivreur = $this->numLivreur ;
    $this->dateLivraison = $nvDateLivraison ;
    $reqMajDateLiv = "UPDATE livreur SET datelivraison = '$nvDateLivraison' WHERE numLivreur = '$numLivreur'" ;
    mysqli_query($this->co, $reqMajDateLiv) or die("erreur modification ou insertion derniere date de livraison") ;
}

public function modif_telLivreur($nvTelLivreur)
{
    $numLivreur = $this->numLivreur ;
    $this->telLivreur = $nvTelLivreur ;
    $reqMajTelLiv = "UPDATE livreur SET telLivreur = '$nvTelLivreur' WHERE numLivreur = '$numLivreur'" ;
    mysqli_query($this->co, $reqMajTelLiv) or die("erreur modification numero de tel livreur") ;
}

public function modif_mailLivreur($nvMailLivreur)
{
    $numLivreur = $this->numLivreur ;
    $this->mailLivreur = $nvMailLivreur ;
    $reqMailTelLiv = "UPDATE livreur SET mailLivreur = '$nvMailLivreur' WHERE numLivreur = '$numLivreur'" ;
    mysqli_query($this->co, $reqMailTelLiv) or die("erreur modification mail livreur") ;
}
}

?>