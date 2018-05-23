<?php

/**
 * ================================================
 * Classe qui fait le lien avec la table UE
 * ================================================
 * @author Yann ROS
 */

class ModelUE {
   
    /**
     * -----------
     * Attributs
     * -----------
     */ 
    
    private $id;
    private $idEssai;
    private $refGeno;
    private $numPlanche;
    private $numPassage;
    
    /*
     * ----------------
     * Constructeur
     * ----------------
     */
    
    public function __construct($id = NULL,$idEssai = NULL,$refGeno=NULL,$numPlanche=NULL,$numPassage=NULL)
    {
        if(!is_null($idEssai) && !is_null($refGeno) && !is_null($numPlanche) && !is_null($numPassage))
        {
            $this->id = $id;
            $this->idEssai = $idEssai;
            $this->refGeno = $refGeno;
            $this->numPlanche = $numPlanche;
            $this->numPassage = $numPassage;
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
    
    public function getIdEssai()
    {
        return $this->idEssai;
    }
    
    public function getRefGeno()
    {
        return $this->refGeno;
    }
    
    public function getNumPlanche()
    {
        return $this->numPlanche;
    }
    
    public function getNumPassage()
    {
        return $this->numPassage;
    }
    
    public function save()
    {
        $sql = "INSERT INTO "
                . "UE(id,idEssai,refGeno,numPlanche,numPassage) "
                . "VALUES (NULL,:idEssai,:refGeno,:numPlanche,:numPassage)";
        $req = Model::$pdo->prepare($sql);
        
        $values = array(
            "idEssai"=>$this->idEssai,
            "refGeno"=>$this->refGeno,
            "numPlanche"=>$this->numPlanche,
            "numPassage"=>$this->numPassage
        );
        
        $req->execute($values);
        
        return Model::$pdo->lastInsertId();
    }
    
    public static function savePlanteIndiv($idUE,$numLigne,$numPlante)
    {
        $sql = "INSERT INTO
                Plante_Indiv(idUE,numLigne,numPlante)
                VALUES (:idUE,:numLigne,:numPlante)";
        $req = Model::$pdo->prepare($sql);
        
        $values = array(
            "idUE" => $idUE,
            "numLigne" => $numLigne,
            "numPlante" => $numPlante
        );
        
        $req->execute($values);
    }
    
    public static function getAllById($idEssai)
    {
        $sql = "SELECT refGeno,numPlanche,numPassage "
                . "FROM UE "
                . "WHERE idEssai = $idEssai";
        $req = Model::$pdo->query($sql);
        $tabUE = $req->fetchAll();
        $req->closeCursor();
        return $tabUE;
    }
    
    public static function getAllUEByGeno($refGeno)
    {
        $sql = "SELECT idEssai,numPlanche,numPassage "
                . "FROM UE "
                . "WHERE refGeno = $refGeno";
        $req = Model::$pdo->query($sql);
        $tabUE = $req->fetchAll();
        $req->closeCursor();
        return $tabUE;
    }
    
    public static function nbUEGeno($refGeno)
    {
        $sql = "SELECT COUNT(*) "
                . "FROM UE "
                . "WHERE refGeno = $refGeno";
        $req = Model::$pdo->query($sql);
        $nb = $req -> fetch();
        return $nb[0];
    }
    
    public static function nbUEEssai($idEssai)
    {
        $sql = "SELECT COUNT(*) "
                . "FROM UE "
                . "WHERE idEssai=$idEssai";
        $req = Model::$pdo->query($sql);
        $nb = $req -> fetch();
        return $nb[0];
    }
    
    public static function recupCSV($csv,$idEssai)
    {
        require_once File::build_path(array("Model","ModelEssai.php"));
        
        $planteIndiv = ModelEssai::aPlanteIndiv($idEssai);
        
        echo "planteIndiv id($idEssai) : $planteIndiv";
        
        $data=[];
        
        foreach($csv as $line) 
        {
             $data[] = str_getcsv($line);
        }
        
          
        for ($i=1;$i<count($data);$i++)
        {
            $UE=$data[$i];
            $modelUE = new ModelUE(NULL,$idEssai,$UE[0],$UE[1],$UE[2]);
            $idUE = $modelUE->save();
            echo "idUE:".$idUE;
            
            if($planteIndiv)
            {
                ModelUE::savePlanteIndiv($idUE, $UE[3], $UE[4]);
            }
           
        }
    }
    
    
    
     public static function verifCSV($csv,$idEssai)
    {
        $data = [];
        
        $colonnes = 3;
        
        require_once File::build_path(array("Model","ModelEssai.php"));
        
        if(ModelEssai::aPlanteIndiv($idEssai))
        {
            $colonnes = 5;
        }
        
        foreach($csv as $line) 
          {
             $data[] = str_getcsv($line);
          }
          
           for ($i=0;$i<count($data);$i++)
          {
                $UE = $data[$i];
                
                if(count($UE)!=$colonnes)
                {
                    return false;
                }
          }
          
          return true;
    }
    
    public static function verifGenoCSV( $csv )
    {
        require_once File::build_path(array('Model',"ModelGenotype.php"));
        
        $data = [];
        
        $tab_geno_ligne = [];
        
        foreach($csv as $line) 
        {
             $data[] = str_getcsv($line);
        }
        
        for($i=1;$i<count($data);$i++)
        {
            $refGeno = $data[$i][0];
           
            
            if(!ModelGenotype::existe($refGeno))
            {
                echo $refGeno." existe po";
                $ligne = $i+1;
                $tab_geno_ligne[] = "Ligne ".$ligne." : ".$refGeno;
            }
        }
        //echo "TAILLE:".count($tab_geno_ligne);
        return $tab_geno_ligne;
    }
}
