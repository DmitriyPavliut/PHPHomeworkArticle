<?php
$title = 'Статьи';
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/header.php';

$countPosts = Posts::countPosts();
$pages = ceil($countPosts['COUNT'] / 6);
$offset = empty($_REQUEST['page']) || $_REQUEST['page'] <= 1 || $_REQUEST['page'] > $pages ? 0 : ($_REQUEST['page'] - 1) * 6;

$arArticles = Posts::getExpPostsList(['ID', 'TITLE', 'CODE', 'CATEGORY_ID', 'DATE'], ['ACTIVE'=>1], ['DATE' => 'DESC'], ['limit' => 6, 'offset' => $offset]);
?>
    <div id="container">
        <div class="wrap-container">

            <section class="content-box box-1">
                <div class="zerogrid">
                    <div class="wrap-box">
                        <div class="box-header">
                            <h2>ABOUT US</h2>
                        </div>
                        <div class="box-content">
                            <p>Lorem ipsum dosectetur adipisicing elit, sed do.Lorem ipsum dolor sit amet, consectetur
                                Nulla <br>fringilla purus at leo dignissim congue. Mauris elementum accumsan leo vel
                                tempor. Sit amet cursus nisl aliquam. <br>Aliquam et elit eu nunc rhoncus viverra quis
                                at felis. Sed do</p>
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
                                                        <img src="../images/stati.jpg" alt="">
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
                                <a href="/articles?page=<?= $i ?>"><?= $i ?></a>
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