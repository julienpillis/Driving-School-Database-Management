<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <?php
      include('connexion.php');
      echo "<h1>Ajout d'un thème </h1><br>";
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8');
      $nom = mysqli_escape_string($connect,$_POST['tname']); //la fonction évite l'interprétation de l'entrée en requête SQL à cause des caractères spéciaux (ex: '',""...)
      $descriptif = mysqli_escape_string($connect,$_POST['descriptif']);

      $query = "SELECT * FROM themes WHERE nom='$nom'";
      //echo "Requête SQL : ($query)<br>";
      $result = mysqli_query($connect,$query);
      if (!$result){
          echo "<br>Erreur".mysqli_error($connect)."<br>";
      }
      else if(mysqli_num_rows($result)==0){ //test homonyme, si aucun thème n'a le même nom, on le crée
        $query = "insert into themes values (NULL,'$nom',0,'$descriptif');";
        //echo "Requête SQL : ($query)<br>";
        $result= mysqli_query($connect, $query);
        if (!$result){
            echo "<br>Erreur".mysqli_error($connect)."<br>";
        }
        else{
          echo "Thème créé !<br>";
        }
      }
      else{
        $query = "SELECT * FROM themes WHERE nom='$nom' AND supprime=0";
        //echo "Requête SQL : ($query)<br>";
        $result= mysqli_query($connect, $query);
        if (!$result){
            echo "<br>Erreur".mysqli_error($connect)."<br>";
        }
        else{
          if(!mysqli_num_rows($result)==0){  //si le thème avec le même nom n'est pas supprimé,on signale à l'utilisateur qu'il est déjà actif et qu'il existe
            echo "Thème déjà existant et actif !<br>";
          }
          else{ //sinon on le réactive
            $query ="UPDATE themes SET supprime='0' WHERE nom='$nom'";
            //echo "Requête SQL : ($query)<br>";
            $result=mysqli_query($connect, $query);
            if (!$result){
                echo "<br>Erreur".mysqli_error($connect)."<br>";
            }
            else{
              echo "Thème réactivé !<br>";
            }
          }
        }
      }
      echo "<a href='ajout_theme.html'> <input type='button' value='Recommencer'></a>";
      mysqli_close($connect);
    ?>

  </body>
</html>
