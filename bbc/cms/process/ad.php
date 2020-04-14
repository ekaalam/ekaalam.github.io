<?php
require "../../config/init.php";
require "../inc/checklogin.php";
$ad = new Advertisement;
if (isset($_POST) && !empty($_POST)) {
    // debug($_POST);
    // debug($_FILES, true);
    // if (empty($_POST['title']) || empty($_POST['link']) || empty($_POST['status'])) {
    //     redirect('../ad-form.php', 'error', "Title field is required.");
    // }
    $data = array(
        'title' => sanitize($_POST['title']),
        'link' => sanitize($_POST['link']),
        'status' => sanitize($_POST['status'])
    );
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        //uplode code
        $image_name = uploadImage($_FILES['image'], "ad");
        //debug($image_name,true);
        if ($image_name) {
            $data['image'] = $image_name;
            if (isset($_POST['old_image']) && !empty($_POST['old_image'])) {
                deleteImage($_POST['old_image'], "ad");
            }
        }
    }
    $ad_id = (isset($_POST['ad_id']) && !empty($_POST['ad_id'])) ? (int) $_POST['ad_id'] : null;

    if ($ad_id) {
        //update
        $act = "updat";
        $ad_id = $ad->updateData($data, $ad_id);
    } 
    else {
        //add
        $act = "add";
        $data['added_by'] = $_SESSION['user_id'];
        $ad_id = $ad->insertData($data);
    }
} else {
    redirect("../ad.php", "error", "Please add data first");
}
