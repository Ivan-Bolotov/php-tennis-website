<?php

use App\Classes\Router as R;

$arr = ["famous_tennis_players",
        "famous_tennis_players/novak_djokovic",
        "famous_tennis_players/rafael_nadal",
        "famous_tennis_players/roger_federer",
        "reg",
        "auth"]; // pages

R::page("/", "index"); // main page

foreach($arr as $i) {
    R::page("/{$i}", "{$i}"); // other pages
}

R::post("/registration");
R::post("/authorization");

R::enable();