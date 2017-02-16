<?php

namespace Migrations;

use Config\Database;

/**
 * Class CreateTableNotes
 *
 * @package Migrations
 */
class CreateTableNotes
{
    /**
     * @var Database
     */
    private $connection;

    /**
     * CreateTableNotes constructor.
     */
    function __construct()
    {
        $this->connection = (new Database())->createConnection();
    }

    /**
     * Creates the table when called
     */
    public function create()
    {
        $this->connection->exec('
            CREATE TABLE IF NOT EXISTS notes (
                id      INTEGER PRIMARY KEY AUTOINCREMENT,
                title   TEXT NOT NULL,
                content TEXT NOT NULL,
                created_at DATETIME NOT NULL
            );  
        ');
    }

    /**
     * Drops the table when called
     */
    public function drop()
    {
        $this->connection->exec('
            DROP TABLE IF EXISTS notes;
        ');
    }
}