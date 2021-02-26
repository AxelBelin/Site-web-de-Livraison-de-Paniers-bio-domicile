<?php
session_start() ;

require_once("../modeles/bd.php") ;
require_once("../modeles/panier.php") ;
require_once("../modeles/client.php") ;

if(empty($_POST["qte"]))
{
    die("veuillez saisir une quantité à commander pour ce panier") ;
}

if(isset($_POST["qte"]) && isset($_POST["prodId"]) && isset($_SESSION['numClient']))
{
    if($_POST["qte"] > 0)
    {
        $qte = $_POST["qte"] ;
        $qte = strtr($qte, ",", ".") ;
    } else {
        die("erreur veuillez indiquer une quantité valide de ce panier à commander minimum 1 panier") ;
    }

    $numPanier = $_POST["prodId"] ;
    $numClient = $_SESSION['numClient'] ;

    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;
    
    // Vérifier le stock de paniers
    $reqVerifStock = "SELECT * FROM panier WHERE numPanier = '$numPanier' AND quantite > '$qte'" ;
    $resultVerifStock = mysqli_query($co, $reqVerifStock) or die(mysqli_error($co)) ;
      
    if(mysqli_num_rows($resultVerifStock) >= 1)
    {
        foreach($resultVerifStock as $panier)
        {
            $nomPanier = $panier['nomPanier'] ;
            $prixHT = $panier['prixpanier'] ;
        }

        $tva = 1.2 ;
        $prixTotal = $prixHT * $qte ;
        $prixtotalnet = $prixTotal * $tva ;

        $reqInsertDebutCom = "INSERT INTO commande(datecommande, prixTotal, TVA, prixtotalnet) VALUES(NOW(), '$prixTotal', '$tva', '$prixtotalnet')" ;
        mysqli_query($co, $reqInsertDebutCom) or die(mysqli_error($co)) ;
        $numCommande =  mysqli_insert_id($co) ;

        $reqInsertCommProd = "INSERT INTO commandepanier(numCommande, numPanier, quantite) VALUES('$numCommande', '$numPanier', '$qte')" ;
        mysqli_query($co, $reqInsertCommProd) or die(mysqli_error($co)) ;

        // Associer la commande au client qui l'a passée. peut être à changer 
        $client = new Client($co, $numClient) ;
        $client->setNumCommande($numCommande) ;

        header("Location: ../vues/consulterPaniers_Client.php") ;
    } else {
        die("Nombre insuffisant de ce panier en stock vous devez baisser la quantité à commander") ;
    }
} else {
    die("impossible de commander ce panier vous êtes déconnecté veuillez vous reconnecter") ;
}
?>