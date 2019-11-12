<?php
require "../_include/inc_config.php";
if (isset($_POST["btsubmit"])) {
    //échappe les caractères spéciaux du SQL
    extract($_POST);  
    if ($mo_id==0) {
        $sql = "insert into moniteur values (null,:mo_nom)";
        $statement = $link->prepare($sql);
        $statement->bindParam(":mo_nom",$mo_nom,PDO::PARAM_STR);
        $statement->execute(); 
    } else {
        $sql = "update moniteur set mo_nom=:mo_nom where mo_id=:mo_id";
        $statement = $link->prepare($sql);
        $statement->bindParam(":mo_id",$mo_id,PDO::PARAM_INT);
        $statement->bindParam(":mo_nom",$mo_nom,PDO::PARAM_STR);
        $statement->execute(); 
    }      

    header("location:moniteur_index.php");
} else {
    extract($_GET);
    if ($id > 0) { //UPDATE
        $sql = "select * from moniteur where mo_id=:id";
        $statement = $link->prepare($sql);
        $statement->bindParam(":id",$id,PDO::PARAM_INT);
        $statement->execute();
        $row=$statement->fetch(PDO::FETCH_ASSOC);        
        extract($row);
    } else { //INSERT
        $mo_id=0;
        $mo_nom="";
    }
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
		<form method="post">
            <input type='hidden' name='mo_id' id='mo_id' value='<?= $mo_id ?>'>
            <p>
                <label for='mo_nom'>mo_nom</label>
                <input type='text' name='mo_nom' id='mo_nom' required value='<?= htmlentities($mo_nom,ENT_QUOTES,"utf-8") ?>'>
            </p>            
            <input type="submit" name="btsubmit" value="Enregistrer">
        </form>
    </div>
    <hr>
    <footer>
        <?php require "../_include/inc_pied.php"; ?>
    </footer>
</body>

</html>