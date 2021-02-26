<?php

require_once("bd.php") ; // require_once permet d'arrêter le script en cas d'erreur avec la claasse BD
require_once("client.php") ; // pas sur peut etre a retirer si erreur
require_once("produit.php") ; // pas sur peut etre a retirer si erreur
require_once("panier.php") ;

class Commande { // NON TERMINE : A COMPLETER Voir avec Nauval TODO
    private $co ;
    private $numCommande ;
    private static $tva = 1.2 ; // final
    private $boolComGroupe ;
    private $boolComHebdo ;
    private $etatCommande ;
    private $dateCommande ;

    public function __construct()
    {
        // TODO
    }

    public function deconnexionPanier()
    {
        // session_destroy() ;
        mysqli_close($this->co) ;
    }

    public function supprimmerCommande($numCommande)
    {
        // Utiliser le destructeur ?
        $reqSupprimmerCom = "DELETE FROM commande WHERE numCommande = '$numCommande'" ;
        mysqli_query($this->co, $reqSupprimmerCom) or die("erreur suppression dune commande dans la BD") ;
    }

    public function ajouterQtePanierCom($numCommande, $QteAjouterPanierCom)
    {
        // TODO
    }

    public function retirerQtePanierCom($numCommande, $QteRetirerPanierCom)
    {
        // TODO
    }

    public function ajouterQteProduitCom($numCommande, $QteAjouterProdCom)
    {
        // TODO
    }

    public function retirerQteProduitCom($numCommande, $QteAjouterProdCom)
    {
        // TODO
    }

    public function calcPrixTotalTTCCom($numCommande, $QteAjouterProdCom)
    {
        // TODO
        // return $prixTotTTCCom ;
    }

    public function calcNbTotalArtCom()
    {
        // TODO
        // return $nbTotArtCom ;
    }

    public function modif_etatCom($numCommande, $nvEtatCommande)
    {
        // TODO
    }

/* if($nbArgs == 3) // Si le nb de paramètres = 3 : alors on connecte le membre au site
    {
        $co = $tabArgs[0] ; // récupération des valeurs des 3 pramètres à l'aide de tableaux associatifs
        $pseudo = $tabArgs[1] ;
        $passwd = $tabArgs[2] ;

        $reqVerifMembre = "SELECT id, email FROM membres WHERE pseudo = '$pseudo' AND mdpasse = '$passwd'" ; // Requete pour récupérer les informations déja présentes (et non spécifiées en paramètres de l'objet) dans la BD pour un tilisateur qui se connecte
        $resultVerifmembre = mysqli_query($co, $reqVerifMembre) or die(mysqli_error($co)) ; // Erreur si deux pseudos identiques dans la BD

        foreach($resultVerifmembre as $unMembre) // Parcours de chaque ligne retorunées par la requete
        {
            $this->co = $co ; // initialisaion des attributs du constructeur avec toutes les valeurs du membre
            $this->identifiant = $unMembre['id'] ; // Récupération des id
            $this->pseudo = $pseudo ;
            $this->passwd = $passwd ;
            $this->email = $unMembre['email'] ; // et des e-mails
        }
    } else if($nbArgs == 4) // Si le nb de paramètres = 4 : alors on inscrit le membre sur le site = première connection sur le site
    {
        $co = $tabArgs[0] ; // récupération des valeurs des 4 pramètres données à l'objet à l'aide de tableaux associatifs
        $user = $tabArgs[1] ;
        $mdp = $tabArgs[2] ;
        $mail = $tabArgs[3] ; // On récupère aussi l'e-mail : dernier paramètre du constructeur
        $reqCreationCompte = "INSERT INTO membres(pseudo, mdpasse, email) VALUES('$user', '$mdp', '$mail') " ; // requete d'insertion du membre dans la BD avec ses valeurs
        // $reqCreationCompte = "INSERT INTO membres(pseudo, mdpasse, email) VALUES('test', '12sgs', 'test@gglg') " ;
        $resultVerifmembre = mysqli_query($co, $reqCreationCompte) or die(mysqli_error($co)) ;
        $id = mysqli_insert_id($co) ; // récupération du dernier indice inséré (numéro)
        $this->co = $co ; // initialisaion des attributs du constructeur avec toutes les valeurs du membre
        $this->identifiant = $id ;
        $this->pseudo = $pseudo ;
        $this->passwd = $passwd ;
        $this->email = $email ;
    } else {
        die("Erreur de syntaxe : membre") ; // on exit le script en cas de problème
    }
} */
}

?>