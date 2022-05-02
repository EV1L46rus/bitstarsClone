<?php 
include '../../db.php';

$lasttime = '?'.rand();

if (isset($_POST['edite'])){
	foreach ($_POST['edite'] as $key => $value){
		setcookie("playlist", $value);
	}
	header("Location: editor/"); exit();
}




include '../../header.php';

echo '
	<form action="" method="POST">
	<div class="body_user">
		<div class="left_menu">
			';
include '../left.php';
echo '
		</div>
		<div class="screen">
			<a href="/user/playlist/make/">
				<div class="makeplay">
					<h2>Сreate playlist</h2>
				</div>
			</a>
			<div class="your_playlist">
				<div class="your">
					<h4>Your playlist</h4>
				</div>
					<div class="list_playlist">';
				if (isset($_COOKIE['id'])){
					$result = mysqli_query($link, "SELECT * FROM `playlist` WHERE id_user = '".$_COOKIE['id']."'");
					for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
					foreach ($data as $count => $ksong) {
						foreach ($ksong as $key => $value){
							if ($key == 'id') $idPlaylist = $value;
							if ($key == 'title') $title = $value;
							if ($key == 'rash') $rashImg = $value;
						}
					echo '
						<div class="playlist">
							<img src="/img/playlist/',$rashImg,'" alt="">
							<div class="imgblure">
								<img src="/img/-.png" id="',$idPlaylist,'" alt="" onclick="playListAdd(this)">
								<div class="edite_btn" id="',$idPlaylist,'">
									<img src="/img/pencil.png" alt="">
								</div>
								
								<h5>',$title,'</h5>
							</div>
						</div>
						<button class="editor" id="editor_',$idPlaylist,'" name="edite[]" value="',$idPlaylist,'"></button>
						<div class="playlist_push" id="playlist',$idPlaylist,'">
							<div class="allUpp">
								<div class="close">
									<div class="close_btn" onclick="playListRemove(this)">
										<img src="/img/closedark.png" alt="">
									</div>
								
								</div>
								<div class="up_menu">
									<img src="/img/playlist/',$rashImg,'" alt="">
									<input type="text" readonly class="inp_push" value="',$title,'">
								</div>	
							</div>
							<div class="search_music">
								<input type="text" name="search_play" placeholder="What are you want?" class="search_music_input">
							</div>';
							$result = mysqli_query($link, "SELECT DISTINCT music.id, music.name, music.title, music.user, music.rash_audio, music.rash_img, music.scan, music.dmy_music FROM music, playlist, playlist_music WHERE playlist_music.id_playlist = playlist.id AND playlist_music.id_music = music.id AND playlist.id = '".$idPlaylist."' ORDER BY playlist_music.date DESC, playlist_music.id DESC");
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
									<img src="/img/playdark.png" alt="" class="play" id="play_',$idMusic,'">
									<img src="/img/imgsongs/',$imgAudio,'" alt="" class="img_song">
									<div class="titles_songs">
										<h3>',$title,'</h3>
										<h4>',$name,'</h4>
									</div>
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
						</div>';
					}
				}
				echo'

				</div>		
			</div>
			<div class="your_playlist">
				<div class="your">
					<h4>All playlist</h4>
				</div>
					<div class="list_playlist">
					';
					$result = mysqli_query($link, "SELECT * FROM `playlist` WHERE `hide` = '0'");
					for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
					foreach ($data as $count => $ksong) {
						foreach ($ksong as $key => $value){
							if ($key == 'id') $idPlaylist = $value;
							if ($key == 'title') $title = $value;
							if ($key == 'rash') $rashImg = $value;
						}
					echo '
						<div class="playlist">
							<img src="/img/playlist/',$rashImg,'" alt="">
							<div class="imgblure">
								<img src="/img/-.png" alt="" id="',$idPlaylist,'" onclick="playListAdd(this)">
								<h5>',$title,'</h5>
							</div>
						</div>
						<div class="playlist_push" id="playlist',$idPlaylist,'">
							<div class="allUpp">
								<div class="close">
									<div class="close_btn" onclick="playListRemove(this)">
										<img src="/img/closedark.png" alt="">
									</div>
								
								</div>
								<div class="up_menu">
									<img src="/img/playlist/',$rashImg,'" alt="">
									<input type="text" readonly class="inp_push" value="',$title,'">
								</div>	
							</div>
							<div class="search_music">
								<input type="text" name="search_play" placeholder="What are you want?" class="search_music_input">
							</div>

						';
						$result = mysqli_query($link, "SELECT DISTINCT music.id, music.name, music.title, music.user, music.rash_audio, music.rash_img, music.scan, music.dmy_music FROM music, playlist, playlist_music WHERE playlist_music.id_playlist = playlist.id AND playlist_music.id_music = music.id AND playlist.id = '".$idPlaylist."' ORDER BY playlist_music.date DESC, playlist_music.id DESC");
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
							</div>';
					}
				echo'

				</div>		
			</div>
		</div>
		<div class="left" onclick="clicked(\'left\')">
			<img src="/img/next.png" alt="">
		</div>
		<div class="right" onclick="clicked(\'right\')">
			<img src="/img/next.png" alt="">
		</div>
	</div>
	</form>
	<script style="text/javascript" src="/user/playlist/script.js"></script>
';


?>