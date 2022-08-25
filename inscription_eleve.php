<html>
  <head><meta charset="utf-8"></head>
  <body>
    <?php
      include('connexion.php');
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      echo "<h1>Inscription d'un élève à une séance </h1><br>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8

      $query1="SELECT * FROM eleves";//on récupère la liste des élèves
      $eleves = mysqli_query($connect,$query1);
      //echo "Requête SQL : ($eleve)<br>";
      $query2="SELECT idseance, nom, DateSeance, EffMax FROM seances INNER JOIN themes on seances.idtheme=themes.idtheme  WHERE DateSeance >'$date' ORDER BY DateSeance;";//on recupère les séances futures
      $futures_seances = mysqli_query($connect,$query2);
      //echo "Requête SQL : ($futures_seances)<br>";
      if (!$eleves OR !$futures_seances){
          echo "<br>Erreur".mysqli_error($connect)."<br>";
          echo "<a href='inscription_eleve.html'> <input type='button' value='Recommencer'></a>";
      }
      else{ // affichage des élèves, et des séances futures 
        echo "<FORM METHOD='POST' ACTION='inscrire_eleve.php' >";
        echo "<table>";
        echo "<tr><td><label for='eleve'>Eleve : </label></td><td><select id='eleve' name='menuChoixEleve' required>";
        while ($row = mysqli_fetch_array($eleves, MYSQLI_NUM))
        {
          echo "<OPTION VALUE='$row[0]'>$row[1] $row[2]</OPTION>"; // value = eleve (unique)
        }
        echo"</select>";
        echo "<tr><td><label for='seance'>Séance : </label></td><td><select id='seance' name='menuChoixSeance' required >";
        while ($row = mysqli_fetch_array($futures_seances, MYSQLI_NUM))
        {
          $verif = mysqli_query($connect,"SELECT * FROM inscription WHERE idseance='$row[0]';"); // récupération des élèves inscrit à la séance
          if (!$verif){
              echo "<br>Erreur".mysqli_error($connect)."<br>";
              echo "<a href='ajout_eleve.html'> <input type='button' value='Recommencer'></a>";
          }
          else if(mysqli_num_rows($verif)< $row[3]){ // on compare le nombre d'elève inscrit et l'effectif max de la séance
            echo "<OPTION VALUE='$row[0]'>$row[1] / $row[2]</OPTION>";
          }
          else{
              echo "<OPTION disabled VALUE='$row[0]'>$row[1] / $row[2] (Séance pleine)</OPTION>";
          }

        }
        echo"</select>";
        echo "<tr><td><INPUT type='submit' value='Inscrire'></td><td><INPUT type='reset' value='Effacer'></td></tr>";
        echo "</table>";
        echo "</FORM>";
      }
      mysqli_close($connect);
    ?>
  </body>
</html>
