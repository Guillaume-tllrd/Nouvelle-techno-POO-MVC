<?php
// c'est la création d'un model pour une table particulière
namespace App\Models;
// comme on est dans le namespace ModelS on a pas besoin du use :
// use App\Models\Model;
// la classe Model est accessible par héritage à AnnoncesModel
class AnnoncesModel extends Model
{
    protected $id;
    protected $titre;
    protected $description;
    protected $created_at;
    protected $actif;
    protected $users_id;
    // On a mis du protected donc on doit faire du getter et setter 


    // cette classe va avoir un constructor, trè simple: 
    public function __construct()
    {
        $this->table = "annonces";
    }
    // mtn je peux inbterroger ma bdd et récupérer toutes les annonces 

    // les getter and setter: pck on a mis du protected et donc on ne peut pas y accéder en direct

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getTitre()
    {
        return $this->titre;
    }
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getCreated_at()
    {
        return $this->created_at;
    }
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getActif()
    {
        return $this->actif;
    }
    public function setActif($actif)
    {
        $this->actif = $actif;
        return $this;
    }

    public function getUsers_id(): int
    {
        return $this->users_id;
    }
    public function setUsers_id(int $users_id)
    {
        $this->users_id = $users_id;
        return $this;
    }

    // le return $this, va servir a permettre de créer les différentes informations directement depuis notre instance de Model 
}
