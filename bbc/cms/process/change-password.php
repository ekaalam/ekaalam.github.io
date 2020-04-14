<?php
require "../../config/init.php";
require "../inc/checklogin.php";


$users = new User;
if (isset($_POST) && !empty($_POST)) {
    if (empty($_POST['password']) || empty($_POST['re_password']) || $_POST['password'] != $_POST['re_password'] || empty($_GET['id'])){
        redirect('../users.php','error', 'Password should match');
    }
    $data = array(
        'password' => password_hash($_POST['password'], PASSWORD_BCRYPT)
    );

    $id = (int) $_GET['id'];
    if ($id <= 0){
        redirect('../users.php','error','Invalid User');
    }

    $user_info = $users->getRowById($id);
    if(!$user_info){
        redirect('../users.php','error','User does not exist');
    }
        $staus = $users->updateData($data, $_GET['id']);
        if($staus){
            if($_GET['id'] == $_SESSION['user_id']){
                redirect('../logout.php');
            }
            redirect('../users.php','success','Password changed successfully');
        }else{
            redirect('./users.php', 'error', 'Problem on updating password');
        }
} else {
    redirect('../users.php', 'error', 'Select a user');
}
