<?php

namespace App\Classes;

class Post {
    private $mysql;

    public function __construct($action) {
        $this->mysql = new \mysqli("127.0.0.1", "root", "", "main");
        $queries = SQL::get_queries();
        if ($action === "registration") {
            $query = $this->mysql->query($queries["users.login"]);
            if (!$_POST["login"] or !$_POST["name"] or !$_POST["psw"] or !$_POST["email"]) {
                die(
                '<link rel="stylesheet" href="/views/css/__components/flex_container.css">
                <div class="container">
                    <div>Поля 
                    <b>логин, имя, пароль и email</b> 
                    не должны быть пустыми или равными <b>нулю</b>!<br>
                        <h2 class="container">
                                <a href="/reg">
                                    <b><i>Пройдите регистрацию повторно.</i></b>
                                </a>
                        </h2>
                    </div>
                </div>'
                );
            } else {

                $arr = [];

                while ($subArr = $query->fetch_assoc()) {
                    $arr[] = $subArr;
                }
                if ($arr) {
                    foreach ($arr as $subArr) {
                        if ($subArr["login"] === $_POST["login"])
                            die(
                '<link rel="stylesheet" href="/views/css/__components/flex_container.css">
                <div class="container">
                    <div>
                        <h1>
                            Такой пользователь уже существует!
                        </h1>
                        <h2 class="container">
                                <a href="/reg">
                                    <b><i>Пройдите регистрацию повторно.</i></b>
                                </a>
                        </h2>
                    </div>
                </div>'
                    );
                    }
                }
                if (strlen($_POST["login"]) > 50 or strlen($_POST["name"]) > 50
                    or strlen($_POST["email"]) > 100 or strlen($_POST["psw"]) > 32) {
                    die(
                '<link rel="stylesheet" href="/views/css/__components/flex_container.css">
                <div class="container">
                    <div>
                        <h1>
                            В каком-то из полей слишком много символов!
                        </h1>
                        <h2 class="container">
                                <a href="/reg">
                                    <b><i>Пройдите регистрацию повторно.</i></b>
                                </a>
                        </h2>
                    </div>
                </div>'
                );
                }
                if ($_FILES["avatar"]["error"]) {
                    $this->mysql->query($queries["newUserNoAvatar"]);
                } else {
                    $avatarPath = "./avatars/" . time() . $_FILES["avatar"]["name"];
                    move_uploaded_file($_FILES["avatar"]["tmp_name"], $avatarPath);
                    $this->mysql->query($queries["newUserWithAvatar"]);
                }
                die(
                '<link rel="stylesheet" href="/views/css/__components/flex_container.css">
                <div class="container">
                    <div>
                        <h1>
                            Вы успешно зарегистрированы в системе!
                        </h1>
                        <h2 class="container">
                                <a href="/auth">
                                    <b><i>Войти в мой аккаунт.</i></b>
                                </a>
                        </h2>
                    </div>
                </div>'
                );
            }
        } elseif ($action === "authorization") {
            $query = $this->mysql->query($queries["users"]);
            if (!$_POST["login"] or !$_POST["psw"]) {
                die(
                '<link rel="stylesheet" href="/views/css/__components/flex_container.css">
                <div class="container">
                    <div>Поля 
                    <b>логин и пароль</b> не должны быть пустыми или равными <b>нулю</b>!<br>
                        <h2 class="container">
                                <a href="/auth">
                                    <b><i>Пройдите авторизацию повторно.</i></b>
                                </a>
                        </h2>
                    </div>
                </div>'
                );
            }
            else {
                $arr = [];

                while ($subArr = $query->fetch_assoc()) {
                    $arr[] = $subArr;
                }
                if ($arr) {
                    foreach ($arr as $subArr) {
                        if ($subArr["login"] === $_POST["login"]
                        and md5($_POST["psw"]) === $subArr["password"])
                            die(
                '<link rel="stylesheet" href="/views/css/__components/flex_container.css">
                <div class="container">
                    <h1>Добро пожаловать, ' . $subArr["login"] . '!</h1>
                </div>'
                    );
                    }
                }
            }
        }
    }
}