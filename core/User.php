<?php

/**
 * User core class.
 */
class User
{
    /**
     * User email.
     */
    public $email;

    /**
     * User password.
     */
    public $password;

    /**
     * User repassword.
     */
    public $repassword;

    /**
     * User created date.
     */
    public $created_date;

    /**
     * User is admin.
     */
    public $is_admin;

    public function __construct() {}

    public static function getTableName(): string
    {
        return 'users';
    }

    /**
     * Get users
     *
     * @return array Users
     */
    public static function getUsers(): array
    {
        $query = \Cinefy::$database->query("SELECT * FROM users ORDER BY id DESC");

        $users = [];

        if ($query) {
            $i = 0;
            while ($user = $query->fetch_assoc()) {
                $users[$i] = $user;
                $i++;
            }
        }

        return $users;
    }
}
