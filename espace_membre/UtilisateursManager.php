<?php

class UtilisateursManager
{
    private $bddPDO;

    public function __construct(PDO $bddPDO)
    {
        $this->bddPDO = $bddPDO;
    }

    public function inserer(Utilisateurs $utilisateur)
    {
        $requete = $this->bddPDO->prepare("INSERT INTO utilisateurs(nom,prenom,tel,email) VALUES (:nom,:prenom,:tel,:email)");
        $requete->bindValue(":nom",$utilisateur->getNom());
        $requete->bindValue(":prenom",$utilisateur->getPrenom());
        $requete->bindValue(":tel",$utilisateur->getTel());
        $requete->bindValue(":email",$utilisateur->getEmail());
        $requete->execute();
    }

    public function mAj(Utilisateurs $utilisateur)
    {
        $requete = $this->bddPDO->prepare("UPDATE utilisateurs SET nom= :nom, prenom= :prenom, tel=:tel,email=:email WHERE id=:id");
        
        $requete->bindValue(":id",$utilisateur->getId(),PDO::PARAM_INT);

        $requete->bindValue(":nom",$utilisateur->getNom());
        $requete->bindValue(":prenom",$utilisateur->getPrenom());
        $requete->bindValue(":tel",$utilisateur->getTel());
        $requete->bindValue(":email",$utilisateur->getEmail());
        $requete->execute();
    }

    public function getListeUtilisateur()
    {
        $requete = $this->bddPDO->query("SELECT * FROM utilisateurs ORDER BY nom ASC");
        $requete->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Utilisateurs');
        $listeUtilisateurs = $requete->fetchAll();
        $requete->closeCursor();
        return $listeUtilisateurs;
    }

    public function getUtilisateur($id)
    {
        $requete = $this->bddPDO->prepare("SELECT * FROM utilisateurs WHERE id = :id");
        $requete->bindValue('id',(int)$id,PDO::PARAM_INT);
        $requete->execute();
        $requete->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Utilisateurs');
        $utilisateur = $requete->fetch();
        return $utilisateur;
    }

    public function supprimer($id)
    {
        $requete = $this->bddPDO->prepare("DELETE FROM utilisateurs WHERE id = :id");
        $requete->bindValue(":id",$id,PDO::PARAM_INT);
        $requete->execute();
    }

    public function count()
    {
    }
}
