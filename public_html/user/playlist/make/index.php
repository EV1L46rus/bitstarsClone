<?php 
include '../../../db.php';
$lasttime = '?'.rand();
$random = rand();
$hash = $_COOKIE['hash'];


if (isset($_POST['make'])) {
	mysqli_query($link, "INSERT INTO `playlist` (`id_time`) VALUES ('".$hash."')");
	mysqli_query($link, "UPDATE `playlist` SET `id_user` = '".$_COOKIE['id']."' WHERE `playlist`.`id_time` = '".$hash."';");
	if ($_FILES["img_file"]['name'] !== ''){
		$uploaddirimg = '../../../img/playlist/';
		$original_name = $_FILES["img_file"]["name"];
		$extensionImg = pathinfo($original_name, PATHINFO_EXTENSION);
		$new_name = $random.'.'.$extensionImg;
		$uploadimg = $uploaddirimg . $new_name;
		if (move_uploaded_file($_FILES['img_file']['tmp_name'], $uploadimg));
		mysqli_query($link, "UPDATE `playlist` SET `rash` = '".$new_name."' WHERE `playlist`.`id_time` = '".$hash."';");
	} else {
		mysqli_query($link, "UPDATE `playlist` SET `rash` = 'defoult.jpg' WHERE `playlist`.`id_time` = '".$hash."';");
	}

	if ($_POST['title'] !== ''){
		mysqli_query($link, "UPDATE `playlist` SET `title` = '".$_POST['title']."' WHERE `playlist`.`id_time` = '".$hash."';");
	} else {
		mysqli_query($link, "UPDATE `playlist` SET `title` = 'Playlist' WHERE `playlist`.`id_time` = '".$hash."';");
	}

	if (isset($_POST['descr'])) {
		mysqli_query($link, "UPDATE `playlist` SET `descr` = '".$_POST['descr']."' WHERE `playlist`.`id_time` = '".$hash."';");
	}

	if (isset($_POST['hide'])) {
		mysqli_query($link, "UPDATE `playlist` SET `hide` = '1' WHERE `playlist`.`id_time` = '".$hash."';");
	} else {
		mysqli_query($link, "UPDATE `playlist` SET `hide` = '0' WHERE `playlist`.`id_time` = '".$hash."';");
	}

	$result = mysqli_query($link, "SELECT * FROM `playlist` WHERE `playlist`.`id_time` = '".$hash."'");
	for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
	foreach ($data as $count => $ksong) {
		foreach ($ksong as $key => $value){
			if ($key == 'id') $id = $value;			
		}
		mysqli_query($link, "UPDATE `playlist_music` SET `id_playlist` = '".$id."' WHERE `playlist_music`.`id_playlist` = '".$hash."';");
		mysqli_query($link, "UPDATE `playlist` SET `id_time` = '".$random."' WHERE `playlist`.`id_time` = '".$hash."';");
	}
	header("Location: ../"); exit();

}

if (isset($_GET['search_play'])){
	$searchMy = mysqli_real_escape_string($link, $_GET['search_play']);
	$resultSearch = mysqli_query($link, "SELECT * FROM `music` WHERE `title` LIKE '%".$searchMy."%' OR `name`LIKE '%".$searchMy."%'");

}





include '../../../header.php';
echo '
	<div class="body_user">
		<div class="left_menu">
			';
include '../../left.php';
echo '
		</div>
		<div class="screen">
			<a href="../">
				<button class="makeplay">
					<h2>Back</h2>
				</button>
			</a>
			<div class="make_menu">
				<form enctype="multipart/form-data" class="forma" action="" method="POST">
				<div class="upp">
					<div class="play_img">
						<input onchange="replaceImg(this)" class="upload_img" id="infile" type="file" name="img_file" accept="image/*">
						<img src="/img/playlist/defoult.jpg',$lasttime,'" alt="" id="photo_playlist">
						<div class="file" >
							<h4>Сhange photo</h4>
						</div>
					</div>
					<div class="input">
						<input type="text" name="title" placeholder="Title" class="title">
						<input type="text" name="descr" placeholder="description" id="description" class="title">
						<div class="check">
							<input name="hide" class="inpt_check" type="checkbox" id="checkbox">
							<label class="lbl_check" for="checkbox">hide playlist</label>
						</div>
						<button class="make" name="make">
							<h4>Make playlist</h4>
						</button>
					</div>
				</div>
				</form>
				<div class="audio_menu">
					<div class="all_music">
						<h3>All audio</h3>
					</div>
						<div class="search_music">
							<input type="text" name="search_play" placeholder="What are you want?" class="search_music_input">
						</div>
					<div class="music_list">';
		if(isset($resultSearch)){
			$result = $resultSearch;
		} else {
		$result = mysqli_query($link, "SELECT * FROM `music`");
		}
		for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
		foreach ($data as $count => $ksong) {
			foreach ($ksong as $key => $value){
				if ($key == 'id') $idMusic = $value;
				if ($key == 'name') $name = $value;
				if ($key == 'title') $title = $value;
				if ($key == 'rash_audio') $rashAudio = $value;
				if ($key == 'rash_img') {
					if ($value !== '') {
						$imgAudio = $idMusic.'.'.$value.$lasttime;
					} else {
						$imgAudio = 'defoult.png'.$lasttime;
					}
				}
			}
			echo'
			<div class="song" data-id="',$idMusic,'" data-hash="',$hash,'">
				<div class="song_mrgn">
					<div class="play_bg"></div>
					<img src="/img/play.png" alt="" class="play">
					<img src="/img/imgsongs/',$imgAudio,'" alt="" class="img_song">
					<div class="titles_songs">
						<h3>',$title,'</h3>
						<h4>',$name,'</h4>
					</div>
					<button onclick="addAudio(this)" id="',$idMusic,'" class="add">
						<img src="/img/plus.png" alt="">
					</button>
				</div>
				
				<audio 
				src="/audio/',$idMusic,'.',$rashAudio,'"
				controls
				data-id="',$idMusic,'"
				class="audio">
					Аудио не поддерживается
				</audio>								
			</div>';
		}
				echo'
					<div class="left" onclick="clicked(\'left\')">
						<img src="/img/next.png" alt="">
					</div>
					<div class="right" onclick="clicked(\'right\')">
						<img src="/img/next.png" alt="">
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script style="text/javascript" src="/user/playlist/make/script.js"></script>
';


?>