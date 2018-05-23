<?php

require_once File::build_path(array("Model","Model.php"));

class ModelEssai
{
    
    //Attributs
    
    private $id;
    private $nom;
    private $nbPlanches;
    private $nbPassages;
    private $longueurPlanche;
    private $largeurPassage;
    private $nbLignes;
    private $latitude;
    private $longitude;
    private $refITK;
    private $idChamp;    
    
    
    //Constructeur
    
    public function __construct(
            $id = NULL, $nom=NULL, $nbPl = NULL, $nbPa=NULL, $longueurPl=NULL, 
            $largPa=NULL, $nbL = NULL, $longiEssai=NULL,
            $latiEssai=NULL, $refITK=NULL, $idC=NULL)
    {
        if(!is_null($nbPl) && !is_null($nom) && !is_null($nbPa) && !is_null($longueurPl) 
                && !is_null($nbL) && !is_null($largPa) && !is_null($longiEssai)
                        && !is_null($latiEssai) && !is_null($refITK) && !is_null($idC))
        {
            $this->id=$id;
            $this->nom=$nom;
            $this->nbPlanches=$nbPl;
            $this->nbPassages=$nbPa;
            $this->longueurPlanche=$longueurPl;
            $this->nbLignes=$nbL;
            $this->largeurPassage=$largPa;
            $this->latitude=$latiEssai;
            $this->longitude=$longiEssai;
            $this->refITK=$refITK;
            $this->idChamp=$idC;
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
    
     public function getNbPlanches()
    {
        return $this->nbPlanches;
    }
     public function getNbPassages()
    {
        return $this->nbPassages;
    }
     public function getNbLignes()
    {
        return $this->nbLignes;
    }
    
     public function getLongueurPlanche()
    {
        return $this->longueurPlanche;
    }
    
    public function getLargeurPassage()
    {
        return $this->largeurPassage;
    }
     public function getLatitude()
    {
        return $this->latitude;
    }
    
     public function getLongitude()
    {
        return $this->longitude;
    }
    
     public function getrefITK()
    {
        return $this->refITK;
    }
     public function getIdChamp()
    {
        return $this->idChamp;
    }
    
   
    
    /*
     * -----------------------------
     *     METHODES ET FONCTIONS
     * -----------------------------
     */
    
    
    public static function getById($idEssai)
    {
        $sql = "SELECT * FROM Essai WHERE id = $idEssai";
        
        $req = Model::$pdo->query($sql);
        
        $req->setFetchMode(PDO::FETCH_CLASS,"ModelEssai");
        
        $essais = $req->fetchAll();
        
        return $essais[0];
    }
    
    /*
     * Méthode qui récupère la ville et le pays dans lesquels se situe un essai
     * @param Objet de type ModelEssai
     * @return tableau contenant ville et pays
     */
    
    public function getVilleEtPays()
    {
        $sql = "SELECT ville,pays "
                . "FROM Station_expe S "
                . "WHERE id = "
                . "(SELECT idStation "
                . " FROM Champ"
                . " WHERE id = "
                . "     (SELECT idChamp "
                . "      FROM Essai "
                . "      WHERE id=$this->id))";
        
        $req = Model::$pdo->query($sql);
        
        $donnees = $req->fetchAll();
        
        return $donnees[0];
    }
    
    /**
     * Fonction qui détermine s'il y a déja eu des UE d'insérées dans l'essai
     * 
     * @return boolean
     */
    
    public static function existeUE()
    {
        $sql = "SELECT COUNT(*) 
                FROM UE 
                WHERE idEssai =".$this->idEssai;
        
        $req = Model::$pdo->query($sql);
        
        $nb = $req->fetch();
        
        return $nb[0]>0;
    }
    
    
    /**
     * Méthode qui enregistre un objet de type ModelEssai dans la BDD
     */
    public function save()
    {
        $sql = "INSERT INTO Essai (id,nom,nbPlanches,nbPassages,longueurPlanche,largeurPassage,nbLignes,"
                . "latitude,longitude,refITK,idChamp) "
                . "VALUES (:id,:nom,:nbPl,:nbPa,:longPl,:largPa,:nbL,:latitudeEssai,:longiEssai,:refITK,:idCh)";
        
        $req_prep = Model::$pdo->prepare($sql);
        
        $values = array(
          "id" => $this->id,
            
          "nom" =>$this->nom,
            
          "nbPl" => $this->nbPlanches,  
            
          "nbPa" => $this->nbPassages,  
            
          "longPl" => $this->longueurPlanche,
            
          "largPa" => $this->largeurPassage, 
            
          "nbL" => $this->nbLignes,  
            
          "latitudeEssai" => $this->latitude,  
            
          "longiEssai" => $this->longitude, 
            
          "refITK" => $this->refITK,  
            
          "idCh" => $this->idChamp  
        );
        
        $req_prep->execute($values);
    } 
    
    /**
     * Fonction statique qui récupère l'ensemble des essais effectués dans un champ donné
     * 
     * @param (int) identifiant d'un champ $idC
     * @return tableau d'objets ModelEssai
     */
    
    public static function getAllEssaiByChamp($idC)
    {
        $rep = Model::$pdo->query("SELECT * FROM Essai WHERE idChamp =$idC");
        
        $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelEssai');
        
        $tab_obj = $rep->fetchAll();
        
        return $tab_obj;    
    }
    
    /**
     * Fonction statique qui renvoie les essais qui ont le même ITK
     * 
     * @param int $refITK identifiant d'un itinéraire technique
     * @return tableau d'objets ModelEssai
     */
    
    public static function getEssaisByITK($refITK)
    {
        $sql = "SELECT * "
                . "FROM Essai "
                . "WHERE refITK LIKE '$refITK'";
        
        $req = Model::$pdo->query($sql);
        
        $req->setFetchMode(PDO::FETCH_CLASS,"ModelEssai");
        
        $essais = $req -> fetchAll();
        
        return $essais;
    }
     
    /**
     * Fonction statique qui Traite un CSV de type "Essai" et insère les données présentes dans la BDD
     * Utilisée dans ControllerEssai fonction created()
     * 
     * @param $csv : fichier CSV de type ESSAI, $idC identifiant d'un champ
     * @return $tab_id_itk l'ensemble des id ITK qui se sont génerés dans la base au moment des insertions
     */
    
    public static function recupCSV($csv,$idC)
    {
          require_once File::build_path(array("Model","ModelTraitement.php"));
          
          //Tableau qui sert à récupérer les données du CSV          
          $data = [];
          
          $tab_id_essais = [];
          
          foreach($csv as $line) 
          {
             $data[] = str_getcsv($line);
          }
  
          for ($i=1;$i<count($data);$i++)
          {
                $essai = $data[$i];
             
                $modelEssai = new ModelEssai(NULL,$essai[0],$essai[1],
                          $essai[2],$essai[3],$essai[4],$essai[5],$essai[6],$essai[7],$essai[8],$idC);
            
                $modelEssai->save();
                
                $tab_id_essais[] = Model::$pdo->lastInsertId();
          }
          
          return $tab_id_essais;
                                        
    }
    
    public static function recupRefCSV($csv)
    {
          require_once File::build_path(array("Model","ModelTraitement.php"));
          
          //Tableau qui sert à récupérer les données du CSV          
          $data = [];
          
          //tableau des reférences itk du CSV inséré
          $tab_ref_itk = [];
          
          $tab_ref_itk[0] = "";
          
          //tableau qui contiendra les différents identifiants ITK
          $tab_ref_itk_diff = [];
          
          $compteurRef = 0; 
          
          foreach($csv as $line) 
          {
             $data[] = str_getcsv($line);
          }
          
          for ($i=1;$i<count($data);$i++)
          {
                $essai = $data[$i];
              
                //Si la référence ITK n'est jamais apparu dans le CSV
                //$essai[8] est la colonne des ref ITK
                if(!in_array($essai[8],$tab_ref_itk))
                {
                    $refITK = $essai[8];
                    
                    //Si la refITK n'existe pas dans la base
                    if(!ModelTraitement::existeRef( $refITK ))
                    {
                    
                        //On enregistre temporairement un ITK
                        ModelEssai::saveITK($essai[8]);
                    }
                    
                    //On stocke la reference dans notre tableau de references d'itk
                    $tab_ref_itk_diff[$compteurRef]=$refITK;
                  
                    $compteurRef++;
                }
                
                //On récupère la ref ITK
                $tab_ref_itk[$i-1]=$essai[8];
             
          }        
         
          return $tab_ref_itk_diff;
    }
    
    public static function recupNomCSV($csv)
    {
        //Tableau qui sert à récupérer les données du CSV          
          $data = [];
          
          $tab_nom_essais = [];
          
          foreach($csv as $line) 
          {
             $data[] = str_getcsv($line);
          }
          
           for ($i=1;$i<count($data);$i++)
          {
                $essai = $data[$i];
                
                $tab_nom_essais[] = $essai[0];
              
          }
          
          return $tab_nom_essais;
    }
    
    
    /**
     * Fonction statique qui récupère l'ensemble des infos d'un champ
     * 
     * @param (int) identifiant d'un champ
     * @return Objet de type ModelChamp
     */
    public static function getChamp($idChamp)
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
     * Fonction statique utilisée dans la fonction recupCSV qui sauvegarde un 
     * tuple dans la table ITK temporairement
     * 
     * @param string $refITK référence ITK de l'utilisateur insérée dans son CSV.
     * @return $refITK référence ITK
     */
    public static function saveITK($refITK)
    {
        $sql = "INSERT INTO ITK"
                . "(refITK,dateSemis,densite,espace)"
                ."VALUES (:refITK,:dateSemis,:densite,:espace)";
        
        $req_prep = Model::$pdo->prepare($sql);
        
        $values = array(
            "refITK" => $refITK,
            
            "dateSemis"=>NULL,
            
            "densite"=>NULL,
            
            "espace" => NULL
        );
        
        $req_prep->execute($values);
        
        
        return $refITK;
    }

    //Fonction qui renvoi un tableau ne contenant que des éléments distincts
    //Utile pour distinguer les différents refITK insérés dans le CSV de type "Essai"
    //NB : a déplacer dans Model.php
    
    public static function ElementsDiffTab($tab)
    {
        $tabelem = [];
        $compteur = 1;
        $tabelem[0]=$tab[0];
        for ($i=1;$i<count($tab);$i++)
        {
            if(!in_array($tab[$i], $tabelem))
            {
                $tabelem[$compteur]=$tab[$i];
                $compteur++;
            }
        }
        return $tabelem;
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
                $essai = $data[$i];
                
                if(count($essai)!=9)
                {
                    return false;
                }
          }
          
          return true;
    }
    
    public static function updateRefITK($ref,$id)
    {
        $sql = "UPDATE Essai SET refITK = '$ref' WHERE id = $id";
        
        $req = Model::$pdo->prepare($sql);
        
        $req->execute();
        
    }
    
    public function updatePlante()
    {
        $this->nom = $this->nom . " (Plantes Individuelles)";
        
        $sql = "UPDATE Essai SET planteIndiv = 1,nom='$this->nom' WHERE id=$this->id";
        
        $req = Model::$pdo->prepare($sql);
        
        $req->execute();
    }
    
    public static function aPlanteIndiv($id)
    {
        $sql = "SELECT planteIndiv
                FROM Essai
                WHERE id=$id;";
        
        $req = Model::$pdo->query($sql);
        
        $plante = $req->fetch();
        
        
        return $plante[0] == 1;
    }
    
    public function aUE()
    {
        $sql = "SELECT COUNT(*) FROM UE WHERE idEssai = $this->id";
        
        $req = Model::$pdo->query($sql);
        
        $nb = $req->fetch();
        
        return $nb[0]>0;
    }
}

