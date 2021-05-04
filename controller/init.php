<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/posts.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/categories.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/authors.php';

$arCategoryList=Categories::getCategoriesList(['CODE','NAME'],[],[],[]);

if (strpos($_SERVER['REQUEST_URI'], 'articles') != false && empty($_REQUEST['category'])) {
    $arArticles = [];
    $arPosts = [];

    $countPosts = Posts::countPosts();
    $pages = ceil($countPosts['COUNT'] / 6);
    $offset = empty($_REQUEST['page']) || $_REQUEST['page'] == 1 ? 0 : ($_REQUEST['page'] - 1) * 6;

    $arPosts = Posts::getPostsList(['ID', 'ACTIVE', 'TITLE', 'CODE', 'CATEGORY_ID','DATE'], [], ['DATE' => 'DESC'], ['limit' => 6, 'offset' => $offset]);

    foreach ($arPosts as $post) {
        if ($post['ACTIVE'] == true) {
            $category = Categories::getСategory($post['CATEGORY_ID'], ['NAME', 'CODE']);
            $post['CATEGORY_NAME'] = $category['NAME'];
            $post['CATEGORY_CODE'] = $category['CODE'];
            $arArticles[] = $post;
        }
    }

}

if (!empty($_REQUEST['category'])) {
    $arCategory = Categories::getCategoriesList(['ID', 'NAME'], ['CODE' => $_REQUEST['category']], [], []);
    $arCategory = $arCategory[0];
    $countPosts = Posts::countPosts(['CATEGORY_ID' => $arCategory['ID']]);
    $pages = ceil($countPosts['COUNT'] / 6);

    $arArticles = [];
    $arPosts = [];

    $offset = empty($_REQUEST['page']) || $_REQUEST['page'] == 1 ? 0 : ($_REQUEST['page'] - 1) * 6;

        $arPosts = Posts::getPostsList(['ID', 'ACTIVE', 'TITLE', 'CODE', 'CATEGORY_ID','DATE'], ['CATEGORY_ID' => $arCategory['ID']], ['DATE' => 'DESC'], ['limit' => 6, 'offset' => $offset]);


    foreach ($arPosts as $post) {
        if ($post['ACTIVE'] == true) {
            $post['CATEGORY_NAME'] = $arCategory['NAME'];
            $post['CATEGORY_CODE'] = $_REQUEST['category'];
            $arArticles[] = $post;
        }
    }

}

if (!empty($_REQUEST['idPost'])) {
    $arPost = Posts::getPost($_REQUEST['idPost'], []);

    if ($arPost!=false && $arPost['ACTIVE'] == true) {
        $category = Categories::getСategory($arPost['CATEGORY_ID'], ['NAME', 'CODE']);
        $author = Authors::getAuthor($arPost['AUTHOR_ID'], ['NAME']);
        $arPost['CATEGORY_NAME'] = $category['NAME'];
        $arPost['CATEGORY_CODE'] = $category['CODE'];
        $arPost['AUTHOR_NAME'] = $author['NAME'];
    }
}
