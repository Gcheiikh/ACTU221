<?php
require_once 'controllers/ArticleCategorie.php';

$articleCategorieController = new ArticleCategorieController();
$articles = $articleCategorieController->getArticles();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ACTU 221</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
      margin-left:-20px;
      margin-top:-20px;
      height:50px;
    }
    .category-link  {
      font-size:20px;
      font-weight:bolder;
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

    <div>
    <aside class="md:col-span-1" >
        <ul class="bg-white p-4 rounded-lg" style="display:flex; align-items:center;justify-content:space-between" >
            <li><a href="/InfosMVC" class="category-link text-gray-900">Toutes les catégories</a></li>
            <?php
            $categories = $articleCategorieController->getCategories();
            foreach ($categories as $categorie) {
                $idCat = $categorie->getId();
                $libCat = $categorie->getLibelle();
                echo '<li class="mt-2" ><a href="?categorie=' . $idCat . '" class="category-link text-gray-900">' . $libCat . '</a></li>';
            }
            ?>
        </ul>
        </aside>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <main class="md:col-span-3">
          
          <div class=" news-content">   
    
                <?php
                    if (!empty($articles)) {
                        foreach ($articles as $article):
                            echo '<div class="bg-white p-5 rounded-lg cardbox">';
                            echo '<div class="text-lg p-2 font-semibold text-white news-title  bg-gray-700">'.$article->getTitre().'</div>';
                            echo '<p class= "text-gray-700" > '.$article->getContenu().'</p>';
                            echo '</div>';
                        endforeach;
                    }else{
                        echo '<div class="bg-white p-5 rounded-lg cardbox">';
                            echo '<div class="text-lg p-2 font-semibold text-white news-title  bg-gray-700">'.'ACTU 221'.'</div>';
                            echo '<h1 class= "text-gray-700" > '.'Cette rubrique ne contient aucune information !'.'</h1>';
                            echo '</div>';
                    }
                ?>
             </div>
        </main>
      </div>
    </div>

   <footer class="bg-gray-200 p-4 text-center">
      <p>&copy; 2023 Site d'actualités. Tous droits réservés.</p>
    </footer>  
    

</div>
</body>
</html>
