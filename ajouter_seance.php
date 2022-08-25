<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <?php
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      include('connexion.php');
      echo "<h1>Ajout d'une séance </h1><br>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
      $query="SELECT * FROM seances WHERE DateSeance='".$_POST['dateSeance']."' AND idtheme=".$_POST['menuChoixTheme'].";";
      //echo "Requête SQL : ($query)<br>";
      $result = mysqli_query($connect,$query);
      if (!$result){
          echo "<br>Erreur".mysqli_error($connect)."<br>";
      }
      else if(mysqli_num_rows($result)==0){ //on vérifie qu'aucune séance n'est existante (même thème/date)
        $query = "insert into seances values (NULL,'".$_POST['dateSeance']."',".$_POST['eff'].",".$_POST['menuChoixTheme'].");";
        //echo "Requête SQL : ($query)<br>";
        $result=mysqli_query($connect, $query);
        if (!$result){
            echo "<br>Erreur".mysqli_error($connect)."<br>";
        }
        else{
          echo"Séance créée avec succès !<br>";
        }
      }

      else{
          echo "Une séance de ce thème est déjà existante à la date donnée.<br>";
      }

      echo "<a href='ajout_seance.php'> <input type='button' value='Retour'></a>";
      mysqli_close($connect);
    ?>
  </body>
</html>
