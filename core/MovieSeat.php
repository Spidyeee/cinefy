<?php

/**
 * MovieSeat class.
 */
class MovieSeat
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
    public $session_id;

    /**
     * Seat id.
     * 
     * @var int
     */
    public $seat_id;

    /**
     * Construct.
     */
    public function __construct() {}

    /**
     * Get table name.
     */
    public static function getTableName(): string
    {
        return 'movies_seat';
    }
}
