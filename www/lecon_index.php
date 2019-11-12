<?php
require "../_include/inc_config.php";
$sql="select * from lecon,moniteur where le_moniteur=mo_id order by le_date,le_heure_debut";
$result=$link->query($sql);
$data=$result->fetchAll();

function getVoiture($vo_id) {
    global $link;
    $sql="select * from voiture where vo_id=:id";
    $st=$link->prepare($sql);
    $st->execute([":id"=>$vo_id]);
    $row=$st->fetch();
    if ($row)
        $chaine=$row["vo_immatriculation"] . "<br>" . $row["vo_nom"];
    else
        $chaine="aucune";

    return $chaine;
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
        <h1>Les leçons</h1>
        <table>
            <caption>
                <a href="lecon_edit.php?id=0">Créer une leçon</a>
            </caption>
            <tr>
                <th>id</th>
                <th>date</th>
                <th>heure début</th>                
                <th>heure fin</th>
                <th>moniteur</th>
                <th>voiture</th>
                <th>editer</th>
                <th>supprimer</th>
            </tr>
            <?php
            foreach($data as $row) {
                $row=array_map("cb_htmlentities",$row);
                extract($row);
                echo "<tr>";
                echo "<td>$le_id</td>";
                echo "<td>$le_date</td>";
                echo "<td>$le_heure_debut</td>";
                echo "<td>$le_heure_fin</td>";
                echo "<td>$mo_nom</td>";
                echo "<td>" . getVoiture($le_voiture) . "</td>";
                echo "<td><a href='lecon_edit.php?id=$le_id'>Editer</a></td>";
                echo "<td><a href='lecon_del.php?id=$le_id'>Supprimer</a></td>";
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