<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/init.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $title ?? 'Document';?></title>
    <meta name="description" content="News">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <link rel="stylesheet" href="../css/zerogrid.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/menu.css">

    <link rel="stylesheet" href="../css/menu.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="../js/script.js"></script>
</head>

<body class="home-page">
<div class="wrap-body">
    <header class="">
        <div class="logo">
            <a href="/">zVintauge</a>
            <span>Collectible Vintage & Antique Photos</span>
        </div>
        <div id="cssmenu" class="align-center">
            <ul>
                <li class="active"><a href="/"><span>Home</span></a></li>
                <li class="active"><a href="/articles"><span>Articles</span></a></li>
                <li class="active"><a href="/contact"><span>Contact</span></a></li>
            </ul>
        </div>

    </header>