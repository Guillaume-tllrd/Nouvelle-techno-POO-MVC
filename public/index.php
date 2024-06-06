<?php
use App\Autoloader;
use App\Core\Main;

// ce fichier sera le fichier centrale de notre dossier et sera uniquement là pour lancer le routeur, c'est ce fichier qui sera interroger a chaque fois que l'on va charger une page
// on va définir une constante contenant le dpossier racine du projet
// je déclare ROOT et doit symboliser le dossier NOUVELLE TECHNO POO MVC et non public 
define('ROOT', dirname(__DIR__)); // ça me donne le chemin d'accès directement du dossier complet

// on importe l'autoloader:
require_once ROOT. '/Autoloader.php';
Autoloader::register();

// On instancie Main (qui sera le routeur)
$app = new Main();

// start sera la méthode du routeur pour démarrer
// on démarre l'application
$app->start();

// ce fichier est terminé je n'y touche plus c'est le fichier d'entrée de l'application , il appele main(le routeur), à chaque fois que l'on va appeler une page on va passer par index.php et ça enmenera les infos sur le routeur . on crée le main dans Core qui lira les URL
