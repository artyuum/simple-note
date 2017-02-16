<?php

/**
 * Include The Autoloader
 */
require_once __DIR__ . '/../app/autoload.php';

/**
 * Use Table We Want
 */
use Migrations\CreateTableNotes;

/**
 * Create Instance
 */
$notes = new CreateTableNotes();

/**
 * Creates the table when called
 */
if ($argv[1] == 'create') {
    $notes->create();

    echo 'Table Has Been Created';
    die();
}

/**
 * Drops the table when called
 */
if ($argv[1] == 'drop') {
    $notes->drop();

    echo 'Table Has Been Dropped';
    die();
}

die();