<?php

class BD {
    private $host ;
    private $user ;
    private $bdd ;
    private $passwd ;
    private $co ;

    function __construct($bdd)
    {
        $this->host = "localhost" ;
        $this->user = "root" ;
        $this->bdd = $bdd ;
        $this->passwd = "" ;
    }

    public function connexion()
    {
        $this->co = mysqli_connect($this->host , $this->user , $this->passwd, $this->bdd) or die(mysqli_connect_error()) ;
        mysqli_set_charset($this->co, "UTF-8") ;
        return $this->co ;
    }

    public function getCo()
    {
        return $this->co ;
    }

    public function deconnexion()
    {
        mysqli_close($this->co) ;
    }
}

?>