<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ACTU 221</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
    .cardbox{
      width:1000px;
      margin-bottom:50px;
    
    }
    .news-content{
     margin-left:17%;
     margin-top:50px;
     
    }
    .news-title{
      
      width:1000px;
      margin-left:-48px;
      margin-top:-50px;
      height:70px;
    }
    .category-link  {
      font-size:20px;
      font-weight:bolder;
    }

    form {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      
     
      border-radius: 5px;
     
    }

    label {
      font-weight: bold;
      margin-bottom: 0.5rem;
    }

    input[type="text"],
    textarea {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      resize: vertical;
    }

    textarea {
      min-height: 150px;
    }

       

  </style>


</head>

<body class="bg-gray-100">
  <div id="wrapper" class="grid min-h-screen" style="grid-template-rows: auto 1fr auto;">

    <header class="bg-gray-800 p-4">
      <div class="container mx-auto">
        <h1 class="text-white font-bold text-xl">ACTU 221</h1>
      </div>
    </header>


    
   

   
    <div>  <aside class="md:col-span-1">
          <ul class="bg-white p-4 rounded-lg" style="display:flex; align-items:center;justify-content:space-between">
            <li><a href="?category=all" class="category-link text-gray-900">Toutes les catégories</a></li>
            <li>
            <?php
            // Connexion à la base de données
              $conn = new mysqli("localhost", "root", "TrapperK5/*", "mglsi_news");
            // Récupérer les catégories depuis la base de données
            $sql = "SELECT * FROM Categorie";
            $result = $conn->query($sql);
            // Vérifier s'il y a des catégories
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $category = $row['id'];
                $categoryName = $row['libelle'];
                echo '<li class="mt-2"><a href="?category=' . $category . '" class="category-link text-gray-900">' . $categoryName . '</a></li>';
              }
            } else {
              echo "Aucune catégorie trouvée.";
            }
            ?></li>
          </ul>
        </aside></div>
     
        
      


    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <main class="md:col-span-3">
        <div class="news-content">
          <?php
            // Construction de la requête SQL en fonction de la catégorie sélectionnée
            $categoryFilter = isset($_GET['category']) ? $_GET['category'] : 'all';
            $conn = new mysqli("localhost", "root", "TrapperK5/*", "mglsi_news");
            $sql = "SELECT * FROM Article";
            if ($categoryFilter !== 'all') {
              $sql .= " WHERE categorie = " . $categoryFilter;
            }
            $result = $conn->query($sql);
            // Vérifier s'il y a des articles
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo '<div class="bg-white p-5 rounded-lg cardbox">';
                echo '<div class="text-lg p-2 font-semibold text-white news-title bg-gray-700">' . $row['titre'] . '</div>';
                
              // Vérifier si l'article est en train d'etre modifié
                if (isset($_POST["edit_article"]) && $_POST["article_id"] === $row['id']) {
                  echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">';
                  echo '<input type="hidden" name="article_id" value="' . $row['id'] . '">';
               
                   echo '</form>';
                } else {
                  echo '<p class="text-gray-700">' . $row['contenu'] . '</p>';
                  echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">';
                  echo '<input type="hidden" name="article_id" value="' . $row['id'] . '">';
                  echo '<button type="submit" name="edit_article" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 mt-3 mr-2">Modifier</button>';
                  echo '<button type="submit" name="delete_article" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 mt-3">Supprimer</button>';
                  echo '</form>';
                }
                
                echo '</div>';
              }
            } else {
              echo "Aucun article trouvé.";
            }
            $conn->close();
          ?>
        </div>
      </main>
    </div>
    <div class="md:col-span-1">

