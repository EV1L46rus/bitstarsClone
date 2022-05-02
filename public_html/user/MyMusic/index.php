<?php 

	include '../../db.php';

	$order = '';
	$idedit = '';
	$lasttime = '?'.rand();
	

	if (isset($_GET['artist'])) {
		$order = 'ORDER BY `music`.`name` DESC';
	}

	if (isset($_GET['title'])) {
		$order = 'ORDER BY `music`.`title` DESC';
	}	

	if (isset($_GET['listening'])) {
		$order = 'ORDER BY `music`.`scan` DESC';
	}

	if (isset($_GET['date'])) {
		$order = 'ORDER BY `music`.`dmy_music` DESC';
	}

	if (isset($_GET['search_my'])){
		$searchMy = mysqli_real_escape_string($link, $_GET['search_my']);
		$resultSearch = mysqli_query($link, "SELECT * FROM `music` WHERE `user`= '".$_COOKIE['id']."' AND `title` LIKE '%".$searchMy."%' OR `user`= '".$_COOKIE['id']."' AND `name`LIKE '%".$searchMy."%' ".$order."");	
	}

	if (isset($_POST['save'])){
		foreach ($_POST['id'] as $key => $value){
			$idedit = $value;
		}
		mysqli_query($link, "UPDATE `music` SET `name` = '".$_POST['author']."', `title` = '".$_POST['title']."' WHERE `music`.`id` = '".$idedit."';");
		if($_FILES["img_file"]){
			$uploaddirimg = '../../img/imgsongs/';
			$original_name = $_FILES["img_file"]["name"];
			$extensionImg = pathinfo($original_name, PATHINFO_EXTENSION);
			$new_name = $idedit.'.'.$extensionImg;
			$uploadimg = $uploaddirimg . $new_name;
			if (move_uploaded_file($_FILES['img_file']['tmp_name'], $uploadimg));
			mysqli_query($link, "UPDATE `music` SET `rash_img` = '".$extensionImg."' WHERE `music`.`id` = '".$idedit."';");
		}

	}


	include '../../header.php';

	echo '
		<div class="body_user">
			<div class="left_menu">';
				include '../left.php';

			echo'	
			</div>
			<div class="screen">
				<form action="" class="form_up">
					<div class="search_my">
						<input name="search_my" type="text" class="input_s" placeholder="search">
						<button class="button_form">Search</button>
					</div>
				</form>
				<form action="">
					<div class="sort">
						<button class="sort_btn" name="artist">Artist</button>
						<button class="sort_btn" name="title">Title</button>
						<button class="sort_btn" name="listening">Listening</button>
						<button class="sort_btn" name="date">Date</button>
					</div>
				</form>';

					if (isset($_COOKIE['id'])){
						if (isset($resultSearch)) {
							$result = $resultSearch;
						} else {
							$result = mysqli_query($link, "SELECT * FROM `music` WHERE `user`='".$_COOKIE['id']."' ".$order."");
						}
						for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
						foreach ($data as $count => $ksong) {
							foreach ($ksong as $key => $value){
								if ($key == 'id') {
									$id = $value;
									$idName = $value;
								}

								if ($key == 'rash_img') {
									if ($value !== ''){
										$rash_img = $value;
									} else {
										$idName = 'defoult';
										$rash_img = 'png';
									}
								}
								if ($key == 'title') $title = $value;
								
								if ($key == 'name') $name = $value;
								
								if ($key =='rash_audio') $rashaudio = $value;
								if ($key == 'scan') $scan = $value;
								if ($key == 'dmy_music') $date_music = $value;
							}	

						echo'
						<div class="one_song" data-id="',$id,'" data-rash=".',$rash_img,'" data-title="',$title,'" data-name="',$name,'">
							<div class="btn_play"></div>
							<img src="/img/play.png" alt="" class="play">
							<img src="/img/imgsongs/',$idName,'.',$rash_img,$lasttime,'" alt="" class="img_song">
							<div class="author">
								<h3>',$title,'</h3>
								<h3 style="color: grey">',$name,'</h3>
							</div>
							
							<div class="info">
								<h4>Genre:&nbsp'; 
								$results = mysqli_query($link, "SELECT * FROM `genre_music` WHERE `id_music`='".$id."'");
								for ($datas = []; $rows = mysqli_fetch_assoc($results); $datas[] = $rows);
								foreach ($datas as $counts => $ksongs) {
									foreach ($ksongs as $keys => $values){
										if ($keys == 'id_genre') $id_genre = $values;		
									}
									$genre = mysqli_query($link, "SELECT * FROM `genres` WHERE `id`='".$id_genre."'");
									for ($dat = []; $rows = mysqli_fetch_assoc($genre); $dat[] = $rows);
									foreach ($dat as $cou => $son) {
										foreach ($son as $kes => $vals){
											if ($kes == 'genre'){
											echo $vals.'&nbsp';
											}		
										}
									}
								}

								echo'</h4>
								<div class="aut">
									<h5>Listening: ',$scan,'</h5>
									<h5>Date: ',$date_music,'</h5>
								</div>
							</div>
							<button class="redact" onclick="editPopUp(this)">
								<img src="/img/edit.png" alt="">
							</button>
							<button class="delete" onclick="acceptPopUp(this)">
								<img src="/img/close.png" alt="">
							</button>
							<audio 
							src="/audio/',$id,'.',$rashaudio,'"
							controls
							data-id="',$id,'"
							class="audio">
								Аудио не поддерживается
							</audio>
						</div>';
					}
				}

				echo'
			</div>
		</div>
		<div class="left" onclick="clicked(\'left\')">
			<img src="/img/next.png" alt="">
		</div>
		<div class="right" onclick="clicked(\'right\')">
			<img src="/img/next.png" alt="">
		</div>
		<script style="text/javascript" src="script.js"></script>	
	';
?>