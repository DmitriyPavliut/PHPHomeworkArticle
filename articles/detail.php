<?php
    $title = 'Детальнее';
    require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/header.php';
$arPost = Posts::getPost($_REQUEST['idPost'], []);

if(isset($arPost) && $arPost==false || $arPost['ACTIVE'] == false){
    require_once $_SERVER["DOCUMENT_ROOT"] . '/404.php';
}

?>
    <section id="container">
        <div class="wrap-container">
            <div id="main-content">
                <div class="wrap-content">
                    <div class="row">
                        <article class="single-post zerogrid">
                            <div class="row wrap-post"><!--Start Box-->
                                <div class="entry-header">
                                    <span class="time"><?= date('F j, Y', strtotime($arPost['DATE'])); ?></span>
                                    <span class="time">Автор: <?= $arPost['AUTHOR_NAME']; ?></span>
                                    <h2 class="entry-title"><?= $arPost['TITLE']; ?></h2>
                                    <span class="cat-links"><a href="/articles/<?= $arPost['CATEGORY_CODE'] ?>"><?= $arPost['CATEGORY_NAME']; ?></a></span>
                                </div>
                                <div class="post-thumbnail-wrap">
                                    <img src="/images/slide2.jpg">
                                </div>
                                <div class="entry-content">
                                    <div class="excerpt"><p><?= $arPost['CONTENT'] ?></p></div>

                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php';
?>