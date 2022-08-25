<html>
  <head><meta charset="utf-8"></head>
  <body>
    <?php
      include('connexion.php');
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      echo "<h1>Ajout d'une séance </h1><br>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
      $query="SELECT * FROM themes WHERE supprime=0 ORDER BY nom"; // on récupère les themes actifs
      //echo "Requête SQL : ($query)<br>";
      $result = mysqli_query($connect,$query);  // récuperer uniquement les thèmes actifs
      if (!$result){
          echo "<br>Erreur".mysqli_error($connect)."<br>";
          echo "<a href='ajout_seance.html'> <input type='button' value='Recommencer'></a>";
      }
      else {
        echo "<FORM METHOD='POST' ACTION='ajouter_seance.php' >";
        echo "<table>";
        echo "<tr><td><label for='theme'>Thème : </label></td><td><select id='theme'name='menuChoixTheme' required>";
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
        {
          echo "<OPTION VALUE='$row[0]'>$row[1]</OPTION>"; // value = idtheme (unique)
        }
        echo "</select></td></tr>";
        echo "<tr><td><label for='eff'>Effectif :</label></td><td><input id='eff' type='number' min=0 name='eff' required></td></tr>";
        echo "<tr><td><label for='dt'>Date de la séance :</label></td><td><input id='dt' type='date' name='dateSeance' min=$date required ></td></tr>"; //Pas de séance avant aujourd'hui
        echo "<tr><td><INPUT type='submit' value='Enregistrer'></td><td><INPUT type='reset' value='Effacer'></td></tr>";
        echo "</table>";
        echo "</FORM>";
      }
      mysqli_close($connect);
    ?>
  </body>
</html>
