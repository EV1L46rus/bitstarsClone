<?php 

	include '../db.php';

	$mail = '';

	if (isset($_POST['but_pass'])) {
		$result = mysqli_query($link, "SELECT * FROM `users` WHERE `user_hash` = '".$_COOKIE['hash']."'");

		if (isset($_POST['login'])) {
			for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
			foreach ($data as $count => $datainfo) {
				foreach ($datainfo as $key => $value){
					if ($key == 'user_login') {
						if ($value !== $_POST['login']){
							mysqli_query($link, "UPDATE `users` SET `user_login` = '".$_POST['login']."' WHERE `users`.`user_hash` = '".$_COOKIE['hash']."';");
						header("Location: authorization/logout.php"); exit;
						}
					}
					if ($key == 'user_email') {
						if ($value !== $_POST['email']) {
							mysqli_query($link, "UPDATE `users` SET `user_email` = '".$_POST['email']."' WHERE `users`.`user_hash` = '".$_COOKIE['hash']."';");
						}
					}
				}
			}
		}

		if (isset($_POST['oldpassword'])){ 

			$result = mysqli_query($link, "SELECT * FROM `users` WHERE `user_hash` = '".$_COOKIE['hash']."'");
			for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
			foreach ($data as $count => $datainfo) {
				foreach ($datainfo as $key => $value){
					if ($key = 'user_password'){
						if($value === md5(md5($_POST['oldpassword']))){
							mysqli_query($link, "UPDATE `users` SET `user_password` = '".md5(md5($_POST['newpassword']))."' WHERE `users`.`user_hash` = '".$_COOKIE['hash']."';");
							header("Location: authorization/logout.php"); exit;
						}
					}
				}
			}
		}
		mysqli_query($link, "DELETE FROM `genre_user` WHERE `id_user` = ".$_COOKIE['id']." ;");
 		if (isset($_POST['genres_ids'])){
	 		foreach ($_POST['genres_ids'] as $key => $value){
	 			mysqli_query($link, "INSERT INTO `genre_user` (`id_genre`, `id_user`) VALUES ('".$value."', '".$_COOKIE['id']."');");
	 		}
 		}
	}

	if (isset($_POST['upload'])){
		if(isset($_COOKIE['id']) and isset($_COOKIE['hash'])){
			$uploaddirimg = '../img/avatars/';
			$original_name = $_FILES["img_file"]["name"];
			$extensionImg = pathinfo($original_name, PATHINFO_EXTENSION);
			$new_name = $_COOKIE['id'].'.'.$extensionImg;
			$uploadimg = $uploaddirimg . $new_name;
			if (move_uploaded_file($_FILES['img_file']['tmp_name'], $uploadimg));
			mysqli_query($link, "UPDATE `users` SET `user_img` = '".$extensionImg."' WHERE `users`.`user_hash` = '".$_COOKIE['hash']."';");
		}
	}

	if (isset($_COOKIE['hash'])) {
		$result = mysqli_query($link, "SELECT `user_img` FROM `users` WHERE `user_hash`= '".$_COOKIE['hash']."'");
		for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
		foreach ($data as $count => $ksong) {
			foreach ($ksong as $key => $value){
				if ($key == 'user_img') {
					if ($value !== '')$img = $value;
				}
			}
		}
		$result = mysqli_query($link, "SELECT `user_email` FROM `users` WHERE `user_hash`= '".$_COOKIE['hash']."'");

		for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
		foreach ($data as $count => $ksong) {
			foreach ($ksong as $key => $value){
				if ($key == 'user_email')$mail = $value;				
			}
		}
	}

	if (isset($img)) {
		if (isset($_COOKIE['id'])){
			$dir =  'avatars/'. $_COOKIE['id'].'.'.$img;
		}
	} else {
		$dir = 'avatars.png';
	}

	include '../header.php';
		
echo '
	<div class="body_user">
		<div class="left_menu">
			';
			include 'left.php';
			$lasttime = '?'.rand();
echo'		
		</div>
		<div class="screen">
			<div class="scr_user">
				<div class="upper">
					<form enctype="multipart/form-data" class="avatars" method="POST">
						<div class="photo">
							<input onchange="replaceImg(this)" class="upload_img" id="infile" type="file" name="img_file" accept="image/*">
							<div class="clicked_btn">
								<img src="/img/',$dir,$lasttime,'" alt="" id="avatar">
								<div class="change">
									<h3>Change<br>photo</h3>
								</div>
							</div>
						</div>
						<button class="accept" name="upload">
							<h4>Apply</h4>
						</button>
					</form>

					<div class="inpt_str">
						<form action="" method="POST" class="form_log" id="all_save">
							<h4>Login</h4>
							<input name="login" class="data" type="text" value="',$_COOKIE['login'],'">
							<h4>Email</h4>
							<input name="email" class="data" type="email" value="',$mail,'">				
							<button onclick="openPassword()" class="cp" name="change">
								<h4>Change password</h4>
							</button>
						
					</div>
				<div class="check_genre">
					<h4>Favorite genres</h4>
					<div class="genre_list">';
					$result = mysqli_query($link, "SELECT * FROM `genres`");

					for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
					foreach ($data as $count => $ksong) {
						foreach ($ksong as $key => $value){
							if ($key == 'id'){
								$idGenre = $value;
								$checked = '';
								$sql = mysqli_query($link, "SELECT * FROM `genre_user` WHERE `id_user` = ".$_COOKIE['id']." AND `id_genre` = ".$value."");
								$sov = mysqli_fetch_assoc($sql);
								if($sov['id_genre'] == $value) $checked = 'checked';
							}
							if ($key == 'genre') {
								echo '
								<div class="genre">
									<input ',$checked,' value="',$idGenre,'" name="genres_ids[]" class="inpt_check" type="checkbox" id="checkbox_',$idGenre,'">
									<label class="lbl_check" for="checkbox_',$idGenre,'">',$value,'</label>
								</div>';
							}
						}
					}
					

				echo'		
					</div>	
					</form>
				</div>
				</div>
				<div class="btn_save">
					<button class="" name="but_pass" form="all_save">
						<h2>Save</h2>
					</button>	
				</div>
			</div>
		</div>
	</div>
	<script style="text/javascript" src="/user/script.js"></script>	
	';
?>