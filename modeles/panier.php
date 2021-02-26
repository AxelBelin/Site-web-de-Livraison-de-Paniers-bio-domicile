<?php

require_once("bd.php") ; // require_once permet d'arrêter le script en cas d'erreur avec la claasse BD
require_once("producteur.php") ; // pas sur peut etre a retirer si erreur
require_once("produit.php") ; // pas sur peut etre a retirer si erreur

class Panier {
    private $co ;
    private $numPanier ;
    private $nomPanier ;
    private $nbProduitPan ;
    private $qtePanier ;
    private $prixpanier ;
    private $poidsPanier ;
    private $imgPanier ;
    private $numProduitPan ;
    private $nomProduitPan ;
    // private $saisonPanier ;

    public function __construct()
    {
        //compter le nombre d'arguments du constructeur via fonction func_num_args
        $cpt = func_num_args() ;
        //recuperer les arguments du constructeur via fonction func_get_args
        $args = func_get_args() ;
        // 4 5 ou 7
        switch($cpt)
        {
            case 5:
                $co = $args[0] ;
                $nomPanier = $args[1] ;
                $nbProduitPan = $args[2] ;
                $qtePanier = $args[3] ;
                $prixpanier = $args[4] ; // !! Verif dans le controleur que le prix passe en parametre est bien HT !!

                // Cas ou le panier n'existe pas encore avec saisie dun nom de panier
                $reqInsertPan = "INSERT INTO panier(nomPanier, nbProduit, quantite, prixpanier) VALUES('$nomPanier', '$nbProduitPan', '$qtePanier', '$prixpanier')" ;
                mysqli_query($co, $reqInsertPan) or die("erreur impossible dajouter le panier saisi") ;
                $this->co = $co ;
                $this->numPanier = mysqli_insert_id($co) ;
                $this->nomPanier = $nomPanier ;
                $this->nbProduitPan = $nbProduitPan ;
                $this->qtePanier = $qtePanier ;
                $this->prixpanier = $prixpanier ;
            break ;
            case 6:
                $co = $args[0] ;
                
                $nomPanier = $args[1] ;
                $nbProduitPan = $args[2] ;
                // $saison = $args[3] ;
                $poidsPanier = $args[4] ;
                $prixpanier = $args[5] ; // !! Dans le controleur remettre en TTC !!

                // Cas ou le panier existe deja
                $reqRecupInfosPanier = "SELECT numPanier, quantite, nomImg FROM panier WHERE nomPanier = '$nomPanier' AND nbProduit = '$nbProduitPan' AND prixpanier = '$prixpanier' AND poids = '$poidsPanier'" ;
                $resultRecupInfosPan = mysqli_query($co, $reqRecupInfosPanier) or die(mysqli_error($co)) ;
                if(mysqli_num_rows($resultRecupInfosPan) >= 1) // Ou == 1
                {
                    foreach($resultRecupInfosPan as $panier)
                    {
                        $this->co = $co ;
                        $this->numPanier = $panier['numPanier'] ;
                        $this->nomPanier = $nomPanier ;
                        $this->saisonPanier = $saison ;
                        $this->poidsPanier = $poidsPanier ;
                        $this->prixpanier = $prixpanier ;
                        $this->qtePanier = $panier['quantite'] ;
                        $this->imgPanier = $panier['nomImg'] ;
                    }
                } else {
                    die("erreur nom prix nbProduits ou poids de panier saisi incorrect") ;
                }
            break ;
            case 3:
                $co = $args[0] ;
                $numPanier = $args[1] ;
                $nbProduitPan = $args[2] ;

                $reqRecupInfosPanier = "SELECT nomPanier, quantite, prixpanier FROM panier WHERE nbProduit = '$nbProduitPan' AND numPanier = '$numPanier'" ;
                $resultRecupInfosPan = mysqli_query($co, $reqRecupInfosPanier) or die(mysqli_error($co)) ;
                if(mysqli_num_rows($resultRecupInfosPan) >= 1) // Ou == 1
                {
                    foreach($resultRecupInfosPan as $panier)
                    {
                        $this->co = $co ;
                        $this->numPanier = $numPanier ;
                        $this->nbProduitPan = $nbProduitPan ;
                        $this->nomPanier = $panier['nomPanier'] ;
                        $this->prixpanier = $panier['prixpanier'] ;
                        $this->qtePanier = $panier['quantite'] ;
                    }
                } else {
                    die("erreur nom num nbProduits saisi incorrect") ;
                }
            break ;
        }
    }

    public function deconnexionPanier()
    {
        // session_destroy() ;
        mysqli_close($this->co) ;
    }

    public function ajouterContenuPanier($numProduitPan, $nbProduitParArt) // !! Trouver le num du produit a partir de son nom dans le controleur !!
    {
        $numPan = $this->numPanier ;
        $this->numProduitPan = $numProduitPan ;
        $reqInsertCompoPanier = "INSERT INTO compopanier(numPanier, numProduit, qteProduitParArt) VALUES('$numPan', '$numProduitPan', '$nbProduitParArt')" ;
        mysqli_query($this->co, $reqInsertCompoPanier) or die(mysqli_error($this->co)) ;
    }

