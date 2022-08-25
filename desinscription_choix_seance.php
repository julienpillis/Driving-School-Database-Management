<html>
  <head><meta charset="utf-8"></head>
  <body>
    <?php
      include('connexion.php');
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      echo "<h1>Désinscrire un.e élève d'une séance</h1><br>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
      $ideleve=$_POST['menuChoixEleve'];
      $query="SELECT inscription.idseance, nom, DateSeance FROM inscription INNER JOIN seances INNER JOIN themes on inscription.idseance=seances.idseance AND seances.idtheme=themes.idtheme WHERE ideleve='$ideleve' AND DateSeance>'$date' ORDER BY DateSeance";
      //on récupère la liste des séances futures auquelles l'élève est inscrit
      $futures_seances = mysqli_query($connect,$query);
      //echo "Requête SQL : ($query)<br>";

      if (!$futures_seances){
          echo "<br>Erreur".mysqli_error($connect)."<br>";
          echo "<a href='desinscription_choix_seance.php'> <input type='button' value='Recommencer'></a>";
      }
      else if(mysqli_num_rows($futures_seances)==0){ // vérification si l'élève n'est inscrit à aucune séance
        echo "L'élève n'est inscrit.e à aucune séance.<br>";
        echo "<a href='desinscription_seance.php'> <input type='button' value='Retour'></a>";
      }
      else{ //sinon on propose de le désinscrire aux séances où il est déjà inscrit
        echo "<FORM METHOD='POST' ACTION='desinscrire_seance.php' >";
        echo "<table>";
        echo "<tr><td><label for='seance'>Seance: </label></td><td><select id='seance' name='menuChoixSeance' required>";
        while ($row = mysqli_fetch_array($futures_seances, MYSQLI_NUM))
        {

            echo "<OPTION VALUE='$row[0]'>$row[1] / $row[2]</OPTION>";

        }
        echo "</select></td></tr><br>";
        echo "<input type='hidden' value='$ideleve' name ='ideleve'<br>";
        echo "<tr><td><INPUT type='submit' class='DeleteButton' value='Désinscrire'></td><td><INPUT type='reset' value='Effacer'></td></tr>";
        echo "</table>";
        echo "</FORM>";
      }
      mysqli_close($connect);
    ?>
  </body>
</html>
