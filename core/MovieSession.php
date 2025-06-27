<?php

/**
 * MovieSession class.
 */
class MovieSession
{
    /**
     * Id.
     * 
     * @var int
     */
    public $id;

    /**
     * Movie id.
     * 
     * @var int
     */
    public $movie_id;

    /**
     * Session date.
     * 
     * @var string
     */
    public $date;

    /**
     * Session type (lyrics, dubbing, lector).
     * 
     * @var int
     */
    public $type;

    /**
     * Session type - lyrics.
     *
     * @var int
     */
    public const TYPE_LYRICS = 1;

    /**
     * Session type - dubbing.
     *
     * @var int
     */
    public const TYPE_DUBBING = 2;

    /**
     * Session type - lector.
     *
     * @var int
     */
    public const TYPE_LECTOR = 3;

    /**
     * Construct.
     */
    public function __construct() {}

    /**
     * Get table name.
     */
    public static function getTableName(): string
    {
        return 'movies_session';
    }

    /**
     * Get movie seats.
     */
    public static function getMovieSessions(): array
    {
        $sql = '
            SELECT
                *
            FROM
                %s as ms
            WHERE
                movie_id = %d';

        $query = \Cinefy::$database->query(sprintf($sql, MovieSession::getTableName(), $_GET['id']));

        $sessions = [];

        $sql = '
            SELECT
                *
            FROM
                %s as ms
            WHERE
                session_id = %d';

        if ($query) {
            $i = 0;
            while ($post = $query->fetch_assoc()) {
                $sessions[$i] = $post;

                $query2 = \Cinefy::$database->query(sprintf($sql, MovieSeat::getTableName(), $post['id']));

                $j = 0;
                $sessions[$i]['seats'] = [];
                while ($post2 = $query2->fetch_assoc()) {
                    $sessions[$i]['seats'][$post2['seat_id']] = $post2;

                    $j++;
                }

                $i++;
            }
        }

        $preparedSessions = [];

        foreach ($sessions as $session) {
            $preparedSessions[$session['type']][] = $session;
        }

        return $preparedSessions;
    }
}
