<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title> resultat de recherche </title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<style>
footer {
    display: flex;
    justify-content: center;
    padding: 15px;
    background-color:#C4C4C4 ;
	color: #fff;
	position: absolute;
	bottom: 0;
	left: 0;
	right: 0 ;
	}

	.help {
		left: 20px;
    justify-content: center;
    padding: 15px;
	}

	.contact {
		right: 20px;
    justify-content: center;
    padding: 15px;
    }
    
    h1 {
        text-align: center ;
        color: white ;
    }

    .titre {
        text-align: center ;
        color: white ;
    }

    body {
      background-image :url("../img/test.jpg") ;
	    background-size:cover;
    }

    table {
    /*border: 3px solid black ; */
    background-color: white ;
  }

  thead {
    background-color: #C4C4C4;
  }

    .col-lg-3 {
      border: 1px solid black ;
      background-color: white ;
    }

</style>
  </head>
   <body>
    <br />
<main>
<div class="position-relative m-5">
  <h1>Resultat de votre recherche de paniers</h1>
<?php
require_once("../modeles/bd.php") ;
require_once("../modeles/panier.php") ;

$cobd = new BD("projettutore") ;
$co = $cobd->connexion() ;

if(empty($_POST['barre']))
{
    die("veuillez saisir votre recherche") ;
}

if(isset($_POST['barre']))
{
    $recherche = $_POST['barre'] ;

    $tva = 1.2 ;

    $reqProduits = "SELECT numPanier, nomImg, nomPanier, prixpanier, quantite FROM panier WHERE quantite > 2 AND nomPanier LIKE '%$recherche%'" ;
      $resultProuits = mysqli_query($co, $reqProduits) or die(mysqli_error($co)) ;
      
	if(mysqli_num_rows($resultProuits) >= 1)
	{
        foreach($resultProuits as $panier)
		{
          echo "<div class='col-lg-3'>" ;
            echo "<div class='position-relative m-5'>" ;
               echo "<img src='../img/".$panier['nomImg']."' class='bd-placeholder-img' width='140' height='140' alt='".$panier['nomPanier']."'>" ;
               echo "</div>" ;
               echo "<p></p>" ;
               echo "<p> Nom : ".$panier['nomPanier']."</p>" ;
               echo "<p> Prix unitaire : ".$tva*$panier['prixpanier']." &euro; TTC</p>" ;
               echo "<p> Quantité en stock : ".$panier['quantite']." KG</p>" ;
              echo "</div>" ;
        }
    } else {
        echo "<h4>Aucun résultat...</h4>" ;
    }
} else {
    die("erreur recherche") ;
}
?>