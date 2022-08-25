<html>
  <head><meta charset="utf-8"></head>
  <body>
    <?php
      include('connexion.php');
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      echo "<h1>Evaluer une séance </h1><br>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
      $idseance=$_POST['menuChoixSeance'];
      $query="SELECT * FROM inscription INNER JOIN eleves on inscription.ideleve=eleves.ideleve WHERE idseance='$idseance'";//on récupère la liste des élèves inscrit à la séance
      //echo "Requête SQL : ($query)<br>";
      $eleves = mysqli_query($connect,$query);
      if (!$eleves){
          echo "<br>Erreur".mysqli_error($connect)."<br>";
          echo "<a href='validation_seance.php'> <input type='button' value='Retour'></a>";
      }
      else if(mysqli_num_rows($eleves)==0){
        echo "Aucun.e élève n'était inscrit.e à la séance.<br>";
        echo "<a href='validation_seance.php'><INPUT type='button' value='Retour'></a>";
      }
      else{
        echo "<FORM METHOD='POST' ACTION='noter_eleves.php' >";
        echo "<table border=1>";
        echo "<th>Nom</th><th>Prénom</th><th>Nombre de fautes</th>";
        $var=1;
        while ($row = mysqli_fetch_array($eleves, MYSQLI_NUM))
        {
          if($var==0){ /*si $var=0, alors la ligne est pair (elle sera de couleur grise)*/
            $val='pair';
            $var=1;
          }
          else{ /*sinon elle est impair, elle sera de couleur blanche*/
            $val='impair';
            $var=0;
          }
          echo "<tr><td class=$val>$row[4]</td><td class=$val>$row[5]</td>";
          echo "<td class=$val><input type='number'max=40 min=0 name='$row[1]' placeholder='$row[2]'></td></tr>"; //value indique la précédente note de l'élève
        }
        echo"</select>";
        echo "</table>";
        echo "<br><tr><td><INPUT type='submit' value='Mettre à jour'></td><td><INPUT type='reset' value='Effacer'></td></tr>";
        echo "<input type='hidden'value='$idseance' name='idseance'>"; //on récupère l'id de la séance pour la requête sql
        echo "</FORM>";
     }
      mysqli_close($connect);
    ?>
  </body>
</html>
