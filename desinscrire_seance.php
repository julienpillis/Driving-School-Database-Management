<html>
  <head><meta charset="utf-8"></head>
  <body>
    <?php
      include('connexion.php');
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      echo "<h1>Désinscrire un.e élève </h1><br>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
      $ideleve = $_POST['ideleve'];
      $idseance = $_POST['menuChoixSeance'];
      $query="DELETE FROM inscription WHERE ideleve='$ideleve' AND idseance='$idseance'";
      //echo "Requête SQL : ($query)<br>";
      $supp = mysqli_query($connect,$query); //supprime l'inscription de l'élève à la séance correspondante
      if (!$supp){
          echo "<br>Erreur".mysqli_error($connect)."<br>";
      }
      else{
      echo "L'élève n'est plus inscrit à la séance.<br>";
      }
      echo "<a href='desinscription_seance.php'> <input type='button' value='Retour'></a>";
      mysqli_close($connect);
    ?>
  </body>
</html>
