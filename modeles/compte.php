<?php
require_once("bd.php") ; // require_once permet d'arrêter le script en cas d'erreur avec la classe BD

class Compte { // Attributs de la classe
    private $co ;
    private $numCompte ;
    private $profil ;
    private $id ;
    private $mdp ;
    private $CB ;


public function __construct() // Constructeur : Il est dynamique et s'adapte en focntion des besoins : soit créer un compte soit se connecter
{
    //compter le nombre d'arguments du constructeur via fonction func_num_args
    $cpt = func_num_args() ;
    //recuperer les arguments du constructeur via fonction func_get_args
    $args = func_get_args() ;

    switch($cpt)
    {
        case 4:
            $co = $args[0] ;
            $profil = $args[1] ;
            $id = $args[2] ;
            $mdp = $args[3] ;
            // Cas ou il ny a pas de numero de CB
            $hashmdp = md5($mdp) ;
            $reqInsertSansCB = "INSERT INTO compte(profil, indentifiant, motdepasse) VALUES('$profil', '$id', '$hashmdp')" ;
            mysqli_query($co, $reqInsertSansCB) or die(mysqli_error($co)) ;
            $this->co = $co ;
            $this->numCompte = mysqli_insert_id($co) ;
            $this->profil = $profil ;
            $this->id = $id ;
            $this->mdp = $hashmdp ;
        break ;
        case 5:
            $co = $args[0] ;
            $profil = $args[1] ;
            $id = $args[2] ;
            $mdp = $args[3] ;
            $CB = $args[4] ;
            // Cas ou il y a un numero de CB
            $hashmdp = md5($mdp) ;
            $hashCB = md5($CB) ;
            $reqInsertCB = "INSERT INTO compte(profil, indentifiant, motdepasse, numCB) VALUES('$profil', '$id', '$hashmdp', '$hashCB')" ;
            mysqli_query($co, $reqInsertCB) or die(mysqli_error($co)) ;
            $this->co = $co ;
            $this->numCompte = mysqli_insert_id($co) ;
            $this->profil = $profil ;
            $this->id = $id ;
            $this->mdp = $hashmdp ;
            $this->CB = $hashCB ;
        break ;
    }
}

public function connexionCompte()
{
    session_start() ;
    $_SESSION['profil'] = $this->profil ;
    $_SESSION['numCompte'] = $this->numCompte ;
    $_SESSION['idCompte'] = $this->id ;
}

public function deconnexionCompte()
{
    session_destroy() ;
    mysqli_close($this->co) ;
}

public function modif_pseudo($nvPseudo)
{
    $numCompte = $this->numCompte ;
    $this->id = $nvPseudo ;
    $reqMajPseudo = "UPDATE compte SET indentifiant = '$nvPseudo' WHERE numCompte = '$numCompte'" ;
    mysqli_query($this->co, $reqMajPseudo) or die("erreur modification du pseudo") ;
}

public function modif_mdpasse($nvMdepasse)
{
    $numCompte = $this->numCompte ;
    $this->mdp = $nvMdepasse ;
    $reqMajMdp = "UPDATE compte SET motdepasse = '$nvMdepasse' WHERE numCompte = '$numCompte'" ;
    mysqli_query($this->co, $reqMajMdp) or die("erreur modification du mot de passe") ;
}

public function modif_CB($nvCB)
{
    $hashCB = md5($nvCB) ;
    $numCompte = $this->numCompte ;
    $this->CB = $hashCB ;
    $reqMajCB = "UPDATE compte SET numCB = '$hashCB' WHERE numCompte = '$numCompte'" ;
    mysqli_query($this->co, $reqMajCB) or die("erreur modification du numero de CB") ;
}
}
?>