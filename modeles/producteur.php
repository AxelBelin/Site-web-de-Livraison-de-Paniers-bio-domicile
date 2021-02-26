<?php

require_once("bd.php") ; // require_once permet d'arrêter le script en cas d'erreur avec la claasse BD

Class Producteur {
    private $co ;
    private $idProd ;
    private $mdpProd ;

    public function __construct()
    {
        //compter le nombre d'arguments du constructeur via fonction func_num_args
        $cpt = func_num_args() ;
        //recuperer les arguments du constructeur via fonction func_get_args
        $args = func_get_args() ;

        // Le producteur est unique et ne peut pas etre cree
        if($cpt == 3)
        {
            $co = $args[0] ;
            $idProd = $args[1] ;
            $mdpProd = $args[2] ;

            $hashMdpProd = md5($mdpProd) ;

            $verifProd = "SELECT * FROM producteur WHERE identifiant = '$idProd' AND mdp = '$mdpProd'" ; // $hashMdpProd
            $resultVerifProd = mysqli_query($co, $verifProd) or die("erreur requete verif infos producteur") ;
                foreach($resultVerifProd as $producteur)
                {
                    $this->co = $co ;
                    $this->idProd = $producteur['identifiant'] ;
                    $this->mdpProd = $producteur['mdp'] ;
                }
        } else {
            die("erreur 3 parametres obligatoires") ;
        }
    }

    public function connexionPro()
    {
        session_start() ;
        $_SESSION['idProducteur'] = $this->idProd ;
        $_SESSION['mdpProducteur'] = $this->mdpProd ;
    }

    public function deconnexionPro()
    {
        session_destroy() ;
        mysqli_close($this->co) ;
    }

    public function modif_mdpassePro($nvMdepasse)
    {
        $idProd = $this->idProd ; // pas utile ?
        $this->mdpProd = $nvMdepasse ;

        $reqMajMdpProd = "UPDATE producteur SET mdp = '$nvMdepasse' WHERE identifiant = '$idProd'" ;
        mysqli_query($this->co, $reqMajMdpProd) or die("erreur modif mdp Producteur") ;
    }
}

?>