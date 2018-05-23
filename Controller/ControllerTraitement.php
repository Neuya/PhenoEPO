<?php

require_once (File::build_path(array('Model','ModelTraitement.php')));
require_once (File::build_path(array('Model','ModelEssai.php')));
require_once (File::build_path(array("Model","ModelStade.php")));
require_once (File::build_path(array("Model","ModelIntrant.php")));

class ControllerTraitement
{
    
    public static function create()
    {       
        
        $tab_ref_itk = unserialize(myGet("tab_itk"));
              
        $tab_id_essais = (myGet("tab_id_essais"));
       
        $tabIntrants = ModelIntrant::getAll();
        
        
        
        $controller="traitement";
        $view = "create";
        $pagetitle = "Insertion de traitements";
        require_once(File::build_path(array('View','view.php')));        
    }
    
    public static function createExistant()
    {
        require_once (File::build_path(array('Model','ModelTraitement.php')));
        require_once (File::build_path(array('Model','ModelEssai.php'))); 
        
        $tab_id_essais = unserialize(myGet("tab_id_essais"));
        
        $tab_ref_itk = myGet("tab_ref_itk");
        
        $tab_annees = ModelTraitement::getAllYear();
        
        $controller = "traitement";
        $view = "createExistant";
        $pagetitle = "Insertion d'ITK existants";
        require_once File::build_path(array("View","view.php"));
    }
    
    public static function createdExistant()
    {
        
        $tab_id_essais = unserialize(myGet("tab_id_essais"));
            
        $tab_ref_itk = myGet('tab_ref_itk');
        
        $tab_ref  = [];
         
        $create = false;
        
        $tab_ref_inconnu = [];
        
        for ($i=0;$i<myGet("compteur");$i++)
        {
            $refITK = myGet("ref$i");
            
            $tab_ref[] = $refITK;
            
            if(isset($_POST["check$i"]))
            {
                $create = true;
                
                //  ModelTraitement::deleteITK($refITK);
                if(!ModelTraitement::existeRef($refITK))
                {
                ModelTraitement::createITK($refITK);
                }
                
                ModelEssai::updateRefITK($refITK,$tab_id_essais[$i]);
                
            }
            
            if(!(isset($_POST["check$i"]) || ModelTraitement::aTraitement($tab_ref[$i])))
            {
              $tab_ref_inconnu[] = $tab_ref[$i] ;
            }
                
        }
          
        if(count($tab_ref_inconnu)>0)
        {
            $controller = "traitement";
            
            $view = "erreurCreatedExistant";
            
            $pagetitle = "Erreur dans les références";
                
        }
        else if ($create)
        {
            $tab_ref_itk = [];
             
            for ($i=0;$i<count($tab_id_essais);$i++)
            {
                $tab_ref_itk[] = ModelEssai::getById($tab_id_essais[$i])->getRefITK();
                
            }
            
            $tabIntrants = ModelIntrant::getAll();
            
            $insertion = true;
            
            $controller = "traitement";
            
            $view = "create";
            
            $pagetitle = "traitements insérés";

        }
        else
        {
            $tab_id_essais = serialize($tab_id_essais);
            
            $controller = "traitement";
            
            $view = "created";
            
            $pagetitle="Traitements insérés";
        }
        
        
        require_once File::build_path(array("View","view.php"));
        
    }
    
    public static function readAll()
    {
        $idEssai = myGet("idEssai");
        $traitements = ModelTraitement::getAllByIdEssai($idEssai);
        
        $controller="traitement";
        $view="list";
        $pagetitle = "Liste des traitements effectués sur l'essai";
        require_once File::build_path(array("View","view.php"));
        
    }
    
    public static function readAllITK()
    {
        $tab_annees = ModelTraitement::getAllYear();
        $controller="traitement";
        $view = "listITK";
        $pagetitle = "Liste de l'ensemble des itinéraires techniques";
        require_once File::build_path(array("View","view.php"));
        
    }
    
    public static function createdStadeInconnu()
    {
        $uploaddir = File::build_path(array('uploads')).'/';
        
        $uploadfile = $uploaddir . basename($_FILES['csvstade']['name']);
        
        move_uploaded_file($_FILES['csvstade']['tmp_name'], $uploadfile);
       
        $fichier = file($uploadfile);
        
        ModelStade::recupCSV($fichier);
        
        
        $controller="traitement";
        $view = "createdStade";
        $pagetitle = "Stades insérés";
        require_once(File::build_path(array('View','view.php')));      
    }
    
