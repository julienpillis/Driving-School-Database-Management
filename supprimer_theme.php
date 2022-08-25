<html>
  <head><meta charset="utf-8"></head>
  <body>
    <?php
      include('connexion.php');
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      echo "<h1>Suppression d'un thème </h1><br>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
      // ATTENTION il manque les affichages et tests de debugage !!!!
      $idtheme=$_POST['menuChoixTheme'];
      $query= "UPDATE themes SET supprime='1' WHERE idtheme='$idtheme'"; // on change la valeur de supprime
      //echo "Requête SQL : ($query)<br>";
      $result = mysqli_query($connect,$query);  // récuperer uniquement les thèmes actifs
      if (!$result){
          echo "<br>Erreur".mysqli_error($connect)."<br>";

      }
      else {
        //echo "<br>$query<br>"; //affichage de la requête
        echo "Le thème a bien été supprimé.";
     }
     echo "<br><a href='suppression_theme.php'> <input type='button' value='Retour'></a>";
     mysqli_close($connect);
    ?>
  </body>
</html>
