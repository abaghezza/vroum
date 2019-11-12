<?php
require "../_include/inc_config.php";
$sql="select * from moniteur";
$result=$link->query($sql);
$data=$result->fetchAll(PDO::FETCH_ASSOC);
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
        <h1>Bienvenu sur Mon Auto école</h1>
        <table>
            <caption>
                <a href="moniteur_edit.php?id=0">Créer un moniteur</a>
            </caption>
            <tr>
                <th>id</th>
                <th>nom</th>
                <td>editer</td>
                <td>supprimer</td>
            </tr>
            <?php
            foreach($data as $row) {
                $row=array_map("cb_htmlentities",$row);
                extract($row);
                echo "<tr>";
                echo "<td>$mo_id</td>";
                echo "<td>$mo_nom</td>";
                echo "<td><a href='moniteur_edit.php?id=$mo_id'>Editer</a></td>";
                echo "<td><a href='moniteur_del.php?id=$mo_id'>Supprimer</a></td>";
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