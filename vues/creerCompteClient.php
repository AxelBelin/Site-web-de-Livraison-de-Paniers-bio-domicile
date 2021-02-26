<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title> Créer un Compte Client </title>
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

	.formCli {
		padding: 5px;
		margin: 5px;
		height: 650px;
  		width: 800px ;
	}

	html {
		position: absolute;
		height: 100%;
  		width: 100% ;
	}

</style>

</head>
<body>
	<main>
		<div class="container">
			<div class="row">
			  <div class="col-lg-auto">
				<div class="position-absolute top-50 start-50 translate-middle">
	<h1>Créer un compte Client</h1>
	<p></p>
	
<form class="formCli" method="post" action="../controleurs/ajouterClient.php">
					<div class="mb-3">
					<p>
							<label for="lblnom" class="form-label">Votre nom : *</label>
							<input type="text" class="form-control" id="nomCli" name="nomCli" placeholder="Saisir votre nom">
					</p>
					</div>
					<div class="mb-3">
					<p>
						<label for="lblprenom" class="form-label">Votre prénom : *</label>
						<input type="text" class="form-control" id="prenomCli" name="prenomCli" placeholder="Saisir votre prénom">
						</p>
						</div>
					<div class="mb-3">
						<p>
								<label for="lblmail" class="form-label">Votre adresse e-mail : *</label>
								<input type="email" class="form-control" id="mailCli" name="mailCli" placeholder="Exemples: nom@gmail.com ou nom@orange.fr...">
						</p>
					</div>
					<div class="mb-3">
						<p>
								<label for="lbladresse" class="form-label">Votre adresse de livraison : *</label>
								<input type="text" class="form-control" id="adresse" name="adresse" placeholder="Exemples: 50 rue des pépins...">

								<label for="lblCP" class="form-label">Code Postal : *</label>
								<input type="number" class="form-control" id="CP" name="cp" min="10000" max="99999">

								<label for="lblQuartier" class="form-label">Quartier : *</label>
								<Select class="form-select" name="quartier">
                                <option value="nulle">Sélectionnez votre quartier...</option>
                                <?php
                                    require_once("../modeles/bd.php") ;
                                    $cobd = new BD("projettutore") ;
                                    $co = $cobd->connexion() ;

                                    $reqRecupQuartier = "SELECT numCartier, nomCartier FROM quartier" ;
                                    $resultRecupQuartier = mysqli_query($co, $reqRecupQuartier) or die(mysqli_error($co)) ;
                                    foreach($resultRecupQuartier as $quartiers)
                                    {
                                        echo "<option value='".$quartiers['numCartier']."'>".$quartiers['nomCartier']."</option>" ;
                                    }
                                ?>
                                </select>
						</p>
					</div>
					<div class="mb-3">
						<p>
								<label for="lblbudget" class="form-label">Votre Budget (&euro;) :</label>
								<input type="number" class="form-control" id="limitePrix" name="limitePrix" min="2" max="500">
						</p>
					</div>
						<div class="mb-3">
							<p>
								<label for="lbltel" class="form-label">Votre numéro de téléphone : *</label>
								<input type="text" class="form-control" id="telCli" name="telCli" placeholder="Exemples: 0665121212 ou +33665121212...">
							</p>
						</div>
						<div class="mb-3">
							<p>
									<label for="lblgroupe" class="form-label">Combien de personnes êtes-vous ? :</label>
									<p>(si vous faites partie d'un groupe)</p>
									<input type="number" class="form-control" id="groupe" name="groupe" min="2" max="20">
							</p>
						</div>
		<p> NB : les champs suivis de * sont obligatoires</p>
			<p>
				<input type="submit" class="btn btn-outline-primary" name="creerCompteCli" value="Créer votre compte Client >">
		</p>

	<hr>
		<a class="help" href="">besoin d'aide?</a>
		<p></p>
		<a class="prod" href="connexionProducteur.html">Espace Producteur</a>
		<p></p>
		<a class="contact" href="">Contacts</a>
		<p></p>
			
</form>
</div>
</div>
</div>
</div>
</main>
</body>
</html>