<?php


    require_once (File::build_path(array('Controller','ControllerAppli.php')));
    require_once (File::build_path(array('Controller','ControllerEssai.php')));
    require_once (File::build_path(array('Controller','ControllerStation.php')));
    require_once (File::build_path(array('Controller','ControllerChamp.php')));
    require_once (File::build_path(array('Controller','ControllerTraitement.php')));
    require_once (File::build_path(array('Controller','ControllerStade.php')));
    require_once (File::build_path(array('Controller','ControllerIntrant.php')));
    require_once (File::build_path(array('Controller','ControllerGenotype.php')));
    require_once (File::build_path(array('Controller','ControllerUE.php')));

   function myGet($nomvar){
                    if(isset($_GET[$nomvar])){
                        return $_GET[$nomvar];
                    }
                    else if(isset($_POST[$nomvar])){
                        return $_POST[$nomvar];
                    }
                    else {
                        return NULL;
                    }
            } 
        
         
       
        
	// On recupère l'action passée dans l'URL
	if(!is_null(myGet('action'))){
		$action = myGet('action'); 
	}
	else{
		$action='accueil';
    
	} 
        
        if(!is_null(myGet('controller'))){
		$controller = myGet('controller'); 
	}
	else{
		$controller='Appli';
	} 
        
        if($action=='accueil' && $controller=='Appli'){
            ControllerAppli::accueil();
            if($action=="insertion")
            {
                
            }
        }
        
                    
        else{         
            $controller_class='Controller'.$controller;
            $tab_class=get_class_methods($controller_class); 
            if(class_exists($controller_class)){
                if(in_array($action,$tab_class)){
                        $controller_class::$action();
                    }
                    else{
                        //$controller_class::error();
                    }

            }

            else{
                ControllerAppli::accueil();
            }
        }
        
        

?>