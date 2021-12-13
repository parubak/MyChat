<?php

/**
 * @var $title
 * @var $header
 * @var $content
 * @var $footer
 */
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/css/style.css" media="screen" type="text/css" />


    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/5.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title><?= $title ?></title>
</head>

<body>
    <div class="container">
        <?= $header??"" ?>

        <?= $content??""?>

        <?= $footer??""?>

    </div>
</body>

</html>