    public static function createdIntrantInconnu()
    {
         for ($i=0;$i<myGet("nombreIntrants");$i++)
        {
            $code = myGet("code$i");
           
            $type = myGet("type$i");
           
            $unite = myGet("unite$i");
            
            $intrant = new ModelIntrant($code,$type,$unite);  
            
            $intrant->save();
        }
        
        
        
        $controller="traitement";
        $view="createdIntrant";
        $pagetitle="Intrants insérés";
        
        require_once (File::build_path(array("View","view.php")));
        
    }
    
    public static function created()
    {
        $tab = myGet("tab_itk");
        $tab_itk = unserialize($tab);
        $uploaddir = File::build_path(array('uploads')).'/';
        $tab_fichiers = [];
        $tabStadesInconnus = [];        
        $tabIntrantsInconnus = [];
        $aStadeInconnu = false;
        $aIntrantInconnu = false;
        $fichiersCorrects = true;
        $tab_csv_errones = [];

        $controller = "traitement";
        
        for ($i=0;$i<count($tab_itk);$i++)
        {
            $uploadfile = $uploaddir . basename($_FILES["csvITK$i"]["name"]);
            
            move_uploaded_file($_FILES["csvITK$i"]['tmp_name'], $uploadfile);
            
            $tab_fichiers[$i] = file($uploadfile);
        }
        
        for ($i=0;$i<count($tab_itk);$i++)
        {
            if (!ModelTraitement::verifCSV($tab_fichiers[$i]))
            {
                $tab_csv_errones[] =  basename($_FILES["csvITK$i"]["name"]);
                
                $fichiersCorrects = false;
            }
        }
        
        if($fichiersCorrects)
        {
        for ($i=0;$i<count($tab_itk);$i++)
        {  
            $tabStadesInconnus[$i] = ModelTraitement::existeStades($tab_fichiers[$i]);
            $tabIntrantsInconnus[$i] = ModelTraitement::existeIntrants($tab_fichiers[$i]);
            if(!empty($tabStadesInconnus[$i]))
            {
                $aStadeInconnu = true;
            }
            if(!empty($tabIntrantsInconnus[$i]))
            {
                $aIntrantInconnu = true;
            }
        }    
        
       
        if(!($aStadeInconnu) && !($aIntrantInconnu))
        {
            for ($i=0;$i<count($tab_itk);$i++)
            {
                 if(!ModelTraitement::aTraitement($tab_itk[$i]))
                 {
                    $tab_id_trait=ModelTraitement::recupCSV($tab_fichiers[$i]);
                    $dateSemis=myGet("dateSemis$i");      
                    $densite = myGet("densite$i");
                    $espace = myGet("espace$i");
                 
                    $id_ITK=ModelTraitement::updateITK($tab_itk[$i],$dateSemis,$densite,$espace);
            
                    for ($j=0;$j<count($tab_id_trait);$j++)
                    {
                     ModelTraitement::saveAssocITKTrait($tab_itk[$i], $tab_id_trait[$j]);
                    }
                 }
            }
                  
            $view="created";
            $pagetitle="Traitements insérés";
            
        }
        
        else 
        {
            $pagetitle = "Erreur dans le csv";
            if ($aStadeInconnu)
            {
                $view = "createdErreurStade";  
            }
            if ($aIntrantInconnu)
            {
                $tabIntrants=ModelIntrant::getAll();
                $insertion = true;
                $view = "createdErreurIntrant";
            }
        }
        $tab_id_essais=(myGet("tab_id_essais"));
        
        $tab_ref_itk = serialize($tab_itk);
        }
        else
        {
            $controller="appli";
            
            $view="erreurCSV";
            
            $pagetitle="Erreur dans le(s) CSV";
        }
        require_once(File::build_path(array('View','view.php')));
    }
    
    public static function readAllYear()
    {
        
        $annees = ModelTraitement::getAllYear();
        
        $controller = "traitement";
        $pagetitle = "Sélectionnez une année";
        $view = "allYear";
        require_once (File::build_path(array('View','view.php')));
    }
    
    public static function readAllByYear()
    {
        $traitement = ModelTraitement::getAllByYear(myGet("annee"));
        
        $controller = "traitement";
        $pagetitle = "Selectionnez une année";
        $view = "allByYear";
        
        require_once (File::build_path(array("View","view.php")));
        
    }
    
    
    
}

