<?php
class Article
{
    private $titre;
    private $contenu;
    private $categorie;

    public function __construct($titre, $contenu, $categorie)
    {
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->categorie = $categorie;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function getContenu()
    {
        return $this->contenu;
    }

    public function getCategorie()
    {
        return $this->categorie;
    }
}
