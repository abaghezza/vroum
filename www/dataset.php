<?php
//composer require fzaninotto/faker
require "../_include/inc_config.php";
require_once '../vendor/autoload.php';
// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create("fr_FR");

?>
<!DOCTYPE html>
<html>

<head>
    <?php require "../_include/inc_head.php" ?>
</head>

<body>
    <header>
        <?php require "../_include/inc_entete.php" ?>
    </header>
    <nav>
        <?php require "../_include/inc_menu.php"; ?>
    </nav>
    <div id="contenu">
        <h1>Génération du jeu de données</h1>        
        <?php       
        //création des moniteurs
        $nbmoniteur = 10;
        echo "<h1>Création des moniteur</h1>";
        $sql = "insert into moniteur values (null,:mo_nom)";
        $statement = $link->prepare($sql);
		$statement->bindParam(":mo_nom",$mo_nom,PDO::PARAM_STR);
        for ($i = 1; $i <= $nbmoniteur; $i++) {
            $mo_nom=$faker->name;            
            $statement->execute();       
        }
        
        //création des clients
        $nbclient = 100;
        echo "<h1>Création des clients</h1>";
        $sql = "insert into client values (null,:cl_nom)";
        $statement = $link->prepare($sql);
		$statement->bindParam(":cl_nom",$cl_nom,PDO::PARAM_STR);
        for ($i = 1; $i <= $nbclient; $i++) {
            $cl_nom=$faker->name;            
            $statement->execute();                
        }  
        
        //création des voitures
        $nbvoiture = 20;
        echo "<h1>Création des voitures</h1>";
        $sql = "insert into voiture values (null,:vo_immatriculation,:vo_nom)";
        $statement = $link->prepare($sql);
		$statement->bindParam(":vo_immatriculation",$vo_immatriculation,PDO::PARAM_STR);
        $statement->bindParam(":vo_nom",$vo_nom,PDO::PARAM_STR);
        for ($i = 1; $i <= $nbvoiture; $i++) {
            $vo_immatriculation=strtoupper($faker->bothify('##???##'));
            $vo_nom=$faker->text(10);
            $statement->execute();
        }
         
        //création des leçon
        $nblecon = 100;
        echo "<h1>Création des leçon</h1>";
        $sql = "insert into lecon values (null,:le_moniteur,:le_voiture,:le_heure_debut,:le_heure_fin,:le_date)";
        $statement = $link->prepare($sql);
		$statement->bindParam(":le_moniteur",$le_moniteur,PDO::PARAM_INT);		
		$statement->bindParam(":le_voiture",$le_voiture,PDO::PARAM_INT);
		$statement->bindParam(":le_heure_debut",$le_heure_debut,PDO::PARAM_STR);
		$statement->bindParam(":le_heure_fin",$le_heure_fin,PDO::PARAM_STR);
		$statement->bindParam(":le_date",$le_date,PDO::PARAM_STR);
			
        for ($i = 1; $i <= $nblecon; $i++) {
            $le_moniteur=rand(1,$nbmoniteur);
            $le_voiture=rand(0,$nbvoiture);
			if ($le_voiture==0)
				$le_voiture=null;
            $x=rand(8,18);
            $le_heure_debut="$x:00";
            $x+=2;
            $le_heure_fin="$x:00";
            $le_date=date("Y-m-d",mktime(0,0,0,rand(1,12),rand(1,30),2019));            
            $statement->execute();
        }

        //création des planifications
        echo "<h1>Création des planifications</h1>";
        $tab=range(1,$nbclient);
        $sql = "insert into plannifier values (null,:le_lecon,:le_client)";
        $statement = $link->prepare($sql);
		$statement->bindParam(":le_lecon",$le_lecon,PDO::PARAM_INT);
        $statement->bindParam(":le_client",$le_client,PDO::PARAM_INT);
        for ($i = 1; $i <= $nblecon; $i++) {
            $le_lecon=$i;
            //nombre de client inscrit à la leçon
            $nbin=rand(1,10);
            /**
			* tirer au hasard $nbin clients différents :
			* - prendre les nombre de 1 à $nbclient
			* - mélanger
			* - prendre $nbin valeurs
			*/	
            shuffle($tab);
            for($k=1; $k<=$nbin ;$k++) {
                $le_client=$tab[$k];                
                $statement->execute();
            }
        }
        ?>
    </div>
    <hr>
    <footer>
        <?php require "../_include/inc_pied.php"; ?>
    </footer>
</body>

</html>