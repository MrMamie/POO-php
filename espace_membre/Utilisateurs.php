<?php

class Utilisateurs
{

    private $erreur = [];
    private $id;
    private $nom;
    private $prenom;
    private $tel;
    private $email;

    const NOM_INVALIDE = 1;
    const PRENOM_INVALIDE = 2;
    const MAIL_INVALIDE = 3;


    public function __construct($donnees = [])
    {
        if (!empty($donnees)) {
            $this->hydrater($donnees);
        }
    }


    public function hydrater($donnees)
    {
        foreach ($donnees as $attribut => $value) {
            $methodeSetters = "set".ucfirst($attribut);
            $this->$methodeSetters($value);
        }
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of nom
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Get the value of prenom
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Get the value of tel
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function getErreur()
    {
        return $this->erreur;
    }

    public function isUserValid()
    {
        return !(empty($this->nom) || empty($this->prenom ) || empty($this->email));
    }

    /**
     * Set the value of nom
     */
    public function setNom($nom)
    {
        if (!is_string($nom) || empty($nom)) {
            $this->erreur[] = self::NOM_INVALIDE;
        } else {

            $this->nom = $nom;
        }
    }

    /**
     * Set the value of prenom
     */
    public function setPrenom($prenom)
    {

        if (!is_string($prenom) || empty($prenom)) {
            $this->erreur[] = self::PRENOM_INVALIDE;
        } else {

            $this->prenom = $prenom;
        }
    }

    /**
     * Set the value of tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }


    /**
     * Set the value of email
     */
    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            $this->erreur[] = self::MAIL_INVALIDE;
        }
    }

    /**
     * Set the value of id
     */
    public function setId($id)
    {
        if (!empty($id)) {

            $this->id = (int) $id;
        }
    }
}
