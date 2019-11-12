<?php
require "../_include/inc_config.php";
if (isset($_POST["btsubmit"])) {
    //échappe les caractères spéciaux du SQL
    extract($_POST);  
    if ($vo_id==0) {
        $sql = "insert into voiture values (null,:vo_immatriculation,:vo_nom)";
        $statement = $link->prepare($sql);
		$statement->bindParam(":vo_immatriculation",$vo_immatriculation,PDO::PARAM_STR);
        $statement->bindParam(":vo_nom",$vo_nom,PDO::PARAM_STR);
        $statement->execute(); 
    } else {
        $sql = "update voiture set vo_immatriculation=:vo_immatriculation, vo_nom=:vo_nom where vo_id=:vo_id";
        $statement = $link->prepare($sql);
        $statement->bindParam(":vo_id",$vo_id,PDO::PARAM_INT);
		$statement->bindParam(":vo_immatriculation",$vo_immatriculation,PDO::PARAM_STR);
        $statement->bindParam(":vo_nom",$vo_nom,PDO::PARAM_STR);
        $statement->execute(); 
    }      

    header("location:voiture_index.php");
} else {
    extract($_GET);
    if ($id > 0) { //UPDATE
        $sql = "select * from voiture where vo_id=:id";
        $statement = $link->prepare($sql);
        $statement->bindParam(":id",$id,PDO::PARAM_INT);
        $statement->execute();
        $row=$statement->fetch(PDO::FETCH_ASSOC);        
        extract($row);
    } else { //INSERT
        $vo_id=0;
		$vo_immatriculation="";
        $vo_nom="";
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
            <input type='hidden' name='vo_id' id='vo_id' value='<?= $vo_id ?>'>
			<p>
                <label for='immatriculation_nom'>vo_immatriculation</label>
                <input type='text' name='vo_immatriculation' id='vo_immatriculation' required value='<?= htmlentities($vo_immatriculation,ENT_QUOTES,"utf-8") ?>'>
            </p>
            <p>
                <label for='vo_nom'>vo_nom</label>
                <input type='text' name='vo_nom' id='vo_nom' required value='<?= htmlentities($vo_nom,ENT_QUOTES,"utf-8") ?>'>
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