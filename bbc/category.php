<?php
require_once 'config/init.php';
$no_cat = false;
$no_news = false;
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int) $_GET['id'];
    if ($id <= 0) {
        $no_cat = true;
    } else {
        $category = new Category;
        $category_info = $category->getRowById($id);

        if (!$category_info) {
            $no_cat = true;
        } else {
            $news = new News();
            $cat_news = $news->getCategoryWiseNews($id, 0, 10);
            if (!$cat_news) {
                $no_news = true;
            }
        }
    }
}
if ($no_cat != true) {
    $meta = array(
        'title' => $category_info[0]->title . " || " . SITE_NAME,
        "image" => ASSETS_IMAGES_URL . '/category/' . $category_info[0]->image,
        'keywords' => $category_info[0]->title,
        'description' => $category_info[0]->summary
    );
}
require_once 'inc/header.php';
?>
<div class="container">
    <?php
    if ($no_cat) {
        echo "<p class='alert alert-danger'>Category not found.</p>";
    } else {
    ?>
        <div class="row">
            <div class="col-12">
                <ul class="css-nav">
                    <li>
                        <h4 style="color:#fff"><?php echo $category_info[0]->title ?></h4>
                    </li>
                </ul>
            </div>
        </div>
        <?php
        if ($no_news) {
            echo "<p class='alert alert-danger'>No News</p>";
        } else {
            foreach ($cat_news as $category_news) {
        ?>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <img src="<?php echo UPLOAD_URL . '/news/' . $category_news->image ?>" alt="" class="img img-fluid img-thumbnail">
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <a href="news.php?id=<?php echo $category_news->id?>">
                            <h2><?php echo $category_news->title ?></h2>
                        </a>
                        <p>
                            <?php echo $category_news->summary ?>
                        </p>
                        <p>
                            <a href="news.php?id=<?php echo $category_news->id?>">
                                Read More...
                            </a>
                        </p>
                    </div>
                </div>
                <hr>
    <?php
            }
        }
    }
    ?>
</div>
<?php
require_once 'inc/footer.php';
?>