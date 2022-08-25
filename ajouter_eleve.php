<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <?php
      echo "<h1>Ajout d'un.e élève </h1><br>";
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      include('connexion.php');
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');

      mysqli_set_charset($connect, 'utf8');
      $query="SELECT * FROM eleves WHERE nom='".mysqli_escape_string($connect,$_POST['nom'])."' AND prenom='".mysqli_escape_string($connect,$_POST['prenom'])."';";
      //echo "Requête SQL : ($query)<br>";
      $result = mysqli_query($connect,$query); //requête pour récuperér la liste des élèves ayant les mêmes nom et prénom
      if (!$result){
          echo "<br>Erreur".mysqli_error($connect)."<br>";
          echo "<a href='ajout_eleve.html'> <input type='button' value='Recommencer'></a>";
      }
      else if(mysqli_num_rows($result)==0){ //test homonyme (ici on traite le cas négatif)
        $query = "insert into eleves values (NULL,'".mysqli_escape_string($connect,$_POST['nom'])."','".mysqli_escape_string($connect,$_POST['prenom'])."','".mysqli_escape_string($connect,$_POST['dn'])."','$date');";//on insère l'élève
        //echo "Requête SQL : ($query)<br>";
        $result = mysqli_query($connect,$query);
        if (!$result){
            echo "<br>Erreur".mysqli_error($connect)."<br>";
            echo "<a href='ajout_eleve.html'> <input type='button' value='Recommencer'></a>";
        }
        else{
          echo "Elève ajouté !<br>";
          echo "<a href='ajout_eleve.html'> <input type='button' value='Recommencer'></a>";
        }
      }

      else{
        echo "ATTENTION HOMONYME!<br>";
        echo "Confirmez-vous l'ajout de l'élève ?<br>";
        echo "<FORM METHOD='POST' ACTION='valider_eleve.php' >";
        echo "<input type='hidden' name='nom' value='".mysqli_escape_string($connect,$_POST['nom'])."'>";
        echo "<input type='hidden' name='prenom' value='".mysqli_escape_string($connect,$_POST['prenom'])."'>";
        echo "<input type='hidden' name='dn' value='".$_POST['dn']."'>";
        echo "<input type='submit' name='validite' value='oui' >";
        echo "<input type='submit' name='validite' value='non'>";
        echo "</form>";
      }
      mysqli_close($connect);
    ?>
  </body>
</html>
