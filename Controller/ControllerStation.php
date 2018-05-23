<?php

require_once (File::build_path(array('Model','ModelStation.php')));

class ControllerStation
{
    
    
    public static function readAll()
    {
        $tab_station = ModelStation::getAllStation();
        $pagetitle = "Liste des stations";
        $controller="Station";
        $view="list";
        require File::build_path(array('View','view.php'));
        
    }
    
    public static function create()
    {
        $pagetitle="Insertion d'une station";
        $controller="station";
        $view="create";
        require File::build_path(array('View','view.php'));
    }
    
    public static function created()
    {
        $nom = myGet("nom");
        $ville=myGet("ville");
        $pays=myGet("pays");
        $longi=myGet("longi");
        $lati=myGet("lati");
        
        $station = new ModelStation(NULL,$nom,$longi,$lati,$ville,$pays);
        $station->save();
        
        $pagetitle="Station insérée";
        $controller="station";
        $view="created";
        
        require File::build_path(array("View","view.php"));
    }
    
    public static function recherche()
    {
        $nomStation = rawurldecode(myGet('nomStation'));
        $paysStation = rawurldecode(myGet('paysStation'));
        
        $tab_station = ModelStation::findStations($nomStation,$paysStation);
        $pagetitle="Résultats de votre recherche";
        $controller="station";
        $view="search";
        require File::build_path(array("View","view.php"));
    }
    
  
    
    
}

