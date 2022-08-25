
<html>
  <head><meta charset="utf-8"></head>
  <body>
    <?php
      include('connexion.php');
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      echo "<h1>Consultation d'un élève </h1><br>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
      $query="SELECT * FROM eleves ORDER BY nom";
      //echo "Requête SQL : ($query)<br>";
      $result = mysqli_query($connect,$query);
      if (!$result){
          echo "<br>Erreur".mysqli_error($connect)."<br>";
          echo "<a href='ajout_eleve.html'> <input type='button' value='Recommencer'></a>";
      }
      else {
        echo "<FORM METHOD='POST' ACTION='consulter_eleve.php' >";
        echo "<table>";
        echo "<tr><td><label for='eleve'>Eleve : </label></td><td><select id='eleve' name='menuChoixEleve' required>";
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
        {
          echo "<OPTION VALUE='$row[0]'>$row[1] $row[2]</OPTION>"; // value = idtheme (unique)
        }
        echo "<tr><td><INPUT type='submit' value='Consulter'></td><td><INPUT type='reset' value='Effacer'></td></tr>";
        echo "</table>";
        echo "</FORM>";
     }
      mysqli_close($connect);
    ?>
  </body>
</html>
