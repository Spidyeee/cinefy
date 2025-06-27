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
        $this->handleForm();

        $movie = Movie::getMovie($_GET['id']);
        $sessions = MovieSession::getMovieSessions();

        require 'layout/buy.phtml';
    }

    /**
     * Handle form submit
     *
     * @return array Results
     */
    public function handleForm(): array
    {
        require 'core/Movie.php';
        require 'core/MovieSeat.php';
        require 'core/MovieSession.php';

        if (empty($_POST) || !isset($_POST['ids'])) {
            return [];
        }

        $seats = json_decode($_POST['ids']);

        foreach ($seats as $seatId) {
            $seat = new MovieSeat();
            $seat->session_id = $_POST['session_id'];
            $seat->seat_id = $seatId;

            $query = \Cinefy::$database->save(MovieSeat::getTableName(), $seat);
        }

        if ($query) {
            return [
                'result' => true,
                'message' => 'Dodano post'
            ];
        }

        return [
            'result' => false,
            'message' => 'Wystąpił błąd przy zapisie'
        ];
    }
}
