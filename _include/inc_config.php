<?php
const MODE_PROD=false;
session_start();
const DB_SERVER = "localhost";
const DB_NAME = "basevoiture";
const DB_USER = "abdel";
const DB_PWD="abdel";
$link = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER,DB_PWD);
$link->exec("SET CHARACTER SET UTF8");
$nomApplication = "Mon Auto école";
$menu=array(
    ["moniteur_index.php","Moniteur"],    
	    ["cl_index.php", "Clients"],
		["voiture_index.php", "Voitures"],
		["lecon_index.php", "lecon"],
    ["creerdatabase.php","RAZ BDD"],
    ["dataset.php","jeu de données"]	    
);

require "inc_fonction.php";
?>