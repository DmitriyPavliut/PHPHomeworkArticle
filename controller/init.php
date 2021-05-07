<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/posts.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/categories.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/authors.php';

$arCategoryList = Categories::getCategoriesList(['CODE', 'NAME'], [], [], []);