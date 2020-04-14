<?php
    require_once "../config/init.php";
    $user = new User;
    if(isset($_COOKIE, $_COOKIE['_au']) && !empty($_COOKIE['_au'])){
        setcookie('_au',"",time()-30,"/");
        $data= array(
            'remember_token' => null
        );
        $user-> updateData($data, $_SESSION['user_id']);
    }
    session_destroy();
    redirect("./");
?>