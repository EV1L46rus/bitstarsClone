<?php 
	include '../db.php';
	include '../header.php';

	$number = 0;
	$pastTitle = "Udefinde";
	
	

	echo '
	<form action="" method="POST">
		<div class="Tracks_bg">
			<div class="audio_filtres_list">
				<div class="tracks_filters">
					<div class="menu_lvl_one">
						<button class="buttonAll" name="top_chart">
							<h3>Top chart</h3>
						</button>
						<button class="buttonAll" name="for_you">
							<h3>Top4You</h3>
						</button>
						<div class="pushMenu" onclick="pushBtn(this)">
							<div class="divAll">
								<h4>Genre</h4>
								<img src="/img/push.png" alt="">
							</div>
						</div>
					</div>
					<div class="menu_lvl_2">
						<button class="select_genre" name="filtr_genre[]" value="1">
							<h3>Hip Hop</h3>
						</button>
						<button class="select_genre" name="filtr_genre[]" value="2">
							<h3>Trap</h3>
						</button>
						<button class="select_genre" name="filtr_genre[]" value="3">
							<h3>Rnb</h3>
						</button>
						<button class="select_genre" name="filtr_genre[]" value="4">
							<h3>Pop</h3>
						</button>
						<div class="showMore" onclick="showMore()">
							+ Show more
						</div>
					</div>
					<div class="menu_lvl_2_hide">';
					$result = mysqli_query($link, "SELECT * FROM `genres`");
					for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
					foreach ($data as $count => $ksong) {
						foreach ($ksong as $key => $value){
							if ($key == 'id') $id = $value;
							if ($key == 'genre') $genre = $value;
						}
					
					echo '
						<button class="select_genre" name="filtr_genre[]" value="',$id,'">
							<h3>',$genre,'</h3>
						</button>
						
					';
					}

				echo '	
						<div class="showMore" id="hide" onclick="hideMore()">
							- hide
						</div>
					</div>
					<div class="pushMenuType" onclick="pushBtnType(this)">
							<div class="divAllBg">
								<div class="divAll">
									<h4>Type</h4>
									<img src="/img/push.png" alt="">
								</div>
							</div>
							<div class="menu_lvl_2_type">';
							$result = mysqli_query($link, "SELECT * FROM `types`");
							for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
							foreach ($data as $count => $ksong) {
								foreach ($ksong as $key => $value){
									if ($key == 'id') $id = $value;
									if ($key == 'name') $type = $value;
								}
							echo '
								<button class="select_genre" name="filtr_type[]" value="',$id,'">
									<h3>',$type,'</h3>
								</button>';
							}
							echo'
							</div>
					</div>
				</div>
				<div class="audio_list">
					<div class="top_chart">
						<h1>Audio List</h1>
					</div>
					<div class="songs_list">
					';

					if (isset($_POST['top_chart'])){
						$result = mysqli_query($link, "SELECT * FROM `music` ORDER BY `music`.`scan` DESC");
						include 'onesong.php';
					} elseif (isset($_POST['for_you'])) {
						if (isset($_COOKIE['id'])) {						
							$result = mysqli_query($link, "SELECT DISTINCT music.id, music.name, music.title, music.user, music.rash_audio, music.rash_img, music.scan, music.dmy_music, music.hm, music.id_type FROM music, genre_user, genre_music WHERE genre_music.id_genre = genre_user.id_genre AND music.id = genre_music.id_music AND genre_user.id_user = '".$_COOKIE['id']."' ORDER BY music.scan DESC");
							include 'onesong.php';
						}
					} elseif (isset($_POST['filtr_genre'])){
						foreach ($_POST['filtr_genre'] as $key => $value){
							$result = mysqli_query($link, "SELECT DISTINCT music.id, music.name, music.title, music.user, music.rash_audio, music.rash_img, music.scan, music.dmy_music, music.hm, music.id_type FROM music, genre_music WHERE genre_music.id_genre = '".$value."' AND music.id = genre_music.id_music ORDER BY music.scan DESC");
							include 'onesong.php';
						}
					} elseif (isset($_POST['filtr_type'])){
						foreach ($_POST['filtr_type'] as $key => $value){
							$result = mysqli_query($link, "SELECT * FROM `music` WHERE `id_type` = '".$value."' ORDER BY music.scan DESC");
							include 'onesong.php';
						}
					} else {
						$result = mysqli_query($link, "SELECT * FROM `music` ORDER BY `music`.`scan` DESC");
						include 'onesong.php';
					}
		echo '
						</div>	
						<div class="left" onclick="clicked(\'left\')">
							<img src="/img/next.png" alt="">
						</div>
						<div class="right" onclick="clicked(\'right\')">
							<img src="/img/next.png" alt="">
						</div>
							
				</div>
			</div>
		</div>
	</form>	
	<script style="text/javascript" src="script.js"></script>	
	';


?>