    public function retirerContenuPanier($numProduitPan)
    {
        $numPan = $this->numPanier ;
        $this->numProduitPan = $numProduitPan ;
        $reqSupprimmerCompoPanier = "DELETE FROM compopanier WHERE numProduit = '$numProduitPan' AND numPanier = '$numPan'" ;
        mysqli_query($this->co, $reqSupprimmerCompoPanier) or die("erreur ce produit n'est pas dans ce panier. Veuillez choisir un produit valide") ;
    }

    public function supprimmerPanier($numPanier)
    {
        // Utiliser le destructeur ?
        $reqSupprimmerPanier = "DELETE FROM panier WHERE numPanier = '$numPanier'" ;
        mysqli_query($this->co, $reqSupprimmerPanier) or die("erreur suppression du panier dans la BD") ;
    }

    public function approvisionnerPanier($numPanier, $QteAjouterPanier)
    {
        // Quantité finale = Quantité Initiale + quantité à ajouter en stock
        $this->qtePanier = $this->qtePanier + $QteAjouterPanier ; // A tester possible erreur
        $reqAjouterStockPanier = "UPDATE panier SET quantite = quantite + '$QteAjouterPanier' WHERE numPanier = '$numPanier'" ;
        mysqli_query($this->co, $reqAjouterStockPanier) or die("erreur approvisionnement du stock de panier pour ce panier donne") ;
    }

    public function destockagePanier($numPanier, $QteRetirerPanier)
    {
        // Quantité finale = Quantité Initiale - quantité à retirer du stock
        $this->qtePanier = $this->qtePanier - $QteRetirerPanier ; // A tester possible erreur
        $reqRetirerStockPanier = "UPDATE panier SET quantite = quantite - '$QteRetirerPanier' WHERE numPanier = '$numPanier'" ;
        mysqli_query($this->co, $reqRetirerStockPanier) or die("erreur destockage du stock de panier pour ce panier donne") ;
    }

    /* public function insertSaisonPanier($numPanier, $saison)
    {
        // TODO
    } */

    public function insertPoidsPanier($poidsKGPanier) // !! Verif poids du panier dans le controleur !!
    {
        $numPanier = $this->numPanier ;
        $this->poidsPanier = $poidsKGPanier ;
        $reqMajPoidsPanierKG = "UPDATE panier SET poids = '$poidsKGPanier' WHERE numPanier = '$numPanier'" ;
        mysqli_query($this->co, $reqMajPoidsPanierKG) or die(mysqli_error($this->co)) ;
    }

    public function insertSaisonPanier($saison)
    {
        $numPanier = $this->numPanier ;
        $this->poidsPanier = $saison ;
        $reqMajSaisonPanier = "UPDATE panier SET saison = '$saison' WHERE numPanier = '$numPanier'" ;
        mysqli_query($this->co, $reqMajSaisonPanier) or die(mysqli_error($this->co)) ;
    }

    public function insertImgPanier($img) // !! Verifier bon format immage dans le controleur avec une Regex si il finit bien par un .jpeg ou .png
    {
        $numPanier = $this->numPanier ;
        $this->imgPanier = $img ;
        $reqMajImgPanier = "UPDATE panier SET nomImg = '$img' WHERE numPanier = '$numPanier'" ;
        mysqli_query($this->co, $reqMajImgPanier) or die(mysqli_error($this->co)) ;
    }

    public function modif_prixPanier($nvPrixPanier) // !! Verif dans le controleur que le prix passe en parametre est bien HT !!
    {
        $numPanier = $this->numPanier ;
        $this->prixpanier = $nvPrixPanier ;
        $reqMajPrixPanier = "UPDATE panier SET prixpanier = '$nvPrixPanier' WHERE numPanier = '$numPanier'" ;
        mysqli_query($this->co, $reqMajPrixPanier) or die("erreur modification prix unitaire HT du panier") ;
    }

    public function modif_nbProdPaniers($nvnbProduits)
    {
        $numPanier = $this->numPanier ;
        $this->nbProduitPan = $nvnbProduits ;
        $reqMajNbProduitsPan = "UPDATE panier SET nbProduit = '$nvnbProduits' WHERE numPanier = '$numPanier'" ;
        mysqli_query($this->co, $reqMajNbProduitsPan) or die("erreur modification nombre de produits contenus dans le panier") ;
    }

    public function rechercherNomPanier($nomPanier) // !! Si erreur ne pas tenir compte des methodes de recherche et tout refaire dans les controleurs
    {
        $reqSelectNomPanier = "SELECT numPanier, nomImg, nomPanier, prixpanier FROM panier WHERE quantite > 0 AND nomProduit LIKE '%$nomPanier%'" ; // Si LIKE fonctionne pas utiliser =
        $resultSelectNomPanier = mysqli_query($this->co, $reqSelectNomPanier) or die("erreur requete recherche de paniers par nom de panier") ;
        if(mysqli_num_rows($resultSelectNomPanier) >= 1) // Ou == 1
        {
            return $resultSelectNomPanier ;
        } else {
            return 1 ; // Ou die()
        }
    }

    public function rechercherNbProdPanier($nbProduitsPanier)
    {
        // TODO
    }

    public function rechercherPoidsPanier($poidsPanier)
    {
        // TODO
    }

    public function rechercherLPrixpanier($limitePrix)
    {
        // TODO
    }

    public function rechercherLPrixproduit($limitePrix)
    {
        // TODO
    }
}

?>