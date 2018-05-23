<?php

require_once File::build_path(array("Model","Model.php"));


class ModelStation{
    
     /**
     * -----------
     * Attributs
     * -----------
     */
    
    private $id;
    private $nom;
    private $longitude;
    private $latitude;   
    private $ville;
    private $pays;
    
    
    
    /*
     * ----------------
     * Constructeur
     * ----------------
     */
    
    public function __construct( $id=NULL, $nom=NULL, $longi=NULL, $lati=NULL,
            $ville=NULL, $pays=NULL ) 
    { 
        
        if(!is_null($nom) && !is_null($longi) 
                && !is_null($lati) && !is_null($ville) && !is_null($pays))
        {
            $this->id = $id;
            
            $this->nom = $nom;
            
            $this->longitude = $longi;
            
            $this->latitude = $lati;
            
            $this->ville = $ville;
            
            $this->pays = $pays;
        }
    }
    
    /**
     * ---------------------
     * Getters
     * ---------------------
    */
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getNom()
    {
        return $this->nom;
    }
    
    public function getLongitude()
    {
        return $this->longitude;
    }
    
    public function getLatitude()
    {
        return $this->latitude;
    }
    
    public function getVille()
    {
        return $this->ville;
    }
    
    public function getPays()
    {
        return $this->pays;
    }
    
    public function save()
    {
        $sql = "INSERT INTO Station_expe (id,nom,longitude,latitude,ville,pays) "
                . "VALUES (:id,:nom,:longi,:lati,:ville,:pays)";
        
        $req=Model::$pdo->prepare($sql);
        
        $values = array(
            "id"=>$this->id,
            
            "nom"=>$this->nom,
            
            "longi"=>$this->longitude,
            
            "lati"=>$this->latitude,
            
            "ville"=>$this->ville,
            
            "pays"=>$this->pays
        );
        
        $req->execute($values);
    }
    
    //Renvoi les données de toutes les station de la BDD
     public static function getAllStation()
    {
        $rep = Model::$pdo->query("SELECT * FROM Station_expe");
        
        $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelStation');
        
        $tab_obj = $rep->fetchAll();
        
        return $tab_obj;
    }
    
    //Renvoi toutes les données sur les champs d'une station donnée
    public function getAllChampsStation()
    {
        $rep = Model::$pdo->query("SELECT * FROM Champ WHERE idStation =$this->id");
        
        $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelChamp');
        
        $tab_obj = $rep->fetchAll();
        
        return $tab_obj; 
    }
    
    //Renvoie le nombre de champs dans une station donnée
    public function countChampsStation()
    {
        $idStation=$this->id;
        
        $sql="SELECT COUNT(C.id)"
                . " FROM Champ C "
                . "JOIN Station_expe S ON C.idStation = S.id "
                . "WHERE S.id=$idStation";
        
        $rep = Model::$pdo->query($sql);
        
        $nbChamps = $rep->fetch();
        
        $rep->closeCursor();
        
        return $nbChamps[0];
    }
    
    //Renvoie tous les pays des stations présentes dans la base de données.
      public static function getPaysStations()
    {
        $sql = "SELECT DISTINCT pays"
                . " FROM Station_expe";
        
        $rep = Model::$pdo->query($sql);
       
        $pays = $rep->fetchAll();   
        
        $rep->closeCursor();
        
        return $pays;
    }
    
    //Fonction de recherche pour l'ensemble des stations présentes dans la BDD
    public static function findStations($nomStation,$paysStation)
    {
        if($paysStation=="Tous les pays")
        {
            $paysStation="";
        }
        
        $sql = "SELECT * "
                . "FROM Station_expe "
                . "WHERE nom LIKE '%$nomStation%' AND pays LIKE '%$paysStation%'";
        
        $rep = Model::$pdo->query($sql);
        
        $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelStation');
        
        $tab_stations = $rep->fetchAll();     
        
        return $tab_stations;
    }
    
    public function aChampInconnu()
    {
          $sql = "SELECT nom "
                    . "FROM Champ "
                    . "WHERE idStation = $this->id";
            
          $req=Model::$pdo->query($sql);
            
            $nomChamp = $req->fetch();
            
            $req->closeCursor();
            
            if ($nomChamp[0]=="NA")
            {
               return true;
            }
           
            return false;
    }
    
    public function idChampInconnu()
    {
        $sql = "SELECT id "
                . "FROM Champ"
                . " WHERE idStation = $this->id";
        
        $req = Model::$pdo->query($sql);
        
        $idChamp = $req->fetch();
        
        $req->closeCursor();
        
        return $idChamp[0];
    }
    
    public function aChamp()
    {
        $sql = "SELECT COUNT(*) "
                . "FROM Champ "
                . "WHERE idStation = $this->id";
        
        $req = Model::$pdo->query($sql);
        
        $nbChamps = $req->fetch();
        
        $req->closeCursor();
        
        if ($nbChamps[0]==0)
        {
            return false;
        }
        
        if($nbChamps[0]==1)
        {
        
           if($this->aChampInconnu())
           {
               return false;
           }
           
           else
           { 
               return true;
           }
                   
        }
        
        return true;
    }
    
    
    
}

