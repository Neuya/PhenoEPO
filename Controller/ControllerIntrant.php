<?php

require_once File::build_path(array("Model","ModelIntrant.php"));

class ControllerIntrant {
    
    
    public static function create()
    {
        $tabIntrants = ModelIntrant::getAll();
        $insertion = true;
        $controller = "intrant";
        $view = "create";
        $pagetitle = "Insertion d'intrant";
        
        require_once File::build_path(array("View","view.php"));
    }
    
    public static function created()
    {      
        $code = myGet("code");
        $type = myGet("type");
        $unite = myGet("unite");
        $intrant = new ModelIntrant($code,$type,$unite);  
        $intrant->save();
        
        $controller = "intrant";
        $view = "created";
        $pagetitle = "Intrant correctement inséré";
        
        require_once File::build_path(array("View","view.php"));
    }
    
    public static function readAll()
    {
        $tabIntrants = ModelIntrant::getAll();
        $insertion = false;
        $controller = "intrant";
        $view = "list";
        $pagetitle= "Liste des intrants";
        
        require_once File::build_path(array("View","view.php"));
    }
}
