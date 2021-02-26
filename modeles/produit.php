<?php

require_once("bd.php") ; // require_once permet d'arrêter le script en cas d'erreur avec la claasse BD
require_once("producteur.php") ; // pas sur peut etre a retirer si erreur

Class Produit {
    private $co ;
    private $numProduit ;
    private $nomProduit ;
    private $qteProd ;
    private $prixKG ;
    private $numTypeProd ;
    private $catProd ;
    private $imgProd ;
    private $saison ;
    private $numFamille ;

    public function __construct()
    {
        // 5 ou 4 ? 5 et  6
        //compter le nombre d'arguments du constructeur via fonction func_num_args
        $cpt = func_num_args() ;
        //recuperer les arguments du constructeur via fonction func_get_args
        $args = func_get_args() ;

        switch($cpt)
        {
            case 5:
                $co = $args[0] ;
                $nomProduit = $args[1] ;
                $qteProd = $args[2] ;
                $prixKG = $args[3] ; // !! Verif dans le controleur que le prix passe en parametre est bien HT !!
                $numTypeProd = $args[4] ;

                // cas ou le produit nexiste pas encore
                $reqInsertProd = "INSERT INTO produit(nomproduit, quantite, prixproduit, numTypeProduit) VALUES('$nomProduit', '$qteProd', '$prixKG', '$numTypeProd')" ;
                mysqli_query($co, $reqInsertProd) or die(mysqli_error($co)) ;
                $this->co = $co ;
                $this->numProduit = mysqli_insert_id($co) ;
                $this->nomProduit = $nomProduit ;
                $this->qteProd = $qteProd ;
                $this->prixKG = $prixKG ;
                $this->numTypeProd = $numTypeProd ;
            break ;
            case 6:
                $co = $args[0] ;
                $nomProduit = $args[1] ;
                $prixKG = $args[2] ; // !! Dans le controleur remettre en TTC
                $saison = $args[3] ; 
                $numTypeProd = $args[4] ;
                $catProd = $args[5] ; // !! Recup dans le controleur !!

                // cas ou le produit existe deja
                $reqRecupInfosProduit = "SELECT numProduit, quantite, nomImg FROM produit WHERE nomproduit = '$nomProduit' AND prixproduit = '$prixKG' AND numTypeProduit = '$numTypeProd'" ;
                $resultRecupInfosProduit = mysqli_query($co, $reqRecupInfosProduit) or die("erreur requete pour la recup des infos supplementaires du produit") ;
                if(mysqli_num_rows($resultRecupInfosProduit) >= 1) // Ou == 1
                {
                    foreach($resultRecupInfosProduit as $produit)
                    {
                        $this->co = $co ;
                        $this->numProduit = $produit['numProduit'] ;
                        $this->nomProduit = $nomProduit ;
                        $this->prixKG = $prixKG ;
                        $this->saison = $saison ;
                        $this->numTypeProd = $numTypeProd ;
                        $this->catProd = $catProd ;
                        $this->qteProd = $produit['quantite'] ;
                        $this->imgProd = $produit['nomImg'] ;
                    }
                } else {
                    die("erreur nom prix ou type de produit saisi incorrect") ;
                }
            break ;
            case 4:
                $co = $args[0] ;
                $numProduit = $args[1] ;
                $nomProduit = $args[2] ;
                $quantite = $args[3]; // !! Dans le controleur remettre en TTC

                $reqRecupInfosProd = "SELECT * FROM produit WHERE numProduit = '$numProduit'" ;
                $resultRecupInfosProd = mysqli_query($co, $reqRecupInfosProd) or die(mysqli_error($co)) ;
                if(mysqli_num_rows($resultRecupInfosProd) >= 1) // Ou == 1
                {
                    foreach($resultRecupInfosProd as $produit)
                    {
                        $this->co = $co ;
                        $this->numProduit = $produit['numProduit'] ;
                        $this->nomProduit = $nomProduit ;
                        $this->prixKG = $produit['prixproduit'];
                        $this->numTypeProd = $produit['numTypeProduit'] ;
                        $this->qteProd = $produit['quantite'] ;
                        $this->imgProd = $produit['nomImg'] ;
                    }
                } else {
                    die("erreur nom prix ou type de produit saisi incorrect") ;
                }
        }
    }

    public function deconnexionProduit()
    {
        // session_destroy() ;
        mysqli_close($this->co) ;
    }

    public function coProduit()
    {
        session_start() ;
        $_SESSION['numProduit'] = $this->numProduit ;
        $_SESSION['nomProduit'] = $this->nomProduit ;
    }

    public function supprimmerProduit($numProduit)
    {
        // Utiliser le destructeur ?
        $reqSupprimmerProd = "DELETE FROM produit WHERE numProduit = '$numProduit'" ;
        mysqli_query($this->co, $reqSupprimmerProd) or die("erreur suppression du produit dans la BD") ;
    }

    public function approvisionnerProduit($numProduit, $QteAjouterKG)
    {
        // Qantité finale (KG) = Quantité Initiale + quantité à ajouter en stock
        $this->qteProd = $this->qteProd + $QteAjouterKG ; // A tester possible erreur
        $reqAjouterStockProd = "UPDATE produit SET quantite = quantite + '$QteAjouterKG' WHERE numProduit = '$numProduit'" ;
        mysqli_query($this->co, $reqAjouterStockProd) or die("erreur approvisionnement du stock de produit pour ce produit") ;
    }

    public function destockageProduit($numProduit, $QteRetirerKG)
    {
        // Quantité finale (KG) = Quantité Initiale - quantité à retirer du stock
        $this->qteProd = $this->qteProd - $QteRetirerKG ; // A tester possible erreur
        $reqRetirerStockProd = "UPDATE produit SET quantite = quantite - '$QteRetirerKG' WHERE numProduit = '$numProduit'" ;
        mysqli_query($this->co, $reqRetirerStockProd) or die("erreur destockage du stock de produit pour ce produit") ;
    }

    public function insertCategorieProduit($numTypePro) // !! Changement dans la BD DONC METHODE SUREMENT A REFAIRE
    {
        $id = $this->numProduit ;
        $this->numTypeProd = $numTypePro ;
        $reqMajCat = "UPDATE compofamille SET numFamille =  WHERE numTypeProduit  = '$numTypePro'" ;
        mysqli_query($this->co, $reqMajCat) or die(mysqli_error($this->co)) ;
    }

    public function insertImgProduit($img) // !! Verifier bon format image dans le controleur avec une Regex si il finit bien par un .jpeg ou .png
    {
        $id = $this->numProduit ;
        $this->imgProd = $img ;
        $reqMajImgProd = "UPDATE produit SET nomImg = '$img' WHERE numProduit  = '$id'" ;
        mysqli_query($this->co, $reqMajImgProd) or die(mysqli_error($this->co)) ;
    }

    public function modif_prixKGProduit($nvPrixKG) // !! Verif dans le controleur que le prix passe en parametre est bien HT !!
    {
        $numProduit = $this->numProduit ;
        $this->prixKG = $nvPrixKG ;
        $reqMajPrixKG = "UPDATE produit SET prixproduit = '$nvPrixKG' WHERE numProduit = '$numProduit'" ;
        mysqli_query($this->co, $reqMajPrixKG) or die("erreur modification prix KG HT du produit") ;
    }

    // fonction verif stock

    public function rechercherNomProduit($nomProduit) // !! Si erreur ne pas tenir compte des methodes de recherche et tout refaire dans les controleurs
    {
        $reqSelectNomProd = "SELECT produit.numProduit, nomImg, nomproduit, prixproduit, saison, nomtypeproduit, categorie FROM produit, typeproduit, famille, compofamille WHERE produit.numTypeProduit = typeproduit.numTypeProduit AND typeproduit.numTypeProduit = compofamille.numTypeProduit AND compofamille.numFamille = famille.numFamille AND nomProduit LIKE '%$nomProduit%' AND quantite > 0" ; // Si LIKE fonctionne pas utiliser =
        $resultSelectNomProd = mysqli_query($this->co, $reqSelectNomProd) or die("erreur requete recherche de produits par nom de produit") ;
        if(mysqli_num_rows($resultSelectNomProd) >= 1) // Ou == 1
        {
            return $resultSelectNomProd ;
        } else {
            return 1 ; // Ou die()
        }
    }

    public function rechercherTypeProduit($typeProduit)
    {
        // TODO
    }

    public function rechercherSaison($saison)
    {
        // TODO
    }

    public function rechercherCatProduit($nomCatégorie)
    {
        // TODO
    }

    public function rechercherLPrixproduit($limitePrix)
    {
        // TODO
    }
}

?>