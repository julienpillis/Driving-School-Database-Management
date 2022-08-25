<html>
  <head><meta charset="utf-8"></head>
  <body>
    <?php
      include('connexion.php');
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      echo "<h1>Visualiser le calendrier d'un.e élève </h1><br>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
      $query="SELECT * FROM eleves"; //on récupère la liste des élèves
      //echo "Requête SQL : ($query)<br>";
      $eleves = mysqli_query($connect,$query);
      if (!$eleves){
          echo "<br>Erreur".mysqli_error($connect)."<br>";
          echo "<a href='visualisation_calendrier_eleve.php'> <input type='button' value='Retour'></a>";
      }
      else {
        echo "<FORM METHOD='POST' ACTION='visualiser_calendrier_eleve.php' >";
        echo "<table>";
        echo "<tr><td>Eleve : </td><td><select name='menuChoixEleve' required>";
        while ($row = mysqli_fetch_array($eleves, MYSQLI_NUM))
        {
          echo "<OPTION VALUE='$row[0]'>$row[1] $row[2]</OPTION>"; // value = idtheme (unique)
        }
        echo"</select>";
        echo "<tr><td><INPUT type='submit' value='Visualiser'></td><td><INPUT type='reset' value='Effacer'></td></tr>";
        echo "</table>";
        echo "</FORM>";
     }
      mysqli_close($connect);
    ?>
  </body>
</html>
