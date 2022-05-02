<?php
	
	if (isset($_POST['logout'])) {
		header("Location: ../../../user/authorization/logout.php");		
	}
	include 'db.php';
	include 'setings.php';
	
echo '
<body>
	<header>
		<div class="upbg"></div>
		<div class="upbrd"></div>
		<div class="up">
			<a href="/"><img src="/img/music.png" alt=""></a>
			<form action="" class="searchform" method="">
				<button class="bsearch"><img src="/img/search.png" alt=""></button>
				<input type="text" name="mainSearch" placeholder="What are you loocking for?">
				<select name="janr" id="">
					<option value="All">All</option>
					<option selected value="Tracks">Tracks</option>
					<option value="Musicians">Musicians</option>
					<option value="Playlists">Playlists</option>
					<option value="Albums">Albums</option>
					<option value="Services">Services</option>
				</select>
			</form>
			<div class="login">';
			if (isset($_COOKIE['hash'])) {
				echo '
				<a href="/user/">
					<button class="selling">	
						',$_COOKIE['login'],'						
					</button>
				</a>
				<form method="POST">
					<button type="logout" name="logout" class="logout"><img src="/img/logout.png" alt=""></button>
				</form>';
			} else {
				echo'
					<a href="/user/authorization/register.php">
						<button style="background: rgba(0, 0, 0, 0);" >
							Sign up
						</button>
					</a>
					<a href="/user/authorization/login.php">
						<button class="signin">
							Sign in
						</button>
					</a>
					<a href="/user/authorization/login.php">
						<button class="selling">		
							Start Selling
						</button>
					</a>
						';}
			echo'
					<div class="divider-vertical">|</div>
					<div class="cart">
						<button style="cursor: pointer; border: 0; background: url(/img/cart.png); width: 32px; height: 32px;"></button>
					</div>
			</div>
		</div>
		<div class="down">
			<div class="downmid">
				<a href="/"><div class="dbutton">Home</div></a>
				<a href="/feed/"><div class="dbutton">Feed</div></a>
				<a href="/Tracks/"><div class="dbutton">Tracks</div></a>
				<a href=""><div class="dbutton">Distribution</div></a>
				<a href=""><div class="dbutton">Publishing</div></a>
				<a href=""><div class="dbutton">Beat ID</div></a>
				<a href=""><div class="dbutton">Beats4Love</div></a>
				<a href=""><div class="dbutton">Gift Cards</div></a>
			</div>
		</div>
	</header>
';

 ?>