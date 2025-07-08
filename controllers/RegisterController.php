<?php

/**
 * Handle register events.
 */
class Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $results = $this->handleForm();


        require('layout/welcome.phtml');
        require 'layout/register.phtml';
    }

    /**
     * Handle form submit
     *
     * @return array Results
     */
    public function handleForm(): array
    {
        $requiredFields = [
            'email',
            'password'
        ];

        require 'core/User.php';
        $user = new User();

        if (!empty($_POST)) {

            // Fill data
            foreach ($_POST as $key => $field) {
                $user->{$key} = $field;
            }

            // Check if required fields are not null
            foreach ($requiredFields as $key) {
                if (!array_key_exists($key, (array) $user)) {
                    return [
                        'result' => false,
                        'message' => 'Wystąpił błąd rejestracji'
                    ];
                }
            }

            if ($user->repassword != $user->password) {
                return [
                    'result' => false,
                    'message' => 'Hasla sa rozne'
                ];
            }

            unset($user->repassword);

            $user->password = md5($user->password);

            $query = \Cinefy::$database->query('SELECT * FROM users WHERE email = "' . $user->email . '"');

            if (0 != mysqli_fetch_row($query)) {
                return [
                    'result' => false,
                    'message' => 'Email zajety'
                ];
            }

            if (!empty($user)) {
                $query = \Cinefy::$database->save(User::getTableName(), $user);

                if ($query) {
                    return [
                        'result' => true,
                        'message' => 'Zarejestrowano pomyslnie'
                    ];
                }

                return [
                    'result' => false,
                    'message' => 'Wystąpił błąd przy zapisie'
                ];
            }
        }

        return [];
    }
}
