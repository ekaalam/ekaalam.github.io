<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <meta name="keywords" content="<?php echo (isset($meta['keywords'])) ? $meta['keyword'] : META_KEYWORDS; ?>">
    <meta name="description" content="<?php echo (isset($meta['description'])) ? $meta['description'] : META_DESCRIPTION; ?>">
    <meta property="og:url" content="<?php echo getCurrentUrl(); ?>">
    <meta property="og:title" content="<?php echo (isset($meta['title'])) ? $meta['title'] : SITE_NAME ?>">
    <meta property="og:description" content="<?php echo (isset($meta['description'])) ? $meta['description'] : META_DESCRIPTION; ?>">
    <meta property="og:image" content="<?php echo (isset($meta['image'])) ? $meta['image'] : ASSETS_IMAGES_URL . '/logo.png'; ?>">
    <meta property="og:type" content="article">
    <link rel="stylesheet" href="<?php echo ASSETS_CSS_URL ?>/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_CSS_URL ?>/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_CSS_URL ?>/all.min.css">
    <title><?php echo (isset($meta['title'])) ? $meta['title'] : SITE_NAME ?></title>
</head>

<body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v6.0&appId=211575796776720&autoLogAppEvents=1"></script>
    <?php
    $ads = new Advertisement;
    $home_1 = $ads->getAdvertisementByPosition('home1');
    if ($home_1) {
    ?>
        <div class="container" style="margin-top: 20px">
            <div class="row">
                <div class="col-12">
                    <a href="<?php echo $home_1[0]->link ?>" target='_ads'>
                        <img src="<?php echo UPLOAD_URL . '/ad/' . $home_1[0]->image ?>" alt="<?php echo $home_1[0]->title ?>" class="img img-fluid">
                    </a>
                </div>
            </div>
        </div>
    <?php  } ?>
    <!--Top_Head-->
    <div class="top_head">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="logo_holder">
                        <a href="./">
                            <img src="<?php echo ASSETS_IMAGES_URL ?>/logo.png">
                        </a>
                    </div>
                    <div class="date_note">
                        <?php
                        $np = new NepaliCalendar;
                        list($year, $month, $date) = explode("-", date('Y-m-d'));
                        $nep_date = $np->eng_to_nep($year, $month, $date);
                        echo $nep_date['date'] . " " . $nep_date['nmonth'] . " " . $nep_date['year'] . ", " . $nep_date['day'];
                        ?>
                    </div>
                </div>
                <?php
                $home_2 = $ads->getAdvertisementByPosition('home2');
                if ($home_2) {
                ?>
                    <div class="col-md-6">
                        <div class="info">
                            <a href="<?php echo $home_2[0]->link ?>" target="_ads">
                                <img src="<?php echo UPLOAD_URL . '/ad/' . $home_2[0]->image ?>" style="width: 100%;" alt="<?php echo $home_2[0]->title ?>">
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!--Top_head end-->
    <!-- NavBar-Open -->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary menu sticky-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./">Home</a>
                    </li>   
                    <?php
                    $category = new Category;
                    $all_cats = $category->getMenu();
                    if ($all_cats) {
                        foreach ($all_cats as $cats) {
                    ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo (getCurrentPage() == 'category' && $cats->id == $_GET['id']) ? 'active' : '' ?>" href="category.php?id=<?php echo $cats->id ?>">
                                    <?php echo $cats->title ?>
                                </a>
                            </li>
                    <?php
                        }
                    }
                    ?>
                    <li class="nav-item" >
                        <a class="nav-link" href="../cms/index.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- NavBar-closed -->
    
    