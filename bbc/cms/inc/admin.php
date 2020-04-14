<?php
    $role = $_SESSION['role'];
    if($role != 'admin'){
        redirect('./rdashboard.php','warning', 'Access Denied');
    }
?>