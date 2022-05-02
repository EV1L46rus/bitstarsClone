<?php 
include '../db.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = mysqli_query($link,"UPDATE `music` SET `scan` = `scan`+1 WHERE `music`.`id` = '".$id."'");
}   
?>