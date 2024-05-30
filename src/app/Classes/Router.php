<?php

namespace App\Classes;

class Router {
    private static $arr = [];

    public static function page($uri, $page_name) {
        self::$arr[] = [
            "uri" => $uri,
            "page" => $page_name
        ];
    }

    public static function post($uri) {
        self::$arr[] = [
            "uri" => $uri,
            "post" => true
        ];
    }

    public static function enable() {
        $query = $_GET["query"];
        foreach(self::$arr as $item) {
            if ($item["uri"] === "/" . $query) {
                if ($_SERVER["REQUEST_METHOD"] === "POST" and $item["post"]) {
                    new Post($query);
                    die();
                }
                if ($item["page"]) {
                    require_once "views/pages/" . $item["page"] . ".html";
                    die();
                }
            }
        }

        require_once "views/pages/__errors/404.html";
    }
}