<?php
require "../../config/init.php";
require "../inc/checklogin.php";
require_once '../inc/admin.php';


$users = new User;
//debug($_POST);
//debug($_FILES);
//exit();
if (isset($_POST) && !empty($_POST)){
    if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        if (empty($_POST['name'])) {
            redirect('../user-form.php', 'error', 'Name is required.');
        }
    }else{
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
            redirect('../user-form.php', 'error', 'Name Email and Password are required.');
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            redirect('../user-form.php', 'error', 'Enter Valid Email ID');
        }

        if ($_POST['password'] != $_POST['re_password']) {
            redirect('../user-form.php', 'error', 'Password Doenot Match');
        }
    }

    $data = array(
        'name' => sanitize($_POST['name']),
        'role' => 'reporter',
        'status' => sanitize($_POST['status']),

    );

    $user_id = (isset($_POST['user_id']) && !empty($_POST['user_id'])) ? (int) $_POST['user_id'] : null;

    if ($user_id) {
        //update
        $act = "updat";
        $user_id = $users->updateData($data, $user_id);
    } else {
        //add
        $act = "add";
        $data['email'] = $_POST['email'];
        $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $user_id = $users->insertData($data);
    }
    if ($user_id) {
        redirect('../users.php', 'success', 'User ' . $act . 'ed success');
    } else {
        redirect('../users.php', 'error', 'Sorry! There was problem while ' . $act . 'ing users');
    }
} else if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int) $_GET['id'];
    if ($id <= 0) {
        redirect("../users.php", 'error', 'Invalid User ID');
    }
    $user_info = $users->getRowById($id);
    if (!$user_info) {
        redirect("../users.php", "error", 'User does not exists or has been already deleted.');
    }

    $del = $users->deleteRowById($id);
    if ($del) {
        redirect("../users.php", 'success', 'User Deleted');
    } else {
        redirect("../users.php", 'error', 'User could not Delete');
    }
} else {
    redirect("../users.php", "error", "Please add data first");
}
