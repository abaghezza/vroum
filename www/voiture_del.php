<?php
require "../_include/inc_config.php";  
extract($_GET);  
$sql = "delete from voiture  where vo_id=:id";
$statement = $link->prepare($sql);
$statement->bindParam(":id",$id,PDO::PARAM_INT);
$statement->execute(); 
header("location:voiture_index.php");
?>