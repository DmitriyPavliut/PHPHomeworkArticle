<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/posts.php';
    require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/categories.php';
    require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/authors.php';


    if ($_SERVER['REQUEST_URI'] == '/articles/') {
        $arArticles = [];
        $arPosts = [];

        if (empty($_REQUEST['page'])) {
            $arPosts = Posts::getPostsList(['ID', 'ACTIVE', 'TITLE', 'CODE', 'CATEGORY_ID'], [], [], ['limit' => 6, 'offset' => 0]);
        }

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

        $arArticles = [];
        $arPosts = [];
        if (empty($_REQUEST['page'])) {
            $arPosts = Posts::getPostsList(['ID', 'ACTIVE', 'TITLE', 'CODE', 'CATEGORY_ID'], ['CATEGORY_ID' => $arCategory['ID']], [], ['limit' => 6, 'offset' => 0]);
        }

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

        if ($arPost['ACTIVE'] == true) {
            $category = Categories::getСategory($arPost['CATEGORY_ID'], ['NAME', 'CODE']);
            $author = Authors::getAuthor($arPost['AUTHOR_ID'], ['NAME']);
            $arPost['CATEGORY_NAME'] = $category['NAME'];
            $arPost['CATEGORY_CODE'] = $category['CODE'];
            $arPost['AUTHOR_NAME'] = $author['NAME'];
        } else {
            require_once $_SERVER["DOCUMENT_ROOT"] . '/404.php';
        }
    }
