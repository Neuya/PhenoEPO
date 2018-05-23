<?php

require_once File::build_path(array("Model","ModelStade.php"));

class ControllerStade {
    
    
    
    public static function readAll()
    {
        $stade = ModelStade::readAll();
        $controller = "stade";
        $view = "list";
        $pagetitle="Liste des stades";
        require_once File::build_path(array("View","view.php"));
    }
    
    public static function read()
    {
        $stade = ModelStade::getStadeById(myGet("idStade"));
        
        $controller = "stade";
        $view = "read";
        $pagetitle="Stade ".$stade->getIdStade();
        require_once File::build_path(array("View","view.php"));
        
    }
    
    public static function create()
    {
        $controller="stade";
        $view="create";
        $pagetitle="Insertion de stades";
        require_once File::build_path(array('View','view.php'));
    }
    
    public static function created()
    {
        $uploaddir = File::build_path(array('uploads')).'/';
        
        $uploadfile = $uploaddir . basename($_FILES['csvstade']['name']);
        
        move_uploaded_file($_FILES['csvstade']['tmp_name'], $uploadfile);
       
        $fichier = file($uploadfile);
        
        if(!ModelStade::verifCSV($fichier))
        {
            $tab_csv_errones[]=basename($_FILES['csvstade']['name']);
            
            $controller = "appli";
            
            $view = "erreurCSV";
            
            $pagetitle = "Erreur dans le CSV";
        }
        
        else
        {
        $tab_id_stade=ModelStade::recupCSV($fichier);
        
        $controller="stade";
        $view="created";
        $pagetitle="Stades insérés";
        }
        
        require_once File::build_path(array("View","view.php"));
    }
    
    public static function recherche()
    {
        $stade=ModelStade::search(myGet("idStade"),myGet("description"));
        $controller="stade";
        $view = "search";
        $pagetitle="Résultats de votre recherche";
        require_once File::build_path(array("View","view.php"));
    }
    
    public static function update()
    {
        $idStade = myGet("idStade");
        $stade = ModelStade::getStadeById($idStade);
        $controller="stade";
        $view="update";
        $pagetitle="Modification du stade $idStade";
        require_once File::build_path(array("View","view.php"));
        
    }
    
    public static function updated()
    {
        $description = myGet("description");
        $idStade = myGet("idStade");
        $stade = new ModelStade($idStade,$description);
        $stade->update();
        $controller="stade";
        $view = "updated";
        $pagetitle="Stade correctement modifié";
        require_once File::build_path(array("View","view.php"));
    }
}