<h1>Ajouter un nouvel article</h1>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <label for="titre">Titre :</label><br>
  <input type="text" name="titre" id="titre">
  <br>

  <label for="categorie">Catégorie :</label>
  <select class="form-control" name="categorie" id="categorie">
    <?php
      // Connexion à la base de données
      $conn = new mysqli("localhost", "root", "TrapperK5/*", "mglsi_news");
      // Vérifier s'il y a une erreur de connexion
      if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
      }

      // Récupérer les catégories depuis la base de données (sauf "Toutes les catégories")
      $sql = "SELECT * FROM Categorie WHERE libelle != 'Toutes les catégories'";
      $result = $conn->query($sql);
      // Vérifier s'il y a des catégories
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<option value="' . $row['id'] . '">' . $row['libelle'] . '</option>';
        }
      } else {
        echo '<option disabled>Aucune catégorie trouvée.</option>';
      }
    ?>
  </select>
  <br>

  <label for="contenu">Contenu :</label><br>
  <textarea name="contenu" id="contenu" cols="30" rows="10"></textarea>
  <br>


  <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 mt-3 mr-2" >Ajouter l'article </button>
</form>

<?php
  // Traitement du formulaire d'ajout d'article
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifier si tous les champs sont remplis
    if (isset($_POST["titre"]) && isset($_POST["categorie"]) && isset($_POST["contenu"])) {
      // Récupérer les données du formulaire
      $titre = $_POST["titre"];
      $categorie = $_POST["categorie"];
      $contenu = $_POST["contenu"];

      // Connexion à la base de données
      $conn = new mysqli("localhost", "root", "TrapperK5/*", "mglsi_news");
      // Vérifier s'il y a une erreur de connexion
      if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
      }

     

      // Requête d'insertion dans la base de données
      $sql = "INSERT INTO Article (titre, categorie, contenu) VALUES ('$titre', '$categorie', '$contenu')";

      // Exécution de la requête
      if ($conn->query($sql) === TRUE) {
        echo "Nouvel article ajouté avec succès.";
      } else {
        echo "Erreur lors de l'ajout de l'article : " . $conn->error;
      }

      // Fermer la connexion à la base de données
      $conn->close();
    } else {
      echo "Tous les champs sont obligatoires.";
    }
  }

  
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
   
    if (isset($_POST["edit_article"]) && isset($_POST["article_id"])) {
      $article_id = $_POST["article_id"];

     
      $conn = new mysqli("localhost", "root", "TrapperK5/*", "mglsi_news");
      if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
      }

      $sql = "SELECT * FROM Article WHERE id = $article_id";
      $result = $conn->query($sql);
      if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $current_contenu = $row['contenu'];

        // Afficher le formulaire de modification
        echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">';
        echo '<input type="hidden" name="article_id" value="' . $article_id . '">';
        echo '<textarea name="new_contenu" id="new_contenu" cols="30" rows="10">' . $current_contenu . '</textarea><br>';
        echo '<button type="submit" name="save_changes" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 mt-3">Enregistrer</button>';
        echo '</form>';
      } else {
        echo "Erreur lors de la récupération des données de l'article.";
      }

      
      $conn->close();
    }

    // Mettre à jour
    if (isset($_POST["save_changes"]) && isset($_POST["article_id"]) && isset($_POST["new_contenu"])) {
      $article_id = $_POST["article_id"];
      $new_contenu = $_POST["new_contenu"];

      
      $conn = new mysqli("localhost", "root", "TrapperK5/*", "mglsi_news");
      if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
      }

      $new_contenu = $conn->real_escape_string($new_contenu);
      $sql = "UPDATE Article SET contenu = '$new_contenu' WHERE id = $article_id";

      if ($conn->query($sql) === TRUE) {
        echo "Article mis à jour avec succès.";
      } else {
        echo "Erreur lors de la mise à jour de l'article : " . $conn->error;
      }

      
      $conn->close();
    }
  }

  // Suppression de L'article
 if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_article"]) && isset($_POST["article_id"])) {
          $article_id = $_POST["article_id"];

          
          $conn = new mysqli("localhost", "root", "TrapperK5/*", "mglsi_news");
          if ($conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $conn->connect_error);
          }

         
          $sql = "DELETE FROM Article WHERE id = $article_id";

          if ($conn->query($sql) === TRUE) {
            echo "Article supprimé avec succès.";
          } else {
            echo "Erreur lors de la suppression de l'article : " . $conn->error;
          }

          
          $conn->close();
        }

?>
</div>

    <footer class="bg-gray-200 p-4 text-center">
      <p>&copy; 2023 Site d'actualités. Tous droits réservés.</p>
    </footer>

  </div>
</body>

</html>
