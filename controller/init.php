<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/posts.php';
    require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/categories.php';
    require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/authors.php';


    if($_SERVER['REQUEST_URI']=='/articles/') {
        $arArticles=[];
        $arPosts = Posts::getPostsList(['ID', 'TITLE', 'CODE', 'CATEGORY_ID'], [], [], []);
        foreach($arPosts as $post){
            $category=Categories::getСategory($post['CATEGORY_ID'], ['NAME']);
            $post['CATEGORY_NAME']=$category['NAME'];
            $arArticles[]=$post;
        }

    }
