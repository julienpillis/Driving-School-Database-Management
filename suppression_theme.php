<html>
  <head><meta charset="utf-8"></head>
  <body>
    <?php
      include('connexion.php');
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      echo "<h1>Suppresion d'un thème </h1><br>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
      $query="SELECT * FROM themes WHERE supprime=0";
      //echo "Requête SQL : ($query)<br>";
      $result = mysqli_query($connect,$query);  // récuperer uniquement les thèmes actifs
      if (!$result){
          echo "<br>Erreur".mysqli_error($connect)."<br>";
          echo "<a href='suppression_theme.php'> <input type='button' value='Recommencer'></a>";
      }
      else {
        echo "<FORM METHOD='POST' ACTION='supprimer_theme.php' >";
        echo "<table>";
        echo "<tr><td><label for='theme'>Thème à supprimer : </label></td><td><select id='theme' name='menuChoixTheme' required>";
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
        {
          echo "<OPTION VALUE='$row[0]'>$row[1]</OPTION>"; // value = idtheme (unique)
        }
        echo "</select></td></tr>";
        echo "<tr><td><INPUT type='submit' value='Supprimer' class='deleteButton'></td><td><INPUT type='reset' value='Effacer'></td></tr>";
        echo "</table>";
        echo "</FORM>";
     }
      mysqli_close($connect);
    ?>
  </body>
</html>
