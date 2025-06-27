<?php

/**
 * Database core class.
 */
class Database
{
    /**
     * Database object.
     */
    private $database;

    /**
     * Constructor - create database object.
     * 
     * @param string $servername
     * @param string $username
     * @param string $password
     * @param string $name
     */
    public function __construct(string $servername, string $username, string $password = null, string $name)
    {
        $this->database = new mysqli($servername, $username, $password, $name);
    }

    /**
     * Save object to database.
     * 
     * @param string $table Table name
     * @param mixed  $object All object properties will be saved
     */
    public function save(string $table, $object): bool
    {
        // Fill created_date field if null
        if (property_exists($object, 'created_date')) {
            if (null == $object->created_date) {
                $object->created_date = date('Y-m-d H:i:y');
            }
        }

        $object = (array) $object;
        $object = array_filter($object);

        $tableColumns = implode(',', array_keys($object));
        $tableValues = implode("','", $object);

        $sql = "INSERT INTO $table($tableColumns) VALUES('$tableValues')";

        return $this->database->query($sql);
    }

    /**
     * Query to database.
     * 
     * @param string $query
     */
    public function query(string $query)
    {
        return $this->database->query($query);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->database->close();
    }

    /**
     * 
     * EXPERIMENTAL FUNCTION - DO NOT USE IT
     * 
     * Synchronize database.
     */
    public static function synchronize()
    {
        $directory = scandir('core');

        foreach ($directory as $file) {
            if (!is_file('core/' . $file)) {
                continue;
            }

            if ('Database.php' == $file) {
                continue;
            }

            if (!preg_match('/\$model =/m', file_get_contents('core/' . $file))) {
                continue;
            }

            include $file;

            $modelName = pathinfo($file, PATHINFO_FILENAME);
            $table = $modelName::$model;

            $sql = "CREATE TABLE %s (";

            foreach ($table as $column) {
                $sql .= '';
                foreach ($column as $field) {
                }
            }

            dump($sql);
        }
    }
}
