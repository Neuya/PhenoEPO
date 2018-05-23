 <?php

 
 /**
  * ======================================================================================
  * Classe qui fait lien avec la base de données
  * Dans l'ensemble des classes Model* elle est utilisé afin d'effectuer des requêtes sql
  * Nécessite modification de /Config/Conf.php avec les 
  * identifiants corrects afin de se connecter à la base
  * ======================================================================================
  */
 

require(__DIR__."/../Config/Conf.php");
 
class Model {

    public static $pdo;
    
    /**
     * Fonction qui initialise la connexion avec la base de données
     * Si échec il y a, un message d'erreur s'affiche.
     * Les paramètres utilisés sont présents dans Conf.php.
     */

    public static function Init() {
        $hostname = Conf::getHostname();
        $database_name = Conf::getDatabase();
        $login = Conf::getLogin();
        $password = Conf::getPassword();

        try 
        {
            self::$pdo = new PDO( "mysql:host=$hostname;dbname=$database_name",
                    $login, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" ));
            
            self::$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch ( PDOException $e ) 
        {      
            echo $e->getMessage(); // affiche un message d'erreur
            
            die();
        }
    }

}

//La fonction est lancé dans l'ensemble des classes Model afin d'initialiser la connexion à la base. 
Model::Init();
?>
