<?php  
	setcookie("id", "", time() - 3600*24*30*12, "/");
	setcookie("login", "", time() - 3600*24*30*12, "/");
	setcookie("hash", "", time() - 3600*24*30*12, "/",null,null,true);

	header("Location: ../../user/authorization/check.php"); exit;
?>