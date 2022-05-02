<?php
include '../../db.php';

if(isset($_POST['submit'])) {

    $err = [];

    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }

    $query = mysqli_query($link, "SELECT user_id FROM users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }

    if(count($err) == 0)
    {

        $login = $_POST['login'];

        $email = $_POST['email'];

        $password = md5(md5(trim($_POST['password'])));

        mysqli_query($link,"INSERT INTO users SET user_login='".$login."', user_email='".$email."', user_password='".$password."'");
        header("Location: ../authorization/login.php"); exit();
    }
    else
    {
        print "<b>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
    }
}

include '../../setings.php';
echo '
<div class="registration_menu">
    <form method="POST" action="">
    <br><a href="/"><img src="/img/music.png" alt=""></a><br>
    <h2 style="cursor: default;">Завести учетную запись</h2>
    <h5 style="cursor: default;">Создайте учетную запись BeatStars и начинайте монетизировать свои биты!</h5><br>
    <h3>Логин</h3> <input name="login" type="text" required>
    <h3>Email</h3> <input name="email" type="email" required>
    <h3>Пароль</h3> <input name="password" type="password" required>
    <button name="submit" type="submit" class="button_reg"><h3 style="background-color: rgba(0, 0, 0, 0); margin: auto;">Регистрация</h3></button>
    <div class="button_login"><h5>или &nbsp&nbsp;</h5><a href="/user/authorization/login.php"><h5>Войти</h5></a></div>  
    </form>
</div>

';

?>