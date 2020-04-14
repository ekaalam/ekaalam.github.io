<?php
require_once 'config/init.php';
$no_news = false;
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int) $_GET['id'];
    if ($id <= 0) {
        $no_news = true;
    } else {
        $news = new News;
        $news_info = $news->getRowById($id);

        if (!$news_info) {
            $no_news = true;
        }
    }
}
if ($no_news != true) {
    $meta = array(
        'title' => $news_info[0]->title . " || " . SITE_NAME,
        "image" => ASSETS_IMAGES_URL . '/news/' . $news_info[0]->image,
        'keywords' => $news_info[0]->title,
        'description' => $news_info[0]->summary
    );
}
require_once 'inc/header.php';
?>
<div class="container">
    <div class="row mt-5">
        <div class="col-12">
            <?php
            if ($no_news) {
                echo "<p class='alert alert-danger'>No News.</p>";
            } else {
            ?>
                <div class="row">
                    <div class="col-12" style="color: #ffffff">
                        <h1 class="text-center">
                            <?php echo $news_info[0]->title; ?>
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center">
                        <?php
                        if (!empty($news_info[0]->image) && file_exists(UPLOAD_PATH . '/news/' . $news_info[0]->image)) {
                        ?>
                            <img src="<?php echo UPLOAD_URL . '/news/' . $news_info[0]->image; ?>" alt="" class="img img-fluid">
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="text-justify">
                            <?php
                            echo html_entity_decode($news_info[0]->description);
                            ?>
                        </div>
                        <?php
                        ?>
                        <p>
                            <span>
                                <i class="fa fa-map-marker"></i>
                                <?php echo $news_info[0]->location; ?>,
                            </span>
                            <span>
                                <i class="fa fa-calendar"></i>
                                <?php echo $news_info[0]->news_date ?>
                            </span>

                            <br>
                            <samll>
                                <em>
                                    Source: <?php echo $news_info[0]->source; ?>
                                </em>
                            </samll>
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <ul class="css-nav">
                            <li>
                                <h4 style="color:#ffffff">Comments</h4>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="fb-comments" data-href="<?php echo getCurrentUrl();?>" data-width="100%" data-numposts="5"></div>
                    </div>
                </div>
                <hr>
                <div class="row mt-5">
                    <div class="col-12">
                        <h4>Share</h4>
                        <!-- Go to www.addthis.com/dashboard to customize your tools -->
                        <div class="addthis_inline_share_toolbox_wyw2"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <ul class="css-nav">
                            <li>
                                <h4 style="color:#ffffff">Related News</h4>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="row">
                            <?php
                            $related_news = $news->getRelatedNews($news_info[0]->cat_id, $id);
                            if ($related_news) {
                                foreach ($related_news as $related) {
                            ?>
                                    <div class="col-sm-12 col-md-3 ">
                                        <div class="row">
                                            <div class="col-12">
                                                <img src="<?php echo UPLOAD_URL . '/news/' . $related->image ?>" alt="" class="img img-fluid img-thumbnail">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <a href="news.php?id=<?php echo $related->id ?>">
                                                    <h4>
                                                        <?php
                                                        echo $related->title
                                                        ?>
                                                    </h4>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php
require_once 'inc/footer.php';
?>