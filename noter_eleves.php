<html>
  <head><meta charset="utf-8"></head>
  <body>
    <?php
      include('connexion.php');
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      echo "<h1>Evaluer une séance </h1><br>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
      $idseance=$_POST['idseance'];
      $query="SELECT * FROM inscription INNER JOIN eleves on inscription.ideleve=eleves.ideleve WHERE idseance='$idseance'";//on récupère la liste des élèves
      //echo "Requête SQL : ($query)<br>";
      $eleves = mysqli_query($connect,$query);
      if (!$eleves){
          echo "<br>Erreur".mysqli_error($connect)."<br>";
          echo "<a href='desinscription_choix_seance.php'> <input type='button' value='Recommencer'></a>";
      }
      else{
        while ($row = mysqli_fetch_array($eleves, MYSQLI_NUM)) // on réalise la modification de la note pour chaque élève inscrit à la séance
        {
          if(!empty($_POST["$row[1]"])){
            $note =$_POST["$row[1]"]; // on récupère la note du formulaire de valider_seance.php

            $query = "UPDATE inscription SET note='$note' WHERE ideleve='$row[1]' AND idseance='$idseance'";
            //echo "Requête SQL : ($query)<br>";
            $update = mysqli_query($connect,$query); // on modifie la note en fonction de l'id de l'élève et de la séance
            if (!$update){
                echo "<br>Erreur".mysqli_error($connect)."<br>";
            }
          }
        }
        mysqli_close($connect);
        if ($eleves){
          echo "Les notes ont été mises à jour !";
        }
     }
      echo "<br><a href='validation_seance.php'><INPUT type='button' value='Retour'></a>";
    ?>
  </body>
</html>
