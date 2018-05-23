<?php


class ControllerAppli {

    public static function accueil(){
                    
                    $pagetitle="Bienvenue!";
                    $controller="appli";
                    $view="Accueil";
                    require File::build_path(array("View","view.php"));
                }
     
    public static function insertion()
    {
        $pagetitle="Insertion dans la base";
        $controller="appli";
        $view = "insertion";
        require File::build_path(array("View","view.php"));
                
    }
    
    public static function consulter()
    {
        $pagetitle="Choisissez l'action à effectuer";
        $controller="appli";
        $view="consulter";
        require File::build_path(array("View","view.php"));
    }
}