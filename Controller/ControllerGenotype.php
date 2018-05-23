<?php


/**
 * Description of ControllerGenotype
 *
 * @author Yann ROS
 */


require_once File::build_path(array("Model","ModelGenotype.php"));
class ControllerGenotype {
    
    public static function readAll()
    {
        $especes = ModelGenotype::getAllEspeces();
        $groupes = ModelGenotype::getAllGroupes();
        $genotypes = ModelGenotype::getAll();
        $controller="genotype";
        $view = "list";
        $pagetitle="Liste des génotypes";
        require_once File::build_path(array("View","view.php"));
    }
    
    public static function create()
    {
        $controller="genotype";
        $view="create";
        $pagetitle="Insertion de génotypes";
        require_once File::build_path(array("View","view.php"));
    }
    
    public static function created()
    {
        $uploaddir = File::build_path(array('uploads')).'/';
        
        $uploadfile = $uploaddir . basename($_FILES['csvgeno']['name']);
        
        move_uploaded_file($_FILES['csvgeno']['tmp_name'], $uploadfile);
       
        $fichier = file($uploadfile);
        
        if(!ModelGenotype::verifCSV($fichier))
        {
            $tab_csv_errones[] = basename($_FILES['csvgeno']['name']);
            
            $controller="appli";
            
            $view = "erreurCSV";
            
            $pagetitle = "Erreur dans le CSV";
        }
        
        else
        {
        ModelGenotype::recupCSV($fichier);
        
        $controller="genotype";
        $view="created";
        $pagetitle="Données insérées";
        
        }
        require_once File::build_path(array("View","view.php"));
    }
    
    public static function recherche()
    {
        $especes = ModelGenotype::getAllEspeces();
        $groupes = ModelGenotype::getAllGroupes();
        $genotypes = ModelGenotype::findGenotype(myGet("refGeno"),myGet("espece"),myGet("groupeGeno"));
        
        $controller="genotype";
        $view = "search";
        $pagetitle ="Résultats de votre recherche";
        require_once File::build_path(array("View","view.php"));
    }
}
