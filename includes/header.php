<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/articles.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $title ?? 'Document';?></title>
    <meta name="description" content="News">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <link rel="stylesheet" href="css/zerogrid.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">

    <link rel="stylesheet" href="css/menu.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</head>

<body class="home-page">
<div class="wrap-body">
    <header class="">
        <div class="logo">
            <a href="#">zVintauge</a>
            <span>Collectible Vintage & Antique Photos</span>
        </div>
        <div id="cssmenu" class="align-center">
            <ul>
                <li class="active"><a href="index.php"><span>Home</span></a></li>
                <li><a href="gallery.html"><span>Gallery</span></a></li>
                <li><a href="single.html"><span>About</span></a></li>
                <li class="last"><a href="contact.html"><span>Contact</span></a></li>
            </ul>
        </div>
        <div id="owl-slide" class="owl-carousel">
            <div class="item">
                <img src="images/slide1.jpg"/>
            </div>
        </div>
    </header>