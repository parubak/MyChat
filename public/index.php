<?php

declare(strict_types=1);

try {

    // https://5minphp.ru/

    require_once __DIR__ . "/../global/bootstrap.php";

    $database = require_once __DIR__ . "/../config/database.php";

    $host = $database["host"];
    $db = $database["dbname"];
    $login = $database["login"];
    $pass = $database["password"];

    $layout = __DIR__ . "/../app/layouts/main.php";

    try {
        $dbh = new PDO(sprintf('mysql:host=%s;dbname=%s', $host, $db), $login, $pass);
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    

    $title = "Hello from our test site";
    // $header="";
    // $header = empty($_SESSION["user"])? loadView(__DIR__ . "/../app/views/header.php"):loadView(__DIR__ . "/../app/views/headerin.php");
    // loadView(__DIR__ . "/../app/views/header.php");
    $footer = loadView(__DIR__ . "/../app/views/footer.php");

    $uri = trim($_SERVER['REQUEST_URI'], "?");

    $routes = require_once __DIR__ . "/../routes/web.php";

    $found = false;

    if (!empty($routes[$uri])) {
        $route = $routes[$uri];
        // $_SERVER['REQUEST_URI'] == "/news"
        // $_SERVER["REQUEST_METHOD"] == GET
        // $_SERVER["REQUEST_METHOD"] == POST

        if (!empty($route[$_SERVER["REQUEST_METHOD"]])) {
            $data = $route[$_SERVER["REQUEST_METHOD"]];

            if (!empty($data["layout"])) {
                $layout = $data["layout"];
            }


            $content = call_user_func($data['handler']);
            $found = true;
        }
    }

    if (!$found) {
        echo 404;
        die();
        // 404
        // or 301 redirect
        //    header("HTTP/1.1 301 Moved Permanently");
        //    header("Location: /");
        //    exit(); // die();
    }

    require_once $layout;
} catch (Throwable $e) {
    $date = date("Y-m-d H:i:s");
    $logStr = sprintf("[%s] %s File: %s, Line: %s" . PHP_EOL, $date, $e->getMessage(), $e->getFile(), $e->getLine());
    file_put_contents(__DIR__ . "/../storage/log.txt", $logStr, FILE_APPEND);
    require_once __DIR__ . "/../app/layouts/errors/500.php";
}
