<?php

/**===================================================
 * Classe qui contient l'ensemble des fonction utiles 
 * pour les requêtes à la base concernant les Champs
 * ===================================================
 */

require_once File::build_path(array("Model","Model.php"));

class ModelChamp
{
    //Attributs
    private $id;
    private $nom;
    private $longitude;
    private $latitude;
    private $altitude;
    private $typeSol;
    private $pronfondeurSol;
    private $idStation;
    
    //Constructeur
    public function __construct(  $id=NULL, $nom=NULL, $longi=NULL, $lati=NULL,
            $alti=NULL, $typeSol=NULL, $profondeur=NULL,$idStat=NULL) {
        
        if(!is_null($nom) && !is_null($longi) 
                && !is_null($lati)  && !is_null($alti)  && !is_null($idStat)
                && !is_null($profondeur) && !is_null($typeSol))
        {
            $this->id = $id;
            
            $this->nom = $nom;
            
            $this->longitude = $longi;
            
            $this->latitude = $lati;
            
            $this->altitude = $alti;
            
            $this->typeSol = $typeSol;
            
            $this->profondeurSol = $profondeur;
            
            $this->idStation = $idStat;
            
        }
    }
    
    //Getters
    public function getId()
    {
        return $this->id;
    }
    
    public function getNom()
    {
        return $this->nom;
    }
    
    public function getLatitude()
    {
        return $this->latitude;
    }
    
    public function getLongitude()
    {
        return $this->longitude;
    }
    
    public function getAltitude()
    {
        return $this->altitude;
    }
    
    public function getTypeSol()
    {
        return $this->typeSol;
    }
    
    public function profondeurSol()
    {
        return $this->pronfondeurSol;
    }     
    
    public function getIdStation()
    {
        return $this->idStation;
    }
    
    /*
     * -------------------------
     * FONCTIONS ET METHODES
     * -------------------------
     */
    
    
    /**
     * Méthode qui sauvegarde un objet de type ModelChamp dans la base.
     */
    public function save()
    {
        $sql = "INSERT "
                . "INTO Champ (id,nom,longitude,latitude,altitude,typeSol,profondeurSol,idStation) "
                . "VALUES (:id,:nom,:longitude,:latitude,:altitude,:typeSol,:profondeurSol,:idStation)";
        
        $req = Model::$pdo->prepare($sql);
        
        $values = array(
            "id"=>$this->id,
            
            "nom"=>$this->nom,
            
            "longitude"=>$this->longitude,
            
            "latitude"=>$this->latitude,
            
            "altitude"=>$this->altitude,
            
            "typeSol"=>$this->typeSol,
            
            "profondeurSol"=>$this->profondeurSol,
            
            "idStation"=>$this->idStation
        );
        
        $req->execute($values);
    }
    
    
    /**
     * Fonction statique qui récupère l'ensemble des noms des champs 
     * 
     * @return tableau avec l'ensemble des noms de champ
     */
    public static function getAllNameChamp()
    {
        $rep = Model::$pdo->query("SELECT nom FROM Champ ");
        
        $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelChamp');
        
        $tab_obj = $rep->fetchAll();
        
        return $tab_obj;
    }
    

    /**
     * Fonction statique qui renvoie l'ensemble des champs appartenant à une même station
     * 
     * @param identifiant d'une station $idStation (int)
     * @return tableau des champs appartenants à idStation
     */
    public static function getChampByStation($idStation)
    {
        $rep = Model::$pdo->query("SELECT * FROM Champ WHERE idStation =$idStation");
        
        $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelChamp');
        
        $tab_obj = $rep->fetchAll();
        
        return $tab_obj;      
    }
    
    //Recupère infos station dans laquelle est compris le champ
    public static function getStationById($idStation)
    {
        $sql = "SELECT * "
                . "FROM Station_expe"
                ." WHERE id = $idStation";
        
        $rep = Model::$pdo->query($sql);
        
        $rep->setFetchMode(PDO::FETCH_CLASS,"ModelStation");
        
        $station=$rep->fetch();
        
        return $station;
        
    }
    
    /**
     * Methode qui compte le nombre d'essais d'un objet de type ModelChamp
     * 
     * @return Int, le nombre d'essais de ce champ
     */
    
    public  function countNbEssaisChamp()
    {
        $idChamp=$this->id;
        
        $sql = "SELECT COUNT(*)"
                . " FROM Champ C"
                . " JOIN Essai E ON C.id=E.idChamp "
                . "WHERE E.idChamp=$idChamp";
        
        $rep = Model::$pdo->query($sql);
        
        $nbEssais = $rep->fetch();
        
        $rep->closeCursor();
        
        return $nbEssais[0];
    }
     
    /**
     * Fonction statique qui enregistre un champ générique dans la base
     * On considère que ce champ est inconnu de l'utilisateur,
     * il est utile pour le code mais ne sert à rien en tant que tel.
     * 
     * @param identifiant de la station dans laquelle on va enregistré le champ
     * @return type
     */
    public static function saveInconnu($idStation)
    {
        $nom="NA";
        
        $champ = new ModelChamp(NULL,$nom,1,1,1,NULL,NULL,$idStation);
        
        $champ->save();
        
        return Model::$pdo->lastInsertId();
    }
    
    /**
     * Fonction statique qui renvoie l'ensemble des infos d'un champ depuis son id
     * 
     * @param identifiant d'un champ (int)
     * @return objet ModelChamp
     * 
     */
    
    public static function getChampById($idChamp)
    {
        $sql = "SELECT * "
                . "FROM Champ "
                . "WHERE id=$idChamp";
       
        $req = Model::$pdo->query($sql);
        
        $req->setFetchMode(PDO::FETCH_CLASS, 'ModelChamp');
        
        $champ = $req->fetch();     
        
        return $champ;
    }
    
    /**
     * Methode qui met à jour un objet de type ModelChamp dans la base de données
     * 
     */
    
    public function update()
    {
        
        $sql = "UPDATE Champ "
                . "SET nom=':nom',longitude=':longitude',latitude=':latitude',altitude=':altitude,profondeurSol=:profondeur,typeSol=:typeSol' "
                . "WHERE id=:id";
        
        $req = Model::$pdo->prepare($sql);
        
        $values = array(
            "id"=>$this->id,
            "nom"=>$this->nom,
            "longitude"=>$this->longitude,
            "latitude"=>$this->latitude,
            "altitude"=>$this->altitude,
            "typeSol"=>$this->typeSol,
            "profondeur"=>$this->profondeur
        );
        
        $req->execute($values);
    }
    
    /**
     * Fonction qui supprime un champ par son identifiant dans la base
     * @param int identifiant d'un champ $idChamp
     */
    
    public static function deleteById($idChamp)
    {
        $sql = "DELETE "
                . "FROM Champ "
                . "WHERE id=$idChamp";
       
        $req = Model::$pdo->query($sql);
       
        $req->closeCursor();
       
    }
    
    /**
     * Fonction qui récupère l'ensemble des types de sols présent dans la base
     * 
     * 
     * @return $tabTypeSol tableau de String
     */
    
    public static function getAllTypeSol()
    {
        $sql = "SELECT * FROM Type_Sol";
        
        $req = Model::$pdo->query($sql);
        
        $tabTypeSol = $req->fetchAll();
        
        return $tabTypeSol;
    }
    
    public static function getAllProfondeur()
    {
        $sql = "SELECT profondeur FROM Profondeur_Sol";
        
        $req = Model::$pdo->query($sql);
        
        $tabProfondeur = $req->fetchAll();
        
        return $tabProfondeur;     
    }
   
    
    
    
    
    
}
