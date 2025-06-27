<?php

/**
 * Movie class.
 */
class Movie
{
    /**
     * Author id.
     * 
     * @var int
     */
    public $user_id;

    /**
     * Photo url to server folder.
     * 
     * @var string
     */
    public $photo_url;

    /**
     * Construct.
     */
    public function __construct() {}

    /**
     * Get table name.
     */
    public static function getTableName(): string
    {
        return 'movies';
    }

    /**
     * Get movie.
     *
     * @param int $id Movie id
     */
    public static function getMovie(int $id): array
    {
        $query = \Cinefy::$database->query(sprintf("SELECT * FROM %s WHERE id=%s", self::getTableName(), $id));

        if ($query) {
            while ($post = $query->fetch_assoc()) {
                $movie = $post;
            }
        }

        return $movie;
    }

    /**
     * Get movies.
     */
    public static function getMovies(): array
    {
        $query = \Cinefy::$database->query("
            SELECT
                m.*,
                COUNT(ms.seat_id) AS seats
            FROM
                movies AS m
            LEFT JOIN
                movies_seat AS ms
            ON
                m.id = ms.session_id
            GROUP BY m.id");

        $movies = [];

        if ($query) {
            $i = 0;
            while ($post = $query->fetch_assoc()) {
                $movies[$i] = $post;
                $i++;
            }
        }

        return $movies;
    }
}
