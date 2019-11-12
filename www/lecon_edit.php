<?php
require "../_include/inc_config.php";
if (isset($_POST["btsubmit"])) {
    extract($_POST);  
    $option[":le_moniteur"]=$le_moniteur;
    $option[":le_voiture"]=$le_voiture;
    $option[":le_date"]=$le_date;
    $option[":le_heure_debut"]=$le_heure_debut;
    $option[":le_heure_fin"]=$le_heure_fin;
    if ($le_id==0) {
        $sql = "insert into lecon values (null,:le_moniteur, :le_voiture, :le_heure_debut, :le_heure_fin,:le_date)";
        $statement = $link->prepare($sql);        
        $statement->execute($option); 
    } else {
        $sql = "update lecon set le_moniteur= :le_moniteur, le_voiture=:le_voiture, le_date=:le_date, le_heure_debut=:le_heure_debut, le_heure_fin=:le_heure_fin where le_id=:le_id";
        $statement = $link->prepare($sql);
        $option[":le_id"]=$le_id;
        $statement->execute($option); 
    }      

    header("location:lecon_index.php");
} else {
    extract($_GET);
    if ($id > 0) { //UPDATE
        $sql = "select * from lecon where le_id=:id";
        $statement = $link->prepare($sql);
        $statement->execute([":id"=>$id]);
        $row=$statement->fetch();        
        extract($row);
    } else { //INSERT
        $le_id=0;
        $le_date="";
        $le_heure_debut="";
        $le_heure_fin="";
        $le_moniteur="";
        $le_voiture="";
    }
}

function listeInscrit($le_id) {
    global $link;
    $sql="select * from plannifier,client where pl_client=cl_id and pl_lecon=:le_id";
    $statement = $link->prepare($sql);
    $statement->execute([":le_id"=>$le_id]);
    $data=$statement->fetchAll();        
    return $data;
}

function listenoninscrit ($le_id) {
	global $link;
$sql="select * from client where cl_id notin (select pl_client from plannifier where pl_lecon=pl_lecon)";
$statement = $link->prepare($sql);
    $statement->execute([":le_id"=>$le_id]);
    $data2=$statement->fetchAll();        
    return $data2;
}		   
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
        <h1>Leçon n°<?=$id?></h1>
		<form method="post">
            <input type='hidden' name='le_id' id='le_id' value='<?= $le_id ?>'>
            <p>
                <label for='le_date'>le_date</label>
                <input type='text' name='le_date' id='le_date' required value='<?= htmlentities($le_date,ENT_QUOTES,"utf-8") ?>'>
            </p>            
            <p>
                <label for='le_heure_debut'>le_heure_debut</label>
                <input type='text' name='le_heure_debut' id='le_heure_debut' required value='<?= htmlentities($le_heure_debut,ENT_QUOTES,"utf-8") ?>'>
            </p>
            <p>
                <label for='le_heure_fin'>le_heure_fin</label>
                <input type='text' name='le_heure_fin' id='le_heure_fin' required value='<?= htmlentities($le_heure_fin,ENT_QUOTES,"utf-8") ?>'>
            </p>
            <p>
                <label for='le_moniteur'>le_moniteur</label>
                <select name='le_moniteur' id='le_moniteur'>
                    <?php
                    HTMLselect($link,"select mo_id id, mo_nom label from moniteur",$le_moniteur);
                    ?>
                </select>
            </p>
            <p>
                <label for='le_voiture'>le_voiture</label>
                <select name='le_voiture' id='le_voiture'>
                    <option value="0">Aucune</option>
                    <?php
                    HTMLselect($link,"select vo_id id, concat(vo_immatriculation,' - ', vo_nom) label from voiture",$le_voiture);
                    ?>
                </select>
            </p>
            <input type="submit" name="btsubmit" value="Enregistrer">
        </form>
        <h2>Liste des inscrits</h2>
        <table>
            <caption><a href="lecon_inscrire.php?">Inscrire un client</a></caption>
            <tr>
                <th>client</th>
                <th>Désinscrire</th>
            </tr>
            <?php
                $data=listeInscrit($le_id);
                foreach($data as $row) {
                    extract($row);
                    echo "<tr>";
                    echo "<td>$cl_nom</td>";
                    echo "<td><a href='lecon_desinscrire.php?le_id=$le_id&cl_id=$cl_id'>Désinscrire</a></td>";
                    echo "</tr>";
                }
            ?>            
        </table>
        <h2>Liste des non inscrits : </h2>
        <p>... afficher la liste des clients non inscrits
             à cette leçon et proposer un lien "inscription" pour chacun.</p>
        <table>
            <caption><a href="lecon_edit.php?">Inscrire un client</a></caption>
            <tr>
                <th>client</th>
                <th>inscrire</th>
            </tr>
            <?php
                $data2=listenoninscrit($le_id);
                foreach($data as $row) {
                    extract($row);
                    echo "<tr>";
               echo "<td>$cl_nom</td>";
                    echo "<td><a href='lecon_edit.php?le_id=$le_id&cl_id=$cl_id'>Inscrire</a></td>";
                    echo "</tr>";
                }
            ?>            
        </table>		
    </div>
    <hr>
    <footer>
        <?php require "../_include/inc_pied.php"; ?>
    </footer>
</body>

</html>