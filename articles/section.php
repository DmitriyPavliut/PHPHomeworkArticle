<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/init.php';

$arCategory = Categories::getCategoriesList(['ID', 'NAME'], ['CODE' => $_REQUEST['category']], [], []);
$arCategory = $arCategory[0];
$countPosts = Posts::countPosts(['CATEGORY_ID' => $arCategory['ID']]);
$pages = ceil($countPosts['COUNT'] / 6);


$offset = empty($_REQUEST['page']) || $_REQUEST['page'] <= 1 || $_REQUEST['page'] > $pages ? 0 : ($_REQUEST['page'] - 1) * 6;

$arArticles = Posts::getExpPostsList(['ID', 'TITLE', 'CODE', 'CATEGORY_ID', 'DATE'], ['CATEGORY_ID' =>$arCategory['ID'],'ACTIVE'=>1], ['DATE' => 'DESC'], ['limit' => 6, 'offset' => $offset]);


$title = ucfirst($arCategory['NAME']);
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/header.php';
?>
    <div id="container">
        <div class="wrap-container">

            <section class="content-box box-1">
                <div class="zerogrid">
                    <div class="wrap-box">
                        <div class="box-header">
                            <h2><?= ucfirst($arCategory['NAME']) ?></h2>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div id="container">
        <div class="wrap-container">
            <section class="content-box box-style-1 box-2">
                <div class="zerogrid">
                    <div class="wrap-box">
                        <div class="row">
                            <?php if (!empty($arArticles)):
                                foreach ($arArticles as $article):?>
                                    <div class="col-1-3">
                                        <div class="wrap-col">
                                            <article>
                                                <div class="post-thumbnail-wrap">
                                                    <a href="/articles/<?= $article['CATEGORY_CODE'] ?>/<?= $article['ID'] ?>" class="portfolio-box">
                                                        <img src="/images/stati.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="entry-header ">
                                                    <h3 class="entry-title"><?= $article['TITLE'] ?></h3>
                                                    <div class="l-tags">
                                                        <a href="/articles/<?= $article['CATEGORY_CODE'] ?>"><?= $article['CATEGORY_NAME'] ?></a>
                                                    </div>
                                                    <div class="l-tags"><?= date('F j, Y', strtotime($article['DATE'])); ?>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                <?php endforeach;
                            endif; ?>
                        </div>
                    </div>
                    <div class="pages">
                        <?php if (isset($pages)):
                            for ($i = 1; $i <= $pages; $i++): ?>
                                <a href="/articles/<?= $article['CATEGORY_CODE'] ?>?page=<?= $i ?>"><?= $i ?></a>
                            <?php endfor;
                        endif; ?>
                    </div>
                </div>
            </section>
        </div>
    </div>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php';
?>