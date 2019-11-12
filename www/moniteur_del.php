<?php
require "../_include/inc_config.php";  
extract($_GET);  
$sql = "delete from moniteur where mo_id=:id";
$statement = $link->prepare($sql);
$statement->bindParam(":id",$id,PDO::PARAM_INT);
$statement->execute(); 
header("location:moniteur_index.php");
?>