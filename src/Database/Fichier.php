<?php

namespace App\Database;

/**
 * A quoi sert cette class?
 * Les objets de la class Fichier représentent les données de la table "fichier"
 * 1 instance = 1 ligne
 */
class Fichier
{
    /*
    * PHP 7.4 et +
    *       private ?int $id = null;
    * PHP < 7.4:
    *       private $id;
    */
    private ?int $id = null;
    private ?string $nom = null;
    private ?string $nom_original = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * self désigne la classe actuelle
     * @return self retourne l'objet actuel
     */
    

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getNomOriginal(): ?string
    {
        return $this->nom_original;
    }

    public function setNomOriginal(string $nom_original): self
    {
        $this->nom_original = $nom_original;
        return $this;
    }
    
}