<?php
require "../_include/inc_config.php";
if (isset($_POST["btsubmit"])) {
    //échappe les caractères spéciaux du SQL
    extract($_POST);  
    if ($cl_id==0) {
        $sql = "insert into client values (null,:cl_nom)";
        $statement = $link->prepare($sql);
        $statement->bindParam(":cl_nom",$cl_nom,PDO::PARAM_STR);
        $statement->execute(); 
    } else {
        $sql = "update client set cl_nom=:cl_nom where cl_id=:cl_id";
        $statement = $link->prepare($sql);
        $statement->bindParam(":cl_id",$cl_id,PDO::PARAM_INT);
        $statement->bindParam(":cl_nom",$cl_nom,PDO::PARAM_STR);
        $statement->execute(); 
    }      

    header("location:cl_index.php");
} else {
    extract($_GET);
    if ($id > 0) { //UPDATE
        $sql = "select * from client where cl_id=:id";
        $statement = $link->prepare($sql);
        $statement->bindParam(":id",$id,PDO::PARAM_INT);
        $statement->execute();
        $row=$statement->fetch(PDO::FETCH_ASSOC);        
        extract($row);
    } else { //INSERT
        $cl_id=0;
        $cl_nom="";
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
            <input type='hidden' name='cl_id' id='cl_id' value='<?= $cl_id ?>'>
            <p>
                <label for='cl_nom'>cl_nom</label>
                <input type='text' name='cl_nom' id='cl_nom' required value='<?= htmlentities($cl_nom,ENT_QUOTES,"utf-8") ?>'>
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