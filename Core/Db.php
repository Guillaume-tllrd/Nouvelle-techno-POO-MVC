<?php
// je fais une class Db pour étendre PDO 
// Je change le namespace car le ficheir est mtn dans App\core 
namespace App\Core;

// On doit importer PDO 
use PDO;
use PDOException; // pour lever les excepetion si il y en a

class Db extends PDO
{

    // Instance unique de la classe elle servira uniquement ici
    private static $instance;

    // Informations de connexion:
    private const DBHOST = 'db';
    private const DBUSER = 'test';
    private const DBPASS = "test";
    private const DBNAME = 'nouvelleTechno_MVC';

    // contrucotr mais en privée, on ne pourras pas instancier la classe elle aura unqiuement sa propre instance en instance unique
    private function __construct()
    {
        $_dsn = "mysql:dbname=" . self::DBNAME . ';host=' . self::DBHOST;

        // étant donné qu'on a éténdu PDO, on appelle le constructeur de la classe PDO
        try {
            // je vais faire des setAttribute pour paramétrer les messages d'erreur: 
            parent::__construct($_dsn, self::DBUSER, self::DBPASS);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); // ici ca veut dire que a chaque fois que je vais faire un fetch je vais le faire avec la propriété fetch_obj qui me permet d'écrire de facon objet dans les balises html
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //   ici on pourrait mettre en silence i on ne veut pas d'eerreur ici on va déclencher une exception
            // étant donné que je vais faire du PDO j'ai relié PDOexcepetion que je vais mettre en dessous. du coup je vais faire un try pour essayer de me co et ensuite un catch
        } catch (PDOException $e) {
            die($e->getMessage());
            // pour avoir un message d'erreur si jamais ca ne fonctionne pas
        }
    }

    public static function getInstance()
    {
        // permet de récupérer l'instance unique de notre classe
        // permet de générer une instance si il n'y en a pas ou de récupérer l'instance unique de notre classe: 
        if (self::$instance === null) {
            // je vais récupérer l'instance et vérifier si elle est null 
            self::$instance = new self();
            // on pourrrait faire un new db mais ici on fait new self
        }
        return self::$instance;
        // quoi qu'il arrive on retourne l'instance elle-même
    }
}
// Notre dossier db est prêt si on veut récupérer une instance de notre classe db il nous suffira de faire un DB::getInstance()