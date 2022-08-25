<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <?php
      include('connexion.php');
      echo "<h1>Ajout d'un.e élève </h1><br>";
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
      if($_POST['validite']=='oui'){
        $query = "insert into eleves values (NULL,'".$_POST['nom']."','".$_POST['prenom']."','".$_POST['dn']."','$date')";//ajout de l'élève
        //echo "Requête SQL : ($query)<br>";
        $insertion = mysqli_query($connect, $query);
        if (!$insertion){
            echo "<br>Erreur".mysqli_error($connect)."<br>";
        }
        else {
        echo "Elève ajouté !<br>";
        }
      }
      else{
        echo"L'élève n'a pas été ajouté.<br>";
      }
      echo "<a href='ajout_eleve.html'> <input type='button' value='Retour'></a>";
      mysqli_close($connect);
    ?>
  </body>
</html>
