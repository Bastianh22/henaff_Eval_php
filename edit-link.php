<?php 
  require("functions.php");

  // vérifie si l'utilisateur click sur le bouton 'Ajouter'
  if(isset($_POST['submit']))
  {
    // vérifie si les input continent des éléments
    if(isset($_POST['title'], $_POST['url']))
    {
      // récupere les éléments passé en paramètre puis les assigne à une variable
      $title = htmlspecialchars($_POST['title']);
      $url = htmlspecialchars($_POST['url']);

      $data = ['title' => $title, 'url' => $url]; 
      
      // envoie les informations à la fonction connect dans le fichier function puis les assigne à une variable
      $enregistrement = update_link($data);
      if($enregistrement == true)
      {
        echo 'Vous avez modifié un lien';
        header('Refresh: 5; url=index.php');
      }
    }
  }
  if(isset($_GET['link_id']))
  {
    $link_id = htmlspecialchars($_GET['link_id']);
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Link manager</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
      crossorigin="anonymous"
    />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;600&display=swap"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <link rel="stylesheet" href="./assets/css/style.css" />
  </head>
  <body>
    <header class="pt-5 mb-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <h1 class="display-4 text-center">Gestionnaire de liens utiles</h1>
          </div>
        </div>
      </div>
    </header>
    <main>
      <div class="container h-100">
        <div class="row justify-content-center h-50">
          <div class="col-md-6 shadow p-3 pt-5">
            <?php
              $links = get_link_by_id($link_id);
              foreach($links as $link)
              {
                ?>
                  <h2 class="mb-3">Éditer le lien # <?=$link['link_id']?></h2>
                  <div class="mb-3">
                    <form action="" method="post">
                      <div class="mb-3">
                        <div class="form-floating">
                          <input type="text" class="form-control" id="title" name="title" value="<?= $link['title']?>"/>
                          <label for="title">Titre</label>
                        </div>
                      </div>
                      <div class="mb-3">
                        <div class="form-floating">
                          <input type="url" class="form-control" id="url" name="url" value="<?= $link['url']?>"/>
                          <label for="url">Lien</label>
                        </div>
                      </div>
                      <div class="col-md-auto d-flex">
                        <button class="btn btn-primary btn-lg">Enregister</button>
                      </div>
                    </form>
                  </div>
                <?php
              }
            ?>
          </div>
        </div>
      </div>
    </main>
    <footer class="shadow">&copy; 2022 La Manu</footer>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
<?php
}
else
{
    header('Location: index.php');
}
?>