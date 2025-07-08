<?php

/**
 * Handle login events.
 */
class Controller
{
    /**
     * Constructor
     */
    public function __construct($action = null)
    {
        if ('logout' == $action) {
            session_unset();
            session_destroy();
            \Cinefy::redirect('../');
        }


        $results = $this->handleForm();

        if (!empty($_SESSION)) {
            \Cinefy::redirect('account');
        }

        require('layout/welcome.phtml');
        require 'layout/login.phtml';
    }

    /**
     * Handle form submit
     *
     * @return array Results
     */
    public function handleForm(): array
    {
        $fieldsToCheck = [
            'email',
            'password'
        ];

        $record = [];

        if (!empty($_POST)) {
            foreach ($_POST as $key => $field) {
                if (in_array($key, $fieldsToCheck)) {
                    $record[$key] = $field;
                }
            }

            // Encode password
            if (in_array('password', $fieldsToCheck)) {
                $record['password'] = md5($record['password']);
            }

            if (in_array('email', $fieldsToCheck)) {
                $query = \Cinefy::$database->query(sprintf("SELECT * FROM users WHERE email = '%s' AND password = '%s'", $record['email'], $record['password']));

                if (!mysqli_num_rows($query)) {
                    return [
                        'result' => false,
                        'message' => 'Bledne dane'
                    ];
                }

                // Fetch user and save in session
                foreach ($query->fetch_assoc() as $key => $value) {
                    $_SESSION[$key] = $value;
                }
            }
        }

        return [];
    }
}
