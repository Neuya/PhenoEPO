<?php

require_once File::build_path(array("Model","ModelEssai.php"));

class ControllerEssai{
    
    
    
    public static function create()
    {
        $champ = ModelEssai::getChamp(myGet("idChamp"));
        
        $pagetitle="Insertion d'essais";
        $controller="Essai";
        $view="create";
        require_once(File::build_path(array("View","view.php")));
        
    }
    
    public static function createdPlante()
    {        
        $idChamp = myGet("idChamp");
        $uploaddir = File::build_path(array('uploads')).'/';
        
        $uploadfile = $uploaddir . basename($_FILES['csvessai']['name']);
        
        move_uploaded_file($_FILES['csvessai']['tmp_name'], $uploadfile);
       
        $fichier = file($uploadfile);
        
        if(!ModelEssai::verifCSV($fichier))
        {
            $tab_csv_errones[] = basename($_FILES['csvessai']['name']);
            
            $controller="appli";
            
            $view = "erreurCSV";
            
            $pagetitle="Erreur dans le CSV";
        }
        else
        {
        $tab_ref_itk = serialize(ModelEssai::recupRefCSV($fichier)); 
        
        $tab_id_essais = serialize(ModelEssai::recupCSV($fichier,$idChamp));
          
        
        $controller = "essai";
        
        $view = "createdPlante";
        
        $pagetitle="Faites un choix";
        }
        require_once File::build_path(array("View","view.php"));
    }
    
    public static function created()
    {
        
        $tab_ref_itk = myGet("tab_ref_itk");
        
        $tab_id_essais = unserialize(myGet("tab_id_essais"));

        for($i=0;$i<count($tab_id_essais);$i++)
        {
            if(isset($_POST["check$i"]))
            {
                ModelEssai::getById($tab_id_essais[$i])->updatePlante();
            }
        }
        
        $tab_id_essais=serialize($tab_id_essais);
       
        $pagetitle="Insertion effectuée";
        $justsave = "essai";
      
        $controller="Essai";
        $view="created";
        require_once File::build_path(array("View","view.php"));
        
    }
    
    public static function readAllByChamp()
    {
        $tab_essai = ModelEssai::getAllEssaiByChamp(myGet('idChamp'));
        $controller="Essai";
        $pagetitle="Liste des essais";
        $view="listbychamp";
        require_once(File::build_path(array("View","view.php")));   
    }
}

