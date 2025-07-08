<?php

/**
 * Handle account events.
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
        require('layout/welcome.phtml');

        $seats = $this->getSeats();

        require 'layout/navbar.phtml';
        require 'layout/account.phtml';
    }

    /**
     * Get user seats
     *
     * @return array seats
     */
    public function getSeats(): array
    {
        require 'core/Movie.php';
        require 'core/MovieSeat.php';
        require 'core/MovieSession.php';

        $sql = 'SELECT
                    *
                FROM
                    %s AS ms
                LEFT JOIN
                    %s AS msess
                ON
                    ms.session_id = msess.id
                LEFT JOIN
                    %s AS m
                ON
                    msess.movie_id = m.id
                WHERE
                    user_id = %d';

        $sql = sprintf($sql, MovieSeat::getTableName(), MovieSession::getTableName(), Movie::getTableName(), $_SESSION['id']);

        $query = \Cinefy::$database->query($sql);

        $seats = [];

        if ($query) {
            $i = 0;
            while ($post = $query->fetch_assoc()) {
                $seats[$i] = $post;
                $i++;
            }
        }

        return $seats;
    }
}
