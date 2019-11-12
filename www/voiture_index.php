<?php
require "../_include/inc_config.php";
$sql="select * from voiture";
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
                <a href="voiture_edit.php?id=0">Créer une voiture</a>
            </caption>
            <tr>
                <th>id</th>			
				<th>vo_immatriculation</th>
                <th>nom</th>
                <td>editer</td>
                <td>supprimer</td>
            </tr>
            <?php
            foreach($data as $row) {
                $row=array_map("cb_htmlentities",$row);
                extract($row);
                echo "<tr>";
                echo "<td>$vo_id</td>";
				echo "<td>$vo_immatriculation</td>";
                echo "<td>$vo_nom</td>";
                echo "<td><a href='voiture_edit.php?id=$vo_id'>Editer</a></td>";
                echo "<td><a href='voiture_del.php?id=$vo_id'>Supprimer</a></td>";
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