<?php 
	include '../../../db.php';

	if(isset($_GET['hash'])) {
		if(isset($_GET['id'])){
			$rand = $_GET['hash'];
			$id = $_GET['id'];
			$date = date('d.m.y g:i');
			$query = mysqli_query($link,"INSERT INTO `playlist_music` (`id_playlist`, `id_music`, `date`) VALUES ('".$rand."', '".$id."', '".$date."');");
		}
	}
?>