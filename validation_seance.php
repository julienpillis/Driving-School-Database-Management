<html>
  <head><meta charset="utf-8"></head>
  <body>
    <?php
      include('connexion.php');
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      echo "<h1>Evaluer une séance </h1><br>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
      $query="SELECT * FROM seances INNER JOIN themes on seances.idtheme=themes.idtheme WHERE DateSeance <'$date' ORDER BY DateSeance";
      //echo "Requête SQL : ($query)<br>";
      $seances = mysqli_query($connect,$query);
      //on récupère la liste des séances passées et on lie la table themes avec l'id du thème correspondant

      if (!$seances){
          echo "<br>Erreur".mysqli_error($connect)."<br>";
          echo "<a href='validation_seance.php'> <input type='button' value='Retour'></a>";
      }
      else{
        echo "<FORM METHOD='POST' ACTION='valider_seance.php' >";
        echo "<table>";
        echo "<tr><td><label for='seance'>Séance à évaluer : </label></td><td><select id='seance' name='menuChoixSeance' required>";
        while ($row = mysqli_fetch_array($seances, MYSQLI_NUM))
        {

          echo "<OPTION VALUE='$row[0]'>$row[5] / $row[1] </OPTION>";

        }
        echo"</select>";
        echo "<tr><td><INPUT type='submit' value='Valider'></td><td><INPUT type='reset' value='Effacer'></td></tr>";
        echo "</table>";
        echo "</FORM>";
     }
      mysqli_close($connect);
    ?>
  </body>
</html>
