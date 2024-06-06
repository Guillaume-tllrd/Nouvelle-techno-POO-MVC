<?php
// on va faire une nouvelle class et elle va être dans le namespace App puisqu'elle est à la racine du dossier classes 
namespace App;

class Autoloader{
    // à l'intérieur de cette classe on fait une fonction static
    static function register(){
        // on définit une fonction spl_autoload qui va détécter les classes et à chaque fois qu'on va lancer un new Compte , new compteCourant etc. on va avoir un chargement automatique de la fonction autoload
        spl_autoload_register([
            // on va faire un tableau à 2 entrées avec la constante magique __CLASS__, qui valler chercher la classe dans lequel on se trouve et on va lancer 'autoload'
            __CLASS__,
            'autoload'
        ]);
    }
    static function autoload($class){
       // si on avait choisi d'appeler brouette au dessus on l'aurait appeler par le m^mem nom ici 
       //ici on récupère dans $class la totalité du namespace de la classe concernée(App\client\compte)
        // 1ère chose on retire App\ 
        // on va utiliser une constnte magique __NAMESPACE__ qui affiche le dossier où on se trouve on va donc retirer App\ en mettant __NAMESPACE__ \
        // on utilise la var class et la fonction str_replace auxquels on va concaténé le 1er agrument: le string que l'on cherche($search), 2ème argument c'est se par quoi on remplace donc nous rien et 3èeme argument c'est l'obj dans laquelle on va chercher les infos
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);
        echo $class; // j'ai enlevé la partie app\
       
        // mtn on va remplacer les \ par des / ça c'est pour écrire le chemin d'accés pour notre fichier:
        $class = str_replace('\\', '/', $class);
        // donc ici je vais orendre mes 2 \\ je le remplace par / dans la var $class 

        // require_once __DIR__. '/'. $class . '.php';
        // la constante magique __DIR__ sert à dire où se trouve monfichier autoloader
        // on a mtn notre chemin d'accès on peut faire notre require

        // on vérifie si le fichier existe:
        $fichier = __DIR__. '/'. $class . '.php';
        if(file_exists($fichier)){
            // si le file exist on fait le require_once de $fichier
            require_once $fichier;
        }
    } // MTN AVEC MON AUTOLOADER DES QUE JE VAIS FAIRE UN NEW IL VA ME CHARGER LE FICHIER QUI CORRESPOND a L'INTERIEUR DU DOSSIER QUI M'INTERESSE
}
