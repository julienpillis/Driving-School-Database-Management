<html>
  <head><meta charset="utf-8"></head>
  <body>
    <?php
      include('connexion.php');
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      echo "<h1>Consultation d'un élève </h1><br>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
      $id=$_POST['menuChoixEleve'];
      $query="SELECT * FROM eleves WHERE ideleve='$id'";
      //echo "Requête SQL : ($query)<br>";
      $result = mysqli_query($connect,$query);  // récuperer uniquement les thèmes actifs
      if (!$result){
          echo "<br>Erreur".mysqli_error($connect)."<br>";
          echo "<a href='ajout_eleve.html'> <input type='button' value='Recommencer'></a>";
      }
      else{
        echo "Voici les informations de l'élève : <br>";
        echo "<table border=1>";
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
        {
          echo "<tr><th>Id</th><th>Nom</th><th>Prénom</th><th>Date de naissance</th><th>Date d'inscription</th></tr>";
          echo"<tr>";
          foreach ($row as $elem ){
            echo "<td class='impaire'>";
            echo $elem.' ';
            echo"</td>";
          }
          echo"</tr>";
        }
        echo "</table>";
      }
      echo "<br><a href='consultation_eleve.php'><INPUT type='button' value='Retour'></a>";
      mysqli_close($connect);
    ?>
  </body>
</html>
