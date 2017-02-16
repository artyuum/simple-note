<?php

namespace Config;

use PDO;

/**
 * Class Database
 *
 * @package Config
 */
class Database
{
    /**
     * @var Parameters
     */
    private $parameters;

    /**
     * @var string
     */
    private $dsn;

    /**
     * Database constructor.
     *
     * Configures the Database Connection For The Application
     */
    function __construct()
    {
        $this->parameters = new Parameters();
        $this->dsn        = 'sqlite:' . __DIR__ . '/../' . $this->parameters->sqliteFile();
    }

    /**
     * Creates a PDO Instance
     *
     * @return PDO
     */
    public function createConnection()
    {
        $pdo = new PDO($this->dsn);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        return $pdo;
    }
}