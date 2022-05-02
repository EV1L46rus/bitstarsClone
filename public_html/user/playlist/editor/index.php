<?php 
include '../../../db.php';
$lasttime = '?'.rand();
$random = rand();
$check = '';


if (isset($_POST['save'])) {
	if ($_FILES["img_file"]['name'] !== ''){
		$uploaddirimg = '../../../img/playlist/';
		$original_name = $_FILES["img_file"]["name"];
		$extensionImg = pathinfo($original_name, PATHINFO_EXTENSION);
		$new_name = $random.'.'.$extensionImg;
		$uploadimg = $uploaddirimg . $new_name;
		if (move_uploaded_file($_FILES['img_file']['tmp_name'], $uploadimg));
		mysqli_query($link, "UPDATE `playlist` SET `rash` = '".$new_name."', `id_time` = '".$random ."' WHERE `playlist`.`id` = '".$_COOKIE['playlist']."';");
	}

	if ($_POST['title'] !== ''){
		mysqli_query($link, "UPDATE `playlist` SET `title` = '".$_POST['title']."' WHERE `playlist`.`id` = '".$_COOKIE['playlist']."';");
	} else {
		mysqli_query($link, "UPDATE `playlist` SET `title` = 'Playlist' WHERE ``playlist`.`id` = '".$_COOKIE['playlist']."';");
	}

	if (isset($_POST['descr'])) {
		mysqli_query($link, "UPDATE `playlist` SET `descr` = '".$_POST['descr']."' WHERE `playlist`.`id` = '".$_COOKIE['playlist']."';");
	}

	if (isset($_POST['hide'])) {
		mysqli_query($link, "UPDATE `playlist` SET `hide` = '1' WHERE `playlist`.`id` = '".$_COOKIE['playlist']."';");
	} else {
		mysqli_query($link, "UPDATE `playlist` SET `hide` = '0' WHERE `playlist`.`id` = '".$_COOKIE['playlist']."';");
	}
	header("Location: ../"); exit();

}

if (isset($_POST['delete'])) {
	mysqli_query($link, "DELETE FROM `playlist` WHERE `playlist`.`id` = '".$_COOKIE['playlist']."'");
	mysqli_query($link, "DELETE FROM `playlist_music` WHERE `playlist_music`.`id_playlist` = '".$_COOKIE['playlist']."'");
	header("Location: ../"); exit();
}

if (isset($_COOKIE['playlist'])){
	$result = mysqli_query($link, "SELECT * FROM `playlist` WHERE `id` = '".$_COOKIE['playlist']."'");
	for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
	foreach ($data as $count => $ksong) {
		foreach ($ksong as $key => $value){
			if ($key == 'title') $title = $value;
			if ($key == 'descr') $descr = $value;
			if ($key == 'hide') {
				if ($value == '1'){
					$check = 'checked';
				} else {
					$check = '';
				}
			}
			if ($key == 'rash') {
				if ($value == 'defoult.jpg') {
					$imgPlay = 'defoult.jpg';
				} else {
					$imgPlay = $value;
				}
			}
		}
	}
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
						<img src="/img/playlist/',$imgPlay.$lasttime,'" alt="" id="photo_playlist">
						<div class="file" >
							<h4>Сhange photo</h4>
						</div>
					</div>
					<div class="input">
						<input type="text" name="title" placeholder="Title" class="title" value="',$title,'">
						<input type="text" name="descr" placeholder="description" id="description" class="title" value="',$descr,'">
						<div class="check">
							<input ',$check,' name="hide" class="inpt_check" type="checkbox" id="checkbox">
							<label class="lbl_check" for="checkbox">hide playlist</label>
						</div>
						<div class="btn_save">
							<button class="make" name="save">
								<h4>Save</h4>
							</button>
							<button class="delete" name="delete">
								<img src="/img/delete.png" alt="">
							</button>
						</div>
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

		$result = mysqli_query($link, "SELECT DISTINCT music.id, music.name, music.title, music.user, music.rash_audio, music.rash_img, music.scan, music.dmy_music FROM music, playlist, playlist_music WHERE playlist_music.id_playlist = playlist.id AND playlist_music.id_music = music.id AND playlist.id = '".$_COOKIE['playlist']."' ORDER BY playlist_music.date DESC, playlist_music.id DESC");
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
			<div class="song" data-id="',$idMusic,'" data-playlist="',$_COOKIE['playlist'],'">
				<div class="song_mrgn">
					<div class="play_bg"></div>
					<img src="/img/play.png" alt="" class="play">
					<img src="/img/imgsongs/',$imgAudio,'" alt="" class="img_song">
					<div class="titles_songs">
						<h3>',$title,'</h3>
						<h4>',$name,'</h4>
					</div>
					<button onclick="addAudio(this)" id="',$idMusic,'" class="add">
						<img src="/img/plus.png" alt="" class="rotate45">
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

		$result = mysqli_query($link, "SELECT * FROM music WHERE NOT music.id IN (SELECT playlist_music.id_music FROM playlist_music WHERE playlist_music.id_playlist = '".$_COOKIE['playlist']."')");
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
			<div class="song" data-id="',$idMusic,'" data-playlist="',$_COOKIE['playlist'],'">
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
	<script style="text/javascript" src="/user/playlist/editor/script.js"></script>
';


?>