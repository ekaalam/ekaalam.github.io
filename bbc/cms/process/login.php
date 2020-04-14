<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';
$user = new User;
/*
     * data received
     *  ->Verify User and Password
     *  ->Email verify
     *      ->DB User
     *          -> User Exists
     *              -> Password check
     *                  ->Matched pswd
     *                      ->Set Session
     * 
     *                      ->Remember Me check
     *                          ->checked
     *                              ->cookie Update
     * 
     *                      ->Redirect -> Dashboard
     *                  ->Not matched
     *                      ->Login Form
     *          ->User does not exists
     *              ->login form
     *  ->Email Not Verify
     *      ->Login form
     * 
     * Data does not received
     *  redirect -> login form
     */

// echo password_hash('admin123', PASSWORD_BCRYPT);
// exit; 
if (isset($_POST) && !empty($_POST)) {
    //form Received/ Data Received
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        redirect("../", 'error', "Invalid Email Format");
    }
    if (empty($_POST['password'])) {
        redirect("../", 'error', 'Password required.');
    }
    $user_info = $user->getUserByEmail($email);
    if ($user_info) {
        //user exists
        if (password_verify($_POST['password'], $user_info[0]->password)) {
            //password match
            setSession('user_id', $user_info[0]->id);
            setSession('name', $user_info[0]->name);
            setSession('email', $user_info[0]->email);
            setSession('role', $user_info[0]->role);
            $token = generateRandomString(100);
            setSession("token", $token);
            if (isset($_POST['remember_me']) && !empty($_POST['remember_me'])) {
                //cookie
                setcookie("_au", $token, (time() + 860000), "/");
                //DB user update
                $data = array(
                    'remember_token' => $token
                );
                //UPDATE users SET remember_token = 'kjbdjahga' WHERE id = 12;
                $user->updateData($data, $user_info[0]->id);
            }
            //debug($_SESSION,true);
            if($user_info[0]->role == 'admin'){
                 redirect('../dashboard.php', 'success', 'Welcome to admin panel.');
            }else{
                redirect('../rdashboard.php', 'success', 'Welcome');
            }
        } else {
            redirect("../", 'error', 'Credentials doesnot match');
        }
    } else {
        redirect("../", 'error', 'Credentials doesnot match');
    }
    // SELECT * FROM user WHERE email = $email;

    // $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // $status = password_verify($_POST['password'], $hash);

    // debug($status, true);

    //$password = sha1($email.$_POST['password']);

    //debug($_POST,true);

} else {
    // setSession('error', 'Please Login First.');
    // redirect("../");
    redirect("../", "error", 'Please Login First.');
}
