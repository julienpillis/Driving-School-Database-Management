<html>
  <head><meta charset="utf-8"></head>
  <body>
    <?php
      include('connexion.php');
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      echo "<h1>Désinscrire un.e élève d'une séance</h1><br>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
      $query="SELECT * FROM eleves";//on récupère la liste des élèves
      //echo "Requête SQL : ($query)<br>";
      $eleves = mysqli_query($connect,$query);
      if (!$eleves){
          echo "<br>Erreur".mysqli_error($connect)."<br>";
          echo "<a href='desinscription_choix_seance.php'> <input type='button' value='Recommencer'></a>";
      }
      else {
        echo "<FORM METHOD='POST' ACTION='desinscription_choix_seance.php' >";
        echo "<table>";
        echo "<tr><td><label for='eleve'>Eleve : </label></td><td><select id='eleve'name='menuChoixEleve' required>";
        while ($row = mysqli_fetch_array($eleves, MYSQLI_NUM)){
          $query="SELECT ideleve, inscription.idseance,DateSeance FROM inscription INNER JOIN seances on inscription.idseance = seances.idseance WHERE ideleve='$row[0]' AND DateSeance>'$date' ORDER BY DateSeance";
          // on récupère  la liste des séances futures auquel l'élève sélectionné est inscrit
          //echo "Requête SQL : ($query)<br>";
          $result = mysqli_query($connect,$query);
          if (!$result){
              echo "<br>Erreur".mysqli_error($connect)."<br>";
              echo "<a href='desinscription_choix_seance.php'> <input type='button' value='Recommencer'></a>";
          }
          else{
            if(mysqli_num_rows($result)>0){ // recherche si l'élève est inscrit à au moins une séance
              echo "<OPTION VALUE='$row[0]'>$row[1] $row[2]</OPTION>"; // value = idtheme (unique)
            }
            else{ // si ce n'est pas le cas, on désactive sa sélection
              echo "<OPTION disabled VALUE='$row[0]'>$row[1] $row[2] (inscrit.e à aucune séance)</OPTION>";
            }
          }
        }
        echo"</select></td></tr>";
        echo "<tr><td><INPUT type='submit' value='Selectionner'></td><td><INPUT type='reset' value='Effacer'></td></tr>";
        echo "</table>";
        echo "</FORM>";
     }
      mysqli_close($connect);
    ?>
  </body>
</html>
