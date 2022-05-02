<?php 
	include '../../db.php';

	if(isset($_GET['id'])){
	    $id = $_GET['id'];
	    $query = mysqli_query($link,"DELETE FROM `music` WHERE `music`.`id` = '".$id."'");
	} 
?>