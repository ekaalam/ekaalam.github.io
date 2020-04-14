<?php
require "../../config/init.php";
require "../inc/checklogin.php";
$news = new News;
if (isset($_POST) && !empty($_POST)) {
    // debug($_POST);
    // debug($_FILES, true);
    if (empty($_POST['title']) || empty($_POST['summary']) || empty($_POST['cat_id'])){
        redirect('../news-form.php', 'error', 'Title field is required.');
    }
    $data = array(
        'title' => sanitize($_POST['title']),
        'cat_id' => (int) ($_POST['cat_id']),
        'summary' => sanitize($_POST['summary']),
        'description' => htmlentities($_POST['description']),
        'location' => sanitize($_POST['location']),
        'news_date' => sanitize($_POST['news_date']),
        'source' => sanitize($_POST['source']),
        'state' => sanitize($_POST['state']),
        'is_featured' => (isset($_POST['is_featured'])) ? 1 : 0,
        'reporter_id' => (isset($_POST['reporter_id'])) ? (int) $_POST['reporter_id'] : null,
        'status' => sanitize($_POST['status'])
    );
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        //uplode code
        $image_name = uploadImage($_FILES['image'], "news");
        //debug($image_name,true);
        if ($image_name) {
            $data['image'] = $image_name;
            if (isset($_POST['old_image']) && !empty($_POST['old_image'])) {
                deleteImage($_POST['old_image'], "news");
            }
        }
    }
    $news_id = (isset($_POST['news_id']) && !empty($_POST['news_id'])) ? (int) $_POST['news_id'] : null;
    if ($news_id) {
        //update
        $act = "updat";
        $news_id = $news->updateData($data, $news_id);
    } else {
        //add
        $act = "add";
        $data['added_by'] = $_SESSION['user_id'];
        $news_id = $news->insertData($data);
    }
    if ($news_id) {
        redirect('../news.php', 'success', 'News ' . $act . 'ed success');
    } else {
        redirect('../news.php', 'error', 'Sorry! There was problem while ' . $act . 'ing news');
    }
} else if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int) $_GET['id'];
    if ($id <= 0) {
        redirect("../news.php", 'error', 'Invalid News ID');
    }
    $news_info = $news->getRowById($id);
    if (!$news_info) {
        redirect("../news.php", "error", 'News does not exists or has been already deleted.');
    }
    $del = $news->deleteRowById($id);
    if ($del) {
        deleteImage($news_info[0]->image, "news");
        redirect("../news.php", 'success', 'News Deleted');
    } else {
        redirect("../news.php", 'error', 'News could not Delete');
    }
} else {
    redirect("../news.php", "error", "Please add data first");
}
