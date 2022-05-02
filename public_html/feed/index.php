<?php 
	include '../db.php';

	$lasttime = '?'.rand();

	if (isset($_POST['btn_send'])){
		foreach ($_POST['btn_send'] as $key => $value){
			$idAudio = $value;
		}
		if(isset($_COOKIE['id'])){
			if ($_POST[$idAudio] !== ''){
				mysqli_query($link, "INSERT INTO `coments` (`id`, `id_music`, `id_user`, `text`, `date`) VALUES (NULL, '".$idAudio."', '".$_COOKIE['id']."', '".$_POST[$idAudio]."', '".date('d.m.y')."')");
			}
		}
	}

	include '../header.php';
	echo '
	<form action="" method="POST">
	<div class="all_screen">
		<h2>NEWS</h2>
		<div class="screen" >';
		$result = mysqli_query($link, "SELECT * FROM `music` ORDER BY `music`.`dmy_music` DESC, `music`.`hm` DESC");
		for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
		foreach ($data as $count => $ksong) {
			foreach ($ksong as $key => $value){
				if ($key == 'id') {
					$id = $value;
					$imgRash = $value;
				}
				if ($key == 'rash_img') {
					if ($value !== '') {
						$imgAudio = $id.'.'.$value.$lasttime;
					} else {
						$imgAudio = 'defoult.png'.$lasttime;
					}
				}

				if ($key == 'title') $title = $value;
				
				if ($key == 'name') $name = $value;

				if ($key == 'user') {
					$id_user = 'avatars/'.$value;
					$feedNews = mysqli_query($link, "SELECT * FROM `users` WHERE `user_id` = ".$value."");
					for ($data = []; $row = mysqli_fetch_assoc($feedNews); $data[] = $row);
					foreach ($data as $count => $kuser) {
						foreach ($kuser as $keys => $values){
							if ($keys == 'user_login') $log = $values;
							if ($keys == 'user_img'){
								$img_user = $values;
								if ($values == '') {
									$id_user = 'avatars';
									$img_user = 'png';
								}
							}
						}
					}
				}
				
				if ($key =='rash_audio') $rashaudio = $value;
				if ($key == 'dmy_music') $dmy_music = $value;
				if ($key == 'hm') $hm = $value;

			}
			echo'
			<div class="feed_one">
				<div class="up_feed">
					<img src="/img/',$id_user,'.',$img_user.$lasttime,'" alt="">
					<h2>',$log,'</h2>
					<div class="date">
						<h4>',$dmy_music,'</h4>
						<h4>',$hm,'</h4>
					</div>
				</div>
				<div class="bottom_feed">
					<div class="song_mrgn">
						<div class="btn_play"></div>
						<img src="/img/play.png" alt="" class="play_btn">
						<img src="/img/imgsongs/',$imgAudio,'" alt="" class="avatar_audio">
						<div class="titles_songs">
						<h3>',$title,'</h3>
						<h4>',$name,'</h4>
						</div>
						<div class="genre">
							<div class="btn_genre">
								<h5>Hip-hop</h5>
							</div>
							<div class="btn_genre">
								<h5>Rap</h5>
							</div>
						</div>
					</div>
				</div>
				<div class="coment">
					<div class="one_coment">';
					$results = mysqli_query($link, "SELECT DISTINCT coments.id, coments.id_music, coments.id_user, coments.text, coments.date, users.user_img, users.user_login FROM music, coments, users WHERE coments.id_music = '".$id."' AND users.user_id = coments.id_user ORDER BY `coments`.`date` DESC, `coments`.`id` DESC");
					for ($datas = []; $rows = mysqli_fetch_assoc($results); $datas[] = $rows);
					foreach ($datas as $counts => $ksongs) {
						foreach ($ksongs as $keys => $values){
							if ($keys == 'id_user') $idUser = $values;
							if ($keys == 'text') $text = $values;
							if ($keys == 'date') $date = $values;
							if ($keys == 'user_img') {
								if ($values !== '') {
									$imgComent = 'avatars/'.$idUser.'.'.$values;
								} else {
									$imgComent = 'avatars.png';
								}
							}
							if ($keys == 'user_login') $login = $values;
						}
						echo'
						<div class="one_com_full">
							<div class="one_com_up">
								<img src="/img/',$imgComent.$lasttime,'" alt="">
								<h3>',$login,'</h3>
								<h4>',$date,'</h4>
							</div>
							<div class="text">
								',$text,'
							</div>
						</div>';
					}

					echo'
						<div class="write_com">
							<textarea name="',$id,'" id="" cols="30" class="inp_com" rows="10" placeholder="Сomment"></textarea>
							<button class="btn_send" name="btn_send[]" value="',$id,'">
								<img src="/img/send-message.png" alt="">
							</button>
						</div>
					</div>
				</div>	
				<audio 
					src="/audio/',$id,'.',$rashaudio,'"
					controls
					data-id="',$id,'"
					class="audio">
						Аудио не поддерживается
				</audio>
			</div>';}
			echo'
			<div class="left" onclick="clicked(\'left\')">
				<img src="/img/next.png" alt="">
			</div>
			<div class="right" onclick="clicked(\'right\')">
				<img src="/img/next.png" alt="">
			</div>
		</div>
	</div>
	</form>
	<script style="text/javascript" src="script.js"></script>	
	';
?>