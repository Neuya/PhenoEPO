<?php

class ModelTraitement
{
   
    /**
    * -----------
    * Attributs
    * -----------
    */
    
    private $id;
    private $date;
    private $dose;
    private $idStade;
    private $codeIntrant;
    
    /*
     * ----------------
     * Constructeur
     * ----------------
     */
    public function __construct( $id = NULL, $date=NULL, $dose=NULL, 
            $idStade=NULL, $codeIntrant=NULL ) 
    {
        if (!is_null($date) && !is_null($dose) && !is_null($idStade) && !is_null($codeIntrant))
        {
            $this->id=$id;
            
            $this->date=$date;
            
            $this->dose=$dose;
            
            $this->idStade=$idStade;
            
            $this->codeIntrant=$codeIntrant;
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
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function getDose()
    {
        return $this->dose;
    }
    
    public function getIdStade()
    {
        return $this->idStade;
    }
    
    public function getcodeIntrant()
    {
        return $this->codeIntrant;
    }
    
    /**
     * Méthode qui sert à insérer un objet de type
     * ModelTraitement dans la BDD
     * 
     */
    
    public function save()
    {
        $sql = "INSERT INTO Traitement"
                . "(id,date,dose,idStade,codeIntrant) "
                . "VALUES (:id,:date,:dose,:idStade,:codeIntrant)";
        
        $req_prep = Model::$pdo->prepare($sql);
        
        $values = array(
          "id" => $this->id,
            
          "date" => $this->date,
            
          "dose" => $this->dose,
            
          "idStade" => $this->idStade,
            
          "codeIntrant" => $this->codeIntrant
        );
        
        $req_prep->execute($values);
    }
    
    /**
     * Fonction statique qui permet de récupérer l'ensemble des traitements effectués 
     * sur un même essai qualifié par son identifiant
     * 
     * @param int $idEssai indentifiant de l'essai concerné
     * @return tableau d'objet ModelTraitement
     */
    
    public static function getAllByIdEssai( $idEssai )
    {
        $sql = "SELECT date,dose,idStade,codeIntrant
                FROM Traitement T JOIN Assoc_trait_itk A
                ON T.id = A.idTrait
                WHERE A.refITK = 
                    (SELECT refITK
                     FROM Essai
                     WHERE id = $idEssai)";
        
        $req = Model::$pdo->query($sql);
        
        $req->setFetchMode(PDO::FETCH_CLASS,"ModelTraitement");
        
        $traitements = $req->fetchAll();
        
        $req->closeCursor();
        
        return $traitements;
    }
    
    /**
     * Fonction statique qui détermine si une référence ITK
     * existe bien dans la base de données.
     * 
     * @param string $refITK
     * @return boolean true si la reference existe
     */
    
    public static function existeRef( $refITK )
    {
        $sql = "SELECT COUNT(*) FROM ITK WHERE refITK LIKE '$refITK'";
        $req = Model::$pdo->query($sql);
        
        $existeRefITK = $req->fetch();
        
        $req->closeCursor();
        
        return $existeRefITK[0] > 0;
    }
    
    /**
     * Fonction statique qui détermine si des traitements on déjà étés insérés 
     * selon une référence ITK donnée. 
     * 
     * @param string $refITK référence ITK 
     * @return boolean true si des traitements on déjà étés intégrés 
     */
    
    public static function aTraitement( $refITK )
    {
        $sql = "SELECT COUNT(*) FROM Assoc_Trait_ITK WHERE refITK LIKE '$refITK'";
 
        $req = Model::$pdo->query($sql);
        
        $existeTraitITK = $req->fetch();
        
        $req->closeCursor();
        
        return $existeTraitITK[0] > 0;
    }
    
    /**
     * Fonction statique qui met à jour les valeurs d'un tuple ITK 
     * dans la base
     * caractérisé par son identifiant
     * 
     * 
     * @param int $refITK identifiant de l'ITK concerné
     * @param date $dateSemis date de Semis
     * @param string $nomSemoir le type de semoir utilisé
     * @return refITK référence de l'ITK 
     */
    
    public static function updateITK( $refITK, $dateSemis, $densite, $espace)
    {
        $sql = "UPDATE ITK "
                . "SET dateSemis = :dateSemis,"
                . "densite = :densite,"
                . "espace = :espace "
                    . "WHERE refITK LIKE '$refITK'";
        
        $req = Model::$pdo->prepare($sql);
        
        $values = [
            
            "dateSemis" => $dateSemis,
            
            "densite" => $densite,
            
            "espace" => $espace
            ];
        
        $req->execute($values);
        
        return $refITK;
    }
    
    /**
     * Fonction qui permet d'enregistrer les données en paramètre
     * dans la table association entre ITK et Traitement
     * 
     * @param String $refITK l'identifiant de l'ITK (référence)
     * @param int $idTrait l'identifiant du traitement
     */
    
    public static function saveAssocITKTrait( $refITK, $idTrait)
    {
        $sql = "INSERT INTO Assoc_Trait_ITK"
                . "(refITK,idTrait)"
                . "VALUES (:refITK,:idTrait)";
        
        $req_prep = Model::$pdo->prepare($sql);
        
        $values = array(
            "refITK" => $refITK,
            
            "idTrait" => $idTrait
       );
        
        $req_prep->execute($values);
    }
    
    /**
     * Traite les données d'un CSV de type "ITK" :
     * Insere les données du CSV dans la table Traitement
     * 
     * @return tableau avec l'ensemble des idTraitements générés (idTraitement Auto-Incrémenté)
    **/
    
    public static function recupCSV($csv)
    {
          $data = [];
          
          //Tableau des id traitement qui vont être générés
          $tab_id_trait = [];
 
          foreach($csv as $line) 
          {
             $data[] = str_getcsv($line);
          }
                   
          for ($i=1;$i<count($data);$i++)
          {
             $traitement = $data[$i];
             
            //Conversion de la date inséré pour la BDD
             $dateTraitement = date("Y-m-d", strtotime($traitement[0]));
             
             $ModelTrait = new ModelTraitement(NULL,$dateTraitement,
                        $traitement[1],$traitement[2],$traitement[3]);
             
             $ModelTrait->save();
             
             //Dernier id inséré dans la BDD
             $tab_id_trait[$i-1] = Model::$pdo->lastInsertId();
          }
 
          return $tab_id_trait;
         
    }
    
    
     public static function verifCSV($csv)
    {
        $data = [];
        
        foreach($csv as $line) 
          {
             $data[] = str_getcsv($line);
          }
          
           for ($i=0;$i<count($data);$i++)
          {
                $trait = $data[$i];
                
                if(count($trait)!=4)
                {
                    return false;
                }
          }
          
          return true;
    }
    
    public static function deleteITK($refITK)
    {
        $sql = "DELETE FROM ITK WHERE refITK LIKE $refITK";
        
        $req = Model::$pdo->query($sql);
        
        $req->fetch();
    }
    
    public static function createITK($refITK)
    {
        $sql = "INSERT INTO ITK (refITK,dateSemis,densite,espace) VALUES (:refITK,NULL,NULL,NULL)";
        
        $req = Model::$pdo->prepare($sql);
        
        $values = array(
            "refITK" => $refITK
        );
                
        $req->execute($values);
        
    }
    
    /**
     * Fonction statique qui traite un fichier CSV de type ITK
     * et qui vérifie que l'ensemble des stades indiqués dans le fichier
     * existent bien dans la BDD
     * 
     * @param Fichier CSV de type ITK $csv
     * @return tableau de l'ensemble des stades inconnus
     */
    
    public static function existeStades($csv)
    {
        require_once File::build_path(array("Model","ModelStade.php"));
        
        //Tableau des stades inconnus
        $stadesInconnu = [];
        
        $compteurStade = 0;
        
        $data = [];
 
        foreach($csv as $line) 
        {
           $data[] = str_getcsv($line);
        }
        
        for ($i=1; $i<count($data); $i++)
        {
            $traitement = $data[$i];
            
            $idStade = $traitement[2];

            if ( !ModelStade::existe($idStade) )
            {
               $stadesInconnu[$compteurStade] = $idStade;
               
               $compteurStade++;
            }
        }
        return $stadesInconnu;
          
    }
    
    /**
     * Fonction qui traite un csv et regarde si l'ensemble des codeIntrants
     * insérés existent bien dans la BDD
     * 
     * @param Fichier csv de type traitement $csv
     * @return Tableau des codes Intrants inexistants dans la base.     
     */
    public static function existeIntrants($csv)
    {
        require_once File::build_path(array("Model","ModelIntrant.php"));
         
        $intrantsInconnu = [];
        
        $data = [];
        
        $compteurIntrants=0;
 
        foreach($csv as $line) 
        {
           $data[] = str_getcsv($line);
        }
        
        for ($i=1;$i<count($data);$i++)
        {
            $traitement = $data[$i];
            
            $codeIntrant = $traitement[3];

            if (!ModelIntrant::existe($codeIntrant))
            {
               $intrantsInconnu[$compteurIntrants] = $codeIntrant;
               
               $compteurIntrants++;
            }
        }
        
        return $intrantsInconnu;
        
    }
    
    /**
     * Fonction statique qui récupère l'ensemble des années
     * insérées dans la table traitement
     * 
     * @return $annees tableau d'années
     */
    
    public static function getAllYear()
    {
        $sql = "SELECT DISTINCT YEAR(dateSemis) "
                . "FROM ITK "
                . "WHERE dateSemis IS NOT NULL ";
        
        $req = Model::$pdo->query($sql);
       
        $annees = $req->fetchAll();
        
        $req->closeCursor();
        
        return $annees;
    }
    
    public static function getRefByYear($annee)
    {
        $sql = "SELECT DISTINCT refITK "
                . "FROM ITK "
                . "WHERE YEAR(dateSemis) = $annee";
        
        $req = Model::$pdo->query($sql);
       
        $ref = $req->fetchAll();
        
        $req->closeCursor();
        
        return $ref;
    }
    
    public static function getAllByRef($refITK)
    {
        $sql = "SELECT DISTINCT(id) as idTrait,date,dose,idStade,codeIntrant
                FROM Traitement T
                WHERE T.id IN 
                (   SELECT A.idTrait
                    FROM Assoc_Trait_ITK A
                    WHERE A.refITK LIKE '$refITK' )
                GROUP BY idTrait,date,dose,idStade,codeIntrant";
        
        $req = Model::$pdo->query($sql);
        
        $req->setFetchMode(PDO::FETCH_CLASS,"ModelTraitement");
        
        $traitements=$req->fetchAll();
        
        $req->closeCursor();
        
        return $traitements;
                    
   }
   
   public static function getITKByRef($refITK)
   {
       $sql = "SELECT * FROM ITK WHERE refITK LIKE '$refITK'";
       
       $req = Model::$pdo->query($sql);
       
       $itk = $req->fetchAll();
       
       $req->closeCursor();
       
       return $itk;
   }
    
    /**
     * Fonction statique qui récupère et regroupe 
     * l'ensemble des traitements effectués 
     * sur une même année.
     * 
     * @return $traitement tableau de traitements
     **/
    
    public static function getAllByYear($annee)
    {
        $sql = "SELECT * "
                . "FROM Traitement "
                . "WHERE idTrait IN "
                . "(SELECT idTrait FROM "
                . "YEAR(Date) = $annee";
        
        $req = Model::$pdo->query($sql);
        
        $traitement = $req->fetch();
        
        $req->closeCursor();
        
        return $traitement;
    }
    
    
}

