<?php
final class  User extends Database
{
    use DataTraits;
    public function __construct()
    {
        parent::__construct();
        $this->table = "users";
    }
    public function getUserByEmail($email)
    {
        // SELECT * FROM users WHERE email = "$email"
        $args = array(
            // 'fields' => "id, name, email",
            // "where" => "email = '".$email."' "
            "where" => array(
                'email' => $email,
                'status' => 'active'
            )
        );
        return $this->select($args);
    }
    public function getUserByCookieToken($token)
    {
        $args = array(
            "where" => array(
                'remember_token' => $token,
                'status' => 'active'
            )
        );
        return $this->select($args);
    }
    public function getUserByType($role)
    {
        $args = array(
            'where' => array(
                'role' => $role
            )
        );
        return $this->select($args);
    }
}
