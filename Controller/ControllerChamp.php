<?php


require_once File::build_path(array("Model","ModelChamp.php"));

class ControllerChamp
{
    
    public static function readAllChampByStation()
    {
        $tab_champ = ModelChamp::getChampByStation(myGet("idStation"));
        $station = ModelChamp::getStationById(myGet("idStation"));
        $pagetitle = "Liste des champs";
        $controller = "Champ";
        $view = "list";
        require_once File::build_path(array("View","view.php"));
    }
    
    public static function create()
    {
        $idStation = myGet("idStation");
        $inconnu = myGet("inconnu");
        
        if($inconnu==1)
        {
            $idChamp=ModelChamp::saveInconnu($idStation);
            $champ = ModelChamp::getChampById($idChamp);
            $controller="essai";
            $view="create";
            $pagetitle="Insertion d'un essai dans la station";
            
        }
        else
        {
            $tabProfondeur = ModelChamp::getAllProfondeur();
            
            $tabTypeSol = ModelChamp::getAllTypeSol();
            
            $station = ModelChamp::getStationById(myGet("idStation"));
            $controller="champ";
            $view="create";
            $pagetitle="Insertion d'un champ dans la station";
        }
        
        require_once File::build_path(array("View","view.php"));
    }
    
    public static function created()
    {
        $idStation = myGet("idStation");
        $station = ModelChamp::getStationById($idStation);
        require_once File::build_path(array("Model","ModelStation.php"));
        if ($station->aChampInconnu())
        {
            $idChampInconnu=$station->idChampInconnu();
            ModelChamp::deleteById($idChampInconnu);
        }
        
        $nom = myGet("nom");
        $longitude = myGet("longitude");
        $latitude = myGet("latitude");
        $altitude = myGet("altitude");
        $profondeur = myGet("profondeur");
        $typeSol = myGet("typeSol");
       
        $champ = new ModelChamp(NULL,$nom,$longitude,$latitude,$altitude,$typeSol,$profondeur,$idStation);
        $champ->save();
        $controller="champ";
        $view="created";
        $pagetitle="Champ inséré!";
        require_once File::build_path(array("View","view.php"));
    }
    
    public static function update()
    {
        $idChamp = myGet("idChamp");
        $idStation = myGet("idStation");
        $station = ModelChamp::getStationById($idStation);
        $champ = ModelChamp::getChampById($idChamp);
        $controller = "champ";
        $view="update";
        $pagetitle="Modification d'un champ";
        require_once File::build_path(array("View","view.php"));
    }
    
    public static function updated()
    {
        $controller="champ";
        $view="updated";
        $pagetitle="Champ modifié";
        require_once File::build_path(array("View","view.php"));
    }
    
}

