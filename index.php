<?php
    $title = 'Главная';
    require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/header.php';

?>
    <header class="">
        <div id="owl-slide" class="owl-carousel">
            <div class="item">
                <img src="../images/slide1.jpg"/>
            </div>
        </div>
    </header>

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

<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php';
?>