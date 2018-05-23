<?php


class ModelSemis {
    
    /**
     * -----------
     * Attributs
     * -----------
     */
    
    private $nomSemoir;
    private $densite;
    private $espace;
    
    /**
     * --------------
     * Constructeur
     * --------------
     * 
     * @param string $nom
     * @param string $densite
     * @param string $espace
     */
    
    
    public function __construct($nom = NULL,$densite = NULL,$espace = NULL)
    {
        if (!is_null($nom) && !is_null($densite) && !is_null($espace))
        {
            $this->nomSemoir = $nom;
            $this->densite = $densite;
            $this->espace = $espace;
        }
    }
    
    /**
     * --------
     * Getters
     * --------
     */
    
    public function getNom()
    {
        return $this->nomSemoir;
    }
    
    public function getDensite()
    {
        return $this->densite;
    }
    
    public function getEspace()
    {
        return $this->densite;
    }
    
    public function create()
    {
        $sql = "INSERT "
                . "INTO Type_Semis"
                . "(nomSemoir,densite,espace) "
                . "VALUES (:nomSemoir,:densite,:espace)";
        $req = Model::$pdo->prepare($sql);
        $values = array(
            "nomSemoir" =>$this->nomSemoir,
            "densite" => $this->densite,
            "espace" => $this->espace
        );
        $req->execute($values);    
    }
    
    public static function getAllNom()
    {
        $sql = "SELECT nomSemoir FROM Type_Semis";
        $req = Model::$pdo->query($sql);
        $noms = $req->fetchAll();
        $req->closeCursor();
        return $noms;
    }
    
    public static function getAllByNom($nom)
    {
        $sql = "SELECT * "
                . "FROM Type_Semis "
                . "WHERE nomSemoir LIKE '$nom'";
        $req = Model::$pdo->query($sql);
        $req->setFetchMode(PDO::FETCH_CLASS,"ModelSemis");
        $typeSemis = $req->fetchAll();
        return $typeSemis[0];   
    }
    
    
    
}
