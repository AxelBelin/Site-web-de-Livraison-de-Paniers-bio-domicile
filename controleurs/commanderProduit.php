<?php
session_start() ;

require_once("../modeles/bd.php") ;
require_once("../modeles/produit.php") ;
require_once("../modeles/client.php") ;

if(empty($_POST["qte"]))
{
    die("veuillez saisir une quantité à commander pour ce produit") ;
}

if(isset($_POST["qte"]) && isset($_POST["prodId"]) && isset($_SESSION['numClient']))
{
    if($_POST["qte"] > 0)
    {
        $qte = $_POST["qte"] ;
        $qte = strtr($qte, ",", ".") ;
    } else {
        die("erreur veuillez indiquer une quantité valide de ce produit à commander entre 0.1 et 30 KG") ;
    }

    $numProduit = $_POST["prodId"] ;
    $numClient = $_SESSION['numClient'] ;

    $cobd = new BD("projettutore") ;
    $co = $cobd->connexion() ;
    
    // Vérifier le stock
    $reqVerifStock = "SELECT * FROM produit WHERE numProduit = '$numProduit' AND quantite > '$qte'" ;
    $resultVerifStock = mysqli_query($co, $reqVerifStock) or die(mysqli_error($co)) ;
      
    if(mysqli_num_rows($resultVerifStock) >= 1)
    {
        foreach($resultVerifStock as $prod)
        {
            $nomproduit = $prod['nomproduit'] ;
            $prixHT = $prod['prixproduit'] ;
        }

        $tva = 1.2 ;
        $prixTotal = $prixHT * $qte ;
        $prixtotalnet = $prixTotal * $tva ;

        $reqInsertDebutCom = "INSERT INTO commande(datecommande, prixTotal, TVA, prixtotalnet) VALUES(NOW(), '$prixTotal', '$tva', '$prixtotalnet')" ;
        mysqli_query($co, $reqInsertDebutCom) or die(mysqli_error($co)) ;
        $numCommande =  mysqli_insert_id($co) ;

        $reqInsertCommProd = "INSERT INTO commandeproduit(numCommande, numProduit, quantite) VALUES('$numCommande', '$numProduit', '$qte')" ;
        mysqli_query($co, $reqInsertCommProd) or die(mysqli_error($co)) ;

        // Associer la commande au client qui l'a passée
        $client = new Client($co, $numClient) ;
        $client->setNumCommande($numCommande) ;

        header("Location: ../vues/consulterProduits_Client.php") ;
    } else {
        die("Le stock de ce produit est insuffisant vous devez baisser la quantité à commander") ;
    }
} else {
    die("impossible de commander ce produit vous êtes déconnecté veuillez vous reconnecter") ;
}
?>