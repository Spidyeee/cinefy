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
        if (empty($_SESSION)) {
            \Cinefy::redirect('./');
        }
        $results = $this->handleForm();

        require('layout/welcome.phtml');
        require 'layout/edit.phtml';
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
            'password',
            'newpassword',
            'repassword'
        ];

        $record = [];

        if (!empty($_POST)) {
            foreach ($_POST as $key => $field) {
                if (in_array($key, $fieldsToCheck)) {
                    $record[$key] = $field;
                }
            }

            $record['email'] = $_SESSION['email'];

            // Encode password
            if (in_array('password', $fieldsToCheck)) {
                $record['password'] = md5($record['password']);
            }

            if (in_array('email', $fieldsToCheck)) {
                $query = \Cinefy::$database->query(sprintf("SELECT id FROM users WHERE email = '%s' AND password = '%s'", $record['email'], $record['password']));
                if (!mysqli_num_rows($query)) {
                    return [
                        'result' => false,
                        'message' => 'Bledne dane'
                    ];
                }

                if (mysqli_num_rows($query)) {

                    if ($record['repassword'] != $record['newpassword']) {
                        return [
                            'result' => false,
                            'message' => 'Hasla sa rozne'
                        ];
                    }

                    $record['newpassword'] = md5($record['newpassword']);

                    $query = \Cinefy::$database->query(sprintf("UPDATE users SET password = '%s' WHERE email = '%s'", $record['newpassword'], $record['email']));

                    if ($query) {
                        return [
                            'result' => true,
                            'message' => 'Haslo zostalo zmienione'
                        ];
                    }
                }
            }
        }

        return [];
    }
}
