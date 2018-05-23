<?php
require_once File::build_path(array("Model","Model.php"));


class ModelGenotype
{
    private $refGeno;
    private $espece;
    
    
    public function __construct($refGeno=NULL,$espece=NULL)
    {
        if(!is_null($refGeno) && !is_null($espece))
        {
            $this->refGeno = $refGeno;
            
            $this->espece = $espece;
        }
    }
    
    public function getRefGeno()
    {
        return $this->refGeno;
    }
    
    public function getEspece()
    {
        return $this->espece();
    }
    
    public function getGroupe()
    {
        $sql = "SELECT A.idGroupeGeno "
                . "FROM Assoc_Groupe_Geno "
                . "WHERE refGeno LIKE '$this->refGeno'";
        $req->query($sql);
        
        $groupe = $req->fetch();
        
        $req->closeCursor();
        
        return $groupe[0];
    }
    
    public static function getAll()
    {
        $sql = "SELECT G.refGeno,G.espece,A.idGroupeGeno "
                . "FROM Genotype G JOIN Assoc_Groupe_Geno A "
                . "ON A.refGeno=G.refGeno";
        
        $req = Model::$pdo->query($sql);
        
        $genotypes = $req->fetchAll();
        
        return $genotypes;
    }
    
    public static function getAllEspeces()
    {
        $sql = "SELECT DISTINCT(espece) FROM Genotype";
        
        $req = Model::$pdo->query($sql);
        
        $especes = $req->fetchAll();
        
        return $especes;
    }
    
    public static function getAllGroupes()
    {
        $sql = "SELECT id FROM Groupe_Genotype";
        $req = Model::$pdo->query($sql);
        
        $groupes = $req->fetchAll();
        
        return $groupes;
    }
    
    public function save()
    {
        $sql = "INSERT INTO Genotype(refGeno,espece) "
                . "VALUES (:refGeno,:espece)";
        
        $req = Model::$pdo->prepare($sql);
        
        $values = array(
            "refGeno"=>$this->refGeno,
            
            "espece"=>$this->espece
        );
        
        $req->execute($values);
    }
    
    public static function saveAssocGroupe($ref,$id)
    {
        $sql = "INSERT INTO Assoc_Groupe_Geno(refGeno,idGroupeGeno) "
                . "VALUES (:refGeno,:idGroupeGeno)";
        $req = Model::$pdo->prepare($sql);
        
        $values = array(
            "refGeno"=>$ref,
            "idGroupeGeno"=>$id
        );
        
        $req->execute($values);
        
    }
    
    public static function existe( $ref )
    {
        $sql = "SELECT COUNT(*) "
                . "FROM Genotype "
                . "WHERE refGeno LIKE '$ref'";
        
        $req = Model::$pdo->query($sql);
        
        $nb = $req->fetch();
        
        $req->closeCursor();
        
        return $nb[0]>0;
    }
    
    public static function existeGroupe($idGroupe)
    {
        $sql = "SELECT COUNT(*) "
                . "FROM Groupe_Genotype "
                . "WHERE id LIKE '$idGroupe'";
        
        $req = Model::$pdo->query($sql);
        
        $nb = $req->fetch();
        
        $req->closeCursor();
        
        return $nb[0]>0;
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
                $geno = $data[$i];
                
                if(count($geno)!=3  )
                {
                    return false;
                }
          }
          
          return true;
    }
    
    public static function recupCSV($csv)
    {
        $data=[];
        
        $compteurRef = 0;
        
        $compteurGroupe = 0;
        
        $tab_ref_existant = [];
        
        $tab_groupe_existant = [];
        
        foreach($csv as $line) 
        {
             $data[] = str_getcsv($line);
        }

          
        for ($i=1;$i<count($data);$i++)
        {
            $genotype=$data[$i];
            
            if( !ModelGenotype::existe( $genotype[0] ) 
                    && ModelGenotype::existeGroupe( $genotype[1] ) )
            {
                $Modelgenotype = new ModelGenotype($genotype[0],$genotype[2]);
                
                $Modelgenotype->save();
                
                ModelGenotype::saveAssocGroupe($genotype[0], $genotype[1]);
            }
            
            else
            {
                //Si le genotype existe dans la base
                if(ModelGenotype::existe($genotype[0]))
                {
                    
                    $tab_ref_existant[$compteurRef]=$genotype[0];
                    
                    $compteurRef++;
                }
                //Si le groupe n'existe pas dans la base
                if(!ModelGenotype::existeGroupe($genotype[1]))
                {
                    
                    $tab_groupe_existant[$compteurGroupe]=$genotype[1];
                    
                    $compteurGroupe++;
                }
            }
        }
    
        return $tab_ref_existant;

    }
    
    public static function findGenotype($refGeno,$espece,$idGroupe)
    {
        if( $espece == "Toutes les espèces" )
        {
            $espece = "";
        }
        
        if( $idGroupe == "Tous les groupes" )
        {
            $idGroupe = "";
        }
        
        $sql = "SELECT G.refGeno,espece,A.idGroupeGeno "
                . "FROM Genotype G JOIN Assoc_Groupe_Geno A "
                . "ON G.refGeno = A.refGeno "
                . "WHERE G.refGeno LIKE '%$refGeno%' "
                . "AND espece LIKE '%$espece%' "
                . "AND A.idGroupeGeno LIKE '%$idGroupe%'";
        
        $req = Model::$pdo->query($sql); 
        
        $genotypes = $req->fetchAll();
        
        return $genotypes;
    }
    
    
}