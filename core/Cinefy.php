<?php

/**
 * Cinefy core class.
 */
class Cinefy
{
    /**
     * Cinefy system version.
     *
     * @var string
     */
    public const SYSTEM_VERSION = '0.1';

    /**
     * Cinefy config.
     *
     * @var array
     */
    public static $config;

    /**
     * Database object.
     *
     * @var object
     */
    public static $database;

    /**
     * Run Cinefy
     *
     * @return void
     */
    public static function run(): void
    {
        self::$config = require 'config.php';

        require 'functions.php';

        self::connectDatabase();

        session_start();

        self::renderIndex();
    }

    /**
     * Connect to database
     */
    public static function connectDatabase(): void
    {
        $config = self::$config['database'];
        require 'Database.php';
        self::$database = new Database($config['hostname'], $config['username'], $config['password'], $config['name']);
    }

    /**
     * Render view
     * If no controller in uri, render main page
     */
    public static function renderIndex(): void
    {
        // Handle ajax requests
        if ('ajax' == self::getControllerName()) {
            self::getController();
            return;
        }

        require('layout/welcome.phtml');

        if (!self::getController()) {
            require 'core/Movie.php';
            $movies = Movie::getMovies();
            require 'layout/main.phtml';
        }
    }

    /**
     * Get current controller name
     *
     * @return string
     */
    public static function getControllerName(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'])['path'];

        return substr($path, 1);
    }

    /**
     * Search for controller and run
     *
     * @return bool
     */
    public static function getController(): bool
    {
        $path = parse_url($_SERVER['REQUEST_URI'])['path'];

        $controller = substr($path, 1);

        if (isset($path[1]) && null != $path[1]) {
            // Search for controller
            if (file_exists('controllers/' . ucfirst($controller) . 'Controller.php')) {
                require 'controllers/' . ucfirst($controller) . 'Controller.php';
            } else {
                throw new Exception(ucfirst($path[$i]) . 'Controller.php does not exist');
            }

            new Controller();
            return true;
        }

        return false;
    }

    /**
     * EXPERIMENTAL FUNCTION
     * Get lang.
     *
     * @param string $lang
     */
    public static function lang(string $lang)
    {
        $langs = require sprintf('assets/langs/%s.php', self::$config['lang']);
        return $langs[$lang];
    }

    /**
     * Redirect to url.
     *
     * @param string $url
     */
    public static function redirect(string $url): void
    {
        header('Location: ' . $url);
    }

    /**
     * Add message to view.
     *
     * @param bool   $type
     * @param string $message Message text
     */
    public static function addMessage(bool $type, string $message): void
    {
        echo '<div class="alert alert-' . ($type ? 'success' : 'danger') . '">';
        echo $message;
        echo '</div>';
    }

    /**
     * Append JavaScript to view.
     *
     * @param string $filename
     */
    public static function appendJavascript(string $filename): void
    {
        echo '<script src="assets/js/' . $filename . '"></script>';
    }
}
