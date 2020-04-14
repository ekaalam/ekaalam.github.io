<?php
require "../../config/init.php";
require "../inc/checklogin.php";
require_once '../inc/admin.php';

$category = new Category;
if (isset($_POST) && !empty($_POST)) {
    if (empty($_POST['title'])) {
        redirect('../category-form.php', 'error', 'Title field is required.');
    }
    $data = array(
        'title' => sanitize($_POST['title']),
        'summary' => sanitize($_POST['summary']),
        'status' => sanitize($_POST['status'])
    );
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        //uplode code
        $image_name = uploadImage($_FILES['image'], "category");
        //debug($image_name,true);
        if ($image_name) {
            $data['image'] = $image_name;
            if (isset($_POST['old_image']) && !empty($_POST['old_image'])) {
                deleteImage($_POST['old_image'], "category");
            }
        }
    }
        $cat_id = (isset($_POST['cat_id']) && !empty($_POST['cat_id'])) ? (int) $_POST['cat_id'] : null;

        if ($cat_id) {
            //update
            $act = "updat";
            $cat_id = $category->updateData($data, $cat_id);
        } else {
            //add
            $act = "add";
            $data['added_by'] = $_SESSION['user_id'];
            $cat_id = $category->insertData($data);
        }
        if ($cat_id) {
            redirect('../category.php', 'success', 'Category ' . $act . 'ed success');
        } else {
            redirect('../category.php', 'error', 'Sorry! There was problem while ' . $act . 'ing category');
        }
    }
 else if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int) $_GET['id'];
    if ($id <= 0) {
        redirect("../category.php", 'error', 'Invalid Category ID');
    }
    $cat_info = $category->getRowById($id);
    if (!$cat_info) {
        redirect("../category.php", "error", 'Category does not exists or has been already deleted.');
    }

    $del = $category->deleteRowById($id);
    if ($del) {
        deleteImage($cat_info[0]->image, "category");
        redirect("../category.php", 'success', 'Category Deleted');
    } else {
        redirect("../category.php", 'error', 'Category could not Delete');
    }
} else {
    redirect("../category.php", "error", "Please add data first");
}
