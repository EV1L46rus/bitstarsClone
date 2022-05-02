<?php 
	include "../../db.php";
	$uploadDir = '../../audio/';
	$uploaddirimg = '../../img/imgsongs/';
	$hashuser = $_COOKIE['hash'];
	$lasttime = '?'.rand();

	if(isset($_POST['submit'])){
		if ($_FILES["music_file"]["name"] !== ''){
			$original_name = $_FILES["music_file"]["name"];
			$extension = pathinfo($original_name, PATHINFO_EXTENSION);
			$new_name = $hashuser.'.'.$extension;
			$uploadfile = $uploadDir . $new_name;
			if (move_uploaded_file($_FILES['music_file']['tmp_name'], $uploadfile));{
				if ($_FILES["music_file"]["name"] !== ''){
					$original_name = $_FILES["img_file"]["name"];
					$extensionImg = pathinfo($original_name, PATHINFO_EXTENSION);
					$new_name = $hashuser.'.'.$extensionImg;
					$uploadimg = $uploaddirimg . $new_name;
					if (move_uploaded_file($_FILES['img_file']['tmp_name'], $uploadimg));
				}
			}

			$author = $_POST['author'];
			$title = $_POST['title'];
			mysqli_query($link, "INSERT INTO `music` (`id`, `name`, `title`, `user`, `rash_audio`, `rash_img`, `scan`, `dmy_music`, `hm`) VALUES (NULL, '".$author."', '".$title."', '".$hashuser."', '".$extension."', '".$extensionImg."', '', '".date('d.m.y')."', '".date('g:i')."')");

			if (isset($_POST['radio'])) {
				mysqli_query($link, "UPDATE `music` SET `id_type` = '".$_POST['radio']."' WHERE `music`.`user` = '".$hashuser."';");
			}

	 		if (isset($_POST['genres_ids'])){
		 		foreach ($_POST['genres_ids'] as $key => $value){
		 			mysqli_query($link, "INSERT INTO `genre_music` (`id_genre`, `id_music`) VALUES ('".$value."', '".$_COOKIE['hash']."');");
		 		}
	 		}
			header("Location: /user/add/accept.php"); exit();
		}
	}

	include "../../header.php";
	
	echo '
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	<div class="body_user">
		<div class="left_menu">	
		';
			include '../left.php';
		echo'	
		</div>
		<div class="screen">
			<div class="upload_file" >
				<form enctype="multipart/form-data" action="" method="POST" action="../.ndex.php">
					<div class="upploadAudio" id="change_bg">
					    <input type="file" name="music_file" id="file" class="input-file" accept="audio/*">
					    <h2>Add audio</h2>
					</div>
					<div class="song_name">
						<div class="add_img">
						      <input onchange="replaceImg(this)" type="file" name="img_file" accept="image/*" id="change_img">
						      <img src="/img/imgsongs/defoult.png',$lasttime,'" alt="" id="avatar">
						      <div class="upper_laer">
						      		<h3>Add photo</h3>
						      </div>
						</div>    
						<div class="param">
							<h3>Автор:</h3>
							<input name="author" type="text" required class="input_value" value="',$_COOKIE['login'],'">
							<h3>Название:</h3>
							<input name="title" type="text" required class="input_value" value="Unknown">
						</div>
						<div class="type_uppload">
								<h4>Type</h4>';

							$result = mysqli_query($link, "SELECT * FROM `types`");
							for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
							foreach ($data as $count => $ksong) {
								foreach ($ksong as $key => $value){
									if ($key == 'id') $id_type = $value;
									if ($key == 'name') $type_name = $value;
								}

							echo'
								<div class="element">
									<input class="input_radio" type="radio" id="radio_',$id_type,'" name="radio" value="',$id_type,'">
									<label class="radio_label" for="radio_',$id_type,'">',$type_name,'</label>
								</div>';
							}
							echo '
							
							</div>
					<div class="check_genre">
					<h4>Genres</h4>
					<div class="genre_list">';

					$result = mysqli_query($link, "SELECT * FROM `genres`");
					for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
					foreach ($data as $count => $ksong) {
						foreach ($ksong as $key => $value){
							if ($key == 'id')$idGenre = $value;
							if ($key == 'genre') {
								echo '
								<div class="genre">
									<input value="',$idGenre,'" name="genres_ids[]" class="inpt_check" type="checkbox" id="checkbox_',$idGenre,'">
									<label class="lbl_check" for="checkbox_',$idGenre,'">',$value,'</label>
								</div>';
							}
						}
					}

				echo'	
					</div>						
					</div>
					<input class="btn_upload" name="submit" type="submit" value="Отправить">
				</form>
			</div>
		</div>
	</div>
	<script style="text/javascript" src="/user/add/script.js"></script>
	';
?>