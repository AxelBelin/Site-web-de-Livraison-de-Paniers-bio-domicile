<?php

require_once("bd.php") ; // require_once permet d'arrêter le script en cas d'erreur avec la claasse BD
require_once("compte.php") ;

Class Client {
    private $co ;
    private $numClient ; // Clé primaire de la table Client
    private $numCompteClient ; // Clé étrangère de la table Client vers numCompte table Compte
    private $idClient ;
    private $mdpClient ;
    private $nomclient ;
    private $prenomclient ;
    private $mailClient ;
    private $adresseClient ;
    private $CP ;
    private $quartier ;
    private $limitePrix ;
    private $telClient ;
    private $groupe ;
    private $numLivreur ;
    private $numCommande ;

    public function __construct()
    {
        //compter le nombre d'arguments du constructeur via fonction func_num_args
        $cpt = func_num_args() ;
        //recuperer les arguments du constructeur via fonction func_get_args
        $args = func_get_args() ;
    
        switch($cpt)
        {
            case 2:
                $co = $args[0] ;
                $numClient = $args[1] ;

                // cas pour gérer les commandes et les livreurs
                $reqVerifId = "SELECT compte.numCompte FROM compte, client WHERE compte.numCompte = client.numCompte AND client.numClient = '$numClient'" ;
                $resultVerifId = mysqli_query($co, $reqVerifId) or die(mysqli_error($co)) ;
                if(mysqli_num_rows($resultVerifId) >= 1) // Ou == 1
                {
                    $reqCoClient = "SELECT nomclient, prenomclient, adresse, limitdeprix, tel, groupe, numCompte, mail, numCommande, numLivreur, quartier.nomCartier, ville.CP FROM client, ville, quartier WHERE client.numCartier = quartier.numCartier AND quartier.numVille = ville.numVille AND client.numClient = '$numClient'" ;
                    $resultCoClient = mysqli_query($co, $reqCoClient) or die(mysqli_error($co)) ;
                    if(mysqli_num_rows($resultCoClient) >= 1) // Ou == 1
                    {
                        foreach($resultCoClient as $client)
                        {
                        $this->co = $co ;
                        $this->mailClient = $client['mail'] ;
                        $this->numClient = $numClient ;
                        $this->numCompteClient = $client['numCompte'] ;
                        $this->nomclient = $client['nomclient'] ;
                        $this->prenomclient = $client['prenomclient'] ;
                        $this->adresseClient = $client['adresse'] ;
                        $this->CP = $client['CP'] ;
                        $this->quartier = $client['nomCartier'] ;
                        $this->limitePrix = $client['limitdeprix'] ;
                        $this->telClient = $client['tel'] ;
                        $this->groupe = $client['groupe'] ;
                        }
                    } else {
                        die("erreur adresse mail saisie incorrecte ou mauvais profil") ;
                    }
                } else {
                    die("erreur identifiant ou mot de passe saisi incorrect ou mauvais profil") ;
                }
            break ;
            case 4:
                $co = $args[0] ;
                $idClient = $args[1] ;
                $mailClient = $args[2] ;
                $mdpClient = $args[3] ;
    
                $hashMdpClient = md5($mdpClient) ;
    
                // Cas où le client existe deja
                $reqVerifId = "SELECT numCompte FROM compte WHERE indentifiant = '$idClient' AND motdepasse = '$hashMdpClient'" ;
                $resultVerifId = mysqli_query($co, $reqVerifId) or die(mysqli_error($co)) ;
                if(mysqli_num_rows($resultVerifId) >= 1) // Ou == 1
                {
                    $reqCoClient = "SELECT numClient , nomclient, prenomclient, adresse, limitdeprix, tel, groupe, numCompte, quartier.nomCartier, ville.CP FROM client, ville, quartier WHERE client.numCartier = quartier.numCartier AND quartier.numVille = ville.numVille AND mail = '$mailClient'" ;
                    $resultCoClient = mysqli_query($co, $reqCoClient) or die(mysqli_error($co)) ;
                    if(mysqli_num_rows($resultCoClient) >= 1) // Ou == 1
                    {
                        foreach($resultCoClient as $client)
                        {
                        $this->co = $co ;
                        $this->idClient = $idClient ;
                        // $this->mdpClient = $hashMdpClient ;
                        $this->mailClient = $mailClient ;
                        $this->numClient = $client['numClient'] ;
                        $this->numCompteClient = $client['numCompte'] ;
                        $this->nomclient = $client['nomclient'] ;
                        $this->prenomclient = $client['prenomclient'] ;
                        $this->adresseClient = $client['adresse'] ;
                        $this->CP = $client['ville.CP'] ;
                        $this->quartier = $client['quartier.nomCartier'] ;
                        $this->limitePrix = $client['limitdeprix'] ;
                        $this->telClient = $client['tel'] ;
                        $this->groupe = $client['groupe'] ;
                        }
                    } else {
                        die("erreur adresse mail saisie incorrecte ou mauvais profil") ;
                    }
                } else {
                    die("erreur identifiant ou mot de passe saisi incorrect ou mauvais profil") ;
                }
            break ;
            case 8: // ou 9
                $co = $args[0] ;
                $idClient = $args[1] ;
                $mailClient = $args[2] ;
                // $mdpClient = $args[3] ;
                $nomclient = $args[3] ;
                $prenomclient = $args[4] ;
                $adresseClient = $args[5] ;
                $telClient= $args[6] ;
                // $CP = $args[8] ; // !! A verif dans le controlleur !!
                // $quartier = $args[9] ; // !! A verif dans le controlleur !!
                $numCompteClient = $args[7] ;
    
                // $hashMdpClient = md5($mdpClient) ;
                
                // Cas ou le client nexiste pas
                $reqVerifId = "SELECT numCompte FROM compte WHERE indentifiant = '$idClient'" ; // AND motdepasse = '$hashMdpClient'
                $resultVerifId = mysqli_query($co, $reqVerifId) or die(mysqli_error($co)) ;
                if(mysqli_num_rows($resultVerifId) >= 1) // Ou == 1
                {
                    $this->numCompteClient = $numCompteClient ;
    
                    $reqInsertClient = "INSERT INTO client(nomclient, prenomclient, mail, adresse, tel, numCompte) VALUES('$nomclient', '$prenomclient', '$mailClient', '$adresseClient', '$telClient', '$numCompteClient')" ;
                    mysqli_query($co, $reqInsertClient) or die(mysqli_error($co)) ;
                    $this->co = $co ;
                    $this->idClient = $idClient ;
                    $this->mailClient = $mailClient ;
                    $this->numClient = mysqli_insert_id($co) ;
                    $this->nomclient = $nomclient ;
                    $this->prenomclient = $prenomclient ;
                    $this->adresseClient = $adresseClient ;
                    $this->telClient = $telClient ;
                } else {
                    die("erreur impossible de retrouver identifiant ou mot de passe du compte pour inserer le client") ;
                }
            break ;
        }
    }

    public function connexionClient()
    {
        session_start() ;
        $_SESSION['profil'] = "Client" ; // A retirer si erreur
        $_SESSION['numClient'] = $this->numClient ;
        $_SESSION['numCompteClient'] = $this->numCompteClient ;
        $_SESSION['idCompteClient'] = $this->idClient ;
        $_SESSION['mailClient'] = $this->mailClient ;
    }

    public function deconnexionClient()
    {
        session_destroy() ;
        mysqli_close($this->co) ;
    }

    public function insertCoordonneesLivraison($CP, $Quartier)
    {
        $numClient = $this->numClient ;
        $this->cp = $CP ;
        $this->quartier = $Quartier ;
        $reqVerifInfosCoo = "SELECT quartier.numCartier , ville.numVille FROM ville, quartier WHERE quartier.numVille = ville.numVille AND quartier.numCartier = '$Quartier' AND ville.CP = '$CP'" ;
        $resultInfosCoo = mysqli_query($this->co, $reqVerifInfosCoo) or die(mysqli_error($this->co)) ;
        if(mysqli_num_rows($resultInfosCoo) >= 1) // Ou == 1
        {
            $reqMajQuartier = "UPDATE client SET numCartier = '$Quartier' WHERE numClient = '$numClient'" ;
            mysqli_query($this->co, $reqMajQuartier) or die(mysqli_error($this->co)) ;
        } else {
            die("erreur CP ou quartier saisis incorrect") ;
        }
    }

    public function insertNumCartier($numClient, $nvNumCartier) // !! Dabord verif CP et quartier et trouver avec une requte le bon numCartier a inserer dans Client !!
    {
        $reqRecupInfosClient = "SELECT quartier.nomCartier, ville.CP FROM ville, quartier WHERE quartier.numVille = ville.numVille AND quartier.numCartier = '$nvNumCartier'" ;
        $resultRecupInfos = mysqli_query($this->co, $reqRecupInfosClient) or die("erreur requete pour la recup des infos ville et CP") ;
        if(mysqli_num_rows($resultRecupInfos) >= 1) // Ou == 1
        {
            foreach($resultRecupInfos as $info)
            {
                $this->CP = $info['ville.CP'] ;
                $this->quartier = $info['quartier.nomCartier'] ;
            }
            
        $reqMajNumCartier = "UPDATE client SET numCartier = '$nvNumCartier' WHERE numClient = '$numClient'" ;
        mysqli_query($this->co, $reqMajNumCartier) or die("erreur modification ou insertion numero de quartier") ;
        } else {
            die("erreur numero de quartier saisi incorrect") ;
        }
    }

    public function insertNumLivreur($numClient, $nvNumLivreur)
    {
        $this->numLivreur = $nvNumLivreur ;
        $reqMajNumLivreur = "UPDATE client SET numLivreur = '$nvNumLivreur' WHERE numClient = '$numClient'" ;
        mysqli_query($this->co, $reqMajNumLivreur) or die("erreur modification ou insertion du num Livreur associe a une commande client") ;
    }

    public function insertBudget($nvBudget)
    {
        $numClient = $this->numClient ;
        $this->limitePrix = $nvBudget ;
        $reqMajBudget = "UPDATE client SET limitdeprix = '$nvBudget' WHERE numClient = '$numClient'" ;
        mysqli_query($this->co, $reqMajBudget) or die(mysqli_error($this->co)) ;
    }

    public function insertGroupe($nvNbPersonnes)
    {
        $numClient = $this->numClient ;
        $this->groupe = $nvNbPersonnes ;
        $reqMajGroupe = "UPDATE client SET groupe = '$nvNbPersonnes' WHERE numClient = '$numClient'" ;
        mysqli_query($this->co, $reqMajGroupe) or die(mysqli_error($this->co)) ;
    }

    public function setNumCommande($numCommande)
    {
        $numClient = $this->numClient ;
        $this->numCommande= $numCommande ;
        $reqMajNumCom = "UPDATE client SET numCommande = '$numCommande' WHERE numClient = '$numClient'" ;
        mysqli_query($this->co, $reqMajNumCom) or die(mysqli_error($this->co)) ;
    }

    public function modif_telClient($nvTelClient)
    {
        $numClient = $this->numClient ;
        $this->telClient = $nvTelClient ;
        $reqMajTelCli = "UPDATE client SET tel = '$nvTelClient' WHERE numClient = '$numClient'" ;
        mysqli_query($this->co, $reqMajTelCli) or die("erreur modification numero de tel client") ;
    }

    public function modif_mailClient($nvMailClient)
    {
        $numClient = $this->numClient ;
        $this->mailClient = $nvMailClient ;
        $reqMajMailCli = "UPDATE client SET mail = '$nvMailClient' WHERE numClient = '$numClient'" ;
        mysqli_query($this->co, $reqMajMailCli) or die("erreur modification mail du client") ;
    }
}

?>