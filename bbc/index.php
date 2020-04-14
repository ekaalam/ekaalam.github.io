<?php
require_once 'config/init.php';
$meta = array(
    'title' => "Homepage || " . SITE_NAME
);
require_once 'inc/header.php';
$news = new News;
$featured_top = $news->getFeaturedNews(0, 3);
if ($featured_top) {
?>
    <!-- Banner open-->
    <div class="banner-news">
        <?php
        foreach ($featured_top as $key => $list_news) {
        ?>
            <div class="newsfeed">
                <div class="container">
                    <h4 class="header1">
                        <a href="news.php?id=<?php echo $list_news->id ?>"><?php echo $list_news->title ?></a>
                    </h4>
                    <?php
                    if ($key == 0) {
                        if (file_exists(UPLOAD_PATH . '/news/' . $list_news->image) && !empty($list_news->image)) {
                    ?>
                            <div class="img_hastag">
                                <img src="<?php echo UPLOAD_URL . '/news/' . $list_news->image ?>" class="img img-fluid">
                            </div>
                        <?php } else { ?>
                            <img src="<?php echo ASSETS_IMAGES_URL . '/logo.png'; ?> . $list_news->image ?>" style="width: 100%; height: auto;">
                        <?php } ?>
                        <p class="img_content">
                            <?php echo $list_news->summary ?>
                        </p>
                    <?php }
                    ?>
                </div>
            </div>
            <hr>
    <?php
        }
    }
    ?>
    </div>
    <!-- Banner Closed-->
    <!-- Content Open -->
    <div class="listing">
        <div class="container">
            <div class="row">
                <?php
                $other = $news->getFeaturedNews(3, 5);
                if ($other) {
                    $first_elem = array_shift($other); //first element
                ?>
                    <div class="col-md-6 col-sm-12">
                        <div class="card listnews-1">
                            <img src="<?php echo UPLOAD_URL . '/news/' . $first_elem->image; ?>" class="card-img-top main-image-1" alt="...">
                            <div class="card-body">
                                <p class="card-text1">
                                    <a href="news.php?id=<?php echo $first_elem->id; ?>">
                                        <?php echo $first_elem->title ?>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">

                        <?php
                        if ($other) {
                            foreach ($other as $key => $other_news) {
                        ?>
                                <div class="row">
                                    <div class="col-md-5">
                                        <img src="<?php echo UPLOAD_URL . '/news/' . $other_news->image ?>" style="width: 100%; height: 150px; " class="img img-fluid">
                                    </div>
                                    <div class="col-md-5">
                                        <p style="font-weight: 600; font-size: 1em;" class="list11">
                                            <a href="news.php?id=<?php echo $other_news->id ?>">
                                                <?php echo $other_news->title ?>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                        <?php
                            }
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Content Closed -->
    <?php
    $category_news = $news->getCategoryWiseNews(11, 0, 5);
    if ($category_news) {
        $first_news = array_shift($category_news);
    ?>
        <!-- Listing_paage -->
        <div class="title_news">
            <div class="container">
                <ul class="css-nav">
                    <li><a href="category.php?id=11">Politics</a></li>
                </ul>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-12">
                                <h1 class="title_news1">
                                    <a href="news.php?id=<?php echo $first_news->id; ?>">
                                        <?php echo $first_news->title; ?>
                                    </a>
                                </h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="news.php?id=<?php echo $first_news->id; ?>">
                                    <img src="<?php echo UPLOAD_URL . '/news/' . $first_news->image ?>" style="height: auto; width: 100%;">
                                </a>
                            </div>
                            <div class="col-md-6">
                                <p class="summary-text">
                                    <?php echo $first_news->summary; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-3">
                    <?php
                    if ($category_news) {
                        foreach ($category_news as $cat_news) {
                    ?>
                            <div class="col-md-3">
                                <img src="<?php echo UPLOAD_URL . '/news/' . $cat_news->image ?>" alt="" style="width: 100%; height: auto;">
                                <p class="three_nepali mt-3">
                                    <a href="news.php?id=<?php echo $cat_news->id ?>">
                                        <?php echo $cat_news->title ?>
                                    </a>
                                </p>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <hr>
                <?php
                $cat_news_first = $news->getCategoryWiseNews(11, 5, 5);
                if ($cat_news_first) {
                ?>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <?php
                            foreach ($cat_news_first as $cat_news_left) {
                            ?>
                                <div class="row mt-3">
                                    <div class="col-md-5">
                                        <img src="<?php echo UPLOAD_URL . '/news/' . $cat_news_left->image ?>" style="width: 100%; height: auto;  border:1px solid #e8edf4;">
                                    </div>
                                    <div class="col-md-5">
                                        <p style="font-weight: 600; font-size: 1em;" class="list11">
                                            <a href="news.php?id=<?php echo $cat_news_left->id; ?>">
                                                <?php echo $cat_news_left->title ?>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            $cat_news_second = $news->getCategoryWiseNews(11, 10, 5);
                            if ($cat_news_second) {
                                foreach ($cat_news_second as $right_news) {
                            ?>
                                    <div class="row mt-3">
                                        <div class="col-md-5">
                                            <img src="<?php echo UPLOAD_URL . '/news/' . $right_news->image; ?>" style="width: 100%; height: auto;  border:1px solid #e8edf4;">
                                        </div>
                                        <div class="col-md-5">
                                            <p style="font-weight: 600; font-size: 1em;" class="list11">
                                                <a href="news.php?id=<?php echo $right_news->id; ?>">
                                                    <?php echo $right_news->title; ?>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php }  ?>
            </div>
        </div>
        <!-- ListingPage closed -->
    <?php
    }
    ?>

    <!-- State Open -->
    <div class="country">
        <div class="container">
            <div class="row mt-3">
                <div class="col-md-9">
                    <nav class="navbar navbar-light bg-primary" style="border-radius: 20px;">
                        <a class="navbar-brand" href="./" style="color:#fff">State</a>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <?php
                            $all = array_shift($state);
                            foreach ($state as $key => $state_name) {
                            ?>
                                <a class="nav-item nav-link <?php echo $key == 'state1' ? 'active' : '' ?>" id="nav-<?php echo $key; ?>-tab" data-toggle="tab" href="#nav-<?php echo $key; ?>" role="tab" aria-controls="nav-<?php echo $key; ?>" aria-selected="<?php echo $key == 'state1' ? true : false; ?>">
                                    <?php echo $state_name ?>
                                </a>
                            <?php
                            }
                            ?>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <?php
                        foreach ($state as $key => $state_name) {
                            $state_wise = $news->getStateWiseNews($key);
                        ?>
                            <div class="tab-pane fade <?php echo $key == 'state1' ? 'show active' : '' ?>" id="nav-<?php echo $key; ?>" role="tabpanel" aria-labelledby="nav-<?php echo $key; ?>-tab">
                                <?php
                                if ($state_wise) {
                                    $first_state_news = array_shift($state_wise);
                                ?>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <a href="news.php?id=<?php echo $first_state_news->id; ?>">
                                                <?php
                                                if (file_exists(UPLOAD_PATH . '/news/' . $first_state_news->image) && !empty($first_state_news->image)) {
                                                ?>
                                                    <img src="<?php echo UPLOAD_URL . '/news/' . $first_state_news->image; ?>" style="width: 100%; height: auto;">
                                                <?php
                                                } else { ?>
                                                    <img src="<?php echo ASSETS_IMAGES_URL . '/logo.png'; ?> . $news_list->image ?>" style="width: 100%; height: auto;">
                                                <?php } ?>
                                            </a>
                                            <h1 class="nagdunga">
                                                <a href="news.php?id=<?php echo $first_state_news->id; ?>">
                                                    <?php echo $first_state_news->title; ?>
                                                </a>
                                            </h1>
                                            <p><?php echo $first_state_news->summary; ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <?php
                                                if ($state_wise) {
                                                    foreach ($state_wise as $news_list) {
                                                ?>
                                                        <div class="col-md-6">
                                                            <a href="news.php?id=<?php echo $news_list->id; ?>">
                                                                <?php
                                                                if (file_exists(UPLOAD_PATH . '/news/' . $news_list->image) && !empty($news_list->image)) {
                                                                ?>
                                                                    <img src="<?php echo UPLOAD_URL . '/news/' . $news_list->image; ?>" style="width: 100%; height: auto;">

                                                                <?php
                                                                } else { ?>
                                                                    <img src="<?php echo ASSETS_IMAGES_URL . '/logo.png'; ?> . $news_list->image ?>" style="width: 100%; height: auto;">
                                                                <?php } ?>
                                                            </a>
                                                            <p style="padding-top: 20px; font-weight: 400; font-size: 16px;">
                                                                <a href="news.php?id=<?php echo $news_list->id; ?>">
                                                                    <?php echo $news_list->title; ?>
                                                                </a>
                                                            </p>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } else {
                                    echo "No News";
                                }
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
                $home_3 = $ads->getAdvertisementByPosition('home3');
                if ($home_3) {
                ?>
                    <div class="col-md-3">
                        <div class="ad">
                            <a href="<?php echo $home_3[0]->link ?>" target="_ads">
                                <img src="<?php echo UPLOAD_URL . '/ad/' . $home_2[0]->image ?>" style="width: 100%;" alt="<?php echo $home_3[0]->title ?>">
                            </a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <!--State Closed-->
    <?php
    $sports_news = $news->getCategoryWiseNews(14, 0, 5);
    if ($sports_news) {
        $second_news = array_shift($sports_news);
    ?>
        <!-- Listing_paage -->
        <div class="title_news">
            <div class="container">
                <ul class="css-nav">
                    <li><a href="category.php?id=11">Sports</a></li>
                </ul>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-12">
                                <h1 class="title_news1">
                                    <a href="news.php?id=<?php echo $second_news->id; ?>">
                                        <?php echo $second_news->title; ?>
                                    </a>
                                </h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="news.php?id=<?php echo $second_news->id; ?>">
                                    <img src="<?php echo UPLOAD_URL . '/news/' . $second_news->image ?>" style="height: auto; width: 100%;">
                                </a>
                            </div>
                            <div class="col-md-6">
                                <p class="summary-text">
                                    <?php echo $second_news->summary; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-3">
                    <?php
                    if ($sports_news) {
                        foreach ($sports_news as $sop_news) {
                    ?>
                            <div class="col-md-3">
                                <img src="<?php echo UPLOAD_URL . '/news/' . $sop_news->image ?>" alt="" style="width: 100%; height: auto;">
                                <p class="three_nepali mt-3">
                                    <a href="news.php?id=<?php echo $sop_news->id ?>">
                                        <?php echo $sop_news->title ?>
                                    </a>
                                </p>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- ListingPage closed -->
    <?php
    }
    ?>
    <?php require_once 'inc/footer.php';
