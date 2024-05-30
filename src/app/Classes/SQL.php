<?php

namespace App\Classes;

class SQL {
    public static function get_queries(): array {
        return [
            "users" => "SELECT * FROM `users`",
            "users.login" => "SELECT `login` FROM `users`",
            "newUserNoAvatar" => "INSERT INTO `users` (`login`, `name`, `password`, `email`)
                                  VALUES ('" . $_POST["login"] . "', '" . $_POST["name"] .
                                  "', '" . md5($_POST["psw"]) . "', '" . $_POST["email"] . "')",
            "newUserWithAvatar" => "INSERT INTO `users`
                                    (`login`, `name`, `password`, `email`, `avatar`)
                                    VALUES ('" . $_POST["login"] . "', '" . $_POST["name"] . "',
                                    '" . md5($_POST["psw"]) . "', '" . $_POST["email"] . "',
                                    '" . $avatarPath . "')"
        ];
    }
}