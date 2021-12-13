<?php
declare(strict_types=1);

const HTTP_GET = "GET";
const HTTP_POST = "POST";


class ValidateException extends Exception
{
}

return [
    "/history" => [
        HTTP_GET => [

            "layout" => __DIR__ . "/../app/layouts/clin.php",
            "handler" => function () use ($dbh) {
                $mess = [];
                foreach ($dbh->query('SELECT * from messages where HOUR(NOW()) >= HOUR(date)-3
                and (DAY(NOW())=DAY(date)
                and YEAR(NOW())=YEAR(date))') as $r) {
                    $mess[] = $r;
                }

                if(empty($mess))return;
                return loadView(__DIR__ . "/../app/views/history.php", [
                    "mess" => $mess,
                ]);
            }
        ],
    ],

    "/chat" => [ 
        HTTP_GET => [
            "handler" => fn () => loadView(__DIR__ . "/../app/views/chat.php", [
                "header" =>  loadView(__DIR__ . "/../app/views/header.php")
            ])
        ],
        HTTP_POST => [
            "handler" => function () use ($dbh) {
                if (empty($_POST["message"])) redirect301("/chat");

                try {
                    $author = $_SESSION["user"]["email"] ?? throw new ValidateException("author is empty");
                    $text = $_POST["message"] ?? throw new ValidateException("body is empty");

                    $stmt = $dbh->prepare("
                        INSERT INTO messages (author, text)
                        VALUES (:author, :text)");
                    $stmt->bindParam(':author', $author);
                    $stmt->bindParam(':text', $text);

                    $stmt->execute();

                } catch (ValidateException $e) {
                    return loadView(__DIR__ . "/../app/views/chat.php", [
                        "error" => $e->getMessage(),
                        "header" =>  loadView(__DIR__ . "/../app/views/header.php")
                    ]);
                }
            }
        ]
    ],
    "/logout" => [
        HTTP_GET => [
            "handler" => function () {
                $_SESSION = [];
                redirect301("/");
            }
        ]

    ],
    "/signup" => [
        HTTP_GET => [
            "handler" => fn () => loadView(__DIR__ . "/../app/views/signup.php", [
                "header" =>  loadView(__DIR__ . "/../app/views/headerin.php")
            ])
        ],
        HTTP_POST => [
            "handler" => function () use ($dbh) {
                try {
                    $email = trim($_POST["email"]) ?? throw new ValidateException("Email is empty");
                    $password = trim($_POST["password"]) ?? throw new ValidateException("Password is empty");
                    $rpassword = trim($_POST["repeat_password"]) ?? throw new ValidateException("Repeat password is empty");
                    if ($email == "" || $password == "" || $rpassword == "") {
                        throw new ValidateException("there are empty fields");
                    }
                    if ($password !== $rpassword) {
                        throw new ValidateException("different passwords");
                    }

                    $stmt = $dbh->prepare("SELECT * FROM users WHERE email=?");
                    $stmt->execute([$email]);
                    $user = $stmt->fetch();

                    !$user ?: throw new ValidateException("User exist");

                    $passwordHashed = hash("sha256", $password);

                    $stmt = $dbh->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $passwordHashed);
                    $stmt->execute();

                    redirect301("/");
                } catch (ValidateException $e) {
                    return loadView(__DIR__ . "/../app/views/signup.php", [
                        "error" => $e->getMessage(),
                        "header" =>  loadView(__DIR__ . "/../app/views/headerin.php")
                    ]);
                }
            }
        ]
    ],
    "/" => [
        HTTP_GET => [
            "handler" => fn () => loadView(__DIR__ . "/../app/views/login.php", [
                "header" =>  loadView(__DIR__ . "/../app/views/header.php")
            ]),
        ],
        HTTP_POST => [
            "handler" => function () use ($dbh) {
                try {
                    $email = trim($_POST["email"]) ?? throw new ValidateException("email is empty");
                    $password = trim($_POST["password"]) ?? throw new ValidateException("password is empty");
                    if ($email == "" || $password == "") {
                        throw new ValidateException("there are empty fields");
                    }

                    // запрос к базе данных
                    $stmt = $dbh->prepare("SELECT * FROM users WHERE email=?");
                    $stmt->execute([$email]);
                    $user = $stmt->fetch();

                    if ($user === false) {
                        throw new ValidateException("user and password is not correct");
                    }

                    $passwordHashed = hash("sha256", $password);
                    if ($user["password"] !== $passwordHashed) {
                        throw new ValidateException("password is not correct");
                    }

                    $_SESSION["user"] = [
                        "email" => $user["email"]
                    ];

                    redirect301("/chat");
                } catch (ValidateException $e) {
                    return loadView(__DIR__ . "/../app/views/login.php", [
                        "error" => $e->getMessage(),
                        "header" =>  loadView(__DIR__ . "/../app/views/header.php")
                    ]);
                }
            }
        ]
    ]
];
