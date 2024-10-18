<?php
// je met le namespace en premier pour ne pas avoir de pb avec le model:
namespace App\Models;

// UsersModel qui est la classe qui nous permet d'accéder à la table users dans la bdd
class UsersModel extends Model
{
    protected $id;
    protected $email;
    protected $password;

    public function __construct()
    {
        $this->table = 'users';
    }

    // on créer une méthode spécifique pour récupérer l'user à partir de son email pour la connexion : 
    // elle est spécifique à userModel c'est our ça qu'on la met ici et pas dans MOdel
    public function findOneByEmail(string $email)
    {
        return $this->requete('SELECT * FROM $this->table WHERE email = ?', [$email])->fetch(); // on fait passer dans un tableau notre email puisque notre methode requete demande dans 1er paramètre un string et un 2eme parametre optionnel un array d'attributs
    }
    // faire les getter settrer (accesseur):
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }
}
