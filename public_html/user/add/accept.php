<?php  
	include '../../db.php';
	$oldFile = "";
	$rashaudio = "";
	$rashimg = "";
	$hashuser = $_COOKIE['hash'];
	$iduser = $_COOKIE['id'];
	
	if (isset($_POST['submit'])) {
		$result = mysqli_query($link, "SELECT id,rash_audio,rash_img FROM `music` WHERE `user` = '".$hashuser."'");
		for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
		foreach ($data as $count => $ksong) {
			foreach ($ksong as $key => $value){
			if ($key == 'id') $idsongs = $value;
			if ($key == 'rash_audio') $rashaudio = $value;
			if ($key == 'rash_img') $rashimg = $value;
			}
		}

		mysqli_query($link, "UPDATE `music` SET `user` = '".$iduser."' WHERE `music`.`user` = '".$hashuser."';");
		mysqli_query($link, "UPDATE `genre_music` SET `id_music` = '".$idsongs."' WHERE `id_music` = '".$hashuser."';");
		$oldName = "../../audio/$hashuser.$rashaudio";
		$newName = "../../audio/$idsongs.$rashaudio";
		rename($oldName, $newName);

		if ($rashimg !== ''){
			$oldName = "../../img/imgsongs/$hashuser.$rashimg";
			$newName = "../../img/imgsongs/$idsongs.$rashimg";
			rename($oldName, $newName);
		}
		header("Location: /user/add/"); exit();
	}

	if (isset($_POST['nsubmit'])) {
		$result = mysqli_query($link, "SELECT id,rash_audio,rash_img FROM `music` WHERE `user` = '".$hashuser."'");
		for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
		foreach ($data as $count => $ksong) {
			foreach ($ksong as $key => $value){
			if ($key == 'id') $idsongs = $value;
			if ($key == 'rash_audio') $rashaudio = $value;
			if ($key == 'rash_img') $rashimg = $value;
			}
		}

		mysqli_query($link, "DELETE FROM `music` WHERE `music`.`user` = '".$hashuser."';");
		mysqli_query($link, "DELETE FROM `genre_music` WHERE `id_music` = '".$hashuser."';");

		$oldFile = "../../audio/$hashuser.$rashaudio";

		if (file_exists($oldFile)) {
			unlink($oldFile);
		}

		$oldFile = "../../img/imgsongs/$hashuser.$rashimg";

		if (file_exists($oldFile)) {
			unlink($oldFile);
		}
		header("Location: /user/add/");
	}

	include '../../setings.php';
	include '../../header.php';
	
	echo '
		<div class="menu_accept">
			<h1>Подтверждение</h1>
			<h2>Вы уверены, что хотите загрузить?</h2>
			<form action="" method="POST">
			<button class="y" name="submit" type="submit"><h3>Уверен</h3></button>
			<button class="n" name="nsubmit" type="nsubmit"><h3>Нет</h3></button>
			</form>
		</div>

	';
?>