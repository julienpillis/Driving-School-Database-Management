<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <?php
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      echo "<h1>Inscription d'un élève à une séance </h1><br>";
      include('connexion.php');
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');

      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
      $idseance=$_POST['menuChoixSeance'];
      $ideleve = $_POST['menuChoixEleve'];
      $query1="SELECT * FROM seances WHERE idseance='$idseance';"; // selection des infos de la séances
      //echo "Requête SQL : ($query1)<br>";
      $query2="SELECT * FROM inscription WHERE idseance='$idseance';";// selection des inscrits à la séance
      //echo "Requête SQL : ($query2)<br>";
      $query3="SELECT * FROM inscription WHERE ideleve='$ideleve' AND idseance='$idseance';"; // pour la vérification si l'élève est déjà inscrit à la séance
      //echo "Requête SQL : ($query3)<br>";
      $result = mysqli_query($connect,$query1);
      $verif_eff = mysqli_query($connect,$query2);
      $verif_insc = mysqli_query($connect,$query3);
      $row = mysqli_fetch_array($result, MYSQLI_NUM);


      if (!$result OR !$verif_eff OR !$verif_insc){
          echo "<br>Erreur".mysqli_error($connect)."<br>";
      }
      else if(mysqli_num_rows($verif_eff) < $row[2] AND mysqli_num_rows($verif_insc)==0){ //on vérifie que l'effectif de la séance n'est pas atteint
        // et qu'il n'est pas déjà inscrit à la séance
        $query = "insert into inscription values ($idseance,$ideleve,NULL);";
        //echo "Requête SQL : ($query)<br>";
        $result = mysqli_query($connect,$query);
        if (!$result){
            echo "<br>Erreur".mysqli_error($connect)."<br>";
        }
        else{
          echo "L'élève a été inscrit.e à la séance !";
        }
      }
      else if (mysqli_num_rows(mysqli_query($connect,"SELECT * FROM inscription WHERE ideleve='$ideleve';"))!=0){ // sinon on regarde si il est déjà inscrit
        echo "L'élève est déjà inscrit.e à cette séance.";
      }

      else{ // sinon c'est que la séance est pleine
          echo "La séance est pleine !<br>";
      }

      echo "<br><a href='inscription_eleve.php'> <input type='button' value='Recommencer'></a>";
      mysqli_close($connect);
    ?>
  </body>
</html>
