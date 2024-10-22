<?php
// le principe du mvc est ne pas faire du SQL dans les controllers mais on fait du sql dans les models!!!
namespace App\Controllers;

use App\Core\Form;
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

    // cette méthode va me permettre d'ajouter une annonce
    // d'abord il faut un user connecté
    public function ajouter()
    {
        // on vérifie si l'utilisateur est connecté
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            // l'utilisaeteur est connecté
            // on vérifie si le formulaire est complet cad avec on verifie dans post si il y a titre et description
            if(Form::validate($_POST, ['titre', 'description'])){
                // le form est complet
                // on doir se protéger contre les failles xss(strips_tags, htmlspecialchars)
                $titre = strip_tags($_POST['titre']);
                $description = strip_tags($_POST['description']);

                // on instancie notre modèle
                $annonce = new AnnoncesModel;

                // on hydrate, comme on a titre et description sous forme de var et pas sous forme de array on utilise les getter et setter
                $annonce->setTitre($titre)
                        ->setDescription($descritpion)
                        ->setUsers_id($_SESSION['user']['id']);

                        // on enregistre
                        $annonce->create();

                        // on redirige
                        $_SESSION['message'] = "Votre annonce a été enregistré avec succès";
                        header('Location: /');
                        exit;

            } else {
                // le form est incomplet, pour qu'on puisse garder un des si jamais l'un des input est vide, il faut également rajouter la valeur de $titre et $description dans le $form. on peut également rajouter un message mais par contre il faut que le post soit pas vide sinon ça envoie directement un message au chargemenrt de la page
                $_SESSION['error']= !empty($_POST) ? "Le formulaire est incomplet" : "";
                $titre = isset($_POST['titre']) ? strip_tags($_POST['titre']) :'';
                $description = isset($_POST['description']) ? strip_tags($_POST['description']) : "";
            }
            $form = new Form;

            $form->debutForm()
                ->ajoutLabelFor('titre', "Titre de l'annonce : ")
                ->ajoutInput('text', 'titre', [
                    'id' => 'titre',
                     'class' => 'form-control',
                     'value' => $titre
                     ])
                ->ajoutLabelFor('description', "Texte de l'annonce")
                ->ajoutTextarea('description', $description, ['id' => 'description', 'class' => 'form-control'])
                ->ajoutBouton('Ajouter', ['class' => 'btn btn-primary'])
                ->finForm();

                // on envoie à la vue :
                $this->render('annonces/ajouter', ['form' => $form-create()])
        }else {
            $_SESSION['error'] = "Vous devez être connecté pour accéder à cette page";
            header('Location: users/loigin');
            exit;
        }
    }

    // pour modifier une annonce: 
    public function modifier(int $id){
        // on vérifie si l'utilisateur est connecté
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            // on vérifie si l'annonce existe dans la bdd
            // on instancie notre modèle:
            $annoncesModel = new AnnoncesModel;

            // on cherche l'annonce avec l'idi $id:
            $annonce-> $annoncesModel->find($id);

            // si l'annonce n'existe pas, on retourne à la sliste des annonces
            if(!$annonce){
                http_response_code(404);
                $_SESSION['error']="L'annonce recherchée n'existe pas";
                header("Location: /annonces");
                exit;
            }

            // mtn on doit vérifier si l'annonce appartien à l'user:
                // on peut faire ->users_id même si c'est protected car $annonce est un objet qui nous soret du find et pas du model
                if($annonce->users_id !== $_SESSION['user']['id']){
                    $_SESSION['error'] = "Vous n'avez pas accès à cette page";
                    header('Location:/annonces');
                    exit;
                }

                // On traite le formulaire  
                if(Form::validate($_POST, ['titre', 'description'])){
                    // on se protège contte les fails xss 
                    $titre = strip_tags($_POST['titre']);
                    $description = strip_tags($_POST['description']);

                    // on stocke l'annonce: 
                    // on a déja une var anonnce qui provient de la bdd donc on fait une var annonceModif sinon on écrase l'annonce déjà existente:
                    $annonceModif = new AnnoncesModel;

                    // on hydrate en donnant d'abord l'id 
                    $annonceModif->setId($annonce->id)
                            ->setTitre($titre)
                            ->setDescription($description);

                    // On met à jour l'annonce
                    $annonceModif->update();

                    // on redirige
                    $_SESSION['message'] = "Votre annonce a été modifiée avec succès";
                    header('Location: /');
                    exit;
                }

                // on peut faire mtn notre formulaire:
                    // on reprend le même formulaire d'ajouter, la seule différence c'est qu'on doit ajoputer la valeur à chaque inout, donc j'ajoute un attribut value où je lui passe le ltitre de l'annonce, pour la textearea j'ajoute à la place de la chaine vide
                    $form = new Form;

                    $form->debutForm()
                        ->ajoutLabelFor('titre', "Titre de l'annonce : ")
                        ->ajoutInput('text', 'titre', [
                            'id' => 'titre', 
                            'class' => 'form-control',
                            'value' => $annonce->titre 
                            ])
                        ->ajoutLabelFor('description', "Texte de l'annonce")
                        ->ajoutTextarea('description', $annonce->description, ['id' => 'description', 'class' => 'form-control'])
                        ->ajoutBouton('Modifier', ['class' => 'btn btn-primary'])
                        ->finForm();

                        // on envoie à la vue: 
                        $this->render('annonces/modifier', ['form' => $form->create()]);



        } else {
            $_SESSION['error'] = "Vous devez être connecté pour accéder à cette page";
            header('Location: users/loigin');
            exit;
        }


    }
}
