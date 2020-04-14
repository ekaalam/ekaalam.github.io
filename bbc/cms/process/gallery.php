<?php
require "../../config/init.php";
require "../inc/checklogin.php";
$gallery = new Gallery;
if (isset($_POST) && !empty($_POST)) {

    // debug($_POST);
    // debug($_FILES, true);
    if (empty($_POST['title']) || empty($_POST['summary']) || empty($_POST['status'])) {
        redirect('../gallery-form.php', 'error', "Title field is required.");
    }
    $data = array(
        'title' => sanitize($_POST['title']),
        'summary' => sanitize($_POST['summary']),
        'status' => sanitize($_POST['status'])
    );
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        //uplode code
        $image_name = uploadImage($_FILES['image'], "gallery");
        //debug($image_name,true);
        if ($image_name) {
            $data['image'] = $image_name;
            if (isset($_POST['old_image']) && !empty($_POST['old_image'])) {
                deleteImage($_POST['old_image'], "gallery");
            }
        }
    }
    $gallery_id = (isset($_POST['gallery_id']) && !empty($_POST['gallery_id'])) ? (int) $_POST['gallery_id'] : null;
    if ($gallery_id) {
        //update
        $act = "updat";
        $gallery_id = $gallery->updateData($data, $gallery_id);
    } else {
        //add
        $act = "add";
        $data['added_by'] = $_SESSION['user_id'];
        $gallery_id = $gallery->insertData($data);
    }
    if ($gallery_id) {
        if (isset($_FILES['related_images']) && !empty($_FILES['related_images'])) {
            //upload
            $related_images = $_FILES['related_images'];
            $size = count($related_images['name']);
            for ($i = 0; $i < $size; $i++) {
                $temp = array(
                    'name' => $related_images['name'][$i],
                    'tmp_name' =>  $related_images['tmp_name'][$i],
                    'size' => $related_images['size'][$i],
                    'type' => $related_images['type'][$i],
                    'error' => $related_images['error'][$i]
                );
                $image_name_rel = uploadImage($temp, 'gallery');
                if ($image_name_rel) {
                    $temp_data = array(
                        'gallery_id' => $gallery_id,
                        'image' => $image_name_rel
                    );
                    $gallery_img_obj = new GalleryImages;
                    $gallery_img_obj->insertData($temp_data);
                }
            }
        }
        if (isset($_POST['del_image']) && !empty($_POST['del_image'])) {
            foreach ($_POST['del_image'] as $del_image) {
                $gallery_imags = new GalleryImages;
                $success = $gallery_imags->deleteImageByName($del_image);
                if ($success) {
                    deleteImage($del_image, 'gallery');
                }
            }
        }
        redirect('../gallery.php', 'success', 'Gallery ' . $act . 'ed success');
    } else {
        redirect('../gallery.php', 'error', 'Sorry! There was problem while ' . $act . 'ing gallery');
    }
} else if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int) $_GET['id'];
    if ($id <= 0) {
        redirect("../gallery.php", 'error', 'Invalid Gallery ID');
    }
    $gallery_info = $gallery->getRowById($id);
    if (!$gallery_info) {
        redirect("../gallery.php", "error", 'Gallery does not exists or has been already deleted.');
    }

    $gallery_images = new GalleryImages;
    $all_images = $gallery_images->getAllGalleryImages($id);

    $del = $gallery->deleteRowById($id);
    if ($del) {
        deleteImage($gallery_info[0]->image, "gallery");
        if($all_images){
            foreach($all_images as $del_images){
                deleteImage($del_images->image,'gallery');
            }
    }
        redirect("../gallery.php", 'success', 'Gallery Deleted');
    } else {
        redirect("../gallery.php", 'error', 'Gallery could not Delete');
    }
} else {
    redirect("../gallery.php", "error", "Please add data first");
}
