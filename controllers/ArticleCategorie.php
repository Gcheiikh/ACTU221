<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/Categorie.php';

class ArticleCategorieController
{
    public function getArticles($categorieId = null)
    {
        $articles = array();

        $connexion = Database::getConnection();

        $categorieId = isset($_GET['categorie']) ? $_GET['categorie'] : null;
        
        $condition = ($categorieId !== null) ? "WHERE categorie = " . $categorieId : "";

        $requete = "SELECT * FROM Article " . $condition;
        $resultat = mysqli_query($connexion, $requete);

        while ($row = mysqli_fetch_assoc($resultat)) {
            $article = new Article($row['titre'], $row['contenu'], $row['categorie']);
            $articles[] = $article;
        }

        // mysqli_close($connexion);

        return $articles;
    }

    public function getCategories()
    {
        $categories = array();

        $connexion = Database::getConnection();

        $requete = "SELECT * FROM Categorie";
        $resultat = mysqli_query($connexion, $requete);

        while ($row = mysqli_fetch_assoc($resultat)) {
            $categorie = new Categorie($row['id'], $row['libelle']);
            $categories[] = $categorie;
        }

        mysqli_close($connexion);

        return $categories;
    }
}
