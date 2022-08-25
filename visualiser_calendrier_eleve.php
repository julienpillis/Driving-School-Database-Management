<html>
  <head><meta charset="utf-8"></head>
  <body>
    <?php
      include('connexion.php');
      echo "<link type='text/css' href='autoecole.css' rel='stylesheet'>";
      echo "<h1>Calendrier de l'élève </h1><br>";
      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
      mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
      $ideleve=$_POST['menuChoixEleve'];
      $query1="SELECT nom, DateSeance,idseance FROM seances INNER JOIN themes on seances.idtheme=themes.idtheme WHERE DateSeance >'$date' ORDER BY DateSeance";//on récupère la liste des séances futures et on lie la table themes avec l'id du thème correspondant
      //echo "Requête SQL : ($query1)<br>";
      $seances = mysqli_query($connect,$query1);
      $query2 = "SELECT prenom, nom FROM eleves WHERE ideleve='$ideleve'"; // on récupère le nom et prénom de l'élève
      //echo "Requête SQL : ($query2)<br>";
      $eleve=mysqli_query($connect,$query2);
      if(!$seances OR !$eleve ){
        echo "<br>Erreur".mysqli_error($connect)."<br>";
      }
      else{
        $row_eleve = mysqli_fetch_array($eleve,MYSQLI_NUM); // on recupère le prenom/nom de l'élève
        echo "Les futures séances de <span class='eleve'>$row_eleve[0] $row_eleve[1]</span> sont : <br>";
        echo "<table border=1>";
        echo "<th>Thème</th><th>Date</th>";
        $var=0;/* variable pour la couleur*/
        $val="impaire";/*variable pour la classe de la 1ère ligne du tableau*/
        while ($row = mysqli_fetch_array($seances, MYSQLI_NUM)){

          $query="SELECT * FROM inscription WHERE ideleve='$ideleve' AND idseance='$row[2]'"; // verif si il est inscrit dans certaines séances
          //echo "Requête SQL : ($query)<br>";
          $verif=mysqli_query($connect,$query);
          if (!$verif){
              echo "<br>Erreur".mysqli_error($connect)."<br>";
          }
          else if(mysqli_num_rows($verif)!=0){
              echo "<tr><td class=$val >$row[0]</td><td class=$val>$row[1]</td></tr>";// on affiche que les séances où il est inscrit
              if($var==0){ /*si $var=0, alors la ligne suivante est paire (elle sera de couleur grise)*/
                $val='paire';
                $var=1;
              }
              else{ /*sinon elle est impair, elle sera de couleur blanche*/
                $val='impaire';
                $var=0;
              }
          }
        }
        echo "</table><br>";
        echo "<a href='visualisation_calendrier_eleve.php'><INPUT type='button' value='Retour'></a>";
      }
      mysqli_close($connect);
    ?>
  </body>
</html>
