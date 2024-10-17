<?php
// le principe du mvc est ne pas faire du SQL dans les controllers mais on fait du sql dans les models!!!
namespace App\Controllers;

use App\Models\AnnoncesModel;

class AnnoncesController extends Controller
{

    // cette méthode affichera une page listant toutes les annonces de la bdd
    public function index()
    {
        // on le dirige vers la page views annonces qui affiche le html
        // include_once ROOT . '/Views/annonces/index.php';

        // on instancie le modele corrrespondant à la table "annonces":
        $annoncesModel = new AnnoncesModel; // cette classe n'a pas de constructeur donc pas besoin de mettre les parenthèses

        // On va chercher toutes les annonces : 
        $annonces = $annoncesModel->findAll();
        // si on veut cchercher les annonces actives: 
        $annoncesActive = $annoncesModel->findBy(['actif => 1']);

        // on génère la vue:
        // $this->render('annonces/index', ['annonces' => $annonces]); pour faire le même tableau assoc il y a la métgode compact
        $this->render('annonces/index', compact("annonces"));
    }

    // méthode affiche un article
    public function lire(int $id)
    {
        // on instancie le model: 
        $annoncesModel = new AnnoncesModel;

        // on va chercher la méthode qui renvoie un article avec l'id : 
        $annonce = $annoncesModel->find($id);

        // on envoie à la vue:
        $this->render('annonces/index', compact('annonce'));
    }
}
