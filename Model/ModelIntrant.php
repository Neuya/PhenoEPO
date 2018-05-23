<?php


class ModelIntrant {
   
   /*
    * ----------
    * Attributs
    * ----------
    */
    
   private $code;
   private $type;
   private $unite;
   
   /*
    * -------------
    * Constructeur
    * -------------
    */
   
   public function __construct ($code = NULL, $type = NULL, $unite = NULL)
   {
       if(!is_null($code) && !is_null($type) && !is_null($unite))
       {
           $this->code = $code;
           
           $this->type = $type;
           
           $this->unite = $unite;
       }
   }
   
   /*
    * ---------
    * Getters
    * ---------
    */
   
   public function getCode()
   {
       return $this->code;
   }
   
   public function getType()
   {
       return $this->type;
   }
   
   public function getUnite()
   {
       return $this->unite;
   }
   
   /*
    * ----------------------
    * METHODES ET FONCTIONS
    * ----------------------
    */
   
   
   /**
    * 
    * Methode qui sauvegarde un objet de type ModelIntrant dans la base
    */
   
   public function save()
   {
       $sql = "INSERT INTO Type_Traitement (code,type,unite)"
               . " VALUES (:code,:type,:unite)";
       
       $req = Model::$pdo->prepare($sql);
       
       $values = array(
           "code"=>$this->code,
           
           "type"=>$this->type,
           
           "unite"=>$this->unite
       );
       
       $req->execute($values);
   }
   
   /**
    * Fonction statique qui récupère l'ensemble des infos d'un type d'intrant 
    * par son identifiant
    * 
    * @param int $id identifiant d'un intrant
    * @return objet de type ModelIntrant
    */
   
   public static function getById($id)
   {
       $sql = "SELECT * "
               . "FROM Type_Traitement"
               . " WHERE code LIKE '$id'";
       
       $req = Model::$pdo->query($sql);
       
       $req->setFetchMode(PDO::FETCH_CLASS,"ModelIntrant");
       
       $intrant = $req->fetchAll();
       
       return $intrant[0];
   }
   
   /**
    * Fonction statique qui renvoie l'ensemble des intrants présents dans 
    * la base de données
    * 
    * @return tableau d'objets ModelIntrant
    */
  
   public static function getAll()
   {
       $sql = "SELECT * FROM Type_Traitement";
       
       $req = Model::$pdo->query($sql);
       
       $req->setFetchMode(PDO::FETCH_CLASS,"ModelIntrant");
       
       $intrants = $req->fetchAll();
       
       return $intrants;
   }
   
   /**
    * Fonction statique qui permet de savoir si un intrant déterminé par son code
    * existe bien dans la base
    * 
    * @param string $code code d'intrant
    * @return boolean vrai s'il existe faux sinon.
    */
   
   public static function existe($code)
   {
       $sql = "SELECT COUNT(*) FROM Type_Traitement WHERE code LIKE '$code'";
       
       $req = Model::$pdo->query($sql);
       
       $existe = $req->fetch();
       
       $req->closeCursor();
       
       return $existe[0]>0;
   }
    
    
    
}
