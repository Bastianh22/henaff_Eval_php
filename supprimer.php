<?php
    require('functions.php');
    // vérifie si les informations continent un élément
    if(isset($_GET['link_id']))
    {
        // récupere les éléments passé en paramètre puis les assigne à une variable
        $link_id = htmlspecialchars($_GET['link_id']);

        // envoie les informations à la fonction insertDepense du fichier function
        $execute = delete_link($link_id);

        // vérifie si la fonction c'est executer correctement
        if($execute == true) 
        {
            echo "<div>Vous avez supprimé un lien</div>";
            header('Refresh: 5; url=index.php');
        }
        else
        {
            echo 'Echec de la connection';  
        }
    }
?>