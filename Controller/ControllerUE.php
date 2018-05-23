<?php

require_once File::build_path(array("Model","ModelUE.php"));

/**
 * Description of ControllerUE
 *
 * @author Yann ROS
 */
class ControllerUE {
    
    
    public static function create()
    {
        $savedTraitement = myGet("savedTraitement");
        
        $tab_id_essais = myGet("tab_id_essais");
        
        $tab_ref_itk = myGet("tab_itk");
        
        $controller="UE";
        
        $view="create";
        
        $pagetitle="Insertion d'UE";
        
        require_once File::build_path(array("View","view.php"));
    }
    
    public static function created()
    {
        $fichiersCorrects = true;
        
        $nbFichier = myGet("compteur");
        
        $tab_ref_itk = myGet("tab_ref_itk");
        
        $tab_id_essais = myGet("tab_id_essais");
        
        $uploaddir = File::build_path(array('uploads')).'/';
        
        $tab_fichiers = [];
        
        for ($i=0;$i<$nbFichier;$i++)
        {
            $uploadfile = $uploaddir . basename($_FILES["csvUE$i"]["name"]);
            
            move_uploaded_file($_FILES["csvUE$i"]['tmp_name'], $uploadfile);
            
            $tab_fichiers[$i] = file($uploadfile);
            
            $tabIdEssai[$i] = myGet("idEssai$i");
            
            if(!ModelUE::verifCSV($tab_fichiers[$i], $tabIdEssai[$i]))
            {
                $fichiersCorrects = false;
                
                $tab_csv_errones[] = basename($_FILES["csvUE$i"]["name"]);
            }
        }
        
        if($fichiersCorrects)
        {
            
        $tab_ligne_geno = [];
        
        $tab_fichier_errone = [];
        
        for ($i=0;$i<count($tab_fichiers);$i++)
        {
            $tab_ligne_geno[] = ModelUE::verifGenoCSV($tab_fichiers[$i]);
            
            $tab_inter = serialize($tab_ligne_geno);
            
            if(count($tab_ligne_geno[$i])==0)
            {
                ModelUE::recupCSV($tab_fichiers[$i], $tabIdEssai[$i]);
            }
            else
            {   
                $tab_fichier_errone[]= basename($_FILES["csvUE$i"]["name"]);;
            }
        }
        if(count($tab_fichier_errone)==0)
        {
        $controller="UE";
        
        $view="created";
        
        $pagetitle="UE insérées";
        }
        else
        {
            $controller = "UE";
            
            $view="ErreurGeno";
            
            $pagetitle="Erreur de références";
        }
        }
        else
        {
            $controller = "appli";
            
            $view="erreurCSV";
            
            $pagetitle = "Erreur de CSV";
        }
        require_once File::build_path(array("View","view.php"));
    }
}
