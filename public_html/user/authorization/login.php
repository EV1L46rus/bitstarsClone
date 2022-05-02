<?php

function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

include '../../db.php';

if(isset($_POST['submit'])){
    $query = mysqli_query($link,"SELECT user_id, user_password, user_login FROM users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    if($data['user_password'] === md5(md5($_POST['password']))){
        $hash = md5(generateCode(10));
        $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
        mysqli_query($link, "UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");
        setcookie("id", $data['user_id'], time()+60*60*24*30, "/");
        setcookie("login", $data['user_login'], time()+60*60*24*30, "/");
        setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true);

        header("Location: check.php"); exit();
    }
    else
    {
        print "Вы ввели неправильный логин/пароль";
    }
}

include '../../setings.php';
echo '
<div class="registration_menu">
    <form method="POST">
        <br><a href="/"><img src="/img/music.png" alt=""></a><br>
        <h2>Чтобы продолжить, войдите в систему</h2>
        <h3>Логин</h3> <input name="login" type="text" required><br>
        <h3>Пароль</h3> <input name="password" type="password" required><br>
        <button name="submit" type="submit" value="Войти" class="button_log"><h3 style="background-color: rgba(0, 0, 0, 0); margin: auto;">Войти</h3></button>
        <h5>или</h5>
        <a href="/user/authorization/register.php"><div class="button_reg"><h3 style="background-color: rgba(0, 0, 0, 0); margin: auto;">Регистрация</h3></div></a>
     </form>
</div>
';
?